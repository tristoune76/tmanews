<?php

namespace App\Backend\Modules\Connexion;

use OCFram\BackController;
use OCFram\HTTPRequest;

class ConnexionController extends BackController
{
    public function executeIndex(HTTPRequest $request )
    {
        
        // setting the title of the page
        $title = 'Connexion au site';
        $this->page->addVar('title', $title);

        //verifying if a login has been passed in the form
        if ($request->postExists('login'))
        {
            //verifying that there are post datas that have been passed
            if ($request->postData('login') && $request->postData('password'))
            {
                $login = $request->postData('login');
                $password = $request->postData('password');
                
                //checking if login and password match
                if ($login == $this->app->config()->get('login') && $password == $this->app->config()->get('password'))
                {
                    //setting the authentification flag as true
                    $this->app->user()->setAuthenticated(true);
                    //redirecting to the same page but as the authenticated flag is on we will be redirected to the admin space
                    $this->app->HTTPResponse()->redirect('.');     

                }
                else
                {
                    //indicating with a flash message that the tlogin is false
                    $this->app->user()->setFlash('mauvais login ou mot de passe reessayez');
                }
    
            }
        }
    }
       
}