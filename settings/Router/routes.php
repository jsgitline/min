<?php
/**
 * Use documentation https://github.com/nikic/FastRoute
 */

return FastRoute\simpleDispatcher(function (FastRoute\RouteCollector $r) {

    $registry = require SETTINGS_PATH . 'Router' . DS . 'registry.php';

    $registry2 = Glue::getRegistry();

    $path = array_merge($registry, $registry2);

    foreach ($path as $k=>$v){
        $r->addRoute($v[0], $v[1], $v[2]);
    }

});