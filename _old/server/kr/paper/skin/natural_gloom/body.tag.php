<?php
/*
	GR Paper 기본스킨 자주 쓰이는 태그 1000개 보기
	작성자: 박희근 (http://sirini.net)
	수정일: 2009-7-9
	내  용: 자주 쓰여진 상위 1,000 개의 태그구름 생성 (자주 쓰이는 순서로 출력됨)
*/

while($tag = $getTagList->fetch_array()) {
	if($tag['count'] > 5 && $tag['count'] < 20) $style = 12;
	elseif($tag['count'] > 19 && $tag['count'] < 50) $style = 14;
	elseif($tag['count'] > 49 && $tag['count'] < 100) $style = 16;
	elseif($tag['count'] > 99 && $tag['count'] < 200) $style = 20;
	elseif($tag['count'] > 199 && $tag['count'] < 500) $style = 26;
	elseif($tag['count'] > 499 && $tag['count'] < 1000) $style = 36;
	elseif($tag['count'] > 999) $style = 'Max';
	else $style = 11;
	$tagName = stripslashes($tag['tag']);
	echo '<a href="'.$config['absPath'].'/?so=tag&amp;st='.urlencode($tagName).'" style="font-size: '.$style.'px">'.$tagName.'</a> &nbsp;';
} #while ?>