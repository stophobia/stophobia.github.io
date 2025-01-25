<?
#------------------------------------------------------------------------------
# 파 일 명: img_form.php
# 작업내용: 이미지 새창 수정화면
# 인    수: img_name : 변경 이미지명
#         :
# 작성일자: 2011.01.14
#------------------------------------------------------------------------------
include $_SERVER[DOCUMENT_ROOT]."/odprogram/odcommon/od_config.inc.php";
include $_SERVER[DOCUMENT_ROOT]."/odprogram/odcommon/od_function.inc.php";
include $_SERVER[DOCUMENT_ROOT]."/odprogram/odcommon/od_lib.inc.php";

$row = mysql_fetch_array(mysql_query("SELECT * FROM odtSetup WHERE serialnum='1'"));
$P_SKIN = $row[P_SKIN];

$temp = getimagesize($_SERVER[DOCUMENT_ROOT]."/pages/skin/".$P_SKIN."/img/".$img_name);
$img_width  = $temp[0];
$img_height = $temp[1];


if ("630" < $img_width ) { $width  = "625"; } else { $width  = $img_width;   }
if ("200" < $img_height) { $height = "195"; } else { $height = $img_height;  }


echo "
<html>
<head>
<title>이미지 변경</title>
<meta http-equiv='content-type' content='text/html; charset=utf-8'>
<link href='/css/managerstyle.css' rel='stylesheet' type='text/css'>
</head>
<script>
    function f_save()
    {
        if (document.PUBLIC_FORM.SIMG.value)
        {
            PUBLIC_FORM.submit();
        }
        else
        {
            alert('변경 이미지를 선택해 주십시오');
        }
    }
</script>
<body topmargin='5' bgcolor='#dddddd'>
<form enctype='multipart/form-data' name='PUBLIC_FORM' action='img_form_tran.php' method='post' target='set'>
<input type='hidden' name='img_name'    value='$img_name'   >
<input type='hidden' name='P_SKIN'      value='$P_SKIN'     >
<table width='100%'>
    <tr>
        <td><li>기존 이미지 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <font color='blue'>원본 사이즈 ( width : <font color='red'>$img_width</font>, height : <font color='red'>$img_height</font> )</font></td>
    </tr>
    <tr><td height='5'></td></tr>
    <tr>
        <td align='center'>
            <table width='630' style='border:1 solid #000000;' bgcolor='#ffffff'>
                <tr>
                    <td height='200' align='center'><img src='/pages/skin/$P_SKIN/img/$img_name' width='$width' height='$height' ></td>
                </tr>
            </table>
        </td>
    </tr>
    <tr><td height='10'></td></tr>
    <tr>
        <td><li>변경 이미지 찾기</td>
    </tr>
    <tr><td height='5'></td></tr>
    <tr>
        <td align='center'>
            <table width='630' style='border:1 solid #000000;' bgcolor='#ffffff'>
                <tr>
                    <td>&nbsp;<input type='file' name='SIMG' size='70'></td>
                </tr>
            </table>
        </td>
    </tr>
    <tr><td height='5'></td></tr>
    <tr>
        <td align='center'>
            <a href='#' onClick='f_save();'><img src='../odimages/odmain/btn_ok.gif' style='border:0; cursor:hand;'></a>&nbsp;&nbsp;
            <a href='#' onClick='self.close();'><img src='../odimages/odmain/btn_cancel.gif' style='border:0; cursor:hand;'></a>
        </td>
    </tr>
    <tr><td height='20'></td></tr>
    <tr>
        <td>
            ※ 이미지 변경시 기존이미지는 삭제가 되고 신규이미지로 변경됩니다<br>
            ※ 이미지 변경시 기존이미지 사이즈와 다를경우 화면이 깨질수 있습니다 될수 있으면 사이즈를 맞춰주셔야 합니다<br>
            ※ 확장자 gif, jpg, png 외에 다른 확장자는 올리실수 없습니다<br>
        </td>
    </tr>
</table>
</form>
<iframe name='set' src='' width='0' height='0' align='center' marginwidth='0' marginheight='0' scrolling='no' frameborder='0'></iframe>";


?>