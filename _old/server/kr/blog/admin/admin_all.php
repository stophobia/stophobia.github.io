<?php if(!defined('__GRBLOG__')) exit(); ?>

<div class="normalTitle">전체 설정</div>

<!-- 전체 설정 -->
<div id="all">
	<form id="set" method="post" onsubmit="return setting(1);" action="<?php echo $_SERVER['PHP_SELF']; ?>" enctype="multipart/form-data">
	<div><input type="hidden" name="target" value="<?php echo $config['uid']; ?>" /></div>
	<div id="adminAll">
	<table rules="none" summary="GR Blog Setting" cellpadding="0" cellspacing="0" border="0">
	<caption></caption>
	<colgroup>
	<col style="width: 150px" />
	<col />
	</colgroup>
	<tbody>
	<tr>
		<td class="l">아이디</td>
		<td class="r"><input type="text" class="t" name="id" value="<?php echo $config['id']; ?>" readonly="readonly" title="아이디는 수정하실 수 없습니다" /></td>
	</tr>
	<tr>
		<td class="l">비밀번호</td>
		<td class="r"><input type="password" class="t" name="password" value="" /> (수정 시 덮어씌워집니다)</td>
	</tr>
	<tr>
		<td class="l">이름(닉네임)</td>
		<td class="r"><input type="text" class="t" name="name" value="<?php echo htmlspecialchars(stripslashes($config['name'])); ?>" /></td>
	</tr>
	<tr>
		<td class="l">홈페이지</td>
		<td class="r">
		<input type="text" class="t" name="homepage" value="<?php echo $config['homepage']; ?>" />
		</td>
	</tr>
	<tr>
		<td class="l">이메일</td>
		<td class="r"><input type="text" class="t" name="email" value="<?php echo $config['email']; ?>" /></td>
	</tr>
	<tr>
		<td class="l">스팸방지 키값</td>
		<td class="r"><input type="text" class="t" name="user_key" value="<?php echo $config['user_key']; ?>" /> 스팸 방지를 위해 사용되는 키 입니다. 아무거나 입력해 주세요.</td>
	</tr>
	<tr>
		<td class="l">블로그 이름</td>
		<td class="r"><input type="text" class="t" name="blog_name" value="<?php echo htmlspecialchars(stripslashes($config['blog_title'])); ?>" /></td>
	</tr>
	<tr>
		<td class="l">한줄 블로그 소개</td>
		<td class="r"><input type="text" class="t" name="blog_info" value="<?php echo htmlspecialchars(stripslashes($config['blog_info'])); ?>" /></td>
	</tr>
	<tr>
		<td class="l">블로그 테마(스킨)</td>
		<td class="r">
			<select name="theme">
			<?php
			$themeDir = @opendir('theme');
			while($theme = @readdir($themeDir)) { 
				if($theme == '.' or $theme == '..') continue; ?>
			<option value="<?php echo $theme; ?>" <?php echo (($config['theme'] == $theme)?'selected="selected"':''); ?>><?php echo $theme; ?></option>
			<?php } ?>
			</select>
		</td>
	</tr>
	<tr>
		<td class="l">한 페이지당 글 수</td>
		<td class="r"><input type="text" class="t" name="num_view_post" maxlength="3" value="<?php echo $config['num_view_post']; ?>" /></td>
	</tr>
	<tr>
		<td class="l">하단 페이지 출력 수</td>
		<td class="r"><input type="text" class="t" name="num_per_page" maxlength="3" value="<?php echo $config['num_per_page']; ?>" /></td>
	</tr>
	<tr>
		<td class="l">RSS 로 보일 글 수</td>
		<td class="r"><input type="text" class="t" name="num_rss_post" maxlength="3" value="<?php echo $config['num_rss_post']; ?>" /></td>
	</tr>
	<tr>
		<td class="l">RSS 의 글 당 글자수</td>
		<td class="r"><input type="text" class="t" name="num_rss_content" maxlength="5" value="<?php echo $config['num_rss_content']; ?>" /> '0' 일 경우 전체글을 보여줍니다.</td>
	</tr>
	<tr>
		<td class="l">트랙백(엮인글) 받기</td>
		<td class="r"><input type="checkbox" name="use_trackback" value="1" <?php if($config['use_trackback']) { ?>checked="checked"<?php } ?> /> 체크하시면 외부에서 온 트랙백(엮인글)을 받습니다.</td>
	</tr>
	<tr>
		<td class="l">코멘트(댓글) 받기</td>
		<td class="r"><input type="checkbox" name="use_comment" value="1" <?php if($config['use_comment']) { ?>checked="checked"<?php } ?> /> 체크하시면 방문객이 코멘트를 남길 수 있도록 합니다.</td>
	</tr>
	<tr>
		<td class="l">RSS 외부로 보내기</td>
		<td class="r"><input type="checkbox" name="use_rss" value="1" <?php if($config['use_rss']) { ?>checked="checked"<?php } ?> /> 체크하시면 외부로 RSS 피드를 발송해 줍니다.</td>
	</tr>
	<tr>
		<td class="l">오픈아이디 사용</td>
		<td class="r"><input type="checkbox" name="use_openid" value="1" <?php if($config['use_openid']) { ?>checked="checked"<?php } ?> /> 체크하시면 오픈아이디를 이용해 댓글을 남길 수 있도록 합니다.</td>
	</tr>
	<tr>
		<td class="l">HTML 캐쉬파일 사용</td>
		<td class="r"><input type="checkbox" name="use_cache" value="1" <?php if($config['use_cache']) { ?>checked="checked"<?php } ?> /> 체크하시면 한 번 이상 쓰이는 페이지를 별도로 HTML 캐쉬로 유지해 서버 부하를 줄입니다.</td>
	</tr>
	<tr>
		<td class="l">HTML 캐쉬 유지시간</td>
		<td class="r"><input type="text" class="t" name="cache_time" maxlength="3" value="<?php echo $config['cache_time']; ?>" /> HTML 캐쉬를 유지하는 시간을 지정합니다. (초단위, 600=10분)</td>
	</tr>
	<tr>
		<td class="l">HTML 캐쉬파일 삭제</td>
		<td class="r"><input type="checkbox" name="delete_cache" value="1" /> 체크하시면 현재까지 저장된 캐쉬파일들을 삭제하고, (필요시) 다시 자동 생성 합니다.</td>
	</tr>
	<tr>
		<td class="l">작성금지단어</td>
		<td class="r">
		<textarea name="filterText" rows="5"><?php @readfile('filter.txt'); ?></textarea>
		<div>※ 금지단어는 공백없이 (<strong>,</strong>) 콤마로 구분합니다.</div>
		<?php if(!is_writable('filter.txt')) { ?><span style="color: red">※ filter.txt 파일의 퍼미션(권한)을 707로 변경해 주세요!<?php } ?>
		</td>
	</tr>
	<tr>
		<td class="l">프로필 사진</td>
		<td class="r">
			<div><input type="file" name="file" class="t" /></div>
			<div><img src="image/my_photo.jpg" alt="image/my_photo.jpg" title="블로그에 보여질 사진 (테마에 따라 출력 안될 수 있음)" /></div>
			<?php if(!is_writable('image')) { ?><div style="color: red">※ image 폴더의 퍼미션(권한)을 707 로 맞추어 주세요!</div><?php } ?>
		</td>
	</tr>
	<tr>
		<td colspan="2" class="b">
			<input type="image" src="image/darkgray/button.confirm.gif" title="설정 수정하기" />
		</td>
	</tr>
	</tbody>
	</table>
	</div>
	</form>
</div>
<!--# 전체 설정 -->