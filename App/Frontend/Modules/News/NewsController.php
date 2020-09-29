<?php

namespace App\Frontend\Modules\News;

use \OCFram\BackController;
use \OCFram\HTTPRequest;

class NewsController extends BackController
{
    public function executeIndex(HTTPRequest $request)
    {
        $nbreNews = $this->app->config()->get('nbreNews');
        $nbreCaractere = $this->app->config()->get('nbreCaractere');

        //setting the title of the view
        //so adding a variable title with the title we want
        $title = 'voici les '.$nbreNews.' dernières news publiées';
        $this->page->addVar('title', $title);

        //retrieving the manager for news
        $manager = $this->managers->getManagerOf('News');

        //getting the 5 last news
        $newsList = $manager->getList(0, $nbreNews);

        //verifying if the news are not too long and shortening them if they are (adding ... at the end)
        foreach ($newsList as $news)
        {
            // $content = $news->contenu();
            if (strlen($news->contenu()) > $nbreCaractere)
            {
                $debut = substr($news->contenu(), 0, $nbreCaractere);
                $debut = substr($debut, 0, strrpos($debut, ' ')).'...';
                $news->setContenu($debut);
            }
        }

        //adding a variable contening the list of news for the page
        $this->page->addVar('newsList', $newsList);
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
