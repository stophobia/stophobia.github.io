<?php
// 필요한 설정파일 불러오기
include $_SERVER[DOCUMENT_ROOT]."/odprogram/odcommon/od_config.inc.php";
include $_SERVER[DOCUMENT_ROOT]."/odprogram/odcommon/od_lib.inc.php";
include $_SERVER[DOCUMENT_ROOT]."/odprogram/odcommon/od_function.inc.php";
?>

						<table border=0 cellspacing=0 cellpadding=0>
							<tr>
								<td width=560>
									<table width=560 border=0 cellpadding=0 cellspacing=0>
										<tr>
											<td height=22></td>
										</tr>
										<tr>
											<td height=39><table width=560 border=0 cellpadding=0 cellspacing=0>
												<tr>
													<td width=500px></td>
													<td valign=bottom>댓글 <b><span class="unnamed7"><?=mysql_result(mysql_query("select count(*) from odtIljiCmt where iljiNo = '".$iljiNo."'"),0);?></a></b>개</td>
												</tr>
											</table></td>
										</tr>
									</table>
                  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td><img src="/img/talk_img_08.jpg" width="560" height="4" /></td>
                    </tr>
                  </table>
									<table border=0 cellpadding=0 cellspacing=0>
										<tr>
											<td height=6></td>
										</tr>
									</table>
									<!-- 일반댓글 시작 -->
									<table width=560 border=0 cellpadding=0 cellspacing=0>
										<tr>
											<td width=560 style="padding:'5px 0 5px 0'">
<?
$que = "select a.*, b.pic from odtIljiCmt as a, odtMember as b where a.iljiNo = '".$iljiNo."' and a.iCmtIsReply != '1' and a.iCmtID = b.id order by iCmtSNo desc,  iCmtRegidate";
$res = mysql_query($que);
while($row = mysql_fetch_array($res)) {
	$replyPadding = $row[isReply] ? "style='padding:0 10px 0 10px'" : NULL;
?>
											<!-- 루프 -->
											<table border=0 cellpadding=0 cellspacing=0>
												<tr>
													<td width=560><table width=560 border=0 cellpadding=0 cellspacing=0>
														<tr>
															<td align=center valign=top><img width=60 height=70  src="<?=$row[pic] ? $row[pic] : ($row_member[id] == $row[iCmtID] ? "/img/my_talk_img_09.jpg\" onclick=\"location.href='/odprogram/odmembers/od_modify.php'\" style='cursor:pointer'" : "/img/talk_img_092.jpg");?>" style="border:1px solid #b1b1b1"></td>
															<td width=466 style="padding-left:7px;" valign=top><table border=0 cellpadding=0 cellspacing=0>
																<tr>
																	<td style="poll2_name" height=30><?=apply_talkid($row[iCmtID],$row[isImg])?> &nbsp; <?=icon_member($row[iCmtID],$row[isImg])?></td>
																	<td align=right>
																	</td>
																</tr>
																<tr>
																	<td width=466 height=1 colspan=2 background="/images/poll2_49.gif"></td>
																</tr>
																<tr>
																	<td  width=466 colspan=2 style="padding:5px 5px 5px 5px">
																	<?=stripslashes($row[iCmtContent])?> 
																	<span class="unnamed3">(<?=date('m.d H:i',strtotime($row[iCmtRegidate]))?>)</span>
																	<a href="#none" onclick="<?=$row_member[id] ? "showReply('".$row[iCmtNo]."')" : "loginConfirm('".urlencode($_SERVER[REQUEST_URI])."')";?>"><img src="/img/talk_ico_03.jpg" border=0 align="absmiddle"></a>  
																	<?
																	if($row_member[id]) {
																	?>
																	<a href="#none" onclick="replyDel(<?=$row[iCmtNo]?>)"><img src="/img/talk_ico_04.jpg" border=0 align=absmiddle></a>
																	<?
																	}
																	?>
																	</td>
																</tr>
															<?
															$que2 = "select * from odtIljiCmt where iljiNo ='".$iljiNo."' and iCmtSNo ='".$row[iCmtNo]."' and iCmtIsReply = '1' order by iCmtRegidate";
															$res2 = mysql_query($que2);
															$total2 = mysql_num_rows($res2);
															if($total2) {
															?>
																<tr style="display:none">
																	<td class="replyreply">
																	<a href="#none" onclick="reply2View('<?=$row[iCmtNo]?>')">댓글의댓글 <b><?=$total2?>개</b> <img id='reply_arrow_<?=$row[iCmtNo]?>' src="/images/ilji_31_up_.gif" border=0></a>
																	</td>
																</tr>
															<?
															}
															?>

																<!-- 댓글 입력폼 -->
																<tr>
																	<td colspan=2 style="padding:5 5 5 5">
																		<span id="reply_<?=$row[iCmtNo]?>"></span>
																	</td>
																</tr>
																<!-- 댓글 입력 폼 끝 -->


															<?
															if($total2) {
															?>
															<!-- 댓글의 댓글 리스트 -->
																<tr id="viewReply_<?=$row[iCmtNo]?>" style="display:">
																	<td><table width=100% border=0 cellpadding=0 cellspacing=0>
																	<?
																	while($row2 = mysql_fetch_array($res2)) {
																	?>
																		<tr>
																			<td>
																				<table cellpadding=0 cellspacing=0 border=0 >
																					<tr>
																						<td width=12><img src="/img/talk_ico_05.jpg"></td>
																						<td style="color:48688e">&nbsp;<?=apply_talkid($row2[iCmtID],$row2[isImg])?>&nbsp;</td>
																						<td align=left style="line-height:200%"><?=stripslashes($row2[iCmtContent])?><span class="unnamed3">(<?=date('m.d H:i',strtotime($row2[iCmtRegidate]))?>)</span> 
																							<a href="#none" onclick="replyDel(<?=$row2[iCmtNo]?>)"><img src="/img/talk_ico_04.jpg" border=0 align=absmiddle></a>
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
								</td>
							</tr>
						</table>