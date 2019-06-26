<?php

function getMinAttr($attr) {
	switch($attr) {
		case "pow": return 0;
		case "hit": return 1;
		case "dodge": return 0;
		case "speed": return 0;
		case "rate": return 1;
		case "critical_harm_rate": return 0;
		case "critical_percent": return 0;
		case "armor_piercing": return 0;
		case "armor": return 0;
		case "def": return 0;
		case "defBreak": return 0;
	}
}


function getGridEffVal($pos, $type) {
    global $grid;
    
    if(isset($grid[$pos][$type]['pow'])) {
        $num0 = $grid[$pos][$type]['pow'] / 100 +1;
    } else $num0 = 1;
    if(isset($grid[$pos][$type]['rate'])) {
        $num1 = $grid[$pos][$type]['rate'] / 100 +1;
    } else $num1 = 1;
    if(isset($grid[$pos][$type]['hit'])) {
        $num2 = $grid[$pos][$type]['hit'] / 100 +1;
    } else $num2 = 1;
    if(isset($grid[$pos][$type]['dodge'])) {
        $num3 = $grid[$pos][$type]['dodge'] / 100 +1;
    } else $num3 = 1;
    if(isset($grid[$pos][$type]['crit'])) {
        $num4 = $grid[$pos][$type]['crit'] / 100 +1;
    } else $num4 = 1;
    if(isset($grid[$pos][$type]['cooldown'])) {
        $num5 = $grid[$pos][$type]['cooldown'] / 100 +1;
    } else $num5 = 1;
    if(isset($grid[$pos][$type]['ap'])) {
        $num6 = $grid[$pos][$type]['ap'] / 100 +1;
    } else $num6 = 1;
    if(isset($grid[$pos][$type]['armor'])) {
        $num7 = $grid[$pos][$type]['armor'] / 100 +1;
    } else $num7 = 1;

	return [$num0, $num1, $num2, $num3, $num4, $num5, $num6, $num7];
}


function getSkillLevel($pos) {
	global $position;
    
    return $position[$pos]['skilllevel'];
}
function getSkill2Level($pos) {
	global $position;
    
    return $position[$pos]['skill2level'];
}


function getLink($pos) {
    global $position;
    
    $lv = $position[$pos]['level'];
    
    if($lv < 10) {
        return 1;
    }
    else  if($lv >= 10 && $lv < 30) {
        return 2;
    }
    else  if($lv >= 30 && $lv < 70) {
        return 3;
    }
    else  if($lv >= 70 && $lv < 90) {
        return 4;
    }
    else  if($lv >= 90){
        return 5;
    }
}

