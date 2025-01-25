<?php
if(!defined('__GRBOARD__')) exit();

// 테마 라이브러리 불러오기
include $theme."/lib.php";

// 상품 정보보기시 이미지 최대크기 지정
$maxProductImgSize = 300;

// 게시물 보기시 이미지 최대크기 지정 (지정한 크기 이상이면 자동 리사이즈)
$maxImageWidth = 550; # ← 여기 숫자 (픽셀 단위입니다) 를 자신의 홈페이지에 맞게 조절해주세요. (기본: 550)
$content = autoImgResize($maxImageWidth, $content);
?>
<div class="viewTitle">
	<?php echo $subject; ?>
	<div class="btn"><?php if($isTrackback) { ?><input type="button" onclick="clickToCopy('<?php echo $trackbackUrl; ?>');" title="이 글의 엮인글(트랙백) 주소 입니다." value="Trackback" />
	<?php } if($view['link1']) { ?><input type="button" onclick="window.open('<?php echo htmlspecialchars($view['link1']); ?>', '_blank'); return false" title="링크 #1 이 있습니다." value="Link 1" />
	<?php } if($view['link2']) { ?><input type="button" onclick="window.open('<?php echo htmlspecialchars($view['link2']); ?>', '_blank'); return false" title="링크 #2 이 있습니다." value="Link 2" /><?php } ?>
	</div>
</div>

