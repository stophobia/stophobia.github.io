<?php if(!defined('__GRNOTE__')) exit(); ?>

<span class="b">GR노트 삭제</span><br />
<br />
GR노트를 삭제하시겠습니까?<br />
삭제하시기 전에 DB백업이 필요하시다면 미리 백업을 먼저 받아두시길 바랍니다.<br />
프로젝트 일정/목표 관리 도구인 GR노트를 그 동안 사용해 주셔서 감사드립니다.<br />
보다 나은 프로그램 개발을 위해 앞으로도 최선을 다 하도록 하겠습니다.<br />
<br />
<a href="#" onclick="Admin.uninstall('<?php echo $_GET['key']; ?>');">{예, GR노트를 삭제하겠습니다}</a>