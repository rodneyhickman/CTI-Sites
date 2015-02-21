 var TempestNS;if(TempestNS==null){TempestNS=new Object();TempestNS.RegisterScript=function(assemblyKey){if(!TempestNS.Client)return;if(!TempestNS.SCRIPTREGISTRY)new TempestNS.Client.ScriptRegistry();TempestNS.SCRIPTREGISTRY.AddAssembly(assemblyKey);};TempestNS.RequestAssembly=function(assemblyKey,callback){if(!TempestNS.Client)return;if(!TempestNS.SCRIPTREGISTRY)new TempestNS.Client.ScriptRegistry();TempestNS.SCRIPTREGISTRY.RequestScript(assemblyKey,callback);};};

	/**
	Common info about the Prospero Server, its build version, and dbg status
	**/
	TempestNS.Server = {
	'buildVersion' : '6577.26528',
	'dbg' : '0',
  'expId' : '',
  'domainPreOS25' : 'login.mycoactive.com',
  'domain' : window.location.hostname,
  'ptco' : 'false',
  'serverprotocol' : 'http://',
	'zone':'',
	'realmId':'20613',
	'tempestPath':'/dir-script/2026637/TempestNS.',
  'systemMessageUrl':'http://login.mycoactive.com/n/pfx/common.aspx?nav=systemMessage&ptpi=y&popinNarrow=true',
  'Apps': {
  'forum': '/n/pfx/forum.aspx',
  'forumindex': '/n/forumindex.aspx',
  'blog': '/n/blogs/blog.aspx',
  'profile': '/n/pfx/profile.aspx',
  'album' :'/n/pfx/album.aspx',
  'wiki':'/n/pfx/wiki.aspx',
  'ideashare':'/n/pfx/ideashare.aspx',
  'control':'/n/pfx/control.aspx',
  'filerepository': '/n/pfx/filerepository.aspx',
  'login': '/n/login/login.aspx',
  'common':'/n/pfx/common.aspx'
  },
  'SeoApps': {
  'forum': '/discussions',
  'forumindex': '/discussions',
  'blog': '/blog',
  'profile': '/profiles',
  'album' :'/photos',
  'wiki':'/wiki',
  'ideashare':'/ideas',
  'filerepository': '/files'
  }
  };
  
 

/**
 <summary>
  Default constructor of TempestNS.Client v2
 </summary>
 <param name=""></param>
**/
TempestNS.Client = function()
{
 this.protocol = location.protocol; 
};


TempestNS.Client.SetCookie = function (name,value,days) {
	var expires = "";
	if (days) {
		var date = new Date();
		date.setTime(date.getTime()+(days*24*60*60*1000));
		expires = "; expires="+date.toGMTString();
	}
	document.cookie = name+"="+escape(value)+expires+"; path=/";
};

TempestNS.Client.GetCookie = function(name) {
	var nameEQ = name + "=";
	var ca = document.cookie.split(';');
	for(var i=0;i < ca.length;i++) {
		var c = ca[i];
		while (c.charAt(0)==' ') c = c.substring(1,c.length);
		if (c.indexOf(nameEQ) == 0) return unescape(c.substring(nameEQ.length,c.length));
	}
	return null;
};

TempestNS.Client.EraseCookie = function(name) {
	TempestNS.Client.SetCookie(name,"",-1);
};


TempestNS.Client.HasClassName = function(elm, classname)
 {
    var reClassMatch = new RegExp("(^| )" + classname + "( |$)");
    return (reClassMatch.test(elm.className));
 };
 TempestNS.Client.RemoveClassName = function(elm, classToRemove)
 {
     var classes = elm.className.split(" ");
     var newClassName = "";
     var len = classes.length;
     for (var i = 0; i < len; i++) 
     {
        if (classes[i] != classToRemove) 
        {
            newClassName += classes[i] + " ";
        }
     }
     elm.className = newClassName;
 };
 TempestNS.Client.AddClassName = function(elm, classToSet)
 {
    if (!TempestNS.Client.HasClassName(elm, classToSet))
    {
      if(elm.className != '')
      {
        var curClass = elm.className;
        elm.className = curClass + " " + classToSet;
      }
      else
      {
        elm.className = classToSet;
      }
    }
 };
 
 TempestNS.Client.SwitchClassName = function(elm, classToRemove,classToSet)
    {
       TempestNS.Client.RemoveClassName(elm, classToRemove);
	   TempestNS.Client.AddClassName(elm, classToSet);
    };
    
    

/**
 <summary>
 Looks at all <script/> tags sees if the passed script is a match.
 Return true/false if it is found.
 </summary>
 <param name="src">The script src to find in the doc.</param>
**/
TempestNS.Client.HaveScript = function(src)
{
    // See if exists
  var scripts = document.getElementsByTagName('script');
  for(var i = 0; i < scripts.length; i++) 
  {
    if(scripts[i].src.toLowerCase().match(src.toLowerCase())) 
    {
      return true;
    }
  }
  
  return false;
};


/**
 <summary>
  Method for resizing an image to its container so as to fit it in the same aspect ratio.
  It also centers the image horizontally and vertically.
  For an onload event handler, this function will work best if
   - Image is called WITHOUT width or height attributes (native dimensions will be calculated by browser)
   - Image style has been set to visibility: hidden
   - Container has a fixed width and height
   - Container is a block-level element with overflow set to hidden
 </summary>
 <param name="img">The image to be resized.</param>
 <param name="vertCenter">If true, image is centered vertically in container.</param>
 <param name="box">Optional. The container in which the image will be resized</param>
**/
TempestNS.Client.FitImageToContainer =  function (img, vertCenter, box)
{
  if (!img) return;
  var container = (box) ? box : img.parentNode;
  /* if (container.className != "myImage") return; */
  var imgW = img.width;
  var imgH = img.height;
  var conW = container.offsetWidth;
  var conH = container.offsetHeight;
  var imgAspect = imgW / imgH;
  var conAspect = conW / conH;
  var sizeCoefficient = 1;
  var marginTop = 0;
  if (imgAspect > conAspect) // resize horizontally
  {
    sizeCoefficient = conW / imgW;
    marginTop =  Math.floor( (conH - Math.floor(imgH*sizeCoefficient))/2);
  }
  else if (conAspect > imgAspect) // resize vertically
  {
    sizeCoefficient = conH / imgH;
  }
  img.style.width = Math.floor(imgW*sizeCoefficient) + "px";
  img.style.height = Math.floor(imgH*sizeCoefficient) + "px";
  //img.src = img.src + "?width=" + Math.floor(imgW*sizeCoefficient) + "&height=" + Math.floor(imgH*sizeCoefficient);
  if (vertCenter) img.style.marginTop = marginTop + "px";
  img.style.visibility = "visible";

};


/**
 <summary>
 Assumes the parent holds one avatar.
 - Find the parent
 - Find the prospero avatar
 - Resize it
 </summary>
 <param name=""></param>
**/
TempestNS.Client.FitImageToContainerById = function (boxId, vertCenter)
{
  var box = document.getElementById(boxId);
  if(!box) 
  {
    return;
  }
  var images = document.getElementsByTagName("img");
  for(var i = 0; i < images.length; i++)
  {
    if(images[i].className == "os-img")
    {
      TempestNS.Client.FitImageToContainer(images[i], vertCenter, box);
    }
  }
};


/**
 <summary>
  Cross-browser method for adding event listeners.
 </summary>
 <param name=""></param>
**/
TempestNS.Client.AddEventListener = function(elm, type, listener, useCapture) 
{
    if(document.addEventListener)
    {
        elm.addEventListener(type, listener, useCapture);
    }
    else if(document.attachEvent)
    {
        elm.attachEvent("on" + type, listener);
    }
    else
  {
        elm["on"+type] = callback;
    }
}

// BugzId: 68416 - Links in widget not always working because multiple event handlers cancel each other out.
/**
 <summary>
  Use older method of setting event listener such that only one handler is registered for the event.
 </summary>
 <param name=""></param>
**/
TempestNS.Client.SetEventListener = function(elm, type, listener) 
{
    elm["on"+type] = listener;
}

TempestNS.Client.StopPropogation=function(evt)
{
    if(evt==null)
    {
        evt = window.event;
    }
    if(evt.stopPropagation)
    {
        evt.stopPropagation();
        evt.preventDefault();
    }
    else if(evt.cancelBubble)
    {
        evt.cancelBubble=true;
        evt.returnValue = false;
    }
}

/**
 <summary>
  Remove a crossbrowser event listener to an element
 </summary>
**/
TempestNS.Client.RemoveEventListener = function(elm, type, listener, useCapture)
{
    if(document.removeEventListener)
    {
        elm.removeEventListener(type, listener, useCapture);
    }
    else if(document.detachEvent)
    {
        elm.detachEvent("on" + type, listener, useCapture);
    }
    else
  {
        elm["on"+type] = null;
    }
}



/**
 <summary>
  Helper function to determine if your browser prefers using the class or classname attribute
 </summary>
 <param name="elm">an element with a class attribute.  If it does NOT have a class then it will return "class".</param>
**/
TempestNS.Client.GetClassAttribute = function(elm)
{
  /* Needed to handle browser differences with JS and setting the class name.
     See if this browser uses pre IE8 model of assigning classes to elements */
  if(elm.getAttribute("className"))
  {
    return "className";
  }
  else
  {
    return "class";
  }
};



/**
 <summary>
  
 </summary>
 <param name=""></param>
**/
TempestNS.Client.GetControlValue = function(ctl)
{
  switch(ctl.type)
  {
    case "checkbox":
    {
      if(!ctl.checked)
      {
        return null;  /* nothing should be posted back */
      }
      break;
    }
    case "radio":
    {
      if(!ctl.checked)
      {
        return null;  /* nothing should be posted back */
      }
      break;
    }
    case "select-one":
    {
      return ctl.options[ctl.selectedIndex].value;
    }
  }
  return ctl.value;
}


/**
 <summary>
 Return the document height NOT the window height
 </summary>
**/
TempestNS.Client.GetDocumentHeight = function(theDoc)
{
  if(theDoc == null)
  {
    theDoc = document;
  }
  
  var h = Math.max(
    Math.max(
      Math.max(theDoc.body.scrollHeight, theDoc.documentElement.scrollHeight),
      Math.max(theDoc.body.offsetHeight, theDoc.documentElement.offsetHeight)
    ),
    Math.max(theDoc.body.clientHeight, theDoc.documentElement.clientHeight)
  );
  return h;
};

/**
 <summary>
 Return the document width NOT the window width
 </summary>
**/
TempestNS.Client.GetDocumentWidth = function(theDoc)
{
  if(theDoc == null)
  {
    theDoc = document;
  }
  
  var w = Math.max(
    Math.max(
      Math.max(theDoc.body.scrollWidth, theDoc.documentElement.scrollWidth),
      Math.max(theDoc.body.offsetWidth, theDoc.documentElement.offsetWidth)
    ),
    Math.max(theDoc.body.clientWidth, theDoc.documentElement.clientWidth)
  );
  return w;
};

/**
 <summary>
  Returns the coordinates of an element relative to the page
 </summary>
 <param name=""></param>
**/
TempestNS.Client.GetElementPosition = function(elm)
{
  if(!elm){
    return {left:0, top:0, absTop:0};
  }
  var offsetTrail = elm;
  var offsetLeft = 0;
  var offsetTop = 0;
  while(offsetTrail) 
  {
    offsetLeft += offsetTrail.offsetLeft;
    offsetTop += offsetTrail.offsetTop;
    offsetTrail = offsetTrail.offsetParent;
  }
  if(navigator.userAgent.indexOf("Mac") != -1 && navigator.userAgent.indexOf("Safari") == -1 && typeof document.body.leftMargin != "undefined") 
  {
    offsetLeft += document.body.leftMargin;
    offsetTop += document.body.topMargin;
  }
  return {left:offsetLeft, top:offsetTop + elm.offsetHeight, absTop:offsetTop};
}


/**
 <summary>
  Returns the coordinates of an element relative to the page
 </summary>
 <param name=""></param>
**/
TempestNS.Client.GetMousePosition = function(e)
{
  var posx;
  var posy;
  if(e == null)
  {
    e = window.event;
  }
  if(e.pageX || e.pageY)
  {
    posx = e.pageX; 
    posy = e.pageY;
  }
  else if(e.clientX || e.clientY)
  {
    if(document.documentElement.scrollTop)
    {
      posx = e.clientX + document.documentElement.scrollLeft;
      posy = e.clientY + document.documentElement.scrollTop;
    }
    else
    {
      posx = e.clientX + document.body.scrollLeft;
      posy = e.clientY + document.body.scrollTop;
    }
  }
  return {"x":posx, "y":posy}
}


/**
 <summary>
  Returns the target of the mouse click
 </summary>
 <param name="e">Current window event</param>
**/
TempestNS.Client.GetMouseTarget = function(e) 
{
  var target;
  if(e == null)
  {
    e = window.event;
  }
  if(e.target) 
  {
    target = e.target;
  }
  else if(e.srcElement)
  {
    target = e.srcElement;
  }
  /* Correct for Safari bug */
  if(target.nodeType == 3)
  {
    target = target.parentNode;
  }
  return target;
}


