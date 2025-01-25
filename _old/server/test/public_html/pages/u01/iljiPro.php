<?php
// 필요한 설정파일 불러오기
include $_SERVER[DOCUMENT_ROOT]."/odprogram/odcommon/od_config.inc.php";
include $_SERVER[DOCUMENT_ROOT]."/odprogram/odcommon/od_function.inc.php";
include $_SERVER[DOCUMENT_ROOT]."/odprogram/odcommon/od_lib.inc.php";
if(!$row_member[id]) {
	error_msgall('회원만 참여할 수 있습니다.');
	exit;
}

$_POST[proMode] = $_GET[proMode] == "del" ? "del" : $_POST[proMode];

switch($_POST[proMode]) {
	case "ins" :

		# 관리자인지체크
		if(array_key_exists($_POST[iCmtID],$array_adminid) === true) {
			$isImg = "md";
		} else {
			$isImg = "";
		}
	
		$que = "insert into odtIljiCmt set
						iCmtID				= '".$_POST[iCmtID]."',
						iCmtSNo				=	'".$_POST[iCmtSNo]."',
						iCmtIsReply		=	'".$_POST[iCmtIsReply]."',
						iljiNo				=	'".$_POST[iljiNo]."',
						iCmtName			= '".$_POST[iCmtName]."',
						isImg					=	'".$isImg."',
						iCmtContent		= '".addslashes($_POST[iCmtContent])."',
						iCmtRegidate	= now();";
		$res = mysql_query($que);

		if(!$_POST[iCmtSNo]) {
			$last_id = mysql_insert_id();
			mysql_query("update odtIljiCmt set iCmtSNo = '".$last_id."' where iCmtNo = '".$last_id."'");
		}

		break;
	case "edt" :



		break;
	case "del" :
		$iCmtNo = $_GET[iCmtNo];
		$iCmtRow = mysql_fetch_array(mysql_query("select * from odtIljiCmt where iCmtNo='".$iCmtNo."'"),0);
		if($iCmtRow[iCmtID] == $row_member[id] || $row_member[Mlevel] > 8) {

			if($iCmtRow[iCmtNo] == $eCmtRow[iCmtSNo]) { // 부모 댓글이면 하위 댓글 있는지 체크 
				$isReply = mysql_result(mysql_query("select count(*) from odtIljiCmt where iCmtSNo = '".$iCmtNo."' and iCmtNo!='".$iCmtNo."'"),0);
				if($isReply) {
					error_msgall('답글이 있는 글은 삭제 할 수 없습니다.');
					exit;
				}
			}

			$res = mysql_query("delete from odtIljiCmt where iCmtNo = '".$iCmtNo."'");
		} else {
			error_msgall('자신의 댓글 만 삭제할 수 있습니다.');
			exit;
		}
		break;
}

if($res) {
	echo "<script>parent.document.eventFrm.reset();parent.iljiAjaxLoad();</script>";
	exit;
} else {
	echo mysql_error();
	echo "<script>alert('에러');</script>";
	exit;
}

?>