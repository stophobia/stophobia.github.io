<?php
// 통계 출력 설정하기
$config = array();
$config['cache'] = 600; # 그림 생성 후 n 초간 기존 그림 재활용하기 (기본: 600=10분)
$config['type'] = 'page'; # 고유방문(uniq) 혹은 페이지뷰(page) 가져오기
$config['width'] = 230; # 그래프 폭
$config['height'] = 130; # 그래프 높이
$config['days'] = 7; # n 일치 통계 (최대=7, 최소=2)
$config['parameters'] = 6; # n 층으로 수평기준선 긋기
$config['textterm'] = 30; # 그래프 좌측 숫자표기 폭
$config['bgcolor'] = array(255, 255, 255); # 그래프 배경색 (R, G, B 색상값)
$config['linecolor'] = array(238, 238, 238); # 그래프 기준선 색 (R, G, B 색상값)
$config['datacolor'] = array(170, 170, 170); # 그래프 선 색 (R, G, B 색상값)
$config['textcolor'] = array(187, 187, 187); # 그래프 속 글자색 (R, G, B 색상값)
?>