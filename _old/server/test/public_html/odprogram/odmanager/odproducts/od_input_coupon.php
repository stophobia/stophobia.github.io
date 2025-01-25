<?

    include "../../odcommon/od_config.inc.php";
    include "../../odcommon/od_lib.inc.php";
    include "../odcommon/od_function.inc.php";  
    include "../odcommon/od_adminAuthority.inc.php";
    include "../odcommon/od_head.inc.php";
    include "../odcommon/od_body.inc.php";

/*

// 네이버지도 추가에 따른 테이블 추가분 ///////////////////////////////////////
alter table odtProduct add com_juso varchar(255);
alter table odtProduct add com_name varchar(100);
alter table odtProduct add com_mapx int(7);
alter table odtProduct add com_mapy int(7);
alter table odtProduct add com_mapzoom int(2);

*/

    ## 접근권한 설정(대분류등록)
    if($row_admin[productLevel] == 5 || $row_admin[productLevel] == 9 || $row_admin[superLevel]==9) {
    }
    else {
        error_msgloc("../","접근권한이 없습니다.   ");
    }
    
    if(!$_GET[code]) {
        
        ## 코드 생성.
        $random = rand(10000,99999);
        $sumTme = (time(Y)+time(m)+time(d)+time(H)+time(i)+time(s)+19)*997;
        $sumTempLength = strlen($sumTme);
        $checkSum = substr($sumTme,$sumTempLength-2,2);
        $code = "S".$checkSum.$random;
        
        ## 등록양식 설정환경
        $brow = mysql_fetch_array(mysql_query("SELECT * FROM odtFormat WHERE serialnum=1"));

    } else {

        $que = "select * from odtProduct where code = '".$_GET[code]."'";
        $res = mysql_query($que);
        $row = mysql_fetch_array($res);

    }

    //-------------------------------------------------------------------------
    // 스킨에 따른 처리 부분 START
    //-------------------------------------------------------------------------

    // 스킨정보 추출 //////////////////////////////////////////////////////////
    $row_skin = mysql_fetch_array(mysql_query("SELECT * FROM odtSetup WHERE serialnum='1'"));
    $P_SKIN = $row_skin[P_SKIN] ? $row_skin[P_SKIN] : 1;

    // 스킨에 따른 이미지 사이즈 txt파일에서 읽어오기 ///////////////////////// 
    $size_line = file($_SERVER[DOCUMENT_ROOT]."/pages/skin/$P_SKIN/img_size.txt"); 

    //-------------------------------------------------------------------------
    // 스킨에 따른 처리 부분 END
    //-------------------------------------------------------------------------

    $cateCode = $row[cateCode] ? $row[cateCode] : $cateCode;
    if($row[sale_date]) $sale_date = $row[sale_date];
    else if($calDate) $sale_date = $calDate;
    else $sale_date = date('Y-m-d');

    if($row[sale_enddate] && $row[sale_enddate]<>'0000-00-00') $sale_enddate = $row[sale_enddate];
    else $sale_enddate = date('Y-m-d',strtotime("+1 day"));

?>

        <script language="javascript">
            function valueCheck(form) {

//              d=myEditor.document.body.createTextRange();
//              form.description2.value=d.htmlText;

                if(!form.code.value) {
                    alert("상품코드를 입력하셔야 합니다.   ");
                    form.code.focus();
                    return false;
                }
                if(!form.name.value) {
                    alert("상품이름을 입력하셔야 합니다.   ");
                    form.name.focus();
                    return false;
                }
                if(!form.customerCode.value) {
                    alert("공급업체를 입력하셔야 합니다.   ");
                    customerWin();
                    return false;
                }


            }

            function snsWindow(name,url,width,height,scrollbar,resizable,status) {
                window.open(url,name,'width='+width+',height='+height+',scrollbars='+scrollbar+',resizable='+resizable+',status='+status);
            }
            function valueMouseDown(fieldTemp,type) {
                if(!fieldTemp.value && type) fieldTemp.value = fieldTemp.defaultValue;
            }
            function valueMouseOver(fieldTemp,type) {
                if(fieldTemp.value == fieldTemp.defaultValue && type) fieldTemp.value = '';
            }
            function valueMouseNone(fieldTemp,type) {
                if(!fieldTemp.value && type) fieldTemp.value = fieldTemp.defaultValue = '';
            }
            function delField(objTemp) {
                objTemp.value='';
            }
            function optionWin() {
                window.open('od_option3modify.php?formname=snsForm&option3='+document.snsForm.option3.value,'optionUpdate', 'width=440, height=400, scrollbars=yes');
            }
            function relationWin() {
                window.open('od_relation.php?formname=inputForm&relation_procode='+document.snsForm.relation.value,'relation', 'width=600, height=700, scrollbars=yes');
            }
            function customerWin() {
                  window.open('od_customer.php','customer','resizable=yes,scrollbars=yes,width=420,height=410'); 
            }

            // 현재 선택한 카테고리와 날짜를 체크하여 메인상품인지 서브상품인지 체크
            function mainOrSubCheck() {
                frm = document.snsForm;
                //hidden_frame.location.href="./od_mainOrSubCheck.php?cateCode="+frm.cateCode.value+"&sale_date="+frm.sale_date.value;
                hidden_frame.location.href="./od_mainOrSubCheck.php?code="+frm.code.value+"&cateCode="+frm.cateCode.value+"&sale_date="+frm.sale_date.value+"&sale_enddate="+frm.sale_enddate.value;
            }
            function add_menu() 
            {  
                objTbl = document.getElementById("proOption"); 
                objRow = objTbl.insertRow(objTbl.rows.length); 

                // 이름
                objCell = objRow.insertCell(0); 
                objCell.innerHTML = "<input type='text' name='optionName[]' class='border' size='20'  value=''>"; 
                objCell.align           =   "center";

                // 공급가
                objCell = objRow.insertCell(1); 
                objCell.innerHTML = "<input type='text' name='optionPurPrice[]' class='border' size='10' value=''>"; 
                objCell.align           =   "center";

                // 판매가
                objCell = objRow.insertCell(2); 
                objCell.innerHTML = "<input type='text' name='optionPrice[]' class='border' size='10' value=''>"; 
                objCell.align           =   "center";
            } 
            function add_file() 
            {  
                objTbl = document.getElementById("proFile"); 
                objRow = objTbl.insertRow(objTbl.rows.length); 

                // 기술서 파일
                objCell = objRow.insertCell(0); 
                objCell.innerHTML = "&nbsp;<input type=\"file\" name=\"proFile[]\" class=\"border\" size=\"40\">"; 

            } 

        function saleType(frm) {
            if(frm.comSaleType[0].checked == true) {
                document.getElementById('comSaleTypeTr1').style.display='';
                document.getElementById('comSaleTypeTr2').style.display='none';
            } else {
                document.getElementById('comSaleTypeTr2').style.display='';
                document.getElementById('comSaleTypeTr1').style.display='none';
            }
        }
        function epLengthCheck(obj) {

            var len = 0; 
              
            for (var i=0; i<obj.value.length; i++) {
                if ( obj.value.substr(i, 1) > '~' ) {
                    len+=2;
                } 
                else {
                    len++;
                }
            }

            document.getElementById('epHTML').innerHTML = "<font color=green>"+len+"자</font>";

        }

        

        function chk_message(form){
            if(form.message.value == "메시지 입력"){
                form.message.value="";
                message_len_id.innerHTML="0";
                form.message.focus();
            }
        }

        function check_length(form){
            var len=str_length(form);

            if(len>80){
                alert('80바이트 이내로 쓰셔야 해요');
                return false;
            }
                
            message_len_id.innerHTML=len;
        }

        function str_length(form) {
            if ( navigator.appCodeName != 'Mozilla' ) {
                return form.message.value.length;
            }
          
            var len = 0; 
          
            for (var i=0; i<form.message.value.length; i++) {
                if ( form.message.value.substr(i, 1) > '~' ) {
                    len+=2;
                } 
                else {
                    len++;
                }
            }
          
            return len;
        }

        </script>

        <!-- 도움말 관련 스크립트 -->
<? include "od_help.php"; ?>
        <!-- 도움말 관련 스크립트 -->


        <table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="FFFFFF">
            <tr> 
                <td height="80" bgcolor="#FFFFFF">
                    <!-- top menu start -->
<? include "../odcommon/od_topMenu.inc.php"; ?>
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
<? include "../odcommon/od_leftMenu.inc.php"; ?>
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
                                                    <td height="33"><font color="313D7D"><img src="../odimages/odmain/title_icon.gif" width="13" height="13" hspace="1" align="absmiddle"> 상품관리 &gt; <span class="st">상품 등록 및 수정 </span></font>
                                                    &nbsp;&nbsp;<font color='red' style='font-size:9pt'>( 스킨에 따라 이미지 사이즈가 다르니 필히 확인 하십시오 )</font></td>
                                                </tr>
                                                <tr> 
                                                    <td height="2" bgcolor="D6D6D6"></td>
                                                </tr>
                                            </table>


                                            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                <tr> 
                                                    <td height="3"></td>
                                                </tr>
                                            </table>

                                            <iframe name="hidden_frame" src="about:blank" width=300 height=300 style="display:none;" frameborder=0></iframe>
                                            <table width="760" border="0" cellspacing="0" cellpadding="0">
                                                <tr> 
                                                    <td width="760" valign="top">
                                                        <table width="760" border="0" cellspacing="0" cellpadding="0">
                                                            <!-- form start ---------------------------------------------->
                                                            <form name="snsForm" method="post" action="od_inputPro.php" enctype="multipart/form-data" target="hidden_frame" onSubmit="return valueCheck(this)">
                                                                <input type="hidden" name="subMode" value="<?=$_GET[code] ? "edt" : "ins";?>">
                                                                <input type="hidden" name="parent_code" value="<?=$row[parent_code] ? $row[parent_code] : $code;?>">
                                                            <tr> 
                                                                <td height="1" bgcolor="c0bebe"></td>
                                                                <td width="600" height="1" bgcolor="#D5D5D5"></td>
                                                            </tr>
                                                            <tr> 
                                                                <td width="160" bgcolor="ececec" class="white" style="padding:5px;" height="41"><img src="../odimages/odmain/table_icon.gif" width="5" height="11" hspace="5">담당 MD</td>
                                                                <td width="600" bgcolor="FAFAFA" style="padding:5px;"> 
                                                                    &nbsp;<select name="md_name" class="border">
