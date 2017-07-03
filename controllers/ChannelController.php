<?php

class ChannelController
{
    
// увеличиваем count в таблице channels определенного $bloger_id на 1
    public function addCount($bloger_id){
        $count = Channel::getCounter($bloger_id);
        $count = $count['count'] + 1;
        Channel::setCount($bloger_id, $count);

    }


    //Возвращает ссылку из таблицы Channel, по bloger_id
    public function linkByBloger_Id($bloger_id){

        $result =  Channel::getLinkByBloger_Id($bloger_id);
        return $result['link'];
    }

    public function allBlogersAndLinks(){
        return Channel::getAllBlogersFromChannel();
    }
    
    ////Получаем bloger_id блогера по id
    public function requestedBlogerId($id)
    {
        $bloger = Channel::getOneBlogers($id);
        return $bloger['bloger_id'];
    }


    public function listAllBlogers()
    {
        $bloger = Channel::getTitleBlogers();
        return $bloger;
    }


    /*
      
        public function requestedName($id){
            $bloger = Channel::getOneBlogers($id);
            return $bloger['title'];
        }*/

    public function setNewLink($bloger_id, $link)
    {
        return Channel::setLinkForChannel($bloger_id, $link);
    }
}
