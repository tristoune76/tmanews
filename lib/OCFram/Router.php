<?php

namespace OCFram;

class Router

{
    protected $routes = [];

    const NO_ROUTE = 1;

    public function routes() {return $this->routes;}
    
    public function addRoute (Route $route)
    {
        if (!in_array($route, $this->routes))
        {
            $this->routes[] = $route;
        }
    }

    public function getRoute ($url)
    {
        // exit ($url);        
        // exit(var_dump($this->routes));
        foreach($this->routes as $route)
        {
            $tabRoute[] = $route->url(); //Debuggage sur le routage

            //if the road corresponds to url
            if(($varsValues = $route->match($url)) !== false)
            {
                // exit('2');
                //if the route has variable
                if($route->hasVars())
                {
                    $varsName = $route->varsName();
                    $listVars=[];

                    //we are creating a news key/value array
                    //key = name of the variable and value = value of the variable
                    foreach ($varsValues as $key => $value)
                    {
                        //when using preg_match the first line of the array is not usefull (see preg_match manual)
                        if($key !==0)
                        {
                            //fulling the array with the variable
                            $listVars[$varsName[$key-1]] = $value;
                        }
                    }
                    //setting the vars variable of the route with the array
                    $route->setVars($listVars);
                }
                return $route;
            }
        }
        exit(var_dump($tabRoute).'<br>'.$url); //Debuggage sur le routage
        throw new \RuntimeException('No road for this url', self::NO_ROUTE);
    }
}