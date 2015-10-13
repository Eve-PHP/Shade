<?php //-->
/*
 * A Custom Library
 *
 * Copyright and license information can be found at LICENSE
 * distributed with this package.
 */
class Eve_Model_Profile_Create_Test extends PHPUnit_Framework_TestCase
{
    public function testErrors() 
    {
        $errors = eve()->model('profile')->create()->errors();
        
        $this->assertEquals('Cannot be empty', $errors['profile_name']);
    }
    
    public function testProcess() 
    {
        $model = eve()
            ->model('profile')
            ->create()
            ->process(array(
                'profile_name' => '123'));

        eve()->registry()->set('test', 'profile', $model->get());
        $this->assertTrue(is_numeric($model['profile_id']));
    }
}