<?php
	define("GF_HEADER", "aaaaa");
	require_once("common.php");
	
	if(empty($_GET['id'])) { header("Location: http://gfl.zzzzz.kr/dolls.php", true, 301); exit();}
	
	switch($_GET['id']) {
		case "스텐MK-2": $_GET['id'] = 29; break;
		case "RO": $_GET['id'] = 143; break;
		case "FN-FNC": $_GET['id'] = 70; break;
		case "노엘": $_GET['id'] = 1001; break;
		case "엘펠트": $_GET['id'] = 1002; break;
	}
	
	//인형데이터 불러오기
	$dolls = json_decode(file_get_contents("data/doll.json"));
	foreach($dolls as $data) {
		if(is_numeric($_GET['id'])) {
			if($data->id == $_GET['id']) {
				$doll = $data;
				break;
			}
		}
		else {
			if($data->name == $_GET['id'] || $data->krName == $_GET['id']) {
				$_GET['id'] = $data->id;
				$doll = $data;
				break;
			}
		}
	}
	
	if(empty($doll)) Error('데이터 없음<br><br>NPC, BOSS는 데이터가 존재하지 않습니다.<br> 인형의 경우는 데이터가 안맞는것으로 게시판에 알려주심됩니다.');
	
	$maxlevel = 100;
	if($doll->id > 20000) {
		$maxlevel = 120;
	}
	
	//스킬데이터 불러오기
	$skills = json_decode(file_get_contents("data/skill.json"));
	foreach($skills as $data) {
		if($data->id == $doll->skill->id) {
			$skill = $data;
			break;
		}
	}
	
	//인형 보이스 불러오기
	$audio = [];
	if(file_exists("audio/doll/" . $doll->name) && is_dir("audio/doll/" . $doll->name)) {
		$dir = scandir("audio/doll/" . $doll->name);
		array_shift($dir); array_shift($dir);
		
		$ext = 'opus';
		if(stripos($_SERVER['HTTP_USER_AGENT'], 'Safari') !== false && stripos($_SERVER['HTTP_USER_AGENT'], 'Chrome') == false) {
		   $ext = 'mp3';
		}

		foreach($dir as $filename) {
			$matches;
			if(preg_match ('/.*.acb_000000(.*).opus/', $filename, $matches)) {
				$num = $matches[1];
				if(count($dir) == 80) {
					$audio[audiohex_to_str($num, 0)] = "audio/doll/{$doll->name}/{$doll->name}.acb_000000$num.$ext";
				}
				else if(count($dir) == 82) {
					$audio[audiohex_to_str($num, 1)] = "audio/doll/{$doll->name}/{$doll->name}.acb_000000$num.$ext";
				}
			}
		}
	}
	
	//대사집 불러오기 및 파싱
	$voice = [];
	
	if($lang == "en") {
		$voices = explode(PHP_EOL, file_get_contents("data/charactervoice_en.txt"));
		$voices_fallback = explode(PHP_EOL, file_get_contents("data/charactervoice.txt"));
	} else 
		$voices = explode(PHP_EOL, file_get_contents("data/charactervoice.txt"));

	foreach($voices as $data) {
		if(substr($data, 0, strlen($doll->name . "|")) === $doll->name . "|") {
			$tmp = explode('|', $data);
			$tmp[2] = str_replace('<>', '', $tmp[2]);
			
			if($tmp[1] == 'Introduce') {
				$introduce = $tmp[2];
				continue;
			}
			
			$krcode = audiocode_to_kr($tmp[1]);
			if(isset($audio[$tmp[1]])) {
				$tmp[2] .= ' <button name="playvoice" class="btn btn-sm btn-dark"><i class="far fa-play-circle"></i></button><audio preload="none" src="'. $audio[$tmp[1]] .'"></audio>';
				unset($audio[$tmp[1]]);
				if($lang == 'en') 
					array_push($voice, [$tmp[1], $tmp[2]]);
				else 
					array_push($voice, [$krcode, $tmp[2]]);
			}
			else {
				if($lang == 'en') 
					array_push($voice, [$tmp[1], $tmp[2]]);
				else 
					array_push($voice, [$krcode, $tmp[2]]);
			}
		}
	}
	
	//타 섭에 없는 데이터의 경우 한국데이터를 fallback으로 사용
	if($introduce == '' || !isset($introduce)) {
		foreach($voices_fallback as $data) {
			if(substr($data, 0, strlen($doll->name . "|")) === $doll->name . "|") {
				$tmp = explode('|', $data);
				$tmp[2] = str_replace('<>', '', $tmp[2]);
				
				if($tmp[1] == 'Introduce') {
					$introduce = $tmp[2];
					continue;
				}
				
				$krcode = audiocode_to_kr($tmp[1]);
				if(isset($audio[$tmp[1]])) {
					$tmp[2] .= ' <button name="playvoice" class="btn btn-sm btn-dark"><i class="far fa-play-circle"></i></button><audio preload="none" src="'. $audio[$tmp[1]] .'"></audio>';
					unset($audio[$tmp[1]]);
					array_push($voice, [$tmp[1], $tmp[2]]);
				}
				else {
					array_push($voice, [$tmp[1], $tmp[2]]);
				}
			}
		}
	}
	
	
	foreach($audio as $key => $val) {
		$str = '<button name="playvoice" class="btn btn-sm btn-dark"><i class="far fa-play-circle"></i></button><audio preload="none" src="'.$val.'"></audio>';
		$krcode = audiocode_to_kr($key);
		if($lang == 'en') 
			array_push($voice, [$key, $str]);
		else 
			array_push($voice, [$krcode, $str]);
	}
	
	
	//스킬 파싱
	$replace = [];
	$num = [];
	$skilldata = array();
	preg_match_all("/{([a-zA-Z0-9]{1,})}/", $skill->desc, $matches);
	$i = 0;
	foreach($matches[1] as $match) {
		if(isset($doll->skill->nightDataPool->{$match})){
			array_push($num, "<span class='txthighlight' id='skillattr_$i'>" . end($doll->skill->dataPool->{$match})."</span>(<span class='txthighlight' id='skillattr_night_$i'>".end($doll->skill->nightDataPool->{$match}).'</span>)');
			for($j = 0 ; $j <= sizeof($doll->skill->dataPool->{$match})-1 ; $j++) {
				$skilldata['attr'][$i][$j] = $doll->skill->dataPool->{$match}[$j];
			}
			for($j = 0 ; $j <= sizeof($doll->skill->nightDataPool->{$match})-1 ; $j++) {
				$skilldata['attr_night'][$i][$j] = $doll->skill->nightDataPool->{$match}[$j];
			}
		} else {
			array_push($num, "<span class='txthighlight' id='skillattr_$i'>" . end($doll->skill->dataPool->{$match}) . '</span>');
			for($j = 0 ; $j <= sizeof($doll->skill->dataPool->{$match})-1 ; $j++) {
				$skilldata['attr'][$i][$j] = $doll->skill->dataPool->{$match}[$j];
			}
		}
		array_push($replace, "(\{$match\})");
		$i++;
	}
	$skill->desc = preg_replace($replace, $num, $skill->desc);
	
	if(isset($doll->skill->dataPool->DR)) {
		$duration = end($doll->skill->dataPool->DR);
		if(isset($doll->skill->nightDataPool->DR)) {
			$duration_n = "(<span id='skillduration_n'>". end($doll->skill->nightDataPool->DR) . "</span>)";
			for($i = 0 ; $i <= sizeof($doll->skill->dataPool->DR)-1 ; $i++) {
				$skilldata['duration_n'][$i] = $doll->skill->nightDataPool->DR[$i];
			}
		} else $duration_n = '';
		$skill->desc .= " 지속시간 <span id='skillduration'>{$duration}</span>{$duration_n}초.";
		for($i = 0 ; $i <= sizeof($doll->skill->dataPool->DR)-1 ; $i++) {
			$skilldata['duration'][$i] = $doll->skill->dataPool->DR[$i];
		}
	}
	
	if(isset($doll->skill->dataPool->IC) && isset($doll->skill->dataPool->CD)) {
		if(!is_array($doll->skill->dataPool->CD)) {
			$cooldown = $doll->skill->dataPool->CD;
			$skillcolldown = "초반쿨 : {$doll->skill->dataPool->IC}초, 쿨다운 : <span id='skillcool'>{$cooldown}</span>턴<br>";
		}
		else {
			$cooldown = end($doll->skill->dataPool->CD);
			$skillcolldown = "초반쿨 : {$doll->skill->dataPool->IC}초, 쿨다운 : <span id='skillcool'>{$cooldown}</span>초<br>";
			for($i = 0 ; $i <= sizeof($doll->skill->dataPool->CD)-1 ; $i++) {
				$skilldata['cooldown'][$i] = $doll->skill->dataPool->CD[$i];
			}
		}
	}
	//스킬 야간
	if(isset($skill->night)) {
		$matches = [];
		$replace = [];
		$num = [];
		preg_match_all("/{([a-zA-Z0-9]{1,})}/", $skill->night->desc, $matches);
		$i = 0;
		foreach($matches[1] as $match) {
			array_push($num, "<span class='txthighlight' id='skillattr_n_$i'>" . end($doll->skill->nightDataPool->{$match}) . '</span>');
			array_push($replace, "(\{$match\})");
			for($j = 0 ; $j <= sizeof($doll->skill->nightDataPool->{$match})-1 ; $j++) {
				$skilldata['attr_n'][$i][$j] = $doll->skill->nightDataPool->{$match}[$j];
			}
			$i++;
		}
		
		$skill->night->desc = preg_replace($replace, $num, $skill->night->desc);
		if(isset($doll->skill->nightDataPool->DR)) {
			$duration = end($doll->skill->nightDataPool->DR);
			$skill->night->desc .= " 지속시간 <span id='skillduration_n'>{$duration}</span>초.";
			for($i = 0 ; $i <= sizeof($doll->skill->nightDataPool->DR)-1 ; $i++) {
				$skilldata['duration_n'][$i] = $doll->skill->nightDataPool->DR[$i];
			}
		}
		
		if(isset($doll->skill->nightDataPool->IC) && isset($doll->skill->nightDataPool->CD)) {
			$cooldown = end($doll->skill->nightDataPool->CD);
			$n_skillcolldown = "초반쿨 : {$doll->skill->nightDataPool->IC}초, 쿨다운 : <span id='skillcool_n'>{$cooldown}</span>초<br>";
			for($i = 0 ; $i <= sizeof($doll->skill->dataPool->CD)-1 ; $i++) {
				$skilldata['cooldown_n'][$i] = $doll->skill->dataPool->CD[$i];
			}
		}
	}
	
	//스킬 mod3	
	if(isset($doll->skill2)) {
		foreach($skills as $data) {
			if($data->id == $doll->skill2->id) {
				$skill2 = $data;
				break;
			}
		}
		$matches = [];
		$replace = [];
		$num = [];
		preg_match_all("/{([a-zA-Z0-9]{1,})}/", $skill2->desc, $matches);
		$i = 0;
		foreach($matches[1] as $match) {
			array_push($num, "<span class='txthighlight' id='skillattr_mod3_$i'>" . end($doll->skill2->dataPool->{$match}) . '</span>');
			array_push($replace, "(\{$match\})");
			for($j = 0 ; $j <= sizeof($doll->skill2->dataPool->{$match})-1 ; $j++) {
				$skilldata['attr_mod3'][$i][$j] = $doll->skill2->dataPool->{$match}[$j];
			}
			$i++;
		}
		$skill2->desc = preg_replace($replace, $num, $skill2->desc);
		if(isset($doll->skill2->dataPool->DR)) {
			$duration = end($doll->skill2->dataPool->DR);
			if(isset($doll->skill2->nightDataPool->DR)) {
				$duration_n = "(<span id='skillduration_n_mod3'>". end($doll->skill2->nightDataPool->DR) . "</span>)";
				for($i = 0 ; $i <= sizeof($doll->skill2->dataPool->DR)-1 ; $i++) {
					$skilldata['duration_n_mod3'][$i] = $doll->skill2->nightDataPool->DR[$i];
				}
			}
			$skill2->desc .= " 지속시간 <span id='skillduration_mod3'>{$duration}</span>초.";
			for($i = 0 ; $i <= sizeof($doll->skill2->dataPool->DR)-1 ; $i++) {
				$skilldata['duration_mod3'][$i] = $doll->skill2->dataPool->DR[$i];
			}
		}
		
		if(isset($doll->skill2->dataPool->IC) && isset($doll->skill2->dataPool->CD)) {
			$cooldown = end($doll->skill2->dataPool->CD);
			$mod3_skillcolldown = "초반쿨 : {$doll->skill2->dataPool->IC}초, 쿨다운 : <span id='skillcool_mod3'>{$cooldown}</span>초<br>";
			for($i = 0 ; $i <= sizeof($doll->skill2->dataPool->CD)-1 ; $i++) {
				$skilldata['cooldown_mod3'][$i] = $doll->skill2->dataPool->CD[$i];
			}
		}
	}
	
	//진형효과 진형 불러오기
	$effectpos = ['','','','','','','','','',''];
	$effectpos[$doll->effect->effectCenter] = 'class="center"';
	foreach($doll->effect->effectPos as $pos) {
		$effectpos[$pos] = 'class="affected"';
	}
	
	//진형효과 불러오기
	function parseEffect($eff, $type) {
		$result = "";
		switch($eff->effectType) {
			case 'all': $result .= L::database_buffto(L::database_bufftype_all); break;
			case 'ar': $result .= L::database_buffto(L::database_bufftype_ar); break;
			case 'rf': $result .= L::database_buffto(L::database_bufftype_rf); break;
			case 'smg': $result .= L::database_buffto(L::database_bufftype_smg); break;
			case 'sg': $result .= L::database_buffto(L::database_bufftype_sg); break;
			case 'hg': $result .= L::database_buffto(L::database_bufftype_hg); break;
			case 'mg': $result .= L::database_buffto(L::database_bufftype_mg); break;
		}
		
		if($type == 'hg') {
			if(isset($eff->gridEffect->armor)) { $result .= L::database_buffeff(L::database_buff_armor, $eff->gridEffect->armor*2); }
			if(isset($eff->gridEffect->pow)) { $result .= L::database_buffeff(L::database_buff_pow, $eff->gridEffect->pow*2); }
			if(isset($eff->gridEffect->rate)) { $result .= L::database_buffeff(L::database_buff_rate, $eff->gridEffect->rate*2); }
			if(isset($eff->gridEffect->hit)) { $result .= L::database_buffeff(L::database_buff_hit, $eff->gridEffect->hit*2); }
			if(isset($eff->gridEffect->dodge)) { $result .= L::database_buffeff(L::database_buff_dodge, $eff->gridEffect->dodge*2); }
			if(isset($eff->gridEffect->cooldown)) { $result .= L::database_buffeff_r(L::database_buff_cooldown, $eff->gridEffect->cooldown*2); }
			if(isset($eff->gridEffect->crit)) { $result .= L::database_buffeff(L::database_buff_crit, $eff->gridEffect->crit*2); }
			$result .= '<br>' . L::database_buff_5links;
		}
		else {
			if(isset($eff->gridEffect->armor)) { $result .= L::database_buffeff(L::database_buff_armor, $eff->gridEffect->armor); }
			if(isset($eff->gridEffect->pow)) { $result .= L::database_buffeff(L::database_buff_pow, $eff->gridEffect->pow); }
			if(isset($eff->gridEffect->rate)) { $result .= L::database_buffeff(L::database_buff_rate, $eff->gridEffect->rate); }
			if(isset($eff->gridEffect->hit)) { $result .= L::database_buffeff(L::database_buff_hit, $eff->gridEffect->hit); }
			if(isset($eff->gridEffect->dodge)) { $result .= L::database_buffeff(L::database_buff_dodge, $eff->gridEffect->dodge); }
			if(isset($eff->gridEffect->cooldown)) { $result .= L::database_buffeff_r(L::database_buff_cooldown, $eff->gridEffect->cooldown); }
			if(isset($eff->gridEffect->crit)) { $result .= L::database_buffeff(L::database_buff_crit, $eff->gridEffect->crit); }
		}
		
		return $result;
	}
	
	//스킨 불러오기
	$tmp = file_get_contents("data/skin.txt");
	
	$skins = [];
	$tmpobj = new stdClass;
	$tmpobj->id = 0;
	$tmpobj->name = '기본';
	array_push($skins, $tmpobj);
	$tmps = explode(PHP_EOL, $tmp);
	foreach($tmps as $line) {
		if(preg_match("/.*([0-9]{8}),(.*) - ([^-]*)/", $line, $match)) {
			if($match[2] == "M1개런드") $match[2] = "M1";
			if($match[2] == "웰로드MKII") $match[2] = "Welrod";
			if($match[2] == "엘펠트") $match[2] = "GG_elfeldt";
			if($match[2] == "노엘") $match[2] = "BB_Noel";
			if($match[2] == "그리즐리") $match[2] = "Grizzly";
			if($match[2] == "스텐 MkII") $match[2] = "StenMK2";
			if($match[2] == "리-엔필드") $match[2] = "리엔필드";
			if($match[2] == "키아나") $match[2] = "키아나 카스라나";
			if($match[2] == "브로냐") $match[2] = "브로냐 자이칙";
			if($match[2] == "제레") $match[2] = "제레 발레리";

			if($match[2] == $doll->name || $match[2] == $doll->krName) {
				$tmpobj = new stdClass;
				$tmpobj->id = $match[1] % 10000000;
				$tmpobj->name = $match[3];
				if($tmpobj->name !== '오리지널')
					array_push($skins, $tmpobj);
			}
		}
	}
	
	//스킨 리스트 만들기
	$tmpskin = [];

	for($i = 1 ; $i <= sizeof($skins)-1 ; $i++) {
		array_push($tmpskin, $skins[$i]->name);
		
	}
	$skinstr = implode(', ', $tmpskin);
	if($skinstr == '') $skinstr = 'X';
	
	
	//이미지 불러오기
	$imglist = [];
	$skinlist = [];
	$sdStatus = [];
	$path = 'img/characters/';
	
	foreach($skins as $skin) {
		if($skin->id == 0) {
			array_push($imglist, "$path{$doll->name}/pic/pic_{$doll->name}.png");
			array_push($imglist, "$path{$doll->name}/pic/pic_{$doll->name}_d.png");
			array_push($skinlist, [L::database_defaultskin, 0]);
			
			if(file_exists("$path{$doll->name}/spine/r{$doll->name}.atlas")) $sdStatus[0][0] = 1;
			else $sdStatus[0][0] = 0;
			if(file_exists("$path{$doll->name}/spine/r{$doll->name}.png")) $sdStatus[0][1] = 1;
			else $sdStatus[0][1] = 0;
			if(file_exists("$path{$doll->name}/spine/r{$doll->name}.skel")) $sdStatus[0][2] = 1;
			else $sdStatus[0][2] = 0;
		}
		else {
			array_push($imglist, "$path{$doll->name}_{$skin->id}/pic/pic_{$doll->name}_{$skin->id}.png");
			array_push($imglist, "$path{$doll->name}_{$skin->id}/pic/pic_{$doll->name}_{$skin->id}_d.png");
			array_push($skinlist, [$skin->name, $skin->id]);
			
			if(file_exists("$path{$doll->name}_{$skin->id}/spine/r{$doll->name}_{$skin->id}.atlas")) $sdStatus[$skin->id][0] = 1;
			else $sdStatus[$skin->id][0] = 0;
			if(file_exists("$path{$doll->name}_{$skin->id}/spine/r{$doll->name}_{$skin->id}.png")) $sdStatus[$skin->id][1] = 1;
			else $sdStatus[$skin->id][1] = 0;
			if(file_exists("$path{$doll->name}_{$skin->id}/spine/r{$doll->name}_{$skin->id}.skel")) $sdStatus[$skin->id][2] = 1;
			else $sdStatus[$skin->id][2] = 0;
		}
	}
	
	//live2d 리스트
	$live2dlist = [];
	foreach(array_slice(scandir("img/live2d"), 2) as $dir) {
		foreach(array_slice($skinlist, 1) as $skin_t) {
			if(strtoupper($dir) == strtoupper($doll->name . '_' . $skin_t[1])) {
				array_push($live2dlist, $skin_t[1]);
			}
		}
	}
	if(sizeof($live2dlist) >= 1) {
		$live2d_list = json_encode($live2dlist);
	}
	else {
		$live2d_list = '\'\'';
	}
	
	$header_title =  "" . $doll->name . ", " . $doll->krName . " | 소전 DB";
	$header_desc = "{$doll->krName}, {$doll->krName} 보이스, {$doll->krName} SD, {$doll->krName} 스킨, {$doll->name}, 소녀전선 검열, " . implode(', ', $doll->nick) . ", " . implode(', ', $doll->skin);
	$header_image = "http://gfl.zzzzz.kr/img/characters/" .$doll->name . "/pic/pic_" . $doll->name . "_n.jpg";
	require_once("header.php");
