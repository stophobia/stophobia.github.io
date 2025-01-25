<?
    include "../../odcommon/od_config.inc.php";
    include "$folderpath_manager_common/od_function.inc.php";  
    include "../../odcommon/od_lib.inc.php";
    include "$folderpath_manager_common/od_adminAuthority.inc.php";
    include "$folderpath_manager_common/od_head.inc.php";
    include "$folderpath_manager_common/od_body.inc.php";

    ## 세부권한 체크
    if($row_admin[orderLevel] < 3) {
        error_msgloc("$folderpath_manager/","접근권한이 없습니다.   ");
    }
    
    // 쿠폰처리 /////////////////////////////////////////////////////////////////
    if ("coupon_check" == $status)
    {
        //echo "UPDATE odtOrder SET csu = '$value' WHERE ordernum = '$id'   ";
        mysql_query("UPDATE odtOrder SET csu = '$value' WHERE ordernum = '$id'  ");

        echo "
        <script>
            parent.location.reload(true);
        </script>";
        exit;
    }

    ## 주문취소/삭제처리
    include "od_ordercheck.php";
    
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
    
    if(trim($key) != "" ) { 
        $search_value = " AND ".$search." LIKE '%".$key."%'";
    }
    if(!$search_standard) $search_standard = "paydate";
    if(!$page_number) $page_number = "50";
    
    ## 검색조건 Par 정리 #####################################
    if($search_value_ == "true") {

        $search = "";
        $key = "";
    
        if($partnerCode) {
            $queTmp2 = "select * from odtMember where bannder = '".$partnerCode."'";
            $resTmp2 = mysql_query($queTmp2);
            while($rowTmp2 = mysql_fetch_array($resTmp2)) {
                if($search_value) $search_value .= " OR ";
                $search_value .= "partnerCode = '".$rowTmp2[id]."' ";
            }

            $search_value = " and (".$search_value.") ";
        }
        if($paymethod) $search_value .= " AND paymethod='".$paymethod."'";
        if($paystatus) $search_value .= " AND paystatus='".$paystatus."'";
        if($delivstatus) $search_value .= " AND delivstatus='".$delivstatus."'";
        if($order_type) $search_value .= " AND order_type='".$order_type."'";
        if($searchfield && $searchkey) {
            $search_value .= " and ".$searchfield." like '%".$searchkey."%' ";
        }

        if($start_date && $end_date) $search_value .= " AND ".$search_standard." BETWEEN '".date('Y-m-d H:i:s',$start_date_time)."' AND '".date('Y-m-d H:i:s',$end_date_time)."'";

        if($hIDTmp) $search_value .= " and hID = '".$hIDTmp."' ";

        if($order_by) $search_value .= " ORDER BY ".$order_by."";
        if($order_by_rule) $search_value .= " ".$order_by_rule."";
    }
    else {
        $search_value .= " and paystatus='Y' ORDER BY paydate DESC";
    }
    
    ## 페이지링크 PAR 정리 ############################################
    if($search) $par_page .= "&search=$search";
    if($key) $par_page .= "&key=$key";
    if($paymethod) $par_page .= "&paymethod=$paymethod";
    if($paystatus) $par_page .= "&paystatus=$paystatus";
    if($delivstatus) $par_page .= "&delivstatus=$delivstatus";
    if($start_date && $end_date) $par_page .= "&start_date=$start_date&end_date=$end_date";
    if($date_term) $par_page .= "&date_term=$date_term";
    if($search_standard) $par_page .= "&search_standard=$search_standard";
    if($order_by) $par_page .= "&order_by=$order_by";
    if($order_by_rule) $par_page .= "&order_by_rule=$order_by_rule";
    if($search_value_) $par_page .= "&search_value_=$search_value_";
    if($page_number) $par_page .= "&page_number=$page_number";
    if($partnerCode) $par_page .= "&partnerCode=".rawurlencode($partnerCode);
    if($order_type) $par_page .= "&order_type=$order_type";



    ## 매출총액
    $qry_sum = "SELECT SUM(tPrice) as ST FROM odtOrder WHERE ordernum  != '' and canceled='N' AND paystatus ='Y' and orderstatus='Y' ".$search_value."";
    $res_sum = mysql_query($qry_sum);
    $num_sum = mysql_num_rows($res_sum);

    if($num_sum){
        $row_sum = mysql_fetch_array($res_sum);

        $sum_total = $row_sum[ST];
    }
    else $sum_total = 0;
    
    ## 입점업체결제금
    $qry_sum = "SELECT pLog  FROM odtOrder WHERE ordernum  != '' and canceled='N' AND paystatus ='Y' and orderstatus='Y' ".$search_value."";
    $res_sum = mysql_query($qry_sum);
    $num_sum = mysql_num_rows($res_sum);

    if($num_sum){
        while($row_sum = mysql_fetch_array($res_sum)) {
            $pLogArray = explode("^",$row_sum[pLog]);
            for($ii=0 ;$ii < count($pLogArray); $ii++) {
                $pLogArray2 = explode("|",$pLogArray[$ii]);
                $purPrice = @mysql_result(mysql_query("select purPrice from odtProduct where code ='".$pLogArray2[0]."'"),0);
                $sum_total2 += $purPrice * $pLogArray2[1];
            }
            $del_price_com = @mysql_result(mysql_query("select del_price_com from odtProduct where code = (select parent_code from odtProduct where code = '".reset(explode("|",$row_sum[pLog]))."')"),0);
            $sum_total2 += $del_price_com;
        }
    }
    else $sum_total2 = 0;

    ## 수수료
    //수수료
    $comission = array('B'=>0,'C'=>3.3,'L'=>2,'H'=>7,'G'=>0);       // 실시간계좌이체는 10700 이하는 2백원으로 고정이다.

    $qry_sum = "SELECT paymethod,tPrice  FROM odtOrder WHERE ordernum  != '' and canceled='N' AND paystatus ='Y' and orderstatus='Y' ".$search_value."";
    $res_sum = mysql_query($qry_sum);
    $num_sum = mysql_num_rows($res_sum);

    if($num_sum){
        while($row_sum = mysql_fetch_array($res_sum)) {

            if($row_sum[tPrice] <= "10700" && $row_sum[paymethod] == "L") { // 실시간계좌이체는 10700 이하는 2백원으로 고정이다.
                $sum_total3 += 200;
            } else {
                $sum_total3 += $row_sum[tPrice] * $comission[$row_sum[paymethod]] / 100;
            }
        }
    }
    else $sum_total3 = 0;

    ## 총 마진
    $sum_total4 = $sum_total - $sum_total2 - $sum_total3;

