<?php
$useragent=$_SERVER['HTTP_USER_AGENT'];
if(!preg_match('/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|mobile.+firefox|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows ce|xda|xiino/i',$useragent)||preg_match('/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i',substr($useragent,0,4)))
{
?>
<video autoplay muted loop id="pv" style="z-index: -1">
	<source src="img/pv/kr-52S.mp4" type="video/mp4">
</video>
<?php } ?>

<?php
	define("GF_HEADER", "aaaaa");
	require_once("common.php");
	
	$header_desc = "소전DB 난류연속 스토리";
	$header_title = "난류연속 | 소전DB";
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
		.badend {
			color: #f44336;
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
	
    <main role="main" class="container" >
		<div class="my-3 p-3 rounded box-shadow" style="background-color: white">
			<div class="row" style="text-align:center;">
				<div style="display:block; margin-left: auto;margin-right: auto; margin-bottom: 4rem"><img style="max-width:100%; height:auto;" src="img/난류연속.jpg" /></div>
				
				<div class="col-12 item pb-5">
					<h2 class="mb-4 pb-1 border-bottom border-gray">황천의 여명</h2>
					
					<div class="row">
						<div class="col-12 item">
							<a href="story.php?q=-24-1">
								<span>폭심지</span>
							</a>
						</div>

						
						<div class="col-12 item">
							<a href="story.php?q=-24-2">
								<span>폐기물</span>
							</a>
						</div>
						
						
						<div class="col-6 item">
							<a href="story.php?q=-24-4">
								<span>세이프 하우스</span>
							</a>
						</div>
						<div class="col-6 item">
							<a class="badend" href="story.php?q=-24-3">
								<span>어두운 밤</span>
							</a>
						</div>
						
						
						<div class="col-12 item">
							<a href="story.php?q=-24-5">
								<span>예비전원</span>
							</a>
						</div>
						
						<div class="col-12 item">
							<a href="story.php?q=-24-6">
								<span>비축거점</span>
							</a>
						</div>
						
						<div class="col-6 item">
							<a href="story.php?q=-24-8">
								<span>마지막 날</span>
							</a>
						</div>
						<div class="col-6 item">
							<a class="badend" href="story.php?q=-24-7">
								<span>잘 가라 허수아비</span>
							</a>
						</div>
						
						<div class="col-6 item">
							<a href="story.php?q=-24-10">
								<span>평화협상</span>
							</a>
						</div>
						<div class="col-6 item">
							<a class="badend" href="story.php?q=-24-9">
								<span>피 없는 전장</span>
							</a>
						</div>
						
						<div class="col-12 item">
							<a href="story.php?q=-24-11">
								<span>행운?</span>
							</a>
						</div>
						
						<div class="col-12 item">
							<a href="story.php?q=-24-12">
								<span>철혈고위거점</span>
							</a>
						</div>
						
						<div class="col-12 item">
							<a href="story.php?q=-24-13">
								<span>마인드 파편</span>
							</a>
						</div>
						
						<div class="col-12 item">
							<a href="story.php?q=-24-14">
								<span>가장 비겁한 소원</span>
							</a>
						</div>
						
						<div class="col-12 item">
							<a href="story.php?q=-24-15">
								<span>다음 목적지</span>
							</a>
						</div>
					</div>
				</div>
				
				<div class="col-12 item pb-5">
					<h2 class="mb-4 pb-1 border-bottom border-gray">유일한 결말</h2>
					<div class="row">
						<div class="col-12 item">
							<a href="story.php?q=-25-1">
								<span>의문의 적</span>
							</a>
						</div>
						
						<div class="col-12 item">
							<a href="story.php?q=-25-2">
								<span>지원군</span>
							</a>
						</div>
						
						<div class="col-6 item">
							<a href="story.php?q=-25-3">
								<span>그리폰 결사대</span>
							</a>
						</div>
						<div class="col-6 item">
							<a class="badend" href="story.php?q=-25-12">
								<span>포효하는 태양</span>
							</a>
						</div>
						
						<div class="col-12 item">
							<a href="story.php?q=-25-4">
								<span>2번 수비거점</span>
							</a>
						</div>
						
						<div class="col-6 item">
							<a href="story.php?q=-25-5">
								<span>3번 수비거점</span>
							</a>
						</div>
						<div class="col-6 item">
							<a class="badend" href="story.php?q=-25-13">
								<span>무서운 굉음</span>
							</a>
						</div>
						
						<div class="col-6 item">
							<a href="story.php?q=-25-6">
								<span>거친 장난</span>
							</a>
						</div>
						<div class="col-6 item">
							<a href="story.php?q=-25-7">
								<span>4번 수비거점</span>
							</a>
						</div>
						
						<div class="col-6 item">
							<a href="story.php?q=-25-9">
								<span>총공격</span>
							</a>
						</div>
						<div class="col-6 item">
							<a href="story.php?q=-25-8">
								<span>떠보는 공세</span>
							</a>
						</div>
						
						<div class="col-6 item">
							
						</div>
						<div class="col-6 item">
							<a href="story.php?q=-25-10">
								<span>미래를 위해</span>
							</a>
						</div>
						
						<div class="col-12 item">
							<a href="story.php?q=-25-11">
								<span>검은 인형</span>
							</a>
						</div>
						
						<div class="col-4 item">
							<a href="story.php?q=-25-16">
								<span>마지막 티켓</span>
							</a>
						</div>
						<div class="col-4 item">
							<a class="badend" href="story.php?q=-25-14">
								<span>작별 인사</span>
							</a>
						</div>
						<div class="col-4 item">
							<a class="badend" href="story.php?q=-25-15">
								<span>잠깐만인 평화</span>
							</a>
						</div>
					</div>
				</div>
				
				<div class="col-12 item pb-5">
					<h2 class="mb-4 pb-1 border-bottom border-gray">종말을 넘어</h2>
					<div class="row">
						<div class="col-12 item">
							<a href="story.php?q=-26-1">
								<span>ELID 감염자</span>
							</a>
						</div>
						
						<div class="col-12 item">
							<a href="story.php?q=-26-2">
								<span>신호탄</span>
							</a>
						</div>
						
						<div class="col-12 item">
							<a href="story.php?q=-26-3">
								<span>레드존</span>
							</a>
						</div>
						
						<div class="col-6 item">
							<a href="story.php?q=-26-4">
								<span>옐로우존</span>
							</a>
						</div>
						<div class="col-6 item">
							<a class="badend" href="story.php?q=-26-15">
								<span>유지</span>
							</a>
						</div>
						
						<div class="col-6 item">
							<a href="story.php?q=-26-6">
								<span>표식</span>
							</a>
						</div>
						<div class="col-6 item">
							<a href="story.php?q=-26-5">
								<span>복수</span>
							</a>
						</div>

						<div class="col-12 item">
							<a href="story.php?q=-26-7">
								<span>희망 출현</span>
							</a>
						</div>
						
						<div class="col-6 item">
							<a href="story.php?q=-26-9">
								<span>비열한 생쥐들</span>
							</a>
						</div>
						<div class="col-6 item">
							<a class="badend" href="story.php?q=-26-8">
								<span>모든 울분</span>
							</a>
						</div>
						
						<div class="col-6 item">
							<a href="story.php?q=-26-11">
								<span>나쁜 소식</span>
							</a>
						</div>
						<div class="col-6 item">
							<a class="badend" href="story.php?q=-26-10">
								<span>운에 맡기다</span>
							</a>
						</div>
						
						<div class="col-12 item">
							<a href="story.php?q=-26-12">
								<span>IED</span>
							</a>
						</div>
						
						<div class="col-6 item">
							<a href="story.php?q=-26-13">
								<span>걸림돌</span>
							</a>
						</div>
						<div class="col-6 item">
							<a class="badend" href="story.php?q=-26-18">
								<span>승리자</span>
							</a>
						</div>

						<div class="col-12 item">
							<a href="story.php?q=-26-14">
								<span>하얀 인형</span>
							</a>
						</div>
					</div>
				</div>
				
				<div class="col-12 item pb-5">
					<h2 class="mb-4 pb-1 border-bottom border-gray">돌풍구출</h2>
					<div class="row">
						<div class="col-12 item">
							<a href="story.php?q=-27-1">
								<span>돌풍구출</span>
							</a>
						</div>
					</div>
				</div>
				
				<div class="col-12 item pb-5">
					<h2 class="mb-4 pb-1 border-bottom border-gray">추방자</h2>
					<div class="row">
						<div class="col-12 item">
							<a href="story.php?q=-28-1">
								<span>추방자</span>
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