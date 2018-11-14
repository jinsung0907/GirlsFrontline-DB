<?php
	define("GF_HEADER", "aaaaa");
	require_once("common.php");
	
	if(empty($_GET['id'])) { header("Location: http://gfl.zzzzz.kr/fairies.php"); exit();}
	
	//요정데이터 불러오기
	$fairies = getJson('fairy');
	foreach($fairies as $data) {
		if(is_numeric($_GET['id'])) {
			if($data->id == $_GET['id']) {
				$fairy = $data;
				break;
			}
		}
		else {
			if($data->name == $_GET['id'] || getFairyName($fairy) == $_GET['id']) {
				$fairy = $data;
				break;
			}
		}
	}
	
	if(empty($fairy)) Error('데이터 없음');
	
	//스킬데이터 불러오기
	$skills = getJson('skill');
	foreach($skills as $data) {
		if($data->id == $fairy->skill->id) {
			$skill = $data;
			break;
		}
	}
	
	//스킬 파싱
	$replace = [];
	$num = [];
	$skilldata = array();
	preg_match_all("/{([a-zA-Z0-9]{1,})}/", $skill->desc, $matches);
	$i = 0;
	foreach($matches[1] as $match) {
		if(isset($fairy->skill->nightDataPool->{$match})){
			array_push($num, "<span class='txthighlight' id='skillattr_$i'>" . end($fairy->skill->dataPool->{$match})."</span>(<span class='txthighlight' id='skillattr_night_$i'>".end($fairy->skill->nightDataPool->{$match}).'</span>)');
			for($j = 0 ; $j <= sizeof($fairy->skill->dataPool->{$match})-1 ; $j++) {
				$skilldata['attr'][$i][$j] = $fairy->skill->dataPool->{$match}[$j];
			}
			for($j = 0 ; $j <= sizeof($fairy->skill->nightDataPool->{$match})-1 ; $j++) {
				$skilldata['attr_night'][$i][$j] = $fairy->skill->nightDataPool->{$match}[$j];
			}
		} else {
			if($fairy->id == 11) $fairy->skill->dataPool->MV[9] = '∞';
			array_push($num, "<span class='txthighlight' id='skillattr_$i'>" . end($fairy->skill->dataPool->{$match}) . '</span>');
			for($j = 0 ; $j <= sizeof($fairy->skill->dataPool->{$match})-1 ; $j++) {
				$skilldata['attr'][$i][$j] = $fairy->skill->dataPool->{$match}[$j];
			}
		}
		array_push($replace, "(\{$match\})");
		$i++;
	}
	$skill->desc = preg_replace($replace, $num, $skill->desc);
	
	if(isset($fairy->skill->dataPool->DR)) {
		$skill->desc .= L::fairy_duration($fairy->skill->dataPool->DR);
	}
	
	if(isset($fairy->skill->dataPool->CP)) {
		$skillcolldown = L::fairy_cooldown_p($fairy->skill->dataPool->CP);
		if(isset($fairy->skill->dataPool->CD)) {
			$skillcolldown .= L::fairy_cooldown($fairy->skill->dataPool->CD);
		}
	}
	
	//클라데이터 스킬
	if($fairy->skill->realid > 900000)
		$tmp = getDataFile('battle_skill_config', $lang);
	else 
		$tmp = getDataFile('mission_skill_config', $lang);
	
	$rskills = explode(PHP_EOL, $tmp);
	if(isset($fairy->skill->realid)) {
		$rskill_name = '';
		$rskill_txt = [];
		$i = 0;
		foreach($rskills as $line) {
			if($fairy->skill->realid > 900000)
				preg_match("/battle_skill_config-([0-9])([0-9]{6})([0-9]{2}),(.*)/", $line, $matches);
			else {
				preg_match("/mission_skill_config-([0-9])([0-9]{5})([0-9]{2}),(.*)/", $line, $matches);
				$matches[2] = $matches[2] % 100000;
			}
			$s_level = intval($matches[3]);
			
			if($matches[1] == 1 && $matches[2] == $fairy->skill->realid) {
				$rskill_name = explode(',', $rskills[$i])[1];
				$rskill_txt[$s_level] = explode(',', $rskills[$i+1])[1];
				$rskill_txt[$s_level] = str_replace("//c" , ',', $rskill_txt[$s_level]);
				$rskill_txt[$s_level] = str_replace("；" , '<br>', $rskill_txt[$s_level]);
				$rskill_txt[$s_level] = str_replace("//n" , '<br>', $rskill_txt[$s_level]);
				$rskill_txt[$s_level] = preg_replace("/([\+\-0-9.]{1,4}[%배초의칸개발회])/u", "<span class='txthighlight'>\\1</span>", $rskill_txt[$s_level]);
				$rskill_txt[$s_level] = preg_replace("/([\+\-0-9.]{1,4}[％倍秒])/u", "<span class='txthighlight'>\\1</span>", $rskill_txt[$s_level]);
				
				if($s_level == 10) break;
			}
			$i++;
		}
	}
	
	//설명 및 등장대사 파싱
	$voice = '';
	$voices = explode(PHP_EOL, getDataFile('fairy', $lang));
	$voices_fallback = explode(PHP_EOL, getDataFile('fairy', 'ko'));
	
	$i = 0;
	foreach($voices as $data) {
		$tmp = explode(',', $data);
		$tmp[0] = str_replace('fairy-', '', $tmp[0]);
		if($fairy->id == $tmp[0] % 10000000) {
			$fairyname = str_replace('//c', ',', explode(",", $voices[$i])[1]);
			$saying = str_replace('//c', ',', explode(",", $voices[$i+1])[1]);
			$comment = str_replace('//c', ',', explode(",", $voices[$i+2])[1]);
			break;
		}
		$i++;
	}
	
	//타 섭에 없는 데이터의 경우 한국데이터를 fallback으로 사용
	if($comment == '' || !isset($comment)) {
		$i = 0;
		foreach($voices_fallback as $data) {
			$tmp = explode(',', $data);
			$tmp[0] = str_replace('fairy-', '', $tmp[0]);
			if($fairy->id == $tmp[0] % 10000000) {
				$fairyname = str_replace('//c', ',', explode(",", $voices[$i])[1]);
				$saying = str_replace('//c', ',', explode(",", $voices_fallback[$i+1])[1]);
				$comment = str_replace('//c', ',', explode(",", $voices_fallback[$i+2])[1]);
				break;
			}
			$i++;
		}
	}
	/*
	{
		"armor": [5, 0.05],
		"critDmg": [10, 0.101],
		"dodge": [20, 0.202],
		"hit": [25, 0.252],
		"pow": [7, 0.076],
		"proportion": [0.4, 0.5, 0.6, 0.8, 1.0]
	}
	*/

	//이미지 불러오기
	$imglist = [];
	array_push($imglist, $fairy->name. "_1");
	array_push($imglist, $fairy->name. "_2");
	array_push($imglist, $fairy->name. "_3");
	

	
	$header_title =  $fairyname . " | " . L::sitetitle_short;
	$header_desc = L::title_fairy_desc($fairyname);
	$header_keyword = $fairyname . ", 소녀전선 요정";
	$header_image = "http://gfl.zzzzz.kr/img/fairy/{$imglist[2]}.png";
	
	require_once("header.php");	
