<?php //-->
return array(
	'/rest/profile/search' => array(
		'method' => 'GET',
		'role' => 'public_profile',
		'class' => '\\Eve\\App\\Rest\\Action\\Profile\\Search'
	),
	'/rest/profile/detail/*' => array(
		'method' => 'GET',
		'role' => 'public_profile',
		'class' => '\\Eve\\App\\Rest\\Action\\Profile\\Detail'
	),
	'/rest/access' => array(
		'method' => 'POST',
		'role' => 'public_sso',
		'class' => '\\Eve\\App\\Rest\\Action\\Access'
	),
	'/rest/user/profile/detail' => array(
		'method' => 'GET',
		'role' => 'user_profile',
		'class' => '\\Eve\\App\\Rest\\Action\\Profile\\Detail'
	),
	'/rest/user/profile/update' => array(
		'method' => 'POST',
		'role' => 'user_profile',
		'class' => '\\Eve\\App\\Rest\\Action\\Profile\\Update'
	),
	'/rest/profile/detail' => array(
		'method' => 'GET',
		'role' => 'personal_profile',
		'class' => '\\Eve\\App\\Rest\\Action\\Profile\\Detail'
	),
	'/rest/profile/update' => array(
		'method' => 'POST',
		'role' => 'personal_profile',
		'class' => '\\Eve\\App\\Rest\\Action\\Profile\\Update'
	)
);