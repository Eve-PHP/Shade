<?php //-->
/*
 * A Custom Library
 *
 * Copyright and license information can be found at LICENSE
 * distributed with this package.
 */
class ApiAppBackActionAppRemoveTest extends PHPUnit_Framework_TestCase
{

	public function testValid()
	{
		$data = array(
			'profile_id' => 2
		);

		$variables = array(2);

		$results = BrowserTest::i()
			->setPath('/back/action/app/remove')
			->setPost($data)
			->setVariables($variables)
			->setIsValid(true)
			->setIsTriggered(true)
			->process();

		$this->assertTrue($results['triggered']);
	}
}