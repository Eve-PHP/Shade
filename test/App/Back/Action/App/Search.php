<?php //-->
/*
 * A Custom Library
 *
 * Copyright and license information can be found at LICENSE
 * distributed with this package.
 */
class ApiAppBackActionAppSearchTest extends PHPUnit_Framework_TestCase
{
    public function testRender()
    {
        $results = BrowserTest::i()->setPath('/back/action/app/search')
            ->setMethod('GET')
            ->setIsTriggered(false)
            ->process();
            
        $this->assertContains('Search', $results['data']);
    }
}