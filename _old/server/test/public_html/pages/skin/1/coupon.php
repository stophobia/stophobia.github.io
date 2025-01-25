<iframe name="hiddenFrame" src="about:blank" width=100px height=100px style="display:none"></iframe>
<!--센터 내용-->
<table width="960" cellpadding="0" cellspacing="0" border="0">
		<tr>
				<td width="698" valign="top">

						<table width="100%" border="0" cellspacing="0" cellpadding="0">
								<tr>
										<!--타이틀 이미지-->
										<td height="72"><img src="<?=$row_product[mainNameImg]?>" ></td>
										<!--//타이틀 이미지-->
								</tr>
								<tr>
										<td height="1" bgcolor="#cdcbc7"> </td>
								</tr>
								<tr>
										<td align="center" class="img_box" style="padding-bottom:70px">
										<script>
										var numIdx = 1;
										function changeImg(idx,img) {

											btnNew = document.getElementById("num_"+idx);
											btnOld = document.getElementById("num_"+this.numIdx);

											btnOld.src = btnOld.src.replace("_on_","_off_");
											btnNew.src = btnNew.src.replace("_off_","_on_");
											
											document.getElementById("mainImage").src = img;

											this.numIdx = idx;

										}
										</script>
												<table width="685" border="0" cellspacing="0" cellpadding="0" class="smt6">
														<tr>
																<td>
																<!-- 이미지 넘버링 -->
																<div style="Z-INDEX: 1; LEFT: 0px; WIDTH: 0px; POSITION: relative; TOP: 0px; HEIGHT: 0px;display:"><div style="Z-INDEX: 1; LEFT: 543px; WIDTH: 135px; POSITION: absolute; TOP: 12px; HEIGHT: 0px">
																	<table border=0 cellpadding=0 cellspacing=0 align=right>
																		<tr>
<?
$iconArray = array("main_img","big2_img","big3_img","big4_img","big5_img");
for($z=0;$z<5;$z++) {
	if($row_product[$iconArray[$z]]) {
?>
																			<td width=20><a href="#none"><img id='num_<?=$z+1?>' src="/images/group/ico<?=$z+1?><?=!$z ? "_on_" : "_off_";?>.gif" border=0 onclick="changeImg(<?=$z+1?>,'<?=$row_product[$iconArray[$z]]?>')"></a></td>
																			<td width=5></td>
<?
	}
}
?>
																		</tr>
																	</table>
																</div></div>
<?

// 재고량 파악 ////////////////////////////////////////////////////////////////
$minStock = @mysql_result(mysql_query("select max(stock) from odtProduct where parent_code ='".$row_product[code]."'"),0);
$info_nowsale_code = info_nowsale($thiscate);// 금일 상품코드

// 상품의 종료일자확인(현재일자가 종료일자보다 클경우 플래쉬에서 0이 깜박이는 오류발생)
$today_date = date("Y-m-d");
$Query  = " select sale_enddate from odtProduct where code = parent_code and cateCode = '".$thiscate."' and sale_date <= '".$today_date."' and sale_enddate >= '".$today_date."' order by sale_date desc limit 1 ";
$Result = mysql_query($Query);
$Record = mysql_fetch_array($Result);
$sale_enddate = $Record[0];
$nextSaleTime = strtotime($sale_enddate) + $row_setup[changeTime]*3600;
$curr_time    = time();

