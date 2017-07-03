<?php

header('Content-Type: text/html; charset=utf-8');
// подрубаем API
require_once("vendor/autoload.php");

/// Подключение файлов системы
define('ROOT', dirname(__FILE__));
require_once(ROOT . '/components/Autoload.php');

//файл который находит блогеров для отправки




// создаем переменную бота
$token = "357426031:AAF2iYOcp4IDX26TxRCV0lw7Ugp35dal7m4";
$bot = new \TelegramBot\Api\Client($token);

// если бот еще не зарегистрирован - регистрируем
if (!file_exists("registered.trigger")) {
    /**
     * файл registered.trigger будет создаваться после регистрации бота.
     * если этого файла нет значит бот не зарегистрирован
     */

    // URl текущей страницы
    $page_url = "https://" . $_SERVER["SERVER_NAME"] . $_SERVER["REQUEST_URI"];
    $result = $bot->setWebhook($page_url);
    if ($result) {
        file_put_contents("registered.trigger", time()); // создаем файл дабы прекратить повторные регистрации
    }
}

if ($_GET['send'] == "checkforsend") {

    //Обновление постов
    require_once(ROOT . '/components/CheckUpdatesPosts.php');
    //отправляет  посты
    require_once(ROOT . '/components/CheckForSend.php');
}


// обязательное. Запуск бота
$bot->command('start', function ($message) use ($bot) {
    $answer = 'Добро пожаловать, я могу присылать тебе самые свежие видео с You Tube прямо сюда,  нажми /list и следуй инструкциям.
Можешь также нажать /help и увидеть мои команды' . "\xF0\x9F\x98\x83";
    $bot->sendMessage($message->getChat()->getId(), $answer);
});

// помощ
$bot->command('help', function ($message) use ($bot) {
    $answer = 'Команды:
/help - информация :)
/subscriber - Списое подписок
/list - Список блогеров';

    $bot->sendMessage($message->getChat()->getId(), $answer);
});



$bot->command('subscriber', function ($message) use ($bot) {
    require_once(ROOT . '/components/GetListSubscriber.php');

});


$bot->command('list', function ($message) use ($bot) {
    //выводит список блогеров
    $text = 'Для подписки на блогера из списка, введи его номер. Если ты хочешь подписаться на нескольких, то вводи их номера 
отдельно в каждом смс. Для отписки от надоевшего блогера, также введи его порядковый номер из списка /list : '. PHP_EOL;

    $bot->sendMessage($message->getChat()->getId(), $text);
    require_once(ROOT . '/components/ListAllBlogers.php');

});

//require_once(ROOT . '/components/CheckForUpdates.php');
//require_once('parser.php');
require_once(ROOT . '/components/AddNewUser.php');
$bot->run();