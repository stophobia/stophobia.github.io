<!-- 포스트 보여주기 -->
<div class="list">
	<div class="title">
		<div class="titleBox">··· <a href="<?php echo $postLink; ?>"><?php echo $gb['subject']; ?></a></div>
	</div>
	<div class="content">
		<?php 
		if($conf_preview) {
			$gb['content'] .= '… <a href="'.$postLink.'" class="readAll" title="클릭하시면 이 포스트 전체 본문을 읽으러 갑니다.">전체보기!</a>';
			if($preview[1]) $gb['content'] = '<a href="'.$preview[1].'" onclick="return hs.expand(this)" title="클릭하시면 본래 크기의 이미지를 봅니다."><img src="'.$grblog.'phpThumb/phpThumb.php?src='.str_replace($absPath, $grblog, $preview[1]).'&amp;w=80&amp;h=50&amp;q=100&amp;fltr[]=usm|99|0.5|3" alt="preview" class="preview" align="left" /></a> '.$gb['content'];
		}
		echo $gb['content']; 
		?>
		<div class="tag">tag … <?php echo $tagList; ?></div>
		<div class="directReply"><span title="이 글에 여러분의 생각을 댓글로 달아봅니다." onclick="more('replyBox<?php echo $gb['uid']; ?>');">trackbacks <?php echo $gb['trackback_count']; ?> : comments <?php echo $gb['comment_count']; ?></span></div>
	</div>
</div>

<!-- 트랙백 / 댓글 / 댓글작성폼 가져오기 -->
<?php if($config['use_comment']) { ?>
<div id="replyBox<?php echo $gb['uid']; ?>" <?php if($replyPuid != $gb['uid']) echo 'style="display: none"'; ?>><div>

<div class="trackbackURL">trackback address: <a href="#" onclick="clickToCopy('<?php echo trackbackURL($gb['uid']); ?>');" style="font-size: 11px; color: #bbb; font-weight: normal; font-family: tahoma, sans-serif;" title="클릭하시면 이 글의 트랙백(엮인글) 주소를 복사하실 수 있습니다."><?php echo trackbackURL($gb['uid']); ?></a></div>

<!-- <rdf:RDF xmlns:rdf="http://www.w3.org/1999/02/22-rdf-syntax-ns#" xmlns:dc="http://purl.org/dc/elements/1.1/" xmlns:trackback="http://madskills.com/public/xml/rss/module/trackback/">
<rdf:Description rdf:about="<?php echo $postLink; ?>" dc:identifier="<?php echo $postLink; ?>" dc:title="<?php echo $gb['subject']; ?>" trackback:ping="<?php echo trackbackURL($gb['uid']); ?>" /></rdf:RDF> -->

<?php
// 트랙백 가져오기
$getTB = @mysql_query('select * from '.$dbFIX.'trackback where post_uid = \''.$gb['uid'].'\'');
while($tb = mysql_fetch_array($getTB)) include $theme.'/trackback.php';

// 코멘트 가져오기
echo '<div id="comment'.$gb['uid'].'"></div>';
$getCO = @mysql_query('select * from '.$dbFIX.'comment where post_uid = \''.$gb['uid'].'\''.$aq.' order by family_uid asc, uid asc');
while($co = mysql_fetch_array($getCO)) include $theme.'/comment.php';

// 코멘트 작성폼
if($gb['comment_condition']) include $theme.'/write_comment.php';
?>
</div></div>
<?php } ?>