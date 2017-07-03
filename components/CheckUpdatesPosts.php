<?php

$users = new UserController();
$channels = new ChannelController();
$posts = new PostsController();
//Здесь хранятся уникальные блогеры с таблицы users
$allUsers = $users->uniqueBlogerIdFromUsers();
$cnt = count($allUsers);

for ($i = 0; $i < $cnt; $i++) {
    $content = simplexml_load_file('http://www.youtube.com/feeds/videos.xml?channel_id=' . $allUsers[$i]['bloger_id']);
    $index = 0;
    foreach ($content->entry as $item) {
        //Берем только первую ссылку, самую первую
        if ($index == 0) {
            $id = $item->id;
            $id = trim(substr($id, 9));
            //Если ссылка в базе и ссылка с ютуб отличаются, то обновляю ссылку в базе
            if ($channels->linkByBloger_Id($allUsers[$i]['bloger_id']) != $id){
                $index++;

                //Добавляем новый пост в таблицу Posts
                $posts->addPostsInPosts($allUsers[$i]['bloger_id'], $id);

                //Если ссылки рознятся, то устанавливаю новую в таблицу Channel
                $channels->setNewLink($allUsers[$i]['bloger_id'], $id);
                // увеличиваем count в таблице channels определенного $bloger_id на 1
                $channels->addCount($allUsers[$i]['bloger_id']);
            }else{
                $index++;
            }


        }
    }
}
