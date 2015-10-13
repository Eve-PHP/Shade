<?php //-->
/*
 * A Custom Library
 *
 * Copyright and license information can be found at LICENSE
 * distributed with this package.
 */
class ApiAppRestActionAccessTest extends PHPUnit_Framework_TestCase
{
    public function setUp() {
         BrowserTest::i()->setTemplate('rest');
    }
    
    public function testRender()
    {
        $app = eve()->registry()->get('test', 'app');
        $session = eve()->registry()->get('test', 'session');
        
        $_GET = array(
            'access_token' => $app['app_token'],
            'access_secret' => $app['app_secret']
            );

        $_POST = array('code' => $session['session_token']);
        $results = BrowserTest::i()
            ->setPath('/rest/action/access')
            ->setMethod($_GET)
            ->setPost($_POST)
            ->setSource($_GET)
            ->setIsTriggered(false)
            ->process();

        $this->assertContains('"error": false', $results['data']);
    }
}
