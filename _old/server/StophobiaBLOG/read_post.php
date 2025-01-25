<?php
if(!defined('__GRBLOG__')) exit();

// HTML로 출판하였다면 캐쉬 사용
$getIsCache = @mysql_fetch_array(mysql_query('select make_html from '.$dbFIX.'post where uid = '.$p));
if($getIsCache['make_html']) {
	$isGuest = ($_SESSION['no']) ? '' : '.guest';
	$modifyTime = @filemtime('cache/'.$p.$isGuest.'.html');
	if(time() < ($modifyTime + 600)) {
		@include 'cache/'.$p.$isGuest.'.html';
		echo '<script type="text/javascript">//<![CDATA['."\n".'var str = \''.$antiSpam0.' '.$antiSpam3.' '.$antiSpam1.' = ?\';'."\n".'$(\'quiz'.$p.'\').innerHTML = str;';
		if($replyTo) echo ' $(\'addHidden\').innerHTML = \'<input type="hidden" name="replyTo" value="'.$replyTo.'" /><input type="hidden" name="is_reply" value="1" />\'; ';
		echo '//]]></script></body></html>';
		exit();
	} else {
		$isCacheStart = true;
		@ob_start();
	}
}
// 글 내용 보기
if(!isset($_SESSION['no'])) $ac = ' and post_condition != \'0\''; else $ac = '';
$getPost = @mysql_query('select * from '.$dbFIX.'post where uid = \''.$p.'\''.$ac);
$gb = mysql_fetch_array($getPost);

// 테마 상단
$browserTitle .= stripslashes($gb['subject']);
include $theme.'/head.php';

// 게시물 앞, 뒤 한 개씩 구해오기
$getNextPost = @mysql_fetch_array(mysql_query('select uid, subject from '.$dbFIX.'post where uid > '.$gb['uid'].$ac.' order by uid asc limit 1'));
$getPrevPost = @mysql_fetch_array(mysql_query('select uid, subject from '.$dbFIX.'post where uid < '.$gb['uid'].$ac.' order by uid desc limit 1'));
if($getNextPost[0]) $nextPost = '<a href="./?p='.$getNextPost['uid'].'" title="다음글 입니다.">'.stripslashes($getNextPost['subject']).' <img src="'.$theme.'/list_arrow.gif" alt="다음글" /></a>';
else $nextPost = '<span>다음글이 없습니다.</span>';
if($getPrevPost[0]) $prevPost = '<a href="./?p='.$getPrevPost['uid'].'" title="이전글 입니다."><img src="'.$theme.'/list_back_arrow.gif" alt="이전글" /> '.stripslashes($getPrevPost['subject']).'</a>';
else $prevPost = '<span>이전글이 없습니다.</span>';

// 태그 처리
if($gb['tag'])
{
	$tags = explode(',', $gb['tag']);
	$tCount = count($tags);
	$tagList = '';
	for($i=0; $i<$tCount; $i++)
		$tagList .= '<a href="'.$grblog.'?tag='.urlencode($tags[$i]).'">'.$tags[$i].'</a>, ';
	$tagList = substr($tagList, 0, -2);
}
else $tagList = '없음';
$gb['subject'] = stripslashes($gb['subject']);
$gb['content'] = str_replace(array('&amp;', '="data/'), array('&', '="'.$grblog.'data/'), stripslashes($gb['content']));
if($gb['uid']) include $theme.'/view.php';
else include $theme.'/error.php';

// 코멘트, 트랙백 허용일 때
if($config['use_comment'])
{
	// 트랙백 가져오기
	$getTB = @mysql_query('select * from '.$dbFIX.'trackback where post_uid = \''.$p.'\'');
	while($tb = mysql_fetch_array($getTB)) include $theme.'/trackback.php';

	// 코멘트 가져오기
	$getCO = @mysql_query('select * from '.$dbFIX.'comment where post_uid = \''.$p.'\' order by family_uid asc, uid asc');
	while($co = mysql_fetch_array($getCO)) 
	{
		$co['reply'] = ($co['is_reply']) ? '_reply' : '';
		if($co['is_secret'] && $_SESSION['no'] != 1) {
			$co['content'] = '<span style="color: red">비밀 댓글 입니다.</span>';
			$name = '?';
		} else {
			$co['content'] = nl2br(stripslashes($co['content']));
			$name = stripslashes($co['name']);
		}
		if($co['homepage']) $headLink = '<a href="'.$co['homepage'].'" title="'.$name.' 님의 웹사이트(블로그)를 방문 합니다">';
		elseif($co['email']) $headLink = '<a href="mailto:'.$co['email'].'" title="'.$name.' 님에게 메일을 보냅니다">';
		else $headLink = '<a href="#">';
		include $theme.'/comment.php';
	}

	// 코멘트 작성폼
	if($gb['comment_condition']) include $theme.'/write_comment.php';
}
?>
</div>
<!-- 사이드바 / 하단 -->
<?php
include $theme.'/sidebar.php';
include $theme.'/foot.php';
if($isCacheStart) {
	$viewPage = @ob_get_contents();
	@ob_clean();
	$f = @fopen('cache/'.$p.$isGuest.'.html', 'w');
	@fwrite($f, $viewPage);
	@fclose($f);
	echo $viewPage.'</body></html>';
}
?>