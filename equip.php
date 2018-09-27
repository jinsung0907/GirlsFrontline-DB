<?php
	define("GF_HEADER", "aaaaa");
	require_once("common.php");
	
	$header_desc = "소녀전선 장비목록입니다.";
	$header_keyword = "소녀전선 장비 목록, 소녀전선 장비 리스트, 소녀전선 추천장비";
	$header_title = "소전DB 장비리스트	| 소전DB";
	require_once("header.php");
	
	$equips = getJson("equip");
	
	$equip_data = explode(PHP_EOL, getDataFile("equip", 'ko'));
	
	for($i = 0 ; $i < sizeof($equip_data) ; $i+=3) {
		$exp = explode(',', $equip_data[$i]);
		$id = str_replace('equip-', '', $exp[0]) % 10000000;
		$name = str_replace('//c', ',', $exp[1]);
		$attr = str_replace('//c', ',', explode(',', $equip_data[$i+1])[1]);
		$desc = str_replace('//c', ',', explode(',', $equip_data[$i+2])[1]);
		
		for($j = 0 ; $j < sizeof($equips) ; $j++) {
			if($equips[$j]->id == $id) {
				foreach($equips[$j]->stats as $key=>$val) {
					$max = '';
					if(isset($val->amp) && $val->maxlevel !== 0)
						$max = "(" . floor($val->max * $val->amp) . ")";
					
					$value = "{$val->min}~{$val->max}";
					if($val->min == $val->max)
						$value = $val->min;
						
					$attr = str_replace("<" . $key . ">", "<span class='txthighlight'>$value$max</span>", $attr);
				}
				
				$equips[$j]->attr = str_replace("$", "<br>", str_replace("\\n", '', $attr));
				$equips[$j]->desc = $desc;
				break;
			}
		}
	}
	
	if($lang != 'ko') {
		$equip_data = explode(PHP_EOL, getDataFile("equip", $lang));
		
		for($i = 0 ; $i < sizeof($equip_data) ; $i+=3) {
			$exp = explode(',', $equip_data[$i]);
			$id = str_replace('equip-', '', $exp[0]) % 10000000;
			$name = str_replace('//c', ',', $exp[1]);
			$attr = str_replace('//c', ',', explode(',', $equip_data[$i+1])[1]);
			$desc = str_replace('//c', ',', explode(',', $equip_data[$i+2])[1]);			
			
			for($j = 0 ; $j < sizeof($equips) ; $j++) {
				if($equips[$j]->id == $id) {
					foreach($equips[$j]->stats as $key=>$val) {
						$max = '';
						if(isset($val->amp) && $val->maxlevel !== 0)
							$max = "(" . floor($val->max * $val->amp) . ")";
						
						$value = "{$val->min}~{$val->max}";
						if($val->min == $val->max)
							$value = $val->min;
							
						$attr = str_replace("<" . $key . ">", "<span class='txthighlight'>$value$max</span>", $attr);
					}
					
					$equips[$j]->attr = str_replace("$", "<br>", str_replace("\\n", '', $attr));
					$equips[$j]->desc = $desc;
					break;
				}
			}
		}
	}
?>
	<style>
		@import url("//fonts.googleapis.com/earlyaccess/nanumgothic.css");
		.portrait_name { font-family:"Nanum Gothic", sans-serif !important; }
	</style>
    <main role="main" class="container">
		<div class="my-3 p-3 bg-white rounded box-shadow">
			<div class="equipindex row">
			<?php
				foreach($equips as $equip) {
					$equipname = $equip->krName;
					if($lang == 'en' && $equip->enName != "") 
						$equipname = $equip->enName;
					else if($lang == 'ja' && $equip->jpName != "") 
						$equipname = $equip->jpName;
					
					?>
				<a href="#" class="equipindex item rank<?=$equip->rank?>" data-name='<?=$equipname?>' data-buildtime='<?=gmdate("Gi", $equip->buildTime)?>' data-toggle="modal" data-target="#equipmodal_<?=$equip->id?>">
					<i class="portrait equip" style="background-image: url('img/equip/<?=$equip->code?>.png');" ></i>
					<div class="portrait_name pt-2 pb-2"><?=$equipname?></div>
				</a><?php } ?>
			</div>
		</div>
    </main>
	
<?php
	foreach($equips as $equip) { 
		$equipname = $equip->krName;
		if($lang == 'en' && $equip->enName != "") 
			$equipname = $equip->enName;
		else if($lang == 'ja' && $equip->jpName != "") 
			$equipname = $equip->jpName;
		
		$buildtime = '';
		$buildTime = gmdate("H:i", $equip->buildTime);
		if(!$equip->buildTime) $buildTime = '';
		$cp = $equip->company;
		if($cp !== "BM" && $cp !== "EOT" && $cp !== "AMP" && $cp !== "IOP" && $cp !== "PMC" && $cp !== "AC" && $cp !== "ILM") $buildTime = '';
		if(isset($equip->fitgun)) $buildTime = '';
		
	?>
	<div class="modal fade" id="equipmodal_<?=$equip->id?>" tabindex="-1" role="dialog">
		<div class="modal-dialog modal-dialog-centered modal-lg" role="document">
			<div class="modal-content">
				<div class="modal-body">
					<div class="container-fluid">
						<div class="row">
							<div class="col-lg-4">
								<img style="width:100%" src="img/equip/<?=$equip->code?>.png">
							</div>
							<div class="col-lg-8">
								<h2 style="display: inline"><b><?=$equipname?></b> </h2><h5 style="display: inline" class="text-muted"><?=$buildTime?></h5>
								<hr class="mt-1 mb-1">
								<span class="text-muted">
									<?=$equip->desc?>
									<hr class="mt-1 mb-1">
									<?=$equip->attr?>
								</span>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<?php } ?>
<?php
	require_once("footer.php");
?>
	</script>
	</body>
</html>