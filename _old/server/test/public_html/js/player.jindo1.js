var Rollover = {
 
	_setSrc :   function(oEl,   sSrc)   {
		if (!oEl.disabled) {
			oEl.src =   sSrc;
		}
	},
	
	set :   function(oEl,   oSrcs, pCallback) {
		
		if (!oEl)   return;
 
		var sOrgSrc =   oEl.src;
		
		oEl.setOver =   function() {
			if (this.callback && !this.callback()) return;
			Rollover._setSrc(this, oSrcs.over);
		}.bind(oEl);
		
		oEl.setOut = function() {
			if (this.callback && !this.callback()) return;
			Rollover._setSrc(this, sOrgSrc);
		}.bind(oEl);
 
		oEl.setDown =   function() {
			if (this.callback && !this.callback()) return;
			Rollover._setSrc(this, oSrcs.down);
		}.bind(oEl);
 
		oEl.setUp   =   function() {
			if (this.callback && !this.callback()) return;
			Rollover._setSrc(this, oSrcs.over   || sOrgSrc);
		}.bind(oEl);
		
		oEl.callback = pCallback;
 
		if (oSrcs.over) {
			Event.register(oEl, "mouseover", oEl.setOver);
			Event.register(oEl, "mouseout", oEl.setOut);
		}
 
		if (oSrcs.down) {
			Event.register(oEl, "mousedown", oEl.setDown);
			Event.register(oEl, "mouseup", oEl.setUp);
		}
	}
 
};
 
Function.prototype.sliently = function(pThis) {
	
	var pFunc = this;
	
	return function() {
		
		var oRet;
		try { oRet = pFunc.apply(pThis, arguments); } catch(e) { }
		
		return oRet;
		
	};
	
};
 
// 참고 :   http://msdn2.microsoft.com/en-gb/library/aa392418.aspx
 