if ($minStock > 0 && $row_product[code] == $info_nowsale_code && $nextSaleTime > $curr_time )
{
?>
																<!-- 카운터 플래쉬 -->
																<div style="Z-INDEX: 1; LEFT: 0px; WIDTH: 0px; POSITION: relative; TOP: 0px; HEIGHT: 0px;display:"><div style="Z-INDEX: 1; LEFT: 478px; WIDTH: 0px; POSITION: absolute; TOP: 300px; HEIGHT: 0px"><script type="text/javascript">
																	AC_FL_RunContent( 'codebase','http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=9,0,28,0','width','195','height','35','src','/flash/today_count2','quality','high','pluginspage','http://www.adobe.com/shockwave/download/download.cgi?P1_Prod_Version=ShockwaveFlash','movie','/flash/today_count2','wmode','transparent' ); //end AC code
																	</script><noscript><object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=9,0,28,0"  width="195" height="35">
																		<param name="movie" value="/flash/today_count2.swf" />
																		<param name="quality" value="high" />
																		<param name="wmode" value="transparent" />
																		<embed src="/flash/today_count2.swf" quality="high" pluginspage="http://www.adobe.com/shockwave/download/download.cgi?P1_Prod_Version=ShockwaveFlash" type="application/x-shockwave-flash" width="195" height="35" wmode="transparent"></embed>
																	</object></noscript></div></div>
																<!-- // 카운터 플래쉬 -->
<?
}
//} else {
/*
?>
<!-- 
																<div style="Z-INDEX: 1; LEFT: 0px; WIDTH: 0px; POSITION: relative; TOP: 0px; HEIGHT: 0px;display:"><div style="Z-INDEX: 1; LEFT: 530px; WIDTH: 0px; POSITION: absolute; TOP: 300px; HEIGHT: 0px"><script type="text/javascript">
																	AC_FL_RunContent( 'codebase','http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=9,0,28,0','width','143','height','35','src','/flash/today_count','quality','high','pluginspage','http://www.adobe.com/shockwave/download/download.cgi?P1_Prod_Version=ShockwaveFlash','movie','/flash/today_count','wmode','transparent' ); //end AC code
																	</script><noscript><object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=9,0,28,0"  width="143" height="35">
																		<param name="movie" value="/flash/today_count.swf" />
																		<param name="quality" value="high" />
																		<param name="wmode" value="transparent" />
																		<embed src="/flash/today_count.swf" quality="high" pluginspage="http://www.adobe.com/shockwave/download/download.cgi?P1_Prod_Version=ShockwaveFlash" type="application/x-shockwave-flash" width="143" height="35" wmode="transparent"></embed>
																	</object></noscript></div></div>
 -->
<?
*/
//}
?>

																<!--상품 메인이미지-->
																<img id="mainImage" src="<?=$row_product[main_img]?>" width="685" height="343"></td>
																<!--//상품 메인이미지-->
														</tr>
														<tr>
																<td height="6"> </td>
														</tr>
														<tr>
																<!--상품상세 메뉴-->
																<td>

			<script>
			function tapView(imgName) {
				var imgArray	= ['detailBtn','cInfoBtn','talkBtn'];
				var trArray	= ['detailTr','cInfoTr','talkTr'];

				for(i=0;i<imgArray.length;i++) {
					obj = document.getElementById(imgArray[i]);
					obj2 = document.getElementById(trArray[i]);
					srcTmp = String(obj.src);
					bgTmp = String(obj.background);



					if(imgArray[i] == imgName) {
						obj.src					= srcTmp.replace("_off_","_on_");
						obj.background	= bgTmp.replace("_off_","_on_");
						obj2.style.display = "";
					} else {
						obj.src					= srcTmp.replace("_on_","_off_");
						obj.background	= bgTmp.replace("_on_","_off_");
						obj2.style.display = "none";
					}

				}

				//if(imgName == "detailBtn") document.getElementById('talkTr').style.display=""
			}
			</script>
																			<table width="100%" border="0" cellspacing="0" cellpadding="0">
																				<tr>
																						<td width="14"><img src="/images/group/tab_box1.gif" width="14" height="41"></td>
																						<td width="658" background="/images/group/tab_box2.gif">
																								<table border="0" cellspacing="0" cellpadding="0">
																										<tr>
																												<td><a href="#none" onclick="tapView('detailBtn')"><img id='detailBtn' src="/images/group/tab_menu1_on_.gif" ></td>
																												<td><img src="/images/group/tab_menu1_space.gif" width="40" height="16"></td>
																												<td><a href="#none" onclick="tapView('cInfoBtn')"><img id='cInfoBtn' src="/images/group/tab_menu2_off_.gif"  border="0"></a></td>
																												<td><img src="/images/group/tab_menu1_space.gif" width="40" height="16"></td>
																												<td><a href="#none" onclick="tapView('talkBtn');"><img id='talkBtn' src="/images/group/tab_menu3_off_.gif"  border="0"></a></td>
																										</tr>
																								</table>
																						</td>
																						<td><img src="/images/group/tab_box3.gif" width="12" height="41"></td>
																				</tr>
																		</table>
																</td>
																<!--//상품상세 메뉴-->
														</tr>
														<tr id='detailTr'>
															<td class="sptb30"><?=htmlspecialchars_decode($row_product[comment2])?></td>
														</tr>
														<!-- 토크 -->
														<tr id='talkTr' style='display:none'>
															<td align="center" id='detail_talk'>
																<?talktalk($row_product[code])?>
															</td>
														</tr>
														<!-- 업체정보 -->
														<tr id='cInfoTr' style='display:none'>
															<td><?=htmlspecialchars_decode($row_product[onecut_img])?></td>
														</tr>
												</table>
										</td>
								</tr>
						</table>
				</td>
				<td width="262" valign="top" class="img_box">

					<!-- 카운터 플래쉬 -->
					<div style="Z-INDEX: 1; LEFT: 0px; WIDTH: 0px; POSITION: relative; TOP: 0px; HEIGHT: 0px;display:"><div style="Z-INDEX: 1; LEFT: 215px; WIDTH: 0px; POSITION: absolute; TOP: 30px; HEIGHT: 0px"><script type="text/javascript">
					AC_FL_RunContent( 'codebase','http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=9,0,28,0','width','101','height','150','src','/flash/main_flash_06','quality','high','pluginspage','http://www.adobe.com/shockwave/download/download.cgi?P1_Prod_Version=ShockwaveFlash','movie','/flash/main_flash_06?inVar=<?=$row_product[price_per]?>','wmode','transparent' ); //end AC code
					</script><noscript><object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=9,0,28,0"  width="101" height="150">
					<param name="movie" value="/flash/main_flash_06.swf?inVar=<?=$row_product[price_per]?>" />
					<param name="quality" value="high" />
					<param name="wmode" value="transparent" />
					<embed src="/flash/main_flash_06.swf?inVar=<?=$row_product[price_per]?>" quality="high" pluginspage="http://www.adobe.com/shockwave/download/download.cgi?P1_Prod_Version=ShockwaveFlash" type="application/x-shockwave-flash" width="101" height="150" wmode="transparent"></embed>
					</object></noscript></div></div>
					<!-- // 카운터 플래쉬 -->

						<!--오늘 날짜 출력-->
						<table width="262" border="0" cellspacing="0" cellpadding="0">
								<tr>
										<td height="73" align="center" background="/images/group/day_print_bg.gif">
												<table border="0" cellspacing="0" cellpadding="0">
														<tr>
