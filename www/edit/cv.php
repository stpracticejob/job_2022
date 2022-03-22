<?php
	//Подключение файла аутентификации	
	require_once("$_SERVER[DOCUMENT_ROOT]/../auth/auth.inc.php");
	//Проверка роли
	if(!user_is_aspirant() && !user_is_admin()) exit();
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
		$item=DBGetCV((int)$_GET["editid"]);
		$form_fields["f_title"]=$item["Title"];
		$form_fields["f_sectionid"]=$item["SectionID"];
		$form_fields["f_content"]=$item["Content"];		
		$form_fields["f_ID"]=(int)$_GET["editid"];		
	}
	
	if(isset($_GET["delid"])) {
		DBDeleteCV((int)$_GET["delid"]);
		header("Location: $_SERVER[PHP_SELF]");
	}
	
	if(isset($_POST["Go"])) {
		//Фильтрация
		$form_fields["f_title"]=_DBEscString($_POST["f_title"]);
		$form_fields["f_sectionid"]=(int)$_POST["f_sectionid"];
		$form_fields["f_content"]=_DBEscString($_POST["f_content"]);			
		if(isset($_POST["f_ID"]))
			$form_fields["f_ID"]=(int)$_POST["f_ID"];
		//Валидация
		if(trim($form_fields["f_title"])=="")
			set_error("Поле Заголовок не заполнено","#f_title");
		if(trim($form_fields["f_sectionid"])<0)
			set_error("Поле Секция не заполнено","#f_sectionid");
		if(trim($form_fields["f_content"])=="")
			set_error("Поле Описание не заполнено","#f_content");		
		
		if($isvalid) {
			try {				
				//Сохраним вакансию в базе данных
				if(!isset($_POST["f_ID"])) {
					if(!user_is_admin()) //Запретим админу создавать резюме
						DBAddCV(
							$_SESSION["user_info"]["ID"],
							$form_fields["f_title"],
							$form_fields["f_sectionid"],
							$form_fields["f_content"]						
						);
				}
				else					
					DBUpdateCV(
						$form_fields["f_ID"],
						$form_fields["f_title"],
						$form_fields["f_sectionid"],
						$form_fields["f_content"]						
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
		<?//Если юзер - админ, форму будем отображать только для редактирования 
		if(isset($form_fields["f_ID"]) || !user_is_admin()):?>
		<form action="" method="POST">
			Заголовок:<br/>
			<input id="f_title" name="f_title" type="text" size="50" value="<?=$form_fields["f_title"]?>"/><br/>
			Секция:<br/>
			<select id="f_sectionid" name="f_sectionid">
			<option value="-1">--Выберите секцию--</option>
			<?_DBFetchQuery(NULL,Array("reset"=>1));?>
			<?while($section=DBFetchSection()):?>				
				<option value="<?=$section["ID"]?>" <?=($form_fields["f_sectionid"]==$section["ID"])?"selected='selected'":""?>><?=$section["Name"]?></option>
			<?endwhile;?>
			</select><br/>
			Описание:<br/>
			<textarea id="f_content" name="f_content"><?=$form_fields["f_content"]?></textarea><br/>			
			<?if(isset($form_fields["f_ID"])):?>
			<input name="f_ID" type="hidden" value="<?=$form_fields["f_ID"]?>"/>
			<?endif;?>
			</div><br/>
			<div style="color: #F00;"><?=$errmsg?></div>
			<input name="Go" type="Submit" value="Сохранить"/>			
		</form>
		<?endif;?>
		<br/>
		<table width="100%" border="1">
			<tr>
				<th width="15%">Дата публикации</th>
				<?if(user_is_admin()){?>
				<th>Автор</th>
				<?}?>
				<th>Должность</th>				
				<th width="20%"></th>
			</tr>
			<?_DBFetchQuery(NULL,Array("reset"=>1));?>
			<?
				if(user_is_admin())
					$user_id=-1;//Если пользователь - админ, вывод резюме всех пользователей
				else //Иначе - вывод резюме только пользователя, который залогинен
					$user_id=$_SESSION["user_info"]["ID"];
			?>	
			<?while($item=DBFetchCV($user_id)):?>
			<tr>
				<td><?=$item["DateTime"]?></td>
				<?if(user_is_admin()){?>
				<td><?=$item["Author"]?></td>
				<?}?>
				<td><?=$item["Title"]?></td>				
				<td>
					<a href="?editid=<?=$item["ID"]?>">Редактировать</a>
					<a href="?delid=<?=$item["ID"]?>" onclick="return confirm('Действительно удалить?');">Удалить</a>
				</td>
			</tr>
			<?endwhile;?>
		</table>
	</body>
</html>