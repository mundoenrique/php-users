'use strict'
var cpo_cook;

function novo_cryptoPass(jsonObject, req) {
	req = req == undefined ? false : req;
	cpo_cook = novo_getCookieValue();
	var cipherObject = CryptoJS.AES.encrypt(jsonObject, cpo_cook, { format: CryptoJSAesJson }).toString();

	if(!req) {
		cipherObject = btoa(JSON.stringify({
			password: cipherObject,
			plot: btoa(cpo_cook)
		}));
	}

	return cipherObject;
}

function novo_getCookieValue() {
	return decodeURIComponent(
		document.cookie.replace(/(?:(?:^|.*;\s*)cpo_cook\s*\=\s*([^;]*).*$)|^.*$/, '$1')
	);
}
