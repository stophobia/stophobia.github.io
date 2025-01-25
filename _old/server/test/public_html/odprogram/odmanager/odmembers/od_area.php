<?
	include "../../odcommon/od_config.inc.php";
	include "$folderpath_manager_common/od_function.inc.php";	
	include "../../odcommon/od_lib.inc.php";
	include "$folderpath_manager_common/od_adminAuthority.inc.php";
	include "$folderpath_manager_common/od_head.inc.php";
	include "$folderpath_manager_common/od_body.inc.php";

	## 세부권한 체크
	if($row_admin[memberLevel] < 3) {
		error_msgloc("$folderpath_manager/","접근권한이 없습니다.   ");
	}

	## 테이블 가로 크기 #########################
	$table_width = 248;
	
	## % 셀을 42로 기준한 그래프 셀 가로 크기 #####
	$graph_width = 206;
	
	## 0% 인 경우 %셀 가로 크기 #################
	$none_width = 247;

	## 분할된 셀 가로 크기 ######################
	$division_width = 0;

	#################################################
	## 전체 회원/남성회원/여성회원 의 수 시작
	#################################################
	$qry_M = "SELECT sex, count(serialnum) as cc FROM odtMember WHERE secession='N' and (sex = 'F' or sex = 'M') and resinum != '' and birthy != '' and userType='B' group by sex";
	$res_M = mysql_query($qry_M);

	$total = 0;
	$MTotal = 0;
	$FMTotal = 0;

	while($row_M = mysql_fetch_array($res_M)){
		if($row_M[sex] == "M") $MTotal = $row_M[cc];
		else if($row_M[sex] == "F") $FMTotal = $row_M[cc];

		$total += $row_M[cc];
	}

	## 성별 회원 퍼센테이지 값 계산
	if($total >0 ) {
		$SexPercentM = floor(100*$MTotal/$total);
		$MPixel = ceil($graph_width*$SexPercentM/100);
		$MPixelE = $table_width-$MPixel-$division_width;
		$MPixelS = $table_width-$MPixelE-$division_width;
		
		if($MPixelS < 1) $MPixelS = 1;
		$SexPercentFM = ceil(100*$FMTotal/$total);
		$FPixel = ceil($graph_width*$SexPercentFM/100);
		$FPixelE = $table_width-$FPixel-$division_width;
		$FPixelS = $table_width-$FPixelE-$division_width;
		
		if($FPixelS < 1) $FPixelS = 1;
	}
	else {
		$SexPercentM = 0;
		$MPixelE = $none_width;
		$MPixelS = 1;
		$SexPercentFM = 0;
		$FPixelE = $none_width;
		$FPixelS = 1;
	}
	#################################################
	## 전체 회원/남성회원/여성회원 의 수 끝
	#################################################

	#################################################
	## 지역별 회원/남성회원/여성회원 의 수 시작
	#################################################	
	## 서울 지역 전체 회원/남성회원/여성회원 의 수 시작
	$qry_M10 = "SELECT sex, count(serialnum) as cc FROM odtMember WHERE address LIKE '서울%' AND secession='N' and (sex = 'F' or sex = 'M') and resinum != '' and birthy != '' and userType='B' group by sex";
	$res_M10 = mysql_query($qry_M10);

	$SETotal = 0;
	$MSETotal = 0;
	$FSETotal = 0;

	while($row_M10 = mysql_fetch_array($res_M10)){
		if($row_M10[sex] == "M") $MSETotal = $row_M10[cc];
		else if($row_M10[sex] == "F") $FSETotal = $row_M10[cc];

		$SETotal += $row_M10[cc];
	}

	## 서울지역 회원 퍼센테이지 값 계산
	if($SETotal >0 ) {
		$MSEPercentM = floor(100*$MSETotal/$total);
		$MSEPixel = ceil($graph_width*$MSEPercentM/100);
		$MSEPixelE = $table_width-$MSEPixel-$division_width;
		$MSEPixelS = $table_width-$MSEPixelE-$division_width;
		
		if($MSEPixelS < 1) $MSEPixelS = 1;
		$FSEPercentFM = ceil(100*$FSETotal/$total);
		$FSEPixel = ceil($graph_width*$FSEPercentFM/100);
		$FSEPixelE = $table_width-$FSEPixel-$division_width;
		$FSEPixelS = $table_width-$FSEPixelE-$division_width;
		
		if($FSEPixelS < 1) $FSEPixelS = 1;
	}
	else {
		$MSEPercentM = 0;
		$MSEPixelE = $none_width;
		$MSEPixelS = 1;
		$FSEPercentFM = 0;
		$FSEPixelE = $none_width;
		$FSEPixelS = 1;
	}

	## 인천 지역 전체 회원/남성회원/여성회원 의 수 시작
	$qry_M20 = "SELECT sex, count(serialnum) as cc FROM odtMember WHERE address LIKE '인천%' AND secession='N' and (sex = 'F' or sex = 'M') and resinum != '' and birthy != '' and userType='B' group by sex";
	$res_M20 = mysql_query($qry_M20);

	$INTotal = 0;
	$MINTotal = 0;
	$FINTotal = 0;

	while($row_M20 = mysql_fetch_array($res_M20)){
		if($row_M20[sex] == "M") $MINTotal = $row_M20[cc];
		else if($row_M20[sex] == "F") $FINTotal = $row_M20[cc];

		$INTotal += $row_M20[cc];
	}

	## 인천지역 회원 퍼센테이지 값 계산
	if($INTotal >0 ) {
		$MINPercentM = floor(100*$MINTotal/$total);
		$MINPixel = ceil($graph_width*$MINPercentM/100);
		$MINPixelE = $table_width-$MINPixel-$division_width;
		$MINPixelS = $table_width-$MINPixelE-$division_width;
		
		if($MINPixelS < 1) $MINPixelS = 1;
		
		$FINPercentF = ceil(100*$FINTotal/$total);
		$FINPixel = ceil($graph_width*$FINPercentF/100);
		$FINPixelE = $table_width-$FINPixel-$division_width;
		$FINPixelS = $table_width-$FINPixelE-$division_width;
		
		if($FINPixelS < 1) $FINPixelS = 1;
	}
	else {
		$MINPercentM = 0;
		$MINPixelE = $none_width;
		$MINPixelS = 1;
		$FINPercentF = 0;
		$FINPixelE = $none_width;
		$FINPixelS = 1;
	}
	## 인천 지역 전체 회원/남성회원/여성회원 의 수 끝

	## 광주 지역 전체 회원/남성회원/여성회원 의 수 시작
	$qry_M30 = "SELECT sex, count(serialnum) as cc FROM odtMember WHERE address LIKE '광주 %' AND secession='N' and (sex = 'F' or sex = 'M') and resinum != '' and birthy != '' and userType='B' group by sex";
	$res_M30 = mysql_query($qry_M30);

	$KJTotal = 0;
	$MKJTotal = 0;
	$FKJTotal = 0;

	while($row_M30 = mysql_fetch_array($res_M30)){
		if($row_M30[sex] == "M") $MKJTotal = $row_M30[cc];
		else if($row_M30[sex] == "F") $FKJTotal = $row_M30[cc];

		$KJTotal += $row_M30[cc];
	}

	## 광주지역 회원 퍼센테이지 값 계산
	if($KJTotal >0 ) {
		$MKJPercent = floor(100*$MKJTotal/$total);
		$MKJPixel = ceil($graph_width*$MKJPercent/100);
		$MKJPixelE = $table_width-$MKJPixel-$division_width;
		$MKJPixelS = $table_width-$MKJPixelE-$division_width;
		
		if($MKJPixelS < 1) $MKJPixelS = 1;
		
		$FKJPercent = ceil(100*$FKJTotal/$total);
		$FKJPixel = ceil($graph_width*$FKJPercent/100);
		$FKJPixelE = $table_width-$FKJPixel-$division_width;
		$FKJPixelS = $table_width-$FKJPixelE-$division_width;
		
		if($FKJPixelS < 1) $FKJPixelS = 1;
	}
	else {
		$MKJPercent = 0;
		$MKJPixelE = $none_width;
		$MKJPixelS = 1;
		$FKJPercent = 0;
		$FKJPixelE = $none_width;
		$FKJPixelS = 1;
	}
	## 광주 지역 전체 회원/남성회원/여성회원 의 수 끝

	## 대구 지역 전체 회원/남성회원/여성회원 의 수 시작
	$qry_M40 = "SELECT sex, count(serialnum) as cc FROM odtMember WHERE address LIKE '대구%' AND secession='N' and (sex = 'F' or sex = 'M') and resinum != '' and birthy != '' and userType='B' group by sex";
	$res_M40 = mysql_query($qry_M40);

	$DGTotal = 0;
	$MDGTotal = 0;
	$FDGTotal = 0;

	while($row_M40 = mysql_fetch_array($res_M40)){
		if($row_M40[sex] == "M") $MDGTotal = $row_M40[cc];
		else if($row_M40[sex] == "F") $FDGTotal = $row_M40[cc];

		$DGTotal += $row_M40[cc];
	}

	## 대구지역 회원 퍼센테이지 값 계산
	if($DGTotal >0 ) {
		$MDGPercent = floor(100*$MDGTotal/$total);
		$MDGPixel = ceil($graph_width*$MDGPercent/100);
		$MDGPixelE = $table_width-$MDGPixel-$division_width;
		$MDGPixelS = $table_width-$MDGPixelE-$division_width;
		
		if($MDGPixelS < 1) $MDGPixelS = 1;
		
		$FDGPercent = ceil(100*$FDGTotal/$total);
		$FDGPixel = ceil($graph_width*$FDGPercent/100);
		$FDGPixelE = $table_width-$FDGPixel-$division_width;
		$FDGPixelS = $table_width-$FDGPixelE-$division_width;
		
		if($FDGPixelS < 1) $FDGPixelS = 1;
	}
	else {
		$MDGPercent = 0;
		$MDGPixelE = $none_width;
		$MDGPixelS = 1;
		$FDGPercent = 0;
		$FDGPixelE = $none_width;
		$FDGPixelS = 1;
	}
	## 대구 지역 전체 회원/남성회원/여성회원 의 수 끝

	## 대전 지역 전체 회원/남성회원/여성회원 의 수 시작
	$qry_M50 = "SELECT sex, count(serialnum) as cc FROM odtMember WHERE address LIKE '대전%' AND secession='N' and (sex = 'F' or sex = 'M') and resinum != '' and birthy != '' and userType='B' group by sex";
	$res_M50 = mysql_query($qry_M50);

	$DJTotal = 0;
	$MDJTotal = 0;
	$FDJTotal = 0;

	while($row_M50 = mysql_fetch_array($res_M50)){
		if($row_M50[sex] == "M") $MDJTotal = $row_M50[cc];
		else if($row_M50[sex] == "F") $FDJTotal = $row_M50[cc];

		$DJTotal += $row_M50[cc];
	}

	## 대전지역 회원 퍼센테이지 값 계산
	if($DJTotal >0 ) {
		$MDJPercent = floor(100*$MDJTotal/$total);
		$MDJPixel = ceil($graph_width*$MDJPercent/100);
		$MDJPixelE = $table_width-$MDJPixel-$division_width;
		$MDJPixelS = $table_width-$MDJPixelE-$division_width;
		
		if($MDJPixelS < 1) $MDJPixelS = 1;
		
		$FDJPercent = ceil(100*$FDJTotal/$total);
		$FDJPixel = ceil($graph_width*$FDJPercent/100);
		$FDJPixelE = $table_width-$FDJPixel-$division_width;
		$FDJPixelS = $table_width-$FDJPixelE-$division_width;
		
		if($FDJPixelS < 1) $FDJPixelS = 1;
	}
	else {
		$MDJPercent = 0;
		$MDJPixelE = $none_width;
		$MDJPixelS = 1;
		$FDJPercent = 0;
		$FDJPixelE = $none_width;
		$FDJPixelS = 1;
	}
	## 대전 지역 전체 회원/남성회원/여성회원 의 수 끝

	## 부산 지역 전체 회원/남성회원/여성회원 의 수 시작
	$qry_M60 = "SELECT sex, count(serialnum) as cc FROM odtMember WHERE address LIKE '부산%' AND secession='N' and (sex = 'F' or sex = 'M') and resinum != '' and birthy != '' and userType='B' group by sex";
	$res_M60 = mysql_query($qry_M60);

	$PSTotal = 0;
	$MPSTotal = 0;
	$FPSTotal = 0;

	while($row_M60 = mysql_fetch_array($res_M60)){
		if($row_M60[sex] == "M") $MPSTotal = $row_M60[cc];
		else if($row_M60[sex] == "F") $FPSTotal = $row_M60[cc];

		$PSTotal += $row_M60[cc];
	}

	## 부산 지역 회원 퍼센테이지 값 계산
	if($PSTotal >0 ) {
		$MPSPercent = floor(100*$MPSTotal/$total);
		$MPSPixel = ceil($graph_width*$MPSPercent/100);
		$MPSPixelE = $table_width-$MPSPixel-$division_width;
		$MPSPixelS = $table_width-$MPSPixelE-$division_width;
		
		if($MPSPixelS < 1) $MPSPixelS = 1;
		
		$FPSPercent = ceil(100*$FPSTotal/$total);
		$FPSPixel = ceil($graph_width*$FPSPercent/100);
		$FPSPixelE = $table_width-$FPSPixel-$division_width;
		$FPSPixelS = $table_width-$FPSPixelE-$division_width;
		
		if($FPSPixelS < 1) $FPSPixelS = 1;
	}
	else {
		$MPSPercent = 0;
		$MPSPixelE = $none_width;
		$MPSPixelS = 1;
		$FPSPercent = 0;
		$FPSPixelE = $none_width;
		$FPSPixelS = 1;
	}
	## 부산 지역 전체 회원/남성회원/여성회원 의 수 끝

	## 울산 지역 전체 회원/남성회원/여성회원 의 수 시작
	$qry_M70 = "SELECT sex, count(serialnum) as cc FROM odtMember WHERE address LIKE '울산%' AND secession='N' and (sex = 'F' or sex = 'M') and resinum != '' and birthy != '' and userType='B' group by sex";
	$res_M70 = mysql_query($qry_M70);

	$WSTotal = 0;
	$MWSTotal = 0;
	$FWSTotal = 0;

	while($row_M70 = mysql_fetch_array($res_M70)){
		if($row_M70[sex] == "M") $MWSTotal = $row_M70[cc];
		else if($row_M70[sex] == "F") $FWSTotal = $row_M70[cc];

		$WSTotal += $row_M70[cc];
	}

	## 울산 지역 회원 퍼센테이지 값 계산
	if($WSTotal >0 ) {
		$MWSPercent = floor(100*$MWSTotal/$total);
		$MWSPixel = ceil($graph_width*$MWSPercent/100);
		$MWSPixelE = $table_width-$MWSPixel-$division_width;
		$MWSPixelS = $table_width-$MWSPixelE-$division_width;
		
		if($MWSPixelS < 1) $MWSPixelS = 1;
		
		$FWSPercent = ceil(100*$FWSTotal/$total);
		$FWSPixel = ceil($graph_width*$FWSPercent/100);
		$FWSPixelE = $table_width-$FWSPixel-$division_width;
		$FWSPixelS = $table_width-$FWSPixelE-$division_width;
		
		if($FWSPixelS < 1) $FWSPixelS = 1;
	}
	else {
		$MWSPercent = 0;
		$MWSPixelE = $none_width;
		$MWSPixelS = 1;
		$FWSPercent = 0;
		$FWSPixelE = $none_width;
		$FWSPixelS = 1;
	}
	## 울산 지역 전체 회원/남성회원/여성회원 의 수 끝

	## 경기 지역 전체 회원/남성회원/여성회원 의 수 시작
	$qry_M80 = "SELECT sex, count(serialnum) as cc FROM odtMember WHERE address LIKE '경기%' AND secession='N' and (sex = 'F' or sex = 'M') and resinum != '' and birthy != '' and userType='B' group by sex";
	$res_M80 = mysql_query($qry_M80);

	$KYTotal = 0;
	$MKYTotal = 0;
	$FKYTotal = 0;

	while($row_M80 = mysql_fetch_array($res_M80)){
		if($row_M80[sex] == "M") $MKYTotal = $row_M80[cc];
		else if($row_M80[sex] == "F") $FKYTotal = $row_M80[cc];

		$KYTotal += $row_M80[cc];
	}

	## 경기 지역 회원 퍼센테이지 값 계산
	if($KYTotal >0 ) {
		$MKYPercent = floor(100*$MKYTotal/$total);
		$MKYPixel = ceil($graph_width*$MKYPercent/100);
		$MKYPixelE = $table_width-$MKYPixel-$division_width;
		$MKYPixelS = $table_width-$MKYPixelE-$division_width;
		
		if($MKYPixelS < 1) $MKYPixelS = 1;
		
		$FKYPercent = ceil(100*$FKYTotal/$total);
		$FKYPixel = ceil($graph_width*$FKYPercent/100);
		$FKYPixelE = $table_width-$FKYPixel-$division_width;
		$FKYPixelS = $table_width-$FKYPixelE-$division_width;
		
		if($FKYPixelS < 1) $FKYPixelS = 1;
	}
	else {
		$MKYPercent = 0;
		$MKYPixelE = $none_width;
		$MKYPixelS = 1;
		$FKYPercent = 0;
		$FKYPixelE = $none_width;
		$FKYPixelS = 1;
	}
	## 경기 지역 전체 회원/남성회원/여성회원 의 수 끝

	## 강원 지역 전체 회원/남성회원/여성회원 의 수 시작
	$qry_M90 = "SELECT sex, count(serialnum) as cc FROM odtMember WHERE address LIKE '강원%' AND secession='N' and (sex = 'F' or sex = 'M') and resinum != '' and birthy != '' and userType='B' group by sex";
	$res_M90 = mysql_query($qry_M90);

	$KWTotal = 0;
	$MKWTotal = 0;
	$FKWTotal = 0;

	while($row_M90 = mysql_fetch_array($res_M90)){
		if($row_M90[sex] == "M") $MKWTotal = $row_M90[cc];
		else if($row_M90[sex] == "F") $FKWTotal = $row_M90[cc];

		$KWTotal += $row_M90[cc];
	}

	## 강원 지역 회원 퍼센테이지 값 계산
	if($KWTotal >0 ) {
		$MKWPercent = floor(100*$MKWTotal/$total);
		$MKWPixel = ceil($graph_width*$MKWPercent/100);
		$MKWPixelE = $table_width-$MKWPixel-$division_width;
		$MKWPixelS = $table_width-$MKWPixelE-$division_width;
		
		if($MKWPixelS < 1) $MKWPixelS = 1;
		
		$FKWPercent = ceil(100*$FKWTotal/$total);
		$FKWPixel = ceil($graph_width*$FKWPercent/100);
		$FKWPixelE = $table_width-$FKWPixel-$division_width;
		$FKWPixelS = $table_width-$FKWPixelE-$division_width;
		
		if($FKWPixelS < 1) $FKWPixelS = 1;
	}
	else {
		$MKWPercent = 0;
		$MKWPixelE = $none_width;
		$MKWPixelS = 1;
		$FKWPercent = 0;
		$FKWPixelE = $none_width;
		$FKWPixelS = 1;
	}
	## 강원 지역 전체 회원/남성회원/여성회원 의 수 끝

	## 충남 지역 전체 회원/남성회원/여성회원 의 수 시작
	$qry_M100 = "SELECT sex, count(serialnum) as cc FROM odtMember WHERE (address LIKE '충남%' or address LIKE '충청남도%') AND secession='N' and (sex = 'F' or sex = 'M') and resinum != '' and birthy != '' and userType='B' group by sex";
	$res_M100 = mysql_query($qry_M100);

	$CNTotal = 0;
	$MCNTotal = 0;
	$FCNTotal = 0;

	while($row_M100 = mysql_fetch_array($res_M100)){
		if($row_M100[sex] == "M") $MCNTotal = $row_M100[cc];
		else if($row_M100[sex] == "F") $FCNTotal = $row_M100[cc];

		$CNTotal += $row_M100[cc];
	}

	## 충남 지역 회원 퍼센테이지 값 계산
	if($CNTotal >0 ) {
		$MCNPercent = floor(100*$MCNTotal/$total);
		$MCNPixel = ceil($graph_width*$MCNPercent/100);
		$MCNPixelE = $table_width-$MCNPixel-$division_width;
		$MCNPixelS = $table_width-$MCNPixelE-$division_width;
		
		if($MCNPixelS < 1) $MCNPixelS = 1;
		
		$FCNPercent = ceil(100*$FCNTotal/$total);
		$FCNPixel = ceil($graph_width*$FCNPercent/100);
		$FCNPixelE = $table_width-$FCNPixel-$division_width;
		$FCNPixelS = $table_width-$FCNPixelE-$division_width;
		
		if($FCNPixelS < 1) $FCNPixelS = 1;
	}
	else {
		$MCNPercent = 0;
		$MCNPixelE = $none_width;
		$MCNPixelS = 1;
		$FCNPercent = 0;
		$FCNPixelE = $none_width;
		$FCNPixelS = 1;
	}
	## 충남 지역 전체 회원/남성회원/여성회원 의 수 끝

	## 충북 지역 전체 회원/남성회원/여성회원 의 수 시작
	$qry_M110 = "SELECT sex, count(serialnum) as cc FROM odtMember WHERE (address LIKE '충북%' or address LIKE '충청북도%') AND secession='N' and (sex = 'F' or sex = 'M') and resinum != '' and birthy != '' and userType='B' group by sex";
	$res_M110 = mysql_query($qry_M110);

	$CBTotal = 0;
	$MCBTotal = 0;
	$FCBTotal = 0;

	while($row_M110 = mysql_fetch_array($res_M110)){
		if($row_M110[sex] == "M") $MCBTotal = $row_M110[cc];
		else if($row_M110[sex] == "F") $FCBTotal = $row_M110[cc];

		$CBTotal += $row_M110[cc];
	}

	## 충북 지역 회원 퍼센테이지 값 계산
	if($CBTotal >0 ) {
		$MCBPercent = floor(100*$MCBTotal/$total);
		$MCBPixel = ceil($graph_width*$MCBPercent/100);
		$MCBPixelE = $table_width-$MCBPixel-$division_width;
		$MCBPixelS = $table_width-$MCBPixelE-$division_width;
		
		if($MCBPixelS < 1) $MCBPixelS = 1;
		
		$FCBPercent = ceil(100*$FCBTotal/$total);
		$FCBPixel = ceil($graph_width*$FCBPercent/100);
		$FCBPixelE = $table_width-$FCBPixel-$division_width;
		$FCBPixelS = $table_width-$FCBPixelE-$division_width;
		
		if($FCBPixelS < 1) $FCBPixelS = 1;
	}
	else {
		$MCBPercent = 0;
		$MCBPixelE = $none_width;
		$MCBPixelS = 1;
		$FCBPercent = 0;
		$FCBPixelE = $none_width;
		$FCBPixelS = 1;
	}
	## 충북 지역 전체 회원/남성회원/여성회원 의 수 끝

	## 경남 지역 전체 회원/남성회원/여성회원 의 수 시작
	$qry_M120 = "SELECT sex, count(serialnum) as cc FROM odtMember WHERE address LIKE '경남 %' AND secession='N' and (sex = 'F' or sex = 'M') and resinum != '' and birthy != '' and userType='B' group by sex";
	$res_M120 = mysql_query($qry_M120);

	$KNTotal = 0;
	$MKNTotal = 0;
	$FKNTotal = 0;

	while($row_M120 = mysql_fetch_array($res_M120)){
		if($row_M120[sex] == "M") $MKNTotal = $row_M120[cc];
		else if($row_M120[sex] == "F") $FKNTotal = $row_M120[cc];

		$KNTotal += $row_M120[cc];
	}

	## 경남 지역 회원 퍼센테이지 값 계산
	if($KNTotal >0 ) {
		$MKNPercent = floor(100*$MKNTotal/$total);
		$MKNPixel = ceil($graph_width*$MKNPercent/100);
		$MKNPixelE = $table_width-$MKNPixel-$division_width;
		$MKNPixelS = $table_width-$MKNPixelE-$division_width;
		
		if($MKNPixelS < 1) $MKNPixelS = 1;
		
		$FKNPercent = ceil(100*$FKNTotal/$total);
		$FKNPixel = ceil($graph_width*$FKNPercent/100);
		$FKNPixelE = $table_width-$FKNPixel-$division_width;
		$FKNPixelS = $table_width-$FKNPixelE-$division_width;
		
		if($FKNPixelS < 1) $FKNPixelS = 1;
	}
	else {
		$MKNPercent = 0;
		$MKNPixelE = $none_width;
		$MKNPixelS = 1;
		$FKNPercent = 0;
		$FKNPixelE = $none_width;
		$FKNPixelS = 1;
	}
	## 경남 지역 전체 회원/남성회원/여성회원 의 수 끝

	## 경북 지역 전체 회원/남성회원/여성회원 의 수 시작
	$qry_M130 = "SELECT sex, count(serialnum) as cc FROM odtMember WHERE address LIKE '경북 %' AND secession='N' and (sex = 'F' or sex = 'M') and resinum != '' and birthy != '' and userType='B' group by sex";
	$res_M130 = mysql_query($qry_M130);

	$KBTotal = 0;
	$MKBTotal = 0;
	$FKBTotal = 0;

	while($row_M130 = mysql_fetch_array($res_M130)){
		if($row_M130[sex] == "M") $MKBTotal = $row_M130[cc];
		else if($row_M130[sex] == "F") $FKBTotal = $row_M130[cc];

		$KBTotal += $row_M130[cc];
	}

	## 경북 지역 회원 퍼센테이지 값 계산
	if($KBTotal >0 ) {
		$MKBPercent = floor(100*$MKBTotal/$total);
		$MKBPixel = ceil($graph_width*$MKBPercent/100);
		$MKBPixelE = $table_width-$MKBPixel-$division_width;
		$MKBPixelS = $table_width-$MKBPixelE-$division_width;
		
		if($MKBPixelS < 1) $MKBPixelS = 1;
		
		$FKBPercent = ceil(100*$FKBTotal/$total);
		$FKBPixel = ceil($graph_width*$FKBPercent/100);
		$FKBPixelE = $table_width-$FKBPixel-$division_width;
		$FKBPixelS = $table_width-$FKBPixelE-$division_width;
		
		if($FKBPixelS < 1) $FKBPixelS = 1;
	}
	else {
		$MKBPercent = 0;
		$MKBPixelE = $none_width;
		$MKBPixelS = 1;
		$FKBPercent = 0;
		$FKBPixelE = $none_width;
		$FKBPixelS = 1;
	}
	## 경북 지역 전체 회원/남성회원/여성회원 의 수 끝

	## 전남 지역 전체 회원/남성회원/여성회원 의 수 시작
	$qry_M140 = "SELECT sex, count(serialnum) as cc FROM odtMember WHERE address LIKE '전남 %' AND secession='N' and (sex = 'F' or sex = 'M') and resinum != '' and birthy != '' and userType='B' group by sex";
	$res_M140 = mysql_query($qry_M140);

	$JNTotal = 0;
	$MJNTotal = 0;
	$FJNTotal = 0;

	while($row_M140 = mysql_fetch_array($res_M140)){
		if($row_M140[sex] == "M") $MJNTotal = $row_M140[cc];
		else if($row_M140[sex] == "F") $FJNTotal = $row_M140[cc];

		$JNTotal += $row_M140[cc];
	}

	## 전남 지역 회원 퍼센테이지 값 계산
	if($JNTotal >0 ) {
		$MJNPercent = floor(100*$MJNTotal/$total);
		$MJNPixel = ceil($graph_width*$MJNPercent/100);
		$MJNPixelE = $table_width-$MJNPixel-$division_width;
		$MJNPixelS = $table_width-$MJNPixelE-$division_width;
		
		if($MJNPixelS < 1) $MJNPixelS = 1;
		
		$FJNPercent = ceil(100*$FJNTotal/$total);
		$FJNPixel = ceil($graph_width*$FJNPercent/100);
		$FJNPixelE = $table_width-$FJNPixel-$division_width;
		$FJNPixelS = $table_width-$FJNPixelE-$division_width;
		
		if($FJNPixelS < 1) $FJNPixelS = 1;
	}
	else {
		$MJNPercent = 0;
		$MJNPixelE = $none_width;
		$MJNPixelS = 1;
		$FJNPercent = 0;
		$FJNPixelE = $none_width;
		$FJNPixelS = 1;
	}
	## 전남 지역 전체 회원/남성회원/여성회원 의 수 끝

	## 전북 지역 전체 회원/남성회원/여성회원 의 수 시작
	$qry_M150 = "SELECT sex, count(serialnum) as cc FROM odtMember WHERE address LIKE '전북 %' AND secession='N' and (sex = 'F' or sex = 'M') and resinum != '' and birthy != '' and userType='B' group by sex";
	$res_M150 = mysql_query($qry_M150);

	$JBTotal = 0;
	$MJBTotal = 0;
	$FJBTotal = 0;

	while($row_M150 = mysql_fetch_array($res_M150)){
		if($row_M150[sex] == "M") $MJBTotal = $row_M150[cc];
		else if($row_M150[sex] == "F") $FJBTotal = $row_M150[cc];

		$JBTotal += $row_M150[cc];
	}

	## 전북 지역 회원 퍼센테이지 값 계산
	if($JBTotal >0 ) {
		$MJBPercent = floor(100*$MJBTotal/$total);
		$MJBPixel = ceil($graph_width*$MJBPercent/100);
		$MJBPixelE = $table_width-$MJBPixel-$division_width;
		$MJBPixelS = $table_width-$MJBPixelE-$division_width;
		
		if($MJBPixelS < 1) $MJBPixelS = 1;
		
		$FJBPercent = ceil(100*$FJBTotal/$total);
		$FJBPixel = ceil($graph_width*$FJBPercent/100);
		$FJBPixelE = $table_width-$FJBPixel-$division_width;
		$FJBPixelS = $table_width-$FJBPixelE-$division_width;
		
		if($FJBPixelS < 1) $FJBPixelS = 1;
	}
	else {
		$MJBPercent = 0;
		$MJBPixelE = $none_width;
		$MJBPixelS = 1;
		$FJBPercent = 0;
		$FJBPixelE = $none_width;
		$FJBPixelS = 1;
	}
	## 전북 지역 전체 회원/남성회원/여성회원 의 수 끝

	## 제주 지역 전체 회원/남성회원/여성회원 의 수 시작
	$qry_M160 = "SELECT sex, count(serialnum) as cc FROM odtMember WHERE address LIKE '제주 %' AND secession='N' and (sex = 'F' or sex = 'M') and resinum != '' and birthy != '' and userType='B' group by sex";
	$res_M160 = mysql_query($qry_M160);

	$JJTotal = 0;
	$MJJTotal = 0;
	$FJJTotal = 0;

	while($row_M160 = mysql_fetch_array($res_M160)){
		if($row_M160[sex] == "M") $MJJTotal = $row_M160[cc];
		else if($row_M160[sex] == "F") $FJJTotal = $row_M160[cc];

		$JJTotal += $row_M160[cc];
	}

	## 제주 지역 회원 퍼센테이지 값 계산
	if($JJTotal >0 ) {
		$MJJPercent = floor(100*$MJJTotal/$total);
		$MJJPixel = ceil($graph_width*$MJJPercent/100);
		$MJJPixelE = $table_width-$MJJPixel-$division_width;
		$MJJPixelS = $table_width-$MJJPixelE-$division_width;
		
		if($MJJPixelS < 1) $MJJPixelS = 1;
		
		$FJJPercent = ceil(100*$FJJTotal/$total);
		$FJJPixel = ceil($graph_width*$FJJPercent/100);
		$FJJPixelE = $table_width-$FJJPixel-$division_width;
		$FJJPixelS = $table_width-$FJJPixelE-$division_width;
		
		if($FJJPixelS < 1) $FJJPixelS = 1;
	}
	else {
		$MJJPercent = 0;
		$MJJPixelE = $none_width;
		$MJJPixelS = 1;
		$FJJPercent = 0;
		$FJJPixelE = $none_width;
		$FJJPixelS = 1;
	}
	## 제주 지역 전체 회원/남성회원/여성회원 의 수 끝
	#################################################
	## 지역별 회원/남성회원/여성회원 의 수 끝
	#################################################	
