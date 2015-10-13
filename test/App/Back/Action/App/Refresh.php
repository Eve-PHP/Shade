<?php //-->
/*
 * A Custom Library
 *
 * Copyright and license information can be found at LICENSE
 * distributed with this package.
 */
class ApiAppBackActionAppRefreshTest extends PHPUnit_Framework_TestCase
{
    public function testRender()
    {
        $variables = array(1);
        
        $results = BrowserTest::i()
            ->setPath('/back/action/app/refresh')
            ->setMethod('GET')
            ->setVariables($variables)
            ->setIsTriggered(true)
            ->process();

        $this->assertTrue($results['triggered']);
    }
}