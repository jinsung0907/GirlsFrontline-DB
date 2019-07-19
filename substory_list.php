<?php
	define("GF_HEADER", "aaaaa");
	require_once("common.php");
	
	$header_title = L::gfl . " " . L::navigation_menu_substory . " | " . L::sitetitle_short;
	$header_desc = L::title_substorylist_desc; 
	$header_keyword = L::title_substorylist_keyword; 
	require_once("header.php");
	
	if($lang != 'ko') {
		$storys = getJson("substory_$lang");
	}
	else $storys = getJson("substory");
	
	$dolls = getJson('doll');
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
?>
    <main role="main" class="container">
		<div class="my-3 p-3 bg-white rounded box-shadow">
			<h2 style="display: inline;margin-right:10px"><?=L::story_dollmemory?></h2>
			<h6 class="border-bottom border-gray pb-2 mb-0"></h6>
			<div class="media text-muted pt-3">
				<p class="media-body pb-3 mb-0 small lh-125 border-bottom border-gray">
		<?php
				foreach($modstory as $mstory) { ?>
					<strong class="d-block text-dark"><?=$mstory[0]?></strong>
					<a target="_blank" href="substory.php?t=1&q=<?=$mstory[1]?>-1">MOD 1</a>
					<a target="_blank" href="substory.php?t=1&q=<?=$mstory[1]?>-2">MOD 2</a>
					<a target="_blank" href="substory.php?t=1&q=<?=$mstory[1]?>-3">MOD 3</a>
					<a target="_blank" href="substory.php?t=1&q=<?=$mstory[1]?>-4">MOD 4</a>
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
					<a target="_blank" href="substory.php?t=2&q=<?=$list->num?>"><strong class="d-block text-dark"><?=$list->name?></strong></a>
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