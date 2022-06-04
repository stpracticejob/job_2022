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
			<h1>Реклама</h1>

			<?foreach ($db->fetchAdvertises() as $item):?>

				<h2><?=$item['Title'] ?></h2>
				<?=$item['Content'] ?>
				<hr/>
			<?endforeach;?>
			</table>
            		<!-- Вакансии -->
            <div class="blog" id="blog">
                <div class="container">
                <h1 class="text-center">Последние Вакансии</h1>
                    <div class="row">
                     <?foreach ($db->fetchVacancies() as $item):?>
                        <div class="col-md-4 col-lg-4 col-sm-12">
                            <div class="card">
                                <div class="card-header">
                                    Категория: <?=$item['SectionName'] ?>
                                </div>
                                <div class="card-body">
                                    <h4 class="card-title">
                                        <h3><?=$item['Title'] ?></h3><hr/>
                                    <p class="card-text">
                                        <h2>Зарплата: <?=$item['Salary'] ?> </h2>
                                            <hr/>
                                        Дата публикации: <?=$item['DateTime'] ?>
                                    </p>
                                </div>
                                <div class="card-footer">
                                    <button type="button" class="btn btn-primary" data-toggle="modal"
                                        data-target="#exampleModalCenter1">Подробности</button>
                                </div>
                            </div>
                        </div>
                    <?endforeach;?>
                    </div>
                </div>
            </div>
		<?include('footer.inc');?>
        <div class="modal fade" id="exampleModalCenter1" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
		  <div class="modal-dialog modal-dialog-centered" role="document">
			<div class="modal-content">
			  <div class="modal-header">
				<h4 class="modal-title" id="exampleModalLongTitle">   Подробная информация относительно вакансий     </h4>
				<button type="button" class="close" data-dismiss="modal" aria-label=
				"Close">
				  <span aria-hidden="true">&times;</span>
				</button>
			  </div>
			  <div class="modal-body">
				<?foreach ($db->fetchVacancies() as $item):?>
				<h5>Категория: <?=$item['SectionName'] ?></h5>
				Должность:<?=$item['Title'] ?></br>
				Описание:<?=$item['Content'] ?></br>
				Требуемый опыт работы: <?=$item['Experience'] ?></br>
				<h3>Зарплата: <?=$item['Salary'] ?></h3></br>
				Дата публикации вакансии: <?=$item['DateTime'] ?><hr/>
				<?endforeach;?>
			  </div>
			  <div class="modal-footer">
				<a href="/vacancy" class="card-link">Страница с Вакансиями</a>
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
			  </div>
			</div>
		  </div>
		</div>
	</body>
</html>
