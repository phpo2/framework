<?php

namespace PHPO2\View;

use PHPO2\Http\Response;
use InvalidArgumentException;
use RuntimeException;


/**
* Render PHPO2 views 
*/
class View
{
    /**
     * Render views path
     *
     * @var string
     */
    protected $path;

    /**
     * Return attributes
     *
     * @var array
     */
    protected $attributes = [];

    /**
     * Load a constructor.
     *
     * @return void
     */
    public function __construct()
    {
        $this->path = rtrim('./../app/Views/', '/\\') . '/';
    }

    /**
     * Render a template
     *
     * $data cannot contain template as a key
     *
     * throws RuntimeException if $templatePath . $template does not exist
     *
     * @param string $template
     * @param array $data
     *
     * @return mixed
     *
     * @throws InvalidArgumentException
     * @throws RuntimeException
     */
    public function render($template, array $data = [])
    {
        $output = $this->fetch($template, $data);

        $response = new Response;

        $response->setContent($output);

        $response->loadHeaders();

        return $response->getContent();
    }

    /**
     * Get the attributes for the renderer
     *
     * @return array
     */
    public function getAttributes()
    {
        return $this->attributes;
    }

    /**
     * Set the attributes for the renderer
     *
     * @param array $attributes
     */
    public function setAttributes(array $attributes)
    {
        $this->attributes = $attributes;
    }

    /**
     * Add an attribute
     *
     * @param $key
     * @param $value
     */
    public function addAttribute($key, $value) {
        $this->attributes[$key] = $value;
    }

    /**
     * Retrieve an attribute
     *
     * @param $key
     *
     * @return mixed
     */
    public function getAttribute($key) {
        if (!isset($this->attributes[$key])) {
            return false;
        }

        return $this->attributes[$key];
    }

    /**
     * Get the template path
     *
     * @return string
     */
    public function getTemplatePath()
    {
        return $this->path;
    }

    /**
     * Renders a template and returns the result as a string
     *
     * cannot contain template as a key
     *
     * throws RuntimeException if $templatePath . $template does not exist
     *
     * @param $template
     * @param array $data
     *
     * @return mixed
     *
     * @throws InvalidArgumentException
     * @throws RuntimeException
     */
    public function fetch($template, array $data = []) {
        if (isset($data['template'])) {
            throw new InvalidArgumentException("Duplicate template key found");
        }

        if (!is_file($this->path . $template . '.php')) {
            throw new RuntimeException("View cannot render `$template` because the template does not exist");
        }

        $data = array_merge($this->attributes, $data);

        try {
            ob_start();
            $this->protectedIncludeScope($this->path . $template . '.php', $data);
            $output = ob_get_clean();
        } catch(\Throwable $e) {
            ob_end_clean();
            throw $e;
        } catch(\Exception $e) {
            ob_end_clean();
            throw $e;
        }

        return $output;
    }

    /**
     * Load the view with parameters
     *
     * @param string $template
     * @param array $data
     */
    protected function protectedIncludeScope($template, array $data) {
        extract($data);
        include_once func_get_arg(0);
    }
}