<?
// 전날상품
$prevCode = @mysql_result(mysql_query("select code from odtProduct where sale_date < '".$row_product[sale_date]."' and cateCode = '".$thiscate."' and code=parent_code order by sale_date desc limit 1"),0);
?>
																<td width="26"><a href="/?cateCode=<?=$thiscate?>&viewCode=<?=$prevCode?>"><img src="/images/group/day_print_arrow1.gif" width="26" height="34" border=0></a></td>


																<td align="center" class="splr15"><script type="text/javascript">
																	AC_FL_RunContent( 'codebase','http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=9,0,28,0','width','123','height','26','src','/flash/main_flash_01','quality','high','pluginspage','http://www.adobe.com/shockwave/download/download.cgi?P1_Prod_Version=ShockwaveFlash','movie','/flash/main_flash_01?inVar1=<?=date('m.d.',strtotime($row_product[sale_date])).$weekArray[date('w',strtotime($row_product[sale_date]))]?>','wmode','transparent' ); //end AC code
																	</script><noscript><object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=9,0,28,0"  width="123" height="26">
																		<param name="movie" value="/flash/main_flash_01.swf?inVar1=<?=date('m.d.',strtotime($row_product[sale_date])).$weekArray[date('w',strtotime($row_product[sale_date]))]?>" />
																		<param name="quality" value="high" />
																		<param name="wmode" value="transparent" />
																		<embed src="/flash/main_flash_01.swf?inVar1=<?=date('m.d.',strtotime($row_product[sale_date])).$weekArray[date('w',strtotime($row_product[sale_date]))]?>" quality="high" pluginspage="http://www.adobe.com/shockwave/download/download.cgi?P1_Prod_Version=ShockwaveFlash" type="application/x-shockwave-flash" width="123" height="26" wmode="transparent"></embed>
																	</object></noscript></td>
