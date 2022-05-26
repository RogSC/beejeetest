<?php
namespace App;

use Closure;

/**
 * Class Router
 * @package App
 */
class Router
{
	private static array $routes = [];

	private function __construct() {}
	private function __clone() {}

	/**
	 * @param string $pattern
	 * @param Closure $callback
	 */
	public static function route(string $pattern, Closure $callback)
	{
		$pattern = '/^' . str_replace('/', '\/', $pattern) . '$/';
		self::$routes[$pattern] = $callback;
	}

	/**
	 * @return mixed
	 */
	public static function execute(): mixed
	{
		$url = str_replace('?'.$_SERVER['QUERY_STRING'], '', $_SERVER['REQUEST_URI']);

		foreach (self::$routes as $pattern => $callback)
		{
			if (preg_match($pattern, $url, $params))
			{
				array_shift($params);
				return call_user_func_array($callback, array_values($params));
			}
		}

		header("HTTP/1.1 404 Not Found");
		return false;
	}
}