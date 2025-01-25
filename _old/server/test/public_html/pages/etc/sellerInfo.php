<?php
// 필요한 설정파일 불러오기
include $_SERVER[DOCUMENT_ROOT]."/odprogram/odcommon/od_config.inc.php";
include $_SERVER[DOCUMENT_ROOT]."/odprogram/odcommon/od_function.inc.php";
include $_SERVER[DOCUMENT_ROOT]."/odprogram/odcommon/od_lib.inc.php";

$customerCode = mysql_result(mysql_query("select customerCode from odtProduct where code ='".$_GET[code]."'"),0);
$cRow = mysql_fetch_array(mysql_query("select * from odtMember where id='".$customerCode."'"));
?>
<html>
	<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title>판매자 정보</title>
	<script>
	function changeImg(imgsrc) {
		obj = document.getElementById('big_img');
		obj.src = imgsrc;
	}
	</script>
	</head>
	<body style="margin:0">

	<table border=0 cellpadding=0 cellspacing=0 width=100% height=100%>
		<tr>
			<td background="/img/odpopup_img_01.jpg" height=49><table width=100%  height=49 border=0 cellpadding=0 cellspacing=0>
				<tr>
					<td width=50% height=49 style="padding-left:11px"><img src="/img/odpopup_img_08.jpg" border=0></td>
					<td width=50% height=49 style="padding-right:7px" align=right><a href="#none" onclick="self.close()"><img src="/img/odpopup_img_03.jpg" border=0></a></td>
				</tr>
			</table></td>
		</tr>
		<tr>
			<td width=100% height=100% ><table width=100% height=100% border=0 cellpadding=0 cellspacing=0>
				<tr>
					<td width=100% height=100% align=center>
					<!-- 내용 시작 -->

						<table  width=452 height=178 border=0 cellpadding=0 cellspacing=0 bgcolor="f3f3f3" align=center>
							<tr>
								<td width=11></td>
								<td width=141 valign=middle><img src="<?=$cRow[pic] ? $cRow[pic] : "/images/no_img2.gif";?>"></td>
								<td width=20></td>
								<td valign=middle><table border=0 cellpadding=0 cellspacing=0>
									<tr>
										<td height=27><img src="/images/seller_10.gif"></td>
										<td style="color:333333;font-weight:bold;font-size:12;font-family:돋움;">판매자 : <span style="color:666666"><?=$cRow[cName] ? $cRow[cName] : "미입력";?></span></td>
									</tr>
									<tr>
										<td height=27><img src="/images/seller_10.gif"></td>
										<td style="color:333333;font-weight:bold;font-size:12;font-family:돋움;">주소 : <span style="color:666666"><?=$cRow[address] ? $cRow[address] : "미입력";?></span></td>
									</tr>
									<tr>
										<td height=27><img src="/images/seller_10.gif"></td>
										<td style="color:333333;font-weight:bold;font-size:12;font-family:돋움;">연락처 : <span style="color:666666"><?=$cRow[tel2] ? $cRow[tel1]. "-".$cRow[tel2] . "-".$cRow[tel3] : "미입력";?></span></td>
									</tr>
									<tr>
										<td height=27><img src="/images/seller_10.gif"></td>
										<td style="color:333333;font-weight:bold;font-size:12;font-family:돋움;">홈페이지 : <span style="color:ed7115"><?=$cRow[homepage] ? $cRow[homepage] : "미입력";?></span></td>
									</tr>
								</table></td>
							</tr>
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
