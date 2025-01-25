<?php 
if(!defined('__GRFORUM__')) exit(); 
$bbsInfo['name'] = stripslashes($bbsInfo['name']);
$papa['name'] = stripslashes($papa['name']);
?>

<!-- 상단 툴바 -->
<div id="topToolbar" class="toolbar">
    <h1 id="pageTitle"><?php echo $setting['forum_title']; ?></h1>
    <a id="backButton" class="button" href="#">처음</a>
    <a class="button" href="./">처음</a>
</div>

<ul id="grforum_mobile" title="<?php echo $bbsInfo['name']; ?>" selected="true">
	<li class="group"><span onclick="location.href='./?parent=<?php echo $bbsInfo['parent']; ?>'"><?php echo $papa['name']; ?></span> 》<span onclick="location.href='bbs.php?id=<?php echo $id; ?>'"><?php echo $bbsInfo['name']; ?></span></li>
	<?php 
	while($post = $core->fetch($list)) {
	?>
	<li><a href="read.php?id=<?php echo $id; ?>&amp;no=<?php echo $post['no']; ?>&page=<?php echo $page; ?>"><?php echo stripslashes($post['subject']); ?><br />
		<span class="postInfo">(<?php echo $post['name'].', '.date('Y.m.d H:i', $post['signdate']).', '.$post['hit'].' hits, '.$post['comment_count'].' responses'; ?>)</span></a></li>
	<?php
	} // while
	?>
	<li class="group">이동</li>
	<li><a href="bbs.php?id=<?php echo $id; ?>">목록 보기</a></li>
	<?php if($page > 1) { ?><li><a href="bbs.php?id=<?php echo $id; ?>&amp;page=<?php echo $page-1; ?>">◀ 이전 페이지로 이동</a></li><?php } ?>
	<?php if($page < $totalPage) { ?><li><a href="bbs.php?id=<?php echo $id; ?>&amp;page=<?php echo $page+1; ?>">다음 페이지로 이동 ▶</a></li><?php } ?>
</ul>