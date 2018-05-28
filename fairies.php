<?php
	define("GF_HEADER", "aaaaa");
	require_once("header.php");
	$fairies = json_decode(file_get_contents("data/fairy.json"));
?>
	<style>
		@import url("//fonts.googleapis.com/earlyaccess/nanumgothic.css" ) ;
body, h1, h2, h3, h4, h5, h6, li, p { font-family:"Nanum Gothic", sans-serif !important; }
	</style>
    <main role="main" class="container">
		<div class="my-3 p-3 bg-white rounded box-shadow">
			제조시간 : <input type="number" id="buildtime" /> ex) 8시간 10분-> 810, 0시간 53분->053<br>
			이름 : <input type="text" id="dollname" /><br><br>
			<div class="fairyindex row">
			<?php
				foreach($fairies as $fairy) {
					$imgsrc = $fairy->name . "_3"; 
					?>
				<a href="fairy.php?id=<?=$fairy->id?>" class="fairyindex item" data-name='<?=$fairy->krName?>' data-buildtime='<?=gmdate("Gi", $fairy->buildTime)?>'>
					<i class="portrait" style="background-image: url('img/fairy/<?=$imgsrc?>.png');" ></i>
					<div class="portrait_name pt-2 pb-2"><?=$fairy->krName?$fairy->krName:$fairy->name?></div>
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