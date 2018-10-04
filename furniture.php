<?php
	define("GF_HEADER", "aaaaa");
	require_once("common.php");
	
	if(empty($_GET['id'])) { header("Location: http://gfl.zzzzz.kr/furnitures.php"); exit();}
	$id = $_GET['id'];
	
	$furniture = getJson('furniture');
	$furniture_txt = explode(PHP_EOL, getDataFile('furniture', 'ko'));
	
	$furn = [];
	foreach($furniture as $data) {
		if($data->classes == $id) {
			foreach($furniture_txt as $key=>$line) {
				$query = $data->name;
				if(substr($line, 0, strlen($query)) === $query) {
					$data->rname = str_replace('//n', '<br>', str_replace('//c', ',', str_replace($query . ',', '', $line)));
					$data->rdesc = str_replace('//n', '<br>', str_replace('//c', ',', str_replace($data->description . ',', '', $furniture_txt[$key+1])));
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
	
	if($lang != 'ko') {
		$furniture_txt = explode(PHP_EOL, getDataFile('furniture', $lang));
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
    
    
    
    //제목설정위해 불러옴
    $header_title;
    $header_desc;
    $header_image;
    $furniture_class = getJson('furniture_class');
	$furniture_txt = explode(PHP_EOL, getDataFile("furniture_classes", 'ko'));
    foreach($furniture_class as $i=>$data) {
        if($data->id == $id) {
            foreach($furniture_txt as $key=>$line) {
                $query = $data->name;
                if(substr($line, 0, strlen($query)) === $query) {
                    $header_title = str_replace('//n', '', str_replace('//c', ',', str_replace($query . ',', '', $line)));
                    $header_desc = str_replace('//n', '', str_replace('//c', ',', str_replace($data->description . ',', '', $furniture_txt[$key+1])));
                    $header_image = "http://gfl.zzzzz.kr/img/furniture/icon/" . $data->code . ".png";
                    break;
                }
            }
        }
    }
    if($lang != 'ko') {
		$furniture_txt = explode(PHP_EOL, getDataFile("furniture_classes", $lang));
		
		foreach($furniture_class as $i=>$data) {
            if($data->id == $id) {
                foreach($furniture_txt as $key=>$line) {
                    $query = $data->name;
                    if(substr($line, 0, strlen($query)) === $query) {
                        $header_title = str_replace('//n', '', str_replace('//c', ',', str_replace($query . ',', '', $line)));
                        $header_desc = str_replace('//n', '', str_replace('//c', ',', str_replace($data->description . ',', '', $furniture_txt[$key+1])));
                        $header_image = "http://gfl.zzzzz.kr/img/furniture/icon/" . $data->code . ".png";
                        break;
                    }
                }
            }
		}
	}
    
    $header_keyword = "소녀전선 가구목록, $header_title 가구 목록, $header_title 가구 리스트";
    $header_title = $header_title . " 가구 | " . L::sitetitle_short;
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
					<h4 class="text-dark" style="display: inline;margin-right:10px"><?=$data->rname?></h4>
					<div class="media text-muted pt-3">
						<p class="media-body pb-3 mb-0 small lh-125 ">
							<?=$data->rdesc?><br><br>
							<?=L::database_furniture_comfort?> <span class="txthighlight">+<?=$data->deco_rate?></span>
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