<?php //-->
/**
 * A Custom Project
 *
 * Copyright and license information can be found at LICENSE
 * distributed with this package.
 */

namespace Eve\Model\App;

use Eve\Framework\Model\Base;
use Eve\Framework\Model\Argument;
use Eve\Framework\Model\Exception;

/**
 * App Model Refresh
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
 * @vendor   Custom
 * @package  Project
 * @author   Christian Blanquera <cblanquera@openovate.com>
 * @standard PSR-2
 */
class Refresh extends Base
{
    /**
     * Returns errors if any
     *
     * @param array $data   The item before processing
     * @param array $errors Existing errors
     *
     * @return array error
     */
    public function errors(array $data = array(), array $errors = array())
    {
        // app_id - required
        if (!isset($data['app_id'])
        || !$this('validation', $data['app_id'])->isType('int', true)) {
            $errors['app_id'] = self::INVALID_REQUIRED;
        }
        
        return $errors;
    }
    
    /**
     * Processes the form
     *
     * @param array $data The item to process
     *
     * @return mixed
     */
    public function process(array $data = array())
    {
        //prevent uncatchable error
        if (count($this->errors($data))) {
            throw new Exception(self::FAIL_406);
        }
        
        //prepare
        $data = $this->prepare($data);
        
        //generate dates
        $updated = date('Y-m-d H:i:s');
        
        $token = md5(uniqid());
        $secret = md5(uniqid());
        
        //SET WHAT WE KNOW
        $model = eve()
            ->database()
            ->model()
            
            // app_id
            ->setAppId($data['app_id'])
            
            // app_token        Required
            ->setAppToken($token)
            
            // app_secret        Required
            ->setAppSecret($secret)
            
            // app_updated
            ->setAppUpdated($updated);
        
        //what's left ?
        $model->save('app');
        
        eve()->trigger('app-refresh', $model);
        
        return $model;
    }
}
