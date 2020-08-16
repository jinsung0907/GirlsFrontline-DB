<?php
if(GF_HEADER != "aaaaa") exit; 
session_start();

if(isset($_GET['lang'])) {
	if($_GET['lang'] == 'en') {
		$_SESSION['lang'] = 'en';
	}
	else if($_GET['lang'] == 'ja') {
		$_SESSION['lang'] = 'ja';
	}
	else if($_GET['lang'] == 'zh') {
		$_SESSION['lang'] = 'zh';
	}
	else if($_GET['lang'] == 'ko') {
		$_SESSION['lang'] = 'ko';
	}
}

/*언어 처리 우선순위
1. session값 2. http언어값*/
if(isset($_SESSION['lang'])) {
	if($_SESSION['lang'] == 'en' || $_SESSION['lang'] == 'en-US')
		$lang = 'en';
	else if($_SESSION['lang'] == 'ja')
		$lang = 'ja';
	else if($_SESSION['lang'] == 'zh')
		$lang = 'zh';
	else 
		$lang = 'ko';
}
else {
	$langs = explode(',', $_SERVER['HTTP_ACCEPT_LANGUAGE']);
	if($langs[0] == "en" || $langs[0] == "en-US")
		$lang = 'en';
	else if(strtolower($langs[0]) == "ja" || strtolower($langs[0]) == "ja-jp")
		$lang = 'ja';
	else if(strtolower($langs[0]) == "zh" || strtolower($langs[0]) == "zh-hans" || strtolower($langs[0]) == "zh-hant")
		$lang = 'zh';
	else 
		$lang = 'ko';
}

require_once "i18n.class.php";
$i18n = new i18n('data/lang/lang_{LANGUAGE}.ini', 'data/lang/cache/', 'ko');
$i18n->init();
//언어 처리 끝

function getJson($file) {
	return json_decode(file_get_contents("data/json/$file.json"));
}
function getDataFile($file, $lang) {
	if(!$lang) 
		$lang = 'ko';
	return file_get_contents("data/gamedata/$lang/$file.txt");
}
/*
function getDollJson() {
	return file_get_contents("data/json/doll.json");
}
function getSquadJson() {
	return file_get_contents("data/json/squad.json");
}
function getSkillJson() {
	return file_get_contents("data/json/skill.json");
}
function getEquipJson() {
	return file_get_contents("data/json/equip.json");
}
function getFairyJson() {
	return file_get_contents("data/json/fairy.json");
}
function getFurnJson() {
	return file_get_contents("data/json/furniture.json");
}
function getSubstoryJson(){
	return file_get_contents("data/json/substory.json");
}

function getVoiceDataFile($lang) {
	return file_get_contents("data/gamedata/$lang/CharacterVoice.txt");
}
function getFairyDataFile($lang) {
	return file_get_contents("data/gamedata/$lang/fairy.txt");
}
function getFurnDataFile($lang) {
	return file_get_contents("data/gamedata/$lang/furniture.txt");
}
function getFurnclassDataFile($lang) {
	return file_get_contents("data/gamedata/$lang/furniture_classes.txt");
}
function getSkillDataFile($lang) {
	return file_get_contents("data/gamedata/$lang/battle_skill_config.txt");
}
function getmSkillDataFile($lang) {
	return file_get_contents("data/gamedata/$lang/mission_skill_config.txt");
}
function getSkinDataFile($lang) {
	return file_get_contents("data/gamedata/$lang/skin.txt");
}
*/
function getBGM($id) {
	global $bgms;
  $list = explode(PHP_EOL, $bgms);
	foreach($list as $bgm) {
    $tmp = explode('|', $bgm);
    
    if(sizeof($tmp) === 1) continue;
    
		if($tmp[1] == $id || $tmp[2] == $id) {
			return $tmp[2] . "/" . $tmp[2] .".mp3";
		}
	}
}

