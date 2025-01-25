<?
//-----------------------------------------------------------------------------
// 지난상품보기
//-----------------------------------------------------------------------------
include $_SERVER[DOCUMENT_ROOT]."/odprogram/odcommon/od_config.inc.php";
include $_SERVER[DOCUMENT_ROOT]."/odprogram/odcommon/od_lib.inc.php";
include $_SERVER[DOCUMENT_ROOT]."/odprogram/odcommon/od_function.inc.php";
include $_SERVER[DOCUMENT_ROOT]."/odprogram/odcommon/od_head.inc.php";

include $_SERVER[DOCUMENT_ROOT]."/pages/subHead.html";

echo "
<script>
function encore(code) {";

if (!$row_member[id]) { echo "alert('앵콜 투표는 회원만 참여할 수 있습니다.');return false"; }

    echo "
    if(confirm('앵콜투표에 참여하시겠습니까?')) {
        hiddenFrame.location.href='/pages/u05/encorePro.php?code='+code;
    }
}
</script>
<iframe name='hiddenFrame' src='about:blank' width='100px' height='100px' style='display:none'></iframe>";


// 다이어리 시작 //////////////////////////////////////////////////////////////
if ("" == $YEAR ) { $YEAR  = date("Y"); }
if ("" == $MONTH) { $MONTH = date("m"); }

if ("before" == $DIARY_KBN)
{
    $MONTH = $MONTH - 1;
    if (0 == $MONTH) { $YEAR = $YEAR - 1; $MONTH = 12;  }
}

if ("next" == $DIARY_KBN)
{
    $MONTH = $MONTH + 1;
    if (13 == $MONTH) { $YEAR  = $YEAR + 1; $MONTH = 1; }
}

$LAST_DAY    = date("d",mktime(0,0,0,$MONTH+1,0,$YEAR));
$FIRST_WEEK  = date("w",mktime(0,0,0,$MONTH,1,$YEAR));
$SYSDATE     = date("Y-m-d");
$CURRENT_DAY = date("d");

$MONTH = sprintf("%02d" , $MONTH);

