<?php

namespace PHPO2\Routing;

use PHPO2\Routing\RouteFactory;
use PHPO2\Routing\RouteResolver;
use PHPO2\Routing\RouteCompiler;
use PHPO2\Routing\RouteService;
use PHPO2\Routing\Route;

/**
 * Routing class
 */
class Router
{
	/**
	 * Route factory
	 *
	 * @var RouteFactory
	 */
	private $factory;

	/**
	 * Route resolver
	 * 
	 * @var RouteResolver
	 */
	private $resolver;

	/**
	 * Route service
	 * 
	 * @var RouteService
	 */
	private $service;

	/**
	 * An array with all the registerd routes
	 *
	 * @var array
	 */
	private $routes = array();

	/**
	 * an array with all routes by method
	 *
	 * @var array
	 */
	private $routesByMethod = array();

	/**
	 * Router constructor
	 */
	public function __construct()
	{
		$this->resolver = new RouteResolver();
		$this->factory  = new RouteFactory();
		$this->service  = new RouteService();
	}

	/**
	 * @param string $uri
	 * @param string $method
	 *
	 * @return array
	 */
	public function resolve($uri, $method)
	{
		return $this->resolver->resolve($this, $uri, $method);
	}

	/**
	 * Add a route with get method
	 *
	 * @param  string $url
	 * @param  mixed  $action
	 * 
	 * @return void
	 */
	public function get($url, $action)
	{
		$this->add($url, 'GET', $action);
	}

	/**
	 * Add a route with post method
	 *
	 * @param  string $url
	 * @param  mixed  $action
	 * 
	 * @return void
	 */
	public function post($url, $action)
	{
		$this->add($url, 'POST', $action);
	}

	/**
	 * Add a route with put method
	 *
	 * @param  string $url
	 * @param  mixed  $action
	 * 
	 * @return void
	 */
	public function put($url, $action)
	{
		$this->add($url, 'PUT', $action);
	}

	/**
	 * Add a route with patch method
	 *
	 * @param  string $url
	 * @param  mixed  $action
	 * 
	 * @return void
	 */
	public function patch($url, $action)
	{
		$this->add($url, 'PATCH', $action);
	}

	/**
	 * Add a route with delete method
	 *
	 * @param  string $url
	 * @param  mixed  $action
	 * 
	 * @return void
	 */
	public function delete($url, $action)
	{
		$this->add($url, 'DELETE', $action);
	}

	/**
	 * Add a route for all posible methods
	 *
	 * @param  string $url
	 * @param  mixed  $action
	 *
	 * @return void
	 */
	public function any($url, $action)
	{
		$this->add($url, 'GET|POST|PUT|PATCH|DELETE', $action);
	}

	/**
	 * Add a route with recource methods
	 *
	 * @param  string $url
	 * @param  mixed  $action
	 *
	 * @return void
	 */
	public function resource($url, $action)
	{
		$this->add($url, 'GET', "$action@index");
		
		$this->add("$url/create", 'GET', "$action@create");
		
		$this->add($url, 'POST', "$action@store");
		
		$this->add("$url/{param}", 'GET', "$action@show");
		
		$this->add("$url/{param}/edit", 'GET', "$action@edit");
		
		$this->add("$url/{param}", 'PUT|PATCH', "$action@update");
		
		$this->add("$url/{param}", 'DELETE', "$action@destroy");
	}

	/**
	 * Add new route to routes array
	 *
	 * @param  string $url
	 * @param  string $method
	 * @param  mixed  $action
	 *
	 * @return void
	 */
	public function add($url, $method, $action)
	{	
		$route = $this->factory->create($url, $method, $action);

		$this->routes[] = $route;

		foreach ($route->getMethod() as $method) {
			$this->routesByMethod[$method][] = $route;
		}
	}

	/**
	 * Get routes by method
	 *
	 * @param  string $method
	 *
	 * @return array
	 */
	public function getRoutesByMethod($method)
	{
		return ($this->routesByMethod && isset($this->routesByMethod[$method])) ? $this->routesByMethod[$method] : array();
	}

	/**
	 * Get all routes
	 *
	 * @return array
	 */
	public function getAllRoutes()
	{
		return $this->routes;
	}

	/**
	 * Get all routes and resolve callback
	 *
	 * @return array
	 */
	public function run()
	{
		$response = $this->resolve($_SERVER['REQUEST_URI'], $_SERVER['REQUEST_METHOD']);
		
		switch ($response['code']) {
		    case Route::STATUS_NOT_FOUND:
		        RouteCompiler::throwNotFoundException();
		        break;
		    
		    case Route::STATUS_FOUND:
		    	$this->service->ClosureControllerAndMethod($response);
		        break;
		}
	}
}
