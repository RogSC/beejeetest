<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\Task;

/**
 * Class TaskController
 * @package App\Controllers
 */
class TaskController extends Controller
{
	public function __construct()
	{
		$this->model = new Task();

		$this->data['isLogin'] = UserController::login();
		$this->data['isAdmin'] = UserController::isAdmin();

		parent::__construct();
	}

	public function index()
	{
		//TODO: Request controller

		if (isset($_POST['name']) && isset($_POST['email']) && isset($_POST['descr']))
		{
			$this->data['success'] = $this->add();
		}

		if ($_SESSION['sort'])
		{
			$this->model->order($_SESSION['sort'], $_SESSION['type']);
		}

		if ($_SESSION['page'])
		{
			$this->model->limit([3, ($_SESSION['page'] - 1) * 3]);
		}

		$this->data['fields'] = $this->model->getFields();
		$this->data['tasks'] = $this->model->get();

		$count = $this->model->getCount();
		$this->data['pages'] = ceil($count / 3);
		$this->data['page'] = isset($_SESSION['page']) ? $_SESSION['page'] : 1;

		$this->view->generate('list', $this->data);
	}

	private function add()
	{
		$fields = [
			'user_name' => $_POST['name'],
			'user_email' => $_POST['email'],
			'descr' => $_POST['descr']
		];

		$this->model->add($fields);

		return true;
	}

	public function update($id)
	{
		if (isset($_POST['name']) && isset($_POST['email']) && isset($_POST['descr']))
		{
			if (UserController::isAdmin())
			{
				$fields = [
					'user_name' => $_POST['name'],
					'user_email' => $_POST['email'],
					'descr' => $_POST['descr']
				];

				$task = $this->model->getById($id);

				if ($_POST['descr'] != $task['descr'])
				{
					$fields['admin_edit'] = 1;
				}

				if (isset($_POST['completed']))
				{
					$fields['completed'] = 1;
				}

				$this->model->update($id, $fields);
				header('Location: http://'.$_SERVER['HTTP_HOST'].'/');
			}
			else
			{
				$this->data['error'] = 'Вы не авторизованы';
			}
		}

		$this->data['task'] = $this->model->getById($id);
		$this->view->generate('edit', $this->data);
	}
}