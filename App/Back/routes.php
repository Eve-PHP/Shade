<?php //-->
return array(
	'/control/login' => array(
		'method' => 'ALL',
		'role' => 'public_sso',
		'class' => '\\Eve\\App\\Back\\Action\\Login'
	),
	'/control/create' => array(
		'method' => 'ALL',
		'role' => 'public_sso',
		'class' => '\\Eve\\App\\Back\\Action\\Create'
	),
	'/control/update' => array(
		'method' => 'ALL',
		'role' => 'public_sso',
		'class' => '\\Eve\\App\\Back\\Action\\Update'
	),
	'/control/logout' => array(
		'method' => 'GET',
		'role' => 'public_sso',
		'class' => '\\Eve\\App\\Back\\Action\\Logout'
	),
	'/control/app/create' => array(
		'method' => 'ALL',
		'class' => '\\Eve\\App\\Back\\Action\\App\\Create'
	),
	'/control/app/refresh' => array(
		'method' => 'GET',
		'class' => '\\Eve\\App\\Back\\Action\\App\\Refresh'
	),
	'/control/app/remove' => array(
		'method' => 'GET',
		'class' => '\\Eve\\App\\Back\\Action\\App\\Remove'
	),
	'/control/app/restore' => array(
		'method' => 'GET',
		'class' => '\\Eve\\App\\Back\\Action\\App\\Restore'
	),
	'/control/app/search' => array(
		'method' => 'ALL',
		'class' => '\\Eve\\App\\Back\\Action\\App\\Search'
	),
	'/control/app/update' => array(
		'method' => 'ALL',
		'class' => '\\Eve\\App\\Back\\Action\\App\\Update'
	),
	'/control/profile/update' => array(
		'method' => 'ALL',
		'class' => '\\Eve\\App\\Back\\Action\\Profile\\Update'
	)
);