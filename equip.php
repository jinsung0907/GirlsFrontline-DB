<?php
	define("GF_HEADER", "aaaaa");
	require_once("common.php");
	
	$header_desc = "소녀전선 장비 목록, 소녀전선 장비 리스트, 소녀전선 추천장비";
	$header_title = "소전DB 장비리스트	 | 소전DB";
	require_once("header.php");
	
	$equips = json_decode(file_get_contents("data/equip.json"));
?>
    <main role="main" class="container">
		<div class="my-3 p-3 bg-white rounded box-shadow">
			<table>
				<thead>
					<th>이름</th>
					<th>이름</th>
					<th>범주</th>
					<th>종류</th>
					<th>스탯</th>
				</thead>
				<tbody>
				<?php foreach($equips as $equip) { ?>
					<tr>
						<td></td>
						<td><?=$equip->name?></td>
						<td><?=$equip->category?></td>
						<td><?=$equip->type?></td>
						<td></td>
					</tr>
				<?php } ?>
				</tbody>
			</table>
		</div>
    </main>
<?php
	require_once("footer.php");
?>
	</body>
</html>