/**
 <summary>
  Returns the height and width of the inner browser window
 </summary>
**/
TempestNS.Client.GetWindowSize = function() 
{
  var w = 0;
  var h = 0;
  if(typeof(window.innerWidth) == 'number') 
  {
    /* Non-IE */
    w = window.innerWidth;
    h = window.innerHeight;
  } 
  else if(document.documentElement && (document.documentElement.clientWidth || document.documentElement.clientHeight )) 
  {
    /* IE 6+ */
    w = document.documentElement.clientWidth;
    h = document.documentElement.clientHeight;
  } 
  else if(document.body && (document.body.clientWidth || document.body.clientHeight )) 
  {
    /* IE 4 compatible */
    w = document.body.clientWidth;
    h = document.body.clientHeight;
  }
  return {"height":h, "width":w};
}


/**
 <summary>
  
 </summary>
 <param name=""></param>
**/
TempestNS.Client.IncludeScript = function(scriptUrl, defer)
{
  /* Make sure the scriptURL is fully qualified */
  if(scriptUrl.substring(0,4) != "http")
  {
    if(scriptUrl.charAt(0) == "/")
    {
      scriptUrl = location.protocol+"//"+ TempestNS.Server.domain + scriptUrl;
    }
    if(scriptUrl.substring(0,3) == "../")
    {
      scriptUrl = location.protocol+"//"+ TempestNS.Server.domain + scriptUrl.substring(2,scriptUrl.length);
    }
  }
  var headElm = document.getElementsByTagName('head')[0];
  var scriptElm = document.createElement('script');
  scriptElm.setAttribute('type','text/javascript');
  scriptElm.setAttribute('src',scriptUrl);
  if(defer) scriptElm.setAttribute('defer','defer');
  headElm.appendChild(scriptElm);
  return scriptElm;
}

TempestNS.Client.RemoveScript = function(scriptElm)
{
  var headElm = document.getElementsByTagName('head')[0];
  headElm.removeChild(scriptElm);
}




/**
 <summary>
  Scroll Page to a place on the customer's page
 </summary>
**/
TempestNS.Client.ScrollToId = function(scrollId)
{
  if(scrollId)
  {
    var placeOnPage = document.getElementById(scrollId);
    if(placeOnPage)
    {
      placeOnPage.scrollIntoView(true);
    }
  }
}


/**
 <summary>
  
 </summary>
 <param name=""></param>
**/
TempestNS.Client.ToolTip = function(parentDiv)
{
  /* Create outer <div/> */
    this.ptcToolTipBox = document.createElement("div");
    this.ptcToolTipBox.id = "ptcToolTip";
    this.ptcToolTipBox.style.position = "absolute";
    this.ptcToolTipBox.style.visibility = "hidden";
    this.ptcToolTipBox.className = "os-tooltipbox";
    /* Create inner <div/> */
    this.ptcToolTipText = document.createElement("div");
    this.ptcToolTipText.style.position = "relative";
    this.ptcToolTipText.className = "os-tooltiptext";
    /* Add inner <div/> to the outer <div/> */
    this.ptcToolTipBox.appendChild(this.ptcToolTipText);
  /* Create an object to hold tips */
  this.msgs = new Array();
  
  /* Add Tool Tip Method */
  this.AddToolTip = function(tsn, msg)
  {
    this.msgs['msg'+tsn] = msg;
  }

    /* Hide Tool Tip Method */
  this.HideToolTip = function()
  {
    this.ptcToolTipBox.style.visibility = "hidden";
  }
  
  /* Show Tool Tip Method */
    this.ShowToolTip = function(tsn, e)
  {
    var mouse = TempestNS.Client.GetMousePosition(e);
    this.ptcToolTipText.innerHTML = this.msgs['msg'+tsn];
    this.ptcToolTipBox.style.top = mouse.y + 15 + "px";
    this.ptcToolTipBox.style.left = mouse.x + 15 + "px";
    this.ptcToolTipBox.style.visibility = "visible";
    if(parentDiv)
    {
      parentDiv.appendChild(this.ptcToolTipBox);
    }
    else
    {
      if(this.ptcToolTipBox.parentNode != document.body)
      {
        document.getElementsByTagName("body")[0].appendChild(this.ptcToolTipBox);
      }
    }
  }
}


TempestNS.Client.ToolTip.prototype = new Object();




/**
    needs server and client
    
    gopes in client

    the script provides utility methods for including new scripts dynamically
    the registry provides the ability to request new assemblys and the ability to execute callback functions once they 
    are complete
**/

TempestNS.Client.ScriptRegistry= function()
{
    if(TempestNS.SCRIPTREGISTRY)
    {
        return;
    }
    TempestNS.SCRIPTREGISTRY= this;
    this._Scripts = new Object();
    this._callbacks = new Object();
    this._head = null;
    this._Has = "";
};



/**
    This is executed from the call by the TempestNS.RegisterScript;
    Its key is inserted in the items collection 
    

**/



  
TempestNS.Client.ScriptRegistry.AddAssembly= function(assemblyKey)
{   
    if(this._Has!=""){
        this._Has+="|";
    }
    this._Has+=assemblyKey;    
    this._Scripts[assemblyKey]= assemblyKey;
    if(this._callbacks[assemblyKey])
    {
        var len = this._callbacks[assemblyKey].length;
        for(var index = 0 ; index <len;index++){
            this._callbacks[assemblyKey][index]();
        }
        if(TempestNS.COMPONENT_REGISTRY){
         TempestNS.COMPONENT_REGISTRY.LoadChildren();
        }
      
        this._callbacks[assemblyKey]=null;
    }
};
    
TempestNS.Client.ScriptRegistry.RequestScript = function(assemblyKey,callback)
{
  if(this._Scripts[assemblyKey])
  {
    callback();
  }
  else
  {
    if(this._callbacks[assemblyKey])
    {
        //there already hass been a request for this assembly -- just add to the call back array
        this._callbacks[assemblyKey].push(callback)
    }
    else
    {   this._callbacks[assemblyKey] = new Array();
        this._callbacks[assemblyKey].push(callback)
        this.MakeRequest(assemblyKey);
    }
  }      
};    
    
TempestNS.Client.ScriptRegistry.MakeRequest = function(assemblyKey)
{
    var src = location.protocol +"//" + TempestNS.Server.domain;
    src += TempestNS.Server.tempestPath;
    src += assemblyKey + ".js?";
     if(TempestNS.Server.dbg!='0')
     {
       src+="&dbg="+TempestNS.Server.dbg+"&";
       src+="ver=" + escape(new Date().valueOf())+"&";
     }
     src +=this.Has();  
     TempestNS.Client.IncludeScript(src);
};
    
TempestNS.Client.ScriptRegistry.Has= function()
{
    return "HaveScripts="+this._Has;
}    
    
    
TempestNS.Client.ScriptRegistry.prototype = new Object();
TempestNS.Client.ScriptRegistry.prototype.AddAssembly = TempestNS.Client.ScriptRegistry.AddAssembly;
TempestNS.Client.ScriptRegistry.prototype.RequestScript = TempestNS.Client.ScriptRegistry.RequestScript;
TempestNS.Client.ScriptRegistry.prototype.MakeRequest = TempestNS.Client.ScriptRegistry.MakeRequest;
TempestNS.Client.ScriptRegistry.prototype.Has = TempestNS.Client.ScriptRegistry.Has;





TempestNS.Client.StyleRegistry = function()
{
    /*insure its a singleton*/
    if(TempestNS.Client.STYLEREGISTRY){
        return;
    }
    TempestNS.Client.STYLEREGISTRY= this;
    this._styleSheets = new Object();
};

TempestNS.Client.StyleRegistry.AddStyle=function(href)
{
    
    if(!TempestNS.Client.STYLEREGISTRY){
        new TempestNS.Client.StyleRegistry();
    }
    
    key = escape(href);
    if(!TempestNS.Client.STYLEREGISTRY._styleSheets[key]){
      TempestNS.Client.STYLEREGISTRY._styleSheets[key]=href;
      if (document.createStyleSheet) /* IE only?  */
      {
        document.createStyleSheet(href);
      }
      else 
      {
        var ptCSS = document.createElement('link');
        ptCSS.rel = 'stylesheet';
        ptCSS.type = 'text/css';
        ptCSS.href = href;
        document.getElementsByTagName('head')[0].appendChild(ptCSS);
      }
    }
    
};

TempestNS.Client.StyleRegistry.prototype = new Object();



/**
 <summary>
  Hide or show all embedded objects on the page
 </summary>
 <param name=""></param>
**/
TempestNS.Client.EmbedShowHide = function(restore)
{
    //var tagName = (navigator.appName == "Microsoft Internet Explorer") ? "object" : "embed";
    //var objects = document.getElementsByTagName(tagName);
   
  var objectTags = new Array('object','embed','iframe');
  for (var j = 0; j < objectTags.length; j++) 
  {
    var objects = document.getElementsByTagName(objectTags[j]);
    for (var i = 0; i < objects.length; i++) 
    { 
      // if the elm has an empty id, will make an assumption to hide it
      // should not hide modaldialog
      if(objects[i].id == "")
      {
        objects[i].style.visibility = (restore ? 'visible' : 'hidden');
      }
      else
      {
        var test = objects[i].id.split("MODALDIALOG");
        if(test.length == 1)
        {
          objects[i].style.visibility = (restore ? 'visible' : 'hidden');
        }
      }
    }
  }
};


/**
 <summary>
  Return the scroll top position
 </summary>
 <param name=""></param>
**/
TempestNS.Client.GetScrollTop = function()
{
  var ScrollTop = document.body.scrollTop;
  if(ScrollTop == 0)
  {
    if(window.pageYOffset)
    {
      ScrollTop = window.pageYOffset;
    }
    else
    {
      ScrollTop = (document.body.parentElement) ? document.body.parentElement.scrollTop : 0;
    }
  }
  return ScrollTop;
};


/**
 <summary>
  Returns a ref to the .document inside an iframe.   Copied from Script.StandardJavascript
 </summary>
 <param name=""></param>
**/
TempestNS.Client.GetIframeDoc = function(oIframe)
{
  if (oIframe != null)
  {
    var i = (oIframe.contentDocument) ? oIframe.contentDocument : (oIframe.contentWindow) ? oIframe.contentWindow.document : (oIframe.document) ? oIframe.document : null;
    return i;
  }
};




/**
 <summary>
  When using IE, find <div> and <li> elements on the page and "rounds" them.
  Looks for the style "border-radius" to see what it should be rounded to.
 </summary>
 <param name="parent">Parent element.  Onload should be document.</param>
**/
TempestNS.Client.IERoundCorners = function(par)
{
  var b = new TempestNS.Client.BrowserDetect();
  
  // Should only work for IE
  if(b.isIE)
  {
    // Parameters used for VML
    var e; // current element
    var eArcSize;
    var eBottom;
    var eClear;
    var eFillColor;
    var eFillSrc;
    var eHeight;
    var eLeft;
    var eMargin;
    var eOuterHTML;
    var ePosition;
    var eRight;
    var eStrokeColor;
    var eStrokeWeight;
    var eStyleFloat;
    var eTop;
    var eWidth;
    
    // First find and round divs
    var allDivs = par.getElementsByTagName("div");
    for(var x = 0; x < allDivs.length; x++)
    {
      e = allDivs[x];
      
      // Look for divs with a ptcBorderRadius classname and without the ptcRoundingDone
      if(e.className.match('os-borderradius') && !e.className.match('os-roundingdone'))
      {
        if(e.currentStyle['border-radius'])
        {
          // Check not to do this twice
          e.className = e.className.concat(' os-roundingdone');
    
          // Add VML namespace
          if (!document.namespaces.v) 
          {
            document.namespaces.add("v", "urn:schemas-microsoft-com:vml");
          }
           
          // Calculate/Set styles
          eArcSize = Math.min(parseInt(e.currentStyle['border-radius']) / Math.min(e.offsetWidth, e.offsetHeight), 1);
          eStrokeColor = e.currentStyle.borderColor; 
          eStrokeWeight = e.currentStyle.borderWidth; 
          e.style.border = 'none';
          eFillColor = e.currentStyle.backgroundColor; 
          eFillSrc = e.currentStyle.backgroundImage.replace(/^url\("(.+)"\)$/, '$1'); 
          e.style.background = 'transparent';
          eMargin = e.currentStyle.margin; 
          e.style.margin = '0';
          eStyleFloat = e.currentStyle.styleFloat; 
          e.style.styleFloat = 'none';
          eClear = e.currentStyle.clear; 
          e.style.clear = 'none';
          ePosition = e.currentStyle.position; 
          e.style.position = 'static';
          eLeft = e.currentStyle.left; 
          e.style.left = '0';
          eRight = e.currentStyle.right; 
          e.style.right = '0';
          eTop = e.currentStyle.top; 
          e.style.top = '0';
          eBottom = e.currentStyle.bottom; 
          e.style.bottom = '0';
          eWidth = (e.currentStyle.width == "100%") ? e.currentStyle.width : e.offsetWidth - parseInt(eStrokeWeight);
          e.style.width = '100%';
          eHeight = (e.currentStyle.height == "auto") ? e.offsetHeight : e.currentStyle.height;
          e.style.height = '100%';
          
          // Build the rounded corners
          eOuterHTML = '<div class="os-borderradiusparent" style="background:transparent;border:none;padding:0;margin:'+ eMargin +';float:'+ eStyleFloat +';clear:'+ eClear +';position:'+ ePosition +';left:'+ eLeft +';right:'+ eRight +';top:'+ eTop +';bottom:'+ eBottom +';width:'+ eWidth +';height:'+ eHeight +';">';
          eOuterHTML += '<v:roundrect arcsize="'+ eArcSize +'" fillcolor="'+ eFillColor +'" strokecolor="'+ eStrokeColor +'" style="behavior:url(#default#VML);top:1;left:1;display:inline-block;width:'+ eWidth +';height:'+ eHeight+';antialias:true;padding:'+ eStrokeWeight + 'px;">';
          eOuterHTML += e.outerHTML;
          eOuterHTML += '</v:roundrect>';
          eOuterHTML += '</div>';         
          e.outerHTML = eOuterHTML;
        }
      }
    }
  }
  
};



