<?
	include "../odcommon/od_config.inc.php";
	include "../odcommon/od_function.inc.php";
	include "../odcommon/od_lib.inc.php";


	if(!$row_member[id] && !$_SESSION[Gid]) {
		echo "<script>alert('잘못된 접근입니다.');self.close();</script>";
		exit;
	}

	unset($id);
	$id = $row_member[id] ? $row_member[id] : $_SESSION[Gid];

	if(!$id) {
		echo "<script>alert('잘못된 접근입니다.');self.close();</script>";
		exit;
	}

?>
<html>
	<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title>이전 배송지 보기</title>
	<script>
	function selectAddr(a,b,c,d,e,f,g,h,i,j,k) {
		frm = opener.orderFrm4;
		frm.recname.value = a;
		frm.rectel1.value = b;
		frm.rectel2.value = c;
		frm.rectel3.value = d;
		frm.rechtel1.value = e;
		frm.rechtel2.value = f;
		frm.rechtel3.value = g;
		frm.reczip1.value = h;
		frm.reczip2.value = i;
		frm.recaddress.value = j;
		frm.recaddress1.value = k;
		self.close();
	}
	</script>
	<style>
	td {
		font-family:돋움;
		font-size:12px;
		color:000000;
		line-height:180%;
	}
	a {
		font-family:돋움;
		font-size:12px;
		color:000000;
		line-height:180%;
		text-decoration:none;
	}
	a:hover {
		font-family:돋움;
		font-size:12px;
		color:000000;
		line-height:180%;
		text-decoration:underline;
	}

	</style>
	</head>
	<body style="margin:0">
	<table border=0 cellpadding=0 cellspacing=0 width=100% height=100%>
		<tr>
			<td background="/img/popup_img_01.jpg" height=49><table width=100%  height=49 border=0 cellpadding=0 cellspacing=0>
				<tr>
					<td width=50% height=49 style="padding-left:11px"><img src="/img/popup_img_09.jpg" border=0></td>
					<td width=50% height=49 style="padding-right:7px" align=right><a href="#none" onclick="self.close()"><img src="/img/popup_img_03.jpg" border=0></a></td>
				</tr>
			</table></td>
		</tr>
		<tr>
			<td width=100% height=100% ><table width=100% height=100% border=0 cellpadding=0 cellspacing=0>
				<tr>
					<td width=100% height=100% valign=top>
						<!-- 내용 -->
						<table width=100% border=0 cellpadding=0 cellspacing=0>
<?
$res = mysql_query("select * from odtOrder where orderid='".$id."' group by recaddress1 order by orderdate desc");
if(!mysql_num_rows($res)) {
?>
							<tr>
								<td align=center>이전 배송 주소가 없습니다.</td>
							</tr>
			
<?
}
while($row = mysql_fetch_array($res)) {
	unset($rectel,$rechtel);
?>
							<tr>
							
								<td width=20% style="padding:5px" align=center><b><?=$row[recname]?></b></td>
								<td width=1px bgcolor=#cccccc></td>
								<td style="padding:5px">
								<?
									if($row[rectel3])		$rectel		= $row[rectel1] . "-". $row[rectel2]. "-".$row[rectel3];
									if($row[rechtel3])	$rechtel	= $row[rechtel1] . "-". $row[rechtel2]. "-".$row[rechtel3];
								?>
								<a href="#none" onclick="selectAddr('<?=$row[recname]?>','<?=$row[rectel1]?>','<?=$row[rectel2]?>','<?=$row[rectel3]?>','<?=$row[rechtel1]?>','<?=$row[rechtel2]?>','<?=$row[rechtel3]?>','<?=$row[reczip1]?>','<?=$row[reczip2]?>','<?=$row[recaddress]?>','<?=$row[recaddress1]?>')">
								<?=$rectel?> / <?=$rechtel?><br>
								(<?=$row[reczip1]."-".$row[reczip1]?>) &nbsp;<?=$row[recaddress]."<br>".$row[recaddress1]?>
								</a>
								</td>
							</tr>
							<tr>
								<td height=5></td>
							</tr>
<?
}
?>

						</table>
						<!-- 내용 끝 -->
					</td>
				</tr>
			</table></td>
		</tr>
    <tr>
      <td height="6" bgcolor="#aaa698"></td>
    </tr>
	</table>
	</body>
</html>