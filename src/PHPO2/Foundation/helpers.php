<?php 

use PHPO2\View\ViewFactory;

if (! function_exists('view')) {
	/**
     * Get the evaluated view contents for the given view.
     *
     * @param  string  $view
     * @param  array   $data
     *
     * @return mixed View
     */
	function view($template, $params = array(), $code = 200)
	{
		return ViewFactory::render($template, $params, $code);
	}
}