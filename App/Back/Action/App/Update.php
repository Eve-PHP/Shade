<?php //-->
/**
 * A Custom Project
 *
 * Copyright and license information can be found at LICENSE
 * distributed with this package.
 */

namespace Eve\App\Back\Action\App;

use Eve\Framework\Action\Html;

/**
 * App HTML Action Update
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
 *
 * @vendor   Custom
 * @package  Project
 * @author   Christian Blanquera <cblanquera@openovate.com>
 * @standard PSR-2
 */
class Update extends Html
{
    /**
     * @const string FAIL_401 Error template
     */
    const FAIL_401 = 'You do not have permissions to update.';

    /**
     * @const string FAIL_404 Error template
     */
    const FAIL_404 = 'App does not exist';

    /**
     * @const string FAIL_406 Error template
     */
    const FAIL_406 = 'There are some errors on the form.';

    /**
     * @const string SUCCESS_200 Error template
     */
    const SUCCESS_200 = 'App successfully updated!';

    /**
     * @var string $title Page title
     */
    protected $title = 'Update App';
    
    /**
     * Main action call
     *
     * @return string|null|void
     */
    public function render()
    {
        //-----------------------//
        // 1. Get Data
        $data = array();
        
        //get id from the url
        $data['app_id'] = $this->request->get('variables', 0);
        
        //was it not included in the url ?
        if (!isset($data['app_id'])
        && isset($_SESSION['me']['app_id'])) {
            //get it from the session
            $data['app_id'] = $_SESSION['me']['app_id'];
        }
        
        //it's going to fail if we don't have the app_id
        if (!isset($data['app_id'])) {
            //we might as we an fail it now
            return $this->fail(
                self::FAIL_404,
                '/control/app/search'
            );
        }
        
        //if no profile_id
        if (!isset($_SESSION['me']['profile_id'])) {
            //permission check failed
            return $this->fail(
                self::FAIL_401,
                '/control/app/search'
            );
        }
        
        $data['profile_id'] = $_SESSION['me']['profile_id'];
        
        //-----------------------//
        // 2. Validate
        //check permissions
        $yes = eve()
            ->model('app')
            ->permissions(
                $data['app_id'],
                $data['profile_id']
            );

        //if not permitted, fail
        if (!$yes) {
            return $this->fail(
                self::FAIL_401,
                '/control/app/search'
            );
        }
        //does it exist?
        $row = eve()
            ->model('app')
            ->detail()
            ->process($data)
            ->getRow();
        
        if (!$row) {
            return $this->fail(
                self::FAIL_404,
                '/control/app/search'
            );
        }
        
        //-----------------------//
        // 3. Process
        //if it's a post
        if (!empty($_POST)) {
            return $this->check($data);
        }
        
        $this->body['item'] = $row;
        
        //NOTE: add anything extra to body here
        
        //success
        return $this->success();
    }

    /**
     * When the form is submitted
     *
     * @param *array $data Data from the initial page load
     *
     * @return string|null|void
     */
    protected function check($data)
    {
        //-----------------------//
        // 1. Get Data
        $data = array('item' => array_merge($data, $this->request->get('post')));
        
        //merge app_permissions
        if (isset($data['item']['app_permissions'])
            && is_array($data['item']['app_permissions'])
        ) {
            $data['item']['app_permissions'] = implode(',', $data['item']['app_permissions']);
        }
        
        //-----------------------//
        //2. Validate
        $errors = eve()
            ->model('app')
            ->update()
            ->errors($data['item']);
        
        //if there are errors
        if (!empty($errors)) {
            return $this->fail(
                self::FAIL_406,
                $errors,
                $data['item']
            );
        }
        
        //-----------------------//
        //3. Process
        try {
            $results = eve()
                ->job('app-update')
                ->setData($data['item'])
                ->run();
        } catch (\Exception $e) {
            return $this->fail(
                $e->getMessage(),
                array(),
                $data['item']
            );
        }
        
        //NOTE: do something with results here
        
        return $this->success(
            self::SUCCESS_200,
            '/control/app/search'
        );
    }
}
