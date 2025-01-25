/**
 * @author daum
 */
var __MiniDaum2008 = function(options) {
	var self = this;
	var s = new Array();
	var serviceUrls = {
		main: [
			{name: "??", url: "http://m.mail.daum.net", tag: "mail"},
			{name: "??", url: "http://m.media.daum.net/", tag: "news"},
			{name: "??", url: "http://m.search.daum.net/mobile/search?q=??", tag: "search"},
			{name: "??", url: "http://m.stock.daum.net/mobile/topindex.daum", tag: "stock"},
			{name: "?????", url: "http://m.bloggernews.media.daum.net", tag: "bloggernews"},
			{name: "?????", url: "http://m.cartoon.media.daum.net/cartoon/main.daum", tag: "cartoon"}
		]
	};
	var _ua = window.navigator.userAgent.toLowerCase();

	var mdBrowser = {
		model: _ua.match(/(sch-m490|sonyericssonx1i|ipod|iphone)/) ? _ua.match(/(sch-m490|sonyericssonx1i|ipod|iphone)/)[0] : "",
		skt : /msie/.test( _ua ) && /nate/.test( _ua ),
		lgt : /msie/.test( _ua ) && /([010|011|016|017|018|019]{3}\d{3,4}\d{4}$)/.test( _ua ),
		opera : (/opera/.test( _ua ) && /(ppc|skt)/.test(_ua)) || /opera mobi/.test( _ua ),
		ipod : /webkit/.test( _ua ) && /\(ipod/.test( _ua ) ,
		iphone : /webkit/.test( _ua ) && /\(iphone/.test( _ua )
	};

	var type = {BASIC: 0};
	this.opts = {
		isLoggedOn: null,
		userId: null,
		location: null,
		type: null,
		loginUrl:"#",
		logoutUrl:"#",
		bgColor: "transparent"
	}
	this.init = function() {
		if (options) {
			for (var prop in options) {
				this.opts[prop] = options[prop];
			}
		}
		this.opts.loginUrl = this.func.verifyUrl(this.opts.loginUrl); //flash referer problem.
		//this.initStyle();

	}
	this.initStyle = function() {
		var el = document.getElementById("DaumUI__minidaum");
		el.style.overflow = "hidden";
	}
	this.generate = function() {
		this.generateSource();
		var html = s.join('');
		document.getElementById("DaumUI__minidaum").innerHTML = html;
		this.addStyleSheets();
	}
	this.generateSource = function() {
		this.mainServiceListHtml();
		this.userStatusHtml();
	}

	this.mainServiceListHtml = function() {
		s[s.length] = '<div id="Mobile__list">';
		var n = serviceUrls.main.length;
		for (var i = 0; i < n; i++) {
			var svc = serviceUrls.main[i];
			if (svc.name == "??" && !this.opts.isLoggedOn) {
				s[s.length] = '<a href="http://www.daum.net/Mail-bin/login.html?url=http%3a%2f%2fm%2email%2edaum%2enet"';
			}else{
				s[s.length] = '<a href="' + serviceUrls.main[i].url; //this.getTaggedUrl("main", i);
			}
			s[s.length] = '" class="Mobile__list' + i + '">';
			s[s.length] = svc.name + '</a>';
		}
		s[s.length] = '</div>';
	}

	this.userStatusHtml = function() {
		s[s.length] = '<div id="Mobile__stat">';
		s[s.length] = '<a class="Mobile__Daum" href="http://m.daum.net/?nil_top=mini">Daum</a>'
		s[s.length] = '<a class="Mobile__tistory" href="http://www.tistory.com/m/new">????</a>'

		if (this.opts.isLoggedOn) {
			s[s.length] = '<span class="Mobile__nick" title="'+this.opts.userId+'">' + this.opts.userId + '?</span>';
			s[s.length] = '<a href="' + this.opts.logoutUrl + '" ><img src="http://icon.daum-img.net/minidaum/common/i_empty.gif" alt="????" class="Mobile__out" width="85" height="32" align="absmiddle"></a>';
		} else {
			//s[s.length] = '<span title="??? ???!" class="Mobile__info">??? ???!</span>';
			s[s.length] = '<a href="' + this.opts.loginUrl + '" ><img src="http://icon.daum-img.net/minidaum/common/i_empty.gif" alt="???" class="Mobile__in" width="71" height="33" align="absmiddle"></a>';
		}

		s[s.length] = '</div>';
	}

	this.getTaggedUrl = function(opt, idx) {
		var list =  serviceUrls.main;
		return this.func.getNilTaggedUrl(list[idx].url, "mini", list[idx].tag);
	}

	this.addStyleSheets = function() {
		try {
			if (mdBrowser.skt || mdBrowser.lgt) {
				var url = "http://go.daum.net/css/minidaumMobile2008.css";
			} else {
				var url = "http://go.daum.net/css/ipn_minidaumMobile2008.css";
			}
			url += "?ver=2008010131135";
			document.write('<link type="text/css" rel="stylesheet" href="' + url + '" charset="utf-8" />');
		} catch (e) {}
	}

	this.addTargetTop = function() {
		var list = document.getElementById("DaumUI__main").getElementsByTagName("a");
		for (var i = 0; i < list.length; i++) {
			list[i].target = "_top";
		}
	}

	// Tiara
	function minidaumMobileTiaraTrack() {
		function loadScript(sScriptSrc, oCallback) {
			var head = document.getElementsByTagName('head')
			if (!head) {
				return;
			}
			var oHead = head[0];
			var oScript = document.createElement('script');
			oScript.charset = 'UTF-8';
			oScript.type = 'text/javascript';
			oScript.src = sScriptSrc;
			// most browsers
			oScript.onload = oCallback;
			// IE 6 & 7
			oScript.onreadystatechange = function() {
				if (this.readyState == 'loaded' || this.readyState == 'complete') {
					oCallback();
				}
			}
			oHead.appendChild(oScript);
		};

		function callTiaraPageview() {

			try {

			    var __pageTracker = {};

			    if (typeof __Tiara != 'undefined' && typeof __Tiara.__getTracker != 'undefined') {
				__pageTracker = __Tiara.__getTracker();
			    } else {
				__pageTracker.__trackPageview = function() {};    }

				/from=simple/.test(window.location.search)

			var isMail = /\w+\.daum\.net\/hanmailex\/mobile/.test(window.location.href)

			if(isMail){
				var hasSimple = /\?from=simple/.test(window.location.search)
				if(hasSimple ){
					__pageTracker.__trackPageview("http://simple.mail.daum.net"+window.location.pathname+window.location.search);
				}else{
					__pageTracker.__trackPageview("http://m.mail.daum.net"+window.location.pathname+window.location.search);				
				}

			}else{
				__pageTracker.__trackPageview();}

			} catch (e) { }
		};


		loadScript('http://static.daum-img.net/tiara/tracker/tiara.js', callTiaraPageview);
	}
	try {
		window.setTimeout(minidaumMobileTiaraTrack, 1);
	} catch (e) {}


	this.func = {
		getNilTaggedUrl: function(url, profile, src) {
			return url + ((url.indexOf("?") > -1) ? "&" : "?") + "nil_profile=" + profile + "&nil_src=" + src;
		},

		getThisUrl: function() {
			try {return window.top.location.href;}
			catch(e) {return window.location.href;}
		},

		verifyUrl: function(url) {
			if (/\w+.swf/.test(url)) return self.func.getThisUrl();
			else return url;
		}

	}

	//init.
	this.init();
}

var __MiniDaumOpts = {};
__MiniDaumOpts.isLoggedOn = miniDaum_varLogInStatus == "logon" ? true : false;
__MiniDaumOpts.userId = miniDaum_varUserid;
__MiniDaumOpts.type = 0;
__MiniDaumOpts.loginUrl = miniDaum_varLogin;
__MiniDaumOpts.logoutUrl = miniDaum_varLogout;

try {
	var __MiniDaumObj = new __MiniDaum2008(__MiniDaumOpts);
	__MiniDaumObj.generate();
} catch (e) {}