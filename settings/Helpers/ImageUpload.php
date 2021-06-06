<?php
/**
 * Created by PhpStorm.
 * User: super-fast
 * Date: 09.08.2018
 * Time: 13:36
 */

namespace Settings\Helpers;

class ImageUpload
{
    /**
     * @param $ids
     * @param $dir
     * @return array
     * Возвращает массив вида id => img
     */
    public static function findImagesByIds($ids, $dir)
    {
        $array = [];

        foreach ($ids as $id){
            $allowed_types = ['jpg', 'jpeg', 'png', 'gif'];
            $file = $dir . $id . '.';
            $path = substr($file, '7');
            foreach ($allowed_types as $val){
                if(is_file(SITE_PATH . $file . $val)){
                    $array[$id] = $path . $val;
                    break;
                }
            }
        }

        return $array;
    }
    /**
     * @param $id
     * @param $dir
     * @return array|null
     * $id - id - единицы
     * $dir - директория
     */
    public function GetImgById($id, $dir)
    {
        $directory = $dir.$id.'/';

        if (is_dir($directory)) {

            if ($dh = opendir($directory)) {

                $files = null;

                $new = scandir($directory);
                foreach ($new as $k=>$v){
                    if(is_file($directory . $v)){
                        $files[] = $v;
                    }
                }
                closedir($dh);
                return $files;
            }
        }
    }

    /**
     * @param $id
     * @param $dir
     * @return array|null
     * $id - id - единицы
     * $dir - директория
     */
    public static function FindImgById($id, $dir)
    {
        if (is_dir($dir)) {

            if ($dh = opendir($dir)) {

                $files = null;

                $new = scandir($dir);
                foreach ($new as $k=>$v){
                    if(is_file($dir . $v)){
                        $exp = explode('.', $v);

                        if($exp[0] == $id){
                            $files = implode('.', $exp);
                        }
                    }
                }
                closedir($dh);
                return $files;
            }
        }
    }

    /**
     * @param $dir
     * @return array|null
     */
    public static function FindImg($dir)
    {
        $directory = SITE_PATH.$dir;

        if (is_dir($directory)) {

            if ($dh = opendir($directory)) {

                $files = null;

                $new = scandir($directory);
                foreach ($new as $k=>$v){
                    if(is_file($directory . $v)){
                        $files[] = $v;
                    }
                }
                closedir($dh);
                return $files;
            }
        }
    }

    public static function FindImgThuimbsById($id, $dir)
    {
        $directory = SITE_PATH.$dir.$id.'/thumbs/';

        if (is_dir($directory)) {

            if ($dh = opendir($directory)) {

                $files = null;

                $new = scandir($directory);
                foreach ($new as $k=>$v){
                    if(is_file($directory . $v)){
                        $files[] = $v;
                    }
                }
                closedir($dh);
                return $files;
            }
        }
    }

    /**
     * @param $dirOriginal
     * @param $dirThumb
     * @param $files
     * @param $rmdir
     * Удаляет картинки
     * $dirOriginal - путь к оригиналу картинки
     * $dirThumb - путь к миниатюре
     */
    public function deleteFiles($dirOriginal, $dirThumb, $files, $rmdir = null)
    {

        foreach($files as $k => $v){


            if(is_file($dirOriginal . $v) && is_file($dirThumb . $v)){


                unlink($dirOriginal . $v);
                unlink($dirThumb . $v);

                # print($v . ' Успешно удалено!');
            }

        }
        if(isset($rmdir) && !empty($rmdir)){
            rmdir($dirThumb);
            rmdir($dirOriginal);
        }

    }

    /**
     * @param $file
     * Удаляет файл
     */
    public function deleteFile($file)
    {
        if(is_file($file)){
            unlink($file);
        }
    }

    public function massDeleteFiles($files, $dir = null)
    {
        if(isset($files) && !empty($files)){
            if(isset($dir) && !empty($dir)){
                foreach($files as $file){
                    $this->deleteFile($dir.$file);
                }
            } else{
                foreach($files as $file){
                    $this->deleteFile($file);
                }
            }
        }
    }

