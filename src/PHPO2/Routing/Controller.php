<?php

namespace PHPO2\Routing;

use PHPO2\Exceptions\BadMethodCallException;

/**
 * Abstract controller
 */
abstract class Controller
{    
    /**
     * Load the constructor
     *
     * @return void
     */
    public function __construct()
    {
        $this->before();
    }

    /**
     * Before filter - called before an action method
     *
     * @return void
     */
    protected function before()
    {

    }

    /**
     * After filter - called after an action method
     *
     * @return void
     */
    protected function after()
    {
        
    }
    
    /**
     * Execute an action on the controller
     *
     * @param string $method
     * @param array $parameters
     *
     * @return mixed
     */
    public function callAction($method, $parameters)
    {
        return call_user_func_array([$this, $method], $parameters); 
    }

    /**
     * Handle calls to missing methods on the controller
     *
     * @param string $method
     * @param array $parameters
     *
     * @throws BadMethodCallException
     */
    public function __call($method, $parameters)
    {
        throw new BadMethodCallException("Method [{$method}] does not exist on [".get_class($this).'].');
    }

    /**
     * Load the destructor
     *
     * @return void
     */
    public function __destruct()
    {
        $this->after();
    }
}