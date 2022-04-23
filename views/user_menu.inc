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
		padding: 14px;
		overflow: hidden;
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
	<div id="welcome">	
		<a href="/">JOB SITE</a>
		<ul>			
			<li><a href="/login">Вход</a></li>
			<li><a href="/reg_user.php">Регистрация</a></li>
		</ul>
	</div>
	<?endif;?>	
</div>