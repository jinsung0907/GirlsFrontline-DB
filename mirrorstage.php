<?php
$useragent=$_SERVER['HTTP_USER_AGENT'];
if(!preg_match('/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|mobile.+firefox|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows ce|xda|xiino/i',$useragent)||preg_match('/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i',substr($useragent,0,4)))
{
?>
<video autoplay muted loop id="pv" style="z-index: -1">
	<source src="img/pv/mirrorstage.mp4" type="video/mp4">
</video>
<?php } ?>

<?php
	define("GF_HEADER", "aaaaa");
	require_once("common.php");
	
	$header_desc = "소전DB 거울단계 스토리";
	$header_title = "거울단계 | 소전DB";
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
					<img style="width: 100%" src="img/mirrorstage.jpg" alt="거울단계" />
				</div>
				
				<div class="col-12 item pb-5">
					<h2 class="mb-4 pb-1 border-bottom border-gray">Chapter 1. </h2>
					
					<div class="row">
						<div class="col-3 item">
               안젤리아
						</div>
						<div class="col-3 item">
              지휘관
						</div>
						<div class="col-3 item">
               외전
						</div>
						<div class="col-3 item">
              뉴스
						</div>
					</div>
          
          <div class="row">
						<div class="col-3 item">
              <a target="_blank" href="story.php?q=-44-A0-1">
								<span>알리바이</span>
							</a>
						</div>
						<div class="col-3 item">
							<a target="_blank" href="story.php?q=-44-B0-1">
								<span>셀레네의 꿈</span>
							</a>
						</div>
						<div class="col-3 item">
							
						</div>
						<div class="col-3 item">
							<a target="_blank" href="story.php?q=-44-N-0">
								<span>AM 10:00</span>
							</a>
						</div>
					</div>
          
          <div class="row">
						<div class="col-3 item">
              <a target="_blank" href="story.php?q=-44-A1-1">
								<span>화살 패러독스</span>
							</a>
						</div>
						<div class="col-3 item">
							<a target="_blank" href="story.php?q=-44-B1-1">
								<span>뱀과 엮여</span>
							</a>
						</div>
						<div class="col-3 item">
							<a target="_blank" href="story.php?q=-44-B1-1a">
								<span>오는자의 길</span>
							</a>
						</div>
						<div class="col-3 item">
						</div>
					</div>
          
          <div class="row">
						<div class="col-3 item">
              <a target="_blank" href="story.php?q=-44-A1-2">
								<span>토리첼리 트럼펫</span>
							</a>
						</div>
						<div class="col-3 item">
							<a target="_blank" href="story.php?q=-44-B1-2">
								<span>아파테의 탄생</span>
							</a>
						</div>
						<div class="col-3 item">
							<a target="_blank" href="story.php?q=-44-B1-1b">
								<span>생존 가이드</span>
							</a>
						</div>
						<div class="col-3 item">
							<a target="_blank" href="story.php?q=-44-N-0-a">
								<span>PM 08:03</span>
							</a>
						</div>
					</div>
          
          <div class="row">
						<div class="col-3 item">
              <a target="_blank" href="story.php?q=-44-A1-3">
								<span>미네르바의 부엉이</span>
							</a>
						</div>
						<div class="col-3 item">
							<a target="_blank" href="story.php?q=-44-B1-3">
								<span>헤메라가 이끄는 빛</span>
							</a>
						</div>
						<div class="col-3 item">
							<a target="_blank" href="story.php?q=-44-B1-2a">
								<span>잠복</span>
							</a>
						</div>
						<div class="col-3 item">
							<a target="_blank" href="story.php?q=-44-N-1">
								<span>PM 10:00</span>
							</a>
						</div>
					</div>
          
          <div class="row">
						<div class="col-3 item">

						</div>
						<div class="col-3 item">
							<a target="_blank" href="story.php?q=-44-B1-4">
								<span>환수의 어깨</span>
							</a>
						</div>
						<div class="col-3 item">
						</div>
						<div class="col-3 item">
							<a target="_blank" href="story.php?q=-44-N-1a">
								<span>PM 04:35</span>
							</a>
						</div>
					</div>
        </div>
        
        
        <div class="col-12 item pb-5">
					<h2 class="mb-4 pb-1 border-bottom border-gray">Chapter 2. </h2>
          
          <div class="row">
						<div class="col-3 item">
               안젤리아
						</div>
						<div class="col-3 item">
              지휘관
						</div>
						<div class="col-3 item">
               외전
						</div>
						<div class="col-3 item">
              뉴스
						</div>
					</div>
          
          <div class="row">
						<div class="col-3 item">
						</div>
						<div class="col-3 item">
							<a target="_blank" href="story.php?q=-44-B2-1">
								<span>테세우스의 배</span>
							</a>
						</div>
						<div class="col-3 item">
						</div>
						<div class="col-3 item">
						</div>
					</div>
          
          <div class="row">
						<div class="col-3 item">
              <a target="_blank" href="story.php?q=-44-A2-1">
								<span>공과 꽃병</span>
							</a>
						</div>
						<div class="col-3 item">
						</div>
						<div class="col-3 item">
						</div>
						<div class="col-3 item">
						</div>
					</div>
          
          <div class="row">
						<div class="col-3 item">
              <a target="_blank" href="story.php?q=-44-A2-2">
								<span>거짓말쟁이 역설</span>
							</a>
						</div>
						<div class="col-3 item">
							<a target="_blank" href="story.php?q=-44-B2-2">
								<span>아리아드네의 실타래</span>
							</a>
						</div>
						<div class="col-3 item">
							<a target="_blank" href="story.php?q=-44-A2-2a">
								<span>비친 모습</span>
							</a>
						</div>
						<div class="col-3 item">
							<a target="_blank" href="story.php?q=-44-N-2-1">
								<span>AM 10:00</span>
							</a>
						</div>
					</div>
          
          
          <div class="row">
						<div class="col-3 item">
              <a target="_blank" href="story.php?q=-44-A2-3">
								<span>헤라클레이토스의 강</span>
							</a>
						</div>
						<div class="col-3 item">
						</div>
						<div class="col-3 item">
							<a target="_blank" href="story.php?q=-44-A2-3a">
								<span>균열</span>
							</a>
						</div>
						<div class="col-3 item">
						</div>
					</div>
          
          <div class="row">
						<div class="col-3 item">
              <a target="_blank" href="story.php?q=-44-A2-4">
								<span>쌀알 소리</span>
							</a>
						</div>
						<div class="col-3 item">
							<a target="_blank" href="story.php?q=-44-B2-3">
								<span>크레타 미궁</span>
							</a>
						</div>
						<div class="col-3 item">
							<a target="_blank" href="story.php?q=-44-A2-4a">
								<span>밤 축제</span>
							</a>
						</div>
						<div class="col-3 item">
							<a target="_blank" href="story.php?q=-44-N-2-a">
								<span>PM 06:30</span>
							</a>
						</div>
					</div>
          
          <div class="row">
						<div class="col-3 item">
              <a target="_blank" href="story.php?q=-44-A2-5">
								<span>죄수의 딜레마</span>
							</a>
						</div>
						<div class="col-3 item">
							<a target="_blank" href="story.php?q=-44-B2-4">
								<span>디아 섬의 꿈</span>
							</a>
						</div>
						<div class="col-3 item">
						</div>
						<div class="col-3 item">
						</div>
					</div>
          
          <div class="row">
						<div class="col-3 item">
              <a target="_blank" href="story.php?q=-44-A2-1">
								<span>ㅁㅁㅁㅁㅁㅁㅁㅁ</span>
							</a>
						</div>
						<div class="col-3 item">
							<a target="_blank" href="story.php?q=-44-B2-1">
								<span>ㅁㅁㅁㅁㅁㅁㅁㅁㅁ</span>
							</a>
						</div>
						<div class="col-3 item">
							<a target="_blank" href="story.php?q=-44-A2-5a">
								<span>섬광</span>
							</a>
						</div>
						<div class="col-3 item">
							<a target="_blank" href="story.php?q=-44-N-2-a">
								<span>PM 11:07</span>
							</a>
						</div>
					</div>
        </div>
          
        
        <div class="col-12 item pb-5">
					<h2 class="mb-4 pb-1 border-bottom border-gray">Chapter 3. </h2>
          
          <div class="row">
						<div class="col-3 item">
               안젤리아
						</div>
						<div class="col-3 item">
              지휘관
						</div>
						<div class="col-3 item">
               외전
						</div>
						<div class="col-3 item">
              뉴스
						</div>
					</div>
          
          <div class="row">
						<div class="col-3 item">
              <a target="_blank" href="story.php?q=-44-A3-1">
								<span>크라틸루스의 강</span>
							</a>
						</div>
						<div class="col-3 item">
							<a target="_blank" href="story.php?q=-44-B3-1">
								<span>모이라이를 향한 반격</span>
							</a>
						</div>
						<div class="col-3 item">
						</div>
						<div class="col-3 item">
							<a target="_blank" href="story.php?q=-44-N-3-1">
								<span>AM 10:00</span>
							</a>
						</div>
					</div>
          
          <div class="row">
						<div class="col-3 item">
						</div>
						<div class="col-3 item">
							<a target="_blank" href="story.php?q=-44-B3-2">
								<span>클로토의 실</span>
							</a>
						</div>
						<div class="col-3 item">
						</div>
						<div class="col-3 item">
						</div>
					</div>
          
          <div class="row">
						<div class="col-3 item">
              <a target="_blank" href="story.php?q=-44-A3-2">
								<span>아킬레우스와 거북</span>
							</a>
						</div>
						<div class="col-3 item">
							<a target="_blank" href="story.php?q=-44-B3-3">
								<span>라케시스의 자</span>
							</a>
						</div>
						<div class="col-3 item">
						</div>
						<div class="col-3 item">
							<a target="_blank" href="story.php?q=-44-N-3-a">
								<span>PM 03:03</span>
							</a>
						</div>
					</div>
          
          <div class="row">
						<div class="col-3 item">
						</div>
						<div class="col-3 item">
							<a target="_blank" href="story.php?q=-44-B3-4">
								<span>아트로포스의 가위</span>
							</a>
						</div>
						<div class="col-3 item">
						</div>
						<div class="col-3 item">
						</div>
					</div>
          
          
          <div class="row">
						<div class="col-3 item">
              <a target="_blank" href="story.php?q=-44-A3-3">
								<span>제논의 동그라미</span>
							</a>
						</div>
						<div class="col-3 item">
						</div>
						<div class="col-3 item">
						</div>
						<div class="col-3 item">
							<a target="_blank" href="story.php?q=-44-N-3-b">
								<span>PM 11:01</span>
							</a>
						</div>
					</div>
          
				</div>
        
        
        <div class="col-12 item pb-5">
					<h2 class="mb-4 pb-1 border-bottom border-gray">Chapter 4. </h2>
          
          <div class="row">
						<div class="col-3 item">
               안젤리아
						</div>
						<div class="col-3 item">
              지휘관
						</div>
						<div class="col-3 item">
               외전
						</div>
						<div class="col-3 item">
              뉴스
						</div>
					</div>
          
          <div class="row">
            <div class="col-3 item">
              <a target="_blank" href="story.php?q=-44-A4-1">
                <span>슈레딩거의 고양이</span>
              </a>
            </div>
            <div class="col-3 item">
              <a target="_blank" href="story.php?q=-44-B4-1">
                <span>닉스의 밤</span>
              </a>
            </div>
            <div class="col-3 item">
            </div>
            <div class="col-3 item">
            </div>
          </div>
          
          <div class="row">
            <div class="col-3 item">
              <a target="_blank" href="story.php?q=-44-A4-2">
                <span>판도라 상자</span>
              </a>
            </div>
            <div class="col-3 item">
            </div>
            <div class="col-3 item">
              <a target="_blank" href="story.php?q=-44-A4-1a">
                <span>추억</span>
              </a>
            </div>
            <div class="col-3 item">
              <a target="_blank" href="story.php?q=-44-N-4-a">
                <span>AM 08:06</span>
              </a>
            </div>
          </div>
          
          <div class="row">
            <div class="col-3 item">
            </div>
            <div class="col-3 item">
              <a target="_blank" href="story.php?q=-44-B4-2">
                <span>히프노스의 눈</span>
              </a>
            </div>
            <div class="col-3 item">
            </div>
            <div class="col-3 item">
              <a target="_blank" href="story.php?q=-44-N-4-b">
                <span>AM 11:05</span>
              </a>
            </div>
          </div>
          
          <div class="row">
            <div class="col-3 item">
              <a target="_blank" href="story.php?q=-44-A4-3">
                <span>통속의 뇌</span>
              </a>
            </div>
            <div class="col-3 item">
              <a target="_blank" href="story.php?q=-44-B4-3">
                <span>타나토스의 키스</span>
              </a>
            </div>
            <div class="col-3 item">
            </div>
            <div class="col-3 item">
            </div>
          </div>
          
          <div class="row">
            <div class="col-3 item">
              <a target="_blank" href="story.php?q=-44-A4-4">
                <span>뫼비우스 고리</span>
              </a>
            </div>
            <div class="col-3 item">
              <a target="_blank" href="story.php?q=-44-B4-4">
                <span>무저갱 카오스</span>
              </a>
            </div>
            <div class="col-3 item">
            </div>
            <div class="col-3 item">
              <a target="_blank" href="story.php?q=-44-N-4-c">
                <span>PM 06:09</span>
              </a>
            </div>
          </div>
          
          <div class="row">
            <div class="col-3 item">
            </div>
            <div class="col-3 item">
            </div>
            <div class="col-3 item">
            </div>
            <div class="col-3 item">
              <a target="_blank" href="story.php?q=-44-N-4-d">
                <span>PM 11:01</span>
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