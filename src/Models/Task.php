<?php
namespace App\Models;

use App\Database\Connection;

class Task
{
	protected $db;

	protected $where;
	protected $order = ['id', 'asc'];
	protected $limit = [0, 3];

	public function __construct()
	{
		$this->db = Connection::getInstance();
	}

	/**
	 * @param array $values
	 * @return $this
	 */
	public function where(array $values): static
	{
		$this->where = $values;

		return $this;
	}

	/**
	 * @param array $values
	 * @return $this
	 */
	public function order(array $values): static
	{
		$this->order = $values;

		return $this;
	}

	/**
	 * @param array $values
	 * @return $this
	 */
	public function limit(array $values): static
	{
		$this->limit = $values;

		return $this;
	}

	/**
	 * @return array
	 */
	public function get(): array
	{
		$dbExec = $this->db->select('task');

		if ($this->where)
		{
			$dbExec->where($this->where);
		}

		if ($this->order)
		{
			$dbExec->orderBy(key($this->order), current($this->order));
		}

		if ($this->limit)
		{
			$dbExec->limit($this->limit[0], $this->limit[1]);
		}

		return $dbExec->execute();
	}

	/**
	 * @param $id
	 * @return array
	 */
	public function getById(int $id): array
	{
		$this->where(['id' => $id]);

		return $this->get();
	}

	/**
	 * @param array $values
	 */
	public function add(array $values)
	{
		$this->db->insert('task')->values($values)->execute();
	}

	/**
	 * @param int $id
	 * @param array $values
	 */
	public function update(int $id, array $values)
	{
		$this->db->update('task')->values($values)->where(['id' => $id])->execute();
	}
}