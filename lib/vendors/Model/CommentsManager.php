<?php

namespace Model;

use \OCFram\Manager;

abstract class CommentsManager extends Manager
{
    //parent class for a CommentManager class declined for each DAO connection (PDO or MySQLi)
    //we must create an abstract method for each method created in the daughter classes
    
    //this method returns a list of the Comment
    //@Param:$news is the int variable for the numbr of the news
    //@Param:$debut is the int variable for the position of the first Comment
    //@Param:$nbrcomment is the int variable for numbre of comment
    //@return : an array of instances of all the comment
    abstract public function getList ($news, $debut = -1, $nbreComment =-1);


    //this method returns one comment
    //@Param:$id is the int variable for the id of the comment
    //@return : an instances of comment
    // abstract public function getUnique ($id);
}


