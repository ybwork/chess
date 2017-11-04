<?php require ROOT . '/views/layouts/header.php'; ?>

<div class="home-login">
	<div class="grid-content">
		<form class="common-ajax-form" action="/login/user" method="POST">
			<img src="/public/image/logo/inpk_logo.svg">

			<div class="login-field-group">
				<img src="/public/image/icon/login/user.png">
				<input type="text" name="login" placeholder="Логин" value="">
			</div>
		
			<div class="login-field-group">
				<img src="/public/image/icon/login/password.png">
				<input type="password" name="password" placeholder="Пароль" value="">
			</div>

			<button type="submit" name="submit">Войти</button>
		</form>
	</div>
</div>
<?php require ROOT . '/views/layouts/footer.php'; ?>