<?require_once("$_SERVER[DOCUMENT_ROOT]/../auth/auth.inc.php");?>
<?require_once("$_SERVER[DOCUMENT_ROOT]/../db/dal.inc.php");?>
<!DOCTYPE html>
<html>
	<head>
		<title></title>
		<link rel="stylesheet" href="/css/style.css"/>
	</head>
	<body>
		<?require_once("$_SERVER[DOCUMENT_ROOT]/../includes/usermenu.inc");?>
		<?require_once("$_SERVER[DOCUMENT_ROOT]/../includes/header.inc");?>
				<h1>Реклама</h1>
				
				<?_DBFetchQuery(null, ["reset" => 1]);?>
				<?while ($item = DBFetchAdvertise()):?>
				
					<h2><?=$item["Title"]?></h2>
					<?=$item["Content"]?>
					<hr/>
				<?endwhile;?>
				</table>
		<?require_once("$_SERVER[DOCUMENT_ROOT]/../includes/footer.inc");?>	
	</body>
</html>