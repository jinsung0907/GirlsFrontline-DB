<?php
	define("GF_HEADER", "aaaaa");
	$header_desc = "소녀전선 군수지원 계산기, 소전 군수지원 계산기, 군수지원 효율";
	$header_title = "군수지원 계산기";
	require_once("header.php");
	
	$logis = json_decode(file_get_contents("data/logistics.json"));
	
	
?>
    <main role="main" class="container">
		<div class="my-3 p-3 bg-white rounded box-shadow">
			일반 작동은됨
			다만 대성공, 우선순위는 작동안됨
			<table class="table">
				<thead>
					<tr>
						<th>군수지역</th>
						<th>제대레벨</th>
						<th>소요시간(분)</th>
						<th>인력</th>
						<th>탄약</th>
						<th>식량</th>
						<th>부품</th>
						<th>추가보상</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td>
							<select id="status_legion1">
								<option value="0">선택</option>
								<option value="1">0-1</option>
								<option value="2">0-2</option>
								<option value="3">0-3</option>
								<option value="4">0-4</option>
								<option value="5">1-1</option>
								<option value="6">1-2</option>
								<option value="7">1-3</option>
								<option value="8">1-4</option>
								<option value="9">2-1</option>
								<option value="10">2-2</option>
								<option value="11">2-3</option>
								<option value="12">2-4</option>
								<option value="13">3-1</option>
								<option value="14">3-2</option>
								<option value="15">3-3</option>
								<option value="16">3-4</option>
								<option value="17">4-1</option>
								<option value="18">4-2</option>
								<option value="19">4-3</option>
								<option value="20">4-4</option>
								<option value="21">5-1</option>
								<option value="22">5-2</option>
								<option value="23">5-3</option>
								<option value="24">5-4</option>
								<option value="25">6-1</option>
								<option value="26">6-2</option>
								<option value="27">6-3</option>
								<option value="28">6-4</option>
								<option value="29">7-1</option>
								<option value="30">7-2</option>
								<option value="31">7-3</option>
								<option value="32">7-4</option>
								<option value="33">8-1</option>
								<option value="34">8-2</option>
								<option value="35">8-3</option>
								<option value="36">8-4</option>
								<option value="37">9-1</option>
								<option value="38">9-2</option>
								<option value="39">9-3</option>
								<option value="40">9-4</option>
								<option value="41">10-1</option>
								<option value="42">10-2</option>
								<option value="43">10-3</option>
								<option value="44">10-4</option>
							</select>
						</td>
						<td><input id="status_level1" type="number" style="width:50px" value="100"></td>
						<td><input id="status_time1" type="text" size="4" disabled></td>
						<td><span id="status_manpower1"></span></td>
						<td><span id="status_ammo1"></span></td>
						<td><span id="status_ration1"></span></td>
						<td><span id="status_parts1"></span></td>
						<td><span id="status_item1"></span></td>
					</tr>
					<tr>
						<td>
							<select id="status_legion2">
								<option value="0">선택</option>
								<option value="1">0-1</option>
								<option value="2">0-2</option>
								<option value="3">0-3</option>
								<option value="4">0-4</option>
								<option value="5">1-1</option>
								<option value="6">1-2</option>
								<option value="7">1-3</option>
								<option value="8">1-4</option>
								<option value="9">2-1</option>
								<option value="10">2-2</option>
								<option value="11">2-3</option>
								<option value="12">2-4</option>
								<option value="13">3-1</option>
								<option value="14">3-2</option>
								<option value="15">3-3</option>
								<option value="16">3-4</option>
								<option value="17">4-1</option>
								<option value="18">4-2</option>
								<option value="19">4-3</option>
								<option value="20">4-4</option>
								<option value="21">5-1</option>
								<option value="22">5-2</option>
								<option value="23">5-3</option>
								<option value="24">5-4</option>
								<option value="25">6-1</option>
								<option value="26">6-2</option>
								<option value="27">6-3</option>
								<option value="28">6-4</option>
								<option value="29">7-1</option>
								<option value="30">7-2</option>
								<option value="31">7-3</option>
								<option value="32">7-4</option>
								<option value="33">8-1</option>
								<option value="34">8-2</option>
								<option value="35">8-3</option>
								<option value="36">8-4</option>
								<option value="37">9-1</option>
								<option value="38">9-2</option>
								<option value="39">9-3</option>
								<option value="40">9-4</option>
								<option value="41">10-1</option>
								<option value="42">10-2</option>
								<option value="43">10-3</option>
								<option value="44">10-4</option>
							</select>
						</td>
						<td><input id="status_level2" type="number" style="width:50px" value="100"></td>
						<td><input id="status_time2" type="text" size="4" disabled></td>
						<td><span id="status_manpower2"></span></td>
						<td><span id="status_ammo2"></span></td>
						<td><span id="status_ration2"></span></td>
						<td><span id="status_parts2"></span></td>
						<td><span id="status_item2"></span></td>
					</tr>
					<tr>
						<td>
							<select id="status_legion3">
								<option value="0">선택</option>
								<option value="1">0-1</option>
								<option value="2">0-2</option>
								<option value="3">0-3</option>
								<option value="4">0-4</option>
								<option value="5">1-1</option>
								<option value="6">1-2</option>
								<option value="7">1-3</option>
								<option value="8">1-4</option>
								<option value="9">2-1</option>
								<option value="10">2-2</option>
								<option value="11">2-3</option>
								<option value="12">2-4</option>
								<option value="13">3-1</option>
								<option value="14">3-2</option>
								<option value="15">3-3</option>
								<option value="16">3-4</option>
								<option value="17">4-1</option>
								<option value="18">4-2</option>
								<option value="19">4-3</option>
								<option value="20">4-4</option>
								<option value="21">5-1</option>
								<option value="22">5-2</option>
								<option value="23">5-3</option>
								<option value="24">5-4</option>
								<option value="25">6-1</option>
								<option value="26">6-2</option>
								<option value="27">6-3</option>
								<option value="28">6-4</option>
								<option value="29">7-1</option>
								<option value="30">7-2</option>
								<option value="31">7-3</option>
								<option value="32">7-4</option>
								<option value="33">8-1</option>
								<option value="34">8-2</option>
								<option value="35">8-3</option>
								<option value="36">8-4</option>
								<option value="37">9-1</option>
								<option value="38">9-2</option>
								<option value="39">9-3</option>
								<option value="40">9-4</option>
								<option value="41">10-1</option>
								<option value="42">10-2</option>
								<option value="43">10-3</option>
								<option value="44">10-4</option>
							</select>
						</td>
						<td><input id="status_level3" type="number" style="width:50px" value="100"></td>
						<td><input id="status_time3" type="text" size="4" disabled></td>
						<td><span id="status_manpower3"></span></td>
						<td><span id="status_ammo3"></span></td>
						<td><span id="status_ration3"></span></td>
						<td><span id="status_parts3"></span></td>
						<td><span id="status_item3"></span></td>
					</tr>
					<tr>
						<td>
							<select id="status_legion4">
								<option value="0">선택</option>
								<option value="1">0-1</option>
								<option value="2">0-2</option>
								<option value="3">0-3</option>
								<option value="4">0-4</option>
								<option value="5">1-1</option>
								<option value="6">1-2</option>
								<option value="7">1-3</option>
								<option value="8">1-4</option>
								<option value="9">2-1</option>
								<option value="10">2-2</option>
								<option value="11">2-3</option>
								<option value="12">2-4</option>
								<option value="13">3-1</option>
								<option value="14">3-2</option>
								<option value="15">3-3</option>
								<option value="16">3-4</option>
								<option value="17">4-1</option>
								<option value="18">4-2</option>
								<option value="19">4-3</option>
								<option value="20">4-4</option>
								<option value="21">5-1</option>
								<option value="22">5-2</option>
								<option value="23">5-3</option>
								<option value="24">5-4</option>
								<option value="25">6-1</option>
								<option value="26">6-2</option>
								<option value="27">6-3</option>
								<option value="28">6-4</option>
								<option value="29">7-1</option>
								<option value="30">7-2</option>
								<option value="31">7-3</option>
								<option value="32">7-4</option>
								<option value="33">8-1</option>
								<option value="34">8-2</option>
								<option value="35">8-3</option>
								<option value="36">8-4</option>
								<option value="37">9-1</option>
								<option value="38">9-2</option>
								<option value="39">9-3</option>
								<option value="40">9-4</option>
								<option value="41">10-1</option>
								<option value="42">10-2</option>
								<option value="43">10-3</option>
								<option value="44">10-4</option>
							</select>
						</td>
						<td><input id="status_level4" type="number" style="width:50px" value="100"></td>
						<td><input id="status_time4" type="text" size="4" disabled></td>
						<td><span id="status_manpower4"></span></td>
						<td><span id="status_ammo4"></span></td>
						<td><span id="status_ration4"></span></td>
						<td><span id="status_parts4"></span></td>
						<td><span id="status_item4"></span></td>
					</tr>
					<tr>
						<td colspan="2">시간당 획득량 (예상)
						</td>
						<td><input type="checkbox" id="status_great"><label for="status_great">대성공여부</label></td>
						<td><span id="status_manpower_tot"></span></td>
						<td><span id="status_ammo_tot"></span></td>
						<td><span id="status_ration_tot"></span></td>
						<td><span id="status_parts_tot"></span></td>
						<td><span id="status_item_tot"></span></td>
					</tr>
				</tbody>
			</table>
			<button onclick="calc_status()">계산하기</button>
		</div>
    </main>
