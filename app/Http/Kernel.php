<?php

namespace App\Http;


use Support\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Routing\Route as BaseRoute;
use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;
use Support\Contracts\HttpKernelContract;
use Exception;

class Kernel implements HttpKernelContract
{
    public function handle(Request $request, Response $response = null): Response
    {
        $this->registerProviders();

        $routes = $this->prepareRoutes();

        if (!$response) {
            $response = new Response();
        }

        return $this->matchRoutes($routes, $request, $response);
    }


    private function registerProviders()
    {
        $providers = config('web.providers', []);

        foreach ($providers as $provider) {
            (new $provider())->register();
        }
    }


    private function prepareRoutes()
    {
        $routes = new RouteCollection();

        foreach (Route::getRoutes() as $route) {
            $routes->add($route['as'], new BaseRoute(
                $route['path'],
                [
                    '_controller' => $route['callback'][0] ?? null,
                    '_method' => $route['callback'][1] ?? null
                ],
                [],
                [],
                '',
                [],
                $route['methods']
            ));
        }

        return $routes;
    }



    private function matchRoutes(RouteCollection $routes, Request $request, Response $response): Response
    {
        $matcher = new UrlMatcher(
            $routes,
            (new RequestContext())->fromRequest($request)
        );
        try {
            $matcher = $matcher->match($request->getPathInfo());

            if (class_exists($matcher['_controller'])) {

                $controller = new $matcher['_controller'];
                $method = $matcher['_method'];
                if (method_exists($controller, $method)) {

                    $request->attributes->add($matcher);

                    $content = call_user_func_array([$controller, $method], [$request, $response]);

                    if ($content instanceof Response) {
                        return $content;
                    }

                    if (is_array($content) || is_object($content)) {
                        $content = json_encode($content);
                    }
                    return $response->setContent($content);
                }
            }

            return $response->setStatusCode(Response::HTTP_NOT_FOUND);
        } catch (ResourceNotFoundException $e) {
            return $response->setStatusCode(Response::HTTP_NOT_FOUND);
        } catch (Exception $e) {
            return $response->setStatusCode(Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
