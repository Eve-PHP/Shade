<?php //-->
/*
 * A Custom Library
 *
 * Copyright and license information can be found at LICENSE
 * distributed with this package.
 */
class Eve_Model_Session_Index_Test extends PHPUnit_Framework_TestCase
{
    
    public function testAccess()
    {
        $class = eve()->model('session')->access();
        $this->assertInstanceOf('Eve\\Model\\Session\\Access', $class);
    }
    
    public function testLogin()
    {
        $class = eve()->model('session')->login();
        $this->assertInstanceOf('Eve\\Model\\Session\\Login', $class);
    }
    
    public function testLogout()
    {
        $class = eve()->model('session')->logout();
        $this->assertInstanceOf('Eve\\Model\\Session\\Logout', $class);
    }
    
    public function testRequest()
    {
        $class = eve()->model('session')->request();
        $this->assertInstanceOf('Eve\\Model\\Session\\Request', $class);
    }
    
    public function testGetProfileByToken() 
    {
        $session = eve()->registry()->get('test', 'session');
        $profile = eve()->registry()->get('test', 'profile');

        $row = eve()
            ->model('session')
            ->getProfileByToken($session['access_token']);
            
        $this->assertEquals($profile['profile_name'], $row['profile_name']);
    }
    
    public function testGetAppByToken() 
    {
        $session = eve()->registry()->get('test', 'session');
        $app = eve()->registry()->get('test', 'app');

        $row = eve()
            ->model('session')
            ->getAppByToken($session['access_token']);
            
        $this->assertEquals($app['app_id'], $row['app_id']);
    }
}