function getAllEff($grid, $isNight) {
    //인형 위치
	// key -> 위치
	// value -> [0] dollid, [1] level, [2] favor [3] type [4] rank [5] skilllevel [6] type
	global $position;
	
	//진형효과, 위치
	// key -> 위치
	// value ->
	//  key -> 무기 타입
	//  value ->
	//   key -> 화력, 사속등의 타입
	//   value -> 수치
	global $grid;
	
	//인형 기본 스탯
	// key -> 위치
	// value -> 레벨, 호감도계산된 doll.json의 stats부분 
	global $stats;
    
	global $fairy;
	
    $tot = 0;
    
    foreach($position as $key => $pos) {
        $stat = $stats[$key];
        
        $doll = new stdClass();
        $gear = 0;
        $fairybuff = 1; //요정버프는 현재 구현안됨, 1배로 넣음
        $fairyskill = 1; //요정스킬은 현재 구현안됨, 1배로 넣음
        $fairyattr = 1; //요정특성은 현재 구현안됨, 1배로 넣음
        $dollskill = 1; //인형스킬 데미지 쿨감은 스킬 없으니 제외
        
        
        $doll->bullet = $stat['bullet'];
        $doll->id = $pos['id'];
        $doll->type = $pos['type'];
        $doll->rank = $pos['rank'];
        $doll->pos = $key;
        
        //인형 스킬 스탯 계산
        //화력 구하기
        if(!isset($grid[$key][$doll->type]['pow']) || $grid[$key][$doll->type]['pow'] == 0) {
            $grid_pow = 1;
        } else {
            $grid_pow = 1 + $grid[$key][$doll->type]['pow'] / 100;
        }
        $pow = ceil(ceil((ceil($stat['pow']) + $gear) * $fairy['pow']) * $grid_pow * $fairyskill * $fairyattr);
        
        //사속 구하기
        if(!isset($grid[$key][$doll->type]['rate']) || $grid[$key][$doll->type]['rate'] == 0) {
            $grid_rate = 1;
        } else {
            $grid_rate = 1 + $grid[$key][$doll->type]['rate'] / 100;
        }
        $rate = ceil(ceil((ceil($stat['rate']) + $gear) * $fairybuff) * $grid_rate * $fairyskill * $fairyattr);
        
		//사속한계 적용
        if($doll->type != 'mg' && $rate > 120) {
            $rate = 120;
        }
        if($doll->type == 'sg' && $rate > 60) {
            $rate = 60;
        }
		
        //명중 구하기
        if(!isset($grid[$key][$doll->type]['hit']) || $grid[$key][$doll->type]['hit'] == 0) {
            $grid_hit = 1;
        } else {
            $grid_hit = 1 + $grid[$key][$doll->type]['hit'] / 100;
        }
        $hit = ceil(ceil((ceil($stat['hit']) + $gear) * $fairy['hit']) * $grid_hit * $fairyskill * $fairyattr);
            
        //회피 구하기
        if(!isset($grid[$key][$doll->type]['dodge']) || $grid[$key][$doll->type]['dodge'] == 0) {
            $grid_dodge = 1;
        } else {
            $grid_dodge = 1 + $grid[$key][$doll->type]['dodge'] / 100;
        }
        $dodge = ceil(ceil((ceil($stat['dodge']) + $gear) * $fairy['dodge']) * $grid_dodge *$fairyskill * $fairyattr);
            
        //크리 구하기
        if(!isset($grid[$key][$doll->type]['crit']) || $grid[$key][$doll->type]['crit'] == 0) {
            $grid_crit = 1;
        } else {
            $grid_crit = 1 + $grid[$key][$doll->type]['crit'] / 100;
        }
        $crit = ceil(ceil((ceil($stat['crit']) + $gear) * $fairybuff) * $grid_crit * $fairyskill * $fairyattr);
        
        //관통 구하기
        if(!isset($grid[$key][$doll->type]['ap']) || $grid[$key][$doll->type]['ap'] == 0) {
            $grid_ap = 1;
        } else {
            $grid_ap = 1 + $grid[$key][$doll->type]['ap'] / 100;
        }
        $ap = ceil(ceil((ceil($stat['armorPiercing']) + $gear) * $fairybuff) * $grid_ap * $fairyskill * $fairyattr);
        
        //아머 구하기
        if(!isset($grid[$key][$doll->type]['armor']) || $grid[$key][$doll->type]['armor'] == 0) {
            $grid_armor = 1;
        } else {
            $grid_armor = 1 + $grid[$key][$doll->type]['armor'] / 100;
        }
        $armor = ceil(ceil((ceil($stat['armor']) + $gear) * $fairy['armor']) * $grid_armor * $fairyskill * $fairyattr);
        
        $doll->pow = $pow;
        $doll->rate = $rate;
        $doll->hit = $hit;
        $doll->crit = $crit;
        $doll->dodge = $dodge;
        $doll->armor = $armor;
        $doll->armorPiercing = $ap;
        $doll->hp = $stat['hp'];
        if($fairy['critDmg'] == 0) $fairy['critDmg'] = 1;
        $critDmg = 1.5 + $stat['critDmg'] / 100;
        $doll->critDmg = $critDmg + ($critDmg*$fairy['critDmg']-1.5);
        
        $tot += getPoint($doll, $isNight);
        
    }
    return $tot;
}

function getPoint($doll, $isNight = false) {
	//return getAtkPoint($doll, $isNight) + getSurPoint($doll) + getSkill1Point($doll) + getSkill2Point($doll);
    if($doll->id > 20000)
        return getAtkPoint($doll, $isNight) + getSurPoint($doll) + getSkill1Point($doll) + getSkill2Point($doll);
    else 
        return getAtkPoint($doll, $isNight) + getSurPoint($doll) + getSkill1Point($doll);
}

