<HTML>
<HEAD>
<meta http-equiv="content-type" content="text/html; charset=utf-8">
<TITLE> 아파트 지도 </TITLE>
</HEAD>

<BODY topmargin="0" leftmargin="0">
<SCRIPT LANGUAGE="JavaScript" src="http://map.naver.com/js/naverMap.naver?key=12298bd0e6b4ccbf1310578bb5e838de"></SCRIPT>
<div id='mapContainer' style='width:700px;height:400px'></div>
<TABLE width="700" cellspacing="0" cellpadding="0">
<TR>
    <TD height="10"></TD>
</TR>
<TR>
    <TD height="2" bgcolor="#D6D6D6"></TD>
</TR>
<TR>
    <TD height="10"></TD>
</TR>
<TR>
    <TD>
        <form name="geoFrm" method="post">
        <input name="code"      type="hidden" value="<?=$code?>">
        <input name="x"         type="hidden" value="<?=$x?>">
        <input name="y"         type="hidden" value="<?=$y?>">
        <input name="zoom"      type="hidden" value="<?=$zoom?>">
        <TABLE width="700" cellspacing="0" cellpadding="0">
            <TR>
                <TD align="left"><button onclick=addClick()>아파트위치변경모드</button><button onclick=removeClick()>위치변경모드취소</button></TD>
                <td align="right"><button onclick=saveClick(this.form)>현재위치저장</button></td>
            </TR>
        </TABLE>
        </form>
    </TD>
</TR>
</TABLE>
<iframe name="hiddenFrame" id="hiddenFrame" src="#" width="0" height="0" frameborder="0"></iframe>
<SCRIPT LANGUAGE="JavaScript">
<!--
    var marker;
    function createMarker(pos,count,content)
    {
        var iconUrl = '/images/aptPoint.png';
        marker = new NMark(pos,new NIcon(iconUrl,new NSize(45,45)));
        NEvent.addListener(marker,"mouseover",function(pos){infowin.set(pos,"<TABLE style='width:100px;height:50px;border:solid 1px #666666' bgcolor='#FFFFFF'><TR><TD>"+content+"</TD></TR></TABLE>");infowin.showWindow()});
        NEvent.addListener(marker,"mouseout",function(){infowin.hideWindow();});
        return marker;
    }
    var mapObj = new NMap(document.getElementById('mapContainer'),700,400);
    var point = new NPoint("<?=$x?>","<?=$y?>");
    var infowin = new NInfoWindow();
    var Amarker = createMarker(point,1,"<?=$content?>");
    mapObj.setCenterAndZoom(point,"<?=$zoom?>");

    mapObj.addOverlay(infowin);
    mapObj.addOverlay(Amarker);

    mapObj.enableWheelZoom();
    /* 지도 컨트롤 생성 (축척 수준, 미니맵) */
    var zoom =new NZoomControl();
    zoom.setAlign("left");
    zoom.setValign("bottom");
    mapObj.addControl(zoom);
    mapObj.addControl(new NIndexMap());

    var regFlag = false;

    function addClick()
    {
        if (!regFlag)
        {
            NEvent.addListener(mapObj,"click",clicked);
            regFlag  = true;
        }
    }

    function removeClick()
    {
        NEvent.removeListener(mapObj,"click",clicked);
        regFlag  = false;
    }

    function saveClick(frm){
        var Apos = Amarker.getPoint()
        document.geoFrm.x.value = Apos.getX();
        document.geoFrm.y.value = Apos.getY();
        document.geoFrm.zoom.value = mapObj.getZoom();
        frm.target = "hiddenFrame";
        frm.action = "/odprogram/odmanager/odmap/map_tran.php";
        frm.submit();
    }

    function clicked(pos)
    {
        document.geoFrm.x.value = pos.getX();
        document.geoFrm.y.value = pos.getY();
        document.geoFrm.zoom.value = mapObj.getZoom();
        mapObj.addOverlay(marker.setPoint(pos));
    }

//-->
</SCRIPT>
</BODY>
</HTML>