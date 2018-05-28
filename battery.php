<?php
	define("GF_HEADER", "aaaaa");
	$header_desc = "소녀전선 전지 계산기, 숙소 전지 계산기";
	$header_title = "전지 계산기";
	require_once("header.php");
?>
    <main role="main" class="container">
		<div class="my-3 p-3 bg-white rounded box-shadow">
			숙소 개수 : <select id="dorm">
				<option value=50>2 숙소</option>
				<option value=85>3 숙소</option>
				<option value=95>4 숙소</option>
				<option value=99>5 숙소</option>
				<option value=101>6 숙소</option>
				<option value=102>7 숙소</option>
				<option value=102.5>8 숙소</option>
				<option value=103>9 숙소</option>
				<option value=103.5>10 숙소</option>
			</select><br>
			총 안락도 : <input type="number" id="comfortpoint"><br>
			전지 획득량(24시간) : <span id="result"></span>
			<br><br>
			출처 : <a target="_blank" href="http://cafe.naver.com/girlsfrontlinekr/1343675">http://cafe.naver.com/girlsfrontlinekr/1343675</a>
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
			$("#result").text("약 " + battery.toFixed(0) + "개");
		});
	</script>
	</body>
</html>