<?php
if(!defined('__GRSHOP__')) exit();

// 설정 저장하기
if($_POST['saveConfig']) {
	@extract($_POST);
	$shop->set('layout_skin', $layout_skin);
	$shop->set('outlogin_skin', $outlogin_skin);
	$shop->set('login_skin', $login_skin);
	$shop->set('order_skin', $order_skin);
	$shop->set('cart_skin', $cart_skin);
	$shop->set('cash_skin', $cash_skin);
	$shop->set('mypage_skin', $mypage_skin);
	$shop->set('shop_title', $shop_title);
	$shop->set('seller_money_code', $seller_money_code);
	$shop->set('seller_address', $seller_address);
	$shop->set('seller_code', $seller_code);
	$shop->set('seller_register_number', $seller_register_number);
	$shop->set('seller_name', $seller_name);
	$shop->set('seller_protector', $seller_protector);
	$shop->set('seller_ceo', $seller_ceo);
	$shop->set('seller_telephone', $seller_telephone);
	$shop->set('seller_fax', $seller_fax);
	$shop->set('seller_messenger', $seller_messenger);
	$shop->set('seller_email', $seller_email);
	$shop->set('latest_product_skin', $latest_product_skin);
	$shop->set('latest_post_skin', $latest_post_skin);
	$shop->set('latest_total_skin', $latest_total_skin);
	$shop->set('agspay_StoreId', $agspay_StoreId);
	if($grcounter_id) $core->fileWrite('../core.php', '<?php $grcore = \''.$_grcore.'\'; $dbFIX = \''.$shop->prefix.'\'; $grid = \''.$grcounter_id.'\'; ?>');
	if($_FILES['shop_logo']) {
		$filename = $_FILES['shop_logo']['name'];
		$filetype = $_FILES['shop_logo']['type'];
		$filesize = $_FILES['shop_logo']['size'];
		$filetmpname = $_FILES['shop_logo']['tmp_name'];
		if($filesize > 0 && is_uploaded_file($filetmpname)) {
			@unlink('../'.$shop->get('shop_logo', ''));
			$filetmpname = str_replace('\\\\', '\\', $filetmpname);
			$filename = str_replace(' ', '_', $filename);
			$filename = str_replace('-', '_', $filename);
			$type = @end(explode('.', $filename));
			if($type != 'jpg' && $type != 'gif' && $type != 'png' && $type != 'bmp') $core->alert('그림 파일이 아닙니다.', './?menu=4');
			if(preg_match("/[가-힣]/uism", $filename)) $filename = md5($filename).'.'.$type;
			if(!move_uploaded_file($filetmpname, '../'.$filename)) $core->alert('로고파일 업로드 실패 : 파일이 너무 크지 않은지 확인해 보세요', './?menu=4');
			$shop->set('shop_logo', $filename);
		}
	}
	$core->alert('설정을 저장하였습니다.', './?menu=4');
}

// GR보드 설정 가져오기
$_grcore = $grcore;
include $grboard.'/core.php';
$grcore = $_grcore;
?>

<div id="shopInfo" class="infoBox">
<strong>GR Shop 매장관리 화면입니다.</strong><br />
이 곳에서는 실제로 GR Shop 첫화면에 접속할 때 보여지는 매장의 전체적인 설정을 총괄합니다.<br />
소소한 것으로는 브라우저 제목표시줄에 보여지는 웹사이트 이름부터 사용할 GR Shop 레이아웃 스킨까지<br />
겉으로 보여지는 쇼핑몰 모습들을 하나씩 설정할 수 있습니다.<br />
<br />
GR Shop 에서는 겉으로 보여지는 디자인들은 전적으로 사용하시는 레이아웃 스킨에 따라서 달라집니다.<br />
따라서 이 곳에서는 레이아웃 스킨들별로 공통으로 사용할 설정만 관리하실 수 있습니다.<br />
각 레이아웃 스킨별로 세부적인 설정은 사용할 레이아웃 스킨을 선택하신 이후 GR Shop 첫화면으로 가시면<br />
우측 하단에 "레이아웃 설정" 버튼이 있는데, 이를 클릭하시면 해당 레이아웃에서 필요로하는 설정을 저장하실 수 있습니다.<br />
<br />
GR Shop 의 레이아웃 스킨과는 별도로, 게시판 스킨은 다시 GR Board 관리화면으로 가셔서<br />
사용하실 스킨을 선택하셔야 합니다. 이 곳에서 설명해드리는 "레이아웃 스킨" 은 GR Board 에서의 그 스킨과<br />
전혀 별개이므로 혼동하지 않으시길 바랍니다.
</div>

