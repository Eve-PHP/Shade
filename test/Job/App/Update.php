<?php //-->
/*
 * A Custom Library
 *
 * Copyright and license information can be found at LICENSE
 * distributed with this package.
 */
class Eve_Job_App_Update_Test extends PHPUnit_Framework_TestCase
{
    public function testRun()
    {
        $thrown = false;
        try {
            eve()
                ->job('app-update')
                ->run();
        } catch(Exception $e) {
            $this->assertInstanceOf('Eve\\Framework\\Job\\Exception', $e);
            $thrown = true;
        }
        
        $this->assertTrue($thrown);
        
        $app = eve()->registry()->get('test', 'app');
        
        $results = eve()
            ->job('app-update')
            ->setData(array(
                'app_id' => $app['app_id'],
                'app_name' => 'Test Job App Update',
                'app_domain' => '*.test.com',
                'app_permissions' => 'public_sso,user_profile,global_profile', 
            ))
            ->run();
        
        $this->assertTrue(is_numeric($results['app']['app_id']));
        $this->assertEquals('Test Job App Update', $results['app']['app_name']);
    }
}