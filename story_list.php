<?php
	define("GF_HEADER", "aaaaa");
	$header_title = "소녀전선 메인스토리 | 소전DB";
	$header_desc = "소녀전선 스토리, 소전 스토리, 소녀전선 스토리 정리, 소녀전선 스토리 순서, 소녀전선 메인 스토리 순서"; 
	require_once("header.php");
	$storys = json_decode(file_get_contents("story_json/story.txt"));
?>
    <main role="main" class="container">
		<div class="my-3 p-3 bg-white rounded box-shadow">
			<h2 style="display: inline;margin-right:10px">프롤로그</h2>
			<h6 class="border-bottom border-gray pb-2 mb-0"></h6>
			<div class="media text-muted pt-3">
				<p class="media-body pb-3 mb-0 small lh-125 border-bottom border-gray">
					<a href="story.php?q=1001"><strong class="d-block text-dark">프롤로그</strong></a>
				</p>
			</div>
		</div>
	<?php foreach($storys as $story) {
		if($story->num == -16) echo '<div class="my-3 p-3 bg-white rounded box-shadow"><h2 style="display: inline;margin-right:10px">특이점</h2><h6 class="border-bottom border-gray pb-2 mb-0"></h6><div class="media text-muted pt-3">
		<p class="media-body pb-3 mb-0 small lh-125 border-bottom border-gray"><a href="singularity.php"><strong class="d-block text-dark">특이점</strong></a></p></div></div>';
		if($story->num == -16 || $story->num == -17 || $story->num == -18) continue;
		?>
		<div class="my-3 p-3 bg-white rounded box-shadow">
			<h2 style="display: inline;margin-right:10px"><?=$story->name?></h2><b><i><?=$story->desc?></i></b>
			<h6 class="border-bottom border-gray pb-2 mb-0"></h6>
			<div class="media text-muted pt-3">
				<p class="media-body pb-3 mb-0 small lh-125 border-bottom border-gray">
			<?php foreach($story->list as $list) { 
					if($list->type == "일반") {
						$href = $list->num;
					} else if($list->type == "긴급") {
						$href = $list->num . "E";
					} else if($list->type == "야간") {
						$href = $list->num . "N";
					}
					
					if($list->num < 0) {
						$list->type = "이벤트";
						$list->num = "";
					}
					
					if($list-> num > 1000) {
						$list->type = "프롤로그";
						$list->num = "";
					}
					
			?>
					<a href="story.php?q=<?=$href?>"><strong class="d-block text-dark">(<?=$list->type?>) <?=$list->num?> - <?=$list->name?></strong></a>
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