function getDollNameLang($doll, $lang) {
	if($lang == 'ja') 
		return isset($doll->jpName)?$doll->jpName:$doll->name;
	else if($lang == 'en') 
		return isset($doll->enName)?$doll->enName:$doll->name;
	else if($lang == 'zh') 
		return isset($doll->cnName)?$doll->cnName:$doll->name;
	else
		return isset($doll->krName)?$doll->krName:$doll->name;
}
function getEquipNameLang($equip, $lang) {
	if($lang == 'ja') 
		return isset($equip->jpName)?$equip->jpName:$equip->name;
	else if($lang == 'en') 
		return isset($equip->enName)?$equip->enName:$equip->name;
	else if($lang == 'zh') 
		return isset($equip->cnName)?$equip->cnName:$equip->name;
	else
		return isset($equip->krName)?$equip->krName:$equip->name;
}

function getFairyNameLang($fairy, $lang) {
	if($lang == 'ja') 
		return isset($fairy->jpName)?$fairy->jpName:$fairy->name;
	else if($lang == 'en') 
		return isset($fairy->enName)?$fairy->enName:$fairy->name;
	else if($lang == 'zh') 
		return isset($fairy->cnName)?$fairy->cnName:$fairy->name;
	else
		return isset($fairy->krName)?$fairy->krName:$fairy->name;
}

function getDollName($doll) {
	global $lang;
	
	if($lang == 'ja') 
		return isset($doll->jpName) && $doll->jpName != ""?$doll->jpName:$doll->name;
	else if($lang == 'en') 
		return isset($doll->enName) && $doll->enName != ""?$doll->enName:$doll->name;
	else if($lang == 'zh') 
		return isset($doll->cnName) && $doll->cnName != ""?$doll->cnName:$doll->name;
	else
		return isset($doll->krName) && $doll->krName != ""?$doll->krName:$doll->name;
}

function getEquipName($equip) {
	global $lang;
	
	if($lang == 'ja') 
		return isset($equip->jpName)?$equip->jpName:$equip->name;
	else if($lang == 'en') 
		return isset($equip->enName)?$equip->enName:$equip->name;
	else if($lang == 'zh') 
		return isset($equip->cnName)?$equip->cnName:$equip->name;
	else
		return isset($equip->krName)?$equip->krName:$equip->name;
}

function getFairyName($fairy, $datafile) {
	foreach($datafile as $data) {
		if(strpos($data, $fairy->name) !== false) {
			$tmp = explode(',', $data);
			return $tmp[1];
		}
	}
}

function getFairyType($type) {
	switch($type) {
		case 1: return "비전투";
		case 2: return "전투 및 공격 속성 클래스";
		case 3: return "전투 방어";
		case 4: return "직접적인 부상";
		case 5: return "강화";
		case 6: return "캠페인";
	}
}

//에러 페이지
function Error($str) {
	require_once("header.php");
		echo '<main role="main" class="container">
		<div class="my-3 p-3 bg-white rounded box-shadow">
			ERROR : ' . $str . '
		</div>
    </main>';
	require_once("footer.php");
	exit;
}

//스토리 색상코드 사이트에 맞춰 짙게 변경
function color_callback($matches) {
  $colors[0] = dechex(hexdec(substr($matches[1], 0, 2)) - 50);
  $colors[1] = dechex(hexdec(substr($matches[1], 2, 2)) - 50);
  $colors[2] = dechex(hexdec(substr($matches[1], 4, 2)) - 50);
  
  for($i = 0 ; $i<3 ; $i++) {
    $num = hexdec(substr($matches[1], $i*2, 2)) - 45;
    if($num < 0) 
      $num = 0;
    $colors[$i] = sprintf("%02X", $num);
  }
  $color = $colors[0] . $colors[1] . $colors[2];
  return "<span style='color:#{$color}'>{$matches[2]}</span>";
}