/**
 <summary>
  A simple browser detecter that should only be used when ABSOLUTELY necessary.  
  When needed, create new browserdetect object and test for versions by 
  doing something like:
    browser = new TempestNS.Client.BrowserDetect(); 
    if(browser.isIE){ ... }
 </summary>
**/
TempestNS.Client.BrowserDetect = function()
{
  var agent = navigator.userAgent.toLowerCase();
  
  // Agents
  this.isIE = agent.indexOf("msie") > -1;
  this.isFireFox = agent.indexOf('firefox') != -1;
  this.isSafari = agent.indexOf('safari') != -1;
  this.isOpera = 'opera' in window;
  this.isChrome = agent.indexOf('chrome') != 1;
  
  // Other useful stuff
  this.isWebKit = agent.indexOf('webkit') != -1;  // Good test for Safari and Chrome
  
  // IE Helpers
  this.ieVer = this.isIE ? /msie\s(\d\.\d)/.exec(agent)[1] : 0;
  this.ieQuirksMode = this.isIE && (!document.compatMode || document.compatMode.indexOf("BackCompat") > -1);
};



/**
 <summary>
  Adds listener to the document and fires function when ready.
  TODO: Find places such as WidgetManager and RegisterComponents where similar code is being used.
 </summary>
 <param name="fn">The function to fire when the dom is ready</param>
**/
TempestNS.Client.OnDOMLoad = function(fn)
{
  /* Create callback function for readystate check */
  var callback = function(){
    if(document.readyState == "complete")
    {
      clearInterval(timerPollDom);
      fn();
    }
  };
  
  /* If browser supports W3C Recommended event listener */
  if(document.addEventListener)
  {
    /* If Opera, and Safari, listen to OnReadyState by 'polling' it every second */
    if(document.readyState) 
    {
      // Poll readyState every second to see the DOM is complete 
      var timerPollDom = setInterval(callback, 1000);
    }
    /* Else Firefox, listen to DOMContentLoaded */
    else
    {
      document.addEventListener("DOMContentLoaded", fn, false);
    }
  }
  /* Else the browser supports IE event listener */
  else if(document.attachEvent) 
  {
    document.attachEvent("onreadystatechange", callback);
  }
  /* Else the browser is very old */
  else
  {
    window.onload = fn;
  }
};



 TempestNS.Client.Event=function(evt){if(evt==null){evt=window.event;}this._event=evt;if(this._event){this._source=this._event.target;}else{this._source=this._event.srcElement;}if(this._event.pageX!=null){this._x=this._event.pageX;this._y=this._event.pageY;}else{this._x=this._event.clientX;this._y=this._event.clientY;}};TempestNS.EventStopPropogation=function(){if(this._event.stopPropagation){this._event.stopPropagation();this._event.preventDefault();}else if(this._event.cancelBubble){this._event.cancelBubble=true;this._event.returnValue=false;}};TempestNS.Client.Event.prototype.StopPropogation=TempestNS.EventStopPropogation;TempestNS.Ajax=function(src,callback,callbackArgs,async){if(src){this.xhr=this.GetXHR();this.xhrSrc=src;if(typeof(async)=='undefined')async=true;this.xhrAsync=async;var self=this;this.xhr.onreadystatechange=function(){if(self.xhr.readyState==4&&self.xhr.status==200){callback(self.xhr,callbackArgs);}};}};TempestNS.Ajax.ActivateScripts=function(elm){var newScripts=elm.getElementsByTagName("script");for(var ix=0;ix<newScripts.length;ix++){if(window.PT_SCRIPTREGISTRY!=null&&newScripts[ix].src!=""){window.PT_SCRIPTREGISTRY.AddScript(new PT_Script_Reference(newScripts[ix].src));}else{var scriptText=newScripts[ix].innerHTML;scriptText=scriptText.replace("<!--","");scriptText=scriptText.replace("-->;","");if(scriptText.length!=0){if(window.execScript){window.execScript(scriptText);}else{window.setTimeout(scriptText,0);}}}}};TempestNS.Ajax.AddFormField=function(frm,type,fld,val){var ctl=document.createElement("input");ctl.type=type;if(this._prefix){ctl.name="mz_"+fld;}else{ctl.name=fld;}if(typeof(val)!='undefined'){ctl.value=val;}frm.appendChild(ctl);return ctl;};TempestNS.Ajax.GetXHR=function(){if(window.XMLHttpRequest){try{return new XMLHttpRequest();}catch(e){return null;}}else if(window.ActiveXObject){try{return new ActiveXObject("Msxml2.XMLHTTP");}catch(e){try{return new ActiveXObject("Microsoft.XMLHTTP");}catch(e){return null;}}}};TempestNS.Ajax.Open=function(action){action=action.toLowerCase();if(action=="post"){this.xhr.open("POST",this.xhrSrc,this.xhrAsync);this.xhr.setRequestHeader('Content-Type','application/x-www-form-urlencoded');}else if(action=="get"){this.xhr.open("GET",this.xhrSrc,this.xhrAsync);}};TempestNS.Ajax.PrepareParams=function(controlList,controlContainer,validationGroup){var postParams="";var myPageValidators=new Array();if(controlList&&controlContainer){var checkValidation=false;if(window.Page_Validators)checkValidation=true;var ctlList=controlContainer.getElementsByTagName("*");var controlsToGet="^"+controlList.replace(",","$|^").replace("*",".*")+"$";var controlsRE=new RegExp(controlsToGet,"i");for(var i=0;i<ctlList.length;i++){var el=ctlList[i];if(el.id.search(controlsRE)!=-1){if(checkValidation){for(var vix=0;vix<Page_Validators.length;vix++){var pvElm=Page_Validators[vix];var vId=pvElm.id;var ctlToV=window[vId].controltovalidate;if(ctlToV==el.id){myPageValidators.push(pvElm);if(validationGroup){if(validationGroup!=window[vId].validationGroup){myPageValidators.pop();}}}}}var ctlVal=TempestNS.Client.GetControlValue(el);if(ctlVal!=null){postParams+="&"+el.name+"="+escape(ctlVal);}}}}else if(controlList){for(var i=0;i<controlList.length;i++){for(var j=0;j<controlList[i].length;j++){var ctlVal=TempestNS.Client.GetControlValue(controlList[i][j]);if(ctlVal){postParams+="&"+controlList[i][j].name+"="+escape(ctlVal);}}}}if(myPageValidators.length!=0){var holdValidators=Page_Validators;Page_Validators=myPageValidators;var validatesOk=Page_ClientValidate();PageValidators=holdValidators;if(!validatesOk){return false;}}return postParams;};TempestNS.Ajax.Send=function(params){this.xhrParams=params;this.xhr.send(this.xhrParams);};TempestNS.Ajax.SetBridge=function(){var fName="MZ_Bridge";if(!this._bridge){this._bridge=document.createElement("div");this._bridge.id=fName;this._bridge.style.display="none";document.body.appendChild(this._bridge);}if(!this._iframe){this._iframe=TempestNS.Ajax.CreateBridgeIframe(this._bridge);}if(this._form){this._bridge.removeChild(this._form);}this._form=document.createElement("form");this._form.method="post";this._form.enctype="multipart/form-data";this._form.encoding="multipart/form-data";this._form.name=fName+"_Form";this._form.target=fName+"_Iframe";this._bridge.appendChild(this._form);};TempestNS.Ajax.CreateBridgeIframe=function(bridge){var fName="MZ_Bridge";var f=document.getElementById(fName+"_Iframe");if(f==null){if(document.attachEvent){bridge.innerHTML="<iframe id='"+fName+"_Iframe'name='"+fName+"_Iframe'style='height:0px;width:0px;visibility:hidden;'></iframe>";f=document.getElementById(fName+"_Iframe");}else if(document.addEventListener){f=document.createElement("iframe");f.style.height="0px";f.style.width="0px";f.style.visibility="hidden";f.id=fName+"_Iframe";f.name=fName+"_Iframe";bridge.appendChild(f);}}return f;};TempestNS.Ajax.prototype=new Object();TempestNS.Ajax.prototype.ActivateScripts=TempestNS.Ajax.ActivateScripts;TempestNS.Ajax.prototype.AddFormField=TempestNS.Ajax.AddFormField;TempestNS.Ajax.prototype.GetXHR=TempestNS.Ajax.GetXHR;TempestNS.Ajax.prototype.Open=TempestNS.Ajax.Open;TempestNS.Ajax.prototype.PrepareParams=TempestNS.Ajax.PrepareParams;TempestNS.Ajax.prototype.Send=TempestNS.Ajax.Send;TempestNS.Ajax.prototype.SetBridge=TempestNS.Ajax.SetBridge;

/**************** Static Methods to replace Script.Ajax ****************/


/**
 <summary>
 Make sure the PT "namespace" object is defined. 
 </summary> 
**/
if(!window.PT)
{
  window.PT = new Object();
};


/**
 <summary>
 Make sure the PTLib "namespace" object is defined.
 </summary> 
**/
var PTLib;
if (!PTLib)
{
  PTLib = new Object();
};

/**
 <summary>
 </summary>
**/
PTLib.Popin = function(id, innerHTML)
{
  this.isActive = false; // not attached to the DOM
  this.element = document.createElement("DIV");
  this.element.innerHTML = innerHTML;
  this.onLoad = new Array();
  this.onBeforeUnload = new Array();
  this.onUnload = new Array();

  // Find any scripts
  TempestNS.Ajax.ActivateScripts(this.element);
  
  return this;
};

/**
 <summary>
 </summary>
**/
PTLib.Popin.prototype.constructor = PTLib.Popin;

/**
 <summary>
 </summary>
**/
PTLib.Popin.prototype.show = function(left, top)
{
  document.body.appendChild(this.element);
  this.element.style.position = "absolute";
  this.element.style.top = (document.body.scrollTop + left) + "px";
  this.element.style.left = (document.body.scrollLeft + right) + "px";
  this.isActive = true;
};


/**
 <summary>
  Replaces PT_ajaxRequest.  Functions for ajax get and post methods retrieve some content without a page refresh.
  If postParams is null, we do a GET otherwise we do a POST, and the postParams are sent as the Form values.
  If status is true, the request was successful.
 </summary>
 <param name="url">Address to reference</param>
 <param name="myCallback">Should be a function(xhr, status)</param>
 <param name="postParams"></param>
**/
TempestNS.Ajax.MakeRequest = function(url, myCallback, postParams)
{
  var xhr = new TempestNS.Ajax(url, myCallback);
  if(postParams != null)
  {
    xhr.Open("post");
  }
  else
  {
    xhr.Open("get");
  }
  xhr.Send(postParams);
};
PT_ajaxRequest = TempestNS.Ajax.MakeRequest;


/**
 <summary>
  Replaces PT_loadFrameAjax.  Load content into a page without a page refresh.  Like PT_loadFrame, but this uses 
  XmlHttpRequest instead of iframes.  This requests the content at the given url when the content is loaded, we 
  copy the loaded HTML (in its entirety) into destination (the id - or the element itself) in the current page 
  where the content should be placed the previous contents of destination are overwritten.
 </summary>
 <param name="url"></param>
 <param name="destination">The id of the element in the current page where the content should be placed.</param>
 <param name="onload">An additional function to be run after the content is loaded and copied.</param>
 <param name="postParams"></param>
**/
TempestNS.Ajax.LoadFrame = function(url, destination, onloadCallback, postParams)
{
  // destination can either be an id or the element itself
  if(destination == null)
  {
    return;  // Maybe set error message here
  }
  if(typeof destination == "string")
  {
    destination = document.getElementById(destination);
  }
  
  // create a callback function that will run when the content has been loaded
  // this is used to transfer the loaded contents to the desired destination and
  // run a caller-specified onload function
  var myCallback = function(xhr) 
  { 
    if(destination != null)
    {
      // get the loaded content
      // and insert it in the destination
      var loadedText = xhr.responseText;
      var loadedXml = xhr.responseXML;
      var newDest = document.createElement("DIV");
      newDest.innerHTML = loadedText;
      newDest.id = destination.id;
      newDest.className = destination.className;
      var myParent = destination.parentNode;
      myParent.replaceChild(newDest, destination);
      // destination.innerHTML = loadedText;

      // activate any scripts that have been loaded by evaluating them
      TempestNS.Ajax.ActivateScripts(newDest);
    }
    // run the caller-specified onload function
    if(onloadCallback)
    { 
      onloadCallback(xhr); 
    }
  };
  
  // request the content
  TempestNS.Ajax.MakeRequest(url, myCallback, postParams);
};
PT_loadFrameAjax = TempestNS.Ajax.LoadFrame;


