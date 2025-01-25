<?
include "./icon.php";
# 채팅 기본값.
$nickName = $row_member[chatNickName] ? $row_member[chatNickName] : $row_member[name];
$color = $row_member[chatColor];
$font = "굴림";
?>
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
function chatPro(obj) {
		// 빈값일때 리턴
		if(!obj.value.trim()) {
			obj.value='';
			event.returnValue = false; 
			return false;
		}
		frm = document.form;
		// 백그라운드로 DB에 입력.
		param = "id="+frm.userID.value+"&name="+frm.nickName.value+"&content="+frm.chatmsg.value+"&color="+frm.color.value+"&font="+encodeURIComponent(frm.font.value)+"&code="+frm.code.value;
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
		chatText = chatText.replace(/\/<?=$iconKey[$i]?>\//g,'<img src=/images/icon/<?=$iconArray[$iconKey[$i]]?>.gif>');
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

function chatKeyCheck(obj) {
	frm = document.form;
	chatDisplay = document.getElementById('chat');
	if(event.keyCode == 13) {
		chatPro(obj);
	}

}

function chatUpdate() {
	frm = document.form;
	// 백그라운드로 DB 추출.
	param = "now="+frm.now.value+"&id="+frm.userID.value+"&code="+frm.code.value;
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
			if(!req.responseText.match('Bad Request')) { // 연결 불안정 메세지는 출력하지 않음.
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
}
function layerView(name) {
	obj = document.getElementById(name);

	// 레이어 컨트롤
	if(obj.style.visibility == "") {
		obj.style.visibility = "hidden";
	} else {
		obj.style.visibility = "";
	}

	iconOnOff(name);
}

function iconOnOff(name) {
	// 이미지 on off
	obj2 = document.getElementById(name+"_2");
	src2 = String(obj2.src)
	if(src2.match('_on_')) {
		obj2.src = src2.replace('_on_','_off_');
	} else {
		obj2.src = src2.replace('_off_','_on_');
	}
}

function reset(name) {
	var nameArray = ['layerIcon','layerFont','layerPalette','layerNick'];
	for(i=0;i<nameArray.length;i++) {
		if(nameArray[i] != name) {
			obj = document.getElementById(nameArray[i]);
			obj.style.visibility = "hidden";

			obj2 = document.getElementById(nameArray[i]+"_2");
			src2 = String(obj2.src)
			obj2.src = src2.replace('_on_','_off_');

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
			hidden_frame.location.href='/pages/etc/chatUpdate.php?type=nick&nick='+encodeURIComponent(obj.value);
			return false;
		} else {
			alert('닉네임을 입력하세요');
		}
	}
}


function colorChangeFun(color) {
	frm = document.form;
	frm.color.value = color;
	hidden_frame.location.href='/pages/etc/chatUpdate.php?type=color&color='+encodeURIComponent(color);
	layerView('layerPalette')
}

function fontChangeFun(font) {
	frm = document.form;
	frm.font.value = font;
	layerView('layerFont');
}

/*
//채팅창 떠다니는 소스
self.onError=null;
currentX = currentY = 0; 
whichIt = null; 
lastScrollX = 0; lastScrollY = 0;
NS = (document.layers) ? 1 : 0;
IE = (document.all) ? 1: 0;
<!-- STALKER CODE -->
function chaterror_loc() {
	if(IE) { 
		diffY = document.body.scrollTop; 
		diffX = 0; 
	}
	if(NS) { 
		diffY = self.pageYOffset; diffX = self.pageXOffset;
	}
	if(diffY != lastScrollY) {
		percent = .1 * (diffY - lastScrollY);
		if(percent > 0) percent = Math.ceil(percent);
		else percent = Math.floor(percent);
		if(IE) document.all.P_LayertodayLiveChat.style.pixelTop += percent;
		if(NS) document.P_LayertodayLiveChat.top += percent; 
		lastScrollY = lastScrollY + percent;
	}
	if(diffX != lastScrollX) {
		percent = .1 * (diffX - lastScrollX);
		if(percent > 0) percent = Math.ceil(percent);
		else percent = Math.floor(percent);
	if(IE) document.all.P_LayertodayLiveChat.style.pixelLeft += percent;
	if(NS) document.P_LayertodayLiveChat.top += percent;
		lastScrollY = lastScrollY + percent;
	} 
} 
if(NS || IE) action = window.setInterval("chaterror_loc()",1);
*/

function chatClose() {
	location.reload();
}
</script>


<script language='javascript' src='/js/layerPopup.js'></script>
<div style='Z-INDEX: 100; LEFT: 0px; WIDTH: 0px; POSITION: relative; TOP: 0px; HEIGHT: 0px;display:none'  ID="P_LayertodayLiveChat" OnMouseDown="ddInit('todayLiveChat',event)" OnMouseUp="ddEnabled=false">
	<div style='position:absolute;z-index:3;top:<?=$thiscafe == "03" ? "5" : "-3";?>px;left:450px;'>
		<table width="420" border="0" cellspacing="0" cellpadding="0">
			<tr>
				<td valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
					<tr>
						<td width="150">
							<!-- 카운터 -->
							<script type="text/javascript">
							AC_FL_RunContent( 'codebase','http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=9,0,28,0','width','150','height','68','src','/flash/chatting_count<?=$thiscafe?>','quality','high','pluginspage','http://www.adobe.com/shockwave/download/download.cgi?P1_Prod_Version=ShockwaveFlash','movie','/flash/chatting_count<?=$thiscafe?>','wmode','transparent' ); //end AC code
							</script><noscript><object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=9,0,28,0"  width="150" height="68">
							<param name="movie" value="/flash/chatting_count<?=$thiscafe?>.swf" />
							<param name="quality" value="high" />
							<param name="wmode" value="transparent" />
							<embed src="/flash/chatting_count<?=$thiscafe?>.swf" quality="high" pluginspage="http://www.adobe.com/shockwave/download/download.cgi?P1_Prod_Version=ShockwaveFlash" type="application/x-shockwave-flash" width="150" height="68" wmode="transparent"></embed>
							</object></noscript>
							<!-- 카운터 끝 -->							
						</td>
						<td width="239"  ID="titleBartodayLiveChat" STYLE="CURSOR:move" ><img src="/img/media_img_19.jpg" width="239" height="68" /></td>
						<td valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
							<tr>
								<td><img src="/img/media_img_20.jpg" width="31" height="14" /></td>
							</tr>
						</table>
							<table width="100%" border="0" cellspacing="0" cellpadding="0">
								<tr>
									<td height="17" valign="top" background="/img/media_img_21.jpg"><table width="100%" border="0" cellspacing="0" cellpadding="0">
										<tr>
											<td><a href="#none"  OnClick="hideLayer('todayLiveChat')"><img src="/img/media_img_22.jpg" width="18" height="17" border=0 /></a></td>
										</tr>
									</table></td>
								</tr>
							</table>
							<table width="100%" border="0" cellspacing="0" cellpadding="0">
								<tr>
									<td><img src="/img/media_img_23.jpg" width="31" height="37" /></td>
								</tr>
							</table></td>
					</tr>
				</table>
					<table width="100%" border="0" cellspacing="0" cellpadding="0">
						<tr>
							<td valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
								<tr>
									<td><img src="/img/media_img_24.jpg" width="420" height="15" /></td>
								</tr>
							</table>
								<table width="100%" border="0" cellspacing="0" cellpadding="0">
									<tr>
										<td width="10" height="199" background="/img/media_img_25.jpg">&nbsp;</td>
										<td width="396" height="199" valign="top" align=left><div id='chat' class="chatStyle2"></div></td>
										<td width="15" valign="top" background="/img/media_img_26.jpg">&nbsp;</td>
									</tr>
								</table>
								<table width="100%" border="0" cellspacing="0" cellpadding="0">
									<tr>
										<td><img src="/img/media_img_27.jpg" width="420" height="22" /></td>
									</tr>
								</table>
					<form name="form" action="" method=post style="display:inline">
						<input type="hidden" name="nickName" value="<?=$nickName?>">
						<input type="hidden" name="userID" value="<?=$row_member[id]?>">
						<input type="hidden" name="color" value="<?=$color?>">
						<input type="hidden" name="font" value="<?=$font?>">
						<input type="hidden" name="code" value="<?=[code]?>">
						<input type="hidden" name="now" value="<?=urlencode([live_start_time])?>">	
								<table width="100%" border="0" cellspacing="0" cellpadding="0">
									<tr>
										<td width="26" height="56" background="/img/media_img_25.jpg">&nbsp;</td>
										<td width="380" height="56" valign="top" bgcolor="ffffff"><table width="100%" border="0" cellspacing="0" cellpadding="0">
											<tr>
				<?
				if($row_member[id]) {	// 로그인
				?>
												<td width="284" valign="top"><textarea name="chatmsg" onkeydown=chatKeyCheck(this) class="chatBox2"></textarea></td>
												<td><a href="#none" onclick="chatPro(document.form.chatmsg)"><img src="/img/media_img_28.jpg" border=0 /></a></td>
				<?
				} else {
				?>
												<td width="284" valign="top" onclick="loginConfirm('<?=urlencode($_SERVER[PHP_SELF])?>');"><textarea name="chatmsg" onkeydown=chatKeyCheck(this) class="chatBox2"  disabled>로그인 후 이용해주세요.</textarea></td>
												<td><a href="#none" onclick="loginConfirm('<?=urlencode($_SERVER[PHP_SELF])?>');" ><img src="/img/media_img_28.jpg" border=0 /></a></td>

				<?
				}
				?>
											</tr>
										</table></td>
										<td valign="top" background="/img/media_img_26.jpg">&nbsp;</td>
									</tr>
								</table>
						</form>
								<table width="100%" border="0" cellspacing="0" cellpadding="0">
									<tr>
										<td><img src="/img/media_img_29.jpg" width="420" height="13" /></td>
									</tr>
								</table></td>
						</tr>
					</table></td>
			</tr>
		</table>

	</div>
</DIV>

<SCRIPT LANGUAGE="JavaScript">
<!--
//View_Popup('todayLiveChat',-12,-9);
chatUpdate();
// 채팅창 자동으로 하단으로이동.
function autoFocus2() {
	obj = document.getElementById('chat');
	if(obj.scrollHeight < 250) {
		setTimeout("autoFocus2()",100);
	} else {
		obj.scrollTop = obj.scrollHeight;
	}
}
autoFocus2();

//-->
</SCRIPT>