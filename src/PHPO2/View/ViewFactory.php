<?php 

namespace PHPO2\View;

use PHPO2\View\View;

/**
* View factory class
*/
class ViewFactory
{
	public static function render(View $view, $template)
	{
		return $view->render($template);
	}
}