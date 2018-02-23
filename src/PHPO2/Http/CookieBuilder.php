<?php

namespace PHPO2\Http;

/**
 * Cookie builder class
 */
class CookieBuilder
{
    /**
     * Specifies the domain to set in the session cookie
     *
     * @var string
     */
    private $defaultDomain;

    /**
     * Path to set in the session cookie
     *
     * @var string
     */
    private $defaultPath = '/';

    /**
     * Specifies whether cookies
     *
     * @var boolean
     */
    private $defaultSecure = true;

    /**
     * Accessible only through the HTTP protocol
     *
     * @var boolean
     */
    private $defaultHttpOnly = true;

    /**
     * Specifies the domain to set in the session cookie. 
     * Default is none at all meaning the host name of the
     * server which generated the cookie according to cookies 
     * specification
     *
     * @param string $domain
     *
     * @return void
     */
    public function setDefaultDomain($domain)
    {
        $this->defaultDomain = (string) $domain;
    }

    /**
     * Specifies path to set in the session cookie. Defaults to /.
     *
     * @param string $path
     *
     * @return void
     */
    public function setDefaultPath($path)
    {
        $this->defaultPath = (string) $path;
    }

    /**
     * If TRUE cookie will only be sent over secure connections.
     *
     * @param boolean $secure
     *
     * @return void
     */
    public function setDefaultSecure($secure)
    {
        $this->defaultSecure = (bool) $secure;
    }

    /**
     * Marks the cookie as accessible only through the HTTP protocol. 
     * This means that the cookie won't be accessible by scripting 
     * languages, such as JavaScript. This setting can effectively 
     * help to reduce identity theft through XSS attacks 
     * (although it is not supported by all browsers).
     *
     * @param boolean $httpOnly
     *
     * @return void
     */
    public function setDefaultHttpOnly($httpOnly)
    {
        $this->defaultHttpOnly = (bool) $httpOnly;
    }

    /**
     * Defines a cookie to be sent along with the rest of the HTTP headers.
     *
     * @param string $name
     * @param string $value
     *
     * @return string
     */
    public function build($name, $value)
    {
        $cookie = new HttpCookie($name, $value);
        $cookie->setPath($this->defaultPath);
        $cookie->setSecure($this->defaultSecure);
        $cookie->setHttpOnly($this->defaultHttpOnly);

        if ($this->defaultDomain !== null) {
            $cookie->setDomain($this->defaultDomain);
        }

        return $cookie;
    }
}