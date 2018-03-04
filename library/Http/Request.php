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

    /**
     * 
     */
    public function __construct($serverVars, $postData)
    {
        $this->uri = $serverVars['REQUEST_URI'];
        $this->method = $serverVars['REQUEST_METHOD'];
        $this->isHttps = $serverVars['HTTPS'] === 'on';
        $this->host = $serverVars['HTTP_HOST'];
        $this->post = (object)$postData;
        $query = [];
        $queryParts = explode('&', $serverVars['QUERY_STRING']);
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