/*
    echo "총마진 : ".$sum_total."<br>";
    echo "정산금 : ".$sum_total2."<br>";
    echo "수수료 : ".$sum_total3."<br>";
    echo "총마진 : ".$sum_total4."<br>";
*/




    if($style == "b") { // 무통장 입금만 출력
        ## 조건에 맞는 주문목록의 수를 구한다 ###################
        $qry_MOOL = "SELECT order_type , ordernum, orderid, ordername, ordertel1, ordertel2, ordertel3, orderhtel1, orderhtel2, orderhtel3, orderemail, tPrice, recname, paymethod, paystatus,paystatus2, delivstatus, pointed,  orderdate, canceled,orderstep, pLog,expressname,expressnum,ordersau, ckbn, csu FROM odtOrder WHERE  ordernum  != '' and ordernum != 'SFBD2DD479' and  canceled='N' AND orderstatus='Y' and (paymethod='B' || paymethod='E') and paystatus='N'";
    } else {
        ## 조건에 맞는 주문목록의 수를 구한다 ###################
        $qry_MOOL = "SELECT order_type , ordernum, orderid, ordername, ordertel1, ordertel2, ordertel3, orderhtel1, orderhtel2, orderhtel3, orderemail, hID,tPrice, recname, paymethod, paystatus, paystatus2,delivstatus, pointed,  orderdate, canceled,orderstep, pLog,expressname,expressnum,ordersau, ckbn, csu FROM odtOrder WHERE  ordernum  != '' and ordernum != 'SFBD2DD479' and  canceled='N' AND orderstatus='Y'  ".$search_value."";
    }

    $res_MOOL = mysql_query($qry_MOOL);
    $num_MOOL = mysql_num_rows($res_MOOL);
    echo mysql_error();
    $total = $num_MOOL;
    
    ## 페이지 링크에 사용할 값들을 설정한다 ###################
    $LineNumber = $page_number;
    $LinkNumber = 10;
    
    ## 전체 페이지 수 계산 ##########################################
    $TotalPage = ceil($total / $LineNumber);
    
    if($page>$TotalPage) { 
        $page=1;
        $first=1;
        $last=0; 
    }
    
    if(!$page) $page = 1;
    
    if(!$total) {
        $first = 1;
        $last = 0;   
    }
    else {
        $first = $LineNumber * ($page - 1);
        $last = $LineNumber * $page;
        $NomLine = $total - $last;
        
        if($NomLine > 0) $last -= 1;
        else $last = $total - 1;
    }

    ## 접근권한 설정(엑셀저장)
    if($row_admin[orderLevel] > 2) $excelTemp1 = "saveExcel('od_orderexcel.php');";
    else $excelTemp1 = "javascript:reject();";
    
    ## 접근권한 설정(삭제)
    if($row_admin[orderLevel] == 7 || $row_admin[orderLevel] == 9 || $row_admin[superLevel]==9) $deleteTemp1 = "selectCheck(this.form);";
    else $deleteTemp1 = "javascript:reject();";
?>


<script>
// 회원상세정보 출럭 Ajax 시작

var selfID;
// request 객체 생성
var req = null;
function create_request() {
    var request = null;
    try {
        request = new XMLHttpRequest();
    } catch (trymicrosoft) {
        try {
            request = new ActiveXObject("Msxml12.XMLHTTP");
        } catch (othermicrosoft) {
            try {
                request = new ActiveXObject("Microsoft.XMLHTTP");
            } catch (failed) {
                request = null;
            }
        }
    }
    if (request == null)
        alert("Error creating request object!");
    else
        return request;
}

function showInfo(id,name,divID) {

    selfID = divID;

    // 백그라운드로 DB 추출.
    param = "id="+id+"&name="+name;
    req = create_request();
    req.open("POST", "/showUserInfo.php", true);
    req.setRequestHeader("Content-Type", "application/x-www-form-urlencoded;charset=UTF-8");
    req.setRequestHeader("Cache-Control","no-cache, must-revalidate");
    req.setRequestHeader("Pragma","no-cache");
    req.send(param);
    req.onreadystatechange = function () {
        printHTML();
    }

    document.getElementById(divID).style.display='';
}
function printHTML() {
    if (req.readyState == 4) {
        if(req.status == 200) {
            // 값이 있을때만 처리
                resultText = req.responseText;
                document.getElementById(selfID+"_1").innerHTML = resultText;
        }
    }
}

function f_check(id, old, value)
{
    if (old < value)
    {
        alert('쿠폰수량은 구매건수보다 클수 없습니다\n\n 다시 확인해 주십시오');
    }
    else
    {
        hf.location.href='od_orderslist.php?status=coupon_check&id='+id+'&value='+value;
    }
}

function f_num_press()
{
    var rtn_cd = true ;
    if( 48 > event.keyCode || 57 < event.keyCode )
    {
        rtn_cd = false ;
    }
    event.returnValue = rtn_cd;
}
//onKeyPress() 이벤트에서 호출(완전한숫자만입력)
function f_num_down()
{
    var rtn_cd = true ;
    if( 229 == event.keyCode )
    {
        rtn_cd = false;
    }
    event.returnValue = rtn_cd;
}


// 회원상세정보 출럭 Ajax 끝

