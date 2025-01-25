<?PHP

$trigger = "yes";
$filename = "./Item.xml";
$handle = fopen( $filename , "r");
$contents = fread($handle, filesize($filename));
if( $contents ) {
	$ex = explode("<AppTime>" , $contents);
	if(sizeof($ex) > 0) {
		$ex2 = explode("</AppTime>" , $ex[1]);
		if( $ex2[0] == date("Y-m-d") ) {
			$trigger = "no";
		}
	}
}
fclose($handle);


if( $trigger  == "yes" ) {

	$bodyXml = "<?xml version=\"1.0\" encoding=\"UTF-8\" ?>
	<Items>
		<Logo>http://www.onedaynet.co.kr/odimages/alimiLogo.jpg</Logo>
		<ItemIMG>".(ereg("http://",$row_product[side_img]) ? $row_product[side_img] : "http://".$_SERVER[HTTP_HOST].$row_product[side_img])."</ItemIMG>
		<Name>".htmlspecialchars($row_product[mainName] ? cut_str_short($row_product[mainName],15,"") : cut_str_short($row_product[name],15,""))."</Name>
		<Price>".number_format($row_product[price])."</Price>
		<ItemURL>http://".$_SERVER[HTTP_HOST]."</ItemURL>
		<LogoURL>http://".$_SERVER[HTTP_HOST]."</LogoURL>
		<AppTime>".date("Y-m-d")."</AppTime>
	</Items>";

	$fpXml = fopen("./Item.xml","w");
	fwrite($fpXml,$bodyXml);
	fclose($fpXml);
}

?>