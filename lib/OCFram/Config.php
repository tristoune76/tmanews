<?php

namespace OCFram;

class Config Extends ApplicationComponent
{
    protected $var =[];

    public function get ($var)
    {
        if (!$this->vars)
        {
            $xml = new \DOMDocument;
            $xml->load('/../../App/'.$this->name.'/Config/app.xml');

            $elements = $xml->getElementByTagName('define');

            foreach ($elements as $element)
            {
                $this->vars[$element->getAttribute('var')] = $element->getAttribute('value');
            }
        }

        if (isset($this->vars[$var]))
        {
            return $this->vars($var);
        }
        return null;
    }    
}