</script>



        <script language="javascript">
            function set_date(opt1,opt2) {
                today = new Date();
                now_year = today.getYear();
                now_month = today.getMonth()+1;
                now_day = today.getDate();
                month_temp = now_month-1;
                switch(month_temp) {
                    case(1): day_temp=31;   break;
                    case(2): day_temp=28;   break;
                    case(3): day_temp=31;   break;
                    case(4): day_temp=30;   break;
                    case(5): day_temp=31;   break;
                    case(6): day_temp=30;   break;
                    case(7): day_temp=31;   break;
                    case(8): day_temp=31;   break;
                    case(9): day_temp=30;   break;
                    case(10): day_temp=31; break;
                    case(11): day_temp=30; break;
                    case(12): day_temp=31; break;
                    default: day_temp=31; break;
                }
                the_day = now_day;
                the_month = now_month;
                the_year = now_year;
                if(opt1 == 'd') {
                    opt_day = now_day-opt2;
                    if(opt_day > 0) {
                        the_day = opt_day;
                    }else{
                        opt_month = now_month-1;
                        the_day = day_temp+opt_day;
                        if(opt_month > 0) {
                            the_month = opt_month;
                        }else{
                            the_year = now_year-1;
                            the_month = 12;
                        }
                    }
                }else if(opt1 == 'm') {
                    opt_month = now_month-opt2;
                    if(opt_month > 0) {
                        the_month = opt_month;
                    }else{
                        the_year = now_year-1;
                        the_month = 12+opt_month;
                    }
                }else if(opt1 == 'y') {
                    the_year = now_year-opt2;
                }
                if(the_month < 10) the_month = '0'+the_month;
                if(the_day < 10) the_day = '0'+the_day;
                the_date = the_year+''+the_month+''+the_day;
                document.view.start_date.value = the_date;
                if(now_month < 10) now_month = '0'+now_month;
                if(now_day < 10) now_day = '0'+now_day;
                now_date = now_year+''+now_month+''+now_day;
                document.view.end_date.value = now_date;
                if(opt1 == 'w') {
                    document.view.start_date.value = '';
                    document.view.end_date.value = '';
                }
            }
            function view_submit() {
                if(document.view.start_date.value) {
                    if(!IsNumber(document.view.start_date)) {
                        alert('조회기간에는 숫자만 입력하실 수 있습니다.  ');
                        document.view.start_date.focus();
                        document.view.start_date.select();
                        return false;
                    }
                }
                if(document.view.end_date.value) {
                    if(!IsNumber(document.view.end_date)) {
                        alert('조회기간에는 숫자만 입력하실 수 있습니다.   ');
                        document.view.end_date.focus();
                        document.view.end_date.select();
                        return false;
                    }
                }
                document.view.submit();
            }
            function IsNumber(formname) {
                var formstr = eval(formname);
                for(var i=0 ; i<formstr.value.length ; i++) {
                    var chr=formstr.value.substr(i,1);
                    if((chr<'0'||chr>'9') && chr!='-' && chr!='_') return false;
                }
                return true;
            }
        </script>

        <script language="javascript">
            function selectCheck(form) {
                var check_nums = document.OderAllDelete.elements.length;
                for (var i = 0; i < check_nums;  i++) {
                    var checkbox_obj = eval("document.OderAllDelete.elements[" + i + "]");
                    if (checkbox_obj.checked == true) {
                        break;
                    }
                }
                if(i == check_nums) {
                    alert ("먼저 삭제하고자 하는 주문 항목을 선택하여 주세요.   ");
                    return;
                }else {
                    document.OderAllDelete.submit();
                }
            }
            function selectAll() {
                var form = document.OderAllDelete;
                for (var i=0;i<form.elements.length;i++) {
                    obj_str = eval(form.elements[i]);
                    obj_str.checked = !obj_str.checked;
                }
            }
            function saveExcel(fileTemp) {
                isCheck = false;
                frm = document.OderAllDelete;
                //obj = frm.elements['OrderNum[]'];
                obj = document.getElementsByName('OrderNum[]');

                for(i=0;i<obj.length;i++) {
                    if(obj[i].checked == true) isCheck = true;
                }
                if(isCheck != true) {
                    alert('엑셀파일로 변환하고자 하는 주문내역을 선택하세요');return false;}

                orgAction = frm.action
                frm.action = fileTemp;
                frm.submit();
                frm.action = orgAction
            }
            function paySuccess() {

                isCheck = false;
                frm = document.OderAllDelete;
                //obj = frm.elements['OrderNum[]'];
                obj = document.getElementsByName('OrderNum[]');

                for(i=0;i<obj.length;i++) {
                    if(obj[i].checked == true) isCheck = true;
                }
                if(isCheck != true) {
                    alert('승인하고자 하는 주문내역을 선택하세요');return false;}

                frm.target = "hf";
                orgAction = frm.action
                frm.action = "od_paySuccess.php";
                frm.submit();
                frm.action = orgAction

            }
            function payBankOk() {
                isCheck = false;
                var checkCnt = 0;
                frm = document.OderAllDelete;
                obj = frm.elements['OrderNum[]'];

                for(i=0;i<obj.length;i++) {
                    if(obj[i].checked == true) {
                        isCheck = true;
                        checkCnt = checkCnt+1;
                    }
                }
                if(isCheck != true) {
                    alert('결제확인 처리 할 주문내역을 선택하세요');return false;}

                if(!confirm('선택된 '+checkCnt+'건의 주문을 결제확인 처리 하시겠습니까?')) return false;

                orgAction = frm.action
                frm.action = "orderbankok.php";
                frm.target = "hf";
                frm.submit();
                frm.action = orgAction;
                frm.target = "";
            }
        </script>

        <!--  달력 스크립트 시작 -->
        <script>
            function cal_setup(mon,day,year,xx,yy,mode){
                if(mode == 2){ 
                    if(document.view.start_date.value == ""){
                        alert('검색기간의 시작날을 먼저 입력해주세요.');
                        return false;
                    }
                }
                if(document.cal_form.mode.value != mode){
                    document.cal_form.old_xx.value="";
                    document.cal_form.old_yy.value="";
                }
                x = (document.layers) ? e.pageX : document.body.scrollLeft+event.clientX;
                y = (document.layers) ? e.pageY : document.body.scrollTop+event.clientY;
                document.cal_form.mon.value = mon;
                document.cal_form.day.value = day;
                document.cal_form.year.value = year;
                if(xx == 0 && yy == 0){
                    document.cal_form.xx.value = xx;
                    document.cal_form.yy.value = yy;
                }
                else{
                    if(!document.cal_form.old_xx.value && !document.cal_form.old_yy.value){
                        document.cal_form.xx.value = x;
                        document.cal_form.yy.value = y;
                        document.cal_form.old_xx.value = x;
                        document.cal_form.old_yy.value = y;
                    }
                    else{
                        document.cal_form.xx.value = document.cal_form.old_xx.value;
                        document.cal_form.yy.value = document.cal_form.old_yy.value;
                    }
                }
                document.cal_form.mode.value = mode;
                document.cal_form.submit();
            }
            function cal_setup2(mon,day,year,xx,yy,mode){
                if(mode == 2){ 
                    if(document.view.start_date.value == ""){
                        alert('검색기간의 시작날을 먼저 입력해주세요.');
                        return false;
                    }
                }
                if(document.cal_form.mode.value != mode){
                    document.cal_form.old_xx.value="";
                    document.cal_form.old_yy.value="";
                }
                x = (document.layers) ? e.pageX : document.body.scrollLeft+event.clientX;
                y = (document.layers) ? e.pageY : document.body.scrollTop+event.clientY;
                document.cal_form.mon.value = mon;
                document.cal_form.day.value = day;
                document.cal_form.year.value = year;
                if(xx == 0 && yy == 0){
                    document.cal_form.xx.value = xx;
                    document.cal_form.yy.value = yy;
                }
                else{
                    if(!document.cal_form.old_xx.value && !document.cal_form.old_yy.value){
                        document.cal_form.xx.value = x;
                        document.cal_form.yy.value = y;
                        document.cal_form.old_xx.value = x;
                        document.cal_form.old_yy.value = y;
                    }
                    else{
                        document.cal_form.xx.value = document.cal_form.old_xx.value;
                        document.cal_form.yy.value = document.cal_form.old_yy.value;
                    }
                }
                document.cal_form.mode.value = mode;
                var win_cal = window.open("","cal_win","top=300,left=300,width=240,height=175");
                document.cal_form.target="cal_win";
                document.cal_form.submit();
            }
            function click_day(clickday,mode){
                if(mode == 2){ 
                    if(document.view.start_date.value > clickday){
                        alert('검색기간의 시작날이 마지막날 보다 큽니다.');
                        return false;
                    }
                }
                document.cal_form.old_xx.value="";
                document.cal_form.old_yy.value="";
                if(mode == 1) document.view.start_date.value=clickday;
                else if(mode == 2) document.view.end_date.value=clickday;
                    document.all.cal_layer.style.display="none";
            }
        </script>
        <!--  달력 스크립트 끝 -->
        <iframe name="hf" src="about:blank" style='display:none'></iframe>
        <!--  달력 레이어 시작 -->
        <div id="cal_layer" style="position:absolute;z-index:3;top:0;left:0;display:none">
        <table border='0' cellpadding='2' cellspacing='2' bgcolor="#7B7B7B">
            <form name="cal_form" method="post" action="cal_frame2.php" target="calframe">
                <input type="hidden" name="mode">
                <input type="hidden" name="old_mode">
                <input type="hidden" name="mon">
                <input type="hidden" name="day">
                <input type="hidden" name="year">
                <input type="hidden" name="xx">
                <input type="hidden" name="yy">
                <input type="hidden" name="old_xx">
                <input type="hidden" name="old_yy">
            </form>
            <tr>
                <td nowrap bgcolor="#FFFFFF" style="padding:2;"><font id="cal_doc"></font></td>
            </tr>
        </table>
        </div>
        <!--  달력 레이어 끝 -->

        <table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="FFFFFF">
            <tr> 
                <td height="80" bgcolor="#FFFFFF">
                    <!-- top menu start -->
