<?php 
if(!defined('__GRFORUM__')) exit(); 

$total = $forum->getTotalStatus();
?>

<div class="navi">
	<div class="nowConn">
		<?php echo $forum->getNowConnList(); ?>
	</div>
	<div class="menu right">
		<p>총 글타래: <strong><?php echo $total['post']; ?></strong> 개, 
		총 댓글: <strong><?php echo $total['reply']; ?></strong> 개,
		총 회원: <strong><?php echo $total['member']; ?></strong> 명,
		최근 등록한 회원: <strong><?php echo $total['latest_member']; ?></strong> 님</p>
	</div>
</div>

<div class="powered center">Powered by <a href="http://sirini.net">GR Forum</a></div>

</div></div></div><!-- #forumMain / #layout / #GRFORUM -->
</body>
</html>