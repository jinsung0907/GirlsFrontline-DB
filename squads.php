<?php
	define("GF_HEADER", "aaaaa");
	require_once("common.php");
	
	$header_title = "소전DB 중장비부대 리스트 | 소전DB";
	$header_desc = "소전DB 중장비부대 리스트입니다.";
	$header_keyword = "소녀전선 중장비부대 목록, 소녀전선 중장비부대 리스트, 소녀전선 추천 중장비부대";
	require_once("header.php");
	$squads = json_decode(file_get_contents("data/squad.json"));
?>
	<style>
		@import url("//fonts.googleapis.com/earlyaccess/nanumgothic.css");
		.portrait_name { font-family:"Nanum Gothic", sans-serif !important; }
	</style>
    <main role="main" class="container">
		<div class="my-3 p-3 bg-white rounded box-shadow">
			<!-- 제조시간 : <input type="number" id="buildtime" /> ex) 8시간 10분-> 810, 0시간 53분->053<br>
			이름 : <input type="text" id="dollname" /><br><br> -->
			<div class="squadindex row">
			<?php
				foreach($squads as $squad) {
					$imgsrc = $squad->name;

					$fairyname = isset($squad->krName)?$squad->krName:$squad->name;
					?>
				<a href="squad.php?id=<?=$squad->id?>" class="squadindex item" data-name='<?=$squad->krName?>' data-buildtime='<?=gmdate("Gi", $fairy->buildTime)?>'>
					<i class="portrait squad" style="background-image: url('img/squads/<?=$imgsrc?>.png');" ></i>
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
		$("a.squadindex.item").hide();
		var val = $("#dollname").val();
		$("a.squadindex.item>.portrait_name:containsIN("+val+")").parent().show();
	});

	$('#buildtime').on('input',function(){
		$("a.squadindex.item").hide();
		var val = $("#buildtime").val();
		$("a.squadindex.item[data-buildtime*='"+val+"']").show();
	});
	</script>
	</body>
</html>