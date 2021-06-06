<?php
/**
 * Created by PhpStorm.
 * User: blackjack
 * Date: 08.05.2020
 * Time: 10:03
 */

namespace FirstApp\Controllers;


use FirstApp\Templates\Template;

class FirstController
{

    /**
     * Стартовая страница
     * StartPage
     */
    public function actionHome()
    {
        $title = 'Hello!';

        Template::getRender('home.php', ['title' => $title]);
    }
}