?>
    <main role="main" class="container-fluid">
		<div class="my-1 p-3 bg-white rounded box-shadow">
			<h2 style="display: inline" class="mr-2">#<?=$doll->id?> <?=isset($doll->krName)?$doll->krName:$doll->name?></h2><i><span class="text-muted"><?=$doll->name?></span></i><br>
			<hr class="mt-1 mb-1">
			<div class="row">
				<div class="col-lg-7">
					<div style="display: flex">
						<div style="width:20%;"><input id="damaged_btn" type="checkbox"><label for="damaged_btn"><?=L::database_viewdamaged?></label></div>
						<div style="width:80%;">
							<select style="width:100%;" id="skinselector" autocomplete='off'>
							<?php foreach($skinlist as $skin) { ?>
								<option value="<?=$skin[1]?>"><?=$skin[0]?></option>
							<?php } ?>
							</select>
						</div>
					</div>
					<div class="doll_img" style="max-height: 100%">
						<img skin-id="0" src="img/characters/<?=$doll->name?>/pic/pic_<?=$doll->name?>.png">
					</div>
					<div id="live2d_div" style="display:none">
						<canvas class="d-block" id="glcanvas" style="margin: auto;"></canvas>
						<i data-toggle="tooltip" data-placement="top" title="스크롤(모바일은 터치)로 크기 조정 가능" class="fas fa-info-circle"></i>
						<select id="l2d_motion_sel">
							<option><?=L::database_l2d_motion?></option>
						</select>
					</div>
					<span style="display:none"><input type="checkbox" id="load_live2d"><label for="load_live2d"><?=L::database_l2d_load?></label></span>
				</div>
				<div class="col-lg-5">
					<div style="display: flex">
						<div style="width:20%;"><input id="sdDorm" type="checkbox"><label for="sdDorm"><?=L::database_sd_dorm?></label></div>
						<div style="width:80%;">
							<select style="width:100%;" id="sdAniSelector" autocomplete='off'>
							</select>
						</div>
					</div>
					<div id="sd_div">
						<div class="canvasclick row align-items-center justify-content-center">
							<div class="preCanvas" style="width: 100%; height: 200px"></div>
						</div>
					</div>
					<b><?=L::database_rare?></b> : <?=gunrank_to_img($doll->rank)?><hr class="mt-1 mb-1">
					<b><?=L::database_type?></b> : <?=guntype_to_str($doll->type)?>(<?=strtoupper($doll->type)?>)<hr class="mt-1 mb-1">
					<b><?=L::database_voice?></b> : <?=isset($doll->voice)?$doll->voice:''?><hr class="mt-1 mb-1">
					<b><?=L::database_buildtime?></b> : <?=isset($doll->buildTime)&&$doll->buildTime!=0?gmdate("H시간 i분", $doll->buildTime): L::database_cantbuild?><hr class="mt-1 mb-1">
					<b><?=L::database_skin?></b> : <?=$skinstr?><hr class="mt-1 mb-1">
					<div class="row">
						<div class="col-md-auto align-self-center">
							<b><?=L::database_stats?></b>
						</div>
						<div class="col">
							<table class="table-sm table-bordered ">
								<tr>
									<td><?=L::database_hp?> : <span id="dollstats_hp">-</span></td>
									<td><?=L::database_pow?> : <span id="dollstats_pow">-</span></td>
									<td><?=L::database_hit?> : <span id="dollstats_hit">-</span></td>
									<td><?=L::database_dodge?> : <span id="dollstats_dodge">-</span></td>
								</tr>
								<tr>
									<td><?=L::database_speed?> : <span id="dollstats_speed">-</span></td>
									<td><?=L::database_rate?> : <span id="dollstats_rate">-</span></td>
									<td><?=L::database_ap?> : <span id="dollstats_armorPiercing"><?=$doll->stats->armorPiercing?></span></td>
									<td><?=L::database_crit?> : <span id="dollstats_crit"><?=$doll->stats->crit?>%</span></td>
								</tr>
								<tr>
									<td><?=L::database_armor?> : <span id="dollstats_armor">-</span></td>
									<td><?=L::database_bullet?> : <?=isset($doll->stats->bullet)?$doll->stats->bullet : '- '?><?=L::database_bullet_cnt?></td>
									<td colspan=2>
										<select id="statlevel"><?php for($i = 1 ; $i <= $maxlevel ; $i++) {?>
											<option <?=($i == 100)?'selected' : ''?> value="<?=$i?>"><?=$i?><?=L::level?></option> <?php } ?>
										</select>
										<select id="statfavor">
											<option value="9"><?=L::database_favor?> 0~9</option>
											<option selected value="50"><?=L::database_favor?> 10~89</option>
											<option value="90"><?=L::database_favor?> 90~139</option>
											<option value="140"><?=L::database_favor?> 140~189</option>
											<?php if($maxlevel == 120) { ?>
											<option value="190"><?=L::database_favor?> 190~200</option>
											<?php } ?>
										</select>
									</td>
							</table>
						</div>
					</div>
					<hr class="mt-1 mb-1">
				<?php if($skill->desc !== "사용 불가") { ?>
					<div class="row pb-0">
						<div class="col-md-auto align-self-center">
							<img class="skillimg" src="img/skill/<?=$skill->path?>.png"> <?=isset($doll->skill->name)?$doll->skill->name:$skill->name?>
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
							<?=$skill->desc?><br>
							<?=$skillcolldown?>
						</div>
					</div>
					<hr class="mt-1 mb-1">
				<?php } ?>
				<?php if(isset($skill->night)) { ?>
					<div class="row">
						<div class="col-md-auto align-self-center">
							<img class="skillimg" src="img/skill/<?=$skill->path?>.png"> <?=$skill->name?><br>(야간)
						</div>
						<div class="col">
						<?php if($skill->desc == "사용 불가") { ?>
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
						<?php } ?>
							<?=$skill->night->desc?><br>
							<?=$n_skillcolldown?>
						</div>
					</div>
					<hr class="mt-1 mb-1">
				<?php } ?>
				<?php if(isset($skill2)) { ?>
					<div class="row">
						<div class="col-md-auto align-self-center">
							<img class="skillimg" src="img/skill/<?=$skill->path?>.png"> <?=$skill2->name?$skill2->name:$doll->skill->name?><br>(mod2)
						</div>
						<div class="col">
							<?=$skill2->desc?><br>
							<?=isset($mod3_skillcolldown)?$mod3_skillcolldown:''?>
						</div>
					</div>
					<hr class="mt-1 mb-1">
				<?php } ?>
					<div class="row align-items-center">
						<div class="col-md-auto">
							<table class="skillview">
								<tr>
									<td <?=$effectpos[7]?>></td>
									<td <?=$effectpos[8]?>></td>
									<td <?=$effectpos[9]?>></td>
								</tr>
								<tr>
									<td <?=$effectpos[4]?>></td>
									<td <?=$effectpos[5]?>></td>
									<td <?=$effectpos[6]?>></td>
								</tr>
								<tr>
									<td <?=$effectpos[1]?>></td>
									<td <?=$effectpos[2]?>></td>
									<td <?=$effectpos[3]?>></td>
								</tr>
							</table>
						</div>
						<div class="col">
							<span class="align-middle"><?=parseEffect($doll->effect, $doll->type)?></span>
						</div>
					</div>
					<hr class="mt-1 mb-1">
				</div>
			</div>
			<hr class="mt-1 mb-1">
			<div style="position:relative">
				<a id="desc_gitlink" target="_blank" class="btn btn-link m-0 p-0" style="position:absolute; right:0; top:0" href="https://github.com/jinsung0907/GFDB-character-description/blob/master/dolls/<?=$doll->id?>.txt"><i class="fab fa-github fa-fw"></i> 수정하기</a>
				<span id="doll_desc">불러오는중..</span>
			</div>
			<hr class="mt-1 mb-1">
			<div class="card card-body bg-light mt-3 p-2">
				<?=L::database_introduce?> : <br><?=str_replace("\\n", "<br>" ,$introduce)?>
			</div>
			<div class="card card-body bg-light mt-3 p-0">
				<table class="table">
					<thead>
						<tr style="text-align:center; vertical-align:middle">
							<th style="width: 15%"><?=L::database_situation?></th>
							<th><?=L::database_dialogue?></th>
						</tr>
					</thead>
					<tbody>
					<?php foreach($voice as $dat) { ?>
						<tr>
							<td class="p-1" style="text-align:center; vertical-align:middle"><?=$dat[0]?></td>
							<td class="p-1"  style="vertical-align:middle"><?=$dat[1]?></td>
						</tr>
					<?php } ?>
					</tbody>
				</table>
			</div>
		</div>	
		<div class="my-3 p-3 bg-white rounded box-shadow">
			<!-- 라이브리 시티 설치 코드 -->
			<div id="lv-container" data-id="city" data-uid="MTAyMC8zNjIyNy8xMjc2Mg==">
				<script type="text/javascript">
				window.livereOptions = { refer: '<?=$_SERVER['HTTP_HOST']?><?=$_SERVER['REQUEST_URI']?>' };
			   (function(d, s) {
				   var j, e = d.getElementsByTagName(s)[0];

				   if (typeof LivereTower === 'function') { return; }

				   j = d.createElement(s);
				   j.src = 'https://cdn-city.livere.com/js/embed.dist.js';
				   j.async = true;

				   e.parentNode.insertBefore(j, e);
			   })(document, 'script');
				</script>
			<noscript> 댓글 작성을 위해 JavaScript를 활성화 해주세요</noscript>
			</div>
			<!-- 시티 설치 코드 끝 -->
		</div>
    </main>
