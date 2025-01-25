<?
    include '../odcommon/od_config.inc.php';
    include '../odcommon/od_function.inc.php';
    include '../odcommon/od_lib.inc.php';
    include '../odcommon/od_head.inc.php';
    include '../odcommon/od_body.inc.php';
    include './COkname.php';

    ##아이핀사용을 위한 인증키 조회
    $sSiteID = $row_setup[nauthen_id2];  	// 사이트 id(KCB)
    $KCB = new COkName($sSiteID);
    $KCB->Exec_Ipin();    //아이핀사인키실행
    $KCB->Set_RetURL("http://".$_SERVER[HTTP_HOST]."/odprogram/odmembers/kcb_IpinResult.php");   //return Page
    $KCB->Make_Inform();  //아이핀 인증데이터 폼(ReturnURL 이 설정된 후에 실행해야함)
    $KCB->Make_RunScript();  //아이인 실행 스크립트생성

    ###########################################
?>

<script>
    function changeUsertype(val)
    {
        if (val=='2')   //외국인등록번호 이미지표시
        {
            document.getElementById('auhtimg').src = '/images/login_11.jpg'
        } else {        //주민등록번호 이미지표시
            document.getElementById('auhtimg').src = '/images/login_05.jpg'
        }
    }
    function changeAuthtype(val)
    {
        if (val=='I')   //아이핀
        {            //IPIN을 표시하고 주민등록번호는 비표시
            document.getElementById('ipin').style.display='';
            document.getElementById('jumin').style.display='none';
        } else {        //주민등록번호
            document.getElementById('jumin').style.display='';
            document.getElementById('ipin').style.display='none';
        }
    }
    function openIntro() {  //소개페이지
        window.open('./kcb_IpinIntro.php','ipinintro','menubar=no,toolbar=no,location=no,status=no,left=50px,top=50px,width=640px,height=500px,scrollbars=yes')
    }
    function validate() {   //
        frm = document.snsForm;

        if(!frm.realname.value) {
            alert('실명을 입력해주세요.');
            frm.realname.focus();
            return false;
        }
        if(!frm.resinum1.value) {
            alert('주민번호를 입력해주세요.');
            frm.resinum1.focus();
            return false;
        }
        if(!frm.resinum2.value) {
            alert('주민번호를 입력해주세요.');
            frm.resinum2.focus();
            return false;
        }

        frm.action = "/odprogram/odmembers/kcb_realCheck.php";
        frm.target = "hidden_frame";
        frm.submit();

        return false;
    }
</script>

<!-- top 시작 -->
<? include $_SERVER[DOCUMENT_ROOT].'/pages/subHead.html'; ?>
<!-- top 끝 -->
<!-- main start -->
<iframe name="hidden_frame" src="about:blank" width=500px height=500px style="display:none"></iframe>
<form name="snsForm" method="post" action ="od_join.php">
<input type="hidden" name="realCheck" value="">
<table width='730' border='0' cellspacing='0' cellpadding='0' align='center'>
    <tr>
        <td><img src='/images/login_10.jpg' width='168' height='56' /></td>
    </tr>
    <tr>
        <td><img src='/images/login_01.jpg' width='730' height='4' /></td>
    </tr>
    <tr>
        <td align='center' style='padding:40 0 40 0'>
            <table border='0' cellspacing='0' cellpadding='0'>
                <tr>
                    <td><img src='/images/login_02.jpg' width='79' height='97' /></td>
                    <td width='80'></td>
                    <td><img src='/images/login_03.jpg' width='79' height='97' /></td>
                </tr>
                <tr>
                    <td align='center'>
                        <input name='usertype' onClick='changeUsertype(this.value)' type='radio' value='1' checked>
                    </td>
                    <td width='80'></td>
                    <td align='center'>
                        <input name='usertype' onClick='changeUsertype(this.value)' type='radio' value='2'>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td height='1' bgcolor='#cccccc'></td>
    </tr>
    <tr>
        <td style='padding: 20 0 20 10'><img src='/images/login_04.jpg' width='446' height='32' /></td>
    </tr>
    <tr>
        <td height='1' bgcolor='#cccccc'></td>
    </tr>
    <!-- 주민등록번호로 확인하기-->
    <tr>
    	<td style='padding:40 0 10 70'><input onClick='changeAuthtype(this.value)' name='#' type='radio' value='J' checked><img name='auhtimg' src='/images/login_05.jpg' align='absmiddle' />&nbsp;
<?
if ($row_setup[ipin_use]=="yes")    //아이핀사용시에는 아이핀인증화면 표시
{
    echo "<input onClick='changeAuthtype(this.value)' name='#' type='radio' value='I'><img src='/images/login_06.jpg' width='89' height='18' align='absmiddle' /><a href='#none' onClick='openIntro()'><img src='/images/login_07.jpg' width='80' height='21' border='0' align='absmiddle' /></a>";
}
?>
</td>
    </tr>
    <tr id='jumin' style='display:'>
        <td align='center'>
            <table style='border:1px solid #cccccc; width:80%; padding:40 20 40 20; background-color:#fafafa' cellspacing='0' cellpadding='0'>
                <tr>
                    <td align='center'><img src='/images/login_08.jpg' width='22' height='12'/>&nbsp;&nbsp;<input class='gray_3' name='realname' type='text' value='' style='height:20; width:120' />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<img src='/images/login_09.jpg' width='62' height='12'/>&nbsp;&nbsp;<input class='gray_3' onkeyup="if(this.value.length==6) {this.form.resinum2.focus();}" maxlength="6" size="24" name='resinum1' type='text' value='' style='height:20; width:60' /> - <input class='gray_3' maxlength="7" size="24" name='resinum2' type='password' value='' style='height:20; width:60' />
                    &nbsp;&nbsp;<a href="#none" onClick="validate()"><img src='/images/bt_ipin.jpg' width='79' height='22' border='0' align='absmiddle'/></a></td>
                </tr>
            </table>
        </td>
    </tr>
    <tr id='ipin' style='display:none'>
        <td align='center'>
            <table style='border:1px solid #cccccc; width:80%; padding:40 20 40 20; background-color:#fafafa' cellspacing='0' cellpadding='0'>
                <tr>
                    <td align='center'>아이핀 인증을 통한 회원가입을 원하시면 아래의 인증 버튼을 눌러 가입하실 수 있습니다.<p><a href="#none"onclick="certKCBIpin('0');"><img src='/images/bt_ipin.jpg' width='79' height='22' border='0'/></a></td>
                </tr>
            </table>
        </td>
    </tr>
<!--
    <tr>
    	<td style='padding:10 0 20 0' align='center'><a href='#'>[다음으로]</a></td>
    </tr>
-->
    <!-- 주민등록번호로 확인하기 끝-->
</table><p>&nbsp;
</form>
<!-- main end -->
<!-- bottom 시작 -->
<? include_once $_SERVER[DOCUMENT_ROOT].'/pages/subFoot.html'; ?>
<!-- bottom 끝 -->