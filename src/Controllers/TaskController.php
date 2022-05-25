<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\Task;

class TaskController extends Controller
{
	public function __construct()
	{
		$this->model = new Task();

		parent::__construct();
	}

	public function index()
	{
		$data['tasks'] = $this->model->get();
		$this->view->generate('list', $data);
	}

	public function update($id)
	{
		$data = $this->model->getById($id);
		$this->view->generate('edit', $data);
	}
}