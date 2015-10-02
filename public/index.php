<?php //-->
/*
 * This file is part a custom application package.
 * (c) 2011-2012 Openovate Labs
 */

require_once realpath(__DIR__ . '/../vendor').'/autoload.php';

Eve\Framework\Index::i(dirname(__DIR__), 'Eve')
//Add any middleware here

//HTPASSWD
//->add(Eden\Middleware\Htpasswd\Plugin::i()->import(array('admin' => 'admin')))

//Rest Route
->add(Eve\App\Rest\Route::i()->import())

//Dialog Route
->add(Eve\App\Dialog\Route::i()->import())

//Control Route
->add(Eve\App\Back\Route::i()->import())

//WWW Route
->add(Eve\App\Front\Route::i()->import())

//and this is the default
->defaultBootstrap();