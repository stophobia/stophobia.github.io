<?
include dirname(__FILE__)."/odprogram/odcommon/od_db_conf.php";
include "./icon.php";
if(!$_POST[id]) exit;
$que = "insert into odtLiveChat set
				id				= '".$_POST[id]."',
				code			=	'".$_POST[code]."',
				name			= '".$_POST[name]."',
				content		= '".$_POST[content]."',
				color			=	'".$_POST[color]."',
				font			=	'".$_POST[font]."',
				regidate	= now()";
$res = mysql_query($que);
if(!$res) {
	echo mysql_error();
} else {
	echo 1;
}

?>