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

<?
// 관리자 전용 메뉴
if($row_admin[id]) {
?>

			<!-- 회원 관리  -->
			<?
			$idxTmp = 4;
			?>
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="27" height="28"></td>
          <td valign="top"  width="180"  background="/images/manager_img_19.jpg"><table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td width="25" height="28"><?=$blinkTemp[$idxTmp]?><img src="/images/manager_img_20.jpg" width="25" height="28" /><?=$blinkTemp_[$idxTmp]?></td>
              <td width="8"></td>
              <td><span class="style3"  onclick="self.location.replace('<?=$folderpath_manager?>/odcommon/od_menu_check.php?sub_menu2=<?=$idxTmp?>');" style='cursor:hand;'>회원관리</span></td>
            </tr>
          </table></td>
        </tr>
				<tr <?=$blinkTemp_style[$idxTmp];?>> 
					<td align="center" colspan=2>
						 <table width="100%" border="0" cellspacing="0" cellpadding="0">
							<tr>
								<td width="27" height="28"></td>
								<td valign="top"  width="180"  background="/images/manager_img_19.jpg"><table width="100%" border="0" cellspacing="0" cellpadding="0">
										<tr>
											<td width="25" height="28"><img src="/images/manager_img_21.jpg" width="25" height="28" /></td>
											<td width="8"></td>
											<td class="cate"><a href="<?=$path_home?>/odmanager/odmembers/od_list.php" onfocus='this.blur();'>회원목록</a></td>
										</tr>
								</table></td>
							</tr>
						</table>

						 <table width="100%" border="0" cellspacing="0" cellpadding="0">
							<tr>
								<td width="27" height="28"></td>
								<td valign="top"  width="180"  background="/images/manager_img_19.jpg"><table width="100%" border="0" cellspacing="0" cellpadding="0">
										<tr>
											<td width="25" height="28"><img src="/images/manager_img_21.jpg" width="25" height="28" /></td>
											<td width="8"></td>
											<td class="cate"><a href="<?=$path_home?>/odmanager/odmembers/od_mailSMSList.php" onfocus='this.blur();'>구독자리스트</a></td>
										</tr>
								</table></td>
							</tr>
						</table>

						 <table width="100%" border="0" cellspacing="0" cellpadding="0">
							<tr>
								<td width="27" height="28"></td>
								<td valign="top"  width="180"  background="/images/manager_img_19.jpg"><table width="100%" border="0" cellspacing="0" cellpadding="0">
										<tr>
											<td width="25" height="28"><img src="/images/manager_img_21.jpg" width="25" height="28" /></td>
											<td width="8"></td>
											<td class="cate"><a href="<?=$path_home?>/odmanager/odpoint/od_pointlist.php" onfocus='this.blur();'>포인트 발급/내역</a></td>
										</tr>
								</table></td>
							</tr>
						</table>

						 <table width="100%" border="0" cellspacing="0" cellpadding="0">
							<tr>
								<td width="27" height="28"></td>
								<td valign="top"  width="180"  background="/images/manager_img_19.jpg"><table width="100%" border="0" cellspacing="0" cellpadding="0">
										<tr>
											<td width="25" height="28"><img src="/images/manager_img_21.jpg" width="25" height="28" /></td>
											<td width="8"></td>
											<td class="cate"><a href="<?=$path_home?>/odmanager/odcoupon/od_couponlist.php" onfocus='this.blur();'>쿠폰발급/내역</a></td>
										</tr>
								</table></td>
							</tr>
						</table>
					
						 <table width="100%" border="0" cellspacing="0" cellpadding="0">
							<tr>
								<td width="27" height="28"></td>
								<td valign="top"  width="180"  background="/images/manager_img_19.jpg"><table width="100%" border="0" cellspacing="0" cellpadding="0">
										<tr>
											<td width="25" height="28"><img src="/images/manager_img_21.jpg" width="25" height="28" /></td>
											<td width="8"></td>
											<td class="cate"><a href="<?=$path_home?>/odmanager/odcustomer/od_list.php" onfocus='this.blur();'>공급업체목록</a></td>
										</tr>
								</table></td>
							</tr>
						</table>
					
						 <table width="100%" border="0" cellspacing="0" cellpadding="0">
							<tr>
								<td width="27" height="28"></td>
								<td valign="top"  width="180"  background="/images/manager_img_19.jpg"><table width="100%" border="0" cellspacing="0" cellpadding="0">
										<tr>
											<td width="25" height="28"><img src="/images/manager_img_21.jpg" width="25" height="28" /></td>
											<td width="8"></td>
											<td class="cate"><a href="<?=$path_home?>/odmanager/odtitle/od_mdList.php" onfocus='this.blur();'>MD 관리</a></td>
										</tr>
								</table></td>
							</tr>
						</table>

						 <table width="100%" border="0" cellspacing="0" cellpadding="0">
							<tr>
								<td width="27" height="28"></td>
								<td valign="top"  width="180"  background="/images/manager_img_19.jpg"><table width="100%" border="0" cellspacing="0" cellpadding="0">
										<tr>
											<td width="25" height="28"><img src="/images/manager_img_21.jpg" width="25" height="28" /></td>
											<td width="8"></td>
											<td class="cate"><a href="<?=$path_home?>/odmanager/odmembers/od_age.php" onfocus='this.blur();'>연령별회원통계</a></td>
										</tr>
								</table></td>
							</tr>
						</table>
						<table width="100%" border="0" cellspacing="0" cellpadding="0">
							<tr>
								<td width="27" height="28"></td>
								<td valign="top"  width="180"  background="/images/manager_img_19.jpg"><table width="100%" border="0" cellspacing="0" cellpadding="0">
										<tr>
											<td width="25" height="28"><img src="/images/manager_img_21.jpg" width="25" height="28" /></td>
											<td width="8"></td>
											<td class="cate"><a href="<?=$path_home?>/odmanager/odmembers/od_area.php" onfocus='this.blur();'>지역별회원통계</a></td>
										</tr>
								</table></td>
							</tr>
						</table>
						 <table width="100%" border="0" cellspacing="0" cellpadding="0">
							<tr>
								<td width="27" height="28"></td>
								<td valign="top"  width="180"  background="/images/manager_img_19.jpg"><table width="100%" border="0" cellspacing="0" cellpadding="0">
										<tr>
											<td width="25" height="28"><img src="/images/manager_img_21.jpg" width="25" height="28" /></td>
											<td width="8"></td>
											<td class="cate"><a href="<?=$path_home?>/odmanager/odcs/od_cs2List.php" onfocus='this.blur();'>고객 1:1문의</a></td>
										</tr>
								</table></td>
							</tr>
						</table>

					</td>
				</tr>
			</table>

			<!-- 상품 관리  -->
			<?
			$idxTmp = 5;
			?>
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="27" height="28"></td>
          <td valign="top"  width="180"  background="/images/manager_img_19.jpg"><table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td width="25" height="28"><?=$blinkTemp[$idxTmp]?><img src="/images/manager_img_20.jpg" width="25" height="28" /><?=$blinkTemp_[$idxTmp]?></td>
              <td width="8"></td>
              <td><span class="style3"  onclick="self.location.replace('<?=$folderpath_manager?>/odcommon/od_menu_check.php?sub_menu2=<?=$idxTmp?>');" style='cursor:hand;'>상품관리</span></td>
            </tr>
          </table></td>
        </tr>
				<tr <?=$blinkTemp_style[$idxTmp];?>> 
					<td align="center" colspan=2>
						 <table width="100%" border="0" cellspacing="0" cellpadding="0">
							<tr>
								<td width="27" height="28"></td>
								<td valign="top"  width="180"  background="/images/manager_img_19.jpg"><table width="100%" border="0" cellspacing="0" cellpadding="0">
										<tr>
											<td width="25" height="28"><img src="/images/manager_img_21.jpg" width="25" height="28" /></td>
											<td width="8"></td>
											<td class="cate"><a href="<?=$path_home?>/odmanager/odproducts/od_category.php" onfocus='this.blur();'>지역관리</a></td>
										</tr>
								</table></td>
							</tr>
						</table>
						 <table width="100%" border="0" cellspacing="0" cellpadding="0">
							<tr>
								<td width="27" height="28"></td>
								<td valign="top"  width="180"  background="/images/manager_img_19.jpg"><table width="100%" border="0" cellspacing="0" cellpadding="0">
										<tr>
											<td width="25" height="28"><img src="/images/manager_img_21.jpg" width="25" height="28" /></td>
											<td width="8"></td>
											<td class="cate"><a href="<?=$path_home?>/odmanager/odproducts/od_calList.php" onfocus='this.blur();'>상품등록</a></td>
										</tr>
								</table></td>
							</tr>
						</table>
						 <table width="100%" border="0" cellspacing="0" cellpadding="0">
							<tr>
								<td width="27" height="28"></td>
								<td valign="top"  width="180"  background="/images/manager_img_19.jpg"><table width="100%" border="0" cellspacing="0" cellpadding="0">
										<tr>
											<td width="25" height="28"><img src="/images/manager_img_21.jpg" width="25" height="28" /></td>
											<td width="8"></td>
											<td class="cate"><a href="<?=$path_home?>/odmanager/odproducts/od_list.php" onfocus='this.blur();'>상품수정</a></td>
										</tr>
								</table></td>
							</tr>
						</table>
						 <table width="100%" border="0" cellspacing="0" cellpadding="0">
							<tr>
								<td width="27" height="28"></td>
								<td valign="top"  width="180"  background="/images/manager_img_19.jpg"><table width="100%" border="0" cellspacing="0" cellpadding="0">
										<tr>
											<td width="25" height="28"><img src="/images/manager_img_21.jpg" width="25" height="28" /></td>
											<td width="8"></td>
											<td class="cate"><a href="<?=$path_home?>/odmanager/odproducts/od_encoreList.php" onfocus='this.blur();'>앵콜신청확인</a></td>
										</tr>
								</table></td>
							</tr>
						</table>
					</td>
				</tr>
			</table>



			<!-- 주문 관리  -->
			<?
			$idxTmp = 6;
			?>
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="27" height="28"></td>
          <td valign="top"  width="180"  background="/images/manager_img_19.jpg"><table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td width="25" height="28"><?=$blinkTemp[$idxTmp]?><img src="/images/manager_img_20.jpg" width="25" height="28" /><?=$blinkTemp_[$idxTmp]?></td>
              <td width="8"></td>
              <td><span class="style3"  onclick="self.location.replace('<?=$folderpath_manager?>/odcommon/od_menu_check.php?sub_menu2=<?=$idxTmp?>');" style='cursor:hand;'>주문관리</span></td>
            </tr>
          </table></td>
        </tr>
				<tr <?=$blinkTemp_style[$idxTmp];?>> 
					<td align="center" colspan=2>
						 <table width="100%" border="0" cellspacing="0" cellpadding="0">
							<tr>
								<td width="27" height="28"></td>
								<td valign="top"  width="180"  background="/images/manager_img_19.jpg"><table width="100%" border="0" cellspacing="0" cellpadding="0">
										<tr>
											<td width="25" height="28"><img src="/images/manager_img_21.jpg" width="25" height="28" /></td>
											<td width="8"></td>
											<td class="cate"><a href="<?=$path_home?>/odmanager/odorders/od_orderslist.php" onfocus='this.blur();'>주문목록</a></td>
										</tr>
								</table></td>
							</tr>
						</table>
						 <table width="100%" border="0" cellspacing="0" cellpadding="0" style="display:none;">
							<tr>
								<td width="27" height="28"></td>
								<td valign="top"  width="180"  background="/images/manager_img_19.jpg"><table width="100%" border="0" cellspacing="0" cellpadding="0">
										<tr>
											<td width="25" height="28"><img src="/images/manager_img_21.jpg" width="25" height="28" /></td>
											<td width="8"></td>
											<td class="cate"><a href="<?=$path_home?>/odmanager/odorders/od_orderslist.php?style=b" onfocus='this.blur();'>주문목록[무통장]</a></td>
										</tr>
								</table></td>
							</tr>
						</table>
						 <table width="100%" border="0" cellspacing="0" cellpadding="0">
							<tr>
								<td width="27" height="28"></td>
								<td valign="top"  width="180"  background="/images/manager_img_19.jpg"><table width="100%" border="0" cellspacing="0" cellpadding="0">
										<tr>
											<td width="25" height="28"><img src="/images/manager_img_21.jpg" width="25" height="28" /></td>
											<td width="8"></td>
											<td class="cate"><a href="<?=$path_home?>/odmanager/odorders/od_orderslistCancel.php" onfocus='this.blur();'>취소주문목록</a></td>
										</tr>
								</table></td>
							</tr>
						</table>
<!--발급대기 추가 -->
                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
							<tr>
								<td width="27" height="28"></td>
								<td valign="top"  width="180"  background="/images/manager_img_19.jpg"><table width="100%" border="0" cellspacing="0" cellpadding="0">
										<tr>
											<td width="25" height="28"><img src="/images/manager_img_21.jpg" width="25" height="28" /></td>
											<td width="8"></td>
											<td class="cate"><a href="<?=$path_home?>/odmanager/odorders/od_orderslist2.php?search_value_=true&delivstatus=no" onfocus='this.blur();'  id='help00'>발급대기목록</a></td>
										</tr>
								</table></td>
							</tr>
						</table>
<!--발급완료 추가 -->
                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
							<tr>
								<td width="27" height="28"></td>
								<td valign="top"  width="180"  background="/images/manager_img_19.jpg"><table width="100%" border="0" cellspacing="0" cellpadding="0">
										<tr>
											<td width="25" height="28"><img src="/images/manager_img_21.jpg" width="25" height="28" /></td>
											<td width="8"></td>
											<td class="cate"><a href="<?=$path_home?>/odmanager/odorders/od_orderslist2.php?search_value_=true&delivstatus=yes" onfocus='this.blur();'  id='help06'>발급완료목록</a></td>
										</tr>
								</table></td>
							</tr>
						</table>

					</td>
				</tr>
			</table>

			<!-- 스킨/디자인 관리  -->
			<?
			$idxTmp = 18;
			?>
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="27" height="28"></td>
          <td valign="top"  width="180"  background="/images/manager_img_19.jpg"><table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td width="25" height="28"><?=$blinkTemp[$idxTmp]?><img src="/images/manager_img_20.jpg" width="25" height="28" /><?=$blinkTemp_[$idxTmp]?></td>
              <td width="8"></td>
              <td><span class="style3"  onclick="self.location.replace('<?=$folderpath_manager?>/odcommon/od_menu_check.php?sub_menu2=<?=$idxTmp?>');" style='cursor:hand;'>스킨/디자인 관리</span></td>
            </tr>
          </table></td>
        </tr>
				<tr <?=$blinkTemp_style[$idxTmp];?>> 
					<td align="center" colspan=2>

						 <table width="100%" border="0" cellspacing="0" cellpadding="0">
							<tr>
								<td width="27" height="28"></td>
								<td valign="top"  width="180"  background="/images/manager_img_19.jpg"><table width="100%" border="0" cellspacing="0" cellpadding="0">
										<tr>
											<td width="25" height="28"><img src="/images/manager_img_21.jpg" width="25" height="28" /></td>
											<td width="8"></td>
											<td class="cate"><a href="<?=$path_home?>/odmanager/odmall/od_skin_form.php" onfocus='this.blur();'>스킨 설정</a></td>
										</tr>
								</table></td>
							</tr>
						</table>
						 <table width="100%" border="0" cellspacing="0" cellpadding="0">
							<tr>
								<td width="27" height="28"></td>
								<td valign="top"  width="180"  background="/images/manager_img_19.jpg"><table width="100%" border="0" cellspacing="0" cellpadding="0">
										<tr>
											<td width="25" height="28"><img src="/images/manager_img_21.jpg" width="25" height="28" /></td>
											<td width="8"></td>
											<td class="cate"><a href="<?=$path_home?>/odmanager/odmall/od_img_form.php" onfocus='this.blur();'>메인이미지설정</a></td>
										</tr>
								</table></td>
							</tr>
						</table>
						 <table width="100%" border="0" cellspacing="0" cellpadding="0">
							<tr>
								<td width="27" height="28"></td>
								<td valign="top"  width="180"  background="/images/manager_img_19.jpg"><table width="100%" border="0" cellspacing="0" cellpadding="0">
										<tr>
											<td width="25" height="28"><img src="/images/manager_img_21.jpg" width="25" height="28" /></td>
											<td width="8"></td>
											<td class="cate"><a href="<?=$path_home?>/odmanager/odmall/od_img_form2.php" onfocus='this.blur();'>개별이미지설정</a></td>
										</tr>
								</table></td>
							</tr>
						</table>

					</td>
				</tr>
			</table>


			<!-- 상점기본 관리  -->
			<?
			$idxTmp = 1;
			?>
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="27" height="28"></td>
          <td valign="top"  width="180"  background="/images/manager_img_19.jpg"><table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td width="25" height="28"><?=$blinkTemp[$idxTmp]?><img src="/images/manager_img_20.jpg" width="25" height="28" /><?=$blinkTemp_[$idxTmp]?></td>
              <td width="8"></td>
              <td><span class="style3"  onclick="self.location.replace('<?=$folderpath_manager?>/odcommon/od_menu_check.php?sub_menu2=<?=$idxTmp?>');" style='cursor:hand;'>상점기본관리</span></td>
            </tr>
          </table></td>
        </tr>
				
				<tr <?=$blinkTemp_style[$idxTmp];?>> 
					<td align="center" colspan=2>
						 <table width="100%" border="0" cellspacing="0" cellpadding="0">
							<tr>
								<td width="27" height="28"></td>
								<td valign="top"  width="180"  background="/images/manager_img_19.jpg"><table width="100%" border="0" cellspacing="0" cellpadding="0">
										<tr>
											<td width="25" height="28"><img src="/images/manager_img_21.jpg" width="25" height="28" /></td>
											<td width="8"></td>
											<td class="cate"><a href="<?=$path_home?>/odmanager/odmall/od_basic.php" onfocus='this.blur();'>상점기본설정</a></td>
										</tr>
								</table></td>
							</tr>
						</table>
						 <table width="100%" border="0" cellspacing="0" cellpadding="0">
							<tr>
								<td width="27" height="28"></td>
								<td valign="top"  width="180"  background="/images/manager_img_19.jpg"><table width="100%" border="0" cellspacing="0" cellpadding="0">
										<tr>
											<td width="25" height="28"><img src="/images/manager_img_21.jpg" width="25" height="28" /></td>
											<td width="8"></td>
											<td class="cate"><a href="<?=$path_home?>/odmanager/odmall/od_admin.php" onfocus='this.blur();'>쇼핑몰관리자설정</a></td>
										</tr>
								</table></td>
							</tr>
						</table>
						 <table width="100%" border="0" cellspacing="0" cellpadding="0">
							<tr>
								<td width="27" height="28"></td>
								<td valign="top"  width="180"  background="/images/manager_img_19.jpg"><table width="100%" border="0" cellspacing="0" cellpadding="0">
										<tr>
											<td width="25" height="28"><img src="/images/manager_img_21.jpg" width="25" height="28" /></td>
											<td width="8"></td>
											<td class="cate"><a href="<?=$path_home?>/odmanager/odmall/od_company.php" onfocus='this.blur();'>회사기본정보설정</a></td>
										</tr>
								</table></td>
							</tr>
						</table>

					</td>
				</tr>
			</table>


			<!-- 부가서비스 관리  -->
			<?
			$idxTmp = 17;
			?>
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="27" height="28"></td>
          <td valign="top"  width="180"  background="/images/manager_img_19.jpg"><table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td width="25" height="28"><?=$blinkTemp[$idxTmp]?><img src="/images/manager_img_20.jpg" width="25" height="28" /><?=$blinkTemp_[$idxTmp]?></td>
              <td width="8"></td>
              <td><span class="style3"  onclick="self.location.replace('<?=$folderpath_manager?>/odcommon/od_menu_check.php?sub_menu2=<?=$idxTmp?>');" style='cursor:hand;'>부가서비스</span></td>
            </tr>
          </table></td>
        </tr>
				<tr <?=$blinkTemp_style[$idxTmp];?>> 
					<td align="center" colspan=2>
						 <table width="100%" border="0" cellspacing="0" cellpadding="0">
							<tr>
								<td width="27" height="28"></td>
								<td valign="top"  width="180"  background="/images/manager_img_19.jpg"><table width="100%" border="0" cellspacing="0" cellpadding="0">
										<tr>
											<td width="25" height="28"><img src="/images/manager_img_21.jpg" width="25" height="28" /></td>
											<td width="8"></td>
											<td class="cate"><a href="<?=$path_home?>/odmanager/odmall/od_pg_basic.php" onfocus='this.blur();'>PG사 설정</a></td>
										</tr>
								</table>
								</td>
							</tr>
						</table>

						 <table width="100%" border="0" cellspacing="0" cellpadding="0">
							<tr>
								<td width="27" height="28"></td>
								<td valign="top"  width="180"  background="/images/manager_img_19.jpg"><table width="100%" border="0" cellspacing="0" cellpadding="0">
										<tr>
											<td width="25" height="28"><img src="/images/manager_img_21.jpg" width="25" height="28" /></td>
											<td width="8"></td>
											<td class="cate"><a href="<?=$path_home?>/odmanager/odmall/od_nameauthen.php" onfocus='this.blur();'>실명인증(i-PIN)</a></td>
										</tr>
								</table>
								</td>
							</tr>
						</table>						
						 <table width="100%" border="0" cellspacing="0" cellpadding="0">
							<tr>
								<td width="27" height="28"></td>
								<td valign="top"  width="180"  background="/images/manager_img_19.jpg"><table width="100%" border="0" cellspacing="0" cellpadding="0">
										<tr>
											<td width="25" height="28"><img src="/images/manager_img_21.jpg" width="25" height="28" /></td>
											<td width="8"></td>
											<td class="cate"><a href="<?=$path_home?>/odmanager/odmall/od_click.php" onfocus='this.blur();'>제휴마케팅설정</a></td>
										</tr>
								</table></td>
							</tr>
						</table>

					</td>
				</tr>
			</table>


			<!-- 일반 관리  -->
			<?
			$idxTmp = 27;
			?>
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="27" height="28"></td>
          <td valign="top"  width="180"  background="/images/manager_img_19.jpg"><table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td width="25" height="28"><?=$blinkTemp[$idxTmp]?><img src="/images/manager_img_20.jpg" width="25" height="28" /><?=$blinkTemp_[$idxTmp]?></td>
              <td width="8"></td>
              <td><span class="style3"  onclick="self.location.replace('<?=$folderpath_manager?>/odcommon/od_menu_check.php?sub_menu2=<?=$idxTmp?>');" style='cursor:hand;'>일반관리</span></td>
            </tr>
          </table></td>
        </tr>
				<tr <?=$blinkTemp_style[$idxTmp];?>> 
					<td align="center" colspan=2>

			
						<table width="100%" border="0" cellspacing="0" cellpadding="0">
							<tr>
								<td width="27" height="28"></td>
								<td valign="top"  width="180"  background="/images/manager_img_19.jpg"><table width="100%" border="0" cellspacing="0" cellpadding="0">
										<tr>
											<td width="25" height="28"><img src="/images/manager_img_21.jpg" width="25" height="28" /></td>
											<td width="8"></td>
											<td class="cate"><a href="<?=$path_home?>/odmanager/odmall/od_point.php" onfocus='this.blur();'>적립금정보설정</a></td>
										</tr>
								</table></td>
							</tr>
						</table>

						 <table width="100%" border="0" cellspacing="0" cellpadding="0">
							<tr>
								<td width="27" height="28"></td>
								<td valign="top"  width="180"  background="/images/manager_img_19.jpg"><table width="100%" border="0" cellspacing="0" cellpadding="0">
										<tr>
											<td width="25" height="28"><img src="/images/manager_img_21.jpg" width="25" height="28" /></td>
											<td width="8"></td>
											<td class="cate"><a href="<?=$path_home?>/odmanager/odetc/od_popupList.php" onfocus='this.blur();'>팝업관리</a></td>
										</tr>
								</table></td>
							</tr>
						</table>

						 <table width="100%" border="0" cellspacing="0" cellpadding="0">
							<tr>
								<td width="27" height="28"></td>
								<td valign="top"  width="180"  background="/images/manager_img_19.jpg"><table width="100%" border="0" cellspacing="0" cellpadding="0">
										<tr>
											<td width="25" height="28"><img src="/images/manager_img_21.jpg" width="25" height="28" /></td>
											<td width="8"></td>
											<td class="cate"><a href="<?=$path_home?>/odmanager/odboard/od_boardkindlist.php" onfocus='this.blur();'>게시판관리</a></td>
										</tr>
								</table></td>
							</tr>
						</table>

						 <table width="100%" border="0" cellspacing="0" cellpadding="0">
							<tr>
								<td width="27" height="28"></td>
								<td valign="top"  width="180"  background="/images/manager_img_19.jpg"><table width="100%" border="0" cellspacing="0" cellpadding="0">
										<tr>
											<td width="25" height="28"><img src="/images/manager_img_21.jpg" width="25" height="28" /></td>
											<td width="8"></td>
											<td class="cate"><a href="<?=$path_home?>/odmanager/odcs/od_faq_list.php" onfocus='this.blur();'>FAQ 설정</a></td>
										</tr>
								</table></td>
							</tr>
						</table>
																 
					</td>
				</tr>
			</table>

			<!-- SMS/메일링 관리  -->
			<?
			$idxTmp = 12;
			?>
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="27" height="28"></td>
          <td valign="top"  width="180"  background="/images/manager_img_19.jpg"><table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td width="25" height="28"><?=$blinkTemp[$idxTmp]?><img src="/images/manager_img_20.jpg" width="25" height="28" /><?=$blinkTemp_[$idxTmp]?></td>
              <td width="8"></td>
              <td><span class="style3"  onclick="self.location.replace('<?=$folderpath_manager?>/odcommon/od_menu_check.php?sub_menu2=<?=$idxTmp?>');" style='cursor:hand;'>SMS/메일링 관리</span></td>
            </tr>
          </table></td>
        </tr>
				<tr <?=$blinkTemp_style[$idxTmp];?>> 
					<td align="center" colspan=2>
<!-- 
						 <table width="100%" border="0" cellspacing="0" cellpadding="0">
							<tr>
								<td width="27" height="28"></td>
								<td valign="top"  width="180"  background="/images/manager_img_19.jpg"><table width="100%" border="0" cellspacing="0" cellpadding="0">
										<tr>
											<td width="25" height="28"><img src="/images/manager_img_21.jpg" width="25" height="28" /></td>
											<td width="8"></td>
											<td class="cate"><a href="<?=$path_home?>/odmanager/odsms/sms.php" onfocus='this.blur();'>SMS 환경설정</a></td>
										</tr>
								</table></td>
							</tr>
						</table>
 -->
						 <table width="100%" border="0" cellspacing="0" cellpadding="0">
							<tr>
								<td width="27" height="28"></td>
								<td valign="top"  width="180"  background="/images/manager_img_19.jpg"><table width="100%" border="0" cellspacing="0" cellpadding="0">
										<tr>
											<td width="25" height="28"><img src="/images/manager_img_21.jpg" width="25" height="28" /></td>
											<td width="8"></td>
											<td class="cate"><a href="<?=$path_home?>/odmanager/odsms/od_smsset.php" onfocus='this.blur();'>SMS발송문구 설정</a></td>
										</tr>
								</table></td>
							</tr>
						</table>


						 <table width="100%" border="0" cellspacing="0" cellpadding="0">
							<tr>
								<td width="27" height="28"></td>
								<td valign="top"  width="180"  background="/images/manager_img_19.jpg"><table width="100%" border="0" cellspacing="0" cellpadding="0">
										<tr>
											<td width="25" height="28"><img src="/images/manager_img_21.jpg" width="25" height="28" /></td>
											<td width="8"></td>
											<td class="cate"><a href="<?=$path_home?>/odmanager/odmembers/od_mail.php" onfocus='this.blur();'>메일링</a></td>
										</tr>
								</table></td>
							</tr>
						</table>

						 <table width="100%" border="0" cellspacing="0" cellpadding="0">
							<tr>
								<td width="27" height="28"></td>
								<td valign="top"  width="180"  background="/images/manager_img_19.jpg"><table width="100%" border="0" cellspacing="0" cellpadding="0">
										<tr>
											<td width="25" height="28"><img src="/images/manager_img_21.jpg" width="25" height="28" /></td>
											<td width="8"></td>
											<td class="cate"><a href="<?=$path_home?>/odmanager/odetc/od_mailList.php" onfocus='this.blur();'>메일발송확인</a></td>
										</tr>
								</table></td>
							</tr>
						</table>

						 <table width="100%" border="0" cellspacing="0" cellpadding="0">
							<tr>
								<td width="27" height="28"></td>
								<td valign="top"  width="180"  background="/images/manager_img_19.jpg"><table width="100%" border="0" cellspacing="0" cellpadding="0">
										<tr>
											<td width="25" height="28"><img src="/images/manager_img_21.jpg" width="25" height="28" /></td>
											<td width="8"></td>
											<td class="cate"><a href="<?=$path_home?>/odmanager/odsms/od_smseach.php" onfocus='this.blur();'>SMS 개별발송</a></td>
										</tr>
								</table></td>
							</tr>
						</table>
						 <table width="100%" border="0" cellspacing="0" cellpadding="0">
							<tr>
								<td width="27" height="28"></td>
								<td valign="top"  width="180"  background="/images/manager_img_19.jpg"><table width="100%" border="0" cellspacing="0" cellpadding="0">
										<tr>
											<td width="25" height="28"><img src="/images/manager_img_21.jpg" width="25" height="28" /></td>
											<td width="8"></td>
											<td class="cate"><a href="<?=$path_home?>/odmanager/odsms/od_smsgroup.php" onfocus='this.blur();'>SMS 그룹발송</a></td>
										</tr>
								</table></td>
							</tr>
						</table>

					</td>
				</tr>
			</table>

			<!-- 판매통계  -->
			<?
			$idxTmp = 7;
			?>
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="27" height="28"></td>
          <td valign="top"  width="180"  background="/images/manager_img_19.jpg"><table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td width="25" height="28"><?=$blinkTemp[$idxTmp]?><img src="/images/manager_img_20.jpg" width="25" height="28" /><?=$blinkTemp_[$idxTmp]?></td>
              <td width="8"></td>
              <td><span class="style3"  onclick="self.location.replace('<?=$folderpath_manager?>/odcommon/od_menu_check.php?sub_menu2=<?=$idxTmp?>');" style='cursor:hand;'>판매통계</span></td>
            </tr>
          </table></td>
        </tr>
				<tr <?=$blinkTemp_style[$idxTmp];?>> 
					<td align="center" colspan=2>
						 <table width="100%" border="0" cellspacing="0" cellpadding="0">
							<tr>
								<td width="27" height="28"></td>
								<td valign="top"  width="180"  background="/images/manager_img_19.jpg"><table width="100%" border="0" cellspacing="0" cellpadding="0">
										<tr>
											<td width="25" height="28"><img src="/images/manager_img_21.jpg" width="25" height="28" /></td>
											<td width="8"></td>
											<td class="cate"><a href="<?=$path_home?>/odmanager/odstatistics/od_year.php" onfocus='this.blur();'>년별 판매통계</a></td>
										</tr>
								</table></td>
							</tr>
						</table>
						 <table width="100%" border="0" cellspacing="0" cellpadding="0">
							<tr>
								<td width="27" height="28"></td>
								<td valign="top"  width="180"  background="/images/manager_img_19.jpg"><table width="100%" border="0" cellspacing="0" cellpadding="0">
										<tr>
											<td width="25" height="28"><img src="/images/manager_img_21.jpg" width="25" height="28" /></td>
											<td width="8"></td>
											<td class="cate"><a href="<?=$path_home?>/odmanager/odstatistics/od_month.php" onfocus='this.blur();'>월별 판매통계</a></td>
										</tr>
								</table></td>
							</tr>
						</table>
						 <table width="100%" border="0" cellspacing="0" cellpadding="0">
							<tr>
								<td width="27" height="28"></td>
								<td valign="top"  width="180"  background="/images/manager_img_19.jpg"><table width="100%" border="0" cellspacing="0" cellpadding="0">
										<tr>
											<td width="25" height="28"><img src="/images/manager_img_21.jpg" width="25" height="28" /></td>
											<td width="8"></td>
											<td class="cate"><a href="<?=$path_home?>/odmanager/odstatistics/od_day.php" onfocus='this.blur();'>일별 판매통계</a></td>
										</tr>
								</table></td>
							</tr>
						</table>
						 <table width="100%" border="0" cellspacing="0" cellpadding="0">
							<tr>
								<td width="27" height="28"></td>
								<td valign="top"  width="180"  background="/images/manager_img_19.jpg"><table width="100%" border="0" cellspacing="0" cellpadding="0">
										<tr>
											<td width="25" height="28"><img src="/images/manager_img_21.jpg" width="25" height="28" /></td>
											<td width="8"></td>
											<td class="cate"><a href="<?=$path_home?>/odmanager/odstatistics/od_cal.php" onfocus='this.blur();'>달력형 판매통계</a></td>
										</tr>
								</table></td>
							</tr>
						</table>

					</td>
				</tr>
			</table>


			<!-- 실명인증관리 
			<?
			$idxTmp = 13;
			?>
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="27" height="28"></td>
          <td valign="top"  width="180"  background="/images/manager_img_19.jpg"><table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td width="25" height="28"><?=$blinkTemp[$idxTmp]?><img src="/images/manager_img_20.jpg" width="25" height="28" /><?=$blinkTemp_[$idxTmp]?></td>
              <td width="8"></td>
              <td><span class="style3"  onclick="self.location.replace('<?=$folderpath_manager?>/odcommon/od_menu_check.php?sub_menu2=<?=$idxTmp?>');" style='cursor:hand;'>실명인증관리</span></td>
            </tr>
          </table></td>
        </tr>
			</table> -->


			<!-- 방문로그분석  -->
			<?
			$idxTmp = 14;
			?>
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="27" height="28"></td>
          <td valign="top"  width="180"  background="/images/manager_img_19.jpg"><table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td width="25" height="28"><?=$blinkTemp[$idxTmp]?><img src="/images/manager_img_20.jpg" width="25" height="28" /><?=$blinkTemp_[$idxTmp]?></td>
              <td width="8"></td>
              <td><span class="style3"  onclick="self.location.replace('<?=$folderpath_manager?>/odcommon/od_menu_check.php?sub_menu2=<?=$idxTmp?>');" style='cursor:hand;'>방문로그분석</span></td>
            </tr>
          </table></td>
        </tr>
				<tr <?=$blinkTemp_style[$idxTmp];?>> 
					<td align="center" colspan=2>
						 <table width="100%" border="0" cellspacing="0" cellpadding="0">
							<tr>
								<td width="27" height="28"></td>
								<td valign="top"  width="180"  background="/images/manager_img_19.jpg"><table width="100%" border="0" cellspacing="0" cellpadding="0">
										<tr>
											<td width="25" height="28"><img src="/images/manager_img_21.jpg" width="25" height="28" /></td>
											<td width="8"></td>
											<td class="cate"><a href="<?=$path_home?>/odmanager/odcounter/od_config.php" onfocus='this.blur();'>카운터환경설정</a></td>
										</tr>
								</table></td>
							</tr>
						</table>
						 <table width="100%" border="0" cellspacing="0" cellpadding="0">
							<tr>
								<td width="27" height="28"></td>
								<td valign="top"  width="180"  background="/images/manager_img_19.jpg"><table width="100%" border="0" cellspacing="0" cellpadding="0">
										<tr>
											<td width="25" height="28"><img src="/images/manager_img_21.jpg" width="25" height="28" /></td>
											<td width="8"></td>
											<td class="cate"><a href="<?=$path_home?>/odmanager/odcounter/od_year.php" onfocus='this.blur();'>년별접속통계</a></td>
										</tr>
								</table></td>
							</tr>
						</table>
						 <table width="100%" border="0" cellspacing="0" cellpadding="0">
							<tr>
								<td width="27" height="28"></td>
								<td valign="top"  width="180"  background="/images/manager_img_19.jpg"><table width="100%" border="0" cellspacing="0" cellpadding="0">
										<tr>
											<td width="25" height="28"><img src="/images/manager_img_21.jpg" width="25" height="28" /></td>
											<td width="8"></td>
											<td class="cate"><a href="<?=$path_home?>/odmanager/odcounter/od_month.php" onfocus='this.blur();'>월별접속통계</a></td>
										</tr>
								</table></td>
							</tr>
						</table>
						 <table width="100%" border="0" cellspacing="0" cellpadding="0">
							<tr>
								<td width="27" height="28"></td>
								<td valign="top"  width="180"  background="/images/manager_img_19.jpg"><table width="100%" border="0" cellspacing="0" cellpadding="0">
										<tr>
											<td width="25" height="28"><img src="/images/manager_img_21.jpg" width="25" height="28" /></td>
											<td width="8"></td>
											<td class="cate"><a href="<?=$path_home?>/odmanager/odcounter/od_day.php" onfocus='this.blur();'>일별접속통계</a></td>
										</tr>
								</table></td>
							</tr>
						</table>
						 <table width="100%" border="0" cellspacing="0" cellpadding="0">
							<tr>
								<td width="27" height="28"></td>
								<td valign="top"  width="180"  background="/images/manager_img_19.jpg"><table width="100%" border="0" cellspacing="0" cellpadding="0">
										<tr>
											<td width="25" height="28"><img src="/images/manager_img_21.jpg" width="25" height="28" /></td>
											<td width="8"></td>
											<td class="cate"><a href="<?=$path_home?>/odmanager/odcounter/od_hour.php" onfocus='this.blur();'>시별접속통계</a></td>
										</tr>
								</table></td>
							</tr>
						</table>
						 <table width="100%" border="0" cellspacing="0" cellpadding="0">
							<tr>
								<td width="27" height="28"></td>
								<td valign="top"  width="180"  background="/images/manager_img_19.jpg"><table width="100%" border="0" cellspacing="0" cellpadding="0">
										<tr>
											<td width="25" height="28"><img src="/images/manager_img_21.jpg" width="25" height="28" /></td>
											<td width="8"></td>
											<td class="cate"><a href="<?=$path_home?>/odmanager/odcounter/od_route.php" onfocus='this.blur();'>접속경로별통계</a></td>
										</tr>
								</table></td>
							</tr>
						</table>
						 <table width="100%" border="0" cellspacing="0" cellpadding="0">
							<tr>
								<td width="27" height="28"></td>
								<td valign="top"  width="180"  background="/images/manager_img_19.jpg"><table width="100%" border="0" cellspacing="0" cellpadding="0">
										<tr>
											<td width="25" height="28"><img src="/images/manager_img_21.jpg" width="25" height="28" /></td>
											<td width="8"></td>
											<td class="cate"><a href="<?=$path_home?>/odmanager/odcounter/od_os.php" onfocus='this.blur();'>운영체제별통계</a></td>
										</tr>
								</table></td>
							</tr>
						</table>
						 <table width="100%" border="0" cellspacing="0" cellpadding="0">
							<tr>
								<td width="27" height="28"></td>
								<td valign="top"  width="180"  background="/images/manager_img_19.jpg"><table width="100%" border="0" cellspacing="0" cellpadding="0">
										<tr>
											<td width="25" height="28"><img src="/images/manager_img_21.jpg" width="25" height="28" /></td>
											<td width="8"></td>
											<td class="cate"><a href="<?=$path_home?>/odmanager/odcounter/od_browser.php" onfocus='this.blur();'>브라우져별통계</a></td>
										</tr>
								</table></td>
							</tr>
						</table>
						 <table width="100%" border="0" cellspacing="0" cellpadding="0">
							<tr>
								<td width="27" height="28"></td>
								<td valign="top"  width="180"  background="/images/manager_img_19.jpg"><table width="100%" border="0" cellspacing="0" cellpadding="0">
										<tr>
											<td width="25" height="28"><img src="/images/manager_img_21.jpg" width="25" height="28" /></td>
											<td width="8"></td>
											<td class="cate"><a href="<?=$path_home?>/odmanager/odcounter/od_log.php" onfocus='this.blur();'>상세로그</a></td>
										</tr>
								</table></td>
							</tr>
						</table>
						 <table width="100%" border="0" cellspacing="0" cellpadding="0">
							<tr>
								<td width="27" height="28"></td>
								<td valign="top"  width="180"  background="/images/manager_img_19.jpg"><table width="100%" border="0" cellspacing="0" cellpadding="0">
										<tr>
											<td width="25" height="28"><img src="/images/manager_img_21.jpg" width="25" height="28" /></td>
											<td width="8"></td>
											<td class="cate"><a href="<?=$path_home?>/odmanager/odcounter/od_fav.php" onfocus='this.blur();'>즐겨찾기/시작페이지</a></td>
										</tr>
								</table></td>
							</tr>
						</table>

					</td>
				</tr>
			</table>



			<!-- 공급업체 관리  
			<?
			$idxTmp = 15;
			?>
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="27" height="28"></td>
          <td valign="top"  width="180"  background="/images/manager_img_19.jpg"><table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td width="25" height="28"><?=$blinkTemp[$idxTmp]?><img src="/images/manager_img_20.jpg" width="25" height="28" /><?=$blinkTemp_[$idxTmp]?></td>
              <td width="8"></td>
              <td><span class="style3"  onclick="self.location.replace('<?=$folderpath_manager?>/odcommon/od_menu_check.php?sub_menu2=<?=$idxTmp?>');" style='cursor:hand;'>공급업체관리</span></td>
            </tr>
          </table></td>
        </tr>
				<tr <?=$blinkTemp_style[$idxTmp];?>> 
					<td align="center" colspan=2>

					</td>
				</tr>
			</table> -->



			<!-- 계정등록  
			<?
			$idxTmp = 20;
			?>
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="27" height="28"></td>
          <td valign="top"  width="180"  background="/images/manager_img_19.jpg"><table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td width="25" height="28"><?=$blinkTemp[$idxTmp]?><img src="/images/manager_img_20.jpg" width="25" height="28" /><?=$blinkTemp_[$idxTmp]?></td>
              <td width="8"></td>
              <td><span class="style3"  onclick="self.location.replace('<?=$folderpath_manager?>/odcommon/od_menu_check.php?sub_menu2=<?=$idxTmp?>');" style='cursor:hand;'>계정등록</span></td>
            </tr>
          </table></td>
        </tr>
				<tr <?=$blinkTemp_style[$idxTmp];?>> 
					<td align="center" colspan=2>

					</td>
				</tr>
			</table> -->



			<!-- 정산관련  -->
			<?
			$idxTmp = 23;
			?>
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="27" height="28"></td>
          <td valign="top"  width="180"  background="/images/manager_img_19.jpg"><table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td width="25" height="28"><?=$blinkTemp[$idxTmp]?><img src="/images/manager_img_20.jpg" width="25" height="28" /><?=$blinkTemp_[$idxTmp]?></td>
              <td width="8"></td>
              <td><span class="style3"  onclick="self.location.replace('<?=$folderpath_manager?>/odcommon/od_menu_check.php?sub_menu2=<?=$idxTmp?>');" style='cursor:hand;'>정산관리</span></td>
            </tr>
          </table></td>
        </tr>
				<tr <?=$blinkTemp_style[$idxTmp];?>> 
					<td align="center" colspan=2>

						 <table width="100%" border="0" cellspacing="0" cellpadding="0">
							<tr>
								<td width="27" height="28"></td>
								<td valign="top"  width="180"  background="/images/manager_img_19.jpg"><table width="100%" border="0" cellspacing="0" cellpadding="0">
										<tr>
											<td width="25" height="28"><img src="/images/manager_img_21.jpg" width="25" height="28" /></td>
											<td width="8"></td>
											<td class="cate"><a href="<?=$path_home?>/odmanager/odtitle/od_accountTitleList.php" onfocus='this.blur();'>입출금관리</a></td>
										</tr>
								</table></td>
							</tr>
						</table>
						 <table width="100%" border="0" cellspacing="0" cellpadding="0">
							<tr>
								<td width="27" height="28"></td>
								<td valign="top"  width="180"  background="/images/manager_img_19.jpg"><table width="100%" border="0" cellspacing="0" cellpadding="0">
										<tr>
											<td width="25" height="28"><img src="/images/manager_img_21.jpg" width="25" height="28" /></td>
											<td width="8"></td>
											<td class="cate"><a href="<?=$path_home?>/odmanager/odtitle/od_cardList.php" onfocus='this.blur();'>카드/통장관리</a></td>
										</tr>
								</table></td>
							</tr>
						</table>

						 <table width="100%" border="0" cellspacing="0" cellpadding="0">
							<tr>
								<td width="27" height="28"></td>
								<td valign="top"  width="180"  background="/images/manager_img_19.jpg"><table width="100%" border="0" cellspacing="0" cellpadding="0">
										<tr>
											<td width="25" height="28"><img src="/images/manager_img_21.jpg" width="25" height="28" /></td>
											<td width="8"></td>
											<td class="cate"><a href="<?=$path_home?>/odmanager/odaccount/od_accountInsert.php" onfocus='this.blur();'>입출금입력</a></td>
										</tr>
								</table></td>
							</tr>
						</table>
						 <table width="100%" border="0" cellspacing="0" cellpadding="0">
							<tr>
								<td width="27" height="28"></td>
								<td valign="top"  width="180"  background="/images/manager_img_19.jpg"><table width="100%" border="0" cellspacing="0" cellpadding="0">
										<tr>
											<td width="25" height="28"><img src="/images/manager_img_21.jpg" width="25" height="28" /></td>
											<td width="8"></td>
											<td class="cate"><a href="<?=$path_home?>/odmanager/odaccount/od_saleDetailView.php" onfocus='this.blur();'>매출현황</a></td>
										</tr>
								</table></td>
							</tr>
						</table>
						 <table width="100%" border="0" cellspacing="0" cellpadding="0">
							<tr>
								<td width="27" height="28"></td>
								<td valign="top"  width="180"  background="/images/manager_img_19.jpg"><table width="100%" border="0" cellspacing="0" cellpadding="0">
										<tr>
											<td width="25" height="28"><img src="/images/manager_img_21.jpg" width="25" height="28" /></td>
											<td width="8"></td>
											<td class="cate"><a href="<?=$path_home?>/odmanager/odaccount/od_accountView.php" onfocus='this.blur();'>입출현황</a></td>
										</tr>
								</table></td>
							</tr>
						</table>

					</td>
				</tr>
			</table>


			<!-- 고객문의  
			<?
			$idxTmp = 21;
			?>
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="27" height="28"></td>
          <td valign="top"  width="180"  background="/images/manager_img_19.jpg"><table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td width="25" height="28"><?=$blinkTemp[$idxTmp]?><img src="/images/manager_img_20.jpg" width="25" height="28" /><?=$blinkTemp_[$idxTmp]?></td>
              <td width="8"></td>
              <td><span class="style3"  onclick="self.location.replace('<?=$folderpath_manager?>/odcommon/od_menu_check.php?sub_menu2=<?=$idxTmp?>');" style='cursor:hand;'>고객문의</span></td>
            </tr>
          </table></td>
        </tr>
				<tr <?=$blinkTemp_style[$idxTmp];?>> 
					<td align="center" colspan=2>


						 <table width="100%" border="0" cellspacing="0" cellpadding="0">
							<tr>
								<td width="27" height="28"></td>
								<td valign="top"  width="180"  background="/images/manager_img_19.jpg"><table width="100%" border="0" cellspacing="0" cellpadding="0">
										<tr>
											<td width="25" height="28"><img src="/images/manager_img_21.jpg" width="25" height="28" /></td>
											<td width="8"></td>
											<td class="cate"><a href="<?=$path_home?>/odmanager/odcs/od_csList.php" onfocus='this.blur();'>입점/제휴문의</a></td>
										</tr>
								</table></td>
							</tr>
						</table>
 
					</td>
				</tr>
			</table> -->


<?
// 입점업체 전용 메뉴
} else if($com[id]) {
?>
			<!-- 입점업체 주문현황 관리  -->
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
              <td><span class="style3"  onclick="self.location.replace('<?=$folderpath_manager?>/odcommon/od_menu_check.php?sub_menu2=<?=$idxTmp?>');" style='cursor:hand;'>주문관리</span></td>
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
	
<?
}
?>
