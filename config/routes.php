<?php
use Cake\Routing\Router;
use App\Routing\Route;
use Cake\Core\Configure;
use Cake\Core\App;

Router::plugin('UserManager',["path"=>"/user-manager"], function ($routes) {

    $routes->connect("/",[
        "controller"=>"Accounts",
        "action"=>"index"
    ]);

    $routes->connect("/:controller",["action"=>"index"]);

    $routes->connect("/:controller/:action");

    $routes->fallbacks("DashedRoute");

});


Router::prefix("admin",function($routes) {


    $routes->plugin("UserManager",["path"=>"/user-manager"],function($routes) {

        $routes->connect("/",[
            "controller"=>"Accounts",
            "action"=>"index"
        ]);

        $routes->connect("/:controller",["action"=>"index"]);

        $routes->connect("/:controller/:action");

        $routes->fallbacks("DashedRoute");

    });

});


foreach(Configure::read("UserManager.LoginProviders") as $k=>$v) {

    if(!$v['enabled']) {
        continue;
    }

    Router::connect("/user-manager/auth-callback/".strtolower($k),[
        "plugin"=>"UserManager",
        "controller"=>"Login",
        "action"=>"handleForeignLogin"
    ]);

}


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
