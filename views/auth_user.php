<!DOCTYPE html>
<html>
	<head>
		<? include("head.inc.php"); ?>
	</head>
	<body class="d-flex flex-column h-100">
		<? include('user_menu.inc.php'); ?>

        <main role="main" class="flex-shrink-0">
            <h1 class="h3 mt-5 text-center">Вход в учётную запись</h1>
            <div class="container text-center col-md-3">
                <form action="/login" method="POST" class="<?= isset($error) ? 'was-validated' : '' ?>">

                    <div class="form-group">
                        <label for="user_login">Логин</label>
                        <input class="form-control" name="user_login"
                            id="user_login" type="text" placeholder="Логин" required/>

                        <label for="user_password">Пароль</label>
                        <input class="form-control" name="user_password"
                            type="password" placeholder="Пароль" required/>

                        <div id="invalid_password" class="invalid-feedback">
                            <?=$error ?? ''?>
                        </div>

                    </div>

                    <input class="btn btn-primary" name="Enter" type="submit"/>
                </form>
            </div>
        </main>
        <? include('footer.inc.php'); ?>
	</body>
</html>
