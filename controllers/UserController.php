<?php


class UserController
{
    public function getListUsers()
    {
        return Users::getAllUsers();

    }

//Возвращает все уникальные bloger_id из таблици Users
    public function uniqueBlogerIdFromUsers()
    {
        $AllElement = Users::getUniqueBlogers();

       return $AllElement;
    }




    public function sendLinks($linkToSend)
    {

        $usersForSend = array();
        $cntPosts = count($linkToSend);

        for ($f=0; $f< $cntPosts; $f++){
            //Поиск юзера для отпраки ссылки(аргумнтом выступает bloger_id со статусом 0)
            $usersForSend[] = Users::getUsersForSend($linkToSend[$f]['bloger_id']);

        }

        return $usersForSend;

    }


     public function createUser($userId, $bloger_id)
     {
         return Users::setUser($userId, $bloger_id);
 
     }

 //Если находит юзера в базе, то возвращает все id каналов на которые он подписан, а затем сравнивает эти id c  с  присланным юзером
 //для подписки
     public function getListSubscriptions($listUser, $userId, $channelId)
     {
         $listChannel = array();
         for ($z = 0; $z < count($listUser); $z++) {
             if ($listUser[$z]["user"] == $userId) {
                 $listChannel[] = $listUser[$z]["bloger_id"];
             }
         }
         $index = 0;
         $cnt = count($listChannel);
         for ($w = 0; $w < $cnt; $w++) {
             if ($channelId == $listChannel[$w]) {
                 $index++;
             }
         }
         return $index;
         
 
     }

    //Получаем список подписок user на каналлы
    public function getListSubscriber($user)
    {
        $list = array();
        $listBlogerId = Users::getListBlogerIdByUser($user);
        $cnt = count($listBlogerId);
        for ($i = 0; $i < $cnt; $i++) {
            $list[] = Channel::getTitleByBlogerId($listBlogerId[$i]['bloger_id']);
        }
        $cntList = count($list);
        $convertInStr = '';
        $index = 1;
        for ($k = 0; $k <$cntList; $k++){
            $convertInStr .=$index++ .'. '. $list[$k]['title']."<br>";
        }

        return $convertInStr;
    }

    //удаляем подписку на блогера
    public function deleteSubscription($user, $bloger_id)
    {
        Users::deleteBlogerId($user, $bloger_id);
    }




}

