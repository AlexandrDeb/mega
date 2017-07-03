<?php


$bot->on(function ($Update) use ($bot) {
    $message = $Update->getMessage();
    $mtext = $message->getText();
    $cid = $message->getChat()->getId();

    $user = new UserController();
    $channel = new ChannelController();


    if (mb_stripos($mtext, $message) !== false) {
        //$mtext - то что я ввожу
        //$cid - мой id
        //$bot->sendMessage(314429111, $mtext);



        $userId = $cid;// мой id
        $bloger = $mtext;// то что я ввожу

//Получаем id блогера из базы
        $bloger_id = $channel->requestedBlogerId($bloger);

//получаю все id юзера и bloger_id на которого они подписаны
        $listUser = $user->getListUsers();
        $cntUser = count($listUser);
        $counter = 0;
        $listSubscribers = 0;
        for ($j = 0; $j < $cntUser; $j++) {
            if ($listUser[$j]['user'] != $userId) {
                //echo $listUser[$j]['user'] . "_________$userId " . "<br>";
                //Если совпадения не найдено увеличиваем counter на еденицу
                $counter++;
            } elseif ($listUser[$j]['user'] == $userId) {

                //Если находит юзера в базе, то возвращает все id каналов на которые он подписан, если оно равно нулю, значит
                // он подписан на другого блогера и можно его добавить в базу
                $listSubscribers = $user->getListSubscriptions($listUser, $userId, $bloger_id);
            }
        }


//Если $counter == $cntUser это знвчит что не было найдено совпадений, значит юзер новый
//Если $listSubscribers == 0, это значит что пришедший юзер уже есть в базе, но он подписан на другого блогера, его тоже добавляем
        if ($counter == $cntUser || $listSubscribers == 0) {
            //Добавляем в базу юзера, с bloger_id на которого он подписался
            $user->createUser($userId, $bloger_id);
            $title = Channel::getTitleByid($bloger);
            $bot->sendMessage($userId, "Вы подписались на: {$title['title']}");
        }else{
            // удаление подписки
            $user->deleteSubscription($userId,$bloger_id);
            $title = Channel::getTitleByid($bloger);
            $bot->sendMessage($userId, "Вы удалили : {$title['title']}");
        }


    }
}
    , function ($message) use ($name) {
        return true; // когда тут true - команда проходит
    });