?>

		<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
			<tr> 
				<td height="80" bgcolor="#FFFFFF">
					<!-- top menu start -->
<? include "$folderpath_manager_common/od_topMenu.inc.php"; ?>
					<!-- top menu end -->
				</td>
			</tr>
			<tr> 
				<td valign="top"> 
					<table width="100%" border="0" cellspacing="0" cellpadding="0">
						<tr>
							<td height="6"></td>
						</tr>
					</table>
					<table height="100%" border="0" cellpadding="0" cellspacing="0">
						<tr>
							<td width="165" height="100%" valign="top"> 
								<!-- left menu start -->
<? include "$folderpath_manager_common/od_leftMenu.inc.php"; ?>
								<!-- left menu end -->
							</td>
							<td width="3">&nbsp;</td>
							<td width="782" valign="top">
								<!-- main table start -->
								<table width="782" height="100%" border="0" cellpadding="10" cellspacing="1" bgcolor="D6D6D6">
									<tr> 
										<td align="center" valign="top" bgcolor="#FFFFFF"> 
											<table width="100%" border="0" cellspacing="0" cellpadding="0">
												<tr> 
													<td height="33"><font color="313D7D"><img src="../odimages/odmain/title_icon.gif" width="13" height="13" hspace="1" align="absmiddle"> 회원관리 &gt; <span class="st">지역대별 회원통계</span></font></td>
												</tr>
												<tr> 
													<td height="2" bgcolor="D6D6D6"></td>
												</tr>
											</table>
											<table width="100%" border="0" cellspacing="1" cellpadding="0">
												<tr>
													<td height="7"></td>
												</tr>
											</table>
											<table width="760" border="0" cellspacing="0" cellpadding="0">
												<tr> 
													<td valign="top">
														<table width="760" border="0" cellspacing="0" cellpadding="0">
															<tr> 
																<td height="3" colspan="11" bgcolor="FFFFFF"></td>
															</tr>
															<tr> 
																<td height="1" colspan="11" bgcolor="c0bebe"></td>
															</tr>
															<tr align="center"> 
																<td width="144" height="27" bgcolor="ececec" class="white">전체회원</td>
																<td width="60" bgcolor="ececec" class="white" >남성회원</td>
																<td width="248" bgcolor="ececec" class="white"></td>
																<td width="60" bgcolor="ececec" class="white">여성회원</td>
																<td width="248" bgcolor="ececec" class="white"></td>
															</tr>
															<tr> 
																<td height="1" colspan="11" bgcolor="c0bebe"></td>
															</tr>
															<tr> 
																<td height="2" colspan="11"></td>
															</tr>
														</table>
														<table width="760" border="0" cellspacing="0" cellpadding="0">
															<tr> 
																<td height='1' colspan='11' bgcolor='D2D2D2'></td>
															</tr>
															<tr> 
																<td height='5' colspan='11' bgcolor='FAFAFA'></td>
															</tr>
															<tr height='23'> 
																<td width='144' align='center' bgcolor='FAFAFA'><b><?=$total?></b>명</td>
																<td width='60' align='center' bgcolor='FAFAFA'><b><?=$MTotal?></b>명</td>
																<td width='248' align='center' bgcolor='FAFAFA'>
																	<table width="248" border="0" cellspacing="0" cellpadding="0" class="text-2">
																		<tr> 
																			<td width="<?=$MPixelS?>"> 
																				<table width="100%" border="0" cellspacing="0" cellpadding="0" height="8" background="../images/pix03.gif">
																					<tr><td height="16"></td></tr>
																				</table>
																			</td>
																			<td width="<?=$MPixelE?>">&nbsp;<?=$SexPercentM?>%</td>
																		</tr>
																	</table>
																</td>
																<td width='60' align='center' bgcolor='FAFAFA'><b><?=$FMTotal?></b>명</td>
																<td width='248' align='center' bgcolor='FAFAFA'>
																	<table width="248" border="0" cellspacing="0" cellpadding="0" class="text-2">
																		<tr> 
																			<td width="<?=$FPixelS?>"> 
																				<table width="100%" border="0" cellspacing="0" cellpadding="0" height="8" background="../images/pix04.gif">
																					<tr><td height="16"></td></tr>
																				</table>
																			</td>
																			<td width="<?=$FPixelE?>">&nbsp;<?=$SexPercentFM?>%</td>
																		</tr>
																	</table>
																</td>
															</tr>
															<tr> 
																<td height='5' colspan='11' bgcolor='FAFAFA'></td>
															</tr>
															<tr> 
																<td height='1' colspan='11' bgcolor='D2D2D2'></td>
															</tr>
														</table>
														<table width="760" border="0" cellspacing="1" cellpadding="0">
															<tr> 
																<td height="25"></td>
															</tr>
														</table>
														<table width="760" border="0" cellspacing="0" cellpadding="0">
															<tr> 
																<td height="3" colspan="11" bgcolor="FFFFFF"></td>
															</tr>
															<tr> 
																<td height="1" colspan="11" bgcolor="c0bebe"></td>
															</tr>
															<tr align="center"> 
																<td width="84" height="27" bgcolor="ececec" class="white">구분</td>
																<td width="60" height="27" bgcolor="ececec" class="white">전체</td>
																<td width="60" bgcolor="ececec" class="white" >남성회원</td>
																<td width="248" bgcolor="ececec" class="white"></td>
																<td width="60" bgcolor="ececec" class="white">여성회원</td>
																<td width="248" bgcolor="ececec" class="white"></td>
															</tr>
															<tr> 
																<td height="1" colspan="11" bgcolor="c0bebe"></td>
															</tr>
															<tr> 
																<td height="2" colspan="11"></td>
															</tr>
														</table>
														<table width="760" border="0" cellspacing="0" cellpadding="0">
															<tr> 
																<td height='1' colspan='11' bgcolor='D2D2D2'></td>
															</tr>
															<tr> 
																<td height='5' colspan='11' bgcolor='FAFAFA'></td>
															</tr>
															<tr height='23'> 
																<td width='84' align='center' bgcolor='FAFAFA'><b><font color="005190">서울</font></b></td>
																<td width='60' align='center' bgcolor='FAFAFA'><b><?=$SETotal?></b>명</td>
																<td width='60' align='center' bgcolor='FAFAFA'><b><?=$MSETotal?></b>명</td>
																<td width='248' align='center' bgcolor='FAFAFA'>
																	<table width="248" border="0" cellspacing="0" cellpadding="0" class="text-2">
																		<tr> 
																			<td width="<?=$MSEPixelS?>"> 
																				<table width="100%" border="0" cellspacing="0" cellpadding="0" height="8" background="../images/pix03.gif">
																					<tr><td height="16"></td></tr>
																				</table>
																			</td>
																			<td width="<?=$MSEPixelE?>">&nbsp;<?=$MSEPercentM?>%</td>
																		</tr>
																	</table>
																</td>
																<td width='60' align='center' bgcolor='FAFAFA'><b><?=$FSETotal?></b>명</td>
																<td width='248' align='center' bgcolor='FAFAFA'>
																	<table width="248" border="0" cellspacing="0" cellpadding="0" class="text-2">
																		<tr> 
																			<td width="<?=$FSEPixelS?>"> 
																				<table width="100%" border="0" cellspacing="0" cellpadding="0" height="8" background="../images/pix04.gif">
																					<tr><td height="16"></td></tr>
																				</table>
																			</td>
																			<td width="<?=$FSEPixelE?>">&nbsp;<?=$FSEPercentFM?>%</td>
																		</tr>
																	</table>
																</td>
															</tr>
															<tr> 
																<td height='5' colspan='11' bgcolor='FAFAFA'></td>
															</tr>
															<tr> 
																<td height='1' colspan='11' bgcolor='D2D2D2'></td>
															</tr>
															<tr> 
																<td height='5' colspan='11' bgcolor='FAFAFA'></td>
															</tr>
															<tr height='23'> 
																<td width='84' align='center' bgcolor='FAFAFA'><b><font color="005190">인천</font></b></td>
																<td width='60' align='center' bgcolor='FAFAFA'><b><?=$INTotal?></b>명</td>
																<td width='60' align='center' bgcolor='FAFAFA'><b><?=$MINTotal?></b>명</td>
																<td width='248' align='center' bgcolor='FAFAFA'>
																	<table width="248" border="0" cellspacing="0" cellpadding="0" class="text-2">
																		<tr> 
																			<td width="<?=$MINPixelS?>"> 
																				<table width="100%" border="0" cellspacing="0" cellpadding="0" height="8" background="../images/pix03.gif">
																					<tr><td height="16"></td></tr>
																				</table>
																			</td>
																			<td width="<?=$MINPixelE?>">&nbsp;<?=$MINPercentM?>%</td>
																		</tr>
																	</table>
																</td>
																<td width='60' align='center' bgcolor='FAFAFA'><b><?=$FINTotal?></b>명</td>
																<td width='248' align='center' bgcolor='FAFAFA'>
																	<table width="248" border="0" cellspacing="0" cellpadding="0" class="text-2">
																		<tr> 
																			<td width="<?=$FINPixelS?>"> 
																				<table width="100%" border="0" cellspacing="0" cellpadding="0" height="8" background="../images/pix04.gif">
																					<tr><td height="16"></td></tr>
																				</table>
																			</td>
																			<td width="<?=$FINPixelE?>">&nbsp;<?=$FINPercentF?>%</td>
																		</tr>
																	</table>
																</td>
															</tr>
															<tr> 
																<td height='5' colspan='11' bgcolor='FAFAFA'></td>
															</tr>
															<tr> 
																<td height='1' colspan='11' bgcolor='D2D2D2'></td>
															</tr>
															<tr> 
																<td height='5' colspan='11' bgcolor='FAFAFA'></td>
															</tr>
															<tr height='23'> 
																<td width='84' align='center' bgcolor='FAFAFA'><b><font color="005190">광주</font></b></td>
																<td width='60' align='center' bgcolor='FAFAFA'><b><?=$KJTotal?></b>명</td>
																<td width='60' align='center' bgcolor='FAFAFA'><b><?=$MKJTotal?></b>명</td>
																<td width='248' align='center' bgcolor='FAFAFA'>
																	<table width="248" border="0" cellspacing="0" cellpadding="0" class="text-2">
																		<tr> 
																			<td width="<?=$MKJPixelS?>"> 
																				<table width="100%" border="0" cellspacing="0" cellpadding="0" height="8" background="../images/pix03.gif">
																					<tr><td height="16"></td></tr>
																				</table>
																			</td>
																			<td width="<?=$MKJPixelE?>">&nbsp;<?=$MKJPercent?>%</td>
																		</tr>
																	</table>
																</td>
																<td width='60' align='center' bgcolor='FAFAFA'><b><?=$FKJTotal?></b>명</td>
																<td width='248' align='center' bgcolor='FAFAFA'>
																	<table width="248" border="0" cellspacing="0" cellpadding="0" class="text-2">
																		<tr> 
																			<td width="<?=$FKJPixelS?>"> 
																				<table width="100%" border="0" cellspacing="0" cellpadding="0" height="8" background="../images/pix04.gif">
																					<tr><td height="16"></td></tr>
																				</table>
																			</td>
																			<td width="<?=$FKJPixelE?>">&nbsp;<?=$FKJPercent?>%</td>
																		</tr>
																	</table>
																</td>
															</tr>
															<tr> 
																<td height='5' colspan='11' bgcolor='FAFAFA'></td>
															</tr>
															<tr> 
																<td height='1' colspan='11' bgcolor='D2D2D2'></td>
															</tr>
															<tr> 
																<td height='5' colspan='11' bgcolor='FAFAFA'></td>
															</tr>
															<tr height='23'> 
																<td width='84' align='center' bgcolor='FAFAFA'><b><font color="005190">대구</font></b></td>
																<td width='60' align='center' bgcolor='FAFAFA'><b><?=$DGTotal?></b>명</td>
																<td width='60' align='center' bgcolor='FAFAFA'><b><?=$MDGTotal?></b>명</td>
																<td width='248' align='center' bgcolor='FAFAFA'>
																	<table width="248" border="0" cellspacing="0" cellpadding="0" class="text-2">
																		<tr> 
																			<td width="<?=$MDGPixelS?>"> 
																				<table width="100%" border="0" cellspacing="0" cellpadding="0" height="8" background="../images/pix03.gif">
																					<tr><td height="16"></td></tr>
																				</table>
																			</td>
																			<td width="<?=$MDGPixelE?>">&nbsp;<?=$MDGPercent?>%</td>
																		</tr>
																	</table>
																</td>
																<td width='60' align='center' bgcolor='FAFAFA'><b><?=$FDGTotal?></b>명</td>
																<td width='248' align='center' bgcolor='FAFAFA'>
																	<table width="248" border="0" cellspacing="0" cellpadding="0" class="text-2">
																		<tr> 
																			<td width="<?=$FDGPixelS?>"> 
																				<table width="100%" border="0" cellspacing="0" cellpadding="0" height="8" background="../images/pix04.gif">
																					<tr><td height="16"></td></tr>
																				</table>
																			</td>
																			<td width="<?=$FDGPixelE?>">&nbsp;<?=$FDGPercent?>%</td>
																		</tr>
																	</table>
																</td>
															</tr>
															<tr> 
																<td height='5' colspan='11' bgcolor='FAFAFA'></td>
															</tr>
															<tr> 
																<td height='1' colspan='11' bgcolor='D2D2D2'></td>
															</tr>
															<tr> 
																<td height='5' colspan='11' bgcolor='FAFAFA'></td>
															</tr>
															<tr height='23'> 
																<td width='84' align='center' bgcolor='FAFAFA'><b><font color="005190">대전</font></b></td>
																<td width='60' align='center' bgcolor='FAFAFA'><b><?=$DJTotal?></b>명</td>
																<td width='60' align='center' bgcolor='FAFAFA'><b><?=$MDJTotal?></b>명</td>
																<td width='248' align='center' bgcolor='FAFAFA'>
																	<table width="248" border="0" cellspacing="0" cellpadding="0" class="text-2">
																		<tr> 
																			<td width="<?=$MDJPixelS?>"> 
																				<table width="100%" border="0" cellspacing="0" cellpadding="0" height="8" background="../images/pix03.gif">
																					<tr><td height="16"></td></tr>
																				</table>
																			</td>
																			<td width="<?=$MDJPixelE?>">&nbsp;<?=$MDJPercent?>%</td>
																		</tr>
																	</table>
																</td>
																<td width='60' align='center' bgcolor='FAFAFA'><b><?=$FDJTotal?></b>명</td>
																<td width='248' align='center' bgcolor='FAFAFA'>
																	<table width="248" border="0" cellspacing="0" cellpadding="0" class="text-2">
																		<tr> 
																			<td width="<?=$FDJPixelS?>"> 
																				<table width="100%" border="0" cellspacing="0" cellpadding="0" height="8" background="../images/pix04.gif">
																					<tr><td height="16"></td></tr>
																				</table>
																			</td>
																			<td width="<?=$FDJPixelE?>">&nbsp;<?=$FDJPercent?>%</td>
																		</tr>
																	</table>
																</td>
															</tr>
															<tr> 
																<td height='5' colspan='11' bgcolor='FAFAFA'></td>
															</tr>
															<tr> 
																<td height='1' colspan='11' bgcolor='D2D2D2'></td>
															</tr>
															<tr> 
																<td height='5' colspan='11' bgcolor='FAFAFA'></td>
															</tr>
															<tr height='23'> 
																<td width='84' align='center' bgcolor='FAFAFA'><b><font color="005190">부산</font></b></td>
																<td width='60' align='center' bgcolor='FAFAFA'><b><?=$PSTotal?></b>명</td>
																<td width='60' align='center' bgcolor='FAFAFA'><b><?=$MPSTotal?></b>명</td>
																<td width='248' align='center' bgcolor='FAFAFA'>
																	<table width="248" border="0" cellspacing="0" cellpadding="0" class="text-2">
																		<tr> 
																			<td width="<?=$MPSPixelS?>"> 
																				<table width="100%" border="0" cellspacing="0" cellpadding="0" height="8" background="../images/pix03.gif">
																					<tr><td height="16"></td></tr>
																				</table>
																			</td>
																			<td width="<?=$MPSPixelE?>">&nbsp;<?=$MPSPercent?>%</td>
																		</tr>
																	</table>
																</td>
																<td width='60' align='center' bgcolor='FAFAFA'><b><?=$FPSTotal?></b>명</td>
																<td width='248' align='center' bgcolor='FAFAFA'>
																	<table width="248" border="0" cellspacing="0" cellpadding="0" class="text-2">
																		<tr> 
																			<td width="<?=$FPSPixelS?>"> 
																				<table width="100%" border="0" cellspacing="0" cellpadding="0" height="8" background="../images/pix04.gif">
																					<tr><td height="16"></td></tr>
																				</table>
																			</td>
																			<td width="<?=$FPSPixelE?>">&nbsp;<?=$FPSPercent?>%</td>
																		</tr>
																	</table>
																</td>
															</tr>
															<tr> 
																<td height='5' colspan='11' bgcolor='FAFAFA'></td>
															</tr>
															<tr> 
																<td height='1' colspan='11' bgcolor='D2D2D2'></td>
															</tr>
															<tr> 
																<td height='5' colspan='11' bgcolor='FAFAFA'></td>
															</tr>
															<tr height='23'> 
																<td width='84' align='center' bgcolor='FAFAFA'><b><font color="005190">울산</font></b></td>
																<td width='60' align='center' bgcolor='FAFAFA'><b><?=$WSTotal?></b>명</td>
																<td width='60' align='center' bgcolor='FAFAFA'><b><?=$MWSTotal?></b>명</td>
																<td width='248' align='center' bgcolor='FAFAFA'>
																	<table width="248" border="0" cellspacing="0" cellpadding="0" class="text-2">
																		<tr> 
																			<td width="<?=$MWSPixelS?>"> 
																				<table width="100%" border="0" cellspacing="0" cellpadding="0" height="8" background="../images/pix03.gif">
																					<tr><td height="16"></td></tr>
																				</table>
																			</td>
																			<td width="<?=$MWSPixelE?>">&nbsp;<?=$MWSPercent?>%</td>
																		</tr>
																	</table>
																</td>
																<td width='60' align='center' bgcolor='FAFAFA'><b><?=$FWSTotal?></b>명</td>
																<td width='248' align='center' bgcolor='FAFAFA'>
																	<table width="248" border="0" cellspacing="0" cellpadding="0" class="text-2">
																		<tr> 
																			<td width="<?=$FWSPixelS?>"> 
																				<table width="100%" border="0" cellspacing="0" cellpadding="0" height="8" background="../images/pix04.gif">
																					<tr><td height="16"></td></tr>
																				</table>
																			</td>
																			<td width="<?=$FWSPixelE?>">&nbsp;<?=$FWSPercent?>%</td>
																		</tr>
																	</table>
																</td>
															</tr>
															<tr> 
																<td height='5' colspan='11' bgcolor='FAFAFA'></td>
															</tr>
															<tr> 
																<td height='1' colspan='11' bgcolor='D2D2D2'></td>
															</tr>
															<tr> 
																<td height='5' colspan='11' bgcolor='FAFAFA'></td>
															</tr>
															<tr height='23'> 
																<td width='84' align='center' bgcolor='FAFAFA'><b><font color="005190">경기</font></b></td>
																<td width='60' align='center' bgcolor='FAFAFA'><b><?=$KYTotal?></b>명</td>
																<td width='60' align='center' bgcolor='FAFAFA'><b><?=$MKYTotal?></b>명</td>
																<td width='248' align='center' bgcolor='FAFAFA'>
																	<table width="248" border="0" cellspacing="0" cellpadding="0" class="text-2">
																		<tr> 
																			<td width="<?=$MKYPixelS?>"> 
																				<table width="100%" border="0" cellspacing="0" cellpadding="0" height="8" background="../images/pix03.gif">
																					<tr><td height="16"></td></tr>
																				</table>
																			</td>
																			<td width="<?=$MKYPixelE?>">&nbsp;<?=$MKYPercent?>%</td>
																		</tr>
																	</table>
																</td>
																<td width='60' align='center' bgcolor='FAFAFA'><b><?=$FKYTotal?></b>명</td>
																<td width='248' align='center' bgcolor='FAFAFA'>
																	<table width="248" border="0" cellspacing="0" cellpadding="0" class="text-2">
																		<tr> 
																			<td width="<?=$FKYPixelS?>"> 
																				<table width="100%" border="0" cellspacing="0" cellpadding="0" height="8" background="../images/pix04.gif">
																					<tr><td height="16"></td></tr>
																				</table>
																			</td>
																			<td width="<?=$FKYPixelE?>">&nbsp;<?=$FKYPercent?>%</td>
																		</tr>
																	</table>
																</td>
															</tr>
															<tr> 
																<td height='5' colspan='11' bgcolor='FAFAFA'></td>
															</tr>
															<tr> 
																<td height='1' colspan='11' bgcolor='D2D2D2'></td>
															</tr>
															<tr> 
																<td height='5' colspan='11' bgcolor='FAFAFA'></td>
															</tr>
															<tr height='23'> 
																<td width='84' align='center' bgcolor='FAFAFA'><b><font color="005190">강원</font></b></td>
																<td width='60' align='center' bgcolor='FAFAFA'><b><?=$KWTotal?></b>명</td>
																<td width='60' align='center' bgcolor='FAFAFA'><b><?=$MKWTotal?></b>명</td>
																<td width='248' align='center' bgcolor='FAFAFA'>
																	<table width="248" border="0" cellspacing="0" cellpadding="0" class="text-2">
																		<tr> 
																			<td width="<?=$MKWPixelS?>"> 
																				<table width="100%" border="0" cellspacing="0" cellpadding="0" height="8" background="../images/pix03.gif">
																					<tr><td height="16"></td></tr>
																				</table>
																			</td>
																			<td width="<?=$MKWPixelE?>">&nbsp;<?=$MKWPercent?>%</td>
																		</tr>
																	</table>
																</td>
																<td width='60' align='center' bgcolor='FAFAFA'><b><?=$FKWTotal?></b>명</td>
																<td width='248' align='center' bgcolor='FAFAFA'>
																	<table width="248" border="0" cellspacing="0" cellpadding="0" class="text-2">
																		<tr> 
																			<td width="<?=$FKWPixelS?>"> 
																				<table width="100%" border="0" cellspacing="0" cellpadding="0" height="8" background="../images/pix04.gif">
																					<tr><td height="16"></td></tr>
																				</table>
																			</td>
																			<td width="<?=$FKWPixelE?>">&nbsp;<?=$FKWPercent?>%</td>
																		</tr>
																	</table>
																</td>
															</tr>
															<tr> 
																<td height='5' colspan='11' bgcolor='FAFAFA'></td>
															</tr>
															<tr> 
																<td height='1' colspan='11' bgcolor='D2D2D2'></td>
															</tr>
															<tr> 
																<td height='5' colspan='11' bgcolor='FAFAFA'></td>
															</tr>
															<tr height='23'> 
																<td width='84' align='center' bgcolor='FAFAFA'><b><font color="005190">충남</font></b></td>
																<td width='60' align='center' bgcolor='FAFAFA'><b><?=$CNTotal?></b>명</td>
																<td width='60' align='center' bgcolor='FAFAFA'><b><?=$MCNTotal?></b>명</td>
																<td width='248' align='center' bgcolor='FAFAFA'>
																	<table width="248" border="0" cellspacing="0" cellpadding="0" class="text-2">
																		<tr> 
																			<td width="<?=$MCNPixelS?>"> 
																				<table width="100%" border="0" cellspacing="0" cellpadding="0" height="8" background="../images/pix03.gif">
																					<tr><td height="16"></td></tr>
																				</table>
																			</td>
																			<td width="<?=$MCNPixelE?>">&nbsp;<?=$MCNPercent?>%</td>
																		</tr>
																	</table>
																</td>
																<td width='60' align='center' bgcolor='FAFAFA'><b><?=$FCNTotal?></b>명</td>
																<td width='248' align='center' bgcolor='FAFAFA'>
																	<table width="248" border="0" cellspacing="0" cellpadding="0" class="text-2">
																		<tr> 
																			<td width="<?=$FCNPixelS?>"> 
																				<table width="100%" border="0" cellspacing="0" cellpadding="0" height="8" background="../images/pix04.gif">
																					<tr><td height="16"></td></tr>
																				</table>
																			</td>
																			<td width="<?=$FCNPixelE?>">&nbsp;<?=$FCNPercent?>%</td>
																		</tr>
																	</table>
																</td>
															</tr>
															<tr> 
																<td height='5' colspan='11' bgcolor='FAFAFA'></td>
															</tr>
															<tr> 
																<td height='1' colspan='11' bgcolor='D2D2D2'></td>
															</tr>
															<tr> 
																<td height='5' colspan='11' bgcolor='FAFAFA'></td>
															</tr>
															<tr height='23'> 
																<td width='84' align='center' bgcolor='FAFAFA'><b><font color="005190">충북</font></b></td>
																<td width='60' align='center' bgcolor='FAFAFA'><b><?=$CBTotal?></b>명</td>
																<td width='60' align='center' bgcolor='FAFAFA'><b><?=$MCBTotal?></b>명</td>
																<td width='248' align='center' bgcolor='FAFAFA'>
																	<table width="248" border="0" cellspacing="0" cellpadding="0" class="text-2">
																		<tr> 
																			<td width="<?=$MCBPixelS?>"> 
																				<table width="100%" border="0" cellspacing="0" cellpadding="0" height="8" background="../images/pix03.gif">
																					<tr><td height="16"></td></tr>
																				</table>
																			</td>
																			<td width="<?=$MCBPixelE?>">&nbsp;<?=$MCBPercent?>%</td>
																		</tr>
																	</table>
																</td>
																<td width='60' align='center' bgcolor='FAFAFA'><b><?=$FCBTotal?></b>명</td>
																<td width='248' align='center' bgcolor='FAFAFA'>
																	<table width="248" border="0" cellspacing="0" cellpadding="0" class="text-2">
																		<tr> 
																			<td width="<?=$FCBPixelS?>"> 
																				<table width="100%" border="0" cellspacing="0" cellpadding="0" height="8" background="../images/pix04.gif">
																					<tr><td height="16"></td></tr>
																				</table>
																			</td>
																			<td width="<?=$FCBPixelE?>">&nbsp;<?=$FCBPercent?>%</td>
																		</tr>
																	</table>
																</td>
															</tr>
															<tr> 
																<td height='5' colspan='11' bgcolor='FAFAFA'></td>
															</tr>
															<tr> 
																<td height='1' colspan='11' bgcolor='D2D2D2'></td>
															</tr>
															<tr> 
																<td height='5' colspan='11' bgcolor='FAFAFA'></td>
															</tr>
															<tr height='23'> 
																<td width='84' align='center' bgcolor='FAFAFA'><b><font color="005190">경남</font></b></td>
																<td width='60' align='center' bgcolor='FAFAFA'><b><?=$KNTotal?></b>명</td>
																<td width='60' align='center' bgcolor='FAFAFA'><b><?=$MKNTotal?></b>명</td>
																<td width='248' align='center' bgcolor='FAFAFA'>
																	<table width="248" border="0" cellspacing="0" cellpadding="0" class="text-2">
																		<tr> 
																			<td width="<?=$MKNPixelS?>"> 
																				<table width="100%" border="0" cellspacing="0" cellpadding="0" height="8" background="../images/pix03.gif">
																					<tr><td height="16"></td></tr>
																				</table>
																			</td>
																			<td width="<?=$MKNPixelE?>">&nbsp;<?=$MKNPercent?>%</td>
																		</tr>
																	</table>
																</td>
																<td width='60' align='center' bgcolor='FAFAFA'><b><?=$FKNTotal?></b>명</td>
																<td width='248' align='center' bgcolor='FAFAFA'>
																	<table width="248" border="0" cellspacing="0" cellpadding="0" class="text-2">
																		<tr> 
																			<td width="<?=$FKNPixelS?>"> 
																				<table width="100%" border="0" cellspacing="0" cellpadding="0" height="8" background="../images/pix04.gif">
																					<tr><td height="16"></td></tr>
																				</table>
																			</td>
																			<td width="<?=$FKNPixelE?>">&nbsp;<?=$FKNPercent?>%</td>
																		</tr>
																	</table>
																</td>
															</tr>
															<tr> 
																<td height='5' colspan='11' bgcolor='FAFAFA'></td>
															</tr>
															<tr> 
																<td height='1' colspan='11' bgcolor='D2D2D2'></td>
															</tr>
															<tr> 
																<td height='5' colspan='11' bgcolor='FAFAFA'></td>
															</tr>
															<tr height='23'> 
																<td width='84' align='center' bgcolor='FAFAFA'><b><font color="005190">경북</font></b></td>
																<td width='60' align='center' bgcolor='FAFAFA'><b><?=$KBTotal?></b>명</td>
																<td width='60' align='center' bgcolor='FAFAFA'><b><?=$MKBTotal?></b>명</td>
																<td width='248' align='center' bgcolor='FAFAFA'>
																	<table width="248" border="0" cellspacing="0" cellpadding="0" class="text-2">
																		<tr> 
																			<td width="<?=$MKBPixelS?>"> 
																				<table width="100%" border="0" cellspacing="0" cellpadding="0" height="8" background="../images/pix03.gif">
																					<tr><td height="16"></td></tr>
																				</table>
																			</td>
																			<td width="<?=$MKBPixelE?>">&nbsp;<?=$MKBPercent?>%</td>
																		</tr>
																	</table>
																</td>
																<td width='60' align='center' bgcolor='FAFAFA'><b><?=$FKBTotal?></b>명</td>
																<td width='248' align='center' bgcolor='FAFAFA'>
																	<table width="248" border="0" cellspacing="0" cellpadding="0" class="text-2">
																		<tr> 
																			<td width="<?=$FKBPixelS?>"> 
																				<table width="100%" border="0" cellspacing="0" cellpadding="0" height="8" background="../images/pix04.gif">
																					<tr><td height="16"></td></tr>
																				</table>
																			</td>
																			<td width="<?=$FKBPixelE?>">&nbsp;<?=$FKBPercent?>%</td>
																		</tr>
																	</table>
																</td>
															</tr>
															<tr> 
																<td height='5' colspan='11' bgcolor='FAFAFA'></td>
															</tr>
															<tr> 
																<td height='1' colspan='11' bgcolor='D2D2D2'></td>
															</tr>
															<tr> 
																<td height='5' colspan='11' bgcolor='FAFAFA'></td>
															</tr>
															<tr height='23'> 
																<td width='84' align='center' bgcolor='FAFAFA'><b><font color="005190">전남</font></b></td>
																<td width='60' align='center' bgcolor='FAFAFA'><b><?=$JNTotal?></b>명</td>
																<td width='60' align='center' bgcolor='FAFAFA'><b><?=$MJNTotal?></b>명</td>
																<td width='248' align='center' bgcolor='FAFAFA'>
																	<table width="248" border="0" cellspacing="0" cellpadding="0" class="text-2">
																		<tr> 
																			<td width="<?=$MJNPixelS?>"> 
																				<table width="100%" border="0" cellspacing="0" cellpadding="0" height="8" background="../images/pix03.gif">
																					<tr><td height="16"></td></tr>
																				</table>
																			</td>
																			<td width="<?=$MJNPixelE?>">&nbsp;<?=$MJNPercent?>%</td>
																		</tr>
																	</table>
																</td>
																<td width='60' align='center' bgcolor='FAFAFA'><b><?=$FJNTotal?></b>명</td>
																<td width='248' align='center' bgcolor='FAFAFA'>
																	<table width="248" border="0" cellspacing="0" cellpadding="0" class="text-2">
																		<tr> 
																			<td width="<?=$FJNPixelS?>"> 
																				<table width="100%" border="0" cellspacing="0" cellpadding="0" height="8" background="../images/pix04.gif">
																					<tr><td height="16"></td></tr>
																				</table>
																			</td>
																			<td width="<?=$FJNPixelE?>">&nbsp;<?=$FJNPercent?>%</td>
																		</tr>
																	</table>
																</td>
															</tr>
															<tr> 
																<td height='5' colspan='11' bgcolor='FAFAFA'></td>
															</tr>
															<tr> 
																<td height='1' colspan='11' bgcolor='D2D2D2'></td>
															</tr>
															<tr> 
																<td height='5' colspan='11' bgcolor='FAFAFA'></td>
															</tr>
															<tr height='23'> 
																<td width='84' align='center' bgcolor='FAFAFA'><b><font color="005190">전북</font></b></td>
																<td width='60' align='center' bgcolor='FAFAFA'><b><?=$JBTotal?></b>명</td>
																<td width='60' align='center' bgcolor='FAFAFA'><b><?=$MJBTotal?></b>명</td>
																<td width='248' align='center' bgcolor='FAFAFA'>
																	<table width="248" border="0" cellspacing="0" cellpadding="0" class="text-2">
																		<tr> 
																			<td width="<?=$MJBPixelS?>"> 
																				<table width="100%" border="0" cellspacing="0" cellpadding="0" height="8" background="../images/pix03.gif">
																					<tr><td height="16"></td></tr>
																				</table>
																			</td>
																			<td width="<?=$MJBPixelE?>">&nbsp;<?=$MJBPercent?>%</td>
																		</tr>
																	</table>
																</td>
																<td width='60' align='center' bgcolor='FAFAFA'><b><?=$FJBTotal?></b>명</td>
																<td width='248' align='center' bgcolor='FAFAFA'>
																	<table width="248" border="0" cellspacing="0" cellpadding="0" class="text-2">
																		<tr> 
																			<td width="<?=$FJBPixelS?>"> 
																				<table width="100%" border="0" cellspacing="0" cellpadding="0" height="8" background="../images/pix04.gif">
																					<tr><td height="16"></td></tr>
																				</table>
																			</td>
																			<td width="<?=$FJBPixelE?>">&nbsp;<?=$FJBPercent?>%</td>
																		</tr>
																	</table>
																</td>
															</tr>
															<tr> 
																<td height='5' colspan='11' bgcolor='FAFAFA'></td>
															</tr>
															<tr> 
																<td height='1' colspan='11' bgcolor='D2D2D2'></td>
															</tr>
															<tr> 
																<td height='5' colspan='11' bgcolor='FAFAFA'></td>
															</tr>
															<tr height='23'> 
																<td width='84' align='center' bgcolor='FAFAFA'><b><font color="005190">제주</font></b></td>
																<td width='60' align='center' bgcolor='FAFAFA'><b><?=$JJTotal?></b>명</td>
																<td width='60' align='center' bgcolor='FAFAFA'><b><?=$MJJTotal?></b>명</td>
																<td width='248' align='center' bgcolor='FAFAFA'>
																	<table width="248" border="0" cellspacing="0" cellpadding="0" class="text-2">
																		<tr> 
																			<td width="<?=$MJJPixelS?>"> 
																				<table width="100%" border="0" cellspacing="0" cellpadding="0" height="8" background="../images/pix03.gif">
																					<tr><td height="16"></td></tr>
																				</table>
																			</td>
																			<td width="<?=$MJJPixelE?>">&nbsp;<?=$MJJPercent?>%</td>
																		</tr>
																	</table>
																</td>
																<td width='60' align='center' bgcolor='FAFAFA'><b><?=$FJJTotal?></b>명</td>
																<td width='248' align='center' bgcolor='FAFAFA'>
																	<table width="248" border="0" cellspacing="0" cellpadding="0" class="text-2">
																		<tr> 
																			<td width="<?=$FJJPixelS?>"> 
																				<table width="100%" border="0" cellspacing="0" cellpadding="0" height="8" background="../images/pix04.gif">
																					<tr><td height="16"></td></tr>
																				</table>
																			</td>
																			<td width="<?=$FJJPixelE?>">&nbsp;<?=$FJJPercent?>%</td>
																		</tr>
																	</table>
																</td>
															</tr>
															<tr> 
																<td height='5' colspan='11' bgcolor='FAFAFA'></td>
															</tr>
															<tr> 
																<td height='1' colspan='11' bgcolor='D2D2D2'></td>
															</tr>
														</table>
														<table width="760" border="0" cellspacing="1" cellpadding="0">
															<tr> 
																<td height="30">&nbsp;</td>
															</tr>
														</table>
													</td>
												</tr>
											</table>
										</td>
									</tr>
									<tr>
										<td height="5" bgcolor="#FFFFFF"></td>
									</tr>
								</table>
								<!-- main table end -->
							</td>
						</tr>
					</table>
				</td>
			</tr>
			<tr>
				<td height="83">
					<!-- bottom start -->
<? include "$folderpath_manager_common/od_bottom.inc.php"; ?>
					<!-- bottom end -->
				</td>
			</tr>
		</table>
	</body>
</html>