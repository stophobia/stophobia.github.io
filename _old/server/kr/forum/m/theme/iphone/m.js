function $(id) { return document.getElementById(id); }
window.onload = function() {
	$('backButton').onclick = function() { location.href='./'; }
}