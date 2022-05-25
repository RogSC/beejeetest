<?php
namespace App\Database;

use PDO;

class Connection
{
	protected $pdo;

	function __construct(){
		require_once $_SERVER['DOCUMENT_ROOT'].'config.php';

		$opt = [
			PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
			PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
		];
		$this->pdo = new PDO("mysql:host=localhost;dbname=".DB_NAME,DB_LOGIN,DB_PASS, $opt);
		$this->pdo->exec("SET CHARSET utf8");
	}
}