<?php //-->
/*
 * A Custom Library
 *
 * Copyright and license information can be found at LICENSE
 * distributed with this package.
 */
class Eve_Model_Auth_Update_Test extends PHPUnit_Framework_TestCase
{
	public function testErrors() 
	{
        $errors = eve()->model('auth')->update()->errors();
		$this->assertEquals('Cannot be empty', $errors['auth_id']);
    }
	
    public function testProcess() 
	{
		$now = explode(" ", microtime());

		$auth = eve()->registry()->get('test', 'auth');
		
        $model = eve()->model('auth')->update()->process(array(
			'auth_id' => $auth['auth_id'],
			'auth_slug' => 'TEST AUTH ' + $now[1],
			'auth_permissions' => 'test_permissions_1,test_permissions_2',
			'auth_password'	=> '123456',
			'confirm' => '123456' ));

		$this->assertEquals('test_permissions_1,test_permissions_2', $model['auth_permissions']);
    }
}