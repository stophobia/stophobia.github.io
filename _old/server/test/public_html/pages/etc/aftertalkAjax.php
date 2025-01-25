<?php
// 필요한 설정파일 불러오기
include $_SERVER[DOCUMENT_ROOT]."/odprogram/odcommon/od_config.inc.php";
include $_SERVER[DOCUMENT_ROOT]."/odprogram/odcommon/od_lib.inc.php";
include $_SERVER[DOCUMENT_ROOT]."/odprogram/odcommon/od_function.inc.php";

# 예약되어있는 후기를 입력.
@exec("/usr/local/bin/php ".dirname(__FILE__)."/odprogram/odmanager/odproducts/afterComment2AutoPro.php");

unset($denyID,$tmp);
$que = "select * from odtAfterTalk  where afterProCode = '".$code."' and afterGood >= 10  order by afterGood desc, afterSNo desc,  afterRegidate  limit 3";
$res = mysql_query($que);
$isBest = @mysql_num_rows($res);
if($isBest) {
?>
									<br>
									<!-- 베스트 시작 -->
									<table width=560 border=0 cellpadding=0 cellspacing=0>
										<tr>
											<td width=560 style="border:1px solid #c0c0c0;padding:'5px 0 5px 0'" bgcolor="fafbe2">
<?
}
while($row = mysql_fetch_array($res)) {
	$row[pic] = @mysql_result(mysql_query("select pic from odtMember where id='".$row[afterID]."'"),0);
	# 베플의 코멘트는 따로 저장해서 리스트에 나오지 않게함.
	$denyID .= " and  afterSNo != '".$row[afterNo]."' ";
?>
											<!-- 루프 -->
											<table border=0 cellpadding=0 cellspacing=0>
												<tr>
													<td width=560><table width=100% border=0 cellpadding=0 cellspacing=0>
														<tr>
															<td align=center valign=top><img width=60 height=70   src="<?=$row[pic] ? $row[pic] : ($row_member[id] == $row[afterID] ? "/img/my_talk_img_092.jpg\" onclick=\"location.href='/odprogram/odmembers/od_modify.php'\" style='cursor:hand'" : "/img/talk_img_092.jpg");?>" style="border:1px solid #b1b1b1"></td>
															<td width=4 bgcolor="#dedede"></td>
															<td width=465 style="padding-left:7px;" valign=top><table border=0 cellpadding=0 cellspacing=0>
																<tr>
																	<td style="poll2_name" height=30><?=apply_talkid($row[afterID],$row[isImg])?> &nbsp; <?=icon_member($row[afterID],$row[isImg])?></td>
																	<td align=right>
																		<img src="/images/beple<?=$tmp?>.gif">&nbsp;&nbsp;
																		<a href="#none" onclick="good2(<?=$row[afterNo]?>)"><img src="/img/talk_img_10.jpg" border=0 align=middle></a> <span id="aftergood_<?=$row[afterNo]?>"  ><?=$row[afterGood]?></span> &nbsp;
																		<a href="#none" onclick="bad2(<?=$row[afterNo]?>)"><img src="/img/talk_img_10.jpg" border=0 align=middle></a> <span id="afterbad_<?=$row[afterNo]?>" ><?=$row[afterBad]?></span>
																	</td>
																</tr>
																<tr>
																	<td width=465 height=1 colspan=2 background="/img/talk_img_12.jpg"></td>
																</tr>
																<tr>
																	<td colspan=2 style="padding:5px 5px 5px 5px">
																		<?=stripslashes($row[afterContent])?> 
																		<span class="unnamed3">(<?=date('m.d H:i',strtotime($row[afterRegidate]))?>)</span> 
																		<a href="#none" onclick="<?=$row_member[id] ? "showReply2('".$row[afterNo]."')" : "loginConfirm('/')";?>"><img src="/images/poll2_03.gif" border=0></a>  
																		<?
																		if($row_member[id]) {
																		?>
																		<a href="#none" onclick="replyDel2(<?=$row[afterNo]?>)"><img src="/img/talk_ico_04.jpg" border=0></a>
																		<?
																		}
																		?>
																	</td>
																</tr>
															<?
															$que2 = "select * from odtAfterTalk where afterProCode ='".$code."' and afterSNo ='".$row[afterNo]."' and afterIsReply = '1' order by afterRegidate";
															$res2 = mysql_query($que2);
															$total2 = mysql_num_rows($res2);
															if($total2) {
															?>
																<tr>
																	<td class="replyreply">
																	<a href="#none" onclick="reply2View2('<?=$row[afterNo]?>')">댓글의댓글 <b><?=$total2?>개</b> <img id='reply_arrow_<?=$row[afterNo]?>' src="/images/ilji_31_up_.gif" border=0></a>
																	</td>
																</tr>
															<?
															}
															?>

																<!-- 댓글 입력폼 -->
																<tr>
																	<td colspan=2 style="padding:5 5 5 5"><span id="reply_<?=$row[afterNo]?>"></span></td>
																</tr>
																<!-- 댓글 입력 폼 끝 -->


															<?
															if($total2) {
															?>
															<!-- 댓글의 댓글 리스트 -->
																<tr id="viewReply_<?=$row[afterNo]?>" style="display:none">
																	<td colspan=2><table width=100% border=0 cellpadding=0 cellspacing=0>
																	<?
																	while($row2 = mysql_fetch_array($res2)) {
																	?>
																		<tr>
																			<td>
																				<table width=95% cellpadding=0 cellspacing=0 border=0 align=right>
																					<tr>
																						<td width=100% height=20 style="padding:3px 0 3px 0;">
																						<img src="/images/poll2_14.gif"> 
																						<span  style="color:48688e"><?=apply_talkid($row2[afterID],$row2[isImg])?></span> &nbsp;
																						<?=stripslashes($row2[afterContent])?> <span class="unnamed3">(<?=date('m.d H:i',strtotime($row2[afterRegidate]))?>)</span> 
																							<a href="#none" onclick="replyDel2(<?=$row2[afterNo]?>)""><img src="/img/talk_ico_04.jpg" border=0></a>
																						</td>
																					</tr>
																				</table>
																			</td>
																		</tr>
																	<?
																	}
																	?>
																</table></td>
															</tr>
															<!-- 댓글의 댓글 끝 -->
															<?
															}
															?>

															</table>
															</td>
														</tr>
													</table></td>
												</tr>
											</table>
											<table width=560 align=center border=0 cellspacing=0 cellpadding=0>
												<tr>
													<td height=5></td>
												</tr>
												<tr>
													<td><img src="/img/talk_img_13.jpg" width="560" height="5" /></td>
												</tr>
												<tr>
													<td height=5></td>
												</tr>
											</table>
