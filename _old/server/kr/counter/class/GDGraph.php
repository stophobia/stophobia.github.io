<?php
// 선형 그래프 (ex. 주식 그래프 형태)
function gdLineGraph($data, $width=150, $height=100, $days=7, $parameters=5, $textTerm=30,
	$bgColor=array(255,255,255), $lineColorArray=array(238,238,238), $dataColorArray=array(170,170,170), $textColorArray=array(187,187,187)) {
	global $grcount, $grid;
	$image = @imagecreate($width, $height);
	@imageantialias($image, true);
	@imagesavealpha($image, true);
	$height -= 10;
	$background = @imagecolorallocatealpha($image, $bgColor[0], $bgColor[1], $bgColor[2], 0);
	@imagefill($image, 0, 0, $background);
	$lineColor = @imagecolorallocate($image, $lineColorArray[0], $lineColorArray[1], $lineColorArray[2]);
	$dataColor = @imagecolorallocate($image, $dataColorArray[0], $dataColorArray[1], $dataColorArray[2]);
	$textColor = @imagecolorallocate($image, $textColorArray[0], $textColorArray[1], $textColorArray[2]);
	$maxValue = max($data);
	$divParameter = floor($maxValue / $parameters);
	$divLine = floor($height / $parameters);
	$divTerm = floor(($width-$textTerm) / ($days-1));
	@imageline($image, $width-1, 0, $width-1, $height, $lineColor);
	@imageline($image, $textTerm, $height-1, $width-1, $height-1, $lineColor);
	for($i=0; $i<=$parameters; $i++) {
		$yPos = $i*$divLine;
		@imagestring($image, 1, 0, ($height-$yPos), sprintf('%5d', $i*$divParameter), $textColor);
		if($i != $parameters) @imageline($image, $textTerm, $yPos, $width, $yPos, $lineColor);
	}
	for($j=0; $j<$days; $j++) {
		$xPos = $textTerm+($j*$divTerm);
		$yPos = $height-floor($height * ($data[$days-$j-1] / $maxValue));
		$nextYPos = $height-floor($height * ($data[$days-$j-2] / $maxValue));
		if($j < ($days-1)) {
			@imageline($image, $xPos, 0, $xPos, $height, $lineColor);
			@imageline($image, $xPos, $yPos, ($xPos+$divTerm), $nextYPos, $dataColor);
		}
	}
	@imagegif($image, $grcount . 'cache/'.$grid.'.line.graph.gif');
	return $grcount . 'cache/'.$grid.'.line.graph.gif';
}
?>