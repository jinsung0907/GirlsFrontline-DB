<?php
$useragent=$_SERVER['HTTP_USER_AGENT'];
if(!preg_match('/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|mobile.+firefox|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows ce|xda|xiino/i',$useragent)||preg_match('/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i',substr($useragent,0,4)))
{
?>
<video autoplay muted loop id="pv" style="z-index: -1">
	<source src="img/pv/pl.mp4" type="video/mp4">
</video>
<?php } ?>

<?php
	define("GF_HEADER", "aaaaa");
	require_once("common.php");
	
	$header_desc = "소전DB 편극광 스토리";
	$header_title = "편극광 | 소전DB";
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
		.row .item a:visited {
			color: brown;
		}

		#pv {
			position: fixed;
			right: 0;
			bottom: 0;
			min-width: 100%; 
			min-height: 100%;
		}
		
		@media all and (min-width: 760px) {
			.container[role=main] {
				background-color: rgba(255,255,255,0.6)!important;
			}
			.container[role=main] > div {
				background-color: rgba(255,255,255,0.6)!important;
			}
			.container[role=main] h2, .container[role=main] span, .container[role=main] img {
				opacity: 1!important;
			}
		}
		
	</style>
    <main role="main" class="container">
		<div class="my-3 p-3 rounded box-shadow" style="background-color: white">
			<div class="row" style="text-align:center;">
				<div class="col-12 mb-5">
					<img style="width: 100%" src="img/pl.jpg" alt="편극광" />
				</div>
				
				<div class="col-12 item pb-5">
					<h2 class="mb-4 pb-1 border-bottom border-gray">비편광권</h2>
					
					<div class="row">
						<div class="col-12 item">
							<a target="_blank" href="story.php?q=-36-1-1">
								<span>점등관</span>
							</a>
						</div>
					</div>
					<div class="row">
						<div class="col-12 item">
							<a target="_blank" href="story.php?q=-36-1-2">
								<span>직진성 Ⅰ</span>
							</a>
						</div>
					</div>	
					<div class="row">
						<div class="col-6 item">
							<a target="_blank" href="story.php?q=-36-1-4">
								<span>임계각 Ⅰ</span>
							</a>
						</div>
						<div class="col-6 item">
							<a target="_blank" href="story.php?q=-36-1-3">
								<span>굴절점</span>
							</a>
						</div>
					</div>
					<div class="row">
						<div class="col-6 item">
							<a target="_blank" href="story.php?q=-36-1-6">
								<span>임계각 Ⅲ</span>
							</a>
						</div>
						<div class="col-6 item">
							<a target="_blank" href="story.php?q=-36-1-5">
								<span>반사면 Ⅰ</span>
							</a>
						</div>
					</div>
					<div class="row">
						<div class="col-12 item">
							<a target="_blank" href="story.php?q=-36-1-7">
								<span>전반사 Ⅰ</span>
							</a>
						</div>
					</div>
					<div class="row">
						<div class="col-12 item">
							<a target="_blank" href="story.php?q=-36-1-8">
								<span>사인 곡선</span>
							</a>
						</div>
					</div>
					<div class="row">
						<div class="col-12 item">
							<a target="_blank" href="story.php?q=-36-1-9">
								<span>가역성 Ⅰ</span>
							</a>
						</div>
					</div>
					<div class="row">
						<div class="col-12 item">
							<a target="_blank" href="story.php?q=-36-1-10">
								<span>코사인 신호</span>
							</a>
						</div>
					</div>
				</div>
				
			
				<div class="col-12 item pb-5">
					<h2 class="mb-4 pb-1 border-bottom border-gray">이중 프리즘</h2>
					
					<div class="row">
						<div class="col-6 item">
							<a target="_blank" href="story.php?q=-36-2-1">
								<span>편광자 Ⅰ</span>
							</a>
						</div>
						<div class="col-6 item">
							<a target="_blank" href="story.php?q=-36-2-3">
								<span>도파관 Ⅰ</span>
							</a>
						</div>
					</div>
					<div class="row">
						<div class="col-6 item">
							<a target="_blank" href="story.php?q=-36-2-2">
								<span>회절 격자</span>
							</a>
						</div>
						<div class="col-6 item">
							<a target="_blank" href="story.php?q=-36-2-4">
								<span>분광계</span>
							</a>
						</div>
					</div>
					<div class="row">
						<div class="col-6 item">
							<a target="_blank" href="story.php?q=-36-2-7">
								<span>진공관</span>
							</a>
						</div>
						<div class="col-6 item">
							<a target="_blank" href="story.php?q=-36-2-5">
								<span>간섭계 Ⅰ</span>
							</a>
						</div>
					</div>
					<div class="row">
						<div class="col-6 item">
							<a target="_blank" href="story.php?q=-36-2-8">
								<span>가속기</span>
							</a>
						</div>
						<div class="col-6 item">
							<a target="_blank" href="story.php?q=-36-2-6">
								<span>틈새</span>
							</a>
						</div>
					</div>
					<div class="row">
						<div class="col-6 item">
							<a target="_blank" href="story.php?q=">
								<span></span>
							</a>
						</div>
						<div class="col-6 item">
							<a target="_blank" href="story.php?q=-36-2-9">
								<span>스펙트럼 Ⅰ</span>
							</a>
						</div>
					</div>
					<div class="row">
						<div class="col-6 item">
							<a target="_blank" href="story.php?q=-17-2">
								<span></span>
							</a>
						</div>
						<div class="col-6 item">
							<a target="_blank" href="story.php?q=-36-2-10">
								<span>검광자</span>
							</a>
						</div>
					</div>
				</div>
				
				<div class="col-12 item pb-5">
					<h2 class="mb-4 pb-1 border-bottom border-gray">극화 종점</h2>
					
					<div class="row">
						<div class="col-12 item">
							<a target="_blank" href="story.php?q=-36-3-1">
								<span>거울상 과다 Ⅰ</span>
							</a>
						</div>
					</div>
					<div class="row">
						<div class="col-12 item">
							<a target="_blank" href="story.php?q=-36-3-2">
								<span>거울상 과다 Ⅱ</span>
							</a>
						</div>
					</div>
					<div class="row">
						<div class="col-12 item">
							<a target="_blank" href="story.php?q=-36-3-3">
								<span>재결정 분해 Ⅰ</span>
							</a>
						</div>
					</div>
					<div class="row">
						<div class="col-12 item">
							<a target="_blank" href="story.php?q=-36-3-4">
								<span>불규칙 편파 Ⅰ</span>
							</a>
						</div>
					</div>
					<div class="row">
						<div class="col-12 item">
							<a target="_blank" href="story.php?q=-36-3-5">
								<span>재결정 분해 Ⅱ</span>
							</a>
						</div>
					</div>
					<div class="row">
						<div class="col-12 item">
							<a target="_blank" href="story.php?q=-36-3-6">
								<span>불규칙 편파 Ⅱ</span>
							</a>
						</div>
					</div>
					<div class="row">
						<div class="col-12 item">
							<a target="_blank" href="story.php?q=-36-3-7">
								<span>비대칭 유도 Ⅰ</span>
							</a>
						</div>
					</div>
					<div class="row">
						<div class="col-12 item">
							<a target="_blank" href="story.php?q=-36-3-8">
								<span>광학 이성질체</span>
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