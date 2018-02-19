<?php

namespace PHPO2\Http\Interfaces;

interface RequestInterface
{
    public function getParameter($key, $defaultValue = null);
    public function getQueryParameter($key, $defaultValue = null);
    public function getBodyParameter($key, $defaultValue = null);
    public function getFile($key, $defaultValue = null);
    public function getParameters();
    public function getQueryParameters();
    public function getBodyParameters();
    public function getRawBody();
    public function getCookies();
    public function get($key);
    public function post($key);
    public function file($key);
    public function all();
    public function cookie($key, $defaultValue = null);
    public function query($key);
    public function has($key);
    public function url();
    public function fullUrl();
    public function path();
    public function getFiles();
    public function getUri();
    public function getPath();
    public function getMethod();
    public function getHttpAccept();
    public function getReferer();
    public function getUserAgent();
    public function getIpAddress();
    public function isSecure();
    public function getProtocol();
    public function getQueryString();
}
