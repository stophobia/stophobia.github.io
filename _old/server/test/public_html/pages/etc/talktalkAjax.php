<?php
// 필요한 설정파일 불러오기
include $_SERVER[DOCUMENT_ROOT]."/odprogram/odcommon/od_config.inc.php";
include $_SERVER[DOCUMENT_ROOT]."/odprogram/odcommon/od_lib.inc.php";
include $_SERVER[DOCUMENT_ROOT]."/odprogram/odcommon/od_function.inc.php";

# 예약되어있는 토크를 입력.
@exec("/usr/local/bin/php ".dirname(__FILE__)."/odprogram/odmanager/odproducts/comment2AutoPro.php");
?>
									
									<table width=645 border=0 cellpadding=0 cellspacing=0>
										<tr>
											<td width=645 style="padding:'5px 0 5px 0'">
<?
$plusLine	= 10;
$limit = is_numeric($_POST[limit])  ? $_POST[limit] : $plusLine; // 더보기 클릭시 추가로 뿌릴 토크수
$que = "select * from odtTt where ttProCode = '".$code."' and ttIsReply != '1' and ttIsNotice = 'N'  order by ttSNo desc,  ttRegidate";

$res = mysql_query($que);
$num = mysql_num_rows($res);
if(!mysql_num_rows($res)) {
?>

											<table width=645 align=center border=0 cellspacing=0 cellpadding=0>
												<tr>
													<td height=5></td>
												</tr>
												<tr>
													<td background="/img/talk_img_13.jpg" width="645" height="5" /></td>
												</tr>
												<tr>
													<td height=5></td>
												</tr>
												<tr>
													<td height=40 align=center>등록된 토크가 없습니다.</td>
												</tr>
												<tr>
													<td height=5></td>
												</tr>
												<tr>
													<td background="/img/talk_img_13.jpg" width="645" height="5" /></td>
												</tr>
												<tr>
													<td height=5></td>
												</tr>
											</table>

<?
}
while($row = mysql_fetch_assoc($res)) {
	$row[pic] = @mysql_result(mysql_query("select pic from odtMember where id='".$row[ttID]."'"),0);

	$replyPadding = $row[ttIsReply] ? "style='padding:0 10px 0 10px'" : NULL;

  $row[ttContent] = str_replace(array("<", ">", "'", '"', '\"'), array("&lt", "&gt;", "&#39;", "&#39;", "&quot;"), $row[ttContent]);

?>
											<!-- 루프 -->
											<table border=0 cellpadding=0 cellspacing=0>
												<tr>
													<td width=645>
													

																	<?
																		if($TmpIdx++) { // 처음만 노출안됨.
																	?>
																			<table width="645" border="0" cellspacing="0" cellpadding="0">
																				<tr>
																						<td colspan="2" bgcolor="#cccccc" height="1"> </td>
																				</tr>
																				<tr>
																						<td height=10></td>
																					</tr>
																			</table>
																	<?
																	}
																	?>

																			<table width="645" border="0" cellspacing="0" cellpadding="0">
																				<tr>
																						<td width="95" valign="top" class="spb15"><img src="<?=$row[pic] ? $row[pic] : ($row_member[id] == $row[ttID] ? "/images/group/talk_sumnail.gif\" onclick=\"location.href='/odprogram/odmembers/od_modify.php'\" style='cursor:hand'" : "/images/group/talk_sumnail.gif");?>" style="border:1px solid #b1b1b1" width="70" height="70"></td>
																						<td valign="top" class="spb15"><span class="green_12B"><?=$row[ttName]?></span> 
																						<?
																							# 공지버튼
																							if(@array_key_exists($row_member[id],$array_adminid) == true) {
																								if($row[isImg] =="md") {
																						?>
																								<input type='checkbox' name='nType' onclick="if(confirm('해당 토크를 공지로 지정하겠습니까?')) {hidden_frame.location.href='/pages/etc/talktalkNotice.php?nType=AN&ttNo=<?=$row[ttNo]?>';} else this.checked=false;">공지
																						<?
																								} else if($row[isImg] =="seller") {
																						?>
																								<input type='checkbox' name='nType' onclick="if(confirm('해당 토크를 공지로 지정하겠습니까?')) {hidden_frame.location.href='/pages/etc/talktalkNotice.php?nType=SN&ttNo=<?=$row[ttNo]?>';} else this.checked=false;">공지
																						<?
																								}
																							}
																						?>
																						
																						&nbsp;&nbsp;&nbsp;(<?=date('m.d H:i',strtotime($row[ttRegidate]))?>)&nbsp;&nbsp;
																						
																								<?
																								if($row_member[id]) {
																								?>
																								<a href="#none" onclick="replyDel(<?=$row[ttNo]?>)"><img src="/images/group/talk_del.gif" align="absmiddle" border=0></a>
																								<?
																								}
																								?>	
																								
																								<div class="smtmb5"><?=stripslashes($row[ttContent])?> &nbsp;<a href="#none" onclick="<?=$row_member[id] ? "showReply('".$row[ttNo]."')" : "loginConfirm('/')";?>"><img src="/images/group/talk_reple.gif" width="58" height="21" align="absmiddle" border=0></a></div>
																								<!--댓글달기-->
																								<span id="reply_<?=$row[ttNo]?>"></span>
																								<!--//댓글달기-->

																					<?
																					$que2 = "select * from odtTt where ttProCode ='".$code."' and ttSNo ='".$row[ttNo]."' and ttIsReply = '1' order by ttRegidate";
																					$res2 = mysql_query($que2);
																					$total2 = mysql_num_rows($res2);
																					if($total2) {
																					?>
																					<!-- 댓글의 댓글 리스트 -->
																					
																					<div id="viewReply_<?=$row[ttNo]?>" style="display:">

																							<?
																							while($row2 = mysql_fetch_assoc($res2)) {
																							?>
																								<span class="black_12B"><img src="/images/group/talk_re_arrow.gif" width="25" height="17"><?=$row2[ttName]?></span> &nbsp;&nbsp;&nbsp;(<?=date('m.d H:i',strtotime($row2[ttRegidate]))?>)&nbsp;&nbsp;<a href="#none" onclick="replyDel(<?=$row2[ttNo]?>)"><img src="/images/group/talk_del.gif" border=0></a><br>
																								<div  style="margin:5px 0px 0px 25px"><?=stripslashes($row2[ttContent])?></div>

																							<?
																							}
																							?>
																					</div>
																					<!-- 댓글의 댓글 끝 -->
																					<?
																					}
																					?>









																						</td>
																				</tr>
																			</table>
																						</td>
																				</tr>
																			</table>
																				
																			<?
																			if($TmpIdx >= $limit) {
																				
																			?>
																				<!--토크리스트-->
																				<div align=center><a href="#none" onclick="document.getElementById('moreView').src='/images/group/loading.gif';talktalkAjaxLoad(<?=$limit+$plusLine?>)"><img id='moreView' src="/images/group/talk_moreview.gif"  border="0"></a></div>
																				<!--//상품 토크-->
																			<?
																				
																				break;
																			}
																			?>

																		<?
																		}
																		?>