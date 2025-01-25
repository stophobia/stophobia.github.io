<?php if(!defined('__GRNOTE__')) exit(); ?>

<span class="b">티켓 발행권한 설정</span><br />
<br />
GR노트에서 "티켓" 이란 특정 프로젝트의 하나의 목표에 대한 세부적인 할 일을 말합니다.<br />
팀에서 팀장이 팀원들에게 특정 목표에 대한 세부적인 티켓을 발행할 수도 있고,<br />
공개 프로젝트의 경우 누구나 개발자들에게 차기버젼에 대한 티켓(할 일)을 보낼 수 있습니다.<br />
이런 티켓을 어떤 레벨 이상만 보낼 수 있도록 정할 것인지 선택해 주세요.<br />
(※ 비회원도 가능하게 하려면 1을 선택하시면 됩니다.)<br />
<br />
<form id="send" method="post" action="./?m=ticket&amp;key=<?php echo $_GET['key']; ?>">
<select name="sendLevel"><?php for($i=1; $i<100; $i++) { ?>
<option value="<?php echo $i; ?>"<?php echo (($grNote['ticket']['sendLevel']==$i)?' selected="selected"':''); ?>><?php echo $i; ?></option><?php } ?></select>
<input type="image" src="images/submit.wiki.write.level.gif" class="s" title="발행권한을 설정 합니다." />
</form>
<div class="dotLine"></div>
<span class="b">티켓 수정권한 설정</span><br />
<br />
한 번 발행된 티켓은 발행한 사용자나 특정 레벨 이상의 사용자가 수정할 수 있습니다.<br />
발행한 사용자 이외에도 수정할 수 있는 사용자층을 정하기 위해 수정권한을 설정해 주세요.<br />
(※ 발행자와 관리자 이외에 수정을 금지하고자 할 경우에는 기본값인 99를 설정하시면 됩니다.)<br />
<br />
<form id="modified" method="post" action="./?m=ticket&amp;key=<?php echo $_GET['key']; ?>">
<select name="modifiedLevel"><?php for($i=1; $i<100; $i++) { ?>
<option value="<?php echo $i; ?>"<?php echo (($grNote['ticket']['modifyLevel']==$i)?' selected="selected"':''); ?>><?php echo $i; ?></option><?php } ?></select>
<input type="image" src="images/submit.wiki.write.level.gif" class="s" title="수정권한을 설정 합니다." />
</form>
<div class="dotLine"></div>
<span class="b">티켓 삭제권한 설정</span><br />
<br />
티켓을 발행한 사용자가 티켓을 삭제할 수 있습니다.<br />
발행자 이외에도 티켓 삭제가 가능한 권한을 설정해 주세요.<br />
(※ 발행자와 관리자 이외에 삭제를 금지하고자 할 경우에는 기본값인 99를 설정하시면 됩니다.)<br />
<br />
<form id="remove" method="post" action="./?m=ticket&amp;key=<?php echo $_GET['key']; ?>">
<select name="removeLevel"><?php for($i=1; $i<100; $i++) { ?>
<option value="<?php echo $i; ?>"<?php echo (($grNote['ticket']['removeLevel']==$i)?' selected="selected"':''); ?>><?php echo $i; ?></option><?php } ?></select>
<input type="image" src="images/submit.wiki.write.level.gif" class="s" title="삭제권한을 설정 합니다." />
</form>
<div class="dotLine"></div>
<span class="b">티켓 볼 개수 지정</span><br />
<br />
한 번에 몇개씩 티켓을 볼 수 있도록 할 것인지 설정합니다.<br />
티켓은 변동사항에 대한 일종의 기록이므로 최근 것만 보고자 하시는 분들은 5~10 사이에서,<br />
많이 보고자 하시는 분들은 20~50 사이에서 설정하시면 좋습니다.<br />
<br />
<form id="modified" method="post" action="./?m=ticket&amp;key=<?php echo $_GET['key']; ?>">
<input type="text" name="viewNumTicket" value="<?php echo $grNote['ticket']['viewNumTicket']; ?>" />
<input type="image" src="images/submit.wiki.write.level.gif" class="s" title="볼 티켓수를 설정 합니다." />
</form>