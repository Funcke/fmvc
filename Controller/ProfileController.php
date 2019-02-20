<?php
use Core\Data\SqlDataBase;
use Core\Controller;

class ProfileController extends Controller
{
    public static function edit($request)
    {
        include 'views/profile/edit.php';
    }
    
    public static function update($request)
    {
        
    }
    
    public static function view($request)
    {
        self::render('profile/index', array('title' => 'Profile', 'user' => $request->session['user']));
    }
    
    public static function follow($request)
    {
        
    }
}
?>