<?
}
if($isBest && !$pg) {
?>
											</td>
										</tr>
									</table>
									<!-- 베스트 끝 -->
<?
}
?>
									
									<!-- 일반댓글 시작 -->
									<table width=560 border=0 cellpadding=0 cellspacing=0>
										<tr>
											<td height=30 align=right valign=bottom>등록된 상품후기<span class="unnamed7"> <?=number_format(mysql_result(mysql_query("select count(*) from odtAfterTalk where afterProCode = '".$code."'"),0))?> 개</span>
											</td>
										</tr>
										<tr>
											<td height=5></td>
										</tr>
									</table>
                  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td><img src="/img/talk_img_08.jpg" width="560" height="4" /></td>
                    </tr>
                  </table>
									<table>
										<tr>
											<td height=5></td>
										</tr>
									</table>

<?
$que = "select * from odtAfterTalk where afterProCode = '".$code."'";
$res = mysql_query($que);
if(!mysql_num_rows($res)) {
?>

											<table width=560 align=center border=0 cellspacing=0 cellpadding=0>
												<tr>
													<td height=5></td>
												</tr>
												<tr>
													<td><img src="/img/talk_img_13.jpg" width="560" height="5" /></td>
												</tr>
												<tr>
													<td height=5></td>
												</tr>
												<tr>
													<td height=40 align=center>등록된 후기가 없습니다.</td>
												</tr>
												<tr>
													<td height=5></td>
												</tr>
												<tr>
													<td><img src="/img/talk_img_13.jpg" width="560" height="5" /></td>
												</tr>
												<tr>
													<td height=5></td>
												</tr>
											</table>

<?
}
?>

									<table width=560 border=0 cellpadding=0 cellspacing=0>
										<tr>
											<td width=560 style="padding:'5px 0 5px 0'">
