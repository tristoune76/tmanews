<?php

namespace OCFram;

class HTTPResponse extends ApplicationComponent
{
    protected $page;

    public function addHeader($header)
    {
        header($header);
    }

    public function redirect ($location)
    {
        header('Location: '.$location);
        exit;
    }

    public function redirect404()
    {

    }

    public function send()
    {

    }

    public function setPage()
    {
        $this->page = $page;
    }

    public function setCookie ($name, $value='', $expires=0, $path=null, $domain=null, $secure=false, $httponly=TRUE)
    {
        setcookie($name, $value, $expire, $path, $domain, $secure, $httponly);
    }
}