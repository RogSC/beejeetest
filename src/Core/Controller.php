<?php
namespace App\Core;

/**
 * Class Controller
 * @package App\Core
 */
class Controller
{
	public Model $model;
	public View $view;

	protected array $data;

	public function __construct()
	{
		$this->view = new View();

		if (isset($_REQUEST['sort']))
		{
			$_SESSION['sort'] = $_REQUEST['sort'];
		}

		if (isset($_REQUEST['type']))
		{
			$_SESSION['type'] = $_REQUEST['type'];
		}

		if (isset($_REQUEST['page']))
		{
			$_SESSION['page'] = $_REQUEST['page'];
		}
	}
}