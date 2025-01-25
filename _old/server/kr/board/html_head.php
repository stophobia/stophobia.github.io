<?php
$grboard = str_replace('/'.end(explode('/', $_SERVER['REQUEST_URI'])), '', $_SERVER['REQUEST_URI']);
$styleURL = $grboard.'/style.css';
if($getOutlogin['var']) $styleURL = $grboard.'/admin/theme/outlogin/'.$getOutlogin['var'].'/style.css';
if($getJoinus['var']) $styleURL = $grboard.'/admin/theme/join/'.$getJoinus['var'].'/style.css';
if($getScrapView['var']) $styleURL = $grboard.'/admin/theme/scrap/'.$getScrapView['var'].'/style.css';
if($getMemo['var']) $styleURL = $grboard.'/admin/theme/memo/'.$getMemo['var'].'/style.css';
if($getReport['var']) $styleURL = $grboard.'/admin/theme/report/'.$getReport['var'].'/style.css';
if($getInformation['var']) $styleURL = $grboard.'/admin/theme/info/'.$getInformation['var'].'/style.css';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ko" lang="ko">
<head>
<link rel="stylesheet" href="<?php echo $styleURL; ?>" type="text/css" title="style" />
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo $encoding; ?>" />
<title><?php echo $title; ?></title>
</head>