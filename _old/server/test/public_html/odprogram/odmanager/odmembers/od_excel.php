<?
	include "../../odcommon/od_config.inc.php";
	include "$folderpath_manager_common/od_function.inc.php";	
	include "$folderpath_manager_common/od_adminAuthority.inc.php";
	
	$todayTemp = date("YmdHis");
	$filename = "member_".$todayTemp.".xls";
	
	header("Content-type: application/vnd.ms-excel");
	header("Content-Disposition: attachment; filename=$filename");
	header("Expires: 0");
	header("Cache-Control: must-revalidate, post-check=0,pre-check=0");
	header("Pragma: public");
	
	$result = mysql_query("SELECT id, name, resinum, email, tel1, tel2, tel3, htel1, htel2, htel3, zip1, zip2, address, address1, signdate FROM odtMember  where isRobot ='N' ORDER BY serialnum DESC");
	
	$serialnumber = 1;
?>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<?
	echo "
		<table border='1'>";
	
	echo "
			<tr>
				<td>번호</td>
				<td>아이디</td>
				<td>이름</td>
				<td>E-mail</td>
				<td>전화번호</td>
				<td>휴대폰번호</td>
				<td>우편번호</td>
				<td>주소</td>
				<td>가입일</td>
			</tr>";

	while($row = mysql_fetch_array($result)) {
		$signdateTemp = date("Y-m-d",$row[signdate]);
	
		echo "
			<tr>
				<td>$serialnumber</td>
				<td>$row[id]</td>
				<td>$row[name]</td>
				<td>$row[email]</td>
				<td>$row[tel1]-$row[tel2]-$row[tel3]</td>
				<td>$row[htel1]-$row[htel2]-$row[htel3]</td>
				<td>$row[zip1]-$row[zip2]</td>
				<td>$row[address] $row[address1]</td>
				<td>$signdateTemp</td>
			</tr>";

		$serialnumber++;
	}
	
	echo "
		</table>";
?>
