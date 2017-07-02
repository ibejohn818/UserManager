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


$path = App::path("Auth/Provider","UserManager");

$providers = [];

foreach(scandir($path[0]) as $v)
{
	if(in_array($v,['.','..']) 
		|| !preg_match('/\.php$/',$v) 
		|| preg_match('/ProviderBase/',$v)
	) {
		continue;
	}

	$providers[] = preg_replace('/(.*)(\.php$)/','$1',$v);

}

foreach($providers as $v) {

	if(Configure::read("UserManager.{$v}LoginEnable")) {

		Router::connect(Configure::read("UserManager.{$v}AuthRedirectUrl"),[
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
