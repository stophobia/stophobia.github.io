						<table border=0 cellpadding=0 cellspacing=0 height=100%>
							<tr>
								
    <td><a href="/?Pid=u01b01"><img src="/images/event_15.gif" border="0"></a></td>
							</tr>
							<tr>
								
    <td><a href="/?Pid=u01b02"><img src="/images/ilji_05.gif" border="0"></a></td>
							</tr>
							<tr>
								
    <td><a href="/odprogram/odboard/od_board.php?board=1&page=1&field=&value="><img src="/images/event_26.gif" border="0"></a></td>
							</tr>
							<tr>
								<td height=198 background="/images/event_28.gif" style="padding-top:18px" valign=top height=100%><table border=0 cellpadding=0 cellspacing=0 height=100%>
									<!-- 루프 -->
<?
$i=0;
$que2 = "select * from odtBoard where boardkind='1' order by wdate desc limit 6";
$res2 = mysql_query($que2);
while($row2 = mysql_fetch_array($res2)) {
?>
									<tr>
										<td width="12"></td>
										<td width="6"><img src="/images/ico_arrow.gif"></td>
										<td height="24" class="main_notice"><a href="/odprogram/odboard/odboardcount.php?board=1&page=1&serialnum=<?=$row2[serialnum]?>"><font color="<?=$i++ < 2 ? "#FF6600" : NULL;?>">[공지] <?=cut_str_short($row2[title],11,'..')?></font></a></td>
									</tr>
									<tr>
										<td height=1 width=180 colspan=3 background="/images/event_30.gif"></td>
									</tr>
<?
}
?>
									<tr>
										<td height=28px></td>
									<tr>
									<!-- 루프 -->
								</table></td>
							</tr>
							<tr>
								<td><img src="/images/event_32.gif"></td>
							
							<tr>
								<td><a href="/?Pid=u02b02"><img src="/images/event_34.gif" border=0></a></td>
							</tr>
							<tr>
								<td height=100% background="/images/event_28.gif"></td>
							</tr>
						</table>