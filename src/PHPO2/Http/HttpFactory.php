<?php 

namespace PHPO2\Http;

/**
* Http factroy class
*/
class HttpFactory
{
	/**
	 * Return all http GET method request parametes
	 *
	 * @return array
	 */
	public static function get()
	{
		return $_GET;
	}

	/**
	 * Return all http POST method request parametes
	 *
	 * @return array
	 */
	public static function post()
	{
		return $_POST;
	}

	/**
	 * Return all cookie parametes
	 *
	 * @return array
	 */
	public static function cookie()
	{
		return $_COOKIE;
	}

	/**
	 * Return all Http POST FILE method  parametes
	 *
	 * @return array
	 */
	public static function file()
	{
		return $_FILES;
	}

	/**
	 * Return all http server information
	 *
	 * @return array
	 */
	public static function server()
	{
		return $_SERVER;
	}

	/**
	 * Return all http php://input method raw data 
	 * stream parametes
	 *
	 * @return array
	 */
	public static function content()
	{
		return file_get_contents('php://input');
	}

	/**
	 * Return http php://input method raw data by specific key
	 * 
	 * @param array $array
	 * @param string $key
	 *
	 * @return mixed
	 */
	public static function multiValue($array = array(), $key)
	{
		foreach ($array as $value) {
			if (is_array($value)) {
				if (array_key_exists($key, $value)) {
					return $value[$key];
				} else {
					return self::multiValue($value, $key);
				}
			}
		}
	}
}