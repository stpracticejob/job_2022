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

    if ($aspirant = DBGetAspirant($_SESSION['user_info']['ID'])) {
        $form_fields['f_ID'] = $aspirant['ID'];
        $form_fields['f_age'] = $aspirant['Age'];
        $form_fields['f_limitsid'] = $aspirant['LimitsID'];
        $form_fields['f_driverstateid'] = $aspirant['DriverStateID'];
    }

    //Если нажата кнопка "Сохранить"
    if (isset($_POST['Go'])) {
        //Фильтрация ввода для предотвращения SQL-инъекций
        $form_fields['f_age'] = (int) $_POST['f_age'];
        $form_fields['f_limitsid'] = (int) $_POST['f_limitsid'];
        $form_fields['f_driverstateid'] = (int) $_POST['f_driverstateid'];
        if (isset($_POST['f_ID'])) {
            $form_fields['f_ID'] = (int) $_POST['f_ID'];
        }

        //Валидация формы (проверка правильности заполнения)
        if ($form_fields['f_age'] < 18 || $form_fields['f_age'] > 150) {
            set_error('Возраст задан некорректно', '#f_age');
        }

        //Если все данные заполнены верно
        if ($isvalid) {
            try {
                //Сохраним пользователя в базе данных
                if (!isset($_POST['f_ID'])) {
                    DBAddAspirant(
                        $_SESSION['user_info']['ID'],
                        $form_fields['f_age'],
                        $form_fields['f_limitsid'],
                        $form_fields['f_driverstateid']
                    );
                } else {
                    DBUpdateAspirant(
                        $form_fields['f_ID'],
                        $form_fields['f_age'],
                        $form_fields['f_limitsid'],
                        $form_fields['f_driverstateid']
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

    //Если нажата кнопка "Добавить образование"
    if (isset($_POST['SaveEducation'])) {
        //Фильтрация ввода для предотвращения SQL-инъекций
        $form_fields['f_edtype'] = (int) $_POST['f_edtype'];
        $form_fields['f_edname'] = _DBEscString($_POST['f_edname']);
        $form_fields['f_edyear'] = (int) $_POST['f_edyear'];
        if (isset($_POST['f_ID2'])) {
            $form_fields['f_ID2'] = (int) $_POST['f_ID2'];
        }
        //Валидация формы (проверка правильности заполнения)
        if (trim($form_fields['f_edname']) == '') {
            set_error('Название образования не задано');
        }
        if ($form_fields['f_edyear'] < 1950 || $form_fields['f_edyear'] > date('Y')) {
            set_error('Год оконания учебного заведения указан неверно');
        }

        if ($isvalid) {
            try {
                //Сохраним пользователя в базе данных
                if (!isset($_POST['f_ID2'])) {
                    DBAddEducation(
                        $_SESSION['user_info']['ID'],
                        $form_fields['f_edtype'],
                        $form_fields['f_edname'],
                        $form_fields['f_edyear']
                    );
                } else {
                    DBUpdateEducation(
                        $form_fields['f_ID2'],
                        $form_fields['f_edtype'],
                        $form_fields['f_edname'],
                        $form_fields['f_edyear']
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

    if (isset($_GET['editid'])) {
        $education = DBGetEducation((int) $_GET['editid']);
        $form_fields['f_edtype'] = $education['EducationTypeID'];
        $form_fields['f_edname'] = $education['Name'];
        $form_fields['f_edyear'] = $education['Year'];
        $form_fields['f_ID2'] = $education['ID'];
    }

    if (isset($_GET['delid'])) {
        DBDeleteEducation((int) $_GET['delid']);
        header("Location: $_SERVER[PHP_SELF]");
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
		<h1>Профиль соискателя</h1>
		Имя: <?=$_SESSION['user_info']['UserName']?><br/>
		<form action="" method="POST">
			Возраст:<br/>
			<input 
				id="f_age" 
				name="f_age" 
				type="text" size="2" 
				value="<?=$form_fields['f_age']?>"/><br/>
			Ограничение трудоспособности:<br/>
			<select name="f_limitsid">
				<option value="2">Нет</option>
				<option value="1" <?=($form_fields['f_limitsid'] == 1) ? "selected='selected'" : ''?>>Есть</option>
			</select><br/>
			
			Водительские права:<br/>
			<select name="f_driverstateid">
				<option value="1">Есть</option>
				<option value="2" <?=($form_fields['f_driverstateid'] == 2) ? "selected='selected'" : ''?>>Нет</option>				
			</select><br/>
			Образование:
			<table>
				<tr>
					<td>Уровень</td>
					<td>Учебное заведение</td>
					<td>Год окончания</td>
				</tr>
				<tr>
					<td>
						<select name="f_edtype">
							<?while ($edtype = DBFetchEducationType()):?>
							<option value="<?=$edtype['ID']?>" 
							<?=($form_fields['f_edtype'] == $edtype['ID']) ? "checked='checked'" : ''?>>
							<?=$edtype['Name']?>
							</option>							
							<?endwhile;?>
						</select>
					</td>
					<td><input name="f_edname" type="text" size="70" value="<?=$form_fields['f_edname']?>"/></td>
					<td><input name="f_edyear" type="text" size="10" value="<?=$form_fields['f_edyear']?>"/></td>
					<td><input name="SaveEducation" type="Submit" value="Добавить"/></td>
				</tr>
				<?//Сбросим итератор на первую строку?>
				<?_DBFetchQuery(null, ['reset' => 1]);?>
				<?while ($education = DBFetchEducation($_SESSION['user_info']['ID'])):?>
				<tr>
					<td><?=$education['Type']?></td>
					<td><?=$education['Name']?></td>
					<td><?=$education['Year']?></td>
					<td>
						<a href="?editid=<?=$education['ID']?>">Редактировать</a>
						<a href="?delid=<?=$education['ID']?>" onclick="return confirm('Действительно удалить?')">Удалить</a>
					</td>
				</tr>
				<?endwhile;?>
			</table>
			
			<div style="color: #F00;"><?=$errmsg?></div>
			<?if (isset($form_fields['f_ID'])):?>
			<input name="f_ID" type="hidden" value="<?=$form_fields['f_ID']?>"/>
			<?endif;?>
			<?if (isset($form_fields['f_ID2'])):?>
			<input name="f_ID2" type="hidden" value="<?=$form_fields['f_ID2']?>"/>
			<?endif;?>
			<input name="Go" type="submit" value="Сохранить"/>
		</form>
	</body>
</html>