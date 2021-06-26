<?php
	define("GF_HEADER", "aaaaa");
	require_once("common.php");
	
	$header_title = L::gfl . " " . L::navigation_menu_mainstory . " | " . L::sitetitle_short;
	$header_desc = L::title_storylist_desc; 
	$header_keyword = L::title_storylist_keyword; 
	require_once("header.php");
	
	if($lang != "ko")
		$storys = json_decode(file_get_contents("story_json/$lang/story.txt"));
	else 
		$storys = json_decode(file_get_contents("story_json/story.txt"));
?>
    <main role="main" class="container">
		<div class="my-3 p-3 bg-white rounded box-shadow">
			<h2 style="display: inline;margin-right:10px"><?=L::story_prologue?></h2>
			<h6 class="border-bottom border-gray pb-2 mb-0"></h6>
			<div class="media text-muted pt-3">
				<p class="media-body pb-3 mb-0 small lh-125 border-bottom border-gray">
					<a target="_blank" href="story.php?q=1001"><strong class="d-block text-dark"><?=L::story_prologue?></strong></a>
				</p>
			</div>
		</div>
	<?php foreach($storys as $story) {
    switch ($story->num) {
      case -1:
      case -7: $bgimg = "/img/title/missionselect_Cube_base.png"; break;
      case -2:
      case -3:
      case -4: 
      case -5: $bgimg = "/img/title/missionselect_Arctic_base.png"; break;
      case -8: $bgimg = "/img/title/missionselect_RabbitHunt.png"; break;
      case -10: 
      case -11: 
      case -12: 
      case -12: 
      case -13: $bgimg = "/img/title/missionselect_DeepDive_base.png"; break;
      case -19: 
      case -20: $bgimg = "/img/title/missionselect_GloryDay_base.png"; break;
      case -32: $bgimg = "/img/title/missionselect_VA11.png"; break;
      case -33: $bgimg = "/img/title/missionselect_Reversible_base.png"; break;
      case -34: $bgimg = "/img/title/missionselect_Halloween_base.png"; break;
      case -35: $bgimg = "/img/title/missionselect_Xmas_base.png"; break;
      case -37: $bgimg = "/img/title/missionselect_WhiteDay2020_base.png"; break;
      case -38: $bgimg = "/img/title/missionselect_GunslingerGirl_base.png"; break;
      case -40: $bgimg = "/img/title/missionSelect_Bikini_2020_base.png"; break;
      case -41: $bgimg = "/img/title/missionselect_Dual Randomness_base.png"; break;
      case -42: $bgimg = "/img/title/missionselect_Halloween2020_base.png"; break;
      case -43: $bgimg = "/img/title/missionselect_TheDivision_base.png"; break;
      case -44: $bgimg = "/img/title/missionselect_MirrorStage_base.png"; break;
      default: $bgimg = "/img/title/chapter{$story->num}_base.png"; break;
    }


    if($story->num == -16) echo '<div class="card mb-3">
        <div class="card-header p-0 story-header" style="background-image: url(\'/img/title/missionselect_Sing_base.png\');" data-toggle="collapse" data-target="#story_singularity">
          <div class="p-3">
            <h3 id="singularity">(대형이벤트) 특이점</h3>
          </div>
        </div>
        <div id="story_singularity" class="collapse">
          <div class="card-body">
            <div class="text-muted">
              <p class="small">
                <a target="_blank" href="singularity.php"><strong class="d-block text-dark">특이점</strong></a>
              </p>
            </div>
          </div>
        </div>
      </div>';
    if($story->num == -16 || $story->num == -17 || $story->num == -18) continue;
    if($story->num == -24) echo '<div class="card mb-3">
      <div class="card-header p-0 story-header" style="background-image: url(\'/img/title/missionselect_ContinuumTurbulence_base.png\');" data-toggle="collapse" data-target="#story_continuum_turbulence">
        <div class="p-3">
          <h3 id="singularity">(대형이벤트) 난류연속</h3>
        </div>
      </div>
      <div id="story_continuum_turbulence" class="collapse">
        <div class="card-body">
          <div class="text-muted">
            <p class="small">
              <a target="_blank" href="continuum_turbulence.php"><strong class="d-block text-dark">난류연속</strong></a>
            </p>
          </div>
        </div>
      </div>
    </div>';
		if($story->num == -24 || $story->num == -25 || $story->num == -26 || $story->num == -27 || $story->num == -28) continue;
    if($story->num == -31) echo '<div class="card mb-3">
      <div class="card-header p-0 story-header" style="background-image: url(\'/img/title/missionselect_Isomer_base.png\');" data-toggle="collapse" data-target="#story_isomer">
        <div class="p-3">
          <h3 id="singularity">(대형이벤트) 이성질체</h3>
        </div>
      </div>
      <div id="story_isomer" class="collapse">
        <div class="card-body">
          <div class="text-muted">
            <p class="small">
              <a target="_blank" href="isomer.php"><strong class="d-block text-dark">이성질체</strong></a>
            </p>
          </div>
        </div>
      </div>
    </div>';
    if($story->num == -31) continue;
    if($story->num == -31) echo '<div class="card mb-3">
      <div class="card-header p-0 story-header" style="background-image: url(\'/img/title/missionselect_PolarizedLight_base.png\');" data-toggle="collapse" data-target="#story_polarizedlight">
        <div class="p-3">
          <h3 id="singularity">(대형이벤트) 편극광</h3>
        </div>
      </div>
      <div id="story_polarizedlight" class="collapse">
        <div class="card-body">
          <div class="text-muted">
            <p class="small">
              <a target="_blank" href="polarizedlight.php"><strong class="d-block text-dark">편극광</strong></a>
            </p>
          </div>
        </div>
      </div>
    </div>';		
		if($story->num == -36) continue;
    if($story->num == -44) continue;
    if($story->num == -44) echo '<div class="card mb-3">
      <div class="card-header p-0 story-header" style="background-image: url(\'/img/title/missionselect_MirrorStage_base.png\');" data-toggle="collapse" data-target="#story_mirrorstage">
        <div class="p-3">
          <h3 id="singularity">(대형이벤트) 거울단계</h3>
        </div>
      </div>
      <div id="story_mirrorstage" class="collapse">
        <div class="card-body">
          <div class="text-muted">
            <p class="small">
              <a target="_blank" href="mirrorstage.php"><strong class="d-block text-dark">거울단계</strong></a>
            </p>
          </div>
        </div>
      </div>
    </div>';		
		?>

   <div class="card mb-3">
      <div class="card-header p-0 story-header" style="background-image: url('<?=$bgimg?>');" data-toggle="collapse" data-target="#story_<?=$story->num?>">
        <div class="p-3">
          <h3 id="<?=$story->name?>" ><?=$story->name?> : <?=$story->keyword?></h3><b><i><?=$story->desc?></i></b>
        </div>
      </div>

      <div id="story_<?=$story->num?>" class="collapse">
        <div class="card-body">
          <div class="text-muted">
            <p class="small">
          <?php foreach($story->list as $list) { 
              if($list->type == "일반") {
                $typename = L::story_normal;
                $href = $list->num;
              } else if($list->type == "긴급") {
                $typename = L::story_emergency;
                $href = $list->num . "E";
              } else if($list->type == "야간") {
                $typename = L::story_night;
                $href = $list->num . "N";
              }
              
              if($list->num < 0) {
                $typename = L::story_event;
                $list->num = "";
              }
              
              if($list-> num > 1000) {
                $typename = L::story_prologue;
                $list->num = "";
              }
              
          ?>
              <a target="_blank" href="story.php?q=<?=$href?>"><strong class="d-block text-dark">(<?=$typename?>) <?=$list->num?> - <?=$list->name?></strong></a>
              <i><?=$list->desc?></i><br><br>
          <?php } ?>
            </p>
          </div>
        </div>
      </div>
    </div>

<!--
		<div class="my-3 p-3 bg-white rounded box-shadow" style="background-image: url('/img/title/chapter<?=$story->num?>_base.png'); background-repeat: no-repeat;">
			<div style="cursor:pointer;" data-toggle="collapse" >
        <h3 id="<?=$story->name?>" style="display: inline;margin-right:10px;"><?=$story->name?> : <?=$story->keyword?></h3><b><i><?=$story->desc?></i></b>
      </div>
      <div id="story_<?=$story->num?>" class='collapse'>
        <h6 class="border-bottom border-gray pb-2 mb-0"></h6>
        <div class="media text-muted pt-3">
          <p class="media-body pb-3 mb-0 small lh-125 border-bottom border-gray">
        <?php foreach($story->list as $list) { 
            if($list->type == "일반") {
              $typename = L::story_normal;
              $href = $list->num;
            } else if($list->type == "긴급") {
              $typename = L::story_emergency;
              $href = $list->num . "E";
            } else if($list->type == "야간") {
              $typename = L::story_night;
              $href = $list->num . "N";
            }
            
            if($list->num < 0) {
              $typename = L::story_event;
              $list->num = "";
            }
            
            if($list-> num > 1000) {
              $typename = L::story_prologue;
              $list->num = "";
            }
            
        ?>
            <a target="_blank" href="story.php?q=<?=$href?>"><strong class="d-block text-dark">(<?=$typename?>) <?=$list->num?> - <?=$list->name?></strong></a>
            <i><?=$list->desc?></i><br><br>
        <?php } ?>
          </p>
        </div>
      </div>
		</div> -->
	<?php } ?>
    </main>
<?php
	require_once("footer.php");
?>
	</body>
</html>