<div class="list">
	<div class="title">
		<?php if($day == date('d', $memo['signdate'])) { ?>
			<div class="space"></div>
		<?php } else { $day = date('d', $memo['signdate']); ?>			
			<div class="miniCal"><div class="top"><?php echo date('M', $memo['signdate']); ?></div><div class="day"><?php echo date('j', $memo['signdate']); ?></div></div>
		<?php } ?>
		<div class="titleBox"><?php echo stripslashes($memo['content']); ?><br />
			<span><?php echo date('a g:i', $memo['signdate']); ?> (by <?php echo $memo['name']; ?>)</span>
			<a href="javascript:;" onclick="if($('comment<?php echo $memo['uid']; ?>').style.display=='')Effect.Fade('comment<?php echo $memo['uid']; ?>'); else Effect.Appear('comment<?php echo $memo['uid']; ?>');" title="이 글에 여러분의 생각을 댓글로 달아봅니다.">comments (<?php echo $memo['comment_num']; ?>)</a>
			<?php if($_SESSION['no'] || ($_SESSION['user_no'] && ($_SESSION['user_no'] == $memo['member_key']))) { ?> &nbsp;<a href="./?deletePost=<?php echo $memo['uid']; ?>" title="클릭하시면 이 글을 삭제합니다!" style="color: #ddd">delete</a><?php } ?>
		</div>
		<div class="clr"></div>
	</div>
</div>