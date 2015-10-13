<?php //-->
/*
 * A Custom Library
 *
 * Copyright and license information can be found at LICENSE
 * distributed with this package.
 */
class ApiAppDialogActionLogoutTest extends PHPUnit_Framework_TestCase
{
    public function testRender()
    {
        $_GET = array(
            'client_id' => $app['app_token'],
            'redirect_uri' => '/control/app/search'
            );

        $results = BrowserTest::i()->setPath('/dialog/action/logout')
            ->setGet($_GET)
            ->setIsTriggered(true)
            ->process();
            
        $this->assertTrue($results['triggered']);
    }
}