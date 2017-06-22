<?php


$bot->on(function ($Update) use ($bot) {
    $message = $Update->getMessage();
    $mtext = $message->getText();
    $cid = $message->getChat()->getId();

    $user2 = new UserController();
    $channel2 = new ChannelController();

    if (mb_stripos($mtext, $message) !== false) {
        //$mtext - то что я ввожу
        //$cid - мой id
        //$bot->sendMessage(314429111, $mtext);

        
        
        $userId = $cid;// мой id
        $bloger = $mtext;// то что я ввожу
        
        
        
        $bloger_id = $channel2->requestedBloger($bloger);
        $link = $channel2->requestedLink($bloger);
        $listUser = $user2->getListUsers();
        $cntUser = count($listUser);
        $counter = 0;

        for ($j = 0; $j < $cntUser; $j++) {

            if ($listUser[$j]['user'] != $userId) {
            } else {
                $counter++;
            }
        }

        if (!$counter) {

            $user2->createUser($userId, $bloger_id, $link);
            $bot->sendMessage($userId, "Успех");
        }


    }
}
    , function ($message) use ($name) {
        return true; // когда тут true - команда проходит
    });