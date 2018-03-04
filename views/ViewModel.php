<?php

namespace Views;

class ViewModel
{
    private $vars;

    public function __construct($vars = [])
    {
        $this->vars = $vars;
    }

    public function getVars()
    {
        return $this->vars;
    }

    public function __get($name)
    {
        if (!isset($this->vars[$name])) {
            return null;
        }

        $value = $this->vars[$name];

        if (\is_object($value)) {
            return new ViewModel((array)$value);
        } else if (\is_array($value)) {
            return array_map(function ($it) {
                return \is_scalar($it) ? $this->safe($it) : new ViewModel((array)$it);
            }, $value);
        } else {
            return $this->safe($this->vars[$name]);
        }
    }

    public function __set($name, $value)
    {
        $this->vars[$name] = $value;
    }

    public function safe($text)
    {
        if (is_string($text)) {
            return htmlentities(strip_tags($text));
        }
        return $text;
    }

    public function raw($name)
    {
        if (!isset($this->vars[$name])) {
            return null;
        }

        return $this->vars[$name];
    }

    public function getRoute()
    {
        return \App::instance()->getCurrentRoute();
    }
}
