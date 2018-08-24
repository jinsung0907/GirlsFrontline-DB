<?php if(GF_HEADER != "aaaaa") exit; ?>
    <script src="dist/jquery-3.3.1.min.js"></script>
    <script src="dist/jquery.lazy.min.js"></script>
    <script src="dist/popper.min.js"></script>
    <script src="dist/bootstrap.min.js"></script>
	<script src="dist/outdatedbrowser/outdatedbrowser.min.js"></script>
	<script>
		$(function () {
			$('[data-toggle="tooltip"]').tooltip()
			var lang = '<?=$lang?>';
			updateLangStringParam('lang', lang);
		})

		function sel_lang(val) {
			updateQueryStringParam('lang', val);
		}
		
		var updateQueryStringParam = function (key, value) {
			var baseUrl = [location.protocol, '//', location.host, location.pathname].join(''),
				urlQueryString = document.location.search,
				newParam = key + '=' + value,
				params = '?' + newParam;
			if (urlQueryString) {
				var updateRegex = new RegExp('([\?&])' + key + '[^&]*');
				var removeRegex = new RegExp('([\?&])' + key + '=[^&;]+[&;]?');

				if( typeof value == 'undefined' || value == null || value == '' ) {
					params = urlQueryString.replace(removeRegex, "$1");
					params = params.replace( /[&;]$/, "" );

				} else if (urlQueryString.match(updateRegex) !== null) {
					params = urlQueryString.replace(updateRegex, "$1" + newParam);

				} else {
					params = urlQueryString + '&' + newParam;
				}
			}
			params = params == '?' ? '' : params;
			window.location.href = baseUrl + params;
		};
		
		var updateLangStringParam = function (key, value) {
			var baseUrl = [location.protocol, '//', location.host, location.pathname].join(''),
				urlQueryString = document.location.search,
				newParam = key + '=' + value,
				params = '?' + newParam;
			if (urlQueryString) {
				var updateRegex = new RegExp('([\?&])' + key + '[^&]*');
				var removeRegex = new RegExp('([\?&])' + key + '=[^&;]+[&;]?');

				if( typeof value == 'undefined' || value == null || value == '' ) {
					params = urlQueryString.replace(removeRegex, "$1");
					params = params.replace( /[&;]$/, "" );

				} else if (urlQueryString.match(updateRegex) !== null) {
					params = urlQueryString.replace(updateRegex, "$1" + newParam);

				} else {
					params = urlQueryString + '&' + newParam;
				}
			}
			params = params == '?' ? '' : params;
			window.history.replaceState("", "", params);
		};

		$( document ).ready(function() {
			outdatedBrowser({
				bgColor: '#f25648',
				color: '#ffffff',
				lowerThan: 'IE11',
				languagePath: 'dist/outdatedbrowser/lang/<?=$lang?>.html'
			})
		})
	</script>
	<select onchange="sel_lang(this.value)">
		<option>Languages</option>
		<option value='ko'>Korean(한국어)</option>
		<option value='en'>English</option>
		<option value='ja'>Japanese</option>
	</select>
	<small>해당 사이트는 '소녀전선'의 데이터를 기반으로 작성되었으며, 그에 관련한 모든 저작권, 권리는 SUNBORN Network Technology, Digital Sky Entertainment, 哔哩哔哩, X.D. global에게 귀속되어있습니다.</small>
	<div id="outdated"></div>