<?php

namespace OCFram;

class Route
{
    private $action;
    private $module;
    private $url;
    private $varNames;
    private $vars = [];

    public function __construct ($action, $module, $url, $varNames)
    {
        $this->setAction($action);
        $this->setModule($module);
        $this->setUrl($url);
        $this->setVarNames($varNames);
        
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

    public function setVarNames($varNames)
    {
        $this->varNames = $varNames;
    }

    public function setVars(array $vars)
    {
        $this->vars = $vars;
    }

    public function hasVars ()
    {
        return !empty($this->varsNames);
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
    public function varNames() {return $this->varNames;}
    public function vars() {return $this->vars;}
}