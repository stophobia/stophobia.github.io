<?php 
if(!defined('__GRBLOG__')) exit();
include 'theme_config.php'; 
?>
<!-- 테마 설정 -->
<div id="all">
	<div class="normalTitle">테마/세부 설정</div>

	<form id="themeSetup" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>?admin=12">
	<div><input type="hidden" name="submitOK" value="1" /></div>
	<div id="adminAll">
	<table rules="none" summary="GR Blog Theme Setup" cellpadding="0" cellspacing="0" border="0">
	<caption></caption>
	<colgroup>
	<col style="width: 150px" />
	<col />
	</colgroup>
	<tbody>
	<tr>
		<td class="l">사진 보이기</td>
		<td class="r"><input type="checkbox" id="conf_photo" name="conf_photo" value="1" <?php echo (($conf_photo)?'checked="checked"':''); ?> /> <label for="conf_photo" title="자신의 사진 혹은 블로그 대표 이미지를 보여줍니다. 스킨에 따라서, 아예 지원하지 않을 수도 있습니다.">블로그 사이드/하단에 자신의 사진(혹은 그림)을 보여줍니다.</label></td>
	</tr>
	<tr>
		<td class="l">달력 보이기</td>
		<td class="r"><input type="checkbox" id="conf_calendar" name="conf_calendar" value="1" <?php echo (($conf_calendar)?'checked="checked"':''); ?> /> <label for="conf_calendar" title="달력을 표시합니다. 포스트가 있는 날짜에는 별도 표시가 됩니다.">블로그 사이드/하단에 달력을 보여줍니다.</label></td>
	</tr>
	<tr>
		<td class="l">공지 보이기</td>
		<td class="r"><input type="checkbox" id="conf_notice" name="conf_notice" value="1" <?php echo (($conf_notice)?'checked="checked"':''); ?> /> <label for="conf_notice" title="이 블로그의 알림사항을 보여줍니다.">블로그 사이드/하단에 공지사항(notice)을 보여줍니다.</label></td>
	</tr>
	<tr>
		<td class="l">분류 보이기</td>
		<td class="r"><input type="checkbox" id="conf_category" name="conf_category" value="1" <?php echo (($conf_category)?'checked="checked"':''); ?> /> <label for="conf_category" title="분류를 보여줍니다.">블로그 사이드/하단에 분류(category)를 보여줍니다.</label></td>
	</tr>
	<tr>
		<td class="l">포토로그 보이기</td>
		<td class="r"><input type="checkbox" id="conf_photolog" name="conf_photolog" value="1" <?php echo (($conf_photolog)?'checked="checked"':''); ?> /> <label for="conf_photolog" title="GR블로그에 내장된 앨범, 포토로그의 최근 사진을 보여줍니다.">블로그 사이드/하단에 포토로그(photolog)를 보여줍니다.</label></td>
	</tr>
	<tr>
		<td class="l">최근글 보이기</td>
		<td class="r"><input type="checkbox" id="conf_article" name="conf_article" value="1" <?php echo (($conf_article)?'checked="checked"':''); ?> /> <label for="conf_article" title="최근에 작성한 포스트들의 목록을 보여줍니다. 작성중인 글(비밀글)은 표시되지 않습니다.">블로그 사이드/하단에 최근 글(posts)을 보여줍니다.</label></td>
	</tr>
	<tr>
		<td class="l">최근댓글 보이기</td>
		<td class="r"><input type="checkbox" id="conf_comment" name="conf_comment" value="1" <?php echo (($conf_comment)?'checked="checked"':''); ?> /> <label for="conf_comment" title="최근에 받은 댓글들을 보여줍니다. 비밀댓글은 표시되지 않습니다.">블로그 사이드/하단에 최근 댓글(comments)을 보여줍니다.</label></td>
	</tr>
	<tr>
		<td class="l">최근트랙백 보이기</td>
		<td class="r"><input type="checkbox" id="conf_trackback" name="conf_trackback" value="1" <?php echo (($conf_trackback)?'checked="checked"':''); ?> /> <label for="conf_trackback" title="최근 받았던 트랙백(엮인글)들을 보여줍니다.">블로그 사이드/하단에 최근 트랙백(trackback)을 보여줍니다.</label></td>
	</tr>
	<tr>
		<td class="l">태그 보이기</td>
		<td class="r"><input type="checkbox" id="conf_tag" name="conf_tag" value="1" <?php echo (($conf_tag)?'checked="checked"':''); ?> /> <label for="conf_tag" title="자주 사용하는 태그(꼬리표)들을 보여줍니다.">블로그 사이드/하단에 태그(tag)를 보여줍니다.</label></td>
	</tr>
	<tr>
		<td class="l">링크 보이기</td>
		<td class="r"><input type="checkbox" id="conf_link" name="conf_link" value="1" <?php echo (($conf_link)?'checked="checked"':''); ?> /> <label for="conf_link" title="자주 가는 블로그/웹사이트를 보여줍니다.">블로그 사이드/하단에 링크(link)를 보여줍니다.</label></td>
	</tr>
	<tr>
		<td class="l">검색 보이기</td>
		<td class="r"><input type="checkbox" id="conf_search" name="conf_search" value="1" <?php echo (($conf_search)?'checked="checked"':''); ?> /> <label for="conf_search" title="스킨 디자인에 의해 아예 검색이 지원되지 않을 수도 있습니다.">블로그 사이드/하단에 검색폼을 보여줍니다.</label></td>
	</tr>
	<tr>
		<td class="l">모노로그 최근글 보이기</td>
		<td class="r"><input type="checkbox" id="conf_monolog" name="conf_monolog" value="1" <?php echo (($conf_monolog)?'checked="checked"':''); ?> /> <label for="conf_monolog" title="GR블로그에 내장된 미니메모장, 모노로그의 최근글을 보여줍니다.">블로그 사이드/하단에 모노로그 최근글을 보여줍니다.</label></td>
	</tr>
	<tr>
		<td class="l">현재접속자수 보이기</td>
		<td class="r"><input type="checkbox" id="conf_nowConnect" name="conf_nowConnect" value="1" <?php echo (($conf_nowConnect)?'checked="checked"':''); ?> /> <label for="conf_nowConnect" title="현재접속자수는 광고봇/검색봇 같은 기계적인 접속도 반영합니다.">블로그 사이드/하단에 현재접속자수를 보여줍니다.</label></td>
	</tr>
	<tr>
		<td class="l">자동등록방지 사용하기</td>
		<td class="r"><input type="checkbox" id="conf_antiSpam" name="conf_antiSpam" value="1" <?php echo (($conf_antiSpam)?'checked="checked"':''); ?> /> <label for="conf_antiSpam" title="이 기능이 비활성화되면, 무작위 스팸 댓글에 GR블로그가 그대로 노출됩니다.">블로그에 댓글을 달 때 8자리 랜덤코드를 받도록 합니다.</label></td>
	</tr>
	<tr>
		<td class="l">한글 없을시 스팸간주</td>
		<td class="r"><input type="checkbox" id="conf_koreanOnly" name="conf_koreanOnly" value="1" <?php echo (($conf_koreanOnly)?'checked="checked"':''); ?> /> <label for="conf_koreanOnly" title="방명록이나 포스트의 댓글에 한글이 포함되어 있지 않으면 스팸으로 간주하여 받지 않습니다. (트랙백 제외)">댓글/답글에 한글이 포함되어 있지 않으면 스팸으로 간주합니다.</label></td>
	</tr>
	<tr>
		<td class="l">방명록 보이기</td>
		<td class="r"><input type="checkbox" id="conf_guestbook" name="conf_guestbook" value="1" <?php echo (($conf_guestbook)?'checked="checked"':''); ?> /> <label for="conf_guestbook" title="v1.1.4 [황조롱이] 이상 버젼을 지원하는 스킨에서 사용가능합니다. 비밀글은 표시되지 않습니다.">방명록에 달린 최근 글들을 보여줍니다.</label></td>
	</tr>
	<tr>
		<td class="l">글 자동저장 간격</td>
		<td class="r"><input type="text" name="conf_autosave_term" value="<?php echo $conf_autosave_term; ?>" class="input" title="숫자만 입력하세요. (단위: 초)" /> 본문 작성시 몇 초 간격으로 자동 저장할 것인지 정합니다. (기본: 60초)</td>
	</tr>
	<tr>
		<td class="l">포스트 미리보기</td>
		<td class="r"><input type="checkbox" id="conf_preview" name="conf_preview" value="1" <?php echo (($conf_preview)?'checked="checked"':''); ?> /> <label title="적당한 길이(300자 정도)로 두시면 보기 좋습니다.">목록에서 포스트를 <input type="text" name="conf_preview_count" value="<?php echo ($conf_preview_count)?$conf_preview_count:300; ?>" maxlength="3" class="input" />글자만 보여주고, 제목(혹은 버튼) 클릭시 본문 전체를 보여줍니다.</label></td>
	</tr>
	<tr>
		<td class="l">미리보기시 썸네일출력</td>
		<td class="r"><input type="checkbox" id="conf_preview_thumbnail" name="conf_preview_thumbnail" value="1" <?php echo (($conf_preview_thumbnail)?'checked="checked"':''); ?> /> <label title="이 기능은 서버에 부담을 줄 수 있습니다. HTML 캐쉬 기능을 사용하시는 걸 추천합니다.">포스트 미리보기 사용시 웹진형 목록처럼 (본문에 그림이 있을 시) 썸네일로 그림을 보여줍니다.</label></td>
	</tr>
	<tr>
		<td class="l"><strong title="시리니넷에서 공개되고 있는 GR카운터를 사용하시는 경우, GR블로그와 쉽게 연동하실 수 있습니다.">GR Counter 연동</strong></td>
		<td class="r"><input type="checkbox" id="conf_grcounter" name="conf_grcounter" value="1" <?php echo (($conf_grcounter)?'checked="checked"':''); ?> /> <span title="이 기능을 사용하기 위해서는 서버에 GR카운터가 이미 설치되어 있어야 합니다."><input type="text" title="GR카운터가 설치된 상대경로를 적습니다. $grcount 변수에 사용됩니다." name="conf_grcounter_path" value="<?php echo (($conf_grcounter_path)?$conf_grcounter_path:'../grcounter/'); ?>" class="input" style="width: 100px" /> 위치에 설치되 있고, ID가 <input type="text" title="GR카운터에서 생성된 ID 를 적습니다. $grid 변수에 사용됩니다." name="conf_grcounter_id" value="<?php echo (($conf_grcounter_id)?$conf_grcounter_id:'blog'); ?>" class="input" /> 인 GR카운터 통계 데이터와 연동합니다.</span></td>
	</tr>
	<tr>
		<td class="l"><strong title="트위터에 업데이트된 나의 글들을 GR Blog 와 연동하여 (테마에 따라서) 사이드바 등의 위치에 보여줍니다.">Twitter 연동</strong></td>
		<td class="r"><input type="text" title="트위터 아이디를 입력해 주세요." name="conf_twitter_id" value="<?php echo $conf_twitter_id; ?>" class="input" style="width: 80px" /> 아이디의 Twitter 글을 <input type="text" title="트위터에 작성한 최근글을 몇 개씩 가져올지 설정합니다." name="conf_twitter_count" value="<?php echo $conf_twitter_count; ?>" class="input" style="width: 30px" /> 개씩 <input type="text" title="자신의 트위터의 RSS 주소를 입력해주세요. (예: http://twitter.com/statuses/user_timeline/54779490.rss)" name="conf_twitter_rss" value="<?php echo $conf_twitter_rss; ?>" class="input" style="width: 200px" /> 에서 가져옵니다.</td>
	</tr>
	<tr>
		<td colspan="2" class="b">
		<?php if(!is_writable('theme_config.php')) {
			echo '<span style="color: red" title="FTP 프로그램을 통해 접근하여, 권한 설정 메뉴를 통해 쉽게 조정이 가능합니다.">'.
				'※ theme_config.php 파일의 퍼미션(접근 권한)이 707 이 아닙니다. 707로 변경해 주세요!</span><br /><br />';
		} ?>
			<input type="image" src="image/darkgray/button.check.gif" title="테마 설정을 완료하기" />
		</td>
	</tr>
	</tbody>
	</table>
	</div>
	</form>
</div>
<!--# 링크 설정 -->