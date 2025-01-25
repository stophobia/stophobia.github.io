<?
############################################################
## Onedaynet RSS 데이터정보 : Ver 0.1-beta-
## Create by Tindevil@nate.com
## BetaVersion
############################################################
## 자유로운 편집 및 사용이 가능합니다. 제작자주석삭제는 허락하지 않습니다.
############################################################
#                   치환자 설명 ver 0.1-beta-
############################################################
# 하단의 REPLACE 정보를 참고하세요.
############################################################

##INCLUDE
include "addon.php";

##솔루션의 형태를 파악한다 odt 와 sns 두종류가있음
function get_slntype() {
    $retval = "odt";
    if ( getRowCount("show tables like 'snsProduct'")*1 > 0 ) 
    {
        $retval = "sns";
    }
    return $retval;
}
//echo "<br>slntype->".$slntype;

##판매종료패치확인
function get_datepatch($slntype) {
    return getRowCount("show columns from ".$slntype."Product where Field in ('sale_enddate')")*1;
    //echo "<br>datepatch->".$datepatch;
}

// TEXT 형식으로 변환
function get_html($str)
{
    $str = str_replace("&gt;", ">", $str);
    $str = str_replace("&lt;", "<", $str);
    $str = str_replace("&amp;", "&", $str);
    $str = str_replace("&quot;", "\"", $str);
    return $str;
}


##현재판매되는 상품을 찾기(미래상품은 제외됨)
function CurrentItem($cateCode,$slntype,$datepatch) {
    $today = date('Y-m-d');
    $que = "select code from ".$slntype."Product ";
    $que .= "where code = parent_code and cateCode = '$cateCode' and sale_date <= '$today' ";

    if ($datepatch) {
       $que .= " and sale_enddate >= '$today'";
    }

    $que = $que."order by sale_date desc limit 1";
    $res = mysql_query($que);
    return @mysql_result($res,0);
}

##판매종료일을 찾기위함
function getNextDate($sale_date,$end_date,$datepatch,$changeTime) {

    if ($datepatch) {   //종료일자패치되었다면 종료일을 사용

        if ($sale_date == $end_date) {  //같은날이면 동일날을 표시
            $NextDay = $end_date;
        } else {    //다른날이면
            $SaleTime = mktime(0,0,0,substr($end_date,5,2),substr($end_date,8,2),substr($end_date,0,4));
            if ($changeTime=="00") {
                $NextDay = date("Y-m-d",mktime(0,0,0,date("m",$SaleTime),date("d",$SaleTime)-1,date("Y",$SaleTime)));
            } else {
                $NextDay = date("Y-m-d",mktime(0,0,0,date("m",$SaleTime),date("d",$SaleTime),date("Y",$SaleTime)));
            }    
        }
        return $NextDay;

    } else {    //다음날로지정
        $SaleTime = mktime(0,0,0,substr($sale_date,5,2),substr($sale_date,8,2),substr($sale_date,0,4));
        if ($changeTime=="00") {
            $NextDay = date("Y-m-d",mktime(0,0,0,date("m",$SaleTime),date("d",$SaleTime),date("Y",$SaleTime)));
        } else {
            $NextDay = date("Y-m-d",mktime(0,0,0,date("m",$SaleTime),date("d",$SaleTime)+1,date("Y",$SaleTime)));
        }

        return $NextDay;
    }
}


