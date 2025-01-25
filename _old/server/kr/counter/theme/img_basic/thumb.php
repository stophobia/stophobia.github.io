<?php
if(!$conf['width']) include 'config.php';
else $config = $conf;
$path = $grcount . 'cache/'.$grid.'.line.graph.gif';
$modifyTime = @filemtime($path);
if(!$modifyTime) $modifyTime = 0;
if($modifyTime + $config['cache'] > time()) {
	echo '<img src="'.$path.'" alt="" />';
} else {
	@unlink($path);
	include $grcount . 'class/GDGraph.php';
	if($config['type'] == 'page') $week = getWeekPageCount($grid);
	else $week = getWeekUniqCount($grid);
	$img = gdLineGraph($week, $config['width'], $config['height'],  $config['days'], $config['parameters'], $config['textterm'], $config['bgcolor'], $config['linecolor'], $config['datacolor'], $config['textcolor']);
	echo '<img src="'.$img.'" alt="" />';
}
?>