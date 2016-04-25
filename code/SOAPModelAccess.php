<?php
/**
 * Basic SOAP Server to access and modify DataObject instances.
 * You can enable SOAP access on a DataObject by setting {@link DataObject::$api_access} to true.
 * This means that you'll also enable a RESTful API through {@link RestfulServer}.
 *
 * @todo Test relation methods
 */
class SOAPModelAccess extends SapphireSoapServer
{
    private static $methods = array(
        'getXML' => array(
            'class' => 'string',
            'id' => 'int',
            'relation' => 'string',
            '_returns' => 'string',
        ),
        'getJSON' => array(
            'class' => 'string',
            'id' => 'int',
            'relation' => 'string',
            '_returns' => 'string',
        ),
        'putXML' => array(
            'class' => 'string',
            'id' => 'int',
            'relation' => 'string',
            'data' => 'string',
            'username' => 'string',
            'password' => 'string',
            '_returns' => 'boolean',
        ),
        'putJSON' => array(
            'class' => 'string',
            'id' => 'int',
            'relation' => 'string',
            '_returns' => 'boolean',
        ),
    );

    public function Link($action = null)
    {
        return Controller::join_links('soap/v1/', $action);
    }

    /**
     * Used to emulate RESTful GET requests with XML data.
     *
     * @param string $class
     * @param Number $id
     * @param string $relation Relation name
     *
     * @return string
     */
    public function getXML($class, $id, $relation = false, $username = null, $password = null)
    {
        $this->authenticate($username, $password);

        $response = Director::test(
            $this->buildRestfulURL($class, $id, $relation, 'xml'),
            null,
            null,
            'GET'
        );

        return ($response->isError()) ? $this->getErrorMessage($response) : $response->getBody();
    }

    /**
     * Used to emulate RESTful GET requests with JSON data.
     *
     * @param string $class
     * @param Number $id
     * @param string $relation Relation name
     * @param string $username
     * @param string $password
     *
     * @return string
     */
    public function getJSON($class, $id, $relation = false, $username = null, $password = null)
    {
        $this->authenticate($username, $password);

        $response = Director::test(
            $this->buildRestfulURL($class, $id, $relation, 'json'),
            null,
            null,
            'GET'
        );

        return ($response->isError()) ? $this->getErrorMessage($response) : $response->getBody();
    }

    /**
     * Used to emulate RESTful POST and PUT requests with XML data.
     *
     * @param string $class
     * @param Number $id
     * @param string $relation Relation name
     * @param array  $data
     * @param string $username
     * @param string $password
     *
     * @return string
     */
    public function putXML($class, $id = false, $relation = false, $data, $username = null, $password = null)
    {
        $this->authenticate($username, $password);

        $response = Director::test(
            $this->buildRestfulURL($class, $id, $relation, 'xml'),
            array(),
            null,
            ($id) ? 'PUT' : 'POST',
            $data
        );

        return ($response->isError()) ? $this->getErrorMessage($response) : $response->getBody();
    }

    /**
     * Used to emulate RESTful POST and PUT requests with JSON data.
     *
     * @param string $class
     * @param Number $id
     * @param string $relation Relation name
     * @param array  $data
     * @param string $username
     * @param string $password
     *
     * @return string
     */
    public function putJSON($class = false, $id = false, $relation = false, $data, $username = null, $password = null)
    {
        $this->authenticate($username, $password);

        $response = Director::test(
            $this->buildRestfulURL($class, $id, $relation, 'json'),
            array(),
            null,
            ($id) ? 'PUT' : 'POST',
            $data
        );

        return ($response->isError()) ? $this->getErrorMessage($response) : $response->getBody();
    }

    /**
     * Used to emulate RESTful DELETE requests.
     *
     * @param string $class
     * @param Number $id
     * @param string $relation Relation name
     * @param string $username
     * @param string $password
     *
     * @return string
     */
    public function deleteXML($class, $id, $relation = false, $username = null, $password = null)
    {
        $this->authenticate($username, $password);

        $response = Director::test(
            $this->buildRestfulURL($class, $id, $relation, 'xml'),
            null,
            null,
            'DELETE'
        );

        return ($response->isError()) ? $this->getErrorMessage($response) : $response->getBody();
    }

    /**
     * Used to emulate RESTful DELETE requests.
     *
     * @param string $class
     * @param Number $id
     * @param string $relation Relation name
     * @param string $username
     * @param string $password
     *
     * @return string
     */
    public function deleteJSON($class, $id, $relation = false, $username = null, $password = null)
    {
        $this->authenticate($username, $password);

        $response = Director::test(
            $this->buildRestfulURL($class, $id, $relation, 'json'),
            null,
            null,
            'DELETE'
        );

        return ($response->isError()) ? $this->getErrorMessage($response) : $response->getBody();
    }

    /**
     * Faking an HTTP Basicauth login in the PHP environment
     * that RestfulServer can pick up.
     *
     * @param string $username Username
     * @param string $password Plaintext password
     */
    protected function authenticate($username, $password)
    {
        if (is_string($username)) {
            $_SERVER['PHP_AUTH_USER'] = $username;
        }
        if (is_string($password)) {
            $_SERVER['PHP_AUTH_PW'] = $password;
        }
    }

    /**
     * @param string $class
     * @param Number $id
     * @param string $relation
     * @param string $extension
     *
     * @return string
     */
    protected function buildRestfulURL($class, $id, $relation, $extension)
    {
        $url = "api/v1/{$class}";
        if ($id) {
            $url .= "/{$id}";
        }
        if ($relation) {
            $url .= "/{$relation}";
        }
        if ($extension) {
            $url .= "/.{$extension}";
        }

        return $url;
    }

    /**
     * @param SS_HTTPResponse $response
     *
     * @return string XML string containing the HTTP error message
     */
    protected function getErrorMessage($response)
    {
        return '<error type="authentication" code="'.$response->getStatusCode().'">'.$response->getStatusDescription().'</error>';
    }
}
