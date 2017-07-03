<?php

/*if ($_GET['cname'] == "choicenews") {
    $user = new UserController();
    $channel = new ChannelController();
    $listUser = $user->getListUsers();
    $cnt = count($listUser);
    for ($i = 0; $i < $cnt; $i++) {
        $content = simplexml_load_file('http://www.youtube.com/feeds/videos.xml?channel_id=' . ($listUser[$i]['bloger_id']));
        $index = 0;
        foreach ($content->entry as $item) {
            if ($index < 1) {
                $id = $item->id;
                $id = trim(substr($id, 9));
                $answer = "https://www.youtube.com/watch?v=" . "{$id}";
                if ($id != $listUser[$i]['link']) {
                    $bot->sendMessage($listUser[$i]['user'], $answer);
                    $index++;
                    $user->update($id, $listUser[$i]['user']);

                } else {
                    //$bot->sendMessage(314429111, 'Старое видео');
                    $index++;
                }

            }
        }
    }
}*/