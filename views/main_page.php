<!DOCTYPE html>
<html>
	<head>
		<title></title>
		<link rel="stylesheet" href="/css/style.css"/>
		<meta charset="utf-8" />
		<?include("head.inc");?>
	</head>
	<body>
		<?include('user_menu.inc');?>
		<?php $advertises = $db->fetchAdvertises(false, 3)->fetchAll(); ?>
        <div>
			<div class="container">
			    <h1 class="text-center">Последняя Реклама</h1>
				<div class="row">
                    <?foreach ($advertises as $item):?>
                    <div class="col-md-4 col-lg-4 col-sm-12">
                        <div class="card">
                            <div class="card-header">
                                Реклама
                            </div>
                            <div class="card-body">
                                <h4 class="card-title"><?=$item['Title'] ?></h4>
                                <p class="card-text">
                                    <?=$item['Content'] ?>
                                </p>
                            </div>
                            <div class="card-footer">
                                <button type="button" class="btn btn-primary" data-toggle="modal"
                                    data-target="#modalAdvertise<?= $item['ID'] ?>">Подробности</button>
                            </div>
                        </div>
                    </div>
                    <?endforeach;?>
                </div>
            </div>
        </div>
        <?foreach ($advertises as $item):?>
        <div class="modal fade" id="modalAdverises<?= $item['ID'] ?>" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Реклама</h4>
                        <button type="button" class="close" data-dismiss="modal">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        Заголовок: <?= $item['Title'] ?><br>
                        Описание: <?= $item['Content'] ?><br>
                        Пользователь: <?= $item['UserID'] ?><br>
                        Дата публикации вакансии: <?= $item['DateTime'] ?>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
                    </div>
                </div>
            </div>
		</div>
        <?endforeach;?>

		<?include('footer.inc');?>	
	</body>
</html>
