<?PHP

	// 2011-01-20 오후 3:36 정준철

    include "../odcommon/od_config.inc.php";
    include "../odcommon/od_function.inc.php";
    include "../odcommon/od_lib.inc.php";
    include "../odcommon/od_head.inc.php";
    include "../odcommon/od_body.inc.php";


    // PG사에 따른 스크립트 추출 //////////////////////////////////////////////
    if ("I" == $row_setup[P_KBN])           // 이니시스
    {
        $action_value  = "od_orderresult.php";
        $action_value2 = "od_ordercomplete.php";
    }
    else if ("A" ==  $row_setup[P_KBN])     // 올더게이트
    {
        $action_value  = "od_orderresult1.php";
        $action_value2 = "od_ordercomplete1.php";
    }
    else if ("M" ==  $row_setup[P_KBN])     // 인포뱅크
    {
        $action_value  = "od_orderresult2.php";
        $action_value2 = "od_ordercomplete_popup.php";
    }
    else if ("K" ==  $row_setup[P_KBN])     // KCP 
    {
        $action_value  = "od_orderresult3.php";
        $action_value2 = "od_ordercomplete3.php";

        include $_SERVER[DOCUMENT_ROOT]."/kcp/cfg/site_conf_inc.php";
    }
    else if ("S" ==  $row_setup[P_KBN])     // 올앳
    {
        $action_value  = "od_orderresult4.php";
        $action_value2 = "od_ordercomplete4.php";
    }
    ///////////////////////////////////////////////////////////////////////////


/*
    if(!$row_member[id] && !$_SESSION[Gid]) {
        echo "<script>alert('잘못된 접근입니다.');location.href='/';</script>";
        exit;
    }
*/
    # 코드값이 없을때 back
    if(!$_GET[code] && !$_POST[code]) {error_msgall("잘못된 접근입니다.","back");exit;}

    if(!$_GET[code] && $_POST[code]) $_GET[code] = $_POST[code];

    # 해당 상품이 오늘 판매 상품인지 체크
    list($sale_date,$cateCode) = mysql_fetch_array(mysql_query("select sale_date, cateCode from odtProduct where code ='".$_GET[code]."'"));

    # 상품정보가 없으면 메인으로 이동
    if(!$sale_date) {error_loc("/");exit;}

    // 미리보기 기능
    $admin = info_admin($row_setup[ranDsum],"00100200300");
    if($admin[superLevel] != 9 && $_GET['buyMode'] != "mart") {

        # 현재 판매상품으로 강제 지정
        $_GET[code] = info_nowsale($cateCode);

    }

    $code = $_GET[code];
    $ordernum = strtoupper(get_ordernumber(7));

    $row_product = mysql_fetch_array(mysql_query("select * from odtProduct where code = '".$_GET[code]."'"));

    // 회원전용상품인지 체크
    if($row_product[guestDisabled] && !$row_member[id]) {
        error_msgall("회원만 구매하실수 있는 상품입니다.","/");
        exit;
    }

    // 중복구매 체크
    if($row_product[ipDistinct]) {
        $orderCheckTmp = @mysql_result(mysql_query("select count(*) from odtOrder where paystatus='Y' and canceled='N' and pLog like '%".$_GET[code]."%' and (ip='".$_SERVER[REMOTE_ADDR]."' or orderid = '".$row_member[id]."')"),0);
        if($orderCheckTmp) {
            error_msgall("중복구입이 불가능한 상품입니다.","/");
            exit;
        }
    }

    // 옵션이 있는지 없는지를 체크 (복수구매를 위해)
    $isOption = @mysql_result(mysql_query("select count(optionName) from odtProduct where parent_code = '".$code."' and optionName != ''"),0);

    //echo "select count(optionName) from odtProduct where parent_code = '".$code."' and optionName != ''"." ". $isOption;


?>
<iframe name="hidden_frame" src="about:blank" width=400 height=400 style="display:none"></iframe>

<?
// PG사에 따른 스크립트 추출 //////////////////////////////////////////////////
if ("I" == $row_setup[P_KBN])
{
    echo "
    <script language=javascript src='http://plugin.inicis.com/pay40_sec_uni.js'></script>
    <script language=javascript>
        StartSmartUpdate();
    </script>";
}
else if ("A" == $row_setup[P_KBN])
{
    echo "
    <script language=javascript src='http://www.allthegate.com/plugin/AGSWallet_utf8.js'></script>
    <script language=javascript>
        StartSmartUpdate(); // 플러그인 설치(확인)
    </script>";
}
else if ("K" == $row_setup[P_KBN])
{
    echo "
    <script type='text/javascript' src='".$g_conf_js_url."'></script>
    <script type='text/javascript'>
        StartSmartUpdate();
    </script>";
}
else if ("S" == $row_setup[P_KBN])
{
    echo "
    <script language=JavaScript charset='euc-kr' src='https://tx.allatpay.com/common/AllatPayRE.js'></script>
    <script language=Javascript>initCheckOB();</script>";
}





?>

