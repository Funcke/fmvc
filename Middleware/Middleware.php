<?php
class Middleware
{
    public static function CheckLogin(&$request)
    {
        if(!array_key_exists('logedin', $request->session))
        {
            header('Location: /');
        }
    }
}
