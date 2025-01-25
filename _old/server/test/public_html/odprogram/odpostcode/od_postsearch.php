<? 	include "../odcommon/od_config.inc.php"; ?>
<html>
	<head>
		<title>우편번호 검색</title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<link href="/css/style.css" rel="stylesheet" type="text/css">
		<script language=javascript>
			function MoveFocus() {
				document.snsForm.search_str.focus();
			}

			function SendPostCheck() {
				str = document.snsForm.search_str.value;
				
				if(str == "") {
					alert("검색어를 기입해 주십시오.");
					document.snsForm.search_str.focus();
					return false;
				}
			}
		</script>
	</head>
	<body bgcolor="#FFFFFF" leftmargin="0" topmargin="0" onload="document.snsForm.search_str.focus();">

	<table border=0 cellpadding=0 cellspacing=0 width=100% height=100%>
		<tr>
			<td background="/img/popup_img_01.jpg" height=49><table width=100%  height=49 border=0 cellpadding=0 cellspacing=0>
				<tr>
					<td width=50% height=49 style="padding-left:11px"><img src="/img/popup_img_07.jpg" border=0></td>
					<td width=50% height=49 style="padding-right:7px" align=right><a href="#none" onclick="self.close()"><img src="/img/popup_img_03.jpg" border=0></a></td>
				</tr>
			</table></td>
		</tr>
		<tr>
			<td width=100% height=100% ><table width=100% height=100% border=0 cellpadding=0 cellspacing=0>
				<tr>
					<td width=100% height=100% align=center>
					<!-- 내용 시작 -->
					<table width="330" border="0" cellspacing="0" cellpadding="0">
						<tr>
							<td>
								<table width="330" border="0" cellspacing="1" cellpadding="0">
									<tr> 
										<td width="10" height="60" align="center" class="cate"><img src="../odimages/odmypage/icon_oranarrow.gif" width="10" height="11" align="absmiddle"><br> 
											<br> <br> </td>
										<td class="locat">찾고자 하는 주소의 동/읍/면 이름을 입력하세요.<br>
											<font color="FF7019">예) 압구정동/단양읍/수산면/설운동</font></td>
									</tr>
								</table>
							</td>
						</tr>
						<tr>
							<td height="40" align="center"> 
								<!-- form start -->
								<table border="0" cellspacing="1" cellpadding="0">
									<form name="snsForm" action='od_postsearchresult.php' method=post onSubmit="return SendPostCheck(this)">
										<input type="hidden" name="Mode" value="<?=$Mode?>">
									<tr> 
										<td width="45" class="cate"><strong><img src="../odimages/odmypage/icon_oranarrow.gif" width="10" height="11" align="absmiddle">검색</strong></td>
										<td>
											<input name="search_str" type="text" class="gray" size="27" style="ime-mode:active"> 
											<input type="image" src="../odimages/odcommunity/bbtn_search.gif" width="35" height="24" align="absmiddle"></td>
									</tr>
									</form>
								</table>
								<!-- form end -->
							</td>
						</tr>
						<tr>
							<td>&nbsp;</td>
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
