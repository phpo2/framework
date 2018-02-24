<?php 

namespace PHPO2\Routing;

use PHPO2\Exceptions\InvalidArgumentException;
use PHPO2\Exceptions\NotFoundException;
use PHPO2\Exceptions\BadMethodCallException;
use PHPO2\Http\Response;
use PHPO2\Routing\Router;

/**
* Route compiler class
*/
class RouteCompiler
{
	/**
	 * Throw an exception when 404 not found
	 *
	 * @throws Exception InvalidArgumentException
	 */
	public static function notFoundException()
	{
		return response('errors.404', 404);
	}

	/**
	 * Throw an exception class dose not exist
	 *
	 * @param string $class
	 *
	 * @throws Exception InvalidArgumentException
	 */
	public static function throwClassNotFoundException($class)
	{
		self::responseCode(500);
		throw new InvalidArgumentException("Controller $class does not exist", 500);
		
	}

	/**
	 * Throw an exception class method dose not exist
	 *
	 * @throws Exception InvalidArgumentException
	 */
	public static function methodNotFoundException()
	{
		self::responseCode(405);
		throw new BadMethodCallException("BadMethodCallException", 405);
		
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
		$response = new Response;
		$response->setStatusCode($code);
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