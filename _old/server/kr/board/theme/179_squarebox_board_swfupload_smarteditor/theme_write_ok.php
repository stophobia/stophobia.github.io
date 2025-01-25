<?php
// 글쓰기 완료 처리전에 선행 처리되어야 할 부분이 있다면 기록
$content = preg_replace("/(<\/?)(\w+)([^>]*>)/e", "'\\1'.strtolower('\\2').'\\3'", stripslashes($_POST['smartEditorContent']));
$content = str_replace(array('<br>', '</p>', '<p>', "\r\n", "\n", '<p style'), array('<br />', '<br />', '', '', '', '<span style'), $content);
?>