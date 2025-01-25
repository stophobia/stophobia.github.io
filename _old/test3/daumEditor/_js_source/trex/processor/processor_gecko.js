Trex.I.Processor.Gecko = {
	/**
	 * Paragraph 를 채운다.
 	 * @private
 	 * @param {Node} node - paragraph 노드
	 */
	stuffNode: function(node) {
		if($tom.hasChildren(node, true)) {
			return node;
		}
		return $tom.html(node, "&nbsp;<br/>");
	},
	/**
	 * @private
	 * @memberOf Trex.Canvas.ProcessorP
	 * Gecko에서 newlinepolicy가 p일 경우 Enter Key 이벤트가 발생하면 실행한다. 
	 * @param {Event} ev - Enter Key 이벤트
	 */
	controlEnterByParagraph: function(ev) {
		var _bNode = this.findNode('%paragraph,%wrapper');
		if ($tom.kindOf(_bNode, 'p,li,td,th,dd,dt')) { 
			throw $propagate;
		}
		
		var _processor = this;
		var _btnNode = this.findNode("button");
		if(_btnNode) {
			_processor.moveCaretTo($tom.next(_btnNode));
			throw $propagate;
		}
		
		this.execWithMarker(function(marker) {
			var _dvNode = _processor.stuffNode(_processor.newNode('p'));
			$tom.insertAt(_dvNode, marker.endMarker);
			_processor.restoreScrollTop(_dvNode);
			_processor.moveCaretTo(_dvNode);
		});
	},
	/**
	 * @private
	 * @memberOf Trex.Canvas.ProcessorBR
	 * Gecko에서 newlinepolicy가 br일 경우 Enter Key 이벤트가 발생하면 실행한다. 
	 * @param {Event} ev - Enter Key 이벤트
	 */
	controlEnterByLinebreak: function(ev) {
		throw $propagate;
	}
};
	
