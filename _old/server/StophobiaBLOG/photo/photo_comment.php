<div id="comments"><img src="./image/title_comment.gif" alt="Talk About Photo" /></div>
<div id="commentList">
<?php
// 이 사진에 달린 코멘트 뿌려주기
$getComment = @mysql_query('select * from '.$dbFIX.'photo_comment where photo_uid = '.$nowPhoto['uid'].' order by uid asc');
while($co = mysql_fetch_array($getComment)) {
	if($co['homepage']) $co['name'] = '<a href="'.$co['homepage'].'" onclick="window.open(this.href, \'_blank\'); return false;">'.$co['name'].'</a>';
	elseif($co['email']) $co['name'] = '<a href="mailto:'.$co['email'].'">'.$co['name'].'</a>';
	$co['comment'] = nl2br(stripslashes($co['comment']));
?>
	<div class="name"><?php echo $co['name']; ?><br /><span>(<?php echo date('Y.m.d', $co['signdate']);
	if($_SESSION['no']) echo ' / <a href="#" onclick="deleteComment('.$nowPhoto['uid'].', '.$co['uid'].');" title="이 코멘트를 사진첩에서 삭제 합니다.">delete</a>'; 
	else echo ' / <span onclick="deleteUserComment('.(($deleteCoUid)?$deleteCoUid:0).', '.$co['uid'].', '.$nowPhoto['uid'].', event);" style="cursor: pointer; '.
		(($deleteCoUid==$co['uid'])?'font-weight: bold; color: #000':'').'" title="이 코멘트를 사진첩에서 삭제 합니다.">DELETE</span>'; ?>)</span></div>
	<div class="memo"><?php echo $co['comment']; ?></div>
	<div class="clr"></div>
<?php } ?>
</div>
<!-- 코멘트 작성폼 -->
<form id="comment" method="post" onsubmit="return checkValue(<?php echo ($_SESSION['no'])?1:0; ?>);" action="<?php echo $_SERVER['PHP_SELF']; ?>">
<div><input type="hidden" name="submitOK" value="1" /><input type="hidden" name="photoUid" value="<?php echo $nowPhoto['uid']; ?>" /></div>
<div id="inputComment">
	<?php if(!$_SESSION['no']) { ?>
	<div><input type="text" name="antispam" class="t" title="우측에 제시된 산수문제의 답을 적어주세요 (필수)" /> answer the question (<strong><span style="color: #000"><?php echo $antiSpam0.' '.$antiSpam3.' '.$antiSpam1; ?> = ?</span></strong>, required)</div>
	<div><input type="text" name="name" class="t" title="이름을 입력해 주세요 (필수)" /> name (required)</div>
	<div><input type="password" name="password" class="t" title="비밀번호를 입력해 주세요 (필수)" /> password (required)</div>
	<div><input type="text" name="email" class="t" title="이메일 주소를 입력해 주세요" /> email</div>
	<div><input type="text" name="homepage" class="t" title="홈페이지(블로그) 주소를 입력해 주세요" /> homepage</div>
	<?php } ?>
	<div><textarea name="content" rows="10" cols="100">댓글을 입력해 주세요~</textarea></div>
	<div class="c"><input type="submit" class="s" value="댓글 작성을 완료 합니다" /></div>
</div>
</form>