<?
    include "../odcommon/od_config.inc.php";
    include "../odcommon/od_function.inc.php";
    include "../odcommon/od_lib.inc.php";
    include "../odcommon/od_head.inc.php";
    include "../odcommon/od_body.inc.php";
    include "od_board.inc.php";

    ## 글읽기 권한체크
    if($configReadLevel > $Cooki_Member_Level) historyBack();

    //authorityTest("Read");

    ## Par 정리 ##########################################################################
    $parTemp = "?board=$board";
    if($page) $parTemp .= "&page=$page";
    if($serialnum) $parTemp .= "&serialnum=$serialnum";
    if($field) $parTemp .= "&field=$field";
    if($value) $parTemp .= "&value=$value";

    ## 로그인 후 현재 페이지를 유지하기 위한 경로 지정 ##################
    $_target_path = $PHP_SELF."?board=".$board."&serialnum=".$serialnum."&page=".$page."&field=".$field."&value=".$value;
    $_target_path = eregi_replace("&", "@", $_target_path);

    ## 이전글/다음글을 호출하기 윈한 게시글 정보 호출 ##
    $roll_result = mysql_query("SELECT depth, familyid FROM odtBoard WHERE serialnum=$serialnum and notice<>'Y'");
    $roll_row = mysql_fetch_array($roll_result);

    ## strlen($roll_row[depth]) 값이 1보다 클 경우 답변글로 결정 ##
    if(strlen($roll_row[depth]) > 1) $serialnum_sequence = $roll_row[familyid];
    else $serialnum_sequence = $serialnum;

    ## 다음글/이전글 ##########################################################################
    $nextResult = mysql_query("SELECT serialnum, writerid, title, privacy FROM odtBoard WHERE serialnum>$serialnum_sequence and boardkind=$board and LENGTH(depth) = 1 and notice != 'Y' ORDER BY serialnum");
    $nextRow = mysql_fetch_array($nextResult);
    
    $nextSerialNum = $nextRow[serialnum];
    $nextTitle = $nextRow[title];
    $nextPrivacy = $nextRow[privacy];
    
    if($nextTitle != "" && $nextSerialNum != "") {
        if($nextPrivacy == "Y") {
            if($row_member[id] && $row_member[id] == $nextRow[writerid]) {
                $nextScript = "";
                $nextTemp = "<a href=\"javascript:moveToPage($nextSerialNum);\">".stripslashes($nextTitle)."</a>";
            }
            else {
                $nextScript = "
                    <form method='post' action='od_boardread.php' name='noticeReadForm'>
                        <input type='hidden' name='Mode'>
                        <input type='hidden' name='board' value='$board'>
                        <input type='hidden' name='page' value='$page'>
                        <input type='hidden' name='field' value='$field'>
                        <input type='hidden' name='value' value='$value'>
                        <input type='hidden' name='serialnum' value='$nextSerialNum'>
                    </form>";

                $nextTemp = "<a href=\"javascript:openPasswordNotice('read');\">".stripslashes($nextTitle)."</a>";
            }
            
            $nextPrivacy_img_ = "<img src='$board_privacy_img'>";
        }
        else {
            $nextScript = "";
            $nextTemp = "<a href=\"javascript:moveToPage($nextSerialNum);\">".stripslashes($nextTitle)."</a>";
            $nextPrivacy_img_ = "";
        }
    } 
    else {
        $nextTemp = "";
    }

    $prevResult = mysql_query("SELECT serialnum, writerid, title, privacy FROM odtBoard WHERE serialnum<$serialnum_sequence and boardkind=$board and LENGTH(depth) = 1 and notice != 'Y' ORDER BY serialnum DESC");
    $prevRow = mysql_fetch_array($prevResult);
    
    $prevSerialNum = $prevRow[serialnum];
    $prevTitle = $prevRow[title];
    $prevPrivacy = $prevRow[privacy];
    
    if($prevTitle != "" && $prevSerialNum != "") {
        if($prevPrivacy == "Y") {
            if($row_member[id] && $row_member[id] == $prevRow[writerid]) {
                $prevScript = "";
                $prevTemp = "<a href=\"javascript:moveToPage($prevSerialNum);\">".stripslashes($prevTitle)."</a>";
            }
            else {
                $prevScript = "
                    <form method='post' action='od_boardread.php' name='noticeReadForm'>
                        <input type='hidden' name='Mode'>
                        <input type='hidden' name='board' value='$board'>
                        <input type='hidden' name='page' value='$page'>
                        <input type='hidden' name='field' value='$field'>
                        <input type='hidden' name='value' value='$value'>
                        <input type='hidden' name='serialnum' value='$prevSerialNum'>
                    </form>";

                $prevTemp = "<a href=\"javascript:openPasswordNotice('read');\">".stripslashes($prevTitle)."</a>";
            }

            $prevPrivacy_img_ = "<img src='$board_privacy_img'>";
        }
        else {
            $prevScript = "";
            $prevTemp = "<a href=\"javascript:moveToPage($prevSerialNum);\">".stripslashes($prevTitle)."</a>";
            $prevPrivacy_img_ = "";
        }
    }
    else {
        $prevTemp = "";
    }

    ## 읽어오기 ##########################################################################
    $row = mysql_fetch_array(mysql_query("SELECT * FROM odtBoard WHERE serialnum=$serialnum"));
    
    if(!$row) { 
        error_msgback_user("해당하는 값이 없습니다.   "); 
    }

    ## 비밀글 허용 체크 ###################################################################
    if($row[privacy] == "Y") {
        if($Mode == "readForm") {
            $_passWord = var_decode($pTemp);
            
            $privacy_result = mysql_query("SELECT password FROM odtBoard WHERE serialnum = $serialnum");
            $privacy_row = mysql_fetch_array($privacy_result);
            
            if($Cooki_Member_Level != 9) {
                $passwordDB = $privacy_row[password];       
                
                if(crypt($_passWord[passWord],$passwordDB) != $passwordDB) {
                    error_msgback_user("비밀글이므로 접근이 허용되지 않습니다.   ");
                }
            }
        }
        else {
            if($Cooki_Member_Level != 9 && $row_member[id] != $row[writerid]) error_msgback_user("비밀글이므로 접근이 허용되지 않습니다.   ");
        }
    }

    ## 변수 설정 #########################################################################
    $FamilyID = $row[familyid];
    
    if($row[email] != "") {
        $emailTemp = "
                        <tr> 
                            <td height='30' style='font-size:12px;LETTER-SPACING: -0.05em;font-family:돋움;'><b><font color='1A4775'>E-mail</font></b></td>
                            <td colspan='5'><a href='mailto:".$row[email]."'>$row[email]</a></td>
                        </tr>
                        <tr> 
                            <td height='1' colspan='6' bgcolor='E8E8E8'></td>
                        </tr>";
    }
    else {
        $emailTemp = "";
    }
    
    //$homepageTemp = substr($row[homepage],0,7);
    
    if($row[homepage] != "" && $row[homepage] != "http://") {
        $homepageTemp = "
                        <tr> 
                            <td height='30' style='font-size:12px;LETTER-SPACING: -0.05em;font-family:돋움;'><b><font color='1A4775'>홈페이지</font></b></td>
                            <td colspan='5'><a href='".$row[homepage]."' target='_blank'>$row[homepage]</a></td>
                        </tr>
                        <tr> 
                            <td height='1' colspan='6' bgcolor='E8E8E8'></td>
                        </tr>";
    }
    else {
        $homepageTemp = "";
    }
    
    if($row[htmls] == "Y") {
        $row[content] = stripslashes($row[content]);
    }
    else {
        $row[content] = stripslashes($row[content]);
        $row[content] = nl2br($row[content]);
    }

    $FileTemp = "";
    
    for($i=1;$i<=$configFileNum;$i++) {
        if($row["file$i"] != "" && file_exists("$folderpath_board_upload/".$row["file$i"])) {
            $SizeImgae = getimagesize("$folderpath_board_upload/".$row["file$i"]);
            $SizeFile = filesize("$folderpath_board_upload/".$row["file$i"]);
            
            if($SizeImgae[0] > 500) $sizeTemp = " width=500";
            else $sizeTemp = "";

            if($configBoardType == "ImageBoard") {
                $FileTemp .= "
                        <tr> 
                            <td valign='top' align='center'>
                                <img src='$urlpath_board_upload/".$row["file$i"]."' $sizeTemp><!--<br>(".$SizeImgae[0]."*".$SizeImgae[1].")--></td>
                        </tr>
                        <tr>
                            <td height='16'></td>
                        </tr>";
            }
            else {
                $FileTemp .= "
                        <tr> 
                            <td height='30' style='font-size:12px;LETTER-SPACING: -0.05em;font-family:돋움;'><b><font color='1A4775'>첨부파일$i</font></b></td>
                            <td colspan='5'><a href=\"javascript:fileDownload('".$row["file$i"]."')\">".$row["file$i"]."</a> (File Size : $SizeFile)</td>
                        </tr>
                        <tr> 
                            <td height='1' colspan='6' bgcolor='E8E8E8'></td>
                        </tr>";
            }

            if($configBoardType == "ImageBoard" && $row["filecomment$i"] != "") {
                $FileTemp .= "
                        <tr>
                            <td valign='top'>".$row["filecomment$i"]."</td>
                        </tr>
                        <tr>
                            <td height='16'></td>
                        </tr>";
            } 
            else if($configBoardType == "ImageBoard") {
                $FileTemp .= "";
            }
        }
    }
