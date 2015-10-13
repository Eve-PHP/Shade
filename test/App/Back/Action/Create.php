<?php //-->
/*
 * A Custom Library
 *
 * Copyright and license information can be found at LICENSE
 * distributed with this package.
 */
class ApiAppBackActionCreateTest extends PHPUnit_Framework_TestCase
{
    public function setUp() {
         BrowserTest::i()->setTemplate('back');
    }
    
    public function testRender()
    {
        $results = BrowserTest::i()
            ->setPath('/back/action/create')
            ->setMethod('GET')
            ->setIsTriggered(false)
            ->process();

        $this->assertContains('Developer Sign Up', $results['data']);
    }
    
    public function testInvalid()
    {
        $data = array(
            'profile_name' => 'Test Action Create',
            'profile_email' => 'test321@test.com',
            'auth_password' => '123'
        );

        $results = BrowserTest::i()
            ->setPath('/back/action/create')
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
            'profile_name' => 'Test Action Create',
            'profile_email' => 'test321@test.com',
            'auth_password' => '123',
            'confirm'        => '123'
        );

        $results = BrowserTest::i()
            ->setPath('/back/action/create')
            ->setPost($data)
            ->setIsValid(true)
            ->setIsTriggered(true)
            ->process();

        $this->assertTrue($results['triggered']);
    }
}