<?

include "../odcommon/od_config.inc.php";
include "../odcommon/od_function.inc.php";
include "../odcommon/od_lib.inc.php";
include "./COkname.php";

@$encPsnlInfo = $_POST["encPsnlInfo"];	//아이핀팝업에서 조회한 PERSONALINFO이다.
@$WEBPUBKEY = trim($_POST["WEBPUBKEY"]);	//KCB서버 공개키
@$WEBSIGNATURE = trim($_POST["WEBSIGNATURE"]);	//KCB서버 서명값

$Ctest = new COkName($row_setup[nauthen_id]);
$out=$Ctest->Exec_IpinResult($encPsnlInfo,$WEBPUBKEY,$WEBSIGNATURE);

//echo "exe -> $Ctest->cmd3<br>";
/*
echo "encPsnlInfo=$encPsnlInfo<br>";
echo "WEBPUBKEY=$WEBPUBKEY<br>";
echo "WEBSIGNATURE=$WEBSIGNATURE<br>";
*/

// 결과라인에서 값을 추출
foreach($out as $a => $b) {
    if($a < 13) {
        $field[$a] = $b;
    }
}
/*
    $field_name_IPIN_DEC = array(
        "dupInfo        ",	// 0
        "coinfo1        ",	// 1
        "coinfo2        ",	// 2
        "ciupdate       ",	// 3
        "virtualNo      ",	// 4
        "cpCode         ",	// 5
        "realName       ",	// 6
        "cpRequestNumber",	// 7
        "age            ",	// 8
        "sex            ",	// 9
        "nationalInfo   ",	// 10
        "birthDate      ",	// 11
        "authInfo       ",	// 12
    );
    
echo "encPsnlInfo=$encPsnlInfo<br>";	
    // 추출된 값 프린트
foreach($field as $a => $b) {
    echo $field_name_IPIN_DEC[$a].": ".$field[$a]."<br>";
}*/


?>
<html>
<head>
<script language="JavaScript">
function fncOpenerSubmit() {
    //인증완료신호
    opener.document.confirmform.ipinuser.value = "1"; //실명
    opener.document.confirmform.name.value = document.dForm.realname.value; //실명
    opener.document.confirmform.resinum1.value = document.dForm.virtualno.value.substr(0,6);    //주민1
    opener.document.confirmform.resinum2.value = document.dForm.virtualno.value.substr(6,7);    //주민2

    opener.document.confirmform.name.readOnly = true;
    opener.document.confirmform.name.style.backgroundColor = "eeeeee";

    opener.document.confirmform.resinum1.readOnly = true;
    opener.document.confirmform.resinum1.style.backgroundColor = "eeeeee";

    opener.document.confirmform.resinum2.readOnly = true;
    opener.document.confirmform.resinum2.style.backgroundColor = "eeeeee";


    //kcb ipin 추가 데이터
    opener.document.confirmform.kcb_dupinfo.value = document.dForm.dupinfo.value;

    //sample data form
    opener.document.kcbOutForm.encPsnlInfo.value = document.dForm.encPsnlInfo.value;
    opener.document.kcbOutForm.dupinfo.value = document.dForm.dupinfo.value;
    opener.document.kcbOutForm.coinfo1.value = document.dForm.coinfo1.value;
    opener.document.kcbOutForm.coinfo2.value = document.dForm.coinfo2.value;
    opener.document.kcbOutForm.ciupdate.value = document.dForm.ciupdate.value;
    opener.document.kcbOutForm.virtualno.value = document.dForm.virtualno.value;
    opener.document.kcbOutForm.cpcode.value = document.dForm.cpcode.value;
    opener.document.kcbOutForm.realname.value = document.dForm.realname.value;
    opener.document.kcbOutForm.cprequestnumber.value=document.dForm.cprequestnumber.value;
    opener.document.kcbOutForm.age.value = document.dForm.age.value;
    opener.document.kcbOutForm.sex.value = document.dForm.sex.value;
    opener.document.kcbOutForm.nationalinfo.value = document.dForm.nationalinfo.value;
    opener.document.kcbOutForm.birthdate.value = document.dForm.birthdate.value;
    opener.document.kcbOutForm.authinfo.value = document.dForm.authinfo.value;

//    opener.document.kcbOutForm.action = "http://grptime.onedaynet.co.kr/kcb/ipin3.php";
//    opener.document.kcbOutForm.submit();
    self.close();
}
</script>
</head>
<body onLoad="javascript:fncOpenerSubmit();">
<form name="dForm" method="post">
    <input type="hidden" name="encPsnlInfo" 	value ="<?=$encPsnlInfo ?>" />
    <input type="hidden" name="dupinfo" 		value="<?=$field[0]?>" />
    <input type="hidden" name="coinfo1" 		value="<?=$field[1]?>" />
    <input type="hidden" name="coinfo2" 		value="<?=$field[2]?>" />
    <input type="hidden" name="ciupdate" 		value="<?=$field[3]?>" />
    <input type="hidden" name="virtualno"  	value="<?=$field[4]?>" />
    <input type="hidden" name="cpcode"        value="<?=$field[5]?>" />
    <input type="hidden" name="realname" 		value="<?=$field[6]?>" />
    <input type="hidden" name="cprequestnumber"	 value="<?=$field[7]?>" />
    <input type="hidden" name="age" 			value="<?=$field[8]?>" />
    <input type="hidden" name="sex" 			value="<?=$field[9]?>" />
    <input type="hidden" name="nationalinfo" 	value="<?=$field[10]?>" />
    <input type="hidden" name="birthdate" 	value="<?=$field[11]?>" />
    <input type="hidden" name="authinfo"      value="<?=$field[12]?>" />
</form>
</body>
</html>
