<?php if(!defined('__GRNOTE__')) exit(); ?>

<span class="b">신규 프로젝트 생성/수정/삭제 권한 설정</span><br />
<br />
GR노트에서 프로젝트는 관리자나 권한 있는 사용자에 의해 신규로 생성될 수 있습니다.<br />
프로젝트를 생성하게되면 그와 함께 관련된 DB테이블이 새로 생성 됩니다.<br />
프로젝트는 GR노트에서 하나의 큰 단위이므로 생성권한과 수정, 삭제권한은 동일하게 취급됩니다.<br />
생성할 수 있는 권한을 지정해 주세요.<br />
(※ 대부분 관리자만 설정할 수 있도록 99레벨로 맞추어 두시는 것이 좋습니다.)<br />
<br />
<form id="projectPermission" method="post" action="./?m=goal&amp;key=<?php echo $_GET['key']; ?>">
<select name="projectLevel"><?php for($i=1; $i<100; $i++) { ?>
<option value="<?php echo $i; ?>"<?php echo (($grNote['project']['makeLevel']==$i)?' selected="selected"':''); ?>><?php echo $i; ?></option><?php } ?></select>
<input type="image" src="images/submit.wiki.write.level.gif" class="s" title="발행권한을 설정 합니다." />
</form>
<div class="dotLine"></div>
<span class="b">신규 목표 생성/수정/삭제 권한 설정</span><br />
<br />
"목표" 혹은 "버젼" 은 특정 프로젝트에 대한 일련의 굵직한 과업을 말합니다.<br />
소프트웨어의 경우 차기 버젼들에 대한 로드맵이 될 수도 있고,<br />
일반 프로젝트의 경우 분기별 과제들이 될 수도 있습니다.<br />
이런 "목표" 들마다 세부적으로 다시 티켓들이 엮이는 구조이므로 이런 목표를 관리하는 데에는<br />
높은 권한을 필요로 합니다. 관리자분의 판단하에, 어떤 레벨 이상 사용자에게 이 권한을 부여할 것인지<br />
확인 후 지정해 주세요.<br />
<br />
<form id="goalPermission" method="post" action="./?m=goal&amp;key=<?php echo $_GET['key']; ?>">
<select name="goalLevel"><?php for($i=1; $i<100; $i++) { ?>
<option value="<?php echo $i; ?>"<?php echo (($grNote['goal']['makeLevel']==$i)?' selected="selected"':''); ?>><?php echo $i; ?></option><?php } ?></select>
<input type="image" src="images/submit.wiki.write.level.gif" class="s" title="발행권한을 설정 합니다." />
</form>
<div class="dotLine"></div>