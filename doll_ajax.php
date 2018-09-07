<?php
	$db = new SQLite3("../mosu_ja.db"); 
	$id = $db->escapeString($_GET['id']);
	$buildresult = $db->query("SELECT mp, ammo, mre, part, count(id) as cnt FROM mosu_gun where gun_id = $id group by `mp`, `ammo`, `mre`, `part` order by `cnt` desc");
	$cnt = 0;
	
	while($row = $buildresult->fetchArray()) {
		$cnt = $cnt + $row['cnt'];
	}
	if($cnt == 0)
		exit;
	
?>
<?php while($row = $buildresult->fetchArray()) {
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