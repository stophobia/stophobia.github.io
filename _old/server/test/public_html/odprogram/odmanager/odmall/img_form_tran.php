<?
#------------------------------------------------------------------------------
# 파 일 명: img_form_tran.php
# 작업내용: 이미지 새창 수정처리
# 인    수: img_name : 변경 이미지명
#         :
# 작성일자: 2011.01.14
#------------------------------------------------------------------------------
include $_SERVER[DOCUMENT_ROOT]."/odprogram/odcommon/od_config.inc.php";
include $_SERVER[DOCUMENT_ROOT]."/odprogram/odcommon/od_function.inc.php";
include $_SERVER[DOCUMENT_ROOT]."/odprogram/odcommon/od_lib.inc.php";

// 확장자 검사 ////////////////////////////////////////////////////////////////
$temp = strtolower(substr(strrchr($SIMG_name, "."),1));

if ("gif" != $temp && "jpg" != $temp  && "png" != $temp)
{
    echo "
    <script>
        alert('해당 확장자 파일은 처리할수 없습니다');
        parent.location.reload(true);
    </script>";
    exit;
}


if("none" != $SIMG && "" != $SIMG)
{
    $LOCATE_DIR = "../../../pages/skin/$P_SKIN/img";    // 이미지 저장경로지정
    $FILE_NAME  = $img_name;                            // 이미지명

    KJ_DEL_IMAGE($SIMG, $LOCATE_DIR);                   // 기존이미지 삭제처리
    KJ_COPY_IMAGE($SIMG, $FILE_NAME, $LOCATE_DIR);      // 이미지저장
}


echo "
<script>
    parent.location.reload(true);
</script>";
exit;




// 이미지저장 함수 ////////////////////////////////////////////////////////////
function KJ_COPY_IMAGE($file, $file_name, $dir)
{
   # temp 파일을 카피한다.
   $des_file_name = "$dir"."/"."$file_name";
   KJ_MSG_ALERT(copy($file,$des_file_name),"[$file]=[$des_file_name]파일을 복사하지 못했습니다.");

   # temp 파일을 삭제한다.
   unlink($file);
}

// 파일 삭제 함수 /////////////////////////////////////////////////////////////
function KJ_DEL_IMAGE($file_name,$dir)
{
     $delete_file = $dir."/".$file_name;    
     @unlink($delete_file); 
}

// 메세지 출력 함수 ///////////////////////////////////////////////////////////
function KJ_MSG_ALERT($chk_data, $string)
{
    if (!$chk_data)
    {
        echo "
        <script language='javascript'>
            alert('$string');
        </script>";
        exit;
    }
}

?>