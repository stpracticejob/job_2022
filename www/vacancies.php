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
				<h1>Вакансии</h1>
				<table width="100%" border="1">
				<?_DBFetchQuery(NULL,Array("reset"=>1));?>
				<?while($item=DBFetchVacancy(-1,(int)$_GET["section_id"])):?>
				<tr>
					<td width="20%"><?=$item["DateTime"]?></td>
					<td width="10%"><?=$item["Author"]?></td>
					<td>
						<a href="/vacancy.php?id=<?=$item["ID"]?>"><?=$item["Title"]?></a>
					</td>
					<td><?=$item["Salary"]?>р</td>
				</tr>
				<?endwhile;?>
				</table>
		<?require_once("$_SERVER[DOCUMENT_ROOT]/../includes/footer.inc");?>	
	</body>
</html>