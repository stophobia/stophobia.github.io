<script src="/odprogram/odcommon/jquery-1.4.2.min.js"></script>
<script language="javascript">
    function ShowLocationDiv()
    {
        $('#divLocation').animate({height:60}, "slow");
        $('#tblLocation').delay(200);
        $('#tblLocation').show('fast');
        $('#divShow').hide();
        $('#divHide').show();
        
    }

    function HideLocationDiv()
    {
        $('#divLocation').animate({height:0}, "slow");
        $('#tblLocation').hide();
        $('#divShow').show();
        $('#divHide').hide();       
    }
</script>
<?
//-----------------------------------------------------------------------------
// 지역
//-----------------------------------------------------------------------------
echo "
<link href='/pages/skin/3/style.css' rel='stylesheet' type='text/css'>
<div style='height:60px; top:0;' id='divLocation'>
<table width='100%' border='0' cellspacing='0' cellpadding='0' style='display:;' id='tblLocation' align='center'>
    <tr>
        <td align='center' bgcolor='#FFFFFF' class='sptb20'>
            <table width='950' border='0' cellspacing='0' cellpadding='0'>
                <tr height='22'>";

            $Cnt = 1;
            // 지역추출 ///////////////////////////////////////////////////////
            $Query  = " SELECT * FROM odtCategory WHERE cHidden = 'no'  ";
            $Result = mysql_query($Query);
            while ($Record = mysql_fetch_array($Result))
            {
                // 해당지역에 상품이 등록되어 있는지 체크 /////////////////////
                $RecCnt = mysql_result(mysql_query(" SELECT COUNT(*) FROM odtProduct WHERE cateCode = '$Record[catecode]' "), 0);

                if ($Record[catecode] == $thiscate) { $aClass = "area_hot";     }
                else                                { $aClass = "area";         }

                    echo "
                    <td class='spl30' width='190'>&bull; ";

                if($RecCnt)
                {
                    echo "<a href='/changeArea.php?Aid=".$Record[catecode]."' class='".$aClass."'>".str_replace(' ','&nbsp;',$Record[catename])."</a>";
                }
                else
                {
                    echo "<a href='#none' onclick=\"alert('진행중인 상품이 없습니다.')\" class='".$aClass."'>".str_replace(' ','&nbsp;',$Record[catename])."</a>";
                }

                    echo "
                    </td>";

                $Cnt++;

                if (6 != $Cnt)
                {
                        echo "
                        <td width='1' bgcolor='#ededed'> </td>";
                }
                else
                {
                    echo "
                    </tr>
                    <tr height='22'>";
                    $Cnt = 1;
                }
            }
                echo "
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td height='1' bgcolor='#66696c'> </td>
    </tr>
</table>
</div>
<table width='100%' border='0' cellspacing='0' cellpadding='0' id='divShow' style='display:none;'>
    <tr>
        <td align='center'><a href='javascript:ShowLocationDiv();'><img src='/pages/skin/3/img/open.gif'></a></td>
    </tr>
</table>
<table width='100%' border='0' cellspacing='0' cellpadding='0' id='divHide'>
    <tr>
        <td align='center'><a href='javascript:HideLocationDiv();'><img src='/pages/skin/3/img/close.gif'></a></td>
    </tr>
</table>";


