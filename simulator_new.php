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
							<!--<button onclick="export_grid()"><?=L::sim_share?></button>-->
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
            
            var url_string = window.location.href
            var url = new URL(url_string);
            if(url.searchParams.get("q") !== null)
                import_grid();
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
	</script>
    
    <script>
    function Grid() {};
    
    Grid.prototype = {
        selected: null,
        grideff: {},
        position: {},
        fairy{},
        autobuild: false,
        selectPos: function(num) {
            num = Number(num);
            if(typeof position[num] === 'undefined') {
                dollpos[selected_item] = {};
                dollpos[selected_item].equip = {};
            }
        }
    }
    
    function Doll() {};
    
    Doll.prototype = {
        id: null,
        level: 100,
        favor: 90,
        rank: 5,
        skilllevel: 10,
        skill2level: 10,
        type: null,
        equip: {
            0: null,
            1: null,
            2: null
        }
        stats: {
            armor: null,
            armorPiercing: null,
            bullet: null,
            crit: null,
            dodge: null,
            hit: null,
            hp: null,
            pow: null,
            rate: null,
            speed: null
        }
        
    }
    </script>
	</body>
</html>