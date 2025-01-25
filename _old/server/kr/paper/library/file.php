<?php
/*
	GR Paper 파일 작업 관련 라이브러리
	작성자: 박희근 (http://sirini.net)
	수정일: 2008-12-7
	내  용: Paper 내에서 파일 관련 작업을 편하게 할 수 있도록 도와주는 메소드들 정의
	참  고: URL 을 통한 원격 파일 작업을 포함한다. allow_url_fopen 등의 옵션에 중립적으로 작성한다.
	주  의: PHP 파일 함수에서 바로 URL 을 인자로 넘기는 것은 하지 않는다. socket 작업을 기본으로 한다.
*/

class GRFILE {
	function write($filename, $content) {
		try {
			$fp = fopen($filename, 'w');
			fwrite($fp, $content);
			fclose($fp);
		} catch(Exception $e) {}
	}
	
	function getPage($url, $isXML=true)
	{
		$parse = @parse_url($url);
		$fp = fsockopen($parse['host'], 80);
		if(!$fp) return 0;
		@stream_set_timeout($fp, 0);
		if($parse['query']) $parse['path'] .= '?';
		fputs($fp, 'GET '.$parse['path'].$parse['query']." HTTP/1.0\r\nHost: ".$parse['host']."\r\nUser-Agent: Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.0)\r\n\r\n");
		$content = '';
		while(!feof($fp)) $content .= fgets($fp, 4096);
		if(($loc = stripos($content, 'Location:')) !== false)
		{
			$str = trim(substr($content, $loc + 9));
			$url = substr($str, 0, strpos($str, "\n")-1);
		}
		fclose($fp);
		if($loc) $content = $this->getPage($url);
		if($isXML) {
			preg_match('|<rss(.+?)</rss>|Usim', $content, $m);
			return '<?xml version="1.0" encoding="utf-8"?><rss'.str_replace(array('<![CDATA[', ']]>'), '', $m[1]).'</rss>';
		} else return $content;
	}

	function xmlSaved($content, $url)
	{
		$p = @simplexml_load_string($content);
		$path = '../cache/tmp.'.md5($url).'.xml';
		$f = @fopen($path, 'w');
		@fwrite($f, $content);
		@fclose($f);
		return $path;
	}
}
