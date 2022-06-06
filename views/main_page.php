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
				<div class="col-md-4 col-lg-4 col-sm-12">
					<div class="card">
						<?foreach ($db->lastVC1() as $item):?>
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
						<?endforeach;?>
					</div>
				</div>
				<div class="col-md-4 col-lg-4 col-sm-12">
					<div class="card">
					<?foreach ($db->lastVC2() as $item):?>
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
							data-target="#exampleModalCenter2">Подробности</button>
						</div>
					<?endforeach;?>
					</div>
				</div>
				<div class="col-md-4 col-lg-4 col-sm-12">
					<div class="card">
					<?foreach ($db->lastVC3() as $item):?>
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
							data-target="#exampleModalCenter3">Подробности</button>
						</div>
					<?endforeach;?>
					</div>
				</div>
				</div>
			</div>
		</div>
				<h1>Реклама</h1>

				<?foreach ($db->fetchAdvertises() as $item):?>

					<h2><?=$item['Title'] ?></h2>
					<?=$item['Content'] ?>
					<hr/>
				<?endforeach;?>

				</table>
		<?include('footer.inc');?>


<!-- Modal -->
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
				<?foreach ($db->lastVC1() as $item):?>
                <h3>Категория: <?=$item['SectionName'] ?></3><hr/>
				<h4>Должность: <?=$item['Title'] ?></h4><hr/>
				<h5>Описание: <?=$item['Content'] ?></h5><hr/>
				<h3>Требуемый опыт работы: <?=$item['Experience'] ?></h3><hr/>
				<h3>Зарплата: <?=$item['Salary'] ?></h3>
				<hr/>
				Дата публикации вакансии: <?=$item['DateTime'] ?>
				<?endforeach;?>
			  </div>
			  <div class="modal-footer">
				<a href="/vacancy" class="card-link">Страница с Вакансиями</a>
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
			  </div>
			</div>
		  </div>
		</div>
		<div class="modal fade" id="exampleModalCenter2" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
		  <div class="modal-dialog modal-dialog-centered" role="document">
			<div class="modal-content">
			  <div class="modal-header">
				<h4 class="modal-title" id="exampleModalLongTitle">   Подробная информация относительно вакансии     </h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				  <span aria-hidden="true">&times;</span>
				</button>
			  </div>
			  <div class="modal-body">
				<?foreach ($db->lastVC2() as $item):?>
				<h3>Категория: <?=$item['SectionName'] ?></3><hr/>
				<h4>Должность: <?=$item['Title'] ?></h4><hr/>
				<h5>Описание: <?=$item['Content'] ?></h5><hr/>
				<h3>Требуемый опыт работы: <?=$item['Experience'] ?></h3><hr/>
				<h3>Зарплата: <?=$item['Salary'] ?></h3>
				<hr/>
				Дата публикации вакансии: <?=$item['DateTime'] ?>
				<?endforeach;?>
			  </div>
			  <div class="modal-footer">
				<a href="/vacancy" class="card-link">Страница с Вакансиями</a>
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
			  </div>
			</div>
		  </div>
		</div>
		<div class="modal fade" id="exampleModalCenter3" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
		  <div class="modal-dialog modal-dialog-centered" role="document">
			<div class="modal-content">
			  <div class="modal-header">
				<h4 class="modal-title" id="exampleModalLongTitle">Подробная информация относительно вакансии</h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				  <span aria-hidden="true">&times;</span>
				</button>
			  </div>
			  <div class="modal-body">
				<?foreach ($db->lastVC3() as $item):?>
                <h3>Категория: <?=$item['SectionName'] ?></3><hr/>
				<h4>Должность: <?=$item['Title'] ?></h4><hr/>
				<h5>Описание: <?=$item['Content'] ?></h5> <hr/>
				<h3>Требуемый опыт работы: <?=$item['Experience'] ?></h3><hr/>
				<h3>Зарплата: <?=$item['Salary'] ?></h3>
				<hr/>
				Дата публикации вакансии: <?=$item['DateTime'] ?>
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
