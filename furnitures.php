<?php
	define("GF_HEADER", "aaaaa");
	require_once("common.php");
	$furniture_class = getJson('furniture_class');
	$furniture_txt = explode(PHP_EOL, getDataFile("furniture_classes", 'ko'));

	$furn = [];
	foreach($furniture_class as $i=>$data) {
		$bonus = '';
		$bonus_cnt = '';
		$bonus_cnt1 = '';
		
		if($data->k_bonus != '' && $data->k_bonus != 0) {
			$bonusdat = explode(',', $data->k_bonus);
			
			foreach($bonusdat as $dat) {
				$tmp = explode(':', $dat);
				$bonus_cnt .= $tmp[0] . ', ';
				$bonus_cnt1 .= $tmp[1] . ', ';
			}
			$data->bonus = L::database_furniture_set_bonus(substr($bonus_cnt, 0, -2), substr($bonus_cnt1, 0, -2));
		}
		
		foreach($furniture_txt as $key=>$line) {
			$query = $data->name;
			if(substr($line, 0, strlen($query)) === $query) {
				$data->rname = str_replace('//n', '', str_replace('//c', ',', str_replace($query . ',', '', $line)));
				$data->rdesc = str_replace('//n', '', str_replace('//c', ',', str_replace($data->description . ',', '', $furniture_txt[$key+1])));
				break;
			}
		}
		array_push($furn, $data);
	}
		
	if($lang != 'ko') {
		$furniture_txt = explode(PHP_EOL, getDataFile("furniture_classes", $lang));
		
		foreach($furn as $i=>$data) {
			foreach($furniture_txt as $key=>$line) {
				$query = $data->name;
				if(substr($line, 0, strlen($query)) === $query) {
					$furn[$i]->rname = str_replace('//n', '<br>', str_replace('//c', ',', str_replace($query . ',', '', $line)));
					$furn[$i]->rdesc = str_replace('//n', '<br>', str_replace('//c', ',', str_replace($data->description . ',', '', $furniture_txt[$key+1])));
					break;
				}
			}
		}
	}

	require_once("header.php");
?>
    <main role="main" class="container">
		<?php
		foreach($furn as $data) {
		?>
		<a href="furniture.php?id=<?=$data->id?>" style="text-decoration:none">
			<div class="my-3 p-3 bg-white rounded box-shadow"> 
				<div class="row">
					<div class="col-mg-4">
						<img src="img/furniture/icon/<?=$data->code?>.png">
					</div>
					<div class="col-lg-8">
						<h2 class="text-dark" style="display: inline;margin-right:10px;"><?=$data->rname?></h2>
						<div class="media text-muted pt-3">
							<p class="media-body pb-3 mb-0 small lh-125 ">
								<?=$data->rdesc?><br><br>
								<?=L::grade?> : <?=gunrank_to_img($data->rank)?><br>
								<?=$data->bonus?>
							</p>
						</div>
					</div>
				</div>
			</div>
		</a>
	<?php } ?>
    </main>
<?php
	require_once("footer.php");
?>
	</body>
</html>