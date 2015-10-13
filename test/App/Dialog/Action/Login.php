<?php //-->
/*
 * A Custom Library
 *
 * Copyright and license information can be found at LICENSE
 * distributed with this package.
 */
class ApiAppDialogActionLoginTest extends PHPUnit_Framework_TestCase
{
    public function setUp() {
        $callback = include(__DIR__.'/../../../helper/create-session.php');
        $settings = $callback(array(
            'profile_name'    => 'TEST AUTH '.microtime(),//. Date.now(),
            'auth_slug'        => 'TEST AUTH '.microtime(),// . Date.now(),
            'auth_password'    => '123456'
        ));

        // fixture.app                 = results.app;
        // fixture.auth             = results.auth;
        // fixture.profile             = results.profile;
        // fixture.session             = results.session;
        // fixture.profile_name     = results.profile_name;
        // fixture.auth_slug         = results.auth_slug;
        // fixture.auth_password     = results.auth_password;
        eve()->registry()->set('test', 'app', $settings['app']);
        eve()->registry()->set('test', 'auth', $settings['auth']);
        eve()->registry()->set('test', 'profile', $settings['profile']);
        eve()->registry()->set('test', 'profile', $settings['profile']);
        eve()->registry()->set('test', 'session', $settings['session']);

    }
    public function testRender()
    {
        $app = eve()->registry()->get('test', 'app');
        
        $_GET = array(
            'client_id' => $app['app_token'],
            'redirect_uri' => '/control/app/search'
            );

        $results = BrowserTest::i()
            ->setPath('/dialog/action/login')
            ->setGet($_GET)
            ->setQueryString($_GET)
            ->setIsTriggered(true)
            ->process();


        $this->assertTrue($results['triggered']);
    }
}
