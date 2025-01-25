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
		if(array_key_exists($_POST[pollID],$array_adminid) === true) {
			$isImg = "md";
		} else {
			$isImg = "";
		}
	
		$que = "insert into odtPoll2 set
						pollID				= '".$_POST[pollID]."',
						pollSNo				=	'".$_POST[pollSNo]."',
						isReply				=	'".$_POST[isReply]."',
						pollProCode		=	'".$_POST[pollProCode]."',
						pollName			= '".$_POST[pollName]."',
						sms						=	'".$_POST[sms]."',
						isImg					=	'".$isImg."',
						pollContent		= '".addslashes($_POST[pollContent])."',
						pollRegidate	= now();";
		$res = mysql_query($que);

		if(!$_POST[pollSNo]) {
			$last_id = mysql_insert_id();
			mysql_query("update odtPoll2 set pollSNo = '".$last_id."' where pollNo = '".$last_id."'");
		} else {		// 문자발송
			// 부모댓글작성자에게 문자
			$pRow = mysql_fetch_array(mysql_query("select * from odtPoll2 where pollNo = '".$_POST[pollSNo]."'"));
			if($pRow[sms] && $_POST[pollID] != $pRow[pollID]) {	//문자 받기에 체크가 되어있고, 작성자의 글이 아니라면
				# 작성자에게 문자발송
				$tran_phone			= @mysql_result(mysql_query("select concat(htel1,\"-\", htel2,\"-\", htel3)  as htel from odtMember where id='".$pRow[pollID]."' and htel3 !='0000' "),0);
				if($tran_phone) {
					$tran_callback	= $row_company[tel];
					$tran_msg				=	$_POST[pollContent];	
					$smsQue = "insert into em_tran set tran_phone = '".$tran_phone."', tran_callback = '".$tran_callback."', tran_msg= '".$tran_msg."', tran_status = 1, tran_date = now()";
					mysql_query($smsQue);
				}
			}
		}

		break;
	case "edt" :



		break;
	case "del" :
		$pollNo = $_GET[pollNo];
		$pollRow = mysql_fetch_array(mysql_query("select * from odtPoll2 where pollNo='".$pollNo."'"));
		if($pollRow[pollID] == $row_member[id] || $row_member[Mlevel] > 8) {

			if($pollRow[pollNo] == $pollRow[pollSNo]) { // 부모 댓글이면 하위 댓글 있는지 체크 
				$isReply = mysql_result(mysql_query("select count(*) from odtPoll2 where pollSNo = '".$pollNo."' and pollNo!='".$pollNo."'"),0);
				if($isReply) {
					error_msgall('답글이 있는 글은 삭제 할 수 없습니다.');
					exit;
				}
			}

			$res = mysql_query("delete from odtPoll2 where pollNo = '".$pollNo."'");
			
		} else {
			error_msgall('자신의 댓글 만 삭제할 수 있습니다.');
			exit;
		}
		break;
}

if($res) {
	echo "<script>parent.document.form2.reset();parent.pollAjaxLoad();</script>";
	exit;
} else {
	echo mysql_error();
	echo "<script>alert('에러');</script>";
	exit;
}

?>