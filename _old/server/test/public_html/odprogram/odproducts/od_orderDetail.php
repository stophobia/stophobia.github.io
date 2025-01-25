<?
	include "../odcommon/od_config.inc.php";
	include "../odcommon/od_function.inc.php";
	include "../odcommon/od_lib.inc.php";

	$que = "select name,comment2 from odtProduct where code ='".$_GET[code]."'";
	$res = mysql_query($que);
	list($name,$comment) =  mysql_fetch_array($res);
?>
<html>
	<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title><?=$name;?> - 상세설명</title>
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
			<td background="/img/popup_img_01.jpg" height=49><table width=100%  height=49 border=0 cellpadding=0 cellspacing=0>
				<tr>
					<td width=50% height=49 style="padding-left:11px"><img src="/img/popup_img_02.jpg" border=0></td>
					<td width=50% height=49 style="padding-right:7px" align=right><a href="#none" onclick="self.close()"><img src="/img/popup_img_03.jpg" border=0></a></td>
				</tr>
			</table></td>
		</tr>
		<tr>
			<td width=100% height=100% ><table width=100% height=100% border=0 cellpadding=0 cellspacing=0>
				<tr>
					<td width=100% height=100%>
						<!-- 내용 -->
							<table border=0 cellpadding=0 cellspacing=0 align=center>
								<Tr>
									<td width=850 style="table-layout: fixed;" align=center><?=htmlspecialchars_decode($comment)?></td>
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







