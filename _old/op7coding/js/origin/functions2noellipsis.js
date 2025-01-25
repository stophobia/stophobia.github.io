/* @ cc_on _d = document; eval(evar document = _df) @*/
$(function() {
	$("#tabs").tabs();
	$("#tabs2").tabs();
});
function checkData (){
	if (document.signup.id.value == "") {
		alert("ID‚ğ“ü—Í‚µ‚Ä‚­‚¾‚³‚¢B");
		document.signup.id.focus();
		return false;
		}
	if (document.signup.pw.value == "") {
		alert("PW‚ğ“ü—Í‚µ‚Ä‚­‚¾‚³‚¢B");
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
function bluring(){
if(event.srcElement.tagName=="A"||event.srcElement.tagName=="IMG")
document.body.focus();
}
document.onfocusin=bluring;