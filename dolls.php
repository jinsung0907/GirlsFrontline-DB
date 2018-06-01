<?php
	define("GF_HEADER", "aaaaa");
	$header_title = "소전DB 인형리스트 | 소전DB";
	$header_desc = "소녀전선 인형 목록, 소녀전선 인형 리스트, 소녀전선 추천인형";
	require_once("header.php");
	$dolls = json_decode(file_get_contents("data/doll.json"));
?>	
	<style>
		@import url("//fonts.googleapis.com/earlyaccess/nanumgothic.css" ) ;
body, h1, h2, h3, h4, h5, h6, li, p { font-family:"Nanum Gothic", sans-serif !important; }
	</style>
    <main role="main" class="container">
		<div class="my-3 p-3 bg-white rounded box-shadow">
			<input class="checkbox" type="checkbox" id="damaged"><label for="damaged">중상보기</label><br>
			<input class="checkbox" type="checkbox" id="rank2_btn" name="rank"><label for="rank2_btn">2성</label>
			<input class="checkbox" type="checkbox" id="rank3_btn" name="rank"><label for="rank3_btn">3성</label>
			<input class="checkbox" type="checkbox" id="rank4_btn" name="rank"><label for="rank4_btn">4성</label>
			<input class="checkbox" type="checkbox" id="rank5_btn" name="rank"><label for="rank5_btn">5성</label>
			<input class="checkbox" type="checkbox" id="rank1_btn" name="rank"><label for="rank1_btn">SP</label><br>
			<input class="checkbox" type="checkbox" id="type_ar_btn" name="type"><label for="type_ar_btn">AR</label>
			<input class="checkbox" type="checkbox" id="type_smg_btn" name="type"><label for="type_smg_btn">SMG</label>
			<input class="checkbox" type="checkbox" id="type_rf_btn" name="type"><label for="type_rf_btn">RF</label>
			<input class="checkbox" type="checkbox" id="type_sg_btn" name="type"><label for="type_sg_btn">SG</label>
			<input class="checkbox" type="checkbox" id="type_hg_btn" name="type"><label for="type_hg_btn">HG</label>
			<input class="checkbox" type="checkbox" id="type_mg_btn" name="type"><label for="type_mg_btn">MG</label>
			<br>
			제조시간 : <input type="number" id="buildtime" /> ex) 8시간 10분-> 810, 0시간 53분->053<br>
			이름 : <input type="text" id="dollname" /><br><br>
			<div class="dollindex row">
			<?php
				foreach($dolls as $doll) {
					
					$imgsrc = $doll->id; 
					if($doll->id > 1000 && $doll->id < 2000) {
						$doll->rank = 1;
						$imgsrc = $doll->id; 
					}
					?>
				<a href="doll.php?id=<?=$doll->id?>" class="dollindex item rank<?=$doll->rank?>" data-rank='<?=$doll->rank?>' data-type='<?=$doll->type?>' data-name='<?=$doll->name?>' data-buildtime='<?=isset($doll->buildTime)?gmdate("Gi", $doll->buildTime):''?>'>
					<i class="rankbar"></i>
					<div class="starrank">
						<img src="img/type/<?=strtoupper($doll->type)?><?=$doll->rank?>.png" class="typeicon">
					</div>
					<i class="portrait" data-src='img/dolls/portraits/<?=$imgsrc?>.png' ></i>
					<div class="portrait_name pt-2 pb-2"><?=$doll->krName?$doll->krName:$doll->name?></div>
				</a><?php } ?>
			</div>
		</div>
    </main>
<?php
	require_once("footer.php");
?>
	<script>
		$(".portrait").lazy({
			effect: 'fadeIn',
			//placeholder: "img/load.gif",
			beforeLoad: function(e) {
				e.append('<img>', {
					src: "img/load.gif"
				});
			},
			afterLoad: function(e) {
				e.empty();
			}
		});
		$("a.dollindex.item").on("mouseover", function() {
			if($('#damaged').prop("checked") === true) {
				$(this).find("i.portrait").removeClass("damaged");
			} else {
				$(this).find("i.portrait").addClass("damaged");
			}
		});
		
		$("a.dollindex.item").on("mouseout", function() {
			if($('#damaged').prop("checked") === true) {
				$(this).find("i.portrait").addClass("damaged");
			} else {
				$(this).find("i.portrait").removeClass("damaged");
			}
		});
		
		$('[data-toggle="rankbuttons"] .btn').on('click', function () {
			// toggle style
			$(this).toggleClass('active');
			
			return false;
		});
		
		$('#damaged').on('click', function () {
			if($(this).prop("checked") === true) {
				$(".dollindex.row").find("i.portrait").addClass("damaged");
			}
			else if($(this).prop('checked') === false) {
				$(".dollindex.row").find("i.portrait").removeClass("damaged");
			}
		});
		
		$('input:checkbox[name="rank"],input:checkbox[name="type"]').on('click', function() {
			apply_filter();
		});
		
		function apply_filter() {
			var rankcnt = 0;
			var typecnt = 0;
			var rank = [];
			var type = [];
			var rankselector = '';
			var typeselector = '';
			for(var i = 1 ; i<= 5 ; i++) {
				if($("#rank" + i + "_btn").prop("checked") === false) {
					rankselector += ",[data-rank="+i+"]";
				} else rankcnt++;
			}
			if($("#type_ar_btn").prop("checked") === false) {
				typeselector += ",[data-type=ar]";

			} else typecnt++;
			if($("#type_rf_btn").prop("checked") === false) {
				typeselector += ",[data-type=rf]";

			} else typecnt++;
			if($("#type_hg_btn").prop("checked") === false) {
				typeselector += ",[data-type=hg]";

			} else typecnt++;
			if($("#type_mg_btn").prop("checked") === false) {
				typeselector += ",[data-type=mg]";

			} else typecnt++;
			if($("#type_sg_btn").prop("checked") === false) {
				typeselector += ",[data-type=sg]";

			} else typecnt++;
			if($("#type_smg_btn").prop("checked") === false) {
				typeselector += ",[data-type=smg]";

			} else typecnt++;
			
			if((rankcnt + typecnt) !== 0) {
				$("a.dollindex.item").show();
				
				var selector = '';
				if(rankcnt !== 0) {
					selector += rankselector;
				}
				if(typecnt !== 0) {
					selector += typeselector;
				}
				selector = selector.substring(1, selector.length);
				$(selector).hide();
			} else {
				$("a.dollindex.item").show();
			}
		}
		
		$.extend($.expr[":"], {
			"containsIN": function(elem, i, match, array) {
				return (elem.textContent || elem.innerText || "").toLowerCase().indexOf((match[3] || "").toLowerCase()) >= 0;
			}
		});
		
		$('#dollname').on('input',function(){
			$("a.dollindex.item").hide();
			var val = $("#dollname").val();
			$("a.dollindex.item>.portrait_name:containsIN("+val+")").parent().show();
		});
		
		$('#buildtime').on('input',function(){
			$("a.dollindex.item").hide();
			var val = $("#buildtime").val();
			$("a.dollindex.item[data-buildtime*='"+val+"']").show();
		});
	</script>
	</body>
</html>