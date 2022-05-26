<?php
namespace App\Models;

use App\Controllers\UserController;
use App\Core\Model;

/**
 * Class Task
 * @package App\Models
 */
class Task extends Model
{
	protected string $tableName = 'task';

	/**
	 * @return array[]
	 */
	public function getFields(): array
	{
		$fields = [
			[
				'id' => 'id',
				'name' => 'ID',
				'sortable' => true,
			],
			[
				'id' => 'user_name',
				'name' => 'Имя пользователя',
				'sortable' => true,
			],
			[
				'id' => 'user_email',
				'name' => 'Email',
				'sortable' => true,
			],
			[
				'id' => 'desc',
				'name' => 'Текст задачи',
				'sortable' => false,
			],
			[
				'id' => 'completed',
				'name' => 'Статус',
				'sortable' => true,
			],
			[
				'id' => 'admin_edit',
				'name' => 'Отредактировано администратором',
				'sortable' => false,
			],
		];

		if (UserController::isAdmin())
		{
			$fields[] = [
				'id' => 'edit',
				'name' => 'Редактировать',
				'sortable' => false,
			];
		}

		return $fields;
	}
}