<?php
	require_once("footer.php");
?>
	</body>
	<script src="dist/pixi.min.js"></script>
	<script src="dist/pixi-spine.js"></script>
	<script src="dist/jsSpine.js?v=5"></script>
	
	<script>
		var dollname = "<?=$doll->name?>";
		var skilldata = <?=json_encode($skilldata)?>;
		var dollgrow = {"after100":{"basic":{"armor":[13.979,0.04],"hp":[96.283,0.138]},"grow":{"dodge":[0.075,22.572],"hit":[0.075,22.572],"pow":[0.06,18.018],"rate":[0.022,15.741]}},"normal":{"basic":{"armor":[2,0.161],"dodge":[5],"hit":[5],"hp":[55,0.555],"pow":[16],"rate":[45],"speed":[10]},"grow":{"dodge":[0.303,0],"hit":[0.303,0],"pow":[0.242,0],"rate":[0.181,0]}}};
		var dollattr = {"hg":{"hp":0.6,"pow":0.6,"rate":0.8,"speed":1.5,"hit":1.2,"dodge":1.8},"smg":{"hp":1.6,"pow":0.6,"rate":1.2,"speed":1.2,"hit":0.3,"dodge":1.6},"rf":{"hp":0.8,"pow":2.4,"rate":0.5,"speed":0.7,"hit":1.6,"dodge":0.8},"ar":{"hp":1,"pow":1,"rate":1,"speed":1,"hit":1,"dodge":1},"mg":{"hp":1.5,"pow":1.8,"rate":1.6,"speed":0.4,"hit":0.6,"dodge":0.6},"sg":{"hp":2.0,"pow":0.7,"rate":0.4,"speed":0.6,"hit":0.3,"dodge":0.3,"armor":1}};
		var dollstats = <?=json_encode($doll->stats)?>;
		var dolltype = '<?=$doll->type?>';
		var grow = <?=$doll->grow?>;
		var attrlist = ['hp', 'pow', 'hit', 'dodge', 'speed', 'rate', 'armor'];
		var l2d_basepath = "/img/live2d/";
		
		calcstats();
		
		$("#statlevel,#statfavor").on('change', function(e) {
			calcstats();
		});
		
		function calcstats() {
			var level = Number($('#statlevel').val());
			var favor = Number($('#statfavor').val());
			
			var attribute = dollattr[dolltype];

			const basicStats = level > 100 ? {...dollgrow.normal.basic, ...dollgrow.after100.basic} : dollgrow.normal.basic;
			const growStats = level > 100 ? {...dollgrow.normal.grow, ...dollgrow.after100.grow} : dollgrow.normal.grow;
			
			for(var i = 0 ; i <= attrlist.length-1 ; i++) {
				var key = attrlist[i];
				
				var basicData = basicStats[key];
				var growData = growStats[key];
				
				if(typeof dollstats[key] !== 'undefined') {
					if(typeof basicData !== 'undefined') {
						var result = basicData.length > 1 ? Math.ceil((((basicData[0] + ((level - 1) * basicData[1])) * attribute[key]) * dollstats[key]) / 100) : Math.ceil(((basicData[0] * attribute[key]) * dollstats[key]) / 100);

						result += growData ? Math.ceil(((((growData[1] + ((level - 1) * growData[0])) * attribute[key] * dollstats[key]) * grow) / 100) / 100) : 0;
						  
						result += key === 'pow' || key === 'hit' || key === 'dodge' ? Math.sign(getFavorRatio(favor)) * Math.ceil(Math.abs(result * getFavorRatio(favor))) : 0;
					} else {
						result = '-';
					}
				} else {
					result = '-';
				}
				$("#dollstats_" + key).text(result);
			}
		}
		
		$('#skilllevel').on('change', function(e) {
			var level = $('#skilllevel').val()-1;
			if(typeof skilldata.attr !== 'undefined') {
				for(var i = 0 ; i<= skilldata.attr.length-1 ; i++) {
					$("#skillattr_"+i).text(skilldata.attr[i][level]);
				}
				$("#skillduration").text(skilldata.duration[level]);
				if(typeof  skilldata.duration_n !== 'undefined') 
					$("#skillduration_n").text(skilldata.duration_n[level]);
				$("#skillcool").text(skilldata.cooldown[level]);
			}
			if(typeof skilldata.attr_n !== 'undefined') {
				for(var i = 0 ; i<= skilldata.attr_n.length-1 ; i++) {
					$("#skillattr_n_"+i).text(skilldata.attr_n[i][level]);
				}
				$("#skillduration_n").text(skilldata.duration_n[level]);
				if(typeof  skilldata.duration_n !== 'undefined') 
					$("#skillduration_n").text(skilldata.duration_n[level]);
				$("#skillcool_n").text(skilldata.cooldown_n[level]);
			}
			if(typeof skilldata.attr_mod3 !== 'undefined') {
				for(var i = 0 ; i<= skilldata.attr_mod3.length-1 ; i++) {
					$("#skillattr_mod3_"+i).text(skilldata.attr_mod3[i][level]);
				}
				$("#skillduration_mod3").text(skilldata.duration_mod3[level]);
				if(typeof  skilldata.duration_n !== 'undefined') 
					$("#skillduration_n_mod3").text(skilldata.duration_n_mod3[level]);
				$("#skillcool_mod3").text(skilldata.cooldown_mod3[level]);
			}
		});
		
		jspine.init(dollname, 0);
		
		$('.preCanvas').on('click', function(e) {
			var animations = jspine.spine.spineData.animations;
			
			if(typeof animations[jspine.curAniIndex+1] !== 'undefined') {
				if(animations[jspine.curAniIndex+1].name == 'animation' && animations[jspine.curAniIndex+1].duration == 0) {
					if(typeof animations[jspine.curAniIndex+2] !== 'undefined') {
						jspine.changeAnimation(jspine.curAniIndex+2);
						$("#sdAniSelector").val(jspine.curAniIndex+1);
					}
					else {
						if(animations[0].name == 'animation' && animations[0].duration == 0) {
							jspine.changeAnimation(1);
							$("#sdAniSelector").val(1);
						}
						else {
							jspine.changeAnimation(0);
							$("#sdAniSelector").val(0);
						}
					}
				}
				else if(animations[jspine.curAniIndex+1].name == 'victoryloop') {
					if(typeof animations[jspine.curAniIndex+2] !== 'undefined') {
						jspine.changeAnimation(jspine.curAniIndex+2);
						$("#sdAniSelector").val(jspine.curAniIndex);
					}
					else {
						if(animations[0].name == 'animation' && animations[0].duration == 0) {
							jspine.changeAnimation(1);
							$("#sdAniSelector").val(1);
						}
						else {
							jspine.changeAnimation(0);
							$("#sdAniSelector").val(0);
						}
					}
				}
				
				jspine.changeAnimation(jspine.curAniIndex+1);
				$("#sdAniSelector").val(jspine.curAniIndex);
			}
			else {
				if(animations[0].name == 'animation' && animations[0].duration == 0) {
					jspine.changeAnimation(1);
					$("#sdAniSelector").val(1);
				}
				else {
					jspine.changeAnimation(0);
					$("#sdAniSelector").val(0);
				}
			}
		});
		
		function getFavorRatio(favor) {
			if (favor < 10) {
				return -0.05;
			} else if (favor < 90) {
				return 0;
			} else if (favor < 140) {
				return 0.05;
			} else if (favor < 190) {
				return 0.1;
			}
			return 0.15;
		}
		
		$(".doll_img").on('click', function(e) {
			var elem = $(this)[0];
			if (elem.requestFullscreen) {
				elem.requestFullscreen();
			} else if (elem.mozRequestFullScreen) {
				elem.mozRequestFullScreen();
			} else if (elem.webkitRequestFullscreen) {
				elem.webkitRequestFullscreen();
			} else {
				alert('전체화면을 지원하지 않는 기기입니다');
			}
		});
		
		var skinlist = <?=json_encode($skins, JSON_UNESCAPED_UNICODE);?>
		
		$.ajax({
			url: 'https://gfdb.github.io/GFDB-character-description/dolls/<?=$doll->id?>.txt',
			success: function(data) {
				if(data == '') {
					$('#doll_desc').text("정보없음");
					return;
				}
				else {
					var txt = data.replace(/\n/g, "<br>");
					$('#doll_desc').html(txt);
					return;
				}
			},
			error: function(e) {
				if(e.status == 404) {
					$('#doll_desc').text("정보없음");
					$('#desc_gitlink').attr('href', 'https://github.com/GFDB/GFDB-character-description/tree/master/dolls').html('<i class="fab fa-github fa-fw"></i> 추가하기');
					return;
				}
				$('#doll_desc').text("에러발생");
				return;
			}
		});
		
		
		$("button[name=playvoice]").on('click', function(e) {
			$(this).next().get(0).play();
		});
		
		var skinstatus = <?=json_encode($sdStatus)?>;
		$("#skinselector").on('change', function(e) {
			var value = $(this).val();
			var skinnum = value;
			
			if(value == 0)
				var imgsrc = "img/characters/" + dollname + "/pic/pic_" + dollname;
			else 
				var imgsrc = "img/characters/" + dollname + "_" + value + "/pic/pic_" + dollname + "_" + value;
		
			
			$("#damaged_btn").prop("checked", false);

			$(".doll_img img").attr('src', imgsrc + '.png').hide().after("<img style='width:100px' src='img/load.gif'>");
			if(is_live2d(Number(value)))
				$("#load_live2d").parent().show();
			else 
				$("#load_live2d").parent().hide();
			
			if(value == 0) value = '';
			
			if($("#sdDorm").prop('checked'))
				jspine.load(dollname, value, skinstatus[skinnum]);
			else 
				jspine.load(dollname, value);

			$("#live2d_div").hide();
			$(".doll_img").show();
			$("#load_live2d").prop("checked", false);
			
			releaseLive2D();
		});
		
		$("#sdAniSelector").on('change', function(e) {
			jspine.changeAnimation($(this).val());
		});
		$("#sdDorm").change(function() {
			var value = $("#skinselector").val();
			var skinnum = value;
			if(value == 0) value = '';
			
			if($(this).prop("checked")) {
				jspine.load(dollname, value, skinstatus[skinnum]);
				console.log(skinstatus[value]);
			}
			else {
				jspine.load(dollname, value);
			}
		});
			
		$("#damaged_btn").change(function() {
			var value = $("#skinselector").val();
			if(value == 0)
				var imgsrc = "img/characters/" + dollname + "/pic/pic_" + dollname;
			else 
				var imgsrc = "img/characters/" + dollname + "_" + value + "/pic/pic_" + dollname + "_" + value;
			
			if($(this).prop("checked")) {
				$(".doll_img img").attr('src', imgsrc + '_d.png').hide().after("<img style='width:100px'  src='img/load.gif'>");
				changeModel(1);
			}
			else {
				$(".doll_img img").attr('src', imgsrc + '.png').hide().after("<img style='width:100px' src='img/load.gif'>");
				changeModel(0);
			}
		});
		
		var live2d_list = <?=$live2d_list?>;
		function is_live2d(no) {
			for(var i = 0 ; i < live2d_list.length ; i++) {
				if(live2d_list[i] == no) {
					console.log('a');
					return true;
				}
			}
			return false;
		}
		
		$("#skinselector > option").each(function() {
			if(is_live2d(this.value)) 
				this.text += "(Live2D)";
		});
		
		$(".doll_img img").on('load', function() {
			$(this).show().next().remove();
		});
	</script>

	<!-- Live2D Library -->
	<script src="/dist/l2d/live2d.min.js"></script>
	<!-- Live2D Framework -->
	<script src="/dist/l2d/Live2DFramework.js"></script>
	<!-- User's Script -->
	<script src="/dist/l2d/utils/MatrixStack.js"></script>
	<script src="/dist/l2d/utils/ModelSettingJson.js"></script>
	<script src="/dist/l2d/PlatformManager.js"></script>
	<script src="/dist/l2d/LAppDefine.js?v=1"></script>
	<script src="/dist/l2d/LAppModel.js?v=1"></script>
	<script src="/dist/l2d/LAppLive2DManager.js?v=1"></script>
	<script src="/dist/l2d/gfdb_l2d.js?v=3"></script>
	<script>
		var jsonpath = "";
		
		$("#load_live2d").change(function(e) {
			if($(this).prop("checked")) {
				//jspine.stage.removeChildren();
				//jspine = null;
				jsonpath = dollname + '_' + $("#skinselector").val();
				
				//$("#load_live2d").text("로딩...");

				//$("#sd_div").remove();
				//$("#load_live2d").remove();
				$(".doll_img").hide();
				$("#live2d_div").show();
				
				if($("#damaged_btn").prop("checked")) 
					var dam_s = 1;
				else 
					var dam_s = 0;
				startLive2D(dam_s);
			}
			else {
				releaseLive2D();
				$("#live2d_div").hide();
				$(".doll_img").show();
			}
		});
	</script>
</html>