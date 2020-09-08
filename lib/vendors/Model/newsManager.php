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
    //@return : an array of all the news of instances of News
    abstract public function getList ($debut = -1, $nbreNews =-1);
}


