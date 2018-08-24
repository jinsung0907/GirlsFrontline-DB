<?php if(GF_HEADER != "aaaaa") exit; 

require_once("common.php");

if(!isset($header_title)) $header_title = L::sitetitle_short . ' | zzzzz.kr';
if(!isset($header_desc)) $header_desc = '소녀전선 데이터베이스 사이트입니다.';
if(!isset($header_image)) $header_image = ''; else $header_image = '<meta property="og:image" content="' . $header_image . '"/>'
?>
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
	<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
	<script>
	  (adsbygoogle = window.adsbygoogle || []).push({
		google_ad_client: "ca-pub-6637664198779025",
		enable_page_level_ads: true
	  });
	</script>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="<?=$header_desc?>">
    <meta name="keywords" content="소녀전선DB, 소전DB, 스토리, 소전, 소전 스토리, 소녀전선, 소녀전선 스토리, <?=$header_keyword?>">
    <meta name="author" content="Jinsung">
	<meta name="theme-color" content="#F0A900"> 
	<meta property="og:type" content="website"/>
	<meta property="og:title" content="<?=$header_title?>"/>
	<meta property="og:url" content="http://<?=$_SERVER[HTTP_HOST] . $_SERVER[REQUEST_URI] ?>"/>
	<?=$header_image?>
	<meta property="og:description" content="<?=$header_desc?>"/>
	
    <title><?=$header_title?></title>

    <link rel="stylesheet" href="dist/bootstrap.min.css">
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.13/css/all.css" integrity="sha384-DNOHZ68U8hZfKXOrtjWvjxusGo9WQnrNx2sqG0tfsghAvtVlRW3tvkXWZh58N9jp" crossorigin="anonymous">
	<link rel="stylesheet" href="dist/outdatedbrowser/outdatedbrowser.min.css">
    <link rel="stylesheet" href="dist/gfdb.css?v=6">
  </head>

  <body class="bg-secondary">
    <nav class="navbar navbar-expand-md navbar-dark" style="background-color: #F0A900;">
      <div class="container">
        <a class="navbar-brand" href="/"><?=L::sitetitle_short?></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsEx" aria-controls="navbarsEx" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarsEx">
          <ul class="navbar-nav mr-auto">
			<li class="nav-item dropdown">
			 <a class="nav-link dropdown-toggle" href="#" id="dbDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
			 <?=L::navigation_title_database?>
			 </a>
			  <div class="dropdown-menu" aria-labelledby="dbDropdown">
			   <a class="dropdown-item" href="/dolls.php"><?=L::navigation_menu_dolllist?></a>
			   <a class="dropdown-item" href="/fairies.php"><?=L::navigation_menu_fairylist?></a>
			   <a class="dropdown-item" href="/squads.php"><?=L::navigation_menu_heavylist?></a>
			   <a class="dropdown-item" href="/furniture.php"><?=L::navigation_menu_furniturelist?></a>
			   <a class="dropdown-item" href="/timetable.php"><?=L::navigation_menu_timetable?></a>
			  </div>
			</li>
			<li class="nav-item">
              <a class="nav-link" href="<?=L::navigation_titile_kakaobot_link?>"><?=L::navigation_titile_kakaobot?></a>
            </li>
			<li class="nav-item dropdown">
			 <a class="nav-link dropdown-toggle" href="#" id="storyDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
			  <?=L::navigation_title_story?>
			 </a>
			  <div class="dropdown-menu" aria-labelledby="storyDropdown">
			   <a class="dropdown-item" href="/story_list.php"><?=L::navigation_menu_mainstory?></a>
			   <a class="dropdown-item" href="/substory_list.php"><?=L::navigation_menu_substory?></a>
			  </div>
			</li>
			<li class="nav-item dropdown">
			 <a class="nav-link dropdown-toggle" href="#" id="toolsDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
			  <?=L::navigation_title_tools?>
			 </a>
			  <div class="dropdown-menu" aria-labelledby="toolsDropdown">
			   <a class="dropdown-item" href="/simulator.php"><?=L::navigation_title_dpssim?></a>
			   <a class="dropdown-item" href="/diskcalc.php"><?=L::navigation_menu_diskcalc?></a>
			   <a class="dropdown-item" href="/battery.php"><?=L::navigation_menu_cellcalc?></a>
			   <a class="dropdown-item" href="/logi.php"><?=L::navigation_menu_opscalc?></a>
			  </div>
			</li>
			<li class="nav-item">
              <a class="nav-link" href="/cartoon.php"><?=L::navigation_title_cartoon?></a>
            </li>
			<li class="nav-item dropdown">
			 <a class="nav-link dropdown-toggle" href="#" id="storyDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
			  Contact
			 </a>
			  <div class="dropdown-menu" aria-labelledby="storyDropdown">
			   <a class="dropdown-item" href=""><i class="fab fa-twitter" style='color:#00aced'></i> Twitter</a>
			   <a class="dropdown-item" href="https://discord.gg/D35j44V"><i style='color:#7289DA' class="fab fa-discord"></i> Discord</a>
			  </div>
			</li>
          </ul>
        </div>
      </div>
    </nav>