<?php
	define("GF_HEADER", "aaaaa");
	require_once("common.php");
	
	if(empty($_GET['id'])) { header("Location: http://gfl.zzzzz.kr/squads.php", true, 301); exit();}
	
	switch($_GET['id']) {
	}
	

	//인형데이터 불러오기
	$squads = json_decode(getJson('squad'));
	foreach($squads as $data) {
		if(is_numeric($_GET['id'])) {
			if($data->id == $_GET['id']) {
				$squad = $data;
				break;
			}
		}
		else {
			if($data->name == $_GET['id'] || $data->krName == $_GET['id']) {
				$_GET['id'] = $data->id;
				$squad = $data;
				break;
			}
		}
	}
	
	if(empty($squad)) Error('데이터 없음<br><br>NPC, BOSS는 데이터가 존재하지 않습니다.<br> 인형의 경우는 데이터가 안맞는것으로 게시판에 알려주심됩니다.');
	
	//이미지 불러오기
	$imglist = [];
	$skinlist = [];
	$sdStatus = [];
	$spath = 'img/squads/';
	$path = 'img/characters/';
	
	$header_title =  "" . $squad->name . ", " . $squad->krName . " | " . L::sitetitle_short;
	$header_desc = "{$squad->krName}, {$squad->krName} 보이스, {$squad->krName} SD, {$squad->krName} 스킨, {$squad->name}, 소녀전선 검열, " . implode(', ', $squad->nick) . ", " . implode(', ', $squad->skin);
	$header_image = "http://gfl.zzzzz.kr/img/squads/" .$squad->name . ".png";
	
	//서버 스킬데이터 불러오기
	$tmp = getDataFile('battle_skill_config', $lang);
	
	$rskills = explode(PHP_EOL, $tmp);
	for($i = 1 ; $i<=3 ; $i++) {
		if(isset($squad->{"skill".$i}->realid)) {
			$rskill_name[$i] = '';
			$rskill_txt[$i] = [];
			$j = 0;
			foreach($rskills as $line) {
				preg_match("/battle_skill_config-([0-9])([0-9]{6})([0-9]{2}),(.*)/", $line, $matches);
				$s_level = intval($matches[3]);
				
				if($matches[1] == 1 && $matches[2] == $squad->{"skill".$i}->realid) {
					$rskill_name[$i] = explode(',', $rskills[$j])[1];
					$rskill_txt[$i][$s_level] = explode(',', $rskills[$j+1])[1];
					$rskill_txt[$i][$s_level] = str_replace("//c" , ',', $rskill_txt[$i][$s_level]);
					$rskill_txt[$i][$s_level] = str_replace("；" , '<br>', $rskill_txt[$i][$s_level]);
					$rskill_txt[$i][$s_level] = str_replace("//n" , '<br>', $rskill_txt[$i][$s_level]);
					$rskill_txt[$i][$s_level] = preg_replace("/([0-9.]{1,4}[%배초의칸개발회])/u", "<span class='txthighlight'>\\1</span>", $rskill_txt[$i][$s_level]);
					$rskill_txt[$i][$s_level] = preg_replace("/([\+\-0-9.]{1,4}[％倍秒])/u", "<span class='txthighlight'>\\1</span>", $rskill_txt[$i][$s_level]);
					
					if($s_level == 10) break;
				}
				$j++;
			}
		}
	}
	
	//진형효과 진형 불러오기
	$chippos = [];
	for($i = 0 ; $i < 5 ; $i++) {
		foreach($squad->chipset[$i] as $val) {
			$chippos[$i][$val] = '1';
		}
	}
	
	/*
	if(file_exists("$path{$doll->name}/spine/r{$doll->name}a.atlas")) $sdStatus[0][0][0] = 1;
	else $sdStatus[0][0][0] = 0;
	if(file_exists("$path{$doll->name}/spine/r{$doll->name}b.atlas")) $sdStatus[0][0][1] = 1;
	else $sdStatus[0][0][1] = 0;
	if(file_exists("$path{$doll->name}/spine/r{$doll->name}c.atlas")) $sdStatus[0][0][2] = 1;
	else $sdStatus[0][0][2] = 0;
	if(file_exists("$path{$doll->name}/spine/r{$doll->name}a.png")) $sdStatus[0][1][0] = 1;
	else $sdStatus[0][1][0] = 0;
	if(file_exists("$path{$doll->name}/spine/r{$doll->name}b.png")) $sdStatus[0][1][1] = 1;
	else $sdStatus[0][1][1] = 0;
	if(file_exists("$path{$doll->name}/spine/r{$doll->name}c.png")) $sdStatus[0][1][2] = 1;
	else $sdStatus[0][1][2] = 0;
	if(file_exists("$path{$doll->name}/spine/r{$doll->name}a.skel")) $sdStatus[0][2][0] = 1;
	else $sdStatus[0][2][0] = 0;
	if(file_exists("$path{$doll->name}/spine/r{$doll->name}b.skel")) $sdStatus[0][2][1] = 1;
	else $sdStatus[0][2][1] = 0;
	if(file_exists("$path{$doll->name}/spine/r{$doll->name}c.skel")) $sdStatus[0][2][2] = 1;
	else $sdStatus[0][2][2] = 0;
	*/
	
	$squadname;
	if($lang == 'en') 
		$squadname = $squad->name;
	else if($lang == 'ja')
		$squadname = isset($squad->jpName)?$squad->jpName:$squad->name;
	else
		$squadname = isset($squad->krName)?$squad->krName:$squad->name;
	
	function getSquadSkillImg($id) {
		switch($id) {
			case 500001: return "tow_missile"; break;
			case 500003: return "squadbuff"; break;
			case 500005: return "squadbuff"; break;
			case 500007: return "2b14_boom"; break;
			case 500009: return "squadbuff"; break;
			case 500010: return "2b14_debuff"; break;
			case 500021: return "ags_grenede"; break;
			case 500022: return "squadbuff"; break;
			case 500023: return "agsprobility"; break;
		}
	}
	
	require_once("header.php");