<? include "$folderpath_manager_common/od_topMenu.inc.php"; ?>
                    <!-- top menu end -->
                </td>
            </tr>
            <tr> 
                <td valign="top"> 
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                            <td height="6"></td>
                        </tr>
                    </table>
                    <table height="100%" border="0" cellpadding="0" cellspacing="0">
                        <tr>
                            <td width="165" height="100%" valign="top"> 
                                <!-- left menu start -->
<? include "$folderpath_manager_common/od_leftMenu.inc.php"; ?>
                                <!-- left menu end -->
                            </td>
                            <td width="3">&nbsp;</td>
                            <td width="100%" valign="top">
                                <!-- main table start -->
                                <table width="782" height="100%" border="0" cellpadding="10" cellspacing="1" bgcolor="D6D6D6">
                                    <tr> 
                                        <td  valign="top" bgcolor="#FFFFFF"> 
                                            <table width="100%" border="0" cellspacing="0" cellpadding="0">

                                                <tr> 
                                                    <td height="33"><font color="313D7D"><img src="../odimages/odmain/title_icon.gif" width="13" height="13" hspace="1" align="absmiddle"> 주문관리 &gt; <span class="st">주문 목록</span></font></td>
                                                </tr>
                                            </table>

                                            <table width="100%" border="0" cellspacing="0" cellpadding="0" style="display:none">
                                                <tr> 
                                                    <td height="18"><font color="313D7D"><img src="../odimages/odmain/tex_icon.gif" width="5" height="11" hspace="5"><b>주문번호를 클릭</b>하시면 주문 상세페이지(주문정보수정)를 보실 수 있습니다.</font></td>
                                                </tr>
                                                <tr> 
                                                    <td height="18"> <font color="313D7D"><img src="../odimages/odmain/tex_icon.gif" width="5" height="11" hspace="5"><b>주문정보를 삭제하실 경우 상품 재고량과 회원이 사용한 적립금이 환원되지 않습니다.</b></font></td>
                                                </tr>
                                                <tr> 
                                                    <td height="18"><font color="313D7D"><img src="../odimages/odmain/tex_icon.gif" width="5" height="11" hspace="5">상품의 재고량과 회원이 사용한 적립금이 환원되기를 바란다면 반드시 <b><font color='red'>주문취소로 처리 하셨다가 삭제</font></b>해 주시기 바랍니다.</font></td>
                                                </tr>
                                                <tr> 
                                                    <td height="18"><font color="313D7D"><img src="../odimages/odmain/tex_icon.gif" width="5" height="11" hspace="5"><b>회원주문</b>인 경우 <b>주문번호가 볼드체(굵은글씨)로 표시</b> 됩니다.</font></td>
                                                </tr>
                                                <tr> 
                                                    <td height="18"><font color="313D7D"><img src="../odimages/odmain/tex_icon.gif" width="5" height="11" hspace="5">주문내역에 대한 <b>엑셀파일</b>은 검색조건에 맞는 내역만 저장됩니다.</font></td>
                                                </tr>
                                            </table>
                                            <table width="100%" border="0" cellspacing="1" cellpadding="0">
                                                <tr>
                                                    <td height="5"></td>
                                                </tr>
                                                <tr> 
                                                    <td height="2" bgcolor="D6D6D6"></td>
                                                </tr>
                                            </table>
                                            <table width="100%" border="0" cellspacing="1" cellpadding="0">
                                                <tr> 
                                                    <td height="15">&nbsp;</td>
                                                </tr>
                                          </table>
