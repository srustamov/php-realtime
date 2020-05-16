<?php


namespace App\Providers;

use Exception;
use Support\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;
use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Routing\Route as BaseRoute;
use Symfony\Component\Routing\RouteCollection;

class HttpRouteProvider
{
    private static $namespace = 'App\\Controllers\\Http\\';

    public static function register(Request $request)
    {

        $routes = new RouteCollection();

        Route::setNamespace(self::$namespace);

        require BASE_PATH . '/routes/web.php';

        foreach (Route::getRoutes() as $array) {
            $routes->add($array['as'], new BaseRoute(
                    $array['path'],
                    [
                        'controller' => $array['callback'][0] ?? null,
                        'method' => $array['callback'][1] ?? null
                    ], [], [], '',[],
                    $array['methods']
                )
            );
        }

        return self::match($routes, $request, new Response());

    }


    public static function match(RouteCollection $routes, Request $request, Response $response)
    {
        $matcher = new UrlMatcher(
            $routes, new RequestContext()
        );

        try {
            $matcher = $matcher->match($request->getPathInfo());

            if (class_exists($matcher['controller'])) {
                $controller = new $matcher['controller'];
                if (method_exists($controller, $matcher['method'])) {
                    $request->attributes->add($matcher);
                    $content = call_user_func([new $matcher['controller'], $matcher['method']], $request);
                    if ($content instanceof Response) {
                        return $content;
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