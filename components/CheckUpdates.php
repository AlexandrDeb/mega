<?php


$users = new UserController();
$channels = new ChannelController();
//GПолучаем всех блогеров ч таблици channels
$allBlogersFromChannels = Channel::getAllBlogersFromChannel();
//Здесь хранятся уникальные блогеры с таблицы users(нам пока не нужно)
$allUsers = $users->uniqueBlogerIdFromUsers();

$cnt = count($allBlogersFromChannels);
for ($i = 0; $i < $cnt; $i++) {
    $content = simplexml_load_file('http://www.youtube.com/feeds/videos.xml?channel_id=' . strip_tags($allBlogersFromChannels[$i]['bloger_id']));
    $index = 0;
    foreach ($content->entry as $item) {
        //Берем только первую ссылку, самую первую
        if ($index == 0) {
            $id = $item->id;
            $id = trim(substr($id, 9));
            //Если ссылка в базе и ссылка с ютуб отличаются, то обновляю ссылку в базе
            if ($allBlogersFromChannels[$i]['link'] != $id){
                // $answer = "https://www.youtube.com/watch?v=" . $id;
                $index++;
                //Если ссылки рознятся, то устанавливаю новую в базу
                $channels->setNewLink(strip_tags($allBlogersFromChannels[$i]['bloger_id']), $id);
            }


        }
    }
}