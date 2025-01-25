<?
#####################################
#           KCB실명인증확인
#최종수정일 : 2011-02-13
#작성자     : tindevil
#####################################

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
    parent.document.snsForm.action = 'od_join.php';
    parent.document.snsForm.target = '_self';
    parent.document.snsForm.submit();
    </script>";
    exit;
}

## 실명인증 시작
$sSiteID = $row_setup[nauthen_id2];  	// 사이트 id(KCB)

$name= $_POST[realname];                                  // *** 성명
$ssn=$_POST[resinum1].$_POST[resinum2];               // *** 주민번호 (숫자
$qryKndCd = $_POST[usertype];                       // 1: 내국인  2: 외국인

//인증클래스사용
include "./COkname.php";
$KCB = new COkName($sSiteID);
$result = $KCB->Exec_Name($name,$ssn,$qryKndCd);

switch ($result)
{
    case "B000": // 정상적으로 인증이 완료된 경우의 처리
        Set_ok();
        break;
    case "B002": // 정상적으로 인증이 완료된 경우의 처리
        error_msgall("이름과 등록번호가 일치하지않습니다.");
        break;
    case "B008": // 정상적으로 인증이 완료된 경우의 처리
        error_msgall("유효하지않은 회원사 코드입니다.");
        break;
    case "B016": // 정상적으로 인증이 완료된 경우의 처리
        error_msgall("입력값이 올바르지 않습니다.");
        break;
    case "B001":
        // 주민등록번호가 존재하지 않는 경우. ok-name.co.kr 에서 실명등록을 할 수 있게함.
        // 주민번호가 없어 인증이 되지 않은 것으로 인증실패로 처리해야 합니다.
        // 스크립트와 해당 페이지를 복사해서 사용하셔도 됩니다. 해당 페이지는 메뉴얼에 포함되어있습니다.
        echo "<script src=\"http://www.ok-name.co.kr/member/js/okname.js\" type=\"text/javascript\" language=\"javascript1.5\" ></script><script>KCB_okNameGuide();</script>";
        break;
    case "B016":
        // 명의보호서비스에 가입된 경우 인증창으로 유도합니다.(준비중)        
        echo "<script src=\"http://www.ok-name.co.kr/member/js/okname.js\" type=\"text/javascript\" language=\"javascript1.5\" ></script><script>KCB_BlockedName();</script>";
        break;
    default:
        // 정상적으로 인증이 되지 않은 경우의 처리.
        error_msgall("인증실패(".$result.")");
}
?>