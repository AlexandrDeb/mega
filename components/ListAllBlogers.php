<?php

$channel = new ChannelController();
//получаем всех блогеров, которые есть в таблице channels
$allBlogers = $channel->listAllBlogers();
$cntBlogers = count($allBlogers);
for ($i = 0; $i < $cntBlogers; $i++) {
    $answer .=  strip_tags($allBlogers[$i][0]) . ". " . strip_tags($allBlogers[$i][1]). PHP_EOL;
    
}
//выводим на печать текст статьи

$bot->sendMessage($message->getChat()->getId(), $answer, "HTML", true);