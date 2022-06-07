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

			<?foreach ($db->fetchAdvertises(false, 3) as $item):?>

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
                <?foreach ($db->fetchVacancies(false, 3) as $item):?>
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
    <?foreach ($db->fetchVacancies(false, 3) as $item):?>
        <div class="modal fade" id="exampleModalCenter1" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
		  <div class="modal-dialog modal-dialog-centered" role="document">
			<div class="modal-content">
			  <div class="modal-header">
				<h4 class="modal-title" id="exampleModalLongTitle">   Подробная информация относительно вакансии     </h4>
				<button type="button" class="close" data-dismiss="modal" aria-label=
				"Close">
				  <span aria-hidden="true">&times;</span>
				</button>
			  </div>
			  <div class="modal-body">
                <h5>Категория: <?=$item['SectionName'] ?></5>
				<h5>Должность: <?=$item['Title'] ?></h5>
				<h5>Описание: <?=$item['Content'] ?></h5>
				<h5>Требуемый опыт работы: <?=$item['Experience'] ?></h5>
				<h3>Зарплата: <?=$item['Salary'] ?> </br>
				<h5>Дата публикации вакансии: <?=$item['DateTime'] ?></h5><hr/>
			  </div>
			  <div class="modal-footer">
				<a href="/views/vacancy" class="card-link">Страница с Вакансиями</a>
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
			  </div>
			</div>
		  </div>
		</div>
    <?endforeach;?>
	</body>
</html>
