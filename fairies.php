<?php
	define("GF_HEADER", "aaaaa");
	require_once("common.php");
	
	$header_title = "소전DB 요정리스트 | 소전DB";
	$header_desc = "소전DB 요정 목록입니다.";
	$header_keyword = "소녀전선 요정 목록, 소녀전선 요정 리스트, 소녀전선 추천요정";
	require_once("header.php");
	$fairies = json_decode(file_get_contents("data/fairy.json"));
?>
	<style>
		@import url("//fonts.googleapis.com/earlyaccess/nanumgothic.css");
		.portrait_name { font-family:"Nanum Gothic", sans-serif !important; }
	</style>
    <main role="main" class="container">
		<div class="my-3 p-3 bg-white rounded box-shadow">
			<?=L::database_buildtime?> : <input type="number" id="buildtime" /> <?=L::database_buildltime_ex?><br>
			<?=L::database_name?> : <input type="text" id="dollname" /><br><br>
			<div class="fairyindex row">
			<?php
				foreach($fairies as $fairy) {
					$imgsrc = $fairy->name . "_3"; 
					if($lang == 'en') 
						$fairyname = ucfirst($fairy->name) . " Fairy";
					else if($lang == 'ja') {
						$voices = explode(PHP_EOL, file_get_contents("data/fairy_$lang.txt"));
						$i = 0;
						foreach($voices as $data) {
							$tmp = explode(',', $data);
							$tmp[0] = str_replace('fairy-', '', $tmp[0]);
							if($fairy->id == $tmp[0] % 10000000) {
								$fairyname = str_replace('//c', ',', explode(",", $voices[$i])[1]);
								break;
							}
							$i++;
						}
					}
					else 
						$fairyname = isset($fairy->krName)?$fairy->krName:$fairy->name;
					?>
				<a href="fairy.php?id=<?=$fairy->id?>" class="fairyindex item" data-name='<?=getFairyName($fairy)?>' data-buildtime='<?=gmdate("Gi", $fairy->buildTime)?>'>
					<i class="portrait fairy" style="background-image: url('img/fairy/<?=$imgsrc?>.png');" ></i>
					<div class="portrait_name pt-2 pb-2"><?=$fairyname?></div>
				</a><?php } ?>
			</div>
		</div>
    </main>
<?php
	require_once("footer.php");
?>
	<script>
	$.extend($.expr[":"], {
		"containsIN": function(elem, i, match, array) {
			return (elem.textContent || elem.innerText || "").toLowerCase().indexOf((match[3] || "").toLowerCase()) >= 0;
		}
	});

	$('#dollname').on('input',function(){
		$("a.fairyindex.item").hide();
		var val = $("#dollname").val();
		$("a.fairyindex.item>.portrait_name:containsIN("+val+")").parent().show();
	});

	$('#buildtime').on('input',function(){
		$("a.fairyindex.item").hide();
		var val = $("#buildtime").val();
		$("a.fairyindex.item[data-buildtime*='"+val+"']").show();
	});
	</script>
	</body>
</html>