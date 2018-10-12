<?php
	define("GF_HEADER", "aaaaa");
	require_once("common.php");
	require_once("header.php");
	require_once("dbconfig.php");
    
    if(ctype_digit($_GET['id'])) {
        $id = $_GET['id'];
    }
    else {
        exit("bad input");
    }
    $result = sql_query("select * from bbs where id = $id");
    $row = mysqli_fetch_array($result);
	
	$nick_icon = '';
	switch($row['idtype']) {
		case 1: $nick_icon = "<img src='img/fix_nik.gif'>"; break;
		case 2: $nick_icon = "<img src='img/nik.gif'>"; break;
	}
?>
    <style>
		.content {
			font-size:13px;
			line-height: 22px;
		}
		.content p {
			margin: 0;
			padding: 0;
			border: 0;
		}
        .content img {
            max-width: 100%;
        }
    </style>
    <main role="main" class="container">
		<div class="my-3 p-3 bg-white rounded box-shadow">
			<h4><?=$row['title']?></h4><small>글쓴이 : <?=$row['name']?><?=$nick_icon?>&nbsp;&nbsp;&nbsp;날짜 : <?=date("m/d H:i", $row['date'])?></small><br><hr>
            <span class="content">
			<small>원본 : <u><a href="<?=$row['orgurl']?>"><?=$row['orgurl']?></a></u></small>
            <?=$row['content']?>
            </span>
			<hr>
		</div>
    </main>
    
<?php
	require_once("footer.php");
?>
	</body>
</html>