<style type="text/css">
<!--
body {
    margin-left: 0px;
    margin-top: 0px;
    margin-right: 0px;
    margin-bottom: 0px;
}
-->
</style>
<script>
String.prototype.comma=function() 
{ 

var l_text=this; 
var l_pattern=/^(-?\d+)(\d{3})($|\..*$)/; 

  if(l_pattern.test(l_text)){ 
    l_text=l_text.replace(l_pattern,function(str,p1,p2,p3) 
    { 
      return p1.comma() + ("," + p2 + p3); 
    }); 
  } 

  return l_text; 

} 
</script>
<style type="text/css">
<!--
.style1 {
    color: #f76a00;
    font-weight: bold;
}
.style2 {
    color: #2759d8;
    font-weight: bold;
}
.style3 {
    color: #2eb000;
    font-weight: bold;
}
.style4 {
    color: #555555;
    font-weight: bold;
}
.style6 {color: #ff601a; font-weight: bold; }
.style7 {color: #555555}
.style8 {color: #ff1319}
.style9 {color: #09689e}
.style10 {color: ##09689e}
.style12 {color: ##09689e; font-weight: bold; }
.style13 {font-weight: bold}
.style14 {
    color: #FF0000;
    font-weight: bold;
    font-size: 14px;
}
.style15 {color: #FF0000}
.style17 {color: #2759d8; font-weight: bold; font-size: 14px; }
.style18 {
    color: #fc29fa;
    font-weight: bold;
}
.style19 {color: #fa7c00}
.style20 {color: #ff7019}
-->
</style>
</head>
<script>
function totalSubmit() {
    var totalSale = 0;

    frm1 = document.orderFrm1;
    frm2 = document.orderFrm2;
    frm3 = document.orderFrm3;
    frm4 = document.orderFrm4;

    // 상품가격
    pName = "상품가격";
    pPrice = frm1.totalPrice.value;
    document.getElementById('pPriceInner').innerHTML = "" + pName + "(<span class='style15'>" + pPrice.comma()+"원</span>)";

    // 배송비
    dName = "배송비";
    dPrice = frm1.dPrice.value;
//  document.getElementById('dPriceInner').innerHTML = "&nbsp;+ " + dName + "(<span class='style15'>" + dPrice.comma()+"원</span>)";
    document.getElementById('dPriceInner').innerHTML = "";

    // 할인쿠폰1
    cPriceSum = 0;
    var cLogVal = "";
    cCnt = frm2.couponCnt.value;
    document.getElementById('cPriceInner').innerHTML = "";

    if(cCnt > 1) {
        for(i=0;i<cCnt;i++) {
            if(frm2.elements['coupon_use[]'][i].checked == true) {
                cName = frm2.elements['couponName[]'][i].value;
                cPrice = frm2.elements['couponPrice[]'][i].value;
                cPriceSum = cPriceSum*1 + cPrice*1;
                document.getElementById('cPriceInner').innerHTML += "&nbsp;- " + cName + "(<span class='style15'>- " + cPrice.comma()+"원</span>)";

                if(cLogVal) cLogVal = cLogVal + "^";
                cLogVal = cLogVal + cName + "|" + cPrice;
            }
        }
    } else if(cCnt == 1) {
        if(frm2.elements['coupon_use[]'].checked == true) {
            cName = frm2.elements['couponName[]'].value;
            cPrice = frm2.elements['couponPrice[]'].value;
            cPriceSum = cPriceSum*1 + cPrice*1;
            document.getElementById('cPriceInner').innerHTML += "&nbsp;- " + cName + "(<span class='style15'>- " + cPrice.comma()+"원</span>)";
            if(cLogVal) cLogVal = cLogVal + "^";
            cLogVal = cLogVal + cName + "|" + cPrice;
        }
    }


    totalSale = totalSale*1 +  cPriceSum*1;

    frm4.cLog.value = cLogVal;

    // 포인트
    gName = "포인트";
    gPrice = frm3.gPoint.value;
    if(gPrice > 0) {
        document.getElementById('gPriceInner').innerHTML = "&nbsp;- " + gName + "(<span class='style15'>- " + gPrice.comma()+" </span>)";
    }
    totalSale = totalSale*1 + gPrice*1;


    // 총할인금액
    totalSale = String(totalSale);
    totalSaleTmp = totalSale;
    totalSale = totalSale != "0" ? "- " + totalSale.comma() : "0";
    document.getElementById('totalSaleInner').innerHTML = totalSale;

    // 총결제금액
    tPrice = parseInt(pPrice) + parseInt(dPrice) - parseInt(cPriceSum) - parseInt(gPrice);
    if(tPrice < 0) tPrice = 0;

    document.getElementById('totalPaymentInner').innerHTML = String(tPrice).comma();

    // 전액 적립금 결제인지 체크
    if(tPrice == 0) {
        if(gPrice > 0) {
            document.getElementById('totalPaymentInner2').innerHTML = "전액 포인트 결제";
        }
        else {
            document.getElementById('totalPaymentInner2').innerHTML = "0 포인트 결제(전액 포인트 결제와 같이 적용됩니다.)";// 0원 결제
        }
        document.getElementById('gDisplay').style.display = "none";
        document.orderFrm4.action='/odprogram/odproducts/<?=$action_value2?>';
        document.orderFrm4.paymethod[4].checked = true;
        document.getElementById('payHide').style.display = 'none';
    } 
    else {
        document.getElementById('totalPaymentInner2').innerHTML = String(tPrice).comma() + " 원";
        document.getElementById('gDisplay').style.display = "";
        document.orderFrm4.action="/odprogram/odproducts/<?=$action_value?>";
        document.orderFrm4.paymethod[0].checked = true;
        document.getElementById('payHide').style.display = 'none';
    }

    // 에스크로 비활성화
    if(tPrice < 99999999) {
        document.getElementById('bank1').style.display = "none";
        document.getElementById('bank2').style.display = "none";
        document.getElementById('escrow1').style.display = "none";
        document.getElementById('escrow2').style.display = "none";
        document.getElementById('escrow3').style.display = "none";
    } else {
        document.getElementById('bank1').style.display = "none";
        document.getElementById('bank2').style.display = "none";
        document.getElementById('escrow1').style.display = "none";
        document.getElementById('escrow2').style.display = "none";
        document.getElementById('escrow3').style.display = "none";
    }

    // 포인트
    getGPoint = parseInt((tPrice - dPrice)*<?=$row_product[point]/100?>);
    if(getGPoint > 0) {
        document.getElementById('getGPointInner').innerHTML = String(getGPoint).comma();
    } else {
        getGPoint= 0;
        document.getElementById('getGPointInner').innerHTML = String(getGPoint).comma();
    }


    /////////////////////////////////////
    // 중요데이터 추출
    /////////////////////////////////////

    // 상품정보
    var pLogVal = "";
    pObj = frm1.elements['codeArray[]'];
    pCnt = frm1.elements['orderCountArray[]'];
    pPri = frm1.elements['priceArray[]'];

    if(pObj.length >= 1) {
        for(i=0;i<pObj.length;i++) {
            pCode = pObj[i].value;
            pCount = pCnt[i].value;
            pPrice2 = pPri[i].value;
        
            if(pCount > 0) {
                if(pLogVal) pLogVal = pLogVal + "^";
                pLogVal = pLogVal + pCode + "|" + pCount + "|" + pPrice2;   
            }
        }
    } else {
        pCode = pObj.value;
        pCount = pCnt.value;
        pPrice2 = pPri.value;
        
        if(pCount > 0) {
            if(pLogVal) pLogVal = pLogVal + "^";
            pLogVal = pLogVal + pCode + "|" + pCount + "|" + pPrice2;   
        }
    }

    frm4.pLog.value = pLogVal;

    // 쿠폰
    var cLogVal = "";
    cCnt = frm2.couponCnt.value;

    if(cCnt > 1) {
        for(i=0;i<cCnt;i++) {
            if(frm2.elements['coupon_use[]'][i].checked == true) {
                cName = frm2.elements['couponName[]'][i].value;
                cPrice = frm2.elements['couponPrice[]'][i].value;

                if(cLogVal) cLogVal = cLogVal + "^";
                cLogVal = cLogVal + cName + "|" + cPrice;
            }
        }
    } else if(cCnt == 1) {
        if(frm2.elements['coupon_use[]'].checked == true) {
            cName = frm2.elements['couponName[]'].value;
            cPrice = frm2.elements['couponPrice[]'].value;

            if(cLogVal) cLogVal = cLogVal + "^";
            cLogVal = cLogVal + cName + "|" + cPrice;
        }
    }

    //상품옵션
    var oLogVal = "";
    oObj = frm1.elements['optionValue[]'];
    sObj = frm1.elements['orderCountArray[]'];
    oCnt = oObj.length;     
    for(i=1;i<oCnt;i++) {
        if(sObj[i-1].length == undefined) {
            if(sObj.value) {
                if(oObj[i].value == "none") {
                    oLogVal = oLogVal + "^" + "";
                } else {
                    oLogVal = oLogVal + "^" + oObj[i].value;
                }
            }
        } else {

            if(sObj[i-1].value) {
                if(oObj[i].value == "none") {
                    oLogVal = oLogVal + "^" + "";
                } else {
                    oLogVal = oLogVal + "^" + oObj[i].value;
                }
            }
        }
    }

    // 옵션
    frm4.oLog.value = oLogVal;

    // 쿠폰
    frm4.cLog.value = cLogVal;

    // 포인트
    frm4.gPrice.value = gPrice;

    // 지급될 포인트
    frm4.gGetPrice.value = getGPoint;

    // 배송료
    frm4.dPrice.value = dPrice;

    // 총할인가
    frm4.sPrice.value = totalSaleTmp;

    // 총결제금액
    frm4.tPrice.value = tPrice;

}

</script>
                    <!-- top 시작 -->
<? include $_SERVER[DOCUMENT_ROOT]."/pages/subHead.html"; ?>
                    <!-- top 끝 -->
                    <!-- main start -->
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td height="31">&nbsp;</td>
                  </tr>
                </table>
                    <!-- main start -->



                                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td valign="top"><table width="855" border="0" align="center" cellpadding="0" cellspacing="0">
                      <tr>
                        <td><img src="/img/order_img_01.jpg" width="855" height="123" /></td>
                      </tr>
                    </table>
                      <table width="855" border="0" align="center" cellpadding="0" cellspacing="0">
                        <tr>
                          <td valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                            <tr>
                              <td height="23"></td>
                            </tr>
                          </table>
                            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                              <tr>
                                <td valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                  <tr>
                                    <td><img src="/img/order_img_04.jpg" width="855" height="46" /></td>
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
                                          <td><img src="/img/order_img_07.jpg" width="783" height="179" /></td>
                                        </tr>
                                      </table>
                                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                          <tr>
                                            <td><img src="/img/order_img_09.jpg" width="783" height="36" /></td>
                                          </tr>
                                        </table>
<script>
// 구매 갯수 제한 함수 limitCheck(this) 로 사용.
function limitCheck(obj) {
    frm = document.orderFrm1;
    countArray          = frm.elements['orderCountArray[]'];

    sum = 0;
    for(i=0;i<countArray.length;i++) {
        sum = sum*1 + countArray[i].value*1;
    }
    
    if(sum > <?=$row_product[buy_limit]?>) {
        nam = <?=$row_product[buy_limit]?> - (sum - obj.value);
        alert('죄송합니다. 이 상품은 <?=$row_product[buy_limit]?>개 까지만 구입하실 수 있습니다.');
        obj.value = nam ? nam : "";
    }

    buyCount();

}

function buyCount(code) {
    frm = document.orderFrm1;

    var total = 0;

    arrayObj                = frm.elements['codeArray[]'];
    orderPriceArray = frm.elements['orderPriceArray[]'];
    priceArray          = frm.elements['priceArray[]'];
    countArray          = frm.elements['orderCountArray[]'];
    optionArray         =   frm.elements['optionValue[]'];


    if(arrayObj.length > 1)
    {
            for(i=0;i<arrayObj.length;i++)
            {

                // 옵션가 추출
                if(optionArray[i+1].value && optionArray[i+1].value != "none") {
                    optionPriceArray = optionArray[i+1].value.split('|');
                    optionPrice = optionPriceArray[2]*1;
                } else {
                    optionPrice = 0;
                }
            

                // 옵션 체크했는지 확인
                if(countArray[i].value > 0 && optionArray[i+1].value == '') {
                    alert('옵션을 먼저 선택 해주세요.');
                    countArray[i][0].selected = true;
                    optionArray[i+1].focus();
                }

                orderPriceArray[i].value = String((priceArray[i].value*1+optionPrice*1)*countArray[i].value).comma();
                total += orderPriceArray[i].value.replace(/,/g,'')*1;

            }
    } 
    else
    {
        // 옵션 체크했는지 확인
        if(countArray[0].value > 0 && optionArray[1].value == '') {
            alert('옵션을 먼저 선택 해주세요.');
            countArray[0].selected = true;
            optionArray[1].focus();
        }

        // 옵션가 추출
        if(optionArray[1].value && optionArray[1].value != "none") {
            optionPriceArray = optionArray[1].value.split('|');
            optionPrice = optionPriceArray[2]*1;
        } else {
            optionPrice = 0;
        }

        //alert(priceArray[0].value+' ->'+optionPrice+'  ->'+countArray[0].value);

        if ('$isOption')
        {
            if(arrayObj.length == 1)
            {
                orderPriceArray[0].value = String((priceArray[0].value*1+optionPrice*1)*countArray[0].value).comma();
                total += orderPriceArray[0].value.replace(/,/g,'')*1;
            }
            else
            {
                orderPriceArray.value = String((priceArray.value*1+optionPrice*1)*countArray.value).comma();
                total += orderPriceArray.value.replace(/,/g,'')*1;

            }
        }
        else
        {
            orderPriceArray[0].value = String((priceArray[0].value*1+optionPrice*1)*countArray[0].value).comma();
            total += orderPriceArray[0].value.replace(/,/g,'')*1;
        }

    }



    // 배송비를 제외한 상품가격
    frm.totalPrice.value = total;

    // 특정금액 이상일경우 배송비 무료
    // 특정금액이 0일경우 무조건 배송비 가산
    dPriceOrg = frm.dPriceOrg.value;
    dPriceLimit = frm.dPriceLimit.value;
    if(dPriceOrg > 0) {
        if(total >= dPriceLimit && dPriceLimit > 0) {
            frm.dPrice.value = 0;
            document.getElementById('delfreeHTML').innerHTML = String(dPriceLimit).comma() + "원 이상 구매시 무료배송.";
            document.getElementById('delResultHTML').innerHTML = "<b>무료배송</b>";
        } else {
            frm.dPrice.value = dPriceOrg;
            document.getElementById('delfreeHTML').innerHTML = "( "+String(dPriceOrg).comma() +"원 )";
            document.getElementById('delResultHTML').innerHTML = "+ "+String(dPriceOrg).comma() +" 원";
        }
    }

    // 배송비 더함.
    total = total + frm.dPrice.value*1;

    document.getElementById('sumPrice').innerHTML = String(total).comma();


    totalSubmit();
}

function optionSelect(code) {
    frm1 = document.orderFrm1;
    frm4 = document.orderFrm4;

    frm4.oPrice.value = 0;

    optionValue             = frm1.elements['optionValue[]'];

    for(i=1;i<optionValue.length;i++) {
        if(optionValue[i].value && optionValue[i].value != "none") {
            oPriceTmp = optionValue[i].value.split('|');
            frm4.oPrice.value = frm4.oPrice.value*1 + oPriceTmp[2]*1;
        }
    }

    buyCount(code);
}

function boksuDel(code) 
{ 
    var objTbl = document.getElementById("boksuOption_"+code); 
    if (objTbl.rows.length > 1) objTbl.deleteRow(objTbl.rows.length - 1); 

    var objTbl = document.getElementById("boksuStock_"+code); 
    if (objTbl.rows.length > 1) objTbl.deleteRow(objTbl.rows.length - 1); 

        if(objTbl.rows.length > 1) {
            objTbl2 = document.getElementById("boksuStock_"+code);
            objTbl2.cells[objTbl2.cells.length-1].innerHTML="<a href='#none' onclick=boksuDel('"+code+"')><img src='/images/btn_dup_can.gif' border=0 align=absmiddle></a>"; 
        }

    var objTbl = document.getElementById("hiddenValue_"+code); 
    if (objTbl.rows.length > 1) objTbl.deleteRow(objTbl.rows.length - 1); 

        buyCount(code);
} 

function boksuAdd(code) {
      objTbl = document.getElementById("boksuOption_"+code); 
    objRow = objTbl.insertRow(objTbl.rows.length); 

    objCell = objRow.insertCell(0); 
    objCell.innerHTML = document.getElementById("optionBackup_"+code).innerHTML; 

      objTbl = document.getElementById("boksuStock_"+code); 
        objCell.height = 20;
        objRow = objTbl.insertRow(objTbl.rows.length); 

    objCell = objRow.insertCell(0); 
        objCell.align = "center";
        objCell.width = 80;
    objCell.innerHTML = document.getElementById("stockBackup_"+code).innerHTML; 
        
    objCell = objRow.insertCell(1); 
    objCell.innerHTML = "<input class='gray_4' size='24' name='orderPriceArray[]' style='text-align:right' value=0 readonly /> 원"; 

        if(objTbl.rows.length > 2) {
            objTbl2 = document.getElementById("boksuStock_"+code);
            objTbl2.cells[objTbl2.cells.length-3].innerHTML='';
        }

    objCell = objRow.insertCell(2); 
        objCell.innerHTML = "<a href='#none' onclick=boksuDel('"+code+"')><img src='/images/btn_dup_can.gif' border=0 align=absmiddle></a>"; 

      objTbl = document.getElementById("hiddenValue_"+code); 
    objRow = objTbl.insertRow(objTbl.rows.length); 

        tmpValue = objTbl.cells[objTbl.cells.length-1].innerHTML;

    objCell = objRow.insertCell(0); 
    objCell.innerHTML = tmpValue; 

}
</script>
            <form name="orderFrm1" action="" method="post" style="display:inline">
            <input type="hidden" name="dPriceOrg" value="<?=$row_product[del_price]?>">
            <input type="hidden" name="dPrice" value="<?=$row_product[del_price]?>">
            <input type="hidden" name="dPriceLimit" value="<?=$row_product[del_limit]?>">
            <input type="hidden" name="totalPrice" value=0>
            <input type='hidden' name='optionValue[]' value="none">
            <!-- 루프 -->

                                                                      <table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#ffffff">
                                          <tr>
                                            <td valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                              <tr>
                                                <td height="1" bgcolor="#d1d1d1"></td>
                                              </tr>
                                            </table>
<?
$que = "select * from odtProduct where parent_code = '".$code."' order by parent_code = code desc, name";
//echo $que;

$res = mysql_query($que);
while($row = mysql_fetch_array($res)) {

    // 라이브 상품 생방일때는 할인가 적용.
    if($row[cateCode] == "03" && chk_live()) 
        $row[price] = $row[price] - $row[live_sale];


?>
        <table width="100%" border="0" id='hiddenValue_<?=$row[code]?>' style='display:none' cellspacing="0" cellpadding="0">
            <tr>
                <td height="85"><input type="hidden" name="codeArray[]" value=<?=$row[code]?>><input type="hidden" name="priceArray[]" value=<?=$row[price]?>></td>
            </tr>
        </table>
<?
        if($row[stock] <10 && $row[stock]) $mejinIcon = "&nbsp;&nbsp;<img src='/images/btn_m_majin.gif' border=0>"; else $mejinIcon = "";
    
?>


        <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
                <td width="12" height="85"></td>
                <td width="80"><img src="<?=$row[prolist_img] ? $row[prolist_img] : $row[oldlist_img];?>" width="80" height="80" /></td>
                <td width="9"></td>
                <td width="450"><table border=0 cellpadding=0 cellspacing=0 width=450>
                    <tr>
    <?
    # 상품상세설명
    if($row[comment2]) {
    ?>
                        <td width=100%><strong><?=$row[name]?></strong> <span class="unnamed4">( <?=number_format($row[price])?>원 )</span><?=$mejinIcon?></td>
                        <td><a href="#none" onclick="window.open('./od_orderDetail.php?code=<?=$row[code]?>','','top=10,width=800,height=700,scrollbars=yes')"><img src="/img/order_img_11.jpg" width="55" height="19" border=0></a></td>
    <?
    } else {
    ?>
                        <td><strong><?=$row[name]?></strong> <span class="unnamed4">( <?=number_format($row[price])?>원 )</span>  <?=$mejinIcon?></td>
    <?
    }
    ?>
    <?
    unset($optionNameArray,$optionPriceArray,$optionValue);
    # 상품 옵션
    $optionTmp = trim(str_replace("|","",$row[optionName]));
    if($optionTmp) echo "<td style='padding:0 5px 0 5px' align=right>
                                                <table border=0 cellpadding=0 cellspacing=0 id='boksuOption_".$row[code]."'>
                                                    <tr>
                                                        <td height=20>";

    $optionValue  = "<select name='optionValue[]'  onchange=optionSelect('".$row[code]."')  style='font-family:돋움체;'>";
    $optionValue .= "<option value=''> 옵 &nbsp; 션 </option>";
    $optionValue .= "<option value=''>----------</option>";                                     
    $optionNameArray    = explode("|",$row[optionName]);
    $optionPriceArray = explode("|",$row[optionPrice]);


    // 옵션 이름의 max 길이 추출
    $optionLenMax=0;
    for($oo=0;$oo<count($optionNameArray);$oo++) {
        $euckrName = iconv("utf-8","euckr",$optionNameArray[$oo]);
        $optionLenMax = strlen($euckrName) > $optionLenMax ? strlen($euckrName) : $optionLenMax;
    }

    for($oo=0;$oo<count($optionNameArray);$oo++) {
        if($optionNameArray[$oo]) {
            if($optionNameArray[$oo] == "----------") $optionPricePrint = "";
            else if($optionPriceArray[$oo] < 1)             $optionPricePrint = "";
            else                                                                            $optionPricePrint = "(+".$optionPriceArray[$oo]."원)";
            
            // 보기좋게 공백 추가
            $gapTmp = $optionLenMax - strlen(iconv("utf-8","euckr",$optionNameArray[$oo]));
            $optionNameTmp = $optionNameArray[$oo];
            for($ee=0;$ee<($gapTmp+1);$ee++) $optionNameTmp .= "&nbsp;";
            // 공백 추가 끝

            $optionValue .= "<option value='".$row[code]."|".$optionNameArray[$oo]."|".$optionPriceArray[$oo]."'>".$optionNameTmp.$optionPricePrint."</option>";
        }
    }

    $optionValue .= "</select>";

    if($optionTmp) echo $optionValue."</td></tr></table></td>";
    else echo "<td><input type='hidden' name='optionValue[]' value='none'></td>";

    // 옵션값 따로 보관
    if($optionValue) $optionBackup[] = "<span id='optionBackup_".$row[code]."' style='display:none'>".$optionValue."</span>\n";
    ?>
                                </tr>
                            </table></td>                           
              <td width=<?=$isOption ? "210" : "170";?> align=right>
                            <table  width=<?=$isOption ? "210" : "170";?> border="0" align="right" cellpadding="0" cellspacing="0" id="boksuStock_<?=$row[code]?>" >
                <tr>
                  <td align=center width=80>
    <?
    # 상품갯수
    unset($stockValue);
    if($row[stock] > 0) {
        $stockValue = "<span style='PADDING-BOTTOM: 1px'>
                                        <SELECT class=input style='FONT-SIZE: 12px; FONT-FAMILY: 굴림;width:50px' onchange=\"buyCount('".$row[code]."');\"  name='orderCountArray[]'>
                                            <option value=''>0</option>";

        $stockLimit = min($row[buy_limit],$row[stock],20);
        for($i=1;$i<=$stockLimit;$i++) {
            $stockValue .= "<option value='".$i."'>".$i."</option>";
        }

        $stockValue .= "</SELECT>개</span>";

        // 수량값 따로 보관
        if($stockValue) $stockBackup[] = "<span id='stockBackup_".$row[code]."' style='display:none'>".$stockValue."</span>\n";
    ?>
                                    <?=$stockValue?>
                                    </td>
                  <td width=80>
                                        <input class='gray_4' size='24' name='orderPriceArray[]' style='text-align:right' value=0 readonly /> 원
                                    </td>
                                    <td>
                    <?
                    if(count($optionNameArray) > 1) {
                    ?>
                                    <a href="#none" onclick="boksuAdd('<?=$row[code]?>')"><img src="/images/btn_dup.gif" border=0 align=absmiddle></a>
                    <?
                    } else echo "&nbsp;";
                    ?>
                                    </td>
    <?
    } else {
    ?>
                                <center>
                                <input type="hidden" name="orderCountArray[]" value="0">
                                <input type="hidden" name='orderPriceArray[]' value="0">
                                <font color="darkorange"><b>(품절)</b></font></center>
    <?
    }
    ?>
                        </td>
                    </tr>
                </table></td>
            </tr>
        </table>
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
                <td height="1" bgcolor="#d1d1d1"></td>
            </tr>
        </table>
<?
}
?>
        </form>
        <!-- 루프 끝 -->


<?
for($pa=0;$pa<count($optionBackup);$pa++) {
    echo $optionBackup[$pa];
    echo $stockBackup[$pa];
}
?>

                                                <table width="100%" border="0" cellspacing="0" cellpadding="0" style='display:none'>
                                                    <tr>
                                                        <td ><table width="781" border="0" align="center" cellpadding="0" cellspacing="0">
                                                            <tr>
                                                                <td height="35" ><table width="781" border="0" align="center" cellpadding="0" cellspacing="0">
                                                                        <tr>
                                                                            <td width="5">&nbsp;</td>
                                                                            <td width="100">&nbsp;</td>
                                                                            <td width="300" style='display:none'>배송비 : <span id=delfreeHTML class="style1">( <?=$row_product[del_price] ? number_format($row_product[del_price])."원" : "무료배송";?> )</span></td>
                                                                            <td width="60">&nbsp;</td>
                                                                            <td><table width="50%" border="0" align="right" cellpadding="0" cellspacing="0">
                                                                                    <tr>
                                                                                        <td width="80">&nbsp;</td>
                                                                                        <td style='display:none'><div id=delResultHTML align="right"><?=$row_product[del_price] ? "+ ".number_format($row_product[del_price])." 원" : "<b>무료배송</b>";?></div></td>
                                                                                    </tr>
                                                                            </table></td>
                                                                        </tr>
                                                                </table></td>
                                                            </tr>
                                                        </table></td>
                                                    </tr>
                                                    <tr>
                                                        <td height=1 bgcolor="#eeeeee"></td>
                                                    </tr>
                                                </table>
                                                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                    <tr>
                                                        <td><table width="781" border="0" align="center" cellpadding="0" cellspacing="0">
                                                            <tr>
                                                                <td height="27"><div align="right" class="unnamed4">결제예정금액 = <span id="sumPrice">0</span> 원</div></td>
                                                            </tr>
                                                        </table></td>
                                                    </tr>
                                                </table>
                                            </td>
                                          </tr>
                                        </table>
                                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                          <tr>
                                            <td height="31" bgcolor="#ffffff"></td>
                                          </tr>
                                        </table>
                                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                          <tr>
                                            <td valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                              <tr>
                                                <td><img src="/img/order_img_12.jpg" width="783" height="45" /></td>
                                              </tr>
                                            </table>
                                              <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                <tr>
                                                  <td width="22" valign="top" background="/img/order_img_13.jpg"></td>
                                                  <td width="740" valign="top"><span style='display:'><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                    <tr>
                                                      <td><img src="/img/order_img_14.jpg" width="740" height="27" /></td>
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
                                                              <td height="24" bgcolor="#f6f2e9"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                                <tr>
                                                                  <td class="unnamed5"><div align="center">사용여부</div></td>
                                                                  <td class="unnamed5"><div align="center">할인쿠폰명</div></td>
                                                                  <td class="unnamed5"><div align="center">할인금액</div></td>
                                                                </tr>
                                                              </table></td>
                                                            </tr>
                                                          </table>
                                                          <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                            <tr>
                                                              <td height="1" bgcolor="#d5c4b9"></td>
                                                            </tr>
                                                          </table>

<script>
function couponCheck(idx) {

    <?
    if(!$row_member[id]) {
    ?>

    alert('쿠폰은 회원만 이용하실 수 있습니다.');
    return false;

    <?
    }
    ?>

    frm = document.orderFrm2;

    //쿠폰 갯수
    cnt = frm.couponCnt.value;

    if(cnt > 1) {

        if(frm.elements['coupon_use[]'][idx-1].checked == true) {
            frm.totalCoupon.value = frm.totalCoupon.value*1 + frm.elements['couponPrice[]'][idx-1].value*1;
            res = "- "+frm.elements['couponPrice[]'][idx-1].value.comma();
        } else {
            frm.totalCoupon.value = frm.totalCoupon.value*1 - frm.elements['couponPrice[]'][idx-1].value*1;
            res = "0";
        }

    } else if(cnt == 1) {
        
        if(frm.elements['coupon_use[]'].checked == true) {
            frm.totalCoupon.value = frm.totalCoupon.value*1 + frm.elements['couponPrice[]'].value*1;
            res = "- "+frm.elements['couponPrice[]'].value.comma();
        } else {
            frm.totalCoupon.value = frm.totalCoupon.value*1 - frm.elements['couponPrice[]'].value*1;
            res = "0";
        }

    }

    document.getElementById('couponPrint_'+idx).innerHTML = res;

    sum = String(frm.totalCoupon.value).comma();
    sum = sum != "0" ? "- " + sum : "0";
    document.getElementById('sumCoupon').innerHTML = sum;


    totalSubmit();
}
</script>
            <form name="orderFrm2" action="" method="post" style="display:inline">
            <input type="hidden" name="totalCoupon" value=0>

<?
if($row_product[coupon_sale] > 0) {
    $couponCnt++;
?>

            <input type="hidden" name="couponPrice[]" value="<?=$row_product[coupon_sale]?>">
            <input type="hidden" name="couponName[]" value="할인쿠폰">
            <!-- 할인쿠폰 -->
      <table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#ffffff">
        <tr>
          <td height="35" background="/images/order_img_11.jpg"><table width="740" border="0" align="center" cellpadding="0" cellspacing="0">
            <tr>
              <td height="35" background="/images/order_img_12.jpg"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td width="64" height="35"><div align="center">
                    <input type="checkbox" name="coupon_use[]" onclick="<?=$row_member[id] ? "couponCheck(1)" : "alert('쿠폰은 회원만 이용하실 수 있습니다.');this.checked=false;";?>" <?=$salecheck_1 ? "checked" : NULL;?>/>
                  </div></td>
                  <td width="25">&nbsp;</td>
                  <td width="55"><img src="/img/coupon_01_on_.jpg" ></td>
                  <td width="22"><div align="center"><img src="/images/order_img_15.jpg" width="7" height="11"></div></td>
                  <td width="490"><span class="style3"><?=number_format($row_product[coupon_sale])?>원</span> <span class="style4">할인쿠폰</span></td>
                  <td align="right" class="style2" style="padding-right:10px" ><span id="couponPrint_1">0</span>원</td>
                </tr>
              </table></td>
            </tr>
          </table></td>
        </tr>
      </table>


<?
}

if($row_member[id]) {
    $queCo = "select coName, coPrice from odtCoupon where coID = '".$row_member[id]."' and coType = '이벤트쿠폰' and coUse ='N' limit 1";
    $resCo = mysql_query($queCo);
    list($coName,$coPrice) = @mysql_fetch_array($resCo);
    if($coPrice) {
        $couponCnt++;
?>

            <!-- 이벤트쿠폰 -->
            <input type="hidden" name="couponPrice[]" value="<?=$coPrice?>">
            <input type="hidden" name="couponName[]" value="이벤트쿠폰">
      <table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#ffffff">
        <tr>
          <td height="35" background="/images/order_img_11.jpg"><table width="740" border="0" align="center" cellpadding="0" cellspacing="0">
              <tr>
                <td height="35" background="/images/order_img_12.jpg"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="64" height="35"><div align="center">
                        <input type="checkbox" name="coupon_use[]" onclick="couponCheck(2)"/ <?=$salecheck_2 ? "checked" : NULL;?>>
                      </div></td>
                      <td width="25">&nbsp;</td>
                      <td width="55"><img src="/img/coupon_02_on_.jpg" ></td>
                      <td width="22"><div align="center"><img src="/images/order_img_16.jpg" width="7" height="11"></div></td>
                      <td width="490"><span class="style6"><?=number_format($coPrice)?>원 할인 (<?=$coName?>)</span></td>
                      <td align="right" class="style2" style="padding-right:10px" ><span id="couponPrint_2">0</span>원</td>
                    </tr>
                </table></td>
              </tr>
          </table></td>
        </tr>
      </table>


<?
    }
}

if(!$coPrice && !$row_product[coupon_sale]) {
?>
                                                          <table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#ffffff">
                                                            <tr>
                                                              <td height="34"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                                <tr>
                                                                  <td class="unnamed5"><div align="center" class="title">사용 가능한 쿠폰이 없습니다.</div></td>
                                                                  </tr>
                                                              </table></td>
                                                            </tr>
                                                          </table>
<?
}
?>

            <input type="hidden" name="couponCnt" value=<?=$couponCnt?>>
            </form>


                                                          <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                            <tr>
                                                              <td height="1" bgcolor="#ebebeb"></td>
                                                            </tr>
                                                          </table>
                                                          <table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#ffffff">
                                                            <tr>
                                                              <td height="38"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                                  <tr>
                                                                    <td height="5"><div align="right"><span class="title">할인금액 : </span><span class="unnamed4"><span id="sumCoupon">0</span> 원</span>&nbsp;&nbsp;</div></td>
                                                                  </tr>
                                                              </table></td>
                                                            </tr>
                                                          </table></td>
                                                      </tr>
                                                    </table>

</span>

                                                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                      <tr>
                                                        <td><img src="/img/order_img_16.jpg" width="740" height="34" /></td>
                                                      </tr>
                                                    </table>


                                                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                      <tr>
                                                        <td valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                          <tr>
                                                            <td height="1" bgcolor="#d5c4b9"></td>
                                                          </tr>
                                                        </table>
<?
# 사용가능한 포인트값 추출
$useLimit = mysql_result(mysql_query("select paypoint from odtSetup"),0);
$isPointUse = $useLimit > $row_member[point] ? false : true;
?>

<script>
function submitPoint() {
    
    frm = document.orderFrm3;
    obj = frm.usePoint;
    if("<?=$useLimit?>" < obj.value*1) {
        obj.value = "<?=$useLimit?>";
    }
    if(frm.nowPoint.value*1 < obj.value*1) {
        obj.value = frm.nowPoint.value;
    }

    frm.gPoint.value = obj.value;
    document.getElementById('pointPrice').innerHTML = String(obj.value) != "0" ? "- " + obj.value.comma() : "0";

    totalSubmit();

    return false;
}

</script>
            <form name="orderFrm3" action="" method="post" style="display:inline" onsubmit="return submitPoint()">
            <input type="hidden" name="gPoint" value=0>
            <input type="hidden" name="nowPoint" value=<?=$row_member[point]?>>
                                                          <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                            <tr>
                                                              <td height="40" bgcolor="#f6f6f6"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                                <tr>
                                                                  <td width="20"></td>
<?
if(!$isPointUse) {
    if($row_member[id]) {
?>
                                            <td class="unnamed4">포인트는 <span class="title"><?=number_format($useLimit)?> 포인트</span> 이상부터 사용할수 있습니다.</td>
<?
    } else {
?>
                                            <td class="unnamed4">포인트는 <b>회원만</b> 사용할수 있습니다.</td>
<?
    }
} else {
?>
                                            <td class="unnamed4">현 주문에는 최대 <span class="title"><?=number_format($useLimit)?> 포인트</span> 까지 사용할 수 있습니다.</td>
<?
}
?>
                                                                </tr>
                                                              </table></td>
                                                            </tr>
                                                          </table>
                                                          <table width="100%" border="0" cellspacing="0"  bgcolor="#ffffff" cellpadding="0"  style="display:<?=!$row_member[id] ? "none" : NULL;?>">
                                                            <tr>
                                                              <td height="1" background="/img/order_img_17.jpg"></td>
                                                            </tr>
                                                          </table>
                                                          <table width="100%" border="0" cellspacing="0" bgcolor="#ffffff" cellpadding="0"  style="display:<?=!$row_member[id] ? "none" : NULL;?>">
                                                            <tr>
                                                              <td height="40" bgcolor="#f6f6f6"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                                <tr>
                                                                  <td width="20"></td>
                                                                  <td width="180" class="unnamed4"><span class="unnamed8">현재 포인트 : </span><span class="title"><?=number_format($row_member[point])?> 포인트</span></td>
                                                                                                                                    <td width="80"><?if($isPointUse) {?><span class="style10">사용할 포인트 </span><?}?></td>
                                                                                                                                    <td width="90"><?if($isPointUse) {?><input class="gray_4" size="24" name="usePoint" /> GP<?}?></td>
                                                                                                                                    <td width="38"><?if($isPointUse) {?><a href="#none" onclick="submitPoint()"><img src="/images/order_img_22.jpg" width="38" height="21" border=0></a><?}?></td>
                                                                                                                                    <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                                                                                                        <tr>
                                                                                                                                            <td class="unnamed4"><div align="right"><span class="title">할인금액 : </span><span id="pointPrice">0</span> 원&nbsp;&nbsp;</div></td>
                                                                                                                                        </tr>
                                                                                                                                    </table></td>
                                                                </tr>
                                                              </table></td>
                                                            </tr>
                                                          </table>
        </form>


                                                          <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                            <tr>
                                                              <td height="1" bgcolor="#d5c4b9"></td>
                                                            </tr>
                                                          </table>
                                                          <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                            <tr>
                                                              <td height="30" bgcolor="#ffffff"></td>
                                                            </tr>
                                                          </table>
                                                          <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                            <tr>
                                                              <td bgcolor="#ffffff"><img src="/img/order_img_18.jpg" width="107" height="24" /></td>
                                                            </tr>
                                                          </table>
                                                          <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                            <tr>
                                                              <td height="1" bgcolor="#d5c4b9"></td>
                                                            </tr>
                                                          </table>
                                                          <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                            <tr>
                                                              <td height="62" bgcolor="#f6f6f6"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                                  <tr>
                                                                    <td width="20"></td>
                                                                    <td class="unnamed4">
                                                                                                                                            <span id="pPriceInner"></span>
                                                                                                                                            <span id="dPriceInner"></span>
                                                                                                                                            <span id="cPriceInner"></span>
                                                                                                                                            <span id="gPriceInner"></span>
                                                                                                                                        </td>
                                                                  </tr>
                                                                  <tr>
                                                                    <td></td>
                                                                    <td class="unnamed4"><div align="right" class="style1">* 총 할인금액 : <span id="totalSaleInner">0</span> 원&nbsp;</div></td>
                                                                  </tr>
                                                              </table></td>
                                                            </tr>
                                                          </table>
                                                          <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                            <tr>
                                                              <td height="1" background="/img/order_img_17.jpg"></td>
                                                            </tr>
                                                          </table>
                                                          <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                            <tr>
                                                              <td height="62" bgcolor="f6f2e9"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                                <tr>
                                                                  <td width="20"></td>
                                                                  <td class="unnamed4"><div align="right"><span class="style1">* 총 결제 예정금액 : <span id="totalPaymentInner">0</span> 원&nbsp;</span></div></td>
                                                                </tr>
                                                                <tr>
                                                                  <td></td>
                                                                  <td class="unnamed4"><div align="right" class="style1">* 오늘 받으실 포인트: <span class="style18" id="getGPointInner">0</span> 포인트&nbsp;</div></td>
                                                                </tr>
                                                              </table></td>
                                                            </tr>
                                                          </table>
                                                          <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                            <tr>
                                                              <td height="1" bgcolor="#d5c4b9"></td>
                                                            </tr>
                                                          </table></td>
                                                      </tr>
                                                    </table></td>
                                                  <td valign="top" background="/img/order_img_15.jpg">&nbsp;</td>
                                                </tr>
                                              </table>
                                              <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                <tr>
                                                  <td><img src="/img/order_img_19.jpg" width="783" height="21" /></td>
                                                </tr>
                                              </table></td>
                                          </tr>
                                        </table>
                                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                          <tr>
                                            <td height="19" bgcolor="#ffffff"></td>
                                          </tr>
                                        </table>
<script>
function orderSubmitFun(frm) {

                if(!frm.pLog.value) {
                    alert('구입할 상품을 선택하세요.');
                    location.href="#pfocus";
                    return false;
                }

                if(!frm.ordername.value) {
                    window.alert("주문자 이름을 입력하세요.   ");
                    frm.ordername.focus();
                    return false;
                }
                if(!frm.orderhtel1.value) {
                    window.alert("핸드폰번호를 정확히 입력해 주세요.   ");
                    frm.orderhtel1.focus();
                    return false;
                }
                if(!frm.orderhtel2.value) {
                    window.alert("핸드폰번호를 정확히 입력해 주세요.   ");
                    frm.orderhtel2.focus();
                    return false;
                }
                if(!frm.orderhtel3.value) {
                    window.alert("핸드폰번호를 정확히 입력해 주세요.   ");
                    frm.orderhtel3.focus();
                    return false;
                }
                if(!frm.orderemail.value) {
                    window.alert("E-mail을 입력해 주세요.   ");
                    frm.orderemail.focus();
                    return false;
                }
                // 10만원 이상 무통장입금은 에스크로 처리
                if(frm.paymethod[3].checked==true) {
                    if(frm.tPrice.value >= 100000) {
                        frm.action = "$action_value";
                    } else {
                        frm.action = "<?=$action_value2?>";
                    }
                }
                return true;

}
function postsearch() {
    window.open('../odpostcode/od_postsearch.php?Mode=ProdOrder','post_find','resizable=yes,scrollbars=yes,width=388,height=410'); 
}   
</script>

            <form name="orderFrm4" method="post" action="<?=$action_value?>" onsubmit="return orderSubmitFun(this)" style="display:inline">

<?
if($row_member[id]) {
?>
            <input type="hidden" name="orderzip1" value="<?=$row_member[zip1]?>">
            <input type="hidden" name="orderzip2" value="<?=$row_member[zip2]?>">
            <input type="hidden" name="orderaddress" value="<?=$row_member[address]?>">
            <input type="hidden" name="orderaddress1" value="<?=$row_member[address1]?>">
            <input type="hidden" name="ordertel1" value="<?=$row_member[tel1]?>" />
            <input type="hidden" name="ordertel2" value="<?=$row_member[tel2]?>" />
            <input type="hidden" name="ordertel3" value="<?=$row_member[tel3]?>" />            

<?
} else {
    $dInfo2 = mysql_fetch_array(mysql_query("select recname,rectel1,rectel2,rectel3,rechtel1,rechtel2,rechtel3,reczip1,reczip2,recaddress,recaddress1 from odtOrder where orderid = '".$_SESSION[Gid]."' order by orderdate desc limit 1"));
?>
            <input type="hidden" name="orderzip1" value="<?=$dInfo2[reczip1]?>">
            <input type="hidden" name="orderzip2" value="<?=$dInfo2[reczip2]?>">
            <input type="hidden" name="orderaddress" value="<?=$dInfo2[recaddress]?>">
            <input type="hidden" name="orderaddress1" value="<?=$dInfo2[recaddress1]?>">
            <input type="hidden" name="ordertel1" value="<?=$dInfo2[rectel1]?>" />
            <input type="hidden" name="ordertel2" value="<?=$dInfo2[rectel2]?>" />
            <input type="hidden" name="ordertel3" value="<?=$dInfo2[rectel3]?>" />          
<?
}
?>
            <input type="hidden" name="parent_code" value="<?=$code?>">
            <input type="hidden" name="ordernum" value="<?=$ordernum;?>">
            <input type="hidden" name="cLog">
            <input type="hidden" name="pLog">
            <input type="hidden" name="oLog">
            <input type="hidden" name="gPrice">
            <input type="hidden" name="gGetPrice">
            <input type="hidden" name="dPrice">
            <input type="hidden" name="sPrice">
            <input type="hidden" name="tPrice">
            <input type="hidden" name="oPrice">

<?
//비회원정보 추출
$gInfo = mysql_fetch_array(mysql_query("select * from odtMember2 where id ='".$_SESSION[Gid]."'"));
?>

                                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                          <tr>
                                            <td bgcolor="#ffffff"><img src="/img/order_img_34.jpg"  /></td>
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
                                                    <td><input name="ordername" class="gray_3" value="<?=$row_member[name] ? $row_member[name] : $gInfo[name];?>" size="24" <?=$gInfo[email] ? "readonly onclick=\"alert('비회원 주문은 주문자 이메일을 수정할수 없습니다.')\"" : NULL;?>/></td>
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
                                                        <td>
                                                                                                                    <input class="gray_3" size="24" name="orderhtel1" style="width:40px" maxlength="4" value="<?=$row_member[htel1] ? $row_member[htel1] : $dInfo2[rechtel1];?>" /> -
                                                                                                                    <input class="gray_3" size="24" name="orderhtel2" style="width:40px" maxlength="4" value="<?=$row_member[htel2] ? $row_member[htel2] : $dInfo2[rechtel2];?>" /> -
                                                                                                                    <input class="gray_3" size="24" name="orderhtel3" style="width:40px" maxlength="4" value="<?=$row_member[htel3] ? $row_member[htel3] : $dInfo2[rechtel3];?>" />
                                                                                                                </td>
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
                                                        <td><input name="orderemail" class="gray_3"  size="24" value="<?=$row_member[email] ? $row_member[email] : $gInfo[email];?>" <?=$gInfo[name] ? "readonly onclick=\"alert('비회원 주문은 주문자 이름을 수정할수 없습니다.')\"" : NULL;?>/></td>
                                                      </tr>
                                                  </table></td>
                                                </tr>
                                              </table></td>
                                          </tr>
                                        </table>





<?PHP
	// 배송기능적용 체크 - onedaynet jjc
	if($row_product[setup_delivery] == "Y") :

		//<!-- 배송적용 -->
?>

										<table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#ffffff"><tr><td height="27"></td></tr></table>

                                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                          <tr>
                                            <td width="85"><img src="/img/order_img_26.jpg" width="96" height="35" /></td>
                                            <td><div align="right"><a href="#none" onclick="window.open('./od_delAddrSearch.php','','width=400,height=400,scrollbars=yes');"><img src="/img/order_img_27.jpg" width="117" height="26" border=0 /></a></div></td>
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
                                                      <td><input name="recname" class="gray_3" value="" size="24" /></td>
                                                    </tr>
                                                </table></td>
                                              </tr>
                                            </table>
                                              <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                <tr>
                                                  <td width="171"><img src="/img/order_1_title_02.jpg" width="171" height="38" /></td>
                                                  <td background="/img/order_1_title_07.jpg"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                      <tr>
                                                        <td width="15"></td>
                                                        <td>
																													<input class="gray_3" size="24" name="rectel1" style="width:40px" maxlength="4" value="" /> -
																													<input class="gray_3" size="24" name="rectel2" style="width:40px" maxlength="4" value="" /> -
																													<input class="gray_3" size="24" name="rectel3" style="width:40px" maxlength="4" value="" />			
																												</td>
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
                                                        <td>
																													<input class="gray_3" size="24" name="rechtel1" style="width:40px" maxlength="4" value="" /> -
																													<input class="gray_3" size="24" name="rechtel2" style="width:40px" maxlength="4" value="" /> -
																													<input class="gray_3" size="24" name="rechtel3" style="width:40px" maxlength="4" value="" />		
																												</td>
                                                      </tr>
                                                  </table></td>
                                                </tr>
                                              </table>
                                              <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                <tr>
                                                  <td width="171"><img src="/img/order_1_title_04.jpg" width="171" height="38" /></td>
                                                  <td background="/img/order_1_title_07.jpg"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                      <tr>
                                                        <td width="15"></td>
                                                        <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
																													<tr>
																														<td width="10" align="center"><input type="checkbox" value="Y" name="orderSame" onclick="addrInsert()" checked /></td>
																														<td width="60">기본주소</td>
																														<td  >&nbsp;</td>
																													</tr>
																											</table></td>
                                                      </tr>
                                                  </table></td>
                                                </tr>
                                              </table>
                                              <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                <tr>
                                                  <td width="171"><img src="/img/order_1_title_05.jpg" width="171" height="99" /></td>
                                                  <td background="/img/order_1_title_08.jpg"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                      <tr>
                                                        <td width="15"></td>
                                                        <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
																													<tr>
																														<td width="60"><input class="gray_4" size="24" name="reczip1" value="" readonly  onClick="postsearch();"/></td>
																														<td width="10"><div align="center">-</div></td>
																														<td width="33"><input class="gray_4" size="24" name="reczip2" value="" readonly  onClick="postsearch();"/></td>
																														<td width="8">&nbsp;</td>
																														<td width="72" class="pro_best_2"><a href="#none" onClick="postsearch();"><img src="/img/member_img_12.jpg" border=0></a></td>
																														<td width="8" class="pro_best_2">&nbsp;</td>
																														<td class="pro_best_2"  >&nbsp;</td>
																													</tr>
																												</table>
																													<table width="100%" border="0" cellspacing="0" cellpadding="0">
																														<tr>
																															<td height="3"></td>
																														</tr>
																													</table>
																												<table width="100%" border="0" cellspacing="0" cellpadding="0">
																														<tr>
																															<td width="10"><input class="gray_5" size="24" name="recaddress" value=""  readonly  onClick="postsearch();"/></td>
																															<td width="8">&nbsp;</td>
																															<td class="pro_best_2">&nbsp;</td>
																														</tr>
																													</table>
																												<table width="100%" border="0" cellspacing="0" cellpadding="0">
																														<tr>
																															<td height="3"></td>
																														</tr>
																													</table>
																												<table width="100%" border="0" cellspacing="0" cellpadding="0">
																														<tr>
																															<td width="10"><input class="gray_5" size="24" name="recaddress1" value="" /></td>
																															<td width="8">&nbsp;</td>
																															<td class="pro_best_2">&nbsp;</td>
																														</tr>
																												</table></td>
                                                      </tr>
                                                  </table></td>
                                                </tr>
                                              </table>

											  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                <tr>
                                                  <td width="171"><img src="/img/order_1_title_06.jpg"></td>
                                                  <td background="/img/order_1_title_09.jpg"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                      <tr>
                                                        <td width="15"></td>
                                                        <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                                                                                    <tr>
                                                                                                                        <td height="50" valign="top"><textarea name="comment"  style='width:95%;height:50px;font-family:굴림;border:1px solid #cccccc;ime-mode:active'></textarea></td>
                                                                                                                    </tr>
                                                                                                                    <tr>
                                                                                                                        <td height="30"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                                                                                            <tr>
                                                                                                                                <td>* 부재시 연락처나 배송시 요청사항을 적어주세요.(200자 이내)<br>
																				&nbsp;&nbsp;개별 주문시 요구사항은 반영하기가 어려우니 양해바랍니다.<br>
																				&nbsp;&nbsp;<span class="style19">※ 한번의 주문으로 다수의 배송지로 배송은 어렵습니다.</span></td>
                                                                                                                            </tr>
                                                                                                                        </table></td>
                                                                                                                    </tr>
                                                                                                                </table></td>
                                                      </tr>
                                                  </table></td>
                                                </tr>
                                              </table></td>
                                          </tr>
                                        </table>
                                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                          <tr>
                                            <td height="27"></td>
                                          </tr>
                                        </table>
<script>
function addrInsert() {
    frm = document.orderFrm4;

    if(frm.orderSame.checked == false) {
        frm.reczip1.value = "";
        frm.reczip2.value = "";
        frm.recaddress.value = "";
        frm.recaddress1.value = "";
        frm.rectel1.value = "";
        frm.rectel2.value = "";
        frm.rectel3.value = "";
        frm.rechtel1.value ="";
        frm.rechtel2.value = "";
        frm.rechtel3.value =    "";
        frm.recname.value = "";
    } 
	else {
        frm.reczip1.value = frm.orderzip1.value;
        frm.reczip2.value = frm.orderzip2.value;
        frm.recaddress.value = frm.orderaddress.value;
        frm.recaddress1.value = frm.orderaddress1.value;
        frm.rectel1.value = frm.ordertel1.value;
        frm.rectel2.value = frm.ordertel2.value;
        frm.rectel3.value = frm.ordertel3.value;
        frm.rechtel1.value = frm.orderhtel1.value;
        frm.rechtel2.value = frm.orderhtel2.value;
        frm.rechtel3.value = frm.orderhtel3.value;
        frm.recname.value = frm.ordername.value;
    }
}
addrInsert();
</script>




<?PHP
	// 배송기능적용 체크 - onedaynet jjc
	else :
		//<!-- 쿠폰적용 -->
?>
                                        <table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#ffffff">
											<tr>
												<td><input type="checkbox" name="viewDel" value="1" onclick="if(this.checked==true) { document.getElementById('viewDel2').style.display='' } else {document.getElementById('viewDel2').style.display='none'}">구매자와 사용자가 다를 경우에는 이곳을 체크해 주세요. 이름이 다르면 사용하실 수 없으니 정확히 기재해 주세요. </td>
                                          </tr>
                                        </table>

										<table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#ffffff"><tr><td height="27"></td></tr></table>



<span id='viewDel2' style='display:none'>
                                        <table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#ffffff" >
                                          <tr>
                                            <td width="85"><img src="/img/order_img_26.jpg"  /></td>
                                            <td style='display:none'>&nbsp;</td>
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
                                                      <td><input name="recname" class="gray_3" value="" size="24" /></td>
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
                                                        <td>
                                                                                                                    <input class="gray_3" size="24" name="rechtel1" style="width:40px" maxlength="4" value="" /> -
                                                                                                                    <input class="gray_3" size="24" name="rechtel2" style="width:40px" maxlength="4" value="" /> -
                                                                                                                    <input class="gray_3" size="24" name="rechtel3" style="width:40px" maxlength="4" value="" />        
                                                                                                                </td>
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
                                                        <td><input name="recemail" class="gray_3"  size="24" /></td>
                                                      </tr>
                                                  </table></td>
                                                </tr>
                                              </table>
                                              <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                <tr>
                                                  <td width="171"><img src="/img/order_1_title_06.jpg" width="171" height="118" /></td>
                                                  <td background="/img/order_1_title_09.jpg"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                      <tr>
                                                        <td width="15"></td>
                                                        <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                                                                                    <tr>
                                                                                                                        <td height="50" valign="top"><textarea name="comment"  style='width:95%;height:70px;font-family:굴림;border:1px solid #cccccc;ime-mode:active'></textarea></td>
                                                                                                                    </tr>
                                                                                                                    <tr>
                                                                                                                        <td height="30"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                                                                                            <tr>
                                                                                                                                <td>* 선물하실 분에게 메시지를 작성해보세요</td>
                                                                                                                            </tr>
                                                                                                                        </table></td>
                                                                                                                    </tr>
                                                                                                                </table></td>
                                                      </tr>
                                                  </table></td>
                                                </tr>
                                              </table></td>
                                          </tr>
                                        </table>
                                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                          <tr>
                                            <td height="27" bgcolor="#ffffff"></td>
                                          </tr>
                                        </table>
</span>
<script>
function addrInsert() {
    frm = document.orderFrm4;

	frm.rechtel1.value = frm.orderhtel1.value;
	frm.rechtel2.value = frm.orderhtel2.value;
	frm.rechtel3.value = frm.orderhtel3.value;
	frm.recname.value = frm.ordername.value;
	frm.recemail.value = frm.orderemail.value;
}
addrInsert();
</script>
<?PHP
	endif;
?>







                                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                          <tr>
                                            <td bgcolor="#ffffff"><img src="/img/order_img_28.jpg" width="92" height="35" /></td>
                                          </tr>
                                        </table>
                                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                          <tr>
                                            <td valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                              <tr>
                                                <td width="171"><img src="/img/order_11_title_01.jpg" width="171" height="38" /></td>
                                                <td background="/img/order_1_title_07.jpg"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                    <tr>
                                                      <td width="15"></td>
                                                      <td><span class="style15"><strong><span id="totalPaymentInner2">0 원</span></strong></span></td>
                                                    </tr>
                                                </table></td>
                                              </tr>
                                            </table>
<script>
function bankClick(obj) {
    frm = document.orderFrm4;
    if(obj.checked) {
        document.getElementById('payHide').style.display = '';
        frm.action='/odprogram/odproducts/<?=$action_value2?>';
    }
}
</script>
                                              <table width="100%" border="0" cellspacing="0" cellpadding="0" id="gDisplay" style="display:">
                                                <tr>
                                                  <td width="171"><img src="/img/order_11_title_02.jpg" width="171" height="38" /></td>
                                                  <td background="/img/order_1_title_07.jpg">
                                                                                        
                                                                                                    
                                                                                                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                      <tr>
                                                        <td width="15"></td>
                                                        <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                                                                                    <tr>
                                                                                                                        <td width="10" align="center"><input type="radio" value="C" name="paymethod" checked onclick="if(this.checked) {document.getElementById('payHide').style.display = 'none';this.form.action='/odprogram/odproducts/<?=$action_value?>'}" /></td>
                                                                                                                        <td width="90">신용카드결제</td>
                                                                                                                        <td width="10" align="center"><input type="radio" value="L" name="paymethod"  onclick="if(this.checked) {document.getElementById('payHide').style.display = 'none';this.form.action='/odprogram/odproducts/<?=$action_value?>'}" /></td>
                                                                                                                        <td width="110">실시간 계좌이체</td>

                                                                    <?
                                                                    // 무통장 입금이 불가한 상품
                                                                    unset($onClickTmp);
                                                                    //if([bankDisabled]) $onClickTmp = "alert('무통장 입금이 불가능한 상품입니다.');this.checked=false;return;"; 
                                                                    ?>

                                                        <?
                                                        if ("I" == $row_setup[P_KBN] && "1" == $row_setup[P_SKBN])
                                                        {
                                                        ?>
                                                                    <td width="10" align="center"><input type="radio" value="E" name="paymethod"  onclick="if(this.checked) {document.getElementById('payHide').style.display = 'none';this.form.action='/odprogram/odproducts/od_orderresult.php'}" /></td>
                                                                    <td width="110">무통장(에스크로)</td>
                                                        <?
                                                        }
                                                        else
                                                        {
                                                            echo "<td width='150'></td>";
                                                        }
                                                        ?>


                                                                                                                        <td width="10" align="center" id="bank1" style='display:none'><input type="radio" value="B" name="paymethod" onclick="<?=$onClickTmp?>bankClick(this);"  /></td>
                                                                                                                        <td  id="bank2" style='display:none'>무통장 입금</td>

                                                                                                                        <td width="10" align="center" id="escrow1" style="display:none"><input type="radio" value="E" name="paymethod" onclick="<?=$onClickTmp?>"/></td>
                                                                                                                        <td  id="escrow2" style="display:none" width=70>무통장(에스크로)
                                                                                                                        </td>
                                                                                                                        <td  id="escrow3" style="display:none">
                                                                                                                            <div id="escrowMent" style='Z-INDEX: 1; LEFT: 0px; WIDTH: 0px; POSITION: relative; TOP: 0px; HEIGHT: 0px;display:none'><div style='position:absolute;z-index:3;top:10;left:0;'><table border='0' cellpadding='2' cellspacing='3' bgcolor='#7B7B7B'>
                                                                                                                                <tr>
                                                                                                                                    <td nowrap bgcolor='#FFFFFF' style='padding:7;font-family:굴림체'>
                                                                                                                                        인터넷에서의 구매자와 판매자가 서로 만나지 않고 거래할때<br>
                                                                                                                                        발생할 수 있는 위험을 피하기 위해 신뢰성 있는 제3자가 구<br>
                                                                                                                                        매자에게서 물품대금을 대신 받은후에 서로의 구매가 원만히<br>
                                                                                                                                        이루어진 것을 확인하고 판매자에게 대금을 결제하는 서비스<br>
                                                                                                                                        를 말하며 <b>저희쇼핑몰에서는 10만원 이상 무통장입금 결<br>
                                                                                                                                        제시</b> 에스크로서비스를 이용하여 결제를 진행하고 있습니다.
                                                                                                                                    </td>
                                                                                                                                </tr>
                                                                                                                            </table></div></div>
                                                                                                                            <span style="color:E53635;cursor:pointer" onmouseover="document.getElementById('escrowMent').style.display='inline';" onmouseout="document.getElementById('escrowMent').style.display='none';"><img src="/images/btn_escrow.gif" border=0></font>
                                                                                                                        </td>
                                                                                                                        <td width="10" style="display:none" align="center"><input type="radio" value="G" name="paymethod"/></td>
                                                                                                                        <td style="display:none"></td>
                                                                                                                    </tr>
                                                                                                                </table></td>
                                                      </tr>
                                                  </table></td>
                                                </tr>
                                              </table>
                                                                                            <div id='payHide' style="display:none">
                                              <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                <tr>
                                                  <td width="171"><img src="/img/order_11_title_03.jpg" width="171" height="38" /></td>
                                                  <td background="/img/order_1_title_07.jpg"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                      <tr>
                                                        <td width="15"></td>
                                                        <td>
                                                                                                                    <select name="paybankname">
                                                <?
                                                    $bankresult = mysql_query("SELECT * FROM odtBank ORDER BY serialnum DESC");

                                                    while($bankrow = mysql_fetch_array($bankresult)) {
                                                        echo "<option value='$bankrow[bankname]/$bankrow[name]/$bankrow[banknum]'>$bankrow[bankname] : $bankrow[banknum] : $bankrow[name]</option>";
                                                    }
                                                ?>
                                                                                                                    </select>   </td>
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
                                                        <td>
                                                                                                                    <input name="paydatey" type="text" class="gray" style="width:40px" size="5" maxlength="4" value="<?=date("Y")?>"> 년 
                                                                                                                    <input name="paydatem" type="text" class="gray" style="width:30px" size="3" maxlength="2" value="<?=date("m")?>"> 월 
                                                                                                                    <input name="paydated" type="text" class="gray" style="width:30px" size="3" maxlength="2" value="<?=date("d")?>"> 일                                                                                                                
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
                                                        <td><input name="payname" class="gray_3"  size="24" value="<?=$row_member[name] ? $row_member[name] : $gInfo[name];?>"/></td>
                                                      </tr>
                                                  </table></td>
                                                </tr>
                                              </table>
                                                                                            </div>
                                                                                            <table width="100%" border=0 cellspacing=0 cellpadding=0>
                                                                                                <tr>
                                                                                                    <td height="1" bgcolor="d2dddf"></td>
                                                                                                </tr>
                                                                                            </table>
                                                                                            </td>
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
                            </table>
                            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                              <tr>
                                <td><div align="center"><input type="image" src="/img/order_img_30.jpg" width="133" height="40" /></div></td>
                              </tr>
                            </table></td>
                        </tr>
                      </table>
            </form> 




<br>


                    <!-- main end -->

        </td>
    </tr>
</table>
                    <!-- bottom 시작 -->
<? include_once $_SERVER[DOCUMENT_ROOT]."/pages/subFoot.html"; ?>
                    <!-- bottom 끝 -->

<script>
// 쿠폰 새로고침
<?
if($salecheck_1) echo "couponCheck(1);";
if($salecheck_2) echo "couponCheck(2);";
?>
</script>