<?php //-->
/*
 * A Custom Library
 *
 * Copyright and license information can be found at LICENSE
 * distributed with this package.
 */
class BrowserTest extends Eden\Core\Base
{
    public function __construct() {
        $this->request = eve()->getRequest();
        $this->response = eve()->getResponse();
    }

    protected function getClass($path)
    {
        // Filter path
        $str = array_map('ucfirst', explode('/', $path));
        $path = implode('\\', $str);
        // Set Class
        $class = '\Eve\App' . $path;
        return new $class();
    }

    public function getResults($results) {
        $this->results = $results;
        return $this;
    }

    public function process() 
    {
        $class = $this->getClass($this->path);

        $this->action = $class::i()
            ->setRequest($this->request)
            ->setResponse($this->response);

        if($this->isTriggered) {
            //listen
            $test = $this->test;
            $triggered = false;
            eve()->on('redirect', function($path, $check) use ($test, &$triggered) {
                if($this->isValid) {
                    $check->stop = true;
                    $triggered = true;
                } else {
                    $triggered = true;
                    $check->stop = true;
                }
            });
        }

        $this->setResults();
        
        if($this->isTriggered) {
            eve()->off('redirect');
        }

        if($this->response->isKey('body')) {
            $this->results = $this->response->get('body');
        }

        $this->data['data'] = $this->results;
        $this->data['triggered'] = $triggered;

        return $this->data;
    }

    public function setClass($path) {
        $class = $this->getClass($path);
        $this->class = $class::i();
        return $this;
    }

    public function setData($data) {
        if($this->method == 'POST') {
            $_POST = $data;
        } else if($this->method == 'GET') {
            $_GET = $data;
        }

        $this->request->set('post', $_POST);
        $this->request->set('get', $_GET);
        return $this;
    }

    public function setGet($data) {
        $_GET = $data;
        $this->request->set('get', $_GET);
        return $this;
    }
    
    public function setIsTriggered($triggered) {
        $this->isTriggered = $triggered;
        return $this;
    }

    public function setIsValid($bool) {
        $this->isValid = $bool;
        return $this;
    }

    public function setMethod($method) {
        $_SERVER['REQUEST_METHOD'] = $method;

        $this->method = $method;

        if($this->method == 'POST') {
            $_GET = array();
        } else if($this->method == 'GET') {
            $_POST = array();
        }

        return $this;
    }

    public function setPath($path) {
        $this->path = $path;
        return $this;
    }

    public function setPost($data) {
        $_POST = $data;
        $this->request->set('post', $_POST);
        return $this;
    }

    public function setQueryString($string) {
        $string = http_build_query($string);
        $_SERVER['QUERY_STRING'] = $string;
        $this->request->set('query', $string);
        return $this;
    }
    
    public function setResults() {
        $this->results = $this->action->render();
        return $this;
    }

    public function setSource($source) {
        $this->request->set('source', $source);
        return $this;
    }

    public function setTemplate($path) {
        eve()->registry()->set('path', 'template', __DIR__.'/../App/'. ucfirst($path) .'/template');
        return $this;
    }

    public function setTest($test) {
        $this->test = $test;
        return $this;
    }

    public function setVariables($variables) {
        $this->request->set('variables', $variables);
        return $this;
    }
}