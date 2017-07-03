<?php
$channel = new ChannelController();
/*
$allBlogers = $channel->listAllBlogers();
$cntBlogers = count($allBlogers);
for ($i = 0; $i< $cntBlogers; $i++) {
    echo "<pre>";
    echo strip_tags($allBlogers[$i][0]) . ". " . strip_tags($allBlogers[$i][1]);
}*/






$allBlogers = $channel->listAllBlogers();
$cntBlogers = count($allBlogers);
for ($i = 0; $i < $cntBlogers; $i++) {
    $answer = strip_tags($allBlogers[$i][0]) . ". " . strip_tags($allBlogers[$i][1]);
    $bot->sendMessage($message->getChat()->getId(), $answer, "HTML", true);
}
//выводим на печать текст статьи