?>

        <script>
        <!--
            function moveToPage(boardindex) {
                ingForm = document.readForm;
                ingForm.serialnum.value = boardindex;
                ingForm.submit();
            }
            
            function fileDownload(fileTemp) {
                top.location='./od_download.php?board=<?=$board?>&file_name='+fileTemp;
            }
            
            var passwdWin;
            
            function openPassword(type) {
<? 
    if($Cooki_Member_Level == 9 || $row_member[id] && $row_member[id] == $row[writerid]) { 
?>
                if(type == "modify") {
                    document.readForm.Mode.value = 'modifyForm';
                    actionTemp = "od_boardmodify.php";
                }
                else {
                    document.readForm.Mode.value = 'deleteAnswer';
                    actionTemp = "od_boarddel.php";
                }
                
                document.readForm.action = actionTemp;
                document.readForm.submit();
<? 
    }
    else { 
?>
                document.readForm.action = 'od_passwordForm.php?mod='+type;
                document.readForm.target = 'passwdWin';
                passwdWin = window.open('','passwdWin','width=330,height=142');
                document.readForm.submit();
<? 
    } 
?>
            }

            function moveToReply() {
                document.readForm.Mode.value = 'replyForm';
                document.readForm.action = 'od_boardreply.php';
                document.readForm.submit();
            }

            function noticeDel(serialnum) {
<? 
    if($Cooki_Member_Level == 9 || $row_member[id] && $row_member[id] == $row[writerid]) { 
?>
                document.NoticeWriteForm.noticeserialnum.value = serialnum;
                document.NoticeWriteForm.action = 'od_noticedel.php';
                document.NoticeWriteForm.submit();
<? 
    }
    else { 
?>
                document.NoticeWriteForm.noticeserialnum.value = serialnum;
                document.NoticeWriteForm.action = 'od_passwordNotice.php';
                document.NoticeWriteForm.target = 'passwdWin';
                passwdWin = window.open('','passwdWin','width=330,height=142');
                document.NoticeWriteForm.submit();
<? 
    } 
?>
            }
        //-->
        </script>

