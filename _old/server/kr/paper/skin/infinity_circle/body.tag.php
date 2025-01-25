<?php
/*
	GR Paper 기본스킨 자주 쓰이는 태그 1000개 보기
	작성자: 박희근 (http://sirini.net)
	수정일: 2008-08-26
	내  용: 자주 쓰여진 상위 1,000 개의 태그구름 생성 (자주 쓰이는 순서로 출력됨)
*/
?>
<div class="left-content">
<div id="tagCloud">
<?php while($tag = $getTagList->fetch_array()) {
	if($tag['count'] > 5 && $tag['count'] < 20) $class = 1;
	elseif($tag['count'] > 19 && $tag['count'] < 50) $class = 2;
	elseif($tag['count'] > 49 && $tag['count'] < 100) $class = 3;
	elseif($tag['count'] > 99 && $tag['count'] < 200) $class = 4;
	elseif($tag['count'] > 199 && $tag['count'] < 500) $class = 5;
	elseif($tag['count'] > 499 && $tag['count'] < 1000) $class = 6;
	elseif($tag['count'] > 999) $class = 'Max';
	else $class = 0;
	$tagName = stripslashes($tag['tag']);
	echo '<a href="'.$config['absPath'].'/?so=tag&amp;st='.urlencode($tagName).'" class="lv'.$class.'">'.$tagName.'</a> &nbsp;';
} #while ?>
</div></div>

	</div>
</div>