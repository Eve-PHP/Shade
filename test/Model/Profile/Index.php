<?php //-->
/*
 * A Custom Library
 *
 * Copyright and license information can be found at LICENSE
 * distributed with this package.
 */
class Eve_Model_Profile_Index_Test extends PHPUnit_Framework_TestCase
{
	
	public function testCreate()
	{
		$class = eve()->model('profile')->create();
		$this->assertInstanceOf('Eve\\Model\\Profile\\Create', $class);
	}
	
	public function testDetail()
	{
		$class = eve()->model('profile')->detail();
		$this->assertInstanceOf('Eve\\Model\\Profile\\Detail', $class);
	}
	
	public function testSet()
	{
		$class = eve()->model('profile')->set();
		$this->assertInstanceOf('Eve\\Model\\Profile\\Set', $class);
	}
	
	public function testRemove()
	{
		$class = eve()->model('profile')->remove();
		$this->assertInstanceOf('Eve\\Model\\Profile\\Remove', $class);
	}
	
	public function testRestore()
	{
		$class = eve()->model('profile')->restore();
		$this->assertInstanceOf('Eve\\Model\\Profile\\Restore', $class);
	}
	
	public function testSearch()
	{
		$class = eve()->model('profile')->search();
		$this->assertInstanceOf('Eve\\Model\\Profile\\Search', $class);
	}
	
	public function testUpdate()
	{
		$class = eve()->model('profile')->update();
		$this->assertInstanceOf('Eve\\Model\\Profile\\Update', $class);
	}
}