<?php
// 블로그 호환 클래스; PHP4 & PHP5 호환됨;
class BLOG
{
	// 트랙백 보내기
	function sendTrackback($tb_url, $url, $sender, $subject, $content) 
	{
		$subject = strip_tags($subject);
		$content = strip_tags($content);
		$tmp_data = 'url='.rawurlencode($url).
			'&title='.rawurlencode($subject).
			'&blog_name='.rawurlencode($sender).
			'&excerpt='.rawurlencode($content);
		$uinfo = parse_url($tb_url);
		if($uinfo['query']) $tmp_data .= '&'.$uinfo['query'];
		if(!$uinfo['port']) $uinfo['port'] = 80;
		$send_str = 'POST '.$uinfo['path']." HTTP/1.1\r\n".
			'Host: '.$uinfo['host']."\r\n".
			"User-Agent: GR Board\r\n".
			"Content-Type: application/x-www-form-urlencoded\r\n".
			'Content-length: '.strlen($tmp_data)."\r\n".
			"Connection: close\r\n\r\n".$tmp_data;
		$fp = fsockopen($uinfo['host'], $uinfo['port']);
		if(!$fp) return '트랙백 URL이 존재하지 않습니다.';
		$fp = fsockopen($uinfo['host'], $uinfo['port']);
		fputs($fp,$send_str);
		while(!feof($fp)) $response .= fgets($fp, 128);
		fclose($fp);
		if(!strstr($response, '<response>')) return '올바른 트랙백 URL이 아닙니다.';
		$response = strchr($response, '<?');
		$response = substr($response, 0, strpos($response, '</response>'));
		if(strstr($response, '<error>0</error>')) return '';
		else
		{
			$tb_error_str = strchr($response, '<message>');
			$tb_error_str = substr($tb_error_str, 0, strpos($tb_error_str, '</message>'));
			$tb_error_str = str_replace('<message>', '', $tb_error_str);
			return '트랙백 전송중 오류가 발생했습니다: '.$tb_error_str;
		}
	}

	// RSS 만들기
	function makeRss($id)
	{
		global $dbFIX;
		@header('Content-Type: text/xml; charset=utf-8');
		@header('Cache-Control: no-cache, must-revalidate'); 
		@header('Pragma: no-cache');
		echo '<?xml version="1.0" encoding="utf-8"?>';
		echo '<rss version="2.0" xmlns:dc="http://purl.org/dc/elements/1.1/">';
		$path = str_replace('/rss.php', '', $_SERVER["SCRIPT_NAME"]);
		$grboard = $tArr[$countBar-1];
		echo '<channel><title>'.$id.' 게시판의 최근글</title>'.
			'<link>http://'.$_SERVER['HTTP_HOST'].$path.'/board.php?id='.$id.'</link>'.
			'<description>'.$id.' 게시판에 올라온 최근글을 RSS 리더기로 볼 수 있습니다.</description>'.
			'<generator>GR Board RSS Generator</generator>';
		$rssView = @mysql_query("select no, name, category, signdate, subject, is_grcode, content, tag from {$dbFIX}bbs_{$id} where is_secret = '0' order by no desc limit 10");
		while($rss = mysql_fetch_array($rssView))
		{
			echo '<item><title>'.htmlspecialchars(stripslashes($rss['subject'])).'</title>'.
			'<link>http://'.$_SERVER['HTTP_HOST'].$path.'/board.php?id='.$id.'&amp;articleNo='.$rss['no'].'</link>'.
			'<description>'.stripslashes(htmlspecialchars(nl2br($rss['content']))).'</description>';
			if($rss['category']) echo '<category>'.$rss['category'].'</category>';
			if($rss['tag']) {
				$tagList = @explode(',', $rss['tag']);
				$tagCount = count($tagList);
				for($t=0; $t<$tagCount; $t++) echo '<category>'.$tagList[$t].'</category>';
			}
			echo '<author>'.$rss['name'].'</author>'.'<pubDate>'.date('r', $rss['signdate']).'</pubDate></item>';
		}
		echo '</channel></rss>';
	}

