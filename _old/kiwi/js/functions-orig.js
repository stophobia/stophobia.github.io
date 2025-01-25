/* ellipsis on firefox */
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
/* tab */
$(function() {
	$("#tabs").tabs();
	$("#tabs2").tabs();
});
/* carousel */
jQuery(document).ready(function(){
jQuery('#viewport').carousel('#prev', '#next');  
});