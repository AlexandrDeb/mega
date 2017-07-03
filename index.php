<?php

header('Content-Type: text/html; charset=utf-8');
// подрубаем API
require_once("vendor/autoload.php");

/// Подключение файлов системы
define('ROOT', dirname(__FILE__));
require_once(ROOT . '/components/Autoload.php');

//файл который находит блогеров для отправки




// создаем переменную бота
$token = "";
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
    $answer = 'Добро пожаловать, я могу присылать тебе самые свежие видео с You Tube прямо сюда, 
    для этого нажми /list, и пришли поочередно номера блогеров от которых ты хочешь получать видос, 
    если тебе какой-то блогер надоест, также пришли его номе и я уберу его из твоего списка можешь
     также нажать /help и увидеть мои команды' . "\xF0\x9F\x98\x83";
    $bot->sendMessage($message->getChat()->getId(), $answer);
});

// помощ
$bot->command('help', function ($message) use ($bot) {
    $answer = 'Команды:
/help - информация :)
/list - Список блогеров';

    $bot->sendMessage($message->getChat()->getId(), $answer);
});


$bot->command('list', function ($message) use ($bot) {
    //выводит список блогеров
    require_once(ROOT . '/components/ListAllBlogers.php');

});

//require_once(ROOT . '/components/CheckForUpdates.php');
//require_once('parser.php');
require_once(ROOT . '/components/AddNewUser.php');
$bot->run();