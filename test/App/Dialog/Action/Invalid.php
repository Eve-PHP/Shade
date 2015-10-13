<?php //-->
/*
 * A Custom Library
 *
 * Copyright and license information can be found at LICENSE
 * distributed with this package.
 */
class ApiAppDialogActionInvalidTest extends PHPUnit_Framework_TestCase
{
    public function testRender()
    {
        $results = BrowserTest::i()
            ->setPath('/dialog/action/invalid')
            ->setMethod('GET')
            ->setIsTriggered(true)
            ->process();

        $this->assertContains('Invalid Request', $results['data']);
    }
}