<form id="configuration" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>?menu=4" enctype="multipart/form-data">
<div><input type="hidden" name="saveConfig" value="1" /></div>
<div id="shopHelp" class="main">

<h2>디자인 설정 관리</h2>

<table rules="none" summary="GR Shop Config List" cellpadding="0" cellspacing="0" border="0">
<caption></caption>
<thead> 
<tr>
	<th style="width: 230px">옵션</th>
	<th style="width: 350px">설정</th>
	<th>설명</th>
</tr>
</thead>
<tbody>
<tr>
	<td class="bg">GR Shop 레이아웃 스킨선택</td>
	<td class="bg"><select name="layout_skin"><?php
	$_layout = $shop->get('layout_skin');
	$layoutList = opendir('../layout');
	while($layout = readdir($layoutList)) {
		if($layout == '.' || $layout == '..') continue;
		echo '<option value="'.$layout.'"'.(($layout==$_layout)?' selected="selected"':'').'>'.$layout.'</option>';
	}
	closedir($layoutList);
	?></select></td>
	<td class="bg">GR Shop 매장 디자인을 결정하는 스킨을 선택합니다.</td>
</tr>
<tr>
	<td>GR Shop 구매하기 스킨선택</td>
	<td><select name="cash_skin"><?php
	$_cash = $shop->get('cash_skin');
	$cashList = opendir('../cash/skin');
	while($cash = readdir($cashList)) {
		if($cash == '.' || $cash == '..') continue;
		echo '<option value="'.$cash.'"'.(($cash==$_cash)?' selected="selected"':'').'>'.$cash.'</option>';
	}
	closedir($layoutList);
	?></select></td>
	<td>장바구니 화면 혹은 상품 진열 게시판에서 "구매하기" 버튼을 클릭할 경우 보여지는 페이지 디자인을 선택합니다. 구매하기 스킨은 레이아웃 스킨 속에서 보여집니다.</td>
</tr>
<tr>
	<td class="bg">GR Shop 자체로그인 스킨선택</td>
	<td class="bg"><select name="login_skin"><?php
	$_login = $shop->get('login_skin');
	$loginList = opendir('../login/skin');
	while($login = readdir($loginList)) {
		if($login == '.' || $login == '..') continue;
		echo '<option value="'.$login.'"'.(($login==$_login)?' selected="selected"':'').'>'.$login.'</option>';
	}
	closedir($loginList);
	?></select></td>
	<td class="bg">GR Shop 자체 로그인 페이지의 스킨을 선택합니다. 자체로그인 스킨은 레이아웃 스킨 속에서 보여집니다.</td>
</tr>
<tr>
	<td>GR Shop 주문조회 스킨선택</td>
	<td><select name="order_skin"><?php
	$_order = $shop->get('order_skin');
	$orderList = @opendir('../order/skin');
	while($order = @readdir($orderList)) {
		if($order == '.' || $order == '..') continue;
		echo '<option value="'.$order.'"'.(($order==$_order)?' selected="selected"':'').'>'.$order.'</option>';
	}
	@closedir($orderList);
	?></select></td>
	<td>주문한 물품들을 조회할 때 보여지는 페이지 디자인을 결정하는 스킨을 선택합니다. 주문조회 스킨은 레이아웃 스킨 속에서 보여집니다.</td>