//캐릭 보이스 코드 -> 한국어 변환
function audiocode_to_str($code) {
	global $lang;
	if($lang != "ko") {
		return $code;
	}
	else {
		switch($code) {
			case "DIALOGUE1":					return '대화1'; break;
			case "DIALOGUE2":					return '대화2'; break;
			case "DIALOGUE3":					return '대화3'; break;
			case "SOULCONTRACT":			return '서약'; break;
			case "Introduce":					return '소개말'; break;
			case "ALLHALLOWS":				return '할로윈'; break;
			case "DIALOGUEWEDDING":		return '서약대화'; break;
			case "CHRISTMAS":					return '성탄절'; break;
			case "HELLO":						return '로그인'; break;
			case "SKILL1":						return '스킬1'; break;
			case "SKILL2":						return '스킬2'; break;
			case "SKILL3":						return '스킬3'; break;
			case "GOATTACK":					return '출격'; break;
			case "BREAK":						return '중상'; break;
			case "RETREAT":						return '퇴각'; break;
			case "FIX":							return '수복'; break;
			case "LOWMOOD":					return '탄식'; break;
			case "MOOD2":						return '놀람'; break;
			case "NEWYEAR":					return '새해'; break;
			case "BLACKACTION":				return '자율작전'; break;
			case "VALENTINE":					return '발렌타인'; break;
			case "ATTACK":						return '공격'; break;
			case "MOOD1":						return '웃음'; break;
			case "AGREE":						return '동의'; break;
			case "ACCEPT":						return '수락'; break;
			case "FEED":							return '강화완료'; break;
			case "DEFENSE":						return '방어'; break;
			case "OPERATIONOVER":			return '지원복귀'; break;
			case "COMBINE":					return '편제확대'; break;
			case "GAIN":							return '획득'; break;
			case "APPRECIATE":					return '감사'; break;
			case "BUILDOVER":					return '제조완료'; break;
			case "FEELING":						return 'FEELING'; break;
			case "FORMATION":				return '제대편성'; break;
			case "LOADING":					return '로딩'; break;
			case "MEET":							return '적 조우'; break;
			case "OPERATIONBEGIN":			return '지원출발'; break;
			case "PHRASE":						return '말버릇(어구)'; break;
			case "TANABATA":					return '칠석'; break;
			case "TIP":							return 'TIP'; break;
			case "TITLECALL":					return '소녀전선'; break;
			case "WIN":							return '승리'; break;
		}
	}
}

//acb 16진수 -> 오디오코드 변환
function audiohex_to_str($hex, $type) {
	//type 0 -> 40개 보이스
	//type 1 -> 41개 보이스
	
	$arr = [
		'ACCEPT',
		'AGREE',
		'ALLHALLOWS',
		'APPRECIATE',
		'ATTACK',
		'BLACKACTION',
		'BREAK',
		'BUILDOVER',
		'CHRISTMAS',
		'COMBINE',
		'DEFENSE',
		'DIALOGUE1',
		'DIALOGUE2',
		'DIALOGUE3',
		'DIALOGUEWEDDING',
		'FEED',
		'FEELING',
		'FIX',
		'FORMATION',
		'GAIN',
		'GOATTACK',
		'HELLO',
		'LOADING',
		'LOWMOOD',
		'MEET',
		'MOOD1',
		'MOOD2',
		'NEWYEAR',
		'OPERATIONBEGIN',
		'OPERATIONOVER',
		'PHRASE',
		'RETREAT',
		'SKILL1',
		'SKILL2',
		'SKILL3',
		'SOULCONTRACT',
		'TANABATA',
		'TIP',
		'TITLECALL',
		'VALENTINE',
		'WIN'
	];
	
	if($type == 0) {
		array_splice($arr, 14, 1);
	}
	
	$no = hexdec($hex);
	
	return $arr[$no];
}

//인형 타입 출력
function fairytype_to_str($type) {
	if($type == 2) {
		return L::fairy_type_tactical;
	}
	else if($type == 1) {
		return L::fairy_type_battle;
	}
}

//인형 별 개수에 따라 반복출력
function gunrank_to_img($rank) {
	$result = "";
	for($i = 1 ; $i<= $rank ; $i++) {
		$result .= '<img style="width:2vh" src="img/rank.png">';
	}
	return $result;
}

