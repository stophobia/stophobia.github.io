<?


echo "
<table width='960' border='0' cellspacing='0' cellpadding='0' align=center>
    <tr>
        <td width='200' height='78'><a href='/'><img src='/images/group/top_logo.gif' width='200' height='57' style='border:0;'></a></td>";

// 회원 로그인 & 로그아웃 /////////////////////////////////////////////////////
if (!$row_member[id])
{
    echo "
    <script language='javascript'>
    function valueCheck3(form) {

        var form = document.snsForm3;
        if(!form.id.value || form.id.value == '아이디') {
            alert('회원님의 아이디를 입력해 주세요.   ');
            form.id.focus();
            return false;
        }
        if(!form.passwd.value || form.passwd.value == 'passwd') {
            alert('회원님의 비밀번호를 입력해 주세요.   ');
            form.passwd.focus();
            return false;
        }
    }
    </script>
        <td align='right' valign='bottom' class='spb15'>
        <form name='snsForm3' method='post' action='/odprogram/odlogon/od_loginForm.php' onSubmit='return valueCheck3(this)' style='display:inline'>
        <input type='hidden' name='_move_path' value='".$_SERVER[REQUEST_URI]."'>
            <input name='id' type='text' class='input' style='width:100px;line-height:160%' value='아이디' onfocus=\"if (this.value=='아이디') this.value=''\">
            <input name='passwd' type='password'  class='input' style='width:100px;line-height:160%' value='passwd' onfocus=\"if(this.value=='passwd') this.value='';\">
            <input type='image' src='/images/group/btn_top_login.gif' width='45' height='19' align='absmiddle' style='border:0px' >
        </form> 
        </td>";
}
else
{
        echo "
        <td align='right' valign='bottom' class='spb15'>
            <span class='green_11B'>" . $row_member[name] . "</span><span class='s'>님께서 로그인되셨습니다. </span><a href='/odprogram/odlogon/od_logout.php'><img src='/images/group/btn_top_logout.gif' width='51' height='19' align='absmiddle' border=0></a>
        </td>";
}
        echo "
        <td width='263' align='center' valign='bottom' class='spb17'>
           <table border='0' cellspacing='0' cellpadding='0'>
               <tr>";

                if (!$row_member[id])
                {
                    echo "
                    <td><a href='/odprogram/odmembers/od_join.php' class='gnb'>회원가입</a></td>
                    <td><img src='/images/group/top_menu_space.gif' width='13' height='10'></td>
                    <td><a href='/?Pid=u02b01' class='gnb'>고객센터</a></td>
                    <td><img src='/images/group/top_menu_space.gif' width='13' height='10'></td>
                    <td><a href='/odprogram/odboard/od_board.php?board=1' class='gnb'>공지사항</a></td>
                    <td><img src='/images/group/top_menu_space.gif' width='13' height='10'></td>
                    <td><a href='/odprogram/odlogon/od_login.php?path=".urlencode('/odprogram/odproducts/ordersearchresult.php')."' class='gnb'><span class='green_11B'>주문조회</span></a></td>";
                }
                else
                {
                    echo "
                    <td><a href='/odprogram/odmembers/od_modify.php' class='gnb'>정보수정</a></td>
                    <td><img src='/images/group/top_menu_space.gif' width='13' height='10'></td>
                    <td><a href='/?Pid=u02b01' class='gnb'>고객센터</a></td>
                    <td><img src='/images/group/top_menu_space.gif' width='13' height='10'></td>
                    <td><a href='/odprogram/odboard/od_board.php?board=1' class='gnb'>공지사항</a></td>
                    <td><img src='/images/group/top_menu_space.gif' width='13' height='10'></td>
                    <td><a href='/odprogram/odproducts/od_ordersearchresult.php' class='gnb'><span class='green_11B'>주문조회</span></a></td>";
                }

                echo "
                </tr>
            </table>
        </td>
    </tr>
</table>";