function getAtkPoint($doll, $isNight) {
  $pow = $doll->pow;
  $rate = $doll->rate;
  $hit = $doll->hit;
  $crit = $doll->crit;
  $piercing = $doll->armorPiercing;
  //$num4 = this.criHarmRate - 100;
  $num4 = $doll->critDmg * 100 - 100;
  /*
  if (!countFairy)
  {
	$pow -= this.fairyPow;
	$hit -= this.fairyHit;
  }
  */
  /*
  if (!basePoint)
  {
	if (team == null)
	  team = this.team;
	if (team != null)
	{
	  $effectGridValue = getGridEffVal($doll->pos, $doll->type);
	  $pow = ceil(max(getMinAttr('pow'), $pow * $effectGridValue[0]));
	  $rate = ceil(max(getMinAttr('rate'), $rate * $effectGridValue[1]));
	  $hit = ceil(max(getMinAttr('hit'), $hit * $effectGridValue[2]));
	  $crit = ceil(max(getMinAttr('critical_percent'),  $crit * $effectGridValue[4]));
	  $piercing = ceil(max(getMinAttr('armor_piercing'), $piercing * $effectGridValue[6]));
	}
  }*/ 
 /*
  $effectGridValue = getGridEffVal($doll->pos, $doll->type);
  $pow = ceil(max(getMinAttr('pow'), $pow * $effectGridValue[0]));
  $rate = ceil(max(getMinAttr('rate'), $rate * $effectGridValue[1]));
  $hit = ceil(max(getMinAttr('hit'), $hit * $effectGridValue[2]));
  $crit = ceil(max(getMinAttr('critical_percent'),  $crit * $effectGridValue[4]));
  $piercing = ceil(max(getMinAttr('armor_piercing'), $piercing * $effectGridValue[6]));
 */
  $maxHp = $doll->hp;
  $num5 = $maxHp;

  $num6 = 0;
  //인형 총알수 + 장비 총알 수
  $num7 = $doll->bullet + 0;
  $num8 = $hit;
  if($isNight)
	  //$hit * (1 + 야간 디버프 * 야간버프(장비))
	$num8 = ceil($hit * (1.0 + -0.9 * (1.0 - 0)));
    
  switch($doll->type)
  {
	case "mg":
	/*
	  float dataFromStringArray1 = Data.GetDataFromStringArray<float>("attack_effect_mg", 0, ',');
	  num6 = Data.GetDataFromStringArray<float>("attack_effect_mg", 1, ',');
	  float dataFromStringArray2 = Data.GetDataFromStringArray<float>("attack_effect_mg", 2, ',');
	  float dataFromStringArray3 = Data.GetDataFromStringArray<float>("attack_effect_mg", 3, ',');
	  float dataFromStringArray4 = Data.GetDataFromStringArray<float>("attack_effect_mg", 4, ',');
	  float dataFromStringArray5 = Data.GetDataFromStringArray<float>("attack_effect_mg", 5, ',');
	  float dataFromStringArray6 = Data.GetDataFromStringArray<float>("attack_effect_mg", 6, ',');
	  */
	  $dataFromStringArray1 = 7;
	  $num6 = 1.5;
	  $dataFromStringArray2 = 4;
	  $dataFromStringArray3 = 200;
	  $dataFromStringArray4 = 23;
	  $dataFromStringArray5 = 8;
	  //$dataFromStringArray6 = 2;
	  $dataFromStringArray6 = 3;
	  return ceil(($dataFromStringArray1 * ceil($num5 / $maxHp * getLink($doll->pos)) * ($num7 * ($pow + $piercing / $dataFromStringArray6) * ($num4 / 100.0 * $crit / 100.0 + 1.0) / ($num7 / 3.0 + $dataFromStringArray2 + $dataFromStringArray3 / $rate) * $num8 / ($num8 + $dataFromStringArray4) + $dataFromStringArray5)));
	case "sg":
	  /*
	  float dataFromStringArray7 = Data.GetDataFromStringArray<float>("attack_effect_sg", 0, ',');
	  num6 = Data.GetDataFromStringArray<float>("attack_effect_sg", 1, ',');
	  float dataFromStringArray8 = Data.GetDataFromStringArray<float>("attack_effect_sg", 2, ',');
	  float dataFromStringArray9 = Data.GetDataFromStringArray<float>("attack_effect_sg", 3, ',');
	  float dataFromStringArray10 = Data.GetDataFromStringArray<float>("attack_effect_sg", 4, ',');
	  float dataFromStringArray11 = Data.GetDataFromStringArray<float>("attack_effect_sg", 5, ',');
	  float dataFromStringArray12 = Data.GetDataFromStringArray<float>("attack_effect_sg", 6, ',');
	  float dataFromStringArray13 = Data.GetDataFromStringArray<float>("attack_effect_sg", 7, ',');
	  float dataFromStringArray14 = Data.GetDataFromStringArray<float>("attack_effect_sg", 8, ',');
	  */
	  $dataFromStringArray7 = 6;
	  $num6 = 1.5;
	  $dataFromStringArray8 = 23;
	  $dataFromStringArray9 = 8;
	  $dataFromStringArray10 = 50;
	  //$dataFromStringArray11 = 2;
	  $dataFromStringArray11 = 3;
	  $dataFromStringArray12 = 3;
	  $dataFromStringArray13 = 1.5;
	  $dataFromStringArray14 = 0.5;
	  return ceil(($dataFromStringArray7 * ceil($num5 / $maxHp * getLink($doll->pos)) * ($dataFromStringArray12 * $num7 * ($pow + $piercing / $dataFromStringArray11) * ($num4 / 100.0 * $crit / 100.0 + 1.0) / ($num7 * $dataFromStringArray10 / $rate + $dataFromStringArray13 + $dataFromStringArray14 * $num7) * $num8 / ($num8 + $dataFromStringArray8) + $dataFromStringArray9)));
	default:
	  /*
	  float dataFromStringArray15 = Data.GetDataFromStringArray<float>("attack_effect_normal", 0, ',');
	  num6 = Data.GetDataFromStringArray<float>("attack_effect_normal", 1, ',');
	  float dataFromStringArray16 = Data.GetDataFromStringArray<float>("attack_effect_normal", 2, ',');
	  float dataFromStringArray17 = Data.GetDataFromStringArray<float>("attack_effect_normal", 3, ',');
	  float dataFromStringArray18 = Data.GetDataFromStringArray<float>("attack_effect_normal", 4, ',');
	  float dataFromStringArray19 = Data.GetDataFromStringArray<float>("attack_effect_normal", 5, ',');
	  */
	  $dataFromStringArray15 = 5;
	  $num6 = 1.5;
	  $dataFromStringArray16 = 23;
	  $dataFromStringArray17 = 8;
	  $dataFromStringArray18 = 50;
	  //$dataFromStringArray19 = 2;
	  $dataFromStringArray19 = 3;
	  return ceil(($dataFromStringArray15 * ceil($num5 / $maxHp * getLink($doll->pos)) * (($pow + $piercing / $dataFromStringArray19) * ($num4 / 100.0 * $crit / 100.0 + 1.0) * $rate / $dataFromStringArray18 * $num8 / ($num8 + $dataFromStringArray16) + $dataFromStringArray17)));
  }
}








