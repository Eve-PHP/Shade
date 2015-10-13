<?php //-->
/*
 * A Custom Library
 *
 * Copyright and license information can be found at LICENSE
 * distributed with this package.
 */
class ApiAppBackActionProfileUpdateTest extends PHPUnit_Framework_TestCase
{
    public function testRender()
    {
        $variables = array($_SESSION['me']['profile_id']);
        $results = BrowserTest::i()
            ->setPath('/back/action/profile/update')
            ->setMethod('GET')
            ->setVariables($variables)
            ->setIsTriggered(false)
            ->process();
            
        $this->assertContains('Update Profile', $results['data']);
    }

    public function testInvalid()
    {
        $data = array(
            'profile_id'    => $_SESSION['me']['profile_id'],
        );

        $variables = array($_SESSION['me']['profile_id']);

        $results = BrowserTest::i()
            ->setPath('/back/action/profile/update')
            ->setPost($data)
            ->setVariables($variables)
            ->setIsValid(false)
            ->setIsTriggered(true)
            ->process();

        $this->assertFalse($results['triggered']);
        $this->assertContains('Cannot be empty', $results['data']);
    }

    public function testValid()
    {
        $data = array(
            'profile_id'    => $_SESSION['me']['profile_id'],
            'profile_name'    => 'Test Action Profile Update last'
        );

        $variables = array($_SESSION['me']['profile_id']);
        
        $results = BrowserTest::i()
            ->setPath('/back/action/profile/update')
            ->setPost($data)
            ->setVariables($variables)
            ->setIsValid(true)
            ->setIsTriggered(true)
            ->process();
            
        $this->assertTrue($results['triggered']);
    }
}