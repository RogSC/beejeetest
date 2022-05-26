<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Models\User;

/**
 * Class UserController
 * @package App\Controllers
 */
class UserController extends Controller
{
	public function __construct()
	{
		$this->model = new User();

		parent::__construct();
	}

	public function auth()
	{
		$this->data['login'] = htmlspecialchars($_POST['login']);
		$this->data['pass'] = htmlspecialchars($_POST['pass']);

		if ($_POST['login'] && $_POST['pass'])
		{
			$this->data['error'] = $this->enter();
		}

		$this->view->generate('auth', $this->data);
	}

	public function enter()
	{
		//TODO: Session security

		if ($_POST['login'] != "" && $_POST['pass'] != "")
		{
			$login = htmlspecialchars($_POST['login']);
			$password = htmlspecialchars($_POST['pass']);

			$user = current($this->model->where(['login' => $login])->get());

			if ($user)
			{
				if (md5($password) == $user['pass'])
				{
					$_SESSION['id'] = $user['id'];
					header('Location: http://'.$_SERVER['HTTP_HOST'].'/');
				}
				else
				{
					return "Неверный пароль";
				}
			}
			else
			{
				return "Неверный логин и пароль";
			}
		}
		else
		{
			return "Поля не должны быть пустыми!";
		}
	}

	public static function login()
	{
		return isset($_SESSION['id']);
	}

	public static function isAdmin()
	{
		return isset($_SESSION['id']) && $_SESSION['id'] == 1;
	}

	public static function out()
	{
		unset($_SESSION['id']);
		header('Location: http://'.$_SERVER['HTTP_HOST'].'/');
	}
}