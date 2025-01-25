<?php if(!defined('__GRNOTE__')) exit(); ?>

<span class="b">문서 수정시 원본보존</span><br />
<br />
GR노트에서 위키문서는 기본적으로 수정시 원본을 보존하도록 되어 있습니다.<br />
하지만 예를 들어, 한 문서를 100번 수정하게 되면 100번 모두 DB에 공간을 차지하게 되어<br />
장기적으로 보았을 때 DB서버에 무리가 가게 됩니다. (즉 100개의 문서가 만들어집니다.)<br />
따라서 관리자가 판단하여 문서 수정시 원본을 보존할 필요가 없다고 판단되면 이 원본보존을<br />
사용하지 않을 수도 있습니다. 보존할 시와 안할 시의 장단점을 비교하신 후 선택해 주세요.<br />
<br />
<form id="original" method="post" action="./?m=wiki">
<input type="radio" name="saveOriginal" id="save" value="1"<?php echo (($grNote['wiki']['saveOriginal']==1)?' checked="checked"':''); ?> /> <label for="save">원본을 보존합니다.</label> &nbsp;&nbsp;&nbsp;&nbsp;
<input type="radio" name="saveOriginal" id="none" value="2"<?php echo (($grNote['wiki']['saveOriginal']==2)?' checked="checked"':''); ?> /> <label for="none">원본을 보존하지 않습니다.</label> &nbsp;&nbsp;&nbsp;&nbsp;
<input type="image" src="images/submit.save.original.gif" class="s" title="원본 보존여부를 저장 합니다." />
</form>
<div class="dotLine"></div>
<span class="b">위키 작성권한 설정</span><br />
<br />
GR노트에서의 위키는 프로젝트와 관련된 문서들을 작성하는 곳입니다.<br />
문서들 간에 서로 연결할 수 있는 내부링크 <a href="#">[[링크이름]]</a> 를 제공하며,<br />
이 위키에 문서를 작성할 수 있는 권한(제한레벨)을 지정하실 수 있습니다.<br />
선택하신 레벨부터 99 레벨까지의 멤버들이 위키 작성권한이 있습니다.<br />
레벨을 선택하신 후 "제한 설정" 을 누르시면 설정 됩니다.<br />
(기본 제한레벨은 2이며, 이는 멤버 등록후 자동으로 부여되는 레벨 입니다. 비회원은 기본 1입니다.)<br />
<br />
<form id="write" method="post" action="./?m=wiki">
<select name="writeLevel"><?php for($i=1; $i<100; $i++) { ?>
<option value="<?php echo $i; ?>"<?php echo (($grNote['wiki']['writeLevel']==$i)?' selected="selected"':''); ?>><?php echo $i; ?></option><?php } ?></select>
<input type="image" src="images/submit.wiki.write.level.gif" class="s" title="작성권한을 설정 합니다." />
</form>
<div class="dotLine"></div>
<span class="b">위키 수정권한 설정</span><br />
<br />
GR노트에서 위키에 작성된 문서를 수정하게 되면 상단의 "원본 보존" 기능을<br />
사용하지 않으실 경우 원본이 보존되지 않습니다. 따라서 대게의 경우 수정권한은 작성권한보다<br />
더 높게 하시는 것을 권장합니다. (※ 단, 작성자 자신은 제한에 상관 없이 수정이 가능 합니다.)<br />
<br />
<form id="modify" method="post" action="./?m=wiki">
<select name="modifyLevel"><?php for($i=1; $i<100; $i++) { ?>
<option value="<?php echo $i; ?>"<?php echo (($grNote['wiki']['modifyLevel']==$i)?' selected="selected"':''); ?>><?php echo $i; ?></option><?php } ?></select>
<input type="image" src="images/submit.wiki.write.level.gif" class="s" title="수정권한을 설정 합니다." />
</form>
<div class="dotLine"></div>
<span class="b">위키 읽기권한 설정</span><br />
<br />
GR노트 첫화면에는 위키가 선택되어 출력이 됩니다. (위키 첫페이지가 나타납니다.)<br />
노트를 사용하는 곳에 따라서 위키 문서를 누구나 보게 할 것인지, 아니면 등록된 멤버만 보게 할 것인지,<br />
아니면 특정 레벨 이상 사용자만 보게 할 것인지 선택하실 수 있습니다.<br />
1을 선택하시면 누구나, 2부터는 멤버 이상만 위키 문서를 볼 수 있습니다.<br />
<br />
<form id="read" method="post" action="./?m=wiki">
<select name="readLevel"><?php for($i=1; $i<100; $i++) { ?>
<option value="<?php echo $i; ?>"<?php echo (($grNote['wiki']['readLevel']==$i)?' selected="selected"':''); ?>><?php echo $i; ?></option><?php } ?></select>
<input type="image" src="images/submit.wiki.write.level.gif" class="s" title="수정권한을 설정 합니다." />
</form>
<div class="dotLine"></div>
<span class="b">위키 삭제권한 설정</span><br />
<br />
위키에 등록된 문서를 삭제하게 될 경우, 보존중인 원본들도 함께 삭제가 됩니다.<br />
즉, 현재 삭제할 문서의 이전 버젼들도 함께 삭제가 됩니다.<br />
문서 삭제권한은 그 어떤 권한보다도 높게 설정해 두시는 것이 좋습니다.<br />
<br />
<form id="delete" method="post" action="./?m=wiki">
<select name="deleteLevel"><?php for($i=1; $i<100; $i++) { ?>
<option value="<?php echo $i; ?>"<?php echo (($grNote['wiki']['deleteLevel']==$i)?' selected="selected"':''); ?>><?php echo $i; ?></option><?php } ?></select>
<input type="image" src="images/submit.wiki.write.level.gif" class="s" title="삭제권한을 설정 합니다." />
</form>
<div class="dotLine"></div>
<span class="b">위키 파일첨부 권한 설정</span><br />
<br />
위키에 문서를 등록할 때 파일을 첨부할 수 있는 권한을 설정합니다.<br />
파일은 HTML 관련 파일들을 제외한 대부분의 파일들(보안상 불허되는 파일들 제외, 예: .php 등)이<br />
업로드 가능합니다. 1을 선택하시면 누구나, 2부터는 멤버 이상만 위키 문서에 파일을 첨부할 수 있습니다.<br />
<br />
<form id="upload" method="post" action="./?m=wiki">
<select name="uploadLevel"><?php for($i=1; $i<100; $i++) { ?>
<option value="<?php echo $i; ?>"<?php echo (($grNote['wiki']['uploadLevel']==$i)?' selected="selected"':''); ?>><?php echo $i; ?></option><?php } ?></select>
<input type="image" src="images/submit.wiki.write.level.gif" class="s" title="첨부권한을 설정 합니다." />
</form>
<div class="dotLine"></div>
<span class="b">위키 페이지 캐쉬 생성 시간</span><br />
<br />
위키에 저장된 문서는 매번 불러질 때마다 서버에서 문자열을 처리하는 등의<br />
작업을 거쳐서 출력이 되게 됩니다. 이에 GR위키는 해당 페이지를 .html 파일로<br />
서버의 cache/ 디렉토리에 저장하여 일정 기간동안 문서가 갱신이 되어도 무조건<br />
만들어둔 캐쉬파일(임시파일)을 불러서 대신 출력합니다.<br />
문서를 새로 갱신할 주기를 초단위로 아래 적어주시면 되겠습니다.<br />
(기본값 600은 60초 x 10 으로 10분을 의미 합니다. 즉, 10분마다 한번씩 해당 문서가 갱신됩니다.)<br />
<br />
<form id="cache" method="post" action="./?m=wiki">
<input type="text" name="cacheTerm" value="<?php echo $grNote['wiki']['cacheTerm']; ?>" />
<input type="image" src="images/submit.wiki.write.level.gif" class="s" title="캐쉬 생성시간을 설정 합니다." />
</form>