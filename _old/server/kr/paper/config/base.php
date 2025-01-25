<?php
/*
   GR Paper 기본 설정들
   작성자: 박희근 (http://sirini.net)
   수정일: 2009-7-9
   내  용: Paper 기본 설정들이 지정됨. (사용자가 거의 수정할 필요 없는 것들)
   주  의: GRCOMMON ($c) 객체가 먼저 정의되어야 $config['absPath'] 사용 가능
*/

$config['version'] = 'GR Paper v0.96';
$config['author'] = 'Heegeun Park (a.k.a SIRINI)';
$config['pathArr'] = @explode('.', $_SERVER['HTTP_HOST']);
if('/'.$config['pathArr'][0] == $c->dirName) $config['absPath'] = 'http://'.$config['pathArr'][1].'.'.$config['pathArr'][2].$c->dirName;
else $config['absPath'] = 'http://'.$_SERVER['HTTP_HOST'].$c->dirName;
?>
