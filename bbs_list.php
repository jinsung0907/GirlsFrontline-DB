<?php
	define("GF_HEADER", "aaaaa");
	require_once("common.php");
	require_once("header.php");
	require_once("dbconfig.php");
    
	if(isset($_POST['url'])) {
		$board; $no;
		
		$requesturl = $_POST['url'];
		$urls = parse_url($_POST['url']);
		if($urls === FALSE) exit('정확한 주소를 입력하세요');
		if($urls['host'] !== "gall.dcinside.com" && $urls['host'] !== "m.dcinside.com") exit ("정확한 주소를 입력하세요"); //호스트 거르기
		if(!isset($urls['query'])) { //쿼리가 아니라 /(슬래시)라우팅 URL일경우
			$exp = explode('/', $urls['path']);
			if($exp[1] == 'm' || $exp[1] == 'board') {
				if($exp[2] !== 'micateam' && $exp[2] !== 'gfl2')
					exit('미카팀, 소전2 갤만 가능');
				if(!isset($exp[3]) || !ctype_digit($exp[3]))
					exit('정확한 주소를 입력하세요');
				
				$board = $exp[2];
				$no = $exp[3];
			}
			else {
				if($exp[1] !== 'micateam' && $exp[1] !== 'gfl2')
					exit('미카팀, 소전2 갤만 가능');
				if(!isset($exp[2]) || !ctype_digit($exp[2]))
					exit('정확한 주소를 입력하세요');
				$board = $exp[1];
				$no = $exp[2];
			}
			$requesturl = "http://gall.dcinside.com/mgallery/board/view/?id=$board&no=$no";
		}
		else { //쿼리일경우
			parse_str($urls['query'], $output);
			if($output['id'] !== 'micateam' && $output['id'] !== 'gfl2')
				exit('미카팀, 소전2 갤만 가능');
			if(!isset($output['no']) || !ctype_digit($output['no']))
				exit('정확한 주소를 입력하세요');
			
			$board = $output['id'];
			$no = $output['no'];
		}
		$board = mysqli_real_escape_string($dbcon, $board);
		$no = mysqli_real_escape_string($dbcon, $no);
		
		$response = $_POST["g-recaptcha-response"];
		$url = 'https://www.google.com/recaptcha/api/siteverify';
		$data = array(
			'secret' => $captcha_key,
			'response' => $_POST["g-recaptcha-response"]
		);
		$options = array(
			'http' => array (
				'method' => 'POST',
				'content' => http_build_query($data)
			)
		);
		$context  = stream_context_create($options);
		$verify = file_get_contents($url, false, $context);
		$captcha_success=json_decode($verify);
		if ($captcha_success->success==true) {
			$cnt = mysqli_fetch_array(sql_query("select count(*) as cnt from bbs where orgboard = '$board' and orgno = $no"));
			if($cnt['cnt'] == 0) {
				$result = reqDCCrawl($requesturl);
				echo "<script>alert(\"완료되었습니다. 안나오면 새로고침을 한번 해주세요\");</script>";
			}
			else {
				echo "<script>alert(\"중복된 주소입니다.\");</script>";
			}
		}
		else {
			exit('캡챠 인증을 진행하고 눌러주세요');
		}
	}
	
    $page = 0;
    if($page == '') $page = 0;
    $number = 15;

    $startnum = $page * $number;
    //$result = sql_query("select * from bbs order by id desc limit $startnum, $number");    
    $result = sql_query("select * from bbs order by id desc");
    
?>
    <style>
    </style>
    <main role="main" class="container">
		<div class="my-3 p-3 bg-white rounded box-shadow" style="font-size: 13px">
			<table class="table table-hover">
                <thead class="thead-light text-center">
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">제목</th>
                        <th scope="col">이름</th>
                        <th scope="col">날짜</th>
                    </tr>
                </thead>
                <tbody class="table-sm">
            <?php while($row = mysqli_fetch_array($result)) { 
					$nick_icon = '';
					switch($row['idtype']) {
						case 2: $nick_icon = "<img src='img/fix_nik.gif'>"; break;
						case 3: $nick_icon = "<img src='img/nik.gif'>"; break;
					} ?>
                    <tr>
                        <td class="text-center"><?=$row['id']?></td>
                        <td style="width: 80%"><a href="bbs.php?id=<?=$row['id']?>"><?=$row['title']?></a></td>
                        <td class="text-center"><?=$row['name']?><?=$nick_icon?></td>
                        <td class="text-center"><?=date('m/d H:i', $row['date'])?></td>
                    </tr>
            <?php } ?>
                </tbody>
            </table>
			<hr>
			아카이브 요청하기. (상당히 시간이 걸리므로 한번만 누르고 기다리세요.)
			<form method="post">
				<input placeholder="DC URL 입력" name='url' type="text"><input type="submit" onsubmit="this.disabled=true; this.value='진행중....';">
				<div class="g-recaptcha" data-sitekey="6LdEvnQUAAAAAG0cckpr3ZoHpDgMZVOApXegwL3P"></div>
			</form><br>
			아직 에러 처리가 덜 되어서 에러가 발생해도 확인이 안됩니다. 오래걸리면 다시 시도하고 그래도 안되면 말해주세요.
		</div>
    </main>
<?php
	require_once("footer.php");
?>
	</body>
	<script src='https://www.google.com/recaptcha/api.js'></script>
</html>