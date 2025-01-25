<?
//-----------------------------------------------------------------------------
// 상품토크 목록
//-----------------------------------------------------------------------------
include $_SERVER[DOCUMENT_ROOT]."/odprogram/odcommon/od_config.inc.php";
include $_SERVER[DOCUMENT_ROOT]."/odprogram/odcommon/od_function.inc.php";
include $_SERVER[DOCUMENT_ROOT]."/odprogram/odcommon/od_lib.inc.php";

//-----------------------------------------------------------------------------
// 사용변수의 지정및 초기화
//-----------------------------------------------------------------------------
$start_rec     = 0;     // 현페이지의 시작레코드번호
$tot_rec       = 0;     // 전체건수
$tot_page      = 0;     // 전체페이지수
$start_page    = 0;     // 현스케일의 시작페이지번호
$end_page      = 0;     // 현스케일의 최종페이지번호
$cur_page;              // 현페이지
$cur_rec       = 0;     // 현레코드
$seq           = 0;     // 현레코드 번호
$count         = 0;     // 현페이지의 취득레코드건수
$max_row       = 5;     // 페이지의 표시행수
$max_page      = 100;   // 한스케일당 표시페이지수
$max_bigo      = 40;    // 비고란의 최대표시문자열
$pre_page      = 0;     // 이전페이지
$next_page     = 0;     // 다음페이지

echo "
<table width='100%' align=center border=0 cellspacing=0 cellpadding=0>";

//-----------------------------------------------------------------------------
// 상품토크 공지목록
//-----------------------------------------------------------------------------
$Query  = " SELECT a.*,b.pic FROM odtTt as a, odtMember as b WHERE a.ttProCode = '".$code."' AND (a.ttIsNotice = 'AN' OR a.ttIsNotice = 'SN') AND a.ttID = b.id ORDER BY ttIsNotice ASC ";
$Result = mysql_query($Query);
while ($Record = mysql_fetch_array($Result))
{
    $Record[ttContent] = str_replace(array("<", ">", "'", '"', '\"'), array("&lt", "&gt;", "&#39;", "&#39;", "&quot;"), $Record[ttContent]);

    echo "
    <tr>
        <td bgcolor='#d1cfcf'>
            <table width='100%' cellpadding='5' cellspacing='5' border='0'>
                <tr>
                    <td width='70' valign='top' class='spr30'><span class='black_14'>".$Record[ttID]."</span></td>
                    <td class='black'>".nl2br(stripslashes($Record[ttContent]))."&nbsp;&nbsp;&nbsp;";
                                                
if ($row_member[id])
{
    echo "<a href='#none' onclick=\"replyDel('".$Record[ttNo]."')\"><img src='/images/group/talk_del.gif' align='absmiddle' border=0></a>";
}
                    echo "
                    </td>
                </tr>
                <tr>
                    <td colspna='2' height='10px'></td>
                </tr>
            </table>
        </td>
    </tr>";
}

//-----------------------------------------------------------------------------
// 상품토크 일반목록
//-----------------------------------------------------------------------------
    echo "
    <tr>
        <td height='20px;'></td>
    </tr>
    <tr>
        <td>";

$Query  = " SELECT * FROM odtTt WHERE ttProCode = '".$code."' AND ttIsReply != '1' AND ttIsNotice = 'N'  ORDER BY ttSNo DESC    ";
$Result = mysql_query($Query);
$RecCnt = mysql_num_rows($Result);

