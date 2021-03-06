<?php //-->
/**
 * A Custom Project
 *
 * Copyright and license information can be found at LICENSE
 * distributed with this package.
 */

namespace Eve\App\Rest\Action\Profile;

use Eve\Framework\Action\Json;

/**
 * Profile REST Action Update
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
 *    -- $this->request->get('source') - Information gathered
 *       from the tokens like profile, app etc.. This information
 *       was provided by the Validator plugin
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
class Update extends Json
{
    /**
     * @const string FAIL_401 Error template
     */
    const FAIL_401 = 'Invalid Permissions';

    /**
     * @const string FAIL_404 Error template
     */
    const FAIL_404 = 'Not Found';

    /**
     * @const string FAIL_406 Error template
     */
    const FAIL_406 = 'Invalid Data';

    /**
     * Main action call
     *
     * @return string|null|void
     */
    public function render()
    {
        //-----------------------//
        // 1. Get Data
        $data = $this->request->get('post');
        
        //was the id not included in the post?
        if (!isset($data['profile_id'])
        && $this->request->isKey('variables', 0)) {
            //get it from the url
            $data['profile_id'] = $this->request->get('variables', 0);
        }
        
        //was it not included in the url ?
        if (!isset($data['profile_id'])
        && $this->request->isKey('source', 'profile_id')) {
            //get it from the source
            $data['profile_id'] = $this->request->get('source', 'profile_id');
        }
        
        //it's going to fail if we don't have the profile_id
        if (!isset($data['profile_id'])) {
            //we might as we an fail it now
            return $this->fail(self::FAIL_404);
        }
        
        
        //-----------------------//
        // 2. Validate
        //check fields
        $errors = eve()
            ->model('profile')
            ->update()
            ->errors($data);
        
        //if there are errors
        if (!empty($errors)) {
            return $this->fail(
                self::FAIL_406,
                $errors
            );
        }
        

        //does it exist?
        $total = eve()
            ->model('profile')
            ->detail()
            ->process($data)
            ->getTotal();
        
        if (!$total) {
            return $this->fail(self::FAIL_404);
        }
        
        //-----------------------//
        // 3. Process
        try {
            $results = eve()
                ->job('profile-update')
                ->setData($data)
                ->run();
        } catch (\Exception $e) {
            return $this->fail($e->getMessage());
        }
       
        return $this->success($results);
    }
}
