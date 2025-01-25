<?
####################################################
## 상품토크
####################################################
function myPostFun1($id) {
	$que = "select * from odtTt where ttID = '".$id."' and ttIsReply != '1' order by ttRegidate desc";
	$res = mysql_query($que);
	if(!mysql_num_rows($res)) {
?>
     <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="100%" height="32" align=center>등록된 글이 없습니다.</td>
				</tr>
			</table>


<?
	}
	while($row = mysql_fetch_array($res)) {
		$img = @mysql_result(mysql_query("select order_img from odtProduct where code ='".$row[ttProCode]."'"),0);
?>
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="744" height="32"><table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td width="140" height="44" align=center>상품토크</td>
                <td ><?=$row[ttContent]?> <span class="poll2_date">(<?=date('m.d H:i',strtotime($row[ttRegidate]))?>)</span></td>
                <td width="100" align=center>
								<?= $img ? "<img src='".$img."' width=81 height=38 align=absmiddle>" : NULL;?>
								</td>
                <td width="100" align=center><?=$row[ttGood]?></td>
              </tr>
          </table>
		<?
			$que2 = "select * from odtTt where ttIsReply = '1' and ttSNO = '".$row[ttNo]."'";
			$res2 = mysql_query($que2);
			$total2 = mysql_num_rows($res2);
			if($total2) {
		?>
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td width="140" valign="top">&nbsp;</td>
                <td valign="top">
<!--
                  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td><span class="style1">댓글의 댓글</span> <span class="style3"><?=$total2?>개</span> <img src="/images/mapage_img_48.jpg" width="13" height="11"></td>
                    </tr>
                  </table>
                  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td height="3"></td>
                    </tr>
                  </table>
-->
									<!-- 루프 -->
						<?
							while($row2 = mysql_fetch_array($res2)) {
						?>
                  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="16" height="22"><img src="/images/mapage_img_49.jpg" width="14" height="11"></td>
                      <td><span class="style4"><?=apply_talkid($row2[ttID],$row2[isImg])?> </span><?=$row2[ttContent]?> <span class="poll2_date">(<?=date('m.d H:i',strtotime($row2[ttRegidate]))?>)</span> </td>
                      <td></td>
                    </tr>
                  </table>
						<?
						}
						?>
									<!-- 루프 -->
								</td>
                <td>&nbsp;</td>
              </tr>
            </table>
			<?
			}
			?>
						
						</td>
        </tr>
      </table>
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td height=5></td>
				</tr>
				<tr>
          <td width="744" height="1" bgcolor="#d6d6d6"></td>
        </tr>
      </table>
		
<?
			} // end while
}


####################################################
## 상품후기
####################################################
function myPostFun2($id) {
	$que = "select * from odtAfterTalk where afterID = '".$id."' and afterIsReply != '1' order by afterRegidate desc";
	$res = mysql_query($que);
	if(!mysql_num_rows($res)) {
?>
     <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="100%" height="32" align=center>등록된 글이 없습니다.</td>
				</tr>
			</table>


<?
	}
	while($row = mysql_fetch_array($res)) {
		$img = mysql_result(mysql_query("select order_img from odtProduct where code ='".$row[afterProCode]."'"),0);
?>
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="744" height="32"><table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td width="140" height="44" align=center>상품후기</td>
                <td ><?=$row[afterContent]?> <span class="poll2_date">(<?=date('m.d H:i',strtotime($row[afterRegidate]))?>)</span></td>
                <td width="100" align=center>
								<?= $img ? "<img src='".$img."' width=81 height=38>" : NULL;?>
								</td>
                <td width="100" align=center><?=$row[afterGood]?></td>
              </tr>
          </table>
		<?
			$que2 = "select * from odtAfterTalk where afterIsReply = '1' and afterSNO = '".$row[afterNo]."'";
			$res2 = mysql_query($que2);
			$total2 = mysql_num_rows($res2);
			if($total2) {
		?>
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td width="140" valign="top">&nbsp;</td>
                <td valign="top">
<!--
                  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td><span class="style1">댓글의 댓글</span> <span class="style3"><?=$total2?>개</span> <img src="/images/mapage_img_48.jpg" width="13" height="11"></td>
                    </tr>
                  </table>
                  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td height="3"></td>
                    </tr>
                  </table>
-->
									<!-- 루프 -->
						<?
							while($row2 = mysql_fetch_array($res2)) {
						?>
                  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="16" height="22"><img src="/images/mapage_img_49.jpg" width="14" height="11"></td>
                      <td><span class="style4"><?=apply_talkid($row2[afterID],$row2[isImg])?> </span><?=$row2[afterContent]?> <span class="poll2_date">(<?=date('m.d H:i',strtotime($row2[afterRegidate]))?>) </span></td>
                      <td></td>
                    </tr>
                  </table>
						<?
						}
						?>
									<!-- 루프 -->
								</td>
                <td>&nbsp;</td>
              </tr>
            </table>
			<?
			}
			?>
						
						</td>
        </tr>
      </table>
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td height=5></td>
				</tr>
        <tr>
          <td width="744" height="1" bgcolor="#d6d6d6"></td>
        </tr>
      </table>
		
<?
			} // end while
}



