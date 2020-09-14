<?php

namespace OCFram;

abstract class Entity implements \ArrayAccess
{
    private $id;
    private $erreurs = [];

    public function id() {return $this->id;}
    public function erreurs() {return $this->erreurs;}

    public function __construct($donnees = [])
    {
        if(!empty($donnees))
        {
            $this->hydrate($donnees);        
        }
    }

    public function hydrate (array $donnees)
    {
        foreach($donnees as $attribut => $value)
        {
            $method = 'set'.ucfirst($attribut);
            if(is_callable([$this, $method]))
            {
                $this->$method($value);
            }
        }
        

    }

    public function setId ($id)
    {
        if(is_int($id))
        {
            $this->id = (int) $id;
        }
    }

    public function isNew ()
    {
        return (empty($this->id));
    }

    public function offsetGet($var)
    {
        if (isset($this->$var) && is_callable([$this, $var]))
        {
        return $this->$var();
        }
    }

    public function offsetSet($var, $value)
    {
        $method = 'set'.ucfirst($var);

        if (isset($this->$var) && is_callable([$this, $method]))
        {
        $this->$method($value);
        }
    }

    public function offsetExists($var)
    {
        return isset($this->$var) && is_callable([$this, $var]);
    }

    public function offsetUnset($var)
    {
        throw new \Exception('Impossible de supprimer une quelconque valeur');
    }


}