<?php
	require_once("footer.php");
?>
	</body>
	
	<script>
		var logi_json;
		$.getJSON("data/logistics.json", function(data) { logi_json = data; } );
		$("#status_legion1, #status_legion2, #status_legion3, #status_legion4").on('change', function(e){
			var num = $(this).attr('id').slice(-1);

			var logi = get_logi_val(Number($(this).val()));
			$("#status_time" + num).val(logi.time);
			$("#status_manpower" + num).text(logi.manpower);
			$("#status_ammo" + num).text(logi.ammo);
			$("#status_ration" + num).text(logi.ration);
			$("#status_parts" + num).text(logi.parts);
			$("#status_item" + num).text(logi.item);
			calc_status();
		});
		
		function get_logi_val(legion) {
			var result = {};
			for(var i = 0 ; i<= logi_json.length-1 ; i++) {
				if(logi_json[i].code == legion) {
					result = logi_json[i];
					return result;
					break;
				}
			}
		}
		function calc_status() {
			var data = {};
			var total = {manpower: 0 , ammo: 0, ration: 0, parts: 0};
			
			data.type = "status";
			for(var i = 1 ; i<=4 ; i++) {
				data["legion" + i] = $("#status_legion" + i).val();
				data["level" + i] = $("#status_level" + i).val();
				data["manpower" + i] = Number($("#status_manpower" + i).text());
				data["ammo" + i] = Number($("#status_ammo" + i).text());
				data["ration" + i] = Number($("#status_ration" + i).text());
				data["parts" + i] = Number($("#status_parts" + i).text());
				data["item" + i] = $("#status_item" + i).text();
				
				var manpower = Math.ceil(data["manpower" + i] / Number($("#status_time" + i).val()) * 60);
				var ammo = Math.ceil(data["ammo" + i] / Number($("#status_time" + i).val()) * 60);
				var ration = Math.ceil(data["ration" + i] / Number($("#status_time" + i).val()) * 60);
				var parts = Math.ceil(data["parts" + i] / Number($("#status_time" + i).val()) * 60);
				
				if(!isNaN(manpower)) 
					total.manpower += manpower;
				if(!isNaN(ammo)) 
					total.ammo += ammo;
				if(!isNaN(ration)) 
					total.ration += ration;
				if(!isNaN(parts)) 
					total.parts += parts;
			}
			
			$("#status_manpower_tot").text(total.manpower);
			$("#status_ammo_tot").text(total.ammo);
			$("#status_ration_tot").text(total.ration);
			$("#status_parts_tot").text(total.parts);
		}
	</script>
</html>