##반복구문생성
function RunLoop($content) {

    $slntype = get_slntype();       //솔루션형태 odt,sns
    $datepatch = get_datepatch($slntype);   //판매종료패치여부

    ##상점기본정보
    $basic = getRow("SELECT * FROM ".$slntype."Setup");  //상점기본설정
    $CHG_HOUR = $basic[changeTime]; //상품변경시간
    $CHG_HOURE = $basic[changeTime]*1-1; //상품변경종료시간
    if ($CHG_HOURE == -1) $CHG_HOURE =23;

    $company =getRow("SELECT * FROM ".$slntype."Company");  //회사기본설정
    if ("" == $CHG_HOUR || "0" == $CHG_HOUSR) $CHG_HOUR = "00";
    if ("" == $CHG_HOURE || "0" == $CHG_HOURE) $CHG_HOURE = "00";


    $TITLE = $company[homepage_title]; //홈페이지타이틀
    $LOGO = ""; //회사로고
    $BEG_DATE = "";                  //쿠폰시작일
    $PTYPE = "쿠폰";    //상품타입(쿠폰,상품)
    $CATEID = "";       //카테고리ID(미확인)
    $KEYWORD = "";      //키워드(미확인)
    $DESC_URL = "";     //상세설명 주소
    

    $CQuery  = "select catecode,catename from ".$slntype."Category where cHidden = 'no' order by catecode asc  ";
    $CResult = mysql_query($CQuery);

    $buffer = $content;
    while ($CRecord = mysql_fetch_array($CResult))
    {
        $content = $buffer;
        $AID = $CRecord[catecode];      //지역코드	
        $ANAME = $CRecord[catename];    //지역명
        
       
        ##해당지역의 현재 판매되어야할 아이템을 찾는다.
        $PID = CurrentItem($AID,$slntype,$datepatch);
        if(!$PID) continue;

        ##해당상품정보를 가져옴
        $Prow = getRow("select * from ".$slntype."Product where code ='".$PID."'");
        $PNAME = $Prow[mainName] ? $Prow[mainName] : $Prow[name];    //메인상품명이없을경우 해당상품명을 사용

        $SUP_IMAGE = $Prow[onecut_img]; //공급업체매장위치
        $DETAIL = $Prow[comment2]; //상품상세설명

        $MAINNAME = $Prow[mainName];    //메인상품명
        $SUBNAME = $Prow[name]; //서브상품명
        $STOCK = $Prow[stock];

        if( $STOCK < 1 || $PNAME == "") continue; //재고가없거나 상품명이 없을경우 PASS

        $BUYLIMIT = $Prow[buy_limit];   //구매제한수
        $CATEGORY = $Prow[rsscate];     //카테고리명(미확인)

        $PPID = $Prow[parent_code];     //쿠폰 상위 상품코드
        $PIMG = $Prow[main_img];        //쿠폰 메인 이미지
        if ( $PIMG ) $PIMG ="http://$_SERVER[HTTP_HOST]".$PIMG; //주소값붙인다.

        $PMSG = $Prow[message];         //쿠폰 설명

        $LINK = "http://".$_SERVER[HTTP_HOST]."/?cateCode=$AID&viewCode=$PID";

        $PRICEO = $Prow[price_org];     //판매가(원가)
        $PRICES = $Prow[price];         //판매가(할인가)
        $PRICER = $Prow[price_per];     //할인율

        $CNTMIN = $Prow[saleCntMax];    //목표도달인원
        $CNTSALE = $Prow[saleCnt];      //판매수량
        $CNTMAX = $CNTSALE*1+$STOCK*1;    //재고량+판매량
        $COMMENT2 = $Prow[comment2];    //상품상세설명

        $STT_DATE = $Prow[sale_date];    //판매시작일
        $END_DATE = $Prow[sale_enddate];    //판매종료일
        $END_DATE = getNextDate($STT_DATE,$END_DATE,$datepatch,$basic[changeTime]);       //판매종료일
        $EXP_DATE = $Prow[expire];                  //쿠폰만료일

        $NOW_DATETIME = date("Y-m-d H:i:s");                  //쿠폰만료일
        $NOW_DATETIMEH = date("Y-m-d H");                  //쿠폰만료일
        $NOW_DATETIMEHM = date("Y-m-d H:i");                  //쿠폰만료일

        $STT_DATETIME = $STT_DATE ? "$STT_DATE ".$CHG_HOUR.":00:00" : "";    //판매시작일(시분초)
        $STT_DATETIMEH = $STT_DATE ? "$STT_DATE ".$CHG_HOUR."" : "";    //판매시작일(시)
        $STT_DATETIMEHM = $STT_DATE ? "$STT_DATE ".$CHG_HOUR.":00" : "";    //판매시작일(시분)

        $END_DATETIME = $END_DATE ? "$END_DATE ".$CHG_HOURE.":59:59" : "";    //판매종료일
        $END_DATETIMEH = $END_DATE ? "$END_DATE ".$CHG_HOURE."" : "";    //판매종료일
        $END_DATETIMEHM = $END_DATE ? "$END_DATE ".$CHG_HOURE.":59" : "";    //판매종료일

        $BEG_DATETIME = $BEG_DATE ? "$BEG_DATE ".$CHG_HOUR.":00:00" : "";    //쿠폰시작
        $BEG_DATETIMEH = $BEG_DATE ? "$BEG_DATE ".$CHG_HOUR."" : "";    //
        $BEG_DATETIMEHM = $BEG_DATE ? "$BEG_DATE ".$CHG_HOUR.":00" : "";    //

        $EXP_DATETIME = $EXP_DATE ? "$EXP_DATE ".$CHG_HOURE.":59:59" : "";    //쿠폰만료
        $EXP_DATETIMEH = $EXP_DATE ? "$EXP_DATE ".$CHG_HOURE."" : "";    //
        $EXP_DATETIMEHM = $EXP_DATE ? "$EXP_DATE ".$CHG_HOURE.":59" : "";    //

        //종료일자가 현재보다 과거일경우에는 나오지않도록한다.
        $end_time_data = mktime(substr($END_DATETIME,11,2),substr($END_DATETIME,14,2),substr($END_DATETIME,17,2),
substr($END_DATETIME,5,2),substr($END_DATETIME,8,2),substr($END_DATETIME,0,4));
        if ($end_time_data < mktime() ) continue;

        //공급업체정보
        $SupplyInfo = getRow("select address,cName,tel1,tel2,tel3 from ".$slntype."Member where id='".$Prow[customerCode]."'");
        $SUP_ADDRESS = $SupplyInfo[address];    //업체주소
        $SUP_NAME = $SupplyInfo[cName];          //업체명
        $SUP_TEL1 = $SupplyInfo[tel1];          //업체전화번호1
        $SUP_TEL2 = $SupplyInfo[tel2];          //업체전화번호2
        $SUP_TEL3 = $SupplyInfo[tel3];          //업체전화번호3


        ##데이터치환
        $content = str_replace("{##AID##}",$AID,$content);              //지역코드
        $content = str_replace("{##ANAME##}",$ANAME,$content);          //지역코드명
        $content = str_replace("{##PID##}",$PID,$content);              //상품코드
        $content = str_replace("{##PNAME##}",$PNAME,$content);          //상품명
        $content = str_replace("{##PMSG##}",$PMSG,$content);            //상품정보
        $content = str_replace("{##PIMG##}",$PIMG,$content);            //상품이미지
        $content = str_replace("{##PPID##}",$PPID,$content);            //상품코드(부모코드)
        $content = str_replace("{##BUYLIMIT##}",$BUYLIMIT,$content);    //구매제한
        $content = str_replace("{##LINK##}",$LINK,$content);            //링크URL
        $content = str_replace("{##DETAIL##}",$DETAIL,$content);            //상품상세설명
        $content = str_replace("{##MAINNAME##}",$MAINNAME,$content);    //메인이름
        $content = str_replace("{##SUBNAME##}",$SUBNAME,$content);      //서브이름

        $content = str_replace("{##PRICEO##}",$PRICEO,$content);        //상품금액(원가)
        $content = str_replace("{##PRICES##}",$PRICES,$content);        //판매금액(할인가)
        $content = str_replace("{##PRICER##}",$PRICER,$content);        //할인율

        $content = str_replace("{##SUP_ADDRESS##}",$SUP_ADDRESS,$content);      //입점업체주소
        $content = str_replace("{##SUP_IMAGE##}",$SUP_IMAGE,$content);      //입점업체주소
        $content = str_replace("{##SUP_NAME##}",$SUP_NAME,$content);      //입점업체명
        $content = str_replace("{##SUP_TEL1##}",$SUP_TEL1,$content);        //공급업체전화1
        $content = str_replace("{##SUP_TEL2##}",$SUP_TEL2,$content);        //공급업체전화2
        $content = str_replace("{##SUP_TEL3##}",$SUP_TEL3,$content);        //공급업체전화3

        $content = str_replace("{##CNTMIN##}",$CNTMIN,$content);        //최소판매량(목표도달인원)
        $content = str_replace("{##CNTMAX##}",$CNTMAX,$content);        //최대판매량
        $content = str_replace("{##CNTSALE##}",$CNTSALE,$content);      //판매량
        $content = str_replace("{##STOCK##}",$STOCK,$content);          //상품재고

        $content = str_replace("{##STT_DATE##}",$STT_DATE,$content);    //판매시작일
        $content = str_replace("{##END_DATE##}",$END_DATE,$content);    //판매종료일
        $content = str_replace("{##EXP_DATE##}",$EXP_DATE,$content);    //쿠폰만료일
        $content = str_replace("{##BEG_DATE##}",$BEG_DATE,$content);    //쿠폰시작일

        $content = str_replace("{##CHG_HOUR##}",$CHG_HOUR,$content);    //상품변경시간
        $content = str_replace("{##CATEGORY##}",$CATEGORY,$content);    //카테고리명
        $content = str_replace("{##CATEID##}",$CATEID,$content);        //카테고리ID

        $content = str_replace("{##STT_DATETIME##}",$STT_DATETIME,$content);    //판매시작일
        $content = str_replace("{##STT_DATETIMEH##}",$STT_DATETIMEH,$content);    //판매시작일
        $content = str_replace("{##STT_DATETIMEHM##}",$STT_DATETIMEHM,$content);    //판매시작일

        $content = str_replace("{##END_DATETIME##}",$END_DATETIME,$content);    //판매종료일
        $content = str_replace("{##END_DATETIMEH##}",$END_DATETIMEH,$content);    //판매종료일
        $content = str_replace("{##END_DATETIMEHM##}",$END_DATETIMEHM,$content);    //판매종료일

        $content = str_replace("{##EXP_DATETIME##}",$EXP_DATETIME,$content);    //쿠폰만료일
        $content = str_replace("{##EXP_DATETIMEH##}",$EXP_DATETIMEH,$content);    //쿠폰만료일
        $content = str_replace("{##EXP_DATETIMEHM##}",$EXP_DATETIMEHM,$content);    //쿠폰만료일

        $content = str_replace("{##BEG_DATETIME##}",$BEG_DATETIME,$content);    //쿠폰시작일
        $content = str_replace("{##BEG_DATETIMEH##}",$BEG_DATETIMEH,$content);    //쿠폰시작일
        $content = str_replace("{##BEG_DATETIMEHM##}",$BEG_DATETIMEHM,$content);    //쿠폰시작일

        $content = str_replace("{##NOW_DATETIME##}",$NOW_DATETIME,$content);    //현재시간
        $content = str_replace("{##NOW_DATETIMEH##}",$NOW_DATETIMEH,$content);    //현재시간
        $content = str_replace("{##NOW_DATETIMEHM##}",$NOW_DATETIMEHM,$content);    //현재시간

        $content = str_replace("{##KEYWORD##}",$KEYWORD,$content);      //키워드

        $content = str_replace("{##LOGO##}",$LOGO,$content);            //회사로고
        $content = str_replace("{##DESC_ADDR##}",$DESC_URL,$content);   //상세설명주소

        $content = str_replace("{##PTYPE##}",$PTYPE,$content);          //상세설명주소

        $content = str_replace("{##RSSAREA1##}",$Prow[rssarea1],$content);          //지역정보
        $content = str_replace("{##RSSAREA2##}",$Prow[rssarea2],$content);          //지역정보-위치

        $content = str_replace("{##TITLE##}",$TITLE,$content);          //홈페이지타이틀

        echo $content;
    }   //end wile
}
?>