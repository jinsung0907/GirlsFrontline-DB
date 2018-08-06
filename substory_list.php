<?php
	define("GF_HEADER", "aaaaa");
	require_once("common.php");
	
	$header_title = "소녀전선 서브스토리 | 소전DB";
	$header_desc = "소녀전선 스토리, 개장 스토리, 스킨스토리, 소전 스토리, "; 
	require_once("header.php");
	
	if($lang != 'ko') {
		$storys = json_decode(file_get_contents("data/substory_$lang.json"));
	}
	else $storys = json_decode(file_get_contents("data/substory.json"));
?>
    <main role="main" class="container">
		<div class="my-3 p-3 bg-white rounded box-shadow">
			<h2 style="display: inline;margin-right:10px">인형의 추억 (개장스토리)</h2>
			<h6 class="border-bottom border-gray pb-2 mb-0"></h6>
			<div class="media text-muted pt-3">
				<p class="media-body pb-3 mb-0 small lh-125 border-bottom border-gray">
					<strong class="d-block text-dark">콜트 리볼버</strong>
					<a href="substory.php?t=1&q=1-1">MOD 1</a>
					<a href="substory.php?t=1&q=1-2">MOD 2</a>
					<a href="substory.php?t=1&q=1-3">MOD 3</a>
					<a href="substory.php?t=1&q=1-4">MOD 4</a>
					<br><br>
					
					<strong class="d-block text-dark">M1911</strong>
					<a href="substory.php?t=1&q=2-1">MOD 1</a>
					<a href="substory.php?t=1&q=2-2">MOD 2</a>
					<a href="substory.php?t=1&q=2-3">MOD 3</a>
					<a href="substory.php?t=1&q=2-4">MOD 4</a>
					<br><br>
					
					<strong class="d-block text-dark">SV-98</strong>
					<a href="substory.php?t=1&q=44-1">MOD 1</a>
					<a href="substory.php?t=1&q=44-2">MOD 2</a>
					<a href="substory.php?t=1&q=44-3">MOD 3</a>
					<a href="substory.php?t=1&q=44-4">MOD 4</a>
					<br><br>
					
					<strong class="d-block text-dark">M4A1</strong>
					<a href="substory.php?t=1&q=55-1">MOD 1</a>
					<a href="substory.php?t=1&q=55-2">MOD 2</a>
					<a href="substory.php?t=1&q=55-3">MOD 3</a>
					<a href="substory.php?t=1&q=55-4">MOD 4</a>
					<br><br>
					
					<strong class="d-block text-dark">G3</strong>
					<a href="substory.php?t=1&q=63-1">MOD 1</a>
					<a href="substory.php?t=1&q=63-2">MOD 2</a>
					<a href="substory.php?t=1&q=63-3">MOD 3</a>
					<a href="substory.php?t=1&q=63-4">MOD 4</a>
					<br><br>
					
					<strong class="d-block text-dark">ST AR-15</strong>
					<a href="substory.php?t=1&q=57-1">MOD 1</a>
					<a href="substory.php?t=1&q=57-2">MOD 2</a>
					<a href="substory.php?t=1&q=57-3">MOD 3</a>
					<a href="substory.php?t=1&q=57-4">MOD 4</a>
					<br><br>
					
					<strong class="d-block text-dark">브렌</strong>
					<a href="substory.php?t=1&q=89-1">MOD 1</a>
					<a href="substory.php?t=1&q=89-2">MOD 2</a>
					<a href="substory.php?t=1&q=89-3">MOD 3</a>
					<a href="substory.php?t=1&q=89-4">MOD 4</a>
					<br><br>
					
					<strong class="d-block text-dark">IDW</strong>
					<a href="substory.php?t=1&q=93-1">MOD 1</a>
					<a href="substory.php?t=1&q=93-2">MOD 2</a>
					<a href="substory.php?t=1&q=93-3">MOD 3</a>
					<a href="substory.php?t=1&q=93-4">MOD 4</a>
					<br><br>
					
					<strong class="d-block text-dark">64식</strong>
					<a href="substory.php?t=1&q=94-1">MOD 1</a>
					<a href="substory.php?t=1&q=94-2">MOD 2</a>
					<a href="substory.php?t=1&q=94-3">MOD 3</a>
					<a href="substory.php?t=1&q=94-4">MOD 4</a>
					<br><br>
					
					<strong class="d-block text-dark">나강 리볼버</strong>
					<a href="substory.php?t=1&q=5-1">MOD 1</a>
					<a href="substory.php?t=1&q=5-2">MOD 2</a>
					<a href="substory.php?t=1&q=5-3">MOD 3</a>
					<a href="substory.php?t=1&q=5-4">MOD 4</a>
					<br><br>
					
					<strong class="d-block text-dark">모신나강</strong>
					<a href="substory.php?t=1&q=39-1">MOD 1</a>
					<a href="substory.php?t=1&q=39-2">MOD 2</a>
					<a href="substory.php?t=1&q=39-3">MOD 3</a>
					<a href="substory.php?t=1&q=39-4">MOD 4</a>
					<br><br>
					
					<strong class="d-block text-dark">브라우닝 M1918</strong>
					<a href="substory.php?t=1&q=75-1">MOD 1</a>
					<a href="substory.php?t=1&q=75-2">MOD 2</a>
					<a href="substory.php?t=1&q=75-3">MOD 3</a>
					<a href="substory.php?t=1&q=75-4">MOD 4</a>
					<br><br>
					
					<strong class="d-block text-dark">MP-446</strong>
					<a href="substory.php?t=1&q=91-1">MOD 1</a>
					<a href="substory.php?t=1&q=91-2">MOD 2</a>
					<a href="substory.php?t=1&q=91-3">MOD 3</a>
					<a href="substory.php?t=1&q=91-4">MOD 4</a>
					<br><br>
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