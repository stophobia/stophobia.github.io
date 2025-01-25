<?php if(!defined('__GRBLOG__')) exit(); ?>

<div class="normalTitle">대쉬 보드</div>

<!-- 대쉬보드 -->
<div id="all">
	
	<div id="latestVersion"></div>
	<div id="newPost"><a href="<?php echo $grblog; ?>admin.php?admin=2" title="클릭하시면 새로운 글을 작성하는 화면을 엽니다."><img src="<?php echo $grblog; ?>image/darkgray/button.write.new.post.gif" alt="새글작성" /></a></div>

	<div class="clr"></div>

	<div class="dash">
		<div class="title"><a href="<?php echo $grblog; ?>admin.php?admin=4&amp;open=0" title="클릭하시면 현재 비공개 상태의 글목록을 보실 수 있습니다.">작성중인 글목록</a></div>
		<ul>
		<?php
		$getSecretList = @mysql_query('select uid, signdate, subject from '.$dbFIX.'post where post_condition = 0 order by uid desc limit 5');
		while($secret = @mysql_fetch_array($getSecretList)) { ?>
			<li><a href="<?php echo $grblog; ?>admin.php?admin=2&amp;modifyTarget=<?php echo $secret['uid']; ?>" title="클릭하시면 마저 작성하러 갑니다."><?php echo stripslashes($secret['subject']); ?></a> 
			<span title="<?php echo date('Y-m-d H:i:s', $secret['signdate']); ?>">(<?php echo date('m.d', $secret['signdate']); ?>)</span></li>
		<?php } ?>
		</ul>
	</div>

	<div class="dash">
		<div class="title"><a href="<?php echo $grblog; ?>admin.php?admin=4&amp;open=1" title="클릭하시면 현재 공개된 글목록을 보실 수 있습니다.">공개된 글목록</a></div>
		<ul>
		<?php
		$getPublishList = @mysql_query('select uid, signdate, subject from '.$dbFIX.'post where post_condition != 0 order by uid desc limit 5');
		while($pub = @mysql_fetch_array($getPublishList)) { ?>
			<li><a href="<?php echo $grblog; ?>admin.php?admin=2&amp;modifyTarget=<?php echo $pub['uid']; ?>" title="클릭하시면 글을 수정하러 갑니다."><?php echo stripslashes($pub['subject']); ?></a> 
			<span title="<?php echo date('Y-m-d H:i:s', $pub['signdate']); ?>">(<?php echo date('m.d', $pub['signdate']); ?>)</span></li>
		<?php } ?>
		</ul>
	</div>

	<div class="dash">
		<div class="title"><a href="<?php echo $grblog; ?>admin.php?admin=5&amp;inView=textBox" title="클릭하시면 전체 댓글(코멘트) 목록을 보실 수 있습니다.">최근 댓글 목록</a></div>
		<ul>
		<?php
		$getReplyList = @mysql_query('select uid, post_uid, is_secret, signdate, content from '.$dbFIX.'comment order by uid desc limit 5');
		while($reply = @mysql_fetch_array($getReplyList)) { ?>
			<li><?php if($reply['is_secret']) echo '<span style="color: red" title="오직 관리자만 볼 수 있는 댓글입니다.">[비밀]</span> '; ?><a href="<?php echo $grblog.$reply['post_uid'].'#viewComment'.$reply['uid']; ?>" title="클릭하시면 댓글을 확인하러 갑니다."><?php echo cutString(strip_tags(stripslashes($reply['content'])), 39); ?></a> 
			<span title="<?php echo date('Y-m-d H:i:s', $reply['signdate']); ?>">(<?php echo date('m.d', $reply['signdate']); ?>)</span></li>
		<?php } ?>
		</ul>
	</div>

	<div class="clr"></div>

	<div class="dash">
		<div class="title"><a href="<?php echo $grblog; ?>admin.php?admin=19" title="클릭하시면 댓글 알리미를 확인합니다.">최근 댓글 알리미</a></div>
		<ul>
		<?php
		$getReplyNotify = @mysql_query('select uid, r2_url, r2_body, signdate from '.$dbFIX.'reply_catch order by uid desc limit 5');
		while($notify = @mysql_fetch_array($getReplyNotify)) { ?>
			<li><a href="<?php echo $notify['r2_url']; ?>" title="클릭하시면 답글을 확인하러 갑니다."><?php echo cutString(stripslashes($notify['r2_body']), 39); ?></a> 
			<span title="<?php echo date('Y-m-d H:i:s', $notify['signdate']); ?>">(<?php echo date('m.d', $notify['signdate']); ?>)</span></li>
		<?php } ?>
		</ul>
	</div>

	<div class="dash">
		<div class="title"><a href="<?php echo $grblog; ?>admin.php?admin=6&inView=textBox" title="클릭하시면 전체 트랙백(엮인글) 목록을 보실 수 있습니다.">최근 트랙백 목록</a></div>
		<ul>
		<?php
		$getTrackbackList = @mysql_query('select uid, post_uid, subject, signdate from '.$dbFIX.'trackback order by uid desc limit 5');
		while($trackback = @mysql_fetch_array($getTrackbackList)) { ?>
			<li><a href="<?php echo $grblog.$trackback['post_uid'].'#viewTrackback'.$trackback['uid']; ?>" title="클릭하시면 트랙백을 확인하러 갑니다."><?php echo stripslashes($trackback['subject']); ?></a> 
			<span title="<?php echo date('Y-m-d H:i:s', $trackback['signdate']); ?>">(<?php echo date('m.d', $trackback['signdate']); ?>)</span></li>
		<?php } ?>
		</ul>
	</div>

	<div class="dash">
		<div class="title"><a href="<?php echo $grblog; ?>admin.php?admin=18" title="클릭하시면 모노로그 설정화면으로 이동합니다.">최근 모노로그</a></div>
		<ul>
		<?php
		$getMonoList = @mysql_query('select content, signdate from '.$dbFIX.'memo_post order by uid desc limit 5');
		while($mono = @mysql_fetch_array($getMonoList)) { ?>
			<li><a href="<?php echo $grblog; ?>mono" title="클릭하시면 모노로그를 확인하러 갑니다."><?php echo cutString(stripslashes($mono['content']), 39); ?></a> 
			<span title="<?php echo date('Y-m-d H:i:s', $mono['signdate']); ?>">(<?php echo date('m.d', $mono['signdate']); ?>)</span></li>
		<?php } ?>
		</ul>
	</div>

	<div class="clr"></div>

	<div class="dash">
		<div class="title"><a href="<?php echo $grblog; ?>admin=9&amp;inView=photoBox" title="클릭하시면 포토로그 설정화면으로 이동합니다.">최근 포토로그</a></div>
		<ul>
		<?php
		$getPhotoList = @mysql_query('select uid, signdate, title from '.$dbFIX.'photo order by uid desc limit 5');
		while($photo = @mysql_fetch_array($getPhotoList)) { ?>
			<li><a href="<?php echo $grblog; ?>photo/?photoNo=<?php echo $photo['uid']; ?>" title="클릭하시면 사진을 보러 갑니다."><?php echo stripslashes($photo['title']); ?></a> 
			<span title="<?php echo date('Y-m-d H:i:s', $photo['signdate']); ?>">(<?php echo date('m.d', $photo['signdate']); ?>)</span></li>
		<?php } ?>
		</ul>
	</div>

	<div class="dash">
		<div class="title"><a href="http://sirini.net/v21/sinknet/" onclick="window.open(this.href, '_blank'); return false" title="클릭하시면 새 창으로 시리니넷 싱크넷을 열어 봅니다.">싱크넷 최근글</a></div>
		<div id="sinkLatest"></div>
	</div>

	<div class="dash">
		<div class="title"><a href="#">블로그 통계</a></div>
		<ul>
		<?php
		$getTotalOpenPost = @mysql_fetch_array(mysql_query('select count(*) from '.$dbFIX.'post where post_condition != 0'));
		$getTotalSecretPost = @mysql_fetch_array(mysql_query('select count(*) from '.$dbFIX.'post where post_condition = 0'));
		$getTotalTrackback = @mysql_fetch_array(mysql_query('select count(*) from '.$dbFIX.'trackback'));
		$getTotalOpenReply = @mysql_fetch_array(mysql_query('select count(*) from '.$dbFIX.'comment where is_secret = 0'));
		$getTotalSecretReply = @mysql_fetch_array(mysql_query('select count(*) from '.$dbFIX.'comment where is_secret = 1'));
		$getTotalPhoto = @mysql_fetch_array(mysql_query('select count(*) from '.$dbFIX.'photo'));
		$getTotalPhotoReply = @mysql_fetch_array(mysql_query('select count(*) from '.$dbFIX.'photo_comment'));
		$getTotalMono = @mysql_fetch_array(mysql_query('select count(*) from '.$dbFIX.'memo_post'));
		$getTotalReplyNotify = @mysql_fetch_array(mysql_query('select count(*) from '.$dbFIX.'reply_catch'));
		$getTotalTag = @mysql_fetch_array(mysql_query('select count(*) from '.$dbFIX.'tag'));
		?>
			<li>공개글: <?php echo $getTotalOpenPost[0]; ?>개 &nbsp;/&nbsp; 비공개글: <?php echo $getTotalSecretPost[0]; ?>개</li>
			<li>트랙백: <?php echo $getTotalTrackback[0]; ?>개 &nbsp;/&nbsp; 댓글알리미: <?php echo $getTotalReplyNotify[0]; ?>개</li>
			<li>공개 댓글: <?php echo $getTotalOpenReply[0]; ?>개 &nbsp;/&nbsp; 비밀 댓글: <?php echo $getTotalSecretReply[0]; ?>개</li>
			<li>포토로그: <?php echo $getTotalPhoto[0]; ?>개 &nbsp;/&nbsp; 포토 댓글: <?php echo $getTotalPhotoReply[0]; ?>개</li>
			<li>모노로그: <?php echo $getTotalMono[0]; ?>개 &nbsp;/&nbsp; 태그수: <?php echo $getTotalTag[0]; ?>개</li>
		</ul>
	</div>

	<div class="clr"></div>

	<div class="dash">
		<div class="title"><a href="<?php echo $grblog; ?>guestbook" title="클릭하시면 방명록으로 이동합니다.">최근 방명록 목록</a></div>
		<ul>
		<?php
		$getGuestbookList = @mysql_query('select uid, content, signdate from '.$dbFIX.'guestbook order by uid desc limit 5');
		while($guestbook = @mysql_fetch_array($getGuestbookList)) { ?>
			<li><a href="<?php echo $grblog.'guestbook/#guest'.$guestbook['uid']; ?>" title="클릭하시면 방명록 글을 확인하러 갑니다."><?php echo cutString(stripslashes($guestbook['content']), 39); ?></a> 
			<span title="<?php echo date('Y-m-d H:i:s', $guestbook['signdate']); ?>">(<?php echo date('m.d', $guestbook['signdate']); ?>)</span></li>
		<?php } ?>
		</ul>
	</div>

	<div class="clr"></div>

</div>
<!--# 대쉬보드 -->