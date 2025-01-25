<?php	
// 트랙백 보내기
function sendTrackback($tb_url, $url, $sender, $subject, $content, $encoding='utf-8') 
{
	if($encoding == 'euc-kr' && function_exists('iconv')) {
		$subject = iconv('utf-8', 'euc-kr', $subject);
		$content = iconv('utf-8', 'euc-kr', $content);
		$sender = iconv('utf-8', 'euc-kr', $sender);
	}
	$subject = strip_tags($subject);
	$content = strip_tags($content);
	$tmp_data = 'url='.rawurlencode($url).
		'&title='.rawurlencode($subject).
		'&blog_name='.rawurlencode($sender).
		'&excerpt='.rawurlencode($content);
	$uinfo = parse_url($tb_url);
	$parseQue = explode('&', $uinfo['query']);
	$tmp_data .= '&'.$parseQue[0].'&'.$parseQue[1];
	if(!$uinfo['port']) $uinfo['port'] = 80;
	$send_str = 'POST '.$uinfo['path']." HTTP/1.1\r\n".
		'Host: '.$uinfo['host']."\r\n".
		"User-Agent: GR Blog\r\n".
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
		if(function_exists('iconv') && (iconv('euc-kr', 'utf-8', $tb_error_str) != $tb_error_str))
			$tb_error_str = iconv('euc-kr', 'utf-8', $tb_error_str);
		return $tb_error_str;
	}
}
?>