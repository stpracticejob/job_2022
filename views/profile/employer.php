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
    $errmsg = ''; $isvalid = true; $selectors = '';
    function set_error($message, $input_selector = '')
    {
        global $errmsg, $isvalid, $selectors;
        static $comma;
        $errmsg .= $message.'<br/>';
        if (trim($input_selector) != '') {
            $selectors .= "$comma $input_selector";
        }
        $comma = ',';
        $isvalid = false;
    }

    if ($employer = DBGetEmployer($_SESSION['user_info']['ID'])) {
        $form_fields['f_ID'] = $employer['ID'];
        $form_fields['f_name'] = $employer['Name'];
        $form_fields['f_tpi'] = $employer['Tpi'];
        $form_fields['f_ofid'] = $employer['OfID'];
    }

    //Если нажата кнопка "Сохранить"
    if (isset($_POST['Go'])) {
        //Фильтрация ввода для предотвращения SQL-инъекций
        $form_fields['f_name'] = _DBEscString($_POST['f_name']);
        $form_fields['f_tpi'] = _DBEscString($_POST['f_tpi']);
        $form_fields['f_ofid'] = (int) $_POST['f_ofid'];
        if (isset($_POST['f_ID'])) {
            $form_fields['f_ID'] = (int) $_POST['f_ID'];
        }

        //Валидация формы (проверка правильности заполнения)
        if (trim($form_fields['f_name']) == '') {
            set_error('Не задано название фирмы', '#f_name');
        }
        if (!preg_match('/^[0-9]{12,14}$/', $form_fields['f_tpi'])) {
            set_error('ИНН задан неверно', '#f_tpi');
        }
        if ($form_fields['f_ofid'] <= 0) {
            set_error('Не задана организационно-правовая форма', '#f_ofid');
        }

        //Если все данные заполнены верно
        if ($isvalid) {
            try {
                //Сохраним пользователя в базе данных
                if (!isset($_POST['f_ID'])) {
                    DBAddEmployer(
                        $_SESSION['user_info']['ID'],
                        $form_fields['f_name'],
                        $form_fields['f_tpi'],
                        $form_fields['f_ofid']
                    );
                } else {
                    DBUpdateEmployer(
                        $form_fields['f_ID'],
                        $form_fields['f_name'],
                        $form_fields['f_tpi'],
                        $form_fields['f_ofid']
                    );
                }

                //и перейдём на эту же страницу
                //для сброса полей формы и
                //предотвращения дублирования данных
                header("Location: $_SERVER[PHP_SELF]");
            } catch (Exception $ex) {
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
		<?if (!$isvalid):?>
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
		<a href="/">На сайт</a>
		<h1>Профиль работодателя</h1>
		Имя: <?=$_SESSION['user_info']['UserName']?><br/>
		<form action="" method="POST">
			Название фирмы:<br/>
			<input 
				id="f_name" 
				name="f_name" 
				type="text" size="50" 
				value="<?=$form_fields['f_name']?>"/><br/>
			ИНН:<br/>
			<input 
				id="f_tpi" 
				name="f_tpi" 
				type="text" size="15" 
				value="<?=$form_fields['f_tpi']?>"/><br/>
			
			Организационно-правовая форма:<br/>
			<select id="f_ofid" name="f_ofid">
				<option value="-1">--Выберите организационно-правовую форму--</option>
				<?while ($of = DBFetchOf()):?>
				<option value="<?=$of['ID']?>" <?=($form_fields['f_ofid'] == $of['ID']) ? "selected='selected'" : ''?>>
				<?=$of['Name']?>
				</option>
				<?endwhile;?>
			</select><br/>			
			
			<div style="color: #F00;"><?=$errmsg?></div>
			<?if (isset($form_fields['f_ID'])):?>
			<input name="f_ID" type="hidden" value="<?=$form_fields['f_ID']?>"/>
			<?endif;?>			
			<input name="Go" type="submit" value="Сохранить"/>
		</form>
	</body>
</html>