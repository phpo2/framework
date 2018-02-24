<?php 

namespace PHPO2\Routing;

use PHPO2\Exceptions\InvalidArgumentException;
use PHPO2\Exceptions\NotFoundException;
use PHPO2\Routing\Router;

/**
* Route compiler class
*/
class RouteCompiler
{
	/**
	 * Throw an exception when 404 not found
	 *
	 * @return Exception InvalidArgumentException
	 */
	public static function throwNotFoundException()
	{
		self::responseCode(404);
		throw new NotFoundException("404 Not found", 404);
	}

	/**
	 * Throw an exception class dose not exist
	 *
	 * @param string $class
	 *
	 * @return Exception InvalidArgumentException
	 */
	public static function throwClassNotFoundException($class)
	{
		self::responseCode(500);
		throw new InvalidArgumentException("Controller $class does not exist", 500);
		
	}

	/**
	 * Throw an exception class method dose not exist
	 *
	 * @param string $method
	 * @param string $class
	 *
	 * @return Exception InvalidArgumentException
	 */
	public static function throwMethodNotFoundException($class, $method)
	{
		self::responseCode(500);
		throw new InvalidArgumentException("$class->$method does not exist", 500);
		
	}

	/**
	 * Generate http response code
	 *
	 * @param integer $code 
	 *
	 * @return void
	 */
	public static function responseCode($code)
	{
		http_response_code($code);
	}

	/**
	 * Compile the routes
	 *
	 * @return void
	 */
	public function compile()
	{
		$route = new Router;

		extract(['route' => $route]);

		require_once('./../config/routes.php');

		$route->run();
	}
}