<?
$mdQue = "select * from odtMD order by mdNo ASC";
$mdRes = mysql_query($mdQue);
while($mdRow = mysql_fetch_array($mdRes)) {
?>
                                                                    <option value="<?=$mdRow[mdName]?>" <?=$mdRow[mdName] == $row[md_name] ? "selected" : NULL;?>><?=$mdRow[mdName]?></option>
<?
}
?>
                                                                    </select>                                                                   
                                                                </td>
                                                            </tr>
                                                            
                                                            <tr> 
                                                                <td height="1" bgcolor="c0bebe"></td>
                                                                <td height="1" bgcolor="D2D2D2"></td>
                                                            </tr>
                                                            <tr> 
                                                                <td height="6" bgcolor="FFFFFF"></td>
                                                            </tr>
                                                            <tr> 
                                                                <td height="1" bgcolor="c0bebe"></td>
                                                                <td width="600" height="1" bgcolor="#D5D5D5"></td>
                                                            </tr>



                                                            <tr> 
                                                                <td width="160" bgcolor="ececec" class="white" style="padding:5px;" height="41"><img src="../odimages/odmain/table_icon.gif" width="5" height="11" hspace="5">판매일</td>
                                                                <td width="600" bgcolor="FAFAFA" style="padding:5px;"> 
                                                                    <img src="blank.gif" width="1" height="1">
                                                                    판매시작일 : <input id='ipt01' type="text" name=sale_date size=10 class="border" readonly style="cursor:hand" value="<?=$sale_date?>" onchange="mainOrSubCheck();" > <?=$_basicSetup[changeTime]?>시 
                                                                    ~ 
                                                                    판매종료일 : <input id='ipt02' type="text" name=sale_enddate size=10 class="border" readonly style="cursor:hand" value="<?=$sale_enddate?>" onchange="mainOrSubCheck();" > <?=$_basicSetup[changeTime]?>시
                                                                    <br>&nbsp;<span id="pro_type" style="color:red">(메인상품)</span>
                                                                    <script>var cal1 = new jsCalendar(document.getElementById('ipt01'));</script>
                                                                    <script>var cal2 = new jsCalendar(document.getElementById('ipt02'));</script>

                                                                </td>
                                                            </tr>
                                                            <tr> 
                                                                <td height="1" bgcolor="c0bebe"></td>
                                                                <td height="1" bgcolor="D2D2D2"></td>
                                                            </tr>
                                                            <tr> 
                                                                <td height="6" bgcolor="FFFFFF"></td>
                                                            </tr>
                                                            <tr> 
                                                                <td height="1" bgcolor="c0bebe"></td>
                                                                <td width="600" height="1" bgcolor="#D5D5D5"></td>
                                                            </tr>


                                                            <tr> 
                                                                <td width="160" bgcolor="ececec" class="white" style="padding:5px;" height="41"><img src="../odimages/odmain/table_icon.gif" width="5" height="11" hspace="5">배송기능</td>
                                                                <td width="600" bgcolor="FAFAFA" style="padding:5px;">
<?PHP
    ## 주문이 있을 경우 수정할 수 없음
    $app_cnt = 0;
    if(sizeof($row) > 0 ) {
        $sres = mysql_query(" select count(*) as cnt from odtOrder where pLog like '$row[code]%' ");
        $app_cnt = mysql_result($sres,0,0);
    }

    if( $app_cnt > 0 ) {
        if( $row[setup_delivery] =="Y" ) {
            echo "<b>배송기능적용</b>";
        }
        else {
            echo "<b>쿠폰판매</b>";
        }
        echo "&nbsp;&nbsp;(적용주문이 있어서 수정할 수 없습니다.)<br>";
	echo "<input type=\"hidden\" name=\"setup_delivery\" value=\"$row[setup_delivery]\">";
    }
    else {
        echo "<input type=\"checkbox\" name=\"setup_delivery\" value=\"Y\" ";
        echo ($row[setup_delivery]=="Y")?"checked":"";
        echo ">배송기능적용<br>";
    }
?>
                                                                    <br>&nbsp;*실물 상품을 판매하기 위해 배송기능을 적용하고자 할 경우 사용합니다.
                                                                    <br>&nbsp;*배송기능 적용 시 해당 상품의 주문정보는 쿠폰기능을 대체하여 택배송장번호와 배송정보로 변경됩니다.
                                                                    <br>&nbsp;<b>*주문이 있을 경우 수정할 수 없습니다.</b>
                                                                </td>
                                                            </tr>
                                                            <tr> 
                                                                <td height="1" bgcolor="c0bebe"></td>
                                                                <td height="1" bgcolor="D2D2D2"></td>
                                                            </tr>
                                                            <tr> 
                                                                <td height="6" bgcolor="FFFFFF"></td>
                                                            </tr>
                                                            <tr> 
                                                                <td height="1" bgcolor="c0bebe"></td>
                                                                <td width="600" height="1" bgcolor="#D5D5D5"></td>
                                                            </tr>


                                                            <tr> 
                                                                <td width="160" bgcolor="ececec" class="white" style="padding:5px;" height="41"><img src="../odimages/odmain/table_icon.gif" width="5" height="11" hspace="5">상품분류</td>
                                                                <td width="600" bgcolor="FAFAFA" style="padding:5px;"> 
<?
if($row[customerCode] == "onedaynet") {
?>

                                                                    <img src="blank.gif" width="1" height="1"><?=$row[cateName]?>
                                                                    <input type="hidden" name="cateCode" value="<?=$cateCode?>">
                                                                    <br><span style='color:red;font-size:11px;font-family:돋움'>( 상품공급서포트로 등록된 상품은 TODAY에서만 판매하실수 있습니다. )</span>

<?
} else {
?>
                                                                    <img src="blank.gif" width="1" height="1"><select name="cateCode" class="border" onchange="mainOrSubCheck();" >
    <?
    $res3 = mysql_query("select * from odtCategory where catecode >='07'");
    while($row3 = mysql_fetch_array($res3)) {
    ?>
                                                                        <option value="<?=$row3[catecode]?>" <?=$cateCode == $row3[catecode] ? "selected" : NULL;?>><?=$row3[catename]?></option>
    <?
    }
    ?>
                                                                    </select>
<?
}
?>
                                                                </td>
                                                            </tr>
                                                            <tr> 
                                                                <td height="1" bgcolor="c0bebe"></td>
                                                                <td height="1" bgcolor="D2D2D2"></td>
                                                            </tr>
                                                            <tr> 
                                                                <td height="6" bgcolor="FFFFFF"></td>
                                                            </tr>
                                                            <tr> 
                                                                <td height="1" bgcolor="c0bebe"></td>
                                                                <td width="600" height="1" bgcolor="#D5D5D5"></td>
                                                            </tr>


                                                            <tr style="display:none"> 
                                                                <td width="160" bgcolor="ececec" class="white" style="padding:5px;" height="41"><img src="../odimages/odmain/table_icon.gif" width="5" height="11" hspace="5">상품코드</td>
                                                                <!-- 에디터관련수정 시작 -->
                                                                <td width="600" bgcolor="FAFAFA" style="padding:5px;"> 
                                                                    &nbsp;<input type="text" name="code" class="proName" size="75" value="<?=$row[code] ? $row[code] : $code;?>" onkeyup="chk_code(snsForm)">
                                                                </td>
                                                                <!-- 에디터관련수정 끝 -->
                                                            </tr>
                                                            <tr style="display:none"> 
                                                                <td height="1" bgcolor="c0bebe"></td>
                                                                <td height="1" bgcolor="D2D2D2"></td>
                                                            </tr>
                                                            <tr style="display:none"> 
                                                                <td height="6" bgcolor="FFFFFF"></td>
                                                            </tr>
                                                            <tr style="display:none"> 
                                                                <td height="1" bgcolor="c0bebe"></td>
                                                                <td width="600" height="1" bgcolor="#D5D5D5"></td>
                                                            </tr>
                                                            <tr> 
                                                                <td width="160" bgcolor="ececec" class="white" style="padding:5px;" height="41"><img src="../odimages/odmain/table_icon.gif" width="5" height="11" hspace="5">대표상품이름</td>
                                                                <td width="600" bgcolor="FAFAFA" style="padding:5px;">
                                                                    &nbsp;텍스트 : <input type="text" name="mainName" class="proName" size="75" value="<?=$row[mainName]?>"><br>
                                                                    &nbsp;이미지 : <input type="file" name="mainNameImg" class="border" size="40" value="<?=$row[mainNameImg]?>"> <?=$size_line[0]?><br>                                 
