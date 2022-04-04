<?php
    //Подключение файла аутентификации
    require_once("$_SERVER[DOCUMENT_ROOT]/../auth/auth.inc.php");
    //Проверка роли
    if (!user_is_admin()) {
        exit();
    }

    //Подключение слоя доступа к данным
    require_once("$_SERVER[DOCUMENT_ROOT]/../db/dal.inc.php");

    if (isset($_GET["toggleid"])) {
        DBToggleUser((int) $_GET["toggleid"]);
        header("Location: $_SERVER[PHP_SELF]");
    }

    if (isset($_GET["delid"])) {
        DBDeleteUser((int) $_GET["delid"]);
        header("Location: $_SERVER[PHP_SELF]");
    }
?>
<!DOCTYPE html>
<html>
	<head></head>
	<body>
		<?require_once("$_SERVER[DOCUMENT_ROOT]/../includes/usermenu.inc");?>
		<br/>		
		<table width="100%" border="1">
			<tr>
				<th width="15%">Логин</th>
				<th>Полное имя</th>
				<th width="15%">Роль</th>				
				<th width="20%"></th>
			</tr>
				
			<?while ($item = DBFetchUser()):?>
			<tr>
				<td><?=$item["Login"]?></td>				
				<td><?=$item["UserName"]?></td>				
				<td><?=$item["RoleName"]?></td>				
				<td>
					<a href="?toggleid=<?=$item["ID"]?>">
						<?if ($item["State"] == 0):?>
						Блокировать
						<?else:?>
						Разблокировать
						<?endif;?>
					</a>
					<a href="?delid=<?=$item["ID"]?>" onclick="return confirm('Действительно удалить?');">Удалить</a>
				</td>
			</tr>
			<?endwhile;?>
		</table>
	</body>
</html>