<?
    if($style != "b") {
?>
                                          <table width="760" border="0" cellspacing="0" cellpadding="0">
                                                <tr> 
                                                    <td colspan="3"><img src="../odimages/odmain/search_piece1.gif" width="760" height="8"></td>
                                                </tr>
                                                <tr> 
                                                    <td width="6" background="../odimages/odmain/search_bg1.gif">&nbsp;</td>
                                                    <td width="748" align="center" style="padding:10px;">
                                                        <!-- search form start -->
                                                        <table width="100%" border="0" cellspacing="1" cellpadding="0">
                                                            <form name="view" method="get" action="od_orderslist.php" onsubmit="return view_submit()">
                                                                <input type="hidden" name="search_value_" value="true">
                                                                <!--
                                                                <input type="hidden" name="search" value="<?=$search?>">
                                                                <input type="hidden" name="key" value="<?=$key?>">
                                                                -->
                                                            <tr> 
                                                                <td height="25" colspan="2"><font color="DD896B"><b>*</b> 검색조건을 선택하신 후 검색 버튼을 클릭해 주시기 바랍니다.</font></td>
                                                            </tr>
                                                            <tr> 
                                                                <td>
                                                                    <table border="0" cellspacing="5" cellpadding="0">
                                                                        <tr> 
                                                                            <td>
<script>
function strreplace(obj) {
    obj.value = obj.value.replace(/-/g,"");
}
</script>
                                                                            
                                                                            <img src="../odimages/odmain/tex_icon.gif" width="5" height="11" hspace="5">검색기간&nbsp;&nbsp;
                                                                                <input id=ipt01 type="text" name="start_date" size="15" class="border" maxlength="8" value="<?=$start_date?>" onchange="strreplace(this)">
                                                                                ~ 
                                                                                <input id=ipt02 type="text" name="end_date" size="15" class="border" maxlength="8" value="<?=$end_date?>" onchange="strreplace(this)">
                                                                                입력예) 20030416 ~ 20030417
                                                                                <script>var cal1 = new jsCalendar(document.getElementById('ipt01'));</script>
                                                                                <script>var cal1 = new jsCalendar(document.getElementById('ipt02'));</script>
                                                                                
                                                                                </td>
                                                                        </tr>
                                                                        <tr> 
                                                                            <td valign="top"><img src="blank.gif" width="67" height="1">
                                                                                <input type="radio" name="date_term" value="t0" onclick="set_date('t',0)" <?if($date_term=="t0")echo" checked";?>>오늘
                                                                                <input type="radio" name="date_term" value="d15" onclick="set_date('d',15)" <?if($date_term=="d15")echo" checked";?>>15일
                                                                                <input type="radio" name="date_term" value="m1" onclick="set_date('m',1)" <?if($date_term=="m1")echo" checked";?>>1개월
                                                                                <input type="radio" name="date_term" value="m3" onclick="set_date('m',3)" <?if($date_term=="m3")echo" checked";?>>3개월
                                                                                <input type="radio" name="date_term" value="m6" onclick="set_date('m',6)" <?if($date_term=="m6")echo" checked";?>>6개월
                                                                                <input type="radio" name="date_term" value="y1" onclick="set_date('y',1)" <?if($date_term=="y1")echo" checked";?>>1년
                                                                                <input type="radio" name="date_term" value="w0" onclick="set_date('w',0)" <?if($date_term=="w0")echo" checked";?>>전체&nbsp;&nbsp;
                                                                                <input type="radio" name="search_standard" value="orderdate" <?if($search_standard=="orderdate")echo" checked";?>>주문일기준
                                                                                <input type="radio" name="search_standard" value="paydate" <?if($search_standard=="paydate")echo" checked";?>>결제일기준</td>
                                                                        </tr>
                                                                        <tr> 
                                                                            <td height="3"></td>
                                                                        </tr>
                                                                        <tr> 
                                                                            <td><img src="../odimages/odmain/tex_icon.gif" width="5" height="11" hspace="5">결제수단&nbsp;&nbsp;
                                                                                <select name="paymethod">
                                                                                <option value="">결제수단</option>
                                                                                <option value="">--------------</option>
                                                                                <!-- 에스크로 끝 -->
                                                                                <option value="C" <?if($paymethod=="C")echo" selected";?>>신용카드결제</option>
                                                                                <option value="L" <?if($paymethod=="L")echo" selected";?>>실시간계좌이체</option>
                                                                                <option value="H" <?if($paymethod=="H")echo" selected";?>>핸드폰결제</option>
                                                                                <option value="B" <?if($paymethod=="B")echo" selected";?>>무통장입금</option>
                                                                                </select>
                                                                                &nbsp;<img src="../odimages/odmain/tex_icon.gif" width="5" height="11" hspace="5">결제상태 
                                                                                <select name="paystatus">
                                                                                <option value="Y" <?if($paystatus=="Y")echo" selected";?>>결제완료</option>
                                                                                <option value="N" <?if($paystatus=="N")echo" selected";?>>결제대기</option>
                                                                                </select>
                                                                                &nbsp;&nbsp;<img src="../odimages/odmain/tex_icon.gif" width="5" height="11" hspace="5">처리상태 
                                                                                <select name="delivstatus">
                                                                                <option value="">처리상태</option>
                                                                                <option value="">----------</option>
                                                                                <option value="yes" <?if($delivstatus=="yes")echo" selected";?>>완료</option>
                                                                                <option value="no" <?if($delivstatus=="no")echo" selected";?>>대기</option>
                                                                                </select></td>
                                                                        </tr>
                                                                        <tr> 
                                                                            <td height="1"></td>
                                                                        </tr>
                                                                        <tr> 
                                                                            <td><img src="../odimages/odmain/tex_icon.gif" width="5" height="11" hspace="5">정 렬 수&nbsp;&nbsp;
                                                                                <img src="blank.gif" width="1" height="1">
                                                                                <select name="page_number">
                                                                                <option value="1" <?if($page_number=="1")echo" selected";?>>1</option>
                                                                                <option value="5" <?if($page_number=="5")echo" selected";?>>5</option>
                                                                                <option value="10" <?if($page_number=="10")echo" selected";?>>10</option>
                                                                                <option value="20" <?if($page_number=="20")echo" selected";?>>20</option>
                                                                                <option value="30" <?if($page_number=="30")echo" selected";?>>30</option>
                                                                                <option value="40" <?if($page_number=="40")echo" selected";?>>40</option>
                                                                                <option value="50" <?if($page_number=="50")echo" selected";?>>50</option>
                                                                                <option value="60" <?if($page_number=="60")echo" selected";?>>60</option>
                                                                                <option value="70" <?if($page_number=="70")echo" selected";?>>70</option>
                                                                                <option value="80" <?if($page_number=="80")echo" selected";?>>80</option>
                                                                                <option value="90" <?if($page_number=="90")echo" selected";?>>90</option>
                                                                                <option value="100" <?if($page_number=="100")echo" selected";?>>100</option>
                                                                                </select>
                                                                                &nbsp; <img src="../odimages/odmain/tex_icon.gif" width="5" height="11" hspace="5">정렬기준 
                                                                                <select name="order_by">
                                                                                <option value="paydate" <?if($order_by=="paydate")echo" selected";?>>결제일시</option>
                                                                                <option value="orderdate" <?if($order_by=="orderdate")echo" selected";?>>주문일시</option>
                                                                                <option value="tPrice" <?if($order_by=="tPrice")echo" selected";?>>결제금액</option>
                                                                                </select>
                                                                                &nbsp;<img src="../odimages/odmain/tex_icon.gif" width="5" height="11" hspace="5">정렬순서 
                                                                                <select name="order_by_rule">
                                                                                <option value="desc" <?if($order_by_rule=="desc")echo" selected";?>>내림차순</option>
                                                                                <option value="asc" <?if($order_by_rule=="asc")echo" selected";?>>오름차순</option>
                                                                                </select></td>
                                                                        </tr>
                                                                        <tr> 
                                                                            <td height="1"></td>
                                                                        </tr>
                                                                        <tr> 
                                                                            <td><img src="../odimages/odmain/tex_icon.gif" width="5" height="11" hspace="5">입점업체&nbsp;
                                                                                <img src="blank.gif" width="1" height="1">
                                                                                <select name="partnerCode">
                                                                                    <option value="">전체</option>
