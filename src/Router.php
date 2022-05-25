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
	 * @param string $url
	 * @return mixed
	 */
	public static function execute(string $url): mixed
	{
		foreach (self::$routes as $pattern => $callback)
		{
			if (preg_match($pattern, $url, $params))
			{
				array_shift($params);
				return call_user_func_array($callback, array_values($params));
			}
		}
	}
}