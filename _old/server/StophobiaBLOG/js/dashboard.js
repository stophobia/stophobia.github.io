window.onload = function () {
	var result = '<ul>';
	var request = new Ajax.Request('admin/admin_get_sinknet.php', {
		parameters : 'x=y',				
		onSuccess : function(request) {
			var lists = request.responseXML.getElementsByTagName('lists');
			for(i=0; i<lists.length; i++) {
				var name = lists[i].getElementsByTagName('name')[0].firstChild.nodeValue;
				var url = lists[i].getElementsByTagName('url')[0].firstChild.nodeValue;
				var title = lists[i].getElementsByTagName('title')[0].firstChild.nodeValue;
				var date = lists[i].getElementsByTagName('date')[0].firstChild.nodeValue;
				result += '<li><span style="color: #008080">['+name+']</span> <a href="http://'+url+'" onclick="window.open(this.href, \'_blank\'); return false" title="이 글을 새 창으로 열어봅니다.">'+title+'</a> <span>('+date+')</span></li>';
			}
			$('sinkLatest').innerHTML = result+'</ul>';
		}
	});

	var latestVer = new Ajax.Request('admin/admin_get_latestversion.php', {
		parameters : 'x=y',
		onSuccess : function(latestVer) {
			var lists = latestVer.responseXML.getElementsByTagName('lists')[0];
			var title = lists.getElementsByTagName('title')[0].firstChild.nodeValue;
			var date = lists.getElementsByTagName('date')[0].firstChild.nodeValue;
			var no = lists.getElementsByTagName('no')[0].firstChild.nodeValue;
			var down = lists.getElementsByTagName('down')[0].firstChild.nodeValue;
			$('latestVersion').innerHTML = '<h2><a href="http://sirini.net/grboard/'+down+'" title="클릭하시면 GR블로그 최신 패키지를 받습니다.">'+title+'</a></h2>'+
				'<p>'+date+', <a href="http://sirini.net/grboard/board.php?id=grblog&amp;articleNo='+no+'" onclick="window.open(this.href, \'_blank\'); return false" title="클릭하시면 새 창으로 시리니넷 GR블로그 배포 페이지를 열어봅니다.">더 많은 정보보기<img src="image/darkgray/bullet.arrow.right.gif" alt="" /></a></p>';
		}
	});
}