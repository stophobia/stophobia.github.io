<?php
if($_GET[hID]) {
	setcookie("hID",$_GET[hID]);
	//
	//부모 ID 추출
	//
	$parentID = @mysql_result(mysql_query("select id from odtMember where hID = '".$_GET[hID]."'"),0);
	//
	//부모 ID가 있으면 처리 없으면 해킹시도로 로그남김
	if($parentID) mysql_query("insert into odtEventJoinLog set parentID ='".$parentID."', hID = '".$_GET[hID]."', ip ='".$_SERVER[REMOTE_ADDR]."', regidate=now(), main='".($_GET['main'] ? $_GET['main'] : "today")."', referer='".$_SERVER[HTTP_REFERER]."'");
	else {	
		$hackMent = "hID을 변경해보며 접속시도 - (hID:".$_GET[hID].")";
		mysql_query("insert into odtEventJoinHackingLog set ip ='".$_SERVER[REMOTE_ADDR]."', ment ='".$hackMent."', regidate=now(), referer='".$_SERVER[HTTP_REFERER]."'");
	}
}
?>