//-----------------------------------------------------------------------------
// 시작페이지, 친구에게 알리기, 로그인, 구독하기
//-----------------------------------------------------------------------------
echo "
<table width='950' cellpadding='0' cellspacing='0' border='0' id=table_layer>
    <tr>
        <td width='358' height='80' valign='top'>
            <div class='top_dv1'>
                <a href='#none' onclick=\"this.style.behavior='url(#default#homepage)'; this.setHomePage('http://".$_SERVER[HTTP_HOST]."');\" class='t_menu1'>시작페이지로 설정</a>
                <span class='top_sp'>|</span>
                <a href='#none' onclick='window.external.AddFavorite(document.location.href,document.title)' class='t_menu2'>즐겨찾기추가</a>
            </div>
            <div class='top_dv2'>
                <a href=\"javascript:sendFaceBook('".str_replace("'","`",$row_product[mainName] ? $row_product[mainName] : $row_product[name])."', 'http://".$_SERVER[HTTP_HOST]."?viewCode=".$row_product[code]."')\"><img src='/pages/skin/3/img/sns_01.gif' width='18' height='18'></a>
                <a href=\"javascript:sendTwitter('".str_replace("'","`",$row_product[mainName] ? $row_product[mainName] : $row_product[name])."', 'http://".$_SERVER[HTTP_HOST]."')\" ><img src='/pages/skin/3/img/sns_02.gif' width='18' height='18'></a>
                <a href=\"javascript:sendMe2Day('".str_replace("'","`",$row_product[mainName] ? $row_product[mainName] : $row_product[name])."', 'http://".$_SERVER[HTTP_HOST]."', '".$row_company[homepage_title]."', '".$row_company[homepage]."')\"><img src='/pages/skin/3/img/sns_03.gif' width='18' height='18'></a>
                <a href='#none' onclick=\"javascript:goYozmDaum('http://".$_SERVER[HTTP_HOST]."','".str_replace("'","`",$row_product[mainName] ? $row_product[mainName] : $row_product[name])."','".$row_company[homepage_title]."', '".$row_company[homepage]."')\"><img src='/pages/skin/3/img/sns_04.gif' width='18' height='18'></a>
                <a href='#none' onclick=\"javascript:sendMail('".str_replace("'","`",$row_product[mainName] ? $row_product[mainName] : $row_product[name])."','".$row_product[code]."')\" /><img src='/pages/skin/3/img/sns_05.gif' width='18' height='18'></a>
                <a href='#none' onclick=\"javascript:sendSms('".str_replace("'","`",$row_product[mainName] ? $row_product[mainName] : $row_product[name])."','".$row_product[code]."')\" /><img src='/pages/skin/3/img/sns_06.gif' width='18' height='18'></a>
            </div>
        </td>
        <td width='233' align='center'><a href='/'><img src='/pages/skin/3/img/logo.gif' width='233' height='33'></a></td>
        <td width='359' valign='top'>
            <div class='top_dv1' align='right'>";

        if ($row_member[id])
        {
                echo "
                <a href='/odprogram/odlogon/od_logout.php' class='t_menu2'>로그아웃</a>
                <span class='top_sp'>|</span>
                <a href='/odprogram/odmembers/od_modify.php' class='t_menu2'>정보수정</a>
                <span class='top_sp'>|</span>
                <a href='/?Pid=u02b01' class='t_menu2'>고객센터</a>
                <span class='top_sp'>|</span>
                <a href='/odprogram/odboard/od_board.php?board=1' class='t_menu2'>공지사항</a>
                <span class='top_sp'>|</span>
                <a href='/odprogram/odproducts/od_ordersearchresult.php' class='t_menu1'>마이페이지</a>";
        }
        else
        {
                echo "
                <a href='/odprogram/odlogon/od_login.php?path=".urlencode($_SERVER[PHP_SELF])."' class='t_menu2'>로그인</a>
                <span class='top_sp'>|</span>
                <a href='/odprogram/odmembers/od_join.php' class='t_menu2'>회원가입</a>
                <span class='top_sp'>|</span>
                <a href='/?Pid=u02b01' class='t_menu2'>고객센터</a>
                <span class='top_sp'>|</span>
                <a href='/odprogram/odboard/od_board.php?board=1' class='t_menu2'>공지사항</a>
                <span class='top_sp'>|</span>
                <a href='#none' onclick=\"loginConfirm('".urlencode("/odprogram/odproducts/od_ordersearchresult.php")."');\" class='t_menu1'>마이페이지</a>";
        }

            echo "
            </div>
            <form name='feedFrm' action='/feedPro.php' method='post' target='feedFrmFrame' style='display:inline' onsubmit='return feedFunc(this)'>
            <div class='top_dv3'>
                <span class='s'>메일</span>
                <input type='checkbox' name='emailCheck' value='1' onclick=\"if(this.checked) this.form.feedEmail.disabled=false; else this.form.feedEmail.disabled=true;\" checked>
                <input name='feedEmail' type='text'  class='t_input' style='width:90px'>
                &nbsp;<span class='s'>핸드폰</span>
                <input type='checkbox' name='smsCheck' value='1'  onclick=\"if(this.checked) this.form.feedSms.disabled=false; else this.form.feedSms.disabled=true;\" >
                <input name='feedSms' type='text' class='t_input'  disabled onkeyup='toCheck(this)' style='width:74px'>
                <input type='image' src='/pages/skin/3/img/btn_paper.gif' width='52' height='21' border=0 align='absmiddle'>
             </div>
            </form>
           <iframe name='feedFrmFrame' src='about:blank' width=0 height=0 style='display:none'></iframe>
        </td>
    </tr>
</table>";

