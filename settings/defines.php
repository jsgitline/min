<?php


# разделитель для путей к файлам
define ('DS', DIRECTORY_SEPARATOR);


# переменная пути приложения
$sitePath = realpath(dirname(__DIR__) . DS);


# путь к корневой папке приложения
define ('SITE_PATH', $sitePath);


# путь к папке c настройками приложения
define ('SETTINGS_PATH', SITE_PATH . DS . 'settings' . DS);


# алиас админки
define ('ADMIN', $_ENV['ADMIN_LINK']);

