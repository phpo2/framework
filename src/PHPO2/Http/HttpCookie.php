<?php

namespace PHPO2\Http;

use PHPO2\Http\Interfaces\CookieInterface;

/**
 * Http cookie generate class
 */
class HttpCookie implements CookieInterface
{
    /**
     * The name of the cookie
     *
     * @var string
     */
    private $name;

    /**
     * The value of the cookie
     *
     * @var string
     */
    private $value;

    /**
     * The domain that the cookie is available to
     *
     * @var string
     */
    private $domain;

    /**
     * Server in which the cookie will be available on
     *
     * @var string
     */
    private $path;

    /**
     * The time the cookie expires
     *
     * @var integer
     */
    private $maxAge;

    /**
     * Indicates that the cookie should only be transmitted
     *
     * @var boolean
     */
    private $secure;

    /**
     * Specifies the domain to set in the session cookie
     *
     * @var boolean
     */
    private $httpOnly;

    /**
     * Set the cookie name and value
     *
     * @param string $name
     * @param string $value
     *
     * @return void
     */
    
    public function __construct($name, $value)
    {
        $this->name = (string) $name;
        $this->value = (string) $value;
    }

    /**
     * Returns the cookie name.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Sets the cookie value.
     *
     * @param  string $value
     *
     * @return void
     */
    public function setValue($value)
    {
        $this->value = (string) $value;
    }

    /**
     * Sets the cookie max age in seconds.
     *
     * @param  integer $seconds
     *
     * @return void
     */
    public function setMaxAge($seconds)
    {
        $this->maxAge = (int) $seconds;
    }

    /**
     * Sets the cookie domain.
     *
     * @param  string $domain
     *
     * @return void
     */
    public function setDomain($domain)
    {
        $this->domain = (string) $domain;
    }

    /**
     * Sets the cookie path.
     *
     * @param  string $path
     *
     * @return void
     */
    public function setPath($path)
    {
        $this->path = (string) $path;
    }

    /**
     * Sets the cookie secure flag.
     *
     * @param  boolean $secure
     *
     * @return void
     */
    public function setSecure($secure)
    {
        $this->secure = (bool) $secure;
    }

    /**
     * Sets the cookie httpOnly flag.
     *
     * @param  boolean $httpOnly
     *
     * @return void
     */
    public function setHttpOnly($httpOnly)
    {
        $this->httpOnly = (bool) $httpOnly;
    }

    /**
     * Returns the cookie HTTP header string.
     *
     * @return string
     */
    public function getHeaderString()
    {
        $parts = [
            $this->name . '=' . rawurlencode($this->value),
            $this->getMaxAgeString(),
            $this->getExpiresString(),
            $this->getDomainString(),
            $this->getPathString(),
            $this->getSecureString(),
            $this->getHttpOnlyString(),
        ];

        $filteredParts = array_filter($parts);

        return implode('; ', $filteredParts);
    }

    /**
     * Returns the cookie expire time with header.
     *
     * @return mixed
     */
    private function getMaxAgeString()
    {
        if ($this->maxAge !== null) {
            return 'Max-Age='. $this->maxAge;
        }
    }

    /**
     * Returns the cookie expire time.
     *
     * @return mixed
     */
    private function getExpiresString()
    {
        if ($this->maxAge !== null) {
            return 'expires=' . gmdate(
                "D, d-M-Y H:i:s",
                time() + $this->maxAge
            ) . ' GMT';
        }
    }

    /**
     * Returns the cookie available domain.
     *
     * @return string
     */
    private function getDomainString()
    {
        if ($this->domain) {
            return "domain=$this->domain";
        }
    }

    /**
     * Returns the cookie stored path.
     *
     * @return string
     */
    private function getPathString()
    {
        if ($this->path) {
            return "path=$this->path";
        }
    }

    /**
     * Returns the cookie should only be sent over 
     * secure connections.
     *
     * @return string
     */
    private function getSecureString()
    {
        if ($this->secure) {
            return 'secure';
        }
    }

    /**
     * Marks the cookie as accessible only through 
     * the HTTP protocol. 
     *
     * @return string
     */
    private function getHttpOnlyString()
    {
        if ($this->httpOnly) {
            return 'HttpOnly';
        }
    }
}