<?
//담날상품
$nextCode = @mysql_result(mysql_query("select code from odtProduct where sale_date > '".$row_product[sale_date]."' and sale_date <= '".date("Y-m-d")."' and cateCode = '".$thiscate."' and code=parent_code order by sale_date asc limit 1"),0);
if($nextCode) {
?>
																<td width="26"><a href="/?cateCode=<?=$thiscate?>&viewCode=<?=$nextCode?>"><img src="/images/group/day_print_arrow2.gif" width="26" height="34" border=0></a></td>
<?
}
?>
														</tr>
												</table>
										</td>
								</tr>
						</table>
						<!--//오늘 날짜 출력-->
						<!--구매하기-->
						<script>
						function submitFun(frm) {

							return true;

						}
						</script>
						<form name="submitFrm" action="/odprogram/odproducts/od_order.php" method="post" onsubmit="return submitFun(this)" style="display:inline">
						<input type="hidden" name="code" value="<?=$row_product[code]?>">
						<table width="100%" height="203" cellpadding="0" cellspacing="0" border="0">
								<tr>
										<td align="center" background="/images/group/price_bg.gif">
												<table width="212" border="0" cellspacing="0" cellpadding="0">
														<tr>
																<td><script type="text/javascript">
																	AC_FL_RunContent( 'codebase','http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=9,0,28,0','width','212','height','85','src','/flash/main_flash_02','quality','high','pluginspage','http://www.adobe.com/shockwave/download/download.cgi?P1_Prod_Version=ShockwaveFlash','movie','/flash/main_flash_02?inVar1=<?=number_format($row_product[price_org])?>&inVar2=<?=number_format($priceMin)?>','wmode','transparent' ); //end AC code
																	</script><noscript><object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=9,0,28,0"  width="212" height="85">
																		<param name="movie" value="/flash/main_flash_02.swf?inVar1=<?=number_format($row_product[price_org])?>&inVar2=<?=number_format($priceMin)?>" />
																		<param name="quality" value="high" />
																		<param name="wmode" value="transparent" />
																		<embed src="/flash/main_flash_02.swf?inVar1=<?=number_format($row_product[price_org])?>&inVar2=<?=number_format($priceMin)?>" quality="high" pluginspage="http://www.adobe.com/shockwave/download/download.cgi?P1_Prod_Version=ShockwaveFlash" type="application/x-shockwave-flash" width="212" height="85" wmode="transparent"></embed>
																	</object></noscript></td>
														</tr>
														<tr>


<?

	// 판매중인 상품의 판매종료시간
	$app_nowSaleTime = info_nowsale_time($row_product[code]);

	// 선택 지역의 오늘 판매상품 코드
	$app_nowSaleItem = info_nowsale($thiscate);


if($minStock < 1 || $row_product[code] != $info_nowsale_code) $buyImg = "btn_soldout.gif";
else if($minStock < 5) $buyImg = "btn_buy.gif";

	// 매진시 버튼수정
	if(
		$minStock > 0 
		&& time() < $app_nowSaleTime
		&& $row_product[code] == $app_nowSaleItem
	) {

		if($row_member[id]) { // 회원이면...
			echo "<td width='189'><input type='image' src='/images/group/btn_buy.gif' border=0 /></td>";

		} 
		else { // 비회원이면..
			echo "<td width='189'><a href='#none' onclick=\"alert('로그인 후 구매하실수 있습니다');\"><img  src='/images/group/btn_buy.gif' border=0/></a></td>";

		}
	} 
	else { // 매진시..
		echo "<td width='189'><a href='#none' onclick=\"alert('죄송합니다. 해당상품은 판매 종료되었습니다.');\" style='cursor:pointer'><img src='/images/group/btn_soldout.gif' border=0/></a></td>";
	}

