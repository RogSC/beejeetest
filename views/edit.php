<form action="" method="post" class="row mb-4 mt-4 needs-validation" novalidate>
    <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Редактирование задачи</h5>
    </div>
    <div class="modal-body">
		<?if ($error) {?>
            <div class="text-danger">
				<?=$error?>
            </div>
		<?}?>

        <div class="mb-3">
            <label for="name" class="form-label">Имя пользователя</label>
            <div class="input-group has-validation">
                <input type="text" class="form-control" name="name" value="<?=htmlspecialchars($task['user_name'])?>"
                       id="name" required>
                <div class="invalid-feedback">
                    Введите имя
                </div>
            </div>
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <div class="input-group has-validation">
                <input type="email" class="form-control" name="email" value="<?=htmlspecialchars($task['user_email'])?>"
                       id="email" required>
                <div class="invalid-feedback">
                    Введите email
                </div>
            </div>
        </div>

        <div class="mb-3">
            <label for="descr" class="form-label">Описание задачи</label>
            <div class="input-group has-validation">
                <input type="text" class="form-control" name="descr" value="<?=htmlspecialchars($task['descr'])?>"
                       id="descr" required>
                <div class="invalid-feedback">
                    Введите описание
                </div>
            </div>
        </div>

        <div class="mb-3 form-check">
            <input type="checkbox" class="form-check-input" name="completed"
                   id="completed" <?=$task['completed'] ? 'checked' : ''?>>
            <label class="form-check-label" for="completed">Задача выполнена</label>
        </div>

    </div>
    <div class="modal-footer">
        <button type="submit" class="btn btn-primary">Сохранить</button>
    </div>
</form>