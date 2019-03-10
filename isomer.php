<?php
$useragent=$_SERVER['HTTP_USER_AGENT'];
if(!preg_match('/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|mobile.+firefox|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows ce|xda|xiino/i',$useragent)||preg_match('/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i',substr($useragent,0,4)))
{
?>
<video autoplay muted loop id="pv" style="z-index: -1">
	<source src="img/pv/kr0214.mp4" type="video/mp4">
</video>
<?php } ?>


<?php
	define("GF_HEADER", "aaaaa");
	require_once("common.php");
	
	$header_desc = "소전DB 이성질체 스토리";
	$header_title = "이성질체 | 소전DB";
	require_once("header.php");
?>
    <style>
      #pv {
        position: fixed;
        right: 0;
        bottom: 0;
        min-width: 100%; 
        min-height: 100%;
      }
      
      @media all and (min-width: 760px) {
        .container-fluid[role=main] {
          opacity: 0.9;
        }
        .container-fluid[role=main] h2, .container-fluid[role=main] span, .container-fluid[role=main] img {
          opacity: 1!important;
        }
      }
    
      .isomer {
        color: white;
        overflow-x: auto;
      }          
    </style>
    <meta name="viewport" content="width=1440">
    <main role="main" class="container-fluid">
      <div class="isomer my-3 p-3 rounded box-shadow" >
        너무 바쁘고 귀찮아서 사진으로 땜빵함.. <a href="https://gall.dcinside.com/mgallery/board/view/?id=micateam&no=842589">사진 출처</a> ㄳㄳ &nbsp;&nbsp;모바일은 걍 폰 눕혀서 봐
        <img src="img/isomer.jpg" usemap="#isomer">
        <map name="isomer">
          <area shape="rect" coords="300,300,570,360" target="_blank" href="story.php?q=-31-0">
          
          <area shape="rect" coords="650,160,990,250" target="_blank" href="story.php?q=-31-1a1">
          <area shape="rect" coords="1070,220,1413,300" target="_blank" href="story.php?q=-31-1a11">
          <area shape="rect" coords="1339,110,1751,200" target="_blank" href="story.php?q=-31-1a2">
          <area shape="rect" coords="1770,18,2100,100" target="_blank" href="story.php?q=-31-1a21">
          <area shape="rect" coords="2329,111,2649,200" target="_blank" href="story.php?q=-31-1a3">
          <area shape="rect" coords="3679,100,3991,200" target="_blank" href="story.php?q=-31-1a4">
          <area shape="rect" coords="4085,64,4385,150" target="_blank" href="story.php?q=-31-1a5">
          
          <area shape="rect" coords="1955,285,2296,374" target="_blank" href="story.php?q=-31-1b1">
          <area shape="rect" coords="2494,285,2835,374" target="_blank" href="story.php?q=-31-1b2">
          <area shape="rect" coords="3040,285,3355,374" target="_blank" href="story.php?q=-31-1b3">
          <area shape="rect" coords="3383,230,3727,320" target="_blank" href="story.php?q=-31-1b31">
          <area shape="rect" coords="4026,350,4280,430" target="_blank" href="story.php?q=-31-1b4">
          
          <area shape="rect" coords="2690,480,3046,590" target="_blank" href="story.php?q=-31-1c1">
          <area shape="rect" coords="3094,480,3365,590" target="_blank" href="story.php?q=-31-1c2">
          <area shape="rect" coords="3468,480,3752,590" target="_blank" href="story.php?q=-31-1c3">
          <area shape="rect" coords="4014,480,4382,590" target="_blank" href="story.php?q=-31-1c4">
          
          <area shape="rect" coords="4444,40,4760,141" target="_blank" href="story.php?q=-31-2a1">
          <area shape="rect" coords="4781,18,5090,100" target="_blank" href="story.php?q=-31-2a11">
          <area shape="rect" coords="5151,18,5460,100" target="_blank" href="story.php?q=-31-2a12">
          <area shape="rect" coords="5864,144,6120,230" target="_blank" href="story.php?q=-31-2a2">
          <area shape="rect" coords="6220,0,6555,80" target="_blank" href="story.php?q=-31-2a21">
          <area shape="rect" coords="6860,125,7230,227" target="_blank" href="story.php?q=-31-2a3">
          
          <area shape="rect" coords="4440,285,4770,385" target="_blank" href="story.php?q=-31-2b1">
          <area shape="rect" coords="5510,235,5837,320" target="_blank" href="story.php?q=-31-2b11">
          <area shape="rect" coords="5858,340,6200,430" target="_blank" href="story.php?q=-31-2b2">
          <area shape="rect" coords="6220,300,6480,370" target="_blank" href="story.php?q=-31-2b3">
          <area shape="rect" coords="6570,300,6909,380" target="_blank" href="story.php?q=-31-2b4">
          
          <area shape="rect" coords="4430,480,4772,590" target="_blank" href="story.php?q=-31-2c1">
          <area shape="rect" coords="5500,480,5855,590" target="_blank" href="story.php?q=-31-2c2">
          <area shape="rect" coords="5500,480,5855,590" target="_blank" href="story.php?q=-31-2c2">
          
          <area shape="rect" coords="7300,110,7610,200" target="_blank" href="story.php?q=-31-3a1">
          <area shape="rect" coords="8361,110,8687,200" target="_blank" href="story.php?q=-31-3a2">
          <area shape="rect" coords="9066,110,9400,200" target="_blank" href="story.php?q=-31-3a3">
          
          <area shape="rect" coords="7300,280,7610,400" target="_blank" href="story.php?q=-31-3b1">
          <area shape="rect" coords="7990,280,8333,400" target="_blank" href="story.php?q=-31-3b2">
          <area shape="rect" coords="8356,280,8616,400" target="_blank" href="story.php?q=-31-3b3">
          <area shape="rect" coords="9418,280,9750,400" target="_blank" href="story.php?q=-31-3b4">
          <area shape="rect" coords="9760,344,10114,443" target="_blank" href="story.php?q=-31-3b5">
          <area shape="rect" coords="10121,344,10460,443" target="_blank" href="story.php?q=-31-3b6">
          <area shape="rect" coords="10497,344,10826,443" target="_blank" href="story.php?q=-31-3b7">
          
          <area shape="rect" coords="10853,475,11218,600" target="_blank" href="story.php?q=-31-3c1">
          <area shape="rect" coords="11235,475,11544,600" target="_blank" href="story.php?q=-31-3c2">
          <area shape="rect" coords="11636,344,11994,443" target="_blank" href="story.php?q=-31-3c21">
          <area shape="rect" coords="12000,475,12300,600" target="_blank" href="story.php?q=-31-3c3">
          <area shape="rect" coords="12447,420,12730,520" target="_blank" href="story.php?q=-31-3c4">
          <area shape="rect" coords="12790,420,13080,520" target="_blank" href="story.php?q=-31-3c5">
          <area shape="rect" coords="13166,420,13536,520" target="_blank" href="story.php?q=-31-3c6">
          <area shape="rect" coords="13511,290,13866,395" target="_blank" href="story.php?q=-31-3c61">
          <area shape="rect" coords="13820,420,14200,520" target="_blank" href="story.php?q=-31-3c62">
          
          <area shape="rect" coords="13149,85,13491,230" target="_blank" href="story.php?q=-31-4">
        </map>
		</div>
    </main>
<?php
	require_once("footer.php");
?>
	</body>
</html>