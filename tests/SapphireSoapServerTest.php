<?php
/**
 */
class SapphireSoapServerTest extends FunctionalTest
{
    /**
     * @see http://open.silverstripe.com/ticket/4570
     */
    public function testWsdl()
    {
        $response = $this->get('SapphireSoapServerTest_MyServer/wsdl');

        $this->assertEquals(
            $response->getHeader('Content-Type'),
            'text/xml; charset=utf-8',
            'wsdl request returns with correct XML content type'
        );
    }
}

/**
 */
class SapphireSoapServerTest_MyServer extends SapphireSoapServer
{
    public function Link($action = null)
    {
        return Controller::join_links('SapphireSoapServerTest_MyServer', $action);
    }
}
