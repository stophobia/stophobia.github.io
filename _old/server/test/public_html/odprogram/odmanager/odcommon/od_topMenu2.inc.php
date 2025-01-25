		<table width="100%" border="0" cellspacing="0" cellpadding="0">
			<tr>
				<td height="61" valign="bottom"> 
					<table border="0" cellspacing="0" cellpadding="0">
						<tr>
							<td width="166" bgcolor="#FFFFFF"><a href="/odprogram/odmanager/"><img src="/images/manager_img_09.jpg" border=0></a></td>
							<td width="141" valign="bottom" bgcolor="#FFFFFF">
								<a href="/" onfocus='this.blur();'><img src="/images/manager_img_10.jpg" name="basket1" border="0" id="usermode"></a></td>
							<td width="141" valign="bottom" bgcolor="#FFFFFF">
								<a href="/odprogram/odmanager/"  target="_blank" onfocus='this.blur();'><img src="/images/manager_img_11.jpg"  border="0" id="adminmode"></a></td>
							<td  bgcolor="#FFFFFF" style='padding-left:10px'>
          <table width="100%" border="0" cellspacing="0" cellpadding="0" >
            <tr>
              <td><div align="right" style='font-size:11px;font-family:돋움'>&quot;http://<?=mysql_result(mysql_query("select homepage from odtCompany"),0)?>&quot; <br>공급업체(<?=$com[cName]?>) 관리자 모드입니다.</div></td>
            </tr>
          </table>
          <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td height="11"></td>
            </tr>
          </table>
							</td>
						</tr>
					</table>
				</td>
			</tr>
		</table>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="182" height="91" valign="top" background="/images/manager_img_13.jpg">
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td height="19"></td>
      </tr>
    </table>
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td><div align="center" style='font-size:12px;font-family:돋움'><img src="/images/manager_img_14.jpg" width="10" height="10" /> <strong><?=$row_company[name]?> 몰</strong>에<br /> 오신것을
            환영합니다.</div></td>
        </tr>
      </table>
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td height="10"></td>
        </tr>
      </table>
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td><div align="center"><a href="/odprogram/odmanager/odcommon/od_logoutManager2.php"><img src="/images/manager_img_15.jpg" width="61" height="19" border=0 /></a></div></td>
        </tr>
      </table></td>
    <td width="786" valign="top"><img src="/images/manager_img_16.jpg" width="786" height="103" /></td>
    <td valign="top" background="/images/manager_img_17.jpg">&nbsp;</td>
  </tr>
</table>