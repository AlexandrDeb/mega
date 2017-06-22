<?php
$posts = new PostsController();
$user = new UserController();
$channel = new ChannelController();
$listUser = $user->getListUsers();

// id пользователя с телеграм
$userId = 99899889;
//bloger на которого он хочет полписаться
$bloger = 9;

//Получаем id блогера из базы
$bloger_id = $channel->requestedBlogerId($bloger);

//При добавлении подьзователя, проверяем, если ли такой блогер в таблице Posts
$blogerInPosts = $posts->chackPostOnExist($bloger_id);

//получаю все id юзера и bloger_id на которого они подписаны
$listUser = $user->getListUsers();

$cntUser = count($listUser);
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
    //echo 'новый';
    if (!$blogerInPosts){
        //echo "добавляем блогера в Posts";
        //Если в таблице Posts нет такого блогера, то добавляем его с последней ссылкой
        $posts->AddNewPost($bloger_id);

    }
}


