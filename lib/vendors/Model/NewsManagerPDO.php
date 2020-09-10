<?php

namespace Model;

use \Entity\News;

class NewsManagerPDO extends NewsManager
{
    public function getList ($debut = -1, $nbreNews = -1)
    {
        $sql = 'SELECT id contenu auteur titre FROM news ORDER BY id DESC';
        if (!$debut ==-1 || !$limite ==-1)
        {
            $sql .= ' LIMIT '.(int) $debut.','.(int) $nbrNews;
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
}