<?php
	define("GF_HEADER", "aaaaa");
	require_once("header.php");
	$dolls = json_decode(file_get_contents("data/doll.json"));
	$fairies = json_decode(file_get_contents("data/fairy.json"));
	$equips = json_decode(file_get_contents("data/equip.json"));
	
	$eqs = [];
	
	foreach($fairies as $fairy) {
		if(!$fairy->buildTime) continue;
		$tmp[0] = $fairy->buildTime;
		$tmp[1] = "요정";
		$tmp[2] = "";
		$tmp[3] = $fairy->krName;
		array_push($eqs, $tmp);
	}
	
	foreach($equips as $equip) {
		if(!$equip->buildTime) continue;
		$tmp[0] = $equip->buildTime;
		$result = '';
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
		$tmp[1] = $result;
		$tmp[2] = $equip->rank . "성";
		$tmp[3] = $equip->name;
		array_push($eqs, $tmp);
	}
?>
    <main role="main" class="container">
		<div class="my-3 p-3 bg-white rounded box-shadow">
			<ul class="nav nav-tabs" id="myTab" role="tablist">
				<li class="nav-item">
					<a class="nav-link active" id="doll-tab" data-toggle="tab" href="#doll" role="tab" aria-controls="doll" aria-selected="true">인형시간표</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" id="equip-tab" data-toggle="tab" href="#equip" role="tab" aria-controls="equip" aria-selected="false">장비시간표</a>
				</li>
			</ul>
			<div class="tab-content" id="myTabContent">
				<div class="tab-pane fade show active" id="doll" role="tabpanel" aria-labelledby="doll-tab">
					<table id="timetable">
							<thead>
								<tr>
									<th>시간</th>
									<th>종류</th>
									<th>등급</th>
									<th>이름</th>
								</tr>
							</thead>
					<?php foreach($dolls as $doll) { 
						if(!$doll->buildTime) continue; ?>
							<tr>
								<td><?=gmdate("H:i", $doll->buildTime)?></td>
								<td><?=strtoupper($doll->type)?></td>
								<td><?=$doll->rank?>성</td>
								<td><a href="doll.php?id=<?=$doll->id?>"><?=$doll->krName?></a></td>
							</tr>
					<?php } ?>
						</table>
				</div>
				<div class="tab-pane fade" id="equip" role="tabpanel" aria-labelledby="equip-tab">
					<table id="equiptimetable">
						<thead>
							<tr>
								<th>시간</th>
								<th>종류</th>
								<th>등급</th>
								<th>이름</th>
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
				if(data[2] == '3성'){
					$(row).css('background-color', '#5dd9c3');
				} 
				else if(data[2] == '4성'){
					$(row).css('background-color', '#d6e35a');
				}
				else if(data[2] == '5성'){
					$(row).css('background-color', '#fda809');
				}
			},
			paging: false
		});
		
		$('#equiptimetable').DataTable({
			'rowCallback': function(row, data, index){
				if(data[2] == '3성'){
					$(row).css('background-color', '#5dd9c3');
				} 
				else if(data[2] == '4성'){
					$(row).css('background-color', '#d6e35a');
				}
				else if(data[2] == '5성'){
					$(row).css('background-color', '#fda809');
				}
			},
			paging: false
		});
	});
</script>
	</body>
</html>