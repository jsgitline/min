<?php

/*
$start = microtime(true);

define ('CSRF_TOKEN', password_hash(uniqid(), PASSWORD_DEFAULT));
$_COOKIE['token'] = CSRF_TOKEN;
$_SESSION['csrf'] = CSRF_TOKEN;

*/

# Подключаем сессии
session_start();


# Устанавливаем локаль
setlocale(LC_ALL, 'ru_RU.UTF-8');


# Подключаем базовые константы
require realpath(dirname(__DIR__) . '/') . '/settings/defines.php';


# Подключаем тестовые функции
require_once SETTINGS_PATH . 'tests.php';


# Подключаем базовые функции
require_once SETTINGS_PATH . 'functions.php';


# Подключаем трамплин
require_once SETTINGS_PATH . 'bootstrap.php';


/*
$time = microtime(true) - $start;
echo '<br> Время выполнения скрипта: '.round(microtime(true) - $start, 4).' сек. <br>';
echo 'Использовано памяти: ' . convert(memory_get_usage());
*/
