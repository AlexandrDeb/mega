<?php

header('Content-Type: text/html; charset=utf-8');
// подрубаем API
require_once("vendor/autoload.php");

/// Подключение файлов системы
define('ROOT', dirname(__FILE__));
require_once(ROOT . '/components/Autoload.php');
//файл который находит блогеров для отправки

//файл добавления новых юзеров
//require_once(ROOT . '/components/AddNewUser.php');

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
    //отправляет  посты
    require_once(ROOT . '/components/CheckForSend.php');

}elseif ($_GET['updates'] == "checkupdates"){
    //файл проверяющий обновления posts
    require_once(ROOT . '/components/CheckUpdates.php');

}


// обязательное. Запуск бота
$bot->command('start', function ($message) use ($bot) {
    $answer = 'Добро пожаловать, здесь собраны самые интересные новости /help ' . "\xF0\x9F\x98\x83";
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
    $answer = '';

    $allBlogers = Channel::getAllBlogers();
    $cntBlogers = count($allBlogers);
    for ($i = 0; $i < $cntBlogers; $i++) {
        $answer = strip_tags($allBlogers[$i][0]) . ". " . strip_tags($allBlogers[$i][1]);
        $bot->sendMessage($message->getChat()->getId(), $answer, "HTML", true);
    }
    //выводим на печать текст статьи


});


/*include_once('list_of_bloggers/list.php');
if ($_GET['newsname'] == "lastvideo") {
    $cnt = count($array);

    for ($i = 0; $i < $cnt; $i++) {
        $content = simplexml_load_file('http://www.youtube.com/feeds/videos.xml?channel_id=' . $array[$i]);
//var_dump($content);
        $index = 0;
        foreach ($content->entry as $item) {
            $id = $item->id;
            $id = trim(substr($id, 9));
            $answer = "https://www.youtube.com/watch?v=" . "{$id}";
            if ($index < 1) {
                if (file_get_contents("list_of_files/{$i}file.txt") != $id) {
                    $bot->sendMessage('@choicenews', $answer);
                }
                $index++;

                // открываем файл, если файл не существует,
                $fp = fopen("list_of_files/{$i}file.txt", 'w');
                // записываем в файл текст
                fwrite($fp, $id);
                // закрываем
                fclose($fp);
            }
            $index++;
        }
    }
}*/


//require_once(ROOT . '/components/CheckForUpdates.php');
//require_once('parser.php');

$bot->run();