/**
 <summary>
  Replaces PTButtonCmdAjax.  Called by ptt:button when action=ajaxPost.
 </summary>
 <param name="url"></param>
 <param name="destination"></param>
 <param name="onloadCallback"></param>
 <param name="cmd"></param>
 <param name="controlList">A comma-delimited list of (possibly wild-carded) control ids whose values we should include.</param>
**/
TempestNS.Ajax.ButtonCmd = function(url, destination, onloadCallback, cmd, controlList, controlContainer, validationGroup)
{
  //var form = document.getElementById('_pttmf');

  var container = null;
  if(controlContainer)
  {
    container = document.getElementById(controlContainer);
  }
  if(container == null)
  {
    container = document;
  }
  
  /* if you come across an command that does not need a controlList see Brendan to discuss options */
  var p = TempestNS.Ajax.PrepareParams(controlList, container, validationGroup);
  //alert(p);
  if(p == false)
  {
    // Does not validate
    return false;
  }
  else if(p != '')
  {
    var postParams = "ptButtonCmd=" + cmd + "&ptButtonValidate=true"+ p;
  }
  else
  {
    var postParams = "ptButtonCmd=" + cmd + "&ptButtonValidate=false";
  }
  //alert(postParams);
   
  TempestNS.Ajax.LoadFrame(url, destination, onloadCallback, postParams);
};
PTButtonCmdAjax = TempestNS.Ajax.ButtonCmd;


/**
 <summary>
  Replaces PT_ajaxShowAlert.  Use this as a callback function to PTButtonCmdAjax. This will  
  grab the HTML content that would otherwise be placed in the destination element and instead  
  place it in a floating element which is located in the visible portion of the current window.
 </summary>
 <param name="xhr">XMLHttpRequest object</param>
 <param name="status">Response message</param>
**/
TempestNS.Ajax.ShowAlert = function(xhr, status)
{
  // When this was PT_ajaxShowAlert, status was a boolean xhr.status == 200
  // now it is the callbackArgs, that are not set when the callback is set up
  if(status || xhr.status == 200)
  {
    TempestNS.Ajax.RemoveAlert();
    
    // create a new DIV and attach it to the document
    window.PT.PT_curAlert = document.createElement("DIV");
    document.body.appendChild(window.PT.PT_curAlert);
    
    // position the DIV relative to the current scrolling position of the page
    window.PT.PT_curAlert.style.position = "absolute";
    window.PT.PT_curAlert.style.top = (document.body.scrollTop + 155) + "px";
    window.PT.PT_curAlert.style.left = (document.body.scrollLeft + 100) + "px";
    
    // and copy the content from the ajax request into the div
    window.PT.PT_curAlert.innerHTML = xhr.responseText;

    var winH = document.body.clientHeight;
    var winW = document.body.clientWidth;
    var ptH = window.PT.PT_curAlert.clientHeight;
    var ptW = window.PT.PT_curAlert.clientWidth;

    if(ptH > (winH + 310)  || ptW >(winW + 200))
    {
      window.PT.PT_curAlert.style.width= (winW - 200)+"px";
      window.PT.PT_curAlert.style.height= (winH - 310)+"px";
      window.PT.PT_curAlert.style.overflow = "auto";
    }
    
    TempestNS.Ajax.ActivateScripts(window.PT.PT_curAlert);
  }
  else
  {
    // display the best error message we can
    //Add a check onto the status in case is comes back unreadable (for FF)
    var myStatus = "";
    try
    {
      myStatus = xhr.statusText;
    }
    catch(e)
    {
      myStatus = "There has been a problem";
    }
    alert("Ajax error: " + myStatus);
  }
};
PT_ajaxShowAlert = TempestNS.Ajax.ShowAlert;


/**
 <summary>
  
 </summary>
 <param name=""></param>
**/
TempestNS.Ajax.RemoveAlert = function()
{
  if(window.PT.PT_curAlert != null)
  {
    window.PT.PT_curAlert.parentNode.removeChild(window.PT.PT_curAlert);
    window.PT.PT_curAlert = null;
    if(window.PT.PT_OnAlertDismiss && window.PT.PT_OnAlertDismiss != null)
    {
      window.PT.PT_OnAlertDismiss();
    }
  }
};
PT_ajaxRemoveAlert = TempestNS.Ajax.RemoveAlert;


/**
 <summary>
  Do a synchronous GET
 </summary>
 <param name=""></param>
**/
TempestNS.Ajax.GetUrl = function(url)
{
  var xhr = new TempestNS.Ajax(url, null, null, false);
  xhr.open("get");
  xhr.send();
  return xhr;
};
PT_ajaxGetUrl = TempestNS.Ajax.GetUrl;


/**
 <summary>
  Replaces PT_ajaxPrepareToUploadFile. A user has clicked on the "attach a file" button,
  construct the elements necessary to choose the file and display its status.
 </summary>
 <param name="parentEl">where to house the file input element</param>
 <param name="msgGuid">the guid of the message to which the file will be attached</param>
 <param name="fileChosenCallback">a function with signature f(fileCtl). This function will be called when the user has chosen a file. fileCtl will be the input type=file. Caller can process this event, e.g. display some UI that says that this file is being uploaded and then should call PT_ajaxUploadFile()</param>
 <param name="postActionDest">the form action</param>
 <param name="thumbSize">the byte size of the thumbnail, defaults to 64.</param>
**/
TempestNS.Ajax.PrepareToUploadFile = function(parentEl, msgGuid, fileChosenCallback, postActionDest, thumbSize)
{
  // Create form and iframe
  var xhr = new TempestNS.Ajax();
  xhr._bridge = parentEl;
  xhr._prefix = null;
  xhr.SetBridge();
  
  // Set action
  xhr._form.action = postActionDest;
  
  // Add file input field and set listener
  var fileCtl = xhr.AddFormField(xhr._form, "file", "fileCtl");
  TempestNS.Client.AddEventListener(fileCtl, "change", function(evt){ fileChosenCallback(fileCtl); }, true);
  
  // Add related fields  
  xhr.AddFormField(xhr._form, "hidden", "uf_msgGuid", msgGuid);
  if(thumbSize)
  {
    xhr.AddFormField(xhr._form, "hidden", "ptButtonCmd", "cmdUploadFile(uf,true,"+ thumbSize +")");
  }
  else
  {
    xhr.AddFormField(xhr._form, "hidden", "ptButtonCmd", "cmdUploadFile(uf,true,64)");
  }
  xhr.AddFormField(xhr._form, "hidden", "ptButtonValidate", "false");
   
  // Return a ref to the form
  return xhr._form;
};
PT_ajaxPrepareToUploadFile = TempestNS.Ajax.PrepareToUploadFile;


/**
 <summary>
  Replaces PT_ajaxUploadFile. Begin a background upload of a file to be attached
 </summary>
 <param name="frm">the posting form built by PT_ajaxPrepareToUploadFile</param>
 <param name="fileLoadedCallback">a function with signature f(errorMsg, results, stateObj) that is called 
 when the upload completes if errorMsg is not null, then some error occurred, and the errorMsg gives details 
 otherwise results is a structure that holds information about the uploaded file, e.g. its file size, height 
 and width, guid, mimeType, etc. see below for details</param>
 <param name="stateObj">?</param>
 <param name="tAjaxObj">Hopefully the object created by PrepareToUploadFile</param>
**/
TempestNS.Ajax.UploadFile = function(frm, fileLoadedCallback, stateObj, tAjaxObj)
{
  var ifr;
  if(tAjaxObj)
  {
    frm = tAjaxObj._form;
    ifr = tAjaxObj._iframe;
  }
  else if(frm)
  {
    ifr = TempestNS.Ajax.CreateBridgeIframe(document.body);
    frm.target = ifr.name;
  }
  
  var GetAttribute = function(doc, attrName){
    // build a reg exp that looks for the attribute name plus everything inside the following quotes
    var re = new RegExp(attrName + '="(.+?)"');
    // execute the reg exp against the input, and return the group inside the quotes
    var m = re.exec(doc);
    if (!m || m.length == 0) return "";
    return m[1];
  };
  
  var IfrLoadedCallback = function(evt){
    // get the document of the iframe and get upload status and size
    var ifrDoc = TempestNS.Client.GetIframeDoc(ifr);
    var resultsDoc = ifrDoc.body.innerHTML;
    
    if (resultsDoc.substring(0, 6) == "Error:")
    {
      fileLoadedCallback(resultsDoc);  // indicate error
    }
    else
    {
      var results = new Object();   
      results["document"] = resultsDoc;
      results["docSizeKB"] = GetAttribute(resultsDoc, "docSize");
      results["docGuid"] = GetAttribute(resultsDoc, "cguid");
      results["currHeight"] = GetAttribute(resultsDoc, "height");
      results["currWidth"] = GetAttribute(resultsDoc, "width");
      results["mimeType"] = GetAttribute(resultsDoc, "mimeType");
      results["isImage"] = results["mimeType"].substr(0, 6) == "image/";
      results["url"] = GetAttribute(resultsDoc, "url");
      results["thumbUrl"] = GetAttribute(resultsDoc, "thumbUrl");
      results["index"] = PT_nextUploadFileIndex++;
      fileLoadedCallback(null, results, stateObj);
    }
  
    // remove the form and the iframe
    if (frm) frm.parentNode.removeChild(frm);   
    if (ifr) setTimeout(function(){ ifr.parentNode.removeChild(ifr); }, 0);
  };

  // add the hook to call ifrLoaded
  TempestNS.Client.AddEventListener(ifr, "load", IfrLoadedCallback, false);

  // upload the document
  frm.submit();
  
};
PT_ajaxUploadFile = TempestNS.Ajax.UploadFile;
PT_nextUploadFileIndex = 0;





 
  

/**
 <summary>
  Submit Prospero Template Commands and manage results
 </summary>
 <param name=""></param>
**/
TempestNS.CommandHandler = function()
{
  /* If one already exists then use it */
  if(TempestNS.COMMANDHANDLER)
  {
    return;
  }
  /* Otherwise, create new global TempestNS.COMMANDHANDLER */
  TempestNS.COMMANDHANDLER = this;
  /* Create a object to hold in-process commands (their callbacks) */
  this.CommandCallbacks = new Object();
  this.nextCommandId = 1;
};



/**
 <summary>
 </summary>
 <param name="widgetId"></param>
 <param name="application"></param>
 <param name="cmd"></param>
 <param name="controlList"></param>
**/
TempestNS.CommandHandler.SendCommand = function(widgetId, application, webtag, cmd, form, controlList, callback)
{
  var src = location.protocol +"/";
  src += "/" + TempestNS.Server.domain;
  src += TempestNS.Server.Apps[application];
  src += "?webtag=" + webtag;
  src += (widgetId) ? "&widgetId="+ widgetId : "";
  src += "&nav=jsscommandhandler";
  src += "&dst="+escape(new Date().toString());
  
  try
  {
  // FB 64642: Experience needs to be part of the url for OS 2.5
  if(TempestNS.Server.expId != '')
  {         
     src += "&experienceId=" + TempestNS.Server.expId;
  }
  else
  {
    var locationTemp = location.href;
    var locationArr = new Array();
    locationArr = locationTemp.split("/");
    
    for(var i=0; i<= locationArr.length -1; i++)
    {
      if(locationArr[i] != null)
      {
        if(locationArr[i].toLowerCase() == 'exp')  
        {
           if(locationArr[i+1] != '')
           src += "&experienceId=" + locationArr[i+1];
        }
      }  
    }
  }
  }
  catch(err)
  {  }
  
  if(TempestNS.Server.dbg)
  {
    src += "&dbg=" + TempestNS.Server.dbg;
  }
  
  if(callback)
  {
    this.CommandCallbacks[widgetId] = callback;
  }
 
  src += "&ptButtonCmd=" + escape(cmd) + "&ptButtonValidate=false";
  src += TempestNS.Ajax.PrepareParams(controlList, form);
  
  TempestNS.Client.IncludeScript(src);
};

TempestNS.CommandHandler.CommandComplete = function(widgetId, commandResult)
{
  var callback = this.CommandCallbacks[widgetId];
  if (callback)
  {
    callback(commandResult);
  }
};

