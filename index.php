<?php

use App\Router;
use App\Controllers\TaskController;
use App\Controllers\UserController;

session_start();
error_reporting(E_ERROR);
require_once 'vendor/autoload.php';

Router::route('/', function () {
	(new TaskController())->index();
});

Router::route('/auth', function () {
	(new UserController())->auth();
});

Router::route('/out', function () {
	(new UserController())->out();
});

Router::route('/update/(\d+)', function ($id) {
	(new TaskController())->update($id);
});

Router::execute();