<div class="viewContent">
	<!-- 게시물 내용 출력 -->
	<div id="mainContent">
		<table rules="none" summary="GR Board Article List" cellpadding="0" cellspacing="0" border="0" style="width: 100%; table-layout: fixed">
		<caption></caption>
		<colgroup>
			<col style="width: <?php echo $maxProductImgSize+30; ?>px" />
			<col style="width: 120px" />
			<col />
		</colgroup>	
		<tbody>
		<tr>
			<td rowspan="10" class="productImg"><?php
			// 첨부파일 #1 의 정보 가져오기
			$getFile1 = @mysql_fetch_array(mysql_query('select file_route from '.$dbFIX.'pds_extend where id = \''.$id.'\' and article_num = '.$articleNo.' order by no asc limit 1'));
			$ft = end(explode('.', $getFile1['file_route']));
			if($ft != 'jpg' && $ft != 'gif' && $ft != 'png' && $ft != 'bmp') $getFile1['file_route1'] = $theme.'/image/no_img.jpg';
			$discountPercent = round(100 - (($view['ext_money_real']/$view['ext_money_original'])*100), 2);
			?><a href="<?php echo $getFile1['file_route']; ?>" onclick="return hs.expand(this)" title="클릭하시면 상품 사진을 크게 봅니다."><img src="<?php echo $grboard; ?>/phpThumb/phpThumb.php?src=../<?php echo $getFile1['file_route']; ?>&amp;w=<?php echo $maxProductImgSize; ?>&amp;h=<?php echo $maxProductImgSize; ?>&amp;q=100&amp;fltr[]=usm|99|0.5|3" alt="미리보기" /></a></td>
			<td class="opt">판매가 (정가)</td>
			<td class="var"><?php echo number_format($view['ext_money_original']); ?>원</td>
		</tr>
		<tr>
			<td class="opt">할인된 판매가</td>
			<td class="var"><strong><?php echo number_format($view['ext_money_real']); ?></strong>원 (<?php echo $discountPercent; ?>% 할인)</td>
		</tr>
		<tr>
			<td class="opt">적립금</td>
			<td class="var"><?php echo number_format($view['ext_money_save']); ?>원</td>
		</tr>
		<tr>
			<td class="opt">구매할 수량</td>
			<td class="var"><select name="getProductNumber"><?php
			for($p=1; $p<=$view['ext_number_get']; $p++) echo '<option value="'.$p.'"'.(($p==1)?' selected="selected"':'').'>'.$p.'</option>';
			?></select>개</td>
		</tr>
		<tr>
			<td class="opt">제조사/원산지</td>
			<td class="var"><?php echo stripslashes($view['ext_from_made']); ?></td>
		</tr>
		<tr>
			<td class="opt">배송비</td>
			<td class="var"><?php echo (!$view['ext_transport_cost'])?'<img src="'.$theme.'/image/cost.free.transport.gif" alt="무료배송" />':number_format($view['ext_transport_cost']).'원'; ?></td>
		</tr>
		<tr>
			<td class="opt">배송기간</td>
			<td class="var"><?php echo $view['ext_transport_term']; ?>일</td>
		</tr>
		<tr>
			<td class="opt">반품/교환안내</td>
			<td class="var"><?php echo stripslashes($view['ext_exchange_info']); ?></td>
		</tr>
		<tr>
			<td class="opt">상품코드</td>
			<td class="var"><?php echo stripslashes($view['ext_product_code']); ?></td>
		</tr>
		<tr>
			<td class="opt" style="border-bottom: #ddd 1px solid">기타안내</td>
			<td class="var" style="border-bottom: #ddd 1px solid"><?php echo stripslashes($view['ext_etc_info']); ?></td>
		</tr>
		<tr>
			<td colspan="3" class="grshopBtn">
			<a href="#" onclick="addCart('<?php echo $id; ?>', '<?php echo $articleNo; ?>', '<?php echo $theme; ?>');"><img src="<?php echo $grboard.'/'.$theme; ?>/image/grshop-cart-btn.gif" alt="장바구니에 담기" /></a>
			<a href="<?php echo $grshop; ?>/cash/?bbs_id=<?php echo $id; ?>&amp;bbs_no=<?php echo $articleNo; ?>"><img src="<?php echo $grboard.'/'.$theme; ?>/image/grshop-cash-btn.gif" alt="구매신청 하기" /></a>
			</td>
		</tr>
		</tbody>
		</table>
		<div style="padding-top: 15px"><?php echo $content; ?></div>
		<div id="writeBy">작성자: <?php echo $view['name']; ?>, 작성시각: <?php echo date('Y.m.d H:i:s', $view['signdate']); ?></div>
	</div>

	<!-- 태그 출력 -->
	<div class="viewTag">
		<p><img src="<?php echo $grboard.'/'.$theme; ?>/image/icon_tag.gif" alt="태그" /> <?php echo $tag; ?></p>
		<p><img src="<?php echo $grboard.'/'.$theme; ?>/image/disk.gif" alt="첨부파일" />
		<?php
		// 추가 첨부된 파일 목록
		$extendLoop = 1;
		$getExtendFile = @mysql_query('select no, file_route from '.$dbFIX.'pds_extend where id = \''.$id.'\' and article_num = '.$articleNo);
		while($extendFile = @mysql_fetch_array($getExtendFile)) { 
			$extendFileName = end(explode('/', $extendFile['file_route']));
			echo showDownImg($extendFileName, $extendFile['no']); 
			$extendLoop++; 
		} ?></p>
	</div>

	<!-- 작성자 소개 출력 -->
	<?php echo showMemberInfo($view['member_key']); ?>

	<!-- 하단 싱크걸기, 추천, 비추, 담기 버튼 출력 -->
	<div id="goodORbad">
		<?php if($isWriter) { ?><a href="#" onclick="window.open('<?php echo $grboard; ?>/sync.php?id=<?php echo $id; ?>&amp;articleNo=<?php echo $articleNo; ?>', 'sinkNET', 'width=10,height=10,menubar=no');" title="이 글을 시리니넷 SinkNET™ 에 싱크(Sync) 합니다."><img src="<?php echo $grboard.'/'.$theme; ?>/image/btn_sink.gif" alt="싱크걸기" /></a><?php } ?> 
		<a href="<?php echo $grboard; ?>/board.php?id=<?php echo $id; ?>&amp;articleNo=<?php echo $articleNo; ?>&amp;good=1" style="color: #386d9f" title="이 글이 좋습니다."><img src="<?php echo $grboard.'/'.$theme; ?>/image/btn_good.gif" alt="추천" /></a> 
		<a href="<?php echo $grboard; ?>/view_scrap.php?isAdd=1&amp;id=<?php echo $id; ?>&amp;article_num=<?php echo $articleNo; ?>" onclick="window.open(this.href, 'addScrap', 'width=600,height=650,menubar=no,scrollbars=yes'); return false" style="color: #a25757" title="이 글을 내 스크랩북에 담습니다."><img src="<?php echo $grboard.'/'.$theme; ?>/image/btn_scrap.gif" alt="스크랩" /></a> 
		<a href="<?php echo $grboard; ?>/report.php?id=<?php echo $id; ?>&amp;article_num=<?php echo $articleNo; ?>" onclick="window.open(this.href, 'addReport', 'width=600,height=650,menubar=no,scrollbars=yes'); return false" style="color: green" title="이 글을 관리자와 마스터에게 신고합니다."><img src="<?php echo $grboard.'/'.$theme; ?>/image/btn_report.gif" alt="신고" /></a>
	</div>
</div>