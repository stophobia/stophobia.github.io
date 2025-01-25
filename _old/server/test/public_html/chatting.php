<?
include dirname(__FILE__)."/odprogram/odcommon/od_db_conf.php";

include "./icon.php";

$nickName = "홍길동";
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>채팅</title>
<script>
// trim 선언
String.prototype.trim = function() { return this.replace(/(^\s+)|(\s+$)/g, ''); } 

// request 객체 생성
var req = null;
function create_request() {
    var request = null;
    try {
        request = new XMLHttpRequest();
    } catch (trymicrosoft) {
        try {
            request = new ActiveXObject("Msxml12.XMLHTTP");
        } catch (othermicrosoft) {
            try {
                request = new ActiveXObject("Microsoft.XMLHTTP");
            } catch (failed) {
                request = null;
            }
        }
    }
    if (request == null)
        alert("Error creating request object!");
    else
        return request;
}


function chatKeyCheck(obj) {
	frm = document.form;
	chatDisplay = document.getElementById('chat');
	if(event.keyCode == 13) {

		// 빈값일때 리턴
		if(!obj.value.trim()) {
			obj.value='';
			event.returnValue = false; 
			return false;
		}

		// 백그라운드로 DB에 입력.
		param = "id=guest&name="+frm.nickName.value+"&content="+frm.chatmsg.value+"&color="+frm.color.value+"&font="+encodeURIComponent(frm.font.value);
		req = create_request();
		req.open("POST", "./chatPro.php", true);
		req.setRequestHeader("Content-Type", "application/x-www-form-urlencoded;charset=UTF-8");
		req.setRequestHeader("Cache-Control","no-cache, must-revalidate");
		req.setRequestHeader("Pragma","no-cache");
		req.send(param);


		// 채팅내용
		chatText = obj.value.trim();

		// 아이콘 치환
		<?
		unset($javaIcon);
		$iconKey = array_keys($iconArray);
		for($i=0;$i<count($iconKey);$i++) {
		?>
		chatText = chatText.replace(/\/<?=$iconKey[$i]?>\//g,'<img src=./icon/<?=$iconArray[$iconKey[$i]]?>.gif>');
		<?
		}
		?>

		// 채팅창에 내용 뿌리기.
		chatDisplay.innerHTML += "<span style='font-weight:bold;color:"+frm.color.value+";font-family:"+frm.font.value+"'>["+frm.nickName.value+"] 님의 말</span><br>"
		chatDisplay.innerHTML += "<span style='font-family:"+frm.font.value+"'>"+chatText+"</span><br />";
		chatDisplay.scrollTop	 = chatDisplay.scrollHeight;	
		event.returnValue = false; 
		obj.value='';
		return false;
	}

}

function chatUpdate() {
	frm = document.form;

	// 백그라운드로 DB 추출.
	param = "now="+frm.now.value+"&name="+frm.nickName.value;
	req = create_request();
	req.open("POST", "./chatUpdate.php", true);
	req.setRequestHeader("Content-Type", "application/x-www-form-urlencoded;charset=UTF-8");
	req.setRequestHeader("Cache-Control","no-cache, must-revalidate");
	req.setRequestHeader("Pragma","no-cache");
	req.send(param);
	req.onreadystatechange = function () {
		printHTML();
	}

	setTimeout("chatUpdate()",1000);
}

function printHTML() {
	if (req.readyState == 4) {
		if(req.status == 200) {
			// 값이 있을때만 처리
			if(req.responseText.trim()) {
				resultText = req.responseText;
				resultTextArray = resultText.split(':::::');
				document.getElementById('chat').innerHTML += resultTextArray[0];
				document.getElementById('chat').scrollTop	 = document.getElementById('chat').scrollHeight;	
				document.form.now.value = resultTextArray[1];
			}
		}
	}
}

function printIcon(icon) {
	frm = document.form;
	frm.chatmsg.value += "/"+icon+"/";
	frm.chatmsg.focus();
	return;
}

function nickNameChangeFun(obj) {
	frm = document.form;
	if(event.keyCode == 13) {
		// 빈값일때 리턴
		if(obj.value.trim()) {
			frm.nickName.value = obj.value;
			layerView('layerNick');
			return false;
		} else {
			alert('닉네임을 입력하세요');
		}
	}
}
function layerView(name) {
	obj = document.getElementById(name);

	if(obj.style.visibility == "") {
		obj.style.visibility = "hidden";
	} else {
		obj.style.visibility = "";
	}
}

function colorChangeFun(color) {
	frm = document.form;
	frm.color.value = color;
	layerView('layerPalette')
}

function fontChangeFun(font) {
	frm = document.form;
	frm.font.value = font;
	layerView('layerFont');
}
function setColor(trName, color) {
        tdCnt = trName.getElementsByTagName('td').length;
        for(var i=0;i<tdCnt;i++) {
                trName.getElementsByTagName('td')[i].style.backgroundColor=color;
        }
}
</script>
</head>
<body>
<style>
.chatStyle {
	width:500px;
	height:300px;
	border:1px solid #aaaaaa;
	font-family:돋움;
	font-size:12px;
  overflow: scroll; 
	overflow-x:hidden;
}
.chatBox {
	width:500px;
	height:40px;
	font-family:돋움;
	font-size:12px;
}
td {
	font-size:12px;
	font-family:돋움;
	line-height:180%;
}
</style>
<body onload="document.form.chatmsg.focus();">
<form name="form" action="" method=post>
<!-- 닉네임 변경 -->
<a href="#none" onclick="layerView('layerNick')">닉네임변경</a>
<div id='layerNick' style="position:relative;left:0px;top:0px;visibility:hidden" onmouseout="layerView('layerNick')">
	<div  style='position:absolute; left:180; top:70; visibility:; z-index:3;'>	
		<table width=100 height=30 border=0 cellpadding=0 cellspacing=0>
			<tr>
				<td><input type="text" size=10 name="nickNameChange" onkeydown="nickNameChangeFun(this)" value="<?=$nickName?>"></td>
			</tr>
		</table>
	</div>
</div>


<!-- 글씨 색깔 -->
<a href="#none" onclick="layerView('layerPalette')">색깔변경</a>
<div id='layerPalette' style="position:relative;left:0px;top:0px;visibility:hidden">
	<div  style='position:absolute; left:180; top:70; visibility:; z-index:3;' >	
		<img src="images/palette.gif" usemap="#palette" border=0   >
		<map name="palette" id="palette">
			<area shape="rect" coords="5,5,17,17" href="javascript:colorChangeFun('#000000')" />
			<area shape="rect" coords="23,5,35,17" href="javascript:colorChangeFun('#A52A00')" />
			<area shape="rect" coords="41,5,53,17" href="javascript:colorChangeFun('#004040')" />
			<area shape="rect" coords="59,5,71,17" href="javascript:colorChangeFun('#005500')" />
			<area shape="rect" coords="77,5,89,17" href="javascript:colorChangeFun('#00005E')" />
			<area shape="rect" coords="95,5,107,17" href="javascript:colorChangeFun('#00008B')" />
			<area shape="rect" coords="113,5,125,17" href="javascript:colorChangeFun('#4B0082')" />
			<area shape="rect" coords="131,5,143,17" href="javascript:colorChangeFun('#282828')" />
			<area shape="rect" coords="5,23,17,35" href="javascript:colorChangeFun('#8B0000')" />
			<area shape="rect" coords="23,23,35,35" href="javascript:colorChangeFun('#FF6820')" />
			<area shape="rect" coords="41,23,53,35" href="javascript:colorChangeFun('#8B8B00')" />
			<area shape="rect" coords="59,23,71,35" href="javascript:colorChangeFun('#009300')" />
			<area shape="rect" coords="77,23,89,35" href="javascript:colorChangeFun('#388E8E')" />
			<area shape="rect" coords="95,23,107,35" href="javascript:colorChangeFun('#0000FF')" />
			<area shape="rect" coords="113,23,125,35" href="javascript:colorChangeFun('#7B7BC0')" />
			<area shape="rect" coords="131,23,143,35" href="javascript:colorChangeFun('#666666')" />
			<area shape="rect" coords="5,41,17,53" href="javascript:colorChangeFun('#FF0000')" />
			<area shape="rect" coords="23,41,35,53" href="javascript:colorChangeFun('#FFAD5B')" />
			<area shape="rect" coords="41,41,53,53" href="javascript:colorChangeFun('#32CD32')" />
			<area shape="rect" coords="59,41,71,53" href="javascript:colorChangeFun('#3CB371')" />
			<area shape="rect" coords="77,41,89,53" href="javascript:colorChangeFun('#7FFFD4')" />
			<area shape="rect" coords="95,41,107,53" href="javascript:colorChangeFun('#7D9EC0')" />
			<area shape="rect" coords="113,41,125,53" href="javascript:colorChangeFun('#800080')" />
			<area shape="rect" coords="131,41,143,53" href="javascript:colorChangeFun('#7F7F7F')" />
			<area shape="rect" coords="5,59,17,71" href="javascript:colorChangeFun('#FFC0CB')" />
			<area shape="rect" coords="23,59,35,71" href="javascript:colorChangeFun('#FFD700')" />
			<area shape="rect" coords="41,59,53,71" href="javascript:colorChangeFun('#FFFF00')" />
			<area shape="rect" coords="59,59,71,71" href="javascript:colorChangeFun('#00FF00')" />
			<area shape="rect" coords="77,59,89,71" href="javascript:colorChangeFun('#40E0D0')" />
			<area shape="rect" coords="95,59,107,71" href="javascript:colorChangeFun('#C0FFFF')" />
			<area shape="rect" coords="113,59,125,71" href="javascript:colorChangeFun('#480048')" />
			<area shape="rect" coords="131,59,143,71" href="javascript:colorChangeFun('#C0C0C0')" />
			<area shape="rect" coords="5,77,17,89" href="javascript:colorChangeFun('#FFE4E1')" />
			<area shape="rect" coords="23,77,35,89" href="javascript:colorChangeFun('#D2B48C')" />
			<area shape="rect" coords="41,77,53,89" href="javascript:colorChangeFun('#FFFFE0')" />
			<area shape="rect" coords="59,77,71,89" href="javascript:colorChangeFun('#98FB98')" />
			<area shape="rect" coords="77,77,89,89" href="javascript:colorChangeFun('#AFEEEE')" />
			<area shape="rect" coords="95,77,107,89" href="javascript:colorChangeFun('#68838B')" />
			<area shape="rect" coords="113,77,125,89" href="javascript:colorChangeFun('#E6E6FA')" />
			<area shape="rect" coords="131,77,143,89" href="javascript:colorChangeFun('#FFFFFF')" />
		</map>
	</div>
</div>

<!-- 폰트 -->
<a href="#none" onclick="layerView('layerFont')">폰트변경</a>
<div id='layerFont' style="position:relative;left:0px;top:0px;visibility:hidden" >
	<div  style='position:absolute; left:180; top:70; visibility:; z-index:3;'>	
		<table width=50 border=0 cellpadding=0 cellspacing=0 style="border:1px solid #aaaaaa">
			<tr onmouseover=setColor(this,'#f3f3b9')  onmouseout=setColor(this,'#ffffff')>
				<td width=50 height=25 align=center style="cursor:hand" onclick="fontChangeFun('굴림')">굴림</td>
			</tr>
			<tr onmouseover=setColor(this,'#f3f3b9')  onmouseout=setColor(this,'#ffffff')>
				<td width=50 height=25 align=center style="cursor:hand" onclick="fontChangeFun('돋움')">돋움</td>
			</tr>
			<tr onmouseover=setColor(this,'#f3f3b9')  onmouseout=setColor(this,'#ffffff')>
				<td width=50 height=25 align=center style="cursor:hand" onclick="fontChangeFun('궁서')">궁서</td>
			</tr>
		</table>
	</div>
</div>

<!-- 폰트 -->
<a href="#none" onclick="layerView('layerIcon')">아이콘변경</a>
<div id='layerIcon' style="position:relative;left:0px;top:0px;visibility:hidden" >
	<div  style='position:absolute; left:180; top:70; visibility:; z-index:3;'>	
		<table border=0 cellpadding=0 cellspacing=0 style="border:1px solid #aaaaaa">
			<tr>
<?
$iconKey = array_keys($iconArray);
for($i=0;$i<count($iconKey);$i++) {
				if($i != 0 && $i % 5 == 0) echo "</tr><tr>";
?>
				<td width=25 height=25 align=center><a href="#none" onclick="printIcon('<?=$iconKey[$i]?>')"><img src="./icon/<?=$iconArray[$iconKey[$i]]?>.gif" border=0 title='<?=$iconKey[$i]?>'></a></td>

<?
}
?>

			</tr>
		</table>
	</div>
</div>




<input type="text" size=10 name="nickName" value="<?=$nickName?>">
<input type="text" size=10 name="color" value="ff0000">
<input type="text" size=10 name="font" value="굴림">

<!-- 아이콘 출력 -->
<?
$iconKey = array_keys($iconArray);
for($i=0;$i<count($iconKey);$i++) {
?>
<a href="#none" onclick="printIcon('<?=$iconKey[$i]?>')"><img src="./icon/<?=$iconArray[$iconKey[$i]]?>.gif" border=0 title='<?=$iconKey[$i]?>'></a>
<?
}
?>

<input type="hidden" name="now" value="<?=urlencode(date('Y-m-d H:i:s'))?>">
<div id='chat'  class="chatStyle"></div>
<textarea name="chatmsg" onkeydown=chatKeyCheck(this) class="chatBox"></textarea>
</form>
<script>
chatUpdate();
</script>
</body>
</html>