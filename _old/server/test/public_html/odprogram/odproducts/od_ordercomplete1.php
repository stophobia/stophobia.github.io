<?
	## ConnectINFO.inc.php 파일 인클루드 ############################
	include "../odcommon/od_config.inc.php";
	include "$folderpath_common/od_function.inc.php";
	include "$folderpath_common/od_lib.inc.php";

    // sms문구 주문시회원에게 보내는 문구 추출 ////////////////////////////////
    $mem_smsQuery  = " SELECT * FROM m_sms_set WHERE smskbn = 'order_mem' ";
    $mem_smsResult = mysql_query($mem_smsQuery);
    $mem_smsRecord = mysql_fetch_array($mem_smsResult);

    // 주문시 운영자에게 보내는 문구 추출 /////////////////////////////////////
    $adm_smsQuery  = " SELECT * FROM m_sms_set WHERE smskbn = 'order_adm' ";
    $adm_smsResult = mysql_query($adm_smsQuery);
    $adm_smsRecord = mysql_fetch_array($adm_smsResult);


	# 제휴마케팅 정보 추출
	$cInfo = mysql_fetch_array(mysql_query("select * from odtClick where sc_idx='1'"));

	// 상품레코드 입력.
	function sellRecord($orow)
	{
		global $_SERVER;

		// 회원정보
		$row_memberInfo = mysql_fetch_array(mysql_query("select address,age,Mlevel,actionLevel from odtMember where id ='".$orow[orderid]."'"));

		// 상품코드
		$parent_code = mysql_result(mysql_query("select parent_code from odtProduct where code = '".reset(explode("|",$orow[pLog]))."'"),0);


		// 구매까지 걸린 시간
		$reTimeTmp = @mysql_result(mysql_query("select unix_timestamp(date) from odtBuyTime where ip='".$_SERVER[REMOTE_ADDR]."' and date like '".date('Y-m-d')."%' order by date desc"),0);
		$reTimeTmp = $reTimeTmp ? $reTimeTmp : time();
		$reTime = time() - $reTimeTmp;
								
		$reQue = "insert into odtReport set
							reID					=	'".$orow[orderid]."',
							reCode				= '".$parent_code."',
							reAge					= '".$row_memberInfo[age]."',
							rePosition		= '".reset(explode(" ",$row_memberInfo[address]))."',
							reLevel				= '".$row_memberInfo[actionLevel]."',
							reTime				= '".$reTime."',
							reRegidate		= now()";
		mysql_query($reQue);

		return;
	}


	if($paymethod == "B" || $paymethod == "G")
	{ 
		//무통장 입금이나 전액 포인트 결제시 바로 주문완료페이지로 오므로 주문테이블에 입력.

		# 주문번호 쿠키로 꾸어놓음.. 주문서 수정할경우를 위해.
		setCookie("pre_ordernum",$ordernum);

		$parent_code	=	addslashes(trim($_POST[parent_code]));// 부모 상품코드
		$ordernum			= addslashes(trim($_POST[ordernum]));		// 주문번호
		$ordertel1		= addslashes(trim($_POST[ordertel1]));	// 주문자 전화
		$ordertel2		= addslashes(trim($_POST[ordertel2]));	//
		$ordertel3		= addslashes(trim($_POST[ordertel3]));	//
		$cLog					= addslashes(trim($_POST[cLog]));				// 쿠폰사용로그
		$pLog					= addslashes(trim($_POST[pLog]));				// 상품구매로그	
		$oLog					= addslashes(trim($_POST[oLog]));				// 구매한상품옵션로그
		$gPrice				= addslashes(trim($_POST[gPrice]));			// 사용한 포인트
		$gGetPrice		= addslashes(trim($_POST[gGetPrice]));	// 적립될 포인트
		$dPrice				= addslashes(trim($_POST[dPrice]));			// 배송비
		$sPrice				= addslashes(trim($_POST[sPrice]));			// 총할인금액
		$tPrice				= addslashes(trim($_POST[tPrice]));			// 최종결제금액
		$ordername		= addslashes(trim($_POST[ordername]));	// 주문자명
		$orderhtel1		= addslashes(trim($_POST[orderhtel1]));	// 주문자핸드폰
		$orderhtel2		= addslashes(trim($_POST[orderhtel2]));	//
		$orderhtel3		= addslashes(trim($_POST[orderhtel3]));	//
		$orderemail		= addslashes(trim($_POST[orderemail]));	// 주문자 이메일
		$recname			= addslashes(trim($_POST[recname]));		// 수취인명
		$rectel1			= addslashes(trim($_POST[rectel1]));		// 수취인전화
		$recemail			= addslashes(trim($_POST[recemail]));		// 수취인이메일
		$rectel2			= addslashes(trim($_POST[rectel2]));		//
		$rectel3			= addslashes(trim($_POST[rectel3]));		//
		$rechtel1			= addslashes(trim($_POST[rechtel1]));		// 수취인핸드폰
		$rechtel2			= addslashes(trim($_POST[rechtel2]));		//
		$rechtel3			= addslashes(trim($_POST[rechtel3]));		//
		$reczip1			= addslashes(trim($_POST[reczip1]));		// 수취인 우편번호
		$reczip2			= addslashes(trim($_POST[reczip2]));		//
		$recaddress		= addslashes(trim($_POST[recaddress]));	// 수취인 주소
		$recaddress1	= addslashes(trim($_POST[recaddress1]));//
		$viewDel			=	addslashes(trim($_POST[viewDel]));		//
		$comment			= addslashes(trim($_POST[comment]));		// 배송희망멘트
		$taxorder			= addslashes(trim($_POST[taxorder]));		// 세금계산서신청유무 (Y / N)
		$companynum		= addslashes(trim($_POST[companynum]));	// 사업자등록번호
		$companyname	= addslashes(trim($_POST[companyname]));// 상호명
		$ceoname			= addslashes(trim($_POST[ceoname]));		// 대표자명
		$companyadd		= addslashes(trim($_POST[companyadd]));	// 사업장주소
		$taxstatus		= addslashes(trim($_POST[taxstatus]));	// 사업형태
		$taxitem			= addslashes(trim($_POST[taxitem]));		// 종목
		$paymethod		= addslashes(trim($_POST[paymethod]));	// 결제방법 (무통장 B , 카드 C , 실시간계좌이체 L)
		$paybankname	= addslashes(trim($_POST[paybankname]));// 입금계좌 (은행명/예금주/계좌번호)
		$paydatey			= addslashes(trim($_POST[paydatey]));		// 입금예정일
		$paydatem			= addslashes(trim($_POST[paydatem]));		//
		$paydated			= addslashes(trim($_POST[paydated]));		//
		$payname			= addslashes(trim($_POST[payname]));		// 입금자명

		$orderid			=	$row_member[id] ? $row_member[id] : $_SESSION[Gid];				// 주문자 아이디, 비회원은 guest

		if(!$orderid) $orderid = @mysql_result(mysql_query("select id from odtMember2 where name = '".$ordername."' and  email ='".$orderemail."' limit 1"),0);


		# 입금 계좌정보 쪼갬.
		$paybankname = isset($paybankname) ? explode("/",$paybankname) : NULL;

		## 데이터 무결성 체크를 한번 해야함..


		######################################


		#해당 상품의 정보 추출
		$row_product = mysql_fetch_array(mysql_query("select * from odtProduct where code = '".$parent_code."'"));

		# 이미 등록된 주문인지 체크.
		$isOrder = mysql_result(mysql_query("select count(*) from odtOrder where ordernum = '".$ordernum."'"),0);


		if($isOrder)
		{	
			//이미 등록되어있는 주문건이면 수정.

			#수정 .
			$que = "update odtOrder set
							partnerCode			= '".$row_product[customerCode]."',
							orderid					= '".$orderid."',
							ordername				= '".$ordername."',
							orderemail			= '".$orderemail."',
							ordertel1				= '".$ordertel1."',
							ordertel2				= '".$ordertel2."',
							ordertel3				= '".$ordertel3."',
							orderhtel1			= '".$orderhtel1."',
							orderhtel2			= '".$orderhtel2."',
							orderhtel3			= '".$orderhtel3."',
							recname					= '".$recname."',
							recemail				= '".$recemail."',
							rectel1					= '".$rectel1."',
							rectel2					= '".$rectel2."',
							rectel3					= '".$rectel3."',
							rechtel1				= '".$rechtel1."',
							rechtel2				= '".$rechtel2."',
							rechtel3				= '".$rechtel3."',
							reczip1					= '".$reczip1."',
							reczip2					= '".$reczip2."',
							recaddress			= '".$recaddress."',
							recaddress1			= '".$recaddress1."',
							viewDel					=	'".$viewDel."',
							comment					= '".$comment."',
							taxorder				= '".$taxorder."',
							companynum			= '".$companynum."',
							companyname			= '".$companyname."',
							ceoname					= '".$ceoname."',
							companyadd			= '".$companyadd."',
							taxstatus				= '".$taxstatus."',
							taxitem					= '".$taxitem."',
							cLog						= '".$cLog."',
							pLog						= '".$pLog."',
							oLog						= '".$oLog."',
							gPrice					= '".$gPrice."',
							gGetPrice				= '".$gGetPrice."',
							dPrice					= '".$dPrice."',
							sPrice					= '".$sPrice."',
							tPrice					= '".$tPrice."',
							pointed					= 'N',
							paymethod				= '".$paymethod."',
							paystatus				= '".($paymethod == "G" ? "Y" : "N")."',
							paydate					=	".($paymethod == "G" ? "now()" : "'0000-00-00 00:00:00'").",
							paybankname			= '".$paybankname[0]."/".$paybankname[1]."',
							paybanknum			= '".$paybankname[2]."',
							paydatey				= '".$paydatey."',
							paydatem				= '".$paydatem."',
							paydated				= '".$paydated."',
							payname					= '".$payname."',
							md_name					= '".$row_product[md_name]."',
							ip							= '".$_SERVER[REMOTE_ADDR]."'
							where
							ordernum				= '".$ordernum."'";

			$res = mysql_query($que);

		}	else { // 없으면 새등록


			// 배송기능 사용시 주문 기록 - onedaynet jjc
			if($row_product[setup_delivery]=="Y") {
				$app_order_type = "product";
			}
			else {
				$app_order_type = "coupon";
			}


			#DB에 입력처리.
			$que = "insert into odtOrder set
							order_type				= '".$app_order_type."',
							ordernum				= '".$ordernum."',
							partnerCode			= '".$row_product[customerCode]."',
							orderid					= '".$orderid."',
							ordername				= '".$ordername."',
							orderemail			= '".$orderemail."',
							ordertel1				= '".$ordertel1."',
							ordertel2				= '".$ordertel2."',
							ordertel3				= '".$ordertel3."',
							orderhtel1			= '".$orderhtel1."',
							orderhtel2			= '".$orderhtel2."',
							orderhtel3			= '".$orderhtel3."',
							recname					= '".$recname."',
							recemail				= '".$recemail."',
							rectel1					= '".$rectel1."',
							rectel2					= '".$rectel2."',
							rectel3					= '".$rectel3."',
							rechtel1				= '".$rechtel1."',
							rechtel2				= '".$rechtel2."',
							rechtel3				= '".$rechtel3."',
							reczip1					= '".$reczip1."',
							reczip2					= '".$reczip2."',
							recaddress			= '".$recaddress."',
							recaddress1			= '".$recaddress1."',
							viewDel					=	'".$viewDel."',
							comment					= '".$comment."',
							taxorder				= '".$taxorder."',
							companynum			= '".$companynum."',
							companyname			= '".$companyname."',
							ceoname					= '".$ceoname."',
							companyadd			= '".$companyadd."',
							taxstatus				= '".$taxstatus."',
							taxitem					= '".$taxitem."',
							cLog						= '".$cLog."',
							pLog						= '".$pLog."',
							oLog						= '".$oLog."',
							gPrice					= '".$gPrice."',
							gGetPrice				= '".$gGetPrice."',
							dPrice					= '".$dPrice."',
							sPrice					= '".$sPrice."',
							tPrice					= '".$tPrice."',
							pointed					= 'N',
							orderstep				=	'finish',
							paymethod				= '".$paymethod."',
							paystatus				= '".($paymethod == "G" ? "Y" : "N")."',
							paydate					=	".($paymethod == "G" ? "now()" : "'0000-00-00 00:00:00'").",
							paybankname			= '".$paybankname[0]."/".$paybankname[1]."',
							paybanknum			= '".$paybankname[2]."',
							paydatey				= '".$paydatey."',
							paydatem				= '".$paydatem."',
							paydated				= '".$paydated."',
							payname					= '".$payname."',
							orderdate				=	now(),
							orderstatus			=	'Y',
							md_name					= '".$row_product[md_name]."',
							hID							=	'".$_COOKIE[hID]."',
							ip							= '".$_SERVER[REMOTE_ADDR]."'";

					$res = mysql_query($que);
					
					if($paymethod=="B") {
						## 무통장 입금 정보를 sms로 발송
						if($orderhtel1 && $orderhtel2 && $orderhtel3) {
							$tran_phone			= $orderhtel1 ."-". $orderhtel2 ."-". $orderhtel3;
							$tran_callback	= $row_company[tel];

                            if ("y" == $mem_smsRecord[smschk])
                            {                            
                                $tran_msg = "".$paybankname[0]."/".$paybankname[2]."/".$paybankname[1]."로 ".number_format($tPrice)."원 입금해주세요";
                                $smsQue = "insert into em_tran set tran_phone = '".$tran_phone."', tran_callback = '".$tran_callback."', tran_msg= '".$tran_msg."', tran_status = 1, tran_date = now()";
                                mysql_query($smsQue);
                            }

                            if ("y" == $adm_smsRecord[smschk])
                            { 
                                #관리자에게 문자발송
                                $tran_phone         = $row_company[htel];
                                $tran_callback  = $orderhtel1 ."-". $orderhtel2 ."-". $orderhtel3;
                                
                                $tran_msg = $adm_smsRecord[smstext]." 주문번호 : ".$ordernum; 
                                $smsQue = "insert into em_tran set tran_phone = '".$tran_phone."', tran_callback = '".$tran_callback."', tran_msg= '".$tran_msg."', tran_status = 1, tran_date = now()";
                                mysql_query($smsQue);
                            }
						}

						## 무통장 입금 이메일 발송.
						if($orderemail) {
							include "od_ordercomplete_bankMail.php";
						}
					} else if($paymethod=="G") {

						## 포인트 결제 정보를 sms로 발송
						if($orderhtel1 && $orderhtel2 && $orderhtel3) {
							$tran_phone = $orderhtel1 ."-". $orderhtel2 ."-". $orderhtel3;
                            $tran_callback  = $row_company[tel];

                            if ("y" == $mem_smsRecord[smschk])
                            {
                                $tran_msg = $mem_smsRecord[smstext]." 주문번호 : ".$ordernum;
                                $smsQue = "insert into em_tran set tran_phone = '".$tran_phone."', tran_callback = '".$tran_callback."', tran_msg= '".$tran_msg."', tran_status = 1, tran_date = now()";
                                mysql_query($smsQue);
                            }

                            
                            #관리자에게 문자발송
                            $tran_phone         = $row_company[htel];
                            $tran_callback  = $orderhtel1 ."-". $orderhtel2 ."-". $orderhtel3;

                            if ("y" == $adm_smsRecord[smschk])
                            {
                                $tran_msg = $adm_smsRecord[smstext]." 주문번호 : ".$ordernum;
                                $smsQue   = "insert into em_tran set tran_phone = '".$tran_phone."', tran_callback = '".$tran_callback."', tran_msg= '".$tran_msg."', tran_status = 1, tran_date = now()";
                                mysql_query($smsQue);
                            }
						}

						## 포인트결제 이메일 발송.
						if($orderemail) {
							include "od_ordercomplete_bankMail.php";
						}
					}
					###########################
					## 포인트 차감
					###########################
					if($gPrice) {
						// 차감
						mysql_query("update odtMember set point = point - ".$gPrice." where id ='".$orderid."'");
						// 로그
						mysql_query("insert into odtPointLog set 
													ordernum		=	'".$ordernum."',
													pointID			= '".$orderid."', 
													pointTitle	= '상품 구입시 사용(".$row_product[name].")', 
													pointPoint	= '-".$gPrice."',
													pointResult = '".(mysql_result(mysql_query("select point from odtMember where id ='".$orderid."'"),0))."',
													pointStatus = 'Y',
													pointRegidate = now()");
					}

					###########################
					## 포인트 차감 끝
					###########################


					###########################
					## 사용한 쿠폰 처리
					###########################
					$cLog00 = explode("^",$cLog);
					for($pp=0;$pp<count($cLog00);$pp++) {
						$cLog000 = explode("|",$cLog00[$pp]);
						if($cLog000[0] == "이벤트쿠폰") {
							// 쿠폰 사용처리.
							$queCo = "select coNo from odtCoupon where coType ='이벤트쿠폰' and coPrice ='".$cLog000[1]."' and coID='".$row_member[id]."' and coUse ='N' order by coNo limit 1 ";
							$app_coNo = mysql_result(mysql_query($queCo),0,0);

							mysql_query("update odtCoupon set coUse='Y' where coNo='${app_coNo}' ");
						}
					}
					###########################
					## 사용한 쿠폰 처리 끝
					###########################

						######################
						## 수량 차감
						######################
						$pLog99 = explode("^",$orow[pLog]);
						for($pp = 0;$pp < count($pLog99) ; $pp++) {
							$pLog999 = explode("|",$pLog99[$pp]);
							mysql_query("update odtProduct set stock = stock - ".$pLog999[1].",saleCnt = saleCnt +  ".$pLog999[1]." where code ='".$pLog999[0]."'");
						}
						######################
						## 수량 차감 끝
						######################

						######################
						## 참여점수 입력
						######################
						$queP = "insert into odtActionLog set
											acID			= '".$orow[orderid]."',
											acTitle		= '".$goodname." 구매',
											acPoint		= '300',
											acRegidate = now()";
						mysql_query($queP);

						$queP = "update odtMember set action		= action + 300 where id = '".$orow[orderid]."'";
						mysql_query($queP);
						######################
						## 참여점수 입력 끝
						######################


				if($cInfo[sc_use] == "Y") {
						######################
						## 아이라이크클릭
						######################
						$c_ValueFromClick = $_COOKIE["c_ValueFromClick"];

						if ( $c_ValueFromClick != NULL )
						{
							$iProArrayTmp = explode("^",$pLog);
							for($ii=0;$ii<count($iProArrayTmp);$ii++) {

								$iCode = explode("|",$iProArrayTmp[$ii]);
								$iProInfo = mysql_fetch_array(mysql_query("select * from odtProduct where code ='".$iCode[0]."'"));

								$iBuyNo		= $ordernum;
								$iCCode		= $iProInfo[cateCode];
								$iPCode		= $iCode[0];
								$iPopt		=	"";
								$iPName		= urlencode(iconv("utf-8","euckr",$iProInfo[name]));
								$iPNum		=	$iCode[1];
								$iPrice		=	$iProInfo[price]-$iProInfo[coupon_sale];
								$iBuyType	=	"O";
								$iMemberID=	$orderid;
								$iUserName= urlencode(iconv("utf-8","euckr",$ordername));

								@mysql_query("insert into odtILikeClickLog set
															`ordernum`		= '".$iBuyNo."',
															`proCode`			=	'".$iPCode."',
															`option`			=	'".$iPopt."',
															`proName`			=	'".$iProInfo[name]."',
															`proCnt`			=	'".$iPNum."',
															`price`				=	'".$iPrice."',
															`id`					=	'".$iMemberID."',
															`ordername`		=	'".$ordername."',
															`cookie`			=	'".$c_ValueFromClick."',
															`regidate`		=	now()");


								echo "<SCRIPT LANGUAGE='JavaScript' src='http://www.ilikeclick.com/tracking/sale/v1_Sale.php?MID=".$cInfo[sc_id]."&BUYNO=".$iBuyNo."&CCODE=".$iCCode."&PCODE=".$iPCode."&POPT=".$iPopt."&PNAME=".$iPName."&PNUM=".$iPNum."&PRICE=".$iPrice."&BUYTYPE=".$iBuyType."&MEMBER_ID=".$iMemberID."&USERNAME=".$iUserName."&ValueFromClick=".$c_ValueFromClick."'></SCRIPT>";
							}
						}

						######################
						## 아이라이크클릭 끝
						######################
				}



		}

		if(!$res) {
			error_msgall('주문서 작성중 오류가 발생하였습니다','back');
			exit;
		}

		## 주문정보 호출
		$orow = mysql_fetch_array(mysql_query("SELECT * FROM odtOrder WHERE ordernum='$ordernum'"));
		

	}
	else if($paymethod == "C" || $paymethod == "L")
	{
				$_POST["StoreNm"]  = iconv("utf-8", "euc-kr", $_POST["StoreNm"]);
				$_POST["ProdNm"]   = iconv("utf-8", "euc-kr", $_POST["ProdNm"]);
				$_POST["OrdNm"]    = iconv("utf-8", "euc-kr", $_POST["OrdNm"]);
				$_POST["RcpNm"]    = iconv("utf-8", "euc-kr", $_POST["RcpNm"]);
				$_POST["DlvAddr"]  = iconv("utf-8", "euc-kr", $_POST["DlvAddr"]);
				$_POST["Remark"]   = iconv("utf-8", "euc-kr", $_POST["Remark"]);

				$_POST["KVP_CURRENCY"]   = iconv("utf-8", "euc-kr", $_POST["KVP_CURRENCY"]);
				$_POST["KVP_CARDCODE"]   = iconv("utf-8", "euc-kr", $_POST["KVP_CARDCODE"]);
				$_POST["KVP_SESSIONKEY"] = iconv("utf-8", "euc-kr", $_POST["KVP_SESSIONKEY"]);
				$_POST["KVP_ENCDATA"]    = iconv("utf-8", "euc-kr", $_POST["KVP_ENCDATA"]);
				$_POST["KVP_CONAME"]     = iconv("utf-8", "euc-kr", $_POST["KVP_CONAME"]);
				$_POST["KVP_NOINT"]      = iconv("utf-8", "euc-kr", $_POST["KVP_NOINT"]);
				$_POST["KVP_QUOTA"]      = iconv("utf-8", "euc-kr", $_POST["KVP_QUOTA"]);

				$_POST["KVP_CONAME"]      = iconv("utf-8", "euc-kr", $_POST["KVP_CONAME"]);
				$_POST["KVP_CARDCODE"]      = iconv("utf-8", "euc-kr", $_POST["KVP_CARDCODE"]);

				$_POST["ICHE_OUTBANKNAME"]   = iconv("utf-8", "euc-kr", $_POST["ICHE_OUTBANKNAME"]);
				$_POST["ICHE_OUTBANKMASTER"] = iconv("utf-8", "euc-kr", $_POST["ICHE_OUTBANKMASTER"]);
				$_POST["ES_SENDNO"]          = iconv("utf-8", "euc-kr", $_POST["ES_SENDNO"]);

				/****************************************************************************
				*
				* [1] 라이브러리(AGSLib.php)를 인클루드 합니다.
				*
				****************************************************************************/
				require($_SERVER[DOCUMENT_ROOT]."/Ags/lib/AGSLib.php");

				/****************************************************************************
				*
				* [2]. agspay4.0 클래스의 인스턴스를 생성합니다.
				*
				****************************************************************************/
				$agspay = new agspay40;


				/****************************************************************************
				*
				* [3] AGS_pay.html 로 부터 넘겨받을 데이타
				*
				****************************************************************************/

				/*공통사용*/
				//$agspay->SetValue("AgsPayHome","C:/htdocs/agspay");										//올더게이트 결제설치 디렉토리 (상점에 맞게 수정)
				$agspay->SetValue("AgsPayHome",$_SERVER[DOCUMENT_ROOT]."/Ags");								      						//올더게이트 결제설치 디렉토리 (상점에 맞게 수정)
				$agspay->SetValue("StoreId",trim($_POST["StoreId"]));										//상점아이디
				$agspay->SetValue("log","true");									//true : 로그기록, false : 로그기록안함.
				$agspay->SetValue("logLevel","INFO");							//로그레벨 : DEBUG, INFO, WARN, ERROR, FATAL (해당 레벨이상의 로그만 기록됨)
				$agspay->SetValue("UseNetCancel","true");					//true : 망취소 사용. false: 망취소 미사용
				$agspay->SetValue("Type", "Pay");									//고정값(수정불가)
				$agspay->SetValue("RecvLen", 7);									//수신 데이터(길이) 체크 에러시 6 또는 7 설정. 
				
				$agspay->SetValue("AuthTy",trim($_POST["AuthTy"]));					//결제형태
				$agspay->SetValue("SubTy",trim($_POST["SubTy"]));						//서브결제형태
				$agspay->SetValue("OrdNo",trim($_POST["OrdNo"]));						//주문번호
				$agspay->SetValue("Amt",trim($_POST["Amt"]));								//금액
				$agspay->SetValue("UserEmail",trim($_POST["UserEmail"]));		//주문자이메일
				$agspay->SetValue("ProdNm",trim($_POST["ProdNm"]));					//상품명

				/*신용카드&가상계좌사용*/
				$agspay->SetValue("MallUrl",trim($_POST["MallUrl"]));		//MallUrl(무통장입금) - 상점 도메인 가상계좌추가
				$agspay->SetValue("UserId",trim($_POST["UserId"]));			//회원아이디


				/*신용카드사용*/
				$agspay->SetValue("OrdNm",trim($_POST["OrdNm"]));			//주문자명
				$agspay->SetValue("OrdPhone",trim($_POST["OrdPhone"]));		//주문자연락처
				$agspay->SetValue("OrdAddr",trim($_POST["OrdAddr"]));		//주문자주소 가상계좌추가
				$agspay->SetValue("RcpNm",trim($_POST["RcpNm"]));			//수신자명
				$agspay->SetValue("RcpPhone",trim($_POST["RcpPhone"]));		//수신자연락처
				$agspay->SetValue("DlvAddr",trim($_POST["DlvAddr"]));		//배송지주소
				$agspay->SetValue("Remark",trim($_POST["Remark"]));			//비고
				$agspay->SetValue("DeviId",trim($_POST["DeviId"]));			//단말기아이디
				$agspay->SetValue("AuthYn",trim($_POST["AuthYn"]));			//인증여부
				$agspay->SetValue("Instmt",trim($_POST["Instmt"]));			//할부개월수
				$agspay->SetValue("UserIp",$_SERVER["REMOTE_ADDR"]);		//회원 IP

				/*신용카드(ISP)*/
				$agspay->SetValue("partial_mm",trim($_POST["partial_mm"]));		//일반할부기간
				$agspay->SetValue("noIntMonth",trim($_POST["noIntMonth"]));		//무이자할부기간
				$agspay->SetValue("KVP_CURRENCY",trim($_POST["KVP_CURRENCY"]));	//KVP_통화코드
				$agspay->SetValue("KVP_CARDCODE",trim($_POST["KVP_CARDCODE"]));	//KVP_카드사코드
				$agspay->SetValue("KVP_SESSIONKEY",$_POST["KVP_SESSIONKEY"]);	//KVP_SESSIONKEY
				$agspay->SetValue("KVP_ENCDATA",$_POST["KVP_ENCDATA"]);			//KVP_ENCDATA
				$agspay->SetValue("KVP_CONAME",trim($_POST["KVP_CONAME"]));		//KVP_카드명
				$agspay->SetValue("KVP_NOINT",trim($_POST["KVP_NOINT"]));		//KVP_무이자=1 일반=0
				$agspay->SetValue("KVP_QUOTA",trim($_POST["KVP_QUOTA"]));		//KVP_할부개월

				/*신용카드(안심)*/
				$agspay->SetValue("CardNo",trim($_POST["CardNo"]));			//카드번호
				$agspay->SetValue("MPI_CAVV",$_POST["MPI_CAVV"]);			//MPI_CAVV
				$agspay->SetValue("MPI_ECI",$_POST["MPI_ECI"]);				//MPI_ECI
				$agspay->SetValue("MPI_MD64",$_POST["MPI_MD64"]);			//MPI_MD64

				/*신용카드(일반)*/
				$agspay->SetValue("ExpMon",trim($_POST["ExpMon"]));				//유효기간(월)
				$agspay->SetValue("ExpYear",trim($_POST["ExpYear"]));			//유효기간(년)
				$agspay->SetValue("Passwd",trim($_POST["Passwd"]));				//비밀번호
				$agspay->SetValue("SocId",trim($_POST["SocId"]));				//주민등록번호/사업자등록번호

				/*계좌이체사용*/
				$agspay->SetValue("ICHE_OUTBANKNAME",trim($_POST["ICHE_OUTBANKNAME"]));		//이체은행명
				$agspay->SetValue("ICHE_OUTACCTNO",trim($_POST["ICHE_OUTACCTNO"]));			//이체계좌번호
				$agspay->SetValue("ICHE_OUTBANKMASTER",trim($_POST["ICHE_OUTBANKMASTER"]));	//이체계좌소유주
				$agspay->SetValue("ICHE_AMOUNT",trim($_POST["ICHE_AMOUNT"]));				//이체금액

				/*핸드폰사용*/
				$agspay->SetValue("HP_SERVERINFO",trim($_POST["HP_SERVERINFO"]));	//SERVER_INFO(핸드폰결제)
				$agspay->SetValue("HP_HANDPHONE",trim($_POST["HP_HANDPHONE"]));		//HANDPHONE(핸드폰결제)
				$agspay->SetValue("HP_COMPANY",trim($_POST["HP_COMPANY"]));			//COMPANY(핸드폰결제)
				$agspay->SetValue("HP_ID",trim($_POST["HP_ID"]));					//HP_ID(핸드폰결제)
				$agspay->SetValue("HP_SUBID",trim($_POST["HP_SUBID"]));				//HP_SUBID(핸드폰결제)
				$agspay->SetValue("HP_UNITType",trim($_POST["HP_UNITType"]));		//HP_UNITType(핸드폰결제)
				$agspay->SetValue("HP_IDEN",trim($_POST["HP_IDEN"]));				//HP_IDEN(핸드폰결제)
				$agspay->SetValue("HP_IPADDR",trim($_POST["HP_IPADDR"]));			//HP_IPADDR(핸드폰결제)

				/*ARS사용*/
				$agspay->SetValue("ARS_NAME",trim($_POST["ARS_NAME"]));				//ARS_NAME(ARS결제)
				$agspay->SetValue("ARS_PHONE",trim($_POST["ARS_PHONE"]));			//ARS_PHONE(ARS결제)

				/*가상계좌사용*/
				$agspay->SetValue("VIRTUAL_CENTERCD",trim($_POST["VIRTUAL_CENTERCD"]));	//은행코드(가상계좌)
				$agspay->SetValue("VIRTUAL_DEPODT",trim($_POST["VIRTUAL_DEPODT"]));		//입금예정일(가상계좌)
				$agspay->SetValue("ZuminCode",trim($_POST["ZuminCode"]));				//주민번호(가상계좌)
				$agspay->SetValue("MallPage",trim($_POST["MallPage"]));					//상점 입/출금 통보 페이지(가상계좌)
				$agspay->SetValue("VIRTUAL_NO",trim($_POST["VIRTUAL_NO"]));				//가상계좌번호(가상계좌)

				/*에스크로사용*/
				$agspay->SetValue("ES_SENDNO",trim($_POST["ES_SENDNO"]));				//에스크로전문번호

				/*계좌이체(소켓) 결제 사용 변수*/
				$agspay->SetValue("ICHE_SOCKETYN",trim($_POST["ICHE_SOCKETYN"]));			//계좌이체(소켓) 사용 여부
				$agspay->SetValue("ICHE_POSMTID",trim($_POST["ICHE_POSMTID"]));				//계좌이체(소켓) 이용기관주문번호
				$agspay->SetValue("ICHE_FNBCMTID",trim($_POST["ICHE_FNBCMTID"]));			//계좌이체(소켓) FNBC거래번호
				$agspay->SetValue("ICHE_APTRTS",trim($_POST["ICHE_APTRTS"]));				//계좌이체(소켓) 이체 시각
				$agspay->SetValue("ICHE_REMARK1",trim($_POST["ICHE_REMARK1"]));				//계좌이체(소켓) 기타사항1
				$agspay->SetValue("ICHE_REMARK2",trim($_POST["ICHE_REMARK2"]));				//계좌이체(소켓) 기타사항2
				$agspay->SetValue("ICHE_ECWYN",trim($_POST["ICHE_ECWYN"]));					//계좌이체(소켓) 에스크로여부
				$agspay->SetValue("ICHE_ECWID",trim($_POST["ICHE_ECWID"]));					//계좌이체(소켓) 에스크로ID
				$agspay->SetValue("ICHE_ECWAMT1",trim($_POST["ICHE_ECWAMT1"]));				//계좌이체(소켓) 에스크로결제금액1
				$agspay->SetValue("ICHE_ECWAMT2",trim($_POST["ICHE_ECWAMT2"]));				//계좌이체(소켓) 에스크로결제금액2
				$agspay->SetValue("ICHE_CASHYN",trim($_POST["ICHE_CASHYN"]));				//계좌이체(소켓) 현금영수증발행여부
				$agspay->SetValue("ICHE_CASHGUBUN_CD",trim($_POST["ICHE_CASHGUBUN_CD"]));	//계좌이체(소켓) 현금영수증구분
				$agspay->SetValue("ICHE_CASHID_NO",trim($_POST["ICHE_CASHID_NO"]));			//계좌이체(소켓) 현금영수증신분확인번호

				/*계좌이체-텔래뱅킹(소켓) 결제 사용 변수*/
				$agspay->SetValue("ICHEARS_SOCKETYN", trim($_POST["ICHEARS_SOCKETYN"]));	//텔레뱅킹계좌이체(소켓) 사용 여부
				$agspay->SetValue("ICHEARS_ADMNO", trim($_POST["ICHEARS_ADMNO"]));			//텔레뱅킹계좌이체 승인번호       
				$agspay->SetValue("ICHEARS_POSMTID", trim($_POST["ICHEARS_POSMTID"]));		//텔레뱅킹계좌이체 이용기관주문번호
				$agspay->SetValue("ICHEARS_CENTERCD", trim($_POST["ICHEARS_CENTERCD"]));	//텔레뱅킹계좌이체 은행코드      
				$agspay->SetValue("ICHEARS_HPNO", trim($_POST["ICHEARS_HPNO"]));			//텔레뱅킹계좌이체 휴대폰번호   
				
				/****************************************************************************
				*
				* [4] 올더게이트 결제서버로 결제를 요청합니다.
				*
				****************************************************************************/
				$agspay->startPay();


	
				// 카드결제로 넘어온값 처리.
				if($agspay->GetResult("rSuccYn") != "y")
				{ 
					mysql_query("update odtOrder set ordersau = '".iconv("euc-kr","utf-8",$agspay->GetResult('rResMsg'))."', orderstep='fail' where ordernum = '".$agspay->GetResult("rOrdNo")."'");
					error_msgall('결제가 이루어 지지 않았습니다. 사유('.iconv("euc-kr","utf-8",$agspay->GetResult('rResMsg')).')');
					echo "<script>history.go(-2);</script>";
					exit;
				} 
				else
				{

					$authum					= $agspay->GetResult('rApprNo');
					$ordernumResult = $agspay->GetResult('rOrdNo');
					$tPriceResult		= $agspay->GetResult('rAmt');
					$apprTm         = $agspay->GetResult('rApprTm');
					$dealNo         = $agspay->GetResult('rDealNo');
					$subTy          = $agspay->GetResult("SubTy");

					$que = "select count(*) from odtOrder where ordernum = '".$ordernumResult ."'	";
					$res = mysql_query($que);

					############################
					## 구매 완료 처리
					############################
					if(mysql_result($res,0) == 1) {

						# 결재완료 
						mysql_query("update odtOrder set paystatus = 'Y' , orderstep='finish', paydate = now(), authum = '".$authum."', apprTm = '".$apprTm."', dealNo = '".$dealNo."', subTy = '".$subTy."' where ordernum ='".$ordernumResult."'");

						## 주문정보 호출
						$orow = mysql_fetch_array(mysql_query("SELECT * FROM odtOrder WHERE ordernum='$ordernumResult'"));
						
						## 구매레포트에 저장
						sellRecord($orow);

						############################
						## sms로 발송
						############################
						if($orow[orderhtel1] && $orow[orderhtel2] && $orow[orderhtel3]) {
							$tran_phone			= $orow[orderhtel1] ."-". $orow[orderhtel2] ."-". $orow[orderhtel3];
							$tran_callback	= $row_company[tel];

                            if ("y" == $mem_smsRecord[smschk])
                            {
                                $tran_msg = $mem_smsRecord[smstext]." 주문번호 : ".$orow[ordernum];
                                $smsQue = "insert into em_tran set tran_phone = '".$tran_phone."', tran_callback = '".$tran_callback."', tran_msg= '".$tran_msg."', tran_status = 1, tran_date = now()";
                                mysql_query($smsQue);
                            }


                            if ("y" == $adm_smsRecord[smschk])
                            {
                                #운영자
                                $tran_phone = $row_company[htel];
                                $tran_msg = $adm_smsRecord[smstext]." 주문번호 : ".$orow[ordernum];
                                $smsQue     = "insert into em_tran set tran_phone = '".$tran_phone."', tran_callback = '".$tran_callback."', tran_msg= '".$tran_msg."', tran_status = 1, tran_date = now()";
                                mysql_query($smsQue);
                            }



						}
						############################
						## sms로 발송 끝
						############################

						############################
						## 포인트 지급 및 차감 및 로그에 남김
						############################
                        $goodname = mysql_result(mysql_query("select name from odtProduct where code ='".reset(explode("|",$orow[pLog]))."'"),0);

						if($orow[gPrice] > 0 && $row_member[id]) {
							
							// 차감
							$queG = "update odtMember set point = point - ".$orow[gPrice]." where id = '".$orow[orderid]."'";
							mysql_query($queG);

							// 로그
							$queL = "insert into odtPointLog set
												pointID				= '".$orow[orderid]."',
												pointTitle		= '상품 구입시 사용(".$goodname.")',
												pointPoint		= '-".$orow[gPrice]."',
												pointResult		=	'".mysql_result(mysql_query("select point from odtMember where id='".$orow[orderid]."'"),0)."',
												pointStatus		= 'Y',
												ordernum			=	'".$orow[ordernum]."',
												pointRegidate = now()";
							mysql_query($queL);

						
						}
						if($row_member[id]) {

							if($orow[gGetPrice] > 0) {
							//증가
//							$queG = "update odtMember set point = point + ".$orow[gGetPrice]." where id = '".$orow[orderid]."'";
//							mysql_query($queG);

								// 로그
								$queL = "insert into odtPointLog set
													pointID				= '".$orow[orderid]."',
													pointTitle		= '상품 구입(".$goodname.")',
													pointPoint		= '".$orow[gGetPrice]."',
													pointStatus		= 'N',
													pointRegidate = now(),
													ordernum			=	'".$orow[ordernum]."',
													redRegidate		=	'".date('Y-m-d',strtotime("+30 days"))."'";
								mysql_query($queL);
		
							}

							## 배너이벤트
							if($_COOKIE[hID] && conn_hID($_COOKIE[hID]) != $orow[orderid] ) {
								$queL = "insert into odtPointLog set
													pointID				= '".conn_hID($_COOKIE[hID])."',
													pointTitle		= '베너이벤트(".$goodname.")',
													pointPoint		= '".round($orow[tPrice]*0.01)."',
													pointStatus		= 'N',
													pointRegidate = now(),
													ordernum			=	'".$orow[ordernum]."',
													redRegidate		=	'".date('Y-m-d',strtotime("+30 days"))."'";
								mysql_query($queL);
							}
						}
						############################
						## 포인트 지급 및 차감 및 로그에 남김 끝
						############################


						############################
						## 사용한 쿠폰 처리
						############################
						$cLog00 = explode("^",$orow[cLog]);
						for($pp=0;$pp<count($cLog00);$pp++) {
							$cLog000 = explode("|",$cLog00[$pp]);
							if($cLog000[0] == "이벤트쿠폰") {
								// 쿠폰 사용처리.
								$queCo = "select coNo from odtCoupon where coType ='이벤트쿠폰' and coPrice ='".$cLog000[1]."' and coID='".$row_member[id]."' and coUse ='N' order by coNo limit 1 ";
								$app_coNo = mysql_result(mysql_query($queCo),0,0);

								mysql_query("update odtCoupon set coUse='Y' where coNo='${app_coNo}' ");
							}
						}
						############################
						## 사용한 쿠폰 처리 끝
						############################

						######################
						## 수량 차감
						######################
						$pLog99 = explode("^",$orow[pLog]);
						for($pp = 0;$pp < count($pLog99) ; $pp++) {
							$pLog999 = explode("|",$pLog99[$pp]);
							mysql_query("update odtProduct set stock = stock - ".$pLog999[1].",saleCnt = saleCnt +  ".$pLog999[1]." where code ='".$pLog999[0]."'");
						}
						######################
						## 수량 차감 끝
						######################

						######################
						## 참여점수 입력
						######################
						$queP = "insert into odtActionLog set
											acID			= '".$orow[orderid]."',
											acTitle		= '".$goodname." 구매',
											acPoint		= '300',
											acRegidate = now()";
						mysql_query($queP);

						$queP = "update odtMember set action		= action + 300 where id = '".$orow[orderid]."'";
						mysql_query($queP);
						######################
						## 참여점수 입력 끝
						######################


						

						###################################
						## 카드결제완료 이메일 발송.
						###################################
						if($orow[orderemail]) include "od_ordercomplete_cardMail.php";



				if($cInfo[sc_use] == "Y") {
						######################
						## 아이라이크클릭
						######################
						$c_ValueFromClick = $_COOKIE["c_ValueFromClick"];

						if ( $c_ValueFromClick != NULL )
						{
							$iProArrayTmp = explode("^",$orow[pLog]);
							for($ii=0;$ii<count($iProArrayTmp);$ii++) {

								$iCode = explode("|",$iProArrayTmp[$ii]);
								$iProInfo = mysql_fetch_array(mysql_query("select * from odtProduct where code ='".$iCode[0]."'"));
								
								$iPayMethodArray = array("Card" => "C","VCard" => "C","DirectBank" => "O");

								$iBuyNo		= $orow[ordernum];
								$iCCode		= $iProInfo[cateCode];
								$iPCode		= $iCode[0];
								$iPopt		=	"";
								$iPName		= urlencode(iconv("utf-8","euckr",$iProInfo[name]));
								$iPNum		=	$iCode[1];
								$iPrice		=	$iProInfo[price]-$iProInfo[coupon_sale];
								$iBuyType	=	$iPayMethodArray[$paymethod];
								$iMemberID=	$orow[orderid];
								$iUserName= urlencode(iconv("utf-8","euckr",$orow[ordername]));

								@mysql_query("insert into odtILikeClickLog set
															`ordernum`		= '".$iBuyNo."',
															`proCode`			=	'".$iPCode."',
															`option`			=	'".$iPopt."',
															`proName`			=	'".$iProInfo[name]."',
															`proCnt`			=	'".$iPNum."',
															`price`				=	'".$iPrice."',
															`id`					=	'".$iMemberID."',
															`ordername`		=	'".$orow[ordername]."',
															`cookie`			=	'".$c_ValueFromClick."',
															`regidate`		=	now()");


								echo "<SCRIPT LANGUAGE='JavaScript' src='http://www.ilikeclick.com/tracking/sale/v1_Sale.php?MID=".$cInfo[sc_id]."&BUYNO=".$iBuyNo."&CCODE=".$iCCode."&PCODE=".$iPCode."&POPT=".$iPopt."&PNAME=".$iPName."&PNUM=".$iPNum."&PRICE=".$iPrice."&BUYTYPE=".$iBuyType."&MEMBER_ID=".$iMemberID."&USERNAME=".$iUserName."&ValueFromClick=".$c_ValueFromClick."'></SCRIPT>";
							}
						}
						######################
						## 아이라이크클릭 끝
						######################
				}


					############################
					## 구매 완료 처리 끝
					############################
					} else {
						mysql_query("update odtOrder set ordersau = '구매완료 처리중 알수없는 오류' where ordernum = '".$agspay->GetResult('rApprNo')."'");
						error_msgall('결제중 오류가 발생하였습니다.');
						echo "<script>history.go(-2);</script>";
						exit;
					}

				}

	} else {
		error_msgall('결제중 오류가 발생하였습니다.');
		@mysql_query("update odtOrder set ordersau = '카드결제방법 오류', orderstep='fail' where ordernum = '".$agspay->GetResult('rApprNo')."'");
		@mysql_query("insert into errorLog set content='카드결제 오류 paymethod = ".$paymethod."', url = '".$_SERVER[PHP_SELF]."' , regidate = now()");
		echo "<script>history.back();</script>";
		exit;
	}






	// 주문확인 및 결제 공통 정보 ---> PG사 추가에 따른 공통 파일 마련
	include "od_ordercomplete.common_inc.php";

?>