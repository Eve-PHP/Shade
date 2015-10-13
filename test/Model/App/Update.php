<?php //-->
/*
 * A Custom Library
 *
 * Copyright and license information can be found at LICENSE
 * distributed with this package.
 */
class Eve_Model_App_Update_Test extends PHPUnit_Framework_TestCase
{
    public function testErrors() 
    {
        $errors = eve()->model('app')->update()->errors();
        $this->assertEquals('Cannot be empty', $errors['app_id']);
    }
    
    public function testProcess() 
    {
        $app = eve()->registry()->get('test', 'app');
        
        $model = eve()
            ->model('app')
            ->update()
            ->process(array(
                'app_id' => $app['app_id'],
                'app_name' => 'Test App Updated',
                'app_permissions'    => 'test_permissions_1,test_permissions_2',
                'app_domain'        => '*.test.com' 
                ));

        $this->assertEquals('Test App Updated', $model['app_name']);
    }
}