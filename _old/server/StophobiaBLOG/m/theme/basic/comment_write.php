<form id="leaveComment" method="post" onsubmit="return leaveCommentOk(this);" action="<?php echo $_SERVER['PHP_SELF']; ?>">
<div class="commentWrite">
	<div>
		<input type="hidden" name="simpleGRBlogKey" value="<?php echo md5('GRBlog'.$_SERVER['HTTP_HOST'].date('YmdH')); ?>" />
		<input type="hidden" name="post_uid" value="<?php echo $p; ?>" />
		<input type="hidden" name="page" value="<?php echo $page; ?>" />
	</div>
	<div><textarea name="content" rows="3" class="i"></textarea></div>
	<div class="gray">블로그: <input type="text" name="homepage" class="i" value="http://" /></div>
	<div>닉네임: <input type="text" name="name" class="i" /></div>
	<div><input type="checkbox" name="is_secret" value="1" /> 비밀글이면 체크해주세요!</div>
	<div class="gray box">※ 알림: 이 곳에서 남긴 댓글은 본인이 삭제할 수 없습니다. 차후 삭제를 원하시면 관리자에게 문의해 주세요! <strong>댓글 고맙습니다! ^^</strong></div>
	<div class="right"><input type="image" src="<?php echo $theme; ?>/leave_msg.gif" /></div>
</div>
</form>