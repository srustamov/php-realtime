<?php


function ds(): string
{
    return DIRECTORY_SEPARATOR;
}

function path_join(...$paths): string
{
    return implode(DIRECTORY_SEPARATOR, array_map(static function ($path) {
        return trim(ds(), $path);
    }, $paths));
}

function base_path(string $path = null): string
{
    return BASE_PATH . ($path ? ds() . trim($path, ds()) : '');
}

function config_path(string $path = null): string
{
    return base_path('configs' . ($path ? ds() . trim($path, ds()) : ''));
}

function config($name, $default = null)
{
    static $configurations;

    if ($configurations === null) {
        foreach (glob(config_path('*.php')) as $file) {
            $configurations[explode('.', basename($file), 2)[0]] = require $file;
        }
    }

    if (strpos($name, '.') !== false) {
        $items = explode('.', $name);

        $config = $configurations ?? [];

        foreach ($items as $item) {
            $config = $config[$item] ?? false;
        }

        return $config ?: $default;
    }

    return $configurations[$name] ?? null;
}


function view($name, $data = [])
{
    $file = implode(ds(), explode('.', $name)) . '.php';

    if (file_exists(base_path('views' . ds() . $file))) {
        $level = ob_get_level();
        ob_start();
        try {
            extract($data, EXTR_OVERWRITE);
            require base_path('views' . ds() . $file);
        } catch (Exception $e) {
            while (ob_get_level() > $level) {
                ob_end_clean();
            }
            throw new RuntimeException($e->getMessage());
        }

        return ob_get_clean();
    }

    throw new RuntimeException('View not found');
}
