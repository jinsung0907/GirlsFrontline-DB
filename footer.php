<?php if(GF_HEADER != "aaaaa") exit; ?>
    <script src="dist/jquery-3.3.1.min.js"></script>
    <script src="dist/jquery.lazy.min.js"></script>
    <script src="dist/popper.min.js"></script>
    <script src="dist/bootstrap.min.js"></script>
	<script>
		$(function () {
			$('[data-toggle="tooltip"]').tooltip()
		})
		function sel_lang(val) {
			window.location.href = 'http://<?=$_SERVER['HTTP_HOST']?>?lang=' + val;
		}
	</script>
	<select onchange="sel_lang(this.value)">
		<option>Languages</option>
		<option value='ko'>Korean(한국어)</option>
		<option value='en'>English</option>
	</select>
	<small>해당 사이트는 '소녀전선'의 데이터를 기반으로 작성되었으며, 그에 관련한 모든 저작권, 권리는 SUNBORN Network Technology, Digital Sky Entertainment, 哔哩哔哩, X.D. global에게 귀속되어있습니다.</small>