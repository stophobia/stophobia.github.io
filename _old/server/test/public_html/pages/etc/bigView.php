<?php
// 필요한 설정파일 불러오기
include $_SERVER[DOCUMENT_ROOT]."/odprogram/odcommon/od_config.inc.php";
include $_SERVER[DOCUMENT_ROOT]."/odprogram/odcommon/od_function.inc.php";
include $_SERVER[DOCUMENT_ROOT]."/odprogram/odcommon/od_lib.inc.php";

$que = "select * from odtProduct where code ='".$_GET[code]."'";
$res = mysql_query($que);
$row = mysql_fetch_array($res);

?>
<html>
	<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title><?=$row[name];?> 이미지 크게 보기</title>
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
					<td width=50% height=49 style="padding-left:11px"><img src="/img/odpopup_img_02.jpg" border=0></td>
					<td width=50% height=49 style="padding-right:7px" align=right><a href="#none" onclick="self.close()"><img src="/img/odpopup_img_03.jpg" border=0></a></td>
				</tr>
			</table></td>
		</tr>
		<tr>
			<td width=100% height=100% ><table width=100% height=100% border=0 cellpadding=0 cellspacing=0>
				<tr>
					<td width=100% height=100%>
						<!-- 내용 -->
						<table width=100% height=100% border=0 cellpadding=0 cellspacing=0>
							<tr>
								<td><table width=610 height=610 border=0 cellspacing=0 cellpadding=0>
									<Tr>
										<td width=610 height=610 align=center><img src="<?=$row[big1_img]?>" width=600 height=600 id='big_img'></td>
									</tr>
								</table></td>
								<td><table border=0 cellspacing=0 cellpadding=0>
									<Tr>
										<td width=121 height=610 valign=top style="padding-top:5px">
										<table border=0 cellpadding=0 cellspacing=0>

											<tr>
												<td width=115 height=115><a href="#none" onclick="changeImg('<?=$row[big1_img]?>')"><img src="<?=$row[big1_img]?>" width=113 height=113 id='big_img' style="border:1px solid #cdd6dd" border=0></a></td>
											</tr>
											<tr>
												<td height=6></td>
											</tr>

<?
if($row[big2_img]) {
?>
											<tr>
												<td width=115 height=115><a href="#none" onclick="changeImg('<?=$row[big2_img]?>')"><img src="<?=$row[big2_img]?>" width=113 height=113 id='big_img' style="border:1px solid #cdd6dd" border=0></a></td>
											</tr>
											<tr>
												<td height=6></td>
											</tr>
<?
}
?>
<?
if($row[big3_img]) {
?>
											<tr>
												<td width=115 height=115><a href="#none" onclick="changeImg('<?=$row[big3_img]?>')"><img src="<?=$row[big3_img]?>" width=113 height=113 id='big_img' style="border:1px solid #cdd6dd" border=0></a></td>
											</tr>
											<tr>
												<td height=6></td>
											</tr>
<?
}
?>
<?
if($row[big4_img]) {
?>
											<tr>
												<td width=115 height=115><a href="#none" onclick="changeImg('<?=$row[big4_img]?>')"><img src="<?=$row[big4_img]?>" width=113 height=113 id='big_img' style="border:1px solid #cdd6dd" border=0></a></td>
											</tr>
											<tr>
												<td height=6></td>
											</tr>
<?
}
?>
<?
if($row[big5_img]) {
?>
											<tr>
												<td width=115 height=115><a href="#none" onclick="changeImg('<?=$row[big5_img]?>')"><img src="<?=$row[big5_img]?>" width=113 height=113 id='big_img' style="border:1px solid #cdd6dd" border=0></a></td>
											</tr>
											<tr>
												<td height=6></td>
											</tr>
<?
}
?>


										</table>
										</td>
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