<div class="table-responsive">
    <table class="table table-striped table-sm">
        <thead>
        <tr>
            <?foreach ($fields as $field) {?>
                <th scope="col">
                    <?if ($field['sortable']) {?>
                    <a href="?sort=<?=$field['id']?>&type=asc"><i class="fa fa-angle-double-up"></i></a>
                        <?=htmlspecialchars($field['name'])?>
                    <a href="?sort=<?=$field['id']?>&type=desc"><i class="fa fa-angle-double-down"></i></a>
                    <?} else {?>
                        <?=htmlspecialchars($field['name'])?>
                    <?}?>
                </th>
			<?}?>
        </tr>
        </thead>
        <tbody>
            <?foreach ($tasks as $task) {?>
                <tr>
                    <td><?=$task['id']?></td>
                    <td><?=htmlspecialchars($task['user_name'])?></td>
                    <td><?=htmlspecialchars($task['user_email'])?></td>
                    <td><?=htmlspecialchars($task['descr'])?></td>
                    <td><?=$task['completed'] ? '<i class="fa fa-check"></i>' : '<i class="fa fa-xmark"></i>'?></td>
                    <td><?=$task['admin_edit'] ? '<i class="fa fa-check"></i>' : '<i class="fa fa-xmark"></i>'?></td>

                    <?if ($isAdmin) {?>
                        <td><a href="/update/<?=$task['id']?>"><i class="fa fa-pen-to-square"></i></a></td>
					<?}?>
                </tr>
            <?}?>
        </tbody>
    </table>
</div>

<?if ($pages > 1) {?>
<nav aria-label="Page navigation example">
    <ul class="pagination">
        <li class="page-item <?=$page == 1 ? 'disabled' : ''?>">
            <a class="page-link" href="?page=<?=$page - 1?>" aria-label="Previous">
                <span aria-hidden="true">&laquo;</span>
            </a>
        </li>
        <?for ($i = 1; $i <= $pages; $i++) {?>
            <li class="page-item <?=$page == $i ? 'active' : ''?>"><a class="page-link" href="?page=<?=$i?>"><?=$i?></a></li>
		<?}?>
        <li class="page-item <?=$page == $pages ? 'disabled' : ''?>">
            <a class="page-link" href="?page=<?=$page + 1?>" aria-label="Next">
                <span aria-hidden="true">&raquo;</span>
            </a>
        </li>
    </ul>
</nav>
<?}?>

<form action="/" method="post" class="row mb-4 mt-4 needs-validation" novalidate>
    <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Новая задача</h5>
    </div>
    <div class="modal-body">
		<?if ($success) {?>
            <div class="text-success">
				Задача успешно создана!
            </div>
		<?}?>

        <div class="mb-3">
            <label for="name" class="form-label">Имя пользователя</label>
            <div class="input-group has-validation">
                <input type="text" class="form-control" name="name" id="name" required>
                <div class="invalid-feedback">
                    Введите имя
                </div>
            </div>
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <div class="input-group has-validation">
                <input type="email" class="form-control" name="email" id="email" required>
                <div class="invalid-feedback">
                    Введите корректный email
                </div>
            </div>
        </div>

        <div class="mb-3">
            <label for="descr" class="form-label">Описание задачи</label>
            <div class="input-group has-validation">
                <input type="text" class="form-control" name="descr" id="descr" required>
                <div class="invalid-feedback">
                    Введите описание
                </div>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="submit" class="btn btn-primary">Создать задачу</button>
    </div>
</form>