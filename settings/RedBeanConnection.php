<?php


# Сокращаем запись
class_alias('\RedBeanPHP\R', '\R');


# Сетапим подключение
R::setup( 'mysql:host='. $_ENV['DB_HOST'] .';dbname='. $_ENV['DB_NAME'], $_ENV['DB_USER'], $_ENV['DB_PASS'] );


# Создаем исключение для обхода доступа к базе данных
R::ext('fDispense', function( $type ){
    return R::getRedBean()->dispense( $type );
});


/* # проверка соединения с базой данных
if ( !R::testConnection() ) {
    exit ('Нет соединения с базой данных');
}
*/
# R::freeze(true);