<?
$imgName = "mainNameImg";
if($row[$imgName]) {
?>
                                                                    <a href="<?=$row[$imgName]?>" target="_blank"><img src="<?=$row[$imgName]?>" width=550 border=0 style='border:1px solid #dddddd'></a>
                                                                    <input type="hidden" name="<?=$imgName?>_org" value="<?=$row[$imgName]?>"><br>
                                                                    <input type="checkbox" name="<?=$imgName?>_del" value="Y"> 삭제
<?
}
?>
                                                            </tr>
                                                            <tr> 
                                                                <td height="1" bgcolor="c0bebe"></td>
                                                                <td height="1" bgcolor="D2D2D2"></td>
                                                            </tr>
                                                            <tr> 
                                                                <td height="6" bgcolor="FFFFFF"></td>
                                                            </tr>
                                                            <tr> 
                                                                <td height="1" bgcolor="c0bebe"></td>
                                                                <td width="600" height="1" bgcolor="#D5D5D5"></td>
                                                            </tr>
                                                            <tr> 
                                                                <td width="160" bgcolor="ececec" class="white" style="padding:5px;" height="41"><img src="../odimages/odmain/table_icon.gif" width="5" height="11" hspace="5">상품명</td>
                                                                <td width="600" bgcolor="FAFAFA" style="padding:5px;">
                                                                    &nbsp;<input type="text" name="name" class="proName" size="75" value="<?=$row[name]?>"> <font color='red'>특수문제 제외</font><br>
                                                                    
                                                                </td>
                                                            </tr>



                                                            <tr> 
                                                                <td width="160" bgcolor="ececec" class="white" style="padding:5px;" height="41"><img src="../odimages/odmain/table_icon.gif" width="5" height="11" hspace="5">상품 공급업체</td>
                                                                <td width="600" bgcolor="FAFAFA" style="padding:5px;"> 
<?
if($row[customerCode] == "onedaynet") {
?>
                                                                    &nbsp;<?=$row[customerCode]?><input type="hidden" name="customerCode" class="border" size="35" value="<?=$row[customerCode]?>" readonly><br>
<?
} else {
?>
                                                                    &nbsp;<input type="text" name="customerCode" class="border" size="35" value="<?=$row[customerCode]?>" readonly>
                                                                    <a href="javascript:customerWin();" class="cate">[공급업체조회]</a> <a href="/odprogram/odmanager/odcustomer/od_list.php" target="_blank">[공급업체등록]</a> <br>

<?
}
?>
                                                                    <img src="" width="1" height="3"></td>
                                                            </tr>
                                                            <tr> 
                                                                <td height="1" bgcolor="c0bebe"></td>
                                                                <td height="1" bgcolor="D2D2D2"></td>
                                                            </tr>
                                                            <tr> 
                                                                <td height="6" bgcolor="FFFFFF"></td>
                                                            </tr>
                                                            <tr> 
                                                                <td height="1" bgcolor="c0bebe"></td>
                                                                <td height="1" bgcolor="D2D2D2"></td>
                                                            </tr>

                                                            <tr> 
                                                                <td width="160" bgcolor="ececec" class="white" style="padding:5px;"><img src="../odimages/odmain/table_icon.gif" width="5" height="11" hspace="5">업체정산형태</td>
                                                                <td width="600" bgcolor="FAFAFA" style="padding:5px;"> 
<?
if($row[customerCode] == "onedaynet") {
?>
                                                                    &nbsp;<?=$row[comSaleType]?><input type="hidden" name="comSaleType" value="공급가" onclick='saleType(this.form)' value="<?=$row[comSaleType]?>">
<?
} else {
?>
                                                                    &nbsp;<input type="radio" name="comSaleType" value="공급가" onclick='saleType(this.form)' <?=$row[comSaleType] == "공급가" || !$row[comSaleType] ? "checked" : NULL;?>>공급가  &nbsp; 
                                                                    &nbsp;<input type="radio" name="comSaleType" value="수수료" onclick='saleType(this.form)' <?=$row[comSaleType] == "수수료" ? "checked" : NULL;?>>수수료
<?
}
?>
                                                                    </td>
                                                            </tr>
                                                            <tr> 
                                                                <td height="1" bgcolor="c0bebe"></td>
                                                                <td height="1" bgcolor="D2D2D2"></td>
                                                            </tr>
                                                            <tr> 
                                                                <td height="6" bgcolor="FFFFFF"></td>
                                                            </tr>
                                                            <tr> 
                                                                <td height="1" bgcolor="c0bebe"></td>
                                                                <td height="1" bgcolor="D2D2D2"></td>
                                                            </tr>

                                                            <tr id='comSaleTypeTr1' style='display:<?=$row[comSaleType] == "공급가" || !$row[comSaleType] ? NULL : "none";?>'> 
                                                                <td width="160" bgcolor="ececec" class="white" style="padding:5px;"><img src="../odimages/odmain/table_icon.gif" width="5" height="11" hspace="5">매입가격 (공급가격)</td>
                                                                <td width="600" bgcolor="FAFAFA" style="padding:5px;"> 
<?
if($row[customerCode] == "onedaynet") {
?>

                                                                    &nbsp;<?=$row[purPrice]?> 원<br><input type="hidden" name="purPrice" class="border" size="10" style='text-align:right;' value="<?=$row[purPrice]?>"> 
<?
} else {
?>

                                                                    &nbsp;<input type="text" name="purPrice" class="border" size="10" style='text-align:right;' value="<?=$row[purPrice]?>"> 원<br>

<?
}
?>
                                                                    <img src="" width="1" height="3"></td>
                                                            </tr>
                                                            <tr id='comSaleTypeTr2' style='display:<?=$row[comSaleType] == "수수료" ? NULL : "none";?>'> 
                                                                <td width="160" bgcolor="ececec" class="white" style="padding:5px;"><img src="../odimages/odmain/table_icon.gif" width="5" height="11" hspace="5">수수료</td>
                                                                <td width="600" bgcolor="FAFAFA" style="padding:5px;"> 
                                                                    &nbsp;<input type="text" name="commission" class="border" size="10" style='text-align:right;' value="<?=$row[commission] ? $row[commission] : 10;?>"> %<br>
                                                                    <img src="" width="1" height="3"></td>
                                                            </tr>
                                                            <tr> 
                                                                <td height="1" bgcolor="c0bebe"></td>
                                                                <td height="1" bgcolor="D2D2D2"></td>
                                                            </tr>
                                                            <tr> 
                                                                <td height="6" bgcolor="FFFFFF"></td>
                                                            </tr>
                                                            <tr> 
                                                                <td height="1" bgcolor="c0bebe"></td>
                                                                <td width="600" height="1" bgcolor="#D5D5D5"></td>
                                                            </tr>
                                                            <tr style='display:none'> 
                                                                <td width="160" bgcolor="ececec" class="white" style="padding:5px;"><img src="../odimages/odmain/table_icon.gif" width="5" height="11" hspace="5">입점업체 배송비 </td>
                                                                <td width="600" bgcolor="FAFAFA" style="padding:5px;"> 
