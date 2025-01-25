<?php
/*
	GR Paper 기본 스킨 몸통 디자인
	작성자: 박희근 (http://sirini.net)
	수정일: 2009-07-9
	내  용: 첫화면 부분임. 구독중인 RSS 글들 목록을 볼 수 있음.
	참  고: 상단부분은 기본스킨 안에 head.php 가 이미 불려졌고, 하단에 기본스킨 foot.php 가 불려지게 됨.
	주  의: 이 곳에 사용된 PHP코드는 수정시 주의를 요함.
*/

while($rss = $getFeedList->fetch_array()) { 
	$blogInfo = $c->db->query('select url, name, is_open from '.$c->prefix.'feed_list where uid = '.$rss['blog_uid'])->fetch_array();
	if(!$blogInfo['is_open'] && !$c->isAdmin()) continue;
	$subject = stripslashes($rss['subject']);
	$content = mb_substr(stripslashes($rss['content']), 0, $charNumber, 'utf-8');
	$blogName = stripslashes($blogInfo['name']);
	$signdate = date('m.d H:i', $rss['signdate']);
	$img = $c->db->query('select url from '.$c->prefix.'image where feed_uid = '.$rss['uid'])->fetch_array();
	if($img['url'] && $thumbWidth) $content = '<a href="http://'.$img['url'].'" onclick="return hs.expand(this)"><img src="'.$config['absPath'].'/phpThumb/phpThumb.php?src=http://'.$img['url'].'&amp;w='.$thumbWidth.'&amp;h='.$thumbHeight.'&amp;q=100&amp;fltr[]=usm|99|0.5|3" alt="preview" /></a> '.$content.'<div class="clearer"></div>';
	if(!$rss['author']) $rss['author'] = $blogInfo['url'];
?>
<div class="post" id="post-<?php echo $rss['uid']; ?>">
	<div class="post_title"><h1><a href="<?php echo $config['absPath']; ?>/read/?u=<?php echo $rss['uid']; ?>&amp;r=http://<?php echo $rss['link']; ?>" title="클릭하시면 글을 보러 갑니다."><?php echo $subject; ?></a></h1></div>

	<div class="post_body">
		<?php echo $content; ?>
		<div class="clearer">&nbsp;</div>
	</div>

	<div class="post_meta">
		Posted on <?php echo date('r', $rss['signdate']); ?> by <a href="http://<?php echo $blogInfo['url']; ?>" title="이 블로그로 이동합니다."><?php echo stripslashes($rss['author']); ?></a>
	</div>			
</div>

<?php } # while 

// 페이징 처리
if($paging) { ?>
	<div id="paging"><?php echo $paging; ?></div>
<?php } ?>