<?
    $queP = "select id,bannder,cName from odtMember where userType='C' group by bannder";
    $resP = mysql_query($queP);
    while($rowP = mysql_fetch_array($resP)) {
?>
                                                                                <option value="<?=$rowP[bannder]?>" <?=$partnerCode == $rowP[bannder] ? "selected" : NULL;?>><?=$rowP[bannder]?></option>
<?
}
?>
                                                                                </select>
																				
                                                                                &nbsp; <img src="../odimages/odmain/tex_icon.gif" width="5" height="11" hspace="5">주문타입
                                                                                <select name="order_type">
                                                                                    <option value="">전체</option>
																					<option value="coupon" <?echo ($order_type =="coupon")?"selected":"";?>>쿠폰발송형태
																					<option value="product" <?echo ($order_type =="product")?"selected":"";?>>상품배송형태
                                                                                </select>
																				</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td><img src="../odimages/odmain/tex_icon.gif" width="5" height="11" hspace="5">상세검색&nbsp;&nbsp;
                                                                                <select name="searchfield">
                                                                                <option value="ordernum" <?if($search=="ordernum") echo" selected";?>>주문번호</option>
                                                                                <option value="orderid" <?if($search=="orderid") echo" selected";?>>주문자아이디</option>
                                                                                <option value="ordername" <?if($search=="ordername" || !$search) echo" selected";?>>주문자이름</option>
                                                                                <option value="payname" <?if($search=="payname") echo" selected";?>>입금인이름</option>
                                                                                <option value="recname" <?if($search=="recname") echo" selected";?>>받는사름이름</option>
                                                                                <option value="recaddress" <?if($search=="recaddress") echo" selected";?>>주소</option>
                                                                                <option value="paymethod" <?if($search=="paymethod") echo" selected";?>>결제방법[C or B]</option>
                                                                                </select>
                                                                                <input name="searchkey" type="text" class="border" size="31" value="<?=$key?>">
                                                                        </td>
                                                                        </tr>


                                                                    </table>
                                                                </td>
                                                                <td align="right"><input type="image" src="../odimages/odmain/search_btn.gif" width="68" height="64" onfocus='this.blur();'></td>
                                                            </tr>
                                                            </form>
                                                        </table>
                                                        <!-- search form end -->
                                                    </td>
                                                    <td width="6" background="../odimages/odmain/search_bg2.gif">&nbsp;</td>
                                                </tr>
                                                <tr> 
                                                    <td colspan="3"><img src="../odimages/odmain/search_piece2.gif" width="760" height="8"></td>
                                                </tr>
                                            </table>
<?
}
?>
                                            <table width="100%" border="0" cellspacing="1" cellpadding="0">
                                                <tr>
                                                    <td>&nbsp;</td>
                                                </tr>
                                            </table>
                                            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                <tr> 
                                                    <td valign="top">
                                                        <table width="760" border="0" cellspacing="0" cellpadding="0">
                                                            <!-- all delete form start -->
                                                            <form name="OderAllDelete" method="post" action="od_orderalldelete.php">
                                                                <input type="hidden" name="PageL" value="All">
                                                                <input type="hidden" name="page" value="<?=$page?>">
                                                                <input type="hidden" name="par_page" value="<?=$par_page?>">
                                                            <tr>
                                                                <td>
                                                                    <img src="../odimages/odmain/page_icon.gif" width="14" height="11"> 
                                                                    <font color="3960AC">전체 <b><?=$TotalPage?></b>페이지 [<b><?=$total?></b>]개 / 매출합계</font> 
                                                                    <font color='FF0000' style="font-size:14;font-family:굴림"><b><?=number_format($sum_total);?>원</b></font>


                                                                </td>
                                                                <td align="right">
                                                                <?
                                                                if($_GET[style] == "b") {
                                                                ?>
                                                                    <!-- 결제확인 
                                                                    <img src="../odimages/btn_bankok.gif" width="77" height="24" onclick="payBankOk()" style='cursor:hand;' onfocus='this.blur();'--> 
                                                                <?
                                                                } else {
                                                                ?>
                                                                    <!-- 결제승인 -->
                                                                    <?help_pop("결제확인을 클릭 해주어야 입점업체 주문리스트에 노출됩니다.<br>결제확인된것은 글씨가 bold(두껍게) 처리됩니다.")?><img src="../odimages/odmain/btn_acc.gif" width="77" height="24" onclick="paySuccess()" style='cursor:hand;' onfocus='this.blur();'> 
                                                                <?
                                                                }
                                                                ?>
                                                                    <!-- 엑셀저장 -->
                                                                    <img src="../odimages/odmain/btn_excel.gif" width="77" height="24" onclick="<?=$excelTemp1?>" style='cursor:hand;' onfocus='this.blur();'> 
                                                                    <!-- 전체삭제   // 선택삭제는 지원하지 않음. 취소후 삭제토록 유도
                                                                    <img src="../odimages/odmain/btn_delete.gif" width="77" height="24" onclick="<?=$deleteTemp1?>" style='cursor:hand;' onfocus='this.blur();'>--></td>
                                                            </tr>
                                                        </table>
                                                        <table width="760" border="0" cellspacing="0" cellpadding="0">
                                                            <tr> 
                                                                <td height="1" colspan="12" bgcolor="c0bebe"></td>
                                                            </tr>
                                                            <tr align="center"> 
                                                                <td width="40" height="27" bgcolor="ececec" class="white">번호</td>
                                                                <td width="25" bgcolor="ececec" class="white"><a onclick="selectAll();" onfocus='this.blur();' style='cursor:hand;'>전체</a></td>
                                                                <td bgcolor="ececec" class="white">주문번호<br>상품명</td>
                                                                <td width="45"  bgcolor="ececec" class="white">주문일</td>
                                                                <td width="60"  bgcolor="ececec" class="white">주문자</td>
                                                                <td width="100" bgcolor="ececec" class="white">연락처</td>
                                                                <td width="70"  bgcolor="ececec" class="white">결제방법</td>
                                                                <td width='80'  bgcolor="ececec" class="white">결제금액</td>
                                                                <td width="80"  bgcolor="ececec" class="white">결제상황</td>
                                                                <td width="60"  bgcolor="ececec" class="white">처리상황</td>
                                                            <td width="40"  bgcolor="ececec" class="white">쿠폰</td>  
                                                                <td width="30"  bgcolor="ececec" class="white">취소</td>
                                                            </tr>
                                                            <tr> 
                                                                <td height="1" colspan="12" bgcolor="c0bebe"></td>
                                                            </tr>
                                                            <tr> 
                                                                <td height="2" colspan="12"></td>
                                                            </tr>
                                                        </table>
                                                        <table width="760" border="0" cellspacing="0" cellpadding="1">
                                                            <tr> 
                                                                <td height="1" colspan="12" bgcolor="D2D2D2"></td>
                                                            </tr>
