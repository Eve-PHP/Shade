<?php //-->
/*
 * A Custom Library
 *
 * Copyright and license information can be found at LICENSE
 * distributed with this package.
 */
class ApiAppRestActionProfileSearchTest extends PHPUnit_Framework_TestCase
{
	public function setUp() {
		 BrowserTest::i()->setTemplate('rest');
	}
	
	public function testRender()
	{
		$app = eve()->registry()->get('test', 'app');

		$_GET = array('access_token' => $app['app_token']);
		
		$results = BrowserTest::i()
			->setPath('/rest/action/profile/search')
			->setGet($_GET)
			->setSource($_GET)
			->setIsTriggered(false)
			->process();

		$this->assertContains('"error": false', $results['data']);
	}
}