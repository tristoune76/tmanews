<?php

namespace App\Backend\Modules\News;

use OCFram\BackController;
use OCFram\HTTPRequest;

class NewsController extends BackController
{
    public function executeIndex (HTTPRequest $request)
    {
        
        //send the variable title to the page
        $this->page->addVar('title', 'index des news');

        //get the manager of the module (News)
        $manager = $this->managers->getManagerOf('News');
        
        //retrieve the list and the numbre of all the news
        $listeNews = $manager->getList();
        $count = $manager->count();

        //send the variable listNews and count to the page
        $this->page->addVar('listNews', $listNews);
        $this->page->addVar('count', $count);
    }
    public function executeInsert (HTTPRequest $request)
    {
        if ($request->postExists('auteur'))
        {
            performForm ($request);
        }

        $this->app->user()->setFash('Ajout d\'une news');
    }

    public function executeUpdate (HTTPResquest $request)
    {
        //retrieving the id of the news to update

        //retrieving the news
        $news = $this->managers->getManagerOf('News')->getUnique($id);
    }

    public function performForm ($request)
    {
        //saving all parameters
        $news['titre'] = $request->postData('titre');
        $news['contenu'] = $request->postData('contenu');
        $news['auteur'] = $request->postData('auteur');
        $news = new News($news);

        if ($request->postExists('id'))
        {
            $news->setId($request->postData('id'));
        }
        //is this a valid News
        if ($news->isValid())
        {
            $this->managers->getManagerOf('News')->save($news);
            $this->app->user()->setFash($news->isNews() ? 'La news a bien été modifiée' : 'La news a bien été ajoutée');
        }
        else
        {
            $this->page->addVar('erreurs', $news->erreurs());
        }
        $this->page->addVar('news',$news);
    }

}