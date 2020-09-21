<?php

namespace Model;

use \Entity\Comments;

class CommentsManagerPDO extends CommentsManager
{
    public function getList ($news, $debut = -1, $nbreComment = -1)
    {
        $sql = 'SELECT * FROM comments WHERE news = :news ORDER BY date ASC';
        if ($debut !=-1 || $nbreComment !=-1)
        {
            $sql .= ' LIMIT '.(int) $nbreComment.' OFFSET '.(int) $debut;
        }
        $requete = $this->dao->prepare($sql);
        $requete->bindparam(':news', $id, PDO::PARAM_INT, 11);
        $requete->execute();

        $requete->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, '\Entity\Comments');
    
        $listComment = $requete->fetchAll();
        
        foreach ($listComment as $Comment)
        {
            $Comment->setDate(new \DateTime($Comment->date()));
        }
        
        $requete->closeCursor();
        
        return $listComment;
    }

    // public function getUnique ($id)
    // {
    //     // if (!is_int ($id))
    //     // {
    //     //     throw new \InvalidArgumentException('L\'index doit être un entier');
    //     // }

    //     //Prepared query because passin $id as a parameter
    //     $sql = 'SELECT * FROM Comment WHERE id = :id';
    //     $requete = $this->dao->prepare($sql);
    //     $requete->bindparam(':id', $id, PDO::PARAM_INT, 11);
    //     $requete->execute();
        
    //     $requete->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, '\Entity\Comment');

    //     $Comment = $requete->fetchAll();

    //     $Comment->setDate(new \DateTime($Comment->date()));
        
    //     $requete->closeCursor();

    //     return $Comment;

    // }
}