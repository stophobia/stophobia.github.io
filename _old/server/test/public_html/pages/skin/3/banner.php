<?
include $_SERVER[DOCUMENT_ROOT]."/odprogram/odcommon/od_config.inc.php";
include $_SERVER[DOCUMENT_ROOT]."/odprogram/odcommon/od_lib.inc.php";
include $_SERVER[DOCUMENT_ROOT]."/odprogram/odcommon/od_function.inc.php";
include $_SERVER[DOCUMENT_ROOT]."/odprogram/odcommon/od_head.inc.php";

include $_SERVER[DOCUMENT_ROOT]."/pages/subHead.html";


$row_product = mysql_fetch_array(mysql_query("select * from odtProduct where code = '".info_nowsale($thiscate)." '"));

echo "
<script>
function banner_copy(obj){ 
        var doc = document.all[obj].createTextRange(); 
        document.all[obj].select(); 
        doc.execCommand('copy'); 
        alert(\"배너가 복사 되었습니다. Ctrl + V로 붙여넣기를 하세요.\"); 
} 
function banner_copy2(obj){ 
        var doc = document.all[obj].createTextRange(); 
        document.all[obj].select(); 
        doc.execCommand('copy'); 
        alert(\"배너가 복사 되었습니다. Ctrl + V로 붙여넣기를 하세요.\"); 
} 
</script>
<link href='/pages/skin/3/style.css' rel='stylesheet' type='text/css'>
<iframe name='hiddenFrame' src='about:blank' width='100px' height='100px' style='display:none'></iframe>

<table width='950' cellpadding='0' cellspacing='0' border='0' bgcolor='#FFFFFF'>
    <tr>
        <td align='center' class='sptb30'>
            <table width='886' border='0' cellspacing='0' cellpadding='0'>
                <tr>
                    <td><img src='/pages/skin/3/img/sub_title_event.gif' width='440' height='43'></td>
                </tr>
            </table>
            <table id='tt_line' cellpadding='0' cellspacing='0'>
                <tr><td> </td></tr>
            </table>
            <table width='886' border='0' cellspacing='0' cellpadding='0' class='smb40'>
                <tr>
                    <td><img src='/pages/skin/3/img/point_con_01.gif' width='892' height='348'></td>
                </tr>
                <tr>
                    <td><img src='/pages/skin/3/img/point_con_02.gif' width='210' height='42'></td>
                </tr>
                <tr>
                    <td>
                        <table width='677' border='0' cellpadding='10' cellspacing='1' bgcolor='#b2b2b2'>
                            <tr>
                                <td align='center' bgcolor='#FFFFFF'>";

if ($row_member[id])
{
    echo "
    <table width='100%' border='0' cellspacing='0' cellpadding='0'>
        <tr>
            <td>
                <input name='texturl' type='text' style='width:577px; height:29px; border:1px solid #e3e1e1; font:12px 돋움; color:#999999' value='http://".$_SERVER[HTTP_HOST]."/?hID=".$row_member[hID]."'>
            </td>
            <td width='80' align='right'><img src='/pages/skin/3/img/popup_img_26.jpg' width='75' height='30' onclick=\"banner_copy2('texturl')\" style='cursor:hand;'></td>
        </tr>
    </table>";
}
else
{
    echo "
    <table width='100%' border='0' cellspacing='0' cellpadding='0'>
        <tr>
            <td>
                <input name='textfield' type='text' id='textfield' style='width:577px; height:29px; border:1px solid #e3e1e1; font:12px 돋움; color:#999999' value='로그인 하시면 회원님의 홍보URL을 볼수 있습니다.' onclick=\"loginConfirm('".urlencode("/pages/skin/3/banner.php")."')\">
            </td>
            <td width='80' align='right'><img src='/pages/skin/3/img/popup_img_26.jpg' width='75' height='30'  onclick=\"loginConfirm('".urlencode("/pages/skin/3/banner.php")."')\" style='cursor:hand;'></td>
        </tr>
    </table>";
}

                                echo "
                                </td>
                            </tr>
                        </table>
                        <p>- 복사된 주소를 메신저 대화창이나 게시판에 올려보세요~<BR>
                        - 적립금을 얻기위해 불공정한 방법으로 클릭을 유도할 경우엔 적립된 모든 금액이   취소되오니 참고해 주세요.</p>
                    </td>
                </tr>
                <tr>
                    <td><img src='/pages/skin/3/img/point_con_03.gif' width='241' height='93'></td>
                </tr>
                <tr>
                    <td>
                        <table width='677' border='0' cellpadding='10' cellspacing='1' bgcolor='#b2b2b2'>
                            <tr>
                                <td align='center' bgcolor='#FFFFFF'>
                                    <table width='100%' border='0' cellspacing='0' cellpadding='0'>
                                        <tr>
                                            <td>
                                                <table width='158' border='0' cellpadding='0' cellspacing='1' bgcolor='#e3e1e1'>
                                                    <tr>
                                                        <td height='81' align='center' bgcolor='#FFFFFF'><img src='".$row_product[banner_img]."' width='153' height='44'></td>
                                                    </tr>
                                                </table>
                                            </td>";

if ($row_member[id])
{
                                            echo "
                                            <td align='right'>
                                                <textarea  id='imgurl' name='ttContent' style='width:395px; height:80px;font-family:Arial;line-height:140%'><a href='http://".$_SERVER[HTTP_HOST]."/?hID=".$row_member[hID]."' target='_blank'><img  src='http://".$_SERVER[HTTP_HOST].$row_product[banner_img]."' border=0></a></textarea>
                                            </td>
                                            <td width='80' align='right'><img src='/pages/skin/3/img/popup_img_30.jpg' width='75' height='81' onclick=\"banner_copy2('imgurl')\" style='cursor:hand;'></td>";
}
else
{
                                            echo "
                                            <td align='right'>
                                                <input name='textfield2' type='text' id='textfield2' style='width:410px; height:81px; border:1px solid #e3e1e1; font:12px 돋움; color:#999999' value='로그인 하시면 회원님의 홍보URL을 볼수 있습니다.'  onclick=\"loginConfirm('".urlencode("/pages/skin/3/banner.php")."')\" style='cursor:hand;'>
                                            </td>
                                            <td width='80' align='right'><img src='/pages/skin/3/img/popup_img_30.jpg' width='75' height='81'  onclick=\"loginConfirm('".urlencode("/pages/skin/3/banner.php")."')\" style='cursor:hand;'></td>";
}
                                        echo "
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>
                        <p>- 이미지 사이즈 : 153*44<BR>
                        - 네이버 블로그나 티스토리 등 블로그를 운영하시는 분이라면 블로그에 부탁해보세요.</p>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>";

include $_SERVER[DOCUMENT_ROOT]."/pages/subFoot.html";


?>