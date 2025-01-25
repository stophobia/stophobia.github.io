<?php
// 필요한 설정파일 불러오기
include $_SERVER[DOCUMENT_ROOT]."/odprogram/odcommon/od_config.inc.php";
include $_SERVER[DOCUMENT_ROOT]."/odprogram/odcommon/od_function.inc.php";
include $_SERVER[DOCUMENT_ROOT]."/odprogram/odcommon/od_lib.inc.php";


$filesrc = $_FILES[file][name] ? file_upload($_FILES[file],"/odprogram/upfiles/proposal") : "";

if(!$_POST[content] || !$_POST[title]) exit;

$que = "insert into odtProposal set
				proName			= '".htmlspecialchars(addslashes($_POST[name]))."',
				proTel			= '".htmlspecialchars(addslashes($_POST[tel]))."',
				proEmail		= '".htmlspecialchars(addslashes($_POST[email]))."',
				proTitle		= '".htmlspecialchars(addslashes($_POST[title]))."',
				proContent	= '".htmlspecialchars(addslashes($_POST[content]))."',
				proFile			= '".htmlspecialchars(addslashes($filesrc))."',
				proFileName	= '".htmlspecialchars(addslashes($_FILES[file][name]))."',
				proRegidate	= now()";
$res = mysql_query($que);
if($res) {

	$mailheaders1		= "From:$_POST[name]<$_POST[email]>\n";
	$mailheaders1  .= "Content-Type: text/html; charset=euc-kr";
	$to1						= "고객센터<".$row_company[email].">";
	$title1					= "[업무제휴]".$_POST[title];
	$body						= nl2br(htmlspecialchars(addslashes($_POST[content])))."<br>";
	$body						.= "<a href='http://".$_SERVER[HTTP_HOST]."/".$filesrc."'>파일다운로드</a><br>";

	$to1					= iconv("utf-8","euckr",$to1);
	$title1				= iconv("utf-8","euckr",$title1);
	$body					= iconv("utf-8","euckr",$body);
	$mailheaders1 = iconv("utf-8","euckr",$mailheaders1);

	mail($to1,$title1,$body,$mailheaders1);

	error_msgall('접수되었습니다.');
	echo "<script>parent.document.frm.reset();</script>";
	exit;
} else {

	error_msgall('접수중 오류가 발생하였습니다');
	exit;
}

?>