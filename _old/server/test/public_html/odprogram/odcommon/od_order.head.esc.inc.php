<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<title><?=$row_company[homepage_title];?></title>
		<meta http-equiv=Cache-Control content=no-cache>
		<meta http-equiv=Pragma content=no-cache>
		<meta http-equiv="imagetoolbar" content="no">
		<!-- 달력 -->
		<script language=javascript src="http://plugin.inicis.com/pay40_uni.js"></script>
		<script language=javascript>
		StartSmartUpdate();	// 플러그인 설치(확인)
		</script>
		<script language="JavaScript" type="text/JavaScript">
		<!--
			function MM_swapImgRestore() { //v3.0
				var i,x,a=document.MM_sr; for(i=0;a&&i<a.length&&(x=a[i])&&x.oSrc;i++) x.src=x.oSrc;
			}

			function MM_preloadImages() { //v3.0
				var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();
				var i,j=d.MM_p.length,a=MM_preloadImages.arguments; for(i=0; i<a.length; i++)
				
				if (a[i].indexOf("#")!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}
			}

			function MM_findObj(n, d) { //v4.01
				var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
				d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
				if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
				for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
				if(!x && d.getElementById) x=d.getElementById(n); return x;
			}

			function MM_swapImage() { //v3.0
				var i,j=0,x,a=MM_swapImage.arguments; document.MM_sr=new Array; for(i=0;i<(a.length-2);i+=3)
				if ((x=MM_findObj(a[i]))!=null){document.MM_sr[j++]=x; if(!x.oSrc) x.oSrc=x.src; x.src=a[i+2];}
			}

			function MM_jumpMenu(targ,selObj,restore){ //v3.0
				eval(targ+".location='"+selObj.options[selObj.selectedIndex].value+"'");
				if (restore) selObj.selectedIndex=0;
			}
		//-->

			function MM_showHideLayers() { //v6.0
			  var i,p,v,obj,args=MM_showHideLayers.arguments;
			  for (i=0; i<(args.length-2); i+=3) if ((obj=MM_findObj(args[i]))!=null) { v=args[i+2];
				if (obj.style) { obj=obj.style; v=(v=='show')?'visible':(v=='hide')?'hidden':v; }
				obj.visibility=v; }
			}

			function Error_Func() {
				alert('로그인 후 사용하실 수 있습니다.   ');
			}

			function openwindow(name,url,width,height,scrollbar) {
				scrollbar_str = scrollbar ? 'yes' : 'no';
				window.open(url,name,'width='+width+',height='+height+',scrollbars='+scrollbar_str);
			}

			function authFunction() {
				alert('해당 게시판에 대한 권한이 없습니다.   ');
			}

		var openwin;

		function pay(frm)
		{
			// MakePayMessage()를 호출함으로써 플러그인이 화면에 나타나며, Hidden Field
			// 에 값들이 채워지게 됩니다. 일반적인 경우, 플러그인은 결제처리를 직접하는 것이
			// 아니라, 중요한 정보를 암호화 하여 Hidden Field의 값들을 채우고 종료하며,
			// 다음 페이지인 INIsecurepay.php로 데이터가 포스트 되어 결제 처리됨을 유의하시기 바랍니다.

			if(document.ini.clickcontrol.value == "enable")
			{
				
				if(document.ini.goodname.value == "")  // 필수항목 체크 (상품명, 상품가격, 구매자명, 구매자 이메일주소, 구매자 전화번호)
				{
					alert("상품명이 빠졌습니다. 필수항목입니다.");
					return false;
				}
				else if(document.ini.price.value == "")
				{
					alert("상품가격이 빠졌습니다. 필수항목입니다.");
					return false;
				}
				else if(document.ini.buyername.value == "")
				{
					alert("구매자명이 빠졌습니다. 필수항목입니다.");
					return false;
				} 
				else if(document.ini.buyeremail.value == "")
				{
					alert("구매자 이메일주소가 빠졌습니다. 필수항목입니다.");
					return false;
				}
				else if(document.ini.buyertel.value == "")
				{
					alert("구매자 전화번호가 빠졌습니다. 필수항목입니다.");
					return false;
				}
				else if(document.INIpay == null || document.INIpay.object == null)  // 플러그인 설치유무 체크
				{
					alert("\n이니페이 플러그인 128이 설치되지 않았습니다. \n\n안전한 결제를 위하여 이니페이 플러그인 128의 설치가 필요합니다. \n\n다시 설치하시려면 Ctrl + F5키를 누르시거나 메뉴의 [보기/새로고침]을 선택하여 주십시오.");
					return false;
				}
				else
				{
					/******
					 * 플러그인이 참조하는 각종 결제옵션을 이곳에서 수행할 수 있습니다.
					 * (자바스크립트를 이용한 동적 옵션처리)
					 */

					hiddenFrame.location.href="/mall/products/order_ing.php?ordernum=<?=$ordernum?>";													 

					if (MakePayMessage(frm))
					{
						disable_click();
						openwin = window.open("childwin.html","childwin","width=299,height=149");		
						return true;
					}
					else
					{
						// 결제취소버튼 누름.
						hiddenFrame.location.href="/mall/products/ordercancle.php?ordernum=<?=$ordernum?>";
						alert("결제를 취소하셨습니다.");
						return false;
					}
				}
			}
			else
			{
				return false;
			}
		}


		function enable_click()
		{
			document.ini.clickcontrol.value = "enable"
		}

		function disable_click()
		{
			document.ini.clickcontrol.value = "disable"
		}

		function focus_control()
		{
			if(document.ini.clickcontrol.value == "disable")
				openwin.focus();
		}

		function MM_reloadPage(init) {  //reloads the window if Nav4 resized
			if (init==true) with (navigator) {if ((appName=="Netscape")&&(parseInt(appVersion)==4)) {
				document.MM_pgW=innerWidth; document.MM_pgH=innerHeight; onresize=MM_reloadPage; }}
			else if (innerWidth!=document.MM_pgW || innerHeight!=document.MM_pgH) location.reload();
		}
		MM_reloadPage(true);

		function MM_jumpMenu(targ,selObj,restore){ //v3.0
			eval(targ+".location='"+selObj.options[selObj.selectedIndex].value+"'");
			if (restore) selObj.selectedIndex=0;
		}
//-->
</script>
		<link href="/css/style.css" rel="stylesheet" type="text/css">

		<style> 
			IMG {border: none;} 
		</style>
<?PHP
	//  브라우저별 구분
	if( !ereg("MSIE" , $_SERVER['HTTP_USER_AGENT']) ) {
		echo "
		<style>
			#table_layer{margin:0 auto;text-align:center;}
			div{margin:0 auto;text-align:center;}
		</style>
		";
	}
?>
	</head>
