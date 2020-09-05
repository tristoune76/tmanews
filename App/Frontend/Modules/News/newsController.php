<?php

namespace App\Frontend\Modules\News;

use /OCFram/BackController;

class NewsController extends BackController
{
    public function executeIndex()
    {
        $nbreNews = $this->app->config()->get('nbreNews');
        $nbreCaractere = $this->app->config()->get('nbreCaractere');

        //setting the title of the view
        //so adding a variable title with the title we want
        $title = 'voici les '.$nbreNews.' dernières news publiées';
        $this->page->addVar('title', $title);

        //retrieving the manager for news
        $manager = $this->app->managers->getManagerOf('News');

        //getting the 5 last news
        $newsList = $manager->get(0, $nbreNews);

        //verifying if the news are not too long and shortening them if they are (adding ... at the end)
        foreach ($newsList as $news)
        {
            $content = $news->contenu();
            if (strlen($content) > $nbreCaractere)
            {
                $debut = substr($content, 0, $nbreCaractere);
                $debut = substr($content, $strrpos($debut, ' ')).'...';
            }
            $news->setContenu($debut);
        }

        //adding a variable contening the list of news for the page
        $this->page->addVar('newsList', $newsList);
    }
}
