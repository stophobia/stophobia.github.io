<?
	include "../odcommon/od_config.inc.php";
	include "../odcommon/od_function.inc.php";
	include "../odcommon/od_lib.inc.php";

	if(!$_POST[name]) {error_msgall('이름이 입력되지 않았습니다.','back');exit;}
	if(!$_POST[email]) {error_msgall('이메일이 입력되지 않았습니다.','back');exit;}

	# 비회원용 아이디 생성
	$tmpID =  get_guestid($_POST[name],$_POST[email]);

	# 비회원테이블에 등록된 인원인지 체크
	$que = "select * from odtMember2 where id ='".$tmpID."'";
	$res = mysql_query($que);
	if(!mysql_num_rows($res)) {
		mysql_query("insert into odtMember2 set id='".$tmpID."', name ='".$_POST[name]."' , email = '".$_POST[email]."', regidate=now()");
	}

	$_SESSION[Gid] = $tmpID;
	if($_POST[proMode] == "order") {
		if($buyMode == "today") {
			error_loc("/odprogram/odproducts/od_order.php?code=".info_nowsale('01'));
		}
		if($buyMode == "week") {
			error_loc("/odprogram/odproducts/od_order.php?code=".info_nowsale('02'));
		}
		if($buyMode == "live") {
			error_loc("/odprogram/odproducts/od_order.php?code=".info_nowsale('03'));
		}
		if($buyMode == "three") {
			error_loc("/odprogram/odproducts/od_order.php?code=".info_nowsale('04'));
		}
		if($buyMode == "five") {
			error_loc("/odprogram/odproducts/od_order.php?code=".info_nowsale('05'));
		}
		if($buyMode == "mart") {
			error_loc("/odprogram/odproducts/od_order.php?code=".$_POST[code]."&buyMode=".$buyMode);
		}

	} else if($_POST[proMode] == "mypage") {
		error_loc("/odprogram/odproducts/od_ordersearchresult.php");
	} else {
		exit;
	}

?>
