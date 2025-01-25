<?
	## MySQL DB 접속
	include dirname(__FILE__)."/../odprogram/odcommon/od_db_conf.php";
	include dirname(__FILE__)."/../odprogram/odcommon/od_lib.inc.php";
	include dirname(__FILE__)."/../odprogram/odcommon/od_function.inc.php";	

	$que = "select * from odtMailLog where status='N' limit 1";
	$res = mysql_query($que);

	if(!mysql_num_rows($res)) exit;

	$row = mysql_fetch_array($res);

	$row2 = mysql_fetch_array(mysql_query("select * from odtMailContent where code ='".$row[code]."'"));
	$emailArray = explode(",",$row[email]);
	$nameArray = explode(",",$row[name]);


	mysql_query("update odtMailLog set status='Y',sendDate=now() where no ='".$row[no]."'");


	for($i=0;$i<count($emailArray);$i++) {

		$nameArray[$i]  = str_replace(" ", "", $nameArray[$i]);
		$emailArray[$i] = str_replace(" ", "", $emailArray[$i]);

		if(!$emailArray[$i] || $row2[body] == "<P>&nbsp;</P>") continue;

		$app_comment = "<html>
										<head>
											<title></title>
											<meta http-equiv='Content-Type' content='text/html; charset=euc-kr'>
										</head>
										<body bgcolor='#FFFFFF' leftmargin='10' topmargin='10'>
											".$row2[body]."<br><br>
											메일 수신을 원치 않으시면 <a href='http://".$row_company[homepage]."/od_feedDel.php?email=".$emailArray[$i]."' target='_blank'>[수신거부]</a>를 클릭하십시오 
										</body>
									</html>";

		$subject			=	iconv("utf-8","euckr",$row2[subject]);
		$comment			=	iconv("utf-8","euckr",$app_comment);
		$mailheaders	=	iconv("utf-8","euckr",$row2['header']);
		$to						= iconv("utf-8","euckr",$nameArray[$i])."<$emailArray[$i]>";

		if(mail($to,$subject,$comment,$mailheaders)){
			$qry_MU = "update odtMember set maildate='".time()."' where email='".$emailArray[$i]."'";
			$res_MU = mysql_query($qry_MU);
		} else {
			mysql_query("insert into odtMailError set email = '".$emailArray[$i]."', code = '".$row[code]."', regidate=now()");
		}
	}

?>