echo "
<link href='/pages/skin/3/style.css' rel='stylesheet' type='text/css'>
<form name='PUBLIC_FORM' method='post' action='$PHP_SELF'>
<input type='hidden' name='DIARY_KBN'   value='$DIARY_KBN'>
<input type='hidden' name='YEAR'        value='$YEAR'>
<input type='hidden' name='MONTH'       value='$MONTH'>
<table width='950' cellpadding='0' cellspacing='0' border='0' bgcolor='#FFFFFF'>
    <tr>
        <td align='center' class='sptb30'>
            <!--서브타이틀 & 서브메뉴-->
            <table width='886' border='0' cellspacing='0' cellpadding='0'>
                <tr>
                    <td width='146'><img src='/pages/skin/3/img/sub_title_old.gif' width='170' height='43'></td>
                    <td>
                        <table border='0' cellspacing='0' cellpadding='0' class='sml30'>
                            <tr>
                                <td><img src='/pages/skin/3/img/month_arrow1.gif' width='23' height='24' onClick=\"document.PUBLIC_FORM.DIARY_KBN.value='before'; PUBLIC_FORM.submit();\" style='cursor:hand;'></td>
                                <td align='center' valign='top' class='on_month'>".$YEAR.".".$MONTH."</td>
                                <td><img src='/pages/skin/3/img/month_arrow2.gif' width='23' height='24' onClick=\"document.PUBLIC_FORM.DIARY_KBN.value='next';   PUBLIC_FORM.submit();\" style='cursor:hand;'></td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
            <table id='tt_line' cellpadding='0' cellspacing='0'>
                <tr><td> </td></tr>
            </table>
            <table cellpadding='0' cellspacing='1' border='0' id='calendar_box'>
                <tr>
                    <td class='box_td1'>SUN</td>
                    <td class='box_td2'>MON</td>
                    <td class='box_td2'>TUE</td>
                    <td class='box_td2'>WED</td>
                    <td class='box_td2'>THU</td>
                    <td class='box_td2'>FRI</td>
                    <td class='box_td2'>SAT</td>
                </tr>";



	// 시간 변경 추가 - 2011-01-20 - onedaynet jjc
	$thisMonth = $YEAR."-".$MONTH ;
	$arr_pro = array();
	$ires = mysql_query("
		select p.* , c.catename from odtProduct as p 
		inner join odtCategory as c on (c.catecode=p.cateCode) 
		where 
			p.cateCode='".$thiscate."' 
			and ( 
				p.sale_date between '". $thisMonth . "-01 00:00:00' and '" . $thisMonth . "-31 23:59:59' 
				or
				p.sale_enddate between '". $thisMonth . "-01 00:00:00' and '" . $thisMonth . "-31 23:59:59' 
			)
			and p.code=p.parent_code 
	");
	while( $r = mysql_fetch_assoc( $ires ) ) {
		foreach( $r as $k=>$v ){
			$arr_pro[$r[serialnum]][$k] = $v;
			if( $k == "sale_enddate" && $v == "0000-00-00" ) {
				$arr_pro[$r[serialnum]][$k] = date("Y-m-d" , strtotime($r[sale_date]) + 3600*24 - 1 );
			}
		}
	}
	$today_date = date("Y-m-d");
	$arr_date_pro = array();
	for( $i=1; $i<=31; $i++ ){
		foreach( $arr_pro as $k=>$v ){
			$app_date = $thisMonth . "-" .sprintf("%02d" , $i);
			$app_nextdate = date("Y-m-d" , strtotime($v[sale_enddate] . " " . $row_setup[changeTime] . ":00:00") -1);
			if( $v[sale_date]<= $app_date && $app_nextdate >= $app_date && $app_date < $today_date ) {
				foreach( $v as $sk=>$sv ){
					$arr_date_pro[$app_date][$k][$sk] = $sv;
				}
			}
		}
	}


$WEEK_CNT = 0;
for($CNT = 0; $CNT < $FIRST_WEEK; $CNT++)
{
    echo "<td class='box_td4' valign='top'>&nbsp;</td>";
    $WEEK_CNT++;
}

for($CNT = 1; $CNT <= $LAST_DAY; $CNT++)
{
    $TEMP_DATE  = $YEAR."-".sprintf("%02d", $MONTH)."-".sprintf("%02d", $CNT);

    $WEEK_CNT++;
    $DAY = sprintf("%02d",$CNT);

    if( 7 < $WEEK_CNT ) { echo "</tr><tr height='90'>";     }

    echo "
    <td class='box_td4' valign='top'>";

    if( 7 < $WEEK_CNT ) 
    { 
        $WEEK_CNT = 1;
        echo "<div class='box_table'><font color='red'>$CNT</font></div>";
    }
    else if ( 7 == $WEEK_CNT )
    {
        echo "<div class='box_table'><font color='blue'>$CNT</font></div>";
    }
    else
    {
        echo "<div class='box_table'>$CNT</div>";
    }


    //-------------------------------------------------------------------------
    // 넘어온지역에 년월일에 해당하는 데이타 추출 
    //-------------------------------------------------------------------------
	$appplayDay = $TEMP_DATE;
	if( sizeof($arr_date_pro[$appplayDay]) > 0 ) {
		foreach($arr_date_pro[$appplayDay] as $k=>$v){
			if($v[code]) {
				$codeTmp2 = $v[code];
			}
			if($v[prolist_img]) {

				// 앵콜요청수 /////////////////////////////////////////////////////////
				$enCnt = @mysql_result(mysql_query("select enCnt from odtEncore where enCode = '".$v[code]."'"), 0);
				if (!$enCnt) { $enCnt = 0; }

				echo "
				<table width='98' align='center' cellpadding='0' cellspacing='0' border='0'>
					<tr>
						<td colspan='2' align='center'><a href='/?cateCode=".$v[cateCode]."&viewCode=".$v[code]."&set_date=".$v[sale_date]."'><img src='".$v[prolist_img]."' width='86' height='50'></a></td>
					</tr>
					<tr>
						<td class='td_title' colspan='2'>".($v[mainName] ? $v[mainName] : $v[name])."</td>
					</tr>
					<tr>
						<td class='td_num'><b>[<span id=\"encoreHTML_".$v[code]."\">".$enCnt."</span>]</b></td>
						<td align='right'><a href='#none' class='encor_link' onclick=\"encore('".$v[code]."')\">앵콜요청</a></td>
					</tr>
				</table>";

			}
		}
	}

    echo "
    </td>";
}

for($CNT = $WEEK_CNT; $CNT < 7; $CNT++)
{
    echo "<td class='box_td4' valign='top'>&nbsp;</td>";
}

                echo "
                </tr>
            </table>
        </td>
    </tr>
</table>";


include $_SERVER[DOCUMENT_ROOT]."/pages/subFoot.html";

?>