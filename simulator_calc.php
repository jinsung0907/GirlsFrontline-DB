<?php
	ini_set('max_execution_time', '5');
	define("GF_HEADER", "aaaaa");
	include_once("common.php");
	
    /*
	//rate limit
	session_start();
	$time = microtime(true);
	if(isset($_SESSION['time'])) {
		if(($time - $_SESSION['time']) <= 0.2) {
			exit;
		}
	}
	$_SESSION['time'] = $time;
	*/
    
	$time_start = microtime(true); 
	
	$dolls = getJson('doll');
	$skills = getJson('skill');
	
	$guntype = ['ar', 'sg', 'rf', 'hg', 'mg', 'smg'];
	$efftype = ['rate', 'pow', 'dodge', 'hit', 'crit', 'cooldown', 'armor'];
	
	$resultvalue;
	
	/*
	grid 정보 
	해당 위치 비어있을때는 0으로 채워넣음
	0: 요정
	1~9: grid 위치한 인형 id
	
	grid 모양
	3 6 9
	2 5 8
	1 4 7
	*/
	
	
	//인형 위치
	// key -> 위치
	// value -> [0] dollid, [1] level, [2] favor
	$position = $_POST['position'];
	
	//진형효과, 위치
	// key -> 위치
	// value ->
	//  key -> 무기 타입
	//  value ->
	//   key -> 화력, 사속등의 타입
	//   value -> 수치
	$grid = $_POST['grid'];
	
	//인형 기본 스탯
	// key -> 위치
	// value -> 레벨, 호감도계산된 doll.json의 stats부분 
	$stats = $_POST['stats'];
	
	$fairy = $_POST['fairy'];
	if(sizeof($fairy) == 0) {
        $fairy['pow'] = 1;
        $fairy['hit'] = 1;
        $fairy['dodge'] = 1;
        $fairy['armor'] = 1;
        $fairy['critDmg'] = 0;
    }

	$fairybuff = 1; //요정버프는 현재 구현안됨, 1배로 넣음
	$fairyskill = 1; //요정스킬은 현재 구현안됨, 1배로 넣음
	$fairyattr = 1; //요정특성은 현재 구현안됨, 1배로 넣음
	
	//스킬
	$skill_timeline = [];
	
	//버프형 스킬 먼저 구함
	foreach($position as $key => $pos) {
		$doll;
		$stat = $stats[$key];
		$level = $pos['level'];
		$favor = $pos['favor'];
		
		
		foreach($dolls as $dol) {
			if($pos['id'] == $dol->id) {
				$doll = $dol;
				break;
			}
		}
		
		if(!is_array($stat)) {
			continue;
		}
		
		$gear = 0;
		
		
		$dollskill = 1; //인형스킬 데미지 쿨감은 스킬 없으니 제외
		
		$skill;
		$skillid = $doll->skill->id;
		$skilllevel = 10; //스킬레벨은 10
		
		foreach($skills as $tmp) {
			if($tmp->id == $skillid) {
				$skill = $tmp;
				break;
			}
		}
		
		//쿨다운 진형효과 구하기
		if(!isset($grid[$key][$doll->type]['cooldown']) || $grid[$key][$doll->type]['cooldown'] == 0) {
			$cooldown = 0;
		} else {
			$cooldown = 1 - $grid[$key][$doll->type]['cooldown'] / 100;
		}
		//$cooldown;
		//$cooldown = floor(ceil((ceil($stat['cooldown']) + $gear) * $fairybuff) * $grid_cooldown * $dollskill * $fairyskill * $fairyattr);
		
		//스킬 타이밍 계산
		$i = 0;
		while($i < 450) {		
			//초반쿨이 있을경우
			if($i == 0 && isset($doll->skill->dataPool->IC)) {
				$cooltime = $doll->skill->dataPool->IC;
				//쿨타임 보너스 적용
				//$cooltime = $cooltime - $cooltime*($cooldown / 100);
				$cooltime = $cooltime*$cooldown;
				$cooltime = $cooltime * 30; //프레임으로 바꿈
				$i += $cooltime;
				
				//스킬 라이브러리 불러오기 
				include('calc_skill.php');
				
			}
			//초반쿨 끝나고 일반 쿨
			else {
				//스킬 라이브러리 불러오기 
				include('calc_skill.php');
			}
		}
	}
	
	//위치별로 한명씩 돌아가며 딜 계산
	foreach($position as $key => $pos) {
		$doll;
		$stat = $stats[$key];
		$level = $pos['level'];
		$favor = $pos['favor'];
		
		foreach($dolls as $dol) {
			if($pos['id'] == $dol->id) {
				$doll = $dol;
				break;
			}
		}
		if(!is_array($stat)) {
			continue;
		}
		
		//레벨별로 링크 구하기
		if($level >= 90)
			$link = 5;
		else if($level >= 70)
			$link = 4;
		else if($level >= 30)
			$link = 3;
		else if($level >= 10)
			$link = 2;
		else 
			$link = 1;
		
		$gear = 0; //장비는 현재 구현안됨, 0으로 넣음
		$critDmg = 1.5; //치명상은 1.5(50%)고정, 장비 구현이 안되어있으니 고정값으로 둠.
		$fairybuff = 1; //요정버프는 현재 구현안됨, 1배로 넣음
		$fairyskill = 1; //요정스킬은 현재 구현안됨, 1배로 넣음
		$fairyattr = 1; //요정특성은 현재 구현안됨, 1배로 넣음
		
		$dollskill_ = 1; //인형스킬은 현재 구현안됨, 1배로 넣음
		
		//15초 계산 (450프레임) 편의상 1초는 30프레임으로 함
		$curframe = 0; //현재프레임
		$fireframe = 0; //평타 발사프레임
		$beforeFrame = 0; //이전 프레임 저장용
		$ammocnt = 9999; //현재 장탄수, 기본은 무한대로 9999넣음
		$firecount = 0; //발사 수. 추후 발사수 기반 스킬에 사용하기 위해 넣음
		if($doll->type == 'mg' || $doll->type == 'sg') { //탄 개수가 있는 총기일경우 
			$ammocnt = $doll->stats->bullet; //빼고 더할때 쓰는 변수
			$doll_ammocnt = $ammocnt; //원래 총알 개수 저장
		}
		
		$dps_timeline = array_fill(0, 451, NULL);
		//인형 스킬 화력 스탯 계산
		//사속 구하기
		if(!isset($grid[$key][$doll->type]['rate']) || $grid[$key][$doll->type]['rate'] == 0) {
			$grid_rate = 1;
		} else {
			$grid_rate = 1 + $grid[$key][$doll->type]['rate'] / 100;
		}
		$rate = floor(ceil((ceil($stat['rate']) + $gear) * $fairybuff) * $grid_rate * $dollskill_ * $fairyskill * $fairyattr);
		//사속한계 적용
		if($doll->type != 'mg' && $rate > 120) {
			$rate = 120;
		}
		if($doll->type == 'sg' && $rate > 60) {
			$rate = 60;
		}
		
		
		//사속 -> 프레임 변환, 다만 mg등 특별 사속은 따로 지정
		$frame = rate_to_frame($rate);
		
		if($doll->type == 'mg') {
			$frame = 10;
			
			//PKP, M2HB, MG5, PK
			if($doll->id == 173 || $doll->id == 77 || $doll->id == 109 || $doll->id == 85) {
				$frame = 11;
			}
			
			//HK21
			if($doll->id == 208) {
				$frame = 9;
			}
		}
		
		//첫 한번은 직접 프레임 추가 및 채워줌
		$fireframe += $frame;	
		for($curframe = 0 ; $curframe <= 450 ; $curframe++) {
			//재장전시간 계산 (장탄수가 0일경우)
			if($ammocnt == 0) {
				if($doll->type == 'mg') {
					$fireframe += ceil((4+(200/$rate))*30);
				}
				else if($doll->type == 'sg') {
					$fireframe += ceil((1.5 + (0.5*$doll_ammocnt))*30);
				}
				$ammocnt = $doll_ammocnt;
				//continue;
			}		

			/*
			//15초 넘어갔을시 멈춤
			if($curframe > 450) {
				break;
			}
			*/
			
			/*
			//사이에 빈 공간을 전부 채움
			for($i = $beforeFrame ; $i < $curframe ; $i++) {
				//첫번째 사이클일경우 ($i가 1일경우)
				if($i == 0) {
					$dps_timeline[0][0] = 0;
					$dps_timeline[0][1] = 0;
					continue;
				}
				
				//이전 총 데미지가 존재하면 이전 총 데미지로 이번 값 채워넣음
				if(isset($dps_timeline[$beforeFrame][1])) {
					$val = $dps_timeline[$beforeFrame][1];
				}
				else { //아니면 0넣기
					$val = 0;
				}
				
				$dps_timeline[$i][0] = 0;
				$dps_timeline[$i][1] = $val;
			}
			*/
			
			//스탯 계산식에 들어갈 버프 인형스킬 계산
			//일단 해당 자리에 어느 버프가 있는지 체크
			$dollskill = [];
			$dollskill['pow'] = 1;
			$dollskill['crit'] = 1;
			$dollskill['rate'] = 1;	
			if(isset($skill_timeline[$key][$curframe])) {
				foreach($skill_timeline[$key][$curframe] as $f_skill) {
					$f_skill_id = $f_skill[0];
					$f_skill_dollid = $f_skill[1];
					$f_skill_level = $f_skill[2];
					
					$l_skill;
					foreach($skills as $tmp) {
						if($tmp->id == $f_skill_id) {
							$l_skill = $tmp;
						}
					}
					
					//해당스킬 데이터 파싱
					foreach($l_skill->data as $f_data) {
						//화력증가
						if($f_data->key == "PW") {
							$dollskill['pow'] *= 1 + getDollById($f_skill_dollid)->skill->dataPool->PW[$f_skill_level-1] / 100;
						}
						//치명률증가
						if($f_data->key == "CR") {
							$dollskill['crit'] *= 1 + getDollById($f_skill_dollid)->skill->dataPool->CR[$f_skill_level-1] / 100;
						}
						//사속증가
						if($f_data->key == "AR") {
							//육참골단 (사속감소)
							if($f_skill_id == 48) {
								$dollskill['rate'] *= 1 - getDollById($f_skill_dollid)->skill->dataPool->AR[$f_skill_level-1] / 100;
							} 
							else {
								$dollskill['rate'] *= 1 + getDollById($f_skill_dollid)->skill->dataPool->AR[$f_skill_level-1] / 100;
							}
						}
					}
				}
			}
			
			//인형 스킬 스탯 계산
			//사속 구하기
			if(isset($grid[$key][$doll->type]['rate'])) {
				$grid_rate = 1 + $grid[$key][$doll->type]['rate'] / 100;
			} else {
				$grid_rate = 1;
			}
			$rate = floor(ceil((ceil($stat['rate']) + $gear) * $fairybuff) * $grid_rate * $dollskill['rate'] * $fairyskill * $fairyattr);
			
			//사속한계 적용
			if($doll->type != 'mg' && $rate > 120) {
				$rate = 120;
			}
			if($doll->type == 'sg' && $rate > 60) {
				$rate = 60;
			}
			
			//화력 구하기
			if(isset($grid[$key][$doll->type]['pow'])) {
				$grid_pow = 1 + $grid[$key][$doll->type]['pow'] / 100;
			} else {
				$grid_pow = 1;
			}
			$pow = ceil(ceil((ceil($stat['pow']) + $gear) * $fairy['pow']) * $grid_pow * $dollskill['pow'] * $fairyskill * $fairyattr);
			
			//치명률 구하기
			if(isset($grid[$key][$doll->type]['crit'])) {
				$grid_crit = 1 + $grid[$key][$doll->type]['crit'] / 100;
			} else {
				$grid_crit = 1;
			}
			
			//치명률은 퍼센트이므로 마지막에 퍼센트 가공을 해줌.
			$crit = 1 + (floor(ceil((ceil($stat['crit']) + $gear) * $fairybuff) * $grid_crit * $dollskill['crit'] * $fairyskill * $fairyattr)) / 100;
			
			/*
			//초당공격수
			$atkpersec = 30/(ceil(1500/$rate)-1);
			*/
			
			/*
			//기초DPS (명중률, 치명타등 제외)
			$dps = $pow * $atkpersec * $link;
			*/
			
			//발사하는 프레임일경우 데미지 계산
			if($curframe == $fireframe) {
				//치명률, 치명상 적용 공식
				//해당 프레임 데미지
				$dps_timeline[$curframe][0] += ($pow + ((($pow * $critDmg) - $pow) * ($crit-1))) * $link;
				//총 데미지
				$dps_timeline[$curframe][1] = $dps_timeline[$curframe-1][1] + $dps_timeline[$curframe][0];
			} 
			
			//발사프레임이 아닐경우 0 넣어줌
			else {
				//첫번째 사이클일경우
				if($curframe == 0) {
					$dps_timeline[0][0] = 0;
					$dps_timeline[0][1] = 0;
				}
				else {
					$dps_timeline[$curframe][0] = 0;
					$dps_timeline[$curframe][1] = $dps_timeline[$curframe-1][1];
				}
			}
			
			//
			//후스킬 구현
			//
			if(isset($skill_timeline[$key][$curframe])) {
				foreach($skill_timeline[$key][$curframe] as $f_skill) {
					$f_skill_id = $f_skill[0];
					$f_skill_dollid = $f_skill[1];
					$f_skill_level = $f_skill[2];

					$l_skill;
					foreach($skills as $tmp) {
						if($tmp->id == $f_skill_id) {
							$l_skill = $tmp;
						}
					}
					
					//호크아이 스킬 구현
					if($f_skill_id == 46 && $curframe == $fireframe) {
						//해당스킬 데이터 파싱
						foreach($l_skill->data as $f_data) {
							//화력증가
							if($f_data->key == "AC") {
								$repeat = getDollById($f_skill_dollid)->skill->dataPool->AC[$f_skill_level-1];
								$tmp = $dps_timeline[$curframe][0];
								$dps_timeline[$curframe][0] += $tmp * ($repeat-1);
								$dps_timeline[$curframe][1] += $tmp * ($repeat-1);
							}
						}
					}
					
					//저격개시 스킬 구현 (저격개시, 정밀저격, 목표제거, 확인사살, 이중사격)
					if($f_skill_id == 32 || $f_skill_id == 33 || $f_skill_id == 34 || $f_skill_id == 35 || $f_skill_id == 43) {
						//해당스킬 데이터 파싱
						foreach($l_skill->data as $f_data) {
							//화력증가
							if($f_data->key == "DM") {
								$amp = getDollById($f_skill_dollid)->skill->dataPool->DM[$f_skill_level-1] / 100;
								$dps_timeline[$curframe][0] += $pow * $link * $amp;
								$dps_timeline[$curframe][1] += $pow * $link * $amp;
							}
						}
					}
				}
			}
			
			//다음 발사시점 구하기
			//mg는 발사시점 고정이니 rate값을 프레임으로 변환하지 않고 그대로감
			if($doll->type != 'mg') {
				$frame = rate_to_frame($rate);
			}
			
			//발사 프레임이였을경우 다음 프레임 계산 및 탄약계산
			if($curframe == $fireframe) {
				$beforeFrame = $curframe;
				$fireframe += $frame;
				$ammocnt--;
				$firecount++;
			}
		}
		
		/*
		//끝나고 한번더 15초까지의 빈 공간을 전부 채움
		for($i = $beforeFrame + 1 ; $i <= 450 ; $i++) {
			if(isset($dps_timeline[$beforeFrame][1])) {
				$val = $dps_timeline[$beforeFrame][1];
			}
			else {
				$val = 0;
			}
			$dps_timeline[$i][0] = 0;
			$dps_timeline[$i][1] = $val;
		}
		*/
		
		//print_r($dps_timeline);
		
		//초단위로 출력
		for($i = 1 ; $i <= 450  ; $i++) {
			if(isset($dps_timeline[$i][1])) {
				$cnt = floor($i/15)+1;
				$dps_timeline_sec[$cnt] = $dps_timeline[$i][1];
			}
		}
		
		
		$time_end = microtime(true);
		$time = $time_end - $time_start;
		
		//print_r($dps_timeline);
		//$resultvalue['timeline'][$key] = $dps_timeline;
		$resultvalue['timeline_sec'][$key] = $dps_timeline_sec;
		$resultvalue['dps'][$key] = $dps_timeline[449][1] / 15;
		$resultvalue['time'] = $time;
	}
	//$resultvalue['skill_timeline'] = $skill_timeline;
    
    include('testlib.php');
    
    $resultvalue["actionPoint"] = getAllEff($grid, false);
    $resultvalue["actionPoint_n"] = getAllEff($grid, true);
	
	echo json_encode($resultvalue);
	
	function rate_to_frame($rate) {
		switch($rate) {
			case 14: return 107; break;
			case 15: return 99; break;
			case 16: return 93; break;
			case 17: return 88; break;
			case 18: return 83; break;
			case 19: return 78; break;
			case 20: return 74; break;
			case 21: return 71; break;
			case 22: return 68; break;
			case 23: return 65; break;
			case 24: return 62; break;
			case 25: return 59; break;
			case 26: return 57; break;
			case 27: return 55; break;
			case 28: return 53; break;
			case 29: return 51; break;
			case 30: return 49; break;
			case 31: return 48; break;
			case 32: return 46; break;
			case 33: return 45; break;
			case 34: return 44; break;
			case 35: return 42; break;
			case 36: return 41; break;
			case 37: return 40; break;
			case 38: return 39; break;
			case 39: return 38; break;
			case 40: return 37; break;
			case 41: return 36; break;
			case 42: return 35; break;
			case 43: return 34; break;
			case 44: return 34; break;
			case 45: return 33; break;
			case 46: return 32; break;
			case 47: return 31; break;
			case 48: return 31; break;
			case 49: return 30; break;
			case 50: return 29; break;
			case 51: return 29; break;
			case 52: return 28; break;
			case 53: return 28; break;
			case 54: return 27; break;
			case 55: return 27; break;
			case 56: return 26; break;
			case 57: return 26; break;
			case 58: return 25; break;
			case 59: return 25; break;
			case 60: return 24; break;
			case 61: return 24; break;
			case 62: return 24; break;
			case 63: return 23; break;
			case 64: return 23; break;
			case 65: return 23; break;
			case 66: return 22; break;
			case 67: return 22; break;
			case 68: return 22; break;
			case 69: return 21; break;
			case 70: return 21; break;
			case 71: return 21; break;
			case 72: return 20; break;
			case 73: return 20; break;
			case 74: return 20; break;
			case 75: return 19; break;
			case 76: return 19; break;
			case 77: return 19; break;
			case 78: return 19; break;
			case 79: return 18; break;
			case 80: return 18; break;
			case 81: return 18; break;
			case 82: return 18; break;
			case 83: return 18; break;
			case 84: return 17; break;
			case 85: return 17; break;
			case 86: return 17; break;
			case 87: return 17; break;
			case 88: return 17; break;
			case 89: return 16; break;
			case 90: return 16; break;
			case 91: return 16; break;
			case 92: return 16; break;
			case 93: return 16; break;
			case 94: return 15; break;
			case 95: return 15; break;
			case 96: return 15; break;
			case 97: return 15; break;
			case 98: return 15; break;
			case 99: return 15; break;
			case 100: return 14; break;
			case 101: return 14; break;
			case 102: return 14; break;
			case 103: return 14; break;
			case 104: return 14; break;
			case 105: return 14; break;
			case 106: return 14; break;
			case 107: return 14; break;
			case 108: return 13; break;
			case 109: return 13; break;
			case 110: return 13; break;
			case 111: return 13; break;
			case 112: return 13; break;
			case 113: return 13; break;
			case 114: return 13; break;
			case 115: return 13; break;
			case 116: return 12; break;
			case 117: return 12; break;
			case 118: return 12; break;
			case 119: return 12; break;
			case 120: return 12; break;
		}
		return 450;
	}
	
	function getDollById($id) {
		global $dolls;
		
		foreach($dolls as $data) {
			if($data->id == $id) {
				return $data;
				break;
			}
		}
	}
	function getSkillById($id) {
		global $skills;
		
		foreach($skills as $data) {
			if($data->id == $id) {
				return $data;
				break;
			}
		}
	}
?>