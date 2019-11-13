'use strict';
var $$ = window;

$$.addEventListener('DOMContentLoaded', function() {
	//vars
	var cpo_cook = decodeURIComponent(
		document.cookie.replace(/(?:(?:^|.*;\s*)cpo_cook\s*\=\s*([^;]*).*$)|^.*$/, '$1')
	);
	var dataRequest = JSON.stringify({token: cpo_cook});
	var active = true;
	var timeout;

	//core
	$$.onload = resetTimer;
	$$.onmousemove = resetTimer;
	$$.onmousedown = resetTimer;
	$$.ontouchstart = resetTimer;
	$$.onclick = resetTimer;
	$$.onkeypress = resetTimer;
	$$.addEventListener('scroll', resetTimer, true);

	//functions
	function resetTimer() {
		if (active){
			clearTimeout(timeout);
			timeout = setTimeout(closeSession, parseInt(idleSession));
		}
	}

	function closeSession() {
		var data = { token: cpo_cook };
		active = false;
		dataRequest = CryptoJS.AES.encrypt(dataRequest, cpo_cook, {format: CryptoJSAesJson}).toString();

		clearTimeout(timeout);

		callNovoCore('POST', 'User', 'closeSession', data, function(response) {
			notiSystem('', response.msg, response.classIconName, response.data);
		});
	}
});
