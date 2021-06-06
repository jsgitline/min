<?php
/**
 * Created by PhpStorm.
 * User: blackjack
 * Date: 05.11.2018
 * Time: 21:37
 *
 * Вспомогательные функции
 */

/**
 * @return array
 * Возвращает дни недели в массиве
 */
function daysOfWeek() {
    $days = [
        '1' => 'Понедельник',
        '2' => 'Вторник',
        '3' => 'Среда',
        '4' => 'Четверг',
        '5' => 'Пятница',
        '6' => 'Суббота',
        '7' => 'Воскресенье',
    ];
    return $days;
}

/**
 * @param $array
 * @return array
 * чистит массив от пустых значений
 */
function cleanArray($array) {
    $arr = [];
    foreach ($array as $k => $v){
        if(!empty($v)){
            $arr[] = $v;
        }
    }
    return $arr;
}

function array_delete(array $array, array $symbols = array('', ' '))
{
    return array_diff($array, $symbols);
}

/**
 * @param $word
 * @param string $charset
 * @return string
 * Первая заглавная
 */
function mb_ucfirst($word, $charset = "utf-8") {
    return mb_strtoupper(mb_substr($word, 0, 1, $charset), $charset).mb_substr($word, 1, mb_strlen($word, $charset)-1, $charset);
}

/**
 * @return false|string
 */
function dateIso() {
    return date('Y-m-d H:i:s');
}

/**
 * @return string
 * Создаёт токен
 */
function uniqueToken()
{
    return base_convert(sha1(uniqid(mt_rand(), true)), 16, 36);
}

/**
 * @param int $digits
 * @return string
 * Генерация пин-кода
 */
function generatePIN($digits = 4){
    $i = 0; //counter
    $pin = ""; //our default pin is blank.
    while($i < $digits){
        //generate a random number between 0 and 9.
        $pin .= mt_rand(0, 9);
        $i++;
    }
    return $pin;
}

/**
 * @return false|string
 */
function today() {
    return date('Y-m-d');
}

function formatDate($str)
{
    $date = new DateTime($str);
    return $date->format('d.m.Y, H:i');
}

/**
 * @param $size
 * @return string
 */
function convert($size)
{
    $unit=array('b','kb','mb','gb','tb','pb');
    return @round($size/pow(1024,($i=floor(log($size,1024)))),2).' '.$unit[$i];
}

/**
 * Функиция транслитерации
 * @param string
 * @return string
 */
function translit($st)
{
    $st = mb_strtolower($st, "utf-8");
    $st = str_replace([
        '?', '!', '.', ',', ':', ';', '*', '(', ')', '{', '}', '[', ']', '%', '#', '№', '@', '$', '^', '-', '+', '/', '\\', '=', '|', '"', '\'',
        'а', 'б', 'в', 'г', 'д', 'е', 'ё', 'з', 'и', 'й', 'к',
        'л', 'м', 'н', 'о', 'п', 'р', 'с', 'т', 'у', 'ф', 'х',
        'ъ', 'ы', 'э', ' ', 'ж', 'ц', 'ч', 'ш', 'щ', 'ь', 'ю', 'я'
    ], [
        '_', '_', '.', '_', '_', '_', '_', '_', '_', '_', '_', '_', '_', '_', '_', '_', '_', '_', '_', '_', '_', '_', '_', '_', '_', '_', '_',
        'a', 'b', 'v', 'g', 'd', 'e', 'e', 'z', 'i', 'y', 'k',
        'l', 'm', 'n', 'o', 'p', 'r', 's', 't', 'u', 'f', 'h',
        'j', 'i', 'e', '_', 'zh', 'ts', 'ch', 'sh', 'shch',
        '', 'yu', 'ya'
    ], $st);
    $st = preg_replace("/[^a-z0-9_.]/", "", $st);
    $st = trim($st, '_');

    $prev_st = '';
    do {
        $prev_st = $st;
        $st = preg_replace("/_[a-z0-9]_/", "_", $st);
    } while ($st != $prev_st);

    $st = preg_replace("/_{2,}/", "_", $st);
    return $st;
}

/**
 * @param $str
 * @return string
 * Уникальный slug
 */
function uniqueSlug($str)
{
    return translit($str) . '_' . uniqid();
}

/**
 * @param $date
 * @return bool
 * Проверка на новое
 */
function isNew($date)
{

    $datetime1 = date_create($date);
    $datetime2 = date_create(dateIso());
    $interval = date_diff($datetime1, $datetime2);
    if($interval->format('%R%a') < 10){

        return true;
    } else{

        return false;
    }
}

/**
 * @param $page
 * @param $offset
 * @return mixed
 * Вовращает количество записей для вывода и с какой записи начинать выводить
 */
function offset($page, $offset)
{
    $var['offset'] = $offset;  //количество записей для вывода
    $var['current'] = ($page * $var['offset']) - $var['offset']; // определяем, с какой записи нам выводить
    return $var;
}

/**
 * @param $str
 * @return string
 */
function daterRu($str) {
    $result = "";
    $iter = 0;
    while ($iter < mb_strlen($str)) {

        switch (mb_substr($str,$iter,1)) {
            case 'д': {
                $dayN = date("N");
                $day = "";
                switch ($dayN) {
                    case 1:$day = "Понедельник";break;
                    case 2:$day = "Вторник";break;
                    case 3:$day = "Среда";break;
                    case 4:$day = "Четверг";break;
                    case 5:$day = "Пятница";break;
                    case 6:$day = "Суббота";break;
                    case 7:$day = "Воскресенье";break;
                }
                $iter++;
                $result .= $day;
                break;
            }
            case 'м': {
                $monthN = date("m");
                $month = "";
                switch($monthN) {
                    case '01':$month = "Январь";break;
                    case '02':$month = "Февраль";break;
                    case '03':$month = "Март";break;
                    case '04':$month = "Апрель";break;
                    case '05':$month = "Май";break;
                    case '06':$month = "Июнь";break;
                    case '07':$month = "Июль";break;
                    case '08':$month = "Август";break;
                    case '09':$month = "Сентябрь";break;
                    case '10':$month = "Октябрь";break;
                    case '11':$month = "Ноябрь";break;
                    case '12':$month = "Декабрь";break;
                }
                $iter++;
                $result .= $month;
                break;

            }

            default: {
                $result .=    date(mb_substr($str,$iter,1));
                $iter++;
                break;
            }
        }

    }

    return $result;
}

/**
 * @param $get
 * @return array
 * Фильтрует GET запрос
 */
function filterGet($get)
{
    $filtered = [];

    foreach ($get as $k=>$v){
        $filtered[$k] = htmlspecialchars($v);
    }

    return $filtered;
}
/*
 * TODO map, filter
 */
