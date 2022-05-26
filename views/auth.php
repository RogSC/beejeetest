<form action="/auth" method="post" class="row mb-4 mt-4 needs-validation" novalidate>
	<div class="modal-header">
		<h5 class="modal-title" id="exampleModalLabel">Авторизация</h5>
	</div>
	<div class="modal-body">
		<?if ($error) {?>
			<div class="text-danger">
				<?=$error?>
			</div>
		<?}?>

		<div class="mb-3">
			<label for="login" class="form-label">Login</label>
			<div class="input-group has-validation">
				<input type="text" class="form-control" name="login" value="<?=$login?>" id="login" required>
				<div class="invalid-feedback">
					Введите логин
				</div>
			</div>
		</div>

		<div class="mb-3">
			<label for="pass" class="form-label">Password</label>
			<div class="input-group has-validation">
				<input type="password" class="form-control" name="pass" value="<?=$pass?>" id="pass" required>
				<div class="invalid-feedback">
					Введите пароль
				</div>
			</div>

		</div>
	</div>
	<div class="modal-footer">
		<button type="submit" class="btn btn-primary">Войти</button>
	</div>
</form>