?>
    <main role="main" class="container-fluid">
		<div class="my-1 p-3 bg-white rounded box-shadow">
			<h2 style="display: inline" class="mr-2">#<?=$squad->id?> <?=$squadname?></h2><i><span class="text-muted"><?=$squad->name?></span></i><br>
			<hr class="mt-1 mb-1">
			<div class="row">
				<div class="doll_img" style="max-height: 100%">
					<img skin-id="0" src="img/squads/<?=$squad->name?>_full.png">
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
			<hr class="mt-1 mb-1">
			<div style="display: flex">
				<!-- <div style="width:20%;"><input id="sdDorm" type="checkbox"><label for="sdDorm"><?=L::database_sd_dorm?></label></div> -->
				<div style="width:20%;">Select Motion</div>
				<div style="width:80%;">
					<select style="width:100%;" id="sdAniSelector" autocomplete='off'>
					</select>
				</div>
			</div>
			<div id="sd_div">
				<div class="canvasclick row align-items-center justify-content-center">
					<div class="preCanvas" style="width: 100%; height: 400px"></div>
				</div>
			</div>
			
	<?php for($i = 1 ; $i <= 3 ; $i++) { ?>
			<hr class="mt-1 mb-1">
			<div class="row pb-0">
				<div class="col-md-2 align-self-center">
					<img class="skillimg" src="img/skill/<?=getSquadSkillImg($squad->{"skill" . $i}->realid)?>.png"> <?=$rskill_name[$i]?>
				</div>
				<div class="col">
					<select class="skilllevel">
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
					<span id="skill<?=$i?>_txt"><?=$rskill_txt[$i][10]?></span><br>
					<?=$skillcolldown?>
				</div>
			</div>
	<?php } ?>
			<hr class="mt-1 mb-1">
			<div class="row">
				<div class="col-md-auto align-self-center">
					<b>특성</b>
				</div>
				<div class="col">
					<table class="table-sm table-bordered ">
						<tr>
							<td>부대규모 : <span id="squadattr_squad"><?=$squad->attr->scale?></span></td>
							<td>지원거리 : <span id="squadattr_range"><?=$squad->attr->minrange?>~<?=$squad->attr->maxrange?></span></td>
						</tr>
						<tr>
							<td>탄약 : <span id="squadattr_ammo"><?=$squad->attr->ammo?></span></td>
							<td>식량 : <span id="squadattr_food"><?=$squad->attr->food?></span></td>
						</tr>
					</table>
				</div>
			</div>
			
			<hr class="mt-1 mb-1">
			<div class="row">
				<div class="col-md-auto align-self-center">
					<b><?=L::database_stats?></b>
				</div>
				<div class="col">
					<table class="table-sm table-bordered ">
						<tr>
							<td>살상 : <span id=""><?=$squad->stats->pow?></span></td>
							<td>파쇄 : <span id=""><?=$squad->stats->crush?></span></td>
						</tr>
						<tr>
							<td>정밀 : <span id=""><?=$squad->stats->precise?></span></td>
							<td>장전 : <span id=""><?=$squad->stats->reload?></span></td>
						</tr>
					</table>
				</div>
			</div>
			
			<hr class="mt-1 mb-1">
			<div class="row">
				<div class="col-md-auto align-self-center">
					<b>칩셋</b>
				</div>
				<div class="col">
					<select id="chiplevel">
						<option value=1>1<?=L::database_star?></option>
						<option value=2>2<?=L::database_star?></option>
						<option value=3>3<?=L::database_star?></option>
						<option value=4>4<?=L::database_star?></option>
						<option value=5>5<?=L::database_star?></option>
					</select>
					<table class="chipview">
			<?php for($i = 0 ; $i < 8 ; $i++) { ?>
						<tr>
			<?php for($j = 0 ; $j < 8 ; $j++) { $cnt = (7-$i)*8 + ($j+1); ?>
							<td id="chip_<?=$cnt?>"></td>
			<?php } ?>
						</tr>
			<?php } ?>
					</table>
				</div>
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
	<script src="dist/jsSpine.js?v=6"></script>
	
	<script>
		var squadname = "<?=$squad->name?>";

		jspine.init(squadname, 0);
		
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
		
		var rskilldata = <?=json_encode($rskill_txt, JSON_UNESCAPED_UNICODE)?>;
		$('.skilllevel').on('change', function(e) {
			var level = $(this).val();
			$('.skilllevel').val(level);
			
			for(var i = 1 ; i <= 3 ; i++) {
				$("#skill" + i + "_txt").html(rskilldata[i][level]);
			}
		});
		
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
		
		var skinstatus = <?=json_encode($sdStatus)?>;
		$("#sdAniSelector").on('change', function(e) {
			jspine.changeAnimation($(this).val());
		});
		$("#sdDorm").change(function() {
			var value = 0;
			
			if($(this).prop("checked")) {
				jspine.loadSquadR(squadname, value, skinstatus[value]);
			}
			else {
				jspine.loadSquadR(squadname, '');
			}
		});
		
		$(".doll_img img").on('load', function() {
			$(this).show().next().remove();
		});
		
		var chipdata = <?=json_encode($chippos, JSON_UNESCAPED_UNICODE)?>;
		$( document ).ready(function() {
			$("#chiplevel").val('5').trigger('change');;
		});

		$("#chiplevel").on('change', function(e) {
			var level = $(this).val() - 1;
			
			$(".chipview td").removeAttr('class');
			for (var key in chipdata[level]) {
				if(chipdata[level][key] == 1) {
					console.log('a');
					$("#chip_"+key).addClass('affected');
				}
			}
			
		});
	</script>
</html>