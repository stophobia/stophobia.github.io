//{
/**
 * @fileOverview This file contains Husky plugin that takes care of the operations related to resizing the editor and fitting of the iframe containing the editor
 * @name hp_SE_OuterIFrameControl.js
 */
nhn.husky.SE_OuterIFrameControl = $Class({
	name : "SE_OuterIFrameControl",
	oResizeGrip : null,

	$init : function(oAppContainer){
		this._assignHTMLObjects(oAppContainer);
		this.$FnMouseDown = $Fn(this._mousedown, this);
		this.$FnMouseMove = $Fn(this._mousemove, this);
		this.$FnMouseMove_Parent = $Fn(this._mousemove_parent, this);
		this.$FnMouseUp = $Fn(this._mouseup, this);

		this.$FnMouseDown.attach(this.oResizeGrip, "mousedown");
	},

	_assignHTMLObjects : function(oAppContainer){
		oAppContainer = $(oAppContainer) || document;

		this.oResizeGrip = cssquery.getSingle(".husky_seditor_editingArea_verticalResizer", oAppContainer);
		
		this.elIFrame = window.frameElement;
		this.welIFrame = $Element(this.elIFrame);
	},

	$ON_MSG_APP_READY : function(){
		this.oApp.exec("SE_FIT_IFRAME", []);
	},
	
	$ON_SE_FIT_IFRAME : function(){
		this.elIFrame.style.height = document.body.offsetHeight+"px";
	},
	
	$AFTER_RESIZE_EDITING_AREA_BY : function(ipWidthChange, ipHeightChange){
		this.oApp.exec("SE_FIT_IFRAME", []);
	},
	
	_mousedown : function(oEvent){
		this.iStartHeight = oEvent.pos().clientY;
		this.iStartHeightOffset = oEvent.pos().layerY;

		this.$FnMouseMove.attach(document, "mousemove");
		this.$FnMouseMove_Parent.attach(parent.document, "mousemove");
		
		this.$FnMouseUp.attach(document, "mouseup");		
		this.$FnMouseUp.attach(parent.document, "mouseup");

		this.iStartHeight = oEvent.pos().clientY;
		
		this.oApp.exec("MSG_EDITING_AREA_RESIZE_STARTED", [this.$FnMouseDown, this.$FnMouseMove, this.$FnMouseUp]);
	},

	_mousemove : function(oEvent){
		var iHeightChange = oEvent.pos().clientY - this.iStartHeight;
		this.oApp.exec("RESIZE_EDITING_AREA_BY", [0, iHeightChange]);
	},

	_mousemove_parent : function(oEvent){
		var iHeightChange = oEvent.pos().clientY - (this.welIFrame.offset().top + this.iStartHeight);
		this.oApp.exec("RESIZE_EDITING_AREA_BY", [0, iHeightChange]);
	},

	_mouseup : function(oEvent){
		this.$FnMouseMove.detach(document, "mousemove");
		this.$FnMouseMove_Parent.detach(parent.document, "mousemove");
		this.$FnMouseUp.detach(document, "mouseup");
		this.$FnMouseUp.detach(parent.document, "mouseup");

		this.oApp.exec("MSG_EDITING_AREA_RESIZE_ENDED", [this.$FnMouseDown, this.$FnMouseMove, this.$FnMouseUp]);
	}
});
//}