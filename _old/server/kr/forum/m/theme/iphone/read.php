<?php 
if(!defined('__GRFORUM__')) exit(); 

$filePath = '../../' . $grboard;
$bbsInfo['name'] = stripslashes($bbsInfo['name']);
$papa['name'] = stripslashes($papa['name']);
$subject = stripslashes($view['subject']);
$content = str_replace('src="data/'.$id.'/', 'src="'. $filePath .'/phpThumb/phpThumb.php?w=300&amp;q=100&amp;src=../data/'.$id.'/', nl2br(stripslashes($view['content'])));
$writer = stripslashes($view['name']);
$date = date('Y.m.d H:i', $view['signdate']);
?>

<!-- 상단 툴바 -->
<div id="topToolbar" class="toolbar">
    <h1 id="pageTitle"><?php echo $setting['forum_title']; ?></h1>
    <a id="backButton" class="button" href="#">처음</a>
    <a class="button" href="./">처음</a>
</div>

<ul id="grforum_mobile" title="<?php echo $bbsInfo['name']; ?>" selected="true">
	<li class="group"><span onclick="location.href='./?parent=<?php echo $bbsInfo['parent']; ?>'"><?php echo $papa['name']; ?></span> 》<span onclick="location.href='bbs.php?id=<?php echo $id; ?>'"><?php echo $bbsInfo['name']; ?></span></li>
	<li><?php echo $subject; ?><br /><span class="postInfo"><?php echo $writer.', '.$date.', '.$view['hit'].' hits'.(($view['link1'])?' <a href="'.$view['link1'].'">Link1</a>, ':'').(($view['link2'])?'<a href="'.$view['link2'].'">Link2</a>':''); ?></span></li>
	<li class="content"><?php echo $content; ?></li>
	<li class="group">이동</li>
	<li><a href="bbs.php?id=<?php echo $id; ?>&amp;page=<?php echo $page; ?>">목록 보기</a></li>
	<li><a href="#files">첨부 파일</a></li>
	<li><a href="#comments">댓글 보기 (<?php echo $view['comment_count']; ?>)</a></li>
</ul>

<ul id="files" title="첨부 파일">
	<li class="group">파일 목록</li>
	<?php
	// 기본 첨부파일 중 이미지만 출력
	for($i=0; $i<10; $i++) { 
		$fileIndex = 'file_route'.($i+1);
		if(!$fileOrigin[$fileIndex]) break;
		if(!preg_match('/\.(jpg|gif|png|bmp)$/i', $fileOrigin[$fileIndex])) continue;
	?>
	<li><img src="<?php echo $filePath; ?>/phpThumb/phpThumb.php?src=../<?php echo $fileOrigin[$fileIndex]; ?>&amp;w=300&amp;q=100" alt="" /></li>
	<?php } 
	
	// 확장 첨부파일 중 이미지만 출력
	while($ext = $core->fetch($fileExtend)) {
		if(!preg_match('/\.(jpg|gif|png|bmp)$/i', $ext['file_route'])) continue;
	?>
	<li><img src="<?php echo $filePath; ?>/phpThumb/phpThumb.php?src=../<?php echo $ext['file_route']; ?>&amp;w=300&amp;q=100" alt="" /></li>
	<?php } ?>

	<li class="group">이동</li>
	<li><a href="read.php?id=<?php echo $id; ?>&amp;no=<?php echo $no; ?>&amp;page=<?php echo $page; ?>">게시물 보기</a></li>
</ul>

<ul id="comments" title="댓글 보기 (<?php echo $view['comment_count']; ?>)">
	<li class="group">댓글 목록</li>
	<?php
	while($reply = $core->fetch($comments)) { 
		$name = stripslashes($reply['name']);
		$date = date('Y.m.d H:i', $reply['signdate']);
		$subject = stripslashes($reply['subject']);
		$content = nl2br(stripslashes($reply['content']));
	?>
	<li>
		<div class="replyTitle"><?php echo $subject; ?></div>
		<div class="content"><?php echo $content; ?></div>
		<span class="postInfo"><?php echo $name.', ('.$date.')'; ?></span>
	</li>
	<?php } ?>

	<li class="group">이동</li>
	<li><a href="read.php?id=<?php echo $id; ?>&amp;no=<?php echo $no; ?>&amp;page=<?php echo $page; ?>">게시물 보기</a></li>
</ul>