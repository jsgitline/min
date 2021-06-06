<?php

namespace bootstrap;

class Autoload
{
    /**
     * Автозагрузка моделей, контроллеров
     */
    public static function load()
    {

        spl_autoload_register(function ($class) {

            $path = SITE_PATH . DS . $class . '.php';
            $arr = explode('\\', $path);
            $arr['0'] = str_replace("Settings","settings", $arr['0']);
            $newPath = implode('/', $arr);

            if (is_file($newPath)) {
                require_once $newPath;
            }

        });
    }
}