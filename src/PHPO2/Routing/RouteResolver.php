<?php

namespace PHPO2\Routing;

use PHPO2\Routing\Router;

/**
 * Class resolves the given route or throws an exception
 */
class RouteResolver
{
	/**
	 * Resolve the given url and call the method that belongs to the route
	 *
	 * @param  Router $router
	 * @param  string $uri
	 * @param  string $method
	 *
	 * @return array
	 */
	public function resolve(Router $router, $uri, $method)
	{
		
		$routes = $router->getRoutesByMethod($method);
		
		$requestedUri = trim(preg_replace('/\?.*/', '', $uri), '/');
		
		foreach ($routes as $route) {
			$matches = array();

			
			if ($route->getUrl() === $requestedUri || preg_match('~^'.$route->getUrl().'$~', $requestedUri, $matches)) {
				$argumentArray = array();
				$arguments = $this->getArguments($matches);

				
				if (is_array($route->getArguments()) && count($route->getArguments()) > 0) {
					
					foreach ($route->getArguments() as $key => $argument) {
						
						if (isset($arguments[$key])) {
							$argumentArray[$argument] = $arguments[$key];
						} else {
							
							$argumentArray[$argument] = null;
						}
					}
				}
				return $this->getFoundRoute($route->getAction(), $argumentArray);
			}
		}

		return $this->methodAllowed($router, $requestedUri, $method);

	}

	/**
	 * Get arguments
	 *
	 * @param  array $matches
	 *
	 * @return array
	 */
	private function getArguments($matches)
	{
		$arguments = array();

		foreach ($matches as $key => $match) {
			if ($key === 0) continue;

			if (strlen($match) > 0) {
				$arguments[] = $match;
			}
		}

		return $arguments;
	}

	/**
	 * Get found route
	 *
	 * @param  string $handler
	 * @param  array $arguments
	 *
	 * @return array
	 */
	public function getFoundRoute($handler, $arguments)
	{
		return [
			'code' => Route::STATUS_FOUND,
			'handler' => $handler,
			'arguments' => $arguments
		];
	}

	/**
	 * Return not found code
	 *
	 * @return array
	 */
	public function routeNotFound()
	{
		return [
			'code' => Route::STATUS_NOT_FOUND,
			'handler' => null,
			'arguments' => []
		];
	}

	/**
	 * Get arguments
	 *
	 * @param  instance $router
	 * @param  string $uri
	 * @param  string $method
	 *
	 * @return array
	 */
	public function methodAllowed(Router $router, $uri, $method)
	{
		$routes = $router->getAllRoutes();

		foreach ($routes as $route) {
			if ($route->getUrl() === $uri) {
				if ($route->getMethod() !== $method) {
					return [
						'code' => Route::STATUS_METHOD_NOT_FOUND,
						'handler' => null,
						'arguments' => []
					];
				}
			}
		}
		return $this->routeNotFound();
	}
}
