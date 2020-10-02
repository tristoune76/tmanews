<?php

namespace App\Backend\Modules\News;

use OCFram\BackController;
use OCFram\HTTPRequest;
use Entity\News;
use Entity\Comments;

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

    public function executeUpdate (HTTPRequest $request)
    {
        if ($request->postExists('auteur'))
        {
            $this->processForm ($request);
            // $this->executeIndex($request);
        }
        else
        {      
            //retrieving the news
            $news = $this->managers->getManagerOf('News')->getUnique($request->getData('id'));
            $this->page->addVar('news', $news);
        }
        $this->page->addVar('title', 'Modifier une news');
    }

    public function processForm ($request)
    {
        //saving all parameters
        $news['titre'] = htmlspecialchars($request->postData('titre'));
        $news['contenu'] = htmlspecialchars($request->postData('contenu'));
        $news['auteur'] = htmlspecialchars($request->postData('auteur'));
        $news = new News($news);

        if ($request->postExists('id'))
        {
            $news->setId($request->postData('id'));
        }

        //is this a valid News
        if ($news->isValid())
        {
            $this->managers->getManagerOf('News')->save($news);
            $this->app->user()->setFlash($news->isNew() ? 'La news a bien été ajoutée' : 'La news a bien été modifiée');
            $this->app->httpResponse()->redirect("/admin/");
        }
        else
        {
            $this->page->addVar('erreurs', $news->erreurs());
        }
        // $this->page->addVar('news',$news);
    }

    public function executeDelete (HTTPRequest $request)
    {
        if ($request->postExists('delete_OK'))
        {
            $news = $this->managers->getManagerOf('News')->delete($request->getData('id'));
            $this->app->user()->setFlash('La news a été effacée.');
            $this->app->httpResponse()->redirect("/admin/");
        }
        elseif ($request->postExists('delete_NOK'))
        {      
            //retrieving the news
            $this->app->user()->setFlash('La news n\'est pas effacée.');
            $this->app->httpResponse()->redirect("/admin/");
        }
        else
        {
            $this->page->addVar('title', 'Effacer une news - controller');
        }
    }

    public function executeShow(HTTPRequest $request)
    {
        $title = 'Voici la news n°'.$request->getData('id');
        $this->page->addVar('title', $title);
        
        //getting the news we want to show
        $manager = $this->managers->getManagerOf('News');

        $news = $manager->getUnique($request->getData('id'));

        // exit ($news->contenu());
        if (empty($news))
        {
            $this->app->httpResponse()->redirect404();
        }
 
        //adding a variable contening the news for the page
        $this->page->addVar('news' , $news);


        $commentManager = $this->managers->getManagerOf('Comments');
        $newsId = $request->getData('id');
        //verifying if there is comment
       
        if ($commentManager->count($newsId) == 0)
        {
            $commentMessage = 'Pas de commentaire pour cette news';
            $this->page->addVar('commentMessage', $commentMessage);
        }
        else
        {
            //getting the comments of the news
            $commentsList = $commentManager->getListOf($newsId);
            //adding a variable contening the list of comments for the page
            $this->page->addVar('commentsList', $commentsList);
        }
    }

}