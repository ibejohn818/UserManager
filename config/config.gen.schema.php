<?php

$gen = [
    'User-Registration'=>[
        'help'=>'User registration options',
        'settings'=>[
            [
                'help'=>'Require user registration to verify email address',
                'key'=>'emailRegistration',
                'default'=>0
            ]
        ]
    ],
    'User-Password'=>[
        'help'=>'User password options',
        'settings'=>[
            [
                'help'=>'Number of passwords to maintain in history. 0=Infinite',
                'key'=>'userPasswdHistoryCount',
                'default'=>5
            ]
        ]
    ]
];

return $gen;
