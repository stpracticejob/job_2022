<?php
    //Подключение файла аутентификации
    require_once("$_SERVER[DOCUMENT_ROOT]/../auth/auth.inc.php");
    //Проверка роли
    if (!user_is_employer() && !user_is_admin()) {
        exit();
    }

    //Подключение слоя доступа к данным
    require_once("$_SERVER[DOCUMENT_ROOT]/../db/dal.inc.php");

    //ВАЛИДАЦИЯ ВВОДА НА PHP
    $errmsg = ""; $isvalid = true; $selectors = "";
    function set_error($message, $input_selector = "")
    {
        global $errmsg, $isvalid, $selectors;
        static $comma;
        $errmsg .= $message."<br/>";
        if (trim($input_selector) != "") {
            $selectors .= "$comma $input_selector";
        }
        $comma = ",";
        $isvalid = false;
    }

    if (isset($_GET["editid"])) {
        $item = DBGetVacancy((int) $_GET["editid"]);
        $form_fields["f_title"] = $item["Title"];
        $form_fields["f_sectionid"] = $item["SectionID"];
        $form_fields["f_content"] = $item["Content"];
        $form_fields["f_experience"] = $item["Experience"];
        $form_fields["f_salary"] = $item["Salary"];
        $form_fields["f_ismain"] = $item["IsMain"];
        $form_fields["f_ispartnership"] = $item["IsPartnership"];
        $form_fields["f_isremote"] = $item["IsRemote"];
        $form_fields["f_ID"] = (int) $_GET["editid"];
    }

    if (isset($_GET["delid"])) {
        DBDeleteVacancy((int) $_GET["delid"]);
        header("Location: $_SERVER[PHP_SELF]");
    }

    if (isset($_POST["Go"])) {
        //Фильтрация
        $form_fields["f_title"] = _DBEscString($_POST["f_title"]);
        $form_fields["f_sectionid"] = (int) $_POST["f_sectionid"];
        $form_fields["f_content"] = _DBEscString($_POST["f_content"]);
        $form_fields["f_experience"] = (int) $_POST["f_experience"];
        $form_fields["f_salary"] = (int) $_POST["f_salary"];
        $form_fields["f_ismain"] = isset($_POST["f_ismain"]) ? 1 : 0;
        $form_fields["f_ispartnership"] = isset($_POST["f_ispartnership"]) ? 1 : 0;
        $form_fields["f_isremote"] = isset($_POST["f_isremote"]) ? 1 : 0;
        if (isset($_POST["f_ID"])) {
            $form_fields["f_ID"] = (int) $_POST["f_ID"];
        }
        //Валидация
        if (trim($form_fields["f_title"]) == "") {
            set_error("Поле Заголовок не заполнено", "#f_title");
        }
        if (trim($form_fields["f_sectionid"]) < 0) {
            set_error("Поле Секция не заполнено", "#f_sectionid");
        }
        if (trim($form_fields["f_content"]) == "") {
            set_error("Поле Описание не заполнено", "#f_content");
        }
        if (trim($_POST["f_experience"]) == "" || $form_fields["f_experience"] < 0) {
            set_error("Поле Стаж не заполнено", "#f_experience");
        }
        if (trim($_POST["f_salary"]) == "" || $form_fields["f_salary"] < 0) {
            set_error("Поле Зарплата не заполнено", "#f_salary");
        }
        if (!isset($_POST["f_ismain"]) && !isset($_POST["f_ispartnership"]) && !isset($_POST["f_isremote"])) {
            set_error("Не выбран ни один из режимов работы", "#format");
        }

        if ($isvalid) {
            try {
                //Сохраним вакансию в базе данных
                if (!isset($_POST["f_ID"])) {
                    if (!user_is_admin()) { //Запретим админу создавать новые вакансии
                        DBAddVacancy(
                            $_SESSION["user_info"]["ID"],
                            $form_fields["f_title"],
                            $form_fields["f_sectionid"],
                            $form_fields["f_content"],
                            $form_fields["f_experience"],
                            $form_fields["f_salary"],
                            $form_fields["f_ismain"],
                            $form_fields["f_ispartnership"],
                            $form_fields["f_isremote"]
                        );
                    }
                } else {
                    DBUpdateVacancy(
                        $form_fields["f_ID"],
                        $form_fields["f_title"],
                        $form_fields["f_sectionid"],
                        $form_fields["f_content"],
                        $form_fields["f_experience"],
                        $form_fields["f_salary"],
                        $form_fields["f_ismain"],
                        $form_fields["f_ispartnership"],
                        $form_fields["f_isremote"]
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
		<?require_once("$_SERVER[DOCUMENT_ROOT]/../includes/usermenu.inc");?>
		<?//Если юзер - админ, форму будем отображать только для редактирования
        if (isset($form_fields["f_ID"]) || !user_is_admin()):?>
		<form action="" method="POST">
			Заголовок:<br/>
			<input id="f_title" name="f_title" type="text" size="50" value="<?=$form_fields["f_title"]?>"/><br/>
			Секция:<br/>
			<select id="f_sectionid" name="f_sectionid">
			<option value="-1">--Выберите секцию--</option>
			<?_DBFetchQuery(null, ["reset" => 1]);?>
			<?while ($section = DBFetchSection()):?>				
				<option value="<?=$section["ID"]?>" <?=($form_fields["f_sectionid"] == $section["ID"]) ? "selected='selected'" : ""?>><?=$section["Name"]?></option>
			<?endwhile;?>
			</select><br/>
			Описание:<br/>
			<textarea id="f_content" name="f_content"><?=$form_fields["f_content"]?></textarea><br/>
			Требуемый стаж работы в подобной области:<br/>
			<input id="f_experience" name="f_experience" type="text" size="2" value="<?=$form_fields["f_experience"]?>"/><br/>
			Зарплата:<br/>
			<input id="f_salary" name="f_salary" type="text" size="7" value="<?=$form_fields["f_salary"]?>"/><br/>
			Возможные режимы работы:<br/>
			<div id="format">
			<input id="1" name="f_ismain" type="checkbox" <?=($form_fields["f_ismain"] == 1) ? "checked='checked'" : ""?>/>
			<label for="1">Основная</label><br/>
			<input id="2" name="f_ispartnership" type="checkbox" <?=($form_fields["f_ispartnership"] == 1) ? "checked='checked'" : ""?>/>
			<label for="2">Совместительство</label> <br/>
			<input id="3" name="f_isremote" type="checkbox" <?=($form_fields["f_isremote"] == 1) ? "checked='checked'" : ""?>/>
			<label for="3">Удалённая</label> <br/>
			<?if (isset($form_fields["f_ID"])):?>
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
				<?if (user_is_admin()) {?>
				<th>Автор</th>
				<?}?>
				<th>Должность</th>
				<th>Зарплата</th>
				<th width="20%"></th>
			</tr>
			<?_DBFetchQuery(null, ["reset" => 1]);?>
			<?php
                if (user_is_admin()) {
                    $user_id = -1;
                }//Если пользователь - админ, вывод вакансий всех пользователей
                else { //Иначе - вывод вакансий только пользователя, который залогинен
                    $user_id = $_SESSION["user_info"]["ID"];
                }
            ?>			
			<?while ($item = DBFetchVacancy($user_id)):?>
			<tr>
				<td><?=$item["DateTime"]?></td>
				<?if (user_is_admin()) {?>
				<td><?=$item["Author"]?></td>
				<?}?>
				<td><?=$item["Title"]?></td>
				<td><?=$item["Salary"]?></td>
				<td>
					<a href="?editid=<?=$item["ID"]?>">Редактировать</a>
					<a href="?delid=<?=$item["ID"]?>" onclick="return confirm('Действительно удалить?');">Удалить</a>
				</td>
			</tr>
			<?endwhile;?>
		</table>
	</body>
</html>