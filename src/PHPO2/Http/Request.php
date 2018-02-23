<?php

namespace PHPO2\Http;

use PHPO2\Http\HttpFactory;
use PHPO2\Http\Interfaces\RequestInterface;
use PHPO2\Http\Exceptions\MissingRequestMetaVariableException;

/**
 * Http request class
 */
class Request implements RequestInterface
{
    /**
     * Http GET method parameters
     *
     * @var string
     */
    protected $getParameters;

    /**
     * Http POST method parameters
     *
     * @var string
     */
    protected $postParameters;

    /**
     * Server request parameters
     *
     * @var string
     */
    protected $server;

    /**
     * File stream of files
     *
     * @var string
     */
    protected $files;

    /**
     * Get all of cookies
     *
     * @var string
     */
    protected $cookies;

    /**
     * Http request constructor
     *
     * @return mixed
     */
    public function __construct() {

        $this->getParameters  = HttpFactory::get();
        $this->postParameters = HttpFactory::post();
        $this->cookies        = HttpFactory::cookie();
        $this->files          = HttpFactory::file();
        $this->server         = HttpFactory::server();
        $this->inputStream    = HttpFactory::content();
    }

    /**
     * Returns a parameter value or a default value if none is set.
     *
     * @param  string $key
     * @param  string $defaultValue (optional)
     *
     * @return string
     */
    public function getParameter($key, $defaultValue = null)
    {
        if (array_key_exists($key, $this->postParameters)) {
            return $this->postParameters[$key];
        }

        if (array_key_exists($key, $this->getParameters)) {
            return $this->getParameters[$key];
        }

        return $defaultValue;
    }

    /**
     * Returns a query parameter value or a default value if none is set.
     *
     * @param  string $key
     * @param  string $defaultValue (optional)
     *
     * @return string
     */
    public function getQueryParameter($key, $defaultValue = null)
    {
        if (array_key_exists($key, $this->getParameters)) {
            return $this->getParameters[$key];
        }

        return $defaultValue;
    }

    /**
     * Returns a body parameter value or a default value if none is set.
     *
     * @param  string $key
     * @param  string $defaultValue (optional)
     *
     * @return string
     */
    public function getBodyParameter($key, $defaultValue = null)
    {
        if (array_key_exists($key, $this->postParameters)) {
            return $this->postParameters[$key];
        }

        return $defaultValue;
    }

    /**
     * Returns a file value or a default value if none is set.
     *
     * @param  string $key
     * @param  string $defaultValue (optional)
     *
     * @return string
     */
    public function getFile($key, $defaultValue = null)
    {
        if (array_key_exists($key, $this->files)) {
            return $this->files[$key];
        }

        return $defaultValue;
    }

    /**
     * Returns all parameters.
     *
     * @return array
     */
    public function getParameters()
    {
        return array_merge($this->getParameters, $this->postParameters);
    }

    /**
     * Returns all query parameters.
     *
     * @return array
     */
    public function getQueryParameters()
    {
        return $this->getParameters;
    }

    /**
     * Returns all body parameters.
     *
     * @return array
     */
    public function getBodyParameters()
    {
        return $this->postParameters;
    }

    /**
    * Returns raw values from the read-only stream that
    * allows you to read raw data from the request body.
    *
    * @return string
    */
    public function getRawBody()
    {
        return $this->inputStream;
    }

    /**
     * Returns a Cookie Iterator.
     *
     * @return array
     */
    public function getCookies()
    {
        return $this->cookies;
    }

    /**
     * Returns a get params by key.
     *
     * @param string $key
     *
     * @return string
     */
    public function get($key)
    {
        if (array_key_exists($key, $this->getParameters)) {
            return $this->getParameters[$key];
        }
    }

    /**
     * Returns a post params by key.
     *
     * @param string $key
     *
     * @return string
     */
    public function post($key)
    {
        if (array_key_exists($key, $this->postParameters)) {
            return $this->postParameters[$key];
        }
    }

    /**
     * Returns a file params by key.
     *
     * @param string $key
     *
     * @return string
     */
    public function file($key)
    {
        return $this->getFile($key);
    }

    /**
     * Returns a all params.
     *
     * @return array
     */
    public function all()
    {
        return $this->getParameters();
    }

    /**
     * Returns a query parameter by key.
     *
     * @param string $key
     *
     * @return string
     */
    public function query($key)
    {   
        if (array_key_exists($key, $this->getQueryParameters())) {
            return $this->getParameter($key);
        }
    }

