<?php

return [
	'General'=>[
		'help'=>'General Settings',
		'settings'=>[
			'emailTransport'=>[
				'help'=>'The email transport to use for sending emails from the usermanager plugin',
				'default'=>'default'
			],
			'masterPassword'=>[
				'help'=>'The master password that will allow you to login to any account. If left blank then no master password will be configured',
				'default'=>''
			],
			'passwordExpireDays'=>[
				'help'=>'',
				'default'=>'0'
			],
			'profileImageServerPath'=>[
				'help'=>'Path on the server profile images will be saved to',
				'default'=>'/mnt/profile-images'
			],
			'profileImageWwwPath'=>[
				'help'=>'The path relative to the webroot that profile images will be upload and serverd from. Ensure this directory is writable',
				'default'=>'/profile-images'
			],
		]
	],
	'GoogleLogin'=>[
		'help'=>'Enable and config Google Login and API',
		'settings'=>[
			'GoogleLoginEnable'=>[
				'help'=>'Enable Google Login. 0=OFF, 1=ON',
				'default'=>'0'
			],
			'GoogleClientId'=>[
				'help'=>'Google API Google Login Client ID',
				'default'=>''
			],
			'GoogleClientSecret'=>[
				'help'=>'Google API Google Login Client Secre',
				'default'=>''
			],
			'GoogleClientScopes'=>[
				'help'=>'Google Login Permission Scopes. Seperate scopes by a space. \'email\' and \'profile\' are required',
				'default'=>'email profile'
			],
			'GoogleAuthRedirectUrl'=>[
				'help'=>'Google OAUTH Redirect URL. Do not put the host, only the URI. This must be registered in your app settings on google',
				'default'=>'/user-manager/auth-callback/google'
			],
		]
	],
	'FacebookLogin'=>[
		'help'=>'Enable and configure Facebook login and API',
		'settings'=>[
			'FacebookLoginEnable'=>[
				'help'=>'Enable Facebook Login. 0=OFF, 1=ON',
				'default'=>'0'
			],
			'FacebookSecret'=>[
				'help'=>'Facebook App API Secret for Facebook Login',
				'default'=>''
			],
			'FacebookId'=>[
				'help'=>'Facebook App API ID for Facebook Login',
				'default'=>''
			],
			'FacebookScopes'=>[
				'help'=>'Facebook App API Permission Scopes. Seperate scopes by a space. \'email\' is requries',
				'default'=>'email'
			],
			'FacebookAuthRedirectUrl'=>[
				'help'=>'Facebook login redirect URL.',
				'default'=>'/user-manager/auth-callback/facebook'
			],
		]
	],
	'GithubLogin'=>[
		'help'=>'Enable and configure Github login and API',
		'settings'=>[
			'GithubLoginEnable'=>[
				'help'=>'Enable Github Login. 0=OFF, 1=ON',
				'default'=>'0'
			],
			'GithubClientId'=>[
				'help'=>'Github Registered App ClientID Used for github.com login',
				'default'=>''
			],
			'GithubClientSecret'=>[
				'help'=>'Github registered App Client Secret Used for github.com login',
				'default'=>''
			],
			'GithubApiScopes'=>[
				'help'=>'Github permissions scopes user will be asked to grant your application access to',
				'default'=>'user:email'
			],
			'GithubAuthRedirectUrl'=>[
				'help'=>'Github OAUTH Redirect URL. If you do not use the default, then make sure you update the routes',
				'default'=>'/user-manager/auth-callback/github'
			],
			'GithubApiCacheConfig'=>[
				'help'=>'CakePHP Cache Config for caching API Calls using the ETAG Header',
				'default'=>'default'
			],
		]
	],
	'BitbucketLogin'=>[
		'help'=>'Enable and configure Bitbucket login and API',
		'settings'=>[
			'BitbucketLoginEnable'=>[
				'help'=>'Enable Bitbucket Login. 0=OFF, 1=ON',
				'default'=>'0'
			],
			'BitbucketClientKey'=>[
				'help'=>'Bitbucket Registered App ClientID Used for github.com login',
				'default'=>''
			],
			'BitbucketClientSecret'=>[
				'help'=>'Bitbucket registered App Client Secret Used for github.com login',
				'default'=>''
			],
			'BitbucketApiScopes'=>[
				'help'=>'Bitbucket permissions scopes user will be asked to grant your application access to',
				'default'=>'user:email'
			],
			'BitbucketAuthRedirectUrl'=>[
				'help'=>'Github OAUTH Redirect URL. If you do not use the default, then make sure you update the routes',
				'default'=>'/user-manager/auth-callback/bitbucket'
			],
			'BitbucketApiCacheConfig'=>[
				'help'=>'CakePHP Cache Config for caching API Calls using the ETAG Header',
				'default'=>'default'
			],
		]
	],
	'YahooLogin'=>[
		'help'=>'Enable and configure Github login and API',
		'settings'=>[
			'YahooLoginEnable'=>[
				'help'=>'Enable Yahoo Login. 0=OFF, 1=ON',
				'default'=>'0'
			],
			'YahooClientId'=>[
				'help'=>'Yahoo Registered App ClientID Used for github.com login',
				'default'=>''
			],
			'YahooClientSecret'=>[
				'help'=>'Yahoo registered App Client Secret Used for github.com login',
				'default'=>''
			],
			'YahooApiScopes'=>[
				'help'=>'Yahoo permissions scopes. Comma separated. View Here: https://developer.yahoo.com/oauth2/guide/yahoo_scopes/',
				'default'=>'sdps-r'
			],
			'YahooAuthRedirectUrl'=>[
				'help'=>'Yahoo OAUTH Redirect URL. If you do not use the default, then make sure you update the routes',
				'default'=>'/user-manager/auth-callback/yahoo'
			]
		]
	],
	'TwitterLogin'=>[
		'help'=>'Enable and configure Twitter login and API',
		'settings'=>[
			'TwitterLoginEnable'=>[
				'help'=>'Enable Twitter Login. 0=OFF, 1=ON',
				'default'=>'0'
			],
			'TwitterConsumerKey'=>[
				'help'=>'Twitter Registered App ClientID Used for github.com login',
				'default'=>''
			],
			'TwitterConsumerSecret'=>[
				'help'=>'Twitter registered App Client Secret Used for github.com login',
				'default'=>''
			],
			'TwitterAuthRedirectUrl'=>[
				'help'=>'Twitter permissions scopes user will be asked to grant your application access to',
				'default'=>'/user-manager/auth-callback/twitter'
			],
		]
	],
];