<!-- top 시작 -->
<? include $_SERVER[DOCUMENT_ROOT]."/pages/subHead.html"; ?>
<!-- top 끝 -->

                                <!-- main start -->
                                <!-- 보드 설명부분 시작 -->

                                <table width="677" border="0" cellspacing="0" cellpadding="0">
                                    <form method='post' action='od_boardread.php' name="readForm">
                                        <input type='hidden' name='Mode'>
                                        <input type='hidden' name='board' value='<?=$board?>'>
                                        <input type='hidden' name='serialnum' value='<?=$serialnum?>'>
                                        <input type='hidden' name='page' value='<?=$page?>'>
                                        <input type='hidden' name='field' value='<?=$field?>'>
                                        <input type='hidden' name='value' value='<?=$value?>'>
                                        <input type="hidden" name="pTemp" value="<?=$pTemp?>">
                                    </form>
                                    <table width="677" border="0" cellspacing="0" cellpadding="0">
                                    <tr>
                                        <td height="30" valign="top" class="locat">
                                            <table width="677" border="0" cellpadding="0" cellspacing="0" >
                                                <tr> 
                                                    <td height="1" bgcolor="CDCDCD"></td>
                                                </tr>
                                                <tr align="center" bgcolor="F7F7F7"> 
                                                    <td height="30" align="center" bgcolor="F7F7F7"><strong><?=stripslashes($row[title])?></strong></td>
                                                </tr>
                                                <tr> 
                                                    <td height="1" bgcolor="CDCDCD"></td>
                                                </tr>
                                                <tr> 
                                                    <td>
                                                        <table width="677" border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF" class="blue" align="center">
                                                            <tr> 
                                                                <td width="66" height="30" class="num" style="font-size:12px;LETTER-SPACING: -0.05em;font-family:돋움;"><b><font color="1A4775">이름</font></b></td>
                                                                <td><?=stripslashes($row[writer])?></td>
                                                                <td width="40" style="font-size:12px;LETTER-SPACING: -0.05em;font-family:돋움;"><b><font color="1A4775">등록일</font></b></td>
                                                                <td width="80" class="num"><?=substr($row[wdate],0,10);?></td>
                                                                <td width="40" style='font-size:12px;LETTER-SPACING: -0.05em;font-family:돋움;'><b><font color="1A4775">조회</font></b></td>
                                                                <td width="70" class="num"><?=$row[readcount]?></td>
                                                            </tr>
                                                            <tr> 
                                                                <td height="1" colspan="6" bgcolor="E8E8E8"></td>
                                                            </tr>
                                                            <?=$emailTemp?>
                                                            <?=$homepageTemp?>
