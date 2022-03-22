<?php
	//Подключение файла аутентификации	
	require_once("$_SERVER[DOCUMENT_ROOT]/../auth/auth.inc.php");
	//Проверка роли
	if(!user_is_admin()) exit();
	
	//Подключение слоя доступа к данным
	require_once("$_SERVER[DOCUMENT_ROOT]/../db/dal.inc.php");
	
	//ВАЛИДАЦИЯ ВВОДА НА PHP
	$errmsg=""; $isvalid=true; $selectors="";
	function set_error($message, $input_selector="") {
		global $errmsg, $isvalid, $selectors;
		static $comma;
		$errmsg.=$message."<br/>";
		if(trim($input_selector)!="")
			$selectors.="$comma $input_selector";
		$comma=",";
		$isvalid=false;
	}
	
	if(isset($_GET["editid"])) {
		$item=DBGetSection((int)$_GET["editid"]);
		$form_fields["f_name"]=$item["Name"];		
		$form_fields["f_ID"]=(int)$_GET["editid"];		
	}
	
	if(isset($_GET["delid"])) {
		DBDeleteSection((int)$_GET["delid"]);
		header("Location: $_SERVER[PHP_SELF]");
	}
	
	if(isset($_POST["Go"])) {
		//Фильтрация
		$form_fields["f_name"]=_DBEscString($_POST["f_name"]);
			
		if(isset($_POST["f_ID"]))
			$form_fields["f_ID"]=(int)$_POST["f_ID"];
		
		//Валидация
		if(trim($form_fields["f_name"])=="")
			set_error("Поле Заголовок не заполнено","#f_name");		
		
		if($isvalid) {
			try {				
				//Сохраним вакансию в базе данных
				if(!isset($_POST["f_ID"])) 				
					DBAddSection($form_fields["f_name"]);				
				else					
					DBUpdateSection(
						$form_fields["f_ID"],
						$form_fields["f_name"]
					);				
				
				//и перейдём на эту же страницу
				//для сброса полей формы и
				//предотвращения дублирования данных
				header("Location: $_SERVER[PHP_SELF]");
				
			}
			catch(Exception $ex) {
				//Если при сохранении возникла ошибка
				//выведем её описание
				set_error($ex->getMessage());
			}
		}
	}
?>
<!DOCTYPE html>
<html>
	<head>
	<?if(!$isvalid):?>
		<!--В случае ошибки выделим неверно заполненные поля красным цветом -->
		<style>
		<?=$selectors?> {
			border-color: #F00;
			border-style: solid;
			border-width: 1px;
		}
		</style>
		<?endif;?>
	</head>
	<body>
		<?require_once("$_SERVER[DOCUMENT_ROOT]/../includes/usermenu.inc");?>
		<br/>
		
		<form action="" method="POST">
			<input id="f_name" name="f_name" type="text" size="50" value="<?=$form_fields["f_name"]?>"/>			
			<?if(isset($form_fields["f_ID"])):?>
			<input name="f_ID" type="hidden" value="<?=$form_fields["f_ID"]?>"/>
			<?endif;?>			
			<input name="Go" type="Submit" value="Сохранить"/>
			<div style="color: #F00;"><?=$errmsg?></div>
		</form>
		
		<br/>
		<table width="100%" border="1">
			<tr>
				<th>Название</th>				
				<th width="20%"></th>
			</tr>	
			<?while($item=DBFetchSection()):?>
			<tr>
				<td><?=$item["Name"]?></td>				
				<td>
					<a href="?editid=<?=$item["ID"]?>">Редактировать</a>
					<a href="?delid=<?=$item["ID"]?>" onclick="return confirm('Действительно удалить?');">Удалить</a>
				</td>
			</tr>
			<?endwhile;?>
		</table>
	</body>
</html>