<?php
	define("GF_HEADER", "aaaaa");
	
	if(isset($_GET['lang'])) {
		session_start();
		if($_GET['lang'] == 'en') {
			$_SESSION['lang'] = 'en';
		}
		else if($_GET['lang'] == 'ko') {
			$_SESSION['lang'] = 'ko';
		}
	}
	require_once("header.php");
	
	$dir = scandir("img/main/");
	$dir = array_slice($dir, 2);
	$img = $dir[rand(0, sizeof($dir)-1)];
?>
    <main role="main" class="container">
		<div class="my-3 p-3 bg-white rounded box-shadow">
			<img style="width:100%" src="img/main/<?=$img?>">
		</div>
    </main>
<?php
	require_once("footer.php");
?>
	</body>
</html>