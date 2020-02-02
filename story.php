<?php
	define("GF_HEADER", "aaaaa");
	require_once("common.php");
	
	if($lang != "ko") {
		$storys = json_decode(file_get_contents("story_json/$lang/story.txt"));
		$langdir = "/$lang/";
	}
	else {
		$storys = json_decode(file_get_contents("story_json/story.txt"));
		$langdir = '/';
	}
	$bgms = getDataFile('audiotemplate', 'ko');
	
	$q = $_GET['q'];
	
	if (substr($q, 0, 1) === '-') {
		$tmp = explode("-", $q);
		$div[0] = "-".$tmp[1];
		$div[1] = $tmp[2];
		$div[2] = $tmp[3];
	} else {
		$div = explode("-", $q);
	}
	
	$fieldname;
	$name;

	foreach($storys as $story) {
		if($story->num == $div[0]) {
			$fieldname = $story->name;
			foreach($story->list as $list) {
				if (substr($q, -1) == 'E') {
					if($list->type == "긴급" && $list->num == substr($q, 0, -1)) {
						$name = $list->name;
						$filelist = $list->file;
					}
				} else if (substr($q, -1) == 'N') {
					if($list->type == "야간" && $list->num == substr($q, 0, -1)) {
						$name = $list->name;
						$filelist = $list->file;
					}
				} else {
					if($list->type == "일반" && $list->num == $q) {
						$name = $list->name;
						$filelist = $list->file;
					}
				}
			}
		}
	}
	
	if($q == 1001) {
		$filelist = ['startavg/Start0','startavg/Start1','startavg/Start2','startavg/Start3','startavg/Start4','startavg/Start5','startavg/Start6','startavg/Start7','startavg/Start8','startavg/Start9','startavg/Start10','startavg/Start11',];
		$fieldname = L::story_prologue;
	} else if($q == 1002) {
		$filelist = ['battleavg/-18-Day3-6B','battleavg/-18-Day3-6C'];
		$fieldname = L::story_prologue;
	} else if(strpos($q, 'va11') !== false) {
    $num = str_replace('va11-', '', $q);
    $filelist = ['va11/va11_' . $num];
    $fieldname = '발할라 콜라보';
    $name = '카페스토리';
    $div = ['va11', $num];
  }
	
	$files = [];
	foreach($filelist as $filename) {
		array_push($files, json_decode(file_get_contents("story_json".$langdir.$filename.".txt")));
	}
	
	$q = substr($q, 1);
	
	if(!sizeof($files)) {
		exit("badinput");
	}
	
	$header_desc = $fieldname . ", " . $name . ", " . $div[0] . "-" . $div[1];
	$header_title = "$fieldname - $name ({$div[0]}-{$div[1]}) | " . L::sitetitle_short;
	require_once("header.php");
	
	$bg = 0;
	
	$second_round = [["-19-2-4-Point6737", "-19-2-4-point6738"], ["-19-2-4-Point6737", "battleavg/-19-2-egg"], ["-19-3-4-point6750", "-19-3-4-point7023"], ["-19-3-4-point6750", "battleavg/-19-3-egg"], ["-20-1-4-point6780", "-20-1-4-point7026"], ["-20-1-4-point6780", "battleavg/-20-1-egg"], ["-20-2-4-point6819", "-20-2-4-point7029"], ["-20-2-4-point6819", "battleavg/-20-2-egg"], ["-20-3-4-point6845", "-20-3-4-point6846"], ["-20-3-4-point6845", "battleavg/-20-3-egg"]];
?>
    <main role="main" class="container">
	<div class="col-12 my-3 p-3 bg-white rounded box-shadow">
		<input type="checkbox" id="storyimg_btn"><label for="storyimg_btn"><?=L::story_textonly?></label>&nbsp;
		<?php 
			foreach($second_round as $val) {
				if(strpos($val[0], $_GET['q']) === 0) { ?>
					<input type="checkbox" id="second_round_btn"><label for="second_round_btn"><?=L::story_secondround?></label>
		<?php break;
				}
			} ?>
	</div>
	<?php foreach($files as $key => $file) {
				$issecond = "";
				for($i = 0 ; $i <= sizeof($second_round)-1 ; $i++) {
					if($filelist[$key] == $second_round[$i][0]) $issecond = "second_round first";
					else if($filelist[$key] == $second_round[$i][1]) $issecond = "second_round second"; }?>
		<div class="col-12 my-3 p-3 bg-white rounded box-shadow <?=$issecond?>">
        <h6 class="border-bottom border-gray pb-2 mb-0"><?=$fieldname?>-<?=$div[1]?> &nbsp;<b><?=$name?></b> (<?=$key+1;?>)</h6>
        <div class="text-muted pt-3">
		<?php foreach($file as $line) { 
					if(isset($line->bg)) {
						$bg = $line->bg;
					}
					if($bg != "0") {
					//if($bg != "0" && $bg != "9" && $bg != "10") {
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
	  <?php } ?>
	  
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
	</body>
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
</html>