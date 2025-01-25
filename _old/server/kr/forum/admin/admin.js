var Forum = {
	remove : function(m, parent, uid) {
		if(confirm('정말로 선택하신 분류를 삭제하시겠습니까?\n\n하위 분류가 있을 경우 하위분류들까지 한 번에 삭제됩니다.')) {
			location.href='./?m='+m+'&parent='+parent+'&deleteTarget='+uid;
		}
	},

	check : function(ptr) {
		if(!ptr.elements['name'].value) {
			alert('분류 이름을 입력해 주세요.');
			ptr.elements['name'].focus();
			return false;
		}
		return true;
	},
	
	paste : function(id) {
		document.forms['block_id'].elements['blockID'].value = id;
	},
	
	suggest : function(ptr) {
		$("#enter").hide("slow");
		$.post("forum.block.id.suggest.php", { id: ptr.value },
		function(data){
			$("#autoSuggest").show();
			$("#autoSuggest").html(data);
		});
	},
	
	limitOpen : function(m, uid) {
		if(confirm('정말로 해제하시겠습니까?')) {
			location.href='./?m='+m+'&limitOpen='+uid;
		}
	},

	action : function(ptr) {
		if(ptr.value) $("#outlink").hide("slow");
		else $("#outlink").show("slow");
	}
}