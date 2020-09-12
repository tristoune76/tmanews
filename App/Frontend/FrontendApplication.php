<?php

namespace App\Frontend;

use \OCFram\Application;

class FrontendApplication extends Application
{
    public function __construct()
    {        
        //Construction of application using constructor of parent class
        parent::__construct();

        //Name assignation
        $this->name = 'Frontend';
    }

    public function run()
    {
        //Obtention du contrôleur avec les informations de la requête - utilisation de la méthode de la classe parente
        $controller = $this->getController();

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