####################################################
## 내가희망하는방송
####################################################
function myPostFun3($id) {
	$que = "select * from odtPoll2 where pollID = '".$id."' and isReply != '1' order by pollRegidate desc";
	$res = mysql_query($que);
	if(!mysql_num_rows($res)) {
?>
     <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="100%" height="32" align=center>등록된 글이 없습니다.</td>
				</tr>
			</table>


<?
	}
	while($row = mysql_fetch_array($res)) {
?>
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="744" height="32"><table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td width="140" height="44" align=center>내가희망하는방송</td>
                <td ><?=$row[pollContent]?> <span class="poll2_date">(<?=date('m.d H:i',strtotime($row[pollRegidate]))?>)</span></td>
                <td width="100" align=center>-</td>
                <td width="100" align=center><?=$row[pollGood]?></td>
              </tr>
          </table>
		<?
			$que2 = "select * from odtPoll2 where isReply = '1' and pollSNo = '".$row[pollNo]."'";
			$res2 = mysql_query($que2);
			$total2 = mysql_num_rows($res2);
			if($total2) {
		?>
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td width="140" valign="top">&nbsp;</td>
                <td valign="top">
<!--
                  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td><span class="style1">댓글의 댓글</span> <span class="style3"><?=$total2?>개</span> <img src="/images/mapage_img_48.jpg" width="13" height="11"></td>
                    </tr>
                  </table>
                  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td height="3"></td>
                    </tr>
                  </table>
-->
									<!-- 루프 -->
						<?
							while($row2 = mysql_fetch_array($res2)) {
						?>
                  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="16" height="22"><img src="/images/mapage_img_49.jpg" width="14" height="11"></td>
                      <td><span class="style4"><?=apply_talkid($row2[pollID],$row2[isImg])?> </span><?=$row2[pollContent]?> <span class="poll2_date">(<?=date('m.d H:i',strtotime($row2[pollRegidate]))?>) </span></td>
                      <td></td>
                    </tr>
                  </table>
						<?
						}
						?>
									<!-- 루프 -->
								</td>
                <td>&nbsp;</td>
              </tr>
            </table>
			<?
			}
			?>
						
						</td>
        </tr>
      </table>
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td height=5></td>
				</tr>
        <tr>
          <td width="744" height="1" bgcolor="#d6d6d6"></td>
        </tr>
      </table>
		
<?
			} // end while
}