var Cplayer =   Class({
 
	_prefix :   "/img/",
	_current_file_name : null,
	
	_sId : null,
	_o : null,
	
	_options : null,
	
	_toObjects : function(oObject) {
 
		var oRetval =   {   };
		var vVal;
 
		for (var sKey   in oObject) {
 
			vVal = oObject[sKey];
			
			if (typeof vVal == "string") {
				oRetval[sKey]   =   $(vVal) || vVal;
			}   else if (typeof vVal == "object")   {
				oRetval[sKey]   =   this._toObjects(vVal);
			}   else {
				oRetval[sKey]   =   vVal;
			}
 
		}
		
		return oRetval;
	},
 
	_setImageRollOver : function() {
		
		this.initialize();
 
		Rollover.set(this._o.controls.grap.playing.firstChild, {
			down : this._prefix +   "media_img_13.jpg"
		}, this._getEnable.owner(this));
		
		// TODO :   small   에서만 필요
		Rollover.set(this._o.controls.grap.volume.firstChild,   {
			down : this._prefix +   "media_img_13.jpg"
		});
		
		Rollover.set(this._o.controls.play, {
			over : this._prefix +   "media_img_08.jpg",
			down : this._prefix +   "media_img_08.jpg"
		});
		
		Rollover.set(this._o.controls.pause, {
			over : this._prefix +   "media_img_09.jpg",
			down : this._prefix +   "media_img_09.jpg"
		});
		
		Rollover.set(this._o.controls.stop, {
			over : this._prefix +   "media_img_10.jpg",
			down : this._prefix +   "media_img_10.jpg"
		});
		
		Rollover.set(this._o.controls.fullscreen,   {
			over : this._prefix +   "playerbtn_pull_on02.gif",
			down : this._prefix +   "playerbtn_pull_down02.gif"
		});
			
/*
			Rollover.set(this._o.buttons.scrap, {
					over : "http://imgnews.naver.com/image/sports/media/player/playerbtn_put_on.gif",
					down : "http://imgnews.naver.com/image/sports/media/player/playerbtn_put_down.gif"
			});
*/
 
	},
 
	_ignoreError : function(fFunc) {
 
		var aArg = $A(arguments);
		aArg.shift();
 
		try {
			fFunc.apply(this,   aArg);
		}   catch(e) { }
	},
 
	_showSoundPanel :   function(bFlag) {
			
		var func = bFlag ? Element.removeClass : Element.addClass;
		func.sliently(Element)(this._o.panels.sound, "hide");
	},
 
	_over   :   {
		sound   :   false
	},
 
	_hidePanels :   function() {
 
		if (!this._over.sound) {
			Element.addClass.sliently(Element)(this._o.panels.sound, "hide");
			this._over.sound = false;
		}
		
	},
 
	_setEvent   :   function() {
		
		var self = this;
 
		this._o.blind.onclick   =   this._ignoreError.bind(this, this.play);
		
		with (this._o.controls) {
				if (this._o.controls.play) play.onclick =   this._ignoreError.bind(this, this.play);
				if (this._o.controls.pause) pause.onclick   =   this._ignoreError.bind(this, this.pause);
				if (this._o.controls.stop) stop.onclick =   this._ignoreError.bind(this, this.stop);
				if (this._o.controls.fullscreen) fullscreen.onclick =   this._ignoreError.bind(this, this.setFullScreen, true);
		}
 
		with (this._o.buttons) {
				if (this._o.buttons.sound) {
					sound.onclick = function() {
						if (self._getEnable()) self._showSoundPanel(true);
					};
				}
		}
 
		with (this._o.panels)   {
				if (this._o.panels.sound)   sound.onmouseover   =   function() { this._over.sound   =   true;   }.bind(this);
				if (this._o.panels.sound)   sound.onmouseout = function()   {   this._over.sound = false;   }.bind(this);
		}
 
		Event.register(document, "mousedown",   this._hidePanels.bind(this));    
	},
 
	_trackSize : {
			playing :   0,
			volume : 0
	},
 
	_dragTimeInfo   :   null,
	_dragSoundInfo : null,
 
	_setTrackEvents :   function() {
 
			with (this) {
					
					_showSoundPanel(true);
					
					_trackSize.playing = _o.controls.grap.playing.parentNode.clientWidth;
					_trackSize.volume   =   _o.controls.grap.volume.parentNode.clientHeight;
					
					_hidePanels();
 
					// 불륨판넬의   스피커 그림 클릭
					this._o.panels.sound.onclick = function(oEvent) {
							
							// 클릭한   부분이 스피커   그림이 있는 부분 (이 부분은 볼륨판넬의 디자인이 바뀔때마다 고쳐야함)
							if (oEvent.layer_y  >= 65   && oEvent.layer_y <=    75) {
									this.setMute(!this.getMute());
									this._applyMute();
							}
							
					}.bindForEvent(this);
	
					_setPlayingTrackEvents();
					_setVolumeTrackEvents();
			}
	},
 
	_setPlayingTrackEvents : function() {
 
			// 드래그   시작
			this._o.controls.track.playing.onmousedown = function(oEvent,   oGrap) {
				
							if (!this._getEnable()) return;
					
					var nLeftPx =   oEvent.layer_x;
 
					if (nLeftPx <   0) nLeftPx = 0;
					if (nLeftPx >   this._trackSize.playing) nLeftPx = this._trackSize.playing;
 
					this._dragTimeInfo = {
							dragLeft : oEvent.page_x - nLeftPx
					};
					
					oGrap.style.left = nLeftPx + "px";
					this._hidePanels();
 
					oGrap.firstChild.setDown();
					Event.stop(oEvent);
 
			}.bindForEvent(this, this._o.controls.grap.playing);
 
			// 드래깅
			Event.register(document, "mousemove",   function(oEvent, oGrap) {
					
					if (!this._dragTimeInfo) return;
					
					var nLeftPx =   oEvent.page_x   -   this._dragTimeInfo.dragLeft;
					
					if (nLeftPx <   0) nLeftPx = 0;
					if (nLeftPx >   this._trackSize.playing) nLeftPx = this._trackSize.playing;
					
					oGrap.style.left = nLeftPx + "px";
					
					Event.stop(oEvent);
					
			}.bindForEvent(this, this._o.controls.grap.playing));
 
			// 드래그   끝
			Event.register(document, "mouseup", function(oEvent, oGrap) {
					if (!this._dragTimeInfo) return;
					
					this._dragTimeInfo = null;
					
					var left = oGrap.style.left;
					this.setPosition(this._getTimelineLeftAs(left, "sec"));
 
					oGrap.firstChild.setUp();
					Event.stop(oEvent);
 
			}.bindForEvent(this, this._o.controls.grap.playing));
 
			// 드래그   시작
			this._o.controls.grap.playing.onmousedown   =   function(oEvent, oGrap) {
 
							if (!this._getEnable()) return;
					
					this._dragTimeInfo = {
							dragLeft : oEvent.page_x - parseInt(oGrap.style.left)
					};
 
					this._hidePanels();
					Event.stop(oEvent);
 
			}.bindForEvent(this, this._o.controls.grap.playing);
 
	},
 
	_setVolumeTrackEvents   :   function() {
			
			// 드래그   시작
			this._o.controls.track.volume.onmousedown   =   function(oEvent, oGrap) {
 
					var nBasePx =   oEvent.layer_y;
					
					if (nBasePx <   0) nBasePx = 0;
					if (nBasePx >   this._trackSize.volume) nBasePx =   this._trackSize.volume;
 
					this._dragSoundInfo =   {
							dragBase : oEvent.page_y - nBasePx
					};
					
					oGrap.style.top =   nBasePx -   2   +   "px";
					this._o.displays.bar.volume.style.height = this._trackSize.volume   -   nBasePx +   "px";
					
					this.setVolume((this._trackSize.volume - nBasePx)   *   2);
					this._applyMute();
 
					this._hidePanels();
 
					oGrap.firstChild.setDown();
					Event.stop(oEvent);
 
			}.bindForEvent(this, this._o.controls.grap.volume);
 
			// 드래깅
			Event.register(document, "mousemove",   function(oEvent, oGrap) {
					
					if (!this._dragSoundInfo)   return;
					
					var nBasePx =   oEvent.page_y   -   this._dragSoundInfo.dragBase;
					
					if (nBasePx <   0) nBasePx = 0;
					if (nBasePx >   this._trackSize.volume) nBasePx =   this._trackSize.volume;
 
					oGrap.style.top =   nBasePx -   2   +   "px";
					this._o.displays.bar.volume.style.height = this._trackSize.volume   -   nBasePx +   "px";
					
					this.setVolume((this._trackSize.volume - nBasePx)   *   2);
					this._applyMute();
					
					Event.stop(oEvent);
					
			}.bindForEvent(this, this._o.controls.grap.volume));
 
			// 드래그   끝
			Event.register(document, "mouseup", function(oEvent, oGrap) {
					if (!this._dragSoundInfo)   return;
					this._dragSoundInfo =   null;
 
					oGrap.firstChild.setUp();
					Event.stop(oEvent);
 
			}.bindForEvent(this, this._o.controls.grap.volume));
 
			// 드래그   시작
			this._o.controls.grap.volume.onmousedown = function(oEvent, oGrap) {
 
					this._dragSoundInfo =   {
							dragBase : oEvent.page_y - parseInt(oGrap.style.top) - 2
					};
 
					this._hidePanels();
					Event.stop(oEvent);
 
			}.bindForEvent(this, this._o.controls.grap.volume);
 
	},
 
	_duration   :   null,
 
	_startTimer :   function() {
			this._stopTimer();
			this._timer =   window.setInterval(this._applyInterval.bind(this), 500);
	},
	
	_stopTimer : function() {
			if (this._timer) window.clearInterval(this._timer);
			this._timer =   null;
	},
 
	_onPageLoad :   function(oObject)   {
		
		this.initialize();
 
		with (this) {
				
			if (window.navigator.userAgent.indexOf("MSIE") ==   -1)
					return;
			
			_setImageRollOver();
			_setEvent();
			_setTrackEvents();
 
			_setEnable(); // ADDED
 
			play();
		}
		
		this._applyMute();
 
		// alert(this._o.displays.time.current);
 
	},
		
		_bPlaying   :   false,
 
		_applyState :   function(nState) {
			
			var oOptions = this._options.options;
			
			if (typeof oOptions.onPlayStateChange == 'function') {
				oOptions.onPlayStateChange.call(this, nState);
			}
 
			var self = this;
 
			// 이유 모를 버그 수정
			Element.setCSS(this._o.player, { height : this._o.height + "px" });
 
				switch (nState) {
				case 9: // Transitioning
				case 6: // Buffering
						Element.removeClass.sliently(Element)(this._o.displays.loading, "hide");
						break;
						
				case 10: // Error?
						//this._showVideo(false);
						// non break;
 
				case 1: // Stopped
						this._bPlaying = false;
 
						Element.addClass.sliently(Element)(this._o.controls.pause, "hide");
						Element.removeClass.sliently(Element)(this._o.controls.play, "hide");
						Element.addClass.sliently(Element)(this._o.displays.loading, "hide");
 //                     this._showVideo(false);
 
						this._stopTimer();
						break;
						
				case 2: // Paused
						Element.addClass.sliently(Element)(this._o.controls.pause, "hide");
						Element.removeClass.sliently(Element)(this._o.controls.play, "hide");
 
						this._stopTimer();
						break;
						
				case 3: // Playing
 
					setTimeout(function() {
						self._applyFullScreen();
					}, 1);
 
						if (this._duration ==   null)   {
 
								this._duration = this.getDuration();
								
								this._applyTime();
								Element.addClass.sliently(Element)(this._o.displays.loading, "hide");
								
								this.stop();
								this.setVolume(50);
								
								this._applyVolume();
								
								if (this._o.options.autoStart)
										this.play();
								else
										return;
 
								/*
								var msg =   [];
								
								// currentMedia
								msg.push("imageSourceWidth : " + this._o.player.currentMedia.imageSourceWidth);
								msg.push("imageSourceHeight :   "   +   this._o.player.currentMedia.imageSourceHeight);
								
								$("debug").innerHTML = msg.join("<br />");
								*/
						}
 
						this._bPlaying = true;
 
						this._showVideo(true);
 
						Element.addClass.sliently(Element)(this._o.controls.play,   "hide");
						Element.removeClass.sliently(Element)(this._o.controls.pause,   "hide");
						Element.addClass.sliently(Element)(this._o.displays.loading, "hide");
 
						//this.setPosition(this._o.options.position);
 
						this._startTimer();
						break;
						
				default:
						break;
				}
 
				this._applyTime();
				this._applyVolume();
				this._applyRolloverButtons();
		},
 
		_getTimelineLeftAs : function(sFrom, sTo)   {
 
				var nLen = sFrom.length;
				
				var cType   =   sFrom.charAt(nLen   -   1);
				var nValue = parseFloat(sFrom);
				
				var nNormalized =   null;
				var nRetval =   null;
 
				var nTrackSize = this._trackSize.playing;
				
				if (sFrom.substr(nLen   -   2) ==   "px")   {
 
						nNormalized =   nValue * 100 / nTrackSize;
 
				}   else if (sFrom.substr(nLen - 3) == "sec")   {
 
						try {
								nNormalized =   nValue * 100 / this.getDuration();
						}   catch(e) { }
 
				}   else if (sFrom.substr(nLen - 1) == "%") {
 
						nNormalized =   nValue;
 
				}
				
				switch (sTo) {
				case "px":
						nRetval =   Math.round(nNormalized * nTrackSize /   100);
						break;
						
				case "sec":
						try {
								nRetval =   nNormalized *   this.getDuration() / 100;
						}   catch(e) { }
						break;
						
				case "%":
						nRetval =   nNormalized;
						break;
				}
				
				return nRetval;         
		},
 
		_toMinSecFormat :   function(nSec) {
				
				var nMin = parseInt(nSec / 60).toString();
				var nSec = parseInt(nSec % 60).toString();
				
				if (nMin.length == 1)   nMin = "0" + nMin;
				if (nSec.length == 1)   nSec = "0" + nSec;
				
				return nMin +   ":" +   nSec;
		},
		
		_applyInterval : function() {
		
				with (this) {
						
						if (_applyFullScreen()) {
								_applyTime();
								_applyVolume();
								_applyMute();
						}
						
				}
				
		},
 
		_applyTime : function() {
 
				try {
						
						var nNow = this.getPosition();
						var nAll = this.getDuration();
						
						if (this._o.displays.time) {
								this._o.displays.time.current.innerHTML =   this._toMinSecFormat(nNow);
								this._o.displays.time.duration.innerHTML = this._toMinSecFormat(nAll);
						}
												
						var nLeftPx =   this._getTimelineLeftAs(nNow + "sec",   "px")   || 0;
						this._o.displays.bar.playing.style.width = nLeftPx + "px";          
 
						// 드래그   하고 있을때는   playing grap 을 움직이지 말자
						if (!this._dragTimeInfo) {
								this._o.controls.grap.playing.style.left = nLeftPx + "px";
						}
						
				}   catch(e) { }
 
		},
		
		_befUiMode : null,
		
		_applyFullScreen : function()   {
				try {
						var uiMode = this._o.player.fullScreen ? "full" :   "none";
						
						if (this._befUiMode !== uiMode) {
								this._o.player.uiMode   =   uiMode;
								this._befUiMode =   uiMode;
						}
						
						return true;
				}   catch(e) { }
						
				return false;
		},
		
		_befVolume : null,
 
		_applyVolume : function()   {
 
				try {
						
						var nVolume =   this.getVolume();
						if (this._befVolume !== nVolume) {
						
								this._o.displays.bar.volume.style.height = (nVolume /   2) + "px";
								this._o.controls.grap.volume.style.top = (50 - nVolume / 2) -   2   +   "px";
								
								this._applyMute();
								this._befVolume =   nVolume;
						}
 
				}   catch(e) { }
 
		},
		
		_applyRolloverButtons   :   function() {
				
				// this._o.controls.stop.disabled   =   !this._bPlaying;
				this._o.controls.fullscreen.disabled = !this._bPlaying;
		},
		
		_bOrgIsMute :   null,
		
		_applyMute : function() {
				
				var nVolume =   this.getVolume();
				var bIsMute =   (this.getMute() || nVolume ==   0);
				
				if (bIsMute != this._bOrgIsMute) { 
 
						this._o.buttons.sound.src   =   this._prefix + 
								(bIsMute ? "media_img_16.jpg" : "media_img_15.jpg");
						
						this._o.panels.sound.style.backgroundImage = "url(" +   this._prefix +
								(bIsMute ? "player_sound_bg_off.gif" : "player_sound_bg_on.gif") + ")";
						
						this._bOrgIsMute = bIsMute; 
				}               
		},
 
		__init : function(sId, oObject) {
				this._sId   =   sId;
				
				if (oObject.options.imagePrefix)
						this._prefix = oObject.options.imagePrefix;
 
				this._options = oObject;
 
				Event.register(window, "load", this._onPageLoad.bind(this, oObject));
		},
		
		initialize : function() {
			if (!this._inited) {
				this._o = this._toObjects(this._options);
				this._inited = true;
			}
		},
 
		// ADDED
		_setEnable : function() {
			if (!this._o.controller) return;
			
			if (this._o.player.url) {
				Element.addClass(this._o.controller, 'enable');
			} else {
				Element.removeClass(this._o.controller, 'enable');
				this._o.controls.grap.playing.style.left = 0;
				this._o.displays.bar.playing.style.width = 0;
			}
		},
		
		_getEnable : function() {
			if (!this._o.controller) return true;
			return Element.hasClass(this._o.controller, 'enable');
		},
 
		play : function()   {
			this._o.player.controls.play();
 
				Element.removeClass.sliently(Element)(this._o.controls.pause,   "hide");
				Element.addClass.sliently(Element)(this._o.controls.play,   "hide");
		},
		
		pause   :   function() {
			this._o.player.controls.pause();
 
				Element.addClass.sliently(Element)(this._o.controls.pause, "hide");
				Element.removeClass.sliently(Element)(this._o.controls.play, "hide");
		},
		
		stop : function()   {
			this._o.player.controls.stop();
						
				Element.addClass.sliently(Element)(this._o.controls.pause, "hide");
				Element.removeClass.sliently(Element)(this._o.controls.play, "hide");
		},
 
		setFullScreen   :   function(bFlag) {
				this._o.player.uiMode   =   bFlag   ?   "full" : "none";
				this._o.player.fullScreen   =   bFlag;
		},
		getFullScreen   :   function() { return this._o.player.fullScreen; },
 
		setMute :   function(bFlag) {   this._o.player.settings.mute = bFlag;   },
		getMute :   function() { return this._o.player.settings.mute;   },
 
		setPosition :   function(nPos) { this._o.player.controls.currentPosition = nPos; },
		getPosition :   function() { return this._o.player.controls.currentPosition; },
 
		getDuration :   function() { return this._o.player.currentMedia.duration;   },
 
		setVolume   :   function(nVolume)   {   this._o.player.settings.volume = nVolume;   },
		getVolume   :   function() { return this._o.player.settings.volume; },
		
    _shouldShowVideo : false,
    _showVideoArea : true,
    
    _showVideo :   function(flag) {
 
            var box =   $("box_" + this._sId);
            if (typeof flag != 'undefined') this._shouldShowVideo = flag;
            
            var b = this._shouldShowVideo && this._showVideoArea;
            
            box.style.visibility = b ?   "visible"   :   "hidden";
            Element[b ? "addClass"   :   "removeClass"](this._o.blind,   "hide");
            
		},
		
		showVideoArea : function(flag) {
			
			this._showVideoArea = flag;
			this._showVideo();
								
		},	
 
		setVideoURL :   function(sUrl, autoStart)   {
 
			try {
				this._stopTimer();
				
				var bIE =   window.navigator.userAgent.indexOf("MSIE") > -1;
 
				if (bIE) {
						this._showVideo(false);
						this.stop();
				}
				
				var sId =   this._sId;
				
				this._o.player = sId;
				this._o.options.autoStart   =   autoStart   ?   true : false;
				var sHtml   =   Cplayer.getPlayerCode(sUrl, this._o);
				
				$("box_" + sId).innerHTML   =   sHtml;
				this._o.player = $(sId);
				
				this._duration = null;
				if (bIE) this.play();
				this._setEnable(); // ADDED
 
			} catch(e) {}
 
		},
		
		getMediaObject : function() { return this._o; }
 
});
 
