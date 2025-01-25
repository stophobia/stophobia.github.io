<?php

// 글쓰기 완료 처리전에 선행 처리되어야 할 부분이 있다면 기록
// Daum Editor 결과물을 GR Board 에서 활용하도록 가공 처리
$content = str_replace('<br>', '<br />', $content);
$content = str_replace(' class=\"multi-preview\"', '', $content);
$content = str_replace('<img src=\"../../data/', '<img class=\"multi-preview\" src=\"data/', $content);
?>