<!--<script>
function Open_NewWindow(tForm)
{
    win_name = tForm.PartCode.options[tForm.PartCode.selectedIndex].value;
    //var newwin = window.open('', win_name);
    tForm.target = "_blank";
    tForm.action = "/odprogram/odmanager/od_main.php?skbn=y&mode=sub";//&cid="+value;
    tForm.submit(); 
}

</script>-->
<table width="100%" border="0" cellspacing="0" cellpadding="0">
			<tr>
				<td height="61" valign="bottom"> 
					<table border="0" cellspacing="0" cellpadding="0">
						<tr>
							<td width="166" bgcolor="#FFFFFF"><a href="/odprogram/odmanager/"><img src="/images/manager_img_09.jpg" border=0></a></td>
							<td width="141" valign="bottom" bgcolor="#FFFFFF">
								<a href="/" onfocus='this.blur();'><img src="/images/manager_img_10.jpg" name="basket1" border="0" id="usermode"></a></td>
							<td width="141" valign="bottom" bgcolor="#FFFFFF">
								<a href="/odprogram/odmanager/od_main.php?mode=sub"  target="_blank" onfocus='this.blur();'><img src="/images/manager_img_11.jpg"  border="0" id="adminmode"></a></td>
<!-- : 공급업체 리스트로 이동 110122
<td width="141" valign="bottom" bgcolor="#FFFFFF">
<form name="partnerForm" method="post">
<?

// 공급업체 자동로그인 접속 select박스 ////////////////////////////////////////
echo "
<select name='PartCode' style='width:170px;' onchange='Open_NewWindow(this.form);'>
    <option value=''  'selected';>공급업체 로그인</option>";

$Query  = " SELECT id, cName FROM odtMember where userType ='C' and cName !='' ORDER BY cName DESC ";
$Result = mysql_query($Query);
while ($Record = mysql_fetch_array($Result)) 
{
    echo "<option value='$Record[id]'>$Record[cName]</option>";
}

echo "
</select>";
?>
</form>
</td>
-->
                        
							<td  bgcolor="#FFFFFF" style='padding-left:10px'>
          <table width="100%" border="0" cellspacing="0" cellpadding="0" >
            <tr>
              <td><div align="right" style='font-size:11px;font-family:돋움'>&quot;http://<?=mysql_result(mysql_query("select homepage from odtCompany"),0)?>&quot; 쇼핑몰 관리자 모드입니다.</div></td>
            </tr>
          </table>
          <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td height="11"></td>
            </tr>
          </table>
<?PHP
	if($_COOKIE["auth_adminid"]){
?>
          <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td><div align="right" style='font-size:11px;font-family:돋움'>오늘의 판매총액은 <span class="style1"><?=number_format(@mysql_result(mysql_query("select sum(tPrice) from odtOrder where paydate like '".date('Y-m-d')."%' and paystatus='Y' and canceled='N'"),0))?></span> 원 입니다.</div></td>
            </tr>
          </table>
          <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td><div align="right" style='font-size:11px;font-family:돋움'>오늘의 총방문자수는 <span class="style2"><?=number_format(@mysql_result(mysql_query("select Visit_Num from odtCounterData where Year='".date('Y')."' and Month='".date('m')."' and Day='".date('d')."'"),0))?></span> 명 입니다.</div></td>
            </tr>
          </table>
<?PHP
		}
?>
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
          <td><div align="center"><a href="/odprogram/odmanager/odcommon/od_logoutManager.php"><img src="/images/manager_img_15.jpg" width="61" height="19" border=0 /></a></div></td>
        </tr>
      </table></td>
    <td width="786" valign="top"><img src="/images/manager_img_16.jpg" width="786" height="103" /></td>
    <td valign="top" background="/images/manager_img_17.jpg">&nbsp;</td>
  </tr>
</table>