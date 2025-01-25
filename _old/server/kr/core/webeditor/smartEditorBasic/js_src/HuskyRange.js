if(typeof window.nhn=='undefined') window.nhn = {};

/**
 * @fileOverview This file contains a cross-browser function that implements all of the W3C's DOM Range specification and some more
 * @name HuskyRange.js
 */
nhn.HuskyRange = $Class({
	setWindow : function(win){
		this._window = win;
		this._document = win.document;
	},

	$init : function(win){
		this.HUSKY_BOOMARK_START_ID_PREFIX = "husky_bookmark_start_";
		this.HUSKY_BOOMARK_END_ID_PREFIX = "husky_bookmark_end_";

		this.sBlockElement = "P|DIV|LI|H[1-6]|PRE";
		this.sBlockContainer = "BODY|TABLE|TH|TR|TD|UL|OL|BLOCKQUOTE|FORM";

		this.rxBlockElement = new RegExp("^("+this.sBlockElement+")$");
		this.rxBlockContainer = new RegExp("^("+this.sBlockContainer+")$")
		this.rxLineBreaker = new RegExp("^("+this.sBlockElement+"|"+this.sBlockContainer+")$")

		this.setWindow(win);

		this.oSimpleSelection = new nhn.SimpleSelection(this._window);
		this.selectionLoaded = this.oSimpleSelection.selectionLoaded;
		
		this.$super.$init(this._document);
	},

	select : function(){
		this.oSimpleSelection.selectRange(this);
	},

	setFromSelection : function(iNum){
		this.setRange(this.oSimpleSelection.getRangeAt(iNum));
	},

	setRange : function(oW3CRange){
		this.setStart(oW3CRange.startContainer, oW3CRange.startOffset);
		this.setEnd(oW3CRange.endContainer, oW3CRange.endOffset);
	},

	setEndNodes : function(oSNode, oENode){
		this.setEndAfter(oENode);
		this.setStartBefore(oSNode);
	},
	
	splitTextAtBothEnds : function(){
		this._splitTextEndNodesOfTheRange();
	},

	getStartNode : function(){
		if(this.collapsed){
			if(this.startContainer.nodeType == 3){
				if(this.startOffset == 0) return null;
				if(this.startContainer.nodeValue.length <= this.startOffset) return null;
				return this.startContainer;
			}
			return null;
		}
		
		if(this.startContainer.nodeType == 3){
			if(this.startOffset >= this.startContainer.nodeValue.length) return this._getNextNode(this.startContainer);
			return this.startContainer;
		}else{
			if(this.startOffset >= nhn.DOMFix.childNodes(this.startContainer).length) return this._getNextNode(this.startContainer);
			return nhn.DOMFix.childNodes(this.startContainer)[this.startOffset];
		}
	},
	
	getEndNode : function(){
		if(this.collapsed) return this.getStartNode();
		
		if(this.endContainer.nodeType == 3){
			if(this.endOffset == 0) return this._getPrevNode(this.endContainer);
			return this.endContainer;
		}else{
			if(this.endOffset == 0) return this._getPrevNode(this.endContainer);
			return nhn.DOMFix.childNodes(this.endContainer)[this.endOffset-1];
		}
	},

	getNodeAroundRange : function(bBefore, bStrict){
		if(this.collapsed && this.startContainer && this.startContainer.nodeType == 3) return this.startContainer;
		if(!this.collapsed || (this.startContainer && this.startContainer.nodeType == 3)) return this.getStartNode();

		var oBeforeRange, oAfterRange, oResult;

		if(this.startOffset >= nhn.DOMFix.childNodes(this.startContainer).length)
			oAfterRange = this._getNextNode(this.startContainer);
		else
			oAfterRange = nhn.DOMFix.childNodes(this.startContainer)[this.startOffset];

		if(this.endOffset == 0)
			oBeforeRange = this._getPrevNode(this.endContainer);
		else
			oBeforeRange = nhn.DOMFix.childNodes(this.endContainer)[this.endOffset-1];

		if(bBefore){
			oResult = oBeforeRange;
			if(!oResult && !bStrict) oResult = oAfterRange;
		}else{
			oResult = oAfterRange;
			if(!oResult && !bStrict) oResult = oBeforeRange;
		}

		return oResult;
	},

	_getXPath : function(elNode){
		var sXPath = "";
		
		while(elNode && elNode.nodeType == 1){
			sXPath = "/" + elNode.tagName+"["+this._getPosIdx4XPath(elNode)+"]" + sXPath;
			elNode = nhn.DOMFix.parentNode(elNode);
		}
		
		return sXPath;
	},
	
	_getPosIdx4XPath : function(refNode){
		var idx = 0;
		for(var node = refNode.previousSibling; node; node = node.previousSibling)
			if(node.tagName == refNode.tagName) idx++;

		return idx;
	},
	
	// this was written specifically for XPath Bookmark and it may not perform correctly for general purposes
	_evaluateXPath : function(sXPath, oDoc){
		sXPath = sXPath.substring(1, sXPath.length-1);
		var aXPath = sXPath.split(/\//);
		var elNode = oDoc.body;

		for(var i=2; i<aXPath.length && elNode; i++){
			aXPath[i].match(/([^\[]+)\[(\d+)/i);
			var sTagName = RegExp.$1;
			var nIdx = RegExp.$2;

			var aAllNodes = nhn.DOMFix.childNodes(elNode);
			var aNodes = [];
			var nLength = aAllNodes.length;
			var nCount = 0;
			for(var ii=0; ii<nLength; ii++){
				if(aAllNodes[ii].tagName == sTagName) aNodes[nCount++] = aAllNodes[ii];
			}

			if(aNodes.length < nIdx)
				elNode = null;
			else
				elNode = aNodes[nIdx];
		}

		return elNode;
	},

	_evaluateXPathBookmark : function(oBookmark){
		var sXPath = oBookmark["sXPath"];
		var nTextNodeIdx = oBookmark["nTextNodeIdx"];
		var nOffset = oBookmark["nOffset"];

		var elContainer = this._evaluateXPath(sXPath, this._document);

		if(nTextNodeIdx > -1 && elContainer){
			var aChildNodes = nhn.DOMFix.childNodes(elContainer);
			var elNode = null;
			
			var nIdx = nTextNodeIdx;
			var nOffsetLeft = nOffset;
			
			while((elNode = aChildNodes[nIdx]) && elNode.nodeType == 3 && elNode.nodeValue.length < nOffsetLeft){
				nOffsetLeft -= elNode.nodeValue.length;
				nIdx++;
			}
			
			elContainer = nhn.DOMFix.childNodes(elContainer)[nIdx];
			nOffset = nOffsetLeft;
		}

		if(!elContainer){
			elContainer = this._document.body;
			nOffset = 0;
		}
		return {elContainer: elContainer, nOffset: nOffset};
	},
	
	// this was written specifically for XPath Bookmark and it may not perform correctly for general purposes
	getXPathBookmark : function(){
		var nTextNodeIdx1 = -1;
		var htEndPt1 = {elContainer: this.startContainer, nOffset: this.startOffset};
		var elNode1 = this.startContainer;
		if(elNode1.nodeType == 3){
			htEndPt1 = this._getFixedStartTextNode();
			nTextNodeIdx1 = this._getPosIdx(htEndPt1.elContainer);
			elNode1 = nhn.DOMFix.parentNode(elNode1);
		}
		var sXPathNode1 = this._getXPath(elNode1);
		var oBookmark1 = {sXPath:sXPathNode1, nTextNodeIdx:nTextNodeIdx1, nOffset: htEndPt1.nOffset};
		
		var nTextNodeIdx2 = -1;
		var htEndPt2 = {elContainer: this.endContainer, nOffset: this.endOffset};
		var elNode2 = this.endContainer;
		if(elNode2.nodeType == 3){
			htEndPt2 = this._getFixedEndTextNode();
			nTextNodeIdx2 = this._getPosIdx(htEndPt2.elContainer);
			elNode2 = nhn.DOMFix.parentNode(elNode2);
		}
		var sXPathNode2 = this._getXPath(elNode2);
		var oBookmark2 = {sXPath:sXPathNode2, nTextNodeIdx:nTextNodeIdx2, nOffset: htEndPt2.nOffset};

		return [oBookmark1, oBookmark2];
	},
	
	moveToXPathBookmark : function(aBookmark){
		if(!aBookmark) return;

		var oBookmarkInfo1 = this._evaluateXPathBookmark(aBookmark[0]);
		var oBookmarkInfo2 = this._evaluateXPathBookmark(aBookmark[1]);

		if(!oBookmarkInfo1["elContainer"] || !oBookmarkInfo2["elContainer"]) return;

		this.startContainer = oBookmarkInfo1["elContainer"];
		this.startOffset = oBookmarkInfo1["nOffset"];

		this.endContainer = oBookmarkInfo2["elContainer"];
		this.endOffset = oBookmarkInfo2["nOffset"];
	},
	
	_getFixedTextContainer : function(elNode, nOffset){
		while(elNode && elNode.nodeType == 3 && elNode.previousSibling && elNode.previousSibling.nodeType == 3){
			nOffset += elNode.previousSibling.nodeValue.length;
			elNode = elNode.previousSibling;
		}
		
		return {elContainer:elNode, nOffset:nOffset};
	},
	
	_getFixedStartTextNode : function(){
		return this._getFixedTextContainer(this.startContainer, this.startOffset);
	},
	
	_getFixedEndTextNode : function(){
		return this._getFixedTextContainer(this.endContainer, this.endOffset);
	},
	
	placeStringBookmark : function(){
		var sTmpId = (new Date()).getTime();

		var oInsertionPoint = this.cloneRange();
		oInsertionPoint.collapseToEnd();
		var oEndMarker = this._document.createElement("A");
		oEndMarker.id = this.HUSKY_BOOMARK_END_ID_PREFIX+sTmpId;
		oInsertionPoint.insertNode(oEndMarker);

		var oInsertionPoint = this.cloneRange();
		oInsertionPoint.collapseToStart();
		var oStartMarker = this._document.createElement("A");
		oStartMarker.id = this.HUSKY_BOOMARK_START_ID_PREFIX+sTmpId;
		oInsertionPoint.insertNode(oStartMarker);

		this.moveToBookmark(sTmpId);

		return sTmpId;
	},

	cloneRange : function(){
		return this._copyRange(new nhn.HuskyRange(this._window));
	},

	moveToBookmark : function(vBookmark){
		if(typeof(vBookmark) != "object")
			this.moveToStringBookmark(vBookmark);
		else
			this.moveToXPathBookmark(vBookmark);
	},

	moveToStringBookmark : function(sBookmarkID){
		var oStartMarker = this._document.getElementById(this.HUSKY_BOOMARK_START_ID_PREFIX+sBookmarkID);
		var oEndMarker = this._document.getElementById(this.HUSKY_BOOMARK_END_ID_PREFIX+sBookmarkID);

		if(!oStartMarker || !oEndMarker) return;

		this.setEndBefore(oEndMarker);
		this.setStartAfter(oStartMarker);
	},

	removeStringBookmark : function(sBookmarkID){
		var oStartMarker = this._document.getElementById(this.HUSKY_BOOMARK_START_ID_PREFIX+sBookmarkID);
		var oEndMarker = this._document.getElementById(this.HUSKY_BOOMARK_END_ID_PREFIX+sBookmarkID);

		if(oStartMarker) nhn.DOMFix.parentNode(oStartMarker).removeChild(oStartMarker);
		if(oEndMarker) nhn.DOMFix.parentNode(oEndMarker).removeChild(oEndMarker);
	},

	collapseToStart : function(){
		this.collapse(true);
	},
	
	collapseToEnd : function(){
		this.collapse(false);
	},

	createAndInsertNode : function(sTagName){
		tmpNode = this._document.createElement(tagName);
		this.insertNode(tmpNode)
		return tmpNode
	},

	getNodes : function(bSplitTextEndNodes, fnFilter){
		if(bSplitTextEndNodes) this._splitTextEndNodesOfTheRange();

		var aAllNodes = this._getNodesInRange();
		var aFilteredNodes = [];

		if(!fnFilter) return aAllNodes;

		for(var i=0; i<aAllNodes.length; i++)
			if(fnFilter(aAllNodes[i])) aFilteredNodes[aFilteredNodes.length] = aAllNodes[i];

		return aFilteredNodes;
	},

	getTextNodes : function(bSplitTextEndNodes){
		var txtFilter = function(oNode){
			if (oNode.nodeType == 3 && oNode.nodeValue != "\n" && oNode.nodeValue != "")
				return true;
			else
				return false;
		}

		return this.getNodes(bSplitTextEndNodes, txtFilter);
	},

	surroundContentsWithNewNode : function(sTagName){
		var oNewParent = this._document.createElement(sTagName);
		this.surroundContents(oNewParent);
		return oNewParent;
	},

	isRangeinRange : function(oAnoterRange, bIncludePartlySelected){
		var startToStart = this.compareBoundaryPoints(this.START_TO_START, oAnoterRange);
		var startToEnd = this.compareBoundaryPoints(this.START_TO_END, oAnoterRange);
		var endToStart = this.compareBoundaryPoints(this.END_TO_START, oAnoterRange);
		var endToEnd = this.compareBoundaryPoints(this.END_TO_END, oAnoterRange);

		if(startToStart <= 0 && endToEnd >= 0) return true;

		if(bIncludePartlyIncluded){
			if(startToEnd == 1) return false;
			if(endToStart == -1) return false;
			return true;
		}

		return false;
	},

	isNodeInRange : function(oNode, bIncludePartlySelected, bContentOnly){
		var oTmpRange = new nhn.HuskyRange(this._window);

		if(bContentOnly && oNode.firstChild){
			oTmpRange.setStartBefore(oNode.firstChild);
			oTmpRange.setEndAfter(oNode.lastChild);
		}else{
			oTmpRange.selectNode(oNode);
		}

		return isRangeInRange(oTmpRange, bIncludePartlySelected);
	},		

	pasteHTML : function(sHTML){
		if(sHTML == ""){
			this.deleteContents();
			return;
		}
		
		var oTmpDiv = this._document.createElement("DIV");
		oTmpDiv.innerHTML = sHTML;

		var oFirstNode = oTmpDiv.firstChild;
		var oLastNode = oTmpDiv.lastChild;

		var clone = this.cloneRange();
		var sBM = clone.placeStringBookmark();

		while(oTmpDiv.lastChild) this.insertNode(oTmpDiv.lastChild);

		this.setEndNodes(oFirstNode, oLastNode);

		// delete the content later as deleting it first may mass up the insertion point
		// eg) <p>[A]BCD</p> ---paste O---> O<p>BCD</p>
		clone.moveToBookmark(sBM);
		clone.deleteContents();
		clone.removeStringBookmark(sBM);
	},
	
	toString : function(){
		this.toString = nhn.W3CDOMRange.prototype.toString;
		return this.toString();
	},
	
	toHTMLString : function(){
		var oTmpContainer = this._document.createElement("DIV");
		oTmpContainer.appendChild(this.cloneContents());

		return oTmpContainer.innerHTML;
	},

	findAncestorByTagName : function(sTagName){
		var oNode = this.commonAncestorContainer;
		while(oNode && oNode.tagName != sTagName) oNode = nhn.DOMFix.parentNode(oNode);
		
		return oNode;
	},

	selectNodeContents : function(oNode){
		if(!oNode) return;

		var oFirstNode = oNode.firstChild?oNode.firstChild:oNode;
		var oLastNode = oNode.lastChild?oNode.lastChild:oNode;

		if(oFirstNode.nodeType == 3)
			this.setStart(oFirstNode, 0);
		else
			this.setStartBefore(oFirstNode);
		
		if(oLastNode.nodeType == 3)
			this.setEnd(oLastNode, oLastNode.nodeValue.length);
		else
			this.setEndAfter(oLastNode);
	},

	styleRange : function(oStyle, oAttribute, sNewSpanMarker){
		var aStyleParents = this._getStyleParentNodes(sNewSpanMarker);
		if(aStyleParents.length < 1) return;

		var sName, sValue;

		for(var i=0; i<aStyleParents.length; i++){
			for(var x in oStyle){
				sName = x;
				sValue = oStyle[sName];

				if(typeof sValue != "string") continue;

				aStyleParents[i].style[sName] = sValue;
			}

			if(!oAttribute) continue;

			for(var x in oAttribute){
				sName = x;
				sValue = oAttribute[sName];

				if(typeof sValue != "string") continue;
				
				if(sName == "class"){
					$Element(aStyleParents[i]).addClass(sValue);
				}else{
					aStyleParents[i].setAttribute(sName, sValue);
				}
			}
		}

		this.setStartBefore(aStyleParents[0]);
		this.setEndAfter(aStyleParents[aStyleParents.length-1]);
	},

	_getStyleParentNodes : function(sNewSpanMarker){
		this._splitTextEndNodesOfTheRange();

		var oSNode = this.getStartNode();
		var oENode = this.getEndNode();

		var aAllNodes = this._getNodesInRange();
		var aResult = [];

		var oNode, iStartRelPos, iEndRelPos, oSpan, iSIdx, iEIdx;
		var nInitialLength = aAllNodes.length;
		for(var i=0; i<nInitialLength; i++){
			oNode = aAllNodes[i];

			if(!oNode) continue;
			if(oNode.nodeType != 3) continue;
			if(oNode.nodeValue == "") continue;

			if(nhn.DOMFix.parentNode(oNode).tagName == "SPAN"){
				// check if the SPAN element is fully contained
				iSIdx = $A(aAllNodes).indexOf(this._getVeryFirstRealChild(nhn.DOMFix.parentNode(oNode.parentNode)));
				iEIdx = $A(aAllNodes).indexOf(this._getVeryLastRealChild(nhn.DOMFix.parentNode(oNode)));

				if(iSIdx != -1 && iEIdx != -1){
					aResult[aResult.length] = nhn.DOMFix.parentNode(oNode);
					continue;
				}
			}

			oSpan = this._document.createElement("SPAN");
			nhn.DOMFix.parentNode(oNode).insertBefore(oSpan, oNode);
			oSpan.appendChild(oNode);
			aResult[aResult.length] = oSpan;
			aAllNodes[aAllNodes.length] = oSpan;
			
			if(sNewSpanMarker) oSpan.setAttribute(sNewSpanMarker, "true");
		}

		this.setStartBefore(oSNode);
		this.setEndAfter(oENode);

		return aResult;
	},
	
	_getVeryFirstChild : function(oNode){
		if(oNode.firstChild) return this._getVeryFirstChild(oNode.firstChild);
		return oNode;
	},

	_getVeryLastChild : function(oNode){
		if(oNode.lastChild) return this._getVeryLastChild(oNode.lastChild);
		return oNode;
	},

	_getFirstRealChild : function(oNode){
		var oFirstNode = oNode.firstChild;
		while(oFirstNode && oFirstNode.nodeType == 3 && oFirstNode.nodeValue == "") oFirstNode = oFirstNode.nextSibling;

		return oFirstNode;
	},
	
	_getLastRealChild : function(oNode){
		var oLastNode = oNode.lastChild;
		while(oLastNode && oLastNode.nodeType == 3 && oLastNode.nodeValue == "") oLastNode = oLastNode.previousSibling;

		return oLastNode;
	},
	
	_getVeryFirstRealChild : function(oNode){
		var oFirstNode = this._getFirstRealChild(oNode);
		if(oFirstNode) return this._getVeryFirstRealChild(oFirstNode);
		return oNode;
	},
	_getVeryLastRealChild : function(oNode){
		var oLastNode = this._getLastRealChild(oNode);
		if(oLastNode) return this._getVeryLastChild(oLastNode);
		return oNode;
	},

	_getLineStartInfo : function(node){
		var frontEndFinal = null;
		var frontEnd = node;
		var lineBreaker = node;
		var bParentBreak = true;

		var rxLineBreaker = this.rxLineBreaker;

		// vertical(parent) search
		function getLineStart(node){
			if(!node) return;
			if(frontEndFinal) return;

			if(rxLineBreaker.test(node.tagName)){
				lineBreaker = node;
				frontEndFinal = frontEnd;

				bParentBreak = true;

				return;
			}else{
				frontEnd = node;
			}

			getFrontEnd(node.previousSibling);

			if(frontEndFinal) return;
			getLineStart(nhn.DOMFix.parentNode(node));
		}

		// horizontal(sibling) search			
		function getFrontEnd(node){
			if(!node) return;
			if(frontEndFinal) return;

			if(rxLineBreaker.test(node.tagName)){
				lineBreaker = node;
				frontEndFinal = frontEnd;

				bParentBreak = false;
				return;
			}

			if(node.firstChild && node.tagName != "TABLE"){
				var curNode = node.lastChild;
				while(curNode && !frontEndFinal){
					getFrontEnd(curNode);
					
					curNode = curNode.previousSibling;
				}
			}else{
				frontEnd = node;
			}
			
			if(!frontEndFinal){
				getFrontEnd(node.previousSibling);
			}
		}
	
		getLineStart(node);
	
		return {oNode: frontEndFinal, oLineBreaker: lineBreaker, bParentBreak: bParentBreak};
	},

	_getLineEndInfo : function(node){
		var backEndFinal = null;
		var backEnd = node;
		var lineBreaker = node;
		var bParentBreak = true;

		var rxLineBreaker = this.rxLineBreaker;

		// vertical(parent) search
		function getLineEnd(node){
			if(!node) return;
			if(backEndFinal) return;
			
			if(rxLineBreaker.test(node.tagName)){
				lineBreaker = node;
				backEndFinal = backEnd;

				bParentBreak = true;

				return;
			}else{
				backEnd = node;
			}
	
			getBackEnd(node.nextSibling);
			if(backEndFinal) return;
	
			getLineEnd(nhn.DOMFix.parentNode(node));
		}
		
		// horizontal(sibling) search
		function getBackEnd(node){
			if(!node) return;
			if(backEndFinal) return;
			
			if(rxLineBreaker.test(node.tagName)){
				lineBreaker = node;
				backEndFinal = backEnd;

				bParentBreak = false;
				
				return;
			}

			if(node.firstChild && node.tagName != "TABLE"){
				var curNode = node.firstChild;
				while(curNode && !backEndFinal){
					getBackEnd(curNode);
					
					curNode = curNode.nextSibling;
				}
			}else{
				backEnd = node;
			}
	
			if(!backEndFinal){
				getBackEnd(node.nextSibling);
			}
		}
	
		getLineEnd(node);
	
		return {oNode: backEndFinal, oLineBreaker: lineBreaker, bParentBreak: bParentBreak};
	},

	getLineInfo : function(){
		var oSNode = this.getStartNode();
		var oENode = this.getEndNode();

		// the range is currently collapsed
		if(!oSNode) oSNode = this.getNodeAroundRange(true, true);
		if(!oENode) oENode = this.getNodeAroundRange(true, true);

		var oStart = this._getLineStartInfo(oSNode);
		var oStartNode = oStart.oNode;
		var oEnd = this._getLineEndInfo(oENode);
		var oEndNode = oEnd.oNode;

		var iRelativeStartPos = this._compareEndPoint(nhn.DOMFix.parentNode(oStartNode), this._getPosIdx(oStartNode), this.endContainer, this.endOffset);
		var iRelativeEndPos = this._compareEndPoint(nhn.DOMFix.parentNode(oEndNode), this._getPosIdx(oEndNode)+1, this.startContainer, this.startOffset);

		if(!(iRelativeStartPos <= 0 && iRelativeEndPos >= 0)){
			oSNode = this.getNodeAroundRange(false, true);
			oENode = this.getNodeAroundRange(false, true);
			oStart = this._getLineStartInfo(oSNode);
			oEnd = this._getLineEndInfo(oENode);
		}

		return {oStart: oStart, oEnd: oEnd};
	}
}).extend(nhn.W3CDOMRange);