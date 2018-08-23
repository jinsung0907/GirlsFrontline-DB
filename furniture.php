<?php
	define("GF_HEADER", "aaaaa");
	require_once("common.php");
	
	if(empty($_GET['id'])) { header("Location: http://gfl.zzzzz.kr/furnitures.php"); exit();}
	$id = $_GET['id'];
	
	$furniture = json_decode(file_get_contents("data/furniture.json"));
	$furniture_txt = explode(PHP_EOL, file_get_contents("data/furniture.txt"));
	
	$furn = [];
	foreach($furniture as $data) {
		if($data->classes == $id) {
			foreach($furniture_txt as $key=>$line) {
				$query = $data->name;
				if(substr($line, 0, strlen($query)) === $query) {
					$name = str_replace('//c', ',', str_replace($query . ',', '', $line));
					$desc = str_replace('//c', ',', str_replace($data->description . ',', '', $furniture_txt[$key+1]));
					$data->name = str_replace('//n', '<br>', $name);
					$data->desc = str_replace('//n', '<br>', $desc);
					break;
				}
			}
			
			$images;
			$imgs = explode(',', $data->code);
			if(sizeof($imgs) == 1) 
				$images = '<img style="width:25vh;" src="img/furniture/' . $data->code . '.png">';
			else 
				$images = '<img style="width:25vh;" src="img/furniture/' . $imgs[0] . '.png"><img style="width:25vh;" src="img/furniture/' . $imgs[1] . '.png">';
			$data->imgtag = $images;
			array_push($furn, $data);
		}
	}
	
	/*
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
	*/
	require_once("header.php");
?>
    <main role="main" class="container">
		<?php
		foreach($furn as $data) {
		?>
		<div class="my-3 p-3 bg-white rounded box-shadow"> 
			<div class="row">
				<div class="col-mg-4 mb-2">
					<?=$data->imgtag?>
				</div>
				<div class="col-lg-8 mt-2">
					<h4 class="text-dark" style="display: inline;margin-right:10px"><?=$data->name?></h4>
					<div class="media text-muted pt-3">
						<p class="media-body pb-3 mb-0 small lh-125 ">
							<?=$data->desc?><br><br>
							안락도 <span class="txthighlight">+<?=$data->deco_rate?></span>
						</p>
						
					</div>
				</div>
			</div>
		</div>
	<?php } ?>
    </main>
<?php
	require_once("footer.php");
?>
	</body>
</html>