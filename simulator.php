<?php
	if(!empty($_POST)) {
		$dolls = json_decode(file_get_contents("data/doll.json"));
		
		
		
		echo json_encode($_POST);
		exit;
	}
	define("GF_HEADER", "aaaaa");
	$header_title = "소녀전선 DPS 시뮬레이터";
	$header_desc = "소녀전선 DPS 시뮬레이터, 소녀전선 제대편성 시뮬레이터, 소녀전선 딜계산기, 제대편성, 소녀전선, 소전";
	require_once("header.php");
?>
	<style>
		.effrow {
			display: flex;
			width: 100%;
			//height: 25vw;
		}
		.effitem {
			width: 100%;
			padding-top: 33%;
			//height: 25vw;
			//background-color: #e0e0e0;
			border: 1px solid black;
			cursor: pointer;
			position: relative;
		}
		.effitem.selected {
			background-color: lightyellow;
		}
		.effitem .content {
			position: absolute;
			top: 0;
			left: 0;
			bottom: 0;
			right: 0;
		}
		.dollicon {
			width: 60%;
		}
		.efficon {
			height: 2em;
		}
	</style>
    <main role="main" class="container">
		<div class="my-3 p-3 bg-white rounded box-shadow">
			<h2 class="pb-3 border-bottom border-gray">소전DB 제대편성&DPS시뮬레이터</h2>
			현재 특정스킬만 지원(맨 아래 확인), 공격력 랜덤조정 미적용, 치명상 랜덤이 아닌 평균값으로 계산<br>
			링크는 해당 레벨에서 가능한 최대치로 설정됨(ex 71lv -> 4링), 야간 스킬 적용안됨, 스킬레벨 10으로 고정 <br>
			DPS계산버튼 누를시 콘솔에 원시데이터 나오니 문제있으면 제보바람<br>
			
			<div id="scapture">
			<span id="watermark"></span>
				<div class="row">
					<div class="col-lg-7">
						<div class="effrow">
							<div class="effitem" id="grid7">
								<div class="content"></div>
							</div>
							<div class="effitem" id="grid8">
								<div class="content"></div>
							</div>
							<div class="effitem" id="grid9">
								<div class="content"></div>
							</div>
						</div>
						<div class="effrow">
							<div class="effitem" id="grid4">
								<div class="content"></div>
							</div>
							<div class="effitem" id="grid5">
								<div class="content"></div>
							</div>
							<div class="effitem" id="grid6">
								<div class="content"></div>
							</div>
						</div>
						<div class="effrow">
							<div class="effitem" id="grid1">
								<div class="content"></div>
							</div>
							<div class="effitem" id="grid2">
								<div class="content"></div>
							</div>
							<div class="effitem" id="grid3">
								<div class="content"></div>
							</div>
						</div>
					</div>
					<div class="col-lg-5">
						<div id="screenshot_hide">
							<form id="doll_inputs">
								<select disabled id="sel_type">
									<option>종류선택</option>
									<option value="AR">AR</option>
									<option value="RF">RF</option>
									<option value="SMG">SMG</option>
									<option value="MG">MG</option>
									<option value="SG">SG</option>
									<option value="HG">HG</option>
								</select>
								<select disabled id="sel_doll">
									<option>종류 먼저 선택</option>
								</select>
								<input disabled type="number" id="sel_level" style='width:50px' placeholder='레벨'/>
								<select disabled id="sel_favor">
									<option value="9">호감도 0~9</option>
									<option value="50">호감도 10~89</option>
									<option selected value="90">호감도 90~139</option>
									<option value="140">호감도 140~189</option>
									<option value="190">호감도 190~200</option>
								</select>
							</form>
							<br>
							<button id="delete">지우기</button>
							<button id="submitbtn">DPS계산</button>
							<button onclick="ScreenCapture()">스크린샷</button>
							<br>
						</div>
						<canvas id="myChart" width="400" height="400"></canvas>
						<span id="dps_div"></span>
					</div>
				</div>
			</div>
		</div>
		<div id="history" class="my-3 p-3 bg-white rounded box-shadow">
			<h3>히스토리</h3>
			1.2.1 v (5/28)<br>
			 - 사속 자가 버프(ex. 고속사격)가 적용되지 않던 버그 수정<br>
			 <br>
			1.2 v (5/28)<br>
			 - 스크린샷 기능 추가<br>
			 - 인형 링크(더미) 구현, 링크는 해당 레벨에서 가능한 최대치로 설정됨(71lv -> 4링)<br>
			 - 이제 그래프 하단 DPS도 그래프와 동일한 계산식 사용<br>
			<br>
			1.1.1 v (5/27)<br>
			 - G11 스킬 "호크아이" 구현<br>
			<br>
			1.1 v (5/26)<br>
			 - 표준 버프형 스킬 구현 (화력전개, 고속사격, 강행돌파, 기습공격, 신속처분, 집중사격, 저격지원, 민첩사격, 일제사격, 진압신호, 돌격개시, 사냥신호, 기습작전, 소멸지시)<br>
			 - 리베롤 스킬 "선혈의 파도" 구현<br>
			 - 그래프 단위 1초에서 0.5초로 변경<br>
			<br>
			1.0 v (5/24)<br>
			 - 첫 생성 <a href="http://gall.dcinside.com/mgallery/board/view/?id=micateam&no=183975"> 링크</a>
			 <br><br>
		</div>
    </main>
