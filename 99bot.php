<?php
	define("GF_HEADER", "aaaaa");
	require_once("common.php");
	require_once("header.php");
	
	$dir = scandir("img/main/");
	$dir = array_slice($dir, 2);
	$img = $dir[rand(0, sizeof($dir)-1)];
?>
    <main role="main" class="container">
		<div class="my-3 p-3 bg-white rounded box-shadow">
			<img style="width: 20%" src="https://k.kakaocdn.net/dn/qyUrm/btqgHSs1Jut/6TX5ACcJwdJWDeGZpK0eW0/img_xl.jpg">
			<h2>별명 추가</h2>
			인형의 경우는 인형:[인형id] 를 (ex. 인형:221)<br>
			요정의 경우는 요정:[요정id] 를 <br>
			장비의 경우는 장비:[장비id] 를 입력하시면 됩니다.<br>
			id는 db에서 상세페이지로 들어가시면 주소에 나옵니다. (ex. doll.php?id=123)<br>
			<br>
			나머지는 그냥 나오게 하고 싶은 말을 적어주시면 검토후 적용됩니다.<br>
		</div>
    </main>
<?php
	require_once("footer.php");
?>
	</body>
</html>