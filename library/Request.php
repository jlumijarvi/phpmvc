<?php

class Request
{
    public $uri;
    public $method;
    public $host;
    public $isHttps;
    public $post;

    public function __construct($serverVariables, $post)
    {
        $this->uri = $_SERVER['REQUEST_URI'];
        $this->method = $_SERVER['REQUEST_METHOD'];
        $this->isHttps = $_SERVER['HTTPS'] === 'on';
        $this->host = $_SERVER['HTTP_HOST'];
        $this->post = (object)$post;
    }
}