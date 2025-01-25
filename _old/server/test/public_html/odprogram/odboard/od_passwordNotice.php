<?
	include "../odcommon/od_config.inc.php";
	include "../odcommon/od_function.inc.php";
	include "od_board.inc.php";
	
	## 글읽기 권한체크
	if($configReadLevel > $Cooki_Member_Level) historyBack();

	## Par 정리 ###########################################################################
	$parTemp = "?board=$board";
	if($page) $parTemp .= "&page=$page";
	if($serialnum) $parTemp .= "&serialnum=$serialnum";
	if($field) $parTemp .= "&field=$field";
	if($value) $parTemp .= "&value=$value";
	if($pTemp) $parTemp .="&pTemp=$pTemp";
?>

<html>
	<head>
		<title>비밀번호 확인</title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<link rel="stylesheet" href="/css/style.css" type="text/css">
		<script>
		<!--
			var openerTarget;
			openerTarget = opener;
			openerTarget.name = 'onedaynet_main';
		//-->
		</script>
	</head>
	<body leftmargin="0" topmargin="0">
		<table border="0" cellspacing="0" cellpadding="0">
			<form name='form1' action='od_noticedel.php' method='post' target="onedaynet_main" onsubmit="window.close();">
				<input type='hidden' name='board' value='<?=$board?>'>
				<input type='hidden' name='serialnum' value='<?=$serialnum?>'>
				<input type='hidden' name='noticeserialnum' value='<?=$noticeserialnum?>'>
				<input type='hidden' name='page' value='<?=$page?>'>
				<input type='hidden' name='field' value='<?=$field?>'>
				<input type='hidden' name='value' value='<?=$value?>'>
				<input type="hidden" name="pTemp" value="<?=$pTemp?>">
			<tr> 
				<td><img src="../odimages/odboard/passnum_title.gif" width="330" height="45"></td>
			</tr>
			<tr>
				<td>&nbsp;</td>
			</tr>
			<tr> 
				<td align="center"> 
					<table width="240" border="0" cellspacing="1" cellpadding="1">
						<tr> 
							<td>비밀번호를 입력해 주시기 바랍니다.</td>
						</tr>
						<tr> 
							<td>
								<input name="password" type="password" size="25">
								<script language='JavaScript'>
									document.form1.password.focus();
								</script>
								<input type="image" src="../odimages/odboard/btn_confirm02.gif" width="42" height="24" align="absmiddle"> 
							</td>
						</tr>
					</table>
				</td>
			</tr>
			<tr> 
				<td height="25" align="center" valign="top"></td>
			</tr>
			<tr> 
				<td height="6" bgcolor="F5F5F5"></td>
			</tr>
			<tr> 
				<td height="1" bgcolor="DBDBDB"></td>
			</tr>
			</form>
		</table>
	</body>
</html>