    /**
     * Returns a json query value by key.
     *
     * @param string $key
     *
     * @return mixed
     */
    public function json($key)
    {
       $input = json_decode($this->getRawBody(), true);

       if (isset($input)) {
            if (array_key_exists($key, $input)) {
               return $input[$key];
            } else { 
                return HttpFactory::multiValue($input, $key);
            }
       }
    }

    /**
     * Returns a cookie value or a default value if none is set.
     *
     * @param  string $key
     * @param  string $defaultValue (optional)
     *
     * @return string
     */
    public function cookie($key, $defaultValue = null)
    {
        if (array_key_exists($key, $this->cookies)) {
            return $this->cookies[$key];
        }

        return $defaultValue;
    }

    /**
     * Detemine has a request parameter key.
     *
     * @param string $key
     *
     * @return string
     */
    public function has($key)
    {   
        if (array_key_exists($key, $this->getParameters())) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Returns a url.
     *
     * @return string
     */
    public function url()
    {
        return sprintf('%s%s%s', 
            $this->getProtocol(), 
            $this->getHost(), 
            substr($this->getPath(), 0, -1)
        );
    }

    /**
     * Returns a full url with parameters.
     *
     * @return array
     */
    public function fullUrl()
    {
        return sprintf('%s%s%s', 
            $this->getProtocol(), 
            $this->getHost(), 
            $this->getUri()
        );
    }

    /**
     * Returns a url path.
     *
     * @return string
     */
    public function path()
    {
        return $this->getPath();
    }

    /**
     * Returns a File Iterator.
     *
     * @return array
     */
    public function getFiles()
    {
        return $this->files;
    }

    /**
     * Returns HTTP Server host.
     *
     * @return string
     *
     * @throws MissingRequestMetaVariableException
     */
    public function getHost()
    {
        return $this->getServerVariable('HTTP_HOST');
    }

    /**
     * The URI which was given in order to access this page
     *
     * @return string
     *
     * @throws MissingRequestMetaVariableException
     */
    public function getUri()
    {
        return $this->getServerVariable('REQUEST_URI');
    }

    /**
     * Return just the path
     *
     * @return string
     */
    public function getPath()
    {
        return strtok($this->getServerVariable('REQUEST_URI'), '?');
    }

    /**
     * Which request method was used to access the page;
     * i.e. 'GET', 'HEAD', 'POST', 'PUT', 'PATCH', 'DELETE'.
     *
     * @return string
     *
     * @throws MissingRequestMetaVariableException
     */
    public function getMethod()
    {
        return $this->getServerVariable('REQUEST_METHOD');
    }

    /**
     * Contents of the Accept: header from the current request, if there is one.
     *
     * @return string
     *
     * @throws MissingRequestMetaVariableException
     */
    public function getHttpAccept()
    {
        return $this->getServerVariable('HTTP_ACCEPT');
    }

    /**
     * The address of the page (if any) which referred the user agent to the
     * current page.
     *
     * @return string
     *
     * @throws MissingRequestMetaVariableException
     */
    public function getReferer()
    {
        return $this->getServerVariable('HTTP_REFERER');
    }

    /**
     * Content of the User-Agent header from the request, if there is one.
     *
     * @return string
     *
     * @throws MissingRequestMetaVariableException
     */
    public function getUserAgent()
    {
        return $this->getServerVariable('HTTP_USER_AGENT');
    }

    /**
     * The IP address from which the user is viewing the current page.
     *
     * @return string
     *
     * @throws MissingRequestMetaVariableException
     */
    public function getIpAddress()
    {
        return $this->getServerVariable('REMOTE_ADDR');
    }

    /**
     * Checks to see whether the current request is using HTTPS.
     *
     * @return boolean
     */
    public function isSecure()
    {
        return (array_key_exists('HTTPS', $this->server)
            && $this->server['HTTPS'] !== 'off'
        );
    }

    /**
     * Return the server http protocol type.
     *
     * @return string
     *
     * @throws MissingRequestMetaVariableException
     */
    public function getProtocol()
    {
        if ($this->isSecure()) {
            $protocol = 'https://';
        } else {
            $protocol = 'http://';
        }

        return $protocol;
    }

    /**
     * The query string which the page was accessed.
     *
     * @return string
     *
     * @throws MissingRequestMetaVariableException
     */
    public function getQueryString()
    {
        return $this->getServerVariable('QUERY_STRING');
    }

    /**
     * The query string, if any, via which the page was accessed.
     *
     * @return string
     *
     * @throws MissingRequestMetaVariableException
     */
    private function getServerVariable($key)
    {
        if (!array_key_exists($key, $this->server)) {
            throw new MissingRequestMetaVariableException($key);
        }

        return $this->server[$key];
    }
}
