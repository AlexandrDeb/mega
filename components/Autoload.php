<?php


//Функция __autoload для автоматического подключения классов

function myAutoload($class_name)
{
    // Масив с папками, в которых могут быть классы
    $array_paths = array(
        '/models/',
        '/components/',
         '/controllers/',
    );

    //Проходим по пассиву папок
    foreach ($array_paths as $path) {

        //Путь и имя файла и класса
        $path = ROOT . $path . $class_name . '.php';

        // Если такой файл существует, то подключаем его
        if (is_file($path)) {
            include_once $path;
        }
    }
}

spl_autoload_register('myAutoload');