<? 
    if($configBoardType != "ImageBoard") { 
?>
                                                            <?=$FileTemp?>
<? 
    } 
?>
                                                        </table>
                                                    </td>
                                                </tr>
                                                <tr> 
                                                    <td valign="top" style="padding:20px;">
<?
    if($board == 3 AND $row[procode]) {
        if($row[procode]) {
            $prow = mysql_fetch_array(mysql_query("SELECT auctionCode, proname, startPrice, point FROM odtAuction WHERE auctionCode='$row[procode]'"));
            
            ## 현지가격
            $bidRow = mysql_fetch_row(mysql_query("SELECT MAX(bidPrice) FROM odtAuctionBids WHERE auctionCode='$row[auctionCode]' AND bidType='B' AND acondition = 'I'"));
            
            if(!$bidRow[0] || $bidRow[0] == 0) $bidRow[0] = $prow[startPrice];

            $move_pdetail = "../auction/auctiondetail.php?code=$prow[auctionCode]";
            $prod_img1 = "../upfiles/auction/$prow[auctionCode]s.jpg";
?>
                                                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                            <tr>
                                                                <td width="130">
                                                                    <a href='<?=$move_pdetail?>' onFocus='blur()'><img src="<?=$prod_img1?>" width="100" height="100" align="absmiddle" border="0"></a></td>
                                                                <td valign="top">
                                                                    경매번호 : <?=$prow[auctionCode]?><br>
                                                                    상품이름 : <b><?=stripslashes($prow[proname])?></b><br>
                                                                    현재가격 : <b><font color='FF7800'><?=number_format($bidRow[0])?>원</font></b><br>
                                                                    적립금 : <?=number_format($prow[point])?>원<br>
                                                                    <img src="../odimages/odboard//blank.gif" width="1" height="7"><br>
                                                                    <a href='<?=$move_pdetail?>' onFocus='blur()'>
                                                                    <img src="../odimages/odboard//go_detail.gif" align="absmiddle" border="0"></a>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td height="10"></td>
                                                            </tr>
                                                        </table>
<?
        }
    }
    else if($board==2 AND $row[procode]) {
        if($row[procode]) {
            $prow = mysql_fetch_array(mysql_query("SELECT * FROM odtProduct WHERE code='$row[procode]'"));
            
            $Length = strlen($prow[cateCode]);
            $proFilename = $prow[code]."s.jpg";
            $move_pdetail = "../odproducts/productdetail.php?code=$prow[code]&catecode=$prow[cateCode]&Length=$Length";
            $prod_img1 = "../upfiles/odproducts/$proFilename";
            
            ## 회원권한별 할인금액
            $row_memberber_sale_price = round_price($prow[price] * $row_member_sale_ratio / 100,$sale_ratio_round);
            $row_memberber_sale_point = $prow[point] * $row_member_sale_ratio / 100;
            
            ## 상품 즉석쿠폰 할인금액
            $coupon_sale_price = round_price($prow[price] * $prow[couponRatio1] / 100,$prow[couponround]);
            $coupon_sale_point = $prow[point] * $prow[couponRatio1] / 100;
            
            ## 보여질 상품가격 및 적립금
            $total_sale_price = $prow[price] - $row_memberber_sale_price - $coupon_sale_price;
            $total_sale_point = floor($prow[point] - $row_memberber_sale_point - $coupon_sale_point);
?>
                                                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                            <tr>
                                                                <td width="130">
                                                                    <a href='<?=$move_pdetail?>' onFocus='blur()'><img src="<?=$prod_img1?>" width="100" height="100" align="absmiddle" border="0"></a></td>
                                                                <td valign="top">
                                                                    분&nbsp;&nbsp;&nbsp;류 : <?=stripslashes($prow[cateName])?><br>
                                                                    상품명 : <b><?=stripslashes($prow[name])?></b><br>
                                                                    가&nbsp;&nbsp;&nbsp;격 : <b><font color='FF7800'><?=number_format($total_sale_price)?>원</font></b><br>
                                                                    적립금 : <?=number_format($total_sale_point)?>원<br>
                                                                    <img src="../odimages/odboard//blank.gif" width="1" height="7"><br>
                                                                    <a href='<?=$move_pdetail?>' onFocus='blur()'>
                                                                    <img src="../odimages/odboard//go_detail.gif" align="absmiddle" border="0"></a>
                                                                    <a onClick="openwindow('zoomimg', '../odproducts/zoomimg.php?code=<?=$prow[code]?>&ImgNum=1',600,519,0);" onfocus='this.blur()' style='cursor:hand;'><img src='../odimages/odboard//zoom_btn_1.gif' align='absmiddle' border='0'></a>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td height="10"></td>
                                                            </tr>
                                                        </table>
<?
        }
    }
