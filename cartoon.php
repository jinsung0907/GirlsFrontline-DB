<?php
	define("GF_HEADER", "aaaaa");
	require_once("header.php");
?>
    <main role="main" class="container">
		<div class="my-3 p-3 bg-white rounded box-shadow">
			<a href="https://twitter.com/crazycken">MADCORE</a>님의 소녀전선 로딩 만화입니다.<br>
			<div class="accordion" id="accordionLoad">
			<?php
			for($i = 1 ; $i<= 27 ; $i++) { ?>
				<div class="card">
					<div class="card-header" id="heading<?=$i?>">
						<h5 class="mb-0">
							<button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#loading<?=$i?>" aria-expanded="false" aria-controls="loading<?=$i?>">
								로딩만화 #<?=$i?>
							</button>
						</h5>
					</div>
					<div id="loading<?=$i?>" class="collapse" aria-labelledby="heading<?=$i?>" data-parent="#accordionLoad">
						<div class="card-body p-0">
							<img style="width:100%" src="/img/cartoon/loading/<?=$i?>.jpg"><br>
							<button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#loading<?=$i?>" aria-expanded="false" aria-controls="collapse<?=$i?>">닫기</button><br><br>
						</div>
					</div>
				</div>
			<?php } ?>
			</div>
		</div>
		
		<div class="my-3 p-3 bg-white rounded box-shadow">
			<div class="accordion" id="accordion4koma">
			<a href="https://twitter.com/crazycken">MADCORE</a>님의 소녀전선 공식 웹툰 "그리폰 일상만화"입니다. <a href="http://www.girlsfrontline.co.kr">소녀전선 공식홈페이지</a>에서 볼 수 있습니다.
			<?php
			for($i = 1 ; $i<= 23 ; $i++) { ?>
				<div class="card">
					<div class="card-header" id="heading<?=$i?>">
						<h5 class="mb-0">
							<button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#4koma<?=$i?>" aria-expanded="false" aria-controls="collapse<?=$i?>">
								그리폰 일상만화 #<?=$i?>
							</button>
						</h5>
					</div>
					<div id="4koma<?=$i?>" class="collapse" aria-labelledby="heading<?=$i?>" data-parent="#accordion4koma">
						<div class="card-body p-0">
							<img style="width:100%" src="/img/cartoon/4koma/4koma-<?=$i?>.jpg"><br>
							<button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#4koma<?=$i?>" aria-expanded="false" aria-controls="collapse<?=$i?>">닫기</button><br><br>
						</div>
					</div>
				</div>
			<?php } ?>
			</div>
		</div>
		
		<div class="my-3 p-3 bg-white rounded box-shadow">
			<div class="accordion" id="accordion4koma">
			<a href="https://twitter.com/crazycken">MADCORE</a>님의 소녀전선 공식 코믹 "그리폰 안내서"입니다. <a href="http://www.girlsfrontline.co.kr">소녀전선 공식홈페이지</a>에서 볼 수 있습니다.
			<?php
			for($i = 1 ; $i<= 17 ; $i++) { ?>
				<div class="card">
					<div class="card-header" id="heading<?=$i?>">
						<h5 class="mb-0">
							<button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#comic<?=$i?>" aria-expanded="false" aria-controls="collapse<?=$i?>">
								그리폰 안내서 #<?=$i?>
							</button>
						</h5>
					</div>
					<div id="comic<?=$i?>" class="collapse" aria-labelledby="heading<?=$i?>" data-parent="#accordioncomic">
						<div class="card-body p-0">
							<img style="width:100%" src="/img/cartoon/comic/<?=$i?>.jpg"><br>
							<button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#comic<?=$i?>" aria-expanded="false" aria-controls="collapse<?=$i?>">닫기</button><br><br>
						</div>
					</div>
				</div>
			<?php } ?>
			</div>
		</div>
    </main>
<?php
	require_once("footer.php");
?>
	</body>
</html>