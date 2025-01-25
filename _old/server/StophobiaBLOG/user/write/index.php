<?php
$prefix = '../../';
include $prefix.'php_head.php';
include $prefix.'lib/common.php';
if(!$_SESSION['user_no']) error('멤버로 먼저 로그인 하셔야 합니다.');
move('../../admin.php?admin=2');
?>