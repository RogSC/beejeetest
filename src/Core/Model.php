<?php
namespace App\Core;

use App\Database\Connection;

class Model
{
	protected Connection $db;
	protected string $tableName;

	protected array $where = [];
	protected array $order = ['id' => 'asc'];
	protected array $limit = [3];

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
		$dbExec = $this->db->select($this->tableName);

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
			$dbExec->limit($this->limit[0], isset($this->limit[1]) ? $this->limit[1] : 0);
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

		return current($this->get());
	}

	/**
	 * @param array $values
	 */
	public function add(array $values)
	{
		$this->db->insert($this->tableName)->values($values)->execute();
	}

	/**
	 * @param int $id
	 * @param array $values
	 */
	public function update(int $id, array $values)
	{
		$this->db->update($this->tableName)->values($values)->where(['id' => $id])->execute();
	}
}