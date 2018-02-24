<?php 

use PHPO2\View\ViewFactory;

if (! function_exists('view')) {
	/**
     * Get the evaluated view contents for the given view.
     *
     * @param  string  $template
     * @param  array   $params
     * @param  string  $code
     *
     * @return mixed View
     */
	function view($template, $params = array(), $code = 200)
	{
		return ViewFactory::render($template, $params, $code);
	}
}

if (! function_exists('response')) {
     /**
     * Get the evaluated view contents for the given view
     *  with response status code.
     *
     * @param  string  $template
     * @param  array   $code
     *
     * @return mixed View
     */
     function response($template, $code = 200)
     {
          return ViewFactory::render($template, [], $code);
     }
}