<?php
if(!defined('__GRFORUM__')) exit(); 

// 부모 분류 정보 가져오기
$list = $forum->getParent($parent);
$path = $forum->getPath($parent);
?>

<div class="navi">
	<div class="info">
		<?php echo $path; ?>
	</div>
	<div class="menu right">
	<ul>
		<?php if(!$forum->isLogin()) { ?>
		<li><a href="./login/">로그인</a></li>
		<li><a href="./register/">회원등록</a></li>
		
		<?php } /* ← 로그인 전 */ else { /* 로그인 후 ↓ */ ?>
		<li><a href="<?php echo $grboard; ?>/view_memo.php" onclick="window.open(this.href, 'viewMemo', 'width=550,height=600,menubar=no,scrollbar=yes'); return false">쪽지함</a></li>
		<li><a href="./myinfo/">정보수정</a></li>
		<li><a href="./logout/">로그아웃</a></li>
		<?php } /* ← 로그인 후 */
		
		// 관리자일 경우
		if($forum->isAdmin()) { ?>
		<li><a href="./admin/">관리화면</a></li>
		<?php } ?>

		<li><a href="./search/">통합검색</a></li>
	</ul>
	</div>
</div>

<div class="list">
	<div class="title"><?php echo $list['name']; ?></div>

	<div class="column center">
		<div class="col">포럼</div>
		<div class="data">
			<div class="article">글타래</div>
			<div class="reply">글</div>
			<div class="latest">최근 글</div>
			<div class="clear"></div>
		</div>
	</div>

	<?php
	// 자식 분류들 출력
	$childList = $forum->getChild($list['uid']);
	while($child = $core->fetch($childList)) { 
		if(!$forum->isViewable($child['uid'], $child['is_public'])) continue;
		$child = $forum->setValid($child);
		$status = $forum->getStatus($child['uid']);
		$postCount = number_format($status['post_count']);
		$replyCount = number_format($status['reply_count']);
		if($child['out_link']) {
			$forumIcon = 'out';
			$postCount = '';
			$replyCount = '';
			$status['latest'] = '외부 링크로 이동';
		}
		elseif($child['bbs_id']) $forumIcon = 'bbs';
		else $forumIcon = 'box';
	?>

		<div class="forum">
			<div class="mark center"><img src="<?php echo $skin; ?>/images/<?php echo $forumIcon; ?>.gif" alt="" /></div>
			<div class="col">
				<?php echo $child['name']; ?>
				<p><?php echo $child['description']; ?></p>
			</div>
			<div class="data center">
				<div class="article"><?php echo $postCount; ?></div>
				<div class="reply"><?php echo $replyCount; ?></div>
				<div class="latest"><?php echo $status['latest']; ?></div>
				<div class="clear"></div>
			</div>
		</div>

	<?php
	} # while
	?>

</div>