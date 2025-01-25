<?
$switch_manager_page = "";
?>
		<script language="javascript">
			function doTwinkle() {
				var twinkle = document.all.tags("BLINK")
				for(var i=0;i<twinkle.length;i++)
				twinkle[i].style.visibility = twinkle[i].style.visibility == "" ? "hidden" : ""
			}
			function startTwinkle() {
				if(document.all)
				setInterval("doTwinkle()",555)
			}
			window.onload = startTwinkle;
		</script>

<?
	## 현재의 메뉴를 구분하기 위한 쿠키값 
	if(!$sub_menu) $sub_menu = 1;

	for($i=1;$i<=30;$i++){
		if($i == $sub_menu){
			$blinkTemp[$i] = "<blink>";
			$blinkTemp_[$i] = "</blink>"; 

			$blinkTemp_style[$i] = "style='display:'";
		}
		else{
			$blinkTemp[$i] = "";
			$blinkTemp_[$i] = ""; 

			$blinkTemp_style[$i] = "style='display:none'";
		}
	}
?>

		<table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td><img src="/images/manager_img_18.jpg" width="182" height="69" /></td>
      </tr>
    </table>

			<!-- 입점업체 쿠폰주문관리현황 관리  -->
			<?
			$idxTmp = 16;
			?>
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="27" height="28"></td>
          <td valign="top"  width="180"  background="/images/manager_img_19.jpg"><table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td width="25" height="28"><?=$blinkTemp[$idxTmp]?><img src="/images/manager_img_20.jpg" width="25" height="28" /><?=$blinkTemp_[$idxTmp]?></td>
              <td width="8"></td>
              <td><span class="style3"  onclick="self.location.replace('<?=$folderpath_manager?>/odcommon/od_menu_check.php?sub_menu2=<?=$idxTmp?>');" style='cursor:hand;'>쿠폰주문관리</span></td>
            </tr>
          </table></td>
        </tr>
		<tr > 
			<td align="center" colspan=2>
				 <table width="100%" border="0" cellspacing="0" cellpadding="0">
					<tr>
						<td width="27" height="28"></td>
						<td valign="top"  width="180"  background="/images/manager_img_19.jpg"><table width="100%" border="0" cellspacing="0" cellpadding="0">
								<tr>
									<td width="25" height="28"><img src="/images/manager_img_21.jpg" width="25" height="28" /></td>
									<td width="8"></td>
									<td class="cate"><a href="<?=$path_home?>/odmanager/odorders2/od_orderslist.php?search_value_=true&delivstatus=no" onfocus='this.blur();'  id='help00'>발급대기 리스트</a></td>
								</tr>
						</table></td>
					</tr>
				</table>
			</td>
		</tr>
		<tr > 
			<td align="center" colspan=2>
				 <table width="100%" border="0" cellspacing="0" cellpadding="0">
					<tr>
						<td width="27" height="28"></td>
						<td valign="top"  width="180"  background="/images/manager_img_19.jpg"><table width="100%" border="0" cellspacing="0" cellpadding="0">
								<tr>
									<td width="25" height="28"><img src="/images/manager_img_21.jpg" width="25" height="28" /></td>
									<td width="8"></td>
									<td class="cate"><a href="<?=$path_home?>/odmanager/odorders2/od_orderslist.php?search_value_=true&delivstatus=yes" onfocus='this.blur();'  id='help06'>발급완료 리스트</a></td>
								</tr>
						</table></td>
					</tr>
				</table>
			</td>
		</tr>
	</table>

			<!-- 입점업체 배송주문현황 관리  -->
			<?
			$idxTmp = 29;
			?>
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="27" height="28"></td>
          <td valign="top"  width="180"  background="/images/manager_img_19.jpg"><table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td width="25" height="28"><?=$blinkTemp[$idxTmp]?><img src="/images/manager_img_20.jpg" width="25" height="28" /><?=$blinkTemp_[$idxTmp]?></td>
              <td width="8"></td>
              <td><span class="style3"  onclick="self.location.replace('<?=$folderpath_manager?>/odcommon/od_menu_check.php?sub_menu2=<?=$idxTmp?>');" style='cursor:hand;'>배송주문관리</span></td>
            </tr>
          </table></td>
        </tr>
		<tr > 
			<td align="center" colspan=2>
				 <table width="100%" border="0" cellspacing="0" cellpadding="0">
					<tr>
						<td width="27" height="28"></td>
						<td valign="top"  width="180"  background="/images/manager_img_19.jpg"><table width="100%" border="0" cellspacing="0" cellpadding="0">
								<tr>
									<td width="25" height="28"><img src="/images/manager_img_21.jpg" width="25" height="28" /></td>
									<td width="8"></td>
									<td class="cate"><a href="<?=$path_home?>/odmanager/odorders2/od_dlv_orderslist.php?search_value_=true&delivstatus=no" onfocus='this.blur();'  id='help00'>배송대기 리스트</a></td>
								</tr>
						</table></td>
					</tr>
				</table>
			</td>
		</tr>
		<tr > 
			<td align="center" colspan=2>
				 <table width="100%" border="0" cellspacing="0" cellpadding="0">
					<tr>
						<td width="27" height="28"></td>
						<td valign="top"  width="180"  background="/images/manager_img_19.jpg"><table width="100%" border="0" cellspacing="0" cellpadding="0">
								<tr>
									<td width="25" height="28"><img src="/images/manager_img_21.jpg" width="25" height="28" /></td>
									<td width="8"></td>
									<td class="cate"><a href="<?=$path_home?>/odmanager/odorders2/od_dlv_orderslist.php?search_value_=true&delivstatus=yes" onfocus='this.blur();'  id='help06'>배송완료 리스트</a></td>
								</tr>
						</table></td>
					</tr>
				</table>
			</td>
		</tr>

		<tr > 
			<td align="center" colspan=2>
				 <table width="100%" border="0" cellspacing="0" cellpadding="0">
					<tr>
						<td width="27" height="28"></td>
						<td valign="top"  width="180"  background="/images/manager_img_19.jpg"><table width="100%" border="0" cellspacing="0" cellpadding="0">
								<tr>
									<td width="25" height="28"><img src="/images/manager_img_21.jpg" width="25" height="28" /></td>
									<td width="8"></td>
									<td class="cate"><a href="<?=$path_home?>/odmanager/odorders2/od_dlv_expressList.php" onfocus='this.blur();'  id='help06'>운송장일괄입력</a></td>
								</tr>
						</table></td>
					</tr>
				</table>
			</td>
		</tr>


	</table>
