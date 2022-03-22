<?php
	//PHP-код
	$menu_admin=Array(
		"/edit/vacancy.php"=>"Вакансии",
		"/edit/cv.php"=>"Резюме",
		"/edit/advertise.php"=>"Объявления",
		"/edit/users.php"=>"Пользователи",
		"/edit/categories.php"=>"Категории"
	);
	
	$menu_aspirant=Array(		
		"/edit/cv.php"=>"Мои резюме"		
	);
	
	$menu_employer=Array(
		"/edit/vacancy.php"=>"Мои вакансии"
	);
	
	$menu_advertiser=Array(		
		"/edit/advertise.php"=>"Мои объявления"		
	);
	
	$menu_items=Array();
	
	if(user_is_admin()) {$menu_items=$menu_admin;$profile_page="admin.php";}
	elseif (user_is_aspirant()) {$menu_items=$menu_aspirant;$profile_page="aspirant.php";}
	elseif (user_is_employer()) {$menu_items=$menu_employer;$profile_page="employer.php";}
	elseif (user_is_advertiser()) {$menu_items=$menu_advertiser;$profile_page="advertiser.php";}
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
<!--xmp><?//print_r($_SESSION)?></xmp-->
<!--HTML-код-->
<div id="usermenu">
	<?if(user_authorized()) :?>
	<div id="welcome">
		<span>Здравствуйте, <?=user_name()?>!</span>
		<ul>
			<li><a href="/">На сайт</a></li>
			<li><a href="/profiles/<?=$profile_page?>">Мой профиль</a></li>
			<li><a href="/auth/exit.php">Выход</a></li>
		</ul>
	</div>
	<ul>
		<?foreach($menu_items As $k=>$v):?>
		<li><a href="<?=$k?>"><?=$v?></a></li>
		<?endforeach;?>
	</ul>
	<?else:?>
	<div id="welcome">	
		<a href="http://job/">JOB.RU</a>
		<ul>			
			<li><a href="/auth_user.php">Вход</a></li>
			<li><a href="/reg_user.php">Регистрация</a></li>
		</ul>
	</div>
	<?endif;?>	
</div>