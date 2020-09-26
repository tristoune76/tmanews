<?php

namespace Model;

use \Entity\News;

class NewsManagerPDO extends NewsManager
{
    public function getList ($debut = -1, $nbreNews = -1)
    {
        $sql = 'SELECT * FROM news ORDER BY id DESC';
        if ($debut !=-1 || $nbreNews !=-1)
        {
            $sql .= ' LIMIT '.(int) $nbreNews.' OFFSET '.(int) $debut;
        }
        $requete = $this->dao->query($sql);
        $requete->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, '\Entity\News');
    
        $listeNews = $requete->fetchAll();
        
        foreach ($listeNews as $news)
        {
            $news->setDateAjout(new \DateTime($news->dateAjout()));
            $news->setDateModif(new \DateTime($news->dateModif()));
        }
        
        $requete->closeCursor();
        
        return $listeNews;
    }

    public function getUnique ($id)
    {
        $requete = $this->dao->prepare('SELECT id, auteur, titre, contenu, dateAjout, dateModif FROM news WHERE id = :id');
        $requete->bindValue(':id', (int) $id, \PDO::PARAM_INT);
        $requete->execute();
        
        $requete->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, '\Entity\News');
        
        if ($news = $requete->fetch())
        {
            $news->setDateAjout(new \DateTime($news->dateAjout()));
            $news->setDateModif(new \DateTime($news->dateModif()));

            return $news;
        }   
        return null;
    }

    public function getComments ($id)
    {
        return ('comments');
    }

    public function count()
    {
        $requete = $this->dao->query('SELECT COUNT(*) FROM news');
        return $requete->fetchColumn();
    }

    public function modify($news)
    {

        $request = $this->dao->prepare('UPDATE contenu = :contenu, titre = :titre, auteur = :auteur, dateModif=NOW() FROM news WHERE id = :id');
        $request->bindvalue (':contenu', $news->contenu());
        $request->bindvalue (':titre', $news->titre());
        $request->bindvalue (':auteur', $news->auteur());
        $request->bindvalue (':id', $news->id());

        $request->execute();

        $flash = 'news correctement modifiée.';

        return $flash;
    }

    public function add($news)
    {

        $request = $this->dao->prepare('INSERT INTO news SET contenu = :contenu, titre = :titre, auteur = :auteur, dateAjout=NOW(), dateModif=NOW()');
        $request->binvalue (':contenu', $news->contenu());
        $request->binvalue (':titre', $news->titre());
        $request->binvalue (':auteur', $news->auteur());

        $request->execute();

        $flash = 'news correctement insérée.';

        return $flash;

    }

}