TempestNS.CommandHandler.SendCommandViaIframe = function(widgetId, application, webtag, cmd, form, controlList, callback)
{
  var src = location.protocol +"/";
  src += "/" + TempestNS.Server.domain;
  src += TempestNS.Server.Apps[application];
  src += "?webtag=" + webtag;
  src += (widgetId) ? "&widgetId="+ widgetId : "";
  src += "&nav=jsscommandhandlerviaiframe";
  src += "&dst="+escape(new Date().toString());
  if(TempestNS.Server.dbg)
  {
    src += "&dbg=" + TempestNS.Server.dbg;
  }
  
  if(callback)
  {
    this.CommandCallbacks[widgetId] = callback;
  }
 
  // Set Domain
  var parentDomain = TempestNS.WIDGETMANAGER.GetRootDomain(window.location.host);
  document.domain = parentDomain;

  // Set Bridge
  var ajaxObj = new TempestNS.Ajax();
  ajaxObj.SetBridge();
   
  // Set Fields in Form 
  for(var i = 0; i < controlList.length; i++)
  {
    for(var j = 0; j < controlList[i].length; j++)
    {
      var ctlVal = TempestNS.Client.GetControlValue(controlList[i][j]);
      if(ctlVal)
      {
        //alert(ctlVal);
        ajaxObj.AddFormField(ajaxObj._form, controlList[i][j].type, controlList[i][j].name, ctlVal);
      }
    }
  }
  ajaxObj.AddFormField(ajaxObj._form, "text", "ptButtonCmd", cmd);
  ajaxObj.AddFormField(ajaxObj._form, "text", "ptButtonValidate", "true");
  
  // Submit It
  ajaxObj._form.action = src +"&parentDomain="+ parentDomain;
	ajaxObj._form.submit();	
};


/**
** An alias of the SetRelationship fucntion, specifying "ignore" as the relationship.
**/
TempestNS.CommandHandler.IgnoreUser = function(webtag, userId, callback)
{
  this.SetRelationship(webtag,userId,"ignore",callback);  
};

/**
** An alias of the SetRelationship fucntion, specifying "friend" as the relationship.
**/
TempestNS.CommandHandler.AddFriend = function(webtag, userId, callback)
{
  this.SetRelationship(webtag,userId,"friend",callback);   
};

/**
** An alias of the SetRelationship fucntion, specifying "neutral" as the relationship.
**/
TempestNS.CommandHandler.ResetRelationship = function(webtag, userId, callback)
{
  this.SetRelationship(webtag,userId,"neutral",callback);  
};

/**
**  Creates or updates a Roster Item
**  webtag - webtag of the forum which contains the user
**  userId - userId to act on
**  relationship - friend, ignore, neutral -- required to determine relationship value to set
**  callback - javascript function to call on completion
**/
TempestNS.CommandHandler.SetRelationship = function(webtag, userId, relationship, callback)
{
  var cmdId = 'PCmd' + this.nextCommandId;
  this.nextCommandId++;
  var cmd = 'rosterSetRelationship(' + userId + ',' + relationship + ')';
    if(TempestNS.Server.dbg == '53')
  {
      alert(cmd);
   }
  this.SendCommand(cmdId, 'forum', webtag, cmd, null, null, callback);  
};

/**
**  Sets the rating on a message.
**  tid - message tid
**  tsn - message tsn
**  ratingValue - Integer (0-5) rating to set.
**/
TempestNS.CommandHandler.SetMessageRating = function(webtag, tid, tsn, ratingValue, callback)
{
  var cmdId = 'PCmd' + this.nextCommandId;
  this.nextCommandId++;
  var cmd = 'cmdSetMessageRating(' + tid + ',' + tsn + ',' + ratingValue + ')';
  this.SendCommand(cmdId, 'forum', webtag, cmd, null, null, callback);  
};

TempestNS.CommandHandler.AddFolder = function(webtag, formName, fldPrefix, ctlList, callback)
{
  var cmdId = 'PCmd' + this.nextCommandId;
  this.nextCommandId++;
  var cmd = 'cmdAddRepoFolder(' + fldPrefix + ')';
  this.SendCommand(cmdId, 'filerepository', webtag, cmd, formName, ctlList, callback);  
};

/**
**  Send an email message.
**  fieldPrefix - All fields that are referenced by this command must have IDs comprised of this prefix, followed by an underscore, followed by the field name.
**  form - form that contains the fields that begin with the fieldPrefix
**/
TempestNS.CommandHandler.EmailSend = function(webtag, fieldPrefix, form, callback)
{
  var cmdId = 'PCmd' + this.nextCommandId;
  this.nextCommandId++;
  var cmd = 'cmdEmailSend(' + fieldPrefix + ')';
  this.SendCommand(cmdId, 'forum', webtag, cmd, form, fieldPrefix+'*', callback);
};

/**
**  Delete a single message.
**  tid - tid of message
**  tsn - tsn of message to delete
**/
TempestNS.CommandHandler.MsgDelete = function(webtag, tid, tsn, callback)
{
  var cmdId = 'PCmd' + this.nextCommandId;
  this.nextCommandId++;
  var cmd = 'cmdMsgDelete(' + tid + ',' + tsn + ')';
  this.SendCommand(cmdId, 'forum', webtag, cmd, null, null, callback);
};

/**
**  Delete a message.
**  msg - The message to delete, formatted as tid.tsn
**/
TempestNS.CommandHandler.ApplyDelete = function(webtag, msg, callback)
{
  var cmdId = 'PCmd' + this.nextCommandId;
  this.nextCommandId++;
  var cmd = 'cmdApplyDelete(' + msg + ')';
  this.SendCommand(cmdId, 'forum', webtag, cmd, null, null, callback);  
};

/**
**  Sets the interest level on a discussion.
**  tid - tid of discussion to set interest level of.
**  newLevel - the interest level to set.  Integer 0, 1, or 2
**/
TempestNS.CommandHandler.SetInterestLevel = function(webtag, tid, newLevel, callback)
{
  var cmdId = 'PCmd' + this.nextCommandId;
  this.nextCommandId++;
  var cmd = 'setInterestLevel('+ tid + ',' + newLevel + ')';
  this.SendCommand(cmdId, 'forum', webtag, cmd, null, null, callback);
};

/**
**  Mark all discussions older than the date specified as read.
**  newestDate - Discussions older than this will be treated as having been read.
**/
TempestNS.CommandHandler.MarkAsRead = function(webtag, newestDate, callback)
{
  var cmdId = 'PCmd' + this.nextCommandId;
  this.nextCommandId++;
  var cmd = 'cmdMarkAsRead(' + newestDate + ')';
  this.SendCommand(cmdId, 'forum', webtag, cmd, null, null, callback);
};

/**
**  Send a Terms-of-Service Violation Report
**  fieldPrefix - All fields that are referenced by this command must have IDs comprised of this prefix, followed by an underscore, followed by the field name.
**  form - form that contains the fields that begin with the fieldPrefix
**/
TempestNS.CommandHandler.SendTOSViolationReport = function(webtag, fieldPrefix, form, callback)
{
  var cmdId = 'PCmd' + this.nextCommandId;
  this.nextCommandId++;
  var cmd = 'cmdSendTOS(' + fieldPrefix + ')';
  this.SendCommand(cmdId, 'forum', webtag, cmd, form, fieldPrefix+'*', callback);
};

/**
**  Send the current message by email to somebody else.  If no template name is specified in the parameters, then a standard format header is prepended to the body, and the template Forum.CCMessage is invoked.
**  fieldPrefix - All fields that are referenced by this command must have IDs comprised of this prefix, followed by an underscore, followed by the field name.
**  templateName - If a template name is specified as the second command argument, a templated email message is generated and sent.  This functionality is then identical to that provided by cmdEmailSend.  All
**  fields with the specified prefix are available in the template as params with the same names (without prefix, of course)
**  form - form that contains the fields that begin with the fieldPrefix
**/
TempestNS.CommandHandler.ForwardMessage = function(webtag, fieldPrefix, templateName, form, callback)
{
  var cmdId = 'PCmd' + this.nextCommandId;
  this.nextCommandId++;
  var cmd = "";
  if(templateName != null)
  {
    cmd = 'cmdForward(' + fieldPrefix +',' + templateName + ')'; 
  }
  else
  { 
    cmd = 'cmdForward(' + fieldPrefix +')'; 
  }
  this.SendCommand(cmdId, 'forum', webtag, cmd, form, fieldPrefix+'*', callback);
};

TempestNS.CommandHandler.SetPresence = function(webtag, fieldPrefix, form, callback)
{
  var cmdId = 'PCmd' + this.nextCommandId;
  this.nextCommandId++;
  var cmd = 'cmdSetPresence(' + fieldPrefix +')';
  this.SendCommand(cmdId, 'forum', webtag, cmd, form, fieldPrefix+'*', callback);
};

/**
**  Casts a vote in a poll
**  fieldPrefix - All fields that are referenced by this command must have IDs comprised of this prefix, followed by an underscore, followed by the field name.
**  form - form that contains the fields that begin with the fieldPrefix
**  fields:  
**    choice - The number of the desired choice (1 thru 25). A choice of 0 means don't enter a vote. A choice of -1 means remove any previous vote.
**    tid - The tid of the poll discussion.
**/
TempestNS.CommandHandler.Vote = function(webtag, fieldPrefix, form, callback)
{
  var cmdId = 'PCmd' + this.nextCommandId;
  this.nextCommandId++;
  var cmd = 'cmdVote(' + fieldPrefix +')';
  this.SendCommand(cmdId, 'forum', webtag, cmd, form, fieldPrefix+'*', callback);
};

/**
**  Creates a new poll.
**  fieldPrefix - All fields that are referenced by this command must have IDs comprised of this prefix, followed by an underscore, followed by the field name.
**  form - form that contains the fields that begin with the fieldPrefix
**  fields:  
**    allowVoteChanges - If true, then users may change their votes after casting them.
**    choice[n] - The text of the poll answers (choices). n can be from 1 to 25.
**    expiration - The number of days until the poll is closed. If -1, then it never closes.
**    folderId - The folderId of the folder where the poll should reside.
**    graphType - if 1 =&gt; vertical, else horiztonal.
**    sendAsHtml - If true, then the question and choices can contain HTML markup.
**    showResults - If true, then users may view the results of the poll before the poll closes.
**    subject - The subject of the poll, i.e. the poll question
**    toScreenName - The screenname of the addressee of the poll. Should be ALL.
**    tid - This is used when editing an existing poll
**/
TempestNS.CommandHandler.NewPoll = function(webtag, fieldPrefix, form, callback)
{
  var cmdId = 'PCmd' + this.nextCommendId;
  this.nextCommandId++;
  var cmd = 'cmdNewPoll(' + fieldPrefix +')';
  this.SendCommand(cmdId, 'forum', webtag, cmd, form, fieldPrefix+'*', callback);
};

/**
**  Ends a current poll
**  fieldPrefix - All fields that are referenced by this command must have IDs comprised of this prefix, followed by an underscore, followed by the field name.
**  form - form that contains the fields that begin with the fieldPrefix
**  fields:  
**    tid - The tid of the poll discussion to be deleted.
**/
TempestNS.CommandHandler.EndPoll = function(webtag, fieldPrefix, form, callback)
{
  var cmdId = 'PCmd' + this.nextCommandId;
  this.nextCommandId++;
  var cmd = 'cmdEndPoll(' + fieldPrefix +')';
  this.SendCommand(cmdId, 'forum', webtag, cmd, form, fieldPrefix+'*', callback); 
};

/**
**  Add a forum or forums to current user's list of favorites.
**  fieldPrefix - All fields that are referenced by this command must have IDs comprised of this prefix, followed by an underscore, followed by the field name.
**  form - form that contains the fields that begin with the fieldPrefix
**  fields:  
**    for check boxes - id = [fieldprefix]_[forumId]  Any checked boxes will be added to list.
**    for list boxes - item values = [forumId]  Any selected items will be added to list.
**/
TempestNS.CommandHandler.SetMyForums = function(webtag, fieldPrefix, form, callback)
{
  var cmdId = 'PCmd' + this.nextCommandId;
  this.nextCommandId++;
  var cmd = 'cmdMyForumsSet(' + fieldPrefix +')';
  this.SendCommand(cmdId, 'forum', webtag, cmd, form, fieldPrefix+'*', callback);
};

/**
**  Remove a forum or forums from current user's list of favorites.
**  fieldPrefix - All fields that are referenced by this command must have IDs comprised of this prefix, followed by an underscore, followed by the field name.
**  form - form that contains the fields that begin with the fieldPrefix
**  fields:  
**    for check boxes - id = [fieldprefix]_[forumId]  Any checked boxes will be removed from list.
**    for list boxes - item values = [forumId]  Any selected items will be removed from list.
**/
TempestNS.CommandHandler.ResetMyForums = function(webtag, fieldPrefix, form, callback)
{
  var cmdId = 'PCmd' + this.nextCommandId;
  this.nextCommandId++;
  var cmd = 'cmdMyForumsReset(' + fieldPrefix +')';
  this.SendCommand(cmdId, 'forum', webtag, cmd, form, fieldPrefix+'*', callback); 
};

TempestNS.CommandHandler.SetRating = function(webtag, fieldPrefix, form, callback)
{
  var cmdId = 'PCmd' + this.nextCommandId;
  this.nextCommandId++;
  var cmd = 'cmdSetRating(' + fieldPrefix +')';
  this.SendCommand(cmdId, 'forum', webtag, cmd, form, fieldPrefix+'*', callback); 
};

