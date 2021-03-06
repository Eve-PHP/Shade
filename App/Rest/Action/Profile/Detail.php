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
 * Profile REST Action Detail
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
class Detail extends Json
{
    const FAIL_404 = 'Not Found';

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
        $data['profile_id'] = $this->request->get('variables', 0);
        
        //was it not included in the url ?
        if (!$data['profile_id']
        && $this->request->isKey('source', 'profile_id')) {
            //get it from the source
            $data['profile_id'] = $this->request->get('source', 'profile_id');
        }
        
        //it's going to fail if we don't have the profile_id
        if (!$data['profile_id']) {
            //we might as we an fail it now
            return $this->fail(self::FAIL_404);
        }
        
        //-----------------------//
        // 2. Validate
        //does it exist?
        $row = eve()
            ->model('profile')
            ->detail()
            ->process($data)
            ->getRow();
        
        if (!$row) {
            return $this->fail(
                self::FAIL_404,
                '/profile/search'
            );
        }

        //-----------------------//
        // 3. Process
        
        //NOTE: add anything extra to row here
        
        //success
        return $this->success($row);
    }
}
