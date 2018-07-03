<?php
	define("GF_HEADER", "aaaaa");
	$header_desc = "디스크 계산기, 작전 보고서 계산기, 작보 계산기, 소녀전선 경험치 계산기";
	$header_title = "작전 보고서 계산기 | 소전DB";
	require_once("header.php");
?>
    <main role="main" class="container">
		<div class="my-3 p-3 bg-white rounded box-shadow">
				<form id="exp">
					<div class="row">
						<div class="col-md-2">
							<span class="label"><?=L::diskcalc_type?></span>
						</div>
						<div class="col-md-10">
							<select name="type">
								<option value="1"><?=L::diskcalc_type_doll?></option>
								<option value="2"><?=L::diskcalc_type_marrydoll?></option>
								<option value="3"><?=L::diskcalc_type_fairy?></option>
							</select>
						</div>
					</div>
					<div class="row">
						<div class="col-md-2">
							<span class="label"><?=L::diskcalc_curlevel?></span>
						</div>
						<div class="col-md-10">
							<input type="number" name="curlevel">
						</div>
					</div>
					<div class="row">
						<div class="col-md-2">
							<span class="label"><?=L::diskcalc_curexp?></span>
						</div>
						<div class="col-md-10">
							<input type="number" name="curexp">
						</div>
					</div>
					<div class="row">
						<div class="col-md-2">
							<span class="label"><?=L::diskcalc_targetlevel?></span>
						</div>
						<div class="col-md-10">
							<input type="number" name="targetlevel">
						</div>
					</div>
					<div class="line">
						<input type="submit" class="submit" value="<?=L::diskcalc_docalc?>">
					</div>
				</form><br>
				<div class="resultWrap"></div>
		</div>
    </main>
<?php
	require_once("footer.php");
?>
	<script>
		var dollexp=[0,100,200,300,400,500,600,700,800,900,1000,1100,1200,1300,1400,1500,1600,1700,1800,1900,2000,2100,2200,2300,2400,2500,2600,2800,3100,3400,4200,4600,5000,5400,5800,6300,6700,7200,7700,8200,8800,9300,9900,10500,11100,11800,12500,13100,13900,14600,15400,16100,16900,17700,18600,19500,20400,21300,22300,23300,24300,25300,26300,27400,28500,29600,30800,32000,33200,34400,45100,46800,48600,50400,52200,54000,55900,57900,59800,61800,63900,66000,68100,70300,72600,74800,77100,79500,81900,84300,112600,116100,119500,123100,126700,130400,134100,137900,141800,145700,100000,120000,140000,160000,180000,200000,220000,240000,280000,360000,480000,640000,900000,1200000,1600000,2200000,3000000,4000000,5000000,6000000];
		var marrylist=[0,100,200,300,400,500,600,700,800,900,1000,1100,1200,1300,1400,1500,1600,1700,1800,1900,2000,2100,2200,2300,2400,2500,2600,2800,3100,3400,4200,4600,5000,5400,5800,6300,6700,7200,7700,8200,8800,9300,9900,10500,11100,11800,12500,13100,13900,14600,15400,16100,16900,17700,18600,19500,20400,21300,22300,23300,24300,25300,26300,27400,28500,29600,30800,32000,33200,34400,45100,46800,48600,50400,52200,54000,55900,57900,59800,61800,63900,66000,68100,70300,72600,74800,77100,79500,81900,84300,112600,116100,119500,123100,126700,130400,134100,137900,141800,145700,50000,60000,70000,80000,90000,100000,110000,120000,140000,180000,240000,320000,450000,600000,800000,1100000,1500000,2000000,2500000,3000000];
		var fairylist=[0,300,600,900,1200,1500,1800,2100,2400,2700,3000,3300,3600,3900,4200,4500,4800,5100,5400,5700,6000,6300,6600,6900,7200,7500,7800,8400,9300,10200,12600,13800,15000,16200,17400,18900,20100,21600,23100,24600,26400,27900,29700,31500,33300,35400,37500,39300,41700,43800,46200,48300,50700,53100,55800,58500,61200,63900,66900,69900,72900,75900,78900,82200,85500,88800,92400,96000,99600,103200,135300,140400,145800,151200,156600,162000,167700,173700,179400,185400,191700,198000,204300,210900,217800,224400,231300,238500,245700,252900,337800,348300,358500,369300,380100,391200,402300,413700,425400,437100,300000,360000,420000,480000,540000,600000,660000,720000,840000,1080000,1440000,1920000,2700000,3600000,4800000,6600000,9000000,12000000,15000000,18000000];
		
		$('#exp').on('submit', function(e){
			e.preventDefault();
			$('.resultWrap').hide();
			var type = Number( $('select[name=type]').val() );
			var nowlv = Number( $('input[name=curlevel]').val() );
			var nowexp = Number( $('input[name=curexp]').val() );
			var target = Number( $('input[name=targetlevel]').val() );

			if ( target > 120 ) {
				alert('목표 레벨은 120 이하로 설정 해주세요.');
				return false;
			}
			
			var totalexp = 0;
			for(i=nowlv;i<target;i++) {
				switch(type) {
					case 1: totalexp+=dollexp[i]; break;
					case 2: totalexp+=marrylist[i]; break;
					case 3: totalexp+=fairylist[i]; break;
				}
			}
			totalexp-=nowexp;

			var rps = Math.ceil(totalexp/3000);
			$(".resultWrap").html("남은 경험치: "+totalexp+"<br>필요 작전보고서: "+rps+"개, 소요전지 " + (rps*3));
			$('.resultWrap').show();
			return false;
		});
	</script>
	</body>
</html>