/**
**  Various commands to manage a discussion.
**  fieldPrefix - All fields that are referenced by this command must have IDs comprised of this prefix, followed by an underscore, followed by the field name.
**  action - Action describing which manage command to execute.  Possible values: closediscussion, opendiscussion, deletediscussion, changesubject, movetofolder, movetowebtag,
**       prune, graft, transplant, setsticky
**  form - form that contains the fields that begin with the fieldPrefix
**  fields:  
**    tid - the tid of the discussion to be closed. (always required for each action)
**    various other fields, see specific commands from the action values for required fields.  All fields are required for each command unless otherwise specified.
**/
TempestNS.CommandHandler.ManageDiscussion = function(webtag, fieldPrefix, action, form, callback)
{
  var cmdId = 'PCmd' + this.nextCommandId;
  this.nextCommandId++;
  var cmd = 'cmdManageDiscussion('+ fieldPrefix + ',' + action + ')';
  this.SendCommand(cmdId, 'forum', webtag, cmd, form, fieldPrefix+'*', callback); 
};

/**
**  Close a discussion.
**  fieldPrefix - All fields that are referenced by this command must have IDs comprised of this prefix, followed by an underscore, followed by the field name.
**  form - form that contains the fields that begin with the fieldPrefix
**  fields:  
**    tid - the tid of the discussion to be closed.
**/
TempestNS.CommandHandler.CloseDiscussion = function(webtag, fieldPrefix, form, callback)
{
  this.ManageDiscussion(webtag, fieldPrefix, "closediscussion", form, callback);
};

/**
**  Open a discussion.
**  fieldPrefix - All fields that are referenced by this command must have IDs comprised of this prefix, followed by an underscore, followed by the field name.
**  form - form that contains the fields that begin with the fieldPrefix
**  fields:  
**    tid - the tid of the discussion to be opened.
**/
TempestNS.CommandHandler.OpenDiscussion = function(webtag, fieldPrefix, form, callback)
{
  this.ManageDiscussion(webtag, fieldPrefix, "opendiscussion", form, callback);
};

/**
**  Delete a discussion.
**  fieldPrefix - All fields that are referenced by this command must have IDs comprised of this prefix, followed by an underscore, followed by the field name.
**  form - form that contains the fields that begin with the fieldPrefix
**  fields:  
**    tid - the tid of the discussion to be deleted.
**/
TempestNS.CommandHandler.DeleteDiscussion = function(webtag, fieldPrefix, form, callback)
{
  this.ManageDiscussion(webtag, fieldPrefix, "deletediscussion", form, callback);
};

/**
**  Change the subject of a discussion.
**  fieldPrefix - All fields that are referenced by this command must have IDs comprised of this prefix, followed by an underscore, followed by the field name.
**  form - form that contains the fields that begin with the fieldPrefix
**  fields:  
**    tid - the tid of the discussion to have it's subject changed.
**    newSubject - Text of the new subject (should contain no HTML, but will be stripped if there is)
**/
TempestNS.CommandHandler.ChangeSubject = function(webtag, fieldPrefix, form, callback)
{
  this.ManageDiscussion(webtag, fieldPrefix, "changesubject", form, callback);
};

/**
**  Move a discussion or discussions to a new folder.
**  fieldPrefix - All fields that are referenced by this command must have IDs comprised of this prefix, followed by an underscore, followed by the field name.
**  form - form that contains the fields that begin with the fieldPrefix
**  fields:  
**    tid - the tid of the discussion to be moved to a new folder.
**    newFolderId - the folderId of the new folder the discussion(s) are being moved to.
**    discussions - a comma delimited list of tid(s) to move to specified folder.
**/
TempestNS.CommandHandler.MoveToFolder = function(webtag, fieldPrefix, form, callback)
{
  this.ManageDiscussion(webtag, fieldPrefix, "movetofolder", form, callback);
};

/**
**  Move a discussion or all discussions to a new webtag.
**  fieldPrefix - All fields that are referenced by this command must have IDs comprised of this prefix, followed by an underscore, followed by the field name.
**  form - form that contains the fields that begin with the fieldPrefix
**  fields:  
**    tid - the tid of the discussion to be moved to a new webtag.
**    newWebtag - the new webtag to move discussion(s) to.
**    moveAllDiscussions - if true, all the discussions in the original folder will be moved to the new folder location. 
**    newWebtagFolderId - the new webtag's folder the discussion(s) are moving to.
**    linkOriginalDiscussion - if true, then the original discussion will contain a single message displaying a link to the new discussion location. 
**    If it is not checked, the original discussion will be deleted. 
**/
TempestNS.CommandHandler.MoveToWebtag = function(webtag, fieldPrefix, form, callback)
{
  this.ManageDiscussion(webtag, fieldPrefix, "movetowebtag", form, callback);
};

/**
**  Prune a discussion - Remove a message from the discussion specified along with all of its replies and create a new discussion.
**  fieldPrefix - All fields that are referenced by this command must have IDs comprised of this prefix, followed by an underscore, followed by the field name.
**  form - form that contains the fields that begin with the fieldPrefix
**  fields:  
**    tid - the tid of the discussion to be pruned.
**    newSubjectPrune - new subject of the discussion being created
**    tsnPrune - the tsn to start pruning from
**    newFolderIdPrune - the destination folder of the pruned discussion.
**/
TempestNS.CommandHandler.PruneDiscussion = function(webtag, fieldPrefix, form, callback)
{
  this.ManageDiscussion(webtag, fieldPrefix, "prune", form, callback);
};

/**
**  Graft a discussion - Remove a message from the specified discussion along with all of its replies and insert it in another discussion.
**  fieldPrefix - All fields that are referenced by this command must have IDs comprised of this prefix, followed by an underscore, followed by the field name.
**  form - form that contains the fields that begin with the fieldPrefix
**  fields:  
**    tid - the tid of the discussion to be grafted.
**    tsnGraft - the tsn (that has replies) to be inserted into another discussion.
**    destMsgGraft - In the form of tid.tsn.  This should be the message to which the message to be removed(tsnGraft) should be a reply.
**/
TempestNS.CommandHandler.GraftDiscussion = function(webtag, fieldPrefix, form, callback)
{
  this.ManageDiscussion(webtag, fieldPrefix, "graft", form, callback);
};

/**
**  Transplant a discussion - Insert the entire discussion into another discussion.
**  fieldPrefix - All fields that are referenced by this command must have IDs comprised of this prefix, followed by an underscore, followed by the field name.
**  form - form that contains the fields that begin with the fieldPrefix
**  fields:  
**    tid - the tid of the discussion to be transplanted.
**    destMsgTransplant - the tid.tsn to transplant disscussion to. This should be the message to which the first message of this discussion should be a reply.
**/
TempestNS.CommandHandler.TransplantDiscussion = function(webtag, fieldPrefix, form, callback)
{
  this.ManageDiscussion(webtag, fieldPrefix, "transplant", form, callback);
};

/**
**  Set whether a discussion should contain sticky posts (always new or always unread).
**  fieldPrefix - All fields that are referenced by this command must have IDs comprised of this prefix, followed by an underscore, followed by the field name.
**  form - form that contains the fields that begin with the fieldPrefix
**  fields:  
**    tid - the tid of the discussion to be set sticky.
**    alwaysNew - boolean specifying whether or not to set this discussion as always new.
**    alwaysUnread - boolean specifying whether or not to set this discussion as always unread.
**/
TempestNS.CommandHandler.SetSticky = function(webtag, fieldPrefix, form, callback)
{
  this.ManageDiscussion(webtag, fieldPrefix, "setsticky", form, callback);
};

TempestNS.CommandHandler.Post = function(webtag, fieldPrefix, msgType, form, callback)
{
  var cmdId = 'PCmd' + this.nextCommandId;
  this.nextCommandId++;
  var cmd;
  if(msgType != null) { cmd = 'cmdPost('+ fieldPrefix + ',' + msgType + ')'; }
  else { cmd = 'cmdPost(' + fieldPrefix + ')'; }
  this.SendCommand(cmdId, 'forum', webtag, cmd, form, fieldPrefix+'*', callback); 
};

TempestNS.CommandHandler.SetStatusInfo = function(webtag, fieldPrefix, tid, objectStatusId, comment, form, callback)
{
  var cmdId = 'PCmd' + this.nextCommandId;
  this.nextCommandId++;
  if(fieldPrefix != null)
  {
    var cmd = 'cmdSetStatusInfo(' + fieldPrefix + ')'; 
    this.SendCommand(cmdId, 'forum', webtag, cmd, form, fieldPrefix+'*', callback);
  }
  else
  {
    var cmd = 'cmdSetStatusInfo(' + tid + ',' + objectStatusId + ',' + comment + ')'; 
    this.SendCommand(cmdId, 'forum', webtag, cmd, null, null, callback);
  }
};

TempestNS.CommandHandler.ApplyDeleteByForm = function(webtag, fieldPrefix, form, callback)
{
  var cmdId = 'PCmd' + this.nextCommandId;
  this.nextCommandId++;
  var cmd = 'cmdApplyDelete('+ fieldPrefix + ')';
  this.SendCommand(cmdId, 'forum', webtag, cmd, form, fieldPrefix+'*', callback); 
};

TempestNS.CommandHandler.ApplyEdit = function(webtag, fieldPrefix, msgType, form, callback)
{
  var cmdId = 'PCmd' + this.nextCommandId;
  this.nextCommandId++;
  var cmd = 'cmdApplyEdit('+ fieldPrefix + ',' + msgType + ')';
  this.SendCommand(cmdId, 'forum', webtag, cmd, form, fieldPrefix+'*', callback); 
};

TempestNS.CommandHandler.MoveCategories = function(webtag, fieldPrefix, tid, form, callback)
{
  var cmdId = 'PCmd' + this.nextCommandId;
  this.nextCommandId++;
  var cmd = 'cmdMoveCategories('+ fieldPrefix + ',' + tid + ')';
  this.SendCommand(cmdId, 'forum', webtag, cmd, form, fieldPrefix+'*', callback); 
};


TempestNS.CommandHandler.MemberSet = function(webtag, fieldPrefix, userId, form, callback)
{
  var cmdId = 'PCmd' + this.nextCommandId;
  this.nextCommandId++;
  var cmd = 'cmdMemberSet('+ fieldPrefix + ',' + userId + ')';
  this.SendCommand(cmdId, 'forum', webtag, cmd, form, fieldPrefix+'*', callback); 
};

TempestNS.CommandHandler.UploadFile = function(webtag, fieldPrefix, includeUrl, thumbMaxSize, form, callback)
{
  var cmdId = 'PCmd' + this.nextCommandId;
  this.nextCommandId++;
  var cmd = 'cmdUploadFile('+ fieldPrefix + ',' + includeUrl + ',' + thumbMaxSize + ')';
  this.SendCommand(cmdId, 'forum', webtag, cmd, form, fieldPrefix+'*', callback); 
};


TempestNS.CommandHandler.SetListMode = function(webtag, val, callback)
{
  var cmdId = 'PCmd' + this.nextCommandId;
  this.nextCommandId++;
  var cmd = 'mbListGoValue(' + val + ')';
  this.SendCommand(cmdId, 'forum', webtag, cmd, null, null, callback);  
};


