<?php
	define("GF_HEADER", "aaaaa");
	
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
	
	$header_title =  "" . $doll->name . ", " . $doll->krName . " | 소전 DB";
	$header_desc = "소녀전선 SD보기, 소녀전선 스킨 보기, 소녀전선 검열" . $doll->krName . ", ". $doll->name . ", " . implode(', ', $doll->nick) . ", " . implode(', ', $doll->skin);
	require_once("header.php");	
	if(empty($doll)) exit('<main role="main" class="container"><div class="my-3 p-3 bg-white rounded box-shadow">데이터 없음<br><br>NPC, BOSS는 데이터가 존재하지 않습니다.<br> 인형의 경우는 데이터가 안맞는것으로 게시판에 알려주심됩니다.</div></main>');
	
	$maxlevel = 100;
	
	//스킬데이터 불러오기
	$skills = json_decode(file_get_contents("data/skill.json"));
	foreach($skills as $data) {
		if($data->id == $doll->skill->id) {
			$skill = $data;
			break;
		}
	}
	
	//대사집 불러오기 및 파싱
	$voice = [];
	$voices = explode(PHP_EOL, file_get_contents("data/charactervoice.txt"));
	foreach($voices as $data) {
		if(substr($data, 0, strlen($doll->name . "|")) === $doll->name . "|") {
			$tmp = explode('|', $data);
			$tmp[2] = str_replace('<>', '', $tmp[2]);
			
			switch($tmp[1]) {
				case "DIALOGUE1": array_push($voice, ['대화1', $tmp[2]]); break;
				case "DIALOGUE2": array_push($voice, ['대화2', $tmp[2]]); break;
				case "DIALOGUE3": array_push($voice, ['대화3', $tmp[2]]); break;
				case "SOULCONTRACT": array_push($voice, ['서약', $tmp[2]]); break;
				case "Introduce": $introduce = $tmp[2]; break;
				case "ALLHALLOWS": array_push($voice, ['할로윈', $tmp[2]]); break;
				case "DIALOGUEWEDDING": array_push($voice, ['서약대화', $tmp[2]]); break;
				case "CHRISTMAS": array_push($voice, ['크리스마스', $tmp[2]]); break;
				case "HELLO": array_push($voice, ['로그인', $tmp[2]]); break;
				case "SKILL2": array_push($voice, ['스킬2', $tmp[2]]); break;
				case "SKILL3": array_push($voice, ['스킬3', $tmp[2]]); break;
				case "GOATTACK": array_push($voice, ['출격', $tmp[2]]); break;
				case "BREAK": array_push($voice, ['중상', $tmp[2]]); break;
				case "RETREAT": array_push($voice, ['퇴각', $tmp[2]]); break;
				case "FIX": array_push($voice, ['수복', $tmp[2]]); break;
				case "LOWMOOD": array_push($voice, ['탄식', $tmp[2]]); break;
				case "MOOD2": array_push($voice, ['놀람', $tmp[2]]); break;
				case "NEWYEAR": array_push($voice, ['신년', $tmp[2]]); break;
				case "BLACKACTION": array_push($voice, ['자율작전', $tmp[2]]); break;
				case "VALENTINE": array_push($voice, ['발렌타인', $tmp[2]]); break;
				case "ATTACK": array_push($voice, ['공격', $tmp[2]]); break;
				case "MOOD1": array_push($voice, ['웃음', $tmp[2]]); break;
				case "AGREE": array_push($voice, ['동의', $tmp[2]]); break;
				case "ACCEPT": array_push($voice, ['수락', $tmp[2]]); break;
				case "FEED": array_push($voice, ['강화', $tmp[2]]); break;
				case "DEFENSE": array_push($voice, ['방어', $tmp[2]]); break;
				case "OPERATIONOVER": array_push($voice, ['작전종료', $tmp[2]]); break;
				case "COMBINE": array_push($voice, ['편제확대', $tmp[2]]); break;
			}
		}
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
	$effectpos = [];
	$effectpos[$doll->effect->effectCenter] = 'class="center"';
	foreach($doll->effect->effectPos as $pos) {
		$effectpos[$pos] = 'class="affected"';
	}
	
	//진형효과 불러오기
	function parseEffect($eff, $type) {
		$result = "버프칸의 ";
		switch($eff->effectType) {
			case 'all': $result .= '<span class="txthighlight">모든총기</span>'; break;
			case 'ar': $result .= '<span class="txthighlight">돌격소총</span>'; break;
			case 'rf': $result .= '<span class="txthighlight">소총</span>'; break;
			case 'smg': $result .= '<span class="txthighlight">기관단총</span>'; break;
			case 'sg': $result .= '<span class="txthighlight">샷건</span>'; break;
			case 'hg': $result .= '<span class="txthighlight">권총</span>'; break;
			case 'mg': $result .= '<span class="txthighlight">기관총</span>'; break;
		}
		$result .= "에게 ";
		
		if($type == 'hg') {
			if(isset($eff->gridEffect->armor)) { $result .= '장갑 <span class="txthighlight">'.$eff->gridEffect->armor*2 ."%</span>증가 "; }
			if(isset($eff->gridEffect->pow)) { $result .= '화력 <span class="txthighlight">'.$eff->gridEffect->pow*2 ."%</span>증가 "; }
			if(isset($eff->gridEffect->rate)) { $result .= '사속 <span class="txthighlight">'.$eff->gridEffect->rate*2 ."%</span>증가 "; }
			if(isset($eff->gridEffect->hit)) { $result .= '명중 <span class="txthighlight">'.$eff->gridEffect->hit*2 ."%</span>증가 "; }
			if(isset($eff->gridEffect->dodge)) { $result .= '회피 <span class="txthighlight">'.$eff->gridEffect->dodge*2 ."%</span>증가 "; }
			if(isset($eff->gridEffect->cooldown)) { $result .= '스킬 쿨타임 <span class="txthighlight">'.$eff->gridEffect->cooldown*2 ."%</span>감소 "; }
			if(isset($eff->gridEffect->crit)) { $result .= '치명률 <span class="txthighlight">'.$eff->gridEffect->crit*2 ."%</span>증가 "; }
			$result .= '<br>(5편제기준)';
		}
		else {
			if(isset($eff->gridEffect->armor)) { $result .= '장갑 <span class="txthighlight">'.$eff->gridEffect->armor."%</span>증가 "; }
			if(isset($eff->gridEffect->pow)) { $result .= '화력 <span class="txthighlight">'.$eff->gridEffect->pow."%</span>증가 "; }
			if(isset($eff->gridEffect->rate)) { $result .= '사속 <span class="txthighlight">'.$eff->gridEffect->rate."%</span>증가 "; }
			if(isset($eff->gridEffect->hit)) { $result .= '명중 <span class="txthighlight">'.$eff->gridEffect->hit."%</span>증가 "; }
			if(isset($eff->gridEffect->dodge)) { $result .= '회피 <span class="txthighlight">'.$eff->gridEffect->dodge."%</span>증가 "; }
			if(isset($eff->gridEffect->cooldown)) { $result .= '스킬 쿨타임 <span class="txthighlight">'.$eff->gridEffect->cooldown."%</span>감소 "; }
			if(isset($eff->gridEffect->crit)) { $result .= '치명률 <span class="txthighlight">'.$eff->gridEffect->crit."%</span>증가 "; }
		}
		
		return $result;
	}
	
	
	//인형 스탯
	$tmp = json_decode(file_get_contents("data/doll_2.json"));
	foreach($tmp as $data) {
		if($data->id == $doll->id) {
			$dollstat = $data;
			if($doll->type == 'ar') {
				$dollstat->speed = 10;
			}
			if($doll->type == 'rf') {
				$dollstat->speed = 7;
			}
			if($doll->type == 'smg') {
				$dollstat->speed = 12;
			}
			if($doll->type == 'sg') {
				$dollstat->speed = 6;
			}
			if($doll->type == 'hg') {
				$dollstat->speed = 15;
			}
			if($doll->type == 'mg') {
				$dollstat->speed = 4;
			}
			
			if($doll->id > 20000) {
				$dollstat->hp[1] = $dollstat->hp[2];
				$dollstat->dmg[1] = $dollstat->dmg[2];
				$dollstat->hit[1] = $dollstat->hit[2];
				$dollstat->dodge[1] = $dollstat->dodge[2];
				$dollstat->FoR[1] = $dollstat->FoR[2];
				$maxlevel = 120;
			}
			break;
		}	
	}
	
	
	//sd스킨 불러오기
	$tmp = file_get_contents("data/skin.txt");
	
	$skin = [];
	$tmpobj = new stdClass;
	$tmpobj->id = 0;
	$tmpobj->name = '기본';
	array_push($skin, $tmpobj);
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
					array_push($skin, $tmpobj);
			}
		}
	}
	
	//스킨 리스트 만들기
	$tmpskin = [];
	for($i = 1 ; $i <= sizeof($skin)-1 ; $i++) {
		array_push($tmpskin, $skin[$i]->name);
	}
	$skinstr = implode(', ', $tmpskin);
	if($skinstr == '') $skinstr = 'X';
	
	
	//이미지 불러오기
	$imglist = [];
	$path = dirname(__FILE__) . '\\img\\dolls\\';
	if($doll->id > 20000) {
		$id = $doll->id-20000;
		array_push($imglist, $id."_U");
		array_push($imglist, $id."_U_D");
		$i = 0;
		while(true) {
			$i++;
			if(file_exists($path . $id."_{$i}_U.png"))
				array_push($imglist, $id."_{$i}_U");
			else break;
			if(file_exists($path . $id."_{$i}_U_D.png"))
				array_push($imglist, $id."_{$i}_U_D");
			else break;
		}
	}
	else {
		array_push($imglist, $doll->id);
		array_push($imglist, $doll->id."_D");
		$i = 0;
		while(true) {
			$i++;
			if(file_exists($path . $doll->id."_{$i}.png"))
				array_push($imglist, $doll->id."_$i");
			else break;
			if(file_exists($path . $doll->id."_{$i}_D.png"))
				array_push($imglist, $doll->id."_{$i}_D");
			else break;
		}
	}
	
	//live2d 리스트
	switch($doll->id) {
		case 16: $live2d_name = "m1928a1_1501"; break;
		case 20: $live2d_name = "vector_1901"; break;
		case 50: $live2d_name = "mlemk1_604"; break;
		case 65: $live2d_name = "hk416_805"; break;
		case 95: $live2d_name = "88type_1809"; break;
		case 104: $live2d_name = "g36c_1202"; break;
		case 114: $live2d_name = "welrod_1401"; break;
		case 115: $live2d_name = "kp31_310"; break;
		case 129: $live2d_name = "95type_405"; break;
		case 172: $live2d_name = "rfb_1601"; break;
		case 179: $live2d_name = "dsr50_1801"; break;
	}