//총기 코드 변환
function guntype_to_str($type) {
	global $lang;
	$type = strtolower($type);
	if($lang == 'en') {
		switch($type) {
			case 'ar': return "Assault Rifle";
			case 'rf': return "Rifle";
			case 'smg': return "Submachine Gun";
			case 'mg': return "Machine Gun";
			case 'sg': return "Shotgun";
			case 'hg': return "Handgun";
		}
	}
	else if($lang == 'ja') {
		switch($type) {
			case 'ar': return "アサルトライフル";
			case 'rf': return "ライフル";
			case 'smg': return "サブマシンガン";
			case 'mg': return "マシンガン";
			case 'sg': return "ショットガン";
			case 'hg': return "ハンドガン";
		}
	}
	else {
		switch($type) {
			case 'ar': return "돌격소총";
			case 'rf': return "소총";
			case 'smg': return "기관단총";
			case 'mg': return "기관총";
			case 'sg': return "샷건";
			case 'hg': return "권총";
		}
	}
}

//스토리용 요정 이미지 불러오기
function getcharimgdir_fairy($str, $emo) {
	if($str == "DJMAXSUEE") {
		switch($emo) {
			case 0: return "fairy/djmaxsuee_1"; break;
		}
	}
	else if($str == "DJMAXSEHRA") {
		switch($emo) {
			case 0: return "fairy/djmaxsehra_1"; break;
		}
	}
	else if($str == "DJMAXPREIYA") {
		switch($emo) {
			case 0: return "fairy/djmaxpreiya_1"; break;
		}
	}
	else if($str == "FairyWarrior") {
		switch($emo) {
			case 0: return "fairy/fighting_1"; break;
		}
	}
	else if($str == "FairyTaunt") {
		switch($emo) {
			case 0: return "fairy/target_1"; break;
			case 1: return "fairy/target_2"; break;
			case 2: return "fairy/target_3"; break;
		}
	}
	else if($str == "FairyGold") {
		switch($emo) {
			case 0: return "fairy/golden_1"; break;
			case 1: return "fairy/golden_2"; break;
		}
	}
	else if($str == "FairyShield") {
		switch($emo) {
			case 0: return "fairy/shield_1"; break;
		}
	}
}
/*
function parseStoryFile($line) {
	$s_line = []
	$tmp = explode(":", $line);
	$tmp1 = explode("||", $tmp[0]);
	$result = [];
	
	$s_line[0] = $tmp1[0]; //아바타 및 speaker 자리
	$s_line[1] = $tmp1[1]; //BGM, 특수효과등 자리
	$s_line[2] = $tmp[1]; //대사자리
	
	//특수문자들 통일
	$line = str_replace("，", ",", str_replace("》", ">", str_replace("《", "<", str_replace("（", "(", str_replace("；", ";", str_replace("）", ")", $line))))));
	
	//아바타, 스피커 처리
	$sp_data = explode(';', $s_line[0]);
	$result['character'] = []; //캐릭터 정보 저장
	$result['character_emotion'] = []; //캐릭터 스킨 정보 저장
	
	//화면에 표시될 캐릭터의 수대로 for문
	for($i = 0 ; $i < sizeof($sp_data) ; $i++) {
		
		$pos = strpos($mystring, $findme);
		
		
		array_push($result['character'], substr($sp_data[$i], 0, strpos($sp_data[$i], "(")); //캐릭터 이름 잘라서 저장 
		array_push($result['character_emotion'], substr($sp_data[$i], strpos($sp_data[$i], "(")+1, strpos($sp_data[$i], ")")); //스킨정보도 잘라서 저장
		
		if(sp_data[i].includes("<Speaker>")) {
			if(sp_data[i].includes("</Speaker>")) {
				result.speaker_name = sp_data[i].match("<Speaker>(.*)</Speaker>")[1];
				result.speaker = i;
			}
			else {
				result.speaker_name = sp_data[i].substring(0, sp_data[i].indexOf("("));
				result.speaker = i;
			}
		}
		else {
			if(sp_data.length === 1 && typeof result.speaker_name === 'undefined') {
				result.speaker_name = sp_data[i].substring(0, sp_data[i].indexOf("("));
				result.speaker = i;
			}
			else if(typeof result.speaker_name === 'undefined') {
				result.speaker_name = '';
				result.speaker = i;
			}
		}
		
	}
		
	//효과들 파싱
	if(s_line[1].includes("<BGM>")) { //BGM
		result.bgm = s_line[1].match("<BGM>(.*)</BGM>")[1];
	}
	if(s_line[1].includes("<BIN>")) { //배경화면
		result.bg = s_line[1].match("<BIN>(.*)</BIN>")[1];
	}
	if(s_line[1].includes("<Pic>")) { //사진효과(난류연속에서 처음 사용)
		result.pic = [];
		var tbr = s_line[1].match("<Pic>(.*)</Pic>")[1];
		var tmp = tbr.split("],[");
		tmp.forEach(function(dat) {
			result.pic.push(dat.replace(']', '').replace('[', '').split('&'));
		});
	}
	if(s_line[1].includes("<分支>")) { //대사 분기(난류연속에서 처음 사용)
		result.branch = s_line[1].match("<分支>(.*)</分支>")[1];
	}
	
	if(s_line[1].includes("<Night>")) {
		result.isnight = 1;
	}
	
	//대사 파싱
	if(isInt(s_line[2])) {
		if(typeof LangData[s_line[2]] === 'undefined') {
			if(typeof LangData_fallback[s_line[2]] === 'undefined') {
				result.text = "no text data avaliable(no ko, cn data)";
			}
			else {
				result.text = LangData_fallback[s_line[2]].replace(/\+/gi, "\n") + "(no korean text data)";
			}
		}
		else {
			result.text = LangData[s_line[2]].replace(/\+/gi, "\n");
		}
	}
	else if(typeof s_line[2] === 'undefined' || s_line[2] == "") {
		result.text = '';
	}
	else {
		result.text = s_line[2].replace(/\/\/n/gi, "\n").replace(/\+/gi, "\n");
	}
	return result;
}
*/
function iscontains($str, $str1) {
	if(strpos($str, $str1 !== false)) {
		return true;
	}
	else {
		return false;
	}
	return false;
}

