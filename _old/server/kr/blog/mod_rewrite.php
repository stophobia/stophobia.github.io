<?php
/*
 * 파일명: mod_rewrite.php
 * 목적: Apache 의 mod_rewrite 를 이용한 주소 줄이기.
 * 작성자: sirini (http://sirini.net)
 * 마지막 수정일: 2008-07-23
 * 사용조건: 1. 웹서버가 Apache 고, mod_rewrite 모듈을 허용해야 함.
 *               2. 이 디렉토리내 .htaccess 파일이 있어야 함. 
 *               3. .htaccess 내 3째줄 RewriteBase 가 경로명에 맞게 정의되어야 함.
 * 주의사항: 기존 URL 체계 (?, & 을 이용한 GET으로 변수 넘기기) 를 유지해야 함. (하위호환성)
 *               RewriteRule 로 모든 것을 해결하려고 하지 말 것. (보조 성격으로 제한)
 *               기존 URL 체계보다 실행 속도가 느려짐. 서버 부하 심해짐.
 * 참고사항: 이 소스코드의 변경내역은 SVN 의 log 를 참고할 것.
 */

// '/' 로 구분해서 경로 저장
$arrPath = @explode('/', $_SERVER['PATH_INFO']);
$cntSlash = @count($arrPath);

// 버퍼 출력 필요없음
switch($arrPath[1]) {
	case 'trackback': 
		$_GET['p'] = $arrPath[2];
		$_GET['grkey'] = $arrPath[3];
		include 'trackback.php';
		exit();
	break;
}

// 버퍼 저장 후 출력할 것들
@ob_start();
switch($arrPath[1]) {

	case 'rss': include 'rss.php'; break;
	case 'owner': include 'admin.php'; break;
	case 'list': include 'article_list.php'; break;
	case 'write': include 'write.php'; break;
	case 'login': include 'login.php'; break;

	case 'reader': 
		$_GET['admin'] = 17;
		include 'admin.php';
	break;

	case 'tag':
		if($arrPath[2]) {
			$_GET['tag'] = $arrPath[2];
			include 'index.php';
		} else include 'tag.php';
	break;

	case 'category':
		$_GET['sortCategory'] = $arrPath[2];
		include 'index.php';
	break;

	case 'post':
		$_GET['admin'] = 2;
		include 'admin.php';
	break;

	default:
		$p = $arrPath[1];
		include 'index.php';
}
$content = @ob_get_contents();
@ob_end_clean();
echo str_replace('/mod_rewrite.php', '', $content);
?>