?>
                                                        <?=$row[content]?></td>
                                                </tr>
                                                <tr> 
                                                    <td height="16"></td>
                                                </tr>
<? 
    if($configBoardType == "ImageBoard") { 
?>
                                                <?=$FileTemp?>
<? 
    } 

    if($prevTemp || $nextTemp) { 
?>
        <script>
            var passwdWin;
            
            function openPasswordNotice(type) {
<? 
        if($Cooki_Member_Level != 9) { 
?>
                document.noticeReadForm.action = 'od_passwordForm.php?mod='+type;
                document.noticeReadForm.target = 'passwdWin';
                passwdWin = window.open('','passwdWin','width=330,height=142');
                document.noticeReadForm.submit();
<? 
        }
        else { 
?>
                if(type == "read") {
                document.noticeReadForm.Mode.value = 'readForm';
                actionTemp = "od_boardcount.php";
                }
                document.noticeReadForm.action = actionTemp;
                document.noticeReadForm.submit();
<? 
        } 
?>
            }
        </script>
<? 
    } 
        
    if($row[notice] != "Y") { 
        if($nextTemp) { 
            echo"$nextScript"; 
?>
                                                <tr> 
                                                    <td height="1" style="padding-left:14px;" valign="top" class="notice">
                                                        <img src='../odimages/odboard/board_icon.gif' align="absmiddle"><font color='#0062BE'> 다음글</font> : <?=$nextTemp?> <?=$nextPrivacy_img_?></td>
                                                </tr>
<? 
        } 

        if($prevTemp) { 
            echo"$prevScript"; 
?>
                                                <tr> 
                                                    <td height="1" style="padding-left:14px;" valign="top" class="notice">
                                                        <img src='../odimages/odboard/board_icon.gif' align="absmiddle"><font color='#0062BE'> 이전글</font> : <?=$prevTemp?> <?=$nextPrivacy_img_?></td>
                                                </tr>
<?
        } 
?>
                                                <tr> 
                                                    <td height="16"></td>
                                                </tr>
<? 
    } 

    ## 댓글을 사용하는 경우에만 디스플레이 
    if($configNoticeUsed == "Yes") {
?>
                                                <!-- 댓글관련 정보 시작 -->
                                                <!-- 댓글 시작 -->
<?
        ## 공지글이 아닌경우에 출력해 준다.
        if($row[notice] != "Y") { 
?>
                                                <tr> 
                                                    <td valign="top" bgcolor="F8F8F8"  style="padding:12px;">
                                                        <table width="660" border="0" cellpadding="0" cellspacing="2" class="blue">
<?
            if($configNoticeUsed == "Yes") {
                $result = mysql_query("SELECT serialnum, writer, email, comment, wdate FROM odtBoardNotice WHERE boardserialnum = $serialnum");
                
                while($row = mysql_fetch_array($result)) {
                    if($row[email] != "") $writerTemp = "<a href='mailto:".$row[email]."'>".stripslashes($row[writer])."</a>";
                    else $writerTemp = stripslashes($row[writer]);
?>
                                                            <tr> 
                                                                <td width="82" valign="top"><font color="3F61AC"><img src="../odimages/odcommunity/icon_tail.gif" width="10" height="9" align="absmiddle"><?=$writerTemp?></font></td>
                                                                <td class="blue">
                                                                    <?=stripslashes($row[comment])?>
                                                                    <span class="num"><font color="959595"><?=substr($row[wdate],0,10)?></font></span>
                                                                    <a style='cursor:hand' onclick="noticeDel('<?=$row[serialnum]?>');">
                                                                    <img src="../odimages/odboard/n_delete_icon.gif" width="13" height="13" border="0" align="absmiddle" title=" 댓글삭제 "></a></td>
                                                            </tr>
                                                            <tr> 
                                                                <td height="8" colspan="2"  background="../odimages/odcommunity/dot_bg.gif"></td>
                                                            </tr>
<? 
                } 
?>
                                                        </table>
                                                    </td>
                                                </tr>
<?
                if($configNoticeLevel <= $Cooki_Member_Level) {
                    $textarea_value = "";
                    $textarea_style = "";
                    $notice_submit = "<input type='image' src='../odimages/common/detail_btn_submit02.gif' width='51' height='18'>";
                }
                else {
                    $textarea_value = "   
                        사용권한이 없습니다.";
                    $textarea_style = "style='background-color:EBEBEB' disabled";
                    $notice_submit = "<a onclick='authFunction();' onfocus='this.blur();' style='cursor:hand;'><img src='../odimages/common/detail_btn_submit02.gif' width='51' height='18' border='0'></a>";
                }
?>
                                                <tr> 
                                                    <td valign="top" bgcolor="F8F8F8"  style="padding:12px;">
                                                        <!-- 댓글 폼 시작 -->
                                                        <table  border="0" cellspacing="2" cellpadding="0">
                                                            <form name="NoticeWriteForm" method="post" action="od_noticewrite.php">
                                                                <input type='hidden' name='board' value='<?=$board?>'>
                                                                <input type='hidden' name='serialnum' value='<?=$serialnum?>'>
                                                                <input type='hidden' name='noticeserialnum'>
                                                                <input type='hidden' name='page' value='<?=$page?>'>
                                                                <input type='hidden' name='field' value='<?=$field?>'>
                                                                <input type='hidden' name='value' value='<?=$value?>'>
                                                                <input type="hidden" name="pTemp" value="<?=$pTemp?>">
                                                            <tr> 
                                                                <td width="82"><img src="../odimages/odcommunity/tail_name.gif" width="20" height="11"></td>
                                                                <td width="430"><img src="../odimages/odcommunity/tail_contents.gif" width="20" height="11"></td>
                                                                <td width="82"><img src="../odimages/odcommunity/tail_pw.gif" width="39" height="11"></td>
                                                                <td width="40" rowspan="2" align="right" valign="top">
                                                                    <br><input type="image" src="../odimages/odcommunity/tail_btn_ok.gif" width="38" height="22"></td>
                                                            </tr>
                                                            <tr> 
                                                                <td height="22" valign="top">
                                                                    <input name="writer" type="text" class="border" size="11" value="<?=$row_member[name]?>" <?=$textarea_style?>></td>
                                                                <td valign="top">
                                                                    <textarea name="comment" class="border" cols="70" rows="3" <?=$textarea_style?>><?=$textarea_value?></textarea></td>
                                                                <td valign="top">
                                                                    <input name="password" type="password" class="border" size="12"></td>
                                                            </tr>
                                                            </form>
                                                        </table>
                                                        <!-- 댓글 폼 종료 -->
                                                    </td>
                                                </tr>
<? 
            } 
?>
                                                <!-- 댓글 관련 테이블 종료 -->
<? 
        } 
        ## 공지글인 경우 
?>
                                                <tr> 
                                                    <td valign="top" height="2"></td>
                                                </tr>
<? 
    } 
    ## 댓글을 사용하는 경우에만 디스플레이
