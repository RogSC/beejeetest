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
	 * @param string $fieldId
	 * @param string $sortType
	 * @return $this
	 */
	public function order(string $fieldId, string $sortType): static
	{
		if (!in_array($fieldId, $this->getSortableFields()))
		{
			$fieldId = 'id';
		}

		if ($sortType !== 'asc' && $sortType !== 'desc')
		{
			$sortType = 'asc';
		}

		$this->order = [$fieldId => $sortType];

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
	 * @return string
	 */
	public function getCount(): string
	{
		$dbExec = $this->db->selectCount($this->tableName);

		return current(current($dbExec->execute()));
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

	/**
	 * @return array
	 */
	public function getFields(): array
	{
		return [];
	}

	/**
	 * @return array
	 */
	public function getSortableFields(): array
	{
		$sortableFields = array_filter($this->getFields(), function ($field) {
			return $field['sortable'];
		});

		return array_map(function ($field) {
			return $field['id'];
		}, $sortableFields);
	}
}