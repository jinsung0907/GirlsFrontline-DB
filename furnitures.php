<?php
	define("GF_HEADER", "aaaaa");
	require_once("common.php");
	$furniture_class = json_decode(file_get_contents("data/furniture_class.json"));
	$furniture_txt = explode(PHP_EOL, file_get_contents("data/furniture_classes.txt"));
	require_once("header.php");
	
	function getInfo($data) {
		global $furniture_txt;

		foreach($furniture_txt as $key=>$line) {
			$query = $data->name;
			if(substr($line, 0, strlen($query)) === $query) {
				$name = str_replace('//c', ',', str_replace($query . ',', '', $line));
				$desc = str_replace('//c', ',', str_replace($data->description . ',', '', $furniture_txt[$key+1]));
				return [$name, $desc];
			}
		}
	}
?>
    <main role="main" class="container">
		<?php
		foreach($furniture_class as $data) {
			$sdata = getInfo($data);
			$bonus = '';
			$bonus_cnt = '';
			$bonus_cnt1 = '';
			if($data->k_bonus != '') {
				$bonusdat = explode(',', $data->k_bonus);
				
				foreach($bonusdat as $dat) {
					$tmp = explode(':', $dat);
					$bonus_cnt .= $tmp[0] . ', ';
					$bonus_cnt1 .= $tmp[1] . ', ';
				}
				$bonus = "세트가구를 " . substr($bonus_cnt, 0, -2) . "개 배치하여 " . substr($bonus_cnt1, 0, -2) . "의 안락도를 추가획득";
			}
		?>
		<a href="furniture.php?id=<?=$data->id?>">
			<div class="my-3 p-3 bg-white rounded box-shadow"> 
				<div class="row">
					<div class="col-mg-4">
						<img src="img/furniture/icon/<?=$data->code?>.png">
					</div>
					<div class="col-lg-8">
						<h2 class="text-dark" style="display: inline;margin-right:10px"><?=$sdata[0]?></h2>
						<div class="media text-muted pt-3">
							<p class="media-body pb-3 mb-0 small lh-125 ">
								<?=$sdata[1]?><br><br>
								등급 : <?=gunrank_to_img($data->rank)?><br>
								<?=$bonus?>
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