<?

    
    if(!$total)  echo "
                                                            <tr>
                                                                <td colspan='12' height='55' align='center'><font color='darkorange'>주문 내역이 없습니다.</font></td>
                                                            </tr>";
    
    $serialnumber = $total - $LineNumber * ($page - 1);
    
    for($i = $first; $i <= $last; $i++) {
        mysql_data_seek($res_MOOL,$i);
        $row = mysql_fetch_array($res_MOOL);
        
        if($row[tPrice] > 0) $_totalprice_ = "<font color='FF6600'>".number_format($row[tPrice])."원</font>";
        else $_totalprice_ = "전액적립금결제";
        

        if($row[paymethod] == "B") $_paymethod_ = "은행";

        else if($row[paymethod] == "L") $_paymethod_ = "실시간";

        else if($row[paymethod] == "H") $_paymethod_ = "핸드폰";

        else if($row[paymethod] == "G") $_paymethod_ = "G포인트";
        
        ## 에스크로 시작
        else if($row[paymethod] == "E") $_paymethod_ = "<font color='#ee0000'>에스크로</font>";
        ## 에스크로 끝

        else $_paymethod_ = "카드";
        
        if($row[paystatus] == "Y") {
            if($row[paystatus2] =="Y") $_paystatus_ = "<font color='red'><b>결제확인</b></font>";
            if($row[paystatus2] !="Y") $_paystatus_ = "<font color='red'>결제확인</font>";
        }
        else if(ereg("B|E",$row[paymethod])) $_paystatus_ = "결제전" ;
        else {
            if($row[orderstep] == "fail") $_paystatus_ = "결제실패";    
            else $_paystatus_ = "결제취소";             
        }


		// 배송기능 추가에 따른 분화 - onedaynet jjc
		if($row[order_type] == "product") {
			if($row[delivstatus] == "yes") {
				$_delivstatus_ = "<font color='red'><b>발송완료</b></font>";
				if($row[expressnum]) {
					$_delivstatus_ .= link_delivery($row[expressname],$row[expressnum]);
				}
			}
			else {
				$_delivstatus_ = "발송대기";
			}
		}
		else {
			if($row[delivstatus] == "yes") {
				$_delivstatus_ = "<font color='red'><b>발급완료</b></font>";
			}
			else {
				$_delivstatus_ = "대기";
			}
		}
    

        $orderdate = date("m.d",strtotime($row[orderdate]));
        
        if($row[canceled] == "N") {
            $cancelTemp = "<a href='od_ordercancel.php?ordernum=$row[ordernum]&page=$page$par_page'><img src='../odimages/cancel_icon.gif' border='0' alt='주문취소처리'></a>";
        }
        else {
            $cancelTemp = "-";
        }
        
        if(!$row[orderid] || $row[orderid] == "guest") $orderNumber = $row[ordernum];
        else $orderNumber = "<b>".$row[ordernum]."</b>";
        
        ## 접근권한 설정(수정)
        if($row_admin[orderLevel]==5 || $row_admin[orderLevel]==9 || $row_admin[superLevel]==9) 
            $modifyTemp1 = "od_ordermodify.php?Form=OrderModify&ordernum=$row[ordernum]&PageL=All&page=$page$par_page";
        else $modifyTemp1 = "javascript:reject();";
        
        ## 접근권한 설정(취소)
        if($row_admin[orderLevel]==7 || $row_admin[orderLevel]==9 || $row_admin[superLevel]==9) $cancelTemp1 = $cancelTemp;
        else $cancelTemp1 = "<a href='javascript:reject();'><img src='../odimages/cancel_icon.gif' border='0' alt='주문취소처리'></a>";

        ## 상품명
        $tmptCnt = 0;
        unset($pNameTmp);
        $pCodeTmp = explode("^",$row[pLog]);
        for($ee=0;$ee<count($pCodeTmp);$ee++) {
            $pCodeTmp2 = explode("|",$pCodeTmp[$ee]);
            $pNameRes = mysql_result(mysql_query("select name from odtProduct where code ='".$pCodeTmp2[0]."'"),0);
            $pNameTmp .= "<span title='".$pNameRes."'><b>".$pCodeTmp2[1]."</b>개 - ".cut_str_short($pNameRes,10)."</span><br>";

            $tmptCnt = $tmptCnt + $pCodeTmp2[1];
        }

        ## 결제진행사항
        unset($orderstep);
        $orderstepArray = array("before"=>"주문서작성중","ing"=>"진행중","cancle"=>"사용자취소","fail"=>"<img src='/images/btn_help_v2.gif' onclick='alert(\"".$row[ordersau]."\")' style='cursor:hand'>결제실패","finish"=>"결제완료");
        if(!strstr($_paystatus_,"결제확인") && !ereg("B|E",$row[paymethod])) {
            $orderstep = "<br>".$orderstepArray[$row[orderstep]];
        } else {
            if($row[paystatus2] =="C") $orderstep = "<br><font color=blue>[취소요청]</font>";
        }

        $randID = rand(1,999999);

        $_partner_ = "";
        if($row[hID]) {
            $_partner_ = @mysql_result(mysql_query("select id from odtMember where hID='".$row[hID]."'"),0);
        }

        echo "
                                                            <tr> 
                                                                <td width='40' align='center' bgcolor='FAFAFA'>$serialnumber</td>
                                                                <td width='30' align='center' bgcolor='FAFAFA'><input type='checkbox' name='OrderNum[]' value='$row[ordernum]'></td>
                                                                <td  align='center' bgcolor='FAFAFA' class='cate'><a href='$modifyTemp1'>$orderNumber</a><br>$pNameTmp</td>
                                                                <td width='45' align='center' bgcolor='FAFAFA'>$orderdate</td>
                                                                <td width='60' align='center' bgcolor='FAFAFA' class='cate'>
                                                                    <div id=".$randID." style='Z-INDEX: 1; LEFT: 0px; WIDTH: 0px; POSITION: relative; TOP: 0px; HEIGHT: 0px;display:none'><div id='".$randID."_1' style='position:absolute;z-index:3;top:20;left:0;'></div></div><span style='font-weight:;cursor:pointer' onclick=\"showInfo('".$row[orderid]."','".$row[ordername]."','".$randID."')\">".$row[ordername]."</span></td>
                                                                <td width=100 align='center' bgcolor='FAFAFA' style='padding-top:3;font-size:11px'>
                                                                    $row[ordertel1]-$row[ordertel2]-$row[ordertel3]<br>$row[orderhtel1]-$row[orderhtel2]-$row[orderhtel3]</td>
                                                                <!--
                                                                <td width='60' align='center' bgcolor='FAFAFA'>$row[recname]</td>
                                                                -->
                                                                <td width='70' align='center' bgcolor='FAFAFA'>$_paymethod_</td>
                                                                <td width='80' align='center' bgcolor='FAFAFA'><b><font color='#0000FF'>$_totalprice_</font></b></td>
                                                                <td width='80' align='center' bgcolor='FAFAFA'><font color='#138CE5'>$_paystatus_</font>$orderstep</td>
                                                                <td width='60' align='center' bgcolor='FAFAFA'><font color='#138CE5'>$_delivstatus_</font></td>
                                                                <td width='40' align='center' bgcolor='FAFAFA'>";


    // 쿠폰발급완료 일때만 버튼이 출력 //////////////////////////////////////////
    if ($row[delivstatus]=="yes" && $row[order_type]=="coupon")
    {
        if ("1" == $tmptCnt)
        {
            if ("1" != $row[csu])
            {
                echo "<img src='/images/unuse.gif' style='border:0; cursor:hand;'  onClick=\"f_check('$row[ordernum]', '$tmptCnt', '1');\" align='absmiddle'>";
            }
            else
            {
                echo "<img src='/images/use.gif' style='border:0; cursor:hand;'  onClick=\"f_check('$row[ordernum]', '$tmptCnt', '0');\" align='absmiddle'>";
            }
        }
        else
        {
            echo "<input class='border' type=text name='csu' value='$row[csu]' size='5' maxlength='3'  style='text-align:right' 
                        onkeypress='f_num_press();' onkeydown='f_num_down();' onChange=\"f_check('$row[ordernum]', '$tmptCnt', this.value);\"   onFocus='this.select();'>";
        }
    }


                                                                echo "
                                                                </td>
                                                                <td width='30' align='center' bgcolor='FAFAFA'>$cancelTemp1</td>
                                                            </tr>
                                                            <tr> 
                                                                <td height='1' colspan='12' bgcolor='D2D2D2'></td>
                                                            </tr>";
                                                            
        $serialnumber--;
    }