echo "
<table width='100%'  bgcolor='#333333' cellpadding='0' cellspacing='0' border='0'>
    <tr>
        <td height='37' align='center'>
    
            <table width='960' border='0' cellspacing='0' cellpadding='0'>
                <tr>
                    <td>
                        <a href='/' onMouseOut='MM_swapImgRestore()' onMouseOver=\"MM_swapImage('Image6','','/images/group/menu_01_on_.gif',0)\"><img src='/images/group/menu_01"; if ($_GET[main] == 'coupon') { echo "_on_"; } else { echo ""; } echo ".gif' name='Image6' width='59' height='12' border='0'></a>
                        <img src='/images/group/menu_space.gif'>
                        <a href='/?main=old&cateCode=".$thiscate."' onMouseOut='MM_swapImgRestore()' onMouseOver=\"MM_swapImage('Image8','','/images/group/menu_02_on_.gif',0)\"><img src='/images/group/menu_02"; if ($_GET[main] == 'old') { echo "_on_"; } else { echo ""; } echo ".gif' name='Image8' width='66' height='12' border='0'></a>
                        <img src='/images/group/menu_space.gif'>
                        <a href='#none'  onclick=\"window.open('/pages/etc/goodsFeed.php','','width=530,height=580')\" onMouseOut='MM_swapImgRestore()' onMouseOver=\"MM_swapImage('Image10','','/images/group/menu_03_hot.gif',0)\"><img src='/images/group/menu_03.gif' name='Image10' width='90' height='12' border='0'></a>
                        <img src='/images/group/menu_space.gif'>
                        <a href='/?Pid=u04b04' onMouseOut='MM_swapImgRestore()' onMouseOver=\"MM_swapImage('Image12','','/images/group/menu_04_hot.gif',0)\"><img src='/images/group/menu_04"; if ($_GET[Pid] == 'u04b04') { echo "_on_"; } else { echo ""; } echo ".gif' name='Image12' width='43' height='12' border='0'></a>
                    </td>
                    <td width='263'>";

    // 다른지역 선택 //////////////////////////////////////////////////////////
    $nowAreaName = @mysql_result(mysql_query("select catename from odtCategory where catecode = '$thiscate' "),0);

                        echo "
                        <table width='263' border='0' cellspacing='0' cellpadding='0'>
                            <tr>
                                <td><img src='/images/group/area_line1.gif' width='2' height='37'></td>
                                <td width='259' align='center'>
                                    <table width='250' border='0' cellspacing='0' cellpadding='0'>
                                        <tr>
                                            <td align='center'><a span class='area' >".$nowAreaName."</span></td>
                                            <td align='center' width='10'><img src='/images/group/area_space.gif'></td>
                                            <td align='center' width='107'><a href='#none' onclick=\"if(document.getElementById('areaLayer').style.display=='') document.getElementById('areaLayer').style.display='none'; else document.getElementById('areaLayer').style.display='';\" class='area'><span style='color:#FFFFFF'>다른지역보기</span> <img src='/images/group/area_arrow.gif' width='13' height='12' align='absmiddle'></a></td>
                                        </tr>
                                    </table>
                                </td>
                                <td><img src='/images/group/area_line2.gif' width='2' height='37'></td>
                            </tr>
                        </table>

                        <div id='areaLayer' style='Z-INDEX: 1; LEFT: 0px; WIDTH: 0px; POSITION: relative; TOP: -1px; HEIGHT: 0px;display:none'> 
                            <div style='Z-INDEX: 1; LEFT: 0px; WIDTH: 23px; POSITION: absolute; TOP: 0px; HEIGHT: 0px'>
                                <table width='263' cellpadding='0' cellspacing='0' border='0'>
                                    <tr>
                                        <td height='1' bgcolor='#000000'> </td>
                                    </tr>
                                    <tr>
                                        <td style=\"border-style:solid; border-width:1px; border-color:#4c4c4c;background-color='#333333'\" class='sp10'>";

                        $aQue = " select * from odtCategory where catecode != '$thiscate' and cHidden = 'no'    ";
                        $aRes = mysql_query($aQue);
                        while($aRow = mysql_fetch_array($aRes))
                        {
                            $isProCnt = mysql_result(mysql_query(" select count(*) from odtProduct where cateCode = '$aRow[catecode]' "),0);
                            
                            if($isProCnt)
                            {
                                echo "<a href='/changeArea.php?Aid=".$aRow[catecode]."' class='area'>&bull; ".str_replace(' ','&nbsp;',$aRow[catename])."</a>";
                            }
                            else
                            {
                                echo "<a href='#none' onclick=\"alert('진행중인 상품이 없습니다.')\" class='area'>&bull; ".str_replace(' ','&nbsp;',$aRow[catename])."</a>";
                            }
                        }
                                        echo "
                                        </td>
                                    </tr>
                                    <tr>
                                        <td height='1' bgcolor='#000000'> </td>
                                    </tr>
                                </table>
                            </div>
                        </div>

                    </td>
                </tr>
            </table>

        </td>
    </tr>
</table>";

// 알리미 /////////////////////////////////////////////////////////////////////
echo "
<script language='javascript' src='/layerjs.js'></script> 
<div id='divMenu' style='Z-INDEX: 1; LEFT: 0px; WIDTH: 0px; POSITION: relative; TOP: 0px; HEIGHT: 0px;display:'> 
    <div  style='Z-INDEX: 1; LEFT: 510px; WIDTH: 23px; POSITION: absolute; TOP: 170px; HEIGHT: 0px'>
        <a href='/onedaynet_alimi.exe'><img src='/images/group/alimi.jpg' border=0></a>
    </div>
</div>
<script language=javascript> 
<!--
if (isNS4) {
 var divMenu = document['divMenu'];
 divMenu.top = top.pageYOffset;
 divMenu.visibility = 'visible';
 moveRightEdge();
} else if (isDOM) {
 var divMenu = getRef('divMenu');
 divMenu.style.top = (isNS ? window.pageYOffset : document.body.scrollTop);
 divMenu.style.visibility = 'visible';
 moveRightEdge();
}
//-->
</script>";


# 서브 head 부분 //////////////////////////////////////////////////////////////
include $_SERVER[DOCUMENT_ROOT]."/pages/skin/1/subhead.php";


?>