<?php

namespace Model;

use \Entity\Comment;

class CommentsManagerPDO extends CommentsManager
{
    public function getListOf($news)
    {
        if (!ctype_digit($news))
        {
            throw new \InvalidArgumentException ('le numéro de la news doit être un entier');
        }
        $sql = 'SELECT * FROM comments WHERE news = :news';
        $requete = $this->dao->prepare($sql);
        $requete->bindvalue(':news', $news, \PDO::PARAM_INT);
        $requete->execute();

        $requete->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, '\Entity\Comment');

        $commentsList = $requete->fetchAll();
        foreach ($commentsList as $comment)
        {
            $comment->setDate(new \DateTime($comment->date()));

        }
        $requete->closeCursor();
        return $commentsList;
    }

    public function count($newsId)
    {
        if (!ctype_digit($newsId))
        {
            throw new \InvalidArgumentException ('le numéro de la news doit être un entier');
        }
        $requete = $this->dao->prepare('SELECT COUNT(*) FROM comments WHERE news = :news');
        $requete->bindvalue('news', $newsId, \PDO::PARAM_INT);
        $requete->execute();
        return $requete->fetchColumn();
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