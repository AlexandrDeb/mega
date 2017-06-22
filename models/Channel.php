<?php

class Channel
{



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

}