?>
    <main role="main" class="container">
		<div class="my-3 p-3 bg-white rounded box-shadow">
			<div class="row">
				<div class="col-md">
					<div id="carouselExampleControls" class="carousel slide border" data-ride="carousel">
						<div class="carousel-inner">
					<?php $first = true;
						foreach($imglist as $img) {
							if($first) { $active = "active"; $first = false; } else $active = ""; ?>
							<div class="carousel-item <?=$active?>">
								<img class="d-block w-100" src="img/fairy/<?=$img?>.png">
							</div>
						<?php } ?>
						</div>
						<a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
							<span style="font-weight:bold; color:black"><<<</span>
							<span class="sr-only">Previous</span>
						</a>
						<a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
							<span style="font-weight:bold; color:black">>>></span>
							<span class="sr-only">Next</span>
						</a>
					</div>
				</div>
				<div class="col-md">
					<h2 style="display: inline" class="mr-2"><?=$fairyname?></h2><br><hr class="mt-1 mb-1">
					<b><?=L::database_type?></b> : <?=fairytype_to_str($fairy->category)?><hr class="mt-1 mb-1">
					<b><?=L::database_buildtime?></b> : <?=$fairy->buildTime?gmdate("H\\" . L::hour . " i\\" . L::min, $fairy->buildTime): L::database_cantbuild;?><hr class="mt-1 mb-1">
					<select id="fairyrank">
						<option value="1">1<?=L::database_star?></option>
						<option value="2">2<?=L::database_star?></option>
						<option value="3">3<?=L::database_star?></option>
						<option value="4">4<?=L::database_star?></option>
						<option value="5" selected>5<?=L::database_star?></option>
					</select>
					<select id="fairylevel"><?php for($i = 1 ; $i <= 99 ; $i++) {?>
						<option value="<?=$i?>"><?=$i?><?=L::level?></option> <?php } ?>
						<option value="100" selected>100<?=L::level?></option>
					</select>
					<hr class="mt-1 mb-1">
					<div class="row">
						<div class="col-md-auto align-self-center">
							<b><?=L::database_stats?></b>
						</div>
						<div class="col">
							<table class="table-sm">
								<tr>
									<td><?=L::database_pow?> : <span id="stat_pow"></span></td>
									<td><?=L::database_hit?> : <span id="stat_hit"></span></td>
									<td><?=L::database_dodge?> : <span id="stat_dodge"></span></td>
								</tr>
								<tr>
									<td><?=L::database_armor?> : <span id="stat_armor"></span></td>
									<td><?=L::database_critdmg?> : <span id="stat_critDmg"></span></td>
								</tr>
							</table>
						</div>
					</div>
					<hr class="mt-1 mb-1">
					<div class="row pb-0">
						<div class="col-md-auto align-self-center">
							<img class="skillimg" src="img/skill/<?=$skill->path?>.png"> <?=$rskill_name?>
						</div>
						<div class="col">
							<select id="skilllevel">
								<option value="1">1<?=L::level?></option>
								<option value="2">2<?=L::level?></option>
								<option value="3">3<?=L::level?></option>
								<option value="4">4<?=L::level?></option>
								<option value="5">5<?=L::level?></option>
								<option value="6">6<?=L::level?></option>
								<option value="7">7<?=L::level?></option>
								<option value="8">8<?=L::level?></option>
								<option value="9">9<?=L::level?></option>
								<option value="10" selected>10<?=L::level?></option>
							</select><br>
							<span id="skill_txt"><?=$rskill_txt[10]?></span><br>
							<?=$skillcolldown?>
						</div>
					</div>
					<hr class="mt-1 mb-1">
				</div>
			</div>
			<div class="card card-body bg-light mt-3 p-2">
				<?=L::fairy_comment?> : <br><?=$comment?><br><br>
				<?=L::fairy_saying?> : <br><?=$saying?>
			</div>
		</div>	
		<div class="my-3 p-3 bg-white rounded box-shadow">
            <ins class="adsbygoogle"
			 style="display:block; text-align:center"
			 data-ad-client="ca-pub-6637664198779025"
			 data-ad-slot="3111645353"
			 data-ad-format="auto"
			 data-full-width-responsive="true"></ins>
		</div>
    </main>
