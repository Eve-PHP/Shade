<?php //-->
/**
 * A Custom Project
 *
 * Copyright and license information can be found at LICENSE
 * distributed with this package.
 */

namespace Eve\Model\Session;

use Eve\Framework\Model\Base;
use Eve\Framework\Model\Argument;
use Eve\Framework\Model\Exception;

/**
 * Session Model Login
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
class Login extends Base
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
        //prepare
        $data = $this->prepare($data);
        
        //REQUIRED

        if (!isset($data['auth_slug']) || empty($data['auth_slug'])) {
            $errors['auth_slug'] = self::INVALID_REQUIRED;
        }
        
        if (!isset($data['auth_password']) || empty($data['auth_password'])) {
            $errors['auth_password'] = self::INVALID_REQUIRED;
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
        
        $search = eve()
            ->database()
            ->search('auth')
            ->setColumns('profile.*', 'auth.*')
            ->innerJoinOn('auth_profile', 'auth_profile_auth = auth_id')
            ->innerJoinOn('profile', 'auth_profile_profile = profile_id')
            ->filterByAuthSlug($data['auth_slug'])
            ->filterByAuthPassword(md5($data['auth_password']));
        

        $row = $search->getRow();
        
        eve()->trigger('session-login', $row);

        return $row;
    }
}
