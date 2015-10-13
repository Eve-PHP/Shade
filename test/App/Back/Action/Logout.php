<?php //-->
/*
 * A Custom Library
 *
 * Copyright and license information can be found at LICENSE
 * distributed with this package.
 */
class ApiAppBackActionLogoutTest extends PHPUnit_Framework_TestCase
{
    public function testRender()
    {
        $results = BrowserTest::i()->setPath('/back/action/logout')
            ->setMethod('GET')
            ->setIsTriggered(true)
            ->process();

        $this->assertTrue($results['triggered']);
    }
}