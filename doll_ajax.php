<?php
  $id = $_GET['id'];
  if(!is_numeric($id)) {
    exit;
  }
  
  //캐시 파일이 있는지 확인, 있으면 캐시파일이 일주일이 지나지 않았는지 확인
  if(file_exists("cache/$id.json") && (time() - filemtime("cache/$id.json")) < 604800) {
    //맞으면 캐시파일 불러옴
    $data = json_decode(file_get_contents("cache/$id.json"), TRUE);
  }
  
  //없거나 캐시파일이 하루 지났으면
  else {
    $db = new SQLite3("../mosu_ja.db"); 
    $id = $db->escapeString($_GET['id']);
    $buildresult = $db->query("SELECT mp, ammo, mre, part, count(id) as cnt FROM mosu_gun where gun_id = $id group by `mp`, `ammo`, `mre`, `part` order by `cnt` desc");
    $data = [];
    while($row = $buildresult->fetchArray(SQLITE3_ASSOC)) {
      array_push($data, $row);
    }
	}
  
  $cnt = 0;
  foreach($data as $row) {
    $cnt = $cnt + $row['cnt'];
  }
  if($cnt == 0)
    exit;
  
  //캐시파일 저장
  file_put_contents("cache/$id.json", json_encode($data), JSON_UNESCAPED_UNICODE);
?>
<?php foreach($data as $row) {
if($row['cnt'] < 10) break;
$row['percent'] = $row['cnt'] / $cnt * 100; ?>

<tr style="text-align:center; vertical-align:middle">
	<td><?=$row['mp']?></td>
	<td><?=$row['ammo']?></td>
	<td><?=$row['mre']?></td>
	<td><?=$row['part']?></td>
	<td><?=printf("%.1f", $row['percent'])?>%</td>
</tr>
<?php } ?>