	// 통합 최근게시물 RSS
	function allRss($select='')
	{
		global $dbFIX;
		@header('Content-Type: text/xml; charset=utf-8');
		@header('Cache-Control: no-cache, must-revalidate'); 
		@header('Pragma: no-cache');
		echo '<?xml version="1.0" encoding="utf-8"?>';
		echo '<rss version="2.0" xmlns:dc="http://purl.org/dc/elements/1.1/">';
		$path = str_replace('/rss.php', '', $_SERVER["SCRIPT_NAME"]);
		echo '<channel><title>http://'.$_SERVER['HTTP_HOST'].' 통합 최근글 RSS</title>'.
			'<link>http://'.$_SERVER['HTTP_HOST'].'</link>'.
			'<description>모든 게시판에 올라온 최근글을 RSS 리더기로 볼 수 있습니다.</description>'.
			'<generator>GR Board RSS Generator</generator>';
		if($select) {
			$addQue = ' where id = \'';
			$tA = @explode(',', $select);
			$cntA = @count($tA);
			for($i=0; $i<$cntA; $i++) $addQue .= $tA[$i].'\' or id = \'';
			$addQue = @substr($addQue, 0, -10);
		} else $addQue = '';
		$rssView = @mysql_query("select * from {$dbFIX}total_article{$addQue} where is_secret = '0' order by no desc limit 10");
		while($rss = mysql_fetch_array($rssView))
		{
			$isRSSOpen = @mysql_fetch_array(mysql_query("select is_rss from {$dbFIX}board_list where id = '".$rss['id']."' limit 1"));
			if(!$isRSSOpen['is_rss']) continue;
			$getPostThumb = @mysql_fetch_array(mysql_query("select name, content from {$dbFIX}bbs_".$rss['id']." where is_secret = '0' and no = ".$rss['article_num']));
			echo '<item><title>'.htmlspecialchars(stripslashes($rss['subject'])).'</title>'.
			'<link>http://'.$_SERVER['HTTP_HOST'].$path.'/board.php?id='.$rss['id'].'&amp;articleNo='.$rss['article_num'].'</link>'.
			'<description>'.htmlspecialchars(stripslashes(nl2br($getPostThumb['content']))).'</description>';
			echo '<author>'.htmlspecialchars(stripslashes($getPostThumb['name'])).'</author><pubDate>'.date('r', $rss['signdate']).'</pubDate></item>';
		}
		echo '</channel></rss>';
	}

	// 댓글만 RSS 뽑기
	function replyRss($id)
	{
		global $dbFIX;
		@header('Content-Type: text/xml; charset=utf-8');
		@header('Cache-Control: no-cache, must-revalidate'); 
		@header('Pragma: no-cache');
		echo '<?xml version="1.0" encoding="utf-8"?>';
		echo '<rss version="2.0" xmlns:dc="http://purl.org/dc/elements/1.1/">';
		$path = str_replace('/rss.php', '', $_SERVER["SCRIPT_NAME"]);
		$grboard = $tArr[$countBar-1];
		echo '<channel><title>'.$id.' 게시판의 댓글 최근글</title>'.
			'<link>http://'.$_SERVER['HTTP_HOST'].$path.'/board.php?id='.$id.'</link>'.
			'<description>'.$id.' 게시판에 올라온 최근 댓글을 RSS 리더기로 볼 수 있습니다.</description>'.
			'<generator>GR Board RSS Generator</generator>';
		$rssView = @mysql_query("select no, board_no, name, signdate, subject, is_grcode, content from {$dbFIX}comment_{$id} where is_secret = '0' order by no desc limit 10");
		while($rss = mysql_fetch_array($rssView))
		{
			echo '<item><title>'.htmlspecialchars(stripslashes($rss['subject'])).'</title>'.
			'<link>http://'.$_SERVER['HTTP_HOST'].$path.'/board.php?id='.$id.'&amp;articleNo='.$rss['board_no'].'</link>'.
			'<description>'.stripslashes(htmlspecialchars(nl2br($rss['content']))).'</description>';
			echo '<author>'.$rss['name'].'</author>'.'<pubDate>'.date('r', $rss['signdate']).'</pubDate></item>';
		}
		echo '</channel></rss>';
	}
}
?>