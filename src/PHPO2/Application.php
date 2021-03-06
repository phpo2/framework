<?php 

namespace PHPO2;

use PHPO2\Exception\PHPO2Exception;
use PHPO2\Routing\RouteCompiler;

/**
* 
* Create the Application.
*
* Here we will load the environment and create the application instance
* that serves as the central piece of this framework.
*/
class Application
{
	/**
     * Run application.
     *
     * This method traverses the application middleware stack and then sends the
     * resultant Response object to the HTTP client.
     *
     * @throws Exception
     */
	public function run()
	{
		$this->exception();

		$this->router();
	}

	/**
	 *
	 * Load the Exception handler. Register framework 
	 * exception handler and error reporter
	 *
	 * @return void
	 */
	public function exception()
	{
		$this->enableErrorReporting();

		$this->registerHandler();
	}

	/**
	 *
	 * Register PHPO2 framework exception handler
	 *
	 * @return void
	 */
	public function registerHandler()
	{
		set_error_handler('PHPO2\Exception\PHPO2Exception::errorHandler');
		set_exception_handler('PHPO2\Exception\PHPO2Exception::exceptionHandler');
	}

	/**
	 *
	 * Enable all error reporting
	 *
	 * @return void
	 */
	public function enableErrorReporting()
	{
		ini_set('display_errors', 1);
		error_reporting(E_ALL | E_STRICT);
	}

	/**
	 *
	 * Compile and callback all routes
	 *
	 * @return void
	 */
	public function router()
	{
		$route = new RouteCompiler;

		$route->compile();
	}
}