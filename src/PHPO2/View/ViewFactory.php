<?php 

namespace PHPO2\View;

use PHPO2\View\View;

/**
* View factory class
*/
class ViewFactory
{
	/**
	 * Block comment
	 *
	 * @param string $template
	 * @param array $params
	 *
	 * @return mixed
	 */
	public static function render($template, $params, $code)
	{
		$view = new View; 
		return $view->render($template, $params, $code);
	}
}