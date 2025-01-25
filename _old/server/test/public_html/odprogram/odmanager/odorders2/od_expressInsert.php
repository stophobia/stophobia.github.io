<?
    include "../../odcommon/od_config.inc.php";
    include "$folderpath_manager_common/od_function.inc.php";
    include "$folderpath_manager_common/od_comAuthority.inc.php";


//파일유무체크 & 업로드 ///////////////////////////
$fileTmp = $_FILES[expressCSV][tmp_name];
if(!is_file($fileTmp)) { 
	msg('업로드가 되지 않았습니다.');
	exit;
}

/* utf8 형식으로 변경 */

$text = file_get_contents($fileTmp);
$text8 = @iconv('CP949', 'UTF-8//IGNORE', $text);

$cnt = strlen($text);
$cnt8 = strlen($text8);
if($cnt <= $cnt8) {
	// 제대로 변경이 되었다면 용량이 커졌을 것이다.
	// 용량이 같다면 한글이 없는 것이다.
	rename($fileTmp, $fileTmp.'.euckr'); // 백업
	file_put_contents($fileTmp, preg_replace('/charset=euc-kr/i', 'charset=utf-8', $text8));
}
unlink($fileTmp.".euckr");
/* utf8 형식으로 변경 */

$fp_org = fopen($fileTmp,"r");
$_body = "";
$i = 0;
$arr_i = "";
while( !feof($fp_org) ) {

   // 한라인씩 읽어들입니다.
	$readline = fgets($fp_org, 2048) ;
	$enter = false; 
	$k = 0; 
	while (!$enter) { 
		if (!strstr(bin2hex($readline) , "0d0a") && strstr(bin2hex($readline) , "0a")) { 
			$readline = str_replace("\r", "", $readline); 
			$readline = str_replace("\n", "", $readline) . "<br>"; 
			$readline .= fgets($fp_org, 2048); 
		} else $enter = true; 
		$k++; 
		
	}	

	$readline = str_replace("\"","",$readline);

	$arr[$i] = explode(",",$readline);

	$i++;
}

// 이미 등록된 내용 삭제
mysql_query("delete from odtExpressTmpTable where partnerCode = '".$com[id]."'");

for($i=0;$i<count($arr);$i++) {

	$ordernum			= trim($arr[$i][0]);
	$express			= $arr[$i][10];
	$expressNum		=	$arr[$i][11];

	if($ordernum == "주문번호" || !$ordernum) continue; //타이틀이면 패스

	$res = mysql_query("insert into odtExpressTmpTable set ordernum='".$ordernum."', express ='".$express."', expressNum = '".$expressNum."', partnerCode='".$com[id]."', regidate = now()");

}

if($res) {
	echo "<script>parent.location.href='./od_dlv_expressList.php';</script>";
	exit;
} else {
	msg('입력중 오류가 발생하였습니다.');
	exit;
}
?>