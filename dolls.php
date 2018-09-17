<?php
	define("GF_HEADER", "aaaaa");
	require_once("common.php");
	
	$header_title = L::title_dolls . " | " . L::sitetitle_short;
	$header_desc = L::title_dolls_desc;
	$header_keyword = "소녀전선 인형 목록, 소녀전선 인형 리스트, 소녀전선 추천인형, 소녀전선 SD, 소녀전선 보이스";
	require_once("header.php");
	$dolls = getJson('doll');
	
	$live2dlist = [];
	foreach(array_slice(scandir("img/live2d"), 2) as $dir) {
		$exp = explode('_', $dir);
		array_push($live2dlist, $exp[0]);
	}
	array_unique($live2dlist);
?>	
	<style>
		@import url("//fonts.googleapis.com/earlyaccess/nanumgothic.css");
			.portrait_name { font-family:"Nanum Gothic", sans-serif !important; }
	</style>
    <main role="main" class="container">
		<div class="my-3 p-3 bg-white rounded box-shadow">
			<input class="checkbox" type="checkbox" id="damaged"><label for="damaged"><?=L::database_viewdamaged?></label>
			<input class="checkbox" type="checkbox" id="live2d"><label for="live2d">Live2D</label>
			<br>
			<input class="checkbox" type="checkbox" id="rank2_btn" name="rank"><label for="rank2_btn"><?=L::database_2star?></label>
			<input class="checkbox" type="checkbox" id="rank3_btn" name="rank"><label for="rank3_btn"><?=L::database_3star?></label>
			<input class="checkbox" type="checkbox" id="rank4_btn" name="rank"><label for="rank4_btn"><?=L::database_4star?></label>
			<input class="checkbox" type="checkbox" id="rank5_btn" name="rank"><label for="rank5_btn"><?=L::database_5star?></label>
			<input class="checkbox" type="checkbox" id="rank1_btn" name="rank"><label for="rank1_btn">SP</label>
			<br>
			<input class="checkbox" type="checkbox" id="type_ar_btn" name="type"><label for="type_ar_btn">AR</label>
			<input class="checkbox" type="checkbox" id="type_smg_btn" name="type"><label for="type_smg_btn">SMG</label>
			<input class="checkbox" type="checkbox" id="type_rf_btn" name="type"><label for="type_rf_btn">RF</label>
			<input class="checkbox" type="checkbox" id="type_sg_btn" name="type"><label for="type_sg_btn">SG</label>
			<input class="checkbox" type="checkbox" id="type_hg_btn" name="type"><label for="type_hg_btn">HG</label>
			<input class="checkbox" type="checkbox" id="type_mg_btn" name="type"><label for="type_mg_btn">MG</label>
			<br>
			<input class="checkbox" type="checkbox" id="buff_pow" name="buff"><label for="buff_pow"><?=L::database_buff_pow?></label>
			<input class="checkbox" type="checkbox" id="buff_rate" name="buff"><label for="buff_rate"><?=L::database_buff_rate?></label>
			<input class="checkbox" type="checkbox" id="buff_dodge" name="buff"><label for="buff_dodge"><?=L::database_buff_dodge?></label>
			<input class="checkbox" type="checkbox" id="buff_hit" name="buff"><label for="buff_hit"><?=L::database_buff_hit?></label>
			<input class="checkbox" type="checkbox" id="buff_cd" name="buff"><label for="buff_cd"><?=L::database_buff_cooldown?></label>
			<input class="checkbox" type="checkbox" id="buff_crit" name="buff"><label for="buff_crit"><?=L::database_buff_crit?></label>
			<input class="checkbox" type="checkbox" id="buff_armor" name="buff"><label for="buff_armor"><?=L::database_buff_armor?></label>
			<br>
			<?=L::database_buildtime?> : <input type="number" id="buildtime" / placeholder="<?=L::database_buildltime_ex?>"><br>
			<?=L::database_name?> : <input type="text" id="dollname" /><br><br>
			<div class="dollindex row">
			<?php
				foreach($dolls as $doll) {
					$imgsrc = $doll->name . "/pic/pic_" . $doll->name . "_n";
					$dollname = getDollName($doll);
					
					$buff = '';
					foreach($doll->effect->gridEffect as $key => $eff) {
						switch($key) {
							case "pow": $buff .= '1'; break;
							case "rate": $buff .= '2'; break;
							case "dodge": $buff .= '3'; break;
							case "hit": $buff .= '4'; break;
							case "cooldown": $buff .= '5'; break;
							case "crit": $buff .= '6'; break;
							case "armor": $buff .= '7'; break;
						}
					}
					
					$live2d = 0;
					foreach($live2dlist as $l2dlist) {
						if(strtolower($l2dlist) == strtolower($doll->name)) {
							$live2d = 1;
							break;
						}
					}
					
					
					//제조가 안되는 인형에도 제조시간이 붙어있으므로 obtain값을 이용하여 제거해야함
					$exp = explode(',', $doll->drop);
					$chk = false;
					foreach($exp as $ex) {
						if($ex == 1 || $ex == 2)
							$chk = true;
					}
					if($chk == false) 
						$doll->buildTime = 0;
					
					if($doll->id >= 1000 && $doll->id <= 2000)
						$doll->rank = 1;
					?>
				<a href="doll.php?id=<?=$doll->id?>" class="dollindex item rank<?=$doll->rank?>" data-id='<?=$doll->rank?>' data-rank='<?=$doll->rank?>' data-type='<?=$doll->type?>' data-name='<?=getDollName($doll)?>' data-buildtime='<?=isset($doll->buildTime)?gmdate("Gi", $doll->buildTime):''?>' data-buff='<?=$buff?>' data-l2d='<?=$live2d?>'>
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
		
		$('#live2d,input:checkbox[name="rank"],input:checkbox[name="type"],input:checkbox[name="buff"]').on('click', function() {
			apply_filter();
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
		
		function apply_filter() {
			var rankcnt = 0;
			var typecnt = 0;
			var buffcnt = 0;
			var l2dcnt = 0;
			var rank = [];
			var type = [];
			var rankselector = '';
			var typeselector = '';
			var buffselector = '';
			var l2dselector = '';
			
			if($("#live2d").prop("checked") === true) {
				l2dselector += ",[data-l2d=0]";
				l2dcnt++;
			} 
			
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
			
			if($("#buff_pow").prop("checked") === false) {
				buffselector += ',[data-buff*="1"]';
			} else buffcnt++;
			if($("#buff_rate").prop("checked") === false) {
				buffselector += ',[data-buff*="2"]';
			} else buffcnt++;
			if($("#buff_dodge").prop("checked") === false) {
				buffselector += ',[data-buff*="3"]';
			} else buffcnt++;
			if($("#buff_hit").prop("checked") === false) {
				buffselector += ',[data-buff*="4"]';
			} else buffcnt++;
			if($("#buff_cd").prop("checked") === false) {
				buffselector += ',[data-buff*="5"]';
			} else buffcnt++;
			if($("#buff_crit").prop("checked") === false) {
				buffselector += ',[data-buff*="6"]';
			} else buffcnt++;
			if($("#buff_armor").prop("checked") === false) {
				buffselector += ',[data-buff*="7"]';
			} else buffcnt++;
			
			
			if((rankcnt + typecnt + buffcnt + l2dcnt) !== 0) {
				$("a.dollindex.item").show();
				
				var selector = '';
				if(rankcnt !== 0) {
					selector += rankselector;
				}
				if(typecnt !== 0) {
					selector += typeselector;
				}
				if(buffcnt !== 0) {
					selector += buffselector;
				}
				if(l2dcnt !== 0) {
					selector += l2dselector;
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