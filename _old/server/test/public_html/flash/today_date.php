<?PHP
	// 필요한 설정파일 불러오기
	include $_SERVER[DOCUMENT_ROOT]."/odprogram/odcommon/od_config.inc.php";
	include $_SERVER[DOCUMENT_ROOT]."/odprogram/odcommon/od_function.inc.php";
	include $_SERVER[DOCUMENT_ROOT]."/odprogram/odcommon/od_lib.inc.php";

	// 기존에 저장되어 있는 쿠키값이 있는지를 확인 ////////////////////////////
	if( $_COOKIE[Aid] )
	{
		// 쿠키의 값이 
		$Query  = "select catecode from odtCategory where cHidden = 'no' and catecode = '$_COOKIE[Aid]' ";
		$Result = mysql_query($Query);
		$RecCnt = mysql_num_rows($Result);

		if ($RecCnt)
		{
			$thiscate = $_COOKIE[Aid];
		}
		else
		{
			$thiscate = mysql_result(mysql_query("select catecode from odtCategory where cHidden = 'no' order by catecode asc limit 1"),0);
		}
	}
	else
	{
		
        $Query  = " select A.catecode from odtProduct as A left join odtCategory as B on A.catecode = B.catecode where B.cHidden = 'no' and A.sale_date <= curdate() and A.code = A.parent_code order by B.cateidx , B.catecode asc limit 1";
		$Result = mysql_query($Query);
		$Record = mysql_fetch_array($Result);
		$thiscate = $Record[0] ? $Record[0] : mysql_result(mysql_query("select catecode from odtCategory where cHidden = 'no' order by catecode asc limit 1"),0);
	}


	$today_date = date("Y-m-d");
	$que = "select sale_enddate from odtProduct where code = parent_code and cateCode = '".$thiscate."' and sale_date <= '".$today_date."' and sale_enddate>='".$today_date."' order by sale_date desc limit 1";
	$res = mysql_query($que);

	if( mysql_num_rows($res) > 0 ){
		$sale_enddate = mysql_result($res,0,0);
	}
	else {
		$sale_enddate = date("Y-m-d" , strtotime("+1 day"));
	}
	$nextSaleTime = strtotime("${sale_enddate}") + $row_setup[changeTime]*3600;


	$curr_time = time();

	echo $curr_time . '/' . $nextSaleTime ;

?>