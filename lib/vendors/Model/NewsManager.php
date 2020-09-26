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

    //this method returns the number of news in the table
    //@Param:none
    //@return : number of news in the table
    abstract public function count();
    
 
    //In this method we will choose between inserting or modifying the news wether it exists or not
    //@Param:the news to be save in db
    //@return : the message indicating the news has been saved in db.
    public function save($news)
    {
        if($news->isValid())
        {
            if ($news->isNew())
            {
                //if the news allready exists then this a modification
                $flash = $this->modify($news);
            }
            else
            {
                //if the news doesn't exists then this an insertin
                $flash = $this->add($news);
            }
            return $flash;

        }
        else
        {
            throw new \RuntimeException ('La news doit être vailda avant d\'être enregistrée');
        }
    }

    //In this method we will insert a new news in the db
    //@Param : the news to be inserted in db
    //@return : the message indicating the news has been inserted in db.
    abstract public function add($news);

    //In this method we will modify a news in the db
    //@Param : the news to be modified in db
    //@return : the message indicating the news has been modified in db.  
    abstract public function modify($news);
}


