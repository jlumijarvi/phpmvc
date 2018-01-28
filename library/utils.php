<?php

// useful for debugging
function dd()
{
    $args = func_get_args();
    foreach ($args as $key => $value) {
        if (is_object($value)) {
            try {
                $public = new \stdClass();
                $reflection = new \ReflectionClass($value);
                foreach ($reflection->getProperties() as $property) {
                    $property->setAccessible(true);
                    $public->{$property->getName()} = $property->getValue($value);
                }
                $args[$key] = $public;
            } catch (\Throwable $e) {
            }
        }
    }
    $args = count($args) === 1 ? $args[0] : $args;
    echo '<pre>';
    if ($args) {
        echo print_r($args, true);
    }
    echo '</pre>';
    die();
}

function safe($text)
{
    if (is_string($text)) {
        return htmlentities(strip_tags($text));
    }
    return $text;
}

function tidyHtml($html)
{
    $options = ['indent' => true, 'wrap' => 1000, 'new-blocklevel-tags' => 'main,nav'];
    $tidy = new \tidy();
    $tidy->parseString($html, $options);
    $tidy->cleanRepair();
    return "$tidy";
}