</tr>
<tr>
	<td class="bg">GR Shop 장바구니 스킨선택</td>
	<td class="bg"><select name="cart_skin"><?php
	$_cart = $shop->get('cart_skin');
	$cartList = @opendir('../cart/skin');
	while($cart = @readdir($cartList)) {
		if($cart == '.' || $cart == '..') continue;
		echo '<option value="'.$cart.'"'.(($cart==$_cart)?' selected="selected"':'').'>'.$cart.'</option>';
	}
	@closedir($cartList);
	?></select></td>
	<td class="bg">찜한 물품 목록들을 조회할 때 보여지는 페이지 디자인을 선택합니다. 장바구니 스킨은 레이아웃 스킨 속에서 보여집니다.</td>
</tr>
<tr>
	<td>GR Shop 마이페이지 스킨선택</td>
	<td><select name="mypage_skin"><?php
	$_mypage = $shop->get('mypage_skin');
	$mypageList = @opendir('../mypage/skin');
	while($mypage = @readdir($mypageList)) {
		if($mypage == '.' || $mypage == '..') continue;
		echo '<option value="'.$mypage.'"'.(($mypage==$_mypage)?' selected="selected"':'').'>'.$mypage.'</option>';
	}
	@closedir($mypageList);
	?></select></td>
	<td>결혼 여부, 쌓은 적립금 확인, 최근 구매한 물품 등의 항목들을 보는 페이지 디자인을 선택합니다. 마이페이지 스킨은 레이아웃 스킨 속에서 보여집니다.</td>
</tr>
<tr>
	<td class="bg">쇼핑몰 이름</td>
	<td class="bg"><input type="text" class="i" name="shop_title" value="<?php echo $shop->get('shop_title'); ?>" /></td>
	<td class="bg">GR Shop 매장의 이름을 정합니다.</td>
</tr>
<tr>
	<td>쇼핑몰 로고 업로드</td>
	<td><div><input type="file" class="i" name="shop_logo" /></div>
	<?php if($shop->get('shop_logo', '')) { ?><div><img src="../<?php echo $shop->get('shop_logo'); ?>" alt="GR Shop LOGO" /></div>
	<?php } if(!is_writable('../')) echo '<div style="color: red">※ GR Shop 디렉토리의 퍼미션(접근권한)을 707로 변경해 주세요!</div>'; ?>
	</td>
	<td>GR Shop 매장의 로고를 업로드 합니다. 사용하시는 레이아웃 스킨에 따라 나타나는 위치가 다르며 배경색, 알맞은 크기가 다르므로 참고해 주세요.</td>
</tr>
</tbody>
</table>

<h2>사업자 정보 관리</h2>

<table rules="none" summary="GR Shop Config List" cellpadding="0" cellspacing="0" border="0">
<caption></caption>
<thead> 
<tr>
	<th style="width: 200px">옵션</th>
	<th style="width: 300px">설정</th>
	<th>설명</th>
</tr>
</thead>
<tbody>
<tr>
	<td>무통장 입금 계좌번호</td>
	<td><input type="text" class="i" name="seller_money_code" value="<?php echo $shop->get('seller_money_code', ''); ?>" /></td>
	<td>고객들이 물품 구매할 때 어디로 돈을 입금하면 되는지 적어주세요.<br />(예: OO은행 / 홍길동 / 123456-00-654321)</td>
</tr>
<tr>
	<td class="bg">사업자 주소</td>
	<td class="bg"><input type="text" class="i" name="seller_address" value="<?php echo $shop->get('seller_address', ''); ?>" /></td>
	<td class="bg">실제 판매자/회사/공장의 주소지를 적어주세요. (예: ㅁㅁ시 OO구 ...)</td>
</tr>
<tr>
	<td>사업자 등록번호</td>
	<td><input type="text" class="i" name="seller_code" value="<?php echo $shop->get('seller_code', ''); ?>" /></td>
	<td>사업자 등록번호를 적어주세요. (예: 123-45-67890)</td>
