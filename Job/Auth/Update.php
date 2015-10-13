<?php //-->
/**
 * A Custom Project
 *
 * Copyright and license information can be found at LICENSE
 * distributed with this package.
 */

namespace Eve\Job\Auth;

use Eve\Framework\Job\Base;
use Eve\Framework\Job\Argument;
use Eve\Framework\Job\Exception;

/**
 * Auth Job Update
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
class Update extends Base
{
    const FAIL_406 = 'Invalid Data';
    
    /**
     * Executes the job
     *
     * @return void
     */
    public function run()
    {
        //if no data
        if (empty($this->data)) {
            //there should be a global catch somewhere
            throw new Exception(self::FAIL_406);
        }
        
        //this will be returned at the end
        $results = array();
        
        //update profile
        $results['profile'] = eve()
            ->model('profile')
            ->update()
            ->process($this->data);
        
        //update auth
        $results['auth'] = eve()
            ->model('auth')
            ->update()
            ->process($this->data);
        
        return $results;
    }
}
