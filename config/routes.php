<?php
use Cake\Routing\Router;
use App\Routing\Route;
use Cake\Core\Configure;
use Cake\Core\App;
use Cake\Routing\Route\DashedRoute;

Router::plugin('UserManager',["path"=>"/user-manager"], function ($routes) {

    $routes->setRouteClass(DashedRoute::class);

    $routes->connect("/",[
        "controller"=>"Accounts",
        "action"=>"index"
    ]);

    $routes->connect("/:controller",["action"=>"index"]);

    $routes->connect("/:controller/:action");

    $routes->fallbacks("DashedRoute");

});


Router::prefix("admin", ["path"=>"/admin"], function($routes) {

    $routes->setRouteClass(DashedRoute::class);

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

    if(!isset($v['callbackUrl'])) {

        Router::connect("/user-manager/auth-callback/".strtolower($k), [
            "plugin"=>"UserManager",
            "controller"=>"Login",
            "action"=>"handleForeignLogin"
        ]);

    } else {

        Router::connect($v['callbackUrl'], [
            "plugin"=>"UserManager",
            "controller"=>"Login",
            "action"=>"handleForeignLogin"
        ]);

    }

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
