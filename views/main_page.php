<!DOCTYPE html>
<html>
	<head>
		<title></title>
		<link rel="stylesheet" href="/css/style.css"/>
                <meta charset="utf-8" /> 
	</head>
	<body>
		<?include('user_menu.inc');?>
		<?include('header.inc');?>
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