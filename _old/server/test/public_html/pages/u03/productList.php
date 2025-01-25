<!-- html 본문이나, head 안에 삽입 S -->
<script language="JavaScript" src="./pages/u03/dhtmllib.js"></script>
<script language="JavaScript" src="./pages/u03/scroller.js"></script>
<script language="JavaScript">

var myScroller1 = new Scroller(0, 0, 300, 20, 0, 0); //(xpos, ypos, width, height, border, padding)

myScroller1.setColors("#000000", "#f7f7f7", "#f7f7f7"); //(fgcolor, bgcolor, bdcolor)
myScroller1.setFont("Verdana,Arial,Helvetica", 2);

//반복되는 부분 S
<?
$que = "select a.title, a.serialnum from odtBoard as a ,odtProduct as b where a.boardkind=2 and b.code = a.procode and b.catecode like '".$catecode."%'";
$res = mysql_query($que);
$num = @mysql_num_rows($res);
if($num < 1) {
	$num = 0;
?>
		myScroller1.addItem("<span class='oneline'>상품평이 없습니다.</span>");
<?
} else {
	while($row = mysql_fetch_array($res)) {
?>
		myScroller1.addItem("<a href='/odprogram/odboard/odboardcount.php?board=2&page=1&serialnum=<?=$row[serialnum]?>'><span class='oneline'><?=$row[title]?></span></a>");
<?
	}
}

?>
// 반복되는 부분  E

myScroller1.setPause(3000); //1000 = 1초

function runmikescroll() {
        var layer;
        var mikex, mikey;
        layer = getLayer("placeholder");
        mikex = getPageLeft(layer);
        mikey = getPageTop(layer);

        myScroller1.create();
        myScroller1.hide();
        myScroller1.moveTo(mikex, mikey);
        myScroller1.setzIndex(100);
        myScroller1.show();
}
window.onload=runmikescroll
</script>
<!-- html 본문이나, head 안에 삽입 E -->

<table width="648"  border="0" align="center" cellpadding="0" cellspacing="0">
      <tr>
        <td height="38" background="/images/shopping_img_ico_07.gif"><table width="100%"  border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="17"></td>
          <td width="70">상품평(<?=$num?>건) : </td>
					<td>
					<!-- 출력을 원하는 위치에 삽입 S-->
					<div id="tempholder"></div><div id="placeholder" style="position:relative; width:230px; height:20px;">
					<!-- 출력을 원하는 위치에 삽입 E-->					
					</td>
          <td width="110"><a href="/odprogram/odboard/od_board.php?board=2"><img src="/images/shopping_img_ico_08.gif" width="88" height="18" border="0"></a></td>
          </tr>
        </table></td>
      </tr>
    </table>
    <table width="100%"  border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td height="18"></td>
      </tr>
    </table>
    <table width="640"  border="0" align="center" cellpadding="0" cellspacing="0">
      <tr>
        <td height="700" valign="top"><table width="100%"  border="0" cellspacing="0" cellpadding="0">
					<tr>
						<td valign="top">
<?

if($searchKey) {$where_ = " AND " .$searchField. " like '%".$searchKey."%' ";}

$que = "SELECT * FROM odtProduct WHERE serialnum!='' AND hiddenTemp <> 'yes' AND (iwpcheck='all' OR iwpcheck='no') AND authum='yes' and cateCode like '".$catecode."%' ".$where_." ORDER BY catecode ASC, lineUp ASC";
$res = mysql_query($que);

/* 페이징 처리 시작 */
$total = mysql_num_rows($res);
## 페이지링크에 사용될 변수값을 정의한다. ###################################
$LineNumber = 100;
$LinkNumber = 10;
	
if(!$page) $page = 1;

if(!$total) {
	$first = 1;
	$last = 0;   
}
else {
	$first = $LineNumber * ($page - 1);
	$last = $LineNumber * $page;
	$NomLine = $total - $last;
	   
	if($NomLine > 0) $last -= 1;
	else $last = $total-1; 
}	

## 전체 페이지수를 계산한다. ##################
$TotalPage = ceil($total / $LineNumber);
/* 페이징 처리 끝  */

