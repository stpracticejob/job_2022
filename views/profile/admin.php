<?php
    //ВАЛИДАЦИЯ ВВОДА НА PHP
    $errmsg = '';
    $isvalid = true;
    $selectors = '';

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

    if ($employer = $db->fetchEmployer($_SESSION['user_info']['ID'])->fetch()) {
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
		<h1>Профиль админа</h1>
		Имя: <?=$_SESSION['user_info']['UserName']?><br/>
		У админа нет профиля (((((
	</body>
</html>