<?php
	require_once("footer.php");
?>
	</body>
	<script>
	var fairystats = <?=json_encode($fairy->stats)?>;
	var grow = {"armor": [5, 0.05],"critDmg": [10, 0.101],"dodge": [20, 0.202],"hit": [25, 0.252],"pow": [7, 0.076],"proportion": [0.4, 0.5, 0.6, 0.8, 1.0]};
	const fairygrow = <?=$fairy->grow?>;
	
	var skilldata = <?=json_encode($skilldata)?>;
	var r_skilldata = <?=json_encode($rskill_txt, JSON_UNESCAPED_UNICODE)?>;
	
	calcstat();
	
	$("#fairylevel,#fairyrank").on('change', function(e) {
		calcstat();
	});
	
	/* 이전 skill.json값 가지고 컨트롤 하던 소스
	$('#skilllevel').on('change', function(e) {
		var level = $('#skilllevel').val()-1;
		if(typeof skilldata.attr !== 'undefined') {
			for(var i = 0 ; i<= skilldata.attr.length-1 ; i++) {
				$("#skillattr_"+i).text(skilldata.attr[i][level]);
			}
			$("#skillduration").text(skilldata.duration[level]);
			$("#skillcool").text(skilldata.cooldown[level]);
		}
		if(typeof skilldata.attr_mod3 !== 'undefined') {
			for(var i = 0 ; i<= skilldata.attr_mod3.length-1 ; i++) {
				$("#skillattr_mod3_"+i).text(skilldata.attr_mod3[i][level]);
			}
			$("#skillduration_mod3").text(skilldata.duration_mod3[level]);
			$("#skillcool_mod3").text(skilldata.cooldown_mod3[level]);
		}
	});*/
	
	$('#skilllevel').on('change', function(e) {
			var level = $('#skilllevel').val();
			$("#skill_txt").html(r_skilldata[level]);
			level--;
			if(typeof skilldata.attr !== 'undefined') {
				$("#skillcool").text(skilldata.cooldown[level]);
			}
		});
	
	function calcstat() {
		var level = $("#fairylevel").val();
		var quality = $("#fairyrank").val();
		
		if(typeof fairystats.pow !== 'undefined') {
			$("#stat_pow").text((Math.ceil((grow.pow[0] * (fairystats.pow / 100)) + Math.ceil(((level - 1) * grow.pow[1]) * (fairystats.pow / 100) * (fairygrow / 100))) * grow.proportion[quality - 1]).toFixed(1) + "%");
		} else $("#stat_pow").text('-');
		if(typeof fairystats.hit !== 'undefined') {
			$("#stat_hit").text((Math.ceil((grow.hit[0] * (fairystats.hit / 100)) + Math.ceil(((level - 1) * grow.hit[1]) * (fairystats.hit / 100) * (fairygrow / 100))) * grow.proportion[quality - 1]).toFixed(1) + "%");
		} else $("#stat_hit").text('-');
		if(typeof fairystats.dodge !== 'undefined') {
			$("#stat_dodge").text((Math.ceil((grow.dodge[0] * (fairystats.dodge / 100)) + Math.ceil(((level - 1) * grow.dodge[1]) * (fairystats.dodge / 100) * (fairygrow / 100))) * grow.proportion[quality - 1]).toFixed(1) + "%");
		} else $("#stat_dodge").text('-');
		if(typeof fairystats.critDmg !== 'undefined') {
			$("#stat_critDmg").text((Math.ceil((grow.critDmg[0] * (fairystats.critDmg / 100)) + Math.ceil(((level - 1) * grow.critDmg[1]) * (fairystats.critDmg / 100) * (fairygrow / 100))) * grow.proportion[quality - 1]).toFixed(1) + "%");
		} else $("#stat_critDmg").text('-');
		if(typeof fairystats.armor !== 'undefined') {
			$("#stat_armor").text((Math.ceil((grow.armor[0] * (fairystats.armor / 100)) + Math.ceil(((level - 1) * grow.armor[1]) * (fairystats.armor / 100) * (fairygrow / 100))) * grow.proportion[quality - 1]).toFixed(1) + "%");
		} else $("#stat_armor").text('-');
	}
	</script>
</html>