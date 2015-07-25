<?php
    session_start();

    $GLOBALS['config'] = array(                                                             //config
        'mysql' => array(
            'host' => '',
            'username' => 'r',
            'password' => '',
            'db' => ''
        ),
        'remember' => array(
            'cookie_name' => 'hash',
            'cookie_expiry' => 604800
        ),
        'session' => array(
            'session_name' => 'user',
            'token_name' => 'token'
        )
    );

    spl_autoload_register(function($class) {                                                //auto load classes by name
        require_once('classes/' . $class . '.php');
    });

    require_once 'functions/sanitize.php';                                                  //manually load function

                                                            //below: if remember cookie exists but there is no logged in session

    if(Cookie::exists(Config::get('remember/cookie_name')) && !Session::exists(Config::get('session/session_name'))) {

        $hash = Cookie::get(Config::get('remember/cookie_name'));                           //set hash to the remember hash
        $hashCheck = DB::getInstance()->get('users_session', array('hash', '=', $hash));    //get hashcheck (remember hash) from users_session table

        if($hashCheck->count()) {                                                           //if hashCheck was stored

            $user = new User($hashCheck->first()->user_id);                                 //set a new user according to the user_id from hashCheck
            $user->login();                                                                 //log that user in
        }
    }
