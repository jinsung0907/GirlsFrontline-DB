<?php
if(GF_HEADER != "aaaaa") exit; 
session_start();

/*언어 처리 우선순위
1. session값 2. http언어값*/
if(isset($_SESSION['lang'])) {
	if($_SESSION['lang'] == 'en')
		$lang = 'en';
	else if($_SESSION['lang'] == 'ja')
		$lang = 'ja';
	else 
		$lang = 'ko';
}
else {
	$langs = explode(',', $_SERVER['HTTP_ACCEPT_LANGUAGE']);
	if($langs[0] == "en" || $langs[0] == "en-US")
		$lang = 'en';
	else if($langs[0] == "ja" || $langs[0] == "ja-JP")
		$lang = 'ja';
	else 
		$lang = 'ko';
}

require_once "i18n.class.php";
$i18n = new i18n('data/lang/lang_{LANGUAGE}.ini', 'data/lang/cache/', 'ko');
$i18n->init();
//언어 처리 끝


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
	$type = strtolower($type);
	switch($type) {
		case 'ar': return "돌격소총";
		case 'rf': return "소총";
		case 'smg': return "기관단총";
		case 'mg': return "기관총";
		case 'sg': return "샷건";
		case 'hg': return "권총";
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
		}
	}
	else if($str == "FairyGold") {
		switch($emo) {
			case 0: return "fairy/golden_1"; break;
		}
	}
}

//스토리용 인형 이미지 불러오기
function getcharimgdir($str, $emo) {
	$dolls = json_decode(file_get_contents("data/doll.json"));
	if($str == "FAL") $str = "FNFAL";
	if($str == "MK2") $str = "StenMK2";
	if($str == "에이전트") $str = "BOSS-8";
	if($str == "RO") { $str = "RO635"; $emo = "0"; }
	
	//dolls.json에 있는것들
	foreach($dolls as $doll) {
		if($emo == "") return "invisible";
		
		if(strtoupper($doll->name) == strtoupper($str)) {
			$result = $doll->id;
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
					case 4: $result = "dolls/" . $result . "_1"; break;
					case 5: $result = "dolls/" . $result . "_1_D"; break;
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
					case 5: $result = "dolls/" . $result . "_2_D"; break;
					case 6: $result = "dolls/" . $result . "_1"; break;
					case 7: $result = "dolls/" . $result . "_1_D"; break;
					case 8: $result = "dolls/" . $result . "_3"; break;
					case 9: $result = "dolls/" . $result . "_3_D"; break;
				}
			}
			else if($str == "RO635") {
				switch($emo) {
					case 1: $result = "dolls/" . $result . "_D"; break;
					case 2: $result = "story_character/pic_RO635_1"; break;
					case 3: $result = "story_character/pic_RO635_2"; break;
					case 4: $result = "story_character/pic_RO635_3"; break;
					case 5: $result = "story_character/pic_RO635_4"; break;
					case 6: $result = "dolls/" . $result . "_1"; break;
					case 7: $result = "dolls/" . $result . "_1_D"; break;
					case 8: $result = "dolls/" . $result . "_2"; break;
					case 9: $result = "dolls/" . $result . "_2_D"; break;
					case 10: $result = "dolls/" . $result . "_3"; break;
					case 11: $result = "dolls/" . $result . "_3_D"; break;
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
				}
			}
			
			return $result;
		}
	}
	
	//dolls.json에 없는것들 (NPC, 스토리전용 이미지)
	if($str == "M16") {
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
		}
	}
	else if($str == "NPC-Ange") {
		switch($emo) {
			case 0: return "story_character/npc/NPC-Ange"; break;
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
	
	return $result;
}
?>