####################################################
## 참여이벤트
####################################################
function myPostFun4($id) {
	$que = "select * from odtEventCmt where eCmtID = '".$id."' and eCmtIsReply != '1' order by eCmtRegidate desc";
	$res = mysql_query($que);
	if(!mysql_num_rows($res)) {
?>
     <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="100%" height="32" align=center>등록된 글이 없습니다.</td>
				</tr>
			</table>


<?
	}
	while($row = mysql_fetch_array($res)) {
?>
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="744" height="32"><table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td width="140" height="44" align=center>참여이벤트</td>
                <td ><?=$row[eCmtContent]?> <span class="poll2_date">(<?=date('m.d H:i',strtotime($row[eCmtRegidate]))?>)</span></td>
                <td width="100" align=center>-</td>
                <td width="100" align=center>-</td>
              </tr>
          </table>
		<?
			$que2 = "select * from odtEventCmt where eCmtIsReply = '1' and eCmtSNo = '".$row[eCmtNo]."'";
			$res2 = mysql_query($que2);
			$total2 = mysql_num_rows($res2);
			if($total2) {
		?>
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td width="140" valign="top">&nbsp;</td>
                <td valign="top">
<!--
                  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td><span class="style1">댓글의 댓글</span> <span class="style3"><?=$total2?>개</span> <img src="/images/mapage_img_48.jpg" width="13" height="11"></td>
                    </tr>
                  </table>
                  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td height="3"></td>
                    </tr>
                  </table>
-->
									<!-- 루프 -->
						<?
							while($row2 = mysql_fetch_array($res2)) {
						?>
                  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="16" height="22"><img src="/images/mapage_img_49.jpg" width="14" height="11"></td>
                      <td><span class="style4"><?=apply_talkid($row2[eCmtID],$row2[isImg])?> </span><?=$row2[eCmtContent]?> <span class="poll2_date">(<?=date('m.d H:i',strtotime($row2[eCmtRegidate]))?>)</span> </td>
                      <td></td>
                    </tr>
                  </table>
						<?
						}
						?>
									<!-- 루프 -->
								</td>
                <td>&nbsp;</td>
              </tr>
            </table>
			<?
			}
			?>
						
						</td>
        </tr>
      </table>
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td height=5></td>
				</tr>
        <tr>
          <td width="744" height="1" bgcolor="#d6d6d6"></td>
        </tr>
      </table>
		
<?
			} // end while
}
####################################################
## 상품토크
####################################################
function myPostFun5($id) {
	$que = "select * from odtIljiCmt where iCmtID = '".$id."' and iCmtIsReply != '1' order by iCmtRegidate desc";
	$res = mysql_query($que);
	if(!mysql_num_rows($res)) {
?>
     <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="100%" height="32" align=center>등록된 글이 없습니다.</td>
				</tr>
			</table>


<?
	}
	while($row = mysql_fetch_array($res)) {
?>
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="744" height="32"><table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td width="140" height="44" align=center>운영일지</td>
                <td ><?=$row[iCmtContent]?> <span class="poll2_date">(<?=date('m.d H:i',strtotime($row[iCmtRegidate]))?>)</span></td>
                <td width="100" align=center>-</td>
                <td width="100" align=center>-</td>
              </tr>
          </table>
		<?
			$que2 = "select * from odtIljiCmt where iCmtIsReply = '1' and iCmtSNo = '".$row[iCmtNo]."'";
			$res2 = mysql_query($que2);
			$total2 = mysql_num_rows($res2);
			if($total2) {
		?>
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td width="140" valign="top">&nbsp;</td>
                <td valign="top">
<!--
                  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td><span class="style1">댓글의 댓글</span> <span class="style3"><?=$total2?>개</span> <img src="/images/mapage_img_48.jpg" width="13" height="11"></td>
                    </tr>
                  </table>
                  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td height="3"></td>
                    </tr>
                  </table>
-->
									<!-- 루프 -->
						<?
							while($row2 = mysql_fetch_array($res2)) {
						?>
                  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="16" height="22"><img src="/images/mapage_img_49.jpg" width="14" height="11"></td>
                      <td><span class="style4"><?=apply_talkid($row2[iCmtID],$row2[isImg])?> </span><?=$row2[iCmtContent]?> <span class="poll2_date">(<?=date('m.d H:i',strtotime($row2[iCmtRegidate]))?>)</span> </td>
                      <td></td>
                    </tr>
                  </table>
						<?
						}
						?>
									<!-- 루프 -->
								</td>
                <td>&nbsp;</td>
              </tr>
            </table>
			<?
			}
			?>
						
						</td>
        </tr>
      </table>
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td height=5></td>
				</tr>
        <tr>
          <td width="744" height="1" bgcolor="#d6d6d6"></td>
        </tr>
      </table>
		
<?
			} // end while
}

?>