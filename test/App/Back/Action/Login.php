<?php //-->
/*
 * A Custom Library
 *
 * Copyright and license information can be found at LICENSE
 * distributed with this package.
 */
class ApiAppBackActionLoginTest extends PHPUnit_Framework_TestCase
{
    public function testRender()
	{
		$results = BrowserTest::i()->setPath('/back/action/login')
			->setMethod('GET')
			->setIsTriggered(false)
			->process();

		$this->assertContains('Developer Login', $results['data']);
	}

	public function testInvalid()
	{
		$data = array(
			'profile_email' => 'test321@test.com',
		);

		$results = BrowserTest::i()->setPath('/back/action/login')
			->setPost($data)
			->setIsValid(false)
			->setIsTriggered(true)
			->process();

		$this->assertFalse($results['triggered']);
		$this->assertContains('Cannot be empty', $results['data']);
	}
	
	public function testValid()
	{
		$data = array(
			'auth_slug' => 'admin@openovate.com',
			'auth_password' => 'admin'
		);

		$results = BrowserTest::i()->setPath('/back/action/login')
			->setPost($data)
			->setIsValid(true)
			->setIsTriggered(true)
			->process();

		$this->assertTrue($results['triggered']);
	}
}