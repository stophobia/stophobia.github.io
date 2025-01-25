$(document).ready(function() {
	var queryhash = window.location.hash;
	switch (queryhash) {
		case "#profile":
			document.title = "Stophobia - Profile";
			initialShowprofile();
			break;
		case "#logo":
			document.title = "Stophobia - Logo & Character";
			initialShowlogo();
			break;
		case "#website":
			document.title = "Stophobia - Private work";
			initialShowwebsite();
			break;
		case "#website2":
			document.title = "Stophobia - Official work";
			initialShowwebsite2();
			break;
		default:
			initialShowprofile();
			break;
	}
	$("h2").hide();
	$("#nav-logo a").click(showlogo);
	$("#nav-website a").click(showwebsite);
	$("#nav-website2 a").click(showwebsite2);
	$("#nav-profile a").click(showprofile);
	$("header .tagxhtml a").hover(showtagxhtml, hidetagxhtml);
	$("header .tagcss a").hover(showtagcss, hidetagcss);
});
function initialShowprofile() {
	$("#content").hide();
	$("#stophobia").removeClass();
	$("#stophobia").addClass("profile");
	$(".node").hide();
	$("#profile").show();
	setTimeout("$('#content').slideDown('slow');", 1000);
}
function initialShowlogo() {
	$("#content").hide();
	$("#stophobia").removeClass();
	$("#stophobia").addClass("logo");
	$(".node").hide();
	$("#logo").show();
	setTimeout("$('#content').slideDown('slow');", 1000);
}
function initialShowwebsite() {
	$("#content").hide();
	$("#stophobia").removeClass();
	$("#stophobia").addClass("website");
	$(".node").hide();
	$("#website").show();
	setTimeout("$('#content').slideDown('slow');", 1000);
}
function initialShowwebsite2() {
	$("#content").hide();
	$("#stophobia").removeClass();
	$("#stophobia").addClass("website2");
	$(".node").hide();
	$("#website2").show();
	setTimeout("$('#content').slideDown('slow');", 1000);
}
function showprofile() {
	if ($("#stophobia").hasClass("profile")){ }
	else {
		document.title = "Stophobia - Profile";
		$("#content").slideUp(500);
		$(".node").fadeOut(500);
		setTimeout("$('.node').hide();", 500);
		setTimeout("$('#profile').show();", 500);
		$("#content").slideDown(500);
		$("#stophobia").removeClass();
		$("#stophobia").addClass("profile");
	}
}
function showlogo() {
	if ($("#stophobia").hasClass("logo")){ }
	else {
		document.title = "Stophobia - Logo & Character";
		$("#content").slideUp(500);
		$(".node").fadeOut(500);
		setTimeout("$('.node').hide();", 500);
		setTimeout("$('#logo').show();", 500);
		$("#content").slideDown(500);
		$("#stophobia").removeClass();
		$("#stophobia").addClass("logo");
	}
}
function showwebsite() {
	if ($("#stophobia").hasClass("website")){ }
	else {
		document.title = "Stophobia - Private work";
		$("#content").slideUp(500);
		$(".node").fadeOut(500);
		setTimeout("$('.node').hide();", 500);
		setTimeout("$('#website').show();", 500);
		$("#content").slideDown(500);
		$("#stophobia").removeClass();
		$("#stophobia").addClass("website");
	}
}
function showwebsite2() {
	if ($("#stophobia").hasClass("website2")){ }
	else {
		document.title = "Stophobia - Official work";
		$("#content").slideUp(500);
		$(".node").fadeOut(500);
		setTimeout("$('.node').hide();", 500);
		setTimeout("$('#website2').show();", 500);
		$("#content").slideDown(500);
		$("#stophobia").removeClass();
		$("#stophobia").addClass("website2");
	}
}
function showtagxhtml() {
	$("header .tagxhtml").animate({top: "-5px"}, 250 );
}
function hidetagxhtml() {
	$("header .tagxhtml").animate({top: "-15px"}, 250 );
}
function showtagcss() {
	$("header .tagcss").animate({top: "-5px"}, 250 );
}
function hidetagcss() {
	$("header .tagcss").animate({top: "-15px"}, 250 );
}