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
				<?$item = DBGetVacancy((int) $_GET["id"]);?>				
				<b>Заголовок</b><br/>
				<?=$item["Title"]?><br/>
				<b>Описание</b><br/>
				<?=$item["Content"]?><br/>
				<b>Требуемый стаж</b><br/>
				<?=$item["Experience"]?><br/>
				<b>Зарплата</b><br/>
				<?=$item["Salary"]?><br/>
				<a href="">Ответить</a>
		<?require_once("$_SERVER[DOCUMENT_ROOT]/../includes/footer.inc");?>	
	</body>
</html>