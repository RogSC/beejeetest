<?php
namespace App\Models;

use App\Database\Connection;

/**
 * Class User
 * @package App\Models
 */
class User
{
	protected $db;

	public function __construct()
	{
		$this->db = Connection::getInstance();
	}

	public function getById(int $id): array
	{
		return $this->db->select('user')->where(['id' => $id])->execute();
	}
}