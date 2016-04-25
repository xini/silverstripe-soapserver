<?php
/**
 * Soap server class which auto-generates a WSDL
 * file to initialize PHPs integrated {@link SoapServer} class.
 *
 * See {@link SOAPModelAccess} for an auto-generated SOAP API for your models.
 *
 * @todo Improve documentation
 */
class SapphireSoapServer extends Controller
{
    /**
     * @var array Map of method name to arguments.
     */
    private static $methods = array();

    /**
     * @var array
     */
    private static $xsd_types = array(
        'int' => 'xsd:int',
        'boolean' => 'xsd:boolean',
        'string' => 'xsd:string',
        'binary' => 'xsd:base64Binary',
    );

    private static $allowed_actions = array(
        'index',
        'wsdl',
    );

    public function wsdl()
    {
        $this->getResponse()->addHeader('Content-Type', 'text/xml; charset=utf-8');

        return $this->renderWith('SapphireSoapServer_wsdl');
    }

    /**
     * @return string
     */
    public function getWSDLURL()
    {
        return Director::absoluteBaseURLWithAuth().$this->Link().'wsdl';
    }

    /**
     * @return SS_List Collection of ArrayData elements describing
     *                 the method (keys: 'Name', 'Arguments', 'ReturnType')
     */
    public function Methods()
    {
        $methods = array();

        foreach ($this->stat('methods') as $methodName => $arguments) {
            $returnType = $arguments['_returns'];
            unset($arguments['_returns']);

            $processedArguments = array();
            foreach ($arguments as $argument => $type) {
                $processedArguments[] = new ArrayData(array(
                    'Name' => $argument,
                    'Type' => self::$xsd_types[$type],
                ));
            }
            $methods[] = new ArrayData(array(
                'Name' => $methodName,
                'Arguments' => new ArrayList($processedArguments),
                'ReturnType' => self::$xsd_types[$returnType],
            ));
        }

        return new ArrayList($methods);
    }

    /**
     * @return string
     */
    public function TargetNamespace()
    {
        return Director::absoluteBaseURL();
    }

    /**
     * @return string
     */
    public function ServiceURL()
    {
        return Director::absoluteBaseURLWithAuth().$this->class.'/';
    }

    public function index()
    {
        $wsdl = $this->getViewer('wsdl')->process($this);
        $wsdlFile = TEMP_FOLDER.'/sapphire-wsdl-'.$this->class;
        $fh = fopen($wsdlFile, 'w');
        fwrite($fh, $wsdl);
        fclose($fh);

        $this->getResponse()->addHeader('Content-Type', 'text/xml; charset=utf-8');

        $s = new SoapServer($wsdlFile, array('cache_wsdl' => WSDL_CACHE_NONE));
        $s->setClass($this->class);
        $s->handle();
    }
}
