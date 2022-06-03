<?php
    //PHP-код
    $menu_admin = [
        "/vacancy" => "Вакансии",
        "/cv" => "Резюме",
        "/advertise" => "Объявления",
        "/users" => "Пользователи",
        "/categories" => "Категории"
    ];

    $menu_aspirant = [
        "/edit/cv" => "Мои резюме"
    ];

    $menu_employer = [
        "/edit/vacancy" => "Мои вакансии"
    ];

    $menu_advertiser = [
        "/edit/advertise" => "Мои объявления"
    ];

    $menu_items = [];

    if ($user->isUserAdmin()) {
        $menu_items = $menu_admin;
        $profile_page = "/profile/admin";
    } elseif ($user->isUserAspirant()) {
        $menu_items = $menu_aspirant;
        $profile_page = "/profile/aspirant";
    } elseif ($user->isUserEmployer()) {
        $menu_items = $menu_employer;
        $profile_page = "/profile/employer";
    } elseif ($user->isUserAdvertiser()) {
        $menu_items = $menu_advertiser;
        $profile_page = "/profile/advertiser";
    }
?>
<!--Стили-->
<style>
	div#usermenu {
		background-color: #EEE;
		overflow: hidden;
		margin-bottom: 4em !important;
	}

	div#usermenu ul {
		list-style: none;
		margin: 0;
		padding: 0;
	}

	div#usermenu ul li{
		display: inline;
		margin-right: 30px;
		margin-left: 0px;
	}

	div#welcome {
		padding: 3px 0;
	}

	div#welcome ul{
		float: right;
	}

	div#welcome ul li{
		margin-left: 30px;
		margin-right: 0px;
	}
	.nav-link , .navbar-brand{
		color: #f4f4f4;
		cursor: pointer;
		background: #343a40 !important;
	}
	.nav-link{
		margin-left: 1em !important;
		border-radius: 10px;
	}
	.nav-link:hover{
		background: #f4f4f4;
		color: #f97300;
	}
	.navbar-collapse{
		justify-content: flex-end;
	}
	.navbar-toggler{
		background:#fff !important;
	}
	.dropdown-menu[data-bs-popper] {
		left: unset !important;
	}
</style>

<div id="usermenu">
    <nav class="navbar bg-dark navbar-expand-lg fixed-top">
		<a class="navbar-brand ml-4" href="">JOB</a>
		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
		</button>

		<div class="collapse navbar-collapse" id="navbarSupportedContent">
			<ul class="navbar-nav">
                <? if (count($menu_items)) { ?>
                    <li class="nav-item">
                        <div class="dropdown">
                            <button class="btn dropdown-toggle nav-link" type="button" id="dropdownMenuButton1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Справочники
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                <?foreach ($menu_items as $k => $v):?>
                                    <li><a class="dropdown-item" href="<?=$k?>"><?=$v?></a></li>
                                <?endforeach;?>
                            </ul>
                        </div>
                    </li>
                <? } ?>
	            <?if ($user->isUserAuthorized()) :?>
                    <li class="nav-item">
                        <a class="nav-link" href="">Настройки</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="">Сообщения(2)</a>
                    </li>
                    <li class="nav-item">
                        <div class="dropdown">
                            <button class="btn dropdown-toggle nav-link" type="button" id="dropdownMenuButton2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <?=$user->getUserName()?>
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton2">
                                <li>
                                    <a class="dropdown-item" href="">Редактировать профиль</a>
                                </li>
                                <li>
                                    <div class="dropdown-divider"></div>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="/logout">Выход</a>
                                </li>
                            </ul>
                        </div>
                    </li>
                <?else:?>
                    <li class="nav-item">
                        <a class="nav-link" href="/login">Вход</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/register">Регистрация</a>
                    </li>
	            <?endif;?>
			</ul>
		</div>
	</nav>
</div>
