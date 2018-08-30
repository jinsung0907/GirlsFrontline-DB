<?php
	define("GF_HEADER", "aaaaa");
	require_once("common.php");
	require_once("header.php");
	
	$dolls = json_decode(file_get_contents("data/doll.json"));

	$missing_name = '';
	$missing_skill = '';

	foreach($dolls as $doll) {
		//이름
		if($doll->id < 20000) {
			if(!isset($doll->jpName)) {
				$missing_name .= "(" . $doll->id . ") " . $doll->name . " JPname missing";
				$missing_name .= "<br>";
			}
			if(!isset($doll->krName)) {
				$missing_name .= "(" . $doll->id . ") " . $doll->name . " KRname missing";
				$missing_name .= "<br>";
			}
			if(!isset($doll->enName)) {
				$missing_name .= "(" . $doll->id . ") " . $doll->name . " ENname missing";
				$missing_name .= "<br>";
			}
		}
		
		//스킬
		if(isset($doll->skill)) {
			if(!isset($doll->skill->realid)) {
				$missing_skill .= "(" . $doll->id . ") " . $doll->name . " rskillid missing";
				$missing_skill .= "<br>";
			}
			if(!isset($doll->skill->id)) {
				$missing_skill .= "(" . $doll->id . ") " . $doll->name . " skillid missing";
				$missing_skill .= "<br>";
			}
			if(!isset($doll->skill->dataPool)) {
				$missing_skill .= "(" . $doll->id . ") " . $doll->name . " skilll dataPool missing";
				$missing_skill .= "<br>";
			}
		}
		else {
			$missing_skill .= "(" . $doll->id . ") " . $doll->name . " skill missing";
			$missing_skill .= "<br>";
		}
		if(isset($doll->skill2)) {
			if(!isset($doll->skill2->realid)) {
				$missing_skill .= "(" . $doll->id . ") " . $doll->name . " mod2 rskillid missing";
				$missing_skill .= "<br>";
			}
		}
		else {
			if($doll->id > 20000) {
				$missing_skill .= "(" . $doll->id . ") " . $doll->name . " mod2 skill missing";
				$missing_skill .= "<br>";
			}
		}
	}
?>
    <main role="main" class="container">
		<div class="my-3 p-3 bg-white rounded box-shadow">
			<h2>dollname</h2>
			<?=$missing_name?>
			<br><br><br>
			<h2>dollskill</h2>
			<?=$missing_skill?>
		</div>
    </main>
<?php
	require_once("footer.php");
?>
	</body>
</html>