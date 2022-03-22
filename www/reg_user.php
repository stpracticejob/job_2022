<?php
	//Подключение файла аутентификации	
	require_once("$_SERVER[DOCUMENT_ROOT]/../auth/auth.inc.php");
	
	//Подключение слоя доступа к данным
	require_once("$_SERVER[DOCUMENT_ROOT]/../db/dal.inc.php");
	
	//Подключение библиотеки Captcha
	require_once("$_SERVER[DOCUMENT_ROOT]/lib/securimage/securimage.php");
	//Создание объекта Captcha
	$securimage = new Securimage();
	
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
	
	//Если нажата кнопка "Регистрация"
	if(isset($_POST["Go"])) {
		//Фильтрация ввода для предотвращения SQL-инъекций
		$form_fields["f_fullname"]=_DBEscString($_POST["f_fullname"]);
		$form_fields["f_email"]=_DBEscString($_POST["f_email"]);
		$form_fields["f_password"]=_DBEscString($_POST["f_password"]);
		$form_fields["f_confirm"]=_DBEscString($_POST["f_confirm"]);
		$form_fields["f_roleid"]=(int)$_POST["f_roleid"];
		
		//Валидация формы (проверка правильности заполнения)
		if(trim($form_fields["f_fullname"])=="") 
			set_error("Не указано полное имя","#f_fullname");
		if(!preg_match("/^[A-Za-z0-9\._-]+@[A-Za-z0-9_-]+\.[A-Za-z0-9_-]+$/",$form_fields["f_email"]))
			set_error("Поле Email не заполнено или содержит недопустимые символы","#f_email");
		if(DBCheckUser($form_fields["f_email"])>0)
			set_error("Пользователь с таким Email уже зарегистрирован","#f_email");
		if(strlen($form_fields["f_password"])<5)
			set_error("Пароль должен содержать не менее 5 символов","#f_password");
		elseif($form_fields["f_password"]!=$form_fields["f_confirm"])
			set_error("Пароль не совпадает с подтверждением","#f_password, #f_confirm");		
		if(!isset($form_fields["f_roleid"]))
			set_error("Не выбран тип создаваемой учётной записи","#f_roleid");
		if (!$securimage->check($_POST['captcha_code']))
			set_error("Неправильно введён код с картинки","#captcha_code");
		
		//Если все данные заполнены верно
		if($isvalid) {			
			try {				
				//Сохраним пользователя в базе данных
				//функция DBAddUser объявлена в файле ../db/dal.inc.php
				DBAddUser(
					$form_fields["f_fullname"],
					//email используется вместо логина, 
					//поэтому если пользователь в конце или 
					//начале случайно поставил пробелы - удалим их функцией trim
					trim($form_fields["f_email"]),
					//Зашифруем пароль по алгоритму md5
					md5($form_fields["f_password"]),
					$form_fields["f_roleid"]
				);
				
				//Залогинимся под созданным пользователем				
				auth_user($form_fields["f_email"],$form_fields["f_password"]);
				//и перейдём на главную страницу
				header("Location: http://$_SERVER[HTTP_HOST]/");
				
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
		
		<h1>Регистрация нового пользователя</h1>
		<form action="" method="POST">
			Ваше полное имя:<br/>
			<input id="f_fullname" name="f_fullname" type="text" size="50" value="<?=$form_fields["f_fullname"]?>"/><br/>
			Email:<br/>
			<input id="f_email" name="f_email" type="text" value="<?=$form_fields["f_email"]?>"/><br/>
			Пароль:<br/>
			<input id="f_password" name="f_password" type="password" value="<?=$form_fields["f_password"]?>"/><br/>
			Подтверждение пароля:<br/>
			<input id="f_confirm" name="f_confirm" type="password" value="<?=$form_fields["f_confirm"]?>"/><br/>
			Зарегистрировать учётную запись:<br/>
			<div id="f_roleid">
			<input name="f_roleid" id="aspirant" type="radio" value="2" <?=($form_fields["f_roleid"]==2)?"checked='checked'":""?>/>
			<label for="aspirant">Соискателя</label><br/>
			
			<input name="f_roleid" id="employer" type="radio" value="3" <?=($form_fields["f_roleid"]==3)?"checked='checked'":""?>/>
			<label for="employer">Работодателя</label><br/>
			
			<input name="f_roleid" id="advertiser" type="radio" value="4" <?=($form_fields["f_roleid"]==4)?"checked='checked'":""?>/>
			<label for="advertiser">Рекламодателя</label><br/>
			</div>
			
			<img id="captcha" src="/lib/securimage/securimage_show.php" alt="CAPTCHA Image" />
			<br/><a href="#" onclick="document.getElementById('captcha').src = '/lib/securimage/securimage_show.php?' + Math.random(); return false">[ Другое изображение ]</a><br/>
			Код с картинки:<br/>
			<input id="captcha_code" name="captcha_code" type="text"/><br/>
			<div style="color: #F00;"><?=$errmsg?></div>
			<input name="Go" type="submit" value="Регистрация"/>
		</form>
	</body>
</html>