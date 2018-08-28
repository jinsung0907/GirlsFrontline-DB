<?php
	define("GF_HEADER", "aaaaa");
	require_once("common.php");
	
	$header_title = "소녀전선 서브스토리 | 소전DB";
	$header_desc = "소전DB 소녀전선 서브스토리 모음 사이트입니다."; 
	$header_keyword = "소녀전선 스토리, 개장 스토리, 스킨스토리, 소전 스토리, "; 
	require_once("header.php");
	
	if($lang != 'ko') {
		$storys = json_decode(file_get_contents("data/substory_$lang.json"));
	}
	else $storys = json_decode(file_get_contents("data/substory.json"));
	
	$dolls = json_decode(file_get_contents("data/doll.json"));
	//live2d 리스트
	$modstory = [];
	if($lang != 'ko') 
		$dir = "story_json/" . $lang . "/memoir";
	else
		$dir = "story_json/memoir";
	
	$dir = array_slice(scandir($dir), 2);
	for($i = 0 ; $i < sizeof($dir) ; $i++) {
		foreach($dolls as $doll) {
			if(explode("_", $dir[$i])[0] == $doll->id) {
				array_push($modstory, [getDollName($doll), $doll->id]);
				$i += 3;
				break;
			}
		}
	}
	if(sizeof($live2dlist) >= 1) {
		$live2d_list = json_encode($live2dlist);
	}
	else {
		$live2d_list = '\'\'';
	}
	
?>
    <main role="main" class="container">
		<div class="my-3 p-3 bg-white rounded box-shadow">
			<h2 style="display: inline;margin-right:10px">인형의 추억 (개장스토리)</h2>
			<h6 class="border-bottom border-gray pb-2 mb-0"></h6>
			<div class="media text-muted pt-3">
				<p class="media-body pb-3 mb-0 small lh-125 border-bottom border-gray">
		<?php
				foreach($modstory as $mstory) { ?>
					<strong class="d-block text-dark"><?=$mstory[0]?></strong>
					<a href="substory.php?t=1&q=<?=$mstory[1]?>-1">MOD 1</a>
					<a href="substory.php?t=1&q=<?=$mstory[1]?>-2">MOD 2</a>
					<a href="substory.php?t=1&q=<?=$mstory[1]?>-3">MOD 3</a>
					<a href="substory.php?t=1&q=<?=$mstory[1]?>-4">MOD 4</a>
					<br><br>
		<?php } ?>
				</p>
			</div>
		</div>
		<?php
		foreach($storys->skin as $story) { 
			$comment = $story->comment . "<br><br>";
		?>
		<div class="my-3 p-3 bg-white rounded box-shadow"> 
			<h2 style="display: inline;margin-right:10px"><?=$story->name?></h2><i><?=$story->desc?></i>
			<h6 class="border-bottom border-gray pb-2 mb-0"></h6>
			<div class="media text-muted pt-3">
				<p class="media-body pb-3 mb-0 small lh-125 border-bottom border-gray">
					<?=$comment?>
					
			<?php foreach($story->list as $list) { ?>
					<a href="substory.php?t=2&q=<?=$list->num?>"><strong class="d-block text-dark"><?=$list->name?></strong></a>
					<i><?=$list->desc?></i>
					<br><br>
			<?php } ?>
			</div>
		</div>
	<?php } ?>
    </main>
<?php
	require_once("footer.php");
?>