var Search = {
	check : function(ptr) {
		if(!ptr.elements['keyword'].value) {
			alert('검색어를 입력해 주세요');
			ptr.elements['keyword'].focus();
		}
		return false;
	},

	findIt : function() {
		var f = document.forms['search'];
		var isReady = false;
		for(k=0; k<f.length; k++) {
			if(f[k].type == 'checkbox' && f[k].checked == true) {
				isReady = true;
				break;
			}
		}
		if(!isReady) {
			alert('검색할 게시판을 하나 이상 선택해 주세요.');
			return;
		}
		var target = f.elements['type'].value;
		var text = f.elements['keyword'].value;
		var count = f.elements['count'].value;
		var bbslist = '';
		for(i=0; i<f.length; i++) {
			if(f[i].type == 'checkbox' && f[i].checked == true) {
				bbslist += f[i].value + '/';
			}
		}
		$.post("search.suggest.php", { keyword: text, type: target, limit: count, selectBBS: bbslist },
		function(data) {
			$("#resultSearchList").show();
			$("#resultSearchList").html(data);
		});
	},

	selectAll : function() {
		var f = document.forms['search'];
		for(i=0; i<f.length; i++) {
			if(f[i].type == 'checkbox') {
				f[i].checked = true;
			}
		}
	},

	clearAll : function() {
		var f = document.forms['search'];
		for(i=0; i<f.length; i++) {
			if(f[i].type == 'checkbox') {
				f[i].checked = false;
			}
		}
	},

	move : function(id) {
		var grboard = document.forms['search'].elements['grboard'].value;
		window.open(grboard + '/board.php?id=' + id, '_blank');
		return false;
	}
}