?>
                                                <!-- 댓글 종료 -->
                                                <tr> 
                                                    <td height="2" bgcolor="CDCDCD" style="padding:15px;"></td>
                                                </tr>
                                            </table>
                                            <table width="677" border="0" cellspacing="0" cellpadding="0">
                                                <tr> 
                                                    <td height="45">
                                                        <a href='<?=$boardmoveTemp?>?board=<?=$board?>&page=<?=$page?>&field=<?=$field?>&value=<?=$value?>'><img src='<?=$board_list_img?>' border='0'></a>
                                                    </td>
                                                    <td align=right>
<?
    ## 공지글 수정 및 삭제 버트 출력 부분 #############################
    if($row[notice] != "Y") {
        //if(($configWriteAuthority == "user" && $Cooki_Member_Level != "") || ($configWriteAuthority == "manager" && $Cooki_Member_Level == $Cooki_Manager_Level) || $configWriteAuthority == "nobody") {
        if($configWriteLevel <= $Cooki_Member_Level) {
            if($configReplyUsed=="Yes" && $configBoardType<>"ImageBoard") {
                echo "
                                                        <a style='cursor:hand' onclick=\"moveToReply()\">
                                                        <img src='$board_reply_img' border='0'></a>";
            }
        
            echo "
                                                        <!-- 글삭제 버튼 -->
                                                        <a style='cursor:hand' onclick=\"openPassword('delete');\">
                                                        <img src='$board_delete_img' border='0'></a>
                                                        <!-- 글수정 버튼 -->
                                                        <a style='cursor:hand' onclick=\"openPassword('modify');\">
                                                        <img src='$board_modify_img' border='0'></a>
                                                        <!-- 글쓰기 버튼 -->
                                                        <a href='od_boardinsert.php?board=$board&Mode=insertForm'>
                                                        <img src='$board_write_img' border='0'></a>";
        }
    }
    else {
        if($row_member[Mlevel] == 9) {
            echo "
                                                        <!-- 글삭제 버튼 -->
                                                        <a style='cursor:hand' onclick=\"openPassword('delete');\">
                                                        <img src='$board_delete_img' border='0'></a>
                                                        <!-- 글수정 버튼 -->
                                                        <a style='cursor:hand' onclick=\"openPassword('modify');\">
                                                        <img src='$board_modify_img' border='0'></a>
                                                        <!-- 글쓰기 버튼 -->
                                                        <a href='od_boardinsert.php?board=$board&Mode=insertForm'>
                                                        <img src='$board_write_img' border='0'></a>";
        }
    }
