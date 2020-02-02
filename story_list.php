<?php
	define("GF_HEADER", "aaaaa");
	require_once("common.php");
	
	$header_title = L::gfl . " " . L::navigation_menu_mainstory . " | " . L::sitetitle_short;
	$header_desc = L::title_storylist_desc; 
	$header_keyword = L::title_storylist_keyword; 
	require_once("header.php");
	
	if($lang != "ko")
		$storys = json_decode(file_get_contents("story_json/$lang/story.txt"));
	else 
		$storys = json_decode(file_get_contents("story_json/story.txt"));
?>
    <main role="main" class="container">
		<div class="my-3 p-3 bg-white rounded box-shadow">
			<h2 style="display: inline;margin-right:10px"><?=L::story_prologue?></h2>
			<h6 class="border-bottom border-gray pb-2 mb-0"></h6>
			<div class="media text-muted pt-3">
				<p class="media-body pb-3 mb-0 small lh-125 border-bottom border-gray">
					<a target="_blank" href="story.php?q=1001"><strong class="d-block text-dark"><?=L::story_prologue?></strong></a>
				</p>
			</div>
		</div>
	<?php foreach($storys as $story) {
		if($story->num == -16) echo '<div class="my-3 p-3 bg-white rounded box-shadow"><h2 style="display: inline;margin-right:10px">(대형이벤트) 특이점</h2><h6 class="border-bottom border-gray pb-2 mb-0"></h6><div class="media text-muted pt-3">
		<p class="media-body pb-3 mb-0 small lh-125 border-bottom border-gray"><a target="_blank" href="singularity.php"><strong class="d-block text-dark">특이점</strong></a></p></div></div>';
		if($story->num == -16 || $story->num == -17 || $story->num == -18) continue;
		if($story->num == -24) echo '<div class="my-3 p-3 bg-white rounded box-shadow"><h2 style="display: inline;margin-right:10px">(대형이벤트) 난류연속</h2><h6 class="border-bottom border-gray pb-2 mb-0"></h6><div class="media text-muted pt-3">
		<p class="media-body pb-3 mb-0 small lh-125 border-bottom border-gray"><a target="_blank" href="continuum_turbulence.php"><strong class="d-block text-dark">난류연속</strong></a></p></div></div>';
		if($story->num == -24 || $story->num == -25 || $story->num == -26 || $story->num == -27 || $story->num == -28) continue;
    if($story->num == -31) echo '<div class="my-3 p-3 bg-white rounded box-shadow"><h2 style="display: inline;margin-right:10px">(대형이벤트) 이성질체</h2><h6 class="border-bottom border-gray pb-2 mb-0"></h6><div class="media text-muted pt-3">
		<p class="media-body pb-3 mb-0 small lh-125 border-bottom border-gray"><a target="_blank" href="isomer.php"><strong class="d-block text-dark">이성질체</strong></a></p></div></div>';
    if($story->num == -31) continue;
		if($story->num == -36) echo '<div class="my-3 p-3 bg-white rounded box-shadow"><h2 style="display: inline;margin-right:10px">(대형이벤트) 편극광</h2><h6 class="border-bottom border-gray pb-2 mb-0"></h6><div class="media text-muted pt-3">
		<p class="media-body pb-3 mb-0 small lh-125 border-bottom border-gray"><a target="_blank" href="polarizedlight.php"><strong class="d-block text-dark">편극광</strong></a></p></div></div>';
		if($story->num == -36) continue;
		?>
		<div class="my-3 p-3 bg-white rounded box-shadow">
			<h3 id="<?=$story->name?>" style="display: inline;margin-right:10px"><?=$story->name?> : <?=$story->keyword?></h3><b><i><?=$story->desc?></i></b>
			<h6 class="border-bottom border-gray pb-2 mb-0"></h6>
			<div class="media text-muted pt-3">
				<p class="media-body pb-3 mb-0 small lh-125 border-bottom border-gray">
			<?php foreach($story->list as $list) { 
					if($list->type == "일반") {
						$typename = L::story_normal;
						$href = $list->num;
					} else if($list->type == "긴급") {
						$typename = L::story_emergency;
						$href = $list->num . "E";
					} else if($list->type == "야간") {
						$typename = L::story_night;
						$href = $list->num . "N";
					}
					
					if($list->num < 0) {
						$typename = L::story_event;
						$list->num = "";
					}
					
					if($list-> num > 1000) {
						$typename = L::story_prologue;
						$list->num = "";
					}
					
			?>
					<a target="_blank" href="story.php?q=<?=$href?>"><strong class="d-block text-dark">(<?=$typename?>) <?=$list->num?> - <?=$list->name?></strong></a>
					<i><?=$list->desc?></i><br><br>
			<?php } ?>
				</p>
			</div>
		</div>
	<?php } ?>
    </main>
<?php
	require_once("footer.php");
?>
	</body>
</html>