<?php
use Core\Controller;
use Core\Request;
use Models\User;

class SessionController extends Controller
{
    public static function create(Request &$request)
    {
        self::render('session/new', $request, array('title' => 'Log In!', $request->params));
    }

    public static function login(Request &$request)
    {
        
        $user = User::find(
            array(
                'Email' => $request->params['email']
            )
        )[0];
        if(is_object($user) == 1 && password_verify($request->params['password'], $user->Password) == 1) {
            $_SESSION['logedin'] = $user->id;
            $_SESSION['selected_bot'] = 1;
            header('Location: '.(array_key_exists('origin', $request->params)? $request->params['origin'] : '/'));
        } else {
            header('Location: /authenticate');
        }
    }
    
    public static function setBot(&$request) {
        $_SESSION['selected_bot'] = $request->params['selected_bot'];
        http_response_code(200);
    }
    
    public static function logout(Request &$request) 
    {
        unset($_SESSION['logedin']);
        header('Location: /');
    }
}
