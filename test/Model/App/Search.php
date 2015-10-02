<?php //-->
/*
 * A Custom Library
 *
 * Copyright and license information can be found at LICENSE
 * distributed with this package.
 */
class Eve_Model_App_Search_Test extends PHPUnit_Framework_TestCase
{
    public function testErrors() 
	{
        $errors = eve()
			->model('app')
			->search()
			->errors();
			
		$this->assertCount(0, $errors);
    }
	
    public function testProcess() 
	{
        $rows = eve()
        	->model('app')
        	->search()
        	->process()
        	->getRows();
            
		foreach ($rows as $row) {
			$this->assertEquals(1, $row['app_active']);
		}
    }
}