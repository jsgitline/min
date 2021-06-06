<?php

namespace Settings\Models;


use RedBeanPHP\R;

class Standard
{
    /**
     * @param $table
     * @param $options
     * @return int|string
     * @throws \RedBeanPHP\RedException\SQL
     * Запрос на создание
     * Возвращает id созданного
     */
    public function Create($table, $options)
    {
        $item = R::dispense($table);

        foreach ($options as $key => $value) {
            $item -> $key = $value;
        }

        if(isset($item->title) && !empty($item->title)){
            if(!$item->slug){
                $item->slug = isset($item->title) ? uniqueSlug($item->title) : null;
            }
        }

        $item->created = dateIso();
        $item->updated = dateIso();

        return R::store( $item );
    }

    /**
     * @param $table
     * @param $options
     * @return int|string
     * @throws \RedBeanPHP\RedException\SQL
     * Запрос на создание без даты
     * Возвращает id созданного
     */
    public function CreateWithoutDate($table, $options)
    {
        $item = R::dispense($table);

        foreach ($options as $key => $value) {
            $item -> $key = $value;
        }

        return R::store( $item );
    }

    /**
     * @param $table
     * @param $options
     * @param $parentTable
     * @param $parentId
     * @return int|string
     * @throws \RedBeanPHP\RedException\SQL
     * Создаёт связь One2Many
     */
    public function CreateOwnItem($table, $options, $parentTable, $parentId)
    {
        $b = $parentTable . '_id';

        $item = R::dispense($table);
        foreach ($options as $key => $value) {
            $item -> $key = $value;
        }
        $item->created = dateIso();
        $item->updated = dateIso();
        $item->$b = $parentId;

        return R::store( $item  );
    }

    /**
     * @param $table
     * @param $options
     * @param null $id
     * @return int|string
     * @throws \RedBeanPHP\RedException\SQL
     * Запрос на создание или обновление (если существует)
     * Возвращает id
     */
    public function CreateOrUpdate($table, $options, $id = null)
    {
        if (isset($id) && !empty($id)) {

            return $this->UpdateById($table, $options, $id);
        } else{

            return $this->Create($table, $options);
        }
    }

    /**
     * @param $table
     * @param null $id
     * @return array|\RedBeanPHP\OODBBean
     * Запрос на чтение
     */
    public static function Read($table, $id = null)
    {
        if (isset($id) && !empty($id)) {

            return R::load($table, $id);
        } else {

            return R::findAll($table, '  ');
        }
    }

    /**
     * @param $table
     * @param null $id
     * @return array|\RedBeanPHP\OODBBean
     * Запрос на чтение активного элемента
     */
    public static function ReadActive($table, $id = null)
    {
        if (isset($id) && !empty($id)) {

            return R::findOne($table, ' active_id = 1 ', $id);
        } else {

            return R::findAll($table, ' active_id = 1 ');
        }
    }

    /**
     * @param $table
     * @param $slug
     * @return \RedBeanPHP\OODBBean
     * Запрос на чтение по slug
     */
    public static function ReadBySlug($table, $slug = null)
    {
        if(isset($slug) && !empty($slug)){

            return R::findOne($table, ' active_id = 1 AND slug = ? LIMIT 1', [$slug]);
        } else{

            return self::Read($table, ' ORDER BY id DESC ');
        }
    }

    /**
     * @param $table
     * @param $limit
     * @return array
     * Читает с лимитом
     */
    public static function ReadWidthLimit($table, $limit)
    {
        return R::find($table, ' ORDER BY id DESC LIMIT ? ', [$limit]);
    }

    /**
     * @param $table
     * @param null $page
     * @param null $offset
     * @return array
     * читает с пагинацией
     */
    public static function ReadWidthPage($table, $page = null, $offset = null)
    {
        $kol = $offset;  //количество записей для вывода
        $art = ($page * $kol) - $kol; // определяем, с какой записи нам выводить
        return R::find($table, ' LIMIT ?, ? ', [$art, $kol]);
    }

    /**
     * @param $table
     * @param null $page
     * @param null $offset
     * @return array
     * читает с пагинацией
     */
    public static function ReadActiveWidthPage($table, $page = null, $offset = null)
    {
        $kol = $offset;  //количество записей для вывода
        $art = ($page * $kol) - $kol; // определяем, с какой записи нам выводить
        return R::find($table, ' active_id = 1 LIMIT ?, ? ', [$art, $kol]);
    }

    /**
     * @param $item - bean
     * @param $options
     * @return int|string
     * @throws \RedBeanPHP\RedException\SQL
     * Запрос на редактирование
     * Возвращает id
     */
    protected function Update($item, $options)
    {

        foreach ($options as $key => $value) {
            $item -> $key = $value;
        }
        if(isset($item->title) && !empty($item->title) && isset($item['slug']) && !empty($item['slug'])){

            $item->slug = isset($item->title) ? uniqueSlug($item->title) : null;

        }
        $item -> updated = dateIso();

        return R::store( $item );
    }

    /**
     * @param $table
     * @param $options
     * @param $id
     * @return int|string
     * @throws \RedBeanPHP\RedException\SQL
     * Обновляет по id
     */
    public function UpdateById($table, $options, $id)
    {
        $item = self::Read($table, $id);
        return $this->Update($item, $options);
    }

    /**
     * @param $table
     * @param $options
     * @param $slug
     * @return int|string
     * @throws \RedBeanPHP\RedException\SQL
     * Обновляет по slug
     */
    public function UpdateBySlug($table, $options, $slug)
    {
        $item = self::ReadBySlug($table, $slug);
        return $this->Update($item,$options);
    }

    /**
     * @param $table
     * @param $sort
     * @return int
     * Сортировка значений местами
     */
    public static function updateSort($table, $sort)
    {
        return R::exec('INSERT INTO '
            . $table
            . ' (id, sort) VALUES '
            . $sort
            . ' ON DUPLICATE KEY UPDATE sort = VALUES(sort)');
    }

    /**
     * @param $table
     * @param null $id
     * @return bool
     */
    public function Delete($table, $id = null)
    {
        $item = R::load($table, $id);
        R::trash($item);
        return true;
    }

    /**
     * @param $items
     * @return bool
     *
     */
    public function DeleteMore($items)
    {
        R::trashAll($items);
        return true;
    }

    /**
     * @param $table
     * @return int
     * Считает количество записей
     */
    public static function CountTotal($table)
    {
        return R::count($table);
    }

    /**
     * @param $table
     * @return int
     * Считает количество записей
     */
    public static function CountTotalActive($table)
    {
        return R::count($table, ' active_id = 1 ');
    }
}