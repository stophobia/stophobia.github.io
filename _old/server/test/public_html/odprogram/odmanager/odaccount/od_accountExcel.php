<?
    include "../../odcommon/od_config.inc.php";
    include "$folderpath_manager_common/od_function.inc.php";  
    include "$folderpath_manager_common/od_comAuthority.inc.php";
    
    $toDay = date("YmdHis");
    $fileName = "accountView";

    ## Exel 파일로 변환 #############################################
    header("Content-Type: application/vnd.ms-excel");
    header("Content-Disposition: attachment; filename=$fileName-$toDay.csv");


    $sDate = $_GET[sDate] ? $_GET[sDate] : date('Y-01-01');
    $eDate = $_GET[eDate] ? $_GET[eDate] : date('Y-m-d',mktime(23,59,59,date('m')+1,0,date('Y')));


    ## 조건 #############################################
    unset($where_);
    if($insType == "input") {
        $where_ .= " and price >= 0 ";
        if($type) $where_ .= " and title = '".$type."'";
    } else if($insType == "output") {
        $where_ .= " and price <= 0 ";
        if($type2) $where_ .= " and title = '".$type2."'";
    }
    #######################################################

    $que = "select * from odtAccount where date >= '".$sDate."' and date <= '".$eDate."' and bank='".$_GET[bank]."' ".$where_." order by date asc";

    $res = mysql_query($que);
    $total = mysql_num_rows($res);

    echo iconv("utf-8","euckr","날짜,내용,계정과목,입금금액,출금금액,잔액,계좌");



    # 조회기간 이전의 잔액을 추출
    $resPrice = mysql_result(mysql_query("select sum(price) from odtAccount where date < '".$sDate."' and bank='".$_GET[bank]."' order by date asc"),0);

    while($row= mysql_fetch_array($res)) {

        $pPrice      = 0;
        $mPrice      = 0;

        $pPrice      = $row['price'] > 0 ? $row['price'] : 0;
        $mPrice      = $row['price'] < 0 ? $row['price'] : 0;

        $resPrice   += $row['price'];
        $plusPrice  += $row['price'] > 0 ? $row['price'] : 0;
        $minusPrice += $row['price'] < 0 ? $row['price'] : 0;


                echo "
    ";
        echo iconv("utf-8","euckr",$row['date'].",".$row['memo'].",".$row['title'].",".$pPrice.",".$mPrice.",".$resPrice.",".$_GET[bank]);  
    }
        

    
                echo "
    ";
    echo iconv("utf-8","euckr","합계,-,-,".$plusPrice.",".$minusPrice.",".$resPrice.",".$totalComPrice.",-");

?>