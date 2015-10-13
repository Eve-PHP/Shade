<?php //-->
/*
 * A Custom Library
 *
 * Copyright and license information can be found at LICENSE
 * distributed with this package.
 */
class ApiAppDialogActionUpdateTest extends PHPUnit_Framework_TestCase
{
    public function testRender()
    {

        $app = eve()->registry()->get('test', 'app');

        $_GET = array(
            'client_id' => $app['app_token'],
            'redirect_uri' => '/control/app/search'
            );

        $results = BrowserTest::i()->setPath('/dialog/action/update')
            ->setGet($_GET)
            ->setSource($app)
            ->setQueryString($_GET)
            ->setIsTriggered(false)
            ->process();

        $this->assertContains('Update Account', $results['data']);
    }
    
    public function testInvalid()
    {
        $app = eve()->registry()->get('test', 'app');

        $_GET = array(
            'client_id' => $app['app_token'],
            'redirect_uri' => '/control/app/search',
        );

        $_POST = array(
            'profile_name'     => 'Test Dialog Action Create',
            'profile_email' => 'testdialog2@test.com',
            'auth_password' => '123',
        );

        $app = eve()->registry()->get('test', 'app');

        $results = BrowserTest::i()->setPath('/dialog/action/update')
            ->setGet($_GET)
            ->setPost($_POST)
            ->setSource($app)
            ->setQueryString($_POST)
            ->setIsValid(false)
            ->setIsTriggered(true)
            ->process();

        $this->assertFalse($results['triggered']);
        $this->assertContains('Passwords do not match!', $results['data']);
    }

    public function testValid()
    {
        $app = eve()->registry()->get('test', 'app');

        $_GET = array(
            'client_id' => $app['app_token'],
            'redirect_uri' => '/control/app/search',
        );

        $_POST = array(
            'profile_name'     => 'Test Dialog Action Create',
            'profile_email' => 'testdialog2@test.com',
            'auth_permissions'     => 'user_profile,personal_profile,global_profile',
            'auth_password' => '123',
            'confirm'        => '123'
        );

        $app = eve()->registry()->get('test', 'app');

        $results = BrowserTest::i()->setPath('/dialog/action/update')
            ->setGet($_GET)
            ->setPost($_POST)
            ->setSource($app)
            ->setQueryString($_POST)
            ->setIsValid(true)
            ->setIsTriggered(true)
            ->process();

        $this->assertTrue($results['triggered']);
    }
}
