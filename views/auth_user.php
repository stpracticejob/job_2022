<!DOCTYPE html>
<html>
	<head></head>
	<body>
		<h1>Вход в учётную запись</h1>
		<form action="/login" method="POST">
			<b>Логин:</b><br/>
			<input name="user_login" type="text" size="15"/><br/>
			<b>Пароль:</b><br/>
			<input name="user_password" type="password" size="15"/><br/>
			<div style="color:#FF0000;padding: 10px 0;">
			<?=$error ?? '' ?>
			</div>
			<input name="Enter" type="Submit"/><br/>
		</form>
	</body>
</html>