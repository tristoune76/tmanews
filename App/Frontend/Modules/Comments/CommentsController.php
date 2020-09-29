<?php

namespace App\Frontend\Modules\Comments;


use OCFram\BackController;
use OCFram\HTTPRequest;
use OCFram\HTTPResponse;
use Entity\Comment;

class CommentsController extends BackController
{
    public function executeInsert(HTTPRequest $request)
    {
        $title = 'vous pouvez ajouter un commentaire.';
        $this->page->addVar('title', $title);
        
        if ($request->postExists('auteur'))
        {
            $this->performForm($request);
        }

    }

    public function performForm(HTTPRequest $request)
    {        
        $comment['contenu'] = $request->postData('contenu');
        $comment['auteur'] = $request->postData('auteur');
        $comment['news'] = $request->getData('newsId');
        $comment = new Comment($comment);

        if ($comment->isValid())
        {
            $manager = $this->managers->getManagerOf('Comments');
            $manager->add($comment);

            $this->app->user()->setFlash('Le commantaire a été coorectement ajouté');
            $this->app->httpResponse()->redirect('news-'.$_GET['newsId'].'.html');
        }
        else
        {
            $this->page->addVar('erreurs', $comment->erreurs());
        }

        // $this->page->addVar('comment', $comment);

    }

    public function executeShow(HTTPRequest $request)
    {
        $newsId = $request->getData('newsId');
        $id = $request->getData('id');

        $manager = $this->managers->getManagerOf('Comments');
        $comment = $manager->getUnique($newsId, $id);

        $this->page->addVar('comment', $comment);

    }
}


