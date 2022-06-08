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
                                    data-target="#modalAdvertises<?= $item['ID'] ?>">Подробности</button>
                            </div>
                        </div>
                    </div>
                    <?endforeach;?>
                </div>
            </div>
        </div>

        <?foreach ($advertises as $item):?>
        <div class="modal fade" id="modalAdvertises<?= $item['ID'] ?>" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
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
                        Дата публикации вакансии: <?= $item['DateTime'] ?>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
                    </div>
                </div>
            </div>
		</div>
        <?endforeach;?>

        <?php $cvs = $db->fetchCvs(false, 3)->fetchAll(); ?>
        <div>
			<div class="container">
			    <h1 class="text-center">Последние Резюме</h1>
				<div class="row">
                    <?foreach ($cvs as $item):?>
                    <div class="col-md-4 col-lg-4 col-sm-12">
                        <div class="card">
                            <div class="card-header">
                                Категория: <?=$item['SectionName'] ?>
                            </div>
                            <div class="card-body">
                                <h4 class="card-title"><?=$item['Title'] ?></h4>
                                <p class="card-text">
                                    <?=$item['UserName'] ?>
                                </p>
                            </div>
                            <div class="card-footer">
                                <button type="button" class="btn btn-primary" data-toggle="modal"
                                    data-target="#modalCv<?= $item['ID'] ?>">Подробности</button>
                            </div>
                        </div>
                    </div>
                    <?endforeach;?>
                </div>

                <h1 class="text-center">Последние Вакансии</h1>
				<div class="row">
                    <?php $Vacancies = $db->fetchVacancies(false, 3)->fetchAll(); ?>
                    <?foreach ($Vacancies as $item):?>
                        <div class="col-md-4 col-lg-4 col-sm-12">
                        <div class="card">
                            <div class="card-header">
                                Категория: <?=$item['SectionName'] ?>
                            </div>
                            <div class="card-body">
                                <h4 class="card-title"><?=$item['Title'] ?></h4>
                                <p class="card-text">
                                    <h2>Зарплата: <?=$item['Salary'] ?> </h2>
                                    <hr/>
									Дата публикации: <?=$item['DateTime'] ?>
                                </p>
                            </div>
                            <div class="card-footer">
                                <button type="button" class="btn btn-primary" data-toggle="modal"
                                    data-target="#modalVacancy<?= $item['ID'] ?>">Подробности</button>
                            </div>
                        </div>
                    </div>
                    <?endforeach;?>
                </div>
            </div>
        </div>
        <?foreach ($cvs as $item):?>
        <div class="modal fade" id="modalCv<?= $item['ID'] ?>" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Вакансия</h4>
                        <button type="button" class="close" data-dismiss="modal">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        Категория: <?= $item['SectionName'] ?><br>
                        Должность: <?= $item['Title'] ?><br>
                        Описание: <?= $item['Content'] ?><br>
                        Пользователь: <?= $item['UserName'] ?><br>
                        Дата публикации вакансии: <?= $item['DateTime'] ?>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
                    </div>
                </div>
            </div>
		</div>
        <?endforeach;?>

        <?foreach ($Vacancies as $item):?>
        <div class="modal fade" id="modalVacancy<?= $item['ID'] ?>" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Вакансия</h4>
                        <button type="button" class="close" data-dismiss="modal">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        Категория: <?= $item['SectionName'] ?><br>
                        Должность: <?= $item['Title'] ?><br>
                        Описание: <?= $item['Content'] ?><br>
                        Зарплата: <?= $item['Salary'] ?><br>
                        Требуемый опыт работы: <?= $item['Experience'] ?><br><hr/>
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
