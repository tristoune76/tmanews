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
        $page = new Page($this->app);
        $page->setContentFile ($page->__DIR__.'/../../redirect404.html');

        $this->addHeader('HTTP/1.0 404 Not Found');
        $this->send();

    }

    public function send()
    {
        exit($this->page->getGeneratedPage());
    }

    public function setPage($page)
    {
        $this->page = $page;
    }

    public function setCookie ($name, $value='', $expires=0, $path=null, $domain=null, $secure=false, $httponly=TRUE)
    {
        setcookie($name, $value, $expire, $path, $domain, $secure, $httponly);
    }
}