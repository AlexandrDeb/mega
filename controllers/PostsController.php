<?php

class PostsController
{
    
    //Добавление нового поста в Posts
    public function addPostsInPosts($bloger_id, $link){
        
        return Posts::addNewPost($bloger_id, $link);
    }
    
    
    public function allPosts()
    {
        return Posts::checkNewPosts();


    }


   /* public function setNewLinks($bloger_id, $link)
    {
        return Posts::setLink($bloger_id, $link);


    }
    */
    
//проверка базы, на наличие обновлений
    public function updatesList()
    {
        return Posts::checkStatusPost();


    }

//установка статуса, после отправки обновлений
    public function updateStatus($id)
    {
        return Posts::setStatus($id);
    }


    //Проверка bloger_id в таблице Posts, если его нет, то возвращаем false
    public function chackPostOnExist($bloger_id)
    {
        return Posts::checkPosts($bloger_id);


    }


    //Если в таблице Posts нет такого блогера, то добавляем его, вместе с последней сылкой
 /*   public function AddNewPost($bloger_id)
    {
        $content = simplexml_load_file('http://www.youtube.com/feeds/videos.xml?channel_id=' . ($bloger_id));
        $index = 0;
        foreach ($content->entry as $item) {
            $id = $item->id;
            $id = trim(substr($id, 9));
            if ($index < 1) {
                Posts::setPost($bloger_id, $id);
                $index++;
            }


        }
    }*/
}