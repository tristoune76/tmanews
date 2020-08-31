<?php

namespace OCFram;

session_start();

class User

{
    public function getAttribut($attr)
    {
        return isset($_SESSION[$attr]) ? $_SESSION[$attr] : null;
    }

    public function getFlash ()
    {
        $flash = $_SESSION['flash'];
        unset($_SESSION['flash']);
        return $flash;
    }

    public function hasFlash ()
    {
        return isset($_SESSION['flash']);
    }
    
}