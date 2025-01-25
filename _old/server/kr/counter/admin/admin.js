var GC = {
	deleteID : function(no) {
		if(confirm('정말로 이 통계자료를 삭제하시겠습니까?\n\n'+
			'해당 ID로 구분지어진 통계자료들이 모두 삭제됩니다.\n\n'+
			'계속 하시겠습니까?')) {
			location.href='./?deleteID='+no;
		}
	},
	checkAddId : function() {
		t = document.forms['addID'];
		if(!t.elements['id'].value) {
			alert('아이디를 입력해 주세요');
			t.elements['id'].focus();
			return false;
		}
		return true;
	},
	selectDate : function(id, go, y, m, d) {
		src = './?selectID='+id+'&admin='+go+'&selectYear='+y;
		if(m) src += '&selectMonth='+m;
		if(d) src += '&selectDay='+d;
		location.href=src;
	},
	changeID : function(t, go, y, m, d) {
		src = './?admin='+go+'&selectID='+t.value;
		if(y) src += '&selectYear='+y;
		if(m) src += '&selectMonth='+m;
		if(d) src += '&selectDay='+d;
		location.href=src;
	},
	deleteCounter : function() {
		if(confirm('정말로 GR카운터를 삭제하시겠습니까?\n\n'+
			'삭제 시 지금까지 저장된 통계 DB가 모두 삭제되며\n\n'+
			'초기상태로 되돌아갑니다. 계속 하시겠습니까?')) {
			location.href='./?deleteCounter=1';
		}
	},
	checkIP : function(t) {
		if(!t.elements['findIP'].value) {
			alert('검색하고자 하는 IP를 입력해 주세요');
			t.elements['findIP'].focus();
			return false;
		}
		return true;
	},
	checkURL : function(t) {
		if(!t.elements['findURL'].value) {
			alert('검색하고자 하는 리퍼러 URL을 입력해 주세요');
			t.elements['findURL'].focus();
			return false;
		}
		return true;
	},
	viewDailyStat : function(id) {
		t = document.getElementById(id);
		if(t.style.display == '') t.style.display = 'none';
		else t.style.display = '';
	}
}

var Draw = {
	lineGraph : function(id, dataset, weeks) {
		var options = {
			shouldFill: false,
			padding: {
				left: 50, 
				right: 10, 
				top: 10, 
				bottom: 15
			},
			background: {
				color: '#f5f5f5'
			},
			colorScheme: 'green',
			axis: {
				labelColor: '#000000',
				x: {
					ticks: [
						{v:0, label: weeks[0]}, 
						{v:1, label: weeks[1]}, 
						{v:2, label: weeks[2]},
						{v:3, label: weeks[3]},
						{v:4, label: weeks[4]},
						{v:5, label: weeks[5]},
						{v:6, label: weeks[6]}
					]
				}
			},
			legend:{
				style:{
					width: '120px',
					left: '660px'
				}
			}
		};
		var line = new Plotr.LineChart('canvas_'+id,options);
		line.addDataset(dataset);
		line.render();
		line.reset();
		line.addDataset(dataset);
		line.render('canvas_'+id, options);
	},
	pieGraph : function(id, dataset, top5) {
		var options = {
			padding: {
				left: 10, 
				right: 10, 
				top: 10, 
				bottom: 10
			},
			background: {
				color: '#ffffff'
			},					
			colorScheme: 'green',				
			axis: {
				labelColor: '#000000',
				x: {
					ticks: [
						{v:0, label: top5[0]}, 
						{v:1, label: top5[1]}, 
						{v:2, label: top5[2]},
						{v:3, label: top5[3]},
						{v:4, label: top5[4]}
					]
				}
			},
			legend:{
				style:{
					width: '210px',
					left: '570px'
				}
			},
			colorScheme: 'green',
			pieRadius: '0.4'
		};
		var pie = new Plotr.PieChart('canvas_pie_'+id, options);
		pie.addDataset(dataset);
		pie.render();
		pie.reset();
		pie.addDataset(dataset);
		pie.render('canvas_pie_'+id, options);
	},
	barGraph : function(id, dataset, days) {
		var options = {
			padding: {
				left: 50, 
				right: 10, 
				top: 10, 
				bottom: 15
			},
			background: {
				color: '#f2f2f2'
			},					
			colorScheme: 'green',
			axis: {
				labelColor: '#000000',
				x: {
					ticks: [
						{v:0, label: days[0]}, 
						{v:1, label: days[1]}, 
						{v:2, label: days[2]},
						{v:3, label: days[3]},
						{v:4, label: days[4]},
						{v:5, label: days[5]},
						{v:6, label: days[6]},
						{v:7, label: days[7]},
						{v:8, label: days[8]},
						{v:9, label: days[9]},
						{v:10, label: days[10]},
						{v:11, label: days[11]},
						{v:12, label: days[12]},
						{v:13, label: days[13]}
					]
				}
			},
			legend:{
				style:{
					width: '120px',
					left: '660px'
				}
			},
			barOrientation: 'vertical'
		};
		var bar = new Plotr.BarChart('canvas_bar_'+id, options);
		bar.addDataset(dataset);
		bar.render();
	}
}