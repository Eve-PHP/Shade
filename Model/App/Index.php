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
 * App Model Factory
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
     * Factory for create
     *
     * @return Eve\Model\App\Create
     */
    public function create()
    {
        return Create::i();
    }
    
    /**
     * Factory for detail
     *
     * @return Eve\Model\App\Detail
     */
    public function detail()
    {
        return Detail::i();
    }
    
    /**
     * Get profile by app access token
     * Random function needed...
     *
     * @param *string $token App client token
     *
     * @return array
     */
    public function getProfileByToken($token)
    {
        //argument test
        Argument::i()->test(1, 'string');
        
        return eve()
            ->database()
            ->search('app')
            ->setColumns(
                'profile.*',
                'app.*'
            )
            ->innerJoinOn(
                'app_profile',
                'app_profile_app = app_id'
            )
            ->innerJoinOn(
                'profile',
                'app_profile_profile = profile_id'
            )
            ->filterByAppToken($token)
            ->getRow();
    }
    
    /**
     * Link app to profile
     *
     * @param *int $addId     app id
     * @param *int $profileId profile id
     * @return Eden\Mysql\Model
     */
    public function linkProfile($appId, $profileId)
    {
        //argument test
        Argument::i()->test(1, 'int')->test(2, 'int');
        
        $model = eve()
            ->database()
            ->model()
            ->setAppProfileApp($appId)
            ->setAppProfileProfile($profileId)
            ->insert('app_profile');
        
        eve()->trigger('app-link-profile', $model);
        
        return $model;
    }
    
    
    /**
     * Check for app permissions
     *
     * @param *int $addId     app id
     * @param *int $profileId profile id
     *
     * @return bool
     */
    public function permissions($appId, $profileId)
    {
        //argument test
        Argument::i()->test(1, 'int')->test(2, 'int');
        
        $row = eve()
            ->database()
            ->search('app_profile')
            ->filterByAppProfileApp($appId)
            ->filterByAppProfileProfile($profileId)
            ->getRow();
        
        if (!$row) {
            return false;
        }
        
        return true;
    }
    
    /**
     * Factory for search
     *
     * @return Eve\Model\App\Search
     */
    public function search()
    {
        return Search::i();
    }
    
    /**
     * Factory for refresh
     *
     * @return Eve\Model\App\Refresh
     */
    public function refresh()
    {
        return Refresh::i();
    }
    
    /**
     * Factory for remove
     *
     * @return Eve\Model\App\Remove
     */
    public function remove()
    {
        return Remove::i();
    }
    
    /**
     * Factory for restore
     *
     * @return Eve\Model\App\Restore
     */
    public function restore()
    {
        return Restore::i();
    }
    
    /**
     * Unlink app to profile
     *
     * @param *int $addId     app id
     * @param *int $profileId profile id
     *
     * @return Eden\Mysql\Model
     */
    public function unlinkProfile($appId, $profileId)
    {
        //argument test
        Argument::i()->test(1, 'int')->test(2, 'int');
        
        $model = eve()
            ->database()
            ->model()
            ->setAppProfileApp($appId)
            ->setAppProfileProfile($profileId)
            ->remove('app_profile');
        
        eve()->trigger('app-unlink-profile', $model);
        
        return $model;
    }
    
    /**
     * Factory for update
     *
     * @return Eve\Model\App\Update
     */
    public function update()
    {
        return Update::i();
    }
}
