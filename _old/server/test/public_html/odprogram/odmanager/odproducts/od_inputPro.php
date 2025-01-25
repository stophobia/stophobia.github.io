<?

include "../../odcommon/od_config.inc.php";
include "../../odcommon/od_lib.inc.php";
include "../odcommon/od_function.inc.php";
include "../odcommon/od_adminAuthority.inc.php";
include "../odcommon/od_head.inc.php";
include "../odcommon/od_body.inc.php";

chk_authfree();




    // 구독하기 설정 적용
    // sms -> 4 , email -> 2 ::: 합산된 정보를 적용하면 됨
    if( sizeof($setup_subscribe) > 0 ) {
        $sum_setup_subscribe = array_sum($setup_subscribe); 
    }
    else {
        $sum_setup_subscribe = 0;
    }



switch ($subMode)
    {
    case "ins":

        ## catecode and catename
        $cateName       =mysql_result(mysql_query("SELECT catename FROM odtCategory WHERE catecode='$cateCode'"), 0);


        $customerName   =@mysql_result(mysql_query("SELECT cName FROM odtMember WHERE id='$customerCode'"), 0);


                ## 값 정리
                $customerCode       = htmlspecialchars(trim($_POST[customerCode]));     // 공급자코드
                $customerName       = htmlspecialchars(trim($customerName));                    // 공급자명
                $cateCode           = htmlspecialchars(trim($_POST[cateCode]));             // 카테고리코드
                $cateName           = htmlspecialchars(trim($cateName));                            // 카테고리명
                $code               = htmlspecialchars(trim($_POST[code]));                     // 상품코드
                $parent_code        = htmlspecialchars(trim($_POST[parent_code]));      // 메인상품코드
                $mainName               = htmlspecialchars(trim($_POST[mainName]));             // 대표상품명
                $name                       = htmlspecialchars(trim($_POST[name]));                     // 상품명
                $epName                 = htmlspecialchars(trim($_POST[epName]));                   // 상품명(가격비교용)
                $sWord                  = htmlspecialchars(trim($_POST[sWord]));                    // 검색어
                $sLink                  = htmlspecialchars(trim($_POST[sLink]));                    // 검색링크
                $md_name                = htmlspecialchars(trim($_POST[md_name]));              // MD 이름
                $sale_date          = htmlspecialchars(trim($_POST[sale_date]));            // 판매일
                $sale_enddate           = htmlspecialchars(trim($_POST[sale_enddate]));         // 판매일
                $purPrice               = htmlspecialchars(trim($_POST[purPrice]));             // 매입가
                $commission         = htmlspecialchars(trim($_POST[commission]));           // 수수료
                $comSaleType        = htmlspecialchars(trim($_POST[comSaleType]));      // 정산유형
                $price                  = htmlspecialchars(trim($_POST[price]));                    // 판매가
                $price_per          = htmlspecialchars(trim($_POST[price_per]));            // 판매가
                $price_org          = htmlspecialchars(trim($_POST[price_org]));            // 정상가격
                $mainPrice          =   htmlspecialchars(trim($_POST[mainPrice]));          // 메인가격으로 지정
                $del_price_com  = htmlspecialchars(trim($_POST[del_price_com]));    // 업점업체 배송비
                $del_price          = htmlspecialchars(trim($_POST[del_price]));            // 배송비
                $del_limit          = htmlspecialchars(trim($_POST[del_limit]));            // 무료배송가
                $coupon_sale        = htmlspecialchars(trim($_POST[coupon_sale]));      // 쿠폰할인가
                $live_sale          = htmlspecialchars(trim($_POST[live_sale]));            // 라이브할인가
                $point                  = htmlspecialchars(trim($_POST[point]));                    // 적립포인트
                $stock                  = htmlspecialchars(trim($_POST[stock]));                    // 재고량
                $buy_limit          = htmlspecialchars(trim($_POST[buy_limit]));            // 구매제한갯수
                $md_ment                = htmlspecialchars(trim($_POST[md_ment]));              // MD한마디
                $seller_ment        = htmlspecialchars(trim($_POST[seller_ment]));      // 생산자한마디
                $comment1               = htmlspecialchars(trim($_POST[comment1]));             // 간략한상품설명
                $comment2               = htmlspecialchars(trim($_POST[comment2]));             // 상세설명
                $comment3               = htmlspecialchars(trim($_POST[comment3]));             // 주문확인서 주의사항
                $onecut_img         =   htmlspecialchars(trim($_POST[onecut_img]));         // 한컷이미지
                $mailing_img        =   htmlspecialchars(trim($_POST[mailing_img]));        // 메일링
                $review_url         = htmlspecialchars(trim($_POST[review_url]));           // 재방 동영상 URL
                $review_flash       = htmlspecialchars(trim($_POST[review_flash]));     // 재방 플래쉬
                $live_time          = htmlspecialchars(trim($_POST[live_time]));            // 방송시간
                $live_time_sec  = htmlspecialchars(trim($_POST[live_time_sec]));    // 방송시간 초
                $live_start_time= htmlspecialchars(trim($_POST[live_start_time]));// 방송시작시간
                $guestDisabled  = htmlspecialchars(trim($_POST[guestDisabled]));    // 비회원구매불가
                $ipDistinct         = htmlspecialchars(trim($_POST[ipDistinct]));           // 중복아이피구매불가
                $talkDisabled       = htmlspecialchars(trim($_POST[talkDisabled]));     // 모닝토크비활성화
                $bankDisabled       = htmlspecialchars(trim($_POST[bankDisabled]));     // 무통장입금불가
                $seeDisabled        = htmlspecialchars(trim($_POST[seeDisabled]));      // 상품숨기기
                $isSaleCnt          = htmlspecialchars(trim($_POST[isSaleCnt]));            // 구매현황 노출여부
                $saleCnt                = htmlspecialchars(trim($_POST[saleCnt]));              // 구매갯수
                $saleCntMax         = htmlspecialchars(trim($_POST[saleCntMax]));           // 최대구매갯수
                $rssarea1         = htmlspecialchars(trim($_POST[rssarea1]));           // 상품의지역정보
                $rssarea2         = htmlspecialchars(trim($_POST[rssarea2]));           // 상품의지역위치정보
                $rsscate         = htmlspecialchars(trim($_POST[rsscate]));           // 상품의카테고리명
                $expire         = htmlspecialchars(trim($_POST[expire]));           // 쿠폰의 사용 만료일


                if ($_POST[optionName])
                {
                    $optionName     = implode("|",str_replace("|","_",$_POST[optionName]));         // 옵션명
                    $optionPurPrice = implode("|",str_replace("|","_",$_POST[optionPurPrice]));     // 옵션명
                    $optionPrice    = implode("|",str_replace("|","_",$_POST[optionPrice]));        // 옵션별 추가 가격
                }
                else
                {
                    $optionName     = "";   // 옵션명
                    $optionPurPrice = "";   // 옵션명
                    $optionPrice    = "";   // 옵션별 추가 가격
                }

        $message        =htmlspecialchars(trim($_POST[message]));                         // 쇼킹한 소식 sms 


        # 파일 업로드
        $dir            ="/odprogram/upfiles/odproducts";

        $main_img       =$main_img[name]            ? file_upload($_FILES[main_img], $dir)               : NULL;
        $mainNameImg    =$mainNameImg[name]     ? file_upload($_FILES[mainNameImg], $dir)        : NULL;
        $big1_img       =$big1_img[name]            ? file_upload($_FILES[big1_img], $dir)               : NULL;
        $big2_img       =$big2_img[name]            ? file_upload($_FILES[big2_img], $dir)               : NULL;
        $big3_img       =$big3_img[name]            ? file_upload($_FILES[big3_img], $dir)               : NULL;
        $big4_img       =$big4_img[name]            ? file_upload($_FILES[big4_img], $dir)               : NULL;
        $big5_img       =$big5_img[name]            ? file_upload($_FILES[big5_img], $dir)               : NULL;
//        $onecut_img     =$onecut_img[name]        ? file_upload($_FILES[onecut_img], $dir)         : NULL;
        $replay_img     =$replay_img[name]      ? file_upload($_FILES[replay_img], $dir)         : NULL;
        $side_img       =$side_img[name]            ? file_upload($_FILES[side_img], $dir)               : NULL;
        $order_img      =$order_img[name]           ? file_upload($_FILES[order_img], $dir)          : NULL;
        $oldlist_img    =$oldlist_img[name]     ? file_upload($_FILES[oldlist_img], $dir)        : NULL;
        $oldview_img    =$oldview_img[name]     ? file_upload($_FILES[oldview_img], $dir)        : NULL;
        $pay_img        =$pay_img[name]             ? file_upload($_FILES[pay_img], $dir)                : NULL;
        $after_img      =$after_img[name]           ? file_upload($_FILES[after_img], $dir)          : NULL;
        $bb_img         =$bb_img[name]              ? file_upload($_FILES[bb_img], $dir)                 : NULL;
        $prolist_img    =$prolist_img[name]     ? file_upload($_FILES[prolist_img], $dir)        : NULL;
        $cpDp_img               =$cpDp_img[name]            ? file_upload($_FILES[cpDp_img], $dir)               : NULL;
        $movie          =$movie[name]                   ? file_upload($_FILES[movie], $dir, 20)          : NULL;
        $mart_main_img  =$mart_main_img[name] ? file_upload($_FILES[mart_main_img], $dir)    : NULL;
        $banner_img         =$banner_img[name]      ? file_upload($_FILES[banner_img], $dir)         : NULL;




        # 이미지 리사이징
        if ($cateCode == "06")
            {
            $prolist_img=$mart_main_img ? resize_img(end(explode("/", $mart_main_img)), "/odproducts", 80, 80) : NULL;
            }


        # 상품기술서 업로드
        mysql_query ("delete from odtProFiles where code ='" . $code . "'");
        $proFile=$_FILES[proFile];

        for ($i=0; $i < count($proFile[name]); $i++)
            {
            $fileTmp[name]    = $proFile[name][$i];
            $fileTmp[tmp_name]=$proFile[tmp_name][$i];
            $fileTmp[size]    =$proFile[size][$i];
            $fileDel          =$proFile_del[$i];
            $fileOrg          =$proFile_org[$i];
            $fileOrgReal      =$proFileReal_org[$i];

            // 파일삭제
            $filesrc          =$fileTmp[name] ? file_upload($fileTmp, "/odprogram/upfiles/profile") : NULL;
            $filename         =$fileTmp[name] ? $fileTmp[name] : NULL;

            if ($filesrc)
                mysql_query ("insert into odtProFiles set code ='" . $code . "', filesrc ='" . $filesrc
                                . "', filename = '" . $filename . "'");
            }


        $que="insert into odtProduct set
                            code                    = '" . $code . "',
                            parent_code                         = '" . $parent_code . "',
                            customerCode                        = '" . $customerCode . "',
                            customerName                        = '" . $customerName . "',
                            cateCode                                = '" . $cateCode . "',
                            cateName                                = '" . $cateName . "',
                            mainName                                = '" . $mainName . "',
                            mainNameImg                         = '" . $mainNameImg . "',
                            name                    = '" . $name . "',
                            epName                                  = '" . $epName . "',
                            sWord                   = '" . $sWord . "',
                            sLink                   = '" . $sLink . "',
                            purPrice                                = '" . $purPrice . "',
                            commission                          = '" . $commission . "',
                            comSaleType                         = '" . $comSaleType . "',
                            price                                       = '" . $price . "',
                            price_per                               = '" . $price_per . "',
                            price_org                               = '" . $price_org . "',
                            mainPrice                               = '" . $mainPrice . "',
                            point                   = '" . $point . "',
                            stock                   = '" . $stock . "',
                            buy_limit                               = '" . $buy_limit . "',
                            comment1                                = '" . $comment1 . "',
                            md_ment                                 = '" . $md_ment . "',
                            seller_ment                         = '" . $seller_ment . "',
                            comment2                                = '" . $comment2 . "',
                            saleNum                                 = '" . $saleNum . "',
                            md_name                                 = '" . $md_name . "',
                            sale_date                               = '" . $sale_date . "',
                            sale_enddate                            = '" . $sale_enddate . "',
                            del_price_com                       = '" . $del_price_com . "',
                            del_price                               = '" . $del_price . "',
                            del_limit                               = '" . $del_limit . "',
                            coupon_sale                         = '" . $coupon_sale . "',
                            live_sale                               = '" . $live_sale . "',
                            review_url                          = '" . $review_url . "',
                            review_flash                        = '" . $review_flash . "',
                            mart_main_img                       = '" . $mart_main_img . "',
                            main_img                                = '" . $main_img . "',
                            big1_img                                = '" . $big1_img . "',
                            big2_img                                = '" . $big2_img . "',
                            big3_img                                = '" . $big3_img . "',
                            big4_img                                = '" . $big4_img . "',
                            big5_img                                = '" . $big5_img . "',
                            onecut_img                          = '" . $onecut_img . "',
                            replay_img                          = '" . $replay_img . "',
                            side_img                                = '" . $side_img . "',
                            order_img                               = '" . $order_img . "',
                            oldlist_img                         = '" . $oldlist_img . "',
                            oldview_img                         = '" . $oldview_img . "',
                            pay_img                                 = '" . $pay_img . "',
                            after_img                               = '" . $after_img . "',
                            bb_img                                  = '" . $bb_img . "',
                            prolist_img                         = '" . $prolist_img . "',
                            mailing_img                         = '" . $mailing_img . "',
                            cpDp_img                                = '" . $cpDp_img . "',
                            banner_img                          =   '" . $banner_img . "',
                            comment3                                = '" . $comment3 . "',
                            message                                 = '" . $message . "',
                            movie                   = '" . $movie . "',
                            live_time                               = '" . $live_time . "',
                            live_time_sec                       = '" . $live_time_sec . "',
                            live_start_time                 = '" . $live_start_time . "',
                            optionName                          = '" . $optionName . "',
                            optionPurPrice                  = '" . $optionPurPrice . "',
                            optionPrice                         = '" . $optionPrice . "',
                            guestDisabled                       = '" . $guestDisabled . "',
                            ipDistinct                          = '" . $ipDistinct . "',
                            talkDisabled                        = '" . $talkDisabled . "',
                            bankDisabled                        = '" . $bankDisabled . "',
                            seeDisabled                         = '" . $seeDisabled . "',
                            isSaleCnt                               = '" . $isSaleCnt . "',
                            saleCnt                                 = '" . $saleCnt . "',
                            saleCntMax                          = '" . $saleCntMax . "',
                            setup_subscribe                 = '"  . $sum_setup_subscribe . "',
                            setup_delivery                 = '"  . $setup_delivery . "',
                            rssarea1                          = '" . $rssarea1 . "',
                            rssarea2                          = '" . $rssarea2 . "',
                            rsscate                          = '" . $rsscate . "',
                            expire                          = '" . $expire . "',
                            com_juso                    = '"  . $com_juso . "',
                            com_name                    = '"  . $com_name . "',
                            com_mapx                    = '"  . $com_mapx . "',
                            com_mapy                    = '"  . $com_mapy . "',
                            com_mapzoom                 = '"  . $com_mapzoom . "',

							opt_1						= '".$opt_1."',
							opt_2						= '".$opt_2."',
							opt_3						= '".$opt_3."',
							opt_4						= '".$opt_4."',

                            inputDate                   = now()";

        $res=mysql_query($que);

        if ($res)
            {
            error_msgall('등록되었습니다.');
            echo "<script>parent.location.reload();</script>";
            exit;
            }
        else
            {
            error_msgall($que);
            exit;
            error_msgall('오류가 발생하였습니다');
            exit;
            }

        break;

    case "edt":


        ## catecode and catename
        $cateName       =mysql_result(mysql_query("SELECT catename FROM odtCategory WHERE catecode='$cateCode'"), 0);

        ## 상품공급업체 코드를 구한다.
        $customerName   =$customerCode ? @mysql_result(
                                             mysql_query("SELECT cName FROM odtMember WHERE id='$customerCode'"),
                                             0) : "";

                ## 값 정리
                $customerCode       = htmlspecialchars(trim($_POST[customerCode]));     // 공급자코드
                $customerName       = htmlspecialchars(trim($customerName));                    // 공급자명
                $cateCode               = htmlspecialchars(trim($_POST[cateCode]));             // 카테고리코드
                $cateName               = htmlspecialchars(trim($cateName));                            // 카테고리명
                $code                       = htmlspecialchars(trim($_POST[code]));                     // 상품코드
                $parent_code        = htmlspecialchars(trim($_POST[parent_code]));      // 메인상품코드
                $mainName               = htmlspecialchars(trim($_POST[mainName]));             // 메인상품명
                $name                       = htmlspecialchars(trim($_POST[name]));                     // 상품명
                $epName                 = htmlspecialchars(trim($_POST[epName]));                   // 상품명(가격비교용)
                $sWord                  = htmlspecialchars(trim($_POST[sWord]));                    // 검색어
                $sLink                  = htmlspecialchars(trim($_POST[sLink]));                    // 검색어링크
                $md_name                = htmlspecialchars(trim($_POST[md_name]));              // MD 이름
                $sale_date          = htmlspecialchars(trim($_POST[sale_date]));            // 판매일
                $sale_enddate           = htmlspecialchars(trim($_POST[sale_enddate]));         // 판매일
                $purPrice               = htmlspecialchars(trim($_POST[purPrice]));             // 매입가
                $commission         = htmlspecialchars(trim($_POST[commission]));           // 수수료
                $comSaleType        = htmlspecialchars(trim($_POST[comSaleType]));      // 정산유형
                $price                  = htmlspecialchars(trim($_POST[price]));                    // 판매가
                $price_per          = htmlspecialchars(trim($_POST[price_per]));            // 판매가
                $price_org          = htmlspecialchars(trim($_POST[price_org]));            // 정상가격
                $mainPrice          =   htmlspecialchars(trim($_POST[mainPrice]));          // 메인가격으로 지정
                $del_price_com  = htmlspecialchars(trim($_POST[del_price_com]));    // 업점업체 배송비
                $del_price          = htmlspecialchars(trim($_POST[del_price]));            // 배송비
                $del_limit          = htmlspecialchars(trim($_POST[del_limit]));            // 무료배송가
                $coupon_sale        = htmlspecialchars(trim($_POST[coupon_sale]));      // 쿠폰할인가
                $live_sale          = htmlspecialchars(trim($_POST[live_sale]));            // 라이브할인가
                $point                  = htmlspecialchars(trim($_POST[point]));                    // 적립포인트
                $stock                  = htmlspecialchars(trim($_POST[stock]));                    // 재고량
                $buy_limit          = htmlspecialchars(trim($_POST[buy_limit]));            // 구매제한갯수
                $md_ment                = htmlspecialchars(trim($_POST[md_ment]));              // MD한마디
                $seller_ment        = htmlspecialchars(trim($_POST[seller_ment]));      // 생산자한마디
                $comment1               = htmlspecialchars(trim($_POST[comment1]));             // 간략한상품설명
                $comment2               = htmlspecialchars(trim($_POST[comment2]));             // 상세설명
                $comment3               = htmlspecialchars(trim($_POST[comment3]));             // 주문확인서 주의사항
                $onecut_img         =   htmlspecialchars(trim($_POST[onecut_img]));         // 한컷이미지
                $mailing_img        =   htmlspecialchars(trim($_POST[mailing_img]));        // 메일링
                $review_url         = htmlspecialchars(trim($_POST[review_url]));           // 재방 동영상 URL
                $review_flash       = htmlspecialchars(trim($_POST[review_flash]));     // 재방 플래쉬
                $live_time          = htmlspecialchars(trim($_POST[live_time]));            // 방송시간
                $live_time_sec  = htmlspecialchars(trim($_POST[live_time_sec]));    // 방송시간 초
                $live_start_time= htmlspecialchars(trim($_POST[live_start_time]));// 방송시작시간
                $guestDisabled  = htmlspecialchars(trim($_POST[guestDisabled]));    // 비회원구매불가
                $ipDistinct         = htmlspecialchars(trim($_POST[ipDistinct]));           // 중복아이피구매불가
                $talkDisabled       = htmlspecialchars(trim($_POST[talkDisabled]));     // 모닝토크비활성화
                $bankDisabled       = htmlspecialchars(trim($_POST[bankDisabled]));     // 무통장입금불가
                $seeDisabled        = htmlspecialchars(trim($_POST[seeDisabled]));      // 상품숨기기
                $isSaleCnt          = htmlspecialchars(trim($_POST[isSaleCnt]));            // 구매현황 노출여부
                $saleCnt                = htmlspecialchars(trim($_POST[saleCnt]));              // 구매갯수
                $saleCntMax         = htmlspecialchars(trim($_POST[saleCntMax]));           // 최대구매갯수
                $rssarea1         = htmlspecialchars(trim($_POST[rssarea1]));           // 상품의지역정보
                $rssarea2         = htmlspecialchars(trim($_POST[rssarea2]));           // 상품의지역위치정보
                $rsscate         = htmlspecialchars(trim($_POST[rsscate]));           // 상품의카테고리명
                $expire         = htmlspecialchars(trim($_POST[expire]));           // 쿠폰의 사용 만료일



                if ($_POST[optionName])
                {
                    $optionName     = implode("|",str_replace("|","_",$_POST[optionName]));         // 옵션명
                    $optionPurPrice = implode("|",str_replace("|","_",$_POST[optionPurPrice]));     // 옵션명
                    $optionPrice    = implode("|",str_replace("|","_",$_POST[optionPrice]));        // 옵션별 추가 가격
                }
                else
                {
                    $optionName     = "";   // 옵션명
                    $optionPurPrice = "";   // 옵션명
                    $optionPrice    = "";   // 옵션별 추가 가격
                }

        $message        =htmlspecialchars(trim($_POST[message]));                         // 


        # 상품기술서 업로드
        mysql_query ("delete from odtProFiles where code ='" . $code . "'");
        $proFile        =$_FILES[proFile];

        for ($i=0; $i < count($proFile[name]); $i++)
            {
            $fileTmp[name]    = $proFile[name][$i];
            $fileTmp[tmp_name]=$proFile[tmp_name][$i];
            $fileTmp[size]    =$proFile[size][$i];
            $fileDel          =$proFile_del[$i];
            $fileOrg          =$proFile_org[$i];
            $fileOrgReal      =$proFileReal_org[$i];

            // 파일삭제
            $fileOrgTmp       =$fileDel == "Y" || $fileTmp[name] ? file_delete(
                                                                       $_SERVER[DOCUMENT_ROOT] . $fileOrg) : $fileOrg;
            $filesrc          =$fileTmp[name] ? file_upload($fileTmp, "/odprogram/upfiles/profile") : $fileOrgTmp;
            $filename         =$fileTmp[name] ? $fileTmp[name] : $fileOrgReal;

            if ($filesrc)
                mysql_query ("insert into odtProFiles set code ='" . $code . "', filesrc ='" . $filesrc
                                . "', filename = '" . $filename . "'");
            }


            # 파일 삭제
            $main_img_org           = $main_img_del         == "Y" || $main_img[name]           ? file_delete($_SERVER[DOCUMENT_ROOT].$main_img_org)            : $main_img_org;
            $mainNameImg_org    = $mainNameImg_del  == "Y" || $mainNameImg[name]    ? file_delete($_SERVER[DOCUMENT_ROOT].$mainNameImg_org)     : $mainNameImg_org;
            $big1_img_org           = $big1_img_del         == "Y" || $big1_img[name]           ? file_delete($_SERVER[DOCUMENT_ROOT].$big1_img_org)            : $big1_img_org;
            $big2_img_org           = $big2_img_del         == "Y" || $big2_img[name]           ? file_delete($_SERVER[DOCUMENT_ROOT].$big2_img_org)            : $big2_img_org;
            $big3_img_org           = $big3_img_del         == "Y" || $big3_img[name]           ? file_delete($_SERVER[DOCUMENT_ROOT].$big3_img_org)            : $big3_img_org;
            $big4_img_org           = $big4_img_del         == "Y" || $big4_img[name]           ? file_delete($_SERVER[DOCUMENT_ROOT].$big4_img_org)            : $big4_img_org;
            $big5_img_org           = $big5_img_del         == "Y" || $big5_img[name]           ? file_delete($_SERVER[DOCUMENT_ROOT].$big5_img_org)            : $big5_img_org;
//          $onecut_img_org     = $onecut_img_del       == "Y" || $onecut_img[name]     ? file_delete($_SERVER[DOCUMENT_ROOT].$onecut_img_org)      : $onecut_img_org;
            $replay_img_org     = $replay_img_del       == "Y" || $replay_img[name]     ? file_delete($_SERVER[DOCUMENT_ROOT].$replay_img_org)      : $replay_img_org;
            $side_img_org           = $side_img_del         == "Y" || $side_img[name]           ? file_delete($_SERVER[DOCUMENT_ROOT].$side_img_org)            : $side_img_org;
            $order_img_org      = $order_img_del        == "Y" || $order_img[name]      ? file_delete($_SERVER[DOCUMENT_ROOT].$order_img_org)           : $order_img_org;
            $oldlist_img_org    = $oldlist_img_del  == "Y" || $oldlist_img[name]    ? file_delete($_SERVER[DOCUMENT_ROOT].$oldlist_img_org)     : $oldlist_img_org;
            $oldview_img_org    = $oldview_img_del  == "Y" || $oldview_img[name]    ? file_delete($_SERVER[DOCUMENT_ROOT].$oldview_img_org)     : $oldview_img_org;
            $pay_img_org            = $pay_img_del          == "Y" || $pay_img[name]            ? file_delete($_SERVER[DOCUMENT_ROOT].$pay_img_org)             : $pay_img_org;
            $after_img_org      = $after_img_del        == "Y" || $after_img[name]      ? file_delete($_SERVER[DOCUMENT_ROOT].$after_img_org)           : $after_img_org;
            $bb_img_org             = $bb_img_del               == "Y" || $bb_img[name]             ? file_delete($_SERVER[DOCUMENT_ROOT].$bb_img_org)              : $bb_img_org;
            $prolist_img_org    = $prolist_img_del  == "Y" || $prolist_img[name]    ? file_delete($_SERVER[DOCUMENT_ROOT].$prolist_img_org)     : $prolist_img_org;
            $cpDp_img_org           = $cpDp_img_del         == "Y" || $cpDp_img[name]           ? file_delete($_SERVER[DOCUMENT_ROOT].$cpDp_img_org)            : $cpDp_img_org;
            $movie_org              = $movie_del                == "Y" || $movie[name]              ? file_delete($_SERVER[DOCUMENT_ROOT].$movie_org)                   : $movie_org;
            $mart_main_img_org= $mart_main_img_del== "Y" || $mart_main_img[name]? file_delete($_SERVER[DOCUMENT_ROOT].$mart_main_img_org)   : $mart_main_img_org;
            $banner_img_org     = $banner_img_del       == "Y" || $banner_img[name]     ? file_delete($_SERVER[DOCUMENT_ROOT].$banner_img_org)      : $banner_img_org;
        

            # 파일 업로드
            $dir = "/odprogram/upfiles/odproducts";
            $main_img           = $main_img[name]           ? file_upload($_FILES[main_img],$dir)            : $main_img_org;
            $mainNameImg    = $mainNameImg[name]    ? file_upload($_FILES[mainNameImg],$dir)     : $mainNameImg_org;
            $big1_img           = $big1_img[name]           ? file_upload($_FILES[big1_img],$dir)            : $big1_img_org;
            $big2_img           = $big2_img[name]           ? file_upload($_FILES[big2_img],$dir)            : $big2_img_org;
            $big3_img           = $big3_img[name]           ? file_upload($_FILES[big3_img],$dir)            : $big3_img_org;
            $big4_img           = $big4_img[name]           ? file_upload($_FILES[big4_img],$dir)            : $big4_img_org;
            $big5_img           = $big5_img[name]           ? file_upload($_FILES[big5_img],$dir)            : $big5_img_org;
//          $onecut_img     = $onecut_img[name]     ? file_upload($_FILES[onecut_img],$dir)      : $onecut_img_org;
            $replay_img     = $replay_img[name]     ? file_upload($_FILES[replay_img],$dir)      : $replay_img_org;
            $side_img           = $side_img[name]           ? file_upload($_FILES[side_img],$dir)            : $side_img_org;
            $order_img      = $order_img[name]      ? file_upload($_FILES[order_img],$dir)           : $order_img_org;
            $oldlist_img    = $oldlist_img[name]    ? file_upload($_FILES[oldlist_img],$dir)     : $oldlist_img_org;
            $oldview_img    = $oldview_img[name]    ? file_upload($_FILES[oldview_img],$dir)     : $oldview_img_org;
            $pay_img            = $pay_img[name]            ? file_upload($_FILES[pay_img],$dir)             : $pay_img_org;
            $after_img      = $after_img[name]      ? file_upload($_FILES[after_img],$dir)           : $after_img_org;
            $bb_img             = $bb_img[name]             ? file_upload($_FILES[bb_img],$dir)              : $bb_img_org;
            $prolist_img    = $prolist_img[name]    ? file_upload($_FILES[prolist_img],$dir)     : $prolist_img_org;
            $cpDp_img           = $cpDp_img[name]           ? file_upload($_FILES[cpDp_img],$dir)            : $cpDp_img_org;
            $movie              = $movie[name]              ? file_upload($_FILES[movie],$dir,20)            : $movie_org;
            $mart_main_img= $mart_main_img[name]? file_upload($_FILES[mart_main_img],$dir)   : $mart_main_img_org;
      $banner_img       = $banner_img[name]     ? file_upload($_FILES[banner_img], $dir)     : $banner_img_org;


        # 이미지 리사이징
        if ($cateCode == "06" && !ereg("onedaynet", $mart_main_img))
            {
            $prolist_img=$mart_main_img ? resize_img(end(explode("/", $mart_main_img)), "/odproducts", 80,
                                                    80) : $prolist_img_org;
            }

        $que="update odtProduct set
                            parent_code                 = '" . $parent_code . "',
                            customerCode                = '" . $customerCode . "',
                            customerName                = '" . $customerName . "',
                            cateCode                        = '" . $cateCode . "',
                            cateName                        = '" . $cateName . "',
                            mainName                        = '" . $mainName . "',
                            mainNameImg                 =   '" . $mainNameImg . "',
                            name                                = '" . $name . "',
                            epName                          = '" . $epName . "',
                            sWord                               =   '" . $sWord . "',
                            sLink                               =   '" . $sLink . "',
                            purPrice                        = '" . $purPrice . "',
                            commission                  = '" . $commission . "',
                            comSaleType                 = '" . $comSaleType . "',
                            price                               = '" . $price . "',
                            price_per                       = '" . $price_per . "',
                            price_org                       = '" . $price_org . "',
                            mainPrice                       =   '" . $mainPrice . "',
                            point                               = '" . $point . "',
                            stock                               = '" . $stock . "',
                            buy_limit                       = '" . $buy_limit . "',
                            comment1                        = '" . $comment1 . "',
                            md_ment                         = '" . $md_ment . "',
                            seller_ment                 = '" . $seller_ment . "',
                            comment2                        = '" . $comment2 . "',
                            saleNum                         = '" . $saleNum . "',
                            md_name                         = '" . $md_name . "',
                            sale_date                       = '" . $sale_date . "',
                            sale_enddate                    = '" . $sale_enddate . "',
                            del_price_com               = '" . $del_price_com . "',
                            del_price                       = '" . $del_price . "',
                            del_limit                       = '" . $del_limit . "',
                            coupon_sale                 = '" . $coupon_sale . "',
                            live_sale                       = '" . $live_sale . "',
                            review_url                  = '" . $review_url . "',
                            review_flash                =   '" . $review_flash . "',
                            mart_main_img               = '" . $mart_main_img . "',
                            main_img                        = '" . $main_img . "',
                            big1_img                        = '" . $big1_img . "',
                            big2_img                        = '" . $big2_img . "',
                            big3_img                        = '" . $big3_img . "',
                            big4_img                        = '" . $big4_img . "',
                            big5_img                        = '" . $big5_img . "',
                            onecut_img                  = '" . $onecut_img . "',
                            replay_img                  = '" . $replay_img . "',
                            side_img                        = '" . $side_img . "',
                            order_img                       = '" . $order_img . "',
                            oldlist_img                 = '" . $oldlist_img . "',
                            oldview_img                 = '" . $oldview_img . "',
                            pay_img                         = '" . $pay_img . "',
                            after_img                       =   '" . $after_img . "',
                            bb_img                          =   '" . $bb_img . "',
                            prolist_img                 = '" . $prolist_img . "',
                            mailing_img                 = '" . $mailing_img . "',
                            cpDp_img                        = '" . $cpDp_img . "',
                                                        banner_img                  =   '" . $banner_img . "',
                            comment3                        = '" . $comment3 . "',
                            message                         = '" . $message . "',
                            movie                               = '" . $movie . "',
                            optionName                  =   '" . $optionName . "',
                            optionPurPrice          =   '" . $optionPurPrice . "',
                            optionPrice                 =   '" . $optionPrice . "',
                            live_time                       = '" . $live_time . "',
                            live_time_sec               = '" . $live_time_sec . "',
                            live_start_time         = '" . $live_start_time . "',
                            guestDisabled               =   '" . $guestDisabled . "',
                            ipDistinct                  =   '" . $ipDistinct . "',
                            talkDisabled                =   '" . $talkDisabled . "',
                            bankDisabled                =   '" . $bankDisabled . "',
                            seeDisabled                 =   '" . $seeDisabled . "',
                            isSaleCnt                       =   '" . $isSaleCnt . "',
                            saleCnt                         =   '" . $saleCnt . "',
                            setup_subscribe                 = '"  . $sum_setup_subscribe . "',
                            setup_delivery                 = '"  . $setup_delivery . "',
                            rssarea1                          = '" . $rssarea1 . "',
                            rssarea2                          = '" . $rssarea2 . "',
                            rsscate                          = '" . $rsscate . "',
                            expire                          = '" . $expire . "',
                            com_juso                    = '"  . $com_juso . "',
                            com_name                    = '"  . $com_name . "',
                            com_mapx                    = '"  . $com_mapx . "',
                            com_mapy                    = '"  . $com_mapy . "',
                            com_mapzoom                 = '"  . $com_mapzoom . "',

							opt_1						= '".$opt_1."',
							opt_2						= '".$opt_2."',
							opt_3						= '".$opt_3."',
							opt_4						= '".$opt_4."',

                            saleCntMax                  =   '" . $saleCntMax . "'
                            where 
                            code                                = '" . $code . "'";

        $res=mysql_query($que);

        if ($res)
            {
            error_msgall('수정되었습니다.');
            echo "<script>parent.location.reload();</script>";
            exit;
            }
        else
            {
            echo $que;
            error_msgall('오류가 발생하였습니다');
            exit;
            }

        break;
    }
?>