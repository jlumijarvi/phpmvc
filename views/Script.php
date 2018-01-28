<?php

namespace Views;

class Script
{
    public $src;
    public $integrity;
    public $crossorigin;

    public function __construct($src, $integrity = null, $crossorigin = null)
    {
        $this->src = $src;
        $this->integrity = $integrity;
        $this->crossorigin = $crossorigin;
    }
}