<?php
$channel = new ChannelController();

$allBlogers = $channel->listAllBlogers();
$cntBlogers = count($allBlogers);
for ($i = 0; $i< $cntBlogers; $i++) {
    echo "<pre>";
    echo strip_tags($allBlogers[$i][0]) . ". " . strip_tags($allBlogers[$i][1]);
}