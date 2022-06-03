<!DOCTYPE html>
<html>
	<head>
		<title></title>
		
		
		
		<link rel="stylesheet" href="/css/style.css"/>
<<<<<<< HEAD
        <meta charset="utf-8" /> 
		<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
		<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
		
		
=======
		<meta charset="utf-8" /> 
		<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
		<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
		<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
		<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
>>>>>>> master
	</head>
	<body>
	
<!-- Реклама -->
		<?include('user_menu.inc');?>
<<<<<<< HEAD
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
=======
			<h1>Реклама</h1>
			
			<?foreach ($db->fetchAdvertises() as $item):?>
			
				<h2><?=$item['Title'] ?></h2>
				<?=$item['Content'] ?>
				<hr/>
			<?endforeach;?>
			</table>
>>>>>>> master
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
				<h4>Категория: <?=$item['SectionName'] ?></h4>
				<h3>Должность:</h3> </br>
					<h4><?=$item['Title'] ?></h4>
				<h3>Описание: </h3> </br> 
					<h4><?=$item['Content'] ?></h4>
				<h3>Требуемый опыт работы: <?=$item['Experience'] ?></h3>
				<h3>Зарплата: <?=$item['Salary'] ?></h3>
				<hr/>
				Дата публикации вакансии: <?=$item['DateTime'] ?>
				<?endforeach;?>
			  </div>
			  <div class="modal-footer">
				<a href="/views/vacancy" class="card-link">Страница с Вакансиями</a>
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
				<h4>Категория: <?=$item['SectionName'] ?></h4>
				<h3>Должность:</h3> </br>
					<h4><?=$item['Title'] ?></h4>
				<h3>Описание: </h3> </br> 
					<h4><?=$item['Content'] ?></h4>
				<h3>Требуемый опыт работы: <?=$item['Experience'] ?></h3>
				<h3>Зарплата: <?=$item['Salary'] ?></h3>
				<hr/>
				Дата публикации вакансии: <?=$item['DateTime'] ?>
				<?endforeach;?>
			  </div>
			  <div class="modal-footer">
				<a href="/views/vacancy" class="card-link">Страница с Вакансиями</a>
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
				<h4>Категория: <?=$item['SectionName'] ?></h4>
				<h3>Должность:</h3> </br>
					<h4><?=$item['Title'] ?></h4>
				<h3>Описание: </h3> </br> 
					<h4><?=$item['Content'] ?></h4>
				<h3>Требуемый опыт работы: <?=$item['Experience'] ?></h3>
				<h3>Зарплата: <?=$item['Salary'] ?></h3>
				<hr/>
				Дата публикации вакансии: <?=$item['DateTime'] ?>
				<?endforeach;?>
			  </div>
			  <div class="modal-footer">
				<a href="/views/vacancy" class="card-link">Страница с Вакансиями</a>
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
			  </div>
			</div>
		  </div>
		</div>
	</body>
<<<<<<< HEAD
	
</html>
=======
</html>
>>>>>>> master
