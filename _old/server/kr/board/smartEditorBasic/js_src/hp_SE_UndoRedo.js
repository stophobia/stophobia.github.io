//{
/**
 * @fileOverview This file contains Husky plugin that takes care of the operations related to Undo/Redo
 * @name hp_SE_UndoRedo.js
 */
nhn.husky.SE_UndoRedo = $Class({
	name : "SE_UndoRedo",
	requiredPlugin : ["SE_EditingAreaManager", "HuskyRangeManager"],
	actionHistory : null,
	// this may also be called, lastAdded/lastRetrieved
	oCurStateIdx : null,
	iMinimumSizeChange : 10,
	sBlankContentsForFF : "<br>",

	$init : function(){
		this.actionHistory = [];
		this.oCurStateIdx = {nIdx: 0, nStep: 0};
	},

	$PRECONDITION : function(){
		try{
			if(this.oApp.getEditingMode() != "WYSIWYG") return false;
		}catch(e){
			return false;
		}
		
		return true;
	},
	
	$BEFORE_MSG_APP_READY : function(){
		this._add_undo_history_at(this.oCurStateIdx, "", "", null);
	},

	$ON_MSG_APP_READY : function(){
		this.bFF = this.oApp.oNavigatorInfo.firefox;

		this.oApp.exec("DISABLE_UI", ["undo"]);
		this.oApp.exec("DISABLE_UI", ["redo"]);

		this.oApp.exec("REGISTER_UI_EVENT", ["undo", "click", "UNDO"]);
		this.oApp.exec("REGISTER_UI_EVENT", ["redo", "click", "REDO"]);
		
		this.oApp.exec("REGISTER_HOTKEY", ["ctrl+z", "UNDO"]);
		this.oApp.exec("REGISTER_HOTKEY", ["ctrl+y", "REDO"]);
	},

	$ON_UNDO : function(){
		var oTmpStateIdx = {};
		this._add_undo_history("KEYPRESS", false, false, true);
		if(this.oCurStateIdx.nIdx == 0) return;

		if(this.oCurStateIdx.nStep > 0){
			this.oCurStateIdx.nStep--;
		}else{
			var oTmpHistory = this.actionHistory[this.oCurStateIdx.nIdx];

			this.oCurStateIdx.nIdx--;

			if(oTmpHistory.nTotalSteps>1){
				this.oCurStateIdx.nStep = 0;
			}else{
				oTmpHistory = this.actionHistory[this.oCurStateIdx.nIdx];
				this.oCurStateIdx.nStep = oTmpHistory.nTotalSteps-1;
			}
		}

		this._retrieveHistory();
		if(this.oCurStateIdx.nIdx<=0) this.oApp.exec("DISABLE_UI", ["undo"]);
		this.oApp.exec("ENABLE_UI", ["redo"]);
		this.oApp.exec("CHECK_STYLE_CHANGE", []);
	},


	$ON_REDO : function(){
		if(this.oCurStateIdx.nIdx >= this.actionHistory.length) return;

		var oCurHistory = this.actionHistory[this.oCurStateIdx.nIdx];
		if(this.oCurStateIdx.nIdx == this.actionHistory.length-1 && this.oCurStateIdx.nStep >= oCurHistory.nTotalSteps-1) return;
		
		if(this.oCurStateIdx.nStep < oCurHistory.nTotalSteps-1){
			this.oCurStateIdx.nStep++;
		}else{
			this.oCurStateIdx.nIdx++;
			oCurHistory = this.actionHistory[this.oCurStateIdx.nIdx];
			this.oCurStateIdx.nStep = oCurHistory.nTotalSteps-1;
		}

		this._retrieveHistory();

		this.oApp.exec("ENABLE_UI", ["undo"]);
		// assumes an action may have up to two steps
		if(this.oCurStateIdx.nIdx >= this.actionHistory.length) this.oApp.exec("DISABLE_UI", ["redo"]);
		
		this.oApp.exec("CHECK_STYLE_CHANGE", []);
	},

	$ON_RECORD_UNDO_ACTION : function(sAction){
		this._add_undo_history(sAction);
	},

	$ON_RECORD_UNDO_ACTION_FORCED : function(sAction){
		this._add_undo_history(sAction, false, false, true);
	},

	$ON_RECORD_UNDO_BEFORE_ACTION : function(sAction){
		this._add_undo_history(sAction, true, true);
	},

	$ON_RECORD_UNDO_AFTER_ACTION : function(sAction){
		this._add_undo_history(sAction, true, false);
	},

	_retrieveHistory : function(){
		var oCurHistory = this.actionHistory[this.oCurStateIdx.nIdx];
		var sContent = oCurHistory.sContent[this.oCurStateIdx.nStep];
		var oBookmark = oCurHistory.oBookmark[this.oCurStateIdx.nStep];

		this.oApp.setIR(sContent, true);

		// setting the innerHTML may change the internal DOM structure, so save the value again.
		var sCurContent = this.oApp.getIR();
		if(this.bFF && sCurContent == this.sBlankContentsForFF){
			sCurContent = "";
		}
		oCurHistory.sContent[this.oCurStateIdx.nStep] = sCurContent;
		
		var oSelection = this.oApp.getEmptySelection();
		if(oSelection.selectionLoaded){
			if(oBookmark){
				oSelection.moveToXPathBookmark(oBookmark);
			}else{
				oSelection = this.oApp.getEmptySelection();
			}
			
			oSelection.select();
		}
	},

	_add_undo_history : function(sAction, bTwoStepAction, bBeforeAction, bForceAddUnlessEqual){
		bTwoStepAction = bTwoStepAction || false;
		bBeforeAction = bBeforeAction || false;
		bForceAddUnlessEqual = bForceAddUnlessEqual || false;
		
		// if we're in the middle of some action history, remove everything after current idx if any "little" change is made
		if(!(this.oCurStateIdx.nIdx == this.actionHistory.length-1)) bForceAddUnlessEqual = true;

		var oCurHistory = this.actionHistory[this.oCurStateIdx.nIdx];
		var sCurContent = this.oApp.getIR();
		var sHistoryContent = oCurHistory.sContent[this.oCurStateIdx.nStep];

		if(this.bFF && sCurContent == this.sBlankContentsForFF){
			sCurContent = "";
		}

		// every TwoStepAction needs to be recorded
		if(!bTwoStepAction){
			if(bForceAddUnlessEqual){
				if(sHistoryContent == sCurContent) return false;
			}else{
				if(Math.abs(sHistoryContent.length - sCurContent.length)<this.iMinimumSizeChange) return false;
			}
		}

		var oSelection = this.oApp.getSelection();
		
		var oBookmark=null;
		if(oSelection.selectionLoaded){
			oBookmark = oSelection.getXPathBookmark();
		}
		
		var oInsertionIdx = {nIdx:this.oCurStateIdx.nIdx, nStep:this.oCurStateIdx.nStep};
		if(bTwoStepAction){
			if(bBeforeAction){
				oInsertionIdx.nStep = 0;
			}else{
				oInsertionIdx.nStep = 1;
			}
		}else{
			oInsertionIdx.nStep = 0;
		}

		if(oInsertionIdx.nStep == 0 && this.oCurStateIdx.nStep == oCurHistory.nTotalSteps-1){
			oInsertionIdx.nIdx = this.oCurStateIdx.nIdx+1;
		}

		return this._add_undo_history_at(oInsertionIdx, sAction, sCurContent, oBookmark);
	},

	_add_undo_history_at : function(oInsertionIdx, sAction, sContent, oBookmark){
		if(oInsertionIdx.nStep != 0){
			this.actionHistory[oInsertionIdx.nIdx].nTotalSteps = oInsertionIdx.nStep+1;
			this.actionHistory[oInsertionIdx.nIdx].sContent[oInsertionIdx.nStep] = sContent;
			this.actionHistory[oInsertionIdx.nIdx].oBookmark[oInsertionIdx.nStep] = oBookmark;
		}else{
			var oNewHistory = {sAction:sAction, nTotalSteps: 1};
			oNewHistory.sContent = [];
			oNewHistory.sContent[0] = sContent;

			oNewHistory.oBookmark = [];
			oNewHistory.oBookmark[0] = oBookmark;
			this.actionHistory.splice(oInsertionIdx.nIdx, this.actionHistory.length - oInsertionIdx.nIdx, oNewHistory);
		}
		
		this.oCurStateIdx.nIdx = oInsertionIdx.nIdx;
		this.oCurStateIdx.nStep = oInsertionIdx.nStep;

		this.oApp.exec("ENABLE_UI", ["undo"]);
		this.oApp.exec("DISABLE_UI", ["redo"]);

		return true;
	}
});
//}