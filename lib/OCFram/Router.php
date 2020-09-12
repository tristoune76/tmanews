<?php

namespace OCFram;

class Router

{
    private $routes = [];

    const NO_ROUTE = 1;

    public function addRoute (Route $route)
    {
        if (in_array($route, $this->routes))
        {
            $this->routes[] = $route;
        }
    }

    public function getRoute ($url)
    {
        foreach( $this->routes as $route)
        {
            //if the road corresponds to url
            if(($varsValues = $route->match($url)) !== false)
            {
                
                //if the route has variable
                if($route->hasVars())
                {
                    $varsNames = $route->varsNames();
                    $listVars=[];

                    //we are creating a news key/value array
                    //key = name of the variable and value = value of the variable
                    foreach ($varNames as $key -> $value)
                    {
                        //when using preg_match the first line of the array is not usefull (see preg_match manual)
                        if($key !==0)
                        {
                            //fulling the array with the variable
                            $listVars[$varNames[$key-1]] = $value;
                        }
                    }
                    
                    //setting the vars variable of the route with the array
                    $route->setVars($listVars);
                }
                return $route;
            }
        }
        throw new \RuntimeException('No road for this url', self::NO_ROUTE);
    }
}