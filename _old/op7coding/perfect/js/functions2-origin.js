$(function() {
	$("#tabs").tabs();
	$("#tabs2").tabs();
});
function checkData (){
	if (document.signup.id.value == "") {
		alert("IDÇì¸óÕÇµÇƒÇ≠ÇæÇ≥Ç¢ÅB");
		document.signup.id.focus();
		return false;
		}
	if (document.signup.pw.value == "") {
		alert("PWÇì¸óÕÇµÇƒÇ≠ÇæÇ≥Ç¢ÅB");
		document.signup.pw.focus();
		return false;
		}
	if ((document.signup.id.value == "") && (document.signup.pw.value == "")) {
	    document.signup.login.disabled = true;
	} else {
	    closeid();
		setTimeout("top.location.href='index-logout.html'", 1000);
	}
}
window.onload = function() {
	if (!document.getBoxObjectFor || !window.openDialog) return;
	var sNS = 'http://www.mozilla.org/keymaster/gatekeeper/there.is.only.xul';
	var xml =  document.createElementNS(sNS , 'window');
	var label = document.createElementNS(sNS, 'description');
	label.setAttribute('crop','end');
	xml.appendChild(label); 
	var fn = function(el) {
		var xml2 =  xml.cloneNode(true);
		var dd = document.createElement('div');
		xml2.firstChild.setAttribute('value', el.textContent);
		el.innerHTML = '<span class="ellipsis-phantom">' + el.innerHTML + '</span>';
		el.appendChild(xml2);
	};
	var a = document.getElementsByTagName('*');
	for(var i=0; el = a[i]; i++) {
		if (/(^|\s)ellipsis(\s|$)/.test(el.className))
		fn(el);
	};
};
function bluring(){
if(event.srcElement.tagName=="A"||event.srcElement.tagName=="IMG")
document.body.focus();
}
document.onfocusin=bluring;
document.signup.login.disabled = true;