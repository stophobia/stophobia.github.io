<?
	include "../../odcommon/od_config.inc.php";
	include "$folderpath_manager_common/od_function.inc.php";	
	include "$folderpath_manager_common/od_comAuthority.inc.php";
    
    $toDay = date("YmdHis");
    /*
    if($m=="a") {
        ## mktime(시간,분,초,월,일,년);
        $today_time = time();
        $start_date_year = substr($start_date,0,4);
        $start_date_month = substr($start_date,4,2);
        $start_date_day = substr($start_date,6,2);
        $start_date_time = mktime(0,0,0,$start_date_month,$start_date_day,$start_date_year);
        $end_date_year = substr($end_date,0,4);
        $end_date_month = substr($end_date,4,2);
        $end_date_day = substr($end_date,6,2);
        $end_date_time = mktime(23,59,59,$end_date_month,$end_date_day,$end_date_year);
        $fileName = "orderList";
        
        if($key) $search_value = " AND ".$search." LIKE '%".$key."%'";
        if(!$search_standard) $search_standard = "orderdate";
        if(!$page_number) $page_number = "10";
        
        ## 검색조건 Par 정리 #####################################
        $search_value .= " AND canceled='N'";
        
        if($search_value_ == "true") {
            $search = "";
            $key = "";
            
            if($paymethod) $search_value = " AND paymethod='".$paymethod."'";
            if($paystatus) $search_value .= " AND paystatus='".$paystatus."'";
            if($delivstatus) $search_value .= " AND delivstatus='".$delivstatus."'";
            if($start_date && $end_date) $search_value .= " AND ".$search_standard." BETWEEN '$start_date_time' AND '$end_date_time'";
            $search_value .= " AND canceled='N' AND orderstatus='Y'";
            if($order_by) $search_value .= " ORDER BY ".$order_by."";
            if($order_by_rule) $search_value .= " ".$order_by_rule."";
        }
        else {
            $search_value .= " AND canceled='N' AND orderstatus='Y' ORDER BY orderdate DESC";
        }
    }
    else {
        $fileName = "취소주문내역";
        $cancelTitle = ",주문취소일시";
        $search_value .= " AND canceled='Y' AND orderstatus='Y' ORDER BY orderdate DESC";
    }
    */
	$fileName = "od_order_list";

    ## Exel 파일로 변환 #############################################
    header("Content-Type: application/vnd.ms-excel");
    header("Content-Disposition: attachment; filename=$fileName-$toDay.csv");
    
    ##############################################################
    unset($search_value);
    for($i=0;$i<count($OrderNum);$i++) {
        $search_value .= $search_value ? " or " : NULL;
        $search_value .= " ordernum ='".$OrderNum[$i]."' ";
    }

    $result = mysql_query("SELECT * FROM odtOrder WHERE ".$search_value."");

    echo iconv("utf-8","euckr","주문번호,상품명,수량,주문자,E-mail,수령인,전화번호,핸드폰번호,판매가격,배송메세지,배송료,할인쿠폰,지포인트사용,지급포인트,결제수단,입금,배송,쿠폰번호,주문일시,결제일시,배송일시,$cancelTitle");

    while($row = mysql_fetch_array($result)) {

        if($row[paymethod] == "C") $PayMethod = "신용카드";
        else if($row[paymethod] == "L") $PayMethod = "실시간계좌이체";
        else if($row[paymethod] == "H") $PayMethod = "핸드폰결제";
        else if($row[paymethod] == "G") $PayMethod = "전액지포인트결제";

        else $PayMethod = "무통장입금";

        $OrderDate  = $row[orderdate] != "0000-00-00 00:00:00" ? date("Y-m-d H:i:s", strtotime($row[orderdate])) : "미주문";
        $PayDate        = $row[paydate] != "0000-00-00 00:00:00" ? date("Y-m-d H:i:s", strtotime($row[paydate])) : "";
        $DelyDate       = $row[expressdate] ? $row[expressdate] : "";

        
        if($m!="a") {
            if($row[canceldate]) {
                $cancelDate = date("Y년 m월 d일 H시 i분", $row[canceldate]);
            } else {
                $cancelDate = "";
            }
        } else {
            $cancelDate = "";
        }

        $serialnumber = 1;
        
        $recname = eregi_replace(",",".",$row[recname]);
        $comment = eregi_replace(",",".",$row[comment]);
        $comment = eregi_replace("\r\n"," ",$comment);
            
        $PayStauts = "결제확인";

        if($row[delivstatus] == "yes") $DelivStatus = "발송완료";
        else $DelivStatus = "발송대기";

        # 쿠폰사용총 가격 추출
        unset($cPrice);
        $cLogArray = explode("^",$row[cLog]);   
        for($o =0; $o < count($cLogArray); $o++) {
            $cPrice += end(explode("|",$cLogArray[$o]));
        }

        $oLogArray = explode("^",preg_replace("[^\^]","",$row[oLog]));
        $pLogArray = explode("^",$row[pLog]);
        for($o =0; $o < count($pLogArray); $o++) {
            $pLogArray2 = explode("|",$pLogArray[$o]);
            $row_product = mysql_fetch_array(mysql_query("select * from odtProduct where code ='".$pLogArray2[0]."'"));

            if($row[orderdate] < "2009-06-12") {        // 복수구매 기능 이전           

                # 옵션값 추출
                if(strstr($row[oLog],$row_product[code])) {   // 해당상품에 대한 옵션내역이 있으면
                    $oLogArray = explode("^",$row[oLog]);
                    for($kk=0;$kk<count($oLogArray);$kk++) {
                        if(strstr($oLogArray[$kk],$row_product[code])) {
                            $oLogTmp = explode("|",$oLogArray[$kk]);
                            $row_product[name] .= " (옵션:".$oLogTmp[1].")";
                        }
                    }   
                }   

            } else { // 복수구매 기능 이후

                # 옵션값 추출
                if($oLogArray[$o]) {    // 해당상품에 대한 옵션내역이 있으면
                    $oLogTmp = explode("|",$oLogArray[$o]);
                    $row_product[name] .= " (옵션:".$oLogTmp[1].")";
                    $pLogArray2[2] += $oLogTmp[2];
                }   

            }


            // --- 2010-10-12 - 같은 주문상품의 경우 적립금 0 - 적용
            if( $o > 0 ) {
                $app_gGetPrice = 0;
            }
            else {
                $app_gGetPrice = $row[gGetPrice];
            }


            $name = str_replace(",", ".", $row_product[name]);
	        $name = str_replace("'", "`", $name);

            if($row[rectel1] && $row[rectel2] && $row[rectel3]) {
                $tel = $row[rectel1]."-".$row[rectel2]."-".$row[rectel3];
            } else {
                $tel = $row[ordertel1]."-".$row[ordertel2]."-".$row[ordertel3];
            }
            if($row[rechtel1] && $row[rechtel2] && $row[rechtel3]) {
                $htel = $row[rechtel1]."-".$row[rechtel2]."-".$row[rechtel3];
            } else {
                $htel = $row[orderhtel1]."-".$row[orderhtel2]."-".$row[orderhtel3];
            }

            // --- 2010-10-12 - 같은 주문상품의 경우 금액 수정
            echo "
$row[ordernum]";
            echo iconv("utf-8","euckr",",$name,$pLogArray2[1],$row[ordername],$row[orderemail],$recname,$tel,$htel," . ($pLogArray2[2]*$pLogArray2[1]) . ",$comment,$row[dPrice],$cPrice,$row[gPrice],${app_gGetPrice},$PayMethod,$PayStauts,$DelivStatus,$row[expressnum],$OrderDate,$PayDate,$DelyDate,$cancelDate");
//          echo iconv("utf-8","euckr",",$row_product[name],$pLogArray2[1],$row[ordername],$row[orderemail],$recname,$row[reczip1]-$row[reczip2],$row[recaddress] $row[recaddress1],$row[rectel1]-$row[rectel2]-$row[rectel3],$row[rechtel1]-$row[rechtel2]-$row[rechtel3],$row[tPrice],$comment,$row[dPrice],$cPrice,$row[gPrice],$row[gGetPrice],$PayMethod,$PayStauts,$DelivStatus,$row[expressname],$row[expressnum],$OrderDate,$PayDate,$DelyDate,$cancelDate");
        }
        
        $serialnumber++;
    }
?>