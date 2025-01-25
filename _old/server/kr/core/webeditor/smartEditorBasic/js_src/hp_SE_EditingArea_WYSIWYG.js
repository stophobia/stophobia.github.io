//{
/**
 * @fileOverview This file contains Husky plugin that takes care of the operations directly related to WYSIWYG iframe
 * @name hp_SE_EditingArea_WYSIWYG.js
 */
nhn.husky.SE_EditingArea_WYSIWYG = $Class({
	name : "SE_EditingArea_WYSIWYG",
	status : nhn.husky.PLUGIN_STATUS["NOT_READY"],

	sMode : "WYSIWYG",
	iframe : null,
	doc : null,

	iLastUndoRecorded : 0,
	iMinUndoInterval : 3000,
	
	_nIFrameReadyCount : 50,
	
	$init : function(iframe){
		this.iframe = $(iframe);

		this.initIframe();
		
		this.elEditingArea = iframe;
	},

	$BEFORE_MSG_APP_READY : function(){
		this.oApp.exec("REGISTER_EDITING_AREA", [this.doc]);
		this.oApp.exec("ADD_APP_PROPERTY", ["getWYSIWYGWindow", $Fn(this.getWindow, this).bind()]);
		this.oApp.exec("ADD_APP_PROPERTY", ["getWYSIWYGDocument", $Fn(this.getDocument, this).bind()]);
	},

	$ON_MSG_APP_READY : function(){
		// uncomment this line if you wish to use the IE-style cursor in FF
		// this.getDocument().body.style.cursor = "text";

		if($Agent().navigator().ie){
			$Fn(
				function(weEvent){
					if(this.doc.selection.type.toLowerCase() == 'control' && weEvent.key().keyCode == 8)  {
						this.oApp.exec("EXECCOMMAND", ['delete', false, false]);
						weEvent.stop();
					}
				}, this
			).attach(this.doc, "keydown");
		}
	},
	
	$ON_CHANGE_EDITING_MODE : function(sMode, bNoFocus){
		if(sMode == this.sMode){
			this.iframe.style.display = "block";

			this.oApp.exec("REFRESH_WYSIWYG", []);
			this.oApp.exec("SET_EDITING_WINDOW", [this.getWindow()]);
		}else{
			this.iframe.style.display = "none";
		}
	},

	$AFTER_CHANGE_EDITING_MODE : function(sMode, bNoFocus){
		if(!bNoFocus && sMode == this.sMode){
			this.focus();
		}
	},

	$ON_REFRESH_WYSIWYG : function(){
		// FF3 bug fix
		// need to re-assign contentEditable = true after the iframe went from display="none"  to display="block"
		if(this.doc.body.contentEditable){
			this.doc.body.contentEditable = false;
			this.doc.body.contentEditable = true;
		}
	},
	
	$ON_ENABLE_WYSIWYG : function(){
		this._enableWYSIWYG();
	},

	$ON_DISABLE_WYSIWYG : function(){
		if (this.doc.body.contentEditable){
			this.doc.body.contentEditable = false;
		} else {
			this.doc.designMode = "off";
		}
	},
	
	$ON_EVENT_EDITING_AREA_KEYUP : function(oEvent){
		var oKeyInfo = oEvent.key();

		// 33, 34: page up/down, 35,36: end/home, 37,38,39,40: left, up, right, down
		if(oKeyInfo.keyCode == 229 || oKeyInfo.enter || oKeyInfo.alt || oKeyInfo.ctrl || (oKeyInfo.keyCode >= 33 && oKeyInfo.keyCode <= 40) || oKeyInfo.keyCode == 16) return;
		this._recordUndo(oKeyInfo)
	},
	
	$ON_PASTE_HTML : function(sHTML, oPSelection){
		var oSelection = oPSelection || this.oApp.getSelection();
		oSelection.pasteHTML(sHTML);
		
		// every browser except for IE may modify the innerHTML when it is inserted
		if(!$Agent().navigator().ie){
			var sTmpBookmark = oSelection.placeStringBookmark();
			this.oApp.getWYSIWYGDocument().body.innerHTML = this.oApp.getWYSIWYGDocument().body.innerHTML;
			oSelection.moveToBookmark(sTmpBookmark);
			oSelection.collapseToEnd();
			oSelection.select();
			oSelection.removeStringBookmark(sTmpBookmark);
		}

		this.oApp.exec("RECORD_UNDO_ACTION", ["INSERT HTML"]);
	},

	initIframe : function(){
		try {
			this.doc = this.iframe.contentWindow.document;
			if (this.doc == null || this.doc.location.href == 'about:blank') {
				throw new Error('Access denied');
			}

			this._enableWYSIWYG();

			this.status = nhn.husky.PLUGIN_STATUS["READY"];
		} catch(e) {
			if(this._nIFrameReadyCount-- > 0){
				setTimeout($Fn(this.initIframe, this).bind(), 100);
			}else{
				throw("iframe for WYSIWYG editing mode can't be initialized. Please check if the iframe document exists and is also accessable(cross-domain issues). ");
			}
		}
	},

	getIR : function(){
		var sContent = this.doc.body.innerHTML;
		var sIR;

		if(this.oApp.applyConverter)
			sIR = this.oApp.applyConverter(this.sMode+"_TO_IR", sContent);
		else
			sIR = sContent;

		return sIR;
	},

	setIR : function(sIR){
		var sContent;
		if(this.oApp.applyConverter)
			sContent = this.oApp.applyConverter("IR_TO_"+this.sMode, sIR);
		else
			sContent = sIR;

		this.doc.body.innerHTML = sContent;
		
		if(this.oApp.oNavigatorInfo.firefox){
			if(this.doc.body.innerHTML == "") this.doc.body.innerHTML = "<br>";
		}
	},

	getWindow : function(){
		return this.iframe.contentWindow;
	},

	getDocument : function(){
		return this.iframe.contentWindow.document;
	},
	
	focus : function(){
		this.getWindow().focus();
	},
	
	_recordUndo : function(oKeyInfo){
		var curTime = new Date();
		if(curTime-this.iLastUndoRecorded < this.iMinUndoInterval) return;
		this.oApp.exec("RECORD_UNDO_ACTION", ["KEYPRESS"]);

		this.iLastUndoRecorded = new Date();

		this.prevKeyCode = oKeyInfo.keyCode;
	},
	
	_enableWYSIWYG : function(){
		if (this.doc.body.contentEditable){
			this.doc.body.contentEditable = true;
		} else {
			this.doc.designMode = "on";
		}
	}
});
//}