<?php
// 댓글 처리
if($co['is_secret'] && !$_SESSION['no']) $co['content'] = '<span style="color: red">비밀 댓글 입니다.</span>';
if($co['homepage']) $name = '<a href="'.$co['homepage'].'" title="'.$name.' 님의 웹사이트(블로그)를 방문 합니다">'.$name.'</a>';
$co['reply'] = ($co['is_reply']) ? '_response' : '';
?>

<li class="ComListLi<?php echo $co['reply']; ?>" id="viewComment<?php echo $co['uid']; ?>">
	<div class="ComListLiTop<?php echo $co['reply']; ?>"></div>

 <span class="ListGrav">
 <img src="http://www.gravatar.com/avatar.php?gravatar_id=<?php echo md5($co['email']).'&amp;default=http://'.urlencode($_SERVER['HTTP_HOST'].$grblog.$theme.'/images/gravatar.png'); ?>&amp;size=25" alt="gravatar" />
 </span>

 <big><?php echo $name; ?></big>
 <small><a href="#comment-<?php echo $co['uid']; ?>">
	<?php echo date('r', $co['signdate']); 
	echo ($_SESSION['no']==1)?' <a href="'.$grblog.'admin.php?admin=5">[edit]</a>':''; ?> </a>
	<a href="#" onclick="checkCoPass('<?php echo $co['uid']; ?>');">[delete]</a>
	<?php if(!$co['is_reply']) { ?><a href="<?php echo 'http://'.$_SERVER['HTTP_HOST'].$grblog.$theme; ?>/reply_new_window.php?p=<?php echo $gb['uid']; ?>&amp;replyTo=<?php echo $co['uid']; ?>&amp;writer=<?php echo urlencode($co['name']); ?>&amp;page=<?php echo $page; ?>" onclick="window.open(this.href, '_blank', 'width=700,height=450,menubar=no,scrollbars=no'); return false"><strong>[reply]</strong></a><?php } ?>
</small>

 <span class="ListNr"><?php $commentNumber++; echo $commentNumber; ?></span>
 <span class="ListContent"><?php echo $co['content']; ?>
 </span>

	<!-- 댓글 삭제시 비밀번호 받는 부분 -->
	<form id="enterCoPass<?php echo $co['uid']; ?>" method="post" onsubmit="return isValidPass(this);" action="<?php echo $_SERVER['PHP_SELF']; ?>">
	<div><input type="hidden" name="deleteCoUid" value="<?php echo $co['uid']; ?>" /><input type="hidden" name="p" value="<?php echo $gb['uid']; ?>" /></div>
	<div id="enterPass<?php echo $co['uid']; ?>" class="enterPass" style="display: none">
		<div>비밀번호: <input type="password" class="i" name="coPass" /><input type="submit" value="확인" class="s" /></div>
	</div>
	</form>

</li>