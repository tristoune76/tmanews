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

    public function update($news)
    {
        // exit('update');
        
        $request = $this->dao->prepare('UPDATE news SET contenu = :contenu, titre = :titre, auteur = :auteur, dateModif=NOW() WHERE id = :id');
        $request->bindvalue (':contenu', $news->contenu());
        $request->bindvalue (':titre', $news->titre());
        $request->bindvalue (':auteur', $news->auteur());
        $request->bindvalue (':id', $news->id(), \PDO::PARAM_INT);

        $request->execute();
    }

    public function add($news)
    {

        // exit('add');

        $request = $this->dao->prepare('INSERT INTO news SET contenu = :contenu, titre = :titre, auteur = :auteur, dateAjout=NOW(), dateModif=NOW()');
        $request->bindvalue (':contenu', $news->contenu());
        $request->bindvalue (':titre', $news->titre());
        $request->bindvalue (':auteur', $news->auteur());

        $request->execute();
    }

    public function delete($id)
    {
        $request =$this->dao->prepare('DELETE FROM news WHERE id =:id');
        $request->bindvalue (':id', $id, \PDO::PARAM_INT);
        $request->execute();
    }
}