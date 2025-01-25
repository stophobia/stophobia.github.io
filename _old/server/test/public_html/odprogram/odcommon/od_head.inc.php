<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<title><?=$row_company[homepage_title];?></title>
		<meta http-equiv=Cache-Control content=no-cache>
		<meta http-equiv=Pragma content=no-cache>
		<meta http-equiv="imagetoolbar" content="no">
		<link rel="alternate" type="application/rss+xml" title="RSS" href="/rss.php">
		<!-- 달력 -->
		<link href="/css/jsCalendar.css" rel="stylesheet" type="text/css">
		<script language="javascript" src="/js/js_date.js" type="text/JavaScript"></script>
		<script language="javascript" src="/js/jsCalendar.js" type="text/JavaScript"></script>
		<script language="javascript" src="/js/common.js" type="text/JavaScript"></SCRIPT>
		<script language="javascript" src="/js/AC_RunActiveContent.js" type="text/javascript"></script>
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
		</script>
		<link href="<?=$path_domain;?>/css/style.css" rel="stylesheet" type="text/css">
		<style> 
			IMG {border: none;} 
		</style>

		<script>
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
		</script>
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