Cplayer._players = { };
 
Cplayer.getPlayerCode   =   function(sUrl, oObject) {
        
        var sId =   oObject.player;
        var bIE =   window.navigator.userAgent.indexOf("MSIE") > -1;
        
        var autoStart   =   (oObject.options.autoStart &&   !bIE)   ?   1   :   0;
        var uiMode = bIE ? "none"   :   "full";
        var volume = bIE ? 0 : 50;
 
		sUrl = sUrl || ''; // ADDED
 
        var sHtml   =
        '<span style="cursor:pointer;hand;"><object id="'   +   sId +   '" type="video/x-ms-asf-plugin"' +
        '   classid="CLSID:6BF52A52-394A-11D3-B153-00C04F79FAA6" ' +
        '   width="' + oObject.width + '"   height="'   +   oObject.height + '" style="cursor:pointer;hand;">' +
        '       <param name="Url"   value="' + sUrl +   '">' +
        '       <param name="AutoStart" value="' + autoStart + '">' +
        '       <param name="uiMode" value="'   +   uiMode + '">'   +
        '       <param name="StretchToFit" value="1">' +
        //'     <param name="WindowlessVideo"   value="1">' +
        '       <param name="Volume" value="'   +   volume + '">'   +
        '       <embed type="video/x-ms-asf-plugin" style="cursor:pointer;hand;" ' +
        '        width="'   +   oObject.width   +   '" height="' + oObject.height   +   '"' +
        '        src="' +   sUrl + '"' +
        '        autostart="'   +   autoStart   +   '"' +
        '        uiMode="' + uiMode +   '"' +
        /*
        '        showControls="0"' +
        '        showStatusBar="0"' +
        */
        '        stretchToFit="1">' +
        //'      windowlessVideo="1">' +
        '       </embed>'   +
        '</object></span>';
        
        return sHtml;
        
};
 
