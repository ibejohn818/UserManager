<?php
use Cake\Routing\Router;

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
		'uri'=>"[a-z\-]{2,}.html"
	]
);

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

if(defined("GOOGLE_CLIENT_REDIRECT_URL")) {

    $googleRedirectParts = parse_url(GOOGLE_CLIENT_REDIRECT_URL);

    Router::connect($googleRedirectParts['path'],[
        "plugin"=>"UserManager",
        "controller"=>"Login",
        "action"=>"handleForeignLogin"
    ]);
}