    /**
     * @param $path
     * @param $id
     * загрузка картинки в папку по ID
     */
    public function UploadImageById($path, $id, $convert = null, $imgX = null, $imgY = null)
    {
        $filename = $id;
        $handle = new Upload($_FILES['image']);
        if ($handle->uploaded) {
            //переименовываем изображение
            $handle->file_new_name_body = $filename;
            //разрешаем изменять размер изображения

            if(isset($imgX) || isset($imgY)) $handle->image_resize = true;
            //$handle->image_ratio_crop      = 'L';
            //ширина изображения будет 400px
            //сохраняем соотношение сторон в зависимости от ширины
            $handle->image_ratio_y = true;
            if(isset($imgX) && !emptY($imgX)) $handle->image_x = $imgX;

            //$handle->image_y = 400;
            if(isset($convert)) $handle->image_convert = $convert;
            
            //указываем путь к водяному знаку для изображения
            //$handle->image_watermark = $_SERVER['DOCUMENT_ROOT'].'/path/to/watermark/watermark.png';
            //загружаем изображение в папку images
            $handle->process($path);
            if ($handle->processed) {
                $handle->clean();
            } else {
                echo 'error : ' . $handle->error;
            }
        }

    }

    /**
     * @param $originalPath - путь к оригиналу картинки
     * @param $thumbPath - путь к миниатюре
     * @param int $thumbWidth - ширина миниатюры
     * Загрузка изображений
     * TODO сделать валидацию файлов
     */
    public function UploadImages($originalPath, $thumbPath, $thumbWidth = 400)
    {
        $validate = [];
        $files = [];
        foreach ($_FILES['images'] as $k => $l) {

            foreach ($l as $i => $v)
            {
                if (!array_key_exists($i, $files))
                    $files[$i] = [];
                $files[$i][$k] = $v;
                //$imagename = 'new' . [$i];
            }
        }
        $i = 0;
        foreach ($files as $file) {
            $i ++;

            $filename = date("YmdHis") . '_' . $i; //переменная

            $handle = new Upload($file);

            if ($handle->uploaded) {

                $this_upload = array();
                //ORIGINAL
                $handle->file_new_name_body = $filename;  //переменная
                $handle->image_resize   = false;
                $handle->process($originalPath); //переменная

                ///// THUMB ////////////////////////////////////////////////////////////////////
                $handle->file_new_name_body = $filename;
                $handle->file_force_extension = true;
                $handle->image_resize   = true;
                $handle->image_x = $thumbWidth;  //переменная
                //$handle->image_y = 500;
                $handle->image_ratio_y  = true;
                //$handle->image_ratio_x  = true;
                $handle->image_background_color = '#FFFFFF';
                # $handle->image_convert = 'jpg';
                $handle->jpeg_quality = '75';
                //$handle->png_compression = 5;

                // ABSOLUTE PATH BELOW
                $handle->process($thumbPath); //переменная
                ////////////////////////////////////////////////////////////////////////////
                ///
                ///// MICRO ////////////////////////////////////////////////////////////////////
                //$handle->file_new_name_body = $filename;
                //$handle->file_force_extension = true;
                //$handle->image_resize   = true;
                //$handle->image_y = 100;
                //$handle->image_ratio_x  = true;
                //$handle->jpeg_quality = '85';

                // ABSOLUTE PATH BELOW
                //$handle->process(SITE_PATH.$thumbPath.'/micro/'); //переменная
                ////////////////////////////////////////////////////////////////////////////
                if ($handle->processed) {

                    // store the image filename
                    $this_upload['image'] = $handle->file_dst_name; // Destination file name
                    $this_upload['body'] = $handle->file_dst_name_body; // Destination file name body
                    $this_upload['extension'] = $handle->file_dst_name_ext; // Destination file extension

                }
                $handle->clean();

            } else {


            }

        }
    }

    /**
     * @param $array
     * @param $dir
     * @param $id
     * Переименовывает картинки, сортируя их в нужном порядке
     */
    public function ReSort($array, $dir = '/public/images/items/', $id = 4)
    {

        $i = 0;
        $directory1 = SITE_PATH . $dir . $id . '/';
        $directory2 = SITE_PATH . $dir . $id . '/teaser/';
        foreach ($array as $k=>$v){

            if(is_file($directory1 . $v) && is_file($directory2 . $v)){
                see($v);
                $file = date('YmdHis') . '_' . $i;
                see($file);
                rename($directory1 . $v, $directory1 . $file . '.jpeg');
                rename($directory2 . $v, $directory2 . $file . '.jpeg');
            }

            $i++;
        }

    }
}