if($total < 1) {
?>
							<table width="144"  border="0" align="center" cellpadding="0" cellspacing="0">
								<tr>
									<td width="144" align=center> 상품이 없습니다. </td>
								</tr>
							</table>

<?
} else {
	while($row = mysql_fetch_array($res)) {
		if($i) {
			if($i % 4 == 0) echo "</tr><tr>";
			echo "</td><td valign='top'>";
		}

		if($row[inputDate] > time()-(60*60*24*7)) $new_icon					= " <img src='/images/shopping_img_ico_01.gif'> "; else unset($new_icon);
		if($row[bestChuchun]	== "yes")						$best_icon				= " <img src='/images/shopping_img_ico_02.gif'> "; else unset($best_icon);
		if($row[mdChuchun]		== "yes")						$mdchuchun_icon		= " <img src='/images/shopping_img_ico_03.gif'> "; else unset($mdchuchun_icon);
		if($row[exDelivery]		== "yes")						$free_icon				= " <img src='/images/shopping_img_ico_04.gif'> "; else unset($free_icon);

		if($searchField == "comment1") $row[comment1] = str_replace($searchKey,"<span style='background-color:yellow'>".$searchKey."</span>",$row[comment1]);

	?>
							<table width="144"  border="0" align="center" cellpadding="0" cellspacing="0">
								<tr>
									<td width="144" valign="top"><table width="100%" cellpadding="0" cellspacing="0">
										<tr>
											<td><div class="PdImg">
												<a href="/odprogram/products/productdetail.php?code=<?=$row[code]?>&catecode=<?=$row[catecode]?>&Length=2">
													<img src="/odprogram/upload/products/<?=$row[code]?>s.jpg" width="140" height="140">
												</a>
												</div>
											</td>
										</tr>
									</table>
										<table width="100%"  border="0" cellspacing="0" cellpadding="0">
											<tr>
												<td height="10"></td>
											</tr>
										</table>
										<table width="100%"  border="0" cellspacing="0" cellpadding="0">
											<tr>
												<td><div align="right"><a href="javascript:;" onclick="openwindow('zoomimg','/odprogram/products/zoomimg.php?code=<?=$row[code]?>&ImgNum=1',600,519,0)"><img src="/images/shopping_img_002.gif" width="31" height="18" border=0></a></div></td>
											<td>
												<a href="/odprogram/products/productdetail.php?code=<?=$row[code]?>&catecode=<?=$row[catecode]?>&Length=2">
													<img src="/images/shopping_img_003.gif" width="71" height="18" border=0>
												</a>
											</td>
											</tr>
										</table>
										<table width="100%"  border="0" cellspacing="0" cellpadding="0">
											<tr>
												<td height="47" class="lux_menu">
													<a href="/odprogram/products/productdetail.php?code=<?=$row[code]?>&catecode=<?=$row[catecode]?>&Length=2">
														<?=$row[name]?>
													</a>
												</td>
											</tr>
										</table>
										<table width="100%"  border="0" cellspacing="0" cellpadding="0">
											<tr>
												<td><?=$new_icon.$best_icon.$mdchuchun_icon.$free_icon?></td>
											</tr>
										</table>
										<table width="100%"  border="0" cellspacing="0" cellpadding="0">
											<tr>
												<td height="8" background="/images/shopping_img_004.gif"></td>
											</tr>
										</table>
										<table width="100%"  border="0" cellspacing="0" cellpadding="0">
											<tr>
												<td height="5"></td>
											</tr>
										</table>
										<table width="100%"  border="0" cellspacing="0" cellpadding="0">
											<tr>
												<td height="47"><?=$row[comment1]?></td>
											</tr>
										</table>
										<table width="100%"  border="0" cellspacing="0" cellpadding="0">
											<tr>
												<td height="8" background="/images/shopping_img_004.gif"></td>
											</tr>
										</table>
										<table width="100%"  border="0" cellspacing="0" cellpadding="0">
											<tr>
												<td height="7"></td>
											</tr>
										</table>
										<table align=center border="0" cellspacing="0" cellpadding="0">
											<tr>
												<td><div align="right"><img src="/images/shopping_img_ico_05.gif" width="18" height="15"></div></td>
											<td class="L_blue"><?=number_format($row[price])?>원</td>
											</tr>
										</table>
										<table width="100%"  border="0" cellspacing="0" cellpadding="0">
											<tr>
												<td height="5"></td>
											</tr>
										</table>
										<table align=center  border="0" cellspacing="0" cellpadding="0">
											<tr>
												<td><div align="right"><img src="/images/shopping_img_ico_06.gif" width="15" height="11"></div></td>
												<td><?=number_format($row[point])?>점</td>
											</tr>
										</table></td>
								</tr>
							</table><br>
<?
	$i++;
	} // end while
}	// end if
?>
						</td>
          </tr>
        </table>
          <table width="100%"  border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td height="20">&nbsp;</td>
            </tr>
          </table>
          <table width="100%"  border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td height=1 background="/images/dot_w.gif" width=100%></td>
            </tr>
          </table>
          <table width="100%"  border="0" cellspacing="0" cellpadding="0">
