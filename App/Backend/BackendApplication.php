<?php

namespace App\Backend;

use \OCFram\Application;

class BackendApplication extends Application
{
    public function __construct()
    {        
        //Construction of application using constructor of parent class
        parent::__construct();

        //Name assignation
        $this->name = 'Backend';
    }

    public function run()
    {
        //Vérification que l'utilisateur administrateur est connecté
        //Si ce n'est pas le cas, on renvoie vers la page de connection
        if ($this->user()->isAuthenticated())
        {
            //Obtention du contrôleur avec les informations de la requête - utilisation de la méthode de la classe parente
            $controller = $this->getController();
        }
        else
        {
            //renvoie vers la page de connection
            $controller = new Modules\Connexion\ConnexionController($this, 'Connexion', 'index');
        }
        
        
         //Exécution du contrôleur - utilisation de la méthode de la classe parente du controller => backControllet avec la méthode déterminée grâce à l'action issue de la route qui correspond à l'URI.
        $controller->execute();

        //Assignation de la page créée par le controleur pour la réponse
        //utilisation de l'instanciation de l'objet Response dans la classe parente
        // et de sa fonction setPage qui utilise la page retournée par le contrôlleur
        $this->httpResponse->setPage($controller->page());

        //Envoi de la page créée
        $this->httpResponse->send();
    }
}