<?
if($row[customerCode] == "onedaynet") {
?>

                                                                    &nbsp;<?=number_format($row[del_price_com])?> 원<input type="hidden" name="del_price_com" class="border" size="10" style='text-align:right;' value="<?=$row[del_price_com]?>">
<?
} else {
?>

                                                                    &nbsp;<input type="text" name="del_price_com" class="border" size="10" style='text-align:right;' value="0"> 원

<?
}
?>
                                                                    
                                                                    <br><img src="" width="1" height="3"></td>
                                                            </tr>
                                                            <tr style='display:none'> 
                                                                <td height="1" bgcolor="c0bebe"></td>
                                                                <td height="1" bgcolor="D2D2D2"></td>
                                                            </tr>
                                                            <tr style='display:none'> 
                                                                <td height="6" bgcolor="FFFFFF"></td>
                                                            </tr>
                                                            <tr style='display:none'> 
                                                                <td height="1" bgcolor="c0bebe"></td>
                                                                <td width="600" height="1" bgcolor="#D5D5D5"></td>
                                                            </tr>
 


                                                            <tr> 
                                                                <td width="160" bgcolor="ececec" class="white" style="padding:5px;" height="41"><img src="../odimages/odmain/table_icon.gif" width="5" height="11" hspace="5">정상가격</td>
                                                                <td width="600" bgcolor="FAFAFA" style="padding:5px;"> 
                                                                    &nbsp;<input type="text" name="price_org" class="border" size="10" style='text-align:right;' value="<?=$row[price_org]?>"> 원
                                                                    
                                                                    </td>
                                                            </tr>
                                                            <tr> 
                                                                <td height="1" bgcolor="c0bebe"></td>
                                                                <td height="1" bgcolor="D2D2D2"></td>
                                                            </tr>
                                                            <tr> 
                                                                <td height="6" bgcolor="FFFFFF"></td>
                                                            </tr>
                                                            <tr> 
                                                                <td height="1" bgcolor="c0bebe"></td>
                                                                <td width="600" height="1" bgcolor="#D5D5D5"></td>
                                                            </tr>
                                                            <tr> 
                                                                <td width="160" bgcolor="ececec" class="white" style="padding:5px;" height="41"><img src="../odimages/odmain/table_icon.gif" width="5" height="11" hspace="5">판매가격 <?help_pop("상품이 2개 이상일때 메인에 노출되는 대표 가격이며,<br>미체크시에는 상품중 가장 낮은값이 메인에 노출됩니다.")?></td>
                                                                <td width="600" bgcolor="FAFAFA" style="padding:5px;"> 
                                                                    &nbsp;<input type="text" name="price" class="border" size="10" style='text-align:right;' value="<?=$row[price]?>"> 원
                                                                    
                                                                    <input type="checkbox" name="mainPrice" value="1" <?=$row[mainPrice] == "1" ? "checked" : NULL;?>>메인가격으로 지정 
                                                                    
                                                                    <br>
                                                                    </td>
                                                            </tr>
                                                            <tr> 
                                                                <td height="1" bgcolor="c0bebe"></td>
                                                                <td height="1" bgcolor="D2D2D2"></td>
                                                            </tr>
                                                            <tr> 
                                                                <td height="6" bgcolor="FFFFFF"></td>
                                                            </tr>
                                                            <tr> 
                                                                <td height="1" bgcolor="c0bebe"></td>
                                                                <td width="600" height="1" bgcolor="#D5D5D5"></td>
                                                            </tr>
                                                            <tr>
                                                                <td width="160" bgcolor="ececec" class="white" style="padding:5px;" height="41"><img src="../odimages/odmain/table_icon.gif" width="5" height="11" hspace="5">할인율 </td>
                                                                <td width="600" bgcolor="FAFAFA" style="padding:5px;"> 
                                                                    &nbsp;<input type="text" name="price_per" class="border" size="10" style='text-align:right;' value="<?=$row[price_per]?>"> %
                                                                    
                                                                    </td>
                                                            </tr>


                                                            <tr> 
                                                                <td height="1" bgcolor="c0bebe"></td>
                                                                <td height="1" bgcolor="D2D2D2"></td>
                                                            </tr>
                                                            <tr> 
                                                                <td height="6" bgcolor="FFFFFF"></td>
                                                            </tr>
                                                            <tr> 
                                                                <td height="1" bgcolor="c0bebe"></td>
                                                                <td width="600" height="1" bgcolor="#D5D5D5"></td>
                                                            </tr>
                                                            <tr style='display:none'> 
                                                                <td width="160" bgcolor="ececec" class="white" style="padding:5px;" height="41"><img src="../odimages/odmain/table_icon.gif" width="5" height="11" hspace="5">쇼핑몰 배송비 <?help_pop("0을 입력하시면 메인에 무료배송 아이콘(<img src='/img/icon_01.jpg' align=absmiddle>)이 노출됩니다.")?></td>
                                                                <td width="600" bgcolor="FAFAFA" style="padding:5px;"> 

                                                                    &nbsp;<input type="text" class="border" name="del_price" size=10 style="text-align:right" value="0"> 원 </td>
                                                            </tr>
                                                            <tr style='display:none'> 
                                                                <td height="1" bgcolor="c0bebe"></td>
                                                                <td height="1" bgcolor="D2D2D2"></td>
                                                            </tr>
                                                            <tr style='display:none'> 
                                                                <td height="6" bgcolor="FFFFFF"></td>
                                                            </tr>
                                                            <tr style='display:none'> 
                                                                <td height="1" bgcolor="c0bebe"></td>
                                                                <td width="600" height="1" bgcolor="#D5D5D5"></td>
                                                            </tr>
                                                            <tr style='display:none'> 
                                                                <td width="160" bgcolor="ececec" class="white" style="padding:5px;" height="41"><img src="../odimages/odmain/table_icon.gif" width="5" height="11" hspace="5">무료배송가</td>
                                                                <td width="600" bgcolor="FAFAFA" style="padding:5px;"> 

                                                                    &nbsp;<input type="text" class="border" name="del_limit" size=10 style="text-align:right" value="0"> 원 이상 무료배송 &nbsp; &nbsp; <font color=red>0일 경우 무조건 배송비 부과</font></td>
                                                            </tr>
                                                            <tr style='display:none'> 
                                                                <td height="1" bgcolor="c0bebe"></td>
                                                                <td height="1" bgcolor="D2D2D2"></td>
                                                            </tr>
                                                            <tr style='display:none'> 
                                                                <td height="6" bgcolor="FFFFFF"></td>
                                                            </tr>
                                                            <tr style='display:none'> 
                                                                <td height="1" bgcolor="c0bebe"></td>
                                                                <td height="1" bgcolor="D2D2D2"></td>
                                                            </tr>
                                                            <tr style='display:none'> 
                                                                <td width="160" bgcolor="ececec" class="white" style="padding:5px;" height="41"><img src="../odimages/odmain/table_icon.gif" width="5" height="11" hspace="5">쿠폰할인가 <?help_pop("회원만 이용할수 있는 할인쿠폰이 발행되며 메인화면에 할인쿠폰 아이콘(<img src='/img/coupon_01_on_.jpg' align=absmiddle>)이 노출됩니다.")?></td>
                                                                <td width="600" bgcolor="FAFAFA" style="padding:5px;"> 
                                                                    &nbsp;<input type="text" name="coupon_sale" class="border" size="10" style='text-align:right;' value="0"> 원</td>
                                                            </tr>
                                                            <tr style='display:none'> 
                                                                <td height="1" bgcolor="c0bebe"></td>
                                                                <td height="1" bgcolor="D2D2D2"></td>
                                                            </tr>
                                                            <tr style='display:none'> 
                                                                <td height="6" bgcolor="FFFFFF"></td>
                                                            </tr>
                                                            <tr style='display:none'> 
                                                                <td height="1" bgcolor="c0bebe"></td>
                                                                <td width="600" height="1" bgcolor="#D5D5D5"></td>
                                                            </tr>
                                                            <tr > 
                                                                <td width="160" bgcolor="ececec" class="white" style="padding:5px;" height="41"><img src="../odimages/odmain/table_icon.gif" width="5" height="11" hspace="5">옵션설정 <?help_pop("상품에 색깔이나, 사이즈등 옵션이 있을때 사용하세요.<br>옵션마다 공급가와 판매가를 지정할수 있으며, 기존 공급가 및 판매가에 추가금액을 입력하셔야 합니다.")?> <font size=3 style="cursor:pointer" onclick="add_menu()">+</font><br>
                                                                
                                                                </td>
                                                                <td width="600" bgcolor="FAFAFA" style="padding:5px;"><table border=0 cellpadding=0 cellspacing=0 width=310 id="proOption" >
                                                                        <tr>
                                                                            <td align=center>옵션이름</td>
                                                                            <td align=center>공급가(추가)</td>
                                                                            <td align=center>판매가(추가)</td>
                                                                        </tr>
<?
$optionNameArray            = explode("|",$row[optionName]);
$optionPurPriceArray    = explode("|",$row[optionPurPrice]);
$optionPriceArray           = explode("|",$row[optionPrice]);

for($oo=0;$oo < count($optionNameArray) ; $oo++) {
    if ($optionNameArray[$oo])
    {
?>
                                                                        <tr>
                                                                            <td align=center><input type="text" name="optionName[]" class="border" size="20"  value="<?=$optionNameArray[$oo]?>"></td>
                                                                            <td align=center><input type="text" name="optionPurPrice[]" class="border" size="10" value="<?=$optionPurPriceArray[$oo]?>"></td>
                                                                            <td align=center><input type="text" name="optionPrice[]" class="border" size="10" value="<?=$optionPriceArray[$oo]?>"></td>
                                                                        </tr>
<?
    }
}
?>
                                                                    </table>
                                                                </td>
                                                            </tr>
                                                            <tr > 
                                                                <td height="1" bgcolor="c0bebe"></td>
                                                                <td height="1" bgcolor="D2D2D2"></td>
                                                            </tr>
                                                            <tr > 
                                                                <td height="6" bgcolor="FFFFFF"></td>
                                                            </tr>
                                                            <tr > 
                                                                <td height="1" bgcolor="c0bebe"></td>
                                                                <td width="600" height="1" bgcolor="#D5D5D5"></td>
                                                            </tr>

                                                            <tr  style='display:none'> 
                                                                <td width="160" bgcolor="ececec" class="white" style="padding:5px;" height="41"><img src="../odimages/odmain/table_icon.gif" width="5" height="11" hspace="5">채팅시간 <?help_pop("MEDIA 메뉴에서만 사용할수 있으며 지정된 시간동안 MD와 판매자와 유저가 채팅할수 있는 기능입니다.")?></td>
                                                                <td width="600" bgcolor="FAFAFA" style="padding:5px;"> 