if (0 < $RecCnt) 
{
    $date     = date("Y-m-d H:i:s", $now);
    $tot_page = ceil($RecCnt / $max_row);                    // 전체페이지수
    $cur_page  = ($cur_page == 0 ? 1 : $cur_page);           // 현재의페이지
    $start_rec = ($cur_page * $max_row) - $max_row;          // 시작레코드번호
    $seq = $start_rec + 1;

    if ($cur_page == $tot_page) { $count = ($tot_rec % $max_row) == 0 ? $max_row : ($tot_rec % $max_row);   }
    else                        { $count = $max_row;    }

    $start_page = (ceil($cur_page / $max_page) - 1) * $max_page + 1;
    $end_page   = $start_page + 9;
    if ($end_page > $tot_page) { $end_page = $tot_page; }
    $pre_page   = $start_page - $max_page;
    $next_page  = $end_page + 1;

    // 페이지별 레코드추출과 표시 /////////////////////////////////////////////
    $Query .= " LIMIT $start_rec, $count ";
    $Result = mysql_query($Query);

    while ($Record = mysql_fetch_array($Result))
    {
        $Record[ttContent] = str_replace(array("<", ">", "'", '"', '\"'), array("&lt", "&gt;", "&#39;", "&#39;", "&quot;"), $Record[ttContent]);

            echo "
            <table width='100%' cellpadding='5' cellspacing='5' border='0' class='smb20'>
                <tr>
                    <td width='70' valign='top' class='spr30'><strong>".$Record[ttID]."</strong></td>
                    <td class='spb20'>".nl2br(stripslashes($Record[ttContent]))."&nbsp;&nbsp;&nbsp;<span class='grey_s'>".date('m.d H:i',strtotime($Record[ttRegidate]))."</span>&nbsp;";

        // 공지버튼 ///////////////////////////////////////////////////////////////
        if (@array_key_exists($row_member[id], $array_adminid) == true)
        {
            if ($Record[isImg] == "md")
            {
                echo "<input type='checkbox' name='nType' onclick=\"if(confirm('해당 토크를 공지로 지정하겠습니까?')) { hiddenFrame.location.href='/pages/etc/talktalkNotice.php?nType=AN&ttNo=".$Record[ttNo]."';} else this.checked=false;\">공지";
            }
            else if ($Record[isImg] == "seller")
            {
                echo "<input type='checkbox' name='nType' onclick=\"if(confirm('해당 토크를 공지로 지정하겠습니까?')) { hiddenFrame.location.href='/pages/etc/talktalkNotice.php?nType=SN&ttNo=".$Record[ttNo]."';} else this.checked=false;\">공지";
            }
        }


        echo "
        <a href='#none' onclick=\""; if ($row_member[id]) { echo "showReply('".$Record[ttNo]."')\""; } else { echo "loginConfirm('/')\""; } echo " ><img src='/pages/skin/3/img/btn_talk_reple.gif' width='18' height='11'></a>&nbsp;";

        if ($row_member[id])
        {
            echo "<a href='#none' onclick=\"replyDel('".$Record[ttNo]."')\"><img src='/pages/skin/3/img/btn_talk_del.gif' ></a>";
        }
                    echo "
                    <span id='reply_".$Record[ttNo]."'></span>
                    </td>
                </tr>";


        // 답변글이 있을경우에 출력 부분 //////////////////////////////////////////
        $sQuery  = " SELECT * FROM odtTt WHERE ttProCode ='".$code."' AND ttSNo ='".$Record[ttNo]."' AND ttIsReply = '1' ORDER BY ttRegidate ";
        $sResult = mysql_query($sQuery);
        $sRecCnt = mysql_num_rows($sResult);

        if ($sRecCnt)
        {
                echo "
                <tr>
                    <td valign='top'>&nbsp;</td>
                    <td>";
            while ($sRecord = mysql_fetch_array($sResult))
            {
                $sRecord[ttContent] = str_replace(array("<", ">", "'", '"', '\"'), array("&lt", "&gt;", "&#39;", "&#39;", "&quot;"), $sRecord[ttContent]);
                        echo "
                        <table width='100%' border='0' cellspacing='0' cellpadding='0' class='smb10'>
                            <tr>
                                <td class='spr30' valign='top' width='80'><img src='/pages/skin/3/img/btn_talk_reple2.gif' width='14' height='11'><b>".$sRecord[ttID]."</b></td>
                                <td>".nl2br(stripslashes($sRecord[ttContent]))."&nbsp;&nbsp; <a href='#none' onclick='replyDel(".$sRecord[ttNo].")'><img src='/pages/skin/3/img/btn_talk_del.gif' ></a></td>
                            </tr>
                        </table>";
            }
                    echo "
                    </td>
                </tr>";
        }

                echo "
                <tr>
                    <td colspan='2' background='/pages/skin/3/img/line_bg01.gif'> </td>
                </tr>
            </table>";
    }
}
        echo "
        </td>
    </tr>
    <tr>
        <td>
            <table id='paging'>
                <tr>
                    <td>";
                    
    for ($loop_1 = $start_page; $loop_1 <= $end_page; $loop_1++)
    {
        if ($loop_1 == $cur_page)
        {
            echo "<a href='#none' class='p_num1'>$loop_1</a>&nbsp; ";
        }
        else
        {
            echo "<a href='#none' onClick=\"talktalkAjaxLoad('$loop_1');\" class='p_num2'>$loop_1</a>&nbsp; ";
        }
    }
                    echo "
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>";


?>