//{
/**
  * @fileOverview This file contains Husky plugin that takes care of the operations directly related to editing the HTML source code using Textarea element
 * @name hp_SE_EditingArea_HTMLSrc.js
 */
nhn.husky.SE_EditingArea_HTMLSrc = $Class({
	name : "SE_EditingArea_HTMLSrc",
	requiredPlugin : ["SE_EditingAreaManager"],

	sMode : "HTMLSrc",
	textarea : null,

	$init : function(textarea){
		this.textarea = $(textarea);
		this.elEditingArea = this.textarea;
	},

	$BEFORE_MSG_APP_READY : function(){
		this.oApp.exec("REGISTER_EDITING_AREA", [this.textarea]);
	},

	$ON_CHANGE_EDITING_MODE : function(sMode, bNoFocus){
		if(sMode == this.sMode){
			this.textarea.style.display = "block";
		}else{
			this.textarea.style.display = "none";
		}
	},
	
	$AFTER_CHANGE_EDITING_MODE : function(sMode, bNoFocus){
		if(!bNoFocus && sMode == this.sMode){
			this.focus();
		}
	},

	getIR : function(){
		var sIR;
		var sContent = this.textarea.value;

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

		this.textarea.value = sContent;
	},
	
	focus : function(){
		this.textarea.focus();
	}
});
//}