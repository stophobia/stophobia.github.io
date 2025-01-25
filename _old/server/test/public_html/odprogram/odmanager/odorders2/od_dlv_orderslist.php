<?
    include "../../odcommon/od_config.inc.php";
    include "$folderpath_manager_common/od_function.inc.php";
    include "$folderpath_manager_common/od_comAuthority.inc.php";
    include "$folderpath_manager_common/od_head.inc.php";
    include "$folderpath_manager_common/od_body.inc.php";

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
    //include "ordercheck.php";

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

    if($key) $search_value = " AND ".$search." LIKE '%".$key."%'";
    if(!$search_standard) $search_standard = "paydate";
    if(!$page_number) $page_number = "50";

    ## 검색조건 Par 정리 #####################################
    if($search_value_ == "true") {
        $search = "";
        $key = "";

        if($paymethod) $search_value = " AND paymethod='".$paymethod."'";
        if($paystatus) $search_value .= " AND paystatus='".$paystatus."'";
        if($delivstatus) $search_value .= " AND delivstatus='".$delivstatus."'";
        if($start_date && $end_date) {
            $search_value .= " AND ".$search_standard." BETWEEN '".date('Y-m-d H:i:s',$start_date_time)."' AND '".date('Y-m-d H:i:s',$end_date_time)."'";
            $search_value2 = " AND ".$search_standard." BETWEEN '".date('Y-m-d H:i:s',$start_date_time)."' AND '".date('Y-m-d H:i:s',$end_date_time)."'";
        }
        if($orderbyName) $search_value .= " ORDER BY ".$orderbyName;
        else $search_value .= " ORDER BY orderdate";
        if($orderbyType) $search_value .= " ".$orderbyType;
        else $search_value .= " desc";

    }
    else {
        $search_value .= " ORDER BY delivstatus DESC, paydate desc";
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

## 전체 주문현황
$que = "select * from odtOrder where order_type='product' and partnerCode = '".$com[0]."' and paystatus='Y' and paystatus2='Y' and canceled='N' ".$search_value2;
$res = mysql_query($que);

## 변수정의
$resSaleDate;           //판매일
$resMainName;           //상품명
$resSaleCnt;            //판매수량
$rescommission;     //수수료
$resComPrice;           //입점업체결제
$resPrice;              //판매가
$resMajin;              //마진

while($row= mysql_fetch_array($res)) {

    ## 상품정보
    $parent_code    = mysql_result(mysql_query("select parent_code from odtProduct where code ='".reset(explode("|",$row[pLog]))."'"),0);
    $row_product =   mysql_fetch_array(mysql_query("select * from odtProduct where code = '".$parent_code."'"));

    ##### 판매수량 추출
    $cntTmp=0;
    $sumPurPrice=0;
    $tmp = explode("^",$row[pLog]);
    for($i=0;$i<count($tmp);$i++) {
        $tmp2                   = explode("|",$tmp[$i]);
        $cntTmp             += $tmp2[1];
        $sumPurPrice    += mysql_result(mysql_query("select purPrice from odtProduct where code ='".$tmp2[0]."'"),0) * $tmp2[1];
    }
    ##############################

    ##### 카드사수수료 추출     B:무통장, C:카드, L:실시간계좌이체, E:에스크로
    unset($commission);
    switch($row[paymethod]) {
        case "C" :
            $commission = $row[tPrice]*0.033;
            break;
        case "L" :
            $commission = $row[tPrice] <= 10700 ? 200 : $row[tPrice]*0.02;
            break;
        case "E" :
            $commission = $row[tPrice] *0.003;
            $commission = $commission < 300 ? 300 : $commission;
            break;
        case "H" :
            $commission = $row[tPrice]*0.07;
            break;
    }
    # 부가세 포함
    //$commission += $commission*0.1;

    ###############################

    ##### 입점업체 결제금 추출
    if($row_product[comSaleType] == "공급가") {

        $sumPurPrice=0;
        $tmp = explode("^",$row[pLog]);
        for($i=0;$i<count($tmp);$i++) {
            $tmp2                   = explode("|",$tmp[$i]);
            $tmpRow             =   mysql_fetch_array(mysql_query("select purPrice,optionName,optionPurPrice from odtProduct where code ='".$tmp2[0]."'"));

            $purPriceTmp = $tmpRow[purPrice];
            ## 옵션별 공급가 처리
            unset($oArray,$optionArray,$optionArray2);
            $optionArray = explode("|",$tmpRow[optionName]);
            $optionArray2 = explode("|",$tmpRow[optionPurPrice]);

            for($z=0;$z<count($optionArray);$z++) {
                $oArray[$optionArray[$z]] = $optionArray2[$z];

            }

            $oTmp = explode("^",$row[oLog]);
            for($y=0;$y<count($oTmp);$y++) {
                $oTmp2 = explode("|",$oTmp[$y]);
                if($oTmp2[0] == $tmp2[0]) {
                    $purPriceTmp += $oArray[$oTmp2[1]];
                }
            }

            $sumPurPrice    += $purPriceTmp * $tmp2[1];

        }

        $comPrice = $sumPurPrice + $row_product[del_price_com];

    }
    if($row_product[comSaleType] == "수수료") {

        $sumPrice=0;
        $tmp = explode("^",$row[pLog]);
        for($i=0;$i<count($tmp);$i++) {
            $tmp2                   = explode("|",$tmp[$i]);
            $price1 = mysql_result(mysql_query("select price from odtProduct where code ='".$tmp2[0]."'"),0);

            $oTmp = explode("^",$row[oLog]);
            for($y=0;$y<count($oTmp);$y++) {
                $oTmp2 = explode("|",$oTmp[$y]);
                if($oTmp2[0] == $tmp2[0]) {
                    $price1 += $oTmp2[2];
                }
            }

            $sumPrice   += $price1 * $tmp2[1];
        }

        $comPrice = ($sumPrice - $sumPrice*$row_product[commission]/100) + $row_product[del_price_com];

    }
    ###############################

    ##### 마진
    $majin  =   $row[tPrice] - $commission - $comPrice;
    ###############################

    $resParentCode[$row_product[cateCode]*1][]        = $parent_code;                     //부모코드
    $resSaleDate[$row_product[cateCode]*1][]          = $row_product[sale_date];            //판매일
    $resMainName[$row_product[cateCode]*1][]          =   $row_product[mainName];               //상품명
    $resSaleCnt[$row_product[cateCode]*1][]               =   $cntTmp;                                //판매수량
    $rescommission[$row_product[cateCode]*1][]        =   $commission;                        //수수료
    $resComPrice[$row_product[cateCode]*1][]          =   $comPrice;                          //입점업체결제
    $resMajin[$row_product[cateCode]*1][]                 =   $majin;                                 //마진
    $resPrice[$row_product[cateCode]*1][]                 =   $row[tPrice];                       //판매가
}

#######################
## 상품별로 합산
#######################
for($z=1;$z<30;$z++) {
    for($i=0;$i<count($resSaleDate[$z]);$i++) {
        $resSaleCnt99           += $resSaleCnt[$z][$i];
        $rescommission99    += $rescommission[$z][$i];
        $resComPrice99      += $resComPrice[$z][$i];
        $resMajin99             += $resMajin[$z][$i];
        $resPrice99             += $resPrice[$z][$i];
    }
}

    ## 조건에 맞는 주문목록의 수를 구한다 ###################
    $qry_MOOL = "SELECT * FROM odtOrder WHERE order_type='product' and ordernum != '' and partnerCode = '".$com[id]."' and paystatus='Y' and paystatus2='Y' and canceled='N' AND orderstatus='Y'".$search_value."";

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
    $excelTemp1 = "saveExcel('od_orderexcel.php');";

    ## 접근권한 설정(삭제)
    $deleteTemp1 = "javascript:reject();";
?>

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

                if(obj.length > 0) {

                    for(i=0;i<obj.length;i++) {
                        if(obj[i].checked == true) isCheck = true;
                    }

                    if(isCheck != true) {
                        alert('엑셀파일로 변환하고자 하는 주문내역을 선택하세요');return false;}

                } else {

                    if(obj.checked!=true) {                     alert('엑셀파일로 변환하고자 하는 주문내역을 선택하세요');return false;}
                }

                orgAction = frm.action
                frm.action = fileTemp;
                frm.submit();
                frm.action = orgAction
            }

            function express() {
                frm = document.OderAllDelete;
                if(!confirm('일괄처리할 주문이 100건 이상인경우에는\n\n원활한 쿠폰발송을 위하여 1~2분 간격으로\n\n100건씩 나누어 처리해주시기 바랍니다.\n\n쿠폰정보를 일괄적으로 수정하시겠습니까.?')) return false;

                orgAction = frm.action;
                orgTarget = frm.target;
                frm.action = "od_dlv_orderexpress.php";
                frm.target = "hidden_frame";
                frm.submit();
                frm.action = orgAction;
                frm.target =    orgTarget;
            }

            function express2() {
                frm = document.OderAllDelete;
                if(!confirm('일괄처리할 주문이 100건 이상인경우에는\n\n원활한 쿠폰발송을 위하여 1~2분 간격으로\n\n100건씩 나누어 처리해주시기 바랍니다.\n\n쿠폰정보를 재 발급하시겠습니까.?')) return false;

                orgAction = frm.action;
                orgTarget = frm.target;
                frm.action = "od_dlv_orderexpress2.php";
                frm.target = "hidden_frame";
                frm.submit();
                frm.action = orgAction;
                frm.target =    orgTarget;
            }

            function createCpNum(){
                var siteCode =  "<?=$onedaynet_id?>".toUpperCase();
                var check_nums = document.forms['OderAllDelete']['OrderNum[]'].length;
                var chk_nums = 0;

                if(check_nums > 1) {

                    for (var i = 0; i < check_nums;  i++) {
                        var checkbox_obj = document.forms['OderAllDelete']['OrderNum[]'][i];
                        var text_obj = document.forms['OderAllDelete']['expressnum[]'][i];
                        if (checkbox_obj.checked == true) {
                            text_obj.value = siteCode+"_"+checkbox_obj.value;
                            chk_nums++;
                        }
                    }

                } else {

                    var checkbox_obj = document.forms['OderAllDelete']['OrderNum[]'];
                    var text_obj = document.forms['OderAllDelete']['expressnum[]'];
                    if (checkbox_obj.checked == true) {
                        text_obj.value = siteCode+"_"+checkbox_obj.value;
                        chk_nums++;
                    }


                }

                if(chk_nums == 0) {
                    alert ("먼저 쿠폰번호를 생성하고자 하는 주문 항목을 선택하여 주세요.   ");
                    return;
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
                    hidden_frame.location.href='od_dlv_orderslist.php?status=coupon_check&id='+id+'&value='+value;
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
        function expressSetFun(frm) {
            res = frm.expressSet.value;
            if(!res) {
                alert('택배사를 선택해주세요.');
                frm.expressSet.focus();
                return;
            }

            obj = document.getElementsByName('expressname[]');
            obj2 = document.getElementsByName('setTmp[]');

            for(i=0;i<obj.length;i++) {
                if(obj2[i].value == '') obj[i].value = res;
            }

        }
        </script>
        <!--  달력 스크립트 끝 -->

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

        <iframe name="hidden_frame" src="about:blank" style="display:none"></iframe>

        <table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
            <tr>
                <td height="80" bgcolor="#FFFFFF">
                    <!-- top menu start -->
<? include "$folderpath_manager_common/od_topMenu2.inc.php"; ?>
                    <!-- top menu end -->
                </td>
            </tr>
            <tr>
                <td valign="top"   bgcolor="#FFFFFF">
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                            <td height="6"></td>
                        </tr>
                    </table>
                    <table height="100%" border="0" cellpadding="0" cellspacing="0">
                        <tr>
                            <td width="165" height="100%" valign="top">
                                <!-- left menu start -->
<? include "$folderpath_manager_common/od_leftMenu2.inc.php"; ?>
                                <!-- left menu end -->
                            </td>
                            <td width="3">&nbsp;</td>
                            <td width="782" valign="top">
                                <!-- main table start -->
                                <table width="782" height="100%" border="0" cellpadding="10" cellspacing="1" bgcolor="D6D6D6">
                                    <tr>
                                        <td align="center" valign="top" bgcolor="#FFFFFF">
                                            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                <tr>
                                                    <td height="33"><font color="313D7D"><img src="../odimages/odmain/title_icon.gif" width="13" height="13" hspace="1" align="absmiddle"> 주문관리 &gt; <span class="st">배송 주문 목록</span></font></td>
                                                </tr>
                                                <tr>
                                                    <td height="2" bgcolor="D6D6D6"></td>
                                                </tr>
                                            </table>
                                            <table width="100%" border="0" cellspacing="1" cellpadding="0">
                                                <tr>
                                                    <td height="5"></td>
                                                </tr>
                                            </table>
                                            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                <tr>
                                                    <td height="18"><font color="313D7D"><img src="../odimages/odmain/tex_icon.gif" width="5" height="11" hspace="5"><b>주문번호를 클릭</b>하시면 주문 상세페이지(주문정보수정)를 보실 수 있습니다.</font></td>
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

                                                <table width="760" border="0" cellspacing="0" cellpadding="0">
                                                    <tr>
                                                        <td colspan="7"><img src="../odimages/odmain/search_piece1.gif" width="760" height="8"></td>
                                                    </tr>
                                                    <tr>
                                                        <td width="6" background="../odimages/odmain/search_bg1.gif">&nbsp;</td>
                                                        <td >
                                                            <table border=0 cellpadding=0 cellspacing=0 width=358>
                                                                <tr>
                                                                    <td style='font-family:돋움체' height=22 colspan=2>&nbsp;
                                                                    <img src="../odimages/odmain/tex_icon.gif" width="5" height="11" hspace="5">기&nbsp;&nbsp;간 :
                                                                    <?=!$start_date ? "전체" :
                                                                    substr($start_date,2,2)."년 ".substr($start_date,4,2)."월 ".substr($start_date,6,2)."일 "." ~ ".
                                                                    substr($end_date,2,2)."년 ".substr($end_date,4,2)."월 ".substr($end_date,6,2)."일 "?>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td style='font-family:돋움체' height=22 width=50%>&nbsp;
                                                                    <img src="../odimages/odmain/tex_icon.gif" width="5" height="11" hspace="5">판매가 : <?=number_format($resPrice99);?>원
                                                                    </td>
                                                                    <td style='font-family:돋움체' height=22 width=50%>
                                                                    <img src="../odimages/odmain/tex_icon.gif" width="5" height="11" hspace="5">수수료 : <?=number_format($resPrice99-$resComPrice99);?>원
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td style='font-family:돋움체' height=22>&nbsp;
                                                                    <img src="../odimages/odmain/tex_icon.gif" width="5" height="11" hspace="5">수&nbsp; 량 : <?=number_format($resSaleCnt99);?>개
                                                                    </td>
                                                                    <td style='font-family:돋움체' height=22>
                                                                    <img src="../odimages/odmain/tex_icon.gif" width="5" height="11" hspace="5">결제금 : <?=number_format($resComPrice99);?>원
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                        </td>
                                                        <td width=1 bgcolor="#cccccc"></td>
                                                        <td width="370" style="padding:10px;">
                                                            <!-- search form start -->
                                                            <table width="350" border="0" cellspacing="1" cellpadding="0">
                                                                <form name="view" method="get" action="od_dlv_orderslist.php" onsubmit="return view_submit()">
                                                                    <input type="hidden" name="search_value_" value="true">
                                                                    <!--
                                                                    <input type="hidden" name="search" value="<?=$search?>">
                                                                    <input type="hidden" name="key" value="<?=$key?>">
                                                                    -->
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
                                                                                    <input id=ipt01 type="text" name="start_date" size="8" class="border" maxlength="8" value="<?=$start_date?>" onchange="strreplace(this)" readonly style='cursor:pointer'>
                                                                                    ~
                                                                                    <input id=ipt02 type="text" name="end_date" size="8" class="border" maxlength="8" value="<?=$end_date?>" onchange="strreplace(this)" readonly style='cursor:pointer'>
                                                                                    <script>var cal1 = new jsCalendar(document.getElementById('ipt01'));</script>
                                                                                    <script>var cal1 = new jsCalendar(document.getElementById('ipt02'));</script>
                                                                                    &nbsp;
                                                                                    &nbsp;
                                                                                    &nbsp;
                                                                                    &nbsp;
                                                                                    </td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td valign="top"><img src="blank.gif" width="67" height="1">
                                                                                    <input type="radio" name="date_term" value="t0" onclick="set_date('t',0)" <?if($date_term=="t0")echo" checked";?>>오늘
                                                                                    <input type="radio" name="date_term" value="d15" onclick="set_date('d',15)" <?if($date_term=="d15")echo" checked";?>>15일
                                                                                    <input type="radio" name="date_term" value="w0" onclick="set_date('w',0)" <?if($date_term=="w0")echo" checked";?>>전체&nbsp;&nbsp;
                                                                                </td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td valign="top">
                                                                                    <img src="../odimages/odmain/tex_icon.gif" width="5" height="11" hspace="5">출력갯수&nbsp;&nbsp;
                                                                                    <select name="page_number" onchange="this.form.submit()">
                                                                                    <option value="10" <?=$page_number == "10" ? "selected" : NULL;?>>10</option>
                                                                                    <option value="20" <?=$page_number == "20" ? "selected" : NULL;?>>20</option>
                                                                                    <option value="30" <?=$page_number == "30" ? "selected" : NULL;?>>30</option>
                                                                                    <option value="50" <?=$page_number == "50" ? "selected" : NULL;?>>50</option>
                                                                                    <option value="70" <?=$page_number == "70" ? "selected" : NULL;?>>70</option>
                                                                                    <option value="100" <?=$page_number == "100" ? "selected" : NULL;?>>100</option>
                                                                                    <option value="200" <?=$page_number == "200" ? "selected" : NULL;?>>200</option>
                                                                                    <option value="500" <?=$page_number == "500" ? "selected" : NULL;?>>500</option>
                                                                                    <option value="999999" <?=$page_number == "999999" ? "selected" : NULL;?>>전체</option>
                                                                                    </select>
                                                                                </td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td valign="top">
                                                                                    <img src="../odimages/odmain/tex_icon.gif" width="5" height="11" hspace="5">정렬기준&nbsp;&nbsp;
                                                                                    <select name="orderbyName" onchange="this.form.submit()">
                                                                                        <option value="">결제일시</option>
                                                                                        <option value="recname" <?=$orderbyName == "recname" ? "selected" : NULL;?>>수령인</option>
                                                                                    </select>
                                                                                    <select name="orderbyType" onchange="this.form.submit()">
                                                                                        <option value="desc" <?=$orderbyType == "desc" ? "selected" : NULL;?>>내림</option>
                                                                                        <option value="asc" <?=$orderbyType == "asc" ? "selected" : NULL;?>>오름</option>
                                                                                    </select>

                                                                                </td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td valign="top">
                                                                                    <img src="../odimages/odmain/tex_icon.gif" width="5" height="11" hspace="5">발급상태&nbsp;&nbsp;
                                                                                    <select name="delivstatus" onchange="this.form.submit()">
                                                                                        <option value="">전체</option>
                                                                                        <option value="no" <?=$delivstatus == "no" ? "selected" : NULL;?>>배송대기</option>
                                                                                        <option value="yes" <?=$delivstatus == "yes" ? "selected" : NULL;?>>배송완료</option>
                                                                                    </select>
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
                                                        <td></td>
                                                        <td width="6" background="../odimages/odmain/search_bg2.gif">&nbsp;</td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="7"><img src="../odimages/odmain/search_piece2.gif" width="760" height="8"></td>
                                                    </tr>
                                                </table>
                                            <table width="760" border="0" cellspacing="1" cellpadding="0">
                                                <tr>
                                                    <td>&nbsp;</td>
                                                </tr>
                                            </table>
                                            <table width="760" border="0" cellspacing="0" cellpadding="0">
                                                <tr>
                                                    <td valign="top">
                                                        <table width="760" border="0" cellspacing="0" cellpadding="0">
                                                            <!-- all delete form start -->
                                                            <form name="OderAllDelete" method="post" action="od_dlv_orderalldelete.php">
                                                                <input type="hidden" name="PageL" value="All">
                                                                <input type="hidden" name="page" value="<?=$page?>">
                                                                <input type="hidden" name="par_page" value="<?=$par_page?>">
                                                            <tr>
                                                                <td>
                                                                    <img src="../odimages/odmain/page_icon.gif" width="14" height="11">
                                                                    <font color="3960AC">전체 <b><?=$TotalPage?></b>페이지 [<b><?=$total?></b>]개</font>
                                                                </td>
                                                                <td align="right">
                                                                    <img src="../odimages/odmain/btn_express.gif" onclick="express()" style='cursor:hand;' onfocus='this.blur();'>
                                                                    <!-- 엑셀저장 -->
                                                                    <img src="../odimages/odmain/btn_excel.gif" width="77" height="24" onclick="<?=$excelTemp1?>" style='cursor:hand;' onfocus='this.blur();'>
																</td>
                                                            </tr>
                                                        </table>
                                                        <table width="760" border="0" cellspacing="0" cellpadding="0">
                                                            <tr>
                                                                <td height="1" colspan="12" bgcolor="c0bebe"></td>
                                                            </tr>
                                                            <tr align="center">
                                                                <td width="40" height="27" bgcolor="ececec" class="white">번호</td>
                                                                <td width="30" bgcolor="ececec" class="white"><a onclick="selectAll();" onfocus='this.blur();' style='cursor:hand;'>전체</a></td>
                                                                <td width="60" bgcolor="ececec" class="white">수령인</td>
                                                                <td bgcolor="ececec" class="white">상품명</td>
                                                                <td width="40" bgcolor="ececec" class="white">수량</td>
                                                                <td width="100" bgcolor="ececec" class="white">전화번호</td>
                                                                <td width="75" bgcolor="ececec" class="white">배송상황</td>
                                                                <td width="135" bgcolor="ececec" class="white">배송정보<br>
                                                                    <select name="expressSet">
                                                                        <option value=''>택배사 일괄선택</option>
<?
    for($k=0;$k<count($array_delivery);$k++) {
        echo "<option value='".$array_delivery[$k]."' >".$array_delivery[$k]."</option>";
    }
?>
                                                                    </select>
                                                                    <input type="button" value="▼일괄적용" onclick="expressSetFun(this.form)">

                                                                </td>
                                                                <td width="75" bgcolor="ececec" class="white">결제일시</td>
                                                            </tr>
                                                            <tr>
                                                                <td height="1" colspan="12" bgcolor="c0bebe"></td>
                                                            </tr>
                                                            <tr>
                                                                <td height="2" colspan="12"></td>
                                                            </tr>
                                                        </table>


                                                        <table width="760" border="0" cellspacing="0" cellpadding="0">
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

		if($row[orderemail]) $_ordername_ = "$row[recname]";
		else $_ordername_ = $row[ordername];


        if($row[paymethod] == "B") $_paymethod_ = "은행";

        else if($row[paymethod] == "L") $_paymethod_ = "실시간";

        else if($row[paymethod] == "H") $_paymethod_ = "핸드폰";


        ## 에스크로 시작
        else if($row[paymethod] == "E") $_paymethod_ = "<font color='#ee0000'>에스크로</font>";
        ## 에스크로 끝

        else $_paymethod_ = "카드";

        if($row[paystatus] == "Y") $_paystatus_ = "<font color='red'><b>결제확인</b></font>";
        else $_paystatus_ = "결제전";


        if($row[delivstatus] == "yes") {
            $_delivstatus_ = "<font color='red'><b>발급완료</b></font>";
        }
        else {
            $_delivstatus_ = "발급대기";
        }

        $orderdate = date("m.d",strtotime($row[orderdate]));

        if($row[canceled] == "N") {
            $cancelTemp = "<a href='od_dlv_ordercancel.php?ordernum=$row[ordernum]&page=$page$par_page'><img src='../odimages/cancel_icon.gif' border='0' alt='주문취소처리'></a>";
        }
        else {
            $cancelTemp = "-";
        }

        if(!$row[orderid] || $row[orderid] == "guest") $orderNumber = $row[ordernum];
        else $orderNumber = "<b>".$row[ordernum]."</b>";

        ## 접근권한 설정(수정)
        $modifyTemp1 = "od_dlv_ordermodify.php?Form=OrderModify&ordernum=$row[ordernum]&PageL=All&page=$page$par_page";


        # 상품 공급가 계산
        unset($_payPrice_,$productList,$countList);
        $oLogArray3 = explode("^",preg_replace("[^\^]","",$row[oLog]));
        $pLogArray3 = explode("^",$row[pLog]);
        for($z=0;$z<count($pLogArray3);$z++) {
            $pLogArray4 = explode("|",$pLogArray3[$z]);
            if($pLogArray4[0]) {
                $purPrice4 = mysql_fetch_array(mysql_query("select name,purPrice from odtProduct where code ='".$pLogArray4[0]."'"));
                $_payPrice_ += $purPrice4[purPrice] * $pLogArray4[1];
                $productList    .= $productList ? "<br>".$purPrice4[name] : $purPrice4[name];
                $countList      .= $countList ? "<br>".$pLogArray4[1] : $pLogArray4[1];

				# 옵션값 추출
				if($oLogArray3[$z]) {   // 해당상품에 대한 옵션내역이 있으면
					$oLogTmp = explode("|",$oLogArray3[$z]);
					$productList .= " (옵션:".$oLogTmp[1].")";
				}

            }
        }


    unset($expressSelect);
    for($k=0;$k<count($array_delivery);$k++) {
        $expressSelect .= "<option value='".$array_delivery[$k]."' ".($row[expressname] == $array_delivery[$k] ? "selected" : NULL).">".$array_delivery[$k]."</option>";
    }

		echo "
															<tr> 
																<td width='40' align='center' bgcolor='FAFAFA'>$serialnumber</td>
																<td width='30' align='center' bgcolor='FAFAFA'><input type='checkbox' name='OrderNum[]' value='$row[ordernum]' checked></td>
																<td width='60' align='center' bgcolor='FAFAFA' class='cate'><a href='$modifyTemp1'>$_ordername_</a></td>
																<td  bgcolor='FAFAFA' class='cate'><a href='$modifyTemp1'>$productList</a></td>
																<td width='40' align='center' bgcolor='FAFAFA' class='cate'>$countList</td>
																<td width='100' align='center' bgcolor='FAFAFA' style='padding-top:3;'>
																	$row[ordertel1]-$row[ordertel2]-$row[ordertel3]<br>$row[orderhtel1]-$row[orderhtel2]-$row[orderhtel3]</td>
																<td width='80' align='center' bgcolor='FAFAFA'><font color='#138CE5'>$_delivstatus_</font></td>
																<td width='130' align='center' bgcolor='FAFAFA'>
																	<input type='hidden' name='OrderNumValue[]' value='$row[ordernum]'>
																	<input type='hidden' name='setTmp[]' value='".trim($row[expressnum])."'>
																	<select name=expressname[] class=border>
																		<option value=''>택배사 선택</option>
																	$expressSelect
																	</select><br>
																	<input type=text name=expressnum[] class=border size=12 value='".$row[expressnum]."'>
																</td>
																<td width='80' align='center' bgcolor='FAFAFA'><font color='#138CE5'>".date('m.d H:i',strtotime($row[paydate]))."</font></td>
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
                                                                    <a href='od_dlv_orderslist.php?page=1<?=$par_page?>'>
                                                                    <img src="../odimages/odmain/num_arrow_pre2.gif" width="13" height="11" border='0' alt="처음페이지" align="absmiddle"></a>
<?PHP
    $TotalJump = ceil($TotalPage / $LinkNumber);
    $Jump = ceil($page / $LinkNumber);
    $FirstPage = ($Jump - 1) * $LinkNumber;
    $LastPage = $Jump * $LinkNumber;

    if($Jump >= $TotalJump) $LastPage = $TotalPage;

    if($Jump > 1) {
        $PrePage = $FirstPage;
        echo "<a href='od_dlv_orderslist.php?page=$PrePage$par_page'><img src='../odimages/odmain/num_arrow_pre1.gif' width='35' height='11' hspace='3' border='0' alt='이전 ${LinkNumber}개'></a> / ";
    }
    else {
        echo " / ";
    }

    for($NowPage = $FirstPage+1; $NowPage <= $LastPage; $NowPage++) {
        if($page == $NowPage) echo "<b>$NowPage</b> / ";
        else echo "<a href='od_dlv_orderslist.php?page=$NowPage$par_page'>$NowPage</a> / ";
    }

    if($Jump < $TotalJump) {
        $PrePage = $LastPage+1;
        echo "<a href='od_dlv_orderslist.php?page=$PrePage$par_page'><img src='../odimages/odmain/num_arrow_next2.gif' width='35' height='11' hspace='3' border='0' alt='다음 ${LinkNumber}개'></a>";
    }
?>
                                                                    <a href='od_dlv_orderslist.php?page=<?=$TotalPage?><?=$par_page?>'>
                                                                    <img src="../odimages/odmain/num_arrow_next1.gif" width="13" height="11" border='0' alt="마지막페이지" align="absmiddle"></a>
                                                                </td>
                                                                <td width="270" align="right">
                                                                    <img src="../odimages/odmain/btn_express.gif" onclick="express()" style='cursor:hand;' onfocus='this.blur();'>
                                                                    <!-- 엑셀저장 -->
                                                                    <img src="../odimages/odmain/btn_excel.gif" width="77" height="24" onclick="<?=$excelTemp1?>" style='cursor:hand;' onfocus='this.blur();'>
																</td>
                                                            </tr>
                                                        </table>
                                                        <table width="760" border="0" cellspacing="0" cellpadding="0">
                                                            <tr>
                                                                <td height="37" align="center">
                                                                    <table border="0" cellspacing="2" cellpadding="0">
                                                                        <!-- form start ----------------------------------------->
                                                                        <form method="post" action="od_dlv_orderslist.php">
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
                                                        <table width="760" border="0" cellspacing="1" cellpadding="0">
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
                <td height="83" bgcolor="ffffff">
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