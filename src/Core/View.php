<?php
namespace App\Core;

/**
 * Class View
 * @package App\Core
 */
class View
{
	public function generate($contentView, $data = [], $templateView = 'main')
	{
		if(is_array($data)) {
			extract($data);
		}

		include 'views/'.$templateView.'.php';
	}
}