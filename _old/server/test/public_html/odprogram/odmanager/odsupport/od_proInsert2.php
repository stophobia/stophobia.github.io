<?
	include "../../odcommon/od_config.inc.php";
	include "../odcommon/od_function.inc.php";		
	include "../odcommon/od_adminAuthority.inc.php";
	include "../odcommon/od_head.inc.php";
	include "../odcommon/od_body.inc.php";

	## 세부권한 체크
	if($row_admin[productLevel] < 3) {
		error_msgloc("../","접근권한이 없습니다.   ");
	}
	
?>

		<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="FFFFFF">
			<tr> 
				<td height="80" bgcolor="#FFFFFF">
					<!-- top menu start -->
<? include "../odcommon/od_topMenu.inc.php"; ?>
					<!-- top menu end -->
				</td>
			</tr>
			<tr> 
				<td valign="top"> 
					<table width="100%" border="0" cellspacing="0" cellpadding="0">
						<tr>
							<td height="6"></td>
						</tr>
					</table>
					<table height="100%" border="0" cellpadding="0" cellspacing="0">
						<tr>
							<td width="165" height="100%" valign="top"> 
								<!-- left menu start -->
<? include "../odcommon/od_leftMenu.inc.php"; ?>
								<!-- left menu end -->
							</td>
							<td width="3">&nbsp;</td>
							<td width="782" valign="top">
								<!-- main table start -->

								<table width="782" height="100%" border="0" cellpadding="10" cellspacing="1" bgcolor="D6D6D6">
									<tr> 
										<td align="center" valign="top" bgcolor="#FFFFFF"> 
											<table width="100%" border="0" cellspacing="0" cellpadding="0">
												<tr> 
													<td height="33"><font color="313D7D"><img src="../odimages/odmain/title_icon.gif" width="13" height="13" hspace="1" align="absmiddle"> 상품공급서포트 &gt; <span class="st">상품등록</span></font></td>
												</tr>
											</table>
											<span id='proAgree'>
											<table width="100%" border="0" cellspacing="1" cellpadding="0">

												<tr> 
													<td height="2" bgcolor="D6D6D6"></td>
												</tr>
												<tr>
													<td height="5"></td>
												</tr>
											</table>
											<table width="100%" border="0" cellspacing="0" cellpadding="0">
												<tr> 
													<td height="18" align=center><img src="http://www.onedaynet.co.kr/odimages/supportInfo_2.jpg"></td>
												</tr>
											</table>
											<form name="proFrm" style='display:inline'>
											<table width="100%" border="0" cellspacing="1" cellpadding="0">
												<tr>
													<td height="30" align=center>위 내용을 읽었으며 동의합니다. <input type="checkbox" name="agree" value="Y" ></td>
												</tr>
											</table>
											<table width="100%" border=0 cellpadding=0 cellspacing=1>
												<tr>
													<td height=60 align=center><a href="#none" onclick="if(proFrm.agree.checked) {document.getElementById('proListFrame').style.display='';document.getElementById('proAgree').style.display='none'} else {alert('동의하셔야 상품리스트를 보실수 있습니다')}"><img src="/img/proSubmit.jpg" border=0 ></a></td>
												</tr>
											</table>
											</form>
											</span>
											<span id='proListFrame'  style='display:none'>
											<table width="100%" border="0" cellspacing="1" cellpadding="0">
												<tr>
													<td height="5"></td>
												</tr>
												<tr> 
													<td height="2" bgcolor="D6D6D6"></td>
												</tr>
											</table>
											<table width="100%" border="0" cellspacing="1" cellpadding="0">
												<tr> 
													<td height="11"></td>
												</tr>
											</table>
											<iframe src="http://www.onedaynet.co.kr/support_mart/proInsert.php?id=<?=$onedaynet_id?>" name="supportFrm" width="800" height="1600" frameborder=0></iframe>

											</span>
										</td>
									</tr>
									<tr>
										<td height="5" bgcolor="#FFFFFF"></td>
									</tr>
								</table>

								<!-- main table end -->
							</td>
						</tr>
					</table>
				</td>
			</tr>
			<tr>
				<td height="83">
					<!-- bottom start -->
<? include "../odcommon/od_bottom.inc.php"; ?>
					<!-- bottom end -->
				</td>
			</tr>
		</table>
	</body>
</html>
