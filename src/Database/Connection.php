<?php
namespace App\Database;

use PDO;

/**
 * Class Connection
 * @package App\Database
 */
class Connection
{
	protected PDO $pdo;
	protected string $sqlQuery;
	protected string $type;

	public static array $instances;

	private function __construct()
	{
		require_once $_SERVER['DOCUMENT_ROOT'].'config.php';

		$opt = [
			PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
			PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
		];
		$this->pdo = new PDO("mysql:host=localhost;dbname=".DB_NAME,DB_LOGIN,DB_PASS, $opt);
		$this->pdo->exec("SET CHARSET utf8");
	}

	private function __clone() {}
	public function __wakeup()
	{
		throw new \Exception("Cannot unserialize a singleton.");
	}

	/**
	 * @return static
	 */
	public static function getInstance(): static
	{
		$cls = static::class;
		if (!isset(self::$instances[$cls])) {
			self::$instances[$cls] = new static();
		}

		return self::$instances[$cls];
	}

	/**
	 * @param string $table
	 * @return $this
	 */
	public function select(string $table): static
	{
		$this->sqlQuery = "SELECT * FROM `$table` ";

		return $this;
	}

	/**
	 * @param array $where
	 * @param string $op
	 * @return $this
	 */
	public function where(array $where, string $op = '='): static
	{
		$values = [];
		foreach ($where as $k => $v)
		{
			$values[] = "`$k` $op '$v'";
		}

		$str = implode(' AND ', $values);
		$this->sqlQuery .= " WHERE " . $str;

		return $this;
	}

	/**
	 * @param string $val
	 * @param string $type
	 * @return $this
	 */
	public function orderBy(string $val, string $type): static
	{
		$this->sqlQuery .= "ORDER BY `$val` $type";

		return $this;
	}

	/**
	 * @param int $limit
	 * @param int $offset
	 * @return $this
	 */
	public function limit(int $limit, int $offset = 0): static
	{
		if ($offset)
		{
			$resStr = $offset . "," . $limit;
		}
		else
		{
			$resStr = $limit;
		}

		$this->sqlQuery .= " LIMIT " . $resStr;

		return $this;
	}

	/**
	 * @param string $table
	 * @return $this
	 */
	public function insert(string $table): static
	{
		$this->sqlQuery = "INSERT INTO `$table` ";
		$this->type = 'insert';

		return $this;
	}

	/**
	 * @param string $table
	 * @return $this
	 */
	public function update(string $table): static
	{
		$this->sqlQuery = "UPDATE `$table` ";
		$this->type = 'update';

		return $this;
	}

	/**
	 * @param array $values
	 * @return $this
	 */
	public function values(array $values): static
	{
		$cols = [];
		$masks = [];
		$valuesForUpdate = [];

		foreach($values as $k => $value)
		{
			$valueKey = explode(' ', $k);
			$valueKey = $valueKey[0];
			$cols[] = "`$valueKey`";
			$masks[] = "'".$value."'";

			$valuesForUpdate[] = "`$valueKey`='$value'";
		}

		if ($this->type == "insert")
		{
			$colsAll = implode(',', $cols);
			$masksAll = implode(',', $masks);
			$this->sqlQuery .= "($colsAll) VALUES ($masksAll)";
		}
		else if ($this->type == 'update')
		{
			$this->sqlQuery .= " SET ";
			$this->sqlQuery .= implode(',', $valuesForUpdate);
		}

		return $this;
	}

	/**
	 * @param string $table
	 * @return $this
	 */
	public function delete(string $table): static
	{
		$this->sqlQuery = "DELETE FROM `$table`";
		$this->type = 'delete';

		return $this;
	}

	/**
	 * @return array
	 */
	public function execute(): array
	{
		$q = $this->pdo->prepare($this->sqlQuery);
		$q->execute();

		if ($q->errorCode() != PDO::ERR_NONE)
		{
			$info = $q->errorInfo();
			die($info[2]);
		}

		return $q->fetchall();
	}
}