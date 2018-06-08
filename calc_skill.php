<?php
//if(GF_HEADER != "aaaaa") exit; 
//$skill_timeline = [];
switch($doll->skill->id) {
	//자가버프
	case 1: //화력전개
	case 2: //화력전개SG
	case 4: //고속사격
	case 21: //강행돌파
	case 22: //기습공격
	case 23: //신속처분
	case 24: //집중사격
	case 25: //집중사격N
	case 55: //저격지원
	case 60: //민첩사격
	
	case 46: //호크아이
	
	case 48: //육참골단
		$duration = $doll->skill->dataPool->DR[$skilllevel-1] * 30;
		$to = $i + $duration;
		for($i; $i <= $to ; $i++) {
			if($i > 450) break;
			
			$skill_timeline[$key][$i][] = [$skillid, $doll->id, $skilllevel];
		}
		$i += $doll->skill->dataPool->CD[$skilllevel-1] * 30 - $duration;
		break;
	
	case 32: //저격개시
	case 33: //정밀저격
	case 34: //목표제거
	case 35: //확인사살
		$to = $i + 45; //1.5초 뒤에 쏴야함
		if($to > 450) break;
		
		$skill_timeline[$key][$to][] = [$skillid, $doll->id, $skilllevel];
		
		$i += $doll->skill->dataPool->CD[$skilllevel-1] * 30;
		break;
		
	case 43: //이중저격
		$to = $i + 30; //1초 뒤에 쏴야함
		if($to > 450) break;
		
		$skill_timeline[$key][$to][] = [$skillid, $doll->id, $skilllevel];
		
		//1초 뒤에 한번 더 쏨
		$skill_timeline[$key][$to+30][] = [$skillid, $doll->id, $skilllevel];
		
		$i += $doll->skill->dataPool->CD[$skilllevel-1] * 30;
		break;
		
	//아군전체 버프
	case 3: //일제사격
	case 5: //진압신호
	case 26: //돌격개시
	case 27: //사냥신호
	case 29: //기습작전
	case 30: //소멸지시
		$duration = $doll->skill->dataPool->DR[$skilllevel-1] * 30;
		$to = $i + $duration;
		for($i; $i <= $to ; $i++) {
			if($i > 450) break;
			for($j = 1 ; $j <= 9 ; $j++) {
				$skill_timeline[$j][$i][] = [$skillid, $doll->id, $skilllevel];
			}
		}
		$i += $doll->skill->dataPool->CD[$skilllevel-1] * 30 - $duration;
		break;
	
	//선혈의 파도
	case 54: 
		$duration = $doll->skill->dataPool->DR[$skilllevel-1] * 30;
		$to = $i + $duration;
		for($i; $i <= $to ; $i++) {
			if($i > 450) {
				break;
			}
			$uppos = $key + 3;
			$downpos = $key - 3;
			if($uppos <= 9) 
				$skill_timeline[$uppos][$i][] = [$skillid, $doll->id, $skilllevel];
			if($downpos >= 1) 
				$skill_timeline[$downpos][$i][] = [$skillid, $doll->id, $skilllevel];
		}
		$i += $doll->skill->dataPool->CD[$skilllevel-1] * 30 - $duration;
		break;
		
	//나머지는 그냥 스킵
	default:
		$i = 451;
}
?>