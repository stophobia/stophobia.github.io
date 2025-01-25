<?php
// 필요한 설정파일 불러오기
include $_SERVER[DOCUMENT_ROOT]."/odprogram/odcommon/od_config.inc.php";
include $_SERVER[DOCUMENT_ROOT]."/odprogram/odcommon/od_lib.inc.php";
include $_SERVER[DOCUMENT_ROOT]."/odprogram/odcommon/od_function.inc.php";

$startDate = $pollDate."-01";
$endDate = date('Y-m-d',mktime(23,59,59,end(explode("-",$pollDate))+1,0,reset(explode("-",$pollDate))));
$dateWhere = " and (pollRegidate >= '".$startDate."' and pollRegidate <= '".$endDate."')";

?>
									
									<table width=560 border=0 cellpadding=0 cellspacing=0 align=center>
										<tr>
											<td height=22></td>
										</tr>
										<tr>
											<td height=39><table width=560 border=0 cellpadding=0 cellspacing=0>
												<tr>
													<td></td>
													<td valign=bottom align=right>댓글 <span class="unnamed7"><b><?=mysql_result(mysql_query("select count(*) from odtPoll2 where pollProCode = '".$proCode."'".$dateWhere),0);?></a></b>개</span></td>
													<td width=10></td>
												</tr>
											</table></td>
										</tr>
									</table>
                  <table width="560" border="0" cellspacing="0" cellpadding="0" align=center>
                    <tr>
                      <td><img src="/img/talk_img_08.jpg" width="560" height="4" /></td>
                    </tr>
                  </table>
<style>
.poll2_name {
	color:000000;
}
.poll2_good {
	color:ff4e17;
	font-weight:bold;
}
.poll2_bad {
	color:666666;
	font-weight:bold;
}
.poll2_date {
	color:858679;
	font-size:10px;
	font-family:tahoma;
}
</style>

<?
unset($denyID,$tmp);
$que = "select a.* , b.pic from odtPoll2 as a, odtMember as b where a.pollProCode = '".$proCode."' and a.pollGood >= 3 and a.isReply != '1' and a.pollID = b.id ".$dateWhere." order by a.pollGood desc, a.pollSNo desc,  a.pollRegidate  limit 3";

