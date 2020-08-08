<?php
	define("GF_HEADER", "aaaaa");
	require_once("common.php");
	
	$bgms = getDataFile('audiotemplate', 'ko');
	
	$t = $_GET['t'];
	$q = $_GET['q'];

	$title;
	
	$langdir = '';
	if($lang != 'ko') 
		$langdir = $lang . '/';
	
	if($t === "1") {
		$div = explode("-", $q);
		$dolls = getJson('doll');
		foreach($dolls as $doll) {
			if($doll->id == $div[0]) {
				$title = getDollName($doll) . " ". L::story_dollmemory . " - MOD" . $div[1];
			}
		}
		$file = json_decode(file_get_contents("story_json/{$langdir}memoir/".$div[0]."_".$div[1].".txt"));
	}
	
	if($t === "2") {
		if($lang != 'ko')
			$storys = getJson("substory_$lang");
		else
			$storys = getJson("substory");
		
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
	$header_title = "$title | " . L::sitetitle_short;
	require_once("header.php");
?>
<main role="main" class="container">
	<div class="col-12 my-3 p-3 bg-white rounded box-shadow">
		<input type="checkbox" id="storyimg_btn"><label for="storyimg_btn">텍스트만 보기</label>
	</div>
		
	<div class="col-12 my-3 p-3 bg-white rounded box-shadow">
		<h6 class="border-bottom border-gray pb-2 mb-0"><b><?=$title?></b></h6>
		<div class="text-muted pt-3">
		<?php foreach($file as $line) { 
					if(isset($line->bg)) {
						$bg = $line->bg;
					}
					if($bg != "0") {
            $profile = getStoryBGProfile();
            $bgname = getStoryBGImageName($bg, $profile);
            
					//if($bg != "0" && $bg != "9" && $bg != "10") {
						echo "<div class=\"storyimg\" style=\"position: relative;overflow: hidden;\">";
						echo "<img style=\"width:100%;position:relative;z-index:\"  src='img/story_background/$bgname.png'>";
						
						$totnum = sizeof($line->character);
						$i = 0;
						$strcount = '';
						switch($totnum) {
							case 1: $strnum = 'one'; break;
							case 2: $strnum = 'two'; break;
							case 3: $strnum = 'three'; break;
						}
						foreach($line->character as $char) {
							if($q == 2606) {
								if($char == "AR") {
									continue;
								}
							}
							$strcount = '';
							switch($i) {
								case 0: $strcount .= 'first'; break;
								case 1: $strcount .= 'second'; break;
								case 2: $strcount .= 'third'; break;
							}
							if($i == $line->speaker) {
								$strcount .= ' saying';
							}
							$imgdir = getcharimgdir($char, $line->character_emotion[$i]);
							if($imgdir != "" && $imgdir != "invisible") {
								echo "<img class=\"storydoll $strnum $strcount\" src='img/$imgdir.png'>";
							} 
							else {
								$imgdir = getcharimgdir_fairy($char, $line->character_emotion[$i]);
                                if($imgdir != "" && $imgdir != "invisible") {
                                    echo "<img class=\"storyfairy fairy $strnum $strcount\" src='img/$imgdir.png'>";
                                }
							}
							$i++;
						}
						echo "</div>";
					}
					//선택지
					if(strpos($line->text, '<c>') !== false) {
						$tmp_br = explode('<c>', $line->text);
						$tmp_brt = '';
						for($j = 0 ; $j < sizeof($tmp_br) ; $j++) {
							if($j == 0) 
								$tmp_brt .= $tmp_br[$j] . '<br>';
							else 
								$tmp_brt .= "선택 " . $j . " : " . $tmp_br[$j] . '<br>';
						}
						$line->text = $tmp_brt;
					}
					
					//색깔코드
					if(strpos($line->text, '<color=') !== false) {
						$exp = explode("</color>", $line->text);
						$str = '';
						foreach($exp as $tmp) {
							$str .= preg_replace_callback("/<color=#([0-9A-Z-a-z]{6})>(.*)/", "color_callback", $tmp);
						}
						$line->text = $str;
					}
					
					if(isset($line->branch)) {
						$line->text = "선택 " . $line->branch . " : " . $line->text;
					}

					if(isset($line->bgm)) {
						if(strtoupper($line->bgm) == "BGM_EMPTY") {
							echo "<button name='bgmstop' class='btn btn-sm btn-dark' data-toggle='tooltip' data-placement='top' title='bgm이 멈추는 구간'><i class='far fa-stop-circle'></i></button>";
						}
						else if(strtoupper($line->bgm) == "BGM_PAUSE") {
							echo "<button name='bgmpause' class='btn btn-sm btn-dark' data-toggle='tooltip' data-placement='top' title='bgm이 일시정지되는 구간'><i class='far fa-stop-circle'></i></button>";
						}
						else if(strtoupper($line->bgm) == "BGM_UNPAUSE") {
							echo "<button name='bgmunpause' class='btn btn-sm btn-dark' data-toggle='tooltip' data-placement='top' title='bgm이 다시재생되는 구간'><i class='far fa-stop-circle'></i></button>";
						}
						else 
							echo "<audio name='audio_bgm' loop controls preload='none' controlsList='nodownload'><source src='audio/" . getBGM($line->bgm) . "' type='audio/mp3'></audio>";
					}
					
					
		?>
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
		<ins class="adsbygoogle"
		 style="display:block; text-align:center"
		 data-ad-client="ca-pub-6637664198779025"
		 data-ad-slot="3111645353"
		 data-ad-format="auto"
		 data-full-width-responsive="true"></ins>
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
		$("#second_round_btn").on('click', function() {
			if($(this).prop("checked") === true) {
				$(".second_round.first").hide();
				$(".second_round.second").show();
			}
			else if($(this).prop('checked') === false) {
				$(".second_round.first").show();
				$(".second_round.second").hide();
			}
		});
		
		var nowplaying;
		var fadeInterval;
		var interval = 50;
		$("audio[name='audio_bgm']").on('play', function(e) {
			if(nowplaying && nowplaying != this) {
				nowplaying.pause();
			}
			if(fadeInterval) {
				nowplaying.pause();
				clearInterval(fadeInterval);
			}
			nowplaying = this;
			nowplaying.volume = 1.0;
		});
		$("button[name='bgmstop']").on('click', function(e) {
			var vol = nowplaying.volume;
			fadeInterval = setInterval(
			function() {
				if (vol > 0) {
				  vol -= 0.05;
				  nowplaying.volume = vol;
				}
				else {
				  nowplaying.pause();
				  clearInterval(fadeInterval);
				}
			}, interval);
		});
		$("button[name='bgmpause']").on('click', function(e) {
			var vol = nowplaying.volume;
			console.log(vol);
			fadeInterval = setInterval(
			function() {
				if (vol > 0) {
				  vol -= 0.05;
				  nowplaying.volume = vol;
				}
				else {
				  nowplaying.pause();
				  clearInterval(fadeInterval);
				}
			}, interval);
		});
		$("button[name='bgmunpause']").on('click', function(e) {
			var vol = nowplaying.volume;
			nowplaying.play();
			fadeInterval = setInterval(
			function() {
				if (vol < 1) {
				  vol += 0.05;
				  nowplaying.volume = vol;
				}
				else {
				  clearInterval(fadeInterval);
				}
			}, interval);
		});
	</script>
	</body>
</html>