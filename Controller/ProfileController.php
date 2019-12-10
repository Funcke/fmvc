<?php
use Core\Controller;
use Core\Data\SqlDataBase;
use Core\Data\SqlTableCreator;
use Core\Request;
use Models\User;

class ProfileController extends Controller
{
    public static function edit($request)
    {
        new User();
        include 'views/profile/edit.php';
    }
    
    public static function test(Request $request)
    {
        echo $request->method;
    }
    
    public static function view($request)
    {
        self::render('profile/index', $request, array('title' => 'Profile', 'user' => $request->session['user']));
    }
    
    public static function follow($request)
    {
        
    }

    public static function showUserStruct($request)
    {
        (new User())->store();
        print_r(User::all());
        //print SqlTableCreator::create('Models\User', 'mysql');
    }
}