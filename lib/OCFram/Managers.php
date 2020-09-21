<?php

namespace OCFram;

class Managers
{
    protected $api = null;
    protected $dao = null;
    protected $managers = [];

    public function __construct ($api, $dao)
    {
        $this->api = $api;
        $this->dao = $dao;
    }

    public function getManagerOf ($module)
    {
        if (!is_string ($module) || empty($module))
        {
            throw new \InvalidArgumentException('Le module doit être une chaine de caractères valide');
        }
        else
        {
            //si ce module n'est pas présent dans la liste des managers alors le rajoute
            if (!isset($this->managers[$module]))
            {
                $manager = '\\Model\\'.$module.'Manager'.$this->api;
                // exit ($manager);
                $this->managers[$module] = new $manager($this->dao);
            }
            return $this->managers[$module]; 
        }
    }
}