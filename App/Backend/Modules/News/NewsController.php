<?php

namespace App\Backend\Modules\News;

use OCFram\BackController;
use OCFram\HTTPRequest;
use Entity\News;

class NewsController extends BackController
{
    public function executeIndex (HTTPRequest $request)
    {
        
        //send the variable title to the page
        $title = 'index des news';
        $this->page->addVar('title', $title);

        //get the manager of the module (News)
        $manager = $this->managers->getManagerOf('News');
        
        //retrieve the list and the numbre of all the news
        $newsList = $manager->getList();
        $count = $manager->count();

        //send the variable listNews and count to the page
        $this->page->addVar('newsList', $newsList);
        $this->page->addVar('count', $count);
    }
    public function executeInsert (HTTPRequest $request)
    {
        if ($request->postExists('auteur'))
        {
            $this->processForm ($request);
        }

        //send the variable title to the page
        $this->page->addVar('title', 'Ajouter une news');
    }

    public function executeUpdate (HTTPResquest $request)
    {
        if ($request->postExists('auteur'))
        {
            $this->processForm ($request);
        }
        else
        {
            //retrieving the news
            $news = $this->managers->getManagerOf('News')->getUnique($request->getData('id'));
            $this->page->addVar('news', news);
        }
        $this->app->user()->setFash('Modification d\'une news');
    }

    public function processForm ($request)
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