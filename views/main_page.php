<!DOCTYPE html>
<html>
	<head>
		<title></title>
		<link rel="stylesheet" href="/css/style.css"/>
        <meta charset="utf-8" /> 
		<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
		<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
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
		<?include('footer.inc');?>	
	</body>
</html>