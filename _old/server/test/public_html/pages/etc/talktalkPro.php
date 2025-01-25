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
	
		# 예약되어있는 토크를 입력.
		@exec("/usr/local/bin/php ".dirname(__FILE__)."/odprogram/odmanager/odproducts/comment2AutoPro.php");

		#첫번째 작성자 참여점수 부여
		$isFirst = @mysql_num_rows(mysql_query("select * from odtTt where ttID = '".$row_member[id]."' and ttProCode = '".$_POST[code]."'"));
		$isFirst2 = @mysql_num_rows(mysql_query("select * from odtActionLog where acID = '".$row_member[id]."' and acTitle ='상품토크' and acRegidate like '".date('Y-m-d')."%'"));
		if(!$isFirst && !$isFirst2) {
			mysql_query("insert into odtActionLog set acID= '".$row_member[id]."', acTitle ='상품토크', acPoint='30', acRegidate = now()");
			mysql_query("update odtMember set action = action + 30 where id='".$row_member[id]."'");
		}

		# 관리자인지, 판매자인지 체크
		$seller = mysql_result(mysql_query("select customerCode from odtProduct where code ='".$_POST[code]."'"),0);
		if(array_key_exists($_POST[ttID],$array_adminid) === true) 
			$isImg = "md";
		else if($_POST[ttID] == $seller) {
			$isImg = "seller";
		} else {
			$isImg = "";
		}

		$que = "insert into odtTt set
						ttID				= '".$_POST[ttID]."',
						ttProCode		=	'".$_POST[code]."',
						ttSNo				=	'".$_POST[ttSNo]."',
						ttIsReply		=	'".$_POST[ttIsReply]."',
						ttNo				=	'".$_POST[ttNo]."',
						ttName			= '".$_POST[ttName]."',
						isImg				=	'".$isImg."',
						sms					=	'".$sms."',
						ttContent		= '".addslashes($_POST[ttContent])."',
						ttRegidate	= now();";
		$res = mysql_query($que);

		if(!$_POST[ttSNo]) {	// 부모댓글이면
			$last_id = mysql_insert_id();
			mysql_query("update odtTt set ttSNo = '".$last_id."' where ttNo = '".$last_id."'");

			#해당상품 카테고리
			unset($cateCodeTmp);
			$cateCodeTmp = @mysql_result(mysql_query("select cateCode from odtProduct where code ='".$_POST[code]."'"),0);
			if($cateCodeTmp == "01") $cateCodeTmp = "TODAY";
			if($cateCodeTmp == "02") $cateCodeTmp = "WEEK";
			if($cateCodeTmp == "03") $cateCodeTmp = "MEDIA";
			if($cateCodeTmp == "04") $cateCodeTmp = "THREE";
			if($cateCodeTmp == "05") $cateCodeTmp = "FIVE";


			#MD에게 문자발송
			$tran_phone			= $row_company[htel];
			$tran_callback	= $row_company[tel];

            $smsQuery  = " SELECT * FROM m_sms_set WHERE smskbn = 'talk' ";
            $smsResult = mysql_query($smsQuery);
            $smsRecord = mysql_fetch_array($smsResult);

            if ("y" == $smsRecord[smschk])
            {
                $tran_msg =	$smsRecord[smstext].addslashes($_POST[ttContent]);
                $smsQue   = "insert into em_tran set tran_phone = '".$tran_phone."', tran_callback = '".$tran_callback."', tran_msg= '".$tran_msg."', tran_status = 1, tran_date = now()";
                mysql_query($smsQue);
            }


		} else { // 자식댓글이면
			// 부모댓글작성자에게 문자
			$pRow = mysql_fetch_array(mysql_query("select * from odtTt where ttNo = '".$_POST[ttSNo]."'"));
			if($pRow[sms] && $_POST[ttID] != $pRow[ttID]) {	//문자 받기에 체크가 되어있고, 작성자의 글이 아니라면
				
				# 작성자에게 문자발송
				$tran_phone			= @mysql_result(mysql_query("select concat(htel1,\"-\", htel2,\"-\", htel3)  as htel from odtMember where id='".$pRow[ttID]."' and htel3 !='0000' "),0);
				if($tran_phone) {
					$tran_callback	= $row_company[tel];

                    $smsQuery  = " SELECT * FROM m_sms_set WHERE smskbn = 'talk_re' ";
                    $smsResult = mysql_query($smsQuery);
                    $smsRecord = mysql_fetch_array($smsResult);

                    if ("y" == $smsRecord[smschk])
                    {
                        $tran_msg = $smsRecord[smstext].$_POST[ttContent];	
                        $smsQue = "insert into em_tran set tran_phone = '".$tran_phone."', tran_callback = '".$tran_callback."', tran_msg= '".$tran_msg."', tran_status = 1, tran_date = now()";
                        mysql_query($smsQue);
                    }

				}
			}
		}
	
		break;
	case "edt" :



		break;
	case "del" :
		$ttNo = $_GET[ttNo];
		$ttRow = mysql_fetch_array(mysql_query("select * from odtTt where ttNo='".$ttNo."'"));

		if(($ttRow[ttID] == $row_member[id]) || @array_key_exists($row_member[id],$array_adminid) == true) {

			if($ttRow[ttNo] == $ttRow[ttSNo]) { // 부모 댓글이면 하위 댓글 있는지 체크 
				$isReply = mysql_result(mysql_query("select count(*) from odtTt where ttSNo = '".$ttNo."' and ttNo !='".$ttNo."'"),0);
				if($isReply) {
					error_msgall('답글이 있는 글은 삭제 할 수 없습니다.');
					exit;
				}
			}

			$res = mysql_query("delete from odtTt where ttNo = '".$ttNo."'");
		} else {
			error_msgall('자신의 댓글 만 삭제할 수 있습니다.');
			exit;
		}
		break;
}

if($res) {
	echo "<script>parent.document.eventFrm.reset();parent.talktalkAjaxLoad();</script>";
	exit;
} else {
	echo mysql_error();
	echo "<script>alert('에러');</script>";
	exit;
}

?>