<?php
	define("GF_HEADER", "aaaaa");
	require_once("common.php");
	$header_desc = L::sitetitle_short . " " . L::diskcalc_reportcalc . ", " . L::diskcalc_sreportcalc;
	$header_keyword =  L::sitetitle_short . " " . L::diskcalc_reportcalc . ", " . L::diskcalc_sreportcalc;;
	$header_title = L::diskcalc_reportcalc . " | " . L::sitetitle_short;
	require_once("header.php");
?>
    <main role="main" class="container">
		<div class="my-3 p-3 bg-white rounded box-shadow">
			<h2><?=L::diskcalc_reportcalc?></h2>
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
		
		<div class="my-3 p-3 bg-white rounded box-shadow">
			<h2><?=L::diskcalc_sreportcalc?></h2>
			<form id="squadexp">
				<div class="row">
					<div class="col-md-2">
						<span class="label"><?=L::diskcalc_trgrlevel?></span>
					</div>
					<div class="col-md-10">
						<input type="number" name="trainlv">
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
			<div class="squadresultWrap"></div>
		</div>
    </main>
<?php
	require_once("footer.php");
?>
	<script>
		var dollexp=[0,100,200,300,400,500,600,700,800,900,1000,1100,1200,1300,1400,1500,1600,1700,1800,1900,2000,2100,2200,2300,2400,2500,2600,2800,3100,3400,4200,4600,5000,5400,5800,6300,6700,7200,7700,8200,8800,9300,9900,10500,11100,11800,12500,13100,13900,14600,15400,16100,16900,17700,18600,19500,20400,21300,22300,23300,24300,25300,26300,27400,28500,29600,30800,32000,33200,34400,45100,46800,48600,50400,52200,54000,55900,57900,59800,61800,63900,66000,68100,70300,72600,74800,77100,79500,81900,84300,112600,116100,119500,123100,126700,130400,134100,137900,141800,145700,100000,120000,140000,160000,180000,200000,220000,240000,280000,360000,480000,640000,900000,1200000,1600000,2200000,3000000,4000000,5000000,6000000];
		var marrylist=[0,100,200,300,400,500,600,700,800,900,1000,1100,1200,1300,1400,1500,1600,1700,1800,1900,2000,2100,2200,2300,2400,2500,2600,2800,3100,3400,4200,4600,5000,5400,5800,6300,6700,7200,7700,8200,8800,9300,9900,10500,11100,11800,12500,13100,13900,14600,15400,16100,16900,17700,18600,19500,20400,21300,22300,23300,24300,25300,26300,27400,28500,29600,30800,32000,33200,34400,45100,46800,48600,50400,52200,54000,55900,57900,59800,61800,63900,66000,68100,70300,72600,74800,77100,79500,81900,84300,112600,116100,119500,123100,126700,130400,134100,137900,141800,145700,50000,60000,70000,80000,90000,100000,110000,120000,140000,180000,240000,320000,450000,600000,800000,1100000,1500000,2000000,2500000,3000000];
		var fairylist=[0,300,600,900,1200,1500,1800,2100,2400,2700,3000,3300,3600,3900,4200,4500,4800,5100,5400,5700,6000,6300,6600,6900,7200,7500,7800,8400,9300,10200,12600,13800,15000,16200,17400,18900,20100,21600,23100,24600,26400,27900,29700,31500,33300,35400,37500,39300,41700,43800,46200,48300,50700,53100,55800,58500,61200,63900,66900,69900,72900,75900,78900,82200,85500,88800,92400,96000,99600,103200,135300,140400,145800,151200,156600,162000,167700,173700,179400,185400,191700,198000,204300,210900,217800,224400,231300,238500,245700,252900,337800,348300,358500,369300,380100,391200,402300,413700,425400,437100,300000,360000,420000,480000,540000,600000,660000,720000,840000,1080000,1440000,1920000,2700000,3600000,4800000,6600000,9000000,12000000,15000000,18000000];
		var squadlist=[0,500,1400,2700,4500,6700,9400,12600,16200,20200,24700,29700,35100,40900,47200,54000,61200,68800,77100,86100,95900,106500,118500,132000,147000,163500,181800,201900,223900,247900,274200,302500,333300,366600,402400,441000,482400,526600,574000,624600,678400,735700,796500,861000,929200,1001500,1077900,1158400,1243300,1332700,1426800,1525600,1629400,1738300,1852300,1971800,2096700,2227200,2363500,2505900,2654400,2809000,2970100,3137800,3312300,3493800,3682300,3877800,4080800,4291400,4509600,4735800,4970000,5212500,5463300,5722800,5990800,6267800,6553800,6849300,7154000,7468500,7792500,8127000,8471000,8826000,9191000,9567000,9954000,10352000,10761000,11182000,11614000,12058000,12514000,12983000,13464000,13957000,14463000,15000000];
		
		$('#exp').on('submit', function(e){
			e.preventDefault();
			$('.resultWrap').hide();
			var type = Number( $('#exp').find('select[name=type]').val() );
			var nowlv = Number( $('#exp').find('input[name=curlevel]').val() );
			var nowexp = Number( $('#exp').find('input[name=curexp]').val() );
			var target = Number( $('#exp').find('input[name=targetlevel]').val() );

			if ( target > 120 ) {
				alert('<?=L::diskcalc_levellimit(120)?>');
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
			$(".resultWrap").html("<?=L::diskcalc_leftexp?>: "+totalexp+"<br><?=L::diskcalc_diskneed?>: "+rps+"<?=L::diskcalc_cnt?>, <?=L::diskcalc_battneed?> " + (rps*3));
			$('.resultWrap').show();
			return false;
		});
		
		$('#squadexp').on('submit', function(e){
			e.preventDefault();
			$('.squadresultWrap').hide();
			var trainlv = Number( $('#squadexp').find('input[name=trainlv]').val() );
			var nowlv = Number( $('#squadexp').find('input[name=curlevel]').val() );
			var nowexp = Number( $('#squadexp').find('input[name=curexp]').val() );
			var target = Number( $('#squadexp').find('input[name=targetlevel]').val() );

			if ( target > 100 ) {
				alert('<?=L::diskcalc_levellimit(100)?>');
				return false;
			}
			
			var totalexp = 0;
			totalexp+=squadlist[target-1];
			totalexp-=squadlist[nowlv-1];
			totalexp-=nowexp;
			
			
			var consume;
			switch(trainlv) {
				case 0: consume = 1; break;
				case 1:
				case 2: consume = 3; break;
				case 3: consume = 5; break;
				case 4:
				case 5: consume = 7; break;
				case 6: consume = 9; break;
				case 7:
				case 8: consume = 11; break;
				case 9: consume = 13; break;
				case 10: consume = 15; break;
			}
			
			var rps = Math.ceil(totalexp/3000);
			var hours = Math.ceil(rps/consume);
			var batt = (rps*3) + (hours*5);
			$(".squadresultWrap").html("<?=L::diskcalc_leftexp?>: "+totalexp+"<br><?=L::diskcalc_sdiskneed?>: "+rps+"<?=L::diskcalc_cnt?>, <?=L::diskcalc_hoursneed?> : " + hours + "<?=L::diskcalc_hours?><br><?=L::diskcalc_battneed?> : " + batt+ "(<?=L::diskcalc_sdisk?>:" + (rps*3) + ", <?=L::diskcalc_trgr?>:" + (hours*5) + ")");
			$('.squadresultWrap').show();
			return false;
		});
	</script>
	</body>
</html>


