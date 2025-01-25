<?
	## MySQL DB 접속
	include dirname(__FILE__)."/../odprogram/odcommon/od_db_conf.php";


	$que = "select * from odtMember";
	$res = mysql_query($que);
	while($row = mysql_fetch_array($res)) {
		if($row[action] > 9000)				$actionLevel = 10;
		else if($row[action] > 8000)	$actionLevel = 9;
		else if($row[action] > 7000)	$actionLevel = 8;
		else if($row[action] > 6000)	$actionLevel = 7;
		else if($row[action] > 5000)	$actionLevel = 6;
		else if($row[action] > 4000)	$actionLevel = 5;
		else if($row[action] > 3000)	$actionLevel = 4;
		else if($row[action] > 2000)	$actionLevel = 3;
		else if($row[action] > 1000)	$actionLevel = 2;
		else													$actionLevel = 1;

		mysql_query("update odtMember set actionLevel = '".$actionLevel."' where id ='".$row[id]."'");

	}

?>
