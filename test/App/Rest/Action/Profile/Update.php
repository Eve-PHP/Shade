<?php //-->
/*
 * A Custom Library
 *
 * Copyright and license information can be found at LICENSE
 * distributed with this package.
 */
class ApiAppRestActionProfileUpdateTest extends PHPUnit_Framework_TestCase
{
    public function setUp() {
         BrowserTest::i()->setTemplate('rest');
    }
    
    public function testRender()
    {
        $app = eve()->registry()->get('test', 'app');

        $_GET = array(
            'access_token' => $app['app_token'],
            'access_secret' => $app['app_secret']
            );

        $_POST = array('profile_name' => 'Profile updated by REST');
        $source = array('profile_id' => 1);

        $results = BrowserTest::i()
            ->setPath('/rest/action/profile/update')
            ->setPost($_POST)
            ->setSource($source)
            ->setIsTriggered(false)
            ->process();

        $this->assertContains('"error": false', $results['data']);
    }
}