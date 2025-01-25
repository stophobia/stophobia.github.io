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
    function sellRecord($orow) {
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
                            reID                    =   '".$orow[orderid]."',
                            reCode              = '".$parent_code."',
                            reAge                   = '".$row_memberInfo[age]."',
                            rePosition      = '".reset(explode(" ",$row_memberInfo[address]))."',
                            reLevel             = '".$row_memberInfo[actionLevel]."',
                            reTime              = '".$reTime."',
                            reRegidate      = now()";
        mysql_query($reQue);

        return;
    }


    if($paymethod == "B" || $paymethod == "G") { //무통장 입금이나 전액 포인트 결제시 바로 주문완료페이지로 오므로 주문테이블에 입력.

        # 주문번호 쿠키로 꾸어놓음.. 주문서 수정할경우를 위해.
        setCookie("pre_ordernum",$ordernum);

        $parent_code    =   addslashes(trim($_POST[parent_code]));// 부모 상품코드
        $ordernum           = addslashes(trim($_POST[ordernum]));       // 주문번호
        $ordertel1      = addslashes(trim($_POST[ordertel1]));  // 주문자 전화
        $ordertel2      = addslashes(trim($_POST[ordertel2]));  //
        $ordertel3      = addslashes(trim($_POST[ordertel3]));  //
        $cLog                   = addslashes(trim($_POST[cLog]));               // 쿠폰사용로그
        $pLog                   = addslashes(trim($_POST[pLog]));               // 상품구매로그 
        $oLog                   = addslashes(trim($_POST[oLog]));               // 구매한상품옵션로그
        $gPrice             = addslashes(trim($_POST[gPrice]));         // 사용한 포인트
        $gGetPrice      = addslashes(trim($_POST[gGetPrice]));  // 적립될 포인트
        $dPrice             = addslashes(trim($_POST[dPrice]));         // 배송비
        $sPrice             = addslashes(trim($_POST[sPrice]));         // 총할인금액
        $tPrice             = addslashes(trim($_POST[tPrice]));         // 최종결제금액
        $ordername      = addslashes(trim($_POST[ordername]));  // 주문자명
        $orderhtel1     = addslashes(trim($_POST[orderhtel1])); // 주문자핸드폰
        $orderhtel2     = addslashes(trim($_POST[orderhtel2])); //
        $orderhtel3     = addslashes(trim($_POST[orderhtel3])); //
        $orderemail     = addslashes(trim($_POST[orderemail])); // 주문자 이메일
        $recname            = addslashes(trim($_POST[recname]));        // 수취인명
        $rectel1            = addslashes(trim($_POST[rectel1]));        // 수취인전화
        $recemail           = addslashes(trim($_POST[recemail]));       // 수취인이메일
        $rectel2            = addslashes(trim($_POST[rectel2]));        //
        $rectel3            = addslashes(trim($_POST[rectel3]));        //
        $rechtel1           = addslashes(trim($_POST[rechtel1]));       // 수취인핸드폰
        $rechtel2           = addslashes(trim($_POST[rechtel2]));       //
        $rechtel3           = addslashes(trim($_POST[rechtel3]));       //
        $reczip1            = addslashes(trim($_POST[reczip1]));        // 수취인 우편번호
        $reczip2            = addslashes(trim($_POST[reczip2]));        //
        $recaddress     = addslashes(trim($_POST[recaddress])); // 수취인 주소
        $recaddress1    = addslashes(trim($_POST[recaddress1]));//
        $viewDel            =   addslashes(trim($_POST[viewDel]));      //
        $comment            = addslashes(trim($_POST[comment]));        // 배송희망멘트
        $taxorder           = addslashes(trim($_POST[taxorder]));       // 세금계산서신청유무 (Y / N)
        $companynum     = addslashes(trim($_POST[companynum])); // 사업자등록번호
        $companyname    = addslashes(trim($_POST[companyname]));// 상호명
        $ceoname            = addslashes(trim($_POST[ceoname]));        // 대표자명
        $companyadd     = addslashes(trim($_POST[companyadd])); // 사업장주소
        $taxstatus      = addslashes(trim($_POST[taxstatus]));  // 사업형태
        $taxitem            = addslashes(trim($_POST[taxitem]));        // 종목
        $paymethod      = addslashes(trim($_POST[paymethod]));  // 결제방법 (무통장 B , 카드 C , 실시간계좌이체 L)
        $paybankname    = addslashes(trim($_POST[paybankname]));// 입금계좌 (은행명/예금주/계좌번호)
        $paydatey           = addslashes(trim($_POST[paydatey]));       // 입금예정일
        $paydatem           = addslashes(trim($_POST[paydatem]));       //
        $paydated           = addslashes(trim($_POST[paydated]));       //
        $payname            = addslashes(trim($_POST[payname]));        // 입금자명

        $orderid            =   $row_member[id] ? $row_member[id] : $_SESSION[Gid];               // 주문자 아이디, 비회원은 guest

        if(!$orderid) $orderid = @mysql_result(mysql_query("select id from odtMember2 where name = '".$ordername."' and  email ='".$orderemail."' limit 1"),0);


        # 입금 계좌정보 쪼갬.
        $paybankname = isset($paybankname) ? explode("/",$paybankname) : NULL;

        ## 데이터 무결성 체크를 한번 해야함..


        ######################################


        #해당 상품의 정보 추출
        $row_product = mysql_fetch_array(mysql_query("select * from odtProduct where code = '".$parent_code."'"));

        # 이미 등록된 주문인지 체크.
        $isOrder = mysql_result(mysql_query("select count(*) from odtOrder where ordernum = '".$ordernum."'"),0);


        if($isOrder)    {    //이미 등록되어있는 주문건이면 수정.

            #수정 .
            $que = "update odtOrder set
                            partnerCode         = '".$row_product[customerCode]."',
                            orderid                 = '".$orderid."',
                            ordername               = '".$ordername."',
                            orderemail          = '".$orderemail."',
                            ordertel1               = '".$ordertel1."',
                            ordertel2               = '".$ordertel2."',
                            ordertel3               = '".$ordertel3."',
                            orderhtel1          = '".$orderhtel1."',
                            orderhtel2          = '".$orderhtel2."',
                            orderhtel3          = '".$orderhtel3."',
                            recname                 = '".$recname."',
                            recemail                = '".$recemail."',
                            rectel1                 = '".$rectel1."',
                            rectel2                 = '".$rectel2."',
                            rectel3                 = '".$rectel3."',
                            rechtel1                = '".$rechtel1."',
                            rechtel2                = '".$rechtel2."',
                            rechtel3                = '".$rechtel3."',
                            reczip1                 = '".$reczip1."',
                            reczip2                 = '".$reczip2."',
                            recaddress          = '".$recaddress."',
                            recaddress1         = '".$recaddress1."',
                            viewDel                 =   '".$viewDel."',
                            comment                 = '".$comment."',
                            taxorder                = '".$taxorder."',
                            companynum          = '".$companynum."',
                            companyname         = '".$companyname."',
                            ceoname                 = '".$ceoname."',
                            companyadd          = '".$companyadd."',
                            taxstatus               = '".$taxstatus."',
                            taxitem                 = '".$taxitem."',
                            cLog                        = '".$cLog."',
                            pLog                        = '".$pLog."',
                            oLog                        = '".$oLog."',
                            gPrice                  = '".$gPrice."',
                            gGetPrice               = '".$gGetPrice."',
                            dPrice                  = '".$dPrice."',
                            sPrice                  = '".$sPrice."',
                            tPrice                  = '".$tPrice."',
                            pointed                 = 'N',
                            paymethod               = '".$paymethod."',
                            paystatus               = '".($paymethod == "G" ? "Y" : "N")."',
                            paydate                 =   ".($paymethod == "G" ? "now()" : "'0000-00-00 00:00:00'").",
                            paybankname         = '".$paybankname[0]."/".$paybankname[1]."',
                            paybanknum          = '".$paybankname[2]."',
                            paydatey                = '".$paydatey."',
                            paydatem                = '".$paydatem."',
                            paydated                = '".$paydated."',
                            payname                 = '".$payname."',
                            md_name                 = '".$row_product[md_name]."',
                            ip                          = '".$_SERVER[REMOTE_ADDR]."'
                            where
                            ordernum                = '".$ordernum."'";

            $res = mysql_query($que);

        }   else { // 없으면 새등록


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
                            ordernum                = '".$ordernum."',
                            partnerCode         = '".$row_product[customerCode]."',
                            orderid                 = '".$orderid."',
                            ordername               = '".$ordername."',
                            orderemail          = '".$orderemail."',
                            ordertel1               = '".$ordertel1."',
                            ordertel2               = '".$ordertel2."',
                            ordertel3               = '".$ordertel3."',
                            orderhtel1          = '".$orderhtel1."',
                            orderhtel2          = '".$orderhtel2."',
                            orderhtel3          = '".$orderhtel3."',
                            recname                 = '".$recname."',
                            recemail                = '".$recemail."',
                            rectel1                 = '".$rectel1."',
                            rectel2                 = '".$rectel2."',
                            rectel3                 = '".$rectel3."',
                            rechtel1                = '".$rechtel1."',
                            rechtel2                = '".$rechtel2."',
                            rechtel3                = '".$rechtel3."',
                            reczip1                 = '".$reczip1."',
                            reczip2                 = '".$reczip2."',
                            recaddress          = '".$recaddress."',
                            recaddress1         = '".$recaddress1."',
                            viewDel                 =   '".$viewDel."',
                            comment                 = '".$comment."',
                            taxorder                = '".$taxorder."',
                            companynum          = '".$companynum."',
                            companyname         = '".$companyname."',
                            ceoname                 = '".$ceoname."',
                            companyadd          = '".$companyadd."',
                            taxstatus               = '".$taxstatus."',
                            taxitem                 = '".$taxitem."',
                            cLog                        = '".$cLog."',
                            pLog                        = '".$pLog."',
                            oLog                        = '".$oLog."',
                            gPrice                  = '".$gPrice."',
                            gGetPrice               = '".$gGetPrice."',
                            dPrice                  = '".$dPrice."',
                            sPrice                  = '".$sPrice."',
                            tPrice                  = '".$tPrice."',
                            pointed                 = 'N',
                            orderstep               =   'finish',
                            paymethod               = '".$paymethod."',
                            paystatus               = '".($paymethod == "G" ? "Y" : "N")."',
                            paydate                 =   ".($paymethod == "G" ? "now()" : "'0000-00-00 00:00:00'").",
                            paybankname         = '".$paybankname[0]."/".$paybankname[1]."',
                            paybanknum          = '".$paybankname[2]."',
                            paydatey                = '".$paydatey."',
                            paydatem                = '".$paydatem."',
                            paydated                = '".$paydated."',
                            payname                 = '".$payname."',
                            orderdate               =   now(),
                            orderstatus         =   'Y',
                            md_name                 = '".$row_product[md_name]."',
                            hID                         =   '".$_COOKIE[hID]."',
                            ip                          = '".$_SERVER[REMOTE_ADDR]."'";

                    $res = mysql_query($que);
                    
                    if($paymethod=="B") {
                        ## 무통장 입금 정보를 sms로 발송
                        if($orderhtel1 && $orderhtel2 && $orderhtel3) {
                            $tran_phone         = $orderhtel1 ."-". $orderhtel2 ."-". $orderhtel3;
                            $tran_callback  = $row_company[tel];

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
                            $tran_phone         = $orderhtel1 ."-". $orderhtel2 ."-". $orderhtel3;
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
                                                    ordernum        =   '".$ordernum."',
                                                    pointID         = '".$orderid."', 
                                                    pointTitle  = '상품 구입시 사용(".$row_product[name].")', 
                                                    pointPoint  = '-".$gPrice."',
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
                                            acID            = '".$orow[orderid]."',
                                            acTitle     = '".$goodname." 구매',
                                            acPoint     = '300',
                                            acRegidate = now()";
                        mysql_query($queP);

                        $queP = "update odtMember set action        = action + 300 where id = '".$orow[orderid]."'";
                        mysql_query($queP);
                        ######################
                        ## 참여점수 입력 끝
                        ######################


                if($cInfo[sc_use] == "Y") {
                        ######################
                        ## 아이라이크클릭
                        ######################
                        $c_ValueFromClick = $_COOKIE ["c_ValueFromClick"];

                        if ( $c_ValueFromClick != NULL )
                        {
                            $iProArrayTmp = explode("^",$pLog);
                            for($ii=0;$ii<count($iProArrayTmp);$ii++) {

                                $iCode = explode("|",$iProArrayTmp[$ii]);
                                $iProInfo = mysql_fetch_array(mysql_query("select * from odtProduct where code ='".$iCode[0]."'"));

                                $iBuyNo     = $ordernum;
                                $iCCode     = $iProInfo[cateCode];
                                $iPCode     = $iCode[0];
                                $iPopt      =   "";
                                $iPName     = urlencode(iconv("utf-8","euckr",$iProInfo[name]));
                                $iPNum      =   $iCode[1];
                                $iPrice     =   $iProInfo[price]-$iProInfo[coupon_sale];
                                $iBuyType   =   "O";
                                $iMemberID= $orderid;
                                $iUserName= urlencode(iconv("utf-8","euckr",$ordername));

                                @mysql_query("insert into odtILikeClickLog set
                                                            `ordernum`      = '".$iBuyNo."',
                                                            `proCode`           =   '".$iPCode."',
                                                            `option`            =   '".$iPopt."',
                                                            `proName`           =   '".$iProInfo[name]."',
                                                            `proCnt`            =   '".$iPNum."',
                                                            `price`             =   '".$iPrice."',
                                                            `id`                    =   '".$iMemberID."',
                                                            `ordername`     =   '".$ordername."',
                                                            `cookie`            =   '".$c_ValueFromClick."',
                                                            `regidate`      =   now()");


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
        

    } else if($gopaymethod == "Card" || $gopaymethod == "VCard" || $gopaymethod == "DirectBank" || $gopaymethod == "HPP") {

                /**************************
                 * 1. 라이브러리 인클루드 *
                 **************************/
                require($_SERVER[DOCUMENT_ROOT]."/../INIpayG/libs/INILib.php");
                
                
                /***************************************
                 * 2. INIpay50 클래스의 인스턴스 생성 *
                 ***************************************/
                $inipay = new INIpay50;

                /*********************
                 * 3. 지불 정보 설정 *
                 *********************/
                $inipay->SetField("inipayhome", $_SERVER[DOCUMENT_ROOT]."/../INIpayG"); // 이니페이 홈디렉터리(상점수정 필요)
                $inipay->SetField("type", "securepay");                         // 고정 (절대 수정 불가)
                $inipay->SetField("pgid", "INIphp".$pgid);                      // 고정 (절대 수정 불가)
                $inipay->SetField("subpgip","203.238.3.10");                    // 고정 (절대 수정 불가)
                $inipay->SetField("admin", $_SESSION['INI_ADMIN']);    // 키패스워드(상점아이디에 따라 변경)
                $inipay->SetField("debug", "true");                             // 로그모드("true"로 설정하면 상세로그가 생성됨.)
                $inipay->SetField("uid", $uid);                                 // INIpay User ID (절대 수정 불가)
                $inipay->SetField("uip", getenv("REMOTE_ADDR"));                // 고정 (절대 수정 불가)
                $inipay->SetField("goodname", iconv("utf-8","euckr",$goodname));// 상품명 
                $inipay->SetField("currency", $currency);                       // 화폐단위

                $inipay->SetField("mid", $_SESSION['INI_MID']);        // 상점아이디
                $inipay->SetField("rn", $_SESSION['INI_RN']);          // 웹페이지 위변조용 RN값
                $inipay->SetField("price", $_SESSION['INI_PRICE']);        // 가격
                $inipay->SetField("enctype", $_SESSION['INI_ENCTYPE']);// 고정 (절대 수정 불가)


                     /*----------------------------------------------------------------------------------------
                         price 등의 중요데이터는
                         브라우저상의 위변조여부를 반드시 확인하셔야 합니다.

                         결제 요청페이지에서 요청된 금액과
                         실제 결제가 이루어질 금액을 반드시 비교하여 처리하십시오.

                         설치 메뉴얼 2장의 결제 처리페이지 작성부분의 보안경고 부분을 확인하시기 바랍니다.
                         적용참조문서: 이니시스홈페이지->가맹점기술지원자료실->기타자료실 의
                                                        '결제 처리 페이지 상에 결제 금액 변조 유무에 대한 체크' 문서를 참조하시기 바랍니다.
                         예제)
                         원 상품 가격 변수를 OriginalPrice 하고  원 가격 정보를 리턴하는 함수를 Return_OrgPrice()라 가정하면
                         다음 같이 적용하여 원가격과 웹브라우저에서 Post되어 넘어온 가격을 비교 한다.

                    $OriginalPrice = Return_OrgPrice();
                    $PostPrice = $_SESSION['INI_PRICE']; 
                    if ( $OriginalPrice != $PostPrice )
                    {
                        //결제 진행을 중단하고  금액 변경 가능성에 대한 메시지 출력 처리
                        //처리 종료 
                    }

                        ----------------------------------------------------------------------------------------*/
                $inipay->SetField("buyername", iconv("utf-8","euckr",$buyername));       // 구매자 명
                $inipay->SetField("buyertel",  $buyertel);        // 구매자 연락처(휴대폰 번호 또는 유선전화번호)
                $inipay->SetField("buyeremail",$buyeremail);      // 구매자 이메일 주소
                $inipay->SetField("paymethod", $paymethod);       // 지불방법 (절대 수정 불가)
                $inipay->SetField("encrypted", $encrypted);       // 암호문
                $inipay->SetField("sessionkey",$sessionkey);      // 암호문
                $inipay->SetField("url", "http://".$_SERVER[HTTP_HOST]); // 실제 서비스되는 상점 SITE URL로 변경할것
                $inipay->SetField("cardcode", $cardcode);         // 카드코드 리턴
                $inipay->SetField("parentemail", $parentemail);   // 보호자 이메일 주소(핸드폰 , 전화결제시에 14세 미만의 고객이 결제하면  부모 이메일로 결제 내용통보 의무, 다른결제 수단 사용시에 삭제 가능)
                
                /*-----------------------------------------------------------------*
                 * 수취인 정보 *                                                   *
                 *-----------------------------------------------------------------*
                 * 실물배송을 하는 상점의 경우에 사용되는 필드들이며               *
                 * 아래의 값들은 INIsecurepay.html 페이지에서 포스트 되도록        *
                 * 필드를 만들어 주도록 하십시요.                                  *
                 * 컨텐츠 제공업체의 경우 삭제하셔도 무방합니다.                   *
                 *-----------------------------------------------------------------*/
                $inipay->SetField("recvname",iconv("utf-8","euckr",$recvname));     // 수취인 명
                $inipay->SetField("recvtel",$recvtel);                                                      // 수취인 연락처
                $inipay->SetField("recvaddr",iconv("utf-8","euckr",$recvaddr));     // 수취인 주소
                $inipay->SetField("recvpostnum",$recvpostnum);                                      // 수취인 우편번호
                $inipay->SetField("recvmsg",iconv("utf-8","euckr",$recvmsg));           // 전달 메세지

                $inipay->SetField("joincard",$joincard);                                                    // 제휴카드코드
                $inipay->SetField("joinexpire",$joinexpire);                                            // 제휴카드유효기간
                $inipay->SetField("id_customer",$id_customer);                                      // user_id

                
                /****************
                 * 4. 지불 요청 *
                 ****************/
                $inipay->startAction();
                
    
        // 카드결제로 넘어온값 처리.
//              include_once "../odcommon/od_lib.inc.php";
                if($inipay->GetResult('ResultCode') != "00") {
                    mysql_query("update odtOrder set ordersau = '".iconv("euc-kr","utf-8",$inipay->GetResult('ResultMsg'))."', orderstep='fail' where ordernum = '".$inipay->GetResult('MOID')."'");
                    error_msgall('결제가 이루어 지지 않았습니다. 사유('.iconv("euc-kr","utf-8",$inipay->GetResult('ResultMsg')).')');
                    echo "<script>history.go(-2);</script>";
                    exit;
                } else {
                    $inipay->GetResult('PayMethod'); // 1:카드결제, 3:실시간, 5:핸드폰

                    $authum                 = $inipay->GetResult('TID');
                    $ordernumResult = $inipay->GetResult('MOID');
                    $tPriceResult       = $inipay->GetResult('TotPrice');

                    $que = "select count(*) from odtOrder where ordernum = '".$ordernumResult ."' and tPrice = '".$tPriceResult."'";
                    $res = mysql_query($que);

                    ############################
                    ## 구매 완료 처리
                    ############################
                    if(mysql_result($res,0) == 1) {

                        # 결재완료 
                        mysql_query("update odtOrder set paystatus = 'Y' , orderstep='finish', paydate = now(), authum = '".$authum."' where ordernum ='".$ordernumResult."'");

                        ## 주문정보 호출
                        $orow = mysql_fetch_array(mysql_query("SELECT * FROM odtOrder WHERE ordernum='$ordernumResult'"));
                        
                        ## 구매레포트에 저장
                        sellRecord($orow);

                        ############################
                        ## sms로 발송
                        ############################
                        if($orow[orderhtel1] && $orow[orderhtel2] && $orow[orderhtel3]) {
                            $tran_phone         = $orow[orderhtel1] ."-". $orow[orderhtel2] ."-". $orow[orderhtel3];
                            $tran_callback  = $row_company[tel];

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
                        if($orow[gPrice] > 0 && $row_member[id]) {
                            
                            // 차감
                            $queG = "update odtMember set point = point - ".$orow[gPrice]." where id = '".$orow[orderid]."'";
                            mysql_query($queG);

                            // 로그
                            $queL = "insert into odtPointLog set
                                                pointID             = '".$orow[orderid]."',
                                                pointTitle      = '상품 구입시 사용(".$goodname.")',
                                                pointPoint      = '-".$orow[gPrice]."',
                                                pointResult     =   '".mysql_result(mysql_query("select point from odtMember where id='".$orow[orderid]."'"),0)."',
                                                pointStatus     = 'Y',
                                                ordernum            =   '".$orow[ordernum]."',
                                                pointRegidate = now()";
                            mysql_query($queL);

                        
                        }
                        if($row_member[id]) {

                            if($orow[gGetPrice] > 0) {
                            //증가
//                          $queG = "update odtMember set point = point + ".$orow[gGetPrice]." where id = '".$orow[orderid]."'";
//                          mysql_query($queG);

                                // 로그
                                $queL = "insert into odtPointLog set
                                                    pointID             = '".$orow[orderid]."',
                                                    pointTitle      = '상품 구입(".$goodname.")',
                                                    pointPoint      = '".$orow[gGetPrice]."',
                                                    pointStatus     = 'N',
                                                    pointRegidate = now(),
                                                    ordernum            =   '".$orow[ordernum]."',
                                                    redRegidate     =   '".date('Y-m-d',strtotime("+30 days"))."'";
                                mysql_query($queL);
        
                            }

                            ## 배너이벤트
                            if($_COOKIE[hID] && conn_hID($_COOKIE[hID]) != $orow[orderid] ) {
                                $queL = "insert into odtPointLog set
                                                    pointID             = '".conn_hID($_COOKIE[hID])."',
                                                    pointTitle      = '베너이벤트(".$goodname.")',
                                                    pointPoint      = '".round($orow[tPrice]*0.01)."',
                                                    pointStatus     = 'N',
                                                    pointRegidate = now(),
                                                    ordernum            =   '".$orow[ordernum]."',
                                                    redRegidate     =   '".date('Y-m-d',strtotime("+30 days"))."'";
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
                                            acID            = '".$orow[orderid]."',
                                            acTitle     = '".$goodname." 구매',
                                            acPoint     = '300',
                                            acRegidate = now()";
                        mysql_query($queP);

                        $queP = "update odtMember set action        = action + 300 where id = '".$orow[orderid]."'";
                        mysql_query($queP);
                        ######################
                        ## 참여점수 입력 끝
                        ######################

                        ######################
                        ##  팝업창 종료
                        ######################
                        echo "
                            <script>
                            var openwin=window.open('childwin.html','childwin','width=299,height=149');
                            openwin.close();
                            </script>
                                    ";
                        

                        ###################################
                        ## 카드결제완료 이메일 발송.
                        ###################################
                        if($orow[orderemail]) include "od_ordercomplete_cardMail.php";



                if($cInfo[sc_use] == "Y") {
                        ######################
                        ## 아이라이크클릭
                        ######################
                        $c_ValueFromClick = $_COOKIE ["c_ValueFromClick"];

                        if ( $c_ValueFromClick != NULL )
                        {
                            $iProArrayTmp = explode("^",$orow[pLog]);
                            for($ii=0;$ii<count($iProArrayTmp);$ii++) {

                                $iCode = explode("|",$iProArrayTmp[$ii]);
                                $iProInfo = mysql_fetch_array(mysql_query("select * from odtProduct where code ='".$iCode[0]."'"));
                                
                                $iPayMethodArray = array("Card" => "C","VCard" => "C","DirectBank" => "O");

                                $iBuyNo     = $orow[ordernum];
                                $iCCode     = $iProInfo[cateCode];
                                $iPCode     = $iCode[0];
                                $iPopt      =   "";
                                $iPName     = urlencode(iconv("utf-8","euckr",$iProInfo[name]));
                                $iPNum      =   $iCode[1];
                                $iPrice     =   $iProInfo[price]-$iProInfo[coupon_sale];
                                $iBuyType   =   $iPayMethodArray[$paymethod];
                                $iMemberID= $orow[orderid];
                                $iUserName= urlencode(iconv("utf-8","euckr",$orow[ordername]));

                                @mysql_query("insert into odtILikeClickLog set
                                                            `ordernum`      = '".$iBuyNo."',
                                                            `proCode`           =   '".$iPCode."',
                                                            `option`            =   '".$iPopt."',
                                                            `proName`           =   '".$iProInfo[name]."',
                                                            `proCnt`            =   '".$iPNum."',
                                                            `price`             =   '".$iPrice."',
                                                            `id`                    =   '".$iMemberID."',
                                                            `ordername`     =   '".$orow[ordername]."',
                                                            `cookie`            =   '".$c_ValueFromClick."',
                                                            `regidate`      =   now()");


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
                        mysql_query("update odtOrder set ordersau = '구매완료 처리중 알수없는 오류' where ordernum = '".$inipay->GetResult('MOID')."'");
                        error_msgall('결제중 오류가 발생하였습니다.');
                        echo "<script>history.go(-2);</script>";
                        exit;
                    }

                }
    } else if($paymethod == "VBank") {
        /**************************
         * 1. 라이브러리 인클루드 *
         **************************/
        require($_SERVER[DOCUMENT_ROOT]."/INIescrow41/sample/INIpay41Lib.php");
        
        /***************************************
         * 2. INIpay41 클래스의 인스턴스 생성 *
         ***************************************/
        $inipay = new INIpay41;



        /*********************
         * 3. 지불 정보 설정 *
         *********************/
        $inipay->m_inipayHome = $_SERVER[DOCUMENT_ROOT]."/INIescrow41";      // 이니페이 홈디렉터리
        $inipay->m_type = "securepay";              // 고정 (절대 수정 불가)
        $inipay->m_pgId = "INIpay".$pgid;           // 고정 (절대 수정 불가)
        $inipay->m_subPgIp = "203.238.3.10";            // 고정 (절대 수정 불가)


        $inipay->m_keyPw = "1111";              // 키패스워드(상점아이디에 따라 변경)
        $inipay->m_debug = "true";              // 로그모드("true"로 설정하면 상세로그가 생성됨.)
        $inipay->m_mid = $row_setup[P_SID];                  // 상점아이디
        $inipay->m_uid = $uid;                  // INIpay User ID (절대 수정 불가)
        $inipay->m_uip = getenv("REMOTE_ADDR");         // 고정 (절대 수정 불가)
        $inipay->m_goodName = iconv("utf-8","euckr",$goodname);         // 상품명 
        $inipay->m_currency = $currency;            // 화폐단위
        $inipay->m_price = $_POST["price"];             // 결제금액
        $inipay->m_buyerName = iconv("utf-8","euckr",$buyername);           // 구매자 명
        $inipay->m_buyerTel = $buyertel;            // 구매자 연락처(휴대폰 번호 또는 유선전화번호)
        $inipay->m_buyerEmail = $buyeremail;            // 구매자 이메일 주소
        $inipay->m_payMethod = $paymethod;          // 지불방법 (절대 수정 불가)
        $inipay->m_encrypted = $encrypted;          // 암호문
        $inipay->m_sessionKey = $sessionkey;            // 암호문
        $inipay->m_url = "http://".$_SERVER[HTTP_HOST];     // 실제 서비스되는 상점 SITE URL로 변경할것
        $inipay->m_cardcode = $cardcode;            // 카드코드 리턴
        $inipay->m_ParentEmail = $parentemail;          // 보호자 이메일 주소(핸드폰 , 전화결제시에 14세 미만의 고객이 결제하면  부모 이메일로 결제 내용통보 의무, 다른결제 수단 사용시에 삭제 가능)


        $inipay->m_recvName = iconv("utf-8","euckr",$recvname); // 수취인 명
        $inipay->m_recvTel = $recvtel;      // 수취인 연락처
        $inipay->m_recvAddr = iconv("utf-8","euckr",$recvaddr); // 수취인 주소
        $inipay->m_recvPostNum = $recvpostnum;  // 수취인 우편번호
        $inipay->m_recvMsg = iconv("utf-8","euckr",$recvmsg);       // 전달 메세지

        $inipay->m_returntype = ""; // URL 통보 방식 : U , java 데몬 수신: J , window 데몬 수신 :W
        $inipay->m_returnurl = "";  // URL 로 전달 받기 위한 상점 수신 URL
        $inipay->m_returnip = "";   // tcp/ip 통신을 통한 전달을 받기 위한 상점 IP
        $inipay->m_returnport = "";  // tcp/ip 통신을 통한 전달을 받기 위한 상점 port


        /****************
         * 4. 지불 요청 *
         ****************/
        $inipay->startAction();

        //
        // 에스크로로 넘어온값 처리.
        //
        if($inipay->m_resultCode != "00") 
        {
            mysql_query("update odtOrder set ordersau = '".iconv("euckr","utf-8",$inipay->m_resultMsg) . "', orderstep='fail' where ordernum = '".$inipay->m_moid."'");
            error_msgall('결제가 이루어 지지 않았습니다. 사유('. iconv("euckr","utf-8", $inipay->m_resultMsg) . ")");
            echo "<script>history.go(-2);</script>";
        } 
        else 
        {
            
            # 변수 설정
            $authum             = $inipay->m_tid;
            $ordernumResult     = $inipay->m_moid;
            $tPriceResult       = $inipay->m_resultprice;   
            $escrowBankNum      = $inipay->m_vacct;                             //입금계좌번호
            $escrowBankName     = $inipay->m_vcdbank;                           //입금은행명
            $escrowName         = iconv("euckr","utf-8",$inipay->m_nmvacct);    //예금주
            $escrowInputName    = iconv("euckr","utf-8",$inipay->m_nminput ) ;  //입금자명
            $escrowOrderNum     = $ordernumResult;                                                  //상품주문번호
            $escrowInputDate    = $inipay->m_dtinput;                                   //입금예정일




            # 결재완료 
            mysql_query("update odtOrder set orderstep='finish', authum = '".$authum."' where ordernum ='".$ordernumResult."'");

            ## 주문정보 호출
            $orow = mysql_fetch_array(mysql_query("SELECT * FROM odtOrder WHERE ordernum='$ordernumResult'"));

            ## 구매레포트에 저장
            sellRecord($orow);

            ############################
            ## 포인트 차감 및 로그에 남김
            ############################
            if($orow[gPrice] > 0 && $row_member[id]) {
                            
                // 차감
                $queG = "update odtMember set point = point - ".$orow[gPrice]." where id = '".$orow[orderid]."'";
                mysql_query($queG);

                // 로그
                $queL = "insert into odtPointLog set
                                    pointID             = '".$orow[orderid]."',
                                    pointTitle      = '상품 구입시 사용(".$goodname.")',
                                    pointPoint      = '-".$orow[gPrice]."',
                                    pointResult     =   '".mysql_result(mysql_query("select point from odtMember where id='".$orow[orderid]."'"),0)."',
                                    pointStatus     = 'Y',
                                    pointRegidate = now()";
                mysql_query($queL);
                
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

            #  팝업창 종료
            echo "
                <script>
                var openwin=window.open('childwin.html','childwin','width=299,height=149');
                openwin.close();
                </script>
                        ";

            ## 카드결제완료 이메일 발송.
            if($orow[orderemail]) {
                include "ordercomplete_escrowMail.php";
            }



            ######################
            ## 아이라이크클릭
            ######################
            $c_ValueFromClick = $_COOKIE ["c_ValueFromClick"];

            if ( $c_ValueFromClick != NULL )
            {
                $iProArrayTmp = explode("^",$orow[pLog]);
                for($ii=0;$ii<count($iProArrayTmp);$ii++) {

                    $iCode = explode("|",$iProArrayTmp[$ii]);
                    $iProInfo = mysql_fetch_array(mysql_query("select * from odtProduct where code ='".$iCode[0]."'"));

                    $iBuyNo     = $orow[ordernum];
                    $iCCode     = $iProInfo[cateCode];
                    $iPCode     = $iCode[0];
                    $iPopt      =   "";
                    $iPName     = urlencode(iconv("utf-8","euckr",$iProInfo[name]));
                    $iPNum      =   $iCode[1];
                    $iPrice     =   $iProInfo[price]-$iProInfo[coupon_sale];
                    $iBuyType   =   "O";
                    $iMemberID= $orow[orderid];
                    $iUserName= urlencode(iconv("utf-8","euckr",$orow[ordername]));

                    @mysql_query("insert into odtILikeClickLog set
                                                `ordernum`      = '".$iBuyNo."',
                                                `proCode`           =   '".$iPCode."',
                                                `option`            =   '".$iPopt."',
                                                `proName`           =   '".$iProInfo[name]."',
                                                `proCnt`            =   '".$iPNum."',
                                                `price`             =   '".$iPrice."',
                                                `id`                    =   '".$iMemberID."',
                                                `ordername`     =   '".$orow[ordername]."',
                                                `cookie`            =   '".$c_ValueFromClick."',
                                                `regidate`      =   now()");


                    echo "<SCRIPT LANGUAGE='JavaScript' src='http://www.ilikeclick.com/tracking/sale/v1_Sale.php?MID=honamtoday&BUYNO=".$iBuyNo."&CCODE=".$iCCode."&PCODE=".$iPCode."&POPT=".$iPopt."&PNAME=".$iPName."&PNUM=".$iPNum."&PRICE=".$iPrice."&BUYTYPE=".$iBuyType."&MEMBER_ID=".$iMemberID."&USERNAME=".$iUserName."&ValueFromClick=".$c_ValueFromClick."'></SCRIPT>";
                }
            }
            ######################
            ## 아이라이크클릭 끝
            ######################



        ############################
        ## 구매 완료 처리 끝
        ############################
        }
    }
    else
    {
        error_msgall('결제중 오류가 발생하였습니다.');
        @mysql_query("update odtOrder set ordersau = '카드결제방법 오류', orderstep='fail' where ordernum = '".$inipay->GetResult('MOID')."'");
        @mysql_query("insert into errorLog set content='카드결제 오류 paymethod = ".$paymethod."', url = '".$_SERVER[PHP_SELF]."' , regidate = now()");
        echo "<script>history.back();</script>";
        exit;
    }

    include "../odcommon/od_head.inc.php";
    include "../odcommon/od_body.inc.php";


?>
    </head>
                    <!-- top 시작 -->
<? include $_SERVER[DOCUMENT_ROOT]."/pages/subHead.html"; ?>
                    <!-- top 끝 -->
                    <!-- main start -->
          <table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                            <td height="31">&nbsp;</td>
                        </tr>
          </table>


<style type="text/css">
<!--
.style20 {
    color: #FF0000;
    font-weight: bold;
    font-size: 14px;
}
.style21 {color: #333333}
.style24 {
    color: #18abe1;
    font-weight: bold;
}
-->
</style>

                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td valign="top"><table width="855" border="0" align="center" cellpadding="0" cellspacing="0">
                      <tr>
                        <td><img src="/img/order_img_02.jpg" width="855" height="123" /></td>
                      </tr>
                    </table>
                      <table width="855" border="0" align="center" cellpadding="0" cellspacing="0">
                        <tr>
                          <td valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                            <tr>
                              <td height="23"></td>
                            </tr>
                          </table>
                            <table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#ffffff">
                              <tr>
                                <td valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                  <tr>
                                    <td><img src="/img/order_img_31.jpg" width="855" height="46" /></td>
                                  </tr>
                                </table>
                                  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                    <tr>
                                      <td><img src="/img/order_img_05.jpg" width="855" height="20" /></td>
                                    </tr>
                                  </table>
                                  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                    <tr>
                                      <td width="36" valign="top" background="/img/order_img_06.jpg">&nbsp;</td>
                                      <td width="783" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                        <tr>
                                          <td><img src="/img/order_img_32.jpg" width="75" height="24" /></td>
                                        </tr>
                                      </table>

                                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                          <tr>
                                            <td valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                              <tr>
                                                <td height="1" bgcolor="#d2dde0"></td>
                                              </tr>
                                            </table>
                                              <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                <tr>
                                                  <td height="30" bgcolor="#eeeeee"><table width="781" border="0" align="center" cellpadding="0" cellspacing="0">
                                                                                                        <tr>
                                                                                                            <td width="425" height="38"><div align="center"><strong>상 품 명</strong></div></td>
                                                                                                            <td width="120"><div align="center"><b>가 격</b></div></td>
                                                                                                            <td width="120"><div align="center"><b>수 량</b></div></td>
                                                                                                            <td width="40">&nbsp;</td>
                                                                                                            <td><div align="center"><b>합 계</b></div></td>
                                                                                                        </tr>
                                                                                                </table></td>
                                                </tr>
                                              </table>
                                              <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                <tr>
                                                  <td height="1" bgcolor="#d2dde0"></td>
                                                </tr>
                                              </table></td>
                                          </tr>
                                        </table>
<?
// 맨 앞의 ^를 제거하기 위함..
$oLogArray = explode("^",preg_replace("[^\^]","",$orow[oLog]));
$pLogArray = explode("^",$orow[pLog]);
for($i=0;$i<count($pLogArray);$i++) {
    list($buyCode,$buyCnt,$buyPrice) = explode("|",$pLogArray[$i]);
    $tmpRow = mysql_fetch_array(mysql_query("select * from odtProduct where code ='".$buyCode."'"));
    if($oLogArray[$i]) {    // 해당상품에 대한 옵션내역이 있으면
        $oLogTmp = explode("|",$oLogArray[$i]);
        $buyPrice += $oLogTmp[2];
        $tmpRow[name] .= "(".$oLogTmp[1].")";
    }
?>
                                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                          <tr>
                                            <td valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                              <tr>
                                                <td height="37"><table width="781" border="0" align="center" cellpadding="0" cellspacing="0">
                                                                                                    <tr>
                                                                                                        <td width="425" height="38"><div align="center"><strong><?=$tmpRow[name]?></strong></div></td>
                                                                                                        <td width="120"><div align="center"><?=number_format($buyPrice)?> 원</div></td>
                                                                                                        <td width="120"><div align="center"><?=$buyCnt?> 개</div></td>
                                                                                                        <td width="40">&nbsp;</td>
                                                                                                        <td><div align="center"><?=number_format($buyPrice * $buyCnt)?> 원</div></td>
                                                                                                    </tr>
                                                                                            </table></td>
                                              </tr>
                                            </table>
                                              <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                <tr>
                                                  <td height="1" bgcolor="#d2dde0"></td>
                                                </tr>
                                              </table></td>
                                          </tr>
                                        </table>
<?
}
?>
                                                                                <!-- 결제정보 -->
                                                                                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                          <tr>
                                            <td><img src="/img/order_img_28.jpg" width="92" height="35" /></td>
                                          </tr>
                                        </table>
                                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                          <tr>
                                            <td valign="top">
                                                                                            <table width="100%" border=0 cellspacing=0 cellpadding=0>
                                                                                                <tr>
                                                                                                    <td height="1" bgcolor="d2dddf"></td>
                                                                                                </tr>
                                                                                            </table>

                                              <table width="100%" border="0" cellspacing="0" cellpadding="0" id="gDisplay" style="display:">
                                                <tr>
                                                  <td width="171"><img src="/img/order_img_43.jpg" width="171" height="38" /></td>
                                                  <td background="/img/order_1_title_07.jpg"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                      <tr>
                                                        <td width="15"></td>
                                                        <td><?=$orow[ordernum]?>                        
                                                                                                                </td>
                                                      </tr>
                                                  </table></td>
                                                </tr>
                                              </table>
                                              <table width="100%" border="0" cellspacing="0" cellpadding="0" id="gDisplay" style="display:">
                                                <tr>
                                                  <td width="171"><img src="/img/order_11_title_02.jpg" width="171" height="38" /></td>
                                                  <td background="/img/order_1_title_07.jpg"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                      <tr>
                                                        <td width="15"></td>
                                                        <td>                                                                
                                            <?
                                            if($orow[paymethod] == "C") echo "카드결제";
                                            if($orow[paymethod] == "H") echo "핸드폰결제";
                                            if($orow[paymethod] == "B") echo "무통장입금";
                                            if($orow[paymethod] == "L") echo "실시간계좌이체";
                                            if($orow[paymethod] == "G") echo "전액 포인트 결제";
                                            if($orow[paymethod] == "E") echo "무통장입금 [에스크로]";
                                            ?>                                                                                                              
                                                                                                                </td>
                                                      </tr>
                                                  </table></td>
                                                </tr>
                                              </table>
<?
if(!ereg("B|E",$orow[paymethod])) {
?>
                                              <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                <tr>
                                                  <td width="171"><img src="/img/order_11_title_03_.jpg" width="171" height="38" /></td>
                                                  <td background="/img/order_1_title_07.jpg"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                      <tr>
                                                        <td width="15"></td>
                                                        <td>결제성공</td>
                                                      </tr>
                                                  </table></td>
                                                </tr>
                                              </table>
 <?
} else if(ereg("B|E",$orow[paymethod])) {
    $payNumTmp = explode("/",$orow[paybankname]);

    if($orow[paymethod] == "B") {
        $inputInfoName = $payNumTmp[0]." ".$orow[paybanknum]." ".$payNumTmp[1];
        $inputInfoDate = $orow[paydatey]."년 ".$orow[paydatem]."월 ".$orow[paydated]."일";
        $inputInfoUser = $orow[payname];
    } else {
        $inputInfoName = $escrowBankName." ".$escrowBankNum." (예금주:".$escrowName.")";
        $inputInfoDate = $escrowInputDate." ".$escrowInputTime;
        $inputInfoUser = $escrowInputName;
    }
?>
                                              <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                <tr>
                                                  <td width="171"><img src="/img/order_11_title_03.jpg" width="171" height="38" /></td>
                                                  <td background="/img/order_1_title_07.jpg"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                      <tr>
                                                        <td width="15"></td>
                                                        <td><?=$inputInfoName?></td>
                                                      </tr>
                                                  </table></td>
                                                </tr>
                                              </table>
                                                                                            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                <tr>
                                                  <td width="171"><img src="/img/order_11_title_04.jpg" width="171" height="38" /></td>
                                                  <td background="/img/order_1_title_07.jpg"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                      <tr>
                                                        <td width="15"></td>
                                                        <td><?=$inputInfoDate?>                                                                                                     
                                                                                                                </td>
                                                      </tr>
                                                  </table></td>
                                                </tr>
                                              </table>
                                              <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                <tr>
                                                  <td width="171"><img src="/img/order_11_title_05.jpg" width="171" height="39" /></td>
                                                  <td background="/img/order_1_title_07.jpg"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                      <tr>
                                                        <td width="15"></td>
                                                        <td><?=$inputInfoUser?></td>
                                                      </tr>
                                                  </table></td>
                                                </tr>
                                              </table>
<?
}
?>
                                                                                            <table width="100%" border=0 cellspacing=0 cellpadding=0>
                                                                                                <tr>
                                                                                                    <td height="1" bgcolor="d2dddf"></td>
                                                                                                </tr>
                                                                                            </table>
                                                                                            </td>
                                          </tr>
                                        </table>




                                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                          <tr>
                                            <td height="21"></td>
                                          </tr>
                                        </table>
                                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                          <tr>
                                            <td><img src="/img/order_img_33.jpg" width="136" height="31" /></td>
                                          </tr>
                                        </table>
                                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                          <tr>
                                            <td valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                <tr>
                                                  <td height="1" bgcolor="#d2dde0"></td>
                                                </tr>
                                              </table>
                                                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                  <tr>
                                                    <td height="30" bgcolor="#eeeeee"><table width="781" border="0" align="center" cellpadding="0" cellspacing="0">
                                                                                                            <tr>
                                                                                                                <td width="95" height="36"><div align="center"><b>항 목</b></div></td>
                                                                                                                <td width="580"><div align="center"><b>내 용</b></div></td>
                                                                                                                <td width="30">&nbsp;</td>
                                                                                                                <td align=right style="padding-right:10px"><b>금 액</b></td>
                                                                                                            </tr>
                                                                                                    </table></td>
                                                  </tr>
                                                </table>
                                              <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                  <tr>
                                                    <td height="1" bgcolor="#d2dde0"></td>
                                                  </tr>
                                              </table></td>
                                          </tr>
                                        </table>

            <!-- 쿠폰 -->
<?
if($orow[cLog]) {
    $cLogArray = explode("^",$orow[cLog]);
    for($i=0;$i<count($cLogArray);$i++) {
        list($cName,$cPrice) = explode("|",$cLogArray[$i]);
    ?>
                                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                          <tr>
                                            <td valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                <tr>
                                                  <td height="37"><table width="781" border="0" align="center" cellpadding="0" cellspacing="0">
                                                                                                        <tr>
                                                                                                            <td width="95" height="36"><div align="center">할인</div></td>
                                                                                                            <td width="580" ><div align="center"><?=$cName?></div></td>
                                                                                                            <td width="30">&nbsp;</td>
                                                                                                            <td align=right style="padding-right:10px">- <?=number_format($cPrice)?> 원</td>
                                                                                                        </tr>
                                                                                                </table></td>
                                                </tr>
                                              </table>
                                                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                  <tr>
                                                    <td height="1" bgcolor="#d2dde0"></td>
                                                  </tr>
                                              </table></td>
                                          </tr>
                                        </table>
    <?
    }
}
?>

<?
if($orow[gPrice]) {
?>
            <!-- 적립금 사용내역 -->
                                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                          <tr>
                                            <td valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                <tr>
                                                  <td height="37"><table width="781" border="0" align="center" cellpadding="0" cellspacing="0">
                                                                                                        <tr>
                                                                                                            <td width="95" height="36"><div align="center">할인</div></td>
                                                                                                            <td width="580" ><div align="center">적립금 사용</div></td>
                                                                                                            <td width="30" >&nbsp;</td>
                                                                                                            <td  align=right style="padding-right:10px">- <?=number_format($orow[gPrice])?> 원</td>
                                                                                                        </tr>
                                                                                                </table></td>
                                                </tr>
                                              </table>
                                                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                  <tr>
                                                    <td height="1" bgcolor="#d2dde0"></td>
                                                  </tr>
                                              </table></td>
                                          </tr>
                                        </table>

<?
}
?>
<?
if($orow[dPrice]) {
?>
                                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                          <tr>
                                            <td valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                <tr>
                                                  <td height="37"><table width="781" border="0" align="center" cellpadding="0" cellspacing="0">
                                                                                                        <tr>
                                                                                                            <td width="95" height="36" ><div align="center">추가</div></td>
                                                                                                            <td width="580" ><div align="center">배송비</div></td>
                                                                                                            <td width="30" >&nbsp;</td>
                                                                                                            <td  align=right style="padding-right:10px">+ <?=number_format($orow[dPrice])?> 원</td>
                                                                                                        </tr>
                                                                                                </table></td>
                                                </tr>
                                              </table>
                                                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                  <tr>
                                                    <td height="1" bgcolor="#d2dde0"></td>
                                                  </tr>
                                              </table></td>
                                          </tr>
                                        </table>

<?
}
?>

                                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                          <tr>
                                            <td height="15"></td>
                                          </tr>
                                        </table>
                                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                          <tr>
                                            <td valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                              <tr>
                                                <td height="1" bgcolor="#d5c4b9"></td>
                                              </tr>
                                            </table>
                                              <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                <tr>
                                                  <td width="510"></td>
                                                  <td><table width="100%" border="1" bordercolor="#FFFFFF"cellspacing="0" cellpadding="0">
                                                    <tr>
                                                      <td height="28" bgcolor="#f6f2e9"><div align="center" class="style21">총 결제된 금액</div></td>
                                                      <td bgcolor="#eeeeee" align=right ><?=number_format($orow[tPrice])?> 원</td>
                                                      </tr>
                                                    <tr>
                                                      <td height="28" bgcolor="#f6f2e9"><div align="center" class="style21">총 할인 금액</div></td>
                                                      <td bgcolor="#eeeeee" align=right ><strong><?=$orow[sPrice] ? "- ".number_format($orow[sPrice]) : "0";?> 원</strong></td>
                                                      </tr>
                                                    <tr style='display:none'>
                                                      <td height="28" bgcolor="#f6f2e9"><div align="center" class="style21">배송비</div></td>
                                                      <td bgcolor="#eeeeee" align=right ><strong><?=$orow[dPrice] ? "+ ". number_format($orow[dPrice]) : "0";?> 원</strong></td>
                                                      </tr>
                                                    <tr>
                                                      <td height="28" bgcolor="#f6f2e9"><div align="center" class="style21">금일 적립 포인트</div></td>
                                                      <td bgcolor="#eeeeee" align=right><strong><?=$orow[gGetPrice] ? number_format($orow[gGetPrice]) : "0";?> 포인트</strong></td>
                                                      </tr>
                                                  </table></td>
                                                </tr>
                                              </table>
                                              <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                <tr>
                                                  <td height="2" bgcolor="#d5c4b9"></td>
                                                </tr>
                                              </table></td>
                                          </tr>
                                        </table>
                                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                          <tr>
                                            <td height="15"></td>
                                          </tr>
                                        </table>
                                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                          <tr>
                                            <td><img src="/img/order_img_34.jpg" width="104" height="31" /></td>
                                          </tr>
                                        </table>
                                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                          <tr>
                                            <td valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                <tr>
                                                  <td width="171"><img src="/img/order_img_21.jpg" width="171" height="38" /></td>
                                                  <td background="/img/order_img_22.jpg"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                      <tr>
                                                        <td width="15"></td>
                                                        <td><?=$orow[ordername]?></td>
                                                      </tr>
                                                  </table></td>
                                                </tr>
                                              </table>
                                                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                  <tr>
                                                    <td width="171"><img src="/img/order_img_23.jpg" width="171" height="38" /></td>
                                                    <td background="/img/order_img_22.jpg"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                        <tr>
                                                          <td width="15"></td>
                                                          <td><?=$orow[orderhtel1] ."-".$orow[orderhtel2]."-".$orow[orderhtel3];?></td>
                                                        </tr>
                                                    </table></td>
                                                  </tr>
                                                </table>
                                              <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                  <tr>
                                                    <td width="171"><img src="/img/order_img_24.jpg" width="171" height="39" /></td>
                                                    <td background="/img/order_img_25.jpg"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                        <tr>
                                                          <td width="15"></td>
                                                          <td><?=$orow[orderemail]?></td>
                                                        </tr>
                                                    </table></td>
                                                  </tr>
                                              </table></td>
                                          </tr>
                                        </table>
                                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                          <tr>
                                            <td height="15"></td>
                                          </tr>
                                        </table>

<?
if($orow[viewDel] == 1) {
?>
                                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                          <tr>
                                            <td><img src="/img/order_img_26.jpg" /></td>
                                          </tr>
                                        </table>
                                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                          <tr>
                                            <td valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                <tr>
                                                  <td width="171"><img src="/img/order_1_title_01.jpg" width="171" height="38" /></td>
                                                  <td background="/img/order_1_title_07.jpg"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                      <tr>
                                                        <td width="15"></td>
                                                        <td><?=$orow[recname]?></td>
                                                      </tr>
                                                  </table></td>
                                                </tr>
                                              </table>
                                              <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                  <tr>
                                                    <td width="171"><img src="/img/order_1_title_03.jpg" width="171" height="38" /></td>
                                                    <td background="/img/order_1_title_07.jpg"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                        <tr>
                                                          <td width="15"></td>
                                                          <td><?=$orow[rechtel1]."-".$orow[rechtel2]."-".$orow[rechtel3]?></td>
                                                        </tr>
                                                    </table></td>
                                                  </tr>
                                                </table>
                                              <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                <tr>
                                                  <td width="171"><img src="/img/order_img_24_.jpg" width="171" height="38" /></td>
                                                  <td background="/img/order_1_title_07.jpg"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                      <tr>
                                                        <td width="15"></td>
                                                        <td><?=$orow[recemail]?></td>
                                                      </tr>
                                                  </table></td>
                                                </tr>
                                              </table>
                                              <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                <tr>
                                                  <td width="171"><img src="/img/order_img_37.jpg" width="171" height="39" /></td>
                                                  <td background="/img/order_img_25.jpg"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                      <tr>
                                                        <td width="15"></td>
                                                        <td><?=nl2br(htmlspecialchars(stripslashes($orow[comment])))?></td>
                                                      </tr>
                                                  </table></td>
                                                </tr>
                                              </table></td>
                                          </tr>
                                        </table>
                                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                          <tr>
                                            <td height="15"></td>
                                          </tr>
                                        </table>
<?
}
?>
                                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                          <tr>
                                            <td><div align="center" class="unnamed8">주문해 주셔서 감사합니다. 자세한 내용은 MY페이지에서 확인하실 수 있습니다</div></td>
                                          </tr>
                                        </table>
                                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                          <tr>
                                            <td height="10"></td>
                                          </tr>
                                        </table>
                                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                          <tr>
                                            <td><div align="center"><a href="/"><img src="/img/order_img_44.jpg" width="133" height="40" border=0></a></div></td>
                                          </tr>
                                        </table></td>
                                      <td width="36" valign="top" background="/img/order_img_08.jpg">&nbsp;</td>
                                    </tr>
                                  </table></td>
                              </tr>
                            </table>
                            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                              <tr>
                                <td><img src="/img/order_img_29.jpg" width="855" height="35" /></td>
                              </tr>
                            </table>
                            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                              <tr>
                                <td>&nbsp;</td>
                              </tr>
                            </table></td>
                        </tr>
                      </table>


        </td>
    </tr>
</table>
                    <!-- bottom 시작 -->
<? include_once $_SERVER[DOCUMENT_ROOT]."/pages/subFoot.html"; ?>
                    <!-- bottom 끝 -->

