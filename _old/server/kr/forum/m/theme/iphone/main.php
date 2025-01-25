<?php 
if(!defined('__GRFORUM__')) exit(); 

// 서브 페이지시 상단 제목 가져오기
if($parent) $papa = $forum->getParent($parent);
?>
<body>
	
	<!-- 상단 툴바 -->
    <div id="topToolbar" class="toolbar">
        <h1 id="pageTitle"><?php echo $setting['forum_title']; ?></h1>
        <a id="backButton" class="button" href="#">처음</a>
        <a class="button" href="./">처음</a>
    </div>

	<!-- 첫 메인 목록 -->
    <ul id="grforum_mobile" title="<?php echo $papa['name']; ?>" selected="true">
		
		<li class="group"><span onclick="location.href='./'">처음 화면</span><?php if($parent) { ?> 》<span><?php echo $papa['name']; ?></span><?php } ?></li>

	<?php
	// 포럼 분류들 출력
	$forumList = $forum->getChild($parent);
	while($list = $core->fetch($forumList)) { 
		if(!$forum->isViewable($list['uid'], $list['is_public'])) continue;
		$list['name'] = stripslashes($list['name']);
		if($list['bbs_id']) $href = 'bbs.php?id=' . $list['bbs_id'];
		elseif($list['out_link']) $href = '#" onclick="location.href=\''.$list['out_link'].'\'';
		else $href = './?parent=' . $list['uid'];
		?>
			<li><a href="<?php echo $href; ?>"><?php echo $list['name']; ?></a></li>
		<?php
	} // while
	?>
	</ul>