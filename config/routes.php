<?php
use Cake\Routing\Router;
use UserManager\Config\Config;
use App\Routing\Route;

Router::plugin('UserManager',["path"=>"/user-manager"], function ($routes) {

    $routes->connect("/",[
        "controller"=>"UserAccounts",
        "action"=>"index"
    ]);

    $routes->connect("/:controller",["action"=>"index"]);

    $routes->connect("/:controller/:action");

    $routes->fallbacks("DashedRoute");

});


Router::prefix("admin",function($routes) {


    $routes->plugin("UserManager",["path"=>"/user-manager"],function($routes) {

        $routes->connect("/",[
            "controller"=>"UserAccounts",
            "action"=>"index"
        ]);

        $routes->connect("/:controller",["action"=>"index"]);

        $routes->connect("/:controller/:action");

        $routes->fallbacks("DashedRoute");

    });

});

if(Config::googleLoginRedirectUrl()) {

    $googleRedirectParts = parse_url(Config::googleLoginRedirectUrl());

    Router::connect($googleRedirectParts['path'],[
        "plugin"=>"UserManager",
        "controller"=>"Login",
        "action"=>"handleForeignLogin"
    ]);
}

if(Config::facebookLoginRedirectUrl()) {

    $facebookRedirect = parse_url(Config::facebookLoginRedirectUrl());

    Router::connect($facebookRedirect['path'],[
        "plugin"=>"UserManager",
        "controller"=>"Login",
        "action"=>"handleForeignLogin"
    ]);
}


if(Config::twitterLoginRedirectUrl()) {

    $twitterRedirect = parse_url(Config::twitterLoginRedirectUrl());

    Router::connect($twitterRedirect['path'],[
        "plugin"=>"UserManager",
        "controller"=>"Login",
        "action"=>"handleForeignLogin"
    ]);
}

Router::connect(Config::get("githubRedirectUrl"),[
	'plugin'=>'UserManager',
	'controller'=>'Login',
	'action'=>'handleForeignLogin'
]);

## Login Url
Router::connect("/login",[
	'plugin'=>'UserManager',
	'controller'=>'Login',
	'action'=>'index'
]);

#Register

Router::connect("/register",[
	'plugin'=>'UserManager',
	'controller'=>'Login',
	'action'=>'register'
]);

#Forgot Password
Router::connect("/forgot-password",[
	'plugin'=>'UserManager',
	'controller'=>'Login',
	'action'=>'forgotPassword'
]);


#Profile 
Router::connect("/profile/:uri",
	[
		'plugin'=>'UserManager',
		'controller'=>'Profile',
		'action'=>'view'
	],
	[
		'uri'=>"[a-z\-\.]{2,}.html"
	]
);
