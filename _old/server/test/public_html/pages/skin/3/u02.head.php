<?

echo "
<a href='/?Pid=u02b01'                  class='tt_link'>"; if ("u02b01" == $Pid) { echo "<span class='tt_hot'>자주 묻는 질문</span>"; } else { echo "자주 묻는 질문"; } echo "</a> &nbsp;<span class='tt_space'>|</span>&nbsp; 
<a href='/?Pid=u02b02'                  class='tt_link'>"; if ("u02b02" == $Pid) { echo "<span class='tt_hot'>1:1 문의하기</span>"; } else { echo "1:1 문의하기"; } echo "</a> &nbsp;<span class='tt_space'>|</span>&nbsp; 
<a href='/odprogram/odboard/od_board.php?board=1' class='tt_link'>"; if ("1" == $board) { echo "<span class='tt_hot'>공지사항</span>"; } else { echo "공지사항"; } echo "</a> &nbsp;<span class='tt_space'>|</span>&nbsp; 
<a href='/odprogram/odboard/od_board.php?board=2' class='tt_link'>"; if ("2" == $board) { echo "<span class='tt_hot'>이벤트</span>"; } else { echo "이벤트"; } echo "</a> &nbsp;<span class='tt_space'>|</span>&nbsp; 
<a href='/rss/rss.php'                  class='tt_link'>RSS 피드</a>";


?>