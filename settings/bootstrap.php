<?php


# Подключаем autoload composer
require_once SETTINGS_PATH . 'vendor' . DS . 'autoload.php';


# Подключаем главный Autoload
require_once SETTINGS_PATH . 'Autoload.php';
\bootstrap\Autoload::load();


# Подключаем DotEnv
require_once SETTINGS_PATH . 'DotEnvConnection.php';


# Подключаем RedBeanPhp
require_once SETTINGS_PATH . 'RedBeanConnection.php';


# подключаем промежутки
require_once SETTINGS_PATH . 'middleware.php';


# диспатчим роуты
$dispatcher = require SETTINGS_PATH . 'Router' . DS . 'routes.php';
require SETTINGS_PATH . 'Router' . DS . 'fetch.php';
