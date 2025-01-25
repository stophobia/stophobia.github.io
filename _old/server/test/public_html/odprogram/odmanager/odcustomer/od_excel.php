<?
	include "../../odcommon/od_config.inc.php";
	include "$folderpath_manager_common/od_function.inc.php";	
	include "$folderpath_manager_common/od_adminAuthority.inc.php";

	## 접근권한 설정
	if($row_admin[productLevel] == 3 || $row_admin[superLevel]==9) {
	}
	else {
		error_msgloc("$folderpath_manager/","접근권한이 없습니다.   ");
	}
	
	$todayTemp = date("YmdHis");
	$filename = "customer_".$todayTemp.".xls";
	
	header("Content-type: application/vnd.ms-excel");
	header("Content-Disposition: attachment; filename=$filename");
	header("Expires: 0");
	header("Cache-Control: must-revalidate, post-check=0,pre-check=0");
	header("Pragma: public");
	
	$result = mysql_query("select * from odtMember where userType = 'C' ORDER BY serialnum DESC");
	
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
				<td>벤더사명</td>
				<td>공급업체이름</td>
				<td>대표자</td>
				<td>담당자</td>
				<td>전화번호</td>
				<td>팩스번호</td>
				<td>E-mail</td>
			</tr>";

	while($row = mysql_fetch_array($result)) {
		$inputDateTemp = date("Y-m-d",$row[inputDate]);
	
		echo "
			<tr>
				<td>$serialnumber</td>
				<td>$row[id]</td>
				<td>$row[bannder]</td>
				<td>$row[cName]</td>
				<td>$row[ceoName]</td>
				<td>$row[name]</td>
				<td>$row[tel1] $row[tel2] $row[tel3]</td>
				<td>$row[ofax1] $row[ofax2] $row[ofax3] </td>
				<td>$row[email]</td>
			</tr>";

		$serialnumber++;
	}

	echo "
		</table>";
?>