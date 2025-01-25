<?php 
if(!defined('__GRFORUM__')) exit(); 
if(!$forum->isLogin()) $info = '아직 로그인을 하시지 않으셨습니다. 로그인을 하시거나, 혹은 회원등록을 해주세요.';
else $info = '어서오세요 <strong>' . $forum->getMemInfo('nickname') . '</strong> 님, 포럼에 오신 것을 환영합니다.';
?>

<div class="navi">
	<div class="info"><?php echo $info; ?></div>
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

<?php
// 포럼 최상단 분류들 출력 {{{
$forumList = $forum->getChild($parent);
while($list = $core->fetch($forumList)) { 
	if(!$forum->isViewable($list['uid'], $list['is_public'])) continue;
	$list = $forum->setValid($list);
	$status = $forum->getStatus($list['uid']);
?>

<div class="list">
	<div class="title"><?php echo $list['title_name']; ?></div>

	<div class="column center">
		<div class="col">포럼</div>
		<div class="data">
			<div class="article">글타래</div>
			<div class="reply">글</div>
			<div class="latest">최근 글타래</div>
			<div class="clear"></div>
		</div>
	</div>

	<?php
	// 하위 분류를 가지면서 타이틀에서 이미 출력한 경우 빼고 상단 분류들 출력 {{
	if(!$forum->hasChild($list['uid'])) { ?>
	<div class="forum">
		<div class="mark center"><img src="<?php echo $skin; ?>/images/<?php echo ($list['out_link']) ? 'out' : 'box'; ?>.gif" alt="" /></div>
		<div class="col">
			<?php echo $list['name']; ?>
			<p><?php echo $list['description']; ?></p>
		</div>
		<div class="data center">
			<div class="article"><?php echo number_format($status['post_count']); ?></div>
			<div class="reply"><?php echo number_format($status['reply_count']); ?></div>
			<div class="latest"><?php echo $status['latest']; ?></div>
			<div class="clear"></div>
		</div>
	</div>
	
	<?php
	} // }}

	// 자식 분류들 출력
	$childList = $forum->getChild($list['uid']);
	while($child = $core->fetch($childList)) { 
		if(!$forum->isViewable($child['uid'], $child['is_public'])) continue;
		$child = $forum->setValid($child);
		$status = $forum->getStatus($child['uid'], 'Y년 m월 d일 H시 i분 s초', 30);
		$postCount = number_format($status['post_count']);
		$replyCount = number_format($status['reply_count']);
		if($child['out_link']) {
			$forumIcon = 'out';
			$postCount = '';
			$replyCount = '';
			$status['latest'] = '<span onclick="location.href=\'' . $child['out_link'] . '\';">외부 링크로 이동</span>';
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
<?php
} # while }}}
?>

<!-- 회원정보 썸네일 박스 -->
<div id="viewMemberInfo" style="display: none" onmouseout="Skin.showOff();"></div>