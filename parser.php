<?php

$bot->on(function ($Update) use ($bot) {
    $message = $Update->getMessage();
    $mtext = $message->getText();
    $cid = $message->getChat()->getId();




    if (mb_stripos($mtext, $message) !== false) {

        $keys = $mtext;
        $page = 1;
        $KeysArray = explode("\n", $keys);
        $KeysArray = array_map("trim", $KeysArray);
        $CountKeys = count($KeysArray);

//счетчик
        $cpl = 0;

///Условие
        if ($CountKeys > 0 && !empty($page)) {

            for ($i = 0; $i < $CountKeys; $i++) {

                //количество страниц
                for ($p = 1; $p <= $page; $p++) {

                    $YouLink = "";

                    //обрабатываем ключевик
                    $key = trim($KeysArray[$i]);
                    $key = urlencode($key);
                    $key = str_replace("%20", "+", $key);

                    $PageParse = file_get_contents("http://www.youtube.com/results?search_type=videos&search_query=" . $key . "&page=" . $p);

                    if (strpos($PageParse, "/watch?v=") != FALSE) {
                        preg_match_all("/href=\"\/watch\?v=([^\"]*)\"/sU", $PageParse, $matches);

                        $resultmovies = array_unique($matches[1]);

                        $moviescount = count($resultmovies);
                        $cnt = 0;

                        foreach ($resultmovies as $movielink) {
                            $link = "https://www.youtube.com/watch?v=" . trim($movielink) . "\r\n";
                            $cpl++;
                            if ($cnt <= 2) {
                               $bot->sendMessage($message->getChat()->getId(), $link);
                               // $bot->sendMessage($message->getChat()->getId(), $cid);
                                $cnt++;
                            }
                        }

                    }

                }

            }

        }

    }
}
    , function ($message) use ($name) {
        return true; // когда тут true - команда проходит
    });

