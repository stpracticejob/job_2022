<!DOCTYPE html>
<html>

<head>
    <?php include('head.inc.php'); ?>
    <title><?= $title ?? '' ?></title>
</head>

<body class="d-flex flex-column h-100">
    <? include('user_menu.inc.php'); ?>

    <main role="main" class="flex-shrink-0">
        <div class="container text-center">
            <h1 class="h3 mt-5"><?= $header ?? '' ?></h1>
            <p><?= $message ?? '' ?></p>
            <?php if (isset($url)): ?>
            <a href="<?= $url ?>" type="button" class="btn btn-primary">
                <?= $button_label ?? 'Перейти' ?>
            </a>
            <?php endif ?>
        </div>
    </main>
    <? include('footer.inc.php'); ?>
</body>

</html>