function getSkill1Point($doll) {
  $num1 = getGridEffVal($doll->pos, $doll->type)[6];
  $num2 = $doll->hp;
  
  //float dataFromStringArray1 = Data.GetDataFromStringArray<float>("skill_effect", 0, ',');
  //float dataFromStringArray2 = Data.GetDataFromStringArray<float>("skill_effect", 1, ',');
  $dataFromStringArray1 = 35;
  $dataFromStringArray2 = 5;
  $level = getSkillLevel($doll->pos);
  
  return ceil(ceil($num2 / $num2 * getLink($doll->pos)) * (0.800000011920929 + $doll->rank / 10.0) * ($dataFromStringArray1 + $dataFromStringArray2 * ($level - 1)) * ceil($level / 10) * $num1);
}









function GetSkill2Point($doll) {
  $num1 = getGridEffVal($doll->pos, $doll->type)[6];
  $num2 = $doll->hp;
  
  //float dataFromStringArray1 = Data.GetDataFromStringArray<float>("skill2_effect", 0, ',');
  //float dataFromStringArray2 = Data.GetDataFromStringArray<float>("skill2_effect", 1, ',');
  $dataFromStringArray1 = 15;
  $dataFromStringArray2 = 2;
  $level = getSkill2Level($doll->pos);
  return ceil(ceil($num2 / $num2 * getLink($doll->pos)) * (0.800000011920929 + $doll->rank / 10.0) * ($dataFromStringArray1 + $dataFromStringArray2 * ($level - 1)) * ceil($level / 10));
}

function GetSurPoint($doll) {
  $pow = $doll->pow;
  $dodge = $doll->dodge;
  $armor = $doll->armor;
/*
  $effectGridValue = getGridEffVal($doll->pos, $doll->type);
  $dodge = ceil(max(getMinAttr('dodge'), $dodge * $effectGridValue[3]));
  $armor = ceil(max(getMinAttr('armor'), $armor * $effectGridValue[7]));
*/
  $num7 = $doll->hp * getLink($doll->pos);

  /*
  float dataFromStringArray1 = Data.GetDataFromStringArray<float>("deffence_effect", 0, ',');
  float dataFromStringArray2 = Data.GetDataFromStringArray<float>("deffence_effect", 1, ',');
  float dataFromStringArray3 = Data.GetDataFromStringArray<float>("deffence_effect", 2, ',');
  float dataFromStringArray4 = Data.GetDataFromStringArray<float>("deffence_effect", 3, ',');
  float dataFromStringArray5 = Data.GetDataFromStringArray<float>("deffence_effect", 4, ',');
  float dataFromStringArray6 = Data.GetDataFromStringArray<float>("deffence_effect", 5, ',');
  */
  $dataFromStringArray1 = 1;
  $dataFromStringArray2 = 35;
  $dataFromStringArray3 = 2.6;
  $dataFromStringArray4 = 75;
  $dataFromStringArray5 = 1.6;
  $dataFromStringArray6 = 1;
  
  return $dataFromStringArray1 * ceil($num7 * (($dataFromStringArray2 + $dodge) / $dataFromStringArray2) * ($dataFromStringArray3 * $dataFromStringArray4 / max($dataFromStringArray4 - $armor / $dataFromStringArray6, 1) - $dataFromStringArray5));
}

?>