<?php

namespace OCFram;

abstract class BackController extends ApplicationComponent
{

    //Every controller will extend fram this class. So they can use these common methods

    protected $action = '';
    protected $module = '';
    protected $page = null;
    protected $view = '';
    protected $managers = null;

    public function __construct (Application $app, string $module, string $action)
    {
        
        parent::__construct($app);
        $this->managers = new Managers ('PDO', PDOFactory::getMysqlConnexion());
        
        $this->setView($action);
        $this->setModule($module);
        $this->setAction($action);
        $this->page = new Page($app);
    }

    public function execute ()
    {
        //the method that is launched correspond to the action requested in the request. The name of the method is executeAction where Action is described in the request.
        $method = 'execute'.ucfirst($this->action);
        if (!is_callable([$this, $method]))
        {
            throw new \RuntimeException('L\'action "'.$this->action.'" n\'est pas définie sur ce module');
        }
        $this->$method($this->app->httpRequest());
    }

    public function action() {return $this->action;}
    public function module() {return $this->module;}
    public function page() {return $this->page;}
    public function view() {return $this->view;}
    
    public function setAction ($action)
    {
        if (is_string($action) && !empty($action))
        {
            $this->action = $action;
        }
        else
        {
            throw new \InvalidArgumentException('L\'action doit être une chaine de caractères valide');
        }
    }

    public function setModule ($module)
    {
        if (!is_string($module) || empty($module))
        {
            throw new \InvalidArgumentException('Le module doit être une chaine de caractères valide');
        }
        else
        {
            $this->module = $module;
        }
    }

    public function setView ($view)
    {
        if (is_string($view) && !empty($view))
        {
            $this->view = $view;

            $this->page->setContentFile(__DIR__.'/../../App/'.$this->app->name().'/Modules/'.$this->module().'/Views/'.$this->view.'.php');
        }
        else
        {
            throw new \InvalidArgumentException('La vue doit être une chaine de caractères valide');
        }
    }

    public function setPage (Page $page)
    {
        $this->page = $page;
    }
}