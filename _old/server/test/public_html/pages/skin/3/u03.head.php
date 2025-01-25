<?
echo "
<a href='/odprogram/odmembers/od_modify.php' class='tt_link'>"; if (ereg("od_modify.php",$_SERVER[PHP_SELF])) { echo "<span class='tt_hot'>회원정보수정</span>"; } else { echo "회원정보수정"; } echo "</a> &nbsp;<span class='tt_space'>|</span>&nbsp; 
<a href='/?Pid=u03b02' class='tt_link'>"; if ("u03b02" == $Pid) { echo "<span class='tt_hot'>참여점수</span>"; } else { echo "참여점수"; } echo "</a> &nbsp;<span class='tt_space'>|</span>&nbsp; 
<a href='/odprogram/odproducts/od_ordersearchresult.php' class='tt_link'>"; if (ereg("od_ordersearchresult.php",$_SERVER[PHP_SELF])) { echo "<span class='tt_hot'>주문내역</span>"; } else { echo "주문내역"; } echo "</a> &nbsp;<span class='tt_space'>|</span>&nbsp; 
<a href='/?Pid=u03b04' class='tt_link'>"; if ("u03b04" == $Pid) { echo "<span class='tt_hot'>포인트 적립내역</span>"; } else { echo "포인트 적립내역"; } echo "</a> &nbsp;<span class='tt_space'>|</span>&nbsp; 
<a href='/?Pid=u03b05' class='tt_link'>"; if ("u03b05" == $Pid) { echo "<span class='tt_hot'>MY쿠폰함</span>"; } else { echo "MY쿠폰함"; } echo "</a> &nbsp;<span class='tt_space'>|</span>&nbsp; 
<a href='/?Pid=u03b06' class='tt_link'>"; if ("u03b06" == $Pid) { echo "<span class='tt_hot'>1:1상담내역</span>"; } else { echo "1:1상담내역"; } echo "</a> &nbsp;<span class='tt_space'>|</span>&nbsp; 
<a href='/?Pid=u03b07' class='tt_link'>"; if ("u03b07" == $Pid) { echo "<span class='tt_hot'>나의글모음</span>"; } else { echo "나의글모음"; } echo "</a> &nbsp;<span class='tt_space'>|</span>&nbsp; 
<a href='/?Pid=u03b08' class='tt_link'>"; if ("u03b08" == $Pid) { echo "<span class='tt_hot'>회원탈퇴</span>"; } else { echo "회원탈퇴"; } echo "</a>";


?>