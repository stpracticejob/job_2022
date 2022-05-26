<?php
    //PHP-код
    $menu_admin = [
        "/edit/vacancy" => "Вакансии",
        "/edit/cv" => "Резюме",
        "/edit/advertise" => "Объявления",
        "/edit/users" => "Пользователи",
        "/edit/categories" => "Категории"
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
	.navbar{
		background:#F97300;
	}
	.nav-link , .navbar-brand{
		color: #f4f4f4;
		cursor: pointer;
	}
	.nav-link{
		margin-right: 1em !important;
		border-radius: 4px;
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
	<?if ($user->isUserAuthorized()) :?>
	<div id="welcome">
		<span>Здравствуйте, <?=$user->getUserName()?>!</span>
		<ul>
			<li><a href="/">На сайт</a></li>
			<li><a href="<?=$profile_page?>">Мой профиль</a></li>
			<li><a href="/logout">Выход</a></li>
		</ul>
	</div>
	<ul>
		<?foreach ($menu_items as $k => $v):?>
		<li><a href="<?=$k?>"><?=$v?></a></li>
		<?endforeach;?>
	</ul>
	<?else:?>
	<nav class="navbar bg-dark text-white navbar-expand-lg fixed-top">
		<a class="navbar-brand ml-4" href="">JOB</a>
		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
		</button>

		<div class="collapse navbar-collapse" id="navbarSupportedContent">
			<ul class="navbar-nav mr-4">
				<li class="nav-item">
					<div class="dropdown">
						<button class="btn dropdown-toggle nav-link" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
							Справочники
						</button>
						<ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
							<li>
								<a class="dropdown-item" href="">Вакансии</a>
							</li>
							<li>
								<a class="dropdown-item" href="/cv">Резюме</a>
							</li>
							<li>
								<a class="dropdown-item" href="">Реклама</a>
							</li>
						</ul>
					</div>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="">Настройки</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="/login">Вход</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="/reg_user.php">Регистрация</a>
				</li>
			</ul>
		</div>
	</nav>
	<?endif;?>	
</div>
