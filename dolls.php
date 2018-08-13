<?php
	define("GF_HEADER", "aaaaa");
	require_once("common.php");
	
	$header_title = L::title_dolls . " | " . L::sitetitle_short;
	$header_desc = L::title_dolls_desc;
	$header_keyword = "소녀전선 인형 목록, 소녀전선 인형 리스트, 소녀전선 추천인형, 소녀전선 SD, 소녀전선 보이스";
	require_once("header.php");
	$dolls = json_decode(file_get_contents("data/doll.json"));
?>	
	<style>
		@import url("//fonts.googleapis.com/earlyaccess/nanumgothic.css");
			.portrait_name { font-family:"Nanum Gothic", sans-serif !important; }
	</style>
    <main role="main" class="container">
		<div class="my-3 p-3 bg-white rounded box-shadow">
			<input class="checkbox" type="checkbox" id="damaged"><label for="damaged"><?=L::database_viewdamaged?></label><br>
			<input class="checkbox" type="checkbox" id="rank2_btn" name="rank"><label for="rank2_btn"><?=L::database_2star?></label>
			<input class="checkbox" type="checkbox" id="rank3_btn" name="rank"><label for="rank3_btn"><?=L::database_3star?></label>
			<input class="checkbox" type="checkbox" id="rank4_btn" name="rank"><label for="rank4_btn"><?=L::database_4star?></label>
			<input class="checkbox" type="checkbox" id="rank5_btn" name="rank"><label for="rank5_btn"><?=L::database_5star?></label>
			<input class="checkbox" type="checkbox" id="rank1_btn" name="rank"><label for="rank1_btn">SP</label><br>
			<input class="checkbox" type="checkbox" id="type_ar_btn" name="type"><label for="type_ar_btn">AR</label>
			<input class="checkbox" type="checkbox" id="type_smg_btn" name="type"><label for="type_smg_btn">SMG</label>
			<input class="checkbox" type="checkbox" id="type_rf_btn" name="type"><label for="type_rf_btn">RF</label>
			<input class="checkbox" type="checkbox" id="type_sg_btn" name="type"><label for="type_sg_btn">SG</label>
			<input class="checkbox" type="checkbox" id="type_hg_btn" name="type"><label for="type_hg_btn">HG</label>
			<input class="checkbox" type="checkbox" id="type_mg_btn" name="type"><label for="type_mg_btn">MG</label>
			<br>
			<?=L::database_buildtime?> : <input type="number" id="buildtime" /> <?=L::database_buildltime_ex?><br>
			<?=L::database_name?> : <input type="text" id="dollname" /><br><br>
			<div class="dollindex row">
			<?php
				foreach($dolls as $doll) {
					$imgsrc = $doll->name . "/pic/pic_" . $doll->name . "_n";
					$dollname = getDollName($doll);
					?>
				<a href="doll.php?id=<?=$doll->id?>" class="dollindex item rank<?=$doll->rank?>" data-rank='<?=$doll->rank?>' data-type='<?=$doll->type?>' data-name='<?=getDollName($doll)?>' data-buildtime='<?=isset($doll->buildTime)?gmdate("Gi", $doll->buildTime):''?>'>
					<i class="rankbar"></i>
					<div class="starrank">
						<img src="img/type/<?=strtoupper($doll->type)?><?=$doll->rank?>.png" class="typeicon">
					</div>
					<i class="portrait" data-src='img/characters/<?=$imgsrc?>.jpg' ></i>
					<div class="portrait_name pt-2 pb-2"><?=$dollname?></div>
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
            beforeLoad: function(e) {
				console.log('a');
                e[0].append($('<img>', { src: 'img/load.gif', class: 'loader' })[0]);
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
			$(".portrait:visible").lazy({
				effect: 'fadeIn',
				beforeLoad: function(e) {
					console.log('a');
					e[0].append($('<img>', { src: 'img/load.gif', class: 'loader' })[0]);
				},
				afterLoad: function(e) {
					e.empty();
				}
			});
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
			$(".portrait:visible").lazy({
				effect: 'fadeIn',
				beforeLoad: function(e) {
					console.log('a');
					e[0].append($('<img>', { src: 'img/load.gif', class: 'loader' })[0]);
				},
				afterLoad: function(e) {
					e.empty();
				}
			});
		});
		
		$('#buildtime').on('input',function(){
			$("a.dollindex.item").hide();
			var val = $("#buildtime").val();
			$("a.dollindex.item[data-buildtime*='"+val+"']").show();
			$(".portrait:visible").lazy({
				effect: 'fadeIn',
				beforeLoad: function(e) {
					e[0].append($('<img>', { src: 'img/load.gif', class: 'loader' })[0]);
				},
				afterLoad: function(e) {
					e.empty();
				}
			});
		});
	</script>
	</body>
</html>