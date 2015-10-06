<?php //-->
/*
 * A Custom Library
 *
 * Copyright and license information can be found at LICENSE
 * distributed with this package.
 */
class ApiAppRestActionProfileDetailTest extends PHPUnit_Framework_TestCase
{
	public function setUp() {
		 BrowserTest::i()->setTemplate('rest');
	}
	
	public function testRender()
	{
		$app = eve()->registry()->get('test', 'app');

		$_GET = array('access_token' => $app['app_token']);
		$source = array('profile_id' => $_SESSION['me']['profile_id']);
		
		$results = BrowserTest::i()
			->setPath('/rest/action/profile/detail')
			->setGet($_GET)
			->setSource($source)
			->setIsTriggered(false)
			->process();

		$this->assertContains('"error": false', $results['data']);
	}
}