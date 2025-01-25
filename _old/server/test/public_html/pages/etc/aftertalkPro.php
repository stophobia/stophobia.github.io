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

		# 예약되어있는 후기를 입력.
		@exec("/usr/local/bin/php ".dirname(__FILE__)."/odprogram/odmanager/odproducts/afterComment2AutoPro.php");

		#첫번째 작성자 참여점수 부여
		$isFirst = @mysql_num_rows(mysql_query("select * from odtAfterTalk where afterID = '".$row_member[id]."' and afterProCode = '".$_POST[code]."'"));
		$isFirst2 = @mysql_num_rows(mysql_query("select * from odtActionLog where acID = '".$row_member[id]."' and acTitle ='상품후기' and acRegidate like '".date('Y-m-d')."%'"));
		if(!$isFirst && !$isFirst2) {
			mysql_query("insert into odtActionLog set acID= '".$row_member[id]."', acTitle ='상품후기', acPoint='20', acRegidate = now()");
			mysql_query("update odtMember set action = action + 20 where id='".$row_member[id]."'");
		}

		# 관리자인지, 판매자인지 체크
		$seller = mysql_result(mysql_query("select customerCode from odtProduct where code ='".$_POST[code]."'"),0);
		if(array_key_exists($_POST[afterID],$array_adminid) === true) 
			$isImg = "md";
		else if($_POST[afterID] == $seller) {
			$isImg = "seller";
		} else {
			$isImg = "";
		}

		$que = "insert into odtAfterTalk set
						afterID					= '".$_POST[afterID]."',
						afterProCode		=	'".$_POST[code]."',
						afterSNo				=	'".$_POST[afterSNo]."',
						afterIsReply		=	'".$_POST[afterIsReply]."',
						afterNo					=	'".$_POST[afterNo]."',
						afterName				= '".$_POST[afterName]."',
						isImg						=	'".$isImg."',
						afterContent		= '".addslashes($_POST[afterContent])."',
						afterRegidate		= now();";
		$res = mysql_query($que);

		if(!$_POST[afterSNo]) {
			$last_id = mysql_insert_id();
			mysql_query("update odtAfterTalk set afterSNo = '".$last_id."' where afterNo = '".$last_id."'");

			#해당상품 카테고리
			unset($cateCodeTmp);
			$mainName = @mysql_result(mysql_query("select mainName from odtProduct where parent_code = code and parent_code ='".$_POST[code]."'"),0);

			#담당MD에게 문자발송
			$tran_phone			= $row_company[htel];
			$tran_callback	= $row_company[tel];
			$tran_msg				=	"[".$mainName."]".addslashes($_POST[afterContent]);
			$smsQue = "insert into em_tran set tran_phone = '".$tran_phone."', tran_callback = '".$tran_callback."', tran_msg= '".$tran_msg."', tran_status = 1, tran_date = now()";
			mysql_query($smsQue);

		}

		break;
	case "edt" :



		break;
	case "del" :
		$afterNo = $_GET[afterNo];
		$afterRow = mysql_fetch_array(mysql_query("select * from odtAfterTalk where afterNo='".$afterNo."'"));

		if(($afterRow[afterID] == $row_member[id]) || $row_member[Mlevel] > 8) {

			if($afterRow[afterNo] == $afterRow[afterSNo]) { // 부모 댓글이면 하위 댓글 있는지 체크 
				$isReply = mysql_result(mysql_query("select count(*) from odtAfterTalk where afterSNo = '".$afterNo."' and afterNo!='".$afterNo."'"),0);
				if($isReply) {
					error_msgall('답글이 있는 글은 삭제 할 수 없습니다.');
					exit;
				}
			}

			$res = mysql_query("delete from odtAfterTalk where afterNo = '".$afterNo."'");
		} else {
			error_msgall('자신의 댓글 만 삭제할 수 있습니다.');
			exit;
		}
		break;
}
if($res) {
	echo "<script>parent.document.eventFrm2.reset();parent.aftertalkAjaxLoad();</script>";
	exit;
} else {
	echo mysql_error();
	echo "<script>alert('에러');</script>";
	exit;
}

?>