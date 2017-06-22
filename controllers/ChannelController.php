<?php

class ChannelController
{
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