?>
                                                            </form>
                                                            <!-- all delete form end -->
                                                        </table>
                                                        <table width="760" border="0" cellspacing="1" cellpadding="0">
                                                            <tr> 
                                                                <td height="4"></td>
                                                            </tr>
                                                        </table>
                                                        <table width="760" border="0" cellspacing="0" cellpadding="0">
                                                            <tr> 
                                                                <td width="160">&nbsp;</td>
                                                                <td width="440" align="center" class='num'>
                                                                    <a href='od_orderslist.php?page=1<?=$par_page?>'>
                                                                    <img src="../odimages/odmain/num_arrow_pre2.gif" width="13" height="11" border='0' alt="처음페이지" align="absmiddle"></a>
<?
    $TotalJump = ceil($TotalPage / $LinkNumber);
    $Jump = ceil($page / $LinkNumber);
    $FirstPage = ($Jump - 1) * $LinkNumber;
    $LastPage = $Jump * $LinkNumber;

    if($Jump >= $TotalJump) $LastPage = $TotalPage;

    if($Jump > 1) {
        $PrePage = $FirstPage;
        echo "<a href='od_orderslist.php?page=$PrePage$par_page'><img src='../odimages/odmain/num_arrow_pre1.gif' width='35' height='11' hspace='3' border='0' alt='이전 ${LinkNumber}개'></a> / ";
    }
    else {
        echo " / ";
    }

    for($NowPage = $FirstPage+1; $NowPage <= $LastPage; $NowPage++) {
        if($page == $NowPage) echo "<b>$NowPage</b> / ";
        else echo "<a href='od_orderslist.php?page=$NowPage$par_page'>$NowPage</a> / ";
    }

    if($Jump < $TotalJump) {
        $PrePage = $LastPage+1;
        echo "<a href='od_orderslist.php?page=$PrePage$par_page'><img src='../odimages/odmain/num_arrow_next2.gif' width='35' height='11' hspace='3' border='0' alt='다음 ${LinkNumber}개'></a>";
    }
?>
                                                                    <a href='od_orderslist.php?page=<?=$TotalPage?><?=$par_page?>'>
                                                                    <img src="../odimages/odmain/num_arrow_next1.gif" width="13" height="11" border='0' alt="마지막페이지" align="absmiddle"></a>
                                                                </td>
                                                                <td width="160" align="right">
                                                                    <!-- 엑셀저장 -->
                                                                    <img src="../odimages/odmain/btn_excel.gif" width="77" height="24" onclick="<?=$excelTemp1?>" style='cursor:hand;' onfocus='this.blur();'> 
                                                                    <!-- 전체삭제   // 선택삭제는 지원하지 않음. 취소후 삭제토록 유도
                                                                    <img src="../odimages/odmain/btn_delete.gif" width="77" height="24" onclick="<?=$deleteTemp1?>" style='cursor:hand;' onfocus='this.blur();'> --></td>
                                                            </tr>
                                                        </table>
                                                        <table width="760" border="0" cellspacing="0" cellpadding="0">
                                                            <tr> 
                                                                <td height="37" align="center">
                                                                    <table border="0" cellspacing="2" cellpadding="0">
                                                                        <!-- form start ----------------------------------------->
                                                                        <form method="get" action="od_orderslist.php">
                                                                            <!--
                                                                            <input type="hidden" name="paymethod" value="<?=$paymethod?>">
                                                                            <input type="hidden" name="paystatus" value="<?=$paystatus?>">
                                                                            <input type="hidden" name="delivstatus" value="<?=$delivstatus?>">
                                                                            <input type="hidden" name="start_date" value="<?=$start_date?>">
                                                                            <input type="hidden" name="end_date" value="<?=$end_date?>">
                                                                            <input type="hidden" name="date_term" value="<?=$date_term?>">
                                                                            <input type="hidden" name="search_standard" value="<?=$search_standard?>">
                                                                            <input type="hidden" name="order_by" value="<?=$order_by?>">
                                                                            <input type="hidden" name="order_by_rule" value="<?=$order_by_rule?>">
                                                                            <input type="hidden" name="search_value_" value="<?=$search_value_?>">
                                                                            <input type="hidden" name="page_number" value="<?=$page_number?>">
                                                                            -->
                                                                        <tr>
                                                                            <td>
                                                                                <select name="search">
                                                                                <option value="ordernum" <?if($search=="ordernum") echo" selected";?>>주문번호</option>
                                                                                <option value="orderid" <?if($search=="orderid") echo" selected";?>>주문자아이디</option>
                                                                                <option value="ordername" <?if($search=="ordername" || !$search) echo" selected";?>>주문자이름</option>
                                                                                <option value="payname" <?if($search=="payname") echo" selected";?>>입금인이름</option>
                                                                                <option value="recname" <?if($search=="recname") echo" selected";?>>받는사름이름</option>
                                                                                <option value="recaddress" <?if($search=="recaddress") echo" selected";?>>주소</option>
                                                                                <option value="paymethod" <?if($search=="paymethod") echo" selected";?>>결제방법[C or B]</option>
                                                                                </select>
                                                                            </td>
                                                                            <td><input name="key" type="text" class="border" size="31" value="<?=$key?>"></td>
                                                                            <td><input type="image" src="../odimages/odmain/btn_search.gif" width="43" height="19" onfocus='this.blur();'></td>
                                                                        </tr>
                                                                        </form>
                                                                        <!-- form end ------------------------>
                                                                    </table>
                                                                </td>
                                                            </tr>
                                                        </table>
                                                        <table width="100%" border="0" cellspacing="1" cellpadding="0">
                                                            <tr> 
                                                                <td height="30">&nbsp;</td>
                                                            </tr>
                                                        </table>
                                                    </td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td height="5" bgcolor="#FFFFFF"></td>
                                    </tr>
                                </table>
                                <!-- main table end -->
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td height="83">
                    <!-- bottom start -->
<? include "$folderpath_manager_common/od_bottom.inc.php"; ?>
                    <!-- bottom end -->
                </td>
            </tr>
        </table>
        <!-- 달력 히든 프레임 시작 -->
        <iframe name="calframe" width=0 height=0 src="cal_frame.php"></iframe>
        <!-- 달력 히든 프레임 끝 -->
    </body>
</html>