<?
if(!isset($row[live_start_time])) {
    if($row[sale_date]) {
        $live_start_time = $row[sale_date] ." 00:00:00";
    } else {
        $live_start_time =$calDate . " 00:00:00";
    }
} else { 
    if(strstr($row[live_start_time],"0000-00-00")) {
        if($row[sale_date]) {
            $live_start_time = $row[sale_date] ." 00:00:00";
        } else {
            $live_start_time = $calDate . " 00:00:00";
        }
    } else {
        $live_start_time = $row[live_start_time];
    }
}
?>
                                                                    &nbsp;<input type="checkbox" name="talkDisabled" value="1" <?=$row[talkDisabled] || !isset($row[talkDisabled]) ? "checked" : NULL;?>>채팅비활성화 <br>
                                                                    &nbsp;<input type="text" name="live_start_time" class="border" size="20" value="<?=$live_start_time?>"> 부터 <input type="text" name="live_time" class="border" size=5 value="<?=$row[live_time] ? $row[live_time] : 0;?>">분  <input type="text" name="live_time_sec" class="border" size=5 value="<?=$row[live_time_sec] ? $row[live_time_sec] : 0;?>">초 동안 </td>
                                                            </tr>
                                                            <tr  style='display:none'> 
                                                                <td height="1" bgcolor="c0bebe"></td>
                                                                <td height="1" bgcolor="D2D2D2"></td>
                                                            </tr>
                                                            <tr  style='display:none'> 
                                                                <td height="6" bgcolor="FFFFFF"></td>
                                                            </tr>
                                                            <tr  style='display:none'> 
                                                                <td height="1" bgcolor="c0bebe"></td>
                                                                <td width="600" height="1" bgcolor="#D5D5D5"></td>
                                                            </tr>

                                                            <tr> 
                                                                <td width="160" bgcolor="ececec" class="white" style="padding:5px;" height="41"><img src="../odimages/odmain/table_icon.gif" width="5" height="11" hspace="5">적립금</td>
                                                                <td width="600" bgcolor="FAFAFA" style="padding:5px;"> 
                                                                    &nbsp;<input type="text" name="point" class="border" size="3" style='text-align:right;' value="<?=isset($row[point]) ? $row[point] : "1";?>"> %<br>
                                                                    </td>
                                                            </tr>
                                                            <tr> 
                                                                <td height="1" bgcolor="c0bebe"></td>
                                                                <td height="1" bgcolor="D2D2D2"></td>
                                                            </tr>
                                                            <tr> 
                                                                <td height="6" bgcolor="FFFFFF"></td>
                                                            </tr>
                                                            <tr> 
                                                                <td height="1" bgcolor="c0bebe"></td>
                                                                <td width="600" height="1" bgcolor="#D5D5D5"></td>
                                                            </tr>

                                                            <tr> 
                                                                <td width="160" bgcolor="ececec" class="white" style="padding:5px;" height="41"><img src="../odimages/odmain/table_icon.gif" width="5" height="11" hspace="5">재고량</td>
                                                                <td width="600" bgcolor="FAFAFA" style="padding:5px;"> 
                                                                    <img src="" width="1" height="3"><br>
<?
if($row[customerCode] == "onedaynet") {
?>

                                                                    &nbsp;<input type="hidden" name="stock" class="border" value="<?=$row[stock];?>" size="10" style='text-align:right;' > <?=$row[stock];?>개
                                                                    &nbsp;&nbsp;&nbsp;
                                                                    구매제한 <input type="hidden" name="buy_limit" class="border" value='<?=$row[buy_limit]?>' size="3"><?=$row[buy_limit]?>개
<?
} else {
?>

                                                                    &nbsp;<input type="text" name="stock" class="border" value="<?=isset($row[stock]) ? $row[stock] : "10000";?>" size="10" style='text-align:right;' > 개
                                                                    &nbsp;&nbsp;&nbsp;
                                                                    구매제한 <input type="text" name="buy_limit" class="border" value='<?=isset($row[buy_limit]) ? $row[buy_limit] : "5";?>' size="3">개

<?
}
?>
                                                                    </td>
                                                            </tr>
                                                            <tr> 
                                                                <td height="1" bgcolor="c0bebe"></td>
                                                                <td height="1" bgcolor="D2D2D2"></td>
                                                            </tr>
                                                            <tr> 
                                                                <td height="6" bgcolor="FFFFFF"></td>
                                                            </tr>
                                                            <tr> 
                                                                <td height="1" bgcolor="c0bebe"></td>
                                                                <td width="600" height="1" bgcolor="#D5D5D5"></td>
                                                            </tr>
                                                            <tr style='display:none'> 
                                                                <td width="160" bgcolor="ececec" class="white" style="padding:5px;" height="41"><img src="../odimages/odmain/table_icon.gif" width="5" height="11" hspace="5">구매량 활성화</td>
                                                                <td width="600" bgcolor="FAFAFA" style="padding:5px;"> 
                                                                    <img src="" width="1" height="3"><br>
                                                                    &nbsp;
                                                                    <input type="hidden" name="isSaleCnt" value="Y">

                                                                    </td>
                                                            </tr>
                                                            <tr style='display:none'> 
                                                                <td height="1" bgcolor="c0bebe"></td>
                                                                <td height="1" bgcolor="D2D2D2"></td>
                                                            </tr>
                                                            <tr style='display:none'> 
                                                                <td height="6" bgcolor="FFFFFF"></td>
                                                            </tr>
                                                            <tr style='display:none'> 
                                                                <td height="1" bgcolor="c0bebe"></td>
                                                                <td width="600" height="1" bgcolor="#D5D5D5"></td>
                                                            </tr>
                                                            <tr> 
                                                                <td width="160" bgcolor="ececec" class="white" style="padding:5px;" height="41"><img src="../odimages/odmain/table_icon.gif" width="5" height="11" hspace="5">현 판매량</td>
                                                                <td width="600" bgcolor="FAFAFA" style="padding:5px;"> 
                                                                    <img src="" width="1" height="3"><br>
                                                                    &nbsp;<input type="text" name="saleCnt" class="border" value="<?=isset($row[saleCnt]) ? $row[saleCnt] : "0";?>" size="10" style='text-align:right;' > 개 &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;

                                                                    최대 <input type="text" name="saleCntMax" class="border" value="<?=isset($row[saleCntMax]) ? $row[saleCntMax] : "100";?>" size="10" style='text-align:right;' > 개
                                                                    </td>
                                                            </tr>
                                                            <tr> 
                                                                <td height="1" bgcolor="c0bebe"></td>
                                                                <td height="1" bgcolor="D2D2D2"></td>
                                                            </tr>
                                                            <tr> 
                                                                <td height="6" bgcolor="FFFFFF"></td>
                                                            </tr>
                                                            <tr> 
                                                                <td height="1" bgcolor="c0bebe"></td>
                                                                <td width="600" height="1" bgcolor="#D5D5D5"></td>
                                                            </tr>
                                                            <tr> 
                                                                <td width="160" bgcolor="ececec" class="white" style="padding:5px;" height="41"><img src="../odimages/odmain/table_icon.gif" width="5" height="11" hspace="5">기타설정</td>
                                                                <td width="600" bgcolor="FAFAFA" style="padding:5px;"> 
                                                                    <img src="" width="1" height="3"><br>
                                                                    <input type="hidden" name="guestDisabled" value="1">
                                                                    <input type="checkbox" name="ipDistinct" value="1" <?=$row[ipDistinct] ? "checked" : NULL;?>>중복구매불가 &nbsp;
                                                                    <input type="hidden" name="bankDisabled" value="1">
                                                                    <input type="checkbox" name="seeDisabled" value="1" <?=$row[seeDisabled] ? "checked" : NULL;?>>지난상품LIST 숨기기 &nbsp;
                                                                    </td>
                                                            </tr>
                                                            <tr> 
                                                                <td height="1" bgcolor="c0bebe"></td>
                                                                <td height="1" bgcolor="D2D2D2"></td>
                                                            </tr>
                                                            <tr> 
                                                                <td height="6" bgcolor="FFFFFF"></td>
                                                            </tr>
                                                            <tr> 
                                                                <td height="1" bgcolor="c0bebe"></td>
                                                                <td width="600" height="1" bgcolor="#D5D5D5"></td>
                                                            </tr>



<!--
                                                            <tr> 
                                                                <td width="165" bgcolor="ececec" class="white" style="padding:5px;"><img src="../odimages/odmain/table_icon.gif" width="5" height="11" hspace="5">상품 옵션1</td>
                                                                <td bgcolor="FAFAFA" style="padding:5px;"> 
                                                                    <table width="99%" border="0" cellspacing="0" cellpadding="0">
                                                                        <tr>
                                                                            <td>
                                                                                &nbsp;옵션명 : <input type="text" name="optionName1" class="border" size="15">
                                                                                &nbsp;<font color="313D7D">* 입력예: 색상</font></td>
                                                                            <td align="right">
                                                                                <a href="javascript:reSize(document.snsForm.option1,5)"><img src="../odimages/button_plus.gif" border="0" align="absmiddle"></a>
                                                                                <a href="javascript:reSize(document.snsForm.option1,'reset')"><img src="../odimages/button_reset.gif" border="0" align="absmiddle"></a>
                                                                                <a href="javascript:reSize(document.snsForm.option1,-5)"><img src="../odimages/button_minus.gif" border="0" align="absmiddle"></a>
                                                                                <img src="blank.gif" width="5" height="1">
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td height="5" colspan="2"></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td colspan="2">
                                                                                &nbsp;<textarea name="option1" class="border" rows="5" cols="95"></textarea><br>
                                                                                <img src="" width="1" height="2"><br><font color="313D7D">
                                                                                &nbsp;* 입력예: 검정색/보라색/카키색/주황색 (옵션값의 구분을 / 로 해주시기 바랍니다.)</font></td>
                                                                        </tr>
                                                                    </table>
                                                                </td>
                                                            </tr>
                                                            <tr> 
                                                                <td height="1" bgcolor="c0bebe"></td>
                                                                <td height="1" bgcolor="D2D2D2"></td>
                                                            </tr>
                                                            <tr> 
                                                                <td height="6" bgcolor="FFFFFF"></td>
                                                            </tr>
                                                            <tr> 
                                                                <td height="1" bgcolor="c0bebe"></td>
                                                                <td width="600" height="1" bgcolor="#D5D5D5"></td>
                                                            </tr>
