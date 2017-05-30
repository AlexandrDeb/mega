<?php

header('Content-Type: text/html; charset=utf-8');
// подрубаем API
require_once("vendor/autoload.php");

// Подключение файлов системы
define('ROOT', dirname(__FILE__));
require_once(ROOT.'/components/Autoload.php');



// создаем переменную бота
$token = "///////////////////";
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

// обязательное. Запуск бота
$bot->command('start', function ($message) use ($bot) {
    $answer = 'Добро пожаловать, здесь собраны самые интересные новости /help ' . "\xF0\x9F\x98\x83";
    $bot->sendMessage($message->getChat()->getId(), $answer);
});

// помощ
$bot->command('help', function ($message) use ($bot) {
    $answer = 'Команды:
/help - информация :)
/top_content - Последние видосы
/news_p - Новости политики
/news_s - Новости спорта
/news_m - Новости мира';

    $bot->sendMessage($message->getChat()->getId(), $answer);
});

$bot->command('news_p', function ($message) use ($bot) {
    $answer = '';


    $rss = simplexml_load_file('http://news.liga.net/politics/rss.xml');
// print_r( $rss );
    $cnt = 0;
    foreach ($rss->channel->item as $item) {

        if ($cnt < 3) {
            $image = $item->enclosure;
            $answer = "\xE2\x9E\xA1 " . '<b>' . $item->title . '</b>' . '. ' . $item->description . " (<a href='" . $item->link . "'>Подробней...</a>)\n";

            $image = $image['url'];

            //выводим на печать текст статьи
            $bot->sendMessage($message->getChat()->getId(), $answer, "HTML", true);
            $bot->sendPhoto($message->getChat()->getId(), $image);

            $cnt++;
        }
    }
});


$bot->command('news_s', function ($message) use ($bot) {
    $answer = '';


    $rss = simplexml_load_file('http://news.liga.net/sport/rss.xml');
// print_r( $rss );
    $cnt = 0;
    foreach ($rss->channel->item as $item) {

        if ($cnt < 3) {
            $image = $item->enclosure;
            $answer = "\xF0\x9F\x8F\x86" . '<b>' . $item->title . '</b>' . '. ' . $item->description . " (<a href='" . $item->link . "'>Подробней...</a>)\n";

            $image = $image['url'];

            //выводим на печать текст статьи
            $bot->sendMessage($message->getChat()->getId(), $answer, "HTML", true);
            $bot->sendPhoto($message->getChat()->getId(), $image);

            $cnt++;
        }
    }
});


$bot->command('news_m', function ($message) use ($bot) {
    $answer = '';


    $rss = simplexml_load_file('http://news.liga.net/world/rss.xml');
// print_r( $rss );
    $cnt = 0;
    foreach ($rss->channel->item as $item) {

        if ($cnt < 3) {
            $image = $item->enclosure;
            $answer = "\xF0\x9F\x8C\x8D" . '<b>' . $item->title . '</b>' . '. ' . $item->description . " (<a href='" . $item->link . "'>Подробней...</a>)\n";

            $image = $image['url'];

            //выводим на печать текст статьи
            $bot->sendMessage($message->getChat()->getId(), $answer, "HTML", true);
            $bot->sendPhoto($message->getChat()->getId(), $image);

            $cnt++;
        }
    }
});

$bot->command('top_content', function ($message) use ($bot) {
    $cnt = 0;
    $content = simplexml_load_file('http://www.youtube.com/feeds/videos.xml?channel_id=UCNb2BkmQu3IfQVcaPExHkvQ');
//var_dump($content);

    foreach ($content->entry as $item) {
        $id = $item->id;
        $id = trim(substr($id, 9));
        $answer = "https://www.youtube.com/watch?v=" . "{$id}";
        if ($cnt < 1) {
            $bot->sendMessage($message->getChat()->getId(), $answer);
            $cnt++;
        }

    }
});

// запускаем обработку
/////////////////////////////////////////////

/*if ($_GET['cname'] == "choicenews") {
    $answer = '';


    $rss = simplexml_load_file('http://news.liga.net/world/rss.xml');
// print_r( $rss );
    $cnt = 0;
    foreach ($rss->channel->item as $item) {

        if ($cnt < 1) {
            $image = $item->enclosure;
            $answer = "\xF0\x9F\x8C\x8D" . '<b>' . $item->title . '</b>' . '. ' . $item->description . " (<a href='" . $item->link . "'>Подробней...</a>)\n";

            $image = $image['url'];

            //выводим на печать текст статьи
            $bot->sendMessage("@choicenews", $answer, "HTML", true);
            $bot->sendPhoto("@choicenews", $image);


            $cnt++;
        }
    }

}*/
//////////////////////////////////////////////////////////////////////////////////////////
include_once('list_of_bloggers/list.php');
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
}
require_once ('parser.php');
$bot->run();