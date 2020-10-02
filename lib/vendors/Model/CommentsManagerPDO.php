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

    public function add ($comment)
    {
        $requete = $this->dao->prepare('INSERT INTO comments SET news=:news, contenu=:contenu, auteur=:auteur, date=NOW()');
        $requete->bindvalue(':news', $comment->news(), \PDO::PARAM_INT);
        $requete->bindvalue(':contenu', $comment->contenu());
        $requete->bindvalue(':auteur', $comment->auteur());
        $requete->execute();
    }

    public function getUnique ($id)
    {
        if (!ctype_digit($id))
        {
            throw new \InvalidArgumentException ('le numéro du commentaire doit être un entier');
        }
        $requete = $this->dao->prepare('SELECT * FROM comments WHERE id = :id');
        $requete->bindValue(':id', $id, \PDO::PARAM_INT);
        $requete->execute();
        
        $requete->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, '\Entity\News');
        
        if ($comment = $requete->fetch())
        {
            $comment->setDate(new \DateTime($comment->date()));

            return $comment;
        }   
        return null;
    }

    public function modify($comment)
    {
        
    }

    public function delete($id)
    {
        $request =$this->dao->prepare('DELETE FROM comments WHERE id =:id');
        $request->bindvalue (':id', $id, \PDO::PARAM_INT);
        $request->execute();
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