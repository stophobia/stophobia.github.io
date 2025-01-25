Trex.module("show button for action of table object", 
	function(editor, toolbar, sidebar, canvas, config) {
		var _removeTableNode = function(tableNode){
			$tom.remove(tableNode);
			canvas.history.saveHistory();
		}
		var typeArr = [
			{
				name:"layout delete",
				button: {
					height: 19,
					left:0,
					className: "tx-table-btn tx-table-remove",
					el: null
				},
				includeRule: "table.txc-layout-wz,table.txc-layout-tb",
				excludeRule: "",
				action: function(){
					if (_hoverdTableNode) {
						if (!confirm("레이아웃을 삭제하시겠습니까?")) {
							return false;
						}
						_removeTableNode(_hoverdTableNode);
					}
				}
			},{
				name:"table layout edit",
				button: {
					height: 23,
					left:0,
					className: "tx-table-btn tx-table-edit-layout",
					el: null
				},
				includeRule: "table",
				excludeRule: ['txc-layout-wz','txc-layout-tb', 'txc-layout-inner-table', 'tx-info-wrap-ie', 'txc-search'],
				action: function(tableNode){
					if (_hoverdTableNode) {
						new Trex.Menu.Table.TableEdit({
							editor: editor,
							table: _hoverdTableNode
						});
					}
					return false;
				}
			},{
				name:"table template edit",
				button: {
					height: 23,
					left:81,
					className: "tx-table-btn tx-table-edit-template",
					el: null
				},
				includeRule: "table",
				excludeRule: ['txc-layout-wz','txc-layout-tb', 'txc-layout-inner-table', 'tx-info-wrap-ie', 'txc-search'],
				action: function(tableNode){
					if (_hoverdTableNode) {
						var tableEdit = new Trex.Menu.Table.TableEdit({
							editor: editor,
							table: _hoverdTableNode
						});
						tableEdit.showMenu(2);
					}
					return false;
				}
			},{
				name:"table delete",
				button: {
					height: 19,
					left:163,
					className: "tx-table-btn tx-table-remove",
					el: null
				},
				includeRule: "table",
				excludeRule: ['txc-layout-wz','txc-layout-tb', 'txc-layout-inner-table', 'tx-info-wrap-ie', 'txc-search'],
				action: function(tableNode){
					if (_hoverdTableNode) {
						if (!confirm("테이블을 삭제하시겠습니까?")) {
							return false;
						}
						_removeTableNode(_hoverdTableNode);
					}
					return false;
				}
			}
		];
		
		var _iframeHeight = 0;
		var _iframeTop = 0;

		// 버튼의 위치를 계산하여 보여지는 위치에 있는 경우는 테이블과 관련된 버튼을 보여준다. 
		var _hoverdTableNode = null;
		var _findTableNode = function(node, includeRule, excludeRule){
			var findNode = $tom.find(node, includeRule);
			if ( !findNode ){
				return null;
			}
			 
			for (var i = 0; i < excludeRule.length; i++) {
				if ( $tx.hasClassName(findNode, excludeRule[i]) ){
					findNode = null;
					return findNode;
				}
			}
			return findNode;
		} 
		var _showButton = function(node) {
			if(!node) {
				return;
			}
			for( var i = 0; i < typeArr.length; i++ ){
				var btn = typeArr[i].button;
				var _tNode = _findTableNode(node, typeArr[i].includeRule, typeArr[i].excludeRule);
				_hoverdTableNode = _moveButton(_tNode, btn.el, {
					x: btn.left,
					y: btn.height
				});
				
			}
		};
		
		var _moveButton = function(selectedNode, elBtn, btnOffset){
			if(elBtn && selectedNode) {
				var _nodePos = canvas.getPositionByNode(selectedNode);
				if (_nodePos.width > 0 && _nodePos.height > 0 && _nodePos.y > 0 && _iframeHeight - _nodePos.y - btnOffset.y > 0) {
					$tx.setStyle(elBtn, { 
						top: (_nodePos.y - btnOffset.y + _iframeTop).toPx(), 
						left: (_nodePos.x + btnOffset.x).toPx()
					});
					$tx.show(elBtn);
					return selectedNode;
				}
			}
			
			$tx.hide(elBtn);
			return null;
		}

		canvas.observeJob(Trex.Ev.__CANVAS_HEIGHT_CHANGE, function(height) {
			_iframeHeight = height.parsePx();
		});
		
		//배경이 변경되면 위치를 수정한다.
		canvas.observeJob('canvas.apply.background', function() {
			var _wysiwygPanel = canvas.getPanel(Trex.Canvas.__WYSIWYG_MODE);
			var _position = $tom.getPosition(_wysiwygPanel.el);
			_iframeTop = _position.y;
		});
			
		// iframe이 로딩되면 버튼을 추가한다.
		canvas.reserveJob(Trex.Ev.__IFRAME_LOAD_COMPLETE, function() {
			var _wysiwygPanel = canvas.getPanel(Trex.Canvas.__WYSIWYG_MODE);
			_iframeHeight = _wysiwygPanel.getPanelHeight().parsePx();
			var _position = $tom.getPosition(_wysiwygPanel.el);
			_iframeTop = _position.y;
			
			var _elHolder = canvas.wysiwygEl;
			for( var i = 0; i < typeArr.length; i++ ){
				var type = typeArr[i];
				type.button.el = tx.a({ 
					'href': 'javascript:;',
					'className': type.button.className 
				}, type.name);				
				$tx.observe(type.button.el, 'click', function(action){
					return action;
				}(type.action), false);
				_elHolder.insertBefore(type.button.el, _elHolder.firstChild);
			}
		},300);
		
		// 스크롤 이벤트가 발생하면 버튼을 보여주는 함수를 호출한다.
//		canvas.observeJob(Trex.Ev.__CANVAS_PANEL_SCROLLING, function(ev) {
//			if(_hoverdTableNode) {
//				_showButton(_hoverdTableNode);
//			}
//		});
		
		// 마우스오버 이벤트가 발생하면 버튼을 보여주는 함수를 호출한다.
		canvas.observeJob(Trex.Ev.__CANVAS_PANEL_MOUSEOVER, function(ev) {
			var _node = $tx.element(ev);
			//같은 테이블이므로 표시하지 않는다.
			if (_hoverdTableNode != _node) {
				_showButton(_node);
			}
		});
	}
);
