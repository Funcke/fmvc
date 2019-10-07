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
        self::render('profile/index', array('title' => 'Profile', 'user' => $request->session['user']));
    }
    
    public static function follow($request)
    {
        
    }

    public static function showUserStruct($request)
    {
        #$base = new SqlDataBase();
        #$base->execute(SqlTableCreator::create('Models\User'));
        print SqlTableCreator::create('Models\User');
    }
}