<?php

class Channel
{

//получить название канала по id
    public static function getTitleByid($id)
    {

        //Соединение с базой данных
        $db = Db::getConnection();

        $sql = 'SELECT title FROM channels WHERE id = :id';

        //подгоовка запроса
        $result = $db->prepare($sql);

        $result->bindParam(':id', $id, PDO:: PARAM_INT);
        $result->setFetchMode(PDO::FETCH_ASSOC);
        //выполнение запроса
        $result->execute();

        //возвращение результата
        return $result->fetch();
    }

    //получить название канала по id
    public static function getTitleByBlogerId($bloger_id)
    {

        //Соединение с базой данных
        $db = Db::getConnection();

        $sql = 'SELECT title FROM channels WHERE bloger_id = :bloger_id';

        //подгоовка запроса
        $result = $db->prepare($sql);

        $result->bindParam(':bloger_id', $bloger_id, PDO:: PARAM_INT);
        $result->setFetchMode(PDO::FETCH_ASSOC);
        //выполнение запроса
        $result->execute();

        //возвращение результата
        return $result->fetch();
    }



    public static function getAllBlogersFromChannel()
    {
// Соединение с БД
        $db = Db::getConnection();

// Текст запроса к БД
        $sql = "SELECT bloger_id, link FROM channels";
        $q = $db->query($sql);
        $array = array();
        $i = 0;
        while ($r = $q->fetch(PDO::FETCH_ASSOC)) {
            $array[$i]['bloger_id'] = $r['bloger_id'] . "<br>";
            $array[$i]['link'] = $r['link'] . "<br>";
            $i++;
        }
        return $array;
    }

//Получаем ссылку на видео по Bloger_id
    public static function getLinkByBloger_Id($bloger_id)
    {
        //Соединение с базой данных
        $db = Db::getConnection();

        $sql = ('SELECT link FROM channels WHERE bloger_id = :bloger_id');

        $result = $db->prepare($sql);

        $result->bindParam('bloger_id', $bloger_id, PDO::PARAM_STR);

        $result->setFetchMode(PDO::FETCH_ASSOC);

        //выполняем запрос
        $result->execute();


        // Возвращаем данные
        return $result->fetch();


    }


    public static function getTitleBlogers()
    {
// Соединение с БД
        $db = Db::getConnection();

// Текст запроса к БД
        $sql = "SELECT * FROM channels ORDER BY title";
        $q = $db->query($sql) or die("failed!");
        $array = array();
        $i = 0;
        while ($r = $q->fetch(PDO::FETCH_ASSOC)) {
            $array[$i][] = $r['id'] . "<br>";
            $array[$i][] = $r['title'] . "<br>";
            $i++;
        }
        return $array;
    }

//Получаем даные блогера по id
    public static function getOneBlogers($id)
    {
        // Соединение с БД
        $db = Db::getConnection();

        // Текст запроса к БД
        $sql = 'SELECT * FROM channels WHERE id =  :id';

        $result = $db->prepare($sql);
        $result->bindParam(':id', $id, PDO::PARAM_INT);

        // Указываем, что хотим получить данные в виде массива
        $result->setFetchMode(PDO::FETCH_ASSOC);

        // Выполняем запрос
        $result->execute();

        // Возвращаем данные
        return $result->fetch();
    }


//при проверке на наличие новых ссылок, если таковы имеются, то вносим их в базу
    public static function setLinkForChannel($bloger_id, $link)
    {
        // Соединение с БД
        $db = Db::getConnection();

        // Текст запроса к БД
        $sql = "UPDATE channels
            SET 
               link = :link
            WHERE bloger_id = :bloger_id";

        // Получение и возврат результатов. Используется подготовленный запрос
        $result = $db->prepare($sql);
        $result->bindParam(':bloger_id', $bloger_id, PDO::PARAM_STR);
        $result->bindParam(':link', $link, PDO::PARAM_STR);
        //Выполнение запроса
        return $result->execute();
    }

    //метод для получение count по определенному блогеру, для последующего увеличения его на 1
    public static function getCounter($bloger_id)
    {
        //соединение с базой данных
        $db = Db::getConnection();

        $sql = 'SELECT count FROM channels WHERE bloger_id = :bloger_id';

        //подготовка запроса
        $result = $db->prepare($sql);

        $result->bindParam(':bloger_id', $bloger_id, PDO::PARAM_STR);

        //данные хотим получить в виде массива
        $result->setFetchMode(PDO::FETCH_ASSOC);

        //выполнение запроса
        $result->execute();

        //возврат данных
        return $result->fetch();

    }
// увеличиваем количество постов оределенного блогера
    public static function setCount($bloger_id, $count){

        //соединение с базой данных
        $db = Db::getConnection();

        $sql = 'UPDATE channels SET count = :count WHERE bloger_id = :bloger_id';

        //подготовка запроса
        $result = $db->prepare($sql);

        $result->bindParam(':count', $count, PDO::PARAM_INT);
        $result->bindParam(':bloger_id', $bloger_id, PDO::PARAM_STR);

        //выполнение запроса
        $result->execute();

        //возврат данных
        return $result->fetch();


    }



}