<?php


class Glue
{
    public $data = [];

    /**
     * @param $arrays
     * @return array
     */
    public static function mergeRoutes($arrays)
    {
        $data = [];

        foreach ($arrays as $k => $array) {

            foreach ($array as $v){
                $data[] = $v;
            }
        }

        return $data;
    }

    /**
     * @return array
     * Регистрация роутеров приложений
     */
    public static function getRegistry()
    {
        # получаем роуты из роутеров приложений
        $data = [
            (new FirstApp\Router())->Routes(),
        ];

        # мержим
        $newData = self::mergeRoutes($data);

        return $newData;
    }
}