<?
	## 페이징 
	if($TotalPage > 0) { 
?>
									<tr> 
										<td height="30" align="center" class="cate">
											<a href='/?Pid=<?=$Pid?>&<?=$par_page;?>&page=1&order=<?=$order;?>&by=<?=$by;?>'><img src='/odprogram/images/shop/arrow_pre2.gif' width='14' height='19' align='absmiddle' border='0'></a>
<?
		$TotalJump = ceil($TotalPage / $LinkNumber);
		$Jump = ceil($page / $LinkNumber);
		$FirstPage = ($Jump - 1) * $LinkNumber;
		$LastPage = $Jump * $LinkNumber;
		
		if($Jump >= $TotalJump) $LastPage = $TotalPage;
		
		if($Jump > 1) {
			$PrePage = $FirstPage;
			echo "<a href='/?Pid=$Pid&$par_page&page=$PrePage&order=$order&by=$by'><img src='/odprogram/images/shop/arrow_pre1.gif' width='14' height='19' align='absmiddle' border='0'></a>";
		}
		else {
			echo "<img src='/odprogram/odimages/odmain/tbtn_line.gif' width='19' height='13' border='0' align='absmiddle'>";
		}

		for($NowPage = $FirstPage+1; $NowPage <= $LastPage; $NowPage++) {
			if($page == $NowPage) {
				echo "<b>$NowPage</b><img src='/odprogram/odimages/odmain/tbtn_line.gif' width='19' height='13' border='0' align='absmiddle'>";
			}
			else {
				echo "<a href='/?Pid=$Pid&$par_page&page=$NowPage&order=$order&by=$by'>$NowPage</a><img src='/odprogram/odimages/odmain/tbtn_line.gif' width='19' height='13' border='0' align='absmiddle'>";
			}
		}

		if($Jump < $TotalJump) {
			$PrePage = $LastPage+1;
			echo "<a href='/?Pid=$Pid&$par_page&page=$PrePage&order=$order&by=$by'><img src='/odprogram/images/shop/arrow_next1.gif' width='14' height='19' align='absmiddle' border='0'></a>";
		}
?>
											<a href='/?Pid=<?=$Pid?>&<?=$par_page;?>&page=<?=$TotalPage;?>&order=<?=$order;?>&by=<?=$by;?>'><img src='/odprogram/images/shop/arrow_next2.gif' width='14' height='19' align='absmiddle' border='0'></a>
										</td>
									</tr>
<? 
	} 
?>
				</table>

<script language="javascript">
function searchSub(frm) {
	if(frm.searchField.value == "") return false;
	return true;
}
</script>
          <table border="0" cellspacing="0" cellpadding="0" align=center>
						<form name="searchFrm" method=get action="<?=$PHP_SELF?>" onsubmit="return searchSub(this)">
						<input type="hidden" name="Pid" value="<?=$Pid?>">
            <tr>
              <td height=40>
								<select name="searchField">
									<option value="">==검색항목선택==</option>
									<option value="name"			<?=$searchField == "name"			? "selected" : NULL;?>>상품이름</option>
									<option value="code"			<?=$searchField == "code"			? "selected" : NULL;?>>상품코드</option>
									<option value="comment1"	<?=$searchField == "comment1" ? "selected" : NULL;?>>상품간략설명</option>
								</select>
								<input type="text" size=15 name="searchKey" value="<?=$searchKey?>">
								<input type="image" src="/images/list_btn_search.gif">							
							</td>
            </tr>
						</form>
          </table>


				</td>
			</tr>
		</table>