-->

                                                            <tr style='display:none'> 
                                                                <td width="165" bgcolor="ececec" class="white" style="padding:5px;"><img src="../odimages/odmain/table_icon.gif" width="5" height="11" hspace="5">MD 한마디</td>
                                                                <td bgcolor="FAFAFA" style="padding:5px;"> 
                                                                    <table width="99%" border="0" cellspacing="0" cellpadding="0">
                                                                        <tr>
                                                                            <td colspan="2">
                                                                                &nbsp;<textarea name="md_ment" class="border" rows="10" cols="95" geditor><?=stripslashes($row[md_ment])?></textarea><br>
                                                                                <img src="" width="1" height="2"></td>
                                                                        </tr>
                                                                    </table>
                                                                </td>
                                                            </tr>
                                                            <tr style='display:none'> 
                                                                <td height="1" bgcolor="c0bebe"></td>
                                                                <td height="1" bgcolor="D2D2D2"></td>
                                                            </tr>
                                                            <tr style='display:none'> 
                                                                <td height="6" bgcolor="FFFFFF"></td>
                                                            </tr>
                                                            <tr style='display:none'> 
                                                                <td height="1" bgcolor="c0bebe"></td>
                                                                <td width="600" height="1" bgcolor="#D5D5D5"></td>
                                                            </tr>
                                                            <tr style='display:none'> 
                                                                <td width="165" bgcolor="ececec" class="white" style="padding:5px;"><img src="../odimages/odmain/table_icon.gif" width="5" height="11" hspace="5">판매자 한마디</td>
                                                                <td bgcolor="FAFAFA" style="padding:5px;"> 
                                                                    <table width="99%" border="0" cellspacing="0" cellpadding="0">
                                                                        <tr>
                                                                            <td colspan="2">
                                                                                &nbsp;<textarea name="seller_ment" class="border" rows="10" cols="95" geditor><?=stripslashes($row[seller_ment])?></textarea><br>
                                                                                <img src="" width="1" height="2"></td>
                                                                        </tr>
                                                                    </table>
                                                                </td>
                                                            </tr>
                                                            <tr style='display:none'> 
                                                                <td height="1" bgcolor="c0bebe"></td>
                                                                <td height="1" bgcolor="D2D2D2"></td>
                                                            </tr>
                                                            <tr style='display:none'> 
                                                                <td height="6" bgcolor="FFFFFF"></td>
                                                            </tr>
                                                            <tr style='display:none'> 
                                                                <td height="1" bgcolor="c0bebe"></td>
                                                                <td width="600" height="1" bgcolor="#D5D5D5"></td>
                                                            </tr>
                                                            <tr> 
                                                                <td width="165" bgcolor="ececec" class="white" style="padding:5px;"><img src="../odimages/odmain/table_icon.gif" width="5" height="11" hspace="5">상품 상세설명<br><?=$size_line[1]?></td>
                                                                <td bgcolor="FAFAFA" style="padding:5px;"> 
                                                                    <table width="99%" border="0" cellspacing="0" cellpadding="0">
                                                                        <tr>
                                                                            <td colspan="2"><textarea name="comment2" class="border" rows="30" cols="94" geditor><?=stripslashes($row[comment2])?></textarea>
                                                                            </td>
                                                                        </tr>
                                                                    </table>
                                                                </td>
                                                            </tr>
                                                            <tr> 
                                                                <td height="1" bgcolor="c0bebe"></td>
                                                                <td height="1" bgcolor="D2D2D2"></td>
                                                            </tr>
                                                            <tr> 
                                                                <td height="6" bgcolor="FFFFFF"></td>
                                                            </tr>
                                                            <tr> 
                                                                <td height="1" bgcolor="c0bebe"></td>
                                                                <td width="608" height="1" bgcolor="#D5D5D5"></td>
                                                            </tr>

                                                            <tr> 
                                                                <td width="143" bgcolor="ececec" class="white" style="padding:5px;"><img src="../odimages/odmain/table_icon.gif" width="5" height="11" hspace="5">업체정보 <br><?=$size_line[2]?></td>
                                                                <td bgcolor="FAFAFA" style="padding:5px;"> 
                                                                    &nbsp;<textarea name="onecut_img" class="border" rows="30" cols="94" geditor><?=stripslashes($row[onecut_img])?></textarea>
                                                                    
                                                                </td>
                                                            </tr>

                                                            <tr> 
                                                                <td width="165" bgcolor="ececec" class="white" style="padding:5px;"><img src="../odimages/odmain/table_icon.gif" width="5" height="11" hspace="5">체크포인트</td>
                                                                <td bgcolor="FAFAFA" style="padding:5px;"> 
                                                                    <input type="checkbox" name="opt_1" value="1" <?=$row[opt_1] ? "checked" : NULL;?>>주차가능 &nbsp;
                                                                    <input type="checkbox" name="opt_2" value="1" <?=$row[opt_2] ? "checked" : NULL;?>>예약필수 &nbsp;
                                                                    <input type="checkbox" name="opt_3" value="1" <?=$row[opt_3] ? "checked" : NULL;?>>주말/공휴일사용 &nbsp;
                                                                    <input type="checkbox" name="opt_4" value="1" <?=$row[opt_4] ? "checked" : NULL;?>>유효기간 (상세부분은 상품상세설명에..)
                                                                </td>
                                                            </tr>

                                                            <tr> 
                                                                <td height="1" bgcolor="c0bebe"></td>
                                                                <td height="1" bgcolor="D2D2D2"></td>
                                                            </tr>
                                                            <tr> 
                                                                <td height="15" bgcolor="FFFFFF"></td>
                                                            </tr>
                                                            <tr> 
                                                                <td height="1" bgcolor="c0bebe"></td>
                                                                <td height="1" bgcolor="#D5D5D5"></td>
                                                            </tr>

                                                            <tr> 
                                                                <td bgcolor="ececec" class="white" style="padding:5px;"><img src="../odimages/odmain/table_icon.gif" width="5" height="11" hspace="5">메일링 이미지 <?help_pop("메일링에서 사용될 이미지입니다.<br>수신거부 안내멘트는 자동삽입 되며 <br>내용이 없을시 메일은 발송되지 않습니다.")?></td>
                                                                <td bgcolor="FAFAFA" style="padding:5px;"> 
                                                                    &nbsp;<textarea name="mailing_img" class="border" rows="30" cols="94" geditor><?=stripslashes($row[mailing_img])?></textarea>
    
                                                                    </td>
                                                            </tr>
                                                            <tr> 
                                                                <td height="1" bgcolor="c0bebe"></td>
                                                                <td height="1" bgcolor="#D5D5D5"></td>
                                                            </tr>
                                                            <tr> 
                                                                <td height="15" bgcolor="FFFFFF"></td>
                                                            </tr>
                                                            <tr> 
                                                                <td height="1" bgcolor="c0bebe"></td>
                                                                <td height="1" bgcolor="#D5D5D5"></td>
                                                            </tr>



                                                            <tr> 
                                                                <td width="143" bgcolor="ececec" class="white" style="padding:5px;"><img src="../odimages/odmain/table_icon.gif" width="5" height="11" hspace="5">메인1  <?help_pop("메인에 노출되는 대표 이미지 입니다.")?></td>
                                                                <td bgcolor="FAFAFA" style="padding:5px;"> 
                                                                    &nbsp;<input type="file" name="main_img" class="border" size="40"> <?=$size_line[3]?>
<?
$imgName = "main_img";
if($row[$imgName]) {7
?>
                                                                    <a href="<?=$row[$imgName]?>" target="_blank"><img src="<?=$row[$imgName]?>" width=50 border=0></a>
                                                                    <input type="hidden" name="<?=$imgName?>_org" value="<?=$row[$imgName]?>">
                                                                    <input type="checkbox" name="<?=$imgName?>_del" value="Y"> 삭제
<?
}
?>
                                                                </td>
                                                            </tr>
                                                            <tr> 
                                                                <td height="1" bgcolor="c0bebe"></td>
                                                                <td height="1" bgcolor="#D5D5D5"></td>
                                                            </tr>
                                                            <tr> 
                                                                <td height="15" bgcolor="FFFFFF"></td>
                                                            </tr>
                                                            <tr> 
                                                                <td height="1" bgcolor="c0bebe"></td>
                                                                <td height="1" bgcolor="#D5D5D5"></td>
                                                            </tr>


                                                            <tr> 
                                                                <td width="143" bgcolor="ececec" class="white" style="padding:5px;"><img src="../odimages/odmain/table_icon.gif" width="5" height="11" hspace="5">메인2  </td>
                                                                <td bgcolor="FAFAFA" style="padding:5px;"> 
                                                                    &nbsp;<input type="file" name="big2_img" class="border" size="40"> <?=$size_line[3]?>
<?
$imgName = "big2_img";
if($row[$imgName]) {
?>
                                                                    <a href="<?=$row[$imgName]?>" target="_blank"><img src="<?=$row[$imgName]?>" width=50 border=0></a>
                                                                    <input type="hidden" name="<?=$imgName?>_org" value="<?=$row[$imgName]?>">
                                                                    <input type="checkbox" name="<?=$imgName?>_del" value="Y"> 삭제
<?
}
?>
                                                                </td>
                                                            </tr>
                                                            <tr> 
                                                                <td height="1" bgcolor="c0bebe"></td>
                                                                <td height="1" bgcolor="#D5D5D5"></td>
                                                            </tr>
                                                            <tr> 
                                                                <td height="15" bgcolor="FFFFFF"></td>
                                                            </tr>
                                                            <tr> 
                                                                <td height="1" bgcolor="c0bebe"></td>
                                                                <td height="1" bgcolor="#D5D5D5"></td>
                                                            </tr>


                                                            <tr> 
                                                                <td width="143" bgcolor="ececec" class="white" style="padding:5px;"><img src="../odimages/odmain/table_icon.gif" width="5" height="11" hspace="5">메인3  </td>
                                                                <td bgcolor="FAFAFA" style="padding:5px;"> 
                                                                    &nbsp;<input type="file" name="big3_img" class="border" size="40"> <?=$size_line[3]?>
