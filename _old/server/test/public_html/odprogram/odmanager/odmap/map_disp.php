<HTML>
<HEAD>
<meta http-equiv="content-type" content="text/html; charset=utf-8">
<TITLE> 아파트 지도 </TITLE>
</HEAD>

<BODY topmargin="0" leftmargin="0">
<SCRIPT LANGUAGE="JavaScript" src="http://map.naver.com/js/naverMap.naver?key=12298bd0e6b4ccbf1310578bb5e838de"></SCRIPT>
<div id='mapContainer' style='width:680px;height:420px'></div>
<SCRIPT LANGUAGE="JavaScript">
<!--
    var marker;
    function createMarker(pos,count,content)
    {
        var iconUrl = '/images/aptPoint.png';
        marker = new NMark(pos,new NIcon(iconUrl,new NSize(45,45)));
        NEvent.addListener(marker,"mouseover",function(pos){infowin.set(pos,"<TABLE style='width:100px;height:50px;border:solid 1px #666666' bgcolor='#FFFFFF'><TR><TD style='font:normal normal normal 10pt 굴림,serif'>"+content+"</TD></TR></TABLE>");infowin.showWindow()});
        NEvent.addListener(marker,"mouseout",function(){infowin.hideWindow();});
        return marker;
    }
    var mapObj = new NMap(document.getElementById('mapContainer'),680,420);
    var point = new NPoint(<?=$x?>,<?=$y?>);
    var infowin = new NInfoWindow();
    var Amarker = createMarker(point,1,"<?=$content?>");
    mapObj.setCenterAndZoom(point,<?=$zoom?>);

    mapObj.addOverlay(infowin);
    mapObj.addOverlay(Amarker);

    //mapObj.enableWheelZoom();             // 마우스 휠 스크롤로 줌 컨트롤하기
    /* 지도 컨트롤 생성 (축척 수준, 미니맵) */
    var zoom =new NZoomControl();
    zoom.setAlign("left");
    zoom.setValign("bottom");
    mapObj.addControl(zoom);
    mapObj.addControl(new NIndexMap());
//-->
</SCRIPT>
</BODY>
</HTML>