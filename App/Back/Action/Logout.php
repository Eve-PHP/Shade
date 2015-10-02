<?php //-->
/*
 * A Custom Library
 *
 * Copyright and license information can be found at LICENSE
 * distributed with this package.
 */
namespace Eve\App\Back\Action;

use Eve\Framework\Action\Json;
use Eve\Framework\Action\Html;

/**
 * Action
 *
 * GUIDE:
 * -- eve() - The current server controller
 *    use this to access the rest of the framework
 *
 *    -- eve()->database() - Returns the current database
 *
 *    -- eve()->model('noun') - Returns the given model factory
 *
 *    -- eve()->job('noun-action') - Returns a job following noun/action
 *
 *    -- eve()->settings('foo') - Returns a settings data originating
 *    from the settings path. ie. settings/foo.php
 *
 *    -- eve()->registry() - Returns Eden\Registry\Index used globally
 *
 * -- $this->request - The Request Object using Eden\Registry\Index
 *
 *    -- $this->request->get('post') - $_POST data
 *       You are free to use the $_POST variable if you like
 *
 *    -- $this->request->get('get') - $_GET data
 *       You are free to use the $_GET variable if you like
 *
 *    -- $this->request->get('server') - $_SERVER data
 *       You are free to use the $_SERVER variable if you like
 *
 *    -- $this->request->get('body') - raw body for 
 *       POST requests that provide JSON data for example
 *       instead of the default x-form-data
 *
 *    -- $this->request->get('method') - GET, POST, PUT or DELETE
 *
 * -- $this->response - The Response Object using Eden\Registry\Index
 *
 *    -- $this->response->set('body', 'Foo') - Sets the response body.
 *       Alternative for returning a string in render()
 *
 *    -- $this->response->set('headers', 'Foo', 'Bar') - Sets a 
 *       header item to 'Foo: Bar' given key/value
 *
 *    -- $this->response->set('headers', 'Foo', '') - Sets a 
 *       header item to 'Foo' given that no value is present
 *       QUIRK: $this->response->set('headers', 'Foo') will erase
 *       all existing headers
 */
class Logout extends Html 
{
    const SUCCESS_200 = 'You are now Logged Out!';
    
    public function render() 
    {
        if(!isset($_SESSION['me'])) {
            return $this->success(
                self::SUCCESS_200, 
                '/control/login');
        }
        
        $data = array('auth_id' => $_SESSION['me']['auth_id']);

        $errors = eve()
            ->model('session')
            ->logout()
            ->errors($data);
        
        if(isset($errors['auth_id'])) {
            return $this->fail($errors['auth_id'], '/control/app/search');
        }
        
        eve()
            ->model('session')
            ->logout()
            ->process($data);
        
        unset($_SESSION['me']);
        
        return $this->success(self::SUCCESS_200, '/control/login');
    }
}