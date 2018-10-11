<?php
	if(!empty($_POST)) {
		$dolls = json_decode(getJson('doll'));
		echo json_encode($_POST);
		exit;
	}
	define("GF_HEADER", "aaaaa");
	require_once("common.php");
	$header_title = L::navigation_title_dpssim . " | " . L::sitetitle_short;
	$header_desc = L::title_sim_desc;
	$header_keyword = L::title_sim_keyword;
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
            pointer-events: none;
			
			-webkit-touch-callout: none; /* iOS Safari */
			-webkit-user-select: none; /* Safari */
			-khtml-user-select: none; /* Konqueror HTML */
			-moz-user-select: none; /* Firefox */
			-ms-user-select: none; /* Internet Explorer/Edge */
			user-select: none; 
		}
		
		.dollicon {
			width:70%;
			height: 70%;
			display: block;
			background-size: 270%;
			background-position: 13% 5%;
			border-radius: 2px;
		}
		
		.efficon {
			height: 1em;
            margin-bottom: 0.1em;
		}
	</style>
    <main role="main" class="container-fluid">
		<div class="my-3 p-3 bg-white rounded box-shadow">
			<h2 class="pb-3 border-bottom border-gray"><?=L::sim_title?></h2>
			<!--<?=L::sim_desc?>-->
			<div id="scapture">
			<span id="watermark"></span>
				<div class="row">
					<div class="col-sm-4">
                        <div class="dollgrid">
                            <div class="effrow">
                                <div class="effitem" id="grid3">
                                    <div class="content"></div>
                                </div>
                                <div class="effitem" id="grid6">
                                    <div class="content"></div>
                                </div>
                                <div class="effitem" id="grid9">
                                    <div class="content"></div>
                                </div>
                            </div>
                            <div class="effrow">
                                <div class="effitem" id="grid2">
                                    <div class="content"></div>
                                </div>
                                <div class="effitem" id="grid5">
                                    <div class="content"></div>
                                </div>
                                <div class="effitem" id="grid8">
                                    <div class="content"></div>
                                </div>
                            </div>
                            <div class="effrow">
                                <div class="effitem" id="grid1">
                                    <div class="content"></div>
                                </div>
                                <div class="effitem" id="grid4">
                                    <div class="content"></div>
                                </div>
                                <div class="effitem" id="grid7">
                                    <div class="content"></div>
                                </div>
                            </div>
                        </div>
                        <div id="screenshot_hide">
							<form id="doll_inputs">
								<select disabled id="sel_type">
									<option><?=L::sim_seltype?></option>
									<option value="AR">AR</option>
									<option value="RF">RF</option>
									<option value="SMG">SMG</option>
									<option value="MG">MG</option>
									<option value="SG">SG</option>
									<option value="HG">HG</option>
								</select>
								<select disabled id="sel_doll">
									<option><?=L::sim_seltypefirst?></option>
								</select>
								<input disabled type="number" min='1' max='120' id="sel_level" style='width:50px' placeholder='<?=L::level?>'/>
                                <br>
								<select disabled id="sel_favor">
									<option value="9"><?=L::sim_favor?> 0~9</option>
									<option value="50"><?=L::sim_favor?> 10~89</option>
									<option selected value="90"><?=L::sim_favor?> 90~139</option>
									<option value="140"><?=L::sim_favor?> 140~189</option>
									<option value="190"><?=L::sim_favor?> 190~200</option>
								</select>
                                <select disabled id="sel_skilllevel">
                                    <option>SkillLv</option>
                                    <option value='1'>1</option>
                                    <option value='2'>2</option>
                                    <option value='3'>3</option>
                                    <option value='4'>4</option>
                                    <option value='5'>5</option>
                                    <option value='6'>6</option>
                                    <option value='7'>7</option>
                                    <option value='8'>8</option>
                                    <option value='9'>9</option>
                                    <option value='10'>10</option>
                                </select>
                                <select disabled id="sel_skill2level">
                                    <option>mod2Lv</option>
                                    <option value='1'>1</option>
                                    <option value='2'>2</option>
                                    <option value='3'>3</option>
                                    <option value='4'>4</option>
                                    <option value='5'>5</option>
                                    <option value='6'>6</option>
                                    <option value='7'>7</option>
                                    <option value='8'>8</option>
                                    <option value='9'>9</option>
                                    <option value='10'>10</option>
                                </select>
                                <button type="button" onclick="equipmodal()">장비선택</button>
							</form>
							<br>
							<button id="delete"><?=L::sim_delete?></button>
							<button style="display:none" id="submitbtn"><?=L::sim_calcdps?></button>
							<button onclick="ScreenCapture()"><?=L::sim_screenshot?></button>
							<button onclick="export_grid()"><?=L::sim_share?></button>
							<br>
						</div>
					</div>
                    
                    <div class="col-8">
                    <div style="width:100%"></div>
                        <select id="sel_fairy">
							<option value='0'>요정없음</option>
						</select>
						<select id="fairyrank">
							<option value='1'>1성</option>
							<option value='2'>2성</option>
							<option value='3'>3성</option>
							<option value='4'>4성</option>
							<option value='5' selected>5성</option>
						</select>
						<input id="fairylevel" type='number' min='1' max='100' value='100' placeholder='요정레벨'>
						<br>
                        <?=L::sim_actpoint?> : <span class="txthighlight" id="actionEff"></span>
                        <canvas id="myChart" width="400" height="100"></canvas>
						<span id="dps_div"></span>
                    </div>
                </div>
                <div class="modal fade" id="equipmodal" tabindex="-1" role="dialog">
                    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-body">
                                <div class="container-fluid">
                                    <div class="row">
                                        <div class="col-lg-4">
                                            <select id="equip_1">
                                                <option>선택</option>
                                            </select>
                                        </div>
                                        <div class="col-lg-4">
                                            <select id="equip_2">
                                                <option>선택</option>
                                            </select>
                                        </div>
                                        <div class="col-lg-4">
                                            <select id="equip_3">
                                                <option>선택</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
			</div>
		</div>
        <div class="my-3 p-3 bg-white rounded box-shadow">
            <ins class="adsbygoogle"
			 style="display:block; text-align:center"
			 data-ad-client="ca-pub-6637664198779025"
			 data-ad-slot="3111645353"
			 data-ad-format="auto"
			 data-full-width-responsive="true"></ins>
        </div>
		<div id="history" class="my-3 p-3 bg-white rounded box-shadow">
			<h3><?=L::sim_history?></h3>
            2.2.2 v (18/10/2) <br>
             - 슬러그탄 화력 곱연산 적용<br>
             <br>
            2.2.1 v (18/10/2) <br>
             - 탄약통 추가 탄약 적용안되던 점 수정<br>
             - 현재 슬러그탄의 화력 곱연산 적용안됨<br>
             <br>
            2.2 v (18/10/1) <br>
             - 요정추가<br>
             - 장비추가<br>
            <br>
            2.1 v (18/9/27) <br>
             - 가져오기 내보내기 기능 추가,<br>
             - 모바일 가로화면시 가로 레이아웃이 나오도록 수정<br>
             - 버프 아이콘 크기 조절<br>
             - 인형을 랭크별로 나눔<br>
            <br>
            2.0 v (18/9/27) <br>
             <font color="#FF0000">- 현재 스킬 계산 안됨</font><br>
             - DPS 계산식 오류 수정<br>
             - 이제 드래그로 인형의 위치 변경 가능<br>
             - 작전능력을 계산하여 표시<br>
            <br>
			1.3.1 v (18/7/31)<br>
			 - 스킬 쿨타임 감소 버프진형과 관련해 문제가 있어 수정<br>
			<br>
			1.3 v (18/6/8)<br>
			 - 표준 저격 스킬 구현 (저격개시, 정밀저격, 목표제거, 확인사살)<br>
			 - IWS2000 전용스킬(육참골단) 구현<br>
			 - Kar98k 전용스킬(이중저격) 구현<br>
			 - 다만 현재 저격스킬은 저격시간동안에도 평타를 때리는걸로 계산되고있음<br>
			<br>
			1.2.3 v (18/6/8)<br>
			 - DPS계산 버튼 삭제, 인형 배치하면 자동으로 수정되도록 변경함<br>
			<br>
			1.2.2 v (18/5/28)<br>
			 - MG 사속 계산이 잘못된 점 수정<br>
			<br>
			1.2.1 v (18/5/28)<br>
			 - 사속 자가 버프(ex. 고속사격)가 적용되지 않던 버그 수정<br>
			 <br>
			1.2 v (18/5/28)<br>
			 - 스크린샷 기능 추가<br>
			 - 인형 링크(더미) 구현, 링크는 해당 레벨에서 가능한 최대치로 설정됨(71lv -> 4링)<br>
			 - 이제 그래프 하단 DPS도 그래프와 동일한 계산식 사용<br>
			<br>
			1.1.1 v (18/5/27)<br>
			 - G11 스킬 "호크아이" 구현<br>
			<br>
			1.1 v (18/5/26)<br>
			 - 표준 버프형 스킬 구현 (화력전개, 고속사격, 강행돌파, 기습공격, 신속처분, 집중사격, 저격지원, 민첩사격, 일제사격, 진압신호, 돌격개시, 사냥신호, 기습작전, 소멸지시)<br>
			 - 리베롤 스킬 "선혈의 파도" 구현<br>
			 - 그래프 단위 1초에서 0.5초로 변경<br>
			<br>
			1.0 v (18/5/24)<br>
			 - 첫 생성 <a href="http://gall.dcinside.com/mgallery/board/view/?id=micateam&no=183975"> 링크</a>
			 <br><br>
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
	<script src="dist/Chart.bundle.min.js"></script>
	<script src="dist/html2canvas.min.js"></script>
	<script>
		var lang = '<?=$lang?>';
		var loaded = 0;
        
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
            document.getElementById('myChart').height = $(".effrow").height() * 3;
            if($(".row").width() > 576)
                document.getElementById('myChart').width = $(document.getElementById('myChart')).parent().width();
            else
                document.getElementById('myChart').width = $(".dollgrid").width();
            
			window.myLine = new Chart(ctx, config);
            
            var loadtimer = setInterval(function(){
                if(loaded === 3) {
                    clearInterval(loadtimer);
                    var url_string = window.location.href
                    var url = new URL(url_string);
                    if(url.searchParams.get("q") !== null)
                        import_grid();
                }
            }, 500);
            
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
				},
                responsive: false
			}
		};
		
		function updateChart(jsondata) {
			var data = JSON.parse(jsondata)
			console.log(data);
			
			config.data.datasets.splice(0, 5);
			window.myLine.update();
			$("#dps_div").empty();
            
			for(var dollid in data.timeline_sec) {
				var doll = searchDoll(dollpos[dollid].id);
				var secdmg = $.map(data.timeline_sec[dollid], function(el) { return el });
				
				var colorNames = Object.keys(window.chartColors);
				if(typeof config.data.datasets !== 'undefined')
					var colorName = colorNames[config.data.datasets.length % colorNames.length];
				else 
					var colorName = colorNames[0];
				var newColor = window.chartColors[colorName];
				var newDataset = {
					label: getDollName(doll),
					borderColor: newColor,
					//backgroundColor: color(newColor).alpha(0.5).rgbString(),
					data: secdmg,
					steppedLine: true
				};
				config.data.datasets.push(newDataset);
				
				window.myLine.update();
				
				$("#dps_div").append(getDollName(doll) + " : " + data.dps[dollid].toFixed(2) + " DPS<br>");
                $("#actionEff").text(data.actionPoint + '(' + data.actionPoint_n + ')');
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
					
					var name = getDollName(dollpos[selected_item].id);
					
					$('#doll_inputs').find('input, select').removeAttr('disabled');
					
					$('#sel_type option').removeAttr('selected', 'selected');
					$('#sel_type').val(doll.type.toUpperCase()).trigger('change');
					
					$('#sel_doll option').removeAttr('selected', 'selected');
					$('#sel_doll').val(doll.id);
					
					$('#sel_level').val(dollpos[selected_item].level);
					
					$('#sel_favor option').removeAttr('selected', 'selected');
					$('#sel_favor').val(dollpos[selected_item].favor);
                    
                    $('#sel_skilllevel').val(dollpos[selected_item].skilllevel);
                    $('#sel_skill2level').val(dollpos[selected_item].skill2level);
                    
                    if(dollpos[selected_item].id < 20000)
                        $('#sel_skill2level').attr('disabled', 'disabled');
					
				}
				//비어있으면 타입과 인형선택만 활성화
				else {
					$('#sel_level, #sel_favor, #sel_skilllevel, #sel_skill2level').attr('disabled','disabled');
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
				text: "<?=L::sim_seltypefirst?>"
			}));
			
            for(var rank = 2 ; rank <= 5 ; rank++) {
                $("#sel_doll").append($('<option>', {
                    text: "====" + rank + "<?=L::database_star?>===="
                }));
                        
                for(var i in dolls) {
                    if(dolls[i].type.toUpperCase() == type && dolls[i].rank === rank) {
                        var name = getDollName(dolls[i]);
                        
                        $("#sel_doll").append($('<option>', {
                            value: dolls[i].id,
                            text: name
                        }));
                    }
                }
			}
		});
		
		$("#sel_doll").on('change', function(e) {
			if(!selected_item) return;
			
			var dollid = Number($(this).val());
			console.log("select doll : " + dollid);
			
			if(typeof dollpos[selected_item] === 'undefined') {
				dollpos[selected_item] = {};
                dollpos[selected_item].equip = {};
			}
			dollpos[selected_item].id = dollid;
			dollpos[selected_item].level = 100;
			dollpos[selected_item].favor = 90;
			dollpos[selected_item].skilllevel = 10;
			dollpos[selected_item].skill2level = 10;
			
			$('#sel_level').val(100);
			$('#sel_favor option[value="90"]').attr('selected', 'selected');
			$('#sel_skilllevel').val(10);
			$('#sel_skill2level').val(10);
            
			$('#doll_inputs').find('input, select').removeAttr('disabled');
			
            if(dollid < 20000)
                $('#sel_skill2level').attr('disabled', 'disabled');
			
			var doll = searchDoll(dollid);
            dollpos[selected_item].type = doll.type;
            dollpos[selected_item].rank = doll.rank;
			$("#grid" + selected_item + " .content").empty().append($('<i>', {
				class: 'dollicon',
				style: 'background-image: url("img/characters/' + doll.name + '/pic/pic_' + doll.name + '_n.jpg"); border: ' + rankbordercolor(doll.rank) +  ' 3px solid;'
			}))
			.append(drawefftile(doll.effect.effectPos, doll.effect.effectCenter));
			
			$("#grid" + selected_item + " .content").append($('<div>', {
				class: 'w-100',
				style: 'bottom: 0; position: absolute; pointer-events: none;'
			}));
			
			updateTable();
			
			if(autobuild === false)
                $("#submitbtn").trigger('click');
		});
		
		
		$("#sel_level, #sel_favor, #sel_skilllevel, #sel_skill2level, #sel_fairy, #fairyrank, #fairylevel, #equip_1, #equip_2, #equip_3").on('change', function(e) {
			if($(this).attr('id') == 'sel_level') {
				dollpos[selected_item].level = Number($(this).val());
				console.log("insert level : " + dollpos[selected_item].level);
			}
			else if($(this).attr('id') == 'sel_favor'){
				dollpos[selected_item].favor = Number($(this).val());
				console.log("insert favor : " + dollpos[selected_item].favor);
			}
			else if($(this).attr('id') == 'sel_skilllevel'){
				dollpos[selected_item].skilllevel = Number($(this).val());
				console.log("insert skilllevel : " + dollpos[selected_item].skilllevel);
			}
			else if($(this).attr('id') == 'sel_skill2level'){
				dollpos[selected_item].skill2level = Number($(this).val());
				console.log("insert skill2level : " + dollpos[selected_item].skill2level);
			}
            else if($(this).attr('id') == 'equip_1'){
				dollpos[selected_item].equip[0] = Number($(this).val());
				console.log("insert equip1 : " + dollpos[selected_item].equip[0]);
			}
            else if($(this).attr('id') == 'equip_2'){
				dollpos[selected_item].equip[1] = Number($(this).val());
				console.log("insert equip2 : " + dollpos[selected_item].equip[1]);
			}
            else if($(this).attr('id') == 'equip_3'){
				dollpos[selected_item].equip[2] = Number($(this).val());
				console.log("insert equip3 : " + dollpos[selected_item].equip[2]);
			}
            if(autobuild === false)
                $("#submitbtn").trigger('click');
		});

		var dolls;
		var fairies;
        var equips;
		var grid = {};
		var guntype = ['ar', 'sg', 'rf', 'hg', 'mg', 'smg'];
		var efftype = ['rate', 'pow', 'dodge', 'hit', 'crit', 'cooldown', 'armor'];
		$.getJSON("data/json/doll.json", function(json) {
			dolls = json;
            loaded++;
		});
		$.getJSON("data/json/fairy.json", function(json) {
			fairies = json;
			fairies.forEach(function(val) {
				$("#sel_fairy").append($('<option>', {
					value: val.id,
					text: val.krName
				}));
			});
            loaded++;
		});
		$.getJSON("data/json/equip.json", function(json) {
			equips = json;
			for(var i in equips) {
				$("#equip_1").append($('<option>', {
					value: equips[i].id,
					text: equips[i].krName
				}));
				$("#equip_2").append($('<option>', {
					value: equips[i].id,
					text: equips[i].krName
				}));
				$("#equip_3").append($('<option>', {
					value: equips[i].id,
					text: equips[i].krName
				}));
			}
            loaded++;
		});
		
		$("#delete").on('click', function() {
			dollpos[selected_item] = undefined;
			$("#grid" + selected_item + " .content").empty();
			updateTable();
			$("#submitbtn").trigger('click');
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
                    dollstats[i] = calcequipstat(i, dollstats[i]);
				}
			}
			updata.stats = dollstats;
            updata.fairy = calcfairystat();
			
            console.log(updata);
			
			$.ajax({
				url: "simulator_calc.php",
				method: "POST",
				data: updata,
				beforeSend: function( xhr ) {
					//xhr.overrideMimeType( "application/json; charset=utf-8" );
				}
			})
			.done(function( data ) {
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
		
		function drawefftile(effectPos, effectCenter) {
			var tableinner = $.parseHTML('<tr><td class="skill3"></td><td class="skill6"></td><td class="skill9"></td></tr><tr><td class="skill2"></td><td class="skill5"></td><td class="skill8"></td></tr><tr><td class="skill1"></td><td class="skill4"></td><td class="skill7"></td></tr>');
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
					effarray.push('<img class="efficon" src="img/tile/armor.png">' + grid[i][doll.type].armor + '%');
				}
				if(typeof grid[i][doll.type].cooldown !== 'undefined') {
					effarray.push('<img class="efficon" src="img/tile/cooldown.png">' + grid[i][doll.type].cooldown + '%');
				}
				if(typeof grid[i][doll.type].crit !== 'undefined') {
					effarray.push('<img class="efficon" src="img/tile/crit.png">' + grid[i][doll.type].crit + '%');
				}
				if(typeof grid[i][doll.type].dodge !== 'undefined') {
					effarray.push('<img class="efficon" src="img/tile/dodge.png">' + grid[i][doll.type].dodge + '%');
				}
				if(typeof grid[i][doll.type].hit !== 'undefined') {
					effarray.push('<img class="efficon" src="img/tile/hit.png">' + grid[i][doll.type].hit + '%');
				}
				if(typeof grid[i][doll.type].pow !== 'undefined') {
					effarray.push('<img class="efficon" src="img/tile/pow.png">' + grid[i][doll.type].pow + '%');
				}
				if(typeof grid[i][doll.type].rate !== 'undefined') {
					effarray.push('<img class="efficon" src="img/tile/rate.png">' + grid[i][doll.type].rate + '%');
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
				v.y = num;
				v.x = 1;
			}
			else if(num > 3 && num < 7) {
				v.y = num-3;
				v.x = 2;
			}
			else if(num > 6) {
				v.y = num-6;
				v.x = 3;
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
				if(v.x == 1) {
					return v.y;
				}
				else if (v.x == 2) {
					return v.y + 3;
				}
				else if (v.x == 3) {
					return v.y + 6;
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
		
		function searchFairy(num) {
			var result;
			$.each(fairies, function(i, v) {
				if (v.id == num) {
					result = v;
				}
			});
			if(!result) return false;
			return result;
		}
		
		function searchEquip(num) {
			var result;
			$.each(equips, function(i, v) {
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
						result[key] = 0;
					}
				} else {
					result[key] = 0;
				}
			}
			result['crit'] = dollstats.crit;
			result['armorPiercing'] = dollstats.armorPiercing;
			result['bullet'] = dollstats.bullet;
			return result;
		}
		
		function calcfairystat() {
			var fid = $("#sel_fairy").val();
			var level = $("#fairylevel").val();
			var quality = $("#fairyrank").val();
			
            var result = {};
            if(typeof fid === 'undefined' || fid == 0) {
                return result;
            }
            
			var fairy = searchFairy(fid);
			var fairystats = fairy.stats;
			var grow = {"armor": [5, 0.05],"critDmg": [10, 0.101],"dodge": [20, 0.202],"hit": [25, 0.252],"pow": [7, 0.076],"proportion": [0.4, 0.5, 0.6, 0.8, 1.0]};
			var fairygrow = fairy.grow;
			
			
			if(typeof level !== 'undefined' && typeof quality !== 'undefined') {
				if(typeof fairystats.pow !== 'undefined') {
					result.pow = ((Math.ceil((grow.pow[0] * (fairystats.pow / 100)) + Math.ceil(((level - 1) * grow.pow[1]) * (fairystats.pow / 100) * (fairygrow / 100))) * grow.proportion[quality - 1]).toFixed(1) / 100) + 1;
				} else result.pow = 1;
				if(typeof fairystats.hit !== 'undefined') {
					result.hit = ((Math.ceil((grow.hit[0] * (fairystats.hit / 100)) + Math.ceil(((level - 1) * grow.hit[1]) * (fairystats.hit / 100) * (fairygrow / 100))) * grow.proportion[quality - 1]).toFixed(1) / 100) + 1;
				} else result.hit = 1;
				if(typeof fairystats.dodge !== 'undefined') {
					result.dodge = ((Math.ceil((grow.dodge[0] * (fairystats.dodge / 100)) + Math.ceil(((level - 1) * grow.dodge[1]) * (fairystats.dodge / 100) * (fairygrow / 100))) * grow.proportion[quality - 1]).toFixed(1) / 100) + 1;
				} else result.dodge = 1;
				if(typeof fairystats.critDmg !== 'undefined') {
					result.critDmg = ((Math.ceil((grow.critDmg[0] * (fairystats.critDmg / 100)) + Math.ceil(((level - 1) * grow.critDmg[1]) * (fairystats.critDmg / 100) * (fairygrow / 100))) * grow.proportion[quality - 1]).toFixed(1) / 100) + 1;
				} else result.critDmg = 0;
				if(typeof fairystats.armor !== 'undefined') {
					result.armor = ((Math.ceil((grow.armor[0] * (fairystats.armor / 100)) + Math.ceil(((level - 1) * grow.armor[1]) * (fairystats.armor / 100) * (fairygrow / 100))) * grow.proportion[quality - 1]).toFixed(1) / 100) + 1;
				} else result.armor = 1;
			}
			return result;
		}
        
        function calcequipstat(num, stats) {
            if(typeof dollpos[num].equip === 'undefined')
                dollpos[num].equip = {};
            
            var result = stats;
            
            for(var i = 0 ; i <= 2 ; i++) {
                if(typeof dollpos[num].equip[i] !== 'undefined') {
                    var eq = searchEquip(dollpos[num].equip[i]);
                    for(var key in eq.stats) {
                        value = eq.stats[key].max;
                        if(typeof eq.stats[key].amp !== 'undefined')
                            value = Math.floor(value * eq.stats[key].amp);
                        
                        switch(key) {
                            case "critical_percent": key = 'crit'; break;
                            case "armor_piercing": key = 'armorPiercing'; break;
                            case "critical_harm_rate": key = 'critDmg'; break;
                            case "bullet_number_up": key = 'bullet'; break;
                        }
                        
                        if(typeof stats[key] === 'undefined')
                            stats[key] = 0;
                        
                        stats[key] += value;
                    }
                    
                    //슬러그탄
                    if(eq.id == 77 || eq.id == 78 || eq.id == 79 || eq.id == 80)
                        stats.pow = stats.pow*3;
                }
            }
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
			if(lang == 'en') {
				return doll.name;
			}
			else {
				if(typeof doll.krName !== 'undefined') {
					return doll.krName;
				} else {
					return doll.name;
				}
			}
		}
		
		function ScreenCapture() {
			$("#watermark").text("<?=L::sim_title?> : gfl.zzzzz.kr/simulator.php");
			var x = document.getElementById("screenshot_hide");
			x.style.display = "none";
			
			try {
				html2canvas(document.querySelector("#scapture")).then(canvas => {
                    
                    var image = canvas.toDataURL();
                    //var image = canvas.toDataURL("image/png").replace("image/png", "image/octet-stream");
                    //window.location.href = image;

                   downloadURI(image, "screenshot.png");
                    
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
        
        function downloadURI(uri, name) {
            var link = document.createElement("a");
            link.download = name;
            link.href = uri;
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
            delete link;
        }
        
        function rankbordercolor(rank) {
            switch(rank) {
                case 2: return "#bcbcbc";
                case 3: return "#5dd9c3";
                case 4: return "#d6e35a";
                case 5: return "#fda809";
            }
        }
        
        function equipmodal() {
            if(typeof dollpos[selected_item].equip === 'undefined')
                dollpos[selected_item].equip = {};
            
            $("#equip_1").val($("#equip_1 option:first").val());
            $("#equip_2").val($("#equip_2 option:first").val());
            $("#equip_3").val($("#equip_3 option:first").val());
            
            if(typeof dollpos[selected_item].equip[0] !== 'undefined')
                $("#equip_1").val(dollpos[selected_item].equip[0]);
            if(typeof dollpos[selected_item].equip[1] !== 'undefined')
                $("#equip_2").val(dollpos[selected_item].equip[1]);
            if(typeof dollpos[selected_item].equip[2] !== 'undefined')
                $("#equip_3").val(dollpos[selected_item].equip[2]);
            
            $('#equipmodal').modal('show');
        }
	</script>
    
    <script>
    var swaporg = null;
    var swapnum = null;
    var dragstatus = null;
    var dragelem;
	var gridnum;
	var touchlast;
    var autobuild = false;
	
    $(".effitem").on('mousedown touchstart', function(e) {
        dragelem = $(this).children();
        dragstatus = Number($(this).attr('id').replace('grid', ''));
        console.log(dragstatus);
        console.log('drag start');
    });
    
    /*
    $(".dollgrid").on('mouseover touchover', function(e) { 
        if(dragstatus) {
            
        }
    });
    */
    
    $(".effitem").on('touchmove', function(e) {
        if(dragstatus) {
			touchlast = e.touches[0];
			var elem = document.elementFromPoint(e.touches[0].clientX, e.touches[0].clientY);			
			var tmpnum = Number($(elem).attr('id').replace('grid', ''));
            if(!isNaN(tmpnum)) {
                if(dragstatus != tmpnum) {
                    if(swapnum != tmpnum) {
                        $(swaporg).css('background-color', '');
                        swaporg = elem;
                        swapnum = tmpnum;
                    }
                    gridnum = swapnum;
                    console.log(gridnum);
                    $(elem).css('background-color', '#FF0000');
                }
            }
			e.preventDefault();
        }
    });
    
    $(".effitem").on('mouseenter touchenter', function(e) {
        gridnum = Number($(this).attr('id').replace('grid', ''));
        if(dragstatus && dragstatus != gridnum) {
            console.log('drag enter');
            $(this).css('background-color', '#FF0000');
        }
    });
    $(".effitem").on('mouseleave', function(e) {
        gridnum = Number($(this).attr('id').replace('grid', ''));
        if(dragstatus) {
            console.log('drag out');
            $(this).css('background-color', '');
        }
    });
    
    $(".effitem").on('touchend', function(e) { 
		var t = touchlast;
		if(t != null) {
			var elem = document.elementFromPoint(t.clientX, t.clientY);
			gridnum = Number($(elem).attr('id').replace('grid', ''));		
            if(!isNaN(gridnum)) {
                if(dragstatus && dragstatus != gridnum) {
                    var tmpgrid = $(elem).children();
                    $(elem).html(dragelem);
                    $("#grid" + dragstatus).html(tmpgrid);
                    
                    
                    var tmp = dollpos[gridnum];
                    dollpos[gridnum] = dollpos[dragstatus];
                    dollpos[dragstatus] = tmp;
                    
                    updateTable();
                    $("#submitbtn").trigger('click');
                }
                $(elem).css('background-color', '');
                clear();
            }
		}
	});
	
    $(".effitem").on('mouseup', function(e) { 
        gridnum = Number($(this).attr('id').replace('grid', ''));
        if(dragstatus && dragstatus != gridnum) {
            console.log('drag end');

            var tmpgrid = $(this).children();
            $(this).html(dragelem);
            $("#grid" + dragstatus).html(tmpgrid);
			
			var tmp = dollpos[gridnum];
            dollpos[gridnum] = dollpos[dragstatus];
            dollpos[dragstatus] = tmp;
            
            updateTable();
            $("#submitbtn").trigger('click');
        }
        $(this).css('background-color', '');

        clear();
    });
    
    /*
    $(".dollgrid").mouseleave(function(e) { 
        swaporg = null;
        swapnum = null;
        dragstatus = null; 
        drapelem = null;
    });
    */
    /*
    $(window).on('touchmove', function(e) {
        if (dragstatus) {
            e.preventDefault();
        }
    });*/
	
	function clear() {
		swaporg = null;
		swapnum = null;
		dragstatus = null;
		dragelem = null;
		gridnum = null;
		touchlast = null;
	}
    
    function export_grid() {
        var resultstr = '';
        for(var i = 1 ; i <= 9 ; i++) {
            if(typeof dollpos[i] !== 'undefined') {
                var eq = [0,0,0];
                for(var j=0 ; j<=2 ; j++) {
                    if(typeof dollpos[i].equip[j] !== 'undefined')
                        eq[j] = dollpos[i].equip[j];
                }

                var str = i + ":" + dollpos[i].id + ":" + dollpos[i].level + ":" + dollpos[i].favor + ":" + dollpos[i].skilllevel + ":" + dollpos[i].skill2level + ":" + eq[0] + ":" + eq[1] + ":" + eq[2] + "|";
                resultstr += str;
            }
        }
        
        resultstr = resultstr.slice(0, -1);

        fairy_str = '';
        var fid = $("#sel_fairy").val();
        if(typeof fid !== 'undefined' && fid != 0) {
            var f_level = $("#fairylevel").val();
            var f_rank = $("#fairyrank").val();
            
            var str = fid + ":" + f_level + ":" + f_rank;
            fairy_str = "&f=" + encodeURI(str);
        }
        
        var url_string = window.location.href
        var url = new URL(url_string);
        var query = url.searchParams.get("lang");
        prompt("URL을 복사하세요", window.location.origin + window.location.pathname + "?lang=" + query + "&q=" + encodeURI(resultstr) + fairy_str);
    }
    
    function import_grid() {
        var url_string = window.location.href
        var url = new URL(url_string);
        var query = url.searchParams.get("q");
        console.log(query);

        var str = decodeURI(query);
        str = str.split("|");
        str.forEach(function(data) {
            data = data.split(":");
            console.log(data);
            if(data.length <= 12) {
                var l_num = data[0];
                var l_id = data[1];
                var l_level = data[2];
                var l_favor = data[3];
                var l_skilllevel = data[4];
                var l_skill2level = data[5];
                if(data.length > 6) {
                    var l_equip1 = data[6];
                    var l_equip2 = data[7];
                    var l_equip3 = data[8];
                }
                autobuild = true;
                $("#grid" + l_num).click();
                $("#sel_doll").append($('<option>', {value: l_id}));
                $("#sel_doll").val(l_id).trigger('change');
                $("#sel_level").val(l_level).trigger('change');
                $("#sel_favor").val(l_favor).trigger('change');
                $("#sel_skilllevel").val(l_skilllevel).trigger('change');
                if(Number(l_id) > 20000)
                    $("#sel_skill2level").val(l_skill2level).trigger('change');
                
                if(data.length > 6) {
                    if(l_equip1 != 0)
                        $("#equip_1").val(l_equip1).trigger('change');
                    if(l_equip2 != 0)
                        $("#equip_2").val(l_equip2).trigger('change');
                    if(l_equip3 != 0)
                        $("#equip_3").val(l_equip3).trigger('change');
                }
                $("#grid" + l_num).click();
                autobuild = false;
            }
        });
        
        var query = url.searchParams.get("f");
        if(query !== null) {
            data = query.split(":");
            var f_id = data[0];
            var f_level = data[1];
            var f_rank = data[2];
            
            autobuild = true;
            $("#sel_fairy").val(f_id).trigger('change');
            $("#fairyrank").val(f_rank).trigger('change');
            $("#fairylevel").val(f_level).trigger('change');
            autobuild = false;
        }
        
        $("#submitbtn").trigger('click');
    }
    /*
    window.onerror = function(msg, url, linenumber) {
        alert('Error message: '+msg+'\nURL: '+url+'\nLine Number: '+linenumber);
    }*/
    </script>
	</body>
</html>