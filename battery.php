<?php
	define("GF_HEADER", "aaaaa");
	require_once("common.php");
	$header_desc = L::sitetitle_short . " " . L::gfl . " " . L::navigation_menu_cellcalc . ", " . L::battery_domitory . " " . L::navigation_menu_cellcalc;
	$header_keyword = L::gfl . " " . L::navigation_menu_cellcalc . ", " . L::battery_domitory . " " . L::navigation_menu_cellcalc;
	$header_title = L::navigation_menu_cellcalc . " | " . L::sitetitle_short;
	require_once("header.php");
?>
    <main role="main" class="container">
		<div class="my-3 p-3 bg-white rounded box-shadow">
			<?=L::battery_domitory_num?> : <select id="dorm">
				<option value=50>2 <?=L::battery_domitory?></option>
				<option value=85>3 <?=L::battery_domitory?></option>
				<option value=95>4 <?=L::battery_domitory?></option>
				<option value=99>5 <?=L::battery_domitory?></option>
				<option value=101>6 <?=L::battery_domitory?></option>
				<option value=102>7 <?=L::battery_domitory?></option>
				<option value=102.5>8 <?=L::battery_domitory?></option>
				<option value=103>9 <?=L::battery_domitory?></option>
				<option value=103.5>10 <?=L::battery_domitory?></option>
			</select><br>
			<?=L::battery_comfort_total?> : <input type="number" id="comfortpoint"><br>
			<?=L::battery_battery_accquire?> : <span id="result"></span>
			<br><br>
			<?=L::battery_source?> : <a target="_blank" href="http://cafe.naver.com/girlsfrontlinekr/1343675">http://cafe.naver.com/girlsfrontlinekr/1343675</a>
		</div>
    </main>
<?php
	require_once("footer.php");
?>
	<script>
		$("#comfortpoint,#dorm").on('input change', function(e) {
			var dormnum = Number($("#dorm").val());
			var point = Number($("#comfortpoint").val());
			var battery = dormnum + 11 * point / 10000 - 0.1 * Math.pow(point,2) / 100000000;
			$("#result").text(battery.toFixed(0) + "<?=L::battery_cnt?>");
		});
	</script>
	</body>
</html>