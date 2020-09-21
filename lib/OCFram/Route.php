<?php

namespace OCFram;

class Route
{
    protected $action;
    protected $module;
    protected $url;
    protected $varsName;
    protected $vars = [];

    public function __construct ($action, $module, $url, $varsName)
    {
        $this->setAction($action);
        $this->setModule($module);
        $this->setUrl($url);
        $this->setvarsName($varsName);
    }

    public function setAction($action)
    {
        if (is_string($action))
        {
            $this->action = $action;
        }
    }
    
    public function setUrl($url)
    {
        if (is_string($url))
        {
            $this->url = $url;
        }
    }

    public function setModule($module)
    {
        if (is_string($module))
        {
            $this->module = $module;
        }
    }   

    public function setvarsName($varsName)
    {
        $this->varsName = $varsName;
    }

    public function setVars(array $vars)
    {
        $this->vars = $vars;
    }

    public function hasVars ()
    {
        return !empty($this->varsName);
    }

    public function match ($url)
    {
        if(preg_match("`^".$this->url."$`",$url,$matches))
        {
            return $matches;
        }
        else
        {
            return false;
        }
    }

    public function url() {return $this->url;}
    public function action() {return $this->action;}
    public function module() {return $this->module;}
    public function varsName() {return $this->varsName;}
    public function vars() {return $this->vars;}
}