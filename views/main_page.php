<!DOCTYPE html>
<html>
	<head>
		<title></title>
		<link rel="stylesheet" href="/css/style.css"/>
		<meta charset="utf-8" />
		<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.6.0/css/bootstrap.min.css"/>
		<script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
		<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.6.0/js/bootstrap.min.js"></script>
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