TempestNS.CommandHandler.prototype.SendCommand                = TempestNS.CommandHandler.SendCommand;
TempestNS.CommandHandler.prototype.SendCommandViaIframe       = TempestNS.CommandHandler.SendCommandViaIframe;
TempestNS.CommandHandler.prototype.CommandComplete            = TempestNS.CommandHandler.CommandComplete;
TempestNS.CommandHandler.prototype.IgnoreUser                 = TempestNS.CommandHandler.IgnoreUser;
TempestNS.CommandHandler.prototype.AddFriend                  = TempestNS.CommandHandler.AddFriend;
TempestNS.CommandHandler.prototype.ResetRelationship          = TempestNS.CommandHandler.ResetRelationship;
TempestNS.CommandHandler.prototype.SetRelationship            = TempestNS.CommandHandler.SetRelationship;
TempestNS.CommandHandler.prototype.SetMessageRating           = TempestNS.CommandHandler.SetMessageRating;
TempestNS.CommandHandler.prototype.EmailSend                  = TempestNS.CommandHandler.EmailSend;
TempestNS.CommandHandler.prototype.MsgDelete          = TempestNS.CommandHandler.MsgDelete;
TempestNS.CommandHandler.prototype.ApplyDelete                = TempestNS.CommandHandler.ApplyDelete;
TempestNS.CommandHandler.prototype.SetInterestLevel           = TempestNS.CommandHandler.SetInterestLevel;
TempestNS.CommandHandler.prototype.MarkAsRead                 = TempestNS.CommandHandler.MarkAsRead;
TempestNS.CommandHandler.prototype.SendTOSViolationReport     = TempestNS.CommandHandler.SendTOSViolationReport;
TempestNS.CommandHandler.prototype.ForwardMessage             = TempestNS.CommandHandler.ForwardMessage;
TempestNS.CommandHandler.prototype.SetPresence          = TempestNS.CommandHandler.SetPresence;
TempestNS.CommandHandler.prototype.AddFolder                  = TempestNS.CommandHandler.AddFolder;
TempestNS.CommandHandler.prototype.Vote              = TempestNS.CommandHandler.Vote;
TempestNS.CommandHandler.prototype.NewPoll            = TempestNS.CommandHandler.NewPoll;
TempestNS.CommandHandler.prototype.EndPoll            = TempestNS.CommandHandler.EndPoll;
TempestNS.CommandHandler.prototype.SetMyForums          = TempestNS.CommandHandler.SetMyForums;
TempestNS.CommandHandler.prototype.ResetMyForums        = TempestNS.CommandHandler.ResetMyForums;
TempestNS.CommandHandler.prototype.SetRating          = TempestNS.CommandHandler.SetRating;
TempestNS.CommandHandler.prototype.ManageDiscussion        = TempestNS.CommandHandler.ManageDiscussion;
TempestNS.CommandHandler.prototype.CloseDiscussion        = TempestNS.CommandHandler.CloseDiscussion;
TempestNS.CommandHandler.prototype.OpenDiscussion        = TempestNS.CommandHandler.OpenDiscussion;
TempestNS.CommandHandler.prototype.DeleteDiscussion        = TempestNS.CommandHandler.DeleteDiscussion;
TempestNS.CommandHandler.prototype.ChangeSubject        = TempestNS.CommandHandler.ChangeSubject;
TempestNS.CommandHandler.prototype.MoveToFolder          = TempestNS.CommandHandler.MoveToFolder;
TempestNS.CommandHandler.prototype.MoveToWebtag          = TempestNS.CommandHandler.MoveToWebtag;
TempestNS.CommandHandler.prototype.PruneDiscussion        = TempestNS.CommandHandler.PruneDiscussion;
TempestNS.CommandHandler.prototype.GraftDiscussion        = TempestNS.CommandHandler.GraftDiscussion;
TempestNS.CommandHandler.prototype.TransplantDiscussion      = TempestNS.CommandHandler.TransplantDiscussion;
TempestNS.CommandHandler.prototype.SetSticky          = TempestNS.CommandHandler.SetSticky;
TempestNS.CommandHandler.prototype.Post                          = TempestNS.CommandHandler.Post;
TempestNS.CommandHandler.prototype.SetStatusInfo                 = TempestNS.CommandHandler.SetStatusInfo;
TempestNS.CommandHandler.prototype.ApplyDeleteByForm             = TempestNS.CommandHandler.ApplyDeleteByForm;
TempestNS.CommandHandler.prototype.ApplyEdit                     = TempestNS.CommandHandler.ApplyEdit;
TempestNS.CommandHandler.prototype.MoveCategories                = TempestNS.CommandHandler.MoveCategories;
TempestNS.CommandHandler.prototype.MemberSet                     = TempestNS.CommandHandler.MemberSet;
TempestNS.CommandHandler.prototype.UploadFile                    = TempestNS.CommandHandler.UploadFile;
TempestNS.CommandHandler.prototype.SetListMode = TempestNS.CommandHandler.SetListMode;

