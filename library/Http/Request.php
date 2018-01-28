<?php

namespace Http;

class Request
{
    public $uri;
    public $method;
    public $host;
    public $isHttps;
    public $post;
    public $query;

    public function __construct($serverVariables, $post)
    {
        $this->uri = $_SERVER['REQUEST_URI'];
        $this->method = $_SERVER['REQUEST_METHOD'];
        $this->isHttps = $_SERVER['HTTPS'] === 'on';
        $this->host = $_SERVER['HTTP_HOST'];
        $this->post = (object)$post;
        $query = [];
        $queryParts = explode('&', $_SERVER['QUERY_STRING']);
        foreach ($queryParts as $queryPart) {
            $nameValue = explode('=', $queryPart);
            if (!isset($nameValue[1])) {
                continue;
            }
            $name = $nameValue[0];
            $value = urldecode($nameValue[1]);
            if (substr($name, '-2') == '[]') {
                $query[$name] = isset($query[$name]) ? $query[$name] : [];
                $this->query[$name][] = $value;
            } else {
                $query[$name] = $value;
            }
        }
        $this->query = (object)$query;
    }
}