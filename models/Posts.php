<?php

class Posts
{
    public static function checkNewPosts()
    {

        // Соединение с БД
        $db = Db::getConnection();

        // Запрос к БД
        $result = $db->query('SELECT bloger_id, link FROM posts');

        $updates = array();

        $i = 0;
        while ($row = $result->fetch()) {
            $updates[$i]['bloger_id'] = $row['bloger_id'];
            $updates[$i]['link'] = $row['link'];
            $i++;
        }

        return $updates;
    }



    public static function setPost($bloger_id, $link)
    {
        // Соединение с БД
        $db = Db::getConnection();
        $status = 0;
        // Текст запроса к БД
        $sql = 'INSERT INTO posts (bloger_id, link, status) '
            . 'VALUES (:bloger_id, :link, :status)';
        // Получение и возврат результатов. Используется подготовленный запрос
        $result = $db->prepare($sql);
        $result->bindParam(':bloger_id', $bloger_id, PDO::PARAM_STR);
        $result->bindParam(':link', $link, PDO::PARAM_STR);
        $result->bindParam(':status', $status, PDO::PARAM_INT);
        return $result->execute();
    }

    public static function checkStatusPost()
    {

        // Соединение с БД
        $db = Db::getConnection();

        // Запрос к БД
        $result = $db->query('SELECT bloger_id, link FROM posts WHERE status = 0');

        $updates = array();

        $i = 0;
        while ($row = $result->fetch()) {
            $updates[$i]['bloger_id'] = $row['bloger_id'];
            $updates[$i]['link'] = $row['link'];
            $i++;
        }

        return $updates;
    }

    public static function checkPosts($bloger_Id)
    {
        // Соединение с БД
        $db = Db::getConnection();

        // Текст запроса к БД
        $sql = 'SELECT id FROM posts WHERE bloger_Id =  :bloger_Id';

        $result = $db->prepare($sql);
        $result->bindParam(':bloger_Id', $bloger_Id, PDO::PARAM_STR);

        // Указываем, что хотим получить данные в виде массива
        $result->setFetchMode(PDO::FETCH_ASSOC);

        // Выполняем запрос
        $result->execute();

        // Возвращаем данные
        return $result->fetch();
    }

    /*
        public static function setStatus($bloger_id, $status)
        {
            // Соединение с БД
            $db = Db::getConnection();

            // Текст запроса к БД
            $sql = "UPDATE posts
                SET
                    status = :status,
                WHERE bloger_id = :bloger_id";

            // Получение и возврат результатов. Используется подготовленный запрос
            $result = $db->prepare($sql);
            $result->bindParam(':bloger_id', $bloger_id, PDO::PARAM_INT);
            $result->bindParam(':status', $status, PDO::PARAM_INT);
            return $result->execute();
        }*/

    public static function setStatus($bloger_id, $status)
    {
        // Соединение с БД
        $db = Db::getConnection();

        // Текст запроса к БД
        $sql = "UPDATE posts
            SET 
                status = :status
            WHERE bloger_id = :bloger_id";

        // Получение и возврат результатов. Используется подготовленный запрос
        $result = $db->prepare($sql);
        $result->bindParam(':bloger_id', $bloger_id, PDO::PARAM_STR);
        $result->bindParam(':status', $status, PDO::PARAM_INT);
        return $result->execute();
    }






}