<?php
include $grcount.'class/GRCounter.php';
$GC = new GRCounter;
$GC->inputData($_SERVER['REMOTE_ADDR'], $grid, $_SERVER['HTTP_REFERER']);
?>