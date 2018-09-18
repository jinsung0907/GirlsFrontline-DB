<?php
$useragent=$_SERVER['HTTP_USER_AGENT'];
if(!preg_match('/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|mobile.+firefox|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows ce|xda|xiino/i',$useragent)||preg_match('/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i',substr($useragent,0,4)))
{
?>
<video autoplay muted loop id="pv" style="z-index: -1">
	<source src="img/pv/180207.mp4" type="video/mp4">
</video>
<?php } ?>

<?php
	define("GF_HEADER", "aaaaa");
	require_once("common.php");
	
	$header_desc = "소전DB 특이점 스토리";
	$header_title = "특이점 | 소전DB";
	require_once("header.php");
?>
	<style>
		.row .item {
			padding-top: 1rem; padding-bottom: 1rem;
		}
		.row .item span{
			font-size: 20px;
			font-weight: bold;
		}
		
		#pv {
			position: fixed;
			right: 0;
			bottom: 0;
			min-width: 100%; 
			min-height: 100%;
		}
		
		.container[role=main] {
			background-color: rgba(255,255,255,0.7);
		}
		.container[role=main] h2, .container[role=main] span, .container[role=main] img {
			opacity: 1!important;
		}
	</style>
    <main role="main" class="container">
		<div class="my-3 p-3 rounded box-shadow">
			<div class="row" style="text-align:center;">
				<img style="display:block; margin-left: auto;margin-right: auto; margin-bottom: 4rem" src="img/singularity.jpg" />
				
				<div class="col-12 item pb-5">
					<h2 class="mb-4 pb-1 border-bottom border-gray">풀 리트릿</h2>
					
					<div class="row">
						<div class="col-12 item">
							<a href="story.php?q=-16-1">
								<span>엔드 게임</span>
								<i class="text-muted">13:20</i>
							</a>
						</div>
					</div>
					<div class="row">
						<div class="col-12 item">
							<a href="story.php?q=-16-2">
								<span>시작점</span>
								<i class="text-muted">리벨리온 16:00</i>
							</a>
						</div>
					</div>
					<div class="row">
						<div class="col-12 item">
							<a href="story.php?q=-16-3">
								<span>분기점</span>
								<i class="text-muted">리벨리온 16:40</i>
							</a>
						</div>
					</div>
					
					<div class="row">
						<div class="col-4 item">
							<a href="story.php?q=-16-4">
								<span>행정사점 Ⅰ</span>
								<i class="text-muted">안젤리아 16:55</i>
							</a>
						</div>
						<div class="col-4 item">
							<a href="story.php?q=-16-8">
								<span>압축시동 Ⅰ</span>
								<i class="text-muted">리벨리온 16:46</i>
							</a>
						</div>
						<div class="col-4 item">
							<a href="story.php?q=-16-12">
								<span>재점화 Ⅰ</span>
								<i class="text-muted">그리폰 18:30</i>
							</a>
						</div>
					</div>
					<div class="row">
						<div class="col-4 item">
							<a href="story.php?q=-16-5">
								<span>행정사점 Ⅱ</span>
								<i class="text-muted">안젤리아 17:42</i>
							</a>
						</div>
						<div class="col-4 item">
							<a href="story.php?q=-16-9">
								<span>압축시동 Ⅱ</span>
								<i class="text-muted">리벨리온 17:50</i>
							</a>
						</div>
						<div class="col-4 item">
							<a href="story.php?q=-16-13">
								<span>재점화 Ⅱ</span>
								<i class="text-muted">그리폰 19:00</i>
							</a>
						</div>
					</div>
					<div class="row">
						<div class="col-4 item">
							<a href="story.php?q=-16-6">
								<span>행정사점 Ⅲ</span>
								<i class="text-muted">안젤리아 18:20</i>
							</a>
						</div>
						<div class="col-4 item">
							<a href="story.php?q=-16-10">
								<span>압축시동 Ⅲ</span>
								<i class="text-muted">리벨리온 18:20</i>
							</a>
						</div>
						<div class="col-4 item">
							<a href="story.php?q=-16-14">
								<span>재점화 Ⅲ</span>
								<i class="text-muted">그리폰 19:10</i>
							</a>
						</div>
					</div>
					<div class="row">
						<div class="col-4 item">
							<a href="story.php?q=-16-7">
								<span>행정사점 Ⅳ</span>
								<i class="text-muted">안젤리아 19:30</i>
							</a>
						</div>
						<div class="col-4 item">
							<a href="story.php?q=-16-11">
								<span>압축시동 Ⅳ</span>
								<i class="text-muted">리벨리온 19:30</i>
							</a>
						</div>
						<div class="col-4 item">
							<a href="story.php?q=-16-15">
								<span>재점화 Ⅳ</span>
								<i class="text-muted">그리폰 19:30</i>
							</a>
						</div>
					</div>
					
					<div class="row">
						<div class="col-12 item">
							<a href="story.php?q=-16-16">
								<span>메신저</span>
								<i class="text-muted">히든</i>
							</a>
						</div>
					</div>
				</div>
				
				<div class="col-12 item pb-5">
					<h2 class="mb-4 pb-1 border-bottom border-gray">세컨드 문</h2>
					
					<div class="row">
						<div class="col-12 item">
							<a href="story.php?q=-17-1">
								<span>분기점</span>
								<i class="text-muted">안젤리아&리벨리온 20:00</i>
							</a>
						</div>
					</div>
					
					<div class="row">
						<div class="col-3 item">
							<a href="story.php?q=-17-2">
								<span>퀸즈 갬빗 Ⅰ</span>
								<i class="text-muted">안젤리아&페르시카 21:20</i>
							</a>
						</div>
						<div class="col-3 item">
							<a href="story.php?q=-17-6">
								<span>캐슬링 Ⅰ</span>
								<i class="text-muted">리벨리온 22:30</i>
							</a>
						</div>
						<div class="col-3 item">
							<a href="story.php?q=-17-10">
								<span>프로모션 Ⅰ</span>
								<i class="text-muted">404소대 20:10</i>
							</a>
						</div>
						<div class="col-3 item">
							<a href="story.php?q=-17-14">
								<span>노 메이트 Ⅰ</span>
								<i class="text-muted">그리폰 22:10</i>
							</a>
						</div>
					</div>
					
					<div class="row">
						<div class="col-3 item">
							<a href="story.php?q=-17-3">
								<span>퀸즈 갬빗 Ⅱ</span>
								<i class="text-muted">안젤리아&페르시카 22:50</i>
							</a>
						</div>
						<div class="col-3 item">
							<a href="story.php?q=-17-7">
								<span>캐슬링 Ⅱ</span>
								<i class="text-muted">리벨리온 00:05</i>
							</a>
						</div>
						<div class="col-3 item">
							<a href="story.php?q=-17-11">
								<span>프로모션 Ⅱ</span>
								<i class="text-muted">404소대 21:50</i>
							</a>
						</div>
						<div class="col-3 item">
							<a href="story.php?q=-17-15">
								<span>노 메이트 Ⅱ</span>
								<i class="text-muted">그리폰 00:00</i>
							</a>
						</div>
					</div>
					
					<div class="row">
						<div class="col-3 item">
							<a href="story.php?q=-17-4">
								<span>퀸즈 갬빗 Ⅲ</span>
								<i class="text-muted">안젤리아&페르시카 00:25</i>
							</a>
						</div>
						<div class="col-3 item">
							<a href="story.php?q=-17-8">
								<span>캐슬링 Ⅲ</span>
								<i class="text-muted">리벨리온 02:14</i>
							</a>
						</div>
						<div class="col-3 item">
							<a href="story.php?q=-17-12">
								<span>프로모션 Ⅲ</span>
								<i class="text-muted">404소대 00:30</i>
							</a>
						</div>
						<div class="col-3 item">
							<a href="story.php?q=-17-16">
								<span>노 메이트 Ⅲ</span>
								<i class="text-muted">그리폰 00:30</i>
							</a>
						</div>
					</div>
					
					<div class="row">
						<div class="col-3 item">
							<a href="story.php?q=-17-5">
								<span>퀸즈 갬빗 Ⅳ</span>
								<i class="text-muted">안젤리아&페르시카 00:30</i>
							</a>
						</div>
						<div class="col-3 item">
							<a href="story.php?q=-17-9">
								<span>캐슬링 Ⅳ</span>
								<i class="text-muted">리벨리온 03:15</i>
							</a>
						</div>
						<div class="col-3 item">
							<a href="story.php?q=-17-13">
								<span>프로모션 Ⅳ</span>
								<i class="text-muted">404소대 03:15</i>
							</a>
						</div>
						<div class="col-3 item">
							<a href="story.php?q=-17-17">
								<span>노 메이트 Ⅳ</span>
								<i class="text-muted">그리폰 01:50</i>
							</a>
						</div>
					</div>
					
					<div class="row">
						<div class="col-12 item">
							<a href="story.php?q=-17-18">
								<span>생존자</span>
								<i class="text-muted">히든</i>
							</a>
						</div>
					</div>
				</div>
				
				<div class="col-12 item pb-5">
					<h2 class="mb-4 pb-1 border-bottom border-gray">엔드 게임</h2>
					
					<div class="row">
						<div class="col-12 item">
							<a href="story.php?q=-18-1">
								<span>최종수단 Ⅰ</span>
								<i class="text-muted">06:00</i>
							</a>
						</div>
					</div>
					<div class="row">
						<div class="col-12 item">
							<a href="story.php?q=-18-2">
								<span>최종수단 Ⅱ</span>
								<i class="text-muted">08:00</i>
							</a>
						</div>
					</div>
					<div class="row">
						<div class="col-12 item">
							<a href="story.php?q=-18-3">
								<span>최종수단 Ⅲ</span>
								<i class="text-muted">09:00</i>
							</a>
						</div>
					</div>
					<div class="row">
						<div class="col-12 item">
							<a href="story.php?q=-18-4">
								<span>최종수단 Ⅳ</span>
								<i class="text-muted">12:30</i>
							</a>
						</div>
					</div>
					<div class="row">
						<div class="col-12 item">
							<a href="story.php?q=-18-5">
								<span>최종수단 Ⅴ</span>
								<i class="text-muted">13:00</i>
							</a>
						</div>
					</div>
					<div class="row">
						<div class="col-12 item">
							<a href="story.php?q=-18-6">
								<span>엔드 게임</span>
								<i class="text-muted">13:20</i>
							</a>
						</div>
					</div>
					<div class="row">
						<div class="col-12 item">
							<a href="story.php?q=-18-7">
								<span>굿바이 용궁</span>
								<i class="text-muted">히든</i>
							</a>
						</div>
					</div>
					<div class="row">
						<div class="col-12 item">
							<a href="story.php?q=-18-8">
								<span>말벌집</span>
								<i class="text-muted">방어전</i>
							</a>
						</div>
					</div>
				</div>
			</div>
		</div>
    </main>
<?php
	require_once("footer.php");
?>
	</body>
</html>