<?
$que = "select * from odtAfterTalk where afterProCode = '".$code."' and afterIsReply != '1' and afterIsNotice = 'N'  order by afterSNo desc,  afterRegidate";
$res = mysql_query($que);
while($row = mysql_fetch_array($res)) {
	$row[pic] = @mysql_result(mysql_query("select pic from odtMember where id='".$row[afterID]."'"),0);
	$replyPadding = $row[afterIsReply] ? "style='padding:0 10px 0 10px'" : NULL;
?>
											<!-- 루프 -->
											<table border=0 cellpadding=0 cellspacing=0>
												<tr>
													<td width=560><table width=100% border=0 cellpadding=0 cellspacing=0>
														<tr>
															<td align=center width=82 valign=top><img width=60 height=70   src="<?=$row[pic] ? $row[pic] : ($row_member[id] == $row[afterID] ? "/img/my_talk_img_09.jpg\" onclick=\"location.href='/odprogram/odmembers/od_modify.php'\" style='cursor:hand'" : "/img/talk_img_092.jpg");?>" style="border:1px solid #b1b1b1"></td>
															<td width=465 style="padding-left:7px;" valign=top><table border=0 cellpadding=0 cellspacing=0>
																<tr>
																	<td style="poll2_name" height=30 align=left><?=apply_talkid($row[afterID],$row[isImg])?> &nbsp; <?=icon_member($row[afterID],$row[isImg])?></td>
																	<td align=right>
																		<a href="#none" onclick="good2(<?=$row[afterNo]?>)"><img src="/img/talk_img_10.jpg" border=0 align=middle></a>
																		<span  id="aftergood_<?=$row[afterNo]?>"><?=$row[afterGood]?></span> &nbsp;
																		<a href="#none" onclick="bad2(<?=$row[afterNo]?>)"><img src="/img/talk_img_11.jpg" border=0 align=middle></a>
																		<span  id="afterbad_<?=$row[afterNo]?>"><?=$row[afterBad]?></span>
																	</td>
																</tr>
																<tr>
																	<td width=465 height=1 colspan=2 background="/img/talk_img_12.jpg"></td>
																</tr>
																<tr>
																	<td width=465 colspan=2 style="padding:5px 5px 5px 5px"  align=left>
																	<?=stripslashes($row[afterContent])?> 
																	<span class="unnamed3">(<?=date('m.d H:i',strtotime($row[afterRegidate]))?>)</span>
																	<a href="#none" onclick="<?=$row_member[id] ? "showReply2('".$row[afterNo]."')" : "loginConfirm('".urlencode($_SERVER[REQUEST_URI])."')";?>"><img src="/img/talk_ico_03.jpg" border=0></a>  
																	<?
																	if($row_member[id]) {
																	?>
																	<a href="#none" onclick="replyDel2(<?=$row[afterNo]?>)"><img src="/img/talk_ico_04.jpg" border=0></a>
																	<?
																	}
																	?>
																	</td>
																</tr>
																<!-- 댓글 입력폼 -->
																<tr>
																	<td colspan=2 style="padding:5 5 5 5">
																		<span id="reply_<?=$row[afterNo]?>"></span>
																	</td>
																</tr>
																<!-- 댓글 입력 폼 끝 -->


															<?
															$que2 = "select * from odtAfterTalk where afterProCode ='".$code."' and afterSNo ='".$row[afterNo]."' and afterIsReply = '1' order by afterRegidate";
															$res2 = mysql_query($que2);
															$total2 = mysql_num_rows($res2);
															if($total2) {
															?>
															<!-- 댓글의 댓글 리스트 -->
																<tr id="viewReply_<?=$row[afterNo]?>" style="display:">
																	<td colspan=2 align=left><table width=100% border=0 cellpadding=0 cellspacing=0>
																	<?
																	while($row2 = mysql_fetch_array($res2)) {
																	?>
																		<tr>
																			<td>
																				<table width=100% cellpadding=0 cellspacing=0 border=0 align=right>
																					<tr>
																						<td width=100% height=20 style="padding:3px 0 3px 0;">
																						<img src="/img/talk_ico_05.jpg"> 
																						<span  style="color:48688e;padding:0 5px 0 5px"  align=left><?=apply_talkid($row2[afterID],$row2[isImg])?></span> &nbsp;
																						<?=stripslashes($row2[afterContent])?> <span class="unnamed3">(<?=date('m.d H:i',strtotime($row2[afterRegidate]))?>)</span> 
																							<a href="#none" onclick="replyDel2(<?=$row2[afterNo]?>)"><img src="/img/talk_ico_04.jpg" border=0></a>
																						</td>
																					</tr>
																				</table>
																			</td>
																		</tr>
																	<?
																	}
																	?>
																</table></td>
															</tr>
															<!-- 댓글의 댓글 끝 -->
															<?
															}
															?>
															</table></td>
														</tr>
													</table></td>
												</tr>
											</table>
											<table width=560 align=center border=0 cellspacing=0 cellpadding=0>
												<tr>
													<td height=5></td>
												</tr>
												<tr>
													<td><img src="/img/talk_img_13.jpg" width="560" height="5" /></td>
												</tr>
												<tr>
													<td height=5></td>
												</tr>
											</table>
<?
}
?>
									<!-- 일반댓글 끝 -->
									</td>
								</tr>
							</table>