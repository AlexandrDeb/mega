<?php


//Получаем список подписок


$cid = $message->getChat()->getId();

//Получаем список подписок user на каналлы
$user =$cid;

    $list = array();
    $listBlogerId = Users::getListBlogerIdByUser($user);
    $cnt = count($listBlogerId);
    for ($i = 0; $i < $cnt; $i++) {
        $list[] = Channel::getTitleByBlogerId($listBlogerId[$i]['bloger_id']);
    }
    $cntList = count($list);
    $convertInStr = 'Вы подписаны на :'.PHP_EOL;;
    $index = 1;
    for ($k = 0; $k <$cntList; $k++){
        $convertInStr .=$index++ .'. '. $list[$k]['title'].PHP_EOL;
    }

$bot->sendMessage($user, $convertInStr);


