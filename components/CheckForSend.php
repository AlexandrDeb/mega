<?php


$posts = new PostsController();
$users = new UserController();




// ib и link блогеров сос статусом 0 для отправки
$linkToSend = $posts->updatesList();
//считаем количество записей
$cntLinkSend = count($linkToSend);

//В этом цикл, который будет работать $cntLinkSend раз
for ($k = 0; $k < $cntLinkSend; $k++){
    //берем текущего блогера
    $currentBlogerId = $linkToSend[$k]['bloger_id'];
    //берем текущую ссылку
    $currentLink = $linkToSend[$k]['link'];
    //записываем в массив, всех юзеров, которые подписаны на данного блогера
    $usersForSend = Users::getUsersForSend($currentBlogerId);
    // цикл идет столько раз, сколько юзеров в массиве $usersForSend
    for ($z = 0; $z < count($usersForSend); $z++){
        //Отправляем posts пользователям
         $currentUser = $usersForSend[$z]['user'];
        $answer = "https://www.youtube.com/watch?v=" . "{$currentLink}";
        $bot->sendMessage($currentUser, $answer);




//После отправки ставим статус 1
        Posts::setStatus($currentBlogerId, 1);
    }
}
