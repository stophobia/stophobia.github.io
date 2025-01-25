<?php
// 멀티업로드로 올린 파일을 글작성 도중에 다시 제거할 경우 실행
if(!$_POST['id'] || !$_POST['filename']) exit();
$_POST['id'] = str_replace(array('../', '.php'), '', $_POST['id']);
$_POST['filename'] = str_replace(array('../', '.php'), '', $_POST['filename']);
@unlink('data/'.$_POST['id'].'/'.$_POST['filename']);
$readTmpList = @file_get_contents('data/tmpfile.'.$_SERVER['REMOTE_ADDR']);
$newTmp = str_replace('data/'.$_POST['id'].'/'.$_POST['filename']."\n", '', $readTmpList);
$f = @fopen('data/tmpfile.'.$_SERVER['REMOTE_ADDR'], 'w');
@fwrite($f, $newTmp);
@fclose($f);
?>