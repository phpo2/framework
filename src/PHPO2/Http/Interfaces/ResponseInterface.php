<?php

namespace PHPO2\Http\Interfaces;

use PHPO2\Http\Interfaces\CookieInterface;

interface ResponseInterface
{
    public function setStatusCode($statusCode, $statusText = null);
    public function getStatusCode();
    public function addHeader($name, $value);
    public function setHeader($name, $value);
    public function getHeaders();
    public function addCookie(CookieInterface $cookie);
    public function deleteCookie(CookieInterface $cookie);
    public function setContent($content);
    public function getContent();
    public function redirect($url);
}