?>			


														</tr>
												</table>
										</td>
								</tr>
						</table>
						</form>
						<!--//구매하기-->
						<!--그래프-->
						<table width="262" border="0" cellspacing="0" cellpadding="0">
								<tr>
										<td height="146" align="center" background="/images/group/graph_bg.gif">
												<table width="212" border="0" cellspacing="0" cellpadding="0">
														<tr>
																<td><script type="text/javascript">
																	AC_FL_RunContent( 'codebase','http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=9,0,28,0','width','211','height','73','src','/flash/main_flash_03','quality','high','pluginspage','http://www.adobe.com/shockwave/download/download.cgi?P1_Prod_Version=ShockwaveFlash','movie','/flash/main_flash_03?inVar1=<?=number_format($row_product[saleCntMax])?>&inVar2=<?=number_format($saleCntSum)?>','wmode','transparent' ); //end AC code
																	</script><noscript><object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=9,0,28,0"  width="211" height="73">
																		<param name="movie" value="/flash/main_flash_03.swf?inVar1=<?=number_format($row_product[saleCntMax])?>&inVar2=<?=number_format($saleCntSum)?>" />
																		<param name="quality" value="high" />
																		<param name="wmode" value="transparent" />
																		<embed src="/flash/main_flash_03.swf?inVar1=<?=number_format($row_product[saleCntMax])?>&inVar2=<?=number_format($saleCntSum)?>" quality="high" pluginspage="http://www.adobe.com/shockwave/download/download.cgi?P1_Prod_Version=ShockwaveFlash" type="application/x-shockwave-flash" width="211" height="73" wmode="transparent"></embed>
																	</object></noscript></td>
														</tr>

				<?
				$perTmp = @($saleCntSum / $row_product[saleCntMax]);
				$per = $perTmp < 1 ? $perTmp*212 : 212;
				// 그래프 
				?>


														<tr>
																<td height="7" background="/images/group/graph_prograss_bg.gif">
																		<table width="<?=$per?>" border="0" cellpadding="0" cellspacing="0" background="/images/group/graph_prograss_hot.gif">
																				<tr>
																						<td height="7"> </td>
																				</tr>
																		</table>
																</td>
														</tr>
														<tr>
																<td><script type="text/javascript">
																	AC_FL_RunContent( 'codebase','http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=9,0,28,0','width','211','height','17','src','/flash/main_flash_04','quality','high','pluginspage','http://www.adobe.com/shockwave/download/download.cgi?P1_Prod_Version=ShockwaveFlash','movie','/flash/main_flash_04?inVar1=0&inVar2=<?=number_format($row_product[saleCntMax])?>','wmode','transparent' ); //end AC code
																	</script><noscript><object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=9,0,28,0"  width="211" height="17">
																		<param name="movie" value="/flash/main_flash_04.swf?inVar1=0&inVar2=<?=number_format($row_product[saleCntMax])?>" />
																		<param name="quality" value="high" />
																		<param name="wmode" value="transparent" />
																		<embed src="/flash/main_flash_04.swf?inVar1=0&inVar2=<?=number_format($row_product[saleCntMax])?>" quality="high" pluginspage="http://www.adobe.com/shockwave/download/download.cgi?P1_Prod_Version=ShockwaveFlash" type="application/x-shockwave-flash" width="211" height="17" wmode="transparent"></embed>
																	</object></noscript></td>
														</tr>
												</table>
										</td>
								</tr>
						</table>
						<!--그래프-->

<?
include $_SERVER[DOCUMENT_ROOT]."/pages/goodFeed.php";
?>



				</td>
		</tr>
</table>
<script>
window.onload = talktalkAjaxLoad;
</script>
<!--//센터 내용-->