</tr>
<tr>
	<td class="bg">통신판매업 신고번호</td>
	<td class="bg"><input type="text" class="i" name="seller_register_number" value="<?php echo $shop->get('seller_register_number', ''); ?>" /></td>
	<td class="bg">통신판매업 신고번호를 적어주세요. (예: OO구청 제 2000-01234호)</td>
</tr>
<tr>
	<td>상호명</td>
	<td><input type="text" class="i" name="seller_name" value="<?php echo $shop->get('seller_name', ''); ?>" /></td>
	<td>등록된 상호명을 적어주세요. (예: 대박쇼핑 인터넷)</td>
</tr>
<tr>
	<td class="bg">개인정보보호책임자</td>
	<td class="bg"><input type="text" class="i" name="seller_protector" value="<?php echo $shop->get('seller_protector', ''); ?>" /></td>
	<td class="bg">개인정보보호 책임자 성함을 적어주세요. (예: 홍길동)</td>
</tr>
<tr>
	<td>쇼핑몰 대표자</td>
	<td><input type="text" class="i" name="seller_ceo" value="<?php echo $shop->get('seller_ceo', ''); ?>" /></td>
	<td>이 쇼핑몰의 대표자(대표이사) 성함을 적어주세요. (예: 이몽룡)</td>
</tr>
<tr>
	<td class="bg">대표 전화번호</td>
	<td class="bg"><input type="text" class="i" name="seller_telephone" value="<?php echo $shop->get('seller_telephone', ''); ?>" /></td>
	<td class="bg">고객이 전화상담을 할 수 있는 (집 혹은 휴대폰)번호를 적어주세요.</td>
</tr>
<tr>
	<td>대표 팩스번호</td>
	<td><input type="text" class="i" name="seller_fax" value="<?php echo $shop->get('seller_fax', ''); ?>" /></td>
	<td>고객이 팩스를 보낼 수 있는 번호를 적어주세요.</td>
</tr>
<tr>
	<td class="bg">대표 메신져</td>
	<td class="bg"><input type="text" class="i" name="seller_messenger" value="<?php echo $shop->get('seller_messenger', ''); ?>" /></td>
	<td class="bg">온라인으로 상담 할 수 있는 메신져 아이디를 입력하세요.</td>
</tr>
<tr>
	<td>대표 이메일</td>
	<td><input type="text" class="i" name="seller_email" value="<?php echo $shop->get('seller_email', ''); ?>" /></td>
	<td>고객의 이메일을 받는 대표 이메일주소를 적어주세요.</td>
</tr>
</tbody>
</table>

<h2>GR시리즈 연동설정</h2>

<table rules="none" summary="GR Shop Config List" cellpadding="0" cellspacing="0" border="0">
<caption></caption>
<thead> 
<tr>
	<th style="width: 230px">옵션</th>
	<th style="width: 350px">설정</th>
	<th>설명</th>
</tr>
</thead>
<tbody>
<tr>
	<td class="bg">GR Counter 통계수집 ID</td>
	<td class="bg"><input type="text" class="i" name="grcounter_id" value="<?php echo $grid; ?>" /></td>
	<td class="bg">GR Counter 에서 GR Shop 의 접속 통계 수집을 위해 만들어둔 ID 를 입력해 주세요. (예: index) 사용하지 않을 시 빈 칸으로 두세요.</td>
</tr>
<tr>
	<td>GR Board 외부로그인 스킨선택</td>
	<td><select name="outlogin_skin"><?php
	$_outlogin = $shop->get('outlogin_skin');
	$outloginList = @opendir($grboard.'/outlogin');
	while($outlogin = @readdir($outloginList)) {
		if($outlogin == '.' || $outlogin == '..') continue;
		echo '<option value="'.$outlogin.'"'.(($outlogin==$_outlogin)?' selected="selected"':'').'>'.$outlogin.'</option>';
	}
	@closedir($outloginList);
	?></select></td>
	<td>선택하신 GR Shop 레이아웃 스킨에서 사용할 GR Board 외부로그인 스킨을 선택합니다. GR Board 외부로그인 스킨은 <?php echo str_replace('../', '', $grboard); ?>/outlogin/ 에 위치해 있습니다.</td>
