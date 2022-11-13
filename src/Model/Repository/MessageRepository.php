<?php

namespace App\Model\Repository;

use App\Model\Entity\Advert;

class MessageRepository 
{
    public function print(array $data){
         $message=$_POST['message'];
         $title=$_POST['title'];
         print_r($title);
         print_r($message);
    }
}