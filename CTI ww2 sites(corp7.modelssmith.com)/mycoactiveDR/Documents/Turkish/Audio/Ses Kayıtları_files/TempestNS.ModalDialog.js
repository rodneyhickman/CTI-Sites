 TempestNS.Button=function(Button_Ptr,Action,Parent,StyleClasses){TempestNS.Registered_Component.call(this);this._Pointer=Button_Ptr;this._Action=Action;this._Classes=StyleClasses;this._canvas=null;this.register("BUTTON",Parent);this._defaultClassName="";this._normalClassname="";this._hoverClassname="";this._downClassname="";this._activeClassname="";this._disabledClassname="";this._elementName="";this._disabled=false;this._active=false;this._ButtonLoaded=false;this.onClick=function(){};this.onMouseOver=function(){};this.onMouseMove=function(){};this.onMouseOut=function(){};this.onMouseDown=function(){};this.onMouseUp=function(){};this.onDisable=function(){};this.onEnable=function(){};};TempestNS.ButtonOnLoad=function(){if(this._ButtonLoaded){return;}this._ButtonLoaded=true;if(typeof this._Pointer=="string"){this._canvas=document.getElementById(this._Pointer);}else{this._canvas=this._Pointer;}this.InitStyles();if(this._canvas!=null){this._elementName=this._canvas.nodeName;var self=this;this._onclickHandler=function(evt){self.Click(evt)};TempestNS.Client.AddEventListener(this._canvas,"click",this._onclickHandler);this._onmouseoverhandler=function(evt){self.Over(evt);};TempestNS.Client.AddEventListener(this._canvas,"mouseover",this._onmouseoverhandler);this._onmouseouthandler=function(evt){self.Out(evt);};TempestNS.Client.AddEventListener(this._canvas,"mouseout",this._onmouseouthandler);this._onmousedownhandler=function(evt){self.Down(evt);};TempestNS.Client.AddEventListener(this._canvas,"mousedown",this._onmousedownhandler);this._onmouseuphandler=function(evt){self.Up(evt);};TempestNS.Client.AddEventListener(this._canvas,"mouseup",this._onmouseuphandler);this._onmousemovehandler=function(evt){self.Move(evt);};TempestNS.Client.AddEventListener(this._canvas,"mousemove",this._onmousemovehandler);if(typeof this._Action=="string"){this.onClick=new Function(this._Action);}else if(typeof this._Action=="function"){this.onClick=this._Action;}}};TempestNS.ButtonOnUnLoad=function(){TempestNS.Client.RemoveEventListener(this._canvas,"click",this._onclickHandler);TempestNS.Client.RemoveEventListener(this._canvas,"mouseover",this._onmouseoverhandler);TempestNS.Client.RemoveEventListener(this._canvas,"mouseout",this._onmouseouthandler);TempestNS.Client.RemoveEventListener(this._canvas,"mousedown",this._onmousedownhandler);TempestNS.Client.RemoveEventListener(this._canvas,"mouseup",this._onmouseuphandler);TempestNS.Client.RemoveEventListener(this._canvas,"mousemove",this._onmousemovehandler);this._ButtonLoaded=false;};TempestNS.ButtonInitStyles=function(){if(this._canvas==null){return;}if(this._Classes){switch(this._Classes.constructor){case(new Array()).constructor:{TempestNS.Button.initStyleFromArray(this,this._Classes);break;}case(new Object().constructor):{TempestNS.Button.initStyleFromJson(this,this._Classes);break;}case("".constructor):{TempestNS.Button.initStyleFromString(this,this._Classes);break;}default:{this._defaultClassName=this._canvas.className;this._normalClassname=this._defaultClassName;this._hoverClassname=this._defaultClassName+"-Hover";this._downClassname=this._defaultClassName+"-Down";this._activeClassname=this._defaultClassName+"-Active";this._disabledClassname=this._defaultClassName+"-Disabled";break;}}}};TempestNS.ButtonClick=function(evt){if(this._disabled)return;try{this.onClick(evt);var ev=new TempestNS.Client.Event(evt);ev.StopPropogation();}catch(e){TempestNS.Debug_Out(evt,this,"click");}};TempestNS.ButtonOut=function(evt){if(this._disabled)return;if(this._canvas){if(!this._active){this._canvas.className=this._defaultClassName;}else{this._canvas.className=this._activeClassname;}}try{if(this.onMouseOut!=null){if(typeof this.onMouseOut=="string"){this.onMouseOut=new Function("evt",this.onMouseOut);}if(typeof this.onMouseOut=="function"){this.onMouseOut(evt);}}}catch(exception){}};TempestNS.ButtonDown=function(evt){if(this._disabled)return;if(this._canvas){this._canvas.className=this._downClassname;try{if(this.onMouseDown!=null){if(typeof this.onMouseDown=="string"){this.onMouseDown=new Function("evt",this.onMouseDown);}if(typeof this.onMouseDown=="function"){this.onMouseDown(evt);}}}catch(exception){}}};TempestNS.ButtonUp=function(evt){if(this._disabled)return;if(this._canvas){if(!this._active){this._canvas.className=this._defaultClassName;}else{this._canvas.className=this._activeClassname;}try{if(this.onMouseUp!=null){if(typeof this.onMouseUp=="string"){this.onMouseUp=new Function("evt",this.onMouseUp);}if(typeof this.onMouseUp=="function"){this.onMouseUp(evt);}}}catch(exception){}}};TempestNS.ButtonOver=function(evt){if(this._disabled)return;if(this._canvas){this._canvas.className=this._hoverClassname;try{if(this.onMouseOver!=null){if(typeof this.onMouseOver=="string"){this.onMouseOver=new Function("evt",this.onMouseOver);}if(typeof this.onMouseOver=="function"){this.onMouseOver(evt);}}}catch(exception){}}};TempestNS.ButtonMove=function(evt){if(this._disabled)return;if(this._canvas){this._canvas.className=this._hoverClassname;try{if(this.onMouseMove!=null){if(typeof this.onMouseMove=="string"){this.onMouseMove=new Function("evt",this.onMouseMove);}if(typeof this.onMouseMove=="function"){this.onMouseMove(evt);}}}catch(exception){}}};TempestNS.ButtonDisable=function(){this._disabled=true;if(this._canvas){this._canvas.className=this._disabledClassname;try{if(this.onDisable!=null){if(typeof this.onDisable=="string"){this.onDisable=new Function(this.onDisable);}if(typeof this.onDisable=="function"){this.onDisable();}}}catch(exception){}}};TempestNS.ButtonEnable=function(){this._disabled=false;if(this._canvas){this._canvas.className=this._defaultClassName;try{if(this.onEnable!=null){if(typeof this.onEnable=="string"){this.onEnable=new Function(this.onEnable);}if(typeof this.onEnable=="function"){this.onEnable();}}}catch(exception){}}};TempestNS.ButtonSetActive=function(){this._active=true;if(this._canvas){this._canvas.className=this._activeClassName;}};TempestNS.ButtonSetNormal=function(){this._active=false;if(this._canvas){this._canvas.className=this._defaultClassName;}};TempestNS.ButtonSetInActive=function(){this._active=false;if(this._canvas){this._canvas.className=this._defaultClassName;}};TempestNS.Button.prototype=new TempestNS.Registered_Component();TempestNS.Button.prototype.OnLoad=TempestNS.ButtonOnLoad;TempestNS.Button.prototype.OnUnload=TempestNS.ButtonOnUnLoad;TempestNS.Button.prototype.InitStyles=TempestNS.ButtonInitStyles;TempestNS.Button.prototype.Click=TempestNS.ButtonClick;TempestNS.Button.prototype.Out=TempestNS.ButtonOut;TempestNS.Button.prototype.Down=TempestNS.ButtonDown;TempestNS.Button.prototype.Up=TempestNS.ButtonUp;TempestNS.Button.prototype.Over=TempestNS.ButtonOver;TempestNS.Button.prototype.Move=TempestNS.ButtonMove;TempestNS.Button.prototype.Disable=TempestNS.ButtonDisable;TempestNS.Button.prototype.Enable=TempestNS.ButtonEnable;TempestNS.Button.prototype.SetActive=TempestNS.ButtonSetActive;TempestNS.Button.prototype.SetNormal=TempestNS.ButtonSetNormal;TempestNS.Button.initStyleFromArray=function(Button,Class_Array){switch(Class_Array.length){case 1:{Button._defaultClassName=Class_Array[0];Button_normalClassname=Class_Array[0];Button._hoverClassname=Class_Array[0];Button._downClassname=Class_Array[0];Button._activeClassname=Class_Array[0];Button._disabledClassname=Class_Array[0];break;}case 2:{Button._defaultClassName=Class_Array[0];Button._normalClassname=Class_Array[0];Button._hoverClassname=Class_Array[1];Button._downClassname=Class_Array[1];Button._activeClassname=Class_Array[0];Button._disabledClassname=Class_Array[0];break;}case 3:{Button._defaultClassName=Class_Array[0];Button._normalClassname=Class_Array[0];Button._hoverClassname=Class_Array[1];Button._downClassname=Class_Array[2];Button._activeClassname=Class_Array[0];Button._disabledClassname=Class_Array[0];break;}case 4:{Button._defaultClassName=Class_Array[0];Button._normalClassname=Class_Array[0];Button._hoverClassname=Class_Array[1];Button._downClassname=Class_Array[2];Button._activeClassname=Class_Array[3];Button._disabledClassname=Class_Array[0];break;}case 5:{Button._defaultClassName=Class_Array[0];Button._normalClassname=Class_Array[0];Button._hoverClassname=Class_Array[1];Button._downClassname=Class_Array[2];Button._activeClassname=Class_Array[3];Button._disabledClassname=Class_Array[4];break;}}};TempestNS.Button.initStyleFromJson=function(Button,Style_JSON){if(Style_JSON.ButtonStates["@normal"]){Button._defaultClassName=Style_JSON.ButtonStates["@normal"];Button._normalClassname=Button._defaultClassName;}if(Style_JSON.ButtonStates["@hover"]){Button._hoverClassname=Style_JSON.ButtonStates["@hover"];}else{Button._hoverClassname=Button._defaultClassName;}if(Style_JSON.ButtonStates["@down"]){Button._downClassname=Style_JSON.ButtonStates["@down"];}else{Button._downClassname=Button._hoverClassname;}if(Style_JSON.ButtonStates["@active"]){Button._activeClassname=Style_JSON.ButtonStates["@active"];}else{Button._activeClassname=Button._defaultClassName;}if(Style_JSON.ButtonStates["@disabled"]){Button._disabledClassname=Style_JSON.ButtonStates["@disabled"];}else{Button._disabledClassname=Button._defaultClassName;}};TempestNS.Button.initStyleFromString=function(Button,className){Button._defaultClassName=className;Button_normalClassname=className;Button._hoverClassname=className;Button._downClassname=className;Button._activeClassname=className;Button._disabledClassname=className;};TempestNS.Widget.ArgsBuilder=function(argsObj){var args="";for(var i=0;i<argsObj.length;i++){var val=new String(argsObj[i].value);val=val.replace(/\%3[Bb]/g,'%20');val=val.replace(/\%27/g,'%20');val=val.replace(/\'/g,'%20');args+=argsObj[i].name+":"+val+";";}return args;};TempestNS.Widget.ArgsReplacer=function(argsArray){var oldArgs=this.ArgsSplitter(this.args);var newArgs=this.ArgsUpdater(oldArgs,argsArray);this.args=this.ArgsBuilder(newArgs);};TempestNS.Widget.ArgsSplitter=function(args){var argsObj=new Array();var arg=args.split(";");for(var i=0,j=0;i<arg.length;i++){if(arg[i]!=""){var a=arg[i].split(":");argsObj[j]={"name":a[0],"value":a[1]};j++;}}return argsObj;};TempestNS.Widget.ArgsUpdater=function(argsObj,changes){for(var i=0;i<changes.length;i++){var notFound=true;for(var j=0;j<argsObj.length;j++){if(argsObj[j].name==changes[i].name){argsObj[j].value=changes[i].value;notFound=false;break;}}if(notFound){argsObj[argsObj.length]={"name":changes[i].name,"value":changes[i].value};}}return argsObj;};TempestNS.Widget.prototype.ArgsBuilder=TempestNS.Widget.ArgsBuilder;TempestNS.Widget.prototype.ArgsReplacer=TempestNS.Widget.ArgsReplacer;TempestNS.Widget.prototype.ArgsSplitter=TempestNS.Widget.ArgsSplitter;TempestNS.Widget.prototype.ArgsUpdater=TempestNS.Widget.ArgsUpdater;


TempestNS.ModalDialog = function()
{
    if(TempestNS.MODALDIALOG) return;

    TempestNS.MODALDIALOG = this;
    // alert ("New TempestNS.MODALDIALOG created!");
    window.PTMODALDIALOG=this;
    TempestNS.Registered_Container.call(this);
    this.register("MODALDIALOG");
    this._canvas = null;
    this._frame=null; 
    this._frameCanvas = null;
    this._visable = false;
    this._loaded = false;
    this._Domainfix =false;
    this._refreshCallback = null;
};

TempestNS.ModalDialog.OnLoad = function()
{
    if(this._loaded) return;
    
    this._canvas = document.createElement("DIV");
    this._canvas.setAttribute(TempestNS.Client.GetClassAttribute(this._canvas), "os-modaldialog");
    this._canvas.style.position="absolute";
    this._canvas.style.display="none"; 
    document.body.appendChild(this._canvas);
    
    this._loaded = true;
    this.LoadChildren();
    this.Restore();
};

TempestNS.ModalDialog.CreateFrame= function(url)
{
    this._frameCanvas= document.createElement("IFRAME");
    this._frameCanvas.frameBorder=0;
    this._frameCanvas.setAttribute("allowTransparency","true"); /* needed for IE */
    this._frameCanvas.name=this._refIndex;
    this._frameCanvas.id=this._refIndex;
    this._frameCanvas.src = url;
    
    this._canvas.appendChild(this._frameCanvas);
    this._frame= window.frames[this._refIndex];
    
    // Resize the frame during onload.
    var self = this;
    this._frame.onload = function() { self.OnResize(); };
    //debugger;
};

TempestNS.ModalDialog.OnUnload = function()
{
  this.UnloadChildren();
};

// BugzId 61573: come back to the pop-in you were trying to open when shunted off to login.
// Setting ptpiUrl happens in Seamless.cs when it detects &ptpi=y in the query string of the url being processed.
// ptpiState is set here in Open() and deleted in Close(); it summarizes the dimensions and resize of the dialog being opened
TempestNS.ModalDialog.Restore = function()
{
  var restoreModal = TempestNS.Client.GetCookie('ptpiUrl');
  if (!restoreModal) return;
  
  TempestNS.Client.EraseCookie('ptpiUrl');
  var stateStr = TempestNS.Client.GetCookie('ptpiState');
  if (!stateStr) return;
  
  TempestNS.Client.EraseCookie('ptpiState');
  
  var state;
  eval("state="+stateStr+";");
  this.Open(restoreModal, state.w, state.h, state.r);
}

TempestNS.ModalDialog.Open = function(url,width,height,resizable,CallingWidgetID, refreshCallback)
{
	// The canvas must exist. Created in OnLoad.
	if(this._canvas==null) return;
    
  // debugger;
    
  this._widgetId =CallingWidgetID;
  this._refreshCallback = refreshCallback;
    
 	if(!this._visable)
	{ 
    var isPopin = url.indexOf('ptpi=') > 0;
    if (isPopin)
    {
      TempestNS.Client.SetCookie('ptpiState','{"w":'+width+',"h":'+height+',"r":'+resizable+'}');
    }
	        if(resizable!= null)
	        {
	           this._resizable= resizable;
	        }
	        else
	        {
	            this._resizable= true;
	        }  
	        
	        if(width != null)
	       {
	            this._width = width;
	        }
	      
	        if(height !=null)
	        {
	            this._height = height;
	        }
	        
          this._isOpen = true;
	        this.ShowBackground();
	        this.CreateFrame(url);
	        
	        // Create the canvas. Needed before resizing to get the true size of the canvas.
          this._canvas.style.display="block";
	        this._canvas.style.visibility="hidden";
	        
          this.InitializeDimensions();
	        
	        // Make the canvas visible.
	        this._canvas.style.visibility="visible";  
	        this._canvas.style.zIndex=999;
	        this._visable = true;
         
    	}
};

/* if refresh is true, use either the previously set refresh callback or the widget refresh; otherwise
   refresh the whole parent page or optionally redirect to the specified URL */ 
TempestNS.ModalDialog.Close = function(refresh, redirectUrl)
{
    TempestNS.Client.EraseCookie('ptpiState');
    
    // remove the display.
    this._visable = false;
    this._canvas.style.display="none";

    // Must delete frame to recreate the document element on the next launch.
    try
    {
     // remove the elements.
      this._canvas.removeChild(this._frameCanvas);
      delete window.frames[this._refIndex];
    }
    catch(e)
    {
      // debugger;
    }
    
    this._frame=null;
    this._frameCanvas = null;
    
    this.HideBackground();
    this._isOpen = false;
    
    /* refresh might be a boolean (don't see how) or a function to call */
    //debugger;
    if(refresh)
    {
      if(this._refreshCallback)
       {
            this._refreshCallback();    
       }
       else
       {
          //debugger;
            var _widget = TempestNS.WIDGETMANAGER.Widgets[this._widgetId];
            if(_widget)
            {
              _widget.Reload();
            }
            else
            {
              /* refresh the whole page */
              if (redirectUrl)
              {
                //alert ("Ready to redirect to " + redirectUrl + "\nCurrent: " + window.location.href);
                window.location.href = redirectUrl;
              }
              else
              {
                window.location.href= window.location.href;
              }
            }
       }
    }
 };
 
/**
  <summary>
  These are the dimensions of the modal dialog before resizing, if that is requested.
  </summary>
**/
TempestNS.ModalDialog.InitializeDimensions = function()
{
    var winSize = TempestNS.Client.GetWindowSize();
    var padT = Math.floor(winSize.height/10);  
    
    // Maybe be passed in, otherwise use 3/4 of the window
    if(this._height == null)
    {
    	this._height = winSize.height - 2*(padT);
    }

    // Maybe be passed in.
    if(this._width == null)
    {
    	this._width = winSize.width - 200;
    }

    this._left = Math.floor((winSize.width-this._width)/2);
    this._top = padT;
    
    this.SetDimensions();
};
 
TempestNS.ModalDialog.SetDimensions= function()
{
   if(this._canvas != null){
        this.PositionCanvas();
        this._canvas.style.width = (this._width + 10) + "px";
        this._canvas.style.height= (this._height + 10) + "px";
    }
    
    if(this._frameCanvas != null){
      this._frameCanvas.style.width = (this._width + 10) + "px";
      this._frameCanvas.style.height= (this._height + 10) + "px";
    }
};

TempestNS.ModalDialog.PositionCanvas = function()
{
    // this._canvas.style.top = (document.body.scrollTop + this._top) + "px";
    this._canvas.style.top = (TempestNS.Client.GetScrollTop() + this._top) + "px";
    this._canvas.style.left = (document.body.scrollLeft + this._left) + "px";
};

TempestNS.ModalDialog.OnResize = function()
{
    //debugger;
    if (window.DANDEBUG)
    {
        //debugger;  
    }
    if (this._resizable)
    {
      try
      {
        this.CalculateDimensions();
        this.SetDimensions();
        this.ShowBackground();
      }
      catch(e)
      {
        if (window.DANDEBUG)
          alert(e.message);
      }
    }
};

TempestNS.ModalDialog.CalculateDimensions= function()
{
   /* Get the actual frame's dimensions */ 
    try{
      if(this._frame)
      {
        if(this._frame.document)
        {
            this._height = TempestNS.Client.GetDocumentHeight(this._frame.document);
            this._width = this._frame.document.body.clientWidth;
        }
      }
    }
    catch(e)
    {
      var errorMsg = e.message;
    }
    
    /* If the client is larger than the document make it smaller. */
    /* No longer do this - 6/19/2009 - Dan
    var winSize = TempestNS.Client.GetWindowSize();
    var winH = winSize.height - 10;
    var winW = winSize.width - 10;
    if(this._height > winH)
    {
        this._height= winH;
    } 
    
    if(this._width > winW)
    {
        this._width= winW;
    }
    */
};

TempestNS.ModalDialog.CloseModal = function(target, refresh, redirectUrl)
{
 if(target != null)
 {
    if(target["TempestNS"] != null)
    {
      if(target["TempestNS"]["MODALDIALOG"] != null)
      {
        target["TempestNS"]["MODALDIALOG"].Close(refresh,redirectUrl);
       
      }
    }
 }
};

/**
  <summary>
  Debugger
  </summary>
**/
TempestNS.ModalDialog.DebugMe = function(msg)
{
  if (this._canvas)
  {
    this._left = this._left - 25;
    this._canvas.style.left = (document.body.scrollLeft + this._left) + "px";
  }
};

TempestNS.ModalDialog.Move = function(deltaX, deltaY)
{
  if (this._canvas)
  {
    this._left = this._left + deltaX;
    this._top = this._top + deltaY;
    this.PositionCanvas();
  }

};

TempestNS.ModalDialog.GetPosition = function()
{
   return {x: this._left, y: this._top };
};

TempestNS.ModalDialog.ShowBackground= function()
{
  if(this._isOpen)
  {
    if(!this._popInBack){
        this._popInBack = document.createElement("div");
        this._popInBack.style.display="none";
        this._popInBack.className="os-popinbackground";
        document.body.appendChild(this._popInBack);
    }
    TempestNS.Client.EmbedShowHide(false);
    if(this._popInBack)
    {
      this._popInBack.style.position = "absolute";
      this._popInBack.style.top = "0px";
      this._popInBack.style.left = "0px";
      
      var h = TempestNS.Client.GetDocumentHeight(window.document);
      var w = TempestNS.Client.GetDocumentWidth(window.document);
      var winSize = TempestNS.Client.GetWindowSize();
     
      /* this seems to be setting some sort of cushion.  What for? */
      if(h > winSize.height)
      {
        h = h + Math.floor(winSize.height/10);
      }
     
      try{
        this._popInBack.style.height = h+"px";
        this._popInBack.style.width= w+"px";   /* "100%"; */
        this._popInBack.style.display="block";
      }catch(e){}
    
    }
  }
};

TempestNS.ModalDialog.HideBackground= function(){
  TempestNS.Client.EmbedShowHide(true);
  //debugger;
  if(this._popInBack){
    this._popInBack.style.display="none";
  }
};

/**
 <summary>
 Fade out close of Modal Dialog version 1
 </summary>
**/
TempestNS.ModalDialog.FadeOut = function(refresh)
{
  this.fadeIt = function(self, val)
  {
    if(val > 5)
    {
      TempestNS.OpacityTools.set(self._canvas, val);
      val = val - 5;
      setTimeout(function(){ self.fadeIt(self, val); }, 5);
    }
    else
    {
      self.Close(refresh);
      TempestNS.OpacityTools.set(self._canvas, 100);
    }
  };
  this.fadeIt(this, 95);
};


TempestNS.ModalDialog.prototype = new TempestNS.Registered_Container();
TempestNS.ModalDialog.prototype.OnLoad = TempestNS.ModalDialog.OnLoad;
TempestNS.ModalDialog.prototype.OnUnload = TempestNS.ModalDialog.OnUnload;
TempestNS.ModalDialog.prototype.CreateFrame = TempestNS.ModalDialog.CreateFrame;
TempestNS.ModalDialog.prototype.Restore = TempestNS.ModalDialog.Restore;
TempestNS.ModalDialog.prototype.Open = TempestNS.ModalDialog.Open;
TempestNS.ModalDialog.prototype.Close = TempestNS.ModalDialog.Close;
TempestNS.ModalDialog.prototype.InitializeDimensions  = TempestNS.ModalDialog.InitializeDimensions;
TempestNS.ModalDialog.prototype.SetDimensions  = TempestNS.ModalDialog.SetDimensions;
TempestNS.ModalDialog.prototype.OnResize  = TempestNS.ModalDialog.OnResize;
TempestNS.ModalDialog.prototype.CalculateDimensions = TempestNS.ModalDialog.CalculateDimensions;
TempestNS.ModalDialog.prototype.CloseModal  = TempestNS.ModalDialog.CloseModal;
TempestNS.ModalDialog.prototype.DebugMe = TempestNS.ModalDialog.DebugMe;
TempestNS.ModalDialog.prototype.ShowBackground = TempestNS.ModalDialog.ShowBackground;
TempestNS.ModalDialog.prototype.HideBackground = TempestNS.ModalDialog.HideBackground;
TempestNS.ModalDialog.prototype.FadeOut = TempestNS.ModalDialog.FadeOut;
TempestNS.ModalDialog.prototype.Move = TempestNS.ModalDialog.Move;
TempestNS.ModalDialog.prototype.PositionCanvas = TempestNS.ModalDialog.PositionCanvas;
TempestNS.ModalDialog.prototype.GetPosition = TempestNS.ModalDialog.GetPosition;

/**consts**/
TempestNS.ModalDialog.DIALOG_MIN_HEIGHT = 500;
TempestNS.ModalDialog.DIALOG_MIN_WIDTH= 600;

/* Always create one - a singleton */
new TempestNS.ModalDialog();


TempestNS.ModalDialogButton = function(canvasKey,widgetId,webtag,app,plan,args,userid,styleClasses,width,height,resizable)
{
    TempestNS.Registered_Container.call(this);
    this._canvasKey = canvasKey;
    this._userId =userid; 
    this._widgetId = widgetId;
    this._webtag =webtag;
    this._app =app;
    this._plan = plan;
    this._args= args;
    this._styleClass = styleClasses;
    this._loaded=false;

    this._DialogWidth= width;
    this._DialogHeight= height;
    this._DialogResizable = resizable;
    this._widget = TempestNS.WIDGETMANAGER.Widgets[this._widgetId];
    this.register("ModalDialogButton",this._widget);
};


TempestNS.ModalDialogButton.OnLoad = function()
{
  if(this._loaded)return;
  
    this._canvas = document.getElementById(this._canvasKey);
    if(this._canvas)
    {
        new TempestNS.Button(this._canvas,new Function(this._ref +".Open();") , this, this._styleClass).OnLoad();
        this._loaded=true;
    }
   
};

TempestNS.ModalDialogButton.OnUnload = function()
{
  this.UnloadChildren();
  this._loaded=false;
};

TempestNS.ModalDialogButton.Open = function()
{
  var src = location.protocol +"/";
  src += "/" + TempestNS.Server.domain;
  src += TempestNS.Server.Apps[this._app];
  src += "?webtag=" + this._webtag;
  /* If using T2V2 implementation */
  src += "&nav=" + this._plan; 
  /* If args exists, append it to the src variable */
  if(this._args && this._args != "")
  {
    /* Remove any semicolons */
    src += "&" + this._args;
  }
  if(this._userId &&this._userId!=""){
    src+="&userId=" + this._userId; 
  }  /* If the debug flag has been set, add it to the src */
  if(TempestNS.Server.dbg)
  {
    src += "&dbg=" + TempestNS.Server.dbg;
  }
  TempestNS.MODALDIALOG.Open(src,this._DialogWidth,this._DialogHeight,this._DialogResizable,this._widgetId);
};

TempestNS.ModalDialogButton.prototype = new TempestNS.Registered_Container();
TempestNS.ModalDialogButton.prototype.OnLoad = TempestNS.ModalDialogButton.OnLoad;
TempestNS.ModalDialogButton.prototype.OnUnload = TempestNS.ModalDialogButton.OnUnload;
TempestNS.ModalDialogButton.prototype.Open = TempestNS.ModalDialogButton.Open;



 TempestNS.RegisterScript('Buttons');TempestNS.RegisterScript('WidgetArgs');TempestNS.RegisterScript('ModalDialog');