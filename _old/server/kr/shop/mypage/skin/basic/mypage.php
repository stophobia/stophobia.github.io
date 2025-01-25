<?php if(!defined('__GRSHOP__')) exit(); ?>

<div id="mypageField">

<div class="infoBox">
<strong>마이페이지에서 자신의 부가정보를 확인하고, (필요시) 수정하실 수 있습니다.</strong><br />
이 곳에서 고객님의 기본 회원정보와, 적립금/결혼여부 등을 확인하실 수 있습니다.<br />
사용중 불편하신 점 혹은 궁금하신 점 있으시면 언제든지 "<a href="<?php echo $grboard; ?>/board.php?id=<?php echo $config['bbs_qna']; ?>"><?php echo $config['btn_qna']; ?></a>" 에서 문의해 주세요!
</div>

<table rules="none" summary="GR Shop Mypage List" cellpadding="0" cellspacing="0" border="0" style="width: 100%; table-layout: fixed">
<caption></caption>
<thead>
<tr>
	<th style="width: 100px">항목</th>
	<th>기본정보</th>
</tr>
</thead>
<tbody>
<tr>
	<td class="opt">로그인 ID</td>
	<td class="var"><?php echo $myinfo['id']; ?></td>
</tr>
<tr>
	<td class="opt">성 함</td>
	<td class="var"><?php echo $myinfo['realname']; ?></td>
</tr>
<tr>
	<td class="opt">이메일</td>
	<td class="var"><?php echo $myinfo['email']; ?></td>
</tr>
<tr>
	<td class="opt">홈페이지</td>
	<td class="var"><?php echo ($myinfo['homepage']) ? $myinfo['homepage'] : '없음'; ?></td>
</tr>
<tr>
	<td class="opt" style="border-bottom: #ddd 1px solid">자기소개</td>
	<td class="var" style="border-bottom: #ddd 1px solid"><?php echo ($myinfo['self_info']) ? nl2br(stripslashes($myinfo['self_info'])) : '없음'; ?></td>
</tr>
</tbody>
</table>

<div class="space"></div>

<form id="purchase" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" onsubmit="return Mypage.checkAll(this);">
<div><input type="hidden" name="saveNow" value="1" /></div>
<table rules="none" summary="GR Shop Mypage List" cellpadding="0" cellspacing="0" border="0" style="width: 100%; table-layout: fixed">
<caption></caption>
<thead>
<tr>
	<th style="width: 100px">항목</th>
	<th>부가정보</th>
</tr>
</thead>
<tbody>
<tr>
	<td class="opt">적립금</td>
	<td class="var"><strong><?php echo number_format($addinfo['save_money']); ?></strong> 원</td>
</tr>
<tr>
	<td class="opt">우편번호</td>
	<td class="var"><input class="lock" type="text" name="mail_code" value="<?php echo $addinfo['mail_code']; ?>" readonly="readonly" onclick="Mypage.noInput();" /> <a href="../find.address.php" onclick="window.open(this.href, 'findAddress', 'width=600,height=550,menubar=no,scrollbars=yes'); return false" title="우편번호와 배송지(집주소)는 이 버튼을 클릭하여 찾아보세요!"><img src="<?php echo $mypage; ?>/find.mail.code.icon.gif" alt="" /> 우편번호/주소 찾기</a></td>
</tr>
<tr>
	<td class="opt">배송지 (주소)</td>
	<td class="var">
		<input class="lock" type="text" name="address1" value="<?php echo $addinfo['address1']; ?>" readonly="readonly" onclick="Mypage.noInput();" /> 
		<input type="text" name="address2" value="<?php echo $addinfo['address2']; ?>" onclick="Mypage.checkInput();" /> (← 나머지 주소 입력)</td>
</tr>
<tr>
	<td class="opt">연락처</td>
	<td class="var">
		집전화: <input type="text" name="home_phone" value="<?php echo $addinfo['home_phone']; ?>" /> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		휴대폰: <input type="text" name="mobile_phone" value="<?php echo $addinfo['mobile_phone']; ?>" /></td>
</tr>
<tr>
	<td class="opt">생일(양력기준)</td>
	<td class="var"><input type="text" name="birthday_year" value="<?php echo $addinfo['birthday_year']; ?>" style="width: 60px" />년 &nbsp;&nbsp;
	<input type="text" name="birthday_month" value="<?php echo $addinfo['birthday_month']; ?>" style="width: 30px" />월 &nbsp;&nbsp;
	<input type="text" name="birthday_day" value="<?php echo $addinfo['birthday_day']; ?>" style="width: 30px" />일</td>
</tr>
<tr>
	<td class="opt" style="border-bottom: #ddd 1px solid">결혼여부</td>
	<td class="var" style="border-bottom: #ddd 1px solid"><input type="radio" name="is_married" value="0"<?php echo (!$addinfo['is_married'])?' checked="checked"':''; ?> /> 미혼 &nbsp;&nbsp;
	<input type="radio" name="is_married" value="1"<?php echo ($addinfo['is_married'])?' checked="checked"':''; ?> /> 기혼</td>
</tr>
</tbody>
</table>

<div class="space"></div>

<div><input type="image" src="<?php echo $mypage; ?>/modify.info.ok.gif" alt="부가정보 수정하기" /></div>

</form>

</div>