<?
$imgName = "big3_img";
if($row[$imgName]) {
?>
                                                                    <a href="<?=$row[$imgName]?>" target="_blank"><img src="<?=$row[$imgName]?>" width=50 border=0></a>
                                                                    <input type="hidden" name="<?=$imgName?>_org" value="<?=$row[$imgName]?>">
                                                                    <input type="checkbox" name="<?=$imgName?>_del" value="Y"> 삭제
<?
}
?>
                                                                </td>
                                                            </tr>
                                                            <tr> 
                                                                <td height="1" bgcolor="c0bebe"></td>
                                                                <td height="1" bgcolor="#D5D5D5"></td>
                                                            </tr>
                                                            <tr> 
                                                                <td height="15" bgcolor="FFFFFF"></td>
                                                            </tr>
                                                            <tr> 
                                                                <td height="1" bgcolor="c0bebe"></td>
                                                                <td height="1" bgcolor="#D5D5D5"></td>
                                                            </tr>


                                                            <tr> 
                                                                <td width="143" bgcolor="ececec" class="white" style="padding:5px;"><img src="../odimages/odmain/table_icon.gif" width="5" height="11" hspace="5">메인4  </td>
                                                                <td bgcolor="FAFAFA" style="padding:5px;"> 
                                                                    &nbsp;<input type="file" name="big4_img" class="border" size="40"> <?=$size_line[3]?>
<?
$imgName = "big4_img";
if($row[$imgName]) {
?>
                                                                    <a href="<?=$row[$imgName]?>" target="_blank"><img src="<?=$row[$imgName]?>" width=50 border=0></a>
                                                                    <input type="hidden" name="<?=$imgName?>_org" value="<?=$row[$imgName]?>">
                                                                    <input type="checkbox" name="<?=$imgName?>_del" value="Y"> 삭제
<?
}
?>
                                                                </td>
                                                            </tr>
                                                            <tr> 
                                                                <td height="1" bgcolor="c0bebe"></td>
                                                                <td height="1" bgcolor="#D5D5D5"></td>
                                                            </tr>
                                                            <tr> 
                                                                <td height="15" bgcolor="FFFFFF"></td>
                                                            </tr>
                                                            <tr> 
                                                                <td height="1" bgcolor="c0bebe"></td>
                                                                <td height="1" bgcolor="#D5D5D5"></td>
                                                            </tr>


                                                            <tr> 
                                                                <td width="143" bgcolor="ececec" class="white" style="padding:5px;"><img src="../odimages/odmain/table_icon.gif" width="5" height="11" hspace="5">메인5  </td>
                                                                <td bgcolor="FAFAFA" style="padding:5px;"> 
                                                                    &nbsp;<input type="file" name="big5_img" class="border" size="40"> <?=$size_line[3]?>
<?
$imgName = "big5_img";
if($row[$imgName]) {
?>
                                                                    <a href="<?=$row[$imgName]?>" target="_blank"><img src="<?=$row[$imgName]?>" width=50 border=0></a>
                                                                    <input type="hidden" name="<?=$imgName?>_org" value="<?=$row[$imgName]?>">
                                                                    <input type="checkbox" name="<?=$imgName?>_del" value="Y"> 삭제
<?
}
?>
                                                                </td>
                                                            </tr>
                                                            <tr> 
                                                                <td height="1" bgcolor="c0bebe"></td>
                                                                <td height="1" bgcolor="#D5D5D5"></td>
                                                            </tr>
                                                            <tr> 
                                                                <td height="15" bgcolor="FFFFFF"></td>
                                                            </tr>
                                                            <tr> 
                                                                <td height="1" bgcolor="c0bebe"></td>
                                                                <td height="1" bgcolor="#D5D5D5"></td>
                                                            </tr>



                                                            <tr> 
                                                                <td bgcolor="ececec" class="white" style="padding:5px;"><img src="../odimages/odmain/table_icon.gif" width="5" height="11" hspace="5">상품 리스트 <?help_pop("구매하기 페이지 리스트에 보여질 이미지입니다.")?></td>
                                                                <td bgcolor="FAFAFA" style="padding:5px;"> 
                                                                    &nbsp;<input type="file" name="prolist_img" class="border" size="40"> <?=$size_line[4]?> 
<?
$imgName = "prolist_img";
if($row[$imgName]) {
?>
                                                                    <a href="<?=$row[$imgName]?>" target="_blank"><img src="<?=$row[$imgName]?>" width=50 border=0></a>
                                                                    <input type="hidden" name="<?=$imgName?>_org" value="<?=$row[$imgName]?>">
                                                                    <input type="checkbox" name="<?=$imgName?>_del" value="Y"> 삭제
<?
}
?>                                                                  
                                                                    </td>
                                                            </tr>
                                                            <tr> 
                                                                <td height="1" bgcolor="c0bebe"></td>
                                                                <td height="1" bgcolor="#D5D5D5"></td>
                                                            </tr>
                                                            <tr> 
                                                                <td height="15" bgcolor="FFFFFF"></td>
                                                            </tr>
                                                            <tr> 
                                                                <td height="1" bgcolor="c0bebe"></td>
                                                                <td height="1" bgcolor="#D5D5D5"></td>
                                                            </tr>
                                                            <tr> 
                                                                <td bgcolor="ececec" class="white" style="padding:5px;"><img src="../odimages/odmain/table_icon.gif" width="5" height="11" hspace="5">배너퍼가기 <?help_pop("배너퍼가기 이미지입니다.")?></td>
                                                                <td bgcolor="FAFAFA" style="padding:5px;"> 
                                                                    &nbsp;<input type="file" name="banner_img" class="border" size="40"> 153 x 44 
<?
$imgName = "banner_img";
if($row[$imgName]) {
?>
                                                                    <a href="<?=$row[$imgName]?>" target="_blank"><img src="<?=$row[$imgName]?>" width=50 border=0></a>
                                                                    <input type="hidden" name="<?=$imgName?>_org" value="<?=$row[$imgName]?>">
                                                                    <input type="checkbox" name="<?=$imgName?>_del" value="Y"> 삭제
<?
}
?>                                                                  
                                                                    </td>
                                                            </tr>





                                                            <tr> 
                                                                <td height="1" bgcolor="c0bebe"></td>
                                                                <td height="1" bgcolor="#D5D5D5"></td>
                                                            </tr>
                                                            <tr> 
                                                                <td height="15" bgcolor="FFFFFF"></td>
                                                            </tr>
                                                            <tr> 
                                                                <td height="1" bgcolor="c0bebe"></td>
                                                                <td height="1" bgcolor="#D5D5D5"></td>
                                                            </tr>

                                                            <tr> 
                                                                <td bgcolor="ececec" class="white" style="padding:5px;"><img src="../odimages/odmain/table_icon.gif" width="5" height="11" hspace="5">알리미이미지 <?help_pop("알리미에 노출될 이미지 입니다.<br><img src='/img/alimi_sample.jpg' align=absmiddle>")?></td>
                                                                <td bgcolor="FAFAFA" style="padding:5px;"> 
                                                                    &nbsp;<input type="file" name="side_img" class="border" size="40"> 156 x 174  
<?
$imgName = "side_img";
if($row[$imgName]) {
?>
                                                                    <a href="<?=$row[$imgName]?>" target="_blank"><img src="<?=$row[$imgName]?>" width=50 border=0></a>
                                                                    <input type="hidden" name="<?=$imgName?>_org" value="<?=$row[$imgName]?>">
                                                                    <input type="checkbox" name="<?=$imgName?>_del" value="Y"> 삭제
<?
}
?>                                                                  
                                                                    </td>
                                                            </tr>
                                                            <tr> 
                                                                <td height="1" bgcolor="c0bebe"></td>
                                                                <td height="1" bgcolor="D2D2D2"></td>
                                                            </tr>
                                                            <tr> 
                                                                <td height="15" bgcolor="FFFFFF"></td>
                                                            </tr>
                                                            <tr> 
                                                                <td height="1" bgcolor="c0bebe"></td>
                                                                <td height="1" bgcolor="#D5D5D5"></td>
                                                            </tr>


                                                            <tr> 
                                                                <td bgcolor="ececec" class="white" style="padding:5px;"><img src="../odimages/odmain/table_icon.gif" width="5" height="11" hspace="5">주문확인/쿠폰 이미지 <?help_pop("주문확인과 쿠폰발급시 사용될 이미지입니다.<br><img src='/images/group/coupon2.jpg'>")?></td>
                                                                <td bgcolor="FAFAFA" style="padding:5px;"> 
                                                                    &nbsp;<input type="file" name="cpDp_img" class="border" size="40"> 170px x 170px
