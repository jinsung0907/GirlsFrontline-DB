<?php
if(GF_HEADER != "aaaaa") exit; 
session_start();

if(isset($_GET['lang'])) {
	session_start();
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
	foreach($bgms as $bgm) {
		if($bgm->id == $id || $bgm->file == $id) {
			return $bgm->file . "/" . $bgm->file .".mp3";
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

function getFairyName($fairy) {
	global $lang;
	
	if($lang == 'ja') 
		return isset($fairy->jpName)?$fairy->jpName:$fairy->name;
	else if($lang == 'en') 
		return isset($fairy->enName)?$fairy->enName:$fairy->name;
	else if($lang == 'zh') 
		return isset($fairy->cnName)?$fairy->cnName:$fairy->name;
	else
		return isset($fairy->krName)?$fairy->krName:$fairy->name;
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
	if($type == 'strategy') {
		return L::fairy_type_tactical;
	}
	else if($type == 'battle') {
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

//스토리용 인형 이미지 불러오기
function getcharimgdir($str, $emo) {
	$dolls = getJson('doll');
	if($str == "FAL") $str = "FNFAL";
	if($str == "MK2") $str = "StenMK2";
	if($str == "에이전트") $str = "BOSS-8";
	if($str == "RO") { $str = "RO635"; $emo = "0"; }
	
	//dolls.json에 있는것들
	foreach($dolls as $doll) {
		if($emo == "") return "invisible";
		
		if(strtoupper($doll->name) == strtoupper($str)) {
			$result = $doll->id;
			$emo = intval($emo);
			/*
			if($doll->id > 20000) {
				$result = $result - 20000 . "_U";
			}*/
			
			if($emo == 0) {
				$result = "dolls/" . $result;
			}
			if($str == "NTW20") {
				switch($emo) {
					case 1: $result = "dolls/" . $result . "_D"; break;
					case 2: $result = "dolls/" . $result . "_1"; break;
					case 3: $result = "dolls/" . $result . "_1_D"; break;
					case 4: $result = "dolls/" . $result . "_3"; break;
					case 5: $result = "dolls/" . $result . "_3_D"; break;
					case 6: $result = "dolls/" . $result . "_2"; break;
					case 7: $result = "dolls/" . $result . "_2_D"; break;
					case 8: $result = "dolls/" . $result . "_4"; break;
					case 9: $result = "dolls/" . $result . "_4_D"; break;
				}
			}
			else if($str == "FNFAL") {
				switch($emo) {
					case 1: $result = "dolls/" . $result . "_D"; break;
					case 2: $result = "dolls/" . $result . "_1"; break;
					case 3: $result = "dolls/" . $result . "_1_D"; break;
					case 4: $result = "dolls/" . $result . "_3"; break;
					case 5: $result = "dolls/" . $result . "_3_D"; break;
					case 6: $result = "dolls/" . $result . "_2"; break;
					case 7: $result = "dolls/" . $result . "_2_D"; break;
					case 8: $result = "dolls/" . $result . "_4"; break;
					case 9: $result = "dolls/" . $result . "_4_D"; break;
				}
			}
			else if($str == "AN94") {
				switch($emo) {
					case 1: $result = "dolls/" . $result . "_D"; break;
					case 2: $result = "story_character/an94_angry"; break;
					case 3: $result = "story_character/an94_laugh"; break;
					case 4: $result = "story_character/an94_sad"; break;
					case 5: $result = "story_character/an94_surprise"; break;
					case 6: $result = "dolls/" . $result . "_1"; break;
					case 7: $result = "dolls/" . $result . "_1_D"; break;
					case 8: $result = "dolls/" . $result . "_2"; break;
					case 9: $result = "dolls/" . $result . "_2_D"; break;
					case 10: $result = "dolls/" . $result . "_3"; break;
					case 11: $result = "dolls/" . $result . "_3_D"; break;
				}
			}
			else if($str == "AK12") {
				switch($emo) {
					case 1: $result = "dolls/" . $result . "_D"; break;
					case 2: $result = "story_character/ak12_angry"; break;
					case 3: $result = "story_character/ak12_battle"; break;
					case 4: $result = "story_character/ak12_laugh"; break;
					case 5: $result = "dolls/" . $result . "_1"; break;
					case 6: $result = "dolls/" . $result . "_1_D"; break;
					case 7: $result = "story_character/pic_ak12_2402_story"; break;
					case 8: $result = "dolls/" . $result . "_2"; break;
					case 9: $result = "dolls/" . $result . "_2_D"; break;
					case 10: $result = "dolls/" . $result . "_3"; break;
					case 11: $result = "dolls/" . $result . "_3_D"; break;
				}
			}
			else if($str == "G28") {
				switch($emo) {
					case 1: $result = "dolls/" . $result . "_D"; break;
					case 2: $result = "dolls/" . $result . "_2"; break;
					case 3: $result = "dolls/" . $result . "_2_D"; break;
					case 4: $result = "dolls/" . $result . "_1"; break;
					case 5: $result = "dolls/" . $result . "_1_D"; break;
					case 6: $result = "dolls/" . $result . "_3"; break;
					case 7: $result = "dolls/" . $result . "_3_D"; break;
					case 8: $result = "dolls/" . $result . "_4"; break;
					case 9: $result = "dolls/" . $result . "_4_D"; break;
				}
			}
			else if($str == "Grizzly") {
				switch($emo) {
					case 1: $result = "dolls/" . $result . "_D"; break;
					case 2: $result = "dolls/" . $result . "_3"; break;
					case 3: $result = "dolls/" . $result . "_3_D"; break;
					case 4: $result = "dolls/" . $result . "_2"; break;
					case 5: $result = "dolls/" . $result . "_2_D"; break;
					case 6: $result = "dolls/" . $result . "_1"; break;
					case 7: $result = "dolls/" . $result . "_1_D"; break;
					case 8: $result = "dolls/" . $result . "_4"; break;
					case 9: $result = "dolls/" . $result . "_4_D"; break;
				}
			}
			else if($str == "G11") {
				switch($emo) {
					case 1: $result = "dolls/" . $result . "_D"; break;
					case 2: $result = "story_character/pic_G11_1"; break;
					case 3: $result = "story_character/pic_G11_2"; break;
					case 4: $result = "dolls/" . $result . "_1"; break;
					case 5: $result = "dolls/" . $result . "_1_D"; break;
					case 6: $result = "dolls/" . $result . "_2"; break;
					case 7: $result = "dolls/" . $result . "_2_D"; break;
					case 8: $result = "dolls/" . $result . "_3"; break;
					case 9: $result = "dolls/" . $result . "_3_D"; break;
				}
			}
			else if($str == "SV98") {
				switch($emo) {
					case 1: $result = "dolls/" . $result . "_D"; break;
					case 2: $result = "dolls/" . $result . "_2"; break;
					case 3: $result = "dolls/" . $result . "_2_D"; break;
					case 4: $result = "dolls/" . $result . "_1"; break;
					case 5: $result = "dolls/" . $result . "_1_D"; break;
					case 6: $result = "dolls/" . $result . "_3"; break;
					case 7: $result = "dolls/" . $result . "_3_D"; break;
				}
			}
			else if($str == "56-1type") {
				switch($emo) {
					case 1: $result = "dolls/" . $result . "_D"; break;
					case 2: $result = "dolls/" . $result . "_2"; break;
					case 3: $result = "dolls/" . $result . "_2_D"; break;
					case 4: $result = "dolls/" . $result . "_1"; break;
					case 5: $result = "dolls/" . $result . "_1_D"; break;
					case 6: $result = "dolls/" . $result . "_3"; break;
					case 7: $result = "dolls/" . $result . "_3_D"; break;
				}
			}
			else if($str == "MP5") {
				switch($emo) {
					case 1: $result = "dolls/" . $result . "_D"; break;
					case 2: $result = "dolls/" . $result . "_1"; break;
					case 3: $result = "dolls/" . $result . "_1_D"; break;
					case 4: $result = "dolls/" . $result . "_3"; break;
					case 5: $result = "dolls/" . $result . "_3_D"; break;
					case 6: $result = "dolls/" . $result . "_2"; break;
					case 7: $result = "dolls/" . $result . "_2_D"; break;
				}
			}
			else if($str == "FN57") {
				switch($emo) {
					case 1: $result = "dolls/" . $result . "_D"; break;
					case 2: $result = "dolls/" . $result . "_2"; break;
					case 3: $result = "dolls/" . $result . "_2_D"; break;
					case 4: $result = "dolls/" . $result . "_4"; break;
					case 5: $result = "dolls/" . $result . "_4_D"; break;
					case 6: $result = "dolls/" . $result . "_3"; break;
					case 7: $result = "dolls/" . $result . "_3_D"; break;
				}
			}
			else if($str == "G36") {
				switch($emo) {
					case 1: $result = "dolls/" . $result . "_D"; break;
					case 2: $result = "dolls/" . $result . "_2"; break;
					case 3: $result = "dolls/" . $result . "_2_D"; break;
					case 4: $result = "dolls/" . $result . "_1"; break;
					case 5: $result = "dolls/" . $result . "_1_D"; break;
					case 6: $result = "dolls/" . $result . "_3"; break;
					case 7: $result = "dolls/" . $result . "_3_D"; break;
					case 8: $result = "dolls/" . $result . "_4"; break;
					case 9: $result = "dolls/" . $result . "_4_D"; break;
					case 10: $result = "dolls/" . $result . "_5"; break;
					case 11: $result = "dolls/" . $result . "_5_D"; break;
				}
			}
			else if($str == "M1903") {
				switch($emo) {
					case 1: $result = "dolls/" . $result . "_D"; break;
					case 2: $result = "dolls/" . $result . "_2"; break;
					case 3: $result = "dolls/" . $result . "_2_D"; break;
					case 4: $result = "dolls/" . $result . "_1"; break;
					case 5: $result = "dolls/" . $result . "_1_D"; break;
					case 6: $result = "dolls/" . $result . "_3"; break;
					case 7: $result = "dolls/" . $result . "_3_D"; break;
				}
			}
			else if($str == "WA2000") {
				switch($emo) {
					case 1: $result = "dolls/" . $result . "_D"; break;
					case 2: $result = "dolls/" . $result . "_2"; break;
					case 3: $result = "dolls/" . $result . "_2_D"; break;
					case 4: $result = "dolls/" . $result . "_1"; break;
					case 5: $result = "dolls/" . $result . "_1_D"; break;
					case 6: $result = "dolls/" . $result . "_2"; break;
					case 7: $result = "dolls/" . $result . "_2_D"; break;
					case 8: $result = "dolls/" . $result . "_3"; break;
					case 9: $result = "dolls/" . $result . "_3_D"; break;
				}
			}
			else if($str == "M950A") {
				switch($emo) {
					case 1: $result = "dolls/" . $result . "_D"; break;
					case 2: $result = "dolls/" . $result . "_2"; break;
					case 3: $result = "dolls/" . $result . "_2_D"; break;
					case 4: $result = "dolls/" . $result . "_1"; break;
					case 5: $result = "dolls/" . $result . "_1_D"; break;
					case 6: $result = "dolls/" . $result . "_3"; break;
					case 7: $result = "dolls/" . $result . "_3_D"; break;
					case 8: $result = "dolls/" . $result . "_4"; break;
					case 9: $result = "dolls/" . $result . "_4_D"; break;
				}
			}
			else if($str == "HK416") {
				switch($emo) {
					case 1: $result = "dolls/" . $result . "_D"; break;
					case 2: $result = "story_character/pic_HK416_1"; break;
					case 3: $result = "story_character/pic_HK416_2"; break;
					case 4: $result = "dolls/" . $result . "_1"; break;
					case 5: $result = "dolls/" . $result . "_1_D"; break;
					case 6: $result = "dolls/" . $result . "_2"; break;
					case 7: $result = "dolls/" . $result . "_2_D"; break;
					case 8: $result = "dolls/" . $result . "_3"; break;
					case 9: $result = "dolls/" . $result . "_3_D"; break;
				}
			}
			else if($str == "M4A1") {
				switch($emo) {
					case 1: $result = "dolls/" . $result . "_D"; break;
					case 2: $result = "story_character/M4A1_SAD"; break;
					case 3: $result = "story_character/M4A1_T"; break;
					case 4: $result = "dolls/" . $result . "_1"; break;
					case 5: $result = "dolls/" . $result . "_1_D"; break;
					case 6: $result = "dolls/" . $result . "_2"; break;
					case 7: $result = "dolls/" . $result . "_2_D"; break;
					case 8: $result = "dolls/" . $result . "_3"; break;
					case 9: $result = "dolls/" . $result . "_3_D"; break;
				}
			}
			else if($str == "M4A1Mod") {
				switch($emo) {
					case 1: $result = "dolls/" . $result . "_D"; break;
					case 2: $result = "story_character/m4a1mod_紧张"; break;
					case 3: $result = "story_character/m4a1mod_微笑"; break;
					case 4: $result = "story_character/m4a1mod_悲伤"; break;
					case 5: $result = "dolls/" . $result . "_1"; break;
					case 6: $result = "dolls/" . $result . "_1_D"; break;
					case 7: $result = "dolls/" . $result . "_2"; break;
					case 8: $result = "dolls/" . $result . "_2_D"; break;
					case 9: $result = "dolls/" . $result . "_3"; break;
					case 10: $result = "dolls/" . $result . "_3_D"; break;
				}
			}
			else if($str == "UMP9") {
				switch($emo) {
					case 1: $result = "dolls/" . $result . "_D"; break;
					case 2: $result = "story_character/pic_UMP9_1"; break;
					case 3: $result = "story_character/pic_UMP9_2"; break;
					case 4: $result = "story_character/pic_UMP9_3"; break;
					case 5: $result = "dolls/" . $result . "_2"; break;
					case 6: $result = "dolls/" . $result . "_2_D"; break;
					case 7: $result = "dolls/" . $result . "_1"; break;
					case 8: $result = "dolls/" . $result . "_1_D"; break;
					case 9: $result = "dolls/" . $result . "_3"; break;
					case 10: $result = "dolls/" . $result . "_3_D"; break;
				}
			}
			else if($str == "UMP40") {
				switch($emo) {
					case 1: $result = "dolls/" . $result . "_D"; break;
					case 2: $result = "story_character/pic_UMP40_angry"; break;
					case 3: $result = "story_character/pic_UMP40_lol"; break;
					case 4: $result = "story_character/pic_UMP40_sad"; break;
					case 5: $result = "story_character/pic_UMP40_smile"; break;
					case 6: $result = "dolls/" . $result . "_1"; break;
					case 7: $result = "dolls/" . $result . "_1_D"; break;
					case 8: $result = "dolls/" . $result . "_2"; break;
					case 9: $result = "dolls/" . $result . "_2_D"; break;
					case 10: $result = "dolls/" . $result . "_3"; break;
					case 11: $result = "dolls/" . $result . "_3_D"; break;
				}
			}
			else if($str == "UMP45") {
				switch($emo) {
					case 1: $result = "dolls/" . $result . "_D"; break;
					case 2: $result = "story_character/pic_UMP45_1"; break;
					case 3: $result = "story_character/pic_UMP45_2"; break;
					case 4: $result = "dolls/" . $result . "_2"; break;
					case 5: $result = "story_character/UMP45Damage"; break;
					case 6: $result = "dolls/" . $result . "_2_D"; break;
					case 7: $result = "dolls/" . $result . "_1"; break;
					case 8: $result = "dolls/" . $result . "_1_D"; break;
					case 9: $result = "dolls/" . $result . "_3"; break;
					case 10: $result = "dolls/" . $result . "_3_D"; break;
				}
			}
			else if($str == "RO635") {
				switch($emo) {
					case 1: $result = "dolls/" . $result . "_D"; break;
					case 2: $result = "story_character/pic_RO635_1"; break;
					case 3: $result = "story_character/pic_RO635_2"; break;
					case 4: $result = "story_character/pic_RO635_3"; break;
					case 5: $result = "story_character/pic_RO635_4"; break;
					case 6: $result = "story_character/RO635Dinergate"; break;
					case 7: $result = "dolls/" . $result . "_1"; break;
					case 8: $result = "dolls/" . $result . "_1_D"; break;
					case 9: $result = "dolls/" . $result . "_2"; break;
					case 10: $result = "dolls/" . $result . "_2_D"; break;
					case 11: $result = "dolls/" . $result . "_3"; break;
					case 12: $result = "dolls/" . $result . "_3_D"; break;
				}
			}
			else if($str == "AR15") {
				switch($emo) {
					case 1: $result = "dolls/" . $result . "_D"; break;
					case 2: $result = "story_character/AR15_T"; break;
					case 3: $result = "dolls/" . $result . "_1"; break;
					case 4: $result = "dolls/" . $result . "_1_D"; break;
					case 5: $result = "dolls/" . $result . "_2"; break;
					case 6: $result = "dolls/" . $result . "_2_D"; break;
					case 7: $result = "dolls/" . $result . "_3"; break;
					case 8: $result = "dolls/" . $result . "_3_D"; break;
				}
			}
			else if($str == "AR15Mod") {
				switch($emo) {
					case 1: $result = "dolls/" . $result . "_D"; break;
					case 2: $result = "story_character/AR15Mod_紧张"; break;
					case 3: $result = "story_character/AR15Mod_无奈"; break;
					case 4: $result = "story_character/AR15Mod_微笑"; break;
					case 5: $result = "story_character/AR15Mod_伤心"; break;
				}
			}
			else if($str == "M1918") {
				switch($emo) {
					case 1: $result = "dolls/" . $result . "_D"; break;
					case 2: $result = "dolls/" . $result . "_2"; break;
					case 3: $result = "dolls/" . $result . "_2_D"; break;
					case 4: $result = "dolls/" . $result . "_1"; break;
					case 5: $result = "dolls/" . $result . "_1_D"; break;
					case 6: $result = "dolls/" . $result . "_3"; break;
					case 7: $result = "dolls/" . $result . "_3_D"; break;
					case 8: $result = "dolls/" . $result . "_4"; break;
					case 9: $result = "dolls/" . $result . "_4_D"; break;				
				}
			}
			else if($str == "BB_Noel") {
				switch($emo) {
					case 1: $result = "dolls/" . $result . "_D"; break;
					case 2: $result = "dolls/" . $result . ""; break;
					case 3: $result = "dolls/" . $result . "D"; break;
					case 4: $result = "dolls/" . $result . "_1"; break;
					case 5: $result = "dolls/" . $result . "_1_D"; break;
					case 6: $result = "dolls/" . $result . "_3"; break;
					case 7: $result = "dolls/" . $result . "_3_D"; break;
					case 8: $result = "dolls/" . $result . "_4"; break;
					case 9: $result = "dolls/" . $result . "_4_D"; break;				
				}
			}
			else {
				switch($emo) {
					case 1: $result = "dolls/" . $result . "_D"; break;
					case 2: $result = "dolls/" . $result . "_1"; break;
					case 3: $result = "dolls/" . $result . "_1_D"; break;
					case 4: $result = "dolls/" . $result . "_2"; break;
					case 5: $result = "dolls/" . $result . "_2_D"; break;
					case 6: $result = "dolls/" . $result . "_3"; break;
					case 7: $result = "dolls/" . $result . "_3_D"; break;
					case 8: $result = "dolls/" . $result . "_4"; break;
					case 9: $result = "dolls/" . $result . "_4_D"; break;
					case 10: $result = "dolls/" . $result . "_5_D"; break;
					case 11: $result = "dolls/" . $result . "_5_D"; break;
				}
			}
			
			return $result;
		}
	}
	
	//dolls.json에 없는것들 (NPC, 스토리전용 이미지)
	if($str == "FAMASHalloween") {
		switch($emo) {
			case 0: $result = "dolls/69_1"; break;
			case 1: $result = "dolls/69_1_D"; break;
		}
	}
	else if($str == "AR") {
		switch($emo) {
			case 0: $result = ""; break;
			case 1: $result = ""; break;
		}
	}
	else if($str == "M16") {
		switch($emo) {
			case 0: $result = "dolls/54"; break;
			case 1: $result = "dolls/54_D"; break;
			case 2: $result = "story_character/M16A1_SAD"; break;
			case 3: $result = "story_character/M16A1_T"; break;
			case 4: $result = "dolls/" . $result . "_1"; break;
			case 5: $result = "dolls/" . $result . "_1_D"; break;
			case 6: $result = "dolls/" . $result . "_2"; break;
			case 7: $result = "dolls/" . $result . "_2_D"; break;
			case 8: $result = "dolls/" . $result . "_3"; break;
			case 9: $result = "dolls/" . $result . "_3_D"; break;
		}
	}
	else if($str == "SOPII") {
		switch($emo) {
			case 0: $result = "dolls/56"; break;
			case 1: $result = "dolls/56_D"; break;
			case 2: $result = "story_character/SOPII_SAD"; break;
			case 3: $result = "story_character/SOPII_T"; break;
			case 4: $result = "dolls/56_1"; break;
			case 5: $result = "dolls/56_1_D"; break;
			case 6: $result = "dolls/56_2"; break;
			case 7: $result = "dolls/56_2_D"; break;
			case 8: $result = "dolls/56_3"; break;
			case 9: $result = "dolls/56_3_D"; break;
		}
	}
	else if($str == "UMP45_Young") {
		switch($emo) {
			case 0: $result = "story_character/UMP45-Young"; break;
			case 1: $result = "story_character/UMP45-Young_angry"; break;
			case 2: $result = "story_character/UMP45-Young_sad"; break;
			case 3: $result = "story_character/UMP45-Young_serious"; break;
		}
	}
	else if($str == "BB_Noel_503") {
		switch($emo) {
			case 0: $result = "dolls/1001_1"; break;
			case 1: $result = "dolls/1001_1_D"; break;
		}
	}
	else if($str == "GG_elfeldt_504") {
		switch($emo) {
			case 0: $result = "dolls/1002_1"; break;
			case 1: $result = "dolls/1002_1_D"; break;
		}
	}
	else if($str == "GG_elfeldt_505") {
		switch($emo) {
			case 0: $result = "dolls/1002_2"; break;
			case 1: $result = "dolls/1002_2_D"; break;
		}
	}
	else if($str == "NPC-Kalin") {
		switch($emo) {
			case 0: return "story_character/版娘"; break;
			case 1: return "story_character/版娘-1"; break;
			case 2: return "story_character/版娘-2"; break;
			case 3: return "story_character/版娘-3"; break;
			case 4: return "story_character/版娘-4"; break;
			case 5: return "story_character/版娘-5"; break;
			case 6: return "story_character/版娘-6"; break;
			case 7: return "story_character/版娘-7"; break;
			case 8: return "story_character/版娘-8"; break;
			case 9: return "story_character/版娘Armor"; break;
			case 10: return "story_character/npc_kalina_203"; break;
		}
	}
	else if($str == "SOPIIDamage") {
		switch($emo) {
			case 0: return "story_character/M4 SOPMOD IIDamage"; break;
			case 1: return "story_character/M4 SOPMOD IIDamage2"; break;
			case 2: return "story_character/M4 SOPMOD IIDamage2"; break;
			case 3: return "story_character/M4 SOPMOD IIDamage3"; break;
		}
	}
	else if($str == "RO635-NoArmor") {
		switch($emo) {
			case 0: return "story_character/pic_ro635_noarmor0"; break;
			case 1: return "story_character/pic_ro635_noarmor_1"; break;
			case 2: return "story_character/pic_ro635_noarmor_2"; break;
			case 3: return "story_character/pic_ro635_noarmor_3"; break;
			case 4: return "story_character/pic_ro635_noarmor_4"; break;
		}
	}
	else if($str == "M4 SOPMOD IIMod-Noarmor") {
		switch($emo) {
			case 0: return "story_character/pic_m4 sopmod iimod_noarmor1"; break;
		}
	}
	
	
	else if($str == "NPC-Zielinski") {
		switch($emo) {
			case 0: return "story_character/npc/npc-zielinski"; break;
		}
	}
	else if($str == "NPC-YegorDamage") {
		switch($emo) {
			case 0: return "story_character/npc/npc-yegordamage"; break;
		}
	}
	else if($str == "NPC-AngeDamage") {
		switch($emo) {
			case 0: return "story_character/npc/NPC-AngeDamage"; break;
			case 1: return "story_character/npc/NPC-AngeDamage"; break;
			case 2: return "story_character/npc/NPC-AngeDamage2"; break;
			case 3: return "story_character/npc/NPC-AngeDamage3"; break;
		}
	}
	else if($str == "NPC-Ange") {
		switch($emo) {
			case 0: return "story_character/npc/NPC-Ange"; break;
		}
	}
	else if($str == "NPC-AngeStreet") {
		switch($emo) {
			case 0: return "story_character/npc/NPC-AngeStreet"; break;
		}
	}
	else if($str == "NPC-Yegor") {
		switch($emo) {
			case 0: return "story_character/npc/NPC-Yegor"; break;
			case 1: return "story_character/npc/NPC-YegorArm"; break;
			case 2: return "story_character/npc/NPC-YegorArm2"; break;
			case 3: return "story_character/npc/NPC-YegorArm3"; break;
		}
	}
	else if($str == "NPC-Carter") {
		switch($emo) {
			case 0: return "story_character/npc/pic_NPC-Carter"; break;
		}
	}
	else if($str == "NPC-Helian") {
		switch($emo) {
			case 0: return "story_character/npc/pic_NPC-Helian"; break;
			case 1: return "story_character/npc/pic_NPC-Helian_A"; break;
			case 2: return "story_character/npc/pic_NPC-Helian_F"; break;
			case 3: return "story_character/npc/pic_NPC-Helian_T"; break;
		}
	}
	else if($str == "NPC-Kyruger") {
		switch($emo) {
			case 0: return "story_character/npc/pic_NPC-Kyruger"; break;
		}
	}
	else if($str == "NPC-Lyco") {
		switch($emo) {
			case 0: return "story_character/npc/NPC-Lyco"; break;
		}
	}
	else if($str == "NPC-Persica") {
		switch($emo) {
			case 0: return "story_character/npc/pic_NPC-Persica"; break;
			case 1: return "story_character/npc/pic_NPC-Persica_C"; break;
			case 2: return "story_character/npc/pic_NPC-Persica_J"; break;
			case 3: return "story_character/npc/pic_NPC-Persica_T"; break;
		}
	}
	else if($str == "NPC-Havel") {
		switch($emo) {
			case 0: return "story_character/npc/NPC-Havel"; break;
			case 1: return "story_character/npc/NPC-Havel2"; break;
		}
	}
	else if($str == "NPC-Seele") {
		switch($emo) {
			case 0: return "story_character/npc/pic_NPC-Seele"; break;
		}
	}
	else if($str == "NPC-Deele") {
		switch($emo) {
			case 0: return "story_character/npc/pic_NPC-Deele"; break;
		}
	}
	else if($str == "NPC-Maid") {
		switch($emo) {
			case 0: return "story_character/npc/npc-maid"; break;
		}
	}
	else if($str == "NPC-Jason") {
		switch($emo) {
			case 0: return "story_character/npc/npc-jason"; break;
		}
	}
	else if($str == "NPC-Mercurows") {
		switch($emo) {
			case 0: return "story_character/npc/npc-Mercurows"; break;
		}
	}
	else if($str == "NPC-Nimogen") {
		switch($emo) {
			case 0: return "story_character/npc/npc-Nimogen"; break;
		}
	}
	else if($str == "NPC-Bodyguard1") {
		switch($emo) {
			case 0: return "story_character/npc/npc-Bodyguard1"; break;
		}
	}
	else if($str == "NPC-Bodyguard2") {
		switch($emo) {
			case 0: return "story_character/npc/npc-Bodyguard2"; break;
		}
	}
	else if($str == "NPC-KalinReporter") {
		switch($emo) {
			case 0: return "story_character/npc/npc-KalinReporter"; break;
		}
	}
	else if($str == "NPC-KalinReporter") {
		switch($emo) {
			case 0: return "story_character/npc/npc-KalinReporter"; break;
		}
	}
	else if($str == "NPC-NPC-PasserbyF") {
		switch($emo) {
			case 0: return "story_character/npc/npc-NPC-PasserbyF"; break;
		}
	}
	else if($str == "NPC-NPC-PasserbyM") {
		switch($emo) {
			case 0: return "story_character/npc/npc-NPC-PasserbyM"; break;
		}
	}
	
	
	else if($str == "BOSS-1") {
		switch($emo) {
			case 0: return "story_character/boss/Scarecrow"; break;
		}
	}
	else if($str == "BOSS-2" || $str == "엑스큐셔너") {
		switch($emo) {
			case 0: return "story_character/boss/Excutioner"; break;
		}
	}
	else if($str == "BOSS-3") {
		switch($emo) {
			case 0: return "story_character/boss/Hunter"; break;
		}
	}
	else if($str == "BOSS-4") {
		switch($emo) {
			case 0: return "story_character/boss/Intruder"; break;
		}
	}
	else if($str == "BOSS-5") {
		switch($emo) {
			case 0: return "story_character/BOSS-6"; break;
		}
	}
	else if($str == "BOSS-6") {
		switch($emo) {
			case 0: return "story_character/boss/Destroyer"; break;
		}
	}
	else if($str == "BOSS-7") {
		switch($emo) {
			case 0: return "story_character/BOSS-7"; break;
		}
	}
	else if($str == "BOSS-8") {
		switch($emo) {
			case 0: return "story_character/BOSS-8"; break;
		}
	}
	else if($str == "BOSS-9") {
		switch($emo) {
			case 0: return "story_character/BOSS-9"; break;
		}
	}
	else if($str == "BOSS-10") {
		switch($emo) {
			case 0: return "story_character/BOSS-10"; break;
		}
	}
	else if($str == "BOSS-11") {
		switch($emo) {
			case 0: return "story_character/BOSS-11"; break;
		}
	}	
	
	else if($str == "BossJustice") {
		switch($emo) {
			case 0: return "story_character/boss/BossJustice"; break;
		}
	}
	else if($str == "BossCerberus") {
		switch($emo) {
			case 0: return "story_character/boss/Cerberus"; break;
		}
	}
	else if($str == "ExcutionerElite") {
		switch($emo) {
			case 0: return "story_character/boss/ExcutionerElite"; break;
			case 1: return "story_character/boss/ExcutionerElite_2"; break;
		}
	}
	else if($str == "BossDestroyerPlus") {
		switch($emo) {
			case 0: return "story_character/boss/DestroyerPlus"; break;
		}
	}
	else if($str == "HunterElite") {
		switch($emo) {
			case 0: return "story_character/boss/HunterElite"; break;
			case 1: return "story_character/boss/HunterElite_1"; break;
		}
	}
	else if($str == "Weaver") {
		switch($emo) {
			case 0: return "story_character/boss/Weaver"; break;
			case 1: return "story_character/boss/Weaver_2"; break;
			case 2: return "story_character/boss/Weaver_3"; break;
		}
	}
	else if($str == "M16A1BOSS") {
		switch($emo) {
			case 0: return "story_character/pic_m16a1_boss"; break;
		}
	}
	else if($str == "WeaverElite") {
		switch($emo) {
			case 0: return "story_character/boss/WeaverElite"; break;
			case 1: return "story_character/boss/WeaverElite_1"; break;
			case 2: return "story_character/boss/WeaverElite_2"; break;
			case 3: return "story_character/boss/WeaverElite_3"; break;
			case 4: return "story_character/boss/WeaverElite_4"; break;
		}
	}
	else if($str == "M1903Cafe") {
		switch($emo) {
			case 0: return "story_character/春田咖啡"; break;
		}
	}
	
	else if($str == "Nyto") {
		switch($emo) {
			case 0: return "story_character/npc/nyto"; break;
			case 1: return "story_character/npc/nyto_black"; break;
		}
	}
	else if($str == "NytoWhite") {
		switch($emo) {
			case 0: return "story_character/npc/nyto_white"; break;
		}
	}
	
	return $result;
}
?>