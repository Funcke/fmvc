<?php
use Core\Data\SqlDataBase;
use Core\Controller;

class AuthenticationController
{
    public static function new(&$request)
    {
        $db = new SqlDataBase('user');
        $res = $db->query('INSERT INTO User(username, email, password) VALUES("'.$request->params['username'].'", "'.$request->params['email'].'", "'.password_hash($request->params[''], PASSWORD_DEFAULT).'")');
        if($res)
        {
            $request->session['user'] = $db->query('SELECT * FROM User WHERE username = "'.$request->params['username'].'"')->fetch_assoc();
            http_response_code(204);
            exit();
        } else {
            http_response_code(400);
            exit();
        }
    }
    
    public static function login(&$request)
    {
        $db = new SqlDatabase('user');
        $res = $db->query('SELECT * FROM User WHERE username = "'.$request->params['username'].'" AND password = "'.password_hash($request->params['password'], PASSWORD_DEFAULT).'"');
        if($res)
        {
            $request->session['user'] = $res->fetch_assoc();
            http_response_code(204);
            exit();
        } else {
            http_response_code(404);
            exit();
        }
    }
}
?>