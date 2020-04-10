<?php
$starttime = microtime(true);
	define("GF_HEADER", "aaaaa");
	require_once("common.php");
	
	if(empty($_GET['id'])) { header("Location: http://gfl.zzzzz.kr/dolls.php", true, 301); exit();}
	
	switch($_GET['id']) {
		case "스텐MK-2": $_GET['id'] = 29; break;
		case "RO": $_GET['id'] = 143; break;
		case "FN-FNC": $_GET['id'] = 70; break;
		case "노엘": $_GET['id'] = 1001; break;
		case "엘펠트": $_GET['id'] = 1002; break;
		case "416": $_GET['id'] = 65; break;
		case "4식": $_GET['id'] = 270; break;
	}
	
	//인형데이터 불러오기
	$dolls = getJson('doll');
	foreach($dolls as $data) {
		if(is_numeric($_GET['id'])) {
			if($data->id == $_GET['id']) {
				$doll = $data;
				break;
			}
		}
		else {
			if(strtoupper($data->name) == strtoupper($_GET['id']) || strtoupper(getDollName($data)) == strtoupper($_GET['id'])) {
				$_GET['id'] = $data->id;
				$doll = $data;
				break;
			}
		}
	}
	
	if(empty($doll)) Error('데이터 없음(No data)<br><br>NPC, BOSS는 데이터가 존재하지 않습니다.<br> 인형의 경우는 데이터가 안맞는것으로 게시판에 알려주심됩니다.');
	

	$maxlevel = 100;
	if($doll->id > 20000) {
		$maxlevel = 120;
	}
	
	//인형 보이스 불러오기
	$audio = [];
	if(file_exists("audio/" . $doll->name) && is_dir("audio/" . $doll->name)) {
		$dir = scandir("audio/" . $doll->name);
		array_shift($dir); array_shift($dir);
		
		foreach($dir as $filename) {
			if(preg_match ('/' . $doll->name . '_(.*)_JP.mp3/', $filename, $matches)) {
				$code = $matches[1];
                $audio[$code] = "audio/{$doll->name}/$filename";
			}
		}
	}
	//아동절 인형 보이스 불러오기
	$child_audio = [];
	if(file_exists("audio/" . $doll->name . "_0") && is_dir("audio/" . $doll->name . "_0")) {
		$dir = scandir("audio/" . $doll->name . "_0");
		array_shift($dir); array_shift($dir);
		
		foreach($dir as $filename) {
			if(preg_match ('/' . $doll->name . '_0_(.*)_JP.mp3/', $filename, $matches)) {
				$code = $matches[1];
                $child_audio[$code] = "audio/{$doll->name}_0/$filename";
			}
		}
	}
	
	//대사집 불러오기 및 파싱
	$voice = [];
	$child_voice = [];
	
	//한국어가 아니면
	if($lang != "ko") {
		$voices = explode(PHP_EOL, getDataFile("newCharacterVoice", $lang));
		$voices_fallback = explode(PHP_EOL, getDataFile("newCharacterVoice", 'ko'));
	}
	else 
		$voices = explode(PHP_EOL, getDataFile("newCharacterVoice", $lang));

	foreach($voices as $data) {
		if(substr($data, 0, strlen($doll->name . "|")) === $doll->name . "|") {
			$tmp = explode('|', $data);
			$tmp[2] = str_replace('<>', '<br>', $tmp[2]);
			
			if($tmp[1] == 'Introduce') {
				$introduce = $tmp[2];
				continue;
			}
			
			$code = audiocode_to_str($tmp[1]);
			if(isset($audio[$tmp[1]])) {
				$tmp[2] .= ' <button name="playvoice" class="btn btn-sm btn-dark"><i class="far fa-play-circle"></i></button><audio preload="none" src="'. $audio[$tmp[1]] .'"></audio>';
				unset($audio[$tmp[1]]);
				array_push($voice, [$code, $tmp[2]]);
			}
			else {
				array_push($voice, [$code, $tmp[2]]);
			}
		}
	}
     //아동절 대사
    if(!empty($child_audio)) {
        foreach($voices as $data) {
            if(substr($data, 0, strlen($doll->name . "_0|")) === $doll->name . "_0|") {
                $tmp = explode('|', $data);
                $tmp[2] = str_replace('<>', '<br>', $tmp[2]);
                
                if($tmp[1] == 'Introduce') {
                    $introduce = $tmp[2];
                    continue;
                }
                
                $code = audiocode_to_str($tmp[1]);
                if(isset($child_audio[$tmp[1]])) {
                    $tmp[2] .= ' <button name="playvoice" class="btn btn-sm btn-dark"><i class="far fa-play-circle"></i></button><audio preload="none" src="'. $child_audio[$tmp[1]] .'"></audio>';
                    unset($child_audio[$tmp[1]]);
                    array_push($child_voice, [$code, $tmp[2]]);
                }
                else {
                    array_push($child_voice, [$code, $tmp[2]]);
                }
            }
        }
    }
	
	
	
	//타 섭에 없는 데이터의 경우 한국데이터를 fallback으로 사용
	if($introduce == '' || !isset($introduce)) {
		foreach($voices_fallback as $data) {
			if(substr($data, 0, strlen($doll->name . "|")) === $doll->name . "|") {
				$tmp = explode('|', $data);
				$tmp[2] = str_replace('<>', '<br>', $tmp[2])  . "(No $lang voicedata)";;
				
				if($tmp[1] == 'Introduce') {
					$introduce = $tmp[2];
					continue;
				}
				
				if(isset($audio[$tmp[1]])) {
					$tmp[2] .= ' <button name="playvoice" class="btn btn-sm btn-dark"><i class="far fa-play-circle"></i></button><audio preload="none" src="'. $audio[$tmp[1]] .'"></audio>';
					unset($audio[$tmp[1]]);
					array_push($voice, [$tmp[1], $tmp[2]]);
				}
				else {
					array_push($voice, [$tmp[1], $tmp[2]]);
				}
			}
			
			if(substr($data, 0, strlen($doll->name . "_0|")) === $doll->name . "_0|") {
				$tmp = explode('|', $data);
				$tmp[2] = str_replace('<>', '<br>', $tmp[2])  . "(No $lang voicedata)";;
				
				if($tmp[1] == 'Introduce') {
					$introduce = $tmp[2];
					continue;
				}
				
				if(isset($child_audio[$tmp[1]])) {
					$tmp[2] .= ' <button name="playvoice" class="btn btn-sm btn-dark"><i class="far fa-play-circle"></i></button><audio preload="none" src="'. $child_audio[$tmp[1]] .'"></audio>';
					unset($child_audio[$tmp[1]]);
					array_push($child_voice, [$tmp[1], $tmp[2]]);
				}
				else {
					array_push($child_voice, [$tmp[1], $tmp[2]]);
				}
			}
		}
	}

	
	foreach($audio as $key => $val) {
		$str = '<button name="playvoice" class="btn btn-sm btn-dark"><i class="far fa-play-circle"></i></button><audio preload="none" src="'.$val.'"></audio>';
		$code = audiocode_to_str($key);
		array_push($voice, [$code, $str]);
	}
	
	foreach($child_audio as $key => $val) {
		$str = '<button name="playvoice" class="btn btn-sm btn-dark"><i class="far fa-play-circle"></i></button><audio preload="none" src="'.$val.'"></audio>';
		$code = audiocode_to_str($key);
		array_push($child_voice, [$code, $str]);
	}
	
	//스킬 쿨타임 가져오기
	$skilldata = [];
	$skilldata['skill']['cd'] = $doll->skill->cd;
	if(isset($doll->skill2))
		$skilldata['skill2']['cd'] = $doll->skill2->cd;
	
	if(isset($doll->skill->intercd) && isset($doll->skill->cd)) {
		if(!is_array($doll->skill->cd)) {
			$cooldown = $doll->skill->cd;
			$skillcolldown = L::database_intercool . " : {$doll->skill->intercd}" . L::sec . ", " . L::database_cooldown . " : <span id='skillcool'>{$cooldown}</span>" . L::turn . "<br>";
		}
		else {
			$cooldown = end($doll->skill->cd);
			$skillcolldown = L::database_intercool . " : {$doll->skill->intercd}" . L::sec . ", " . L::database_cooldown . " : <span id='skillcool'>{$cooldown}</span>" . L::sec . "<br>";
			for($i = 0 ; $i <= sizeof($doll->skill->cd)-1 ; $i++) {
				$skilldata['cooldown'][$i] = $doll->skill->cd[$i];
			}
		}
	}
	if(isset($doll->skill2->intercd) && isset($doll->skill2->cd)) {
		$cooldown = end($doll->skill2->cd);
		$mod3_skillcolldown = L::database_intercool . " : {$doll->skill2->intercd}" . L::sec . ", " . L::database_cooldown . " : <span id='skillcool_mod3'>{$cooldown}</span>" . L::turn . "<br>";
		for($i = 0 ; $i <= sizeof($doll->skill2->cd)-1 ; $i++) {
			$skilldata['cooldown_mod3'][$i] = $doll->skill2->cd[$i];
		}
	}
	
	//서버 스킬데이터 불러오기
	if($lang != 'ko') {
		$tmp = getDataFile('battle_skill_config', $lang);
		$rskills = explode(PHP_EOL, $tmp);
		if(isset($doll->skill->realid)) {
			$rskill_name = '';
			$rskill_txt = [];
			$i = 0;
			foreach($rskills as $line) {
				preg_match("/battle_skill_config-([0-9])([0-9]{6})([0-9]{2}),(.*)/", $line, $matches);
				$s_level = intval($matches[3]);
				
				if($matches[1] == 1 && $matches[2] == $doll->skill->realid) {
					$rskill_name = explode(',', $rskills[$i])[1];
					$rskill_txt[$s_level] = explode(',', $rskills[$i+2])[1];
					$rskill_txt[$s_level] = str_replace("//c" , ',', $rskill_txt[$s_level]);
					$rskill_txt[$s_level] = str_replace("；" , '<br>', $rskill_txt[$s_level]);
					$rskill_txt[$s_level] = str_replace("//n" , '<br>', $rskill_txt[$s_level]);
					$rskill_txt[$s_level] = preg_replace("/([0-9.]{1,4}[%배초의칸개발회])/u", "<span class='txthighlight'>\\1</span>", $rskill_txt[$s_level]);
					$rskill_txt[$s_level] = preg_replace("/([\+\-0-9.]{1,4}[％倍秒])/u", "<span class='txthighlight'>\\1</span>", $rskill_txt[$s_level]);
					
					if($s_level == 10) break;
				}
				$i++;
			}
		}
		//mod2스킬
		if(isset($doll->skill2->realid)) {
			$rskill2_txt = [];
			$i = 0;
			foreach($rskills as $line) {
				preg_match("/battle_skill_config-([0-9])([0-9]{6})([0-9]{2}),(.*)/", $line, $matches);
				$s_level = intval($matches[3]);
				
				if($matches[1] == 1 && $matches[2] == $doll->skill2->realid) {
					$rskill2_name = explode(',', $rskills[$i])[1];
					$rskill2_txt[$s_level] = explode(',', $rskills[$i+1])[1];
					$rskill2_txt[$s_level] = str_replace("//c" , ',', $rskill2_txt[$s_level]);
					$rskill2_txt[$s_level] = str_replace("；" , '<br>', $rskill2_txt[$s_level]);
					$rskill2_txt[$s_level] = str_replace("//n" , '<br>', $rskill2_txt[$s_level]);
					$rskill2_txt[$s_level] = preg_replace("/ ([\+\-0-9.]{1,4}[%배초의칸개발회])/u", " <span class='txthighlight'>\\1</span>", $rskill2_txt[$s_level]);
					$rskill2_txt[$s_level] = preg_replace("/([\+\-0-9.]{1,4}[％倍秒])/u", "<span class='txthighlight'>\\1</span>", $rskill2_txt[$s_level]);
					
					if($s_level == 10) break;
				}
				$i++;
			}
		}
	}
	
	//만약 해당 언어 스킬 데이터가 없으면 한국 데이터를 불러옴 (한국은 그냥 한국데이터 불러옴)
	if(!isset($rskill_txt) || sizeof($rskill_txt) == 0 || $rskill_name == "") {
		$tmp = getDataFile('battle_skill_config', 'ko');
		$rskills = explode(PHP_EOL, $tmp);
		if(isset($doll->skill->realid)) {
			$rskill_name = '';
			$rskill_txt = [];
			$i = 0;
			foreach($rskills as $line) {
				preg_match("/battle_skill_config-([0-9])([0-9]{6})([0-9]{2}),(.*)/", $line, $matches);
				$s_level = intval($matches[3]);
				
				if($matches[1] == 1 && $matches[2] == $doll->skill->realid) {
					$rskill_name = explode(',', $rskills[$i])[1];
					if($lang != 'ko') {
						$rskill_name .= "(no $lang skilldata)";
					}
					$rskill_txt[$s_level] = explode(',', $rskills[$i+2])[1];
					$rskill_txt[$s_level] = str_replace("//c" , ',', $rskill_txt[$s_level]);
					$rskill_txt[$s_level] = str_replace("；" , '<br>', $rskill_txt[$s_level]);
					$rskill_txt[$s_level] = str_replace("//n" , '<br>', $rskill_txt[$s_level]);
					$rskill_txt[$s_level] = preg_replace("/ ([0-9.]{1,4}[%배초의칸개발회])/u", " <span class='txthighlight'>\\1</span>", $rskill_txt[$s_level]);
					$rskill_txt[$s_level] = preg_replace("/([\+\-0-9.]{1,4}[％倍秒])/u", "<span class='txthighlight'>\\1</span>", $rskill_txt[$s_level]);
					
					if($s_level == 10) break;
				}
				$i++;
			}
		}
	}
	if(!isset($rskill2_txt) || sizeof($rskill2_txt) == 0 || $rskill2_name == "") {
		//mod2스킬
		if(isset($doll->skill2->realid)) {
			$rskill2_txt = [];
			$i = 0;
			foreach($rskills as $line) {
				preg_match("/battle_skill_config-([0-9])([0-9]{6})([0-9]{2}),(.*)/", $line, $matches);
				$s_level = intval($matches[3]);
				
				if($matches[1] == 1 && $matches[2] == $doll->skill2->realid) {
					$rskill2_name = explode(',', $rskills[$i])[1];
					//한국어가아니면 데이터 없다는 안내문구 추가
					if($lang != 'ko') {
						$rskill2_name .= "(no $lang skill2data)";
					}
					$rskill2_txt[$s_level] = explode(',', $rskills[$i+1])[1];
					$rskill2_txt[$s_level] = str_replace("//c" , ',', $rskill2_txt[$s_level]);
					$rskill2_txt[$s_level] = str_replace("；" , '<br>', $rskill2_txt[$s_level]);
					$rskill2_txt[$s_level] = str_replace("//n" , '<br>', $rskill2_txt[$s_level]);
					$rskill2_txt[$s_level] = preg_replace("/([\+\-0-9.]{1,4}[%배초의칸개발회])/u", "<span class='txthighlight'>\\1</span>", $rskill2_txt[$s_level]);
					$rskill2_txt[$s_level] = preg_replace("/([\+\-0-9.]{1,4}[％倍秒])/u", "<span class='txthighlight'>\\1</span>", $rskill2_txt[$s_level]);
					
					if($s_level == 10) break;
				}
				$i++;
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
	$tmp = getDataFile('skin', 'ko');
	
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
			if($match[2] == "스텐 MkⅡ") $match[2] = "StenMK2";
			if($match[2] == "리-엔필드") $match[2] = "리엔필드";
      if($match[2] == "모신-나강") $match[2] = "모신나강";
			if($match[2] == "키아나") $match[2] = "키아나 카스라나";
			if($match[2] == "브로냐") $match[2] = "브로냐 자이칙";
			if($match[2] == "제레") $match[2] = "제레 발레리";
			if($match[2] == "EVO") $match[2] = "EVO3";
			if($match[2] == "카르카노 M1891") $match[2] = "카르카노M1891";
			if($match[2] == "카르카노 M91/38") $match[2] = "카르카노M91/38";
			if($match[2] == "게파드M1") $match[2] = "게파드 M1";
			if($match[2] == "그리즐리 MkV") $match[2] = "Grizzly";
			if($match[2] == "그리즐리 MkⅤ") $match[2] = "Grizzly";

			if(strtolower($match[2]) == strtolower($doll->name) || strtolower($match[2]) == strtolower($doll->krName)) {
				$tmpobj = new stdClass;
				$tmpobj->id = $match[1] % 10000000;
				$tmpobj->name = $match[3];
				if($tmpobj->name !== '오리지널')
					array_push($skins, $tmpobj);
			}
		}
	}
	
	if($lang != 'ko') {
		$tmp = getDataFile('skin', $lang);
		$tmps = explode(PHP_EOL, $tmp);
		$i = 0;
		foreach($skins as $skin) {
			foreach($tmps as $line) {
        $exp = "/skin-1([0-9]{7})([,])(.*)/";
				if(preg_match($exp, $line, $match)) {
					$id = $match[1] % 10000000;
					if($skin->id == $id) {
						$tmpname = str_replace('//c', ',', $match[3]);
            if($tmpname !== '') {
              $skins[$i]->name = $tmpname;
            }
					}
				}
			}
			$i++;
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
  $skinnames = [];
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
      array_push($skinnames, $skin->name);
			
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
	
	//이름구하기
	$dollname = getDollName($doll);

	$header_title = getDollName($doll) . " | " . L::sitetitle_short;
	$header_desc = L::title_doll_desc($dollname);
	$header_keyword = "$dollname, $dollname 소전, $dollname 소녀전선, $dollname 보이스, $dollname SD, $dollname 스킨, {$doll->name}, 소녀전선 검열, " . implode(', ', $skinnames);
	$header_image = "http://gfl.zzzzz.kr/img/characters/" .$doll->name . "/pic/pic_" . $doll->name . "_n.jpg";

	
	//제조가 안되는 인형에도 제조시간이 붙어있으므로 obtain값을 이용하여 제거해야함
	$exp = explode(',', $doll->drop);
	$chk = false;
	foreach($exp as $ex) {
		if($ex == 1 || $ex == 2)
			$chk = true;
	}
	if($chk == false) 
		$doll->buildTime = 0;
	
	
	$obtain = '';
	//obtain파싱
	$tmps = explode(PHP_EOL, getDataFile('gun_obtain', $lang));
	foreach($exp as $ex) {
		foreach($tmps as $line) {
			$preg = "/gun_obtain-1([0-9]{7}),(.*)/";
			if(preg_match($preg, $line, $match)) {
				$id = $match[1] % 10000000;
				if($id == $ex) {
					$obtain .= str_replace('//c', ',', $match[2]) . '<br>';
					break;
				}
			}
		}
	}
	
	if(empty($obtain)) {
		$obtain = 'No Information';
	}
	
	require_once("header.php");
?>
    <main role="main" class="container-fluid">
		<div class="my-1 p-3 bg-white rounded box-shadow">
			<h2 style="display: inline" class="mr-2">#<?=$doll->id?> <?=$dollname?></h2><i><span class="text-muted"><?=$doll->name?></span></i><br>
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
					<span style="display:none"><input type="checkbox" id="load_live2d"><label for="load_live2d"><?=L::database_l2d_load?></label></span>
					<select id="l2d_motion_sel" style="display:none">
						<option><?=L::database_l2d_motion?></option>
					</select>
					<div class="doll_img" style="max-height: 100%">
						<img skin-id="0" src="img/characters/<?=$doll->name?>/pic/pic_<?=$doll->name?>.png">
					</div>
					<div id="live2d_div" style="display:none">
						<canvas class="d-block" id="glcanvas" style="margin: auto;"></canvas>
					</div>
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
							<div class="preCanvas" style="width: 100%; height: 300px"></div>
						</div>
					</div>
					<div class="row">
						<div class="col">
							<b><?=L::database_rare?></b> : <?=gunrank_to_img($doll->rank)?>
						</div>
						<div class="col">
							<b><?=L::database_type?></b> : <?=guntype_to_str($doll->type)?>(<?=strtoupper($doll->type)?>)
						</div>
					</div>
					<hr class="mt-1 mb-1">
					<div class="row">
						<div class="col">
							<b><?=L::database_illust?></b> : <?=isset($doll->illust)?$doll->illust:''?>
						</div>
						<div class="col">
							<b><?=L::database_voice?></b> : <?=isset($doll->voice)?$doll->voice:''?>
						</div>
					</div>
					<hr class="mt-1 mb-1">
					<div class="row">
						<div class="col">
							<b><?=L::database_buildtime?></b> : <?=isset($doll->buildTime)&&$doll->buildTime!=0?gmdate("H\\" . L::hour . " i\\" . L::min, $doll->buildTime): L::database_cantbuild?>
						</div>
						<div class="col">
							<b><?=L::database_obtain?></b> : <i class="fas fa-info-circle" data-toggle="tooltip" data-html="true" data-placement="top" title="<?=$obtain?>"></i>
						</div>
					</div>
					<hr class="mt-1 mb-1">
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
					<div class="row pb-0">
						<div class="col-md-auto align-self-center">
							<img class="skillimg rounded" src="img/skill/<?=$doll->skill->code?>.png"> <?=$rskill_name?>
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
				<?php if(isset($doll->skill2)) { ?>
					<div class="row">
						<div class="col-md-auto align-self-center">
							<img class="skillimg" src="img/skill/<?=$doll->skill2->code?>.png"> <?=$rskill2_name?><br>(mod2)
						</div>
						<div class="col">
							<span id="skill2_txt"><?=$rskill2_txt[10]?></span><br>
							<?=isset($doll->skill2->cd) && $doll->skill2->cd[9] != 0?$mod3_skillcolldown:''?>
						</div>
					</div>
					<hr class="mt-1 mb-1">
				<?php } ?>
					<div class="row align-items-center">
						<div class="col-md-auto">
							<table class="skillview">
								<tr>
									<td <?=$effectpos[3]?>></td>
									<td <?=$effectpos[6]?>></td>
									<td <?=$effectpos[9]?>></td>
								</tr>
								<tr>
									<td <?=$effectpos[2]?>></td>
									<td <?=$effectpos[5]?>></td>
									<td <?=$effectpos[8]?>></td>
								</tr>
								<tr>
									<td <?=$effectpos[1]?>></td>
									<td <?=$effectpos[4]?>></td>
									<td <?=$effectpos[7]?>></td>
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
				<a id="desc_gitlink" target="_blank" class="btn btn-link m-0 p-0" style="position:absolute; right:0; top:0" href="https://github.com/jinsung0907/GFDB-character-description/blob/master/dolls/<?=$doll->id?>.txt"><i class="fab fa-github fa-fw"></i> <?=L::database_modify?></a>
				<b><?=L::database_dollinfo?></b><br>
				 <span id="doll_desc"><?=L::database_loading?></span>
			</div>
			<hr class="mt-1 mb-1">
			<div class="card card-body bg-light mt-3 p-2">
				<?=L::database_introduce?> : <br><?=str_replace("\\n", "<br>" ,$introduce)?>
			</div>
			<div class="row">
				<div class="col-lg">
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
						<?php if(!empty($child_voice)) { ?>
						<table class="table">
							<thead>
								<tr style="text-align:center; vertical-align:middle">
									<th style="width: 15%"><?=L::database_situation?></th>
									<th><?=L::database_child_dialogue?></th>
								</tr>
							</thead>
							<tbody>
							<?php foreach($child_voice as $dat) { ?>
								<tr>
									<td class="p-1" style="text-align:center; vertical-align:middle"><?=$dat[0]?></td>
									<td class="p-1"  style="vertical-align:middle"><?=$dat[1]?></td>
								</tr>
							<?php } ?>
							</tbody>
						</table>
                        <?php } ?>
					</div>
				</div>
				<div class="col-lg">
					<div class="card card-body bg-light mt-3 p-0 table-responsive">
						<table id="buildtable" class="table table-striped">
							<thead>
								<tr style="text-align:center; vertical-align:middle">
									<th><?=L::database_mp?></th>
									<th><?=L::database_ammo?></th>
									<th><?=L::database_mre?></th>
									<th><?=L::database_part?></th>
									<th><?=L::database_percent?></th>
								</tr>
							</thead>
							<tbody>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>	
		<div class="my-3 p-3 bg-white rounded box-shadow">
			<?php 
			if($_GET['id'] != 179 && $_GET['id'] != 42) { ?>
			<ins class="adsbygoogle"
			 style="display:block; text-align:center"
			 data-ad-client="ca-pub-6637664198779025"
			 data-ad-slot="3111645353"
			 data-ad-format="auto"
			 data-full-width-responsive="true"></ins>
		</div>
		<?php } ?>
    </main>
<?php
	require_once("footer.php");
?>
	</body>
	<script src="dist/pixi.min.js"></script>
	<script src="dist/pixi-spine.js"></script>
	<script src="dist/jsSpine.js?v=5"></script>
	
	<script>
		var dollid = <?=$doll->id?>;
		var dollname = "<?=$doll->name?>";
		var skilldata = <?=json_encode($skilldata)?>;
		var dollgrow = {"after100":{"basic":{"armor":[13.979,0.04],"hp":[96.283,0.138]},"grow":{"dodge":[0.075,22.572],"hit":[0.075,22.572],"pow":[0.06,18.018],"rate":[0.022,15.741]}},"normal":{"basic":{"armor":[2,0.161],"dodge":[5],"hit":[5],"hp":[55,0.555],"pow":[16],"rate":[45],"speed":[10]},"grow":{"dodge":[0.303,0],"hit":[0.303,0],"pow":[0.242,0],"rate":[0.181,0]}}};
		var dollattr = {"hg":{"hp":0.6,"pow":0.6,"rate":0.8,"speed":1.5,"hit":1.2,"dodge":1.8},"smg":{"hp":1.6,"pow":0.6,"rate":1.2,"speed":1.2,"hit":0.3,"dodge":1.6},"rf":{"hp":0.8,"pow":2.4,"rate":0.5,"speed":0.7,"hit":1.6,"dodge":0.8},"ar":{"hp":1,"pow":1,"rate":1,"speed":1,"hit":1,"dodge":1},"mg":{"hp":1.5,"pow":1.8,"rate":1.6,"speed":0.4,"hit":0.6,"dodge":0.6},"sg":{"hp":2.0,"pow":0.7,"rate":0.4,"speed":0.6,"hit":0.3,"dodge":0.3,"armor":1}};
		var dollstats = <?=json_encode($doll->stats)?>;
		var dolltype = '<?=$doll->type?>';
		var grow = <?=$doll->grow?>;
		var attrlist = ['hp', 'pow', 'hit', 'dodge', 'speed', 'rate', 'armor'];
		var l2d_basepath = "/img/live2d/";
		var r_skilldata = <?=json_encode($rskill_txt, JSON_UNESCAPED_UNICODE)?>;
		var r_skill2data = <?=isset($rskill2_txt) ? json_encode($rskill2_txt, JSON_UNESCAPED_UNICODE) : 'null'?>;
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
			var level = $('#skilllevel').val();
			$("#skill_txt").html(r_skilldata[level]);
			if(r_skill2data != null) {
				$("#skill2_txt").html(r_skill2data[level]);
			}
			level--;
			if(typeof skilldata.skill !== 'undefined') {
				$("#skillcool").text(skilldata.skill.cd[level]);
			}
			if(typeof skilldata.skill2 !== 'undefined') {
				$("#skillcool_mod3").text(skilldata.skill2.cd[level]);
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
			url: 'https://jinsung0907.github.io/GFDB-character-description/dolls/' + dollid + '.txt',
			success: function(data) {
				if(data == '') {
					$('#doll_desc').text("<?=L::database_noinfo?>");
					return;
				}
				else {
					var txt = data.replace(/\n/g, "<br>");
					txt = Autolinker.link(txt);
					$('#doll_desc').html(txt);
					return;
				}
			},
			error: function(e) {
				if(e.status == 404) {
					$('#doll_desc').text("<?=L::database_noinfo?>");
					$('#desc_gitlink').attr('href', 'https://github.com/jinsung0907/GFDB-character-description/tree/master/dolls').html('<i class="fab fa-github fa-fw"></i> <?=L::database_addinfo?>');
					return;
				}
				$('#doll_desc').text("Error");
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

			$("#l2d_motion_sel").hide();
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
		
		$.ajax({
			url: 'doll_ajax.php?id=' + dollid,
			success: function(data) {
				if(data == '') {
					$("#buildtable tbody").html("<tr style='text-align:center'><td colspan=5>No data</td></tr>");
					return;
				}
				else {
					$("#buildtable tbody").html(data);
					return;
				}
			},
			error: function(e) {
				if(e.status == 404) {
					$("buildtable tbody").html("<tr><td cols=5>No data</td></tr>");
					return;
				}
				$("buildtable tbody").html("<tr><td cols=5>No data</td></tr>");
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
	<script src="/dist/l2d/utils/ModelSettingJson.js?v=1"></script>
	<script src="/dist/l2d/PlatformManager.js"></script>
	<script src="/dist/l2d/LAppDefine.js?v=1"></script>
	<script src="/dist/l2d/LAppModel.js?v=1"></script>
	<script src="/dist/l2d/LAppLive2DManager.js"></script>
	<script src="/dist/l2d/gfdb_l2d.js"></script>
	
	<script src="https://cdnjs.cloudflare.com/ajax/libs/autolinker/1.7.1/Autolinker.min.js" integrity="sha256-yZXU/f+V8xVBqX0cCVVySvxvjU6h8uuQb1N0e8jRvhE=" crossorigin="anonymous"></script>
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
				$("#l2d_motion_sel").show();
				
				if($("#damaged_btn").prop("checked")) 
					var dam_s = 1;
				else 
					var dam_s = 0;
				startLive2D(dam_s);
			}
			else {
				releaseLive2D();
				$(l2d_motion_sel).hide();
				$("#live2d_div").hide();
				$(".doll_img").show();
			}
		});
	</script>
<?php echo microtime(true) - $starttime; ?>
</html>