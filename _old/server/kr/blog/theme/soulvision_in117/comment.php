<?php
// 댓글 처리
if($co['is_secret'] && !$_SESSION['no']) $co['content'] = '<span style="color: red">비밀 댓글 입니다.</span>';
if($co['homepage']) $name = '<a href="'.$co['homepage'].'" title="'.$name.' 님의 웹사이트(블로그)를 방문 합니다">'.$name.'</a>';
$co['reply'] = ($co['is_reply']) ? 'response' : '';
?>
   <li id="comment-<?php echo $co['uid']; ?>">
	<span id="viewComment<?php echo $co['uid']; ?>"></span>
        
        <p class="meta">
			<a href="#" onclick="checkCoPass('<?php echo $co['uid']; ?>');">DELETE</a>
			<?php if(!$co['is_reply']) { ?><a href="<?php echo 'http://'.$_SERVER['HTTP_HOST'].$grblog.$theme; ?>/reply_new_window.php?p=<?php echo $gb['uid']; ?>&amp;replyTo=<?php echo $co['uid']; ?>&amp;writer=<?php echo urlencode($co['name']); ?>&amp;page=<?php echo $page; ?>" onclick="window.open(this.href, '_blank', 'width=700,height=450,menubar=no,scrollbars=no'); return false"><strong>REPLY*</strong></a><?php } ?>		
		</p>
		
		<div class="commenttext <?php echo $co['reply']; ?>">
			<img src="http://www.gravatar.com/avatar.php?gravatar_id=<?php echo md5($co['email']).'&amp;default=http://'.urlencode($_SERVER['HTTP_HOST'].$grblog.$theme.'/images/gravatar.png'); ?>&amp;size=50" alt="gravatar" class="g" />		
			
			<?php echo $co['content']; ?>

			<div class="clearer"></div>
		</div>
	    
		<!-- 댓글 삭제시 비밀번호 받는 부분 -->
		<form id="enterCoPass<?php echo $co['uid']; ?>" method="post" onsubmit="return isValidPass(this);" action="<?php echo $_SERVER['PHP_SELF']; ?>">
		<div><input type="hidden" name="deleteCoUid" value="<?php echo $co['uid']; ?>" /><input type="hidden" name="p" value="<?php echo $gb['uid']; ?>" /></div>
		<div id="enterPass<?php echo $co['uid']; ?>" class="enterPass" style="display: none">
			<div>비밀번호: <input type="password" class="i" name="coPass" /><input type="submit" value="확인" class="s" /></div>
		</div>
		</form>	
		
	</li>