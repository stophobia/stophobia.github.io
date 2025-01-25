<?php
// 원격 서버의 RSS을 가져온다.
function getPage($url) {
	$content = @file_get_contents($url);
	if(!$content) {
		$parse = parse_url($url);
		if(!$parse['port']) $parse['port'] = 80;
		$fp = @fsockopen($parse['host'], $parse['port']);
		if(!$fp) return 0;
		@stream_set_timeout($fp, 0);
		if($parse['query']) $parse['path'] .= '?';
		@fputs($fp, 'GET '.$parse['path'].$parse['query']." HTTP/1.0\r\nHost: ".$parse['host']."\r\nUser-Agent: User-Agent: Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.0)\r\n\r\n");
		$content = '';
		while(!feof($fp)) $content .= @fgets($fp, 2048);
		if(($loc = strpos($content, 'Location:')) !== false)
		{
			$str = trim(substr($content, $loc + 9));
			$url = substr($str, 0, strpos($str, "\n")-1);
		}
		@fclose($fp);
		if($loc) $content = getPage($url);
	}
	return preg_replace('|^HTTP.+?<\?xml|is', '<?xml', $content);
}
?>