<?php 

namespace PHPO2\Routing;

use PHPO2\Routing\RouteFactory;
use PHPO2\Routing\RouteCompiler;

/**
* Route Service class
*/
class RouteService
{
	/**
	 * Route factory
	 *
	 * @var RouteFactory
	 */
	private $factory;

	/**
	 * Route Service constructor
	 */
	public function __construct()
	{
		$this->factory  = new RouteFactory();
	}

	/**
	 * Closure callback controller and method(s)
	 * 
	 * @param array $response
	 *
	 * @return mixed
	 */
	public function closureControllerAndMethod($response)
	{
		if ($response['handler'] instanceof \Closure) {
			
		    echo call_user_func_array($response['handler'], $response['arguments']);
		} else {

			$handler = $this->factory->parseControllerAndMethod($response['handler']);

			if (is_array($handler)) {

				if (class_exists($handler[0])) {

					$obj = new $handler[0];

					if (method_exists($obj, $handler[1])) {
						echo call_user_func_array([$obj, $handler[1]], $response['arguments']);	
					} else {
						RouteCompiler::throwMethodNotFoundException($handler[0], $handler[1]);
					}

				} else {
					RouteCompiler::throwClassNotFoundException($handler[0]);
				}
			}
		}
	}

}