 <?php if(GF_HEADER != "aaaaa") exit; 
if(!isset($header_title)) $header_title = '소전DB | zzzzz.kr';
require_once("common.php");?>
<!doctype html>
<html lang="ko">
  <head>
	<!-- Global site tag (gtag.js) - Google Analytics -->
	<script async src="https://www.googletagmanager.com/gtag/js?id=UA-45210527-6"></script>
	<script>
	window.dataLayer = window.dataLayer || [];
	function gtag(){dataLayer.push(arguments);}
	gtag('js', new Date());

	gtag('config', 'UA-45210527-6');
	</script>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="소녀전선DB, 소전DB, 스토리, 소전, 소전 스토리, 소녀전선, 소녀전선 스토리, <?=$header_desc?>">
    <meta name="keywords" content="소녀전선DB, 소전DB, 스토리, 소전, 소전 스토리, 소녀전선, 소녀전선 스토리, <?=$header_desc?>">
    <meta name="author" content="Jinsung">
	<meta name="theme-color" content="#F0A900"> 
	<meta property="og:title" content="<?=$header_title?>"/>
	<meta property="og:url" content="http://gfl.zzzzz.kr"/>
	<meta property="og:description" content="<?=$header_desc?>, 소녀전선DB, 소전DB, 스토리, 소전, 소전 스토리, 소녀전선, 소녀전선 스토리"/>
	
    <title><?=$header_title?></title>

    <link rel="stylesheet" href="dist/bootstrap.min.css">
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.13/css/all.css" integrity="sha384-DNOHZ68U8hZfKXOrtjWvjxusGo9WQnrNx2sqG0tfsghAvtVlRW3tvkXWZh58N9jp" crossorigin="anonymous">
    <link rel="stylesheet" href="dist/gfdb.css?v=4">
  </head>

  <body class="bg-secondary">
    <nav class="navbar navbar-expand-md navbar-dark" style="background-color: #F0A900;">
      <div class="container">
        <a class="navbar-brand" href="/">소전DB</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsEx" aria-controls="navbarsEx" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarsEx">
          <ul class="navbar-nav mr-auto">
			<li class="nav-item dropdown">
			 <a class="nav-link dropdown-toggle" href="#" id="dbDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
			  소녀전선 DB
			 </a>
			  <div class="dropdown-menu" aria-labelledby="dbDropdown">
			   <a class="dropdown-item" href="/dolls.php">인형 목록</a>
			   <a class="dropdown-item" href="/fairies.php">요정 목록</a>
			   <a class="dropdown-item" href="/timetable.php">제조시간표</a>
			  </div>
			</li>
			<li class="nav-item">
              <a class="nav-link" href="/simulator.php">제대편성&DPS시뮬</a>
            </li>
			<li class="nav-item">
              <a class="nav-link" href="https://pf.kakao.com/_VxgYxeC">제조시간(카톡봇)</a>
            </li>
			<li class="nav-item dropdown">
			 <a class="nav-link dropdown-toggle" href="#" id="storyDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
			  스토리
			 </a>
			  <div class="dropdown-menu" aria-labelledby="storyDropdown">
			   <a class="dropdown-item" href="/story_list.php">메인 스토리</a>
			   <a class="dropdown-item" href="/substory_list.php">서브 스토리</a>
			  </div>
			</li>
			<li class="nav-item dropdown">
			 <a class="nav-link dropdown-toggle" href="#" id="toolsDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
			  도구&계산기
			 </a>
			  <div class="dropdown-menu" aria-labelledby="toolsDropdown">
			   <a class="dropdown-item" href="/diskcalc.php">작보계산기</a>
			   <a class="dropdown-item" href="/battery.php">전지계산기</a>
			   <a class="dropdown-item" href="/logi.php">군수지원계산기</a>
			  </div>
			</li>
			<li class="nav-item">
              <a class="nav-link" href="/cartoon.php">만화</a>
            </li>
			<li class="nav-item">
              <a class="nav-link" href="http://zzzzz.kr">메인</a>
            </li>
          </ul>
        </div>
      </div>
    </nav>