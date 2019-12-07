'use strict';
var $w = window;

$$.addEventListener('DOMContentLoaded', function() {
	//vars
	var active = true;
	var timeout;

	//core
	$w.onload = resetTimer;
	$w.onmousemove = resetTimer;
	$w.onmousedown = resetTimer;
	$w.ontouchstart = resetTimer;
	$w.onclick = resetTimer;
	$w.onkeypress = resetTimer;
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
});
