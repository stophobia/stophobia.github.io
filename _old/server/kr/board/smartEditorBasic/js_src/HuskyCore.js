if(typeof window.nhn=='undefined') window.nhn = {};
if (!nhn.husky) nhn.husky = {};

 //{
 /**
 * @fileOverview This file contains Husky framework core
 * @name HuskyCore.js
 */
nhn.husky.HuskyCore = $Class({
	name : "HuskyCore",

	plugins : null,
	aOrderedPlugins : null,

	oCommandMap : null,
	oDisabledCommand : null,

	// To prevent processing a Husky command before all the plugins are registered and ready,
	// Queue up all the commands here until the application's status is changed to READY
	commandQueue : [],

	$init : function(){
		this.plugins = {};
		this.oCommandMap = {};
		this.oDisabledCommand = {};
		this.aOrderedPlugins = [];

		this.oAgentInfo = $Agent();
		this.oNavigatorInfo = this.oAgentInfo.navigator();

		this.appStatus = nhn.husky.APP_STATUS["NOT_READY"];

		// Register the core as a plugin so it will receive the commands
		this.registerPlugin(this);
	},

	exec : function(cmd, args, oEvent){
		// If the application is not yet ready and it is not trying to change the application's status, just queue the command
		if(this.appStatus == nhn.husky.APP_STATUS["NOT_READY"] && cmd != "CHANGE_APP_STATUS"){
			this._queueAppCommand(cmd, args, oEvent);
			return true;
		}

		this.exec = this._exec;
		this.exec(cmd, args, oEvent);
	},

	delayedExec : function(cmd, args, nDelay, oEvent){
		var fExec = $Fn(this.exec, this).bind(cmd, args, oEvent);
		setTimeout(fExec, nDelay);
	},
	
	_exec : function(cmd, args, oEvent){
		if(this.oDisabledCommand[cmd]) return false;

		var allArgs = [];
		if(args && args.length){
			var iLen = args.length;
			for(var i=0; i<iLen; i++) allArgs[i] = args[i];
		}
		if(oEvent) allArgs[allArgs.length] = oEvent;

		var bContinue = true;
		bContinue = this._execAppCommand("$BEFORE_"+cmd, allArgs);
		if(bContinue) bContinue = this._execAppCommand("$ON_"+cmd, allArgs);
		if(bContinue) bContinue = this._execAppCommand("$AFTER_"+cmd, allArgs);

		return bContinue;
	},

	registerPlugin : function(oPlugin){
		if(!oPlugin) throw("Invalid plugin cannot be registered");
		if(!oPlugin.name) throw("Plugin.name is required");
		
		var bSupportedBrowser = true;
		if(oPlugin.supportedBrowser){
			bSupportedBrowser = false;
			for(var i=0; i<oPlugin.supportedBrowser.length; i++){
				if(this.oNavigatorInfo[oPlugin.supportedBrowser[i]]){
					bSupportedBrowser = true;
					break;
				}
			}

			if(!bSupportedBrowser){
				this.exec("MSG_PLUGIN_REJECTED", [oPlugin]);
				return;
			}
		}

		if(oPlugin.unsupportedBrowser){
			for(var i=0; i<oPlugin.unsupportedBrowser.length; i++){
				if(this.oNavigatorInfo[oPlugin.unsupportedBrowser[i]]){
					this.exec("MSG_PLUGIN_REJECTED", [oPlugin]);
					return;
				}
			}
		}

		this.plugins[oPlugin.name] = oPlugin;
		this.aOrderedPlugins[this.aOrderedPlugins.length] = oPlugin;

		oPlugin.oApp = this;

		// If the plugin does not specify that it takes time to be ready, change the stauts to READY right away
		if(oPlugin.status != nhn.husky.PLUGIN_STATUS["NOT_READY"]) oPlugin.status = nhn.husky.PLUGIN_STATUS["READY"];

		this.exec("MSG_PLUGIN_REGISTERED", [oPlugin]);
	},

	registerBrowserEvent : function(obj, sEvent, sCMD, aParams){
		aParams = aParams || [];
		var func = $Fn(this.exec, this).bind(sCMD, aParams);
		$Fn(func, this).attach(obj, sEvent);
	},

	stopBrowserEvent : function(obj, sEvent){
		$Fn(function(we){we.stop();}, this).attach(obj, sEvent);
	},

	run : function(funcOnReady){
		// Change the status from NOT_READY to let exec to process all the way
		this.exec("CHANGE_APP_STATUS", [nhn.husky.APP_STATUS["WAITING_FOR_PLUGIN_READY"]]);

		// Check if all the required plugins are registered
		for(var x in this.plugins){
			if(this.plugins[x].requiredPlugin){
				for(var y in this.plugins[x].requiredPlugin){
					if(!this.plugins[this.plugins[x].requiredPlugin[y]]){
						var sMsg = this.plugins[x].name+" requires " + this.plugins[x].requiredPlugin[y] + " plugin";
						throw(sMsg);
					}
				}
			}
		}

		// Process all the commands in the queue
		var iQueueLength = this.commandQueue.length;
		for(i=0; i<iQueueLength; i++){
			var curCmdAndArgs = this.commandQueue[i];
			this.exec(curCmdAndArgs.cmd, curCmdAndArgs.args, curCmdAndArgs.event);
		}

		this._waitForPluginReady(funcOnReady);
	},

	$ON_ADD_APP_PROPERTY : function(sPropertyName, oProperty){
		this[sPropertyName] = oProperty;
	},
	$ON_CHANGE_APP_STATUS : function(appStatus, funcOnReady){
		this.appStatus = appStatus;

		// Initiate MSG_APP_READY if the application's status is being switched to READY
		if(this.appStatus == nhn.husky.APP_STATUS["READY"]) this.exec("MSG_APP_READY", [funcOnReady]);
	},

	$AFTER_MSG_APP_READY : function(funcOnReady){
		this.oApp.exec("EXEC_INITIALIZER", [funcOnReady]);
	},

	$ON_DISABLE_COMMAND : function(sCommand){
		this.oDisabledCommand[sCommand] = true;
	},

	$ON_ENABLE_COMMAND : function(sCommand){
		this.oDisabledCommand[sCommand] = false;
	},

	$ON_EXEC_INITIALIZER : function(funcOnReady){
		if(typeof funcOnReady == "function") funcOnReady();
	},

	_execAppCommand : function(sCmdHandler, args){
		if(!this.oCommandMap[sCmdHandler]){
			this.createCommandMap(sCmdHandler);
		}

		var aPlugins = this.oCommandMap[sCmdHandler];
		var iNumOfPlugins = aPlugins.length;

		var tmpStatus;

		// two similar codes were written twice due to the performace.
		if(sCmdHandler.match(/^\$(BEFORE|ON|AFTER)_MSG_APP_READY$/)){
			for(var i=0; i<iNumOfPlugins; i++){
				tmpStatus = aPlugins[i][sCmdHandler].apply(aPlugins[i], args);
				if(tmpStatus === false) return false;
			}
		}else{
			for(var i=0; i<iNumOfPlugins; i++){
				if(typeof aPlugins[i]["$PRECONDITION"] == "function") if(!aPlugins[i]["$PRECONDITION"].call(aPlugins[i], sCmdHandler, args)) continue;
				
				tmpStatus = aPlugins[i][sCmdHandler].apply(aPlugins[i], args);
				if(tmpStatus === false) return false;
			}
		}
		return true;
	},
	
	// Use this also to update the mapping
	createCommandMap : function(sCmdHandler){
		this.oCommandMap[sCmdHandler] = [];

		var nLen = this.aOrderedPlugins.length;
		var oPlugin;
		for(var i=0; i<nLen; i++){
			oPlugin = this.aOrderedPlugins[i];
			if(typeof oPlugin[sCmdHandler] == "function") this.oCommandMap[sCmdHandler][this.oCommandMap[sCmdHandler].length] = oPlugin;
		}
	},

	_queueAppCommand : function(cmd, args, oEvent){
		this.commandQueue[this.commandQueue.length] = {'cmd':cmd, 'args':args, 'event':oEvent};
	},

	_waitForPluginReady : function(funcOnReady){
		var bAllReady = true;
		for(x in this.plugins){
			if(this.plugins[x].status == nhn.husky.PLUGIN_STATUS["NOT_READY"]){
				bAllReady = false;
				break;
			}
		}
		if(bAllReady){
			this.exec("CHANGE_APP_STATUS", [nhn.husky.APP_STATUS["READY"], funcOnReady]);
		}else{
			setTimeout($Fn(this._waitForPluginReady, this).bind(funcOnReady), 100);
		}
	}
});
//}

nhn.husky.APP_STATUS = {
	'NOT_READY' : 0,
	'WAITING_FOR_PLUGIN_READY' : 1,
	'READY' : 2
};

nhn.husky.PLUGIN_STATUS = {
	'NOT_READY' : 0,
	'READY' : 1
};
