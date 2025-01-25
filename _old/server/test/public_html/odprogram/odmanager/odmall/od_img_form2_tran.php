<?
#------------------------------------------------------------------------------
# 파 일 명: od_img_form2_tran.php
# 작업내용: 이미지 새창 수정처리
# 인    수: img_name : 변경 이미지명
#         :
# 작성일자: 2011.01.14
#------------------------------------------------------------------------------
include $_SERVER[DOCUMENT_ROOT]."/odprogram/odcommon/od_config.inc.php";
include $_SERVER[DOCUMENT_ROOT]."/odprogram/odcommon/od_function.inc.php";
include $_SERVER[DOCUMENT_ROOT]."/odprogram/odcommon/od_lib.inc.php";


// 스킨별 디렉토리 ////////////////////////////////////////////////////////////
$CUR_DIR = $_SERVER[DOCUMENT_ROOT]."/pages/skin/$P_SKIN/img";

echo "
<script>
    function f_win_form(img)
    {
        window.open('img_form.php?img_name='+img, 'image','scrollbars=no, resizable=no, width=650,height=500,top=0,left=0');
    }
</script>
<table border='0' cellspacing='0' cellpadding='0'>";

$TCnt = 0;

// 해당 디렉토리에 있는 이미지 파일들을 배열로 저장 ///////////////////////////
$dirHandle = opendir($CUR_DIR);
while ($filename = readdir($dirHandle))
{
    $tempext = strtolower(substr(strrchr($filename, "."),1));

    if ("gif" == $tempext || "jpg" == $tempext || "png" == $tempext)
    {
        if ($find_img)
        {
            if (substr_count($filename, $find_img))
            {
                $temp = getimagesize($_SERVER[DOCUMENT_ROOT]."/pages/skin/".$P_SKIN."/img/".$filename);
                $img_width  = $temp[0];
                $img_height = $temp[1];

                $filedate = filemtime($CUR_DIR."/".$filename);
                $filedate = date("Y-m-d H:i:s",$filedate);
                $filesize = filesize($CUR_DIR."/".$filename);

                $A_FILED[$TCnt][0]  = $filename;
                $A_FILED[$TCnt][1]  = $filesize;
                $A_FILED[$TCnt][2]  = $img_width."ⅹ".$img_height;
                $A_FILED[$TCnt][3]  = $tempext;
                $A_FILED[$TCnt][4]  = $filedate;

                $TCnt++;
            }
        }
        else
        {
            $temp = getimagesize($_SERVER[DOCUMENT_ROOT]."/pages/skin/".$P_SKIN."/img/".$filename);
            $img_width  = $temp[0];
            $img_height = $temp[1];

            $filedate = filemtime($CUR_DIR."/".$filename);
            $filedate = date("Y-m-d H:i:s",$filedate);
            $filesize = filesize($CUR_DIR."/".$filename);

            $A_FILED[$TCnt][0]  = $filename;
            $A_FILED[$TCnt][1]  = $filesize;
            $A_FILED[$TCnt][2]  = $img_width."ⅹ".$img_height;
            $A_FILED[$TCnt][3]  = $tempext;
            $A_FILED[$TCnt][4]  = $filedate;

            $TCnt++;
        }
    }
}

closedir($dirHandle);

// 정렬 ///////////////////////////////////////////////////////////////////////
if (0 < $TCnt)
{
    foreach ($A_FILED as $key => $row) 
    { 
        if      ("1" == $ORDER_FILED) { $aaa[$key] = $row[0];    }
        else if ("2" == $ORDER_FILED) { $aaa[$key] = $row[1];    }
        else if ("3" == $ORDER_FILED) { $aaa[$key] = $row[2];    }
        else if ("4" == $ORDER_FILED) { $aaa[$key] = $row[3];    }
        else if ("5" == $ORDER_FILED) { $aaa[$key] = $row[4];    }
    }
  
    if ("ASC" == $ORDER_KBN) { array_multisort($aaa, SORT_ASC,  $A_FILED);   }
    else                     { array_multisort($aaa, SORT_DESC, $A_FILED);   }

    reset($A_FILED);
}


// 배열로 저장된 이미지 목록 표시 /////////////////////////////////////////////
$RecCnt = $TCnt;

if ($RecCnt > 0) 
{
    for ($Cnt = 0; $Cnt < $RecCnt; $Cnt++)
    {
        $filesize = getFileSizeText($A_FILED[$Cnt][1]);

        echo "
        <tr height='25'>
            <td width='200' align='left'  ><a href=\"javascript:f_win_form('".$A_FILED[$Cnt][0]."');\">".$A_FILED[$Cnt][0]."</a></td>
            <td width='100' align='right' >".$filesize."</td>
            <td width='100' align='left'  >&nbsp;&nbsp;&nbsp;&nbsp; ".$A_FILED[$Cnt][2]."</td>
            <td width='50'  align='center'>&nbsp;&nbsp; ".$A_FILED[$Cnt][3]."</td>
            <td width='160' align='right' >".$A_FILED[$Cnt][4]."</td>
        </tr>";
    }
}

echo "
</table>";

// 파일사이즈를 알기쉽게 M, K, G단위로 표시하는 함수 //////////////////////////
function getFileSizeText($size)
{ 
    $post = array('', 'K', 'M', 'G', 'T', 'P', 'E', 'Z', 'Y'); 
    while($size > 1024 && $i < count($post))
    { 
        $size /= 1024; 
        $i++; 
    } 

    $sifht = pow(10, 3 - strlen(floor($size))); 
    return (floor($size * $sifht) / $sifht).$post[$i]; 
}

?>