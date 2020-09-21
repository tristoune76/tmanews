<?php

namespace Model;

use \OCFram\Manager;

abstract class NewsManager extends Manager
{
    //parent class for a NewsManager class declined for each DAO connection (PDO or MySQLi)
    //we must create an abstract method for each method created in the daughter classes
    
    //this method returns a list of the news
    //@Param:$debut is the int variable for the fposition of the first news
    //@Param:$nbrNews is the int variable for numbre of news
    //@return : an array of instances of all the News
    abstract public function getList ($debut = -1, $nbreNews =-1);


    //this method returns one news
    //@Param:$id is the int variable for the id of the news
    //@return : an instances of News
    abstract public function getUnique ($id);
}


