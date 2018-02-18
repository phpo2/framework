<?php 

namespace PHPO2\HttpComponent;

use PHPO2\Exception\NotFoundException;

/**
* 
* Framework controller.
*
* This class represents the main controller in the framework.
* It's manage the sub controllers.
*
*/
abstract class Controller 
{
	/**
     * Parameters from the matched route
     * @var array
     */
    protected $params = [];

    /**
     * Class constructor
     *
     * @param array $params  Parameters from the route
     *
     * @return void
     */
    public function __construct()
    {
        
    }

    /**
     * Magic method called when a non-existent or inaccessible method is
     * called on an object of this class. Used to execute before and after
     * filter methods on action methods.
     *
     * @param string $name  Method name
     * @param array $args Arguments passed to the method
     *
     * @return void
     */
    public function __call($name, $args)
    {
        $method = $name;

        if (method_exists($this, $method)) {
            if ($this->before() !== false) {
                call_user_func_array([$this, $method], $args);
                $this->after();
            }
        } else {
            throw new NotFoundException("Method $method not found in controller " . get_class($this));
        }
    }

    /**
     * Before filter - called before an action method.
     *
     * @return void
     */
    protected function before()
    {

    }

    /**
     * After filter - called after an action method.
     *
     * @return void
     */
    protected function after()
    {
    	
    }
}