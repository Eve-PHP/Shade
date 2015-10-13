<?php //-->
/*
 * A Custom Library
 *
 * Copyright and license information can be found at LICENSE
 * distributed with this package.
 */
class ApiAppDialogActionRequestTest extends PHPUnit_Framework_TestCase
{
    public function testRender()
    {
        $app = eve()->registry()->get('test', 'app');

        $_GET = array(
            'client_id' => $app['app_token'],
            'redirect_uri' => '/control/app/search'
            );

        $results = BrowserTest::i()
            ->setPath('/dialog/action/request')
            ->setGet($_GET)
            ->setSource($app)
            ->setQueryString($_GET)
            ->setIsTriggered(false)
            ->process();

        $this->assertContains('would like permissions to access your data', $results['data']);
    }

    public function testValid() 
    {
        $app = eve()->registry()->get('test', 'app');
        $auth = eve()->registry()->get('test', 'auth');

        $_GET = array(
            'client_id' => $app['app_token'],
            'redirect_uri' => '/control/app/search'
            );

        $config = eve()->settings('test');

        $_POST = array(
            'session_permissions' => $config['scope'],
            'action' => 'allow'
            );
        
        $results = BrowserTest::i()
            ->setPath('/dialog/action/request')
            ->setGet($_GET)
            ->setPost($_POST)
            ->setSource($app)
            ->setQueryString($_GET)
            ->setIsTriggered(true)
            ->process();

        $this->assertTrue($results['triggered']);

        $session = eve()
            ->model('session')
            ->request()
            ->process(array(
                'app_id' => $app['app_id'],
                'auth_id' => $_SESSION['me']['auth_id'],
                'session_permissions' => implode(',', $config['scope'])
        ));

        eve()->registry()->set('test', 'session', $session);
    }
}
