<?
//-----------------------------------------------------------------------------
// 메인이미지 순번 
//-----------------------------------------------------------------------------
echo "
<script>
var mnumIdx = 1;
function changeImg(idx,img) {

    btnNew = document.getElementById(\"mnum_\"+idx);
    btnOld = document.getElementById(\"mnum_\"+this.mnumIdx);

    btnOld.src = btnOld.src.replace(\"_hot\",\"\");
    btnNew.src = btnNew.src.replace(\"num\"+idx+\"\",\"num\"+idx+\"_hot\");
    
    document.getElementById(\"mainImage\").src = img;

    this.mnumIdx = idx;

}
</script>
<div style='Z-INDEX: 1; LEFT: 0px; WIDTH: 0px; POSITION: relative; TOP: 0px; HEIGHT: 0px;display:'>
<div style='Z-INDEX: 1; LEFT: -450px; WIDTH: 200px; POSITION: absolute; TOP: 360px; HEIGHT: 0px'>
<table border='0' cellpadding='0' cellspacing='0' align='left' id=table_layer>
    <tr>";

$iconArray = array("main_img", "big2_img", "big3_img", "big4_img", "big5_img");
for ($z = 0; $z < 5; $z++)
{
    if ($row_product[$iconArray[$z]])
    {
        echo "<td width=20><a href='#none'><img id='mnum_".($z+1)."' src='/pages/skin/3/img/img_num"; echo ($z+1); if (!$z) { echo "_hot"; } echo ".gif' border='0' onclick=\"changeImg(".($z+1).", '".$row_product[$iconArray[$z]]."')\"></a></td>
              <td width=5></td>";
    }
}
    echo "
    </tr>
</table>
</div></div>";

//-----------------------------------------------------------------------------
// 메인 상품이미지
//-----------------------------------------------------------------------------
echo "
<table width='950' cellpadding='0' cellspacing='0' border='0' id=table_layer>
    <tr>
        <td><img src='".$row_product[main_img]."' width='950' height='407' id='mainImage'></td>
    </tr>
</table>";

//-----------------------------------------------------------------------------
// 할인율
//-----------------------------------------------------------------------------
echo "
<div style='Z-INDEX: 1; LEFT: 0px; WIDTH: 0px; POSITION: relative; TOP: 0px; HEIGHT: 0px;display:'>
<div style='Z-INDEX: 1; LEFT: -645px; WIDTH: 200px; POSITION: absolute; TOP: -620px; HEIGHT: 0px'>
<div id='save'>";
for ($j = 0; $j < strlen($row_product[price_per]); $j++)
{
    echo "<img src='/pages/skin/3/img/save_num_".sprintf("%02d", $row_product[price_per][$j]).".gif' >";
}
echo "
</div>
</div>
</div>";

// 재고량 파악 ////////////////////////////////////////////////////////////////
$minStock = @mysql_result(mysql_query("select max(stock) from odtProduct where parent_code ='".$row_product[code]."'"),0);
$info_nowsale_code = info_nowsale($thiscate);// 금일 상품코드

// 상품의 종료일자확인(현재일자가 종료일자보다 클경우 플래쉬에서 0이 깜박이는 오류발생)
$today_date = date("Y-m-d");
$Query  = " select sale_enddate from odtProduct where code = parent_code and cateCode = '".$thiscate."' and sale_date <= '".$today_date."' and sale_enddate >= '".$today_date."' order by sale_date desc limit 1 ";
$Result = mysql_query($Query);
$Record = mysql_fetch_array($Result);
$sale_enddate = $Record[0];
$nextSaleTime = strtotime($sale_enddate) + $row_setup[changeTime]*3600;
$curr_time    = time();

if ($minStock > 0 && $row_product[code] == $info_nowsale_code && $nextSaleTime > $curr_time )
{
    //-------------------------------------------------------------------------
    // 플래쉬 남은 시간
    //-------------------------------------------------------------------------
    echo "
    <div style='Z-INDEX: 1; LEFT: 0px; WIDTH: 0px; POSITION: relative; TOP: 0px; HEIGHT: 0px;display:'>
    <div style='Z-INDEX: 1; LEFT: 220px; WIDTH: 0px; POSITION: absolute; TOP: -90px; HEIGHT: 0px'>
    <script type='text/javascript'>
        AC_FL_RunContent( 'codebase','http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=9,0,28,0','width','248','height','83','src','/pages/skin/3/flash/today_count','quality','high','pluginspage','http://www.adobe.com/shockwave/download/download.cgi?P1_Prod_Version=ShockwaveFlash','movie','/pages/skin/3/flash/today_count','wmode','transparent' );
    </script>
    <noscript>
    <object classid='clsid:D27CDB6E-AE6D-11cf-96B8-444553540000' codebase='http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=9,0,28,0'  width='248' height='83'>
        <param name='movie' value='/pages/skin/3/flash/today_count.swf' />
        <param name='quality' value='high' />
        <param name='wmode' value='transparent' />
        <embed src='/pages/skin/3/flash/today_count.swf' quality='high' pluginspage='http://www.adobe.com/shockwave/download/download.cgi?P1_Prod_Version=ShockwaveFlash' type='application/x-shockwave-flash' width='248' height='83' wmode='transparent'></embed>
    </object>
    </noscript>
    </div>
    </div>";
}
else
{
    // 판매종료 시간 00:00:00 이미지 처리 /////////////////////////////////////
    echo "
    <div style='Z-INDEX: 1; LEFT: 0px; WIDTH: 0px; POSITION: relative; TOP: 0px; HEIGHT: 0px;display:'>
    <div style='Z-INDEX: 1; LEFT: 220px; WIDTH: 0px; POSITION: absolute; TOP: -90px; HEIGHT: 0px'>
    <img src='/pages/skin/3/img/soldout.png' >
    </div>
    </div>";
}



//-----------------------------------------------------------------------------
// 타이틀이미지, 체크포인트, 구매하기부분
//-----------------------------------------------------------------------------
echo "
<script>
function submitFun(frm)
{
    return true;
}
</script>
<table width='950' cellpadding='0' cellspacing='0' border='0' id=table_layer>
    <tr>
        <td width='670'><img src='".$row_product[mainNameImg]."' width='670' height='216'></td>
        <td rowspan='2' valign='top' id='price_box'>
            <table width='100%' border='0' cellspacing='0' cellpadding='0'>
                <tr>
                    <td class='price_txt1'>정상가격</td>
                    <td align='right'><span class='price1'>".number_format($row_product[price_org])."</span> <span class='price_txt3'>원</span></td>
                </tr>
                <tr>
                    <td class='price_txt2'>할인가격</td>
                    <td align='right'><span class='price2'>".number_format($priceMin)."</span> <span class='price_txt3'>원</span></td>
                </tr>
                <tr>
                    <td colspan='2' class='price_line'>&nbsp;</td>
                </tr>
                <tr>
                    <td class='price_txt1'>최소 구매자</td>
                    <td align='right'><span class='person1'>".number_format($row_product[saleCntMax])."</span> <span class='price_txt3'>명</span></td>
                </tr>
                <tr>
                    <td class='price_txt2'>현재 구매자</td>
                    <td align='right'><span class='person2'>".number_format($saleCntSum)."</span> <span class='price_txt3'>명</span></td>
                </tr>
                <tr>
                    <td colspan='2' class='price_line'>&nbsp;</td>
                </tr>
                <tr>
                    <td colspan='2' class='price_txt1'><b>".number_format($row_product[saleCntMax])."</b> 명이 구매하면 할인가격이 적용됩니다.</td>
                </tr>
            </table>
            <form name='submitFrm' action='/odprogram/odproducts/od_order.php' method='post' onsubmit='return submitFun(this)' style='display:inline'>
            <input type='hidden' name='code' value='".$row_product[code]."'>
            <div class='buy_btn'>";

if ($minStock > 0 && $row_product[code] == $info_nowsale_code && $nextSaleTime > $curr_time )
{
    if ($row_member[id])
    {
        echo "<input type='image' src='/pages/skin/3/img/btn_buy.gif' border=0 />";
    }
    else
    {
        echo "<img src='/pages/skin/3/img/btn_buy.gif' border=0 onClick=\"alert('로그인 후 구매하실수 있습니다')\" style='cursor:hand;' />";
    }
}
else
{
    echo "<img src='/pages/skin/3/img/btn_end.gif' border=0 onClick=\"alert('죄송합니다. 해당상품은 판매 종료되었습니다')\" style='cursor:hand;' />";
}
            echo "
            </div>
            </form>
        </td>
    </tr>
    <tr>
        <td valign='top'>
            <table width='100%' border='0' cellspacing='0' cellpadding='0'>
                <tr>
                    <td width='145'><img src='/pages/skin/3/img/checkpoint_title.gif' width='145' height='89'></td>
                    <td class='check'>
                        <table border='0' cellspacing='0' cellpadding='0'>
                            <tr>";


if (1 == $row_product[opt_1]) { echo "<td class='spr20'><img src='/pages/skin/3/img/checkpoint_icon_01.gif' ></td>";   }   // 주차가능
if (1 == $row_product[opt_2]) { echo "<td class='spr20'><img src='/pages/skin/3/img/checkpoint_icon_02.gif' ></td>";   }   // 예약필수
if (1 == $row_product[opt_3]) { echo "<td class='spr20'><img src='/pages/skin/3/img/checkpoint_icon_03.gif' ></td>";   }   // 주말/공휴일 사용
if (1 == $row_product[opt_4]) { echo "<td class='spr20'><img src='/pages/skin/3/img/checkpoint_icon_04.gif' ></td>";   }   // 유효기간

                            echo "
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td colspan='2' height='1' bgcolor='#c6c6c6'> </td>
                </tr>
            </table>
        </td>
    </tr>
</table>";

//-----------------------------------------------------------------------------
// 상품상세설명
//-----------------------------------------------------------------------------
echo "
<table width='950' cellpadding='0' cellspacing='0' border='0' bgcolor='#FFFFFF' id=table_layer>
    <tr>
        <td class='spb30'>".htmlspecialchars_decode($row_product[comment2])."</td>
    </tr>
</table>";

//-----------------------------------------------------------------------------
// 업체정보 & 위치정보
//-----------------------------------------------------------------------------
echo "
<table width='950' cellpadding='0' cellspacing='0' border='0' bgcolor='#FFFFFF' id=table_layer>
    <tr>
        <td class='spb30'>".htmlspecialchars_decode($row_product[onecut_img])."</td>
    </tr>
</table>";


//-----------------------------------------------------------------------------
// 상품토크
//-----------------------------------------------------------------------------
echo "
<script>
function replyDel(ttNo) {
    if(confirm('삭제하시겠습니까?')) hiddenFrame.location.href='/pages/skin/3/talktalkPro.php?proMode=del&ttNo='+ttNo;
}

function frmCheckFun(frm) { ";

if (!$row_member[id]) { echo "return false;"; }

    echo "
    if(!frm.ttContent.value) {
        alert('댓글을 입력하세요.');
        frm.ttContent.focus();
        return false;
    }

    return true;
}
</script>

<table width='950' cellpadding='0' cellspacing='0' border='0' bgcolor='#FFFFFF' id=table_layer>
    <tr>
        <td>
            <table width='100%' border='0' cellspacing='0' cellpadding='0'>
                <tr>
                    <td width='203'><a name='talk_pos'><img src='/pages/skin/3/img/talk_title.gif' width='203' height='42'></a></td>
                    <td width='727' class='talk'><b>".$row_product[mainName]."</b>에 대한 토크를 나눠보아요! </td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td align='center' class='spb30'>
            <table id='talk_box' cellpadding='0' cellspacing='0'>
                <tr>
                    <td>
                        <form name='eventFrm' action='/pages/skin/3/talktalkPro.php' method='post' target='hiddenFrame' onsubmit='return frmCheckFun(this)' style='display:inline'>
                            <input type='hidden' name='code'        value='".$row_product[code]."'>
                            <input type='hidden' name='ttNo'        value=''>
                            <input type='hidden' name='ttID'        value='".$row_member[id]."'>
                            <input type='hidden' name='ttName'      value='".$row_member[chatNickName]."'>
                            <input type='hidden' name='ttSNo'       value=''>
                            <input type='hidden' name='ttIsReply'   value='0'>
                            <input type='hidden' name='proMode'     value='ins'>";

                        if ($row_member[id])
                        {
                            echo "
                            <textarea name='ttContent' style='width:720px; height:77px'  wrap='hard'></textarea>&nbsp;";
                        }
                        else
                        {
                            echo "
                            <textarea name='ttContent' style='width:720px; height:77px' onclick=\"loginConfirm('".urlencode($_SERVER[REQUEST_URI])."');\"></textarea>&nbsp;";
                        }

                            echo "
                            <input type='image' src='/pages/skin/3/img/btn_talk_submit.gif' style='width:104; height:77; border:0;' align='absmiddle'>
                        </form>
                    </td>
                </tr>";

//-----------------------------------------------------------------------------
// 상품토크 답변화면
//-----------------------------------------------------------------------------
echo "
<span id='inputBox' style='display:none'>
<form name='form3' action='/pages/skin/3/talktalkPro.php' method='post' target='hiddenFrame' onsubmit='return frmCheckFun(this)' style='display:inline'>
    <input type='hidden' name='code'        value='".$row_product[code]."'>
    <input type='hidden' name='ttID'        value='".$row_member[id]."'>
    <input type='hidden' name='ttName'      value='".$row_member[chatNickName]."'>
    <input type='hidden' name='ttSNo'       value=''>
    <input type='hidden' name='ttIsReply'   value=''>
    <input type='hidden' name='proMode'     value='ins'>
    <div class='smtmb5'><textarea name='ttContent' style='width:650px; height:33px'  wrap='hard' class='input'></textarea> <input type='image' src='/images/group/talk_btn_submit.gif' width='62' height='33' align='absmiddle'></div>
</form>
</span>";


                    echo "
                    </td>
                </tr>
                <tr>
                    <td>
                        <span id='talktalkAjax'>
                        <table width=860 align=center border=0 cellspacing=0 cellpadding=0>
                            <tr>
                                <td height=5></td>
                            </tr>
                            <tr>
                                <td height=1 background='/images/hope_49.gif'></td>
                            </tr>
                            <tr>
                                <td height=5></td>
                            </tr>
                            <tr>
                                <td height=40 align=center><img src='/images/group/loading.gif' align=absmiddle> 데이터를 불러오고 있습니다. 잠시만 기다려 주십시요.</td>
                            </tr>
                            <tr>
                                <td height=5></td>
                            </tr>
                            <tr>
                                <td height=1 background='/images/hope_49.gif'></td>
                            </tr>
                            <tr>
                                <td height=5></td>
                            </tr>
                        </table>
                        </span>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>";

?>

<script>
function talktalkAjaxLoad(limit)
{
    param = "code=<?=$row_product[code]?>&cur_page="+limit;
    req = create_request();
    req.open("POST", "/pages/skin/3/goodtalk.php", true);
    req.setRequestHeader("Content-Type", "application/x-www-form-urlencoded;charset=UTF-8");
    req.setRequestHeader("Cache-Control","no-cache, must-revalidate");
    req.setRequestHeader("Pragma","no-cache");
    req.send(param);
    req.onreadystatechange = function ()
    {
        printHTML2();
    }
}

function printHTML2()
{
    if (req.readyState == 4 && req.status == 200)
    {
        if(!req.responseText.match('Bad Request'))
        {
            document.getElementById('talktalkAjax').innerHTML = req.responseText;
        }
    }
}



inputBoxHtml = document.getElementById('inputBox').innerHTML;
var showNo;

function replyBoxShow() {
    document.getElementById('inputBox').innerHTML = inputBoxHtml;
}

function replyBoxHidden() {
    document.getElementById('inputBox').innerHTML = '';
}

function replyBoxChange(no) {
    if(!showNo) {
        replyBoxHidden();
    } else if(showNo != no) {
        obj = eval(document.getElementById('reply_'+showNo));
        obj.innerHTML = "";
    }
}

function showReply(no) {
    replyBoxChange(no);     // 현재 열려있는 박스 삭제
    showNo = no;                    // 현재 열려있는 박스 넘버 저장

    obj = eval(document.getElementById('reply_'+no));
    obj.innerHTML = inputBoxHtml;

    // 리플에 필요한 값 저장
    frm = document.form3;
    frm.ttSNo.value = no;
    frm.proMode.value   = 'ins';
    frm.ttIsReply.value = 1;

}

window.onload = talktalkAjaxLoad;
</script>

