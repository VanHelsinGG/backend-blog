<?php

namespace Api\Php\Handler;

class Request
{
    protected $uri;
    protected $data = [];
    protected $method;
    protected $protocol;
    protected $base;

    public function __construct()
    {
        $this->uri = $_SERVER['REQUEST_URI'];
        $this->base = $this->_protocol() . '://' . $_SERVER['HTTP_HOST'];
        $this->protocol = $this->_protocol();
        $this->method = $_SERVER['REQUEST_METHOD'];

        $this->getData();
    }

    protected function _protocol()
    {
        return isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' ? 'https' : 'http';
    }
    protected function getData()
    {
        switch ($this->method) {
            case 'post':
                $this->data = $_POST;
                break;
            case 'get':
                $this->data = $_GET;
                break;
            case 'patch':
            case 'delete':
                $input = file_get_contents('php://input');
                parse_str($input, $patchOrDeleteData);
    
                $this->data = $patchOrDeleteData;
                break;
            default:
                $this->data = [];
        }
    }
    
    public function uri()
    {
        $indexPos = strpos($this->uri, 'index.php');
        return $indexPos !== false ? substr($this->uri, $indexPos + strlen('index.php')) : $this->uri;
    }

    public function data()
    {
        return $this->data;
    }

    public function method()
    {
        return $this->method;
    }

    public function protocol()
    {
        return $this->protocol;
    }

    public function base()
    {
        return $this->base;
    }
}
