/* @ cc_on _d = document; eval(Åevar document = _dÅf) @*/
$(document).ready(function() {
	$("#sub .mapnavi a.open").click(openmap);
	$("#sub .mapnavi a.hide").click(hidemap);
});
function openmap() {
	//$("#sub .mapnavi").animate({width: "640px"}, 250 );
	$("#sub a.open").animate({left: "470px"}, 250 );
	$("#sub .mapnavi").animate({height: "370px"}, 250 );
}
function hidemap() {
	$("#sub .mapnavi").animate({height: "50px"}, 250 );
	$("#sub a.open").animate({left: "250px"}, 250 );
	//$("#sub .mapnavi").animate({width: "100px"}, 250 );
}