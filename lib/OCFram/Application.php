<?php

namespace OCFram;

abstract class Application
{
    //class witch represents all the application
    
    protected $httpRequest;
    protected $httpResponse;
    protected $name;
    protected $user;
    protected $config;

    public function __construct()
    {
        //when constructing it creates all its differents components
        //the application deals with a request that tells it what asked and what to do and a response that it  when the request is complete

        $this->httpRequest =  new HTTPRequest($this);
        $this->httpResponse = new HTTPResponse($this);
        $this->user = new User ($this);
        $this->config = new Config ($this);

        $this->name = '';
    }

    public function getController()
    {
        //this function retrieves the controller that corresponds to the application
        //the controller is determine from the matching between the routes for an application that are listed in an xml file anf the request.
        //The routes contain the module, the action to do and some variables so when matching with a request we can launch the good action, in the good controller, with the good modules (manager) and the associated variables.
        //The xml file lists all the routes from every app
        //the router contains all the routes off an app extracted fromthe xml file

        //creation of the router
        $router = new Router;

        //loadinfg the xml file
        $xml = new \DOMDocument;
        $xml->load(__DIR__.'/../../App/'.$this->name.'/Config/routes.xml');

        //storing all the routes in an array
        $routes = $xml->getElementsByTagName('route');

        // On parcourt les routes du fichier XML et on va les stocker dans le router.
        foreach ($routes as $route)
        {
            $vars = [];

            // On regarde si des variables sont présentes dans l'URL.
            if ($route->hasAttribute('vars'))
            {
                $vars = explode(',', $route->getAttribute('vars'));
            }


            // On ajoute la route au routeur.
            $router->addRoute(new Route($route->getAttribute('action'), $route->getAttribute('module') ,$route->getAttribute('url'), $vars));
            
        }
        try
        {
            // exit($this->httpRequest->requestURI());

            // On récupère la route correspondante à l'URL.
            $matchedRoute = $router->getRoute($this->httpRequest->requestURI());
        }
        catch (\RuntimeException $e)
        {
            if ($e->getCode() == Router::NO_ROUTE)
            {
                // Si aucune route ne correspond, c'est que la page demandée n'existe pas.
                $this->httpResponse->redirect404();
            }
        }

        // On ajoute les variables de l'URL au tableau $_GET.
        $_GET = array_merge($_GET, $matchedRoute->vars());
        // exit (var_dump($_GET));

        // getting the path and name of the controller so we can create a new object of this controller - using namespaces
        $controllerClass = 'App\\'.$this->name.'\\Modules\\'.$matchedRoute->module().'\\'.$matchedRoute->module().'Controller';
        
        //returning the controller constructed whith the constructor of the backController
        return new $controllerClass($this, $matchedRoute->module(), $matchedRoute->action());
    }


    abstract public function run();

    //Getters  
    public function httpRequest() { return $this->httpRequest; }
    public function httpResponse() { return $this->httpResponse; }
    public function name() { return $this->name; }
    public function config() { return $this->config; }
    public function user() { return $this->user; }
}

