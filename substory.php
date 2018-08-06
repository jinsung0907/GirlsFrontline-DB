<?php
	define("GF_HEADER", "aaaaa");
	require_once("common.php");
	
	$t = $_GET['t'];
	$q = $_GET['q'];

	$title;
	
	$langdir = '';
	if($lang != 'ko') 
		$langdir = $lang . '/';
	
	if($t === "1") {
		$div = explode("-", $q);
		$dolls = json_decode(file_get_contents("data/doll.json"));
		foreach($dolls as $doll) {
			if($doll->id == $div[0]) {
				$title = $doll->krName . " 인형의 추억";
			}
		}
		$file = json_decode(file_get_contents("story_json/{$langdir}memoir/".$div[0]."_".$div[1].".txt"));
	}
	
	if($t === "2") {
		if($lang != 'ko')
			$storys = json_decode(file_get_contents("data/substory_$lang.json"));
		else
			$storys = json_decode(file_get_contents("data/substory.json"));
		
		$num = floor($q / 100);
		switch($num) {
			case 0: $lists = $storys->skin[0]->list; break;
			case 15: $lists = $storys->skin[1]->list; break;
			case 3: $lists = $storys->skin[2]->list; break;
			case 18: $lists = $storys->skin[3]->list; break;
			case 19: $lists = $storys->skin[4]->list; break;
			case 8: $lists = $storys->skin[5]->list; break;
			case 21: $lists = $storys->skin[6]->list; break;
		}
		
		if(isset($lists)) {
			foreach($lists as $list) {
				if($q == $list->num) 
					$title = $list->name;
			}
		} else {
			$title = '스킨 스토리';
		}
		
		$file = json_decode(file_get_contents("story_json/{$langdir}skin/$q.txt"));
	}

	
	
	if(!sizeof($file)) {
		exit("badinput");
	}
	
	$header_desc .= ", $title";
	$header_title = "$title | 소전DB";
	require_once("header.php");
?>
<main role="main" class="container">
	<div class="col-12 my-3 p-3 bg-white rounded box-shadow">
		<input type="checkbox" id="storyimg_btn"><label for="storyimg_btn">텍스트만 보기</label>
	</div>
		
	<div class="col-12 my-3 p-3 bg-white rounded box-shadow">
		<h6 class="border-bottom border-gray pb-2 mb-0"><b><?=$title?></b></h6>
		<div class="text-muted pt-3">
		<?php	foreach($file as $line) { 
				if(isset($line->bg)) {
					$bg = $line->bg;
				}
					if($bg != "0" && $bg != "9" && $bg != "10") {
						echo "<div class=\"storyimg\" style=\"position: relative;overflow: hidden;\">";
						echo "<img style=\"width:100%;position:relative;z-index:\"  src='img/story_background/$bg.png'>";
						
						$totnum = sizeof($line->character);
						$i = 0;
						$strcount = '';
						switch($totnum) {
							case 1: $strnum = 'one'; break;
							case 2: $strnum = 'two'; break;
							case 3: $strnum = 'three'; break;
						}
						foreach($line->character as $char) {
							$strcount = '';
							switch($i) {
								case 0: $strcount .= 'first'; break;
								case 1: $strcount .= 'second'; break;
								case 2: $strcount .= 'third'; break;
							}
							$imgdir = getcharimgdir($char, $line->character_emotion[$i]);
							if($i == $line->speaker) {
								$strcount .= ' saying';
							}
							if($imgdir != "") {
								echo "<img class=\"storydoll $strnum $strcount\" src='img/$imgdir.png'>";
							} 
							else {
								$imgdir = getcharimgdir_fairy($char, $line->character_emotion[$i]);
								echo "<img class=\"storyfairy fairy $strnum $strcount\" src='img/$imgdir.png'>";
							}
							$i++;
						}
						echo "</div>";
					}
				//} ?>
			<p class="pb-3 mb-0 small lh-125">
				<strong class="d-block text-dark"><a class="doll_link" href="doll.php?id=<?=$line->speaker_name?>"><?=$line->speaker_name?></a></strong>
				<?=nl2br($line->text)?>
				<br>
				<br>
			</p>
			<?php } ?>
        </div>
      </div>
	  <div class="my-3 p-3 bg-white rounded box-shadow">
		<!-- 라이브리 시티 설치 코드 -->
		<div id="lv-container" data-id="city" data-uid="MTAyMC8zNjIyNy8xMjc2Mg==">
			<script type="text/javascript">
			window.livereOptions = { refer: '<?=$_SERVER['HTTP_HOST']?><?=$_SERVER['REQUEST_URI']?>' };
		   (function(d, s) {
			   var j, e = d.getElementsByTagName(s)[0];

			   if (typeof LivereTower === 'function') { return; }

			   j = d.createElement(s);
			   j.src = 'https://cdn-city.livere.com/js/embed.dist.js';
			   j.async = true;

			   e.parentNode.insertBefore(j, e);
		   })(document, 'script');
			</script>
		<noscript> 댓글 작성을 위해 JavaScript를 활성화 해주세요</noscript>
		</div>
		<!-- 시티 설치 코드 끝 -->
	</div>
    </main>
<?php
	require_once("footer.php");
?>
	<script>
		$("#storyimg_btn").on('click', function() {
			if($(this).prop("checked") === true) {
				$(".container").find("img").hide();
			}
			else if($(this).prop('checked') === false) {
				$(".container").find("img").show();
			}
		});
	</script>
	</body>
</html>