<?php //-->
/*
 * A Custom Library
 *
 * Copyright and license information can be found at LICENSE
 * distributed with this package.
 */
class ApiAppBackActionAppUpdateTest extends PHPUnit_Framework_TestCase
{
    public function testRender()
    {
        $app = eve()->registry()->get('test', 'app');
        $variables = array($app['app_id']);

        $results = BrowserTest::i()
            ->setPath('/back/action/app/update')
            ->setMethod('GET')
            ->setVariables($variables)
            ->setIsTriggered(false)
            ->process();

        $this->assertContains('Update App', $results['data']);
    }
    
    public function testInvalid()
    {
        $data = array(
            'app_id' => '',
            'app_name' => 'Test Action App Updated',
            'app_permissions' => 'public_sso,user_profile,global_profile',
        );

        $app = eve()->registry()->get('test', 'app');
        $variables = array($app['app_id']);
        
        $results = BrowserTest::i()
            ->setPath('/back/action/app/update')
            ->setPost($data)
            ->setVariables($variables)
            ->setIsValid(false)
            ->setIsTriggered(true)
            ->process();
        
        $this->assertFalse($results['triggered']);
        $this->assertContains('Cannot be empty', $results['data']);
    }
    
    public function testValid()
    {
        $data = array(
            'app_name' => 'Test Action App Updated',
            'app_domain' => '*.test.com',
            'app_permissions' => 'public_sso,user_profile,global_profile', 
            'profile_id' => $_SESSION['me']['profile_id']
        );

        $app = eve()->registry()->get('test', 'app');
        $variables = array($app['app_id']);

        $results = BrowserTest::i()
            ->setPath('/back/action/app/update')
            ->setPost($data)
            ->setVariables($variables)
            ->setIsValid(true)
            ->setIsTriggered(true)
            ->process();

        $this->assertTrue($results['triggered']);
    }
}