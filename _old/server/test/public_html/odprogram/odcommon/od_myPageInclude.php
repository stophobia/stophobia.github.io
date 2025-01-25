<?
function myPageLeftPrint($idx){
	global $mem;
?>

					<table width="100%" border="0" cellspacing="0" cellpadding="0">
<?
if($row_member[id]) {
?>
						<tr>
							<td height="34"><a href="/odprogram/odmembers/od_modify.php" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Image2','','/images/mapage_roll_02.jpg',1)"><img src="/images/mapage_roll_<?=$idx == "1" ? "02" : "01";?>.jpg" name="Image2" width="180" height="34" border="0"></a></td>
						</tr>
						<tr>
							<td height="34"><a href="/?Pid=u03b02" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Image3','','/images/mapage_roll_04.jpg',1)"><img src="/images/mapage_roll_<?=$idx == "2" ? "04" : "03";?>.jpg" name="Image3" width="180" height="34" border="0"></a></td>
						</tr>
<?
}
?>
						<tr>
							<td height="34"><a href="/odprogram/odproducts/od_ordersearchresult.php" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Image4','','/images/mapage_roll_06.jpg',1)"><img src="/images/mapage_roll_<?=$idx == "3" ? "06" : "05";?>.jpg" name="Image4" width="180" height="34" border="0"></a></td>
						</tr>
<?
if($row_member[id]) {
?>
						<tr>
							<td height="34"><a href="/?Pid=u03b04" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Image5','','/images/mapage_roll_08.jpg',1)"><img src="/images/mapage_roll_<?=$idx == "4" ? "08" : "07";?>.jpg" name="Image5" width="180" height="34" border="0"></a></td>
						</tr>
						<tr>
							<td height="34"><a href="/?Pid=u03b05" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Image6','','/images/mapage_roll_10.jpg',1)"><img src="/images/mapage_roll_<?=$idx == "5" ? "10" : "09";?>.jpg" name="Image6" width="180" height="34" border="0"></a></td>
						</tr>
<?
}
?>
						<tr>
							<td height="34"><a href="/?Pid=u03b06" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Image7','','/images/mapage_roll_12.jpg',1)"><img src="/images/mapage_roll_<?=$idx == "6" ? "12" : "11";?>.jpg" name="Image7" width="180" height="34" border="0"></a></td>
						</tr>
<?
if($row_member[id]) {
?>
						<tr>
							<td height="34"><a href="/?Pid=u03b07" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Image8','','/images/mapage_roll_14.jpg',1)"><img src="/images/mapage_roll_<?=$idx == "7" ? "14" : "13";?>.jpg" name="Image8" width="180" height="34" border="0"></a></td>
						</tr>
						<tr>
							<td height="34"><a href="/?Pid=u03b08" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Image9','','/images/mapage_roll_16.jpg',1)"><img src="/images/mapage_roll_<?=$idx == "8" ? "16" : "15";?>.jpg" name="Image9" width="180" height="34" border="0"></a></td>
						</tr>
<?
}
?>
					</table>
<?
}
?>