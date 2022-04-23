<div id="envelope">
    <div id="sidebar">				
	<div class="points">Вакансии</div>
	    <ul class="sections">
		<?foreach ($db->fetchSections() as $item):?>
		    <li><a href="/vacancies.php?section_id=<?=$item["ID"]?>"><?=$item["Name"]?></a></li>
		<?endforeach;?>
	    </ul>
	    <div class="points">Резюме</div>
		<ul class="sections">
		    <?foreach ($db->fetchSections() as $item):?>
			<li><a href="/cvs.php?section_id=<?=$item["ID"]?>"><?=$item["Name"]?></a></li>
		    <?endforeach;?>
		</ul>
	    </div>
	    <div id="content">