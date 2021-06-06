<?php


namespace FirstApp\Templates;


class Template
{
    /**
     * @param $template
     * @param array $context
     */
    public static function getRender($template, $context = [])
    {
        $path = SITE_PATH . DS . 'FirstApp' . DS . 'Templates' . DS;
        $mainTemplate = 'index.php';
        require_once $path . $mainTemplate;
    }
}