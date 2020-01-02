'use strict';
var $$ = document;

$$.addEventListener('DOMContentLoaded', function() {

	var actualPage = window.location.pathname.split("/").pop();
	var pageNoTObserved = ['inicio','preregistro','recuperaracceso']

	if (!pageNoTObserved.includes(actualPage)) {

		//vars
		var timeout;
		var $w = window;
		var active = true;

		//core
		$w.onload = resetTimer;
		$w.onclick = resetTimer;
		$w.onkeypress = resetTimer;
		$w.onmousemove = resetTimer;
		$w.onmousedown = resetTimer;
		$w.ontouchstart = resetTimer;
		$w.addEventListener('scroll', resetTimer, true);

		//functions
		function resetTimer() {
			if (active){
				clearTimeout(timeout);
				timeout = setTimeout(closeSession, parseInt(idleSession));
			}
		}

		function closeSession() {
			clearTimeout(timeout);

			callNovoCore('POST', 'User', 'closeSession', [], function(response) {
				notiSystem(titleNotiSystem, txtCloseIdleSession, iconDanger, {
					btn1: {
						action: 'redirect',
						link: 'cerrarsesion',
						text: txtBtnAcceptNotiSystem
					}
				});
			});
		}
	}

});
