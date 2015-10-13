<?php //-->
return array(
    '/dialog/login' => array(
        'method' => 'ALL',
        'role' => 'public_sso',
        'class' => '\\Eve\\App\\Dialog\\Action\\Login'
    ),
    '/dialog/request' => array(
        'method' => 'ALL',
        'role' => 'public_sso',
        'class' => '\\Eve\\App\\Dialog\\Action\\Request'
    ),
    '/dialog/create' => array(
        'method' => 'ALL',
        'role' => 'public_sso',
        'class' => '\\Eve\\App\\Dialog\\Action\\Create'
    ),
    '/dialog/update' => array(
        'method' => 'ALL',
        'role' => 'public_sso',
        'class' => '\\Eve\\App\\Dialog\\Action\\Update'
    ),
    '/dialog/logout' => array(
        'method' => 'GET',
        'role' => 'public_sso',
        'class' => '\\Eve\\App\\Dialog\\Action\\Logout'
    )
);