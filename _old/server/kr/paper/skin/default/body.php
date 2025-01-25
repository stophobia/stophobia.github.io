<?php
/*
	GR Paper 기본 스킨 몸통 디자인
	작성자: 박희근 (http://sirini.net)
	수정일: 2008-08-26
	내  용: 첫화면 부분임. 구독중인 RSS 글들 목록을 볼 수 있음.
	참  고: 상단부분은 기본스킨 안에 head.php 가 이미 불려졌고, 하단에 기본스킨 foot.php 가 불려지게 됨.
	주  의: 이 곳에 사용된 PHP코드는 수정시 주의를 요함.
*/
?>
<div id="feedList">
<?php 
while($rss = $getFeedList->fetch_array()) { 
	$blogInfo = $c->db->query('select url, name, is_open from '.$c->prefix.'feed_list where uid = '.$rss['blog_uid'])->fetch_array();
	if(!$blogInfo['is_open'] && !$c->isAdmin()) continue;
	$subject = stripslashes($rss['subject']);
	$content = mb_substr(stripslashes($rss['content']), 0, $charNumber, 'utf-8');
	$blogName = stripslashes($blogInfo['name']);
	$signdate = date('m.d H:i', $rss['signdate']);
	$img = $c->db->query('select url from '.$c->prefix.'image where feed_uid = '.$rss['uid'])->fetch_array();
	if($img['url'] && $thumbWidth) $content = '<a href="http://'.$img['url'].'" onclick="return hs.expand(this)"><img src="'.$config['absPath'].'/phpThumb/phpThumb.php?src=http://'.$img['url'].'&amp;w='.$thumbWidth.'&amp;h='.$thumbHeight.'&amp;q=100&amp;fltr[]=usm|99|0.5|3" alt="preview" /></a> '.$content;
?>
	<div class="title">
		<a href="<?php echo $config['absPath']; ?>/read/?u=<?php echo $rss['uid']; ?>&amp;r=http://<?php echo $rss['link']; ?>" title="클릭하시면 글을 보러 갑니다."><?php echo $subject; ?></a> 
		<span>| <a href="http://<?php echo $blogInfo['url']; ?>" title="이 블로그로 이동합니다."><?php echo $blogName; ?></a>
		(<?php echo $signdate; ?>)</span>
	</div>
	<div class="preview"><?php echo $content; ?></div>
	<div class="clear"></div>

<?php } # while ?>
</div>

<?php if($paging) { ?>
<div id="paging"><?php echo $paging; ?></div>
<?php } ?>