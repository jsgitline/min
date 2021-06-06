<?php

namespace FirstApp;

class Router
{
    public function Routes()
    {
        $namespace = 'FirstApp\Controllers';
        $routes = [
            [['GET', 'POST'], '/', $namespace . '\FirstController/actionHome'],

        ];

        return $routes;
    }
}