<?
include "../odcommon/od_config.inc.php";
include "../odcommon/od_function.inc.php";
include "../odcommon/od_lib.inc.php";

## 이미 가입된 주민번호인지 체크.

$Query = "select count(*) from odtMember where resinum = '".md5($_POST[resinum1].$_POST[resinum2])."'";
$Result = mysql_query($Query);
$isJoin = mysql_result($Result,0);
if ( $isJoin )
{
    error_msgall('이미 가입된 등록번호 입니다.');
    exit;
}

## 실명인증확인처리
function Set_ok() {
echo "
    <script>
    alert('실명으로 확인되었습니다.');
    parent.document.snsForm.realCheck.value                         = 1;
    parent.document.snsForm.name.readOnly                           = true;
    parent.document.snsForm.resinum1.readOnly                       = true;
    parent.document.snsForm.resinum2.readOnly                       = true;
    parent.document.snsForm.name.style.backgroundColor              = 'eeeeee';
    parent.document.snsForm.resinum1.style.backgroundColor          = 'eeeeee';
    parent.document.snsForm.resinum2.style.backgroundColor          = 'eeeeee';
    </script>";
}

if ( $row_setup[nauthen_use] == "no" ) {   //실명인증 서비스 사용안함.
    Set_ok();   //바로 인증확인을 한다.
    return;
}

## 실명인증 시작
$sSiteID = $row_setup[nauthen_id];  	// 사이트 id 
$sSitePW = $row_setup[nauthen_pw];		// 비밀번호
$sSiteCOM = $row_setup[nauthen_com];		// 실명인증회사 (S:한국신용평가 K:KCB)

switch ( $sSiteCOM )
{
    case "S" : //신용평가정보
        $strJumin= $_POST[resinum1].$_POST[resinum2];		// 주민번호
        $strName = iconv("utf-8","euckr",$_POST[name]);		//이름
        $iReturnCode  = "";

        if ( $row_setup[recharge] == "no" ) {
            $cb_encode_path = $_SERVER[DOCUMENT_ROOT]."/../nameCheck/cb_namecheck";     // cb_namecheck 모듈이 설치된 위치(정액식)
        } else {
            $cb_encode_path = $_SERVER[DOCUMENT_ROOT]."/../nameCheck/cb_namecheckr";    // cb_namecheck 모듈이 설치된 위치(충전식)
        }

        if (strstr($HTTP_REFERER,str_replace("www.","",$_SERVER[HTTP_HOST])."/odprogram/odmembers/od_join.php")) {
            $iReturnCode = `$cb_encode_path $sSiteID $sSitePW $strJumin $strName`;		
        } else {
            error_msgall('잘못된 접근입니다.');
        }

        //결과값 확인
        switch($iReturnCode)
        {
            case 1:	// 맞음
                Set_ok();
                break;
            case 4: // 접속 오류
                error_msgall('인터넷 상태가 좋지 않습니다. 잠시후 다시 이용해주세요.');
                break;
            case 9: // 접속 오류
                error_msgall('모듈타입을 변경해보시기 바랍니다(정액/충전식)');
                break;
            case 5: // 주민번호 오류
                error_msgall('올바르지 않은 주민번호 입니다.');
                break;
            case 2: // 아님
                error_msgall('실명으로 확인되지 않았습니다. 이름과 주민번호를 확인해주세요.');
                break;
            case 3: //  데이터베이스 없음?
                echo "
                <script language=\"javascript\">
                 var URL =\"http://www.creditbank.co.kr/its/its.cb?m=namecheckMismatch\"; 
                 var status = \"toolbar=no,directories=no,scrollbars=no,resizable=no,status=no,menubar=no, width= 640, height= 480, top=0,left=20\"; 
                 window.open(URL,\"\",status); 
                </script> ";
                break;
            case 50;    // 명의보호대상자
                echo "
                <script language=\"javascript\">
                 var URL =\"http://www.creditbank.co.kr/its/itsProtect.cb?m=namecheckProtected\"; 
                 var status = \"toolbar=no,directories=no,scrollbars=no,resizable=no,status=no,menubar=no, width= 640, height= 480, top=0,left=20\"; 
                 window.open(URL,\"\",status); 
                </script>";
                break;
            default:
                break;
        }   //switch($iReturnCode)
        break;
} //switch ( $sSiteCOM )

?>