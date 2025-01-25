<?php
/*
	GR Paper 기본 스킨 썸네일 보여주기
	작성자: 박희근 (http://sirini.net)
	수정일: 2008-08-26
	내  용: 추출된 썸네일만 따로 모아서 보여줌.
	참  고: 상단부분은 기본스킨 안에 head.php 가 이미 불려졌고, 하단에 기본스킨 foot.php 가 불려지게 됨.
*/
?>
<div class="left-content">
<div id="thumbnailList">
<?php
while($img = $getThumbnailList->fetch_array()) {
	$post = $c->db->query('select link, subject from '.$c->prefix.'feed where uid = '.$img['feed_uid'].' limit 1')->fetch_array();
	$subject = stripslashes($post['subject']);
	echo '<div class="preview" style="width: '.($thumbWidth+10).'px;height: '.($thumbHeight+40).'px"><a href="http://'.$img['url'].'" onclick="return hs.expand(this)">'.
		'<img src="'.$config['absPath'].'/phpThumb/phpThumb.php?src=http://'.$img['url'].'&amp;w='.$thumbWidth.'&amp;h='.$thumbHeight.
		'&amp;q=100&amp;fltr[]=usm|99|0.5|3" alt="preview" /></a><div><a href="http://'.$post['link'].'">'.$subject.'</a></div></div>';
}
?>
	<div class="clear"></div>
</div></div>

		<div class="clearfix pagination bluegray">
		<?php echo $paging; ?>
		</div>
	</div>
</div>