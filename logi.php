<?php
	define("GF_HEADER", "aaaaa");
	require_once("common.php");
	$header_desc = "소전DB 군수지원 계산기입니다.";
	$header_keyword = "소녀전선 군수지원 계산기, 소전 군수지원 계산기, 군수지원 효율";
	$header_title = "군수지원 계산기";
	require_once("header.php");
	
	$logis = getJson('logistics.json');
?>
    <main role="main" class="container">
		<div class="my-3 bg-white rounded box-shadow">
			출처 : https://tempkaridc.github.io/gf/
			<iframe style="display:block; border:none; width:100%; height: 100vh" src="https://tempkaridc.github.io/gf/"></iframe>
		</div>
    </main>
<?php
	require_once("footer.php");
?>
	</body>
</html>