</tr>
<tr>
	<td class="bg">GR Board 외부상품진열 스킨선택</td>
	<td class="bg"><select name="latest_product_skin"><?php
	$_product = $shop->get('latest_product_skin');
	$productList = @opendir($grboard.'/latest');
	while($product = @readdir($productList)) {
		if($product == '.' || $product == '..') continue;
		echo '<option value="'.$product.'"'.(($product==$_product)?' selected="selected"':'').'>'.$product.'</option>';
	}
	@closedir($productList);
	?></select></td>
	<td class="bg">선택하신 GR Shop 레이아웃 스킨에서 사용할 GR Board 최근게시물 스킨 (상품진열용) 을 선택합니다. GR Board 최근게시물 스킨은 <?php echo str_replace('../', '', $grboard); ?>/latest/ 에 위치해 있습니다.</td>
</tr>
<tr>
	<td>GR Board 일반 최근게시물 스킨선택</td>
	<td><select name="latest_post_skin"><?php
	$_post = $shop->get('latest_post_skin');
	$postList = @opendir($grboard.'/latest');
	while($post = @readdir($postList)) {
		if($post == '.' || $post == '..') continue;
		echo '<option value="'.$post.'"'.(($post==$_post)?' selected="selected"':'').'>'.$post.'</option>';
	}
	@closedir($postList);
	?></select></td>
	<td>선택하신 GR Shop 레이아웃 스킨에서 사용할 GR Board 최근게시물 스킨 (보통) 을 선택합니다. GR Board 최근게시물 스킨은 <?php echo str_replace('../', '', $grboard); ?>/latest/ 에 위치해 있습니다.</td>
</tr>
<tr>
	<td class="bg">GR Board 통합 최근게시물 스킨선택</td>
	<td class="bg"><select name="latest_total_skin"><?php
	$_total = $shop->get('latest_total_skin');
	$totalList = @opendir($grboard.'/latest');
	while($total = @readdir($totalList)) {
		if($total == '.' || $total == '..') continue;
		echo '<option value="'.$total.'"'.(($total==$_total)?' selected="selected"':'').'>'.$total.'</option>';
	}
	@closedir($totalList);
	?></select></td>
	<td class="bg">선택하신 GR Shop 레이아웃 스킨에서 사용할 GR Board 통합 최근게시물 스킨 (신상품 진열용) 을 선택합니다. GR Board 통합 최근게시물 스킨은 <?php echo str_replace('../', '', $grboard); ?>/latest/ 에 위치해 있습니다.</td>
</tr>
</tbody>
</table>

<h2>전자결제 [올더게이트] 연동설정</h2>

<table rules="none" summary="GR Shop Config List" cellpadding="0" cellspacing="0" border="0">
<caption></caption>
<thead> 
<tr>
	<th style="width: 200px">옵션</th>
	<th style="width: 300px">설정</th>
	<th>설명</th>
</tr>
</thead>
<tbody>
<tr>
	<td>상점아이디</td>
	<td><input type="text" class="i" name="agspay_StoreId" value="<?php echo $shop->get('agspay_StoreId', 'aegis'); ?>" /></td>
	<td>(주)이지스효성의 [<a href="http://www.allthegate.com/" onclick="window.open(this.href, '_blank'); return false">올더게이트</a>] 전자결제용 상점 아이디를 입력하세요. 만약 올더게이트 전자결제 서비스 신청을 하시지 않은 경우에는 <a href="http://www.allthegate.com/hyosung/app/process.jsp" onclick="window.open(this.href, '_blank'); return false">여기를 클릭</a>하셔서 신청절차에 대해 알아보실 수 있습니다. (기본값 aegis 는 테스트용 상점아이디입니다.)</td>
</tr>
</tbody>
</table>

</div>
<div style="padding-top: 20px"><input class="s" type="submit" value="저장하기" /></div>
</form>