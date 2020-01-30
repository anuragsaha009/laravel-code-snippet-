<?php

return [

    // 'markdown' => [
    //     'theme' => 'default',

    //     'paths' => [
    //         resource_path('views/vendor/mail'),
    //     ],
    // ],

    'payload'  => [
        'first_name' => '',
        'last_name' => '',
        'id' => '',
        'email' => '',
        'permission' => [],
    ],
    'responseArray' => [
        'status' => '',
        'type' => '',
        'body' => [ "message"=> '',
                    "type"=> ''
        ]   
    ],
    'fieldSpecification' => [
        'role_name' => [
                    'max_length' => 30,
                    'regex' => '^[^!@#$%^&*(),.?":{}|<>\d]*$'
        ],
        'operator_names'    => [
                    'max_length' => 30,
                    'regex' => '^[^!@#$%^&*(),.?":{}|<>\d]*$'
        ],
        'password'  => [
                    'min_length' => 8,
                    'max_length' => 15,
                    'regex' => '^(?=.*[A-Z])(?=.*\d)[A-Za-z\d]{8,15}$'
        ],
        'email_address' => [
                    'max_length'    => 255,
        ],
        'title' => [
            'max_length'    => 255,
        ]
    ]
];
