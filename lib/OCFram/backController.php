<?php

namespace OCFram;

abstract class BackController extends ApplicationComponent
{

    protected $action = "";
    protected $module = "";
    protected $page = null;
    protected $view = "";

    public function action {return $this->action;}
    public function module {return $this->module;}
    public function page {return $this->page;}
    public function view {return $this->view;}

    public setAction ($action)
    {
        if (is_string($action))
        {
            $this->action = $action;
        }
    }

    public setModule ($module)
    {
        if (is_string($module))
        {
            $this->module = $module;
        }
    }

    public setView ($view)
    {
        if (is_string($view))
        {
            $this->view = $view;
        }
    }

    public setPage (Page $page)
    {
        $this->page = $page;
    }

    public function __construct (Application $app, string $module, string $action)
    {
        
        parent->__construct($app);
        
        $this->setView($action);
        $this->setModule($module);
        $this->setAction($action);
        $this->page = new Page;
    }

    public function execute (HttpRequest $httprequest)
    {
        
    }
}