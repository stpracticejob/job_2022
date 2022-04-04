<div id="envelope">
			<div id="sidebar">				
				<div class="points">Вакансии</div>
				<ul class="sections">
					<?_DBFetchQuery(null, array("reset"=>1));?>
					<?while ($item=DBFetchSection()):?>
					<li><a href="/vacancies.php?section_id=<?=$item["ID"]?>"><?=$item["Name"]?></a></li>
					<?endwhile;?>
				</ul>
				<div class="points">Резюме</div>
				<ul class="sections">
					<?_DBFetchQuery(null, array("reset"=>1));?>
					<?while ($item=DBFetchSection()):?>
					<li><a href="/cvs.php?section_id=<?=$item["ID"]?>"><?=$item["Name"]?></a></li>
					<?endwhile;?>
				</ul>
			</div>
			<div id="content">