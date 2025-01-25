<?
//-----------------------------------------------------------------------------
// 지난상품보기
//-----------------------------------------------------------------------------
include $_SERVER[DOCUMENT_ROOT]."/odprogram/odcommon/od_config.inc.php";
include $_SERVER[DOCUMENT_ROOT]."/odprogram/odcommon/od_lib.inc.php";
include $_SERVER[DOCUMENT_ROOT]."/odprogram/odcommon/od_function.inc.php";
include $_SERVER[DOCUMENT_ROOT]."/odprogram/odcommon/od_head.inc.php";

include $_SERVER[DOCUMENT_ROOT]."/pages/subHead.html";

$code = $row_product[code];

echo "
<table width='886' cellpadding='0' cellspacing='0' border='0'>
    <tr>
        <td align='center'>
            <table width='100%' cellpadding='0' cellspacing='0' border='0'>
                <tr>
                    <td height='500' align='center' valign='top' class='infor'>
                        <table width='100%' border='0' cellspacing='0' cellpadding='0' class='smt30'>
                            <tr>
                                <td height='44' valign='top'><img src='/pages/skin/3/img/report_title.gif' width='144' height='30'></td>
                            </tr>
                            <tr>
                                <td height='1' bgcolor='#e3e3e3'> </td>
                            </tr>
                            <tr>
                                <td height='30'> </td>
                            </tr>
                        </table>
                        <table width='100%' border='0' cellspacing='0' cellpadding='0'>
                            <tr>
                                <td class='spb30'>
                                    <table width='100%' border='0' cellspacing='0' cellpadding='0'>
                                        <tr>
                                            <td width='520' valign='top'>
                                                <table width='100%' border='0' cellspacing='0' cellpadding='0'>
                                                    <tr>
                                                        <td width='9' height='0'><img src='/pages/skin/3/img/report_box_01.gif' width='9' height='9'></td>
                                                        <td background='/pages/skin/3/img/report_box_02.gif'> </td>
                                                        <td width='9' height='9'><img src='/pages/skin/3/img/report_box_03.gif' width='9' height='9'></td>
                                                    </tr>
                                                    <tr>
                                                        <td background='/pages/skin/3/img/report_box_04.gif'> </td>
                                                        <td height='93' style='line-height:25px' class='spl15'>";


    // 첫번째 구매고객 ////////////////////////////////////////////////////////
    $Query  = " SELECT * FROM odtReport WHERE reCode = '".$code."' ORDER BY reRegidate asc LIMIT 1 ";
    $Result = mysql_query($Query);
    $Record = mysql_fetch_array($Result);

    // 마지막 구매고객 ////////////////////////////////////////////////////////
    $Query2  = " SELECT * FROM odtReport WHERE reCode = '".$code."' ORDER BY reRegidate desc LIMIT 1 ";
    $Result2 = mysql_query($Query2);
    $Record2 = mysql_fetch_array($Result2);

    $total_time = $Record[reTime]; 
    $분-=($초=($분=$total_time)%60); 
    $분-=($시간=floor($분/3600))*3600; 
    $분/=60; 

    //echo $시간.'시간 '.$분.'분 '.$초.'초'; // 1시간 40분 54초
                                                            echo "
                                                            <li><b>최초 구매 도달시간</b> : ".$분."분 ".$초."초</li>
                                                            <li><b>첫번째 구매 고객</b> : "; if ($Record[reID]) { echo (substr($Record[reID], 0, $Record[reID]-3)."***"); } else { echo "******"; } echo " &nbsp;&nbsp; ( "; if ($Record[reRegidate]) { echo date('Y.m.d H:i:s',strtotime($Record[reRegidate])); } else { echo "0000.00.00 00:00:00"; } echo " )</li>
                                                            <li><b>마지막 구매 고객</b> : "; if ($Record2[reID]) { echo (substr($Record2[reID], 0, $Record2[reID]-3)."***"); } else { echo "******"; } echo " &nbsp;&nbsp; ( "; if ($Record2[reRegidate]) { echo date('Y.m.d H:i:s',strtotime($Record2[reRegidate])); } else { echo "0000.00.00 00:00:00"; } echo " )</li>
                                                        </td>
                                                        <td background='/pages/skin/3/img/report_box_05.gif'> </td>
                                                    </tr>
                                                    <tr>
                                                        <td><img src='/pages/skin/3/img/report_box_06.gif' width='9' height='9'></td>
                                                        <td background='/pages/skin/3/img/report_box_07.gif'> </td>
                                                        <td><img src='/pages/skin/3/img/report_box_08.gif' width='9' height='9'></td>
                                                    </tr>
                                                </table>
                                            </td>
                                            <td width='372'><img src='/pages/skin/3/img/report_img.jpg' width='372' height='111'></td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                            <tr>
                                <td class='spb30'>";

    //-------------------------------------------------------------------------
    // 해당 상품의 판매정보 추출
    //-------------------------------------------------------------------------
    $Query  = " SELECT * FROM odtReport WHERE reCode = '".$code."'  ";
    $Result = mysql_query($Query);
    $RecCnt = mysql_num_rows($Result);
    while ($Record = mysql_fetch_array($Result))
    {
        // 나이별 체크 ////////////////////////////////////////////////////////
        if      ($Record[reAge] <= 19)                         { $age1++;  }
        else if ($Record[reAge] >= 20 && $Record[reAge] <= 29) { $age2++;  }
        else if ($Record[reAge] >= 30 && $Record[reAge] <= 40) { $age3++;  }
        else if ($Record[reAge] >= 41 && $Record[reAge] <= 50) { $age4++;  }
        else if ($Record[reAge] >= 51)                         { $age5++;  }


        // 소요시간대별 ///////////////////////////////////////////////////////
        if      ($Record[reTime] >= 0    && $Record[reTime] <= 10*60) { $mtime1++;  }
        else if ($Record[reTime] > 20*60 && $Record[reTime] <= 30*60) { $mtime2++;  }
        else if ($Record[reTime] > 30*60 && $Record[reTime] <= 40*60) { $mtime3++;  }
        else if ($Record[reTime] > 40*60 && $Record[reTime] <= 60*60) { $mtime4++;  }
        else if ($Record[reTime] > 60*60)                             { $mtime5++;  }


        // 등급별 /////////////////////////////////////////////////////////////
        if      ($Record[reLevel] == 1) { $level1++;  }
        else if ($Record[reLevel] == 2) { $level2++;  }
        else if ($Record[reLevel] == 3) { $level3++;  }
        else if ($Record[reLevel] == 4) { $level4++;  }
        else if ($Record[reLevel] >= 5) { $level5++;  }

        // 시간별주문 /////////////////////////////////////////////////////////
        $tmp = substr($Record[reRegidate], 11, 2);
        ${"stime".$tmp}++;
    }

    $tage   = $age1 + $age2 + $age3 + $age4 + $age5;
    $tmtime = $mtime1 + $mtime2 + $mtime3 + $mtime4 + $mtime5;
    $tlevel = $level1 + $level2 + $level3 + $level4 + $level5;
    $tstime = $RecCnt;


                                    echo "
                                    <table width='100%' border='0' cellspacing='0' cellpadding='0'>
                                        <tr>
                                            <td class='spb20'>
                                                <table width='100%' border='0' cellspacing='0' cellpadding='0'>
                                                    <tr>
                                                        <td height='30' valign='top'><img src='/pages/skin/3/img/report_subject_01.gif' width='99' height='16'></td>
                                                    </tr>
                                                    <tr>
                                                        <td valign='top' class='spl20' style='border-right-style:solid; border-right-color:#f1f1f1; border-right-width:1px'>
                                                            <table border='0' cellspacing='0' cellpadding='0'>";

    // 나이대별 그래프 출력 부분 //////////////////////////////////////////////
    for ($i = 1; $i <= 5; $i++)
    {
        if (0 < $tage)
        {
            ${"vage".$i} = round( ${"age".$i} / $tage * 100);
        }
        else
        {
            ${"vage".$i} = 0;
        }

        if      ("1" == $i) { $title = "19세 이하"; }
        else if ("2" == $i) { $title = "20~29세";   }
        else if ("3" == $i) { $title = "30~40세";   }
        else if ("4" == $i) { $title = "41~50세";   }
        else if ("5" == $i) { $title = "51세 이상"; }

                                                                echo "
                                                                <tr>
                                                                    <td width='120' height='20'><li>".$title."</li></td>
                                                                    <td width='200'>
                                                                        <table width='100%' border='0' cellpadding='0' cellspacing='0' bgcolor='#cccccc'>
                                                                            <tr>
                                                                                <td height='11'>
                                                                                    <table width='".${"vage".$i}."%' border='0' cellspacing='0' cellpadding='0'>
                                                                                        <tr>
                                                                                            <td background='/pages/skin/3/img/report_bg_01.gif' height='11'> </td>
                                                                                        </tr>
                                                                                    </table>
                                                                                </td>
                                                                            </tr>
                                                                        </table>
                                                                    </td>
                                                                    <td width='50' align='center' class='re_color1'>".${"vage".$i}."%</td>
                                                                </tr>";
    }
                                                            echo "
                                                            </table>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </td>
                                            
                                            <td valign='top'>
                                                <table width='100%' border='0' cellspacing='0' cellpadding='0'>
                                                    <tr>
                                                        <td height='30' valign='top' class='spl25'><img src='/pages/skin/3/img/report_subject_06.gif' width='115' height='16'></td>
                                                    </tr>
                                                    <tr>
                                                        <td class='spl45'>
                                                            <table  border='0' cellspacing='0' cellpadding='0'>";

    // 회원등급별 그래프 출력 부분 ////////////////////////////////////////////
    for ($i = 1; $i <= 5; $i++)
    {
        if (0 < $tlevel)
        {
            ${"vlevel".$i} = round( ${"level".$i} / $tlevel * 100);
        }
        else
        {
            ${"vlevel".$i} = 0;
        }


        if      ("1" == $i) { $title = "1등급";         }
        else if ("2" == $i) { $title = "2등급";         }
        else if ("3" == $i) { $title = "3등급";         }
        else if ("4" == $i) { $title = "4등급";         }
        else if ("5" == $i) { $title = "5등급 이상";    }
                                                                echo "
                                                                <tr>
                                                                    <td width='120' height='20'>
                                                                        <li>".$title."</li>
                                                                    </td>
                                                                    <td width='200'>
                                                                        <table width='100%' border='0' cellpadding='0' cellspacing='0' bgcolor='#cccccc'>
                                                                            <tr>
                                                                                <td height='11'>
                                                                                    <table width='".${"vlevel".$i}."%' border='0' cellspacing='0' cellpadding='0'>
                                                                                        <tr>
                                                                                            <td background='/pages/skin/3/img/report_bg_02.gif' height='11'> </td>
                                                                                        </tr>
                                                                                    </table>
                                                                                </td>
                                                                            </tr>
                                                                        </table>
                                                                    </td>
                                                                    <td width='50' align='center' class='re_color2'>".${"vlevel".$i}."%</td>
                                                                </tr>";
    }
                                                            echo "
                                                            </table>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan='2' height='1' bgcolor='#f1f1f1'> </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                            <tr>
                                <td class='spb30'>
                                    <table width='100%' border='0' cellspacing='0' cellpadding='0'>
                                        <tr>
                                            <td class='spb20'>
                                                <table width='100%' border='0' cellspacing='0' cellpadding='0'>
                                                    <tr>
                                                        <td height='30' valign='top'><img src='/pages/skin/3/img/report_subject_03.gif' width='128' height='16'></td>
                                                    </tr>
                                                    <tr>
                                                        <td class='spl20' style='border-right-style:solid; border-right-color:#f1f1f1; border-right-width:1px;'>";

    //-------------------------------------------------------------------------
    // 해당 상품의 구매 갯수별 판매정보 추출
    //-------------------------------------------------------------------------
    $Query  = " SELECT reID, count(*) FROM odtReport WHERE reCode = '".$code."' GROUP BY reID ";
    $Result = mysql_query($Query);
    while ($Record = mysql_fetch_array($Result))
    {
        if      (1  == $Record[1]) { $gcnt1++; }
        else if (2  == $Record[1]) { $gcnt2++; }
        else if (3  <= $Record[1] && 4 >= $Record[1]) { $gcnt3++; }
        else if (5  <= $Record[1] && 9 >= $Record[1]) { $gcnt4++; }
        else if (10 <= $Record[1]) { $gcnt5++; }
    }

    $tgcnt = $gcnt1 + $gcnt2 + $gcnt3 + $gcnt4 + $gcnt5;

                                                            echo "
                                                            <table border='0' cellspacing='0' cellpadding='0'>";

    // 구매 갯수별 그래프 출력 부분 ///////////////////////////////////////////
    for ($i = 1; $i <= 5; $i++)
    {
        if (0 < $tgcnt)
        {
            ${"vgcnt".$i} = round( ${"gcnt".$i} / $tgcnt * 100);
        }
        else
        {
            ${"vgcnt".$i} = 0;
        }

        if      ("1" == $i) { $title = "1개 구매";          }
        else if ("2" == $i) { $title = "2개 구매";          }
        else if ("3" == $i) { $title = "3개 이상 구매";     }
        else if ("4" == $i) { $title = "5개 이상 구매";     }
        else if ("5" == $i) { $title = "10개 이상 구매";    }
                                                                echo "
                                                                <tr>
                                                                    <td width='120' height='20'>
                                                                        <li>".$title."</li>
                                                                    </td>
                                                                    <td width='200'>
                                                                        <table width='100%' border='0' cellpadding='0' cellspacing='0' bgcolor='#cccccc'>
                                                                            <tr>
                                                                                <td height='11'>
                                                                                    <table width='".${"vgcnt".$i}."%' border='0' cellspacing='0' cellpadding='0'>
                                                                                        <tr>
                                                                                            <td background='/pages/skin/3/img/report_bg_03.gif' height='11'> </td>
                                                                                        </tr>
                                                                                    </table>
                                                                                </td>
                                                                            </tr>
                                                                        </table>
                                                                    </td>
                                                                    <td width='50' align='center' class='re_color3'>".${"vgcnt".$i}."%</td>
                                                                </tr>";
    }
                                                            echo "
                                                            </table>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </td>
                                            <td valign='top'>
                                                <table width='100%' border='0' cellspacing='0' cellpadding='0'>
                                                    <tr>
                                                        <td height='30' valign='top' class='spl25'><img src='/pages/skin/3/img/report_subject_04.gif' width='100' height='16'></td>
                                                    </tr>
                                                    <tr>
                                                        <td class='spl45'>
                                                            <table  border='0' cellspacing='0' cellpadding='0'>";

    // 구매소요시간 그래프 출력 부분 //////////////////////////////////////////
    for ($i = 1; $i <= 5; $i++)
    {
        if (0 < $tmtime)
        {
            ${"vmtime".$i} = round( ${"mtime".$i} / $tmtime * 100);
        }
        else
        {
            ${"vmtime".$i} = 0;
        }

        if      ("1" == $i) { $title = "10분 이내"; }
        else if ("2" == $i) { $title = "20분 이내"; }
        else if ("3" == $i) { $title = "30분 이내"; }
        else if ("4" == $i) { $title = "60분 이내"; }
        else if ("5" == $i) { $title = "60분 이후"; }
                                                                echo "
                                                                <tr>
                                                                    <td width='120' height='20'>
                                                                        <li>".$title."</li>
                                                                    </td>
                                                                    <td width='200'>
                                                                        <table width='100%' border='0' cellpadding='0' cellspacing='0' bgcolor='#cccccc'>
                                                                            <tr>
                                                                                <td height='11'>
                                                                                    <table width='".${"vmtime".$i}."%' border='0' cellspacing='0' cellpadding='0'>
                                                                                        <tr>
                                                                                            <td background='/pages/skin/3/img/report_bg_04.gif' height='11'> </td>
                                                                                        </tr>
                                                                                    </table>
                                                                                </td>
                                                                            </tr>
                                                                        </table>
                                                                    </td>
                                                                    <td width='50' align='center' class='re_color4'>".${"vmtime".$i}."%</td>
                                                                </tr>";
    }
                                                            echo "
                                                            </table>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan='2' height='1' bgcolor='#f1f1f1'> </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <table width='100%' border='0' cellspacing='0' cellpadding='0'>
                                        <tr>
                                            <td>
                                                <table width='100%' border='0' cellspacing='0' cellpadding='0'>
                                                    <tr>
                                                        <td height='30' valign='top'><img src='/pages/skin/3/img/report_subject_05.gif' width='128' height='16'></td>
                                                    </tr>
                                                    <tr>
                                                        <td class='spl20'>
                                                            <table width='100%' border='0' cellspacing='0' cellpadding='0'>
                                                                <tr>";

    // 시간대별 주문분포 출력 부분 ////////////////////////////////////////////
    for ($i = 0; $i <= 23; $i++)
    {
        $temp = sprintf("%02d", $i);
        if (0 < $tstime)
        {
            ${"vstime".$temp} = round( ${"stime".$temp} / $tstime * 100);
        }
        else
        {
            ${"vstime".$temp} = 0;
        }


                                                                    echo "
                                                                    <td align='center' class='re_color5'>".${"vstime".$temp}."%</td>";
    }
                                                                echo "
                                                                </tr>
                                                                <tr>";

    // 시간대별 주문분포 출력 부분 ////////////////////////////////////////////
    for ($i = 0; $i <= 23; $i++)
    {
        $temp = sprintf("%02d", $i);
        if (0 < $tstime)
        {
            ${"vstime".$temp} = round( ${"stime".$temp} / $tstime * 100);
        }
        else
        {
            ${"vstime".$temp} = 0;
        }

        $height = 135 * (${"vstime".$temp} / 100);

                                                                    echo "
                                                                    <td height='135' align='center' valign='bottom'>
                                                                        <table width='21' border='0' cellpadding='0' cellspacing='0' bgcolor='#ebebeb' height='135'>
                                                                            <tr>
                                                                                <td valign='bottom'>
                                                                                    <table width='100%' border='0' cellpadding='0' cellspacing='0' background='/pages/skin/3/img/report_bg_05.gif'>
                                                                                        <tr>
                                                                                            <td height='$height'> </td>
                                                                                        </tr>
                                                                                    </table>
                                                                                </td>
                                                                            </tr>
                                                                        </table>
                                                                    </td>";
    }
                                                                echo "
                                                                </tr>
                                                                <tr>";

    // 시간대별 주문분포 타이틀 출력 //////////////////////////////////////////
    for ($i = 0; $i <= 23; $i++)
    {
        $temp = sprintf("%02d", $i);
                                                                    echo "
                                                                    <td align='center' class='s'>".$temp."</td>";
    }
                                                                echo "
                                                                </tr>
                                                            </table>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                            <tr>
                                <td height='40'>&nbsp;</td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>";

include $_SERVER[DOCUMENT_ROOT]."/pages/subFoot.html";

?>

