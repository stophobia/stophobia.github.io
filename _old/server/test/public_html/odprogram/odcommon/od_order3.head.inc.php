<?

// kcp 환경설정 파일 //////////////////////////////////////////////////////////
include "../../kcp/cfg/site_conf_inc.php";

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<title><?=$row_company[homepage_title];?></title>
		<meta http-equiv=Cache-Control content=no-cache>
		<meta http-equiv=Pragma content=no-cache>
		<meta http-equiv="imagetoolbar" content="no">
<?
    /* ============================================================================== */
    /* =   Javascript source Include                                                = */
    /* = -------------------------------------------------------------------------- = */
    /* =   ※ 필수                                                                  = */
    /* =   테스트 및 실결제 연동시 site_conf_inc.php파일을 수정하시기 바랍니다.     = */
    /* = -------------------------------------------------------------------------- = */
?>
    <script type="text/javascript" src='<?=$g_conf_js_url?>'></script>
<?
    /* = -------------------------------------------------------------------------- = */
    /* =   Javascript source Include END                                            = */
    /* ============================================================================== */
?>
    <script type="text/javascript">
        /* 플러그인 설치(확인) */
        StartSmartUpdate();
        
        /* 플러그 인 설치 (확인2) */
        /*
        if(document.Payplus.object == null)
        {
            openwin = window.open( "/Kcp/files/chk_plugin.html", "chk_plugin", "width=600, height=420, top=300, left=300" );
        }
        */
        /* Payplus Plug-in 실행 */
        function jsf__pay(form)
        {
            var RetVal = false;
            if(document.Payplus.object == null)
            {
                openwin = window.open( "/kcp/files/chk_plugin.html", "chk_plugin", "width=600, height=420, top=300, left=300" );
            }
            /* Payplus Plugin 실행 */
            if(MakePayMessage(form) == true)
            {
                //openwin = window.open("/kcp/files/proc_win.html", "proc_win", "width=449, height=209, top=300, left=300");
                RetVal = true;
            }
            else
            {
                /*  res_cd와 res_msg변수에 해당 오류코드와 오류메시지가 설정됩니다.
                ex) 고객이 Payplus Plugin에서 취소 버튼 클릭시 res_cd=3001, res_msg=사용자 취소
                이 설정됩니다.
                */
                res_cd  = document.order_info.res_cd.value ;
                res_msg = document.order_info.res_msg.value ;
                //alert ( "Payplus Plug-in 실행 결과(샘플)\n" + "res_cd = " + res_cd + "|" + "res_msg=" + res_msg ) ;
            }
            return RetVal ;
        }
        /* onLoad 이벤트 시 Payplus Plug-in이 실행되도록 구성하시려면 다음의 구문을 onLoad 이벤트에 넣어주시기 바랍니다. */
        function onload_pay()
        {
             if( jsf__pay(document.order_info) )
                document.order_info.submit();
        }

        function create_goodInfo()
        {
            var chr30 = String.fromCharCode(30);	// ASCII 코드값 30
            var chr31 = String.fromCharCode(31);	// ASCII 코드값 31

            var good_info = "seq=1" + chr31 + "ordr_numb=<?=$ordernum?>" + chr31 + "good_name=<?=$goodname?>" + chr31 + "good_cntx=1" + chr31 + "good_amtx=<?= $tPrice ?>";

          document.order_info.good_info.value = good_info;
        }
    </script>
<!-- //////////////////allthegate //////////////////-->
<script language=javascript>
function Enable_Flag(form){
        form.Flag.value = "enable"
}
function Disable_Flag(form){
        form.Flag.value = "disable"
}
function Check_Common(form){
    if(form.StoreId.value == ""){
        alert("상점아이디를 입력하십시오.");
        return false;
    }
    else if(form.StoreNm.value == ""){
        alert("상점명을 입력하십시오.");
        return false;
    }
    else if(form.OrdNo.value == ""){
        alert("주문번호를 입력하십시오.");
        return false;
    }
    else if(form.ProdNm.value == ""){
        alert("상품명을 입력하십시오.");
        return false;
    }
    else if(form.Amt.value == ""){
        alert("금액을 입력하십시오.");
        return false;
    }
    else if(form.MallUrl.value == ""){
        alert("상점URL을 입력하십시오.");
        return false;
    }
    return true;
}

function Display(form){
    if(form.Job.value == "onlycard" || form.TempJob.value == "onlycard"){
        document.all.card_hp.style.display= "";
        document.all.card.style.display= "";
        document.all.hp.style.display= "none";
        document.all.virtual.style.display= "none";
    }else if(form.Job.value == "onlyhp" || form.TempJob.value == "onlyhp"){
        document.all.card_hp.style.display= "";
        document.all.card.style.display= "none";
        document.all.hp.style.display= "";
        document.all.virtual.style.display= "none";
    }else if(form.Job.value == "onlyvirtual" || form.TempJob.value == "onlyvirtual" ||
             form.Job.value == "onlyvirtualself" || form.TempJob.value == "onlyvirtualself"){
        document.all.card_hp.style.display= "none";
        document.all.card.style.display= "";
        document.all.hp.style.display= "none";
        document.all.virtual.style.display= "";
    }else if(form.Job.value == "onlyiche" || form.TempJob.value == "onlyiche" || 
             form.Job.value == "onlyicheself" || form.TempJob.value == "onlyicheself" ){
        document.all.card_hp.style.display= "none";
        document.all.card.style.display= "none";
        document.all.hp.style.display= "none";
        document.all.virtual.style.display= "none";
    }else{
        document.all.card_hp.style.display= "";
        document.all.card.style.display= "";
        document.all.hp.style.display= "";
        document.all.virtual.style.display= "";
    }
}

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
-->
</script>

    <link href="<?=$path_domain;?>/css/style.css" rel="stylesheet" type="text/css">

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