<?
$imgName = "cpDp_img";
if($row[$imgName]) {
?>
                                                                    <a href="<?=$row[$imgName]?>" target="_blank"><img src="<?=$row[$imgName]?>" width=50 border=0></a>
                                                                    <input type="hidden" name="<?=$imgName?>_org" value="<?=$row[$imgName]?>">
                                                                    <input type="checkbox" name="<?=$imgName?>_del" value="Y"> 삭제
<?
}
?>                                                                  
                                                                    </td>
                                                            </tr>
                                                            <tr> 
                                                                <td height="1" bgcolor="c0bebe"></td>
                                                                <td height="1" bgcolor="#D5D5D5"></td>
                                                            </tr>
                                                            <tr> 
                                                                <td height="15" bgcolor="FFFFFF"></td>
                                                            </tr>
                                                            <tr> 
                                                                <td height="1" bgcolor="c0bebe"></td>
                                                                <td height="1" bgcolor="#D5D5D5"></td>
                                                            </tr>
                                                            <tr> 
                                                                <td width="165" bgcolor="ececec" class="white" style="padding:5px;"><img src="../odimages/odmain/table_icon.gif" width="5" height="11" hspace="5">주문확인서 주의사항 <?help_pop("쿠폰에 들어갈 주의사항입니다.<br><img src='/images/group/coupon1.jpg'>")?></td>
                                                                <td bgcolor="FAFAFA" style="padding:5px;"> 
                                                                    <table width="99%" border="0" cellspacing="0" cellpadding="0">
                                                                        <tr>
                                                                            <td colspan="2">※ 5줄 이내로 입력하시기 바랍니다.<br><textarea name="comment3" class="border" rows="10" cols="94" geditor><?=stripslashes($row[comment3])?></textarea>
                                                                            </td>
                                                                        </tr>
                                                                    </table>
                                                                </td>
                                                            </tr>
                                                            <tr> 
                                                                <td height="1" bgcolor="c0bebe"></td>
                                                                <td height="1" bgcolor="D2D2D2"></td>
                                                            </tr>
                                                            <tr> 
                                                                <td height="6" bgcolor="FFFFFF"></td>
                                                            </tr>
                                                            <tr> 
                                                                <td height="1" bgcolor="c0bebe"></td>
                                                                <td width="608" height="1" bgcolor="#D5D5D5"></td>
                                                            </tr>

                                                            <tr> 
                                                                <td bgcolor="ececec" class="white" style="padding:5px;"><img src="../odimages/odmain/table_icon.gif" width="5" height="11" hspace="5">쿠폰정보 SMS  <?help_pop("구독신청하신 분들께 발송될 SMS에서 사용될 문자열입니다.")?></td>
                                                                <td bgcolor="FAFAFA" style="padding:5px;"> 
                                                                    &nbsp;<textarea name="message" cols="60" rows="2" id="message" style="BACKGROUND-COLOR: #E2EAF9;font-size: 9pt;border: 1x SOLID #D0D0D0;color:#173979;padding: 4px;;font-family:굴림체" onclick="chk_message(snsForm)" onkeyup="check_length(snsForm); return false;"><?=stripslashes($row[message])?></textarea> <font color="265BBC"><font id="message_len_id">0</font> bytes / 80 bytes</font>
                                                                </td>
                                                            </tr>
                                                            <tr> 
                                                                <td height="1" bgcolor="c0bebe"></td>
                                                                <td height="1" bgcolor="#D5D5D5"></td>
                                                            </tr>
                                                            <tr> 
                                                                <td height="15" bgcolor="FFFFFF"></td>
                                                            </tr>
                                                            <tr> 
                                                                <td height="1" bgcolor="c0bebe"></td>
                                                                <td height="1" bgcolor="#D5D5D5"></td>
                                                            </tr>


                                                            <tr> 
                                                                <td bgcolor="ececec" class="white" style="padding:5px;"><img src="../odimages/odmain/table_icon.gif" width="5" height="11" hspace="5">구독하기 설정  <?help_pop("상품이 등록되는 날짜에 구독하기를 보낼 지 선택합니다.")?></td>
                                                                <td bgcolor="FAFAFA" style="padding:5px;"> 
                                                                    &nbsp;<input type="checkbox" name="setup_subscribe[]" value="4" <?echo ( in_array($row[setup_subscribe] , array(4,6)) || !$row[setup_subscribe])?"checked":"";?>>SMS 구독하기 발송
                                                                    &nbsp;<input type="checkbox" name="setup_subscribe[]" value="2" <?echo ( in_array($row[setup_subscribe] , array(2,6)) || !$row[setup_subscribe])?"checked":"";?>>이메일 구독하기 발송
                                                                </td>
                                                            </tr>
                                                            <tr> 
                                                                <td height="1" bgcolor="c0bebe"></td>
                                                                <td height="1" bgcolor="#D5D5D5"></td>
                                                            </tr>
                                                            <tr> 
                                                                <td height="15" bgcolor="FFFFFF"></td>
                                                            </tr>
                                                            <tr> 
                                                                <td height="1" bgcolor="c0bebe"></td>
                                                                <td height="1" bgcolor="#D5D5D5"></td>
                                                            </tr>


                                                            <tr > 
                                                                <td width="160" bgcolor="ececec" class="white" style="padding:5px;" height="41"><img src="../odimages/odmain/table_icon.gif" width="5" height="11" hspace="5">상품기술서 <font size=3 style="cursor:pointer" onclick="add_file()">+</font></td>
                                                                <td width="600" bgcolor="FAFAFA" style="padding:5px;"><table border=0 cellpadding=0 cellspacing=0 width=210 id="proFile" >

<?
$proRes = mysql_query("select * from odtProFiles where code ='".$row[code]."' order by no asc");
while($proRow = mysql_fetch_array($proRes)) {

?>
                                                                        <tr>
                                                                            <Td>

                                                                                &nbsp;<input type="file" name="proFile[]" class="border" size="40">
                                                                                            <a href="./profiledown.php?no=<?=$proRow[no]?>"><?=$proRow[filename]?></a>
                                                                                            <input type="hidden" name="proFile_org[]" value="<?=$proRow[filesrc]?>">
                                                                                            <input type="hidden" name="proFileReal_org[]" value="<?=$proRow[filename]?>">
                                                                                            <input type="checkbox" name="proFile_del[]" value="Y"> 삭제
                                                                            </td>
                                                                        </tr>

<?
}
?>

                                                                        <tr>
                                                                            <Td>
                                                                                &nbsp;<input type="file" name="proFile[]" class="border" size="40"> 
                                                                            </td>
                                                                        </tr>

                                                                    </table>
                                                                </td>
                                                            </tr>

<!-- 정보필드 추가 -->
	<tr> 
	    <td height="1" bgcolor="c0bebe"></td>
	    <td height="1" bgcolor="D2D2D2"></td>
	</tr>
	<tr> 
	    <td height="6" bgcolor="FFFFFF"></td>
	</tr>
	<tr> 
	    <td height="1" bgcolor="c0bebe"></td>
	    <td width="600" height="1" bgcolor="#D5D5D5"></td>
	</tr>
	<tr> 
	    <td width="160" bgcolor="ececec" class="white" style="padding:5px;">
	    <img src="../odimages/odmain/table_icon.gif" width="5" height="11" hspace="5">추가 정보</td>
	    <td width="600" bgcolor="FAFAFA" style="padding:5px;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;지역명
	        <input type="text" name="rssarea1" class="border" size="10" style='text-align:center;' value="<?=$row[rssarea1]?>">&nbsp;/&nbsp;위치
	        <input type="text" name="rssarea2" class="border" size="10" style='text-align:center;' value="<?=$row[rssarea2]?>"> * 예) 서울  /  홍대
	    <img src="" width="1" height="3"></td>
	</tr>
	<tr> 
	    <td width="160" bgcolor="ececec" class="white" style="padding:5px;"></td>
	    <td width="600" bgcolor="FAFAFA" style="padding:5px;">&nbsp;&nbsp;&nbsp;&nbsp;카테고리
	        <input type="text" name="rsscate" class="border" size="10" style='text-align:center;' value="<?=$row[rsscate]?>"> * 예) 맛집 , 공연 , LIFE , 여행 , 미분류
	 : 카테고리는 1개만 적어주시기 바랍니다.
	    <img src="" width="1" height="3"></td>
	</tr>
	<tr> 
	    <td width="160" bgcolor="ececec" class="white" style="padding:5px;"></td>
	    <td width="600" bgcolor="FAFAFA" style="padding:5px;">&nbsp;쿠폰만료일
	        <input id='id_expire' type="text" name=expire size=10 class="border" readonly style="cursor:hand" value="<?=$row[expire]?>"> * 쿠폰의 사용만료일<script>var cal2 = new jsCalendar(document.getElementById('id_expire'));</script>
	    <img src="" width="1" height="3"></td>
	</tr>
	<!--  정보필드 추가 -->



                                                            <tr> 
                                                                <td height="1" bgcolor="c0bebe"></td>
                                                                <td height="1" bgcolor="#D5D5D5"></td>
                                                            </tr>
                                                        </table>
                                                        <table width="760" border="0" cellspacing="0" cellpadding="0">
                                                            <tr> 
                                                                <td height="15" bgcolor="FFFFFF"></td>
                                                            </tr>
                                                        </table>
                                                        <table width="760" border="0" cellspacing="1" cellpadding="0">
                                                            <tr> 
                                                                <td align="center">
                                                                    <input type="image" src="../odimages/odmain/btn_ok.gif" width="77" height="24" hspace="3" onfocus='this.blur();'>
                                                                    <a onclick="reset();" onfocus='this.blur();' style='cursor:hand;'><img src="../odimages/odmain/btn_cancel.gif" width="77" height="24" hspace="3" border="0"></a>
                                                                    <a href="od_list.php" onfocus='this.blur();'><img src="../odimages/btn_list.gif" hspace="3" border="0"></a>
                                                                </td>
                                                            </tr>

                                                            </form>
                                                        </table>
                                                    </td>
                                                </tr>
                                                <tr> 
                                                    <td height="15" valign="top"></td>
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
<? include "../odcommon/od_bottom.inc.php"; ?>
                    <!-- bottom end -->
                </td>
            </tr>
        </table>
        <script language="Javascript" src="/odprogram/geditor/geditor.js"></script>
        <script>
        //메인인지 서브인지 체크
        mainOrSubCheck();
        </script>
    </body>
</html>