?>
    <main role="main" class="container">
		<div class="my-3 p-3 bg-white rounded box-shadow">
			<h2 style="display: inline" class="mr-2">#<?=$doll->id?> <?=$doll->krName?$doll->krName:$doll->name?></h2><br><hr class="mt-1 mb-1">
			<div class="row">
				<div class="col-md">
					<div id="dollcarousel" class="carousel slide" data-ride="carousel">
						<div class="carousel-inner">
					<?php $first = true; 
						foreach($imglist as $img) {
							if($first) { $active = "active"; $first = false; } else $active = ""; ?>
							<div class="carousel-item <?=$active?>">
								<img class="d-block w-100" src="img/dolls/<?=$img?>.png">
							</div>
						<?php } ?>
						</div>
						<a class="carousel-control-prev" href="#dollcarousel" role="button" data-slide="prev">
							<span style="font-weight:bold; color:black"><</span>
							<span class="sr-only">Previous</span>
						</a>
						<a class="carousel-control-next" href="#dollcarousel" role="button" data-slide="next">
							<span style="font-weight:bold; color:black">></span>
							<span class="sr-only">Next</span>
						</a>
					</div>
					<br>
					<div id="sd_div">
						<div class="canvasclick row align-items-center justify-content-center">
							<div class="preCanvas" style="width: 100%; height: 200px"></div>
						</div>
						<button id="chg_sdskin">스킨변경</button> <span id="skinname">기본</span>
					</div>
					<?php if(isset($live2d_name)) { ?>
						<button id="load_live2d">Live 2d 로딩</button>
					<?php } ?>
					<div id="live2d_div" style="display:none">
						<canvas class="d-block" id="glcanvas" height="500px" style="margin: auto;"></canvas>
						<i data-toggle="tooltip" data-placement="top" title="스크롤(모바일은 터치)로 크기 조정 가능" class="fas fa-info-circle"></i>
						<select id="l2d_motion_sel">
							<option>---모션선택---</option>
						</select>
						<button id="l2d_toggleModel">일반/중상</button>
					</div>
					<br><br>
				</div>
				<div class="col-md">
					<b>레어도</b> : <?=gunrank_to_img($doll->rank)?><hr class="mt-1 mb-1">
					<b>종류</b> : <?=guntype_to_str($doll->type)?>(<?=strtoupper($doll->type)?>)<hr class="mt-1 mb-1">
					<b>제조시간</b> : <?=$doll->buildTime?gmdate("H시간 i분", $doll->buildTime): "제조 불가"?><hr class="mt-1 mb-1">
					<b>스킨</b> : <?=$skinstr?><hr class="mt-1 mb-1">
					<div class="row">
						<div class="col-md-auto align-self-center">
							<b>스탯</b>
						</div>
						<div class="col">
							<table class="table-sm table-bordered ">
								<tr>
									<td>체력 : <span id="dollstats_hp">-</span></td>
									<td>화력 : <span id="dollstats_pow">-</span></td>
									<td>명중 : <span id="dollstats_hit">-</span></td>
									<td>회피 : <span id="dollstats_dodge">-</span></td>
								</tr>
								<tr>
									<td>기동 : <span id="dollstats_speed">-</span></td>
									<td>사속 : <span id="dollstats_rate">-</span></td>
									<td>관통 : <span id="dollstats_armorPiercing"><?=$doll->stats->armorPiercing?></span></td>
									<td>치명 : <span id="dollstats_crit"><?=$doll->stats->crit?>%</span></td>
								</tr>
								<tr>
									<td>장갑 : <span id="dollstats_armor">-</span></td>
									<td>장탄 : <?=$dollstat->ammoCount ? $dollstat->ammoCount : '- '?>발</td>
									<td colspan=2>
										<select id="statlevel"><?php for($i = 1 ; $i <= $maxlevel ; $i++) {?>
											<option <?=($i == 100)?'selected' : ''?> value="<?=$i?>"><?=$i?>레벨</option> <?php } ?>
										</select>
										<select id="statfavor">
											<option value="9">호감도 0~9</option>
											<option selected value="50">호감도 10~89</option>
											<option value="90">호감도 90~139</option>
											<option value="140">호감도 140~189</option>
											<?php if($maxlevel == 120) { ?>
											<option value="190">호감도 190~200</option>
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
							<img class="skillimg" src="img/skill/<?=$skill->path?>.png"> <?=$doll->skill->name?$doll->skill->name:$skill->name?>
						</div>
						<div class="col">
							<select id="skilllevel">
								<option value="1">1레벨</option>
								<option value="2">2레벨</option>
								<option value="3">3레벨</option>
								<option value="4">4레벨</option>
								<option value="5">5레벨</option>
								<option value="6">6레벨</option>
								<option value="7">7레벨</option>
								<option value="8">8레벨</option>
								<option value="9">9레벨</option>
								<option value="10" selected>10레벨</option>
							</select><br>
							<?=$skill->desc?><br>
							<?=$skillcolldown?>
						</div>
					</div>
				<?php } ?>
				<hr class="mt-1 mb-1">
				<?php if(isset($skill->night)) { ?>
					<div class="row">
						<div class="col-md-auto align-self-center">
							<img class="skillimg" src="img/skill/<?=$skill->path?>.png"> <?=$skill->name?><br>(야간)
						</div>
						<div class="col">
						<?php if($skill->desc == "사용 불가") { ?>
							<select id="skilllevel">
								<option value="1">1레벨</option>
								<option value="2">2레벨</option>
								<option value="3">3레벨</option>
								<option value="4">4레벨</option>
								<option value="5">5레벨</option>
								<option value="6">6레벨</option>
								<option value="7">7레벨</option>
								<option value="8">8레벨</option>
								<option value="9">9레벨</option>
								<option value="10" selected>10레벨</option>
							</select><br>
						<?php } ?>
							<?=$skill->night->desc?><br>
							<?=$n_skillcolldown?>
						</div>
					</div>
				<?php } ?>
				<hr class="mt-1 mb-1">
				<?php if(isset($skill2)) { ?>
					<div class="row">
						<div class="col-md-auto align-self-center">
							<img class="skillimg" src="img/skill/<?=$skill->path?>.png"> <?=$skill2->name?$skill2->name:$doll->skill->name?><br>(mod2)
						</div>
						<div class="col">
							<?=$skill2->desc?><br>
							<?=$mod3_skillcolldown?>
						</div>
					</div>
				<?php } ?>
					<hr class="mt-1 mb-1">
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
				소개말 : <br><?=str_replace("\\n", "<br>" ,$introduce)?>
			</div>
			<div class="card card-body bg-light mt-3 p-0">
				<table class="table">
					<thead>
						<tr style="text-align:center; vertical-align:middle">
							<th style="width: 15%">상황</th>
							<th>대사</th>
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
	<script src="dist/pixi.min.js" integrity="sha256-SHd/r6RKF17vv9979pxDKSRnyI3OLevL+XNsx0Y+ksQ=" crossorigin="anonymous"></script>
	<script src="dist/pixi-spine.js"></script>
	<script src="dist/jsSpine.js"></script>
	
	<script>
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
		
		
		
		jspine.init('<?=$doll->name?>', 0);
		var skin = 0;
		$('#chg_sdskin').on('click', function(e) {
			if(typeof skin === 'undefined') {
				skin = 0;
				$("#skinname").text(skinlist[0].name);
				jspine.load('<?=$doll->name?>', skinlist[0].id);
			} else {
				if(typeof skinlist[skin+1] === 'undefined') {
					skin = 0;
					jspine.load('<?=$doll->name?>', skinlist[0].id);
					$("#skinname").text(skinlist[0].name);
				} else {
					skin++;
					jspine.load('<?=$doll->name?>', skinlist[skin].id);
					$("#skinname").text(skinlist[skin].name);
				}
			}
		});
		
		$('.preCanvas').on('click touchend', function(e) {
			var animations = jspine.spine.spineData.animations;
			
			if(typeof animations[jspine.curAniIndex+1] !== 'undefined') {
				if(animations[jspine.curAniIndex+1].name == 'animation' && animations[jspine.curAniIndex+1].duration == 0) {
					if(typeof animations[jspine.curAniIndex+2] !== 'undefined') {
						jspine.changeAnimation(jspine.curAniIndex+2);
					}
					else {
						if(animations[0].name == 'animation' && animations[0].duration == 0) {
							jspine.changeAnimation(1);
						}
						else 
							jspine.changeAnimation(0);
					}
				}
				jspine.changeAnimation(jspine.curAniIndex+1);
			}
			else {
				if(animations[0].name == 'animation' && animations[0].duration == 0) {
					jspine.changeAnimation(1);
				}
				else 
					jspine.changeAnimation(0);
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
		
		$(".carousel-item img").on('click', function(e) {
			var elem = document.getElementById("dollcarousel");
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
		
		var skinlist = <?=json_encode($skin, JSON_UNESCAPED_UNICODE);?>
		
		$.ajax({
			url: 'https://gfdb.github.io/GFDB-character-description/dolls/<?=$doll->id?>.txt',
			success: function(data) {
				if(data == '') {
					$('#doll_desc').text("정보없음");
					return;
				}
				else {
					console.log(data);
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
	<script src="/dist/l2d/gfdb_l2d.js?v=1"></script>
	<script>
		var jsonpath = "<?=isset($live2d_name)?$live2d_name:''?>";
		
		$("#l2d_toggleModel").on('click', function(e) {
			changeModel();
		});
		
		$("#load_live2d").on('click', function(e) {
			jspine.stage.removeChildren();
			jspine = null;
			
			$("#load_live2d").text("로딩...");

			$("#sd_div").remove();
			$("#load_live2d").remove();
			
			$("#live2d_div").show();
			startLive2D();
		});
	</script>
</html>