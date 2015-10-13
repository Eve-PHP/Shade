<?php //-->
/*
 * This file is part of the Persistent package of the Eden PHP Library.
 * (c) 2013-2014 Openovate Labs
 *
 * Copyright and license information can be found at LICENSE
 * distributed with this package.
 */
namespace Eve\App\Back;

use Eve\Framework\Exception;
use Eve\Framework\Argument;
use Eve\Framework\Base;

use Eve\App\Dialog\Action\Invalid;

/**
 * Validates dialog requests
 *
 * @vendor   Custom
 * @package  Project
 * @author   Christian Blanquera <cblanquera@openovate.com>
 * @standard PSR-2
 */
class Route extends Base
{
    /**
     * @const int INSTANCE Flag that designates singleton when using ::i()
     */
    const INSTANCE = 1;
    
    /**
     * @var array $routes List of route patterns
     */
    public $routes = array();
    
    /**
     * Include routes
     *
     * @return void
     */
    public function __construct()
    {
        $this->routes = include 'routes.php';
    }
    
    /**
     * Main route method
     *
     * @return function
     */
    public function import()
    {
        //remember this scope
        $self = $this;
        
        //loop through routes
        foreach ($self->routes as $route => $meta) {
            //form the callback
            $callback = function ($request, $response) use ($self, $route, $meta) {
                
                $path = $request->get('path', 'string');
                
                $variables = $self->getVariables($route, $path);
                
                //set the route
                $request->set('route', $route);
                
                //set variables
                $request->set('variables', $variables);
                
                //set the action
                $response->set('action', $meta['class']);
                
                //set paths
                eve()->registry()->set('path', 'action', __DIR__.'/Action');
                eve()->registry()->set('path', 'template', __DIR__.'/template');
                
                $action = $meta['class'];
                
                //it's a class
                $instance = new $action();
                
                //call it
                $results = $instance
                    ->setRequest($request)
                    ->setResponse($response)
                    ->render();
                
                //if there are results
                //and no body was set
                if ($results
                && is_scalar($results)
                && !$response->isKey('body')) {
                    $response->set('body', (string) $results);
                }
                
                //prevent something else from taking over
                if ($response->isKey('body')) {
                    return false;
                }
            };
            
            //add route
            eve()->route($meta['method'], $route, $callback);
        }
        
        //You can add validators here
        return function ($request, $response) use ($self) {
            $path = $request->get('path', 'string');
            if (strpos($path, '/control') === 0
                && !in_array($path, array(
                    '/control/login',
                    '/control/create'
                )) && !isset($_SESSION['me'])
            ) {
                eve()->redirect('/control/login');
            }
        };
    }
    
    /**
     * Returns a dynamic list of variables
     * based on the given pattern and path
     *
     * @param string $route The route pattern
     * @param string $path  The URL path to test against
     *
     * @return array
     */
    public function getVariables($route, $path)
    {
        $variables = array();
        
        $regex = str_replace('**', '!!', $route);
        $regex = str_replace('*', '([^/]*)', $regex);
        $regex = str_replace('!!', '(.*)', $regex);
        
        $regex = '#^'.$regex.'(.*)#';
        
        if (!preg_match($regex, $path, $matches)) {
            return $variables;
        }
        
        if (!is_array($matches)) {
            return $variables;
        }
        
        array_shift($matches);
        
        foreach ($matches as $path) {
            $variables = array_merge($variables, explode('/', $path));
        }
        
        foreach ($variables as $i => $variable) {
            if (!$variable) {
                unset($variables[$i]);
            }
        }
        
        return array_values($variables);
    }
}
