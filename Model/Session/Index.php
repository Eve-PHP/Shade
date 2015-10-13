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
 * Session Model Index
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
class Index extends Base
{
    /**
     * Factory for access
     *
     * @return Eve\Model\Session\Access
     */
    public function access()
    {
        return Access::i();
    }
    
    /**
     * Get profile by access token
     * Random function needed...
     *
     * @param *string $token App client token
     *
     * @return array
     */
    public function getProfileByToken($token)
    {
        return eve()
            ->database()
            ->search('session')
            ->setColumns('profile.*')
            ->innerJoinOn(
                'session_auth',
                'session_auth_session = session_id'
            )
            ->innerJoinOn(
                'auth_profile',
                'auth_profile_auth = session_auth_auth'
            )
            ->innerJoinOn(
                'profile',
                'auth_profile_profile = profile_id'
            )
            ->filterBySessionToken($token)
            ->getRow();
    }
    
    /**
     * Get profile by access token
     * Random function needed...
     *
     * @param *string $token App client token
     *
     * @return array
     */
    public function getAppByToken($token)
    {
        return eve()
            ->database()
            ->search('session')
            ->setColumns('app.*')
            ->innerJoinOn(
                'session_app',
                'session_app_session = session_id'
            )
            ->innerJoinOn(
                'app',
                'session_app_app = app_id'
            )
            ->filterBySessionToken($token)
            ->getRow();
    }
    
    /**
     * Factory for login
     *
     * @return Eve\Model\Session\Login
     */
    public function login()
    {
        return Login::i();
    }
    
    /**
     * Factory for logout
     *
     * @return Eve\Model\Session\Logout
     */
    public function logout()
    {
        return Logout::i();
    }
    
    /**
     * Factory for request
     *
     * @return Eve\Model\Session\Request
     */
    public function request()
    {
        return Request::i();
    }
}