//스토리 배경화면 목록
function getStoryBGProfile() {
  return explode(PHP_EOL, file_get_contents("story_json/profiles.txt"));
}

//스토리 배경화면 이름 가져오기
function getStoryBGImageName($id, $profiles) {
  if ($id == 9) return 'black_template';
  else if ($id == 10) return 'white_template';
  
  return $profiles[$id];
}

//서브스토리 스토리 정보 가져오기
function getSkinStoryInfo($skins, $id) {
  foreach ($skins as $i => $skin) {
    $skinid = str_pad($id, 7, '0', STR_PAD_LEFT);
    
    if (strpos($skin, "skin-1$skinid") !== false) {
      $return = new stdClass();
      $return->name = str_replace('//c', ',', str_replace("skin-1$skinid,", '', $skin));
      $return->desc = str_replace('//c', ',', str_replace("skin-2$skinid,", '', $skins[$i+1]) . "<br>" . str_replace("skin-3$skinid,", '', $skins[$i+2]));
      return $return;
    }
  }
}

//스토리용 인형 이미지 불러오기
function getcharimgdir($str, $emo) {
	$dolls = getJson('avgpic');
	if($str == "FAL") $str = "FNFAL";
	if($str == "MK2") $str = "StenMK2";
	if($str == "에이전트") $str = "BOSS-8";
	if($str == "RO") { $str = "RO635"; $emo = "0"; }
	
  $str = strtolower($str);
  $path = $dolls->{$str}->{$emo}->path;
  return str_replace('characters/', 'characters_original/', str_replace('assets/', '', $path));
}
?>