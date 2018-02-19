<?php 

namespace PHPO2\Routing;

use PHPO2\Routing\RouteFactory;
use PHPO2\Routing\RouteCompiler;
use PHPO2\Http\Response;

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
	 * Http response
	 *
	 * @var Request
	 */
	private $response;

	/**
	 * Route Service constructor
	 */
	public function __construct()
	{
		$this->factory  = new RouteFactory();
		$this->response = new Response();
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
			
		    $response = call_user_func_array($response['handler'], $response['arguments']);

		    if (is_array($response)) {
		    	$this->callbackIsArray(json_encode($response));
		    } else {
		    	$this->callback($response);
		    }
		} else {

			$handler = $this->factory->parseControllerAndMethod($response['handler']);

			if (is_array($handler)) {

				if (class_exists($handler[0])) {

					$obj = new $handler[0];

					$response = call_user_func_array([$obj, 'callAction'], [$handler[1], $response['arguments']]);

					if (is_array($response)) {
						$this->callbackIsArray(json_encode($response));
					} else {
						$this->callback($response);
					}	

				} else {
					RouteCompiler::throwClassNotFoundException($handler[0]);
				}
			}
		}
	}

	/**
	 * Callback is string
	 *
	 * @param string $content
	 *
	 * @return string
	 */
	public function callback($content)
	{
		$this->response->setContent($content);

		$this->response->loadHeaders();

		$this->responseContent();
	}

	/**
	 * Callback is array
	 *
	 * @param array $content
	 *
	 * @return string | json
	 */
	public function callbackIsArray($content)
	{

		$this->response->setContent($content);
		$this->response->setHeader('Content-Type', 'application/json');

		$this->response->loadHeaders();

		$this->responseContent();

	}

	/**
	 * Response generate contents
	 *
	 * @return mixed
	 */
	public function responseContent()
	{
		echo $this->response->getContent();
	}

}