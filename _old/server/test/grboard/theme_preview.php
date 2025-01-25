<?php @header('Content-Type: text/html; charset=utf-8'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ko" lang="ko">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>GR Board Theme Preview</title>
</head>
<body>
<img src="<?php echo $_GET['src']; ?>" alt="테마 미리보기" title="스크린샷을 더블클릭 시 이 창을 닫습니다." ondblclick="window.close()" />
</body>
</html>