?>
                                                    </td>
                                                </tr>
                                            </table>

                                            <!-- 관련글 시작 -->
<? 
    if($row[notice] != "Y") { 
        if($configRelationUsed == "Yes") {
            ## Par 정리 ##########################################################################
            $parTempR = "?board=$board";
            if($page) $parTempR .= "&page=$page";
            if($field) $parTempR .= "&field=$field";
            if($value) $parTempR .= "&value=$value";
?>
            <script>
            <!--
                var passwdWin;
                
                function openPasswordRelation(type,serialnum) {
<? 
            if($Cooki_Member_Level != 9) { 
?>
                    document.relationReadForm.action = 'od_passwordForm.php?mod='+type+'&serialnum='+serialnum;
                    document.relationReadForm.target = 'passwdWin';
                    passwdWin = window.open('','passwdWin','width=330,height=142');
                    document.relationReadForm.submit();
<? 
            }
            else { 
?>
                    if(type == "read") {
                        document.relationReadForm.Mode.value = 'readForm';
                        document.relationReadForm.action = 'od_boardcount.php?serialnum='+serialnum;
                    }
                    document.relationReadForm.submit();
<? 
            } 
?>
                }
            //-->
            </script>

                                            <form method='post' action='od_boardread.php' name="relationReadForm">
                                                <input type='hidden' name='Mode'>
                                                <input type='hidden' name='board' value='<?=$board?>'>
                                                <input type='hidden' name='page' value='<?=$page?>'>
                                                <input type='hidden' name='field' value='<?=$field?>'>
                                                <input type='hidden' name='value' value='<?=$value?>'>
                                            </form>
<?
            $result = mysql_query("SELECT serialnum, writer, writerid, email, title, depth, wdate, privacy FROM odtBoard WHERE familyid = $FamilyID ORDER BY depth");
            $relationTotal = mysql_num_rows($result);

            if($relationTotal > 0) {
?>
                                            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                <tr> 
                                                  <td height="26"></td>
                                                </tr>
                                            </table>
                                            <table width="677" border="0" cellspacing="0" cellpadding="0">
                                                <tr> 
                                                    <td height="20" valign="top" class="locat">
                                                        <img src="../odimages/odcommunity/st_relation.gif" width="43" height="13" align="absmiddle"> <b><?=$relationTotal?></b> 건</td>
                                                </tr>
                                                <tr> 
                                                    <td valign="top">
                                                        <table width="677" border="0" cellpadding="0" cellspacing="0"align="center" >
                                                            <tr bgcolor="CDCDCD"> 
                                                                <td height="1" colspan="4"></td>
                                                            </tr>
                                                            <tr align="center" bgcolor="F7F7F7"> 
                                                                <td width="40" height="30" bgcolor="F7F7F7"><img src="../odimages/odcommunity/list_t01.gif" width="20" height="12"></td>
                                                                <td><img src="../odimages/odcommunity/list_t02.gif" width="20" height="12"></td>
                                                                <td width="55"><img src="../odimages/odcommunity/list_t03.gif" width="29" height="12"></td>
                                                                <td width="75"><img src="../odimages/odcommunity/list_t04.gif" width="29" height="12"></td>
                                                            </tr>
                                                            <tr bgcolor="CDCDCD"> 
                                                                <td height="1" colspan="4"></td>
                                                            </tr>
                                                            <tr> 
                                                                <td height="5" colspan="4"></td>
                                                            </tr>
                                                        </table>
                                                        <table width="677" border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF" class="blue">
<?
                while($row = mysql_fetch_array($result)) {
                    $PageCount++;
                    $Space = "";
                    $row[title] = han_substr($row[title],$titleLimit);
                    
                    if(strlen($row[depth]) > 1) {
                        for($i=1;$i<strlen($row[depth]);$i++) $Space = $Space."&nbsp";

                        $Space = $Space."<img src='$board_reply_icon_img' border='0'>";
                    }

                    $parTempR = "$parTempR&serialnum=".$row[serialnum];

                    if($row[email] != "") {
                        $row[email] = encode_email($row[email]);
                        $writerTemp = "<a href='mailto:".$row[email]."'>".stripslashes($row[writer])."</a>";
                    }
                    else {
                        $writerTemp = stripslashes($row[writer]);
                    }

                    $inputDate = mktime(substr($row[wdate],11,2),substr($row[wdate],14,2),substr($row[wdate],17,2),substr($row[wdate],5,2),substr($row[wdate],8,2),substr($row[wdate],0,4));
                    
                    if($inputDate <= time() AND time() <= $inputDate+($configiconNew*86400)) 
                        $new_img_ = "&nbsp;<img src='$board_new_img' align='absmiddle'>";
                    else $new_img_ = "";
                    
                    $dateTemp = substr($row[wdate],0,10);

                    ## 글읽기 권한 체크
                    if($configReadLevel <= $Cooki_Member_Level) {
                        if($row[privacy] == "Y") {
                            if($row_member[id] && $row_member[id] == $row[writerid]) $read_href_ = "<a href='od_boardcount.php".$parTempR."'>";
                            else $read_href_ = "<a href=\"javascript:openPasswordRelation('read','$row[serialnum]');\">";
                            
                            $privacy_img_ = "<img src='$board_privacy_img' border=0 align='absmiddle'>";
                        }
                        else {
                            $read_href_ = "<a href='od_boardcount.php".$parTempR."'>";
                            $privacy_img_ = "";
                        }
                    }
                    else {
                        $read_href_ = "<a onclick='authFunction();' onfocus='this.blur();' style='cursor:hand;'>";
                        
                        if($row[privacy] == "Y") $privacy_img_ = "<img src='$board_privacy_img' border=0 align='absmiddle'>";
                        else $privacy_img_ = "";
                    }
?>
                                                            <tr> 
                                                                <td width="40" height="25" align="center" class="num"><?=$PageCount?></td>
                                                                <td><?=$Space?> <?=$read_href_?><?=stripslashes($row[title])?></a> <?=$new_img_?> <?=$privacy_img_?></td>
                                                                <td width="55" align="center"><?=$writerTemp?></td>
                                                                <td width="75" align="center" class="num"><?=$dateTemp?></td>
                                                            </tr>
                                                            <tr> 
                                                                <td height="1" colspan="4" bgcolor="E8E8E8"></td>
                                                            </tr>
<? 
                } 
?>
                                                        </table>
                                                    </td>
                                                </tr>
                                            </table>
<? 
            } 
            ## 관련글 if문 종료 
        } 
        ## 관련글 사용여부 if문 종료 
    } 
    ## 공지글 if문 종료 
?>
                                            <!-- 관련글 종료 -->
                                        </td>
                                    </tr>
                                </table>

<? include $_SERVER[DOCUMENT_ROOT]."/pages/subFoot.html"; ?>
