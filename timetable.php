<?php
	define("GF_HEADER", "aaaaa");
	require_once("common.php");
	
	$dolls = getJson('doll');
	$fairies = getJson('fairy');
	$equips = getJson('equip');
	
	$eqs = [];
	
	foreach($fairies as $fairy) {
		if(!$fairy->buildTime) continue;
		$tmp[0] = $fairy->buildTime;
		$tmp[1] = L::fairyd;
		$tmp[2] = "";
		$tmp[3] = getFairyName($fairy);
		array_push($eqs, $tmp);
	}
	
	foreach($equips as $equip) {
		if(!$equip->buildTime) continue;
		$cp = $equip->company;
		if($cp !== "BM" && $cp !== "EOT" && $cp !== "AMP" && $cp !== "IOP" && $cp !== "PMC" && $cp !== "AC") continue;
		if(isset($equip->fitgun)) continue;
		$tmp[0] = $equip->buildTime;
		$result = '';
		/*
		if($lang != 'ko') {
			$result = $equip->type;
		}
		else {
			switch($equip->type) {
				case "nightvision": $result = '야시장비'; break;
				case "apBullet": $result = '철갑탄'; break;
				case "hpBullet": $result = '특수탄'; break;
				case "sgBullet": $result = '산탄'; break;
				case "hvBullet": $result = '고속탄'; break;
				case "skeleton": $result = '외골격'; break;
				case "armor": $result = '방탄판'; break;
				case "silencer": $result = '소음기'; break;
				case "ammoBox": $result = '탄약통'; break;
				case "suit": $result = '슈트'; break;
				case "scope": $result = '옵티컬'; break;
				case "chip": $result = '칩셋'; break;
				case "special": $result = '특수'; break;
				case "holo": $result = '이오텍'; break;
				case "reddot": $result = '레드 닷'; break;
			}
		}
		$tmp[1] = $result;*/
		$tmp[1] = "<img style='width: 15%' src='img/equip/{$equip->code}.png'>";
		$tmp[2] = $equip->rank . L::grade;
		$tmp[3] = getEquipName($equip);
		array_push($eqs, $tmp);
	}
	
	$header_desc = "소전DB 제조시간표입니다.";
	$header_keyword = "소녀전선 시간표, 소전 시간표, 소녀전선 제조시간표, 소전 제조시간표, 소녀전선 인형시간표, 소녀전선 장비시간표, 소녀전선 인형시간표";
	$header_title = "소전DB 시간표 | 소전DB";
	require_once("header.php");
?>
    <main role="main" class="container">
		<div class="my-3 p-3 bg-white rounded box-shadow">
			<ul class="nav nav-tabs" id="myTab" role="tablist">
				<li class="nav-item">
					<a class="nav-link active" id="doll-tab" data-toggle="tab" href="#doll" role="tab" aria-controls="doll" aria-selected="true"><?=L::database_dolltable?></a>
				</li>
				<li class="nav-item">
					<a class="nav-link" id="equip-tab" data-toggle="tab" href="#equip" role="tab" aria-controls="equip" aria-selected="false"><?=L::database_equiptable?></a>
				</li>
			</ul>
			
			<div class="tab-content" id="myTabContent">
				<div class="tab-pane fade show active" id="doll" role="tabpanel" aria-labelledby="doll-tab">
					<table id="timetable">
							<thead>
								<tr>
									<th><?=L::time?></th>
									<th><?=L::database_type?></th>
									<th><?=L::grade?></th>
									<th><?=L::database_name?></th>
								</tr>
							</thead>
					<?php foreach($dolls as $doll) { 
						if(!$doll->buildTime) continue; 
						$dollname = getDollName($doll); ?>
							<tr>
								<td><?=gmdate("H:i", $doll->buildTime)?></td>
								<td><?=strtoupper($doll->type)?></td>
								<td><?=$doll->rank?><?=L::grade?></td>
								<td><a href="doll.php?id=<?=$doll->id?>"><?=$dollname?></a></td>
							</tr>
					<?php } ?>
						</table>
				</div>
				<div class="tab-pane fade" id="equip" role="tabpanel" aria-labelledby="equip-tab">
					<table id="equiptimetable">
						<thead>
							<tr>
								<th><?=L::time?></th>
								<th><?=L::database_type?></th>
								<th><?=L::grade?></th>
								<th><?=L::database_name?></th>
							</tr>
						</thead>
				<?php foreach($eqs as $eq) { ?>
						<tr>
							<td><?=gmdate("H:i", $eq[0])?></td>
							<td><?=$eq[1]?></td>
							<td><?=$eq[2]?></td>
							<td><?=$eq[3]?></td>
						</tr>
				<?php } ?>
					</table>
				</div>
			</div>
		</div>
    </main>
<?php
	require_once("footer.php");
?>
	<link rel="stylesheet" href="//cdn.datatables.net/1.10.18/css/jquery.dataTables.min.css">
	<script src="//cdn.datatables.net/1.10.18/js/jquery.dataTables.min.js"></script>
	
	<script>
	$(document).ready(function () {
		$('#timetable').DataTable({
			'rowCallback': function(row, data, index){
				if(data[2] == '3<?=L::grade?>'){
					$(row).css('background-color', '#5dd9c3');
				} 
				else if(data[2] == '4<?=L::grade?>'){
					$(row).css('background-color', '#d6e35a');
				}
				else if(data[2] == '5<?=L::grade?>'){
					$(row).css('background-color', '#fda809');
				}
			},
			paging: false
		});
		
		$('#equiptimetable').DataTable({
			'rowCallback': function(row, data, index){
				if(data[2] == '3<?=L::grade?>'){
					$(row).css('background-color', '#5dd9c3');
				} 
				else if(data[2] == '4<?=L::grade?>'){
					$(row).css('background-color', '#d6e35a');
				}
				else if(data[2] == '5<?=L::grade?>'){
					$(row).css('background-color', '#fda809');
				}
			},
			paging: false
		});
	});
</script>
	</body>
</html>