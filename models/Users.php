<?php

class Users
{
    
    
    public static function setUser($user, $bloger_id)
    {
        // Соединение с БД
        $db = Db::getConnection();
        $status = 1;
        // Текст запроса к БД
        $sql = 'INSERT INTO users (user, bloger_id, status) '
            . 'VALUES (:user, :bloger_id, :status)';
        // Получение и возврат результатов. Используется подготовленный запрос
        $result = $db->prepare($sql);
        $result->bindParam(':user', $user, PDO::PARAM_STR);
        $result->bindParam(':bloger_id', $bloger_id, PDO::PARAM_STR);
        $result->bindParam(':status', $status, PDO::PARAM_STR);
        return $result->execute();
    }


    /* public static function getUser()
     {
         // Соединение с БД
         $db = Db::getConnection();
 
         // Текст запроса к БД
         $sql = 'SELECT * FROM users';
 
         $result = $db->prepare($sql);
         //$result->bindParam(':user', $user, PDO::PARAM_INT);
 
         // Указываем, что хотим получить данные в виде массива
         $result->setFetchMode(PDO::FETCH_ASSOC);
 
         // Выполняем запрос
         $result->execute();
 
         // Возвращаем данные
         return $result->fetch();
     }*/
    public static function getUniqueBlogers()
    {
        // Соединение с БД
        $db = Db::getConnection();

        // Запрос к БД
        $result = $db->query('SELECT bloger_id  FROM users GROUP BY bloger_id');

        // Получение и возврат результатов
        $categoryList = array();
        $i = 0;
        while ($row = $result->fetch()) {
            $categoryList[$i]['bloger_id'] = $row['bloger_id'];
            $i++;
        }
        return $categoryList;
    }

//Получаю все user_id и bloger_id  с таблици users
    public static function getAllUsers()
    {
        // Соединение с БД
        $db = Db::getConnection();

        // Запрос к БД
        $result = $db->query('SELECT user, bloger_id  FROM users');

        // Получение и возврат результатов
        $categoryList = array();
        $i = 0;
        while ($row = $result->fetch()) {
            $categoryList[$i]['user'] = $row['user'];
            $categoryList[$i]['bloger_id'] = $row['bloger_id'];
            $i++;
        }
        return $categoryList;
    }

    //Список ,bloger_id, на которы, подписан определенный user
    public static function getListBlogerIdByUser($user)
    {


        // Соединение с БД
        $db = Db::getConnection();

        // Текст запроса к БД
        $sql = 'SELECT bloger_id  FROM users WHERE user = :user AND status="1"';

        // Используется подготовленный запрос
        $result = $db->prepare($sql);
        $result->bindParam(':user', $user, PDO::PARAM_STR);

        // Выполнение коменды
        $result->execute();

        // Получение и возврат результатов
        $i = 0;
        $products = array();
        while ($row = $result->fetch()) {
            $products[$i]['bloger_id'] = $row['bloger_id'];

            $i++;
        }
        return $products;
    }

//Список юзеров, которым нужно рассылать данную рассылку
    public static function getUsersForSend($bloger_id)
    {


        // Соединение с БД
        $db = Db::getConnection();

        // Текст запроса к БД
        $sql = 'SELECT user  FROM users WHERE bloger_id = :bloger_id AND status="1"';

        // Используется подготовленный запрос
        $result = $db->prepare($sql);
        $result->bindParam(':bloger_id', $bloger_id, PDO::PARAM_STR);

        // Выполнение коменды
        $result->execute();

        // Получение и возврат результатов
        $i = 0;
        $products = array();
        while ($row = $result->fetch()) {
            $products[$i]['user'] = $row['user'];

            $i++;
        }
        return $products;
    }

// удаляем подписку юзера на определенный канал
    public static function deleteBlogerId($user, $bloger_id)
    {
        // Соединение с БД
        $db = Db::getConnection();

        // Текст запроса к БД
        $sql = 'DELETE FROM users WHERE user = :user AND bloger_id = :bloger_id';

        // Получение и возврат результатов. Используется подготовленный запрос
        $result = $db->prepare($sql);
        $result->bindParam(':user', $user, PDO::PARAM_INT);
        $result->bindParam(':bloger_id', $bloger_id, PDO::PARAM_INT);

        $result->execute();
    }


}