<?php
	require_once("footer.php");
?>
	<script src="dist/Chart.bundle.min.js"></script>
	<script src="dist/html2canvas.min.js"></script>
	<script>
		
		window.chartColors = {
			red: 'rgb(255, 99, 132)',
			orange: 'rgb(255, 159, 64)',
			yellow: 'rgb(255, 205, 86)',
			green: 'rgb(75, 192, 192)',
			blue: 'rgb(54, 162, 235)',
			purple: 'rgb(153, 102, 255)',
			grey: 'rgb(201, 203, 207)'
		};
		
		window.onload = function() {
			var ctx = document.getElementById('myChart').getContext('2d');
			window.myLine = new Chart(ctx, config);
		};
		
		var config = {
			type: 'line',
			data: {
				labels: [0,0.5,1,1.5,2,2.5,3,3.5,4,4.5,5,5.5,6,6.5,7,7.5,8,8.5,9,9.5,10,10.5,11,11.5,12,12.5,13,13.5,14,14.5,15],
			},
			options: {
				scales: {
					yAxes: [{
						ticks: {
							beginAtZero: true,
							min: 0
						}    
					}]
				}
			}
		};
		
		function updateChart(jsondata) {
			var data = JSON.parse(jsondata)
			console.log(data);
			
			config.data.datasets.splice(0, 5);
			window.myLine.update();
			
			for(var dollid in data.timeline_sec) {
				var doll = searchDoll(dollpos[dollid].id);
				var secdmg = $.map(data.timeline_sec[dollid], function(el) { return el });
				console.log(secdmg);
				
				var colorNames = Object.keys(window.chartColors);
				if(typeof config.data.datasets !== 'undefined')
					var colorName = colorNames[config.data.datasets.length % colorNames.length];
				else 
					var colorName = colorNames[0];
				var newColor = window.chartColors[colorName];
				var newDataset = {
					label: getDollName(doll) +" DMG",
					borderColor: newColor,
					//backgroundColor: color(newColor).alpha(0.5).rgbString(),
					data: secdmg,
					steppedLine: true
				};
				config.data.datasets.push(newDataset);
				
				window.myLine.update();
				
				$("#dps_div").append(getDollName(doll) + " : " + data.dps[dollid].toFixed(2) + " DPS<br>");
			}
		}
		

		
		
		
		
		
		
		
		var selected_item;
		
		var dollpos = {};
		
		$(".effitem").on('click', function(e) {
			curritem = Number($(this).attr('id').replace('grid', ''));
			
			$('#doll_inputs').find('input, select').removeAttr('disabled');
			
			//선택중
			if(selected_item) { 
				console.log("remove : " + selected_item);
				$("#grid" + selected_item).removeClass("selected");
			}
			
			//선택중에 + 자기자신클릭 아님
			if(selected_item !== curritem) {
				selected_item = curritem;
				console.log("click : " + selected_item);
				$("#grid" + selected_item).addClass("selected");
				
				//선택한것이 유효한값일경우 해당 정보로 form 변경
				if(typeof dollpos[selected_item] !== 'undefined' && typeof dollpos[selected_item].id !== 'undefined') {
					var doll = searchDoll(dollpos[selected_item].id);
					
					var name = getDollName(dolls[i]);
					
					$('#doll_inputs').find('input, select').removeAttr('disabled');
					
					$('#sel_type option').removeAttr('selected', 'selected');
					$('#sel_type').val(doll.type.toUpperCase()).change();
					
					$('#sel_doll option').removeAttr('selected', 'selected');
					$('#sel_doll').val(doll.id);
					
					$('#sel_level').val(dollpos[selected_item].level);
					
					$('#sel_favor option').removeAttr('selected', 'selected');
					$('#sel_favor').val(dollpos[selected_item].favor);
					
				}
				//비어있으면 타입과 인형선택만 활성화
				else {
					$('#sel_level, #sel_favor').attr('disabled','disabled');
				}
			} 
			//자기자신 클릭(선택해제)
			else {
				selected_item = null;
				/*
				if(typeof dollpos[selected_item][0] !== 'undefined')
					$('#doll_inputs').find('input, select').attr('disabled','disabled');
				else {
					
				}
				*/
				$('#doll_inputs').find('input, select').attr('disabled', 'disabled');
				
				
				$('#sel_type option').removeAttr('selected', 'selected');
				
				$('#sel_doll option').removeAttr('selected', 'selected');
				
				//기본값 레벨 100, 호감도 90
				$('#sel_level').val(100);
				$('#sel_favor').val(90);
			}
		});
		
		$("#sel_type").on('change', function(e) {
			var type = $(this).val();
			console.log("type sel : " + type);
			
			$("#sel_doll").empty().append($('<option>', {
				text: "종류 먼저 선택"
			}));
			
			for(var i in dolls) {
				if(dolls[i].type.toUpperCase() == type) {
					var name = getDollName(dolls[i]);
					$("#sel_doll").append($('<option>', {
						value: dolls[i].id,
						text: name
					}));
				}
			}
		});
		
		$("#sel_doll").on('change', function(e) {
			if(!selected_item) return;
			
			var dollid = Number($(this).val());
			console.log("select doll : " + dollid);
			
			if(typeof dollpos[selected_item] === 'undefined') {
				dollpos[selected_item] = {};
			}
			dollpos[selected_item].id = dollid;
			dollpos[selected_item].level = 100;
			dollpos[selected_item].favor = 50;
			
			$('#sel_level').val(100);
			$('#sel_favor option[value="50"]').attr('selected', 'selected');
			
			$('#doll_inputs').find('input, select').removeAttr('disabled');
			
			var iconnum;
			if(dollid < 10) {
				iconnum = "00" + dollid;
			} else if(dollid < 100) {
				iconnum = "0" + dollid;
			} else {
				iconnum = dollid;
			}
			
			var doll = searchDoll(dollid);
			$("#grid" + selected_item + " .content").empty().append($('<img>', {
				class: 'dollicon',
				src: 'img/dolls/icons/' + iconnum + '.png'
			}))
			.append(drawskilltile(doll.effect.effectPos, doll.effect.effectCenter));
			
			$("#grid" + selected_item + " .content").append($('<div>', {
				class: 'w-100',
				style: 'bottom: 0; position: absolute;'
			}));
			
			updateTable();
		});
		
		$("#sel_level, #sel_favor").on('change', function(e) {
			if($(this).attr('id') == 'sel_level') {
				dollpos[selected_item].level = Number($(this).val());
				console.log("insert level : " + dollpos[selected_item].level);
			}
			else {
				dollpos[selected_item].favor = Number($(this).val());
				console.log("insert favor : " + dollpos[selected_item].favor);
			}
		});

		var dolls;
		var grid = {};
		var guntype = ['ar', 'sg', 'rf', 'hg', 'mg', 'smg'];
		var efftype = ['rate', 'pow', 'dodge', 'hit', 'crit', 'cooldown', 'armor'];
		$.getJSON("data/doll.json", function(json) {
			dolls = json;
		});
		
		$("#delete").on('click', function() {
			dollpos[selected_item] = undefined;
			$("#grid" + selected_item + " .content").empty();
			updateTable();
		});
		
		$("#submitbtn").on('click', function() {
			var updata = {};
			updata.position = dollpos;
			updata.grid = grid;
			$("#dps_div").empty();
			
			var dollstats = [];
			for(var i = 1 ; i<= 9 ; i++) {
				if(typeof dollpos[i] !== 'undefined' && dollpos[i] !== null && typeof dollpos[i].id !== 'undefined' && dollpos[i].id !== null) {
					var doll = searchDoll(dollpos[i].id);
					dollstats[i] = calcstats(doll, dollpos[i].level, dollpos[i].favor);
				}
			}
			updata.stats = dollstats;
			
			$.ajax({
				url: "testcalc.php",
				method: "POST",
				data: updata,
				beforeSend: function( xhr ) {
					//xhr.overrideMimeType( "application/json; charset=utf-8" );
				}
			})
			.done(function( data ) {
				console.log(data);
				updateChart(data);
			});
		});
		/*
		$("input[name=dollinput]").on('input', function(e) {
			var doll = searchDoll($(this).val());
			$(this).next().text(doll.name);
			var dollPos = $(this).attr('id').replace('dollinput', '');
			var dollEffPos = doll.effect.effectPos.map(function(val) { return calcmove(val, doll.effect.effectCenter, dollPos)});
			console.log(dollEffPos);
			dollEffPos.map(function(val) {
				$("#dollinput" + val).next().text("1");
			});
		});*/
		
		/*	
		function uploadTile() {
			for(var i = 1 ; i <= 9 ; i++) {
				
			}
			calcstats
		}
		*/
		
		function drawskilltile(effectPos, effectCenter) {
			var tableinner = $.parseHTML('<tr><td class="skill7"></td><td class="skill8"></td><td class="skill9"></td></tr><tr><td class="skill4"></td><td class="skill5"></td><td class="skill6"></td></tr><tr><td class="skill1"></td><td class="skill2"></td><td class="skill3"></td></tr>');
			$(tableinner).find('.skill' + effectCenter).addClass('center');
			
			$.map(effectPos, function(val) { $(tableinner).find('.skill' + val).addClass('affected'); });
			return $('<table>', { class: 'skillview tile' }).append(tableinner);
		}
		
		function updateTable() {
			init();
			console.log(grid);
			for(var i = 1 ; i<= 9 ; i++) {
				if(typeof dollpos[i] === 'undefined') {
					continue;
				}
				
				var doll = searchDoll(dollpos[i].id);
				if(doll == false) {
					continue;
				}
				
				var dollPos = i;
				var effPos = $.map(doll.effect.effectPos, function(val) { return calcmove(val, doll.effect.effectCenter, dollPos)});
				
				addEffect(effPos, doll.effect.effectType, doll.effect.gridEffect);
			}
			
			
			for(var i = 1 ; i<= 9 ; i++) {
				if(typeof dollpos[i] === 'undefined') {
					continue;
				}
				
				var doll = searchDoll(dollpos[i].id);
				if(doll == false) {
					continue;
				}

				$("#grid" + i + " .content .w-100").empty();
	
				var effarray = [];
				
				if(typeof grid[i][doll.type].armor !== 'undefined') {
					effarray.push('<img class="efficon" src="img/tile/armor.png"> ' + grid[i][doll.type].armor + '%');
				}
				if(typeof grid[i][doll.type].cooldown !== 'undefined') {
					effarray.push('<img class="efficon" src="img/tile/cooldown.png"> ' + grid[i][doll.type].cooldown + '%');
				}
				if(typeof grid[i][doll.type].crit !== 'undefined') {
					effarray.push('<img class="efficon" src="img/tile/crit.png"> ' + grid[i][doll.type].crit + '%');
				}
				if(typeof grid[i][doll.type].dodge !== 'undefined') {
					effarray.push('<img class="efficon" src="img/tile/dodge.png"> ' + grid[i][doll.type].dodge + '%');
				}
				if(typeof grid[i][doll.type].hit !== 'undefined') {
					effarray.push('<img class="efficon" src="img/tile/hit.png"> ' + grid[i][doll.type].hit + '%');
				}
				if(typeof grid[i][doll.type].pow !== 'undefined') {
					effarray.push('<img class="efficon" src="img/tile/pow.png"> ' + grid[i][doll.type].pow + '%');
				}
				if(typeof grid[i][doll.type].rate !== 'undefined') {
					effarray.push('<img class="efficon" src="img/tile/rate.png"> ' + grid[i][doll.type].rate + '%');
				}
				
				console.log(effarray);
				for(var j = 0 ; j < effarray.length ; j++) {
					if(j == 0) {
						$("#grid" + i + " .content .w-100").append($('<div>', {
							class: "row m-0 p-0",
							style: 'height: 100%'
						}));
					}
					if(j == 2) {
						$("#grid" + i + " .content .w-100").prepend($('<div>', {
							class: "row m-0 p-0",
							style: 'height: 100%'
						}));
					}
					if(j == 4) {
						$("#grid" + i + " .content .w-100").prepend($('<div>', {
							class: "row m-0 p-0",
							style: 'height: 100%'
						}));
					}
					
					$("#grid" + i + " .content .w-100 .row:first-child").append($('<div>', {
							class: "col-6 m-0 p-0",
							style: "font-size: 1em"
						})
						.html(effarray[j])
					);
				}
			}
		}
		
		function init() {
			grid = {};
			for(var i = 1 ; i<=9 ; i++) {
					grid[i] = {};
				for(var j = 0 ; j <= guntype.length-1 ; j++) {
					 grid[i][guntype[j]] = {};
				}
			}
		}
		
		function applyEffect(pos) {
			
		}
		
		function getEffect(posnum) {
			var result = '';
			for(var i = 0 ; i <= guntype.length-1 ; i++) {
				for(var j = 0 ; j<= efftype.length-1 ; j++) {
					 if(typeof grid[posnum][guntype[i]][efftype[j]] !== 'undefined') {
						 result += efftype[j] + "(" + guntype[i] + ")" + " : " + grid[posnum][guntype[i]][efftype[j]] + "%";
					 }
				}
			}
			return result;
		}
		
		function addEffect(pos, type, eff) {
			pos.map(function(val) {
				if(type == "all") {
					for(var i = 0 ; i<= guntype.length-1 ; i++) {
						for(var j = 0 ; j<= efftype.length-1 ; j++) {
							if(typeof eff[efftype[j]] !== 'undefined') {
								if(typeof grid[val][guntype[i]][efftype[j]] !== 'undefined') {
									grid[val][guntype[i]][efftype[j]] += eff[efftype[j]]*2;
								} 
								else {
									grid[val][guntype[i]][efftype[j]] = eff[efftype[j]]*2;
								}
								
								if(efftype[j] == 'cooldown' && grid[val][guntype[i]][efftype[j]] > 30) {
									grid[val][guntype[i]][efftype[j]] = 30;
								}
							}
						}
					}
				}
				else {
					for(var j = 0 ; j<= efftype.length-1 ; j++) {
						if(typeof eff[efftype[j]] !== 'undefined') {
							if(typeof grid[val][type][efftype[j]] !== 'undefined') {
								console.log('before : ' + grid[val][type][efftype[j]]);
								console.log('add : ' + eff[efftype[j]]);
								grid[val][type][efftype[j]] += eff[efftype[j]];
								console.log('after : ' + grid[val][type][efftype[j]]);
							} 
							else {
								console.log('add : ' + eff[efftype[j]]);
								grid[val][type][efftype[j]] = eff[efftype[j]];
								console.log('after : ' + grid[val][type][efftype[j]]);
							}
							
							if(efftype[j] == 'cooldown' && grid[val][type][efftype[j]] > 30) {
								grid[val][type][efftype[j]] = 30;
							}
						}
					}
				}
			});
		}

		function calcmove(val, org, doll) {
			var effPos = getPos(val);
			var orgPos = getPos(org);
			var dollPos = getPos(doll);
			var diff = posMinus(dollPos, orgPos);
			
			return getNumFromPos(posPlus(effPos,diff));
		}
		
		function posDiff(a,b) {
			var c = {};
			c.x = a.x - b.x;
			c.y = a.y - b.y;
			return c;
		}
		
		function posPlus(a,b) {
			var c = {};
			c.x = a.x + b.x;
			c.y = a.y + b.y;
			return c;
		}
		
		function posMinus(a,b) {
			var c = {};
			c.x = a.x - b.x;
			c.y = a.y - b.y;
			return c;
		}
		
		function getPos(num) {
			var v = {};
			if(num <= 3) {
				v.x = num;
				v.y = 1;
			}
			else if(num > 3 && num < 7) {
				v.x = num-3;
				v.y = 2;
			}
			else if(num > 6) {
				v.x = num-6;
				v.y = 3;
			}
			else {
				v = null;
			}
			return v;
		}
		
		function getNumFromPos(v) {
			if(v.x > 3 || v.x <1 || v.y > 3 || v.y < 1) {
				return null;
			}
			else {
				if(v.y == 1) {
					return v.x;
				}
				else if (v.y == 2) {
					return v.x + 3;
				}
				else if (v.y == 3) {
					return v.x + 6;
				}
			}
			return null;
		}
		
		function searchDoll(num) {
			var result;
			$.each(dolls, function(i, v) {
				if (v.id == num) {
					result = v;
				}
			});
			if(!result) return false;
			return result;
		}

		
		
		
		
		
		
		var dollgrow = {"after100":{"basic":{"armor":[13.979,0.04],"hp":[96.283,0.138]},"grow":{"dodge":[0.075,22.572],"hit":[0.075,22.572],"pow":[0.06,18.018],"rate":[0.022,15.741]}},"normal":{"basic":{"armor":[2,0.161],"dodge":[5],"hit":[5],"hp":[55,0.555],"pow":[16],"rate":[45],"speed":[10]},"grow":{"dodge":[0.303,0],"hit":[0.303,0],"pow":[0.242,0],"rate":[0.181,0]}}};
		var dollattr = {"hg":{"hp":0.6,"pow":0.6,"rate":0.8,"speed":1.5,"hit":1.2,"dodge":1.8},"smg":{"hp":1.6,"pow":0.6,"rate":1.2,"speed":1.2,"hit":0.3,"dodge":1.6},"rf":{"hp":0.8,"pow":2.4,"rate":0.5,"speed":0.7,"hit":1.6,"dodge":0.8},"ar":{"hp":1,"pow":1,"rate":1,"speed":1,"hit":1,"dodge":1},"mg":{"hp":1.5,"pow":1.8,"rate":1.6,"speed":0.4,"hit":0.6,"dodge":0.6},"sg":{"hp":2.0,"pow":0.7,"rate":0.4,"speed":0.6,"hit":0.3,"dodge":0.3,"armor":1}};
		var attrlist = ['hp', 'pow', 'hit', 'dodge', 'speed', 'rate', 'armor'];
		
		
		function calcstats(doll, level, favor) {
			var dollstats = doll.stats;
			var dolltype = doll.type;
			var grow = doll.grow;
			
			var attribute = dollattr[dolltype];

			const basicStats = level > 100 ? {...dollgrow.normal.basic, ...dollgrow.after100.basic} : dollgrow.normal.basic;
			const growStats = level > 100 ? {...dollgrow.normal.grow, ...dollgrow.after100.grow} : dollgrow.normal.grow;
			
			var result = {};
			
			for(var i = 0 ; i <= attrlist.length-1 ; i++) {
				var key = attrlist[i];
				
				var basicData = basicStats[key];
				var growData = growStats[key];
				
				if(typeof dollstats[key] !== 'undefined') {
					if(typeof basicData !== 'undefined') {
						result[key] = basicData.length > 1 ? Math.ceil((((basicData[0] + ((level - 1) * basicData[1])) * attribute[key]) * dollstats[key]) / 100) : Math.ceil(((basicData[0] * attribute[key]) * dollstats[key]) / 100);

						result[key] += growData ? Math.ceil(((((growData[1] + ((level - 1) * growData[0])) * attribute[key] * dollstats[key]) * grow) / 100) / 100) : 0;

						result[key] += key === 'pow' || key === 'hit' || key === 'dodge' ? Math.sign(getFavorRatio(favor)) * Math.ceil(Math.abs(result[key] * getFavorRatio(favor))) : 0;
					} else {
						result[key] = '';
					}
				} else {
					result[key] = '';
				}
			}
			result['crit'] = dollstats.crit;
			
			return result;
		}
		
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
		
		function getDollName(doll) {
			if(typeof doll.krName !== 'undefined') {
				return doll.krName;
			} else {
				return doll.name;
			}
		}
		
		function ScreenCapture() {
			$("#watermark").text("소전DB 제대편성&DPS시뮬레이터 : gfl.zzzzz.kr/simulator.php");
			var x = document.getElementById("screenshot_hide");
			x.style.display = "none";
			
			try {
				html2canvas(document.querySelector("#scapture")).then(canvas => {
					alert("하단 히스토리 아래의 이미지를 저장해주세요.");
					var capimg = document.createElement("img");
					capimg.src = canvas.toDataURL();
					capimg.style.width = "100%";
					capimg.style.border = "1px solid grey";
					capimg.style.padding = "5px";
					document.getElementById("history").appendChild(capimg);
					$("#watermark").text("");
					x.style.display = "block";
				});
			}
			catch(e) {
				alert("에러발생! \n\n " + e);
				$("#watermark").text("");
				x.style.display = "block";
			}
		}
	</script>
	</body>
</html>