//-----------------------------------------------------------------------------
// 오늘의티켓, 지난티켓, 티켓몰소개, 티켓몰이용안내
//-----------------------------------------------------------------------------
echo "
<table width='950' cellpadding='0' cellspacing='0' border='0' id='main_menu' align='center'>
    <tr>
        <td>
            <table width='100%' border='0' cellspacing='0' cellpadding='0'>
                <tr>
                    <td>
                        <table border='0' cellspacing='0' cellpadding='0'>
                            <tr>
                                <td class='splr25'><a href='/' onMouseOut='MM_swapImgRestore()' onMouseOver=\"MM_swapImage('Image10','','/pages/skin/3/img/main_menu01_hot.gif',0)\"><img src='/pages/skin/3/img/main_menu01"; if ($_GET[main] == 'coupon') { echo "_hot"; } echo ".gif' name='Image10' width='71' height='16' border='0'></a></td>
                                <td width='1' bgcolor='#636363'> </td>
                                <td class='splr25'><a href='/pages/skin/3/old.php' onMouseOut='MM_swapImgRestore()' onMouseOver=\"MM_swapImage('Image11','','/pages/skin/3/img/main_menu02_hot.gif',0)\"><img src='/pages/skin/3/img/main_menu02"; if (ereg("old.php",$_SERVER[PHP_SELF])) { echo "_hot"; } echo ".gif' name='Image11' width='58' height='16' border='0'></a></td>
                                <td width='1' bgcolor='#636363'> </td>
                                <td class='splr25'><a href='/?Pid=u04b04' onMouseOut='MM_swapImgRestore()' onMouseOver=\"MM_swapImage('Image12','','/pages/skin/3/img/main_menu03_hot.gif',0)\"><img src='/pages/skin/3/img/main_menu03"; if ($_GET[Pid] == 'u04b04') { echo "_hot"; } echo ".gif' name='Image12' width='70' height='16' border='0'></a></td>
                                <td width='1' bgcolor='#636363'> </td>
                                <td class='splr25'><a href='/?Pid=u04b09' onMouseOut='MM_swapImgRestore()' onMouseOver=\"MM_swapImage('Image13','','/pages/skin/3/img/main_menu04_hot.gif',0)\"><img src='/pages/skin/3/img/main_menu04"; if ($_GET[Pid] == 'u04b09') { echo "_hot"; } echo ".gif' name='Image13' width='98' height='16' border='0'></a></td>
                            </tr>
                        </table>
                    </td>
                    <td align='right'>
                        <table border='0' cellspacing='0' cellpadding='0'>
                            <tr>";

    // 전날상품 ///////////////////////////////////////////////////////////////
    $prevCode = @mysql_result(mysql_query("select code from odtProduct where sale_date < '".$row_product[sale_date]."' and cateCode = '".$thiscate."' and code = parent_code order by sale_date desc limit 1"), 0);
    if ($prevCode)
    {
        echo "<td><a href='/?cateCode=".$thiscate."&viewCode=".$prevCode."'><img src='/pages/skin/3/img/today_arrow1.gif' width='15' height='20'></a></td>";
    }
                                            echo "
                                            <td class='splr15' align='center'>";

    // 해당 상품의 등록일 출력 부분 ///////////////////////////////////////////
    echo "
    <img src='/pages/skin/3/img/today_num_".sprintf("%02d", substr($row_product[sale_date], 0, 1)).".gif'><img src='/pages/skin/3/img/today_num_".sprintf("%02d", substr($row_product[sale_date], 1, 1)).".gif' ><img src='/pages/skin/3/img/today_num_".sprintf("%02d", substr($row_product[sale_date], 2, 1)).".gif' ><img src='/pages/skin/3/img/today_num_".sprintf("%02d", substr($row_product[sale_date], 3, 1)).".gif' >
    <img src='/pages/skin/3/img/today_space.gif' width='19' height='20'>
    <img src='/pages/skin/3/img/today_num_".sprintf("%02d", substr($row_product[sale_date], 5, 1)).".gif' ><img src='/pages/skin/3/img/today_num_".sprintf("%02d", substr($row_product[sale_date], 6, 1)).".gif' >
    <img src='/pages/skin/3/img/today_space.gif' width='19' height='20'>
    <img src='/pages/skin/3/img/today_num_".sprintf("%02d", substr($row_product[sale_date], 8, 1)).".gif' ><img src='/pages/skin/3/img/today_num_".sprintf("%02d", substr($row_product[sale_date], 9, 1)).".gif' >";
                                            
                                            echo "
                                            </td>";

    // 다음상품 ///////////////////////////////////////////////////////////////
    $nextCode = @mysql_result(mysql_query("select code from odtProduct where sale_date > '".$row_product[sale_date]."' and sale_date <= '".date("Y-m-d")."' and cateCode = '".$thiscate."' and code = parent_code order by sale_date asc limit 1"), 0);
    if($nextCode)
    {
        echo "<td><a href='/?cateCode=".$thiscate."&viewCode=".$nextCode."'><img src='/pages/skin/3/img/today_arrow2.gif' width='15' height='20'></a></td>";
    }
                            echo "
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>";

//-----------------------------------------------------------------------------
// 구매리포트, 알리미다운로드, 배너달기
//-----------------------------------------------------------------------------
echo "
<div style='Z-INDEX: 1; LEFT: 0px; WIDTH: 0px; POSITION: relative; TOP: 0px; HEIGHT: 0px;display:'>
<div style='Z-INDEX: 1; LEFT: -570px; WIDTH: 0px; POSITION: absolute; TOP: 0px; HEIGHT: 0px'>
<table cellpadding='0' cellspacing='0'>
    <tr><td><a href='/pages/skin/3/report.php'><img src='/pages/skin/3/img/banner_01.jpg' width='89' height='106'></a></td></tr>
    <tr><td><a href='/onedaynet_alimi.exe'><img src='/pages/skin/3/img/banner_02.jpg' width='89' height='122'></a></td></tr>
    <tr><td height='5'></td><tr>
    <tr><td><a href='/pages/skin/3/banner.php'><img src='/pages/skin/3/img/banner_event.jpg' width='89' height='173'></a></td><tr>
    </tr>
</table>
</div>
</div>";

// 서브페이지일때는 페이지에 따른 head부분을 추출 /////////////////////////////
include $_SERVER[DOCUMENT_ROOT]."/pages/skin/$row_setup[P_SKIN]/subhead.php";

?>