Cplayer.createPlayer = function(sUrl,   nWidth, nHeight, oObject)   {
 
		var sId =   oObject.player;
		if (Cplayer._players[sId]) return   Cplayer._players[sId];
 
		oObject.options.expandForNOTIE = oObject.options.expandForNOTIE || [ 0, 0 ];
		var oOptions = oObject.options;
 
		var bIE =   window.navigator.userAgent.indexOf("MSIE") > -1;
 
		if (!bIE) {
			nWidth += oOptions.expandForNOTIE[0];
			nHeight += oOptions.expandForNOTIE[1];
		}
		
		oObject.width = nWidth;
		oObject.height = nHeight;
 
		var sHtml   =
				'<div   id="box_'   +   sId +   '" ' + (bIE ?   'style="visibility:hidden;"' : '') + '>' +
				this.getPlayerCode(sUrl, oObject)   +   '</div>';
				
		document.write(sHtml);
 
		sHtml =
			'<script type="text/javascript" language="javascript" for="' + sId + '" event="PlayStateChange(nState)">\n' +
			'       Cplayer._players["' +   sId +   '"]._applyState(nState);\n' +
			'</script>';
			
		document.write(sHtml);
		
		Cplayer._players[sId]   =   new Cplayer(sId, oObject);
		return Cplayer._players[sId];
};
 
 
 
/*
Cplayer.setPngAlpha =   function(obj)   {
		
		if (obj.style.filter.indexOf("progid") > -1) return;
		
	obj.width   =   obj.height = 1;
	obj.style.filter = "progid:DXImageTransform.Microsoft.AlphaImageLoader(src='"+ obj.src +"', sizingMethod='image');";
		
		return "auto";
}
*/