new TempestNS.CommandHandler();


 TempestNS.DEBUG_WIN=null;TempestNS.Debug_Out=function(exception,object,funcName){if(!TempestNS.DEBUG_ON)return;if(TempestNS.DEBUG_WIN==null){TempestNS.DEBUG_WIN=document.createElement("div");TempestNS.DEBUG_WIN.style.position="absolute";TempestNS.DEBUG_WIN.style.top="0px";TempestNS.DEBUG_WIN.style.left="800px";TempestNS.DEBUG_WIN.style.width="400px";TempestNS.DEBUG_WIN.style.height="800px";TempestNS.DEBUG_WIN.style.overflow="auto";TempestNS.DEBUG_WIN.style.backgroundColor="white";document.body.appendChild(TempestNS.DEBUG_WIN);}var stemp="";if(funcName){stemp+="<strong>"+funcName+"</strong><br/>"}else{stemp+="<strong>error</strong><br/>";}for(s in exception){stemp+=s+":"+exception[s]+"<br/>";}stemp+="<br/><br/>";stemp+="<strong>object</strong><br/>";for(s in object){stemp+=s+":";if(typeof(object[s])!="function"){stemp+=object[s];}else{stemp+="function";}stemp+="<br/>";}stemp+="<br/><br/>";TempestNS.DEBUG_WIN.innerHTML=TempestNS.DEBUG_WIN.innerHTML+stemp;};TempestNS.Registered_Component=function(){this._parentContainer=null;this._hasAlreadyBeenLoaded=false;};TempestNS.Registered_Component.Register=function(Control_Prefix,Parent){if(!TempestNS.COMPONENT_REGISTRY){new TempestNS.Component_Register();}this._refIndex=Control_Prefix+TempestNS.Registered_Component.count++;this._parentContainer=Parent;this._control=Control_Prefix;if(Parent&&Parent._Components){this._ref=Parent._ref+"._Components['"+this._refIndex+"']";Parent._Components[this._refIndex]=this;this._Is_Registered=true;}else if(TempestNS.COMPONENT_REGISTRY){this._ref="TempestNS.COMPONENT_REGISTRY._Components['"+this._refIndex+"']";TempestNS.COMPONENT_REGISTRY._Components[this._refIndex]=this;this._Is_Registered=true;}};TempestNS.Registered_Component.CopyProperties=function(object){for(var prop in object){this[prop]=object[prop];}};TempestNS.Registered_Component.RaiseEvent=function(eventName,jArg){if(this._eventListeners[eventName]){this._eventListeners[eventName](jArg);}else{if(this._parentContainer){if(this._parentContainer.Listen){this._parentContainer.Listen(eventName,jArg);}}}};TempestNS.Registered_Component.prototype.register=TempestNS.Registered_Component.Register;TempestNS.Registered_Component.prototype.OnLoad=function(){};TempestNS.Registered_Component.prototype.OnUnload=function(){};TempestNS.Registered_Component.prototype.OnResize=function(){};TempestNS.Registered_Component.prototype.CopyProperties=TempestNS.Registered_Component.CopyProperties;TempestNS.Registered_Component.prototype.RaiseEvent=TempestNS.Registered_Component.RaiseEvent;TempestNS.Registered_Component.count=0;TempestNS.Registered_Container=function(){TempestNS.Registered_Component.call(this);this._Components=new Object();this._eventListeners=new Object();};TempestNS.Registered_Container.UnloadChildren=function(){for(var s in this._Components){try{this._Components[s].OnUnload();this._Components[s]=null;}catch(exception){TempestNS.Debug_Out(exception,this._Components[s],"Unload");}}this._Components=new Object();};TempestNS.Registered_Container.LoadChildren=function(){for(var s in this._Components){try{this._Components[s].OnLoad();}catch(exception){TempestNS.Debug_Out(exception,this._Components[s],"Load");}}};TempestNS.Registered_Container.ResizeChildren=function(){for(var s in this._Components){try{this._Components[s].OnResize();}catch(exception){TempestNS.Debug_Out(exception,this._Components[s],"resize");}}};TempestNS.Registered_Container.CallChildren=function(Method,args){for(var s in this._Components){try{if(typeof this._Components[s][Method]=='function'){this._Components[s][Method](args);}}catch(exception){TempestNS.Debug_Out(exception,this._Components[s],"call"+Method);}}};TempestNS.Registered_Container.Listen=function(eventName,jArgs){if(this._eventListeners[eventName]){this._eventListeners[eventName](jArgs);}else{this.RaiseEvent(eventName,jArgs);}};TempestNS.Registered_Container.AddEventListener=function(eventName,listener){this._eventListeners[eventName]=listener;};TempestNS.Registered_Container.prototype=new TempestNS.Registered_Component();TempestNS.Registered_Container.prototype.ResizeChildren=TempestNS.Registered_Container.ResizeChildren;TempestNS.Registered_Container.prototype.UnloadChildren=TempestNS.Registered_Container.UnloadChildren;TempestNS.Registered_Container.prototype.LoadChildren=TempestNS.Registered_Container.LoadChildren;TempestNS.Registered_Container.prototype.CallChildren=TempestNS.Registered_Container.CallChildren;TempestNS.Registered_Container.prototype.Listen=TempestNS.Registered_Container.Listen;TempestNS.Registered_Container.prototype.AddEventListener=TempestNS.Registered_Container.AddEventListener;TempestNS.Component_Register=function(){if(TempestNS.COMPONENT_REGISTRY){return;}TempestNS.Registered_Container.call(this);TempestNS.COMPONENT_REGISTRY=this;var loader=TempestNS.Component_Register.Loader;var unloader=function(){try{TempestNS.COMPONENT_REGISTRY.UnloadChildren();}catch(e){}};var resizer=function(){try{TempestNS.COMPONENT_REGISTRY.ResizeChildren();}catch(e){}};if(window.RegisterOnLoad){RegisterOnLoad(loader);window.onunload=unloader;window.onresize=resizer;}else{TempestNS.Client.OnDOMLoad(loader);if(document.addEventListener){window.addEventListener("unload",unloader,false);window.addEventListener("resize",resizer,false);}else if(document.attachEvent){window.attachEvent("onunload",unloader);window.attachEvent("onresize",resizer);}else{window.onunload=unloader;window.onresize=resizer;}}};TempestNS.Component_Register.Loader=function(){try{TempestNS.COMPONENT_REGISTRY.LoadChildren();if(window.PTCOMPONENT_REGISTRY){window.PTCOMPONENT_REGISTRY.LoadChildren();}}catch(e){}};TempestNS.Component_Register.prototype=new TempestNS.Registered_Container();TempestNS.WidgetManager=function(){if(TempestNS.WIDGETMANAGER){return;}TempestNS.WIDGETMANAGER=this;this.Widgets=new Object();this.elementCount=0;this.elementMax=21;this.domComplete=false;this.messageTime=5000;this.Initialize();};TempestNS.WidgetManager.ApiSendCommand=function(widgetId,url){if(this.Widgets[widgetId]){this.Widgets[widgetId].ApiSendCommand(url);}};TempestNS.WidgetManager.GetEnvironment=function(){if(TempestNS.Server.domain==window.location.host){return 2;}else{if(this.GetRootDomain(window.location.host)==this.GetRootDomain(TempestNS.Server.domain)){return 1;}else{return 0;}}};TempestNS.WidgetManager.GetRootDomain=function(hostString){var hostArray=hostString.split(".");while(hostArray.length>2){hostArray.shift();}return hostArray.join(".");};TempestNS.WidgetManager.Initialize=function(){var self=this;TempestNS.Client.OnDOMLoad(function(){self.LoadWidgets();});};TempestNS.WidgetManager.LoadWidgets=function(){if(this.elementMax==this.elementCount){return;}var elements1=document.getElementsByTagName("paw:widget");var elements2=document.getElementsByTagName("widget");for(var i=0;i<(elements1.length+elements2.length);i++){if(this.elementMax==this.elementCount){return;}var element=(i<elements1.length)?elements1[i]:elements2[i-elements1.length];var cModule=new TempestNS.Widget(element);if(!this.Widgets[cModule.widgetId]){this.Widgets[cModule.widgetId]=cModule;this.elementCount++;cModule.Load();}}};TempestNS.WidgetManager.ReloadWidget=function(widgetId){if(TempestNS.WIDGETMANAGER.Widgets[widgetId]){var argsSplit=TempestNS.Widget.ArgsSplitter(TempestNS.WIDGETMANAGER.Widgets[widgetId].args);var argsUpdated=TempestNS.Widget.ArgsUpdater(argsSplit,[{"name":"cdsn","value":TempestNS.Widget.GetSeq()}]);var argsCombined=TempestNS.Widget.ArgsBuilder(argsUpdated);TempestNS.WIDGETMANAGER.Widgets[widgetId].Refresh({'args':argsCombined});}};TempestNS.WidgetManager.SendCommand=function(widgetId,cmd,controlList){if(this.Widgets[widgetId]){this.Widgets[widgetId].SendCommand(cmd,controlList);}};TempestNS.WidgetManager.SetContent=function(widgetId,sContent){if(this.Widgets[widgetId]){this.Widgets[widgetId].SetContent(sContent);}};TempestNS.WidgetManager.UpdateContent=function(widgetId,uri,scrollId){if(this.Widgets[widgetId]){var url=location.protocol+"/";url+="/"+TempestNS.Server.domain+uri;this.Widgets[widgetId].UpdateContent(url,scrollId);}};TempestNS.WidgetManager.GoToURL=function(JSON){try{if(JSON.fn){var functionToRun;if(typeof JSON.fn=="string"){functionToRun=function(JSON){eval(JSON.fn);};}else if(typeof JSON.fn=="function"){functionToRun=JSON.fn;}functionToRun(JSON);}else if(JSON.url){window.location=JSON.url;}}catch(e){}};TempestNS.WidgetManager.GoToWidget=function(widgetId,url){try{url+="&widgetId="+widgetId;url+="&args="+this.Widgets[widgetId].args;url+="&config="+this.Widgets[widgetId].config;this.Widgets[widgetId].UpdateContent(url,null);}catch(e){alert('what?');}};TempestNS.WidgetManager.prototype=new Object();TempestNS.WidgetManager.prototype.ApiSendCommand=TempestNS.WidgetManager.ApiSendCommand;TempestNS.WidgetManager.prototype.GetEnvironment=TempestNS.WidgetManager.GetEnvironment;TempestNS.WidgetManager.prototype.GetRootDomain=TempestNS.WidgetManager.GetRootDomain;TempestNS.WidgetManager.prototype.GoToWidget=TempestNS.WidgetManager.GoToWidget;TempestNS.WidgetManager.prototype.GoToURL=TempestNS.WidgetManager.GoToURL;TempestNS.WidgetManager.prototype.Initialize=TempestNS.WidgetManager.Initialize;TempestNS.WidgetManager.prototype.LoadWidgets=TempestNS.WidgetManager.LoadWidgets;TempestNS.WidgetManager.prototype.ReloadWidget=TempestNS.WidgetManager.ReloadWidget;TempestNS.WidgetManager.prototype.SendCommand=TempestNS.WidgetManager.SendCommand;TempestNS.WidgetManager.prototype.SetContent=TempestNS.WidgetManager.SetContent;TempestNS.WidgetManager.prototype.UpdateContent=TempestNS.WidgetManager.UpdateContent;window.PT_WIDGET_MAN=null;TempestNS.Widget=function(Element,def){TempestNS.Registered_Container.call(this);this.register(TempestNS.Widget.Prefix);this.onWidgetRefresh=function(){};this.canvas=null;this.script=null;this.callingProspero=false;this._def=def;this.element=Element;if(!this._def){this.DeriveParamsFromPawTag();}else{this.DeriveParamsFromDef(def);}};TempestNS.Widget.ApiSendCommand=function(url){var apiUrl="/"+this.webtag;apiUrl+="/api";apiUrl+="/vi";apiUrl+=url;apiUrl+="&callback="+this._ref+".ApiHandleResult";TempestNS.Client.IncludeScript(apiUrl);};TempestNS.Widget.ApiHandleResult=function(result){if(result.CommandResultInfo["@succeeded"]=="true"){this.Reload();}};TempestNS.Widget.ArgsValueFinder=function(find){if(this.args){var arg=this.args.split(";");for(var i=0;i<arg.length;i++){if(arg[i]!=""){var a=arg[i].split(":");if(a[0].toLowerCase()==find.toLowerCase()){return a[1];}}}}return null;};TempestNS.Widget.DeriveParamsFromPawTag=function(){this.app=this.element.getAttribute("app");if(!this.app||this.app==""){this.app="forum";}this.args=this.element.getAttribute("args");this.config=this.element.getAttribute("config");this.plan=this.element.getAttribute("plan");this._includeCSS=this.element.getAttribute("includeCSS");if((!this._includeCSS||this._includeCSS=="")&&(this.app=="forum"||this.app=="wiki")){this._includeCSS="false";}if(this.element.getAttribute("preloadid")){this.preloadId=this.element.getAttribute("preloadid");}else{this.preloadId="ptcloading";}this._userId=this.element.getAttribute("userid");this._loginCode=this.element.getAttribute("loginCode");this._profileName=this.element.getAttribute("profileName");if(this.element.getAttribute("onWidgetRefresh")){try{this.onWidgetRefresh=new Function(this.element.getAttribute("onWidgetRefresh"));}catch(e){this.onWidgetRefresh=function(){};}}this.type=this.element.getAttribute("type");this.webtag=this.element.getAttribute("webtag");if(this.element.getAttribute("key")){this.widgetId=TempestNS.Widget.Prefix+this.element.getAttribute("key");}else{this.widgetId=TempestNS.Widget.Prefix+TempestNS.WIDGETMANAGER.elementCount;}var psync=this.ReadPSyncHint();if(psync){this.widgetId=this.widgetId.toLowerCase();}this._exp=this.element.getAttribute("exp");};TempestNS.Widget.DeriveParamsFromDef=function(Def,showOnLoad){this.app=this._def.app;if(!this.app||this.app==""){this.app="forum";}this.args=this._def.args;this.config=this._def.config;this.plan=this._def.plan;this._includeCSS=this._def.includeCSS;this.preloadId="ptcloading";this._userId=this._def.userid;this._loginCode=this._def.loginCode;this._profileName=this._def.profileName;if(this._def.onWidgetRefresh){try{this.onWidgetRefresh=new Function(this._def.onWidgetRefresh);}catch(e){this.onWidgetRefresh=function(){};}}this.type=this._def.type;this.webtag=this._def.webtag;if(this._def.widgetId){this.widgetId=this._def.widgetId;}else{this.widgetId=TempestNS.Widget.Prefix+TempestNS.WIDGETMANAGER.elementCount;}TempestNS.WIDGETMANAGER.Widgets[this.widgetId]=this;TempestNS.WIDGETMANAGER.elementCount++;if(!this._def.preventLoad){this.Load();}};TempestNS.Widget.GetCookieValue=function(name){var allcookies=document.cookie;var cIndex=name+"=";var pos=allcookies.indexOf(cIndex);if(pos!=-1){var start=pos+cIndex.length;var end=allcookies.indexOf(";",start);if(end==-1){end=allcookies.length;}var value=allcookies.substring(start,end);value=decodeURIComponent(value);return value;}return null;};TempestNS.Widget.GetSeq=function(){var seq=TempestNS.Widget.SeqCount++;var rand=Math.floor(Math.random()*997)+seq;return rand;};TempestNS.Widget.Load=function(){src=this.WidgetSource();this.UpdateContent(src);};TempestNS.Widget.OnLoad=function(){this.LoadChildren();};TempestNS.Widget.OnResize=function(){this.ResizeChildren();};TempestNS.Widget.OnUnload=function(){this._hasAlreadyBeenLoaded=false;this.UnloadChildren();};TempestNS.Widget.ReadPSyncHint=function(){var PSynchHint=this.GetCookieValue("PSynchHint");if(PSynchHint){return PSynchHint;}else{return this.ArgsValueFinder("pSyncHint");}};TempestNS.Widget.Refresh=function(args){if(args){if(args.app&&(args.app!="")){this.app=args.app;}if(args.webtag&&(args.webtag!="")){this.webtag=args.webtag;}if(args.args&&(args.args!="")){this.args=args.args;}if(args.config&&(args.config!="")){this.config=args.config;}if(args.userId){this._userId=args.userId;}if(args.loginCode){this._loginCode=args.loginCode;}if(args.profileName){this._profileName=args.profileName;}if(args.plan){this.plan=args.plan;}}this.OnUnload();this.scriptSrc=this.WidgetSource();this.UpdateContent(this.scriptSrc);};TempestNS.Widget.Reload=function(){this.OnUnload();this.UpdateContent(this.scriptSrc);};TempestNS.Widget.SendCommand=function(cmd,controlList){new TempestNS.CommandHandler();var self=this;var callback=function(){self.Reload();};TempestNS.COMMANDHANDLER.SendCommand(this.widgetId,this.app,this.webtag,cmd,null,controlList,callback);};TempestNS.Widget.SetContent=function(sContent){if(this.element){var pawParent;if(this.element.parentNode){pawParent=this.element.parentNode;}if(pawParent){if(!this.canvas){if(this.preloadId){var preLoadingMessage=document.getElementById(this.preloadId);if(preLoadingMessage){preLoadingMessage.style.display="none";}}this.canvas=document.createElement("div");if(this._def){if(!this._def.showOnit){this.canvas.style.display="none";}}this.canvas.className="os-widgetparent";this.canvas.id=this.widgetId;pawParent.replaceChild(this.canvas,this.element);this.element=this.canvas;}this.canvas.innerHTML=sContent;this.callingProspero=false;this.OnLoad();this._hasAlreadyBeenLoaded=false;TempestNS.Client.ScrollToId(this.scrollId);if(this.onWidgetRefresh){this.onWidgetRefresh();}}}this.callingProspero=false;};TempestNS.Widget.SetError=function(msg){this.errorMessage=msg;alert(this.errorMessage);};TempestNS.Widget.UpdateContent=function(src,scrollId){if(this.callingProspero!=true){this.callingProspero=true;if(this.script){TempestNS.Client.RemoveScript(this.script);this.script=null;}this.scriptSrc=src;src+="&cdsn="+TempestNS.Widget.GetSeq();this.script=TempestNS.Client.IncludeScript(src);this.scrollId=scrollId;}};TempestNS.Widget.WidgetSource=function(){var src=location.protocol+"/";src+="/"+TempestNS.Server.domain;if(this._exp&&this.app!="profile"&&this.app!="common"){src+="/exp/"+this._exp;src+=TempestNS.Server.SeoApps[this.app];src+="/";src+="/"+this.webtag;src+="?widgetId="+this.widgetId;}else{src+=TempestNS.Server.Apps[this.app];src+="?webtag="+this.webtag;src+="&widgetId="+this.widgetId;if(this._exp&&this.config&&this.config.indexOf('PresenceMonitor')!=-1)src+="&experienceId="+this._exp;}if(this.plan&&this.plan!=""){src+="&pttv=2&nav="+this.plan;}else{src+="&nav=jsscontent";}if(this._userId){src+="&userId="+this._userId;}if(this._loginCode){src+="&loginCode="+this._loginCode;}if(this._profileName){src+="&profileName="+this._profileName;}if(this.args&&this.args!=""){this.args=this.args.replace(/\%3[Bb]/g,'%20');this.args=this.args.replace(/\#/g,'%23');this.args=this.args.replace(/\%3[Cc]/g,'%20');this.args=this.args.replace(/\%3[Ee]/g,'%20');this.args=this.args.replace(/\</g,'%20');this.args=this.args.replace(/\>/g,'%20');src+="&args="+this.args;var psync=this.ReadPSyncHint();if(psync){src+="&PSync="+psync;}var ptco=this.ArgsValueFinder("ptco");if(ptco){src+="&ptco="+ptco;}var includeCommonCss=this.ArgsValueFinder("includeCommonCss");if(includeCommonCss){src+="&includeCommonCss="+includeCommonCss;}}if(this.config&&this.config!=""){src+="&config="+this.config;}if(this.type&&this.type!=""){src+="&type="+this.type;}if(this._includeCSS&&this._includeCSS!=""){src+="&includeCSS="+this._includeCSS;}if(TempestNS.Server.dbg!='0'){src+="&dbg="+TempestNS.Server.dbg;}if(TempestNS.Server.ptco=='true'){src+="&ptco=y";}if(TempestNS.Server.expId!=''){src+="&experienceId="+TempestNS.Server.expId;}return src;};TempestNS.Widget.prototype=new TempestNS.Registered_Container();TempestNS.Widget.prototype.ApiSendCommand=TempestNS.Widget.ApiSendCommand;TempestNS.Widget.prototype.ApiHandleResult=TempestNS.Widget.ApiHandleResult;TempestNS.Widget.prototype.ArgsValueFinder=TempestNS.Widget.ArgsValueFinder;TempestNS.Widget.prototype.DeriveParamsFromPawTag=TempestNS.Widget.DeriveParamsFromPawTag;TempestNS.Widget.prototype.DeriveParamsFromDef=TempestNS.Widget.DeriveParamsFromDef;TempestNS.Widget.prototype.GetCookieValue=TempestNS.Widget.GetCookieValue;TempestNS.Widget.prototype.Load=TempestNS.Widget.Load;TempestNS.Widget.prototype.OnLoad=TempestNS.Widget.OnLoad;TempestNS.Widget.prototype.OnResize=TempestNS.Widget.OnResize;TempestNS.Widget.prototype.OnUnload=TempestNS.Widget.OnUnload;TempestNS.Widget.prototype.ReadPSyncHint=TempestNS.Widget.ReadPSyncHint;TempestNS.Widget.prototype.Refresh=TempestNS.Widget.Refresh;TempestNS.Widget.prototype.Reload=TempestNS.Widget.Reload;TempestNS.Widget.prototype.SendCommand=TempestNS.Widget.SendCommand;TempestNS.Widget.prototype.SetContent=TempestNS.Widget.SetContent;TempestNS.Widget.prototype.SetError=TempestNS.Widget.SetError;TempestNS.Widget.prototype.UpdateContent=TempestNS.Widget.UpdateContent;TempestNS.Widget.prototype.WidgetSource=TempestNS.Widget.WidgetSource;TempestNS.Widget.Prefix="PTWidget";TempestNS.Widget.Rev=1;TempestNS.Widget.SeqCount=0;new TempestNS.WidgetManager();TempestNS.WIDGETMANAGER.LoadWidgets();TempestNS.RegisterScript('Core');TempestNS.RegisterScript('Server');TempestNS.RegisterScript('Client');TempestNS.RegisterScript('ClientEvents');TempestNS.RegisterScript('Ajax');TempestNS.RegisterScript('AjaxCommands');TempestNS.RegisterScript('CommandHandler');TempestNS.RegisterScript('Debug');TempestNS.RegisterScript('RegisterComponents');TempestNS.RegisterScript('WidgetManager');TempestNS.RegisterScript('Widget');