$res = mysql_query($que);
$isBest = @mysql_num_rows($res);
if($isBest && !$pg) {
?>
									<!-- 베스트 시작 -->
									<table width=560 border=0 cellpadding=0 cellspacing=0 align=center>
										<tr>
											<td width=560 style="border:1px solid #c0c0c0;padding:'5px 0 5px 0'" bgcolor="fafbe2">
<?
}
while($row = mysql_fetch_array($res)) {

	# 베플의 코멘트는 따로 저장해서 리스트에 나오지 않게함.
	$denyID .= " and  pollSNo != '".$row[pollNo]."' ";
	if($pg > 0) continue;
?>
											<!-- 루프 -->
											<table border=0 cellpadding=0 cellspacing=0>
												<tr>
													<td width=560><table width=100% border=0 cellpadding=0 cellspacing=0>
														<tr>
															<td width=100 align=center valign=top><img width=60 height=70  src="<?=$row[pic] ? $row[pic] : ($row_member[id] == $row[pollID] ? "/img/my_talk_img_092.jpg\" onclick=\"location.href='/odprogram/odmembers/od_modify.php'\" style='cursor:hand'" : "/img/talk_img_092.jpg");?>" style="border:1px solid #b1b1b1"></td>
															<td style="padding-left:7px;" valign=top><table width=100% border=0 cellpadding=0 cellspacing=0>
																<tr>
																	<td style="poll2_name" height=30><?=apply_talkid($row[pollID],$row[isImg])?> &nbsp; <?=icon_member($row[pollID],$row[isImg])?></td>
																	<td align=right>
																		<img src="/images/beple<?=$tmp?>.gif">&nbsp;&nbsp;
																		<a href="#none" onclick="good(<?=$row[pollNo]?>)"><img src="/img/talk_img_10.jpg" border=0></a> <span id="pollgood_<?=$row[pollNo]?>"  class=""><?=$row[pollGood]?></span> &nbsp;
																		<a href="#none" onclick="bad(<?=$row[pollNo]?>)"><img src="/img/talk_img_11.jpg" border=0></a> <span id="pollbad_<?=$row[pollNo]?>" class=""><?=$row[pollBad]?></span>
																	</td>
																</tr>
																<tr>
																	<td width=100% height=1 colspan=2 background="/img/talk_img_12.jpg"></td>
																</tr>
																<tr>
																	<td colspan=2 style="padding:5px 5px 5px 5px">
																		<?=stripslashes($row[pollContent])?> 
																		<span class="unnamed3">(<?=date('m.d H:i',strtotime($row[pollRegidate]))?>)</span> 
																		<a href="#none" onclick="<?=$row_member[id] ? "showReply('".$row[pollNo]."')" : "loginConfirm('".urlencode($_SERVER[REQUEST_URI])."')";?>"><img src="/img/talk_ico_03.jpg" border=0 align=absmiddle></a>  
																		<?
																		if($row_member[id]) {
																		?>
																		<a href="#none" onclick="replyDel(<?=$row[pollNo]?>)"><img src="/img/talk_ico_04.jpg" border=0 align=absmiddle></a>
																		<?
																		}
																		?>
																	</td>
																</tr>
															<?
															$que2 = "select * from odtPoll2 where pollProCode ='".$proCode."' and pollSNo ='".$row[pollNo]."' and isReply = '1' order by pollRegidate";
															$res2 = mysql_query($que2);
															$total2 = mysql_num_rows($res2);
															if($total2) {
															?>
																<tr style="display:none">
																	<td class="replyreply">
																	<a href="#none" onclick="reply2View('<?=$row[pollNo]?>')">댓글의댓글 <b><?=$total2?>개</b> <img id='reply_arrow_<?=$row[pollNo]?>' src="/images/ilji_31_up_.gif" border=0></a>
																	</td>
																</tr>
															<?
															}
															?>

																<!-- 댓글 입력폼 -->
																<tr>
																	<td colspan=2 style="padding:5 5 5 5"><span id="reply_<?=$row[pollNo]?>"></span></td>
																</tr>
																<!-- 댓글 입력 폼 끝 -->


															<?
															if($total2) {
															?>
															<!-- 댓글의 댓글 리스트 -->
																<tr id="viewReply_<?=$row[pollNo]?>">
																	<td colspan=2 ><table width=100% border=0 cellpadding=0 cellspacing=0>
																	<?
																	while($row2 = mysql_fetch_array($res2)) {
																	?>
																		<tr>
																			<td >
																				<table  cellpadding=0 cellspacing=0 border=0>
																					<tr>
																						<td width=12><img src="/img/talk_ico_05.jpg" border=0></td>
																						<td style="color:48688e">&nbsp;<?=apply_talkid($row2[pollID],$row2[isImg])?>&nbsp;</td>
																						<td style="line-height:200%"><?=stripslashes($row2[pollContent])?><span class="unnamed3">(<?=date('m.d H:i',strtotime($row2[pollRegidate]))?>)</span> 
																							<a href="#none" onclick="replyDel(<?=$row2[pollNo]?>)"><img src="/img/talk_ico_04.jpg" border=0 align=absmiddle></a>
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
									<table border=0 cellpadding=0 cellspacing=0>
										<tr>
											<td height=10></td>
										</tr>
									</table>


									<!-- 일반댓글 시작 -->
									<table  width=560 border=0 cellpadding=0 cellspacing=0 align=center>
										<tr>
											<td  width=560 style="padding:'5px 0 5px 0'">
<?
$que = "select a.*, b.pic from odtPoll2 as a, odtMember as b where a.pollProCode = '".$proCode."' and a.pollID = b.id and a.isReply != '1' ".$denyID." ".$dateWhere." order by a.pollSNo desc,  a.pollRegidate ";
$res = mysql_query($que);
while($row = mysql_fetch_array($res)) {
	$replyPadding = $row[isReply] ? "style='padding:0 10px 0 10px'" : NULL;
?>
											<!-- 루프 -->
											<table border=0 cellpadding=0 cellspacing=0>
												<tr>
													<td width=560><table width=100% border=0 cellpadding=0 cellspacing=0>
														<tr>
															<td width=100 align=center valign=top><img width=60 height=70  src="<?=$row[pic] ? $row[pic] : ($row_member[id] == $row[pollID] ? "/img/my_talk_img_09.jpg\" onclick=\"location.href='/odprogram/odmembers/od_modify.php'\" style='cursor:hand'" : "/img/talk_img_092.jpg");?>" style="border:1px solid #b1b1b1"></td>
															<td  style="padding-left:7px;" valign=top><table width=100% border=0 cellpadding=0 cellspacing=0>
																<tr>
																	<td style="poll2_name" height=30><?=apply_talkid($row[pollID],$row[isImg])?> &nbsp; <?=icon_member($row[pollID],$row[isImg])?></td>
																	<td align=right>
																		<a href="#none" onclick="good(<?=$row[pollNo]?>)"><img src="/img/talk_img_10.jpg" border=0></a>
																		<span  id="pollgood_<?=$row[pollNo]?>" class=""><?=$row[pollGood]?></span> &nbsp;
																		<a href="#none" onclick="bad(<?=$row[pollNo]?>)"><img src="/img/talk_img_11.jpg" border=0></a>
																		<span  id="pollbad_<?=$row[pollNo]?>" class=""><?=$row[pollBad]?></span>
																	</td>
																</tr>
																<tr>
																	<td width=100%  height=1 colspan=2 background="/img/talk_img_12.jpg"></td>
																</tr>
																<tr>
																	<td colspan=2 style="padding:5px 5px 5px 5px">
																	<?=stripslashes($row[pollContent])?> 
																	<span class="unnamed3">(<?=date('m.d H:i',strtotime($row[pollRegidate]))?>)</span>
																	<a href="#none" onclick="<?=$row_member[id] ? "showReply('".$row[pollNo]."')" : "loginConfirm('".urlencode($_SERVER[REQUEST_URI])."')";?>"><img src="/img/talk_ico_03.jpg" border=0 align=absmiddle></a>  
																	<?
																	if($row_member[id]) {
																	?>
																	<a href="#none" onclick="replyDel(<?=$row[pollNo]?>)"><img src="/img/talk_ico_04.jpg" border=0 align=absmiddle></a>
																	<?
																	}
																	?>
																	</td>
																</tr>
															<?
															$que2 = "select * from odtPoll2 where pollProCode ='".$proCode."' and pollSNo ='".$row[pollNo]."' and isReply = '1' order by pollRegidate";
															$res2 = mysql_query($que2);
															$total2 = mysql_num_rows($res2);
															if($total2) {
															?>
																<tr style="display:none">
																	<td class="replyreply">
																	<a href="#none" onclick="reply2View('<?=$row[pollNo]?>')">댓글의댓글 <b><?=$total2?>개</b> <img id='reply_arrow_<?=$row[pollNo]?>' src="/images/ilji_31_up_.gif" border=0></a>
																	</td>
																</tr>
															<?
															}
															?>

																<!-- 댓글 입력폼 -->
																<tr>
																	<td colspan=2 style="padding:5 5 5 5">
																		<span id="reply_<?=$row[pollNo]?>"></span>
																	</td>
																</tr>
																<!-- 댓글 입력 폼 끝 -->


															<?
															if($total2) {
															?>
															<!-- 댓글의 댓글 리스트 -->
																<tr id="viewReply_<?=$row[pollNo]?>">
																	<td colspan=2><table width=100% border=0 cellpadding=0 cellspacing=0>
																	<?
																	while($row2 = mysql_fetch_array($res2)) {
																	?>
																		<tr>
																			<td>
																				<table cellpadding=0 cellspacing=0 border=0>
																					<tr>
																						<td width=12><img src="/img/talk_ico_05.jpg" border=0></td>
																						<td style="color:48688e">&nbsp;<?=apply_talkid($row2[pollID],$row2[isImg])?>&nbsp;</td>
																						<td  style="line-height:200%"><?=stripslashes($row2[pollContent])?><span class="unnamed3">(<?=date('m.d H:i',strtotime($row2[pollRegidate]))?>)</span> 
																							<a href="#none" onclick="replyDel(<?=$row2[pollNo]?>)"><img src="/img/talk_ico_04.jpg" border=0 align=absmiddle></a>
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