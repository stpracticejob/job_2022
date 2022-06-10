<!DOCTYPE html>
<html>

<head>
    <? include('head.inc.php'); ?>
    <title>Регистрация</title>
</head>

<body class="d-flex flex-column h-100">
    <? include('user_menu.inc.php'); ?>
    <main role="main">
        <div class="container d-flex justify-content-center mt-5 mb-5">
            <div class="col-5">
                <h1 class="h3">Регистрация</h1>
                <form method="post" class="">
                    <div class="form-group">
                        <label for="fullnameId">Ваше имя:</label>
                        <input type="text" class="form-control <?= isset($errors['fullname']) ? 'is-invalid' : '' ?>"
                            name="fullname" id="fullnameId" aria-describedby="fullnameHelpId" placeholder=""
                            value="<?= $form_fields['fullname'] ?? '' ?>" />
                        <small id="fullnameHelpId" class="form-text text-muted">
                            Ваше полное фамилия, имя и отчество.
                        </small>
                        <div id="invalid_fullname" class="invalid-feedback">
                            <?= $errors['fullname'] ?? '' ?>
                        </div>

                        <label for="emailId">E-mail:</label>
                        <input type="text" class="form-control <?= isset($errors['email']) ? 'is-invalid' : '' ?>"
                            name="email" id="email" aria-describedby="emailHelpId" placeholder=""
                            value="<?= $form_fields['email'] ?? '' ?>">
                        <small id="emailHelpId" class="form-text text-muted">
                            Ваш e-mail который будет использоваться как логин.
                        </small>
                        <div id="invalid_email" class="invalid-feedback">
                            <?= $errors['email'] ?? '' ?>
                        </div>

                        <label for="passwordId">Пароль:</label>
                        <input type="password"
                            class="form-control <?= isset($errors['password']) ? 'is-invalid' : '' ?>" name="password"
                            id="password" aria-describedby="passwordHelpId"
                            value="<?= $form_fields['password'] ?? '' ?>" placeholder="">
                        <small id="passwordHelpId" class="form-text text-muted">
                            Ваш пароль для логина.
                        </small>
                        <div id="invalid_password" class="invalid-feedback">
                            <?= $errors['password'] ?? '' ?>
                        </div>

                        <label for="password2Id">Подтверждение пароля:</label>
                        <input type="password"
                            class="form-control <?= isset($errors['password2']) ? 'is-invalid' : '' ?>" name="password2"
                            id="password2" aria-describedby="password2HelpId" placeholder="">
                        <small id="password2HelpId" class="form-text text-muted">
                            Ваш пароль для подтверждения.
                        </small>
                        <div id="invalid_password2" class="invalid-feedback">
                            <?= $errors['password2'] ?? '' ?>
                        </div>

                        <label>Роль:</label>
                        <?php foreach ($db->getUserRoles()->fetchAll() as $role): ?>
                        <div class="form-check">
                            <label class="form-check-label">
                                <input type="radio" class="form-check-input" name="roleId" value="<?= $role['ID'] ?>"
                                    checked="<?= isset($form_fields['roleId']) && $form_fields['roleId'] == $role['ID'] ? 'checked' : '' ?>">
                                <?= $role['Name'] ?>
                            </label>
                        </div>
                        <?php endforeach ?>

                        <div id="invalid_roleId" class="invalid-feedback">
                            <?= $errors[''] ?? '' ?>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">
                        Зарегистрировать
                    </button>
                </form>
            </div>
        </div>
    </main>
    <? include('footer.inc.php'); ?>
</body>

</html>
