<?PHP
if($_GET[mode]=="1") {
	$fileName = "상품기술서.xls";
	$FilePathName = $_SERVER[DOCUMENT_ROOT]."/file/u02b03.xls";	//다운받을 파일경로
} else {
	$fileName = "상품기술서.zip";
	$FilePathName = $_SERVER[DOCUMENT_ROOT]."/file/u02b03.zip";	//다운받을 파일경로
}

$f_name = rawurlencode($fileName);							//다운받을때 원하는 파일명.


header("Content-Type: application/octet-stream");

header("Content-Disposition: attachment;; filename=".$f_name);

header("Content-Transfer-Encoding: binary"); 

header("Content-Length: ".(string)(filesize($FilePathName))); 

header("Cache-Control: cache, must-revalidate");

header("Pragma: no-cache"); 

header("Expires: 0"); 

$fp = fopen($FilePathName,'r') ; 

if(!fpassthru($fp)){

        fclose($fp);

}

?>

