/* @ cc_on _d = document; eval(Åevar document = _dÅf) @*/
$(document).ready(function() {
	$("#sub .mapnavi a.open").click(openmap2);
	$("#sub .mapnavi a.hide").click(hidemap2);
	$("#sub .tables .question a.open2").click(openfaq2);
	$("#sub .tables .ask a.close2").click(hidefaq2);
});
function openmap2() {
	$("#sub a.open").animate({left: "460px"}, 250 );
	$("#sub .mapnavi").animate({height: "370px"}, 250 );
}
function hidemap2() {
	$("#sub .mapnavi").animate({height: "50px"}, 250 );
	$("#sub a.open").animate({left: "240px"}, 250 );
}
function openfaq2() {
	$(this).next().animate({height: "100%"}, 250 );

	
}
function hidefaq2() {
	$(this).parent().animate({height: "0px"}, 250 );
}