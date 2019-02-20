<?php
class Middleware
{
    public static function CheckLogin(&$request)
    {
        if(!array_key_exists('user', $request->session))
        {
            http_response_code(403);
            exit();
        }
    }
}