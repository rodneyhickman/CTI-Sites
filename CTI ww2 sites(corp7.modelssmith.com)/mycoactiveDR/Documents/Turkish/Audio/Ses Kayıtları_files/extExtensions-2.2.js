if (Ext.isIE && !Ext.isIE7) {
	Ext.isIE7 = (navigator.userAgent.toLowerCase().indexOf("msie 8") > -1);
	Ext.isIE6 = Ext.isIE && !Ext.isIE7;
}

Ext.namespace("mzinga", "mzinga.ui", "mzinga.lms.ui", "Ext.ux.data");

Ext.BLANK_IMAGE_URL = '/extjs/images/default/s.gif';
Ext.SSL_SECURE_URL = '/app/blank.html';

//Ensure the "User Extension" namespace is defined.
Ext.namespace("Ext.ux.data");

/**
* @class Ext.ux.data.DwrProxy
* @extends Ext.data.DataProxy
* @author BigLep
* An implementation of Ext.data.DataProxy that uses DWR to make a remote call.
* @see http://github.com/BigLep/ExtJsWithDwr/tree/v2
* @see http://extjs.com/forum/showthread.php?t=23884
* @constructor
* @param {Object} config A configuration object.
*/
Ext.ux.data.DwrProxy = function(config){
    Ext.apply(this, config); // necessary since the superclass doesn't call apply
    Ext.ux.data.DwrProxy.superclass.constructor.call(this);
};

// Alias Ext.ux.data.DWRProxy -> Ext.ux.data.DwrProxy for backwards compatibility
Ext.ux.data.DWRProxy = Ext.ux.data.DwrProxy;

Ext.extend(Ext.ux.data.DwrProxy, Ext.data.DataProxy, {

    /**
* @cfg {Function} dwrFunction The DWR function for this proxy to call during load.
* Must be set before calling load.
*/
    dwrFunction: null,

    /**
* @cfg {String} loadArgsKey Defines where in the params object passed to the load method
* that this class should look for arguments to pass to the "dwrFunction".
* The order of arguments passed to a DWR function matters.
* Must be set before calling load.
* See the explanation of the "params" parameter in load function for more information.
*/
    loadArgsKey: 'dwrFunctionArgs',

    /**
* Load data from the configured "dwrFunction",
* read the data object into a block of Ext.data.Records using the passed {@link Ext.data.DataReader} implementation,
* and process that block using the passed callback.
* @param {Object} params An object containing properties which are to be used for the request to the remote server.
* Params is an Object, but the "DWR function" needs to be called with arguments in order.
* To ensure that one's arguments are passed to their DWR function correctly, a user must either:
* 1. call or know that the load method was called explictly where the "params" argument's properties were added in the order expected by DWR OR
* 2. listen to the "beforeload" event and add a property to params defined by "loadArgsKey" that is an array of the arguments to pass on to DWR.
* If there is no property as defined by "loadArgsKey" within "params", then the whole "params" object will be used as the "loadArgs".
* If there is a property as defined by "loadArgsKey" within "params", then this property will be used as the "loagArgs".
* The "loadArgs" are iterated over to build up the list of arguments to pass to the "dwrFunction".
* @param {Ext.data.DataReader} reader The Reader object which converts the data object into a block of Ext.data.Records.
* @param {Function} callback The function into which to pass the block of Ext.data.Records.
* The function must be passed <ul>
* <li>The Record block object</li>
* <li>The "arg" argument from the load function</li>
* <li>A boolean success indicator</li>
* </ul>
* @param {Object} scope The scope in which to call the callback
* @param {Object} arg An optional argument which is passed to the callback as its second parameter.
*/
    load: function(params, reader, loadCallback, scope, arg){
        var dataProxy = this;
        if (dataProxy.fireEvent("beforeload", dataProxy, params) !== false) {
            var loadArgs = params[this.loadArgsKey] || params; // the Array or Object to build up the "dwrFunctionArgs"
            var dwrFunctionArgs = []; // the arguments that will be passed to the dwrFunction
            if (loadArgs instanceof Array) {
                // Note: can't do a foreach loop over arrays because Ext added the "remove" method to Array's prototype.
                // This "remove" method gets added as an argument unless we explictly use numeric indexes.
                for (var i = 0; i < loadArgs.length; i++) {
                    dwrFunctionArgs.push(loadArgs[i]);
                }
            } else { // loadArgs should be an Object
                for (var loadArgName in loadArgs) {
                    dwrFunctionArgs.push(loadArgs[loadArgName]);
                }
            }
            // Define callbacks for DWR to call when it gets a response from the server.
            dwrFunctionArgs.push({
                callback: function(response){
                    // We call readRecords instead of read because read will attempt to decode the JSON,
                    // but as this point DWR has already decoded the JSON.
                    var records = reader.readRecords(response);
                    dataProxy.fireEvent("load", dataProxy, response, loadCallback);
                    loadCallback.call(scope, records, arg, true);
                },
                exceptionHandler: function(message, exception){
                    // The "loadexception" event is supposed to pass the response, but since DWR doesn't provide that to us, we pass the message.
                    dataProxy.fireEvent("loadexception", dataProxy, message, loadCallback, exception);
                    loadCallback.call(scope, null, arg, false);
                }
            });
            // Call the dwrFunction now that we have the arguments and callback functions.
            // Note: the scope for calling the dwrFunction doesn't matter, so we simply set it to Object.
            this.dwrFunction.apply(Object, dwrFunctionArgs);
        } else { // the beforeload event was vetoed
            callback.call(scope || this, null, arg, false);
        }
    }
});


/**
 * @class mzinga.lms.ui.LayoutObserver
 * Simple observer to notify pages when the layout is ready.
 * @constructor
 * @param config An object containing configuration items.
 */
mzinga.lms.ui.LayoutObserver = Ext.extend(Ext.util.Observable, {
	events: {
		layoutReady: true
	},
	/**
	 * Fires the event notifying that the layout is ready.
	 */
	fireLayoutReady: function() {
		this.fireEvent('layoutReady');
	}
});

/**
 * Static reference to layout observer
 */
mzinga.lms.ui.layoutObserver = new mzinga.lms.ui.LayoutObserver();

/**
 * @class mzinga.ui.LocalizationSet
 * @extends Ext.util.MixedCollection
 * Container for localization values.
 * @param {Object/Array} aLocalizationObject An Object containing properties
 * which will be added to the collection of localization values, or an Array of
 * values, each of which are added to the collection.
 */
mzinga.ui.LocalizationSet = function(aLocalizationObject){
    mzinga.ui.LocalizationSet.superclass.constructor.call(this);
    this.addAll(aLocalizationObject);
};

Ext.extend(mzinga.ui.LocalizationSet, Ext.util.MixedCollection,  {
   /**
     * Get the localized string, replacing the replacement placeholders with
     * the specified values (if specified).
     * @param {String} aKey The key value of the localalization value to get.
     * @param {Array} aReplacementArray (optional) An Array containing the
     * replacement values. If this value isn't passed in, string replacement
     * will not take place.
     * @return {String} the localized string with the replaced values.
     */
    getLocalizedString: function(aKey, aReplacementArray) {
        var value = this.get(aKey);
        if (aReplacementArray == null) {
            return value;
        } else {
            var args = [value].concat(aReplacementArray);
            return String.format.apply(String,args);
        }
    }
});

/**
 * Add a function to fires when the ui is ready.
 * @param {Object} fn The method the event invokes
 * @param {Object} scope An object that becomes the scope of the handler
 * @param {Object} options options (optional) An object containing handler configuration
 * properties. This may contain any of the following properties:<ul>
 * <li>scope {Object} The scope in which to execute the handler function. The handler function's "this" context.</li>
 * <li>delay {Number} The number of milliseconds to delay the invocation of the handler after te event fires.</li>
 * <li>single {Boolean} True to add a handler to handle just the next firing of the event, and then remove itself.</li>
 * <li>buffer {Number} Causes the handler to be scheduled to run in an {@link Ext.util.DelayedTask} delayed
 * by the specified number of milliseconds. If the event fires again within that time, the original
 * handler is <em>not</em> invoked, but the new handler is scheduled in its place.</li>
 * </ul><br>
 */
mzinga.lms.ui.onReady = function(fn, scope, options) {
	mzinga.lms.ui.layoutObserver.addListener('layoutReady',fn, scope, options);
};

/**
 * Add a script tag to the head of the current document.
 * @param {String} aUrl The url for the script tag
 * @param {Object} aParamObject An object containing properties which are to be used as HTTP parameters
 * for the script (i.e. {foo: 1, bar: 2}) would specify parameters foo=1&bar=2
 */
mzinga.lms.ui.addScript = function(aUrl, aParamObject) {
	var head = document.getElementsByTagName("head")[0];
    var script = document.createElement("script");
    var scriptUrl = aUrl;
    if (aParamObject != null) {
	    if (scriptUrl.indexOf("?") == -1) {
	    	scriptUrl += "?";
	    } else {
	    	scriptUrl += "&";
	    }
    	scriptUrl += Ext.urlEncode(aParamObject);
    }
    script.setAttribute("src", scriptUrl);
    script.setAttribute("type", "text/javascript");
    head.appendChild(script);
}


/**
 * Loads the contents of the specified element with the result of a request to
 * a remote url.  This function utilizes the Ext.Updater object, but also adds
 * support for loading css in IE.
 *
 * @param el element id or dom object or Ext.Element object
 * @param config same configuration as {@link Ext.Updater#update} with an additional option called
 * 'listenForDestroyComponentId', which is a component id that on destroy will clear any scripts/css
 */
mzinga.lms.ui.loadElWithRemoteContent = function(el, config) {


    config = Ext.applyIf(config || {}, {
        scripts : true,
        text : 'Loading...'
    });

    var loadCss = mzinga.lms.ui.__loadCss__;

    if (config.callback) {
        config.callback = config.callback.createInterceptor(loadCss, config.scope || window);
    } else {
        config.callback = loadCss;
    }

    var el = Ext.get(el);

    if (config.listenForDestroyComponentId) {
        var cmp = Ext.getCmp(config.listenForDestroyComponentId);

        if (cmp) {
            cmp.on('destroy', mzinga.lms.ui.__removeCss__.createDelegate(window, [el.id]));
        }
    }

    el.load(config);

} // end mzinga.lms.ui.loadElWithRemoteContent

mzinga.lms.ui.__loadCss__ = function(el, success, response) {
    if (!success || !Ext.isIE) {
        return;
    }

    var html = response.responseText;
    var linkPattern = /<link.*?href="(.*?)".*?>/mig;
    var relPattern = /rel="stylesheet"/i;
    var matches;
    var idPrefix = el.dom.id += '-style-';
    var index = 0;

    while (matches = linkPattern.exec(html)) {
        var whole = matches[0];
        var href = matches[1];

        if (whole && href && whole.match(relPattern)) {
            Ext.util.CSS.swapStyleSheet(idPrefix + index, href);
            index++;
        }
    }

    var stylePattern = /<style.*?>((\n|\r|.)*?)<\/style>/mig;

    while (matches = stylePattern.exec(html)) {
        var inlineCss = matches[1] || '';
        inlineCss = inlineCss.trim();

        if (inlineCss) {
            Ext.util.CSS.createStyleSheet(inlineCss, idPrefix + index);
            index++;
        }
    }

} // end mzinga.lms.ui.__loadCss__

mzinga.lms.ui.__removeCss__ = function(id) {
    var idPrefix = id += '-style-';
    var len;

    var linkTags = document.getElementsByTagName('link');
    var itemsToRemove = [];
    var i;

    if (linkTags) {
        len = linkTags.length;
        for (i = 0; i < len; i++) {
            var linkTag = linkTags[i];

            if (linkTag.id && linkTag.id.indexOf(idPrefix) === 0) {
                itemsToRemove[itemsToRemove.length] = linkTag.id;
            }
        }
    }


    var styleTags = document.getElementsByTagName('style');

    if (styleTags) {
        len = styleTags.length;
        for (i = 0; i < len; i++) {
            var styleTag = styleTags[i];

            if (styleTag.id && styleTag.id.indexOf(idPrefix) === 0) {
                itemsToRemove[itemsToRemove.length] = styleTag.id;
            }
        }
    }

    len = itemsToRemove.length;

    if (len) {
        for (i = 0 ; i < len; i++) {
            var itemId = itemsToRemove[i];
            Ext.util.CSS.removeStyleSheet(itemId);
        }
    }






} // end mzinga.lms.ui.__removeCss__

/**
 * Search for all divs with the "os-box" class and replace them with
 * ExtJS panels with rounded corners.
 */
mzinga.lms.ui.roundCorners = function() {
    var currentBox;
    var boxElements = Ext.DomQuery.select('.os-box');
    var i=0;
    var tmpElement;
    var tmpHeight;
    var tmpHeight;
    var tmpParent;
    for (i=0;i < boxElements.length; i++) {
        currentBox = Ext.get(boxElements[i]);
        currentBox.addClass('x-panel');
        tmpElement = currentBox.down('.os-box-header');
        if (tmpElement) {
            tmpElement.addClass('x-panel-header');
        } else {
            currentBox.addClass('os-box-headless');
        }
        tmpElement = currentBox.down('.os-box-body');
        if (tmpElement) {
            tmpElement.addClass('x-panel-body');
        }
        tmpParent = currentBox.parent();
        if (tmpParent.hasClass('os-box-fit')) {
            tmpHeight = tmpParent.getComputedHeight();
        } else if (currentBox.hasClass('os-box-fit')) {
            tmpHeight = currentBox.getComputedHeight();
        } else {
            tmpHeight = '100%';
        }
        if (tmpHeight <=0) {
            tmpHeight = '100%';
        }
        //tmpHeight = 'auto';

        if (currentBox.hasClass('os-viewport-box')) {
            viewport = new mzinga.lms.ui.ViewportPanel({
                id: 'viewportPanel',
                layout:'fit',
                applyTo: currentBox,
                frame: true,
                heightOffset: 0,
                widthOffset: 0
            });
        } else if (currentBox.dom.id == 'centerRegion') {
            centerPanel = new Ext.Panel({
                autoScroll: true,
                frame: true,
                id: 'centerRegionPanel',
                applyTo: currentBox
            });
        } else {
            new Ext.Panel({
                height: tmpHeight,
                applyTo: currentBox,
                frame: true
            });
        }
    }
}

/**
 * Using the current CSS rules apply the proper classes and markup
 * to buttons, depending upon the size
 */
mzinga.lms.ui.sizeButtons = function(){
    function getButtonSize(aCSSClassArray) {
        var buttonSize = 0;
        var tmpCSS = Ext.util.CSS.getRule(aCSSClassArray);
        if (tmpCSS && tmpCSS.style) {
            buttonSize = tmpCSS.style.width;
            buttonSize = parseInt(buttonSize);
        }
        return buttonSize;
    }

    var buttonLength;
    var buttonMetrics = null;
    var currentButton = null;
    var currentButtonWidth = null;
    var currentButtonText = null;
    var i;
    var buttonLength = getButtonSize(['BUTTON','button']);
    var mediumButton = getButtonSize(['BUTTON.os-btn-med','button.os-btn-med']);
    var largeButton = getButtonSize(['BUTTON.os-btn-lrg','button.os-btn-lrg']);
    var buttonList = Ext.DomQuery.select('button');
    for (i=0;i < buttonList.length; i++) {
        currentButton = Ext.get(buttonList[i]);
        if (!buttonMetrics) {
            buttonMetrics = Ext.util.TextMetrics.createInstance(currentButton);
        }
        currentButtonText =  currentButton.dom.innerHTML;
        currentButtonWidth = buttonMetrics.getWidth(currentButtonText)+10;
        if (currentButtonWidth > currentButton.getWidth()) {
            if (currentButtonWidth > buttonLength) {
                if (currentButtonWidth <= mediumButton) {
                    currentButton.addClass('os-btn-med');
                } else if (currentButtonWidth <= largeButton) {
                    currentButton.addClass('os-btn-lrg');
                } else {
                    currentButton.addClass('os-btn-fluid');
                    currentButton.update('<span>'+currentButtonText+'</span>');
                    currentButton.setWidth(currentButtonWidth+18);
                }
            }
        }
    }
}

mzinga.lms.ui.TableWidthLayout = Ext.extend(Ext.layout.TableLayout, {
	//private
	getNextCell : function(c){
		var curCol, curRow;
		if (c.cellPosition) {
			curCol = this.currentColumn = c.cellPosition.column, curRow = this.currentRow = c.cellPosition.row;
		} else {
			var cell = this.getNextNonSpan(this.currentColumn, this.currentRow);
			curCol = this.currentColumn = cell[0], curRow = this.currentRow = cell[1];
		}
		for(var rowIndex = curRow; rowIndex < curRow + (c.rowspan || 1); rowIndex++){
			if(!this.cells[rowIndex]){
				this.cells[rowIndex] = [];
			}
			for(var colIndex = curCol; colIndex < curCol + (c.colspan || 1); colIndex++){
				this.cells[rowIndex][colIndex] = true;
			}
		}
		var td = document.createElement('td');
		if(c.cellId){
			td.id = c.cellId;
		}
		var cls = 'x-table-layout-cell';
		if(c.cellCls){
			cls += ' ' + c.cellCls;
		}
		td.className = cls;
		if(c.colspan){
			td.colSpan = c.colspan;
		}
		if(c.rowspan){
			td.rowSpan = c.rowspan;
		}
		if(c.cellWidth){
			td.width = c.cellWidth;
		}
		this.getRow(curRow).appendChild(td);
		return td;
	}
});
Ext.Container.LAYOUTS['tablewidth'] = mzinga.lms.ui.TableWidthLayout;

/**
 * @class mzinga.lms.ui.ViewportPanel
 * Viewport like panel that doesn't greedily take the whole
 * body.
 * @constructor
 * @param config An object containing configuration items
 * for the Panel.  Besides the Ext.Panel configurations,
 * the following configurations may be specified:
 * - heightOffset The difference between the actual viewport
 * height and the viewport panel height. Default value is 100
 * - widthOffset Default value is 50. The difference between
 * the actual viewport width and the viewport panel width.
 * - fixedWidth a boolean indicating if the viewport has a fixed width.
 */
mzinga.lms.ui.ViewportPanel = Ext.extend(Ext.Panel, {
	/**
	 * Setup the viewport panel, calculating initial height and
	 * width based on the current viewport size.
	 */
    initComponent : function() {
		this.minHeight = this.minHeight == null ? 200:this.minHeight;
		this.heightOffset = this.heightOffset == null ? 100:this.heightOffset;
		this.widthOffset = this.widthOffset == null ?  50: this.widthOffset;
		mzinga.lms.ui.ViewportPanel.superclass.initComponent.call(this);
		var currentSize = Ext.getBody().getViewSize();
		if (!this.height) {
			this.height =(currentSize.height-this.heightOffset);
			if (this.height < this.minHeight) {
				this.height = 200;
			}			
		}
		if (!this.width && !this.fixedWidth) {
			this.width = (currentSize.width-this.widthOffset);
		}
        Ext.EventManager.onWindowResize(this.resizePanel, this);
    },

    /**
     * Handler for window resize.  Resizes the panel to the height and
     * width of the viewport after taking the heightOffset and widthOffset
     * into consideration.
     */
    resizePanel: function(w, h){
    	var newWidth;
    	var newHeight;

    	if (this.fixedWidth) {
    		newWidth = this.width;
    	} else {
    		newWidth = (w-this.widthOffset);
    	}

    	if (this.fixedHeight && this.height > (parseInt(h)-parseInt(this.heightOffset))) {
    		newHeight = this.height;
    	} else {
    		newHeight = (parseInt(h)-parseInt(this.heightOffset));
			if (newHeight < this.minHeight) {
				newHeight = 200;
			}
    	}
    	this.setSize(newWidth, newHeight);
    }
});
Ext.reg('viewportpanel', mzinga.lms.ui.ViewportPanel);

/**
 * @class Ext.form.MiscField
 * @extends Ext.BoxComponent
 * Base class to easily display simple text in the form layout.
 * @constructor
 * Creates a new MiscField Field
 * @param {Object} config Configuration options
 */
Ext.form.MiscField = function(config){
    Ext.form.MiscField.superclass.constructor.call(this, config);
};

Ext.extend(Ext.form.MiscField, Ext.BoxComponent,  {
    /**
     * @cfg {String/Object} autoCreate A DomHelper element spec, or true for a default element spec (defaults to
     * {tag: "div"})
     */
    defaultAutoCreate : {tag: "div"},

    /**
     * @cfg {String} fieldClass The default CSS class for the field (defaults to "x-form-field")
     */
    fieldClass : "x-form-field",

    // private
    isFormField : true,

    /**
     * @cfg {Mixed} value A value to initialize this field with.
     */
    value : undefined,

    /**
     * @cfg {Boolean} disableReset True to prevent this field from being reset when calling Ext.form.Form.reset()
     */
    disableReset: false,

    /**
     * @cfg {String} name The field's HTML name attribute.
     */
    /**
     * @cfg {String} cls A CSS class to apply to the field's underlying element.
     */

    // private ??
    initComponent : function(){
        Ext.form.MiscField.superclass.initComponent.call(this);
    },

    /**
     * Returns the name attribute of the field if available
     * @return {String} name The field name
     */
    getName: function(){
         return this.rendered && this.el.dom.name ? this.el.dom.name : (this.hiddenName || '');
    },

    // private
    onRender : function(ct, position){
        Ext.form.MiscField.superclass.onRender.call(this, ct, position);
        if(!this.el){
            var cfg = this.getAutoCreate();
            if(!cfg.name){
                cfg.name = this.name || this.id;
            }
            this.el = ct.createChild(cfg, position);
        }

        this.el.addClass([this.fieldClass, this.cls]);
        this.initValue();
    },

    /**
     * Apply the behaviors of this component to an existing element. <b>This is used instead of render().</b>
     * @param {String/HTMLElement/Element} el The id of the node, a DOM node or an existing Element
     * @return {Ext.form.MiscField} this
    applyTo : function(target){
        this.allowDomMove = false;
        this.el = Ext.get(target);
        this.render(this.el.dom.parentNode);
        return this;
    },
     */

    // private
    initValue : function(){
        if(this.value !== undefined){
            this.setRawValue(this.value);
        }else if(this.el.dom.innerHTML.length > 0){
            this.setRawValue(this.el.dom.innerHTML);
        }
    },

    /**
     * Returns true if this field has been changed since it was originally loaded.
     */
    isDirty : function() {
        return String(this.getRawValue()) !== String(this.originalValue);
    },

    // private
    afterRender : function(){
        Ext.form.MiscField.superclass.afterRender.call(this);
        this.initEvents();
    },

    /**
     * Resets the current field value to the originally-loaded value
     * @param {Boolean} force Force a reset even if the option disableReset is true
     */
    reset : function(force){
        if(!this.disableReset || force === true){
            this.setRawValue(this.originalValue);
        }
    },

    // private
    initEvents : function(){
        // reference to original value for reset
        this.originalValue = this.getRawValue();
    },

    /**
     * Returns whether or not the field value is currently valid
     * Always returns true, not used in MiscField.
     * @return {Boolean} True
     */
    isValid : function(){
        return true;
    },

    /**
     * Validates the field value
     * Always returns true, not used in MiscField.  Required for Ext.form.Form.isValid()
     * @return {Boolean} True
     */
    validate : function(){
        return true;
    },

    processValue : function(value){
        return value;
    },

    // private
    // Subclasses should provide the validation implementation by overriding this
    validateValue : function(value){
        return true;
    },

    /**
     * Mark this field as invalid
     * Not used in MiscField.  Required for Ext.form.Form.markInvalid()
     */
    markInvalid : function(){
        return;
    },

    /**
     * Clear any invalid styles/messages for this field
     * Not used in MiscField.  Required for Ext.form.Form.clearInvalid()
     */
    clearInvalid : function(){
        return;
    },

    /**
     * Returns the raw field value.
     * @return {Mixed} value The field value
     */
    getRawValue : function(){
        return this.el.dom.innerHTML;
    },

    /**
     * Returns the clean field value - plain text only, strips out HTML tags.
     * @return {Mixed} value The field value
     */
    getValue : function(){
        var f = Ext.util.Format;
        var v = f.trim(f.stripTags(this.getRawValue()));
        return v;
    },

    /**
     * Sets the raw field value.
     * @param {Mixed} value The value to set
     */
    setRawValue : function(v){
        this.value = v;
        if(this.rendered){
            this.el.dom.innerHTML = v;
        }
    },

    /**
     * Sets the clean field value - plain text only, strips out HTML tags.
     * @param {Mixed} value The value to set
     */
    setValue : function(v){
        var f = Ext.util.Format;
    this.setRawValue(f.trim(f.stripTags(v)));
    }
});

Ext.ComponentMgr.registerType('miscfield', Ext.form.MiscField);


Ext.ux.Portal = Ext.extend(Ext.Panel, {
    layout: 'column',
    autoScroll:true,
    cls:'x-portal',
    defaultType: 'portalcolumn',

    initComponent : function(){
        Ext.ux.Portal.superclass.initComponent.call(this);
        this.addEvents({
            validatedrop:true,
            beforedragover:true,
            dragover:true,
            beforedrop:true,
            drop:true
        });
    },

    initEvents : function(){
        Ext.ux.Portal.superclass.initEvents.call(this);
        this.dd = new Ext.ux.Portal.DropZone(this, this.dropConfig);
    },

    beforeDestroy: function() {
        if(this.dd){
            this.dd.unreg();
        }
        Ext.ux.Portal.superclass.beforeDestroy.call(this);
    }
});
Ext.reg('portal', Ext.ux.Portal);


Ext.ux.Portal.DropZone = function(portal, cfg){
    this.portal = portal;
    Ext.dd.ScrollManager.register(portal.body);
    Ext.ux.Portal.DropZone.superclass.constructor.call(this, portal.bwrap.dom, cfg);
    portal.body.ddScrollConfig = this.ddScrollConfig;
};

Ext.extend(Ext.ux.Portal.DropZone, Ext.dd.DropTarget, {
    ddScrollConfig : {
        vthresh: 50,
        hthresh: -1,
        animate: true,
        increment: 200
    },

    createEvent : function(dd, e, data, col, c, pos){
        return {
            portal: this.portal,
            panel: data.panel,
            columnIndex: col,
            column: c,
            position: pos,
            data: data,
            source: dd,
            rawEvent: e,
            status: this.dropAllowed
        };
    },

    notifyOver : function(dd, e, data){
        var xy = e.getXY(), portal = this.portal, px = dd.proxy;

        // case column widths
        if(!this.grid){
            this.grid = this.getGrid();
        }

        // handle case scroll where scrollbars appear during drag
        var cw = portal.body.dom.clientWidth;
        if(!this.lastCW){
            this.lastCW = cw;
        }else if(this.lastCW != cw){
            this.lastCW = cw;
            portal.doLayout();
            this.grid = this.getGrid();
        }

        // determine column
var col = 0, matchedcol = 0, nearestX = -1, nearestY = -1, xs = this.grid.columnXY, cmatch = false;

for(var len = xs.length; col < len; col++){
if(xy[0] < (xs[col].x + xs[col].w) && xy[1] < (xs[col].y + xs[col].h)){ if(nearestX < 0){
cmatch = true;
nearestX = xs[col].x + xs[col].w;
nearestY = xs[col].y + xs[col].h;
matchedcol = col;
continue;
}

if(((xs[col].x + xs[col].w) < nearestX) && ((xs[col].y + xs[col].h) < nearestY)){
nearestX = xs[col].x + xs[col].w;
nearestY = xs[col].y + xs[col].h;
matchedcol = col;
}
}
}
// no match, fix last index
if(!cmatch){
col--;
}else{
col = matchedcol;
}


        // find insert position
        var p, match = false, pos = 0,
            c = portal.items.itemAt(col),
            items = c.items.items, overSelf = false;

        for(var len = items.length; pos < len; pos++){
            p = items[pos];
            var h = p.el.getHeight();
            if(h === 0){
                overSelf = true;
            }
            else if((p.el.getY()+(h/2)) > xy[1]){
                match = true;
                break;
            }
        }

        pos = (match && p ? pos : c.items.getCount()) + (overSelf ? -1 : 0);
        var overEvent = this.createEvent(dd, e, data, col, c, pos);

        if(portal.fireEvent('validatedrop', overEvent) !== false &&
           portal.fireEvent('beforedragover', overEvent) !== false){

            // make sure proxy width is fluid
            px.getProxy().setWidth('auto');

            if(p){
                px.moveProxy(p.el.dom.parentNode, match ? p.el.dom : null);
            }else{
                px.moveProxy(c.el.dom, null);
            }

            this.lastPos = {c: c, col: col, p: overSelf || (match && p) ? pos : false};
            this.scrollPos = portal.body.getScroll();

            portal.fireEvent('dragover', overEvent);

            return overEvent.status;
        }else{
            return overEvent.status;
        }

    },

    notifyOut : function(){
        delete this.grid;
    },

    notifyDrop : function(dd, e, data){
        delete this.grid;
        if(!this.lastPos){
            return;
        }
        var c = this.lastPos.c, col = this.lastPos.col, pos = this.lastPos.p;

        var dropEvent = this.createEvent(dd, e, data, col, c,
            pos !== false ? pos : c.items.getCount());

        if(this.portal.fireEvent('validatedrop', dropEvent) !== false &&
           this.portal.fireEvent('beforedrop', dropEvent) !== false){

            dd.proxy.getProxy().remove();
            dd.panel.el.dom.parentNode.removeChild(dd.panel.el.dom);

            if(pos !== false){
                if(c == dd.panel.ownerCt && (c.items.items.indexOf(dd.panel) <= pos)){
                    pos++;
                }
                c.insert(pos, dd.panel);
            }else{
                c.add(dd.panel);
            }

            c.doLayout();

            this.portal.fireEvent('drop', dropEvent);

            // scroll position is lost on drop, fix it
            var st = this.scrollPos.top;
            if(st){
                var d = this.portal.body.dom;
                setTimeout(function(){
                	try {
                		d.scrollTop = st;
                	} catch (ignored) {}
                }, 10);
            }

        }
        delete this.lastPos;
    },

    // internal cache of body and column coords
    getGrid : function(){
        var box = this.portal.bwrap.getBox();
        box.columnXY = [];
        this.portal.items.each(function(c){
             box.columnXY.push({x: c.el.getX(), w: c.el.getWidth(),y:c.el.getY(),h:c.el.getHeight()});
        });
        return box;
    },

    // unregister the dropzone from ScrollManager
    unreg: function() {
    	try {
    		Ext.dd.ScrollManager.unregister(this.portal.body);
    	} catch (ignoredError) {
    		//ie throws an error on unload that can be ignored.
    	}
        Ext.ux.Portal.DropZone.superclass.unreg.call(this);
    }
});

Ext.ux.Portlet = Ext.extend(Ext.Panel, {
    anchor: '100%',
    frame:true,
    collapsible:true,
    draggable:true,
    cls:'x-portlet'
});
Ext.reg('portlet', Ext.ux.Portlet);

Ext.ux.PortalColumn = Ext.extend(Ext.Panel, {
    layout: 'anchor',
    autoEl: 'div',
    defaultType: 'portlet',
    cls:'x-portal-column'
});
Ext.reg('portalcolumn', Ext.ux.PortalColumn);

/*
 * @class Ext.ux.ManagedIFrame
 * Version:  1.03
 * Author: Doug Hendricks. doug[always-At]theactivegroup.com
 * Copyright 2007-2008, Active Group, Inc.  All rights reserved.
 *
 ************************************************************************************
 *   This file is distributed on an AS IS BASIS WITHOUT ANY WARRANTY;
 *   without even the implied warranty of MERCHANTABILITY or
 *   FITNESS FOR A PARTICULAR PURPOSE.
 ************************************************************************************

 License: ux.ManagedIFrame and ux.ManagedIFramePanel are licensed under the terms of
 the Open Source LGPL 3.0 license.  Commercial use is permitted to the extent
 that the code/component(s) do NOT become part of another Open Source or Commercially
 licensed development library or toolkit without explicit permission.

 Donations are welcomed: http://donate.theactivegroup.com

 License details: http://www.gnu.org/licenses/lgpl.html

 * <p> An Ext harness for iframe elements.

  Adds Ext.UpdateManager(Updater) support and a compatible 'update' method for
  writing content directly into an iFrames' document structure.

  Signals various DOM/document states as the frames content changes with 'domready',
  'documentloaded', and 'exception' events.  The domready event is only raised when
  a proper security context exists for the frame's DOM to permit modification.
  (ie, Updates via Updater or documents retrieved from same-domain servers).

  Frame sand-box permits eval/script-tag writes of javascript source.
  (See execScript, writeScript, and loadFunction methods for more info.)

  * Usage:<br>
   * <pre><code>
   * // Harnessed from an existing Iframe from markup:
   * var i = new Ext.ux.ManagedIFrame("myIframe");
   * // Replace the iFrames document structure with the response from the requested URL.
   * i.load("http://myserver.com/index.php", "param1=1&amp;param2=2");

   * // Notes:  this is not the same as setting the Iframes src property !
   * // Content loaded in this fashion does not share the same document namespaces as it's parent --
   * // meaning, there (by default) will be no Ext namespace defined in it since the document is
   * // overwritten after each call to the update method, and no styleSheets.
  * </code></pre>
  * <br>
   * @cfg {Boolean/Object} autoCreate True to auto generate the IFRAME element, or a {@link Ext.DomHelper} config of the IFRAME to create
   * @cfg {String} html Any markup to be applied to the IFRAME's document content when rendered.
   * @cfg {Object} loadMask An {@link Ext.LoadMask} config or true to mask the iframe while using the update or setSrc methods (defaults to false).
   * @cfg {Object} src  The src attribute to be assigned to the Iframe after initialization (overrides the autoCreate config src attribute)
   * @constructor
  * @param {Mixed} el, Config object The iframe element or it's id to harness or a valid config object.

 * Release:  1.04 (3/8/2008) Made documentloaded an async event call,
 *                           writeScript: Fixed Safari's missing head element.
 *                           add: getDocumentURI method.
 * Release:  1.03 (3/6/2008) Added message:tag event management to MIF object
 * Release:  1.02 (3/4/2008)  Adds tag-based messaging subscriptions
 * Release:  1.01 Final (2/20/2008)
 *    Added eventsFollowFrameLinks (true(default),false) config option --permitting events (domready, documentloaded)
 *       to fire as user follows embedded <A> links.

 * Release:  1.0 Final (2/15/2008)
 *  Added 'message' event for cross-frame message handling
 *  Added transparent DIV mask to prevent bleed-thru on some browsers when frames overlap or during drag-overs
 */

Ext.ux.ManagedIFrame = function(){
    var args=Array.prototype.slice.call(arguments, 0)
        ,el = Ext.get(args[0])
        ,config = args[0];

    if(el && el.dom && el.dom.tagName == 'IFRAME'){
            config = args[1] || {};
    }else{
            config = args[0] || args[1] || {};
            el = config.autoCreate?
            Ext.get(Ext.DomHelper.append(config.autoCreate.parent||document.body,
                Ext.applyIf(config.autoCreate,{tag:'iframe', src:(Ext.isIE&&Ext.isSecure)?Ext.SSL_SECURE_URL:''}))):null;
    }

    if(!el || el.dom.tagName != 'IFRAME') return el;

    !!el.dom.name.length || (el.dom.name = el.dom.id); //make sure there is a valid frame name

    this.addEvents({
       /**
         * @event domready
         * Fires ONLY when an iFrame's Document(DOM) has reach a state where the DOM may be manipulated (ie same domain policy)
         * @param {Ext.ux.ManagedIFrame} this
         * Note: This event is only available when overwriting the iframe document using the update method and to pages
         * retrieved from a "same domain".
         * Returning false from the eventHandler stops further event (documentloaded) processing.
         */
        "domready"       : true,

       /**
         * @event documentloaded
         * Fires when the iFrame has reached a loaded/complete state.
         * @param {Ext.ux.ManagedIFrame} this
         */
        "documentloaded" : true,

        /**
         * @event exception
         * Fires when the iFrame raises an error
         * @param {Ext.ux.ManagedIFrame} this
         * @param {Object/string} exception
         */
        "exception" : true,
        /**
         * @event message
         * Fires upon receipt of a message generated by window.sendMessage method of the embedded Iframe.window object
         * @param {Ext.ux.ManagedIFrame} this
         * @param {object} message (members:  type: {string} literal "message",
         *                                    data {Mixed} [the message payload],
         *                                    domain [the document domain from which the message originated ],
         *                                    uri {string} the document URI of the message sender
         *                                    source (Object) the window context of the message sender
         *                                    tag {string} optional reference tag sent by the message sender
         */
        "message" : true
        /**
         * Alternate event handler syntax for message:tag filtering
         * @event message:tag
         * Fires upon receipt of a message generated by window.sendMessage method
         * which includes a specific tag value of the embedded Iframe.window object
         * @param {Ext.ux.ManagedIFrame} this
         * @param {object} message (members:  type: {string} literal "message",
         *                                    data {Mixed} [the message payload],
         *                                    domain [the document domain from which the message originated ],
         *                                    uri {string} the document URI of the message sender
         *                                    source (Object) the window context of the message sender
         *                                    tag {string} optional reference tag sent by the message sender
         */
        //"message:tagName"
    });

    if(config.listeners){
        this.listeners=config.listeners;
        Ext.ux.ManagedIFrame.superclass.constructor.call(this);
    }

    Ext.apply(el,this);  // apply this class interface ( pseudo Decorator )

    el.addClass('x-managed-iframe');
    if(config.style){
        el.applyStyles(config.style);
    }

    //Generate CSS Rules
    var CSS = Ext.util.CSS, rules=[];
    CSS.getRule('.x-managed-iframe') || ( rules.push('.x-managed-iframe {height:100%;width:100%;overflow:auto;}'));
    CSS.getRule('.x-frame-shim')   || ( rules.push('.x-frame-shim {z-index:18000!important;position:absolute;top:0;left:0;background-color:transparent;width:100%;height:100%;zoom:1;}'));
    CSS.getRule('.x-managed-iframe-mask')   || ( rules.push('.x-managed-iframe-mask {width:100%;height:100%;position:relative;}'));
    if(!!rules.length){
        CSS.createStyleSheet(rules.join(' '));
    }

    el._maskEl = el.parent('.x-managed-iframe-mask') || el.parent().addClass('x-managed-iframe-mask');
    Ext.apply(el._maskEl,{
       applyShim :  function(shimCls){
           if(this._mask){
               this._mask.remove();
           }
           this._mask = Ext.DomHelper.append(this.dom, {cls:shimCls||"x-frame-shim"}, true);
           this.addClass("x-masked");
           this._mask.setDisplayed(true);
       },
       removeShim  : function(){ this.unmask(); }
    });

    Ext.apply(el,{
      disableMessaging : config.disableMessaging===true
     ,applyShim        : el._maskEl.applyShim.createDelegate(el._maskEl)
     ,removeShim       : el._maskEl.removeShim.createDelegate(el._maskEl)
     ,loadMask         : Ext.apply({msg:'Loading..'
                            ,msgCls:'x-mask-loading'
                            ,maskEl: el._maskEl
                            ,hideOnReady:true
                            ,disabled:!config.loadMask},config.loadMask)
    //Hook the Iframes loaded state handler
     ,_eventName       : Ext.isIE?'onreadystatechange':'onload'
     ,_windowContext   : null
     ,eventsFollowFrameLinks  : typeof config.eventsFollowFrameLinks=='undefined'?
                                true:config.eventsFollowFrameLinks
    });

    el.dom[el._eventName] = el.loadHandler.createDelegate(el);

    if(document.addEventListener){  //for Gecko and Opera and any who might support it later
       Ext.EventManager.on(window,"DOMFrameContentLoaded", el.dom[el._eventName]);
    }

    var um = el.updateManager=new Ext.UpdateManager(el,true);
    um.showLoadIndicator= config.showLoadIndicator || false;

    if(config.src){
        el.setSrc(config.src);
    }else{

        var content = config.html || config.content || false;

        if(content){
            el.update.defer(10,el,[content]); //allow frame to quiesce
        }
    }

    return Ext.ux.ManagedIFrame.Manager.register(el);

};

Ext.extend(Ext.ux.ManagedIFrame , Ext.util.Observable,
    {

    src : null ,
      /**
      * Sets the embedded Iframe src property.

      * @param {String/Function} url (Optional) A string or reference to a Function that returns a URI string when called
      * @param {Boolean} discardUrl (Optional) If not passed as <tt>false</tt> the URL of this action becomes the default SRC attribute for
      * this iframe, and will be subsequently used in future setSrc calls (emulates autoRefresh by calling setSrc without params).
      * Note:  invoke the function with no arguments to refresh the iframe based on the current src value.
     */
    setSrc : function(url, discardUrl, callback){
          var reset = Ext.isIE&&Ext.isSecure?Ext.SSL_SECURE_URL:'';
          var src = url || this.src || reset;

          if(Ext.isOpera){
              this.dom.src = reset;
           }
          this._windowContext = null;
          this._hooked = this._domReady = this._domFired = false;
          this._callBack = callback || false;

          this.showMask();

          (function(){
                var s = typeof src == 'function'?src()||'':src;
                try{
                    this._frameAction = true; //signal listening now
                    this.dom.src = s;
                    this.frameInit= true; //control initial event chatter
                    this.checkDOM();
                }catch(ex){ this.fireEvent('exception', this, ex); }

          }).defer(10,this);

          if(discardUrl !== true){ this.src = src; }

          return this;

    },
    reset     : function(src, callback){
          this.setSrc(src || (Ext.isIE&&Ext.isSecure?Ext.SSL_SECURE_URL:''),true,callback);

    },
    //Private: script removal RegeXp
    scriptRE  : /(?:<script.*?>)((\n|\r|.)*?)(?:<\/script>)/gi
    ,
    /*
     * Write(replacing) string content into the IFrames document structure
     * @param {String} content The new content
     * @param {Boolean} loadScripts (optional) true to also render and process embedded scripts
     * @param {Function} callback (optional) Callback when update is complete.
     */
    update : function(content,loadScripts,callback){

        loadScripts = loadScripts || this.getUpdateManager().loadScripts || false;

        content = Ext.DomHelper.markup(content||'');
        content = loadScripts===true ? content:content.replace(this.scriptRE , "");

        var doc;

        if(doc  = this.getDocument()){

            this._frameAction = !!content.length;
            this._windowContext = this.src = null;
            this._callBack = callback || false;
            this._hooked = this._domReady = this._domFired = false;

            this.showMask();
            doc.open();
            doc.write(content);
            doc.close();
            this.frameInit= true; //control initial event chatter
            if(this._frameAction){
                this.checkDOM();
            } else {
                this.hideMask(true);
                if(this._callBack)this._callBack();
            }

        }else{
            this.hideMask(true);
            if(this._callBack)this._callBack();
        }
        return this;
    },

    /* Enables/disables x-frame messaging interface */
    disableMessaging :  true,

    //Private, frame messaging interface (for same-domain-policy frames only)
    _XFrameMessaging  :  function(){
        //each tag gets a hash queue ($ = no tag ).
        var tagStack = {'$' : [] };
        var isEmpty = function(v, allowBlank){
             return v === null || v === undefined || (!allowBlank ? v === '' : false);
        };
        window.sendMessage = function(message, tag, origin ){
            var MIF;
            if(MIF = arguments.callee.manager){
                if(message._fromHost){
                    var fn, result;
                    //only raise matching-tag handlers
                    var compTag= message.tag || tag || null;
                    var mstack = !isEmpty(compTag)? tagStack[compTag.toLowerCase()]||[] : tagStack["$"];

                    for(var i=0,l=mstack.length;i<l;i++){
                        if(fn = mstack[i]){
                            result = fn.apply(fn.__scope,arguments)===false?false:result;
                            if(fn.__single){mstack[i] = null;}
                            if(result === false){break;}
                        }
                    }

                    return result;
                }else{

                    message =
                        {type   :isEmpty(tag)?'message':'message:'+tag.toLowerCase().replace(/^\s+|\s+$/g,'')
                        ,data   :message
                        ,domain :origin || document.domain
                        ,uri    :document.documentURI
                        ,source :window
                        ,tag    :isEmpty(tag)?null:tag.toLowerCase()
                        };

                    try{
                       return MIF.disableMessaging !== true
                        ? MIF.fireEvent.call(MIF,message.type,MIF, message)
                        : null;
                    }catch(ex){} //trap for message:tag handlers not yet defined

                    return null;
                }

            }
        };
        window.onhostmessage = function(fn,scope,single,tag){

            if(typeof fn == 'function' ){
                if(!isEmpty(fn.__index)){
                    throw "onhostmessage: duplicate handler definition" + (tag?" for tag:"+tag:'');
                }

                var k = isEmpty(tag)? "$":tag.toLowerCase();
                tagStack[k] || ( tagStack[k] = [] );
                Ext.apply(fn,{
                   __tag    : k
                  ,__single : single || false
                  ,__scope  : scope || window
                  ,__index  : tagStack[k].length
                });
                tagStack[k].push(fn);

            } else
               {throw "onhostmessage: function required";}


        };
        window.unhostmessage = function(fn){
            if(typeof fn == 'function' && typeof fn.__index != 'undefined'){
                var k = fn.__tag || "$";
                tagStack[k][fn.__index]=null;
            }
        };


    },

    //Private execScript sandbox and messaging interface
    _renderHook : function(){

        this._windowContext = null;
        this._hooked = false;
        try{
           if(this.writeScript('(function(){parent.Ext.get("'+
                                this.dom.id+
                                '")._windowContext='+
                                (Ext.isIE?'window':'{eval:function(s){return eval(s);}}')+
                                ';})();')){

                if(this.disableMessaging !== true){
                       this.loadFunction({name:'XMessage',fn:this._XFrameMessaging},false,true);
                       var sm;
                       if(sm=this.getWindow().sendMessage){
                           sm.manager = this;
                       }
               }
           }
           return this.domWritable();
          }catch(ex){}
        return false;

    },
    /* dispatch a message to the embedded frame-window context */
    sendMessage : function (message,tag,origin){
         var win;
         if(this.disableMessaging !== true && (win = this.getWindow())){
              //support frame-to-frame messaging relay
              tag || (tag= message.tag || '');
              tag = tag.toLowerCase();
              message = Ext.applyIf(message.data?message:{data:message},
                                 {type   :Ext.isEmpty(tag)?'message':'message:'+tag
                                 ,domain :origin || document.domain
                                 ,uri    : document.documentURI
                                 ,source : window
                                 ,tag    :tag || null
                                 ,_fromHost: this
                    });
             return win.sendMessage?win.sendMessage.call(null,message,tag,origin): null;
         }
         return null;

    },
    _windowContext : null,
    /*
      Return the Iframes document object
    */
    getDocument:function(){
        return this.getWindow()?this.getWindow().document:null;
    },

    //Attempt to retrieve the frames current URI
    getDocumentURI : function(){
        var URI;
        try{
           URI = this.src?this.getDocument().location.href:null;
        }catch(ex){} //will fail on NON-same-origin domains

        return URI || this.src;
    },
    /*
     Return the Iframes window object
    */
    getWindow:function(){
        var dom= this.dom;
        return dom?dom.contentWindow||window.frames[dom.name]:null;
    },

    /*
     Print the contents of the Iframes (if we own the document)
    */
    print:function(){
        try{
            var win = this.getWindow();
            if(Ext.isIE){win.focus();}
            win.print();
        } catch(ex){
            throw 'print exception: ' + (ex.description || ex.message || ex);
        }
    },
    //private
    destroy:function(){
        this.removeAllListeners();

        if(this.dom){
             //unHook the Iframes loaded state handlers
             if(document.addEventListener){ //Gecko/Opera
                Ext.EventManager.un(window,"DOMFrameContentLoaded", this.dom[this._eventName]);
               }
             this.dom[this._eventName]=null;

             this._windowContext = null;
             //IE Iframe cleanup
             if(Ext.isIE && this.dom.src){
                this.dom.src = 'javascript:false';
             }
             this._maskEl = null;
             Ext.removeNode(this.dom);

        }

        Ext.apply(this.loadMask,{masker :null ,maskEl : null});
        Ext.ux.ManagedIFrame.Manager.deRegister(this);
    }
    /* Returns the general DOM modification capability of the frame. */
    ,domWritable  : function(){
        return !!this._windowContext;
    }
    /*
     *  eval a javascript code block(string) within the context of the Iframes window object.
     * @param {String} block A valid ('eval'able) script source block.
     * @param {Boolean} useDOM - if true inserts the fn into a dynamic script tag,
     *                           false does a simple eval on the function definition. (useful for debugging)
     * <p> Note: will only work after a successful iframe.(Updater) update
     *      or after same-domain document has been hooked, otherwise an exception is raised.
     */
    ,execScript: function(block, useDOM){
      try{
        if(this.domWritable()){
            if(useDOM){
               this.writeScript(block);
            }else{
                return this._windowContext.eval(block);
            }

        }else{ throw 'execScript:non-secure context' }
       }catch(ex){
            this.fireEvent('exception', this, ex);
            return false;
        }
        return true;

    }
    /*
     *  write a <script> block into the iframe's document
     * @param {String} block A valid (executable) script source block.
     * @param {object} attributes Additional Script tag attributes to apply to the script Element (for other language specs [vbscript, Javascript] etc.)
     * <p> Note: writeScript will only work after a successful iframe.(Updater) update
     *      or after same-domain document has been hooked, otherwise an exception is raised.
     */
    ,writeScript  : function(block, attributes) {
        attributes = Ext.apply({},attributes||{},{type :"text/javascript",text:block});

         try{
            var head,script, doc= this.getDocument();
            if(doc && doc.getElementsByTagName){
                if(!(head = doc.getElementsByTagName("head")[0] )){
                    //some browsers (Webkit, Safari) do not auto-create
                    //head elements during document.write
                    head =doc.createElement("head");
                    doc.getElementsByTagName("html")[0].appendChild(head);
                }
                if(head && (script = doc.createElement("script"))){
                    for(var attrib in attributes){
                          if(attributes.hasOwnProperty(attrib) && attrib in script){
                              script[attrib] = attributes[attrib];
                          }
                    }
                    return !!head.appendChild(script);
                }
            }
         }catch(ex){ this.fireEvent('exception', this, ex);}
         return false;
    }
    /*
     * Eval a function definition into the iframe window context.
     * args:
     * @param {String/Object} name of the function or
                              function map object: {name:'encodeHTML',fn:Ext.util.Format.htmlEncode}
     * @param {Boolean} useDOM - if true inserts the fn into a dynamic script tag,
                                    false does a simple eval on the function definition,
     * examples:
     * var trim = function(s){
     *     return s.replace( /^\s+|\s+$/g,'');
     *     };
     * iframe.loadFunction('trim');
     * iframe.loadFunction({name:'myTrim',fn:String.prototype.trim || trim});
     */
    ,loadFunction : function(fn, useDOM, invokeIt){

       var name  =  fn.name || fn;
       var    fn =  fn.fn   || window[fn];
       this.execScript(name + '=' + fn, useDOM); //fn.toString coercion
       if(invokeIt){
           this.execScript(name+'()') ; //no args only
        }
    }

    //Private
    ,showMask: function(msg,msgCls,forced){
          var lmask;
          if((lmask = this.loadMask) && (!lmask.disabled|| forced)){
               if(lmask._vis)return;
               lmask.masker || (lmask.masker = Ext.get(lmask.maskEl||this.dom.parentNode||this.wrap({tag:'div',style:{position:'relative'}})));
               lmask._vis = true;
               lmask.masker.mask.defer(lmask.delay||5,lmask.masker,[msg||lmask.msg , msgCls||lmask.msgCls] );
           }
       }
    //Private
    ,hideMask: function(forced){
           var tlm;
           if((tlm = this.loadMask) && !tlm.disabled && tlm.masker ){
               if(!forced && (tlm.hideOnReady!==true && this._domReady)){return;}
               tlm._vis = false;
               tlm.masker.unmask.defer(tlm.delay||5,tlm.masker);
           }
    }

    /* Private
      Evaluate the Iframes readyState/load event to determine its 'load' state,
      and raise the 'domready/documentloaded' event when applicable.
    */
    ,loadHandler : function(e){

        if(!this.frameInit || (!this._frameAction && !this.eventsFollowFrameLinks)){return;}

        var rstatus = (e && typeof e.type !== 'undefined'?e.type:this.dom.readyState );
        switch(rstatus){
            case 'loading':  //IE
            case 'interactive': //IE

              break;
            case 'DOMFrameContentLoaded': //Gecko, Opera

              if(this._domFired || (e && e.target !== this.dom)){ return;} //not this frame.

            case 'domready': //MIF
              if(this._domFired)return;
              if(this._domFired = this._hooked = this._renderHook() ){
                 this._frameAction = (this.fireEvent("domready",this) === false?false:this._frameAction);  //Only raise if sandBox injection succeeded (same domain)
              }
            case 'domfail': //MIF

              this._domReady = true;
              this.hideMask();
              break;
            case 'load': //Gecko, Opera
            case 'complete': //IE
              if(!this._domFired ){  // one last try for slow DOMS.
                  this.loadHandler({type:'domready'});
              }
              this.hideMask(true);
              if(this._frameAction || this.eventsFollowFrameLinks ){
                //not going to wait for the event chain, as its not cancellable anyhow.
                this.fireEvent.defer(50,this,["documentloaded",this]);
              }
              this._frameAction = false;
              if(this.eventsFollowFrameLinks){  //reset for link tracking
                  this._domFired = this._domReady = false;
              }
              if(this._callBack){
                   this._callBack(this);
              }

              break;
            default:
        }

    }
    /* Private
      Poll the Iframes document structure to determine DOM ready state,
      and raise the 'domready' event when applicable.
    */
    ,checkDOM : function(win){
        if(Ext.isOpera)return;
        //initialise the counter
        var n = 0
            ,win = win||this.getWindow()
            ,manager = this
            ,domReady = false
            ,max = 100;

            var poll =  function(){  //DOM polling for IE and others
               try{
                 domReady  =false;
                 var doc = win.document,body;
                 if(!manager._domReady){
                    domReady = (doc && doc.getElementsByTagName);
                    domReady = domReady && (body = doc.getElementsByTagName('body')[0]) && !!body.innerHTML.length;
                 }

               }catch(ex){
                     n = max; //likely same-domain policy violation
               }

                //if the timer has reached 100 (timeout after 3 seconds)
                //in practice, shouldn't take longer than 7 iterations [in kde 3
                //in second place was IE6, which takes 2 or 3 iterations roughly 5% of the time]

                if(!manager._frameAction || manager._domReady)return;

                if(n++ < max && !domReady )
                {
                    //try again
                    setTimeout(arguments.callee, 10);
                    return;
                }
                manager.loadHandler ({type:domReady?'domready':'domfail'});

            };
            setTimeout(poll,50);
         }
 });

 Ext.ux.ManagedIFrame.Manager = function(){
  var frames = {};
  return {

    register     :function(frame){
        frame.manager = this;
        return frames[frame.id] = frame;
    },
    deRegister     :function(frame){
        if(frames[frame.id] )delete frames[frame.id];

    },
    hideDragMask : function(){
        if(!this.inDrag)return;
        Ext.select('.x-managed-iframe-mask',true).each(function(maskEl){
            maskEl.removeShim();
        });
        this.inDrag = false;
    },
    /* Mask ALL ManagedIframes (eg. when a region-layout.splitter is on the move.)*/
    showDragMask : function(){
       if(!this.inDrag ){
          this.inDrag = true;
          Ext.select('.x-managed-iframe-mask',true).each(function(maskEl){
               maskEl.applyShim();
           });
       }

    }
   }

 }();

 /*
  * @class Ext.ux.ManagedIFramePanel
  * Version:  1.04  (3/12/2008) State-Management change persists the last URL loaded by the frame.
  *                             ondocumentloaded now fires asynchronously
  *                             Dragmask was not handling nested border layouts
  * Version:  1.03  (3/4/2008) Added message:tag event Management to MIFP interface.
  * Version:  1.02  (3/4/2008) No changes.
  * Version:  1.01  (2/20/2008)
  *     Added frameConfig.eventsFollowFrameLinks option --permitting events (domready, documentloaded)
  *       to fire as user follows embedded <A> links.
  *     Added frameConfig option, allows fine-grain control over the Iframes' config during lazy rendering.
  *     Further enhanced auto-drag-mask support when panel is a member of border layout.
  * Version:  1.0 Final (2/15/2008)
  *     Added 'message'(new) event cross-frame message handling
  *     Added auto-drag-mask support when panel is a member of border layout.
  *
  * Version:  RC 2.01 checkDom defer adjustment.
  *     Improved domready,documentloaded, exception(new) event handling
  * Version:  RC 2
  *     Improved domready,documentloaded, exception(new) event handling
  *     Added getFrame, getFrameWindow, getFrameDocument, loadFunction, writeScript, and domWritable members to MIF
  * Version:  RC1.1
  *     Modified default bodyCfg property for IE6 secure pages
  *     Added getFrame, getFrameWindow, and getFrameDocument members to MIFP
  * Version:  RC1
  *     Adds unsupportedText property to render an element/text indicating lack of Iframe support
  *     Improves el visibility/display support when hiding panels (FF does not reload iframe if using visibility mode)
  *     Adds custom renderer definition to autoLoad config.
  * Version:  0.16
  *     fixed (inherited)panel destroy bugs and iframe cleanup. (now, no orphans/leaks for IE).
  *     added loadMask.disabled= (true/false) toggle
  *     Requesting the Panel.getUpdater now returns the Updater for the Iframe.
  *     MIP.load modified to load content into panel.iframe (rather than panel.body)
  * Version:  0.15
  *     enhanced loadMask.maskEl support to support panel element names ie: 'body, bwrap' etc
  * Version:  0.13
  *     Added loadMask support and refactored domready/documentloaded events
  * Version:  0.11
  *     Made Panel state-aware.
  * Version:  0.1
  * Author: Doug Hendricks 12/2007 doug[always-At]theactivegroup.com
  *
  *
 */
 Ext.ux.ManagedIframePanel = Ext.extend(Ext.Panel, {

    /**
    * Cached Iframe.src url to use for refreshes. Overwritten every time setSrc() is called unless "discardUrl" param is set to true.
    * @type String/Function (which will return a string URL when invoked)
     */
    defaultSrc  :null,
    bodyStyle   :{height:'100%',width:'100%'},

    /**
    * @cfg {String/Object} iframeStyle
    * Custom CSS styles to be applied to the ux.ManagedIframe element in the format expected by {@link Ext.Element#applyStyles}
    * (defaults to CSS Rule {overflow:'auto'}).
    */
    frameStyle  : false,
    loadMask    : false,
    animCollapse: false,
    autoScroll  : false,
    closable    : true, /* set True by default in the event a site times-out while loadMasked */
    ctype       : "Ext.ux.ManagedIframePanel",
    showLoadIndicator : false,

    /**
    *@cfg {String/Object} unsupportedText Text (or Ext.DOMHelper config) to display within the rendered iframe tag to indicate the frame is not supported
    */
    unsupportedText : 'Inline frames are NOT enabled\/supported by your browser.'

   ,initComponent : function(){

        var unsup =this.unsupportedText?{html:this.unsupportedText}:false;
        this.frameConfig || (this.frameConfig = {autoCreate:{}});

        var iframeConfig = Ext.apply({
        	tag:'iframe',
            frameborder  : 0,
            cls          : 'x-managed-iframe',
            style        : this.frameStyle || this.iframeStyle || false
        },this.frameConfig.autoCreate);
        iframeConfig = Ext.apply(iframeConfig, unsup);
        if (Ext.isIE&&Ext.isSecure) {
        	iframeConfig = Ext.applyIf(iframeConfig,{src:Ext.SSL_SECURE_URL});
        }
        if (this.frameScrolling) {
        	iframeConfig = Ext.applyIf(iframeConfig,{scrolling:this.frameScrolling});
        }

        this.bodyCfg ||
           (this.bodyCfg =
               {tag:'div'
               ,cls:'x-panel-body'
               ,children:[
                  {  cls    :'x-managed-iframe-mask' //shared masking DIV for loadMask/dragMask
                    ,children:[iframeConfig]
                  }]
           });

         this.autoScroll = false; //Force off as the Iframe manages this

         //setup stateful events if not defined
         if(this.stateful !== false){
             this.stateEvents || (this.stateEvents = ['documentloaded']);
         }

         Ext.ux.ManagedIframePanel.superclass.initComponent.call(this);

         this.monitorResize || (this.monitorResize = this.fitToParent);

         this.addEvents({documentloaded:true, domready:true,message:true,exception:true});

         //apply the addListener patch for 'message:tagging'
         this.addListener = this.on;

    },

    doLayout   :  function(){
        //only resize (to Parent) if the panel is NOT in a layout.
        //parentNode should have {style:overflow:hidden;} applied.
        if(this.fitToParent && !this.ownerCt){
            var pos = this.getPosition(), size = (Ext.get(this.fitToParent)|| this.getEl().parent()).getViewSize();
            this.setSize(size.width - pos[0], size.height - pos[1]);
        }
        Ext.ux.ManagedIframePanel.superclass.doLayout.apply(this,arguments);

    },

      // private
    beforeDestroy : function(){

        if(this.rendered){

             if(this.tools){
                for(var k in this.tools){
                      Ext.destroy(this.tools[k]);
                }
             }

             if(this.header && this.headerAsText){
                var s;
                if( s=this.header.child('span')) s.remove();
                this.header.update('');
             }

             Ext.each(['iframe','header','topToolbar','bottomToolbar','footer','loadMask','body','bwrap'],
                function(elName){
                  if(this[elName]){
                    if(typeof this[elName].destroy == 'function'){
                         this[elName].destroy();
                    } else { Ext.destroy(this[elName]); }

                    this[elName] = null;
                    delete this[elName];
                  }
             },this);
        }

        Ext.ux.ManagedIframePanel.superclass.beforeDestroy.call(this);
    },
    onDestroy : function(){
        //Yes, Panel.super (Component), since we're doing Panel cleanup beforeDestroy instead.
        Ext.Panel.superclass.onDestroy.call(this);
    },
    // private
    onRender : function(ct, position){
        Ext.ux.ManagedIframePanel.superclass.onRender.call(this, ct, position);

        if(this.iframe = this.body.child('iframe.x-managed-iframe')){

            // Set the Visibility Mode for el, bwrap for collapse/expands/hide/show
            Ext.each(
                [this[this.collapseEl],this.el,this.iframe]
                ,function(el){
                     el.setVisibilityMode(Ext.Element[(this.hideMode||'display').toUpperCase()] || 1).originalDisplay = (this.hideMode != 'display'?'visible':'block');
            },this);

            if(this.loadMask){
                this.loadMask = Ext.apply({disabled     :false
                                          ,maskEl       :this.body
                                          ,hideOnReady  :true}
                                          ,this.loadMask);
             }

            if(this.iframe = new Ext.ux.ManagedIFrame(this.iframe, Ext.apply({
                    loadMask           :this.loadMask
                   ,showLoadIndicator  :this.showLoadIndicator
                   ,disableMessaging   :this.disableMessaging
                   },this.frameConfig))){

                this.loadMask = this.iframe.loadMask;
                this.iframe.ownerCt = this;
                this.relayEvents(this.iframe, ["documentloaded","domready","exception","message"].concat(this._msgTagHandlers ||[]));
                delete this._msgTagHandlers;
            }

            this.getUpdater().showLoadIndicator = this.showLoadIndicator || false;

            // Enable auto-dragMask if the panel participates in border layout.
            var ownerCt = this.ownerCt;
            while(ownerCt){

                ownerCt.on('afterlayout',function(container,layout){
                        var MIM = Ext.ux.ManagedIFrame.Manager,st=false;
                        Ext.each(['north','south','east','west'],function(region){
                            var reg;
                            if((reg = layout[region]) && reg.splitEl){
                                st = true;
                                if(!reg.split._splitTrapped){
                                    reg.split.on('beforeresize',MIM.showDragMask,MIM);
                                    reg.split._splitTrapped = true;
                                }
                            }
                        },this);
                        if(st && !this._splitTrapped ){
                            this.on('resize',MIM.hideDragMask,MIM);
                            this._splitTrapped = true;

                        }

                },this,{single:true});

                ownerCt = ownerCt.ownerCt; //nested layouts
             }


        }
    },
        // private
    afterRender : function(container){
        var html = this.html;
        delete this.html;
        Ext.ux.ManagedIframePanel.superclass.afterRender.call(this);
        if(this.iframe){
            if(this.defaultSrc){
                this.setSrc();
            }
            else if(html){
                this.iframe.update(typeof html == 'object' ? Ext.DomHelper.markup(html) : html);
            }
        }

    }
    ,sendMessage :function (){
        if(this.iframe){
            this.iframe.sendMessage.apply(this.iframe,arguments);
        }

    }
    //relay all defined 'message:tag' event handlers
    ,on : function(name){
           var tagRE=/^message\:/i, n = null;
           if(typeof name == 'object'){
               for (var na in name){
                   if(!this.filterOptRe.test(na) && tagRE.test(na)){
                      n || (n=[]);
                      n.push(na.toLowerCase());
                   }
               }
           } else if(tagRE.test(name)){
                  n=[name.toLowerCase()];
           }

           if(this.getFrame() && n){
               this.relayEvents(this.iframe,n);
           }else{
               this._msgTagHandlers || (this._msgTagHandlers =[]);
               if(n)this._msgTagHandlers = this._msgTagHandlers.concat(n); //queued for onRender when iframe is available
           }
           Ext.ux.ManagedIframePanel.superclass.on.apply(this, arguments);

    },

    /**
    * Sets the embedded Iframe src property.
    * @param {String/Function} url (Optional) A string or reference to a Function that returns a URI string when called
    * @param {Boolean} discardUrl (Optional) If not passed as <tt>false</tt> the URL of this action becomes the default URL for
    * this panel, and will be subsequently used in future setSrc calls.
    * Note:  invoke the function with no arguments to refresh the iframe based on the current defaultSrc value.
    */
    setSrc : function(url, discardUrl,callback){
         url = url || this.defaultSrc || false;

         if(!url)return this;

         if(url.url){
            callback = url.callback || false;
            discardUrl = url.discardUrl || false;
            url = url.url || false;

         }
         var src = url || (Ext.isIE&&Ext.isSecure?Ext.SSL_SECURE_URL:'');

         if(this.rendered && this.iframe){

              this.iframe.setSrc(src,discardUrl,callback);
           }

         return this;
    },

    //Make it state-aware
    getState: function(){

         var URI = this.iframe?this.iframe.getDocumentURI()||null:null;
         return Ext.apply(Ext.ux.ManagedIframePanel.superclass.getState.call(this) || {},
             URI?{defaultSrc  : typeof f == 'function'?URI():URI}:null );

    },
    /**
     * Get the {@link Ext.Updater} for this panel's iframe/or body. Enables you to perform Ajax-based document replacement of this panel's iframe document.
     * @return {Ext.Updater} The Updater
     */
    getUpdater : function(){
        return this.rendered?(this.iframe||this.body).getUpdater():null;
    },
    /**
     * Get the embedded iframe Ext.Element for this panel
     * @return {Ext.Element} The Panels ux.ManagedIFrame instance.
     */
    getFrame : function(){
        return this.rendered?this.iframe:null
    },
    /**
     * Get the embedded iframe's window object
     * @return {Object} or Null if unavailable
     */
    getFrameWindow : function(){
        return this.rendered && this.iframe?this.iframe.getWindow():null
    },
    /**
     * Get the embedded iframe's document object
     * @return {Object} or null if unavailable
     */
    getFrameDocument : function(){
        return this.rendered && this.iframe?this.iframe.getDocument():null
    },
     /**
      * Loads this panel's iframe immediately with content returned from an XHR call.
      * @param {Object/String/Function} config A config object containing any of the following options:
    <pre><code>
    panel.load({
        url: "your-url.php",
        params: {param1: "foo", param2: "bar"}, // or a URL encoded string
        callback: yourFunction,
        scope: yourObject, // optional scope for the callback
        discardUrl: false,
        nocache: false,
        text: "Loading...",
        timeout: 30,
        scripts: false,
        renderer:{render:function(el, response, updater, callback){....}}  //optional custom renderer
    });
    </code></pre>
         * The only required property is url. The optional properties nocache, text and scripts
         * are shorthand for disableCaching, indicatorText and loadScripts and are used to set their
         * associated property on this panel Updater instance.
         * @return {Ext.Panel} this
         */
    load : function(loadCfg){
         var um;
         if(um = this.getUpdater()){
            if (loadCfg && loadCfg.renderer) {
                 um.setRenderer(loadCfg.renderer);
                 delete loadCfg.renderer;
            }
            um.update.apply(um, arguments);
         }
         return this;
    }
     // private
    ,doAutoLoad : function(){
        this.load(
            typeof this.autoLoad == 'object' ?
                this.autoLoad : {url: this.autoLoad});
    }
    // private
    ,onShow : function(){
        if(this.iframe)this.iframe.setVisible(true);
        Ext.ux.ManagedIframePanel.superclass.onShow.call(this);
    }

    // private
    ,onHide : function(){
        if(this.iframe)this.iframe.setVisible(false);
        Ext.ux.ManagedIframePanel.superclass.onHide.call(this);
    }
});

Ext.reg('iframepanel', Ext.ux.ManagedIframePanel);

Ext.ux.ManagedIframePortlet = Ext.extend(Ext.ux.ManagedIframePanel, {
     anchor: '100%',
     frame:true,
     collapseEl:'bwrap',
     collapsible:true,
     draggable:true,
     cls:'x-portlet'
 });
Ext.reg('iframeportlet', Ext.ux.ManagedIframePortlet);

//@ sourceURL=<miframe.js>


function getMarginTop(inWin, oElement) {
    var marginValue;
    if( window.getComputedStyle ) {
        marginValue = inWin.getComputedStyle(oElement,null).getPropertyValue('margin-top');
    } else if( oElement.currentStyle ) {
        marginValue = oElement.currentStyle.marginTop;
    } else {
        marginValue = '0px';
    }
    return parseInt(marginValue.split("px")[0]);
}

function getMarginBottom(inWin, oElement) {
    var marginValue;
    if( window.getComputedStyle ) {
        marginValue = inWin.getComputedStyle(oElement,null).getPropertyValue('margin-bottom');
    } else if( oElement.currentStyle ) {
        marginValue = oElement.currentStyle.marginBottom;
    } else {
        marginValue = '0px';
    }
    return parseInt(marginValue.split("px")[0]);
}


function resizeMangedIframe(mIframe) {
	  
	  var mf = mIframe.iframe;
	  var mfBody = mf.dom.contentWindow.document.body;
	  
	  if(!mfBody || !mf.dom.clientHeight) {
		  return 0;
	  }
	  
	  var sh = mfBody.clientHeight;
    
	  var diff = mIframe.el.dom.offsetHeight - mf.dom.clientHeight;
	  var newHeight = diff + sh;

	  /*
	  var change = newHeight - mIframe.el.dom.offsetHeight; 

	  if(change > 3 || change < 15) {
		  // if it's a bit too small, (lt 3), or a lot too big, (gt 15).
        mIframe.setHeight(mIframe.el.dom.offsetHeight + change); 
	  }
	  */
	  return newHeight;
}



/**
 * @class mzinga.lms.ui.SiteSelector
 * @extends Ext.Window
 * Widget that pops up a window and allows selection of a site and sub-community.
 * <p>Example usage:</p>
 * <pre><code>
 * mzinga.lms.ui.SiteSelector.showOnClick('some-link', {
        callback : function (siteOrCommunity) {
            alert('Selected: ' + siteOrCommunity.webtag);
        },
        scope : this,
        select : this.webtag
  });
 * </code></pre>
 *
 * @constructor
 * @param {Object} config configuration object
 */
mzinga.lms.ui.SiteSelector = Ext.extend(Ext.Window, {

    // @override
    closeAction : 'hide',

    /**
     * @cfg {Array} data an array of site/community objects.  The site objects will have a property called subcommunity,
     * which is an array of community objects
     */
    data : undefined,

    /**
     * @cfg {boolean} forceCommunitySelection when this is true, the selector will for the user to choose a subcommunity
     * (defaults to false)
     */
    forceCommunitySelection : false,

    // @override
    frame : true,

    /**
     * @cfg {mzinga.ui.LocalizationSet} localizationSet required for il8n
     */
    localizationSet : undefined,

    /**
     * @cfg {String} field in the site/community that is used to match agains the select property (defaults to webtag)
     */
    matchField : 'webtag',

    // @override
    height : 260,

    // @override
    layout : 'fit',

    // @override
    modal : true,

    /**
     * @cfg {Mixed} The site/community to initially select.  This can be either be a field value or a site/community
     * json object
     */
    select : undefined,


    // @override
    width : 400,

    /**
     * Binds the selector to an element so that on the specified event, the selector shows.  The most common use case
     * is to bind the click event on a link.
     *
     * @param {Mixed} elOrIdOrDom the id/dom/element to bind the selector to
     * @param {String} eventName the name of the event on the element to which the selector is bound (defaults to click)
     */
    showOn : function(elOrIdOrDom, eventName) {
        var el = Ext.get(elOrIdOrDom);

        var win = this;

        if (el) {
            eventName = eventName || 'click';
            el.on(eventName, this._onBoundEvent, this);
        }

        return this;
    },

    /**
     * Retrieves a references to the community combo box.
     *
     * @return {Ext.form.ComboBox} the community combo box
     */
    getCommunityCombo : function() {
        return this._communityCombo;
    },

    /**
     * Retrieve the selected site/or community as json.
     */
    getResponseJSON : function() {
        var communityCombo = this.getCommunityCombo();
        var communityValue = communityCombo.getValue();

        var json;

        if (communityValue) {
            var communityRecord = communityCombo.store.getById(communityValue);
            json = communityRecord.json;
        } else {
            var siteCombo = this.getSiteCombo();
            var siteRecord = siteCombo.store.getById(siteCombo.getValue());
            json = (siteRecord) ? siteRecord.json : null;
        }

        return json;

    },

    /**
     * Retrieves a reference to the site combo box.
     *
     * @return (Ext.form.ComboBox) the site combo box
     */
    getSiteCombo : function() {
        return this._siteCombo;
    },

    /**
     * Retrieve the data that was initially set with this selector
     *
     * @return {Array} data as an array
     */
    getData : function() {
        if (!this.data) {
            return [];
        }

        return this.data;
    },

    // @override
    initComponent : function() {

        this._loadCachedLocalizationSet();
        this._loadCachedData();

        if (this.localizationSet && !this.title) {
            this.title = this._getLocalizedTitle();
        }

        if (this.localizationSet && this.data) {
            this._formPanel = this._buildFormPanel();

            this.items = [
                this._formPanel
            ];
        } else {

            this._tempPanel = new Ext.Panel({
                html: ''
            });

            this.items = [
                this._tempPanel
            ]
        }

        this.buttons = this._buildButtons();
        mzinga.lms.ui.SiteSelector.superclass.initComponent.apply(this, arguments);
    },

    /**
     * Action taken when the cancel button is clicked.
     */
    onCancel : function() {
        this[this.closeAction]();
    },


    // @override
    onDestroy : function() {
        delete this._communityCombo;
        delete this._siteCombo;
        delete this._formPanel;
        delete this._okButton;
        delete this._cancelButton;

        mzinga.lms.ui.SiteSelector.superclass.onDestroy.apply(this, arguments);
    },

    /**
     * Action taken when the ok button is clicked.
     */
    onOK : function() {
        if (this.validate()) {
            if (this.callback) {
                this.callback.call(this.scope || window, this.getResponseJSON());
            }

            this[this.closeAction]();
        }
    },


    // @override
    onRender : function() {

        if (!this.localizationSet || !this.data) {
            Ext.Ajax.request({
                url: '/worklet/siteSelector.wrk',
                success: this._retrieveSuccess,
                failure: this._retrieveFailure,
                scope: this
            });
        }

        mzinga.lms.ui.SiteSelector.superclass.onRender.apply(this, arguments);
    },

    /**
     * Validates the form.
     *
     * @return {boolean} true if the form was valid, otherwise false
     */
    validate : function() {
        return this._formPanel.getForm().isValid();
    },

    /**
     * Builds the OK and Cancel buttons.
     *
     * @return {Array} array of buttons
     */
    _buildButtons : function() {
        var okText;
        var cancelText;
        var hidden;

        if (this.localizationSet) {
            okText = this._getLocalizedOKButtonText();
            cancelText = this._getLocalizedCancelButtonText();
            hidden = false;
        } else {
            okText = '';
            cancelText = '';
            hidden = true;
        }

        this._okButton = new Ext.Button({
            handler : this.onOK,
            hidden : hidden,
            scope : this,
            text : okText
        });

        this._cancelButton = new Ext.Button({
            handler : this.onCancel,
            hidden : hidden,
            scope : this,
            text : cancelText
        });

        return [this._okButton, this._cancelButton];
    },

    /**
     * Builds the community combo box.
     */
    _buildCommunityCombo : function() {
        var store = this._buildCommunityStore();

        var box = new Ext.form.ComboBox({
            allowBlank : !this.forceCommunitySelection,
            blankText : this.localizationSet.getLocalizedString('Site_Selector_Validation_Blank_Text'),
            displayField : 'name',
            fieldLabel: this.localizationSet.getLocalizedString('Site_Selector_Community_Combo_Label'),
            forceSelection : true,
            mode: 'local',
            name: 'community',
            store : store,
            triggerAction: 'all',
            typeAhead: true,
            valueField : 'webtag'
        });

        if (this.communityWebtag) {
            box.setValue(this.communityWebtag);
        }

        return box;
    },

    /**
     * Builds the underlying store for the community combo box.
     *
     * @return {Ext.data.Store} communithy store
     */
    _buildCommunityStore : function() {
        var reader = this._buildReader();

        var store = new Ext.data.Store({
            autoDestroy : true,
            reader : reader
        });

        return store;
    },

    /**
     * Builds the main form panel for the selector.
     *
     * @return {Ext.form.FormPanel} the form panel
     */
    _buildFormPanel : function() {
        this._initWebtags();
        this._siteCombo = this._buildSiteCombo();
        this._communityCombo = this._buildCommunityCombo();

        if (this._siteCombo.getValue()) {
            var record = this._siteCombo.store.getById(this._siteCombo.getValue());

            if (record) {
                this._onSiteSelect(this._siteCombo, record);
            }
        }

        var formPanel = new Ext.FormPanel({
            labelWidth: 75,
            defaults: {width: 230},
            defaultType: 'combo',
            items : [
				{
					cls: 'os-popin-instructions',
				    anchor: '95%',
				    xtype:'miscfield',
				    hideLabel: true,
				    value : this.localizationSet.getLocalizedString('Site_Selector_Instructions')
				},
                this._siteCombo,
                this._communityCombo
            ],
            plain : true,
            width: 350
        });

        return formPanel;
    },

    /**
     * Builds the reader for the combo boxes.
     *
     * @return {Ext.data.JsonReader} a reader
     */
    _buildReader : function() {
        return new Ext.data.JsonReader({
            id: 'webtag',
            root: 'rows',
            fields: [
                {
                    name : 'webtag'
                },
                {
                    name: 'name'
                },
                {
                    name: 'subcommunity'
                }
            ]

        });
    },

    /**
     * Builds the site combo box.
     *
     * @return {Ext.form.ComboBox} combo box
     */
    _buildSiteCombo : function() {
        var store = this._buildSiteStore();

        var box = new Ext.form.ComboBox({
            allowBlank : false,
            blankText : this.localizationSet.getLocalizedString('Site_Selector_Validation_Blank_Text'),
            displayField : 'name',
            fieldLabel: this.localizationSet.getLocalizedString('Site_Selector_Site_Combo_Label'),
            forceSelection : true,
            invalidText : this.localizationSet.getLocalizedString('Site_Selector_Site_Required_Text'),
            mode: 'local',
            name: 'site',
            store : store,
            triggerAction: 'all',
            typeAhead: true,
            valueField : 'webtag'
        });

        box.on('select', this._onSiteSelect, this);

        if (this.siteWebtag) {
            var siteWebtag = this.siteWebtag;
            box.setValue(siteWebtag);
        }

        return box;
    },

    /**
     * Builds the site store.
     *
     * @return {Ext.data.Store} site store
     */
    _buildSiteStore : function() {

        var data = {
            rows: this.getData()
        }

        var reader = this._buildReader();

        var store = new Ext.data.Store({
            autoDestroy : true,
            reader : reader
        });

        store.loadData(data);

        return store;
    },

    _getLocalizedCancelButtonText : function() {
        return this.localizationSet.getLocalizedString('Site_Selector_Cancel_Button_Label');
    },

    _getLocalizedOKButtonText : function() {
        return this.localizationSet.getLocalizedString('Site_Selector_OK_Button_Label');
    },

    _getLocalizedTitle : function() {
        return this.localizationSet.getLocalizedString('Site_Selector_Title');
    },

    /**
     * Matches the site and community combos agains the select and matchField objects.
     */
    _initWebtags : function() {

        var field = this.matchField || 'webtag';
        var select = this.select;

        if (select && typeof select == 'object') {
            select = select[field];
        }

        if (select) {
            var sites = this.getData();
            var len = sites.length;

            for (var i = 0; i < sites.length; i++) {
                var site = sites[i];

                var subcommunities = site.subcommunity;
                var sublen = subcommunities.length;

                if (site[field] == select) {
                    this.siteWebtag = site.webtag;
                    break;
                }

                for (var j = 0; j < sublen; j++) {
                    var community = subcommunities[j];

                    if (community[field] == select) {
                        this.siteWebtag = site.webtag;
                        this.communityWebtag = community.webtag;
                        break;
                    }
                }
            }

        }
    },

    _loadCachedData : function() {
        if (this.data) {
            return;
        }

        if (parent) {
            if (typeof(parent.__siteSelectorData__) != 'undefined') {
                this.data = parent.__siteSelectorData__;
            }
        }
    },

    _loadCachedLocalizationSet : function() {
        if (this.localizationSet) {
            return;
        }

        if (parent && parent.__siteSelectorResources__) {
            this.localizationSet = new mzinga.ui.LocalizationSet(parent.__siteSelectorResources__);
        }
    },

    /**
     * Action taken when the bound event is fired.
     *
     * @param {Event} event the event
     */
    _onBoundEvent : function(event) {
        event.preventDefault();
        this.show();
    },

    /**
     * Fill the sub-communities when a site is selected.
     *
     * @param {Ext.form.ComboBox} box the site combo box
     * @param {Ext.data.Record} record the record selected
     * @param {Number} index the selected index
     */
    _onSiteSelect : function(box, record, index) {
        var subcommunity = record ? record.get('subcommunity') : [];

        if (!subcommunity) {
            subcommunity = [];
        }

        var rows = [];


        if (!this.forceCommunitySelection) {
            rows[rows.length] = {
                name : this.localizationSet.getLocalizedString('Site_Selector_All_Communities_Label'),
                webtag : ''
            }
        }

        rows = rows.concat(subcommunity);

        var data = {
            rows : rows
        }

        var communityCombo = this.getCommunityCombo();
        communityCombo.store.loadData(data);

        if (this.forceCommunitySelection) {
            communityCombo.setValue((rows.length) ? rows[0].webtag : '');
        } else {
            communityCombo.setValue('');
        }
    },

    _retrieveFailure : function(response) {
        if (typeof console != 'undefined') {
            console.log('failure.');
        }
    },
    
    _retrieveSuccess : function(response) {
        var config = Ext.decode(response.responseText);

        if (!this.data) {
            this.data = config.customer.sites;

            if (parent) {
                parent.__siteSelectorData__ = this.data;
            }
        }

        if (!this.localizationSet) {
            var resources = config.resourceBundle;
            this.localizationSet = new mzinga.ui.LocalizationSet(resources);

            if (parent) {
                parent.__siteSelectorResources__ = resources;
            }
        }

        this.setTitle(this._getLocalizedTitle());
        this._okButton.setText(this._getLocalizedOKButtonText());
        this._cancelButton.setText(this._getLocalizedCancelButtonText());
        this._okButton.show();
        this._cancelButton.show();

        this.remove(this._tempPanel, true);
        delete this._tempPanel;
        
        this._formPanel = this._buildFormPanel();
        this.add(this._formPanel);
        
        this.doLayout();
    }
});

Ext.apply(mzinga.lms.ui.SiteSelector, {

    fromConfig : function(config) {
        return new mzinga.lms.ui.SiteSelector(config);
    },

    showOnClick : function (el, config) {
        return mzinga.lms.ui.SiteSelector.showOn(el, 'click', config);
    },

    showOn : function(el, eventName, config) {
        return mzinga.lms.ui.SiteSelector.fromConfig(config).showOn(el, eventName);
    }

});

// end class mzinga.lms.ui.SiteSelector

Ext.Spotlight = function(config){
    Ext.apply(this, config);
}
Ext.Spotlight.prototype = {
    active : false,
    animate : true,
    animated : false,
    duration: .25,
    easing:'easeNone',

    createElements : function(){
        var bd = Ext.getBody();

        this.right = bd.createChild({cls:'x-spotlight'});
        this.left = bd.createChild({cls:'x-spotlight'});
        this.top = bd.createChild({cls:'x-spotlight'});
        this.bottom = bd.createChild({cls:'x-spotlight'});

        this.all = new Ext.CompositeElement([this.right, this.left, this.top, this.bottom]);
    },

    show : function(el, callback, scope){
        if(this.animated){
            this.show.defer(50, this, [el, callback, scope]);
            return;
        }
        this.el = Ext.get(el);
        if(!this.right){
            this.createElements();
        }
        if(!this.active){
            this.all.setDisplayed('');
            this.applyBounds(true, false);
            this.active = true;
            Ext.EventManager.onWindowResize(this.syncSize, this);
            this.applyBounds(false, this.animate, false, callback, scope);
        }else{
            this.applyBounds(false, false, false, callback, scope); // all these booleans look hideous
        }
    },

    hide : function(callback, scope){
        if(this.animated){
            this.hide.defer(50, this, [callback, scope]);
            return;
        }
        Ext.EventManager.removeResizeListener(this.syncSize, this);
        this.applyBounds(true, this.animate, true, callback, scope);
    },

    doHide : function(){
        this.active = false;
        this.all.setDisplayed(false);
    },

    syncSize : function(){
        this.applyBounds(false, false);
    },

    applyBounds : function(basePts, anim, doHide, callback, scope){

        var rg = this.el.getRegion();

        var dw = Ext.lib.Dom.getViewWidth(true);
        var dh = Ext.lib.Dom.getViewHeight(true);

        var c = 0, cb = false;
        if(anim){
            cb = {
                callback: function(){
                    c++;
                    if(c == 4){
                        this.animated = false;
                        if(doHide){
                            this.doHide();
                        }
                        Ext.callback(callback, scope, [this]);
                    }
                },
                scope: this,
                duration: this.duration,
                easing: this.easing
            };
            this.animated = true;
        }

        this.right.setBounds(
                rg.right,
                basePts ? dh : rg.top,
                dw - rg.right,
                basePts ? 0 : (dh - rg.top),
                cb);

        this.left.setBounds(
                0,
                0,
                rg.left,
                basePts ? 0 : rg.bottom,
                cb);

        this.top.setBounds(
                basePts ? dw : rg.left,
                0,
                basePts ? 0 : dw - rg.left,
                rg.top,
                cb);

        this.bottom.setBounds(
                0,
                rg.bottom,
                basePts ? 0 : rg.right,
                dh - rg.bottom,
                cb);

        if(!anim){
            if(doHide){
                this.doHide();
            }
            if(callback){
                Ext.callback(callback, scope, [this]);
            }
        }
    },

    destroy : function(){
        this.doHide();
        Ext.destroy(
                this.right,
                this.left,
                this.top,
                this.bottom);
        delete this.el;
        delete this.all;
    }
};
mzinga.lms.ui.PopUp = Ext.extend(Ext.Window, {
    resizable : true,
    modal : false,
    closable: true,
    draggable: true,
    constrain: true,
    closeAction: 'hide',
    ctype : "mzinga.lms.ui.PopUp",
    layout: 'fit',
    initComponent : function() {
        if (this.isExternalLink) {
            if (this.url) {
                this.items = {
                    xtype: 'iframepanel',
                    autoScroll : true,
                    disableMessaging: true,
                    frameConfig: {
                        autoCreate: {
                            tag:'iframe',
                            name: this.windowName,
                            frameborder: 0,
                            cls: 'x-managed-iframe',
                            src: this.url
                        }
                    }
                }
            } else {
                this.items = {
                    xtype: 'iframepanel',
                    autoScroll : true,
                    disableMessaging: true,
                    frameConfig: {
                        autoCreate: {
                            tag:'iframe',
                            name: this.windowName,
                            frameborder: 0,
                            cls: 'x-managed-iframe'
                        }
                    }
                };
            }
        } else {
            if (this.url) {
            	this.bodyStyle = "padding:2px 5px;"
                this.autoScroll = true;
            	this.html = this.url;
            } else {
                this.items = {
                    xtype: 'iframepanel',
                    autoScroll : true,
                    disableMessaging: true,
                    frameConfig: {
                        autoCreate: {
                            tag:'iframe',
                            name: this.windowName,
                            frameborder: 0,
                            cls: 'x-managed-iframe'
                        }
                    }
                };
            }
        }

        mzinga.lms.ui.PopUp.superclass.initComponent.call(this);
        this.render(Ext.getBody());

        if (this.elementToPlaceBy) {
            var elementToAlignBy = Ext.get(this.elementToPlaceBy);
            var positions = mzinga.lms.ui.getPopupPosition(elementToAlignBy, this.width, this.height, this.verticalAlignment, this.horizontalAlignment);
            var leftPosition = positions.x;
            var topPosition =  positions.y;
            mzinga.lms.ui.movePopup(this, leftPosition, topPosition)
        }

        if (this.displayNow == true) {
            this.show();
        }
    }
});

Ext.reg('popup', mzinga.lms.ui.PopUp);

mzinga.lms.ui.getPopupPosition = function(elementToAlignTo, aWidth, aHeight, verticalAlignment, horizontalAlignment){
    var elementPosition;
    var targetPosition;
    var position;

    switch (verticalAlignment) {
        case "TOP":
            elementPosition = 'b';
            targetPosition = 't';
            break;
        case "top":
            elementPosition = 'b';
            targetPosition = 'b';
            break;
        case "BELOW":
            elementPosition = 't';
            targetPosition = 'b';
            break;
        case "below":
            elementPosition = 't';
            targetPosition = 't';
            break;
        default: // defaults to BELOW when no option is available
            elementPosition = 't';
            targetPosition = 'b';
            break;
    }

    switch (horizontalAlignment) {
        case "LEFT":
            elementPosition += 'r';
            targetPosition += 'l';
            break;
        case "left":
            elementPosition += 'r';
            targetPosition += 'r';
            break;
        case "RIGHT":
            elementPosition += 'l';
            targetPosition += 'r';
            break;
        case "right":
            elementPosition += 'l';
            targetPosition += 'l';
            break;
        default: // defaults to left when no option is available
            elementPosition += 'r';
            targetPosition += 'r';
            break;
    }

    var tmpElement = new Ext.Element(document.createElement('div'));
    tmpElement.setSize(aWidth, aHeight);

    var positionArray = tmpElement.getAlignToXY(elementToAlignTo, elementPosition + "-" + targetPosition);
    var position = {x: positionArray[0], y: positionArray[1]};
    return position;
}

mzinga.lms.ui.movePopup = function(popup, leftPos, topPos){
    popup.setPosition(leftPos, topPos);
    popup.doLayout();
}


//
// Ext.ux.Multiselect/ItemSelector


//version 3.0

Ext.ux.Multiselect = Ext.extend(Ext.form.Field,  {
	store:null,
	dataFields:[],
	data:[],
	width:100,
	height:100,
	displayField:0,
	valueField:1,
	allowBlank:true,
	minLength:0,
	maxLength:Number.MAX_VALUE,
	blankText:Ext.form.TextField.prototype.blankText,
	minLengthText:'Minimum {0} item(s) required',
	maxLengthText:'Maximum {0} item(s) allowed',
	copy:false,
	allowDup:false,
	allowTrash:false,
	legend:null,
	focusClass:undefined,
	delimiter:',',
	view:null,
	dragGroup:null,
	dropGroup:null,
	tbar:null,
	appendOnly:false,
	sortField:null,
	sortDir:'ASC',
	defaultAutoCreate : {tag: "div"},

    initComponent: function(){
		Ext.ux.Multiselect.superclass.initComponent.call(this);
		this.addEvents({
			'dblclick' : true,
			'click' : true,
			'change' : true,
			'drop' : true
		});
	},
    onRender: function(ct, position){
		var fs, cls, tpl;
		Ext.ux.Multiselect.superclass.onRender.call(this, ct, position);

		cls = 'ux-mselect';

		fs = new Ext.form.FieldSet({
			renderTo:this.el,
			title:this.legend,
			height:this.height,
			width:this.width,
			style:"padding:1px;",
			tbar:this.tbar
		});
		if(!this.legend)fs.el.down('.'+fs.headerCls).remove();
		fs.body.addClass(cls);

		tpl = '<tpl for="."><div class="' + cls + '-item';
		if(Ext.isIE || Ext.isIE7)tpl+='" unselectable=on';
		else tpl+=' x-unselectable"';
		tpl+='>{' + this.displayField + '}</div></tpl>';

		if(!this.store){
			this.store = new Ext.data.SimpleStore({
				fields: this.dataFields,
				data : this.data
			});
		}

		this.view = new Ext.ux.DDView({
			multiSelect: true, store: this.store, selectedClass: cls+"-selected", tpl:tpl,
			allowDup:this.allowDup, copy: this.copy, allowTrash: this.allowTrash,
			dragGroup: this.dragGroup, dropGroup: this.dropGroup, itemSelector:"."+cls+"-item",
			isFormField:false, applyTo:fs.body, appendOnly:this.appendOnly,
			sortField:this.sortField, sortDir:this.sortDir
		});

		fs.add(this.view);

		this.view.on('click', this.onViewClick, this);
		this.view.on('beforeClick', this.onViewBeforeClick, this);
		this.view.on('dblclick', this.onViewDblClick, this);
		this.view.on('drop', function(ddView, n, dd, e, data){
	    	return this.fireEvent("drop", ddView, n, dd, e, data);
		}, this);

		this.hiddenName = this.name;
		var hiddenTag={tag: "input", type: "hidden", value: "", name:this.name};
		if (this.isFormField) {
			this.hiddenField = this.el.createChild(hiddenTag);
		} else {
			this.hiddenField = Ext.get(document.body).createChild(hiddenTag);
		}
		fs.doLayout();
	},

	initValue:Ext.emptyFn,

	onViewClick: function(vw, index, node, e) {
		var arrayIndex = this.preClickSelections.indexOf(index);
		if (arrayIndex  != -1)
		{
			this.preClickSelections.splice(arrayIndex, 1);
			this.view.clearSelections(true);
			this.view.select(this.preClickSelections);
		}
		this.fireEvent('change', this, this.getValue(), this.hiddenField.dom.value);
		this.hiddenField.dom.value = this.getValue();
		this.fireEvent('click', this, e);
		this.validate();
	},

	onViewBeforeClick: function(vw, index, node, e) {
		this.preClickSelections = this.view.getSelectedIndexes();
		if (this.disabled) {return false;}
	},

	onViewDblClick : function(vw, index, node, e) {
		return this.fireEvent('dblclick', vw, index, node, e);
	},

	getValue: function(valueField){
		var returnArray = [];
		var selectionsArray = this.view.getSelectedIndexes();
		if (selectionsArray.length == 0) {return '';}
		for (var i=0; i<selectionsArray.length; i++) {
			returnArray.push(this.store.getAt(selectionsArray[i]).get(((valueField != null)? valueField : this.valueField)));
		}
		return returnArray.join(this.delimiter);
	},

	setValue: function(values) {
		var index;
		var selections = [];
		this.view.clearSelections();
		this.hiddenField.dom.value = '';

		if (!values || (values == '')) { return; }

		if (!(values instanceof Array)) { values = values.split(this.delimiter); }
		for (var i=0; i<values.length; i++) {
			index = this.view.store.indexOf(this.view.store.query(this.valueField,
				new RegExp('^' + values[i] + '$', "i")).itemAt(0));
			selections.push(index);
		}
		this.view.select(selections);
		this.hiddenField.dom.value = this.getValue();
		this.validate();
	},

	reset : function() {
		this.setValue('');
	},

	getRawValue: function(valueField) {
        var tmp = this.getValue(valueField);
        if (tmp.length) {
            tmp = tmp.split(this.delimiter);
        }
        else{
            tmp = [];
        }
        return tmp;
    },

    setRawValue: function(values){
        setValue(values);
    },

    validateValue : function(value){
        if (value.length < 1) { // if it has no value
             if (this.allowBlank) {
                 this.clearInvalid();
                 return true;
             } else {
                 this.markInvalid(this.blankText);
                 return false;
             }
        }
        if (value.length < this.minLength) {
            this.markInvalid(String.format(this.minLengthText, this.minLength));
            return false;
        }
        if (value.length > this.maxLength) {
            this.markInvalid(String.format(this.maxLengthText, this.maxLength));
            return false;
        }
        return true;
    }
});

Ext.reg("multiselect", Ext.ux.Multiselect);

Ext.ux.ItemSelector = Ext.extend(Ext.form.Field,  {
	msWidth:200,
	msHeight:300,
	hideNavIcons:false,
	imagePath:"",
	iconUp:"/extjs/images/default/up2.gif",
	iconDown:"/extjs/images/default/down2.gif",
	iconLeft:"/extjs/images/default/left2.gif",
	iconRight:"/extjs/images/default/right2.gif",
	iconTop:"/extjs/images/default/top2.gif",
	iconBottom:"/extjs/images/default/bottom2.gif",
	drawUpIcon:true,
	drawDownIcon:true,
	drawLeftIcon:true,
	drawRightIcon:true,
	drawTopIcon:true,
	drawBotIcon:true,
	fromStore:null,
	toStore:null,
	fromData:null,
	toData:null,
	displayField:0,
	valueField:1,
	switchToFrom:false,
	allowDup:false,
	focusClass:undefined,
	delimiter:',',
	readOnly:false,
	toLegend:null,
	fromLegend:null,
	toSortField:null,
	fromSortField:null,
	toSortDir:'ASC',
	fromSortDir:'ASC',
	toTBar:null,
	fromTBar:null,
	bodyStyle:null,
	border:false,
	defaultAutoCreate:{tag: "div"},

    initComponent: function(){
		Ext.ux.ItemSelector.superclass.initComponent.call(this);
		this.addEvents({
			'rowdblclick' : true,
			'change' : true
		});
	},

    onRender: function(ct, position){
		Ext.ux.ItemSelector.superclass.onRender.call(this, ct, position);

		this.fromMultiselect = new Ext.ux.Multiselect({
			legend: this.fromLegend,
			delimiter: this.delimiter,
			allowDup: this.allowDup,
			copy: this.allowDup,
			allowTrash: this.allowDup,
			dragGroup: this.readOnly ? null : "drop2-"+this.el.dom.id,
			dropGroup: this.readOnly ? null : "drop1-"+this.el.dom.id,
			width: this.msWidth,
			height: this.msHeight,
			dataFields: this.dataFields,
			data: this.fromData,
			displayField: this.displayField,
			valueField: this.valueField,
			store: this.fromStore,
			isFormField: false,
			tbar: this.fromTBar,
			appendOnly: true,
			sortField: this.fromSortField,
			sortDir: this.fromSortDir
		});
		this.fromMultiselect.on('dblclick', this.onRowDblClick, this);

		if (!this.toStore) {
			this.toStore = new Ext.data.SimpleStore({
				fields: this.dataFields,
				data : this.toData
			});
		}
		this.toStore.on('add', this.valueChanged, this);
		this.toStore.on('remove', this.valueChanged, this);
		this.toStore.on('load', this.valueChanged, this);

		this.toMultiselect = new Ext.ux.Multiselect({
			legend: this.toLegend,
			delimiter: this.delimiter,
			allowDup: this.allowDup,
			dragGroup: this.readOnly ? null : "drop1-"+this.el.dom.id,
			//dropGroup: this.readOnly ? null : "drop2-"+this.el.dom.id+(this.toSortField ? "" : ",drop1-"+this.el.dom.id),
			dropGroup: this.readOnly ? null : "drop2-"+this.el.dom.id+",drop1-"+this.el.dom.id,
			width: this.msWidth,
			height: this.msHeight,
			displayField: this.displayField,
			valueField: this.valueField,
			store: this.toStore,
			isFormField: false,
			tbar: this.toTBar,
			sortField: this.toSortField,
			sortDir: this.toSortDir
		});
		this.toMultiselect.on('dblclick', this.onRowDblClick, this);

		var p = new Ext.Panel({
			bodyStyle:this.bodyStyle,
			border:this.border,
			layout:"table",
			layoutConfig:{columns:3}
		});
		p.add(this.switchToFrom ? this.toMultiselect : this.fromMultiselect);
		var icons = new Ext.Panel({header:false});
		p.add(icons);
		p.add(this.switchToFrom ? this.fromMultiselect : this.toMultiselect);
		p.render(this.el);
		icons.el.down('.'+icons.bwrapCls).remove();

		if (this.imagePath!="" && this.imagePath.charAt(this.imagePath.length-1)!="/")
			this.imagePath+="/";
		this.iconUp = this.imagePath + (this.iconUp || '/extjs/images/default/up2.gif');
		this.iconDown = this.imagePath + (this.iconDown || '/extjs/images/default/down2.gif');
		this.iconLeft = this.imagePath + (this.iconLeft || '/extjs/images/default/left2.gif');
		this.iconRight = this.imagePath + (this.iconRight || '/extjs/images/default/right2.gif');
		this.iconTop = this.imagePath + (this.iconTop || '/extjs/images/default/top2.gif');
		this.iconBottom = this.imagePath + (this.iconBottom || '/extjs/images/default/bottom2.gif');
		var el=icons.getEl();
		if (!this.toSortField) {
			this.toTopIcon = el.createChild({tag:'img', src:this.iconTop, style:{cursor:'pointer', margin:'2px'}});
			el.createChild({tag: 'br'});
			this.upIcon = el.createChild({tag:'img', src:this.iconUp, style:{cursor:'pointer', margin:'2px'}});
			el.createChild({tag: 'br'});
		}
		this.addIcon = el.createChild({tag:'img', src:this.switchToFrom?this.iconLeft:this.iconRight, style:{cursor:'pointer', margin:'2px'}});
		el.createChild({tag: 'br'});
		this.removeIcon = el.createChild({tag:'img', src:this.switchToFrom?this.iconRight:this.iconLeft, style:{cursor:'pointer', margin:'2px'}});
		el.createChild({tag: 'br'});
		if (!this.toSortField) {
			this.downIcon = el.createChild({tag:'img', src:this.iconDown, style:{cursor:'pointer', margin:'2px'}});
			el.createChild({tag: 'br'});
			this.toBottomIcon = el.createChild({tag:'img', src:this.iconBottom, style:{cursor:'pointer', margin:'2px'}});
		}
		if (!this.readOnly) {
			if (!this.toSortField) {
				this.toTopIcon.on('click', this.toTop, this);
				this.upIcon.on('click', this.up, this);
				this.downIcon.on('click', this.down, this);
				this.toBottomIcon.on('click', this.toBottom, this);
			}
			this.addIcon.on('click', this.fromTo, this);
			this.removeIcon.on('click', this.toFrom, this);
		}
		if (!this.drawUpIcon || this.hideNavIcons) { this.upIcon.dom.style.display='none'; }
		if (!this.drawDownIcon || this.hideNavIcons) { this.downIcon.dom.style.display='none'; }
		if (!this.drawLeftIcon || this.hideNavIcons) { this.addIcon.dom.style.display='none'; }
		if (!this.drawRightIcon || this.hideNavIcons) { this.removeIcon.dom.style.display='none'; }
		if (!this.drawTopIcon || this.hideNavIcons) { this.toTopIcon.dom.style.display='none'; }
		if (!this.drawBotIcon || this.hideNavIcons) { this.toBottomIcon.dom.style.display='none'; }

		var tb = p.body.first();
		this.el.setWidth(p.body.first().getWidth());
		p.body.removeClass();

		this.hiddenName = this.name;
		var hiddenTag={tag: "input", type: "hidden", value: "", name:this.name};
		this.hiddenField = this.el.createChild(hiddenTag);
		this.valueChanged(this.toStore);
	},

	initValue:Ext.emptyFn,

	toTop : function() {
		var selectionsArray = this.toMultiselect.view.getSelectedIndexes();
		var records = [];
		if (selectionsArray.length > 0) {
			selectionsArray.sort();
			for (var i=0; i<selectionsArray.length; i++) {
				record = this.toMultiselect.view.store.getAt(selectionsArray[i]);
				records.push(record);
			}
			selectionsArray = [];
			for (var i=records.length-1; i>-1; i--) {
				record = records[i];
				this.toMultiselect.view.store.remove(record);
				this.toMultiselect.view.store.insert(0, record);
				selectionsArray.push(((records.length - 1) - i));
			}
		}
		this.toMultiselect.view.refresh();
		this.toMultiselect.view.select(selectionsArray);
	},

	toBottom : function() {
		var selectionsArray = this.toMultiselect.view.getSelectedIndexes();
		var records = [];
		if (selectionsArray.length > 0) {
			selectionsArray.sort();
			for (var i=0; i<selectionsArray.length; i++) {
				record = this.toMultiselect.view.store.getAt(selectionsArray[i]);
				records.push(record);
			}
			selectionsArray = [];
			for (var i=0; i<records.length; i++) {
				record = records[i];
				this.toMultiselect.view.store.remove(record);
				this.toMultiselect.view.store.add(record);
				selectionsArray.push((this.toMultiselect.view.store.getCount()) - (records.length - i));
			}
		}
		this.toMultiselect.view.refresh();
		this.toMultiselect.view.select(selectionsArray);
	},

	up : function() {
		var record = null;
		var selectionsArray = this.toMultiselect.view.getSelectedIndexes();
		selectionsArray.sort();
		var newSelectionsArray = [];
		if (selectionsArray.length > 0) {
			for (var i=0; i<selectionsArray.length; i++) {
				record = this.toMultiselect.view.store.getAt(selectionsArray[i]);
				if ((selectionsArray[i] - 1) >= 0) {
					this.toMultiselect.view.store.remove(record);
					this.toMultiselect.view.store.insert(selectionsArray[i] - 1, record);
					newSelectionsArray.push(selectionsArray[i] - 1);
				}
			}
			this.toMultiselect.view.refresh();
			this.toMultiselect.view.select(newSelectionsArray);
		}
	},

	down : function() {
		var record = null;
		var selectionsArray = this.toMultiselect.view.getSelectedIndexes();
		selectionsArray.sort();
		selectionsArray.reverse();
		var newSelectionsArray = [];
		if (selectionsArray.length > 0) {
			for (var i=0; i<selectionsArray.length; i++) {
				record = this.toMultiselect.view.store.getAt(selectionsArray[i]);
				if ((selectionsArray[i] + 1) < this.toMultiselect.view.store.getCount()) {
					this.toMultiselect.view.store.remove(record);
					this.toMultiselect.view.store.insert(selectionsArray[i] + 1, record);
					newSelectionsArray.push(selectionsArray[i] + 1);
				}
			}
			this.toMultiselect.view.refresh();
			this.toMultiselect.view.select(newSelectionsArray);
		}
	},

	fromTo : function() {
		var selectionsArray = this.fromMultiselect.view.getSelectedIndexes();
		var records = [];
		if (selectionsArray.length > 0) {
			for (var i=0; i<selectionsArray.length; i++) {
				record = this.fromMultiselect.view.store.getAt(selectionsArray[i]);
				records.push(record);
			}
			if(!this.allowDup)selectionsArray = [];
			for (var i=0; i<records.length; i++) {
				record = records[i];
				if(this.allowDup){
					var x=new Ext.data.Record();
					record.id=x.id;
					delete x;
					this.toMultiselect.view.store.add(record);
				}else{
					this.fromMultiselect.view.store.remove(record);
					this.toMultiselect.view.store.add(record);
					selectionsArray.push((this.toMultiselect.view.store.getCount() - 1));
				}
			}
		}
		this.toMultiselect.view.refresh();
		this.fromMultiselect.view.refresh();
		if(this.toSortField)this.toMultiselect.store.sort(this.toSortField, this.toSortDir);
		if(this.allowDup)this.fromMultiselect.view.select(selectionsArray);
		else this.toMultiselect.view.select(selectionsArray);
	},

	toFrom : function() {
		var selectionsArray = this.toMultiselect.view.getSelectedIndexes();
		var records = [];
		if (selectionsArray.length > 0) {
			for (var i=0; i<selectionsArray.length; i++) {
				record = this.toMultiselect.view.store.getAt(selectionsArray[i]);
				records.push(record);
			}
			selectionsArray = [];
			for (var i=0; i<records.length; i++) {
				record = records[i];
				this.toMultiselect.view.store.remove(record);
				if(!this.allowDup){
					this.fromMultiselect.view.store.add(record);
					selectionsArray.push((this.fromMultiselect.view.store.getCount() - 1));
				}
			}
		}
		this.fromMultiselect.view.refresh();
		this.toMultiselect.view.refresh();
		if(this.fromSortField)this.fromMultiselect.store.sort(this.fromSortField, this.fromSortDir);
		this.fromMultiselect.view.select(selectionsArray);
	},

	valueChanged: function(store) {
		var record = null;
		var values = [];
		for (var i=0; i<store.getCount(); i++) {
			record = store.getAt(i);
			values.push(record.get(this.valueField));
		}
		this.hiddenField.dom.value = values.join(this.delimiter);
		this.fireEvent('change', this, this.getValue(), this.hiddenField.dom.value);
	},

	getValue : function() {
		return this.hiddenField.dom.value;
	},

	onRowDblClick : function(vw, index, node, e) {
		return this.fireEvent('rowdblclick', vw, index, node, e);
	},

	reset: function(){
		range = this.toMultiselect.store.getRange();
		this.toMultiselect.store.removeAll();
		if (!this.allowDup) {
			this.fromMultiselect.store.add(range);
			this.fromMultiselect.store.sort(this.displayField,'ASC');
		}
		this.valueChanged(this.toMultiselect.store);
	}
});

Ext.reg("itemselector", Ext.ux.ItemSelector);

Array.prototype.contains = function(element) {
	return this.indexOf(element) !== -1;
};

Ext.namespace("Ext.ux");

/**
 * @class Ext.ux.DDView
 * A DnD enabled version of Ext.View.
 * @param {Element/String} container The Element in which to create the View.
 * @param {String} tpl The template string used to create the markup for each element of the View
 * @param {Object} config The configuration properties. These include all the config options of
 * {@link Ext.View} plus some specific to this class.<br>
 * <p>
 * Drag/drop is implemented by adding {@link Ext.data.Record}s to the target DDView. If copying is
 * not being performed, the original {@link Ext.data.Record} is removed from the source DDView.<br>
 * <p>
 * The following extra CSS rules are needed to provide insertion point highlighting:<pre><code>
.x-view-drag-insert-above {
    border-top:1px dotted #3366cc;
}
.x-view-drag-insert-below {
    border-bottom:1px dotted #3366cc;
}
</code></pre>
 *
 */
Ext.ux.DDView = function(config) {
	if (!config.itemSelector) {
		var tpl = config.tpl;
		if (this.classRe.test(tpl)) {
			config.tpl = tpl.replace(this.classRe, 'class=$1x-combo-list-item $2$1');
		}
		else {
			config.tpl = tpl.replace(this.tagRe, '$1 class="x-combo-list-item" $2');
		}
		config.itemSelector = ".x-combo-list-item";
	}
    Ext.ux.DDView.superclass.constructor.call(this, Ext.apply(config, {
        border: false
    }));
};

Ext.extend(Ext.ux.DDView, Ext.DataView, {
/**    @cfg {String/Array} dragGroup The ddgroup name(s) for the View's DragZone. */
/**    @cfg {String/Array} dropGroup The ddgroup name(s) for the View's DropZone. */
/**    @cfg {Boolean} copy Causes drag operations to copy nodes rather than move. */
/**    @cfg {Boolean} allowCopy Causes ctrl/drag operations to copy nodes rather than move. */

	sortDir: 'ASC',

    isFormField: true,

    classRe: /class=(['"])(.*)\1/,

    tagRe: /(<\w*)(.*?>)/,

    reset: Ext.emptyFn,

    clearInvalid: Ext.form.Field.prototype.clearInvalid,

    msgTarget: 'qtip',

	afterRender: function() {
		Ext.ux.DDView.superclass.afterRender.call(this);
	    if (this.dragGroup) {
	        this.setDraggable(this.dragGroup.split(","));
	    }
	    if (this.dropGroup) {
	        this.setDroppable(this.dropGroup.split(","));
	    }
	    if (this.deletable) {
	        this.setDeletable();
	    }
	    this.isDirtyFlag = false;
	    this.addEvents(
	        "drop"
	    );
	},

    validate: function() {
        return true;
    },

    destroy: function() {
        this.purgeListeners();
        this.getEl().removeAllListeners();
        this.getEl().remove();
        if (this.dragZone) {
            if (this.dragZone.destroy) {
                this.dragZone.destroy();
            }
        }
        if (this.dropZone) {
            if (this.dropZone.destroy) {
                this.dropZone.destroy();
            }
        }
    },

/**    Allows this class to be an Ext.form.Field so it can be found using {@link Ext.form.BasicForm#findField}. */
    getName: function() {
        return this.name;
    },

/**    Loads the View from a JSON string representing the Records to put into the Store. */
    setValue: function(v) {
        if (!this.store) {
            throw "DDView.setValue(). DDView must be constructed with a valid Store";
        }
        var data = {};
        data[this.store.reader.meta.root] = v ? [].concat(v) : [];
        this.store.proxy = new Ext.data.MemoryProxy(data);
        this.store.load();
    },

/**    @return {String} a parenthesised list of the ids of the Records in the View. */
    getValue: function() {
        var result = '(';
        this.store.each(function(rec) {
            result += rec.id + ',';
        });
        return result.substr(0, result.length - 1) + ')';
    },

    getIds: function() {
        var i = 0, result = new Array(this.store.getCount());
        this.store.each(function(rec) {
            result[i++] = rec.id;
        });
        return result;
    },

    isDirty: function() {
        return this.isDirtyFlag;
    },

/**
 *    Part of the Ext.dd.DropZone interface. If no target node is found, the
 *    whole Element becomes the target, and this causes the drop gesture to append.
 */
    getTargetFromEvent : function(e) {
        var target = e.getTarget();
        while ((target !== null) && (target.parentNode != this.el.dom)) {
            target = target.parentNode;
        }
        if (!target) {
            target = this.el.dom.lastChild || this.el.dom;
        }
        return target;
    },

/**
 *    Create the drag data which consists of an object which has the property "ddel" as
 *    the drag proxy element.
 */
    getDragData : function(e) {
        var target = this.findItemFromChild(e.getTarget());
        if(target) {
            if (!this.isSelected(target)) {
                delete this.ignoreNextClick;
                this.onItemClick(target, this.indexOf(target), e);
                this.ignoreNextClick = true;
            }
            var dragData = {
                sourceView: this,
                viewNodes: [],
                records: [],
                copy: this.copy || (this.allowCopy && e.ctrlKey)
            };
            if (this.getSelectionCount() == 1) {
                var i = this.getSelectedIndexes()[0];
                var n = this.getNode(i);
                dragData.viewNodes.push(dragData.ddel = n);
                dragData.records.push(this.store.getAt(i));
                dragData.repairXY = Ext.fly(n).getXY();
            } else {
                dragData.ddel = document.createElement('div');
                dragData.ddel.className = 'multi-proxy';
                this.collectSelection(dragData);
            }
            return dragData;
        }
        return false;
    },

//    override the default repairXY.
    getRepairXY : function(e){
        return this.dragData.repairXY;
    },

/**    Put the selections into the records and viewNodes Arrays. */
    collectSelection: function(data) {
        data.repairXY = Ext.fly(this.getSelectedNodes()[0]).getXY();
        if (this.preserveSelectionOrder === true) {
            Ext.each(this.getSelectedIndexes(), function(i) {
                var n = this.getNode(i);
                var dragNode = n.cloneNode(true);
                dragNode.id = Ext.id();
                data.ddel.appendChild(dragNode);
                data.records.push(this.store.getAt(i));
                data.viewNodes.push(n);
            }, this);
        } else {
            var i = 0;
            this.store.each(function(rec){
                if (this.isSelected(i)) {
                    var n = this.getNode(i);
                    var dragNode = n.cloneNode(true);
                    dragNode.id = Ext.id();
                    data.ddel.appendChild(dragNode);
                    data.records.push(this.store.getAt(i));
                    data.viewNodes.push(n);
                }
                i++;
            }, this);
        }
    },

/**    Specify to which ddGroup items in this DDView may be dragged. */
    setDraggable: function(ddGroup) {
        if (ddGroup instanceof Array) {
            Ext.each(ddGroup, this.setDraggable, this);
            return;
        }
        if (this.dragZone) {
            this.dragZone.addToGroup(ddGroup);
        } else {
            this.dragZone = new Ext.dd.DragZone(this.getEl(), {
                containerScroll: true,
                ddGroup: ddGroup
            });
//            Draggability implies selection. DragZone's mousedown selects the element.
            if (!this.multiSelect) { this.singleSelect = true; }

//            Wire the DragZone's handlers up to methods in *this*
            this.dragZone.getDragData = this.getDragData.createDelegate(this);
            this.dragZone.getRepairXY = this.getRepairXY;
            this.dragZone.onEndDrag = this.onEndDrag;
        }
    },

/**    Specify from which ddGroup this DDView accepts drops. */
    setDroppable: function(ddGroup) {
        if (ddGroup instanceof Array) {
            Ext.each(ddGroup, this.setDroppable, this);
            return;
        }
        if (this.dropZone) {
            this.dropZone.addToGroup(ddGroup);
        } else {
            this.dropZone = new Ext.dd.DropZone(this.getEl(), {
                owningView: this,
                containerScroll: true,
                ddGroup: ddGroup
            });

//            Wire the DropZone's handlers up to methods in *this*
            this.dropZone.getTargetFromEvent = this.getTargetFromEvent.createDelegate(this);
            this.dropZone.onNodeEnter = this.onNodeEnter.createDelegate(this);
            this.dropZone.onNodeOver = this.onNodeOver.createDelegate(this);
            this.dropZone.onNodeOut = this.onNodeOut.createDelegate(this);
            this.dropZone.onNodeDrop = this.onNodeDrop.createDelegate(this);
        }
    },

/**    Decide whether to drop above or below a View node. */
    getDropPoint : function(e, n, dd){
        if (n == this.el.dom) { return "above"; }
        var t = Ext.lib.Dom.getY(n), b = t + n.offsetHeight;
        var c = t + (b - t) / 2;
        var y = Ext.lib.Event.getPageY(e);
        if(y <= c) {
            return "above";
        }else{
            return "below";
        }
    },

    isValidDropPoint: function(pt, n, data) {
        if (!data.viewNodes || (data.viewNodes.length != 1)) {
            return true;
        }
        var d = data.viewNodes[0];
        if (d == n) {
            return false;
        }
        if ((pt == "below") && (n.nextSibling == d)) {
            return false;
        }
        if ((pt == "above") && (n.previousSibling == d)) {
            return false;
        }
        return true;
    },

    onNodeEnter : function(n, dd, e, data){
    	if (this.highlightColor && (data.sourceView != this)) {
	    	this.el.highlight(this.highlightColor);
	    }
        return false;
    },

    onNodeOver : function(n, dd, e, data){
        var dragElClass = this.dropNotAllowed;
        var pt = this.getDropPoint(e, n, dd);
        if (this.isValidDropPoint(pt, n, data)) {
    		if (this.appendOnly || this.sortField) {
    			return "x-tree-drop-ok-below";
    		}

//            set the insert point style on the target node
            if (pt) {
                var targetElClass;
                if (pt == "above"){
                    dragElClass = n.previousSibling ? "x-tree-drop-ok-between" : "x-tree-drop-ok-above";
                    targetElClass = "x-view-drag-insert-above";
                } else {
                    dragElClass = n.nextSibling ? "x-tree-drop-ok-between" : "x-tree-drop-ok-below";
                    targetElClass = "x-view-drag-insert-below";
                }
                if (this.lastInsertClass != targetElClass){
                    Ext.fly(n).replaceClass(this.lastInsertClass, targetElClass);
                    this.lastInsertClass = targetElClass;
                }
            }
        }
        return dragElClass;
    },

    onNodeOut : function(n, dd, e, data){
        this.removeDropIndicators(n);
    },

    onNodeDrop : function(n, dd, e, data){
        if (this.fireEvent("drop", this, n, dd, e, data) === false) {
            return false;
        }
        var pt = this.getDropPoint(e, n, dd);
        var insertAt = (this.appendOnly || (n == this.el.dom)) ? this.store.getCount() : n.viewIndex;
        if (pt == "below") {
            insertAt++;
        }

//        Validate if dragging within a DDView
        if (data.sourceView == this) {
//            If the first element to be inserted below is the target node, remove it
            if (pt == "below") {
                if (data.viewNodes[0] == n) {
                    data.viewNodes.shift();
                }
            } else { //    If the last element to be inserted above is the target node, remove it 
                if (data.viewNodes[data.viewNodes.length - 1] == n) {
                    data.viewNodes.pop();
                }
            }

//            Nothing to drop...
            if (!data.viewNodes.length) {
                return false;
            }

//            If we are moving DOWN, then because a store.remove() takes place first,
//            the insertAt must be decremented.
            if (insertAt > this.store.indexOf(data.records[0])) {
                insertAt--;
            }
        }

//        Dragging from a Tree. Use the Tree's recordFromNode function.
        if (data.node instanceof Ext.tree.TreeNode) {
            var r = data.node.getOwnerTree().recordFromNode(data.node);
            if (r) {
                data.records = [ r ];
            }
        }

        if (!data.records) {
            alert("Programming problem. Drag data contained no Records");
            return false;
        }

        for (var i = 0; i < data.records.length; i++) {
            var r = data.records[i];
            var dup = this.store.getById(r.id);
            if (dup && (dd != this.dragZone)) {
				if(!this.allowDup && !this.allowTrash){
                	Ext.fly(this.getNode(this.store.indexOf(dup))).frame("red", 1);
					return true
				}
				var x=new Ext.data.Record();
				r.id=x.id;
				delete x;
			}
            if (data.copy) {
                this.store.insert(insertAt++, r.copy());
            } else {
                if (data.sourceView) {
                    data.sourceView.isDirtyFlag = true;
                    data.sourceView.store.remove(r);
                }
                if(!this.allowTrash)this.store.insert(insertAt++, r);
            }
			if(this.sortField){
				this.store.sort(this.sortField, this.sortDir);
			}
            this.isDirtyFlag = true;
        }
        this.dragZone.cachedTarget = null;
        return true;
    },

//    Ensure the multi proxy is removed
    onEndDrag: function(data, e) {
        var d = Ext.get(this.dragData.ddel);
        if (d && d.hasClass("multi-proxy")) {
            d.remove();
            //delete this.dragData.ddel; 
        }
    },

    removeDropIndicators : function(n){
        if(n){
            Ext.fly(n).removeClass([
                "x-view-drag-insert-above",
				"x-view-drag-insert-left",
				"x-view-drag-insert-right",
                "x-view-drag-insert-below"]);
            this.lastInsertClass = "_noclass";
        }
    },

/**
 *    Utility method. Add a delete option to the DDView's context menu.
 *    @param {String} imageUrl The URL of the "delete" icon image.
 */
    setDeletable: function(imageUrl) {
        if (!this.singleSelect && !this.multiSelect) {
            this.singleSelect = true;
        }
        var c = this.getContextMenu();
        this.contextMenu.on("itemclick", function(item) {
            switch (item.id) {
                case "delete":
                    this.remove(this.getSelectedIndexes());
                    break;
            }
        }, this);
        this.contextMenu.add({
            icon: imageUrl || AU.resolveUrl("/images/delete.gif"),
            id: "delete",
            text: AU.getMessage("deleteItem")
        });
    },

/**    Return the context menu for this DDView. */
    getContextMenu: function() {
        if (!this.contextMenu) {
//            Create the View's context menu
            this.contextMenu = new Ext.menu.Menu({
                id: this.id + "-contextmenu"
            });
            this.el.on("contextmenu", this.showContextMenu, this);
        }
        return this.contextMenu;
    },

    disableContextMenu: function() {
        if (this.contextMenu) {
            this.el.un("contextmenu", this.showContextMenu, this);
        }
    },

    showContextMenu: function(e, item) {
        item = this.findItemFromChild(e.getTarget());
        if (item) {
            e.stopEvent();
            this.select(this.getNode(item), this.multiSelect && e.ctrlKey, true);
            this.contextMenu.showAt(e.getXY());
        }
    },

/**
 *    Remove {@link Ext.data.Record}s at the specified indices.
 *    @param {Array/Number} selectedIndices The index (or Array of indices) of Records to remove.
 */
    remove: function(selectedIndices) {
        selectedIndices = [].concat(selectedIndices);
        for (var i = 0; i < selectedIndices.length; i++) {
            var rec = this.store.getAt(selectedIndices[i]);
            this.store.remove(rec);
        }
    },

/**
 *    Double click fires the event, but also, if this is draggable, and there is only one other
 *    related DropZone that is in another DDView, it drops the selected node on that DDView.
 */
    onDblClick : function(e){
        var item = this.findItemFromChild(e.getTarget());
        if(item){
            if (this.fireEvent("dblclick", this, this.indexOf(item), item, e) === false) {
                return false;
            }
            if (this.dragGroup) {
                var targets = Ext.dd.DragDropMgr.getRelated(this.dragZone, true);

//                Remove instances of this View's DropZone
                while (targets.contains(this.dropZone)) {
                    targets.remove(this.dropZone);
                }

//                If there's only one other DropZone, and it is owned by a DDView, then drop it in
                if ((targets.length == 1) && (targets[0].owningView)) {
                    this.dragZone.cachedTarget = null;
                    var el = Ext.get(targets[0].getEl());
                    var box = el.getBox(true);
                    targets[0].onNodeDrop(el.dom, {
                        target: el.dom,
                        xy: [box.x, box.y + box.height - 1]
                    }, null, this.getDragData(e));
                }
            }
        }
    },

    onItemClick : function(item, index, e){
//        The DragZone's mousedown->getDragData already handled selection
        if (this.ignoreNextClick) {
            delete this.ignoreNextClick;
            return;
        }

        if(this.fireEvent("beforeclick", this, index, item, e) === false){
            return false;
        }
        if(this.multiSelect || this.singleSelect){
            if(this.multiSelect && e.shiftKey && this.lastSelection){
                this.select(this.getNodes(this.indexOf(this.lastSelection), index), false);
            } else if (this.isSelected(item) && e.ctrlKey) {
                this.deselect(item);
            }else{
                this.deselect(item);
                this.select(item, this.multiSelect && e.ctrlKey);
                this.lastSelection = item;
            }
            e.preventDefault();
        }
        return true;
    }
});

/**
 * @class mzinga.ui.TabPanel
 * @extends Ext.TabPanel
 * This class extends tabpanel so that we can create custom markup.
 * @param {Object} config The configuration object for the tabpanel
 */
mzinga.ui.TabPanel = Ext.extend(Ext.TabPanel, {
    afterRender : function(){
		this.stripSpacer.boxWrap().addClass("os-tab-strip-spacer");
		mzinga.ui.TabPanel.superclass.afterRender.call(this);
    }
});

mzinga.ui.readCookies = function(){
    var cookies = {};
    var c = document.cookie + ";";
    var re = /\s?(.*?)=(.*?);/g;
	var matches;
	while((matches = re.exec(c)) != null){
        var name = matches[1];
        var value = matches[2];
        cookies[name] = value;
    }
    return cookies;
};

mzinga.ui.getCookie=function(name){
	var allCookies = mzinga.ui.readCookies();	
    return allCookies[name];
};

mzinga.ui.setCookie=function(name, value, options){
	options = (options == null) ? {} : options;
    document.cookie = name + "=" + value +
       ((options.expires == null) ? "" : ("; expires=" + options.expires.toGMTString())) +
       ((options.path == null) ? "" : ("; path=" + options.path)) +
       ((options.domain == null) ? "" : ("; domain=" + options.domain)) +
       ((options.secure == true) ? "; secure" : "");
};


mzinga.ui.clearCookie=function(name, options){
	options = (options == null) ? {} : options;
    document.cookie = name + "=null; expires=Thu, 01-Jan-70 00:00:01 GMT" +
       ((options.path == null) ? "" : ("; path=" + options.path)) +
       ((options.domain == null) ? "" : ("; domain=" + options.domain)) +
       ((options.secure == true) ? "; secure" : "");
};

/**
 * The main application viewport.  It doesn't extend the viewport object because
 * it needs to expand within a certain bounds instead of the whole screen.
 *
 * @constructor
 * @param {object} config a configuration object
 */
mzinga.ui.MainScreen = Ext.extend(Ext.Container, {

    lastHeight : 0,
    lastWidth : 0,
    lastRepeated : 0,
    
    // @override
    initComponent : function() {

        mzinga.ui.MainScreen.superclass.initComponent.call(this);

        var body = Ext.getBody();

        if (this.renderTo) {
            this.el = Ext.get(this.renderTo);
        } else {
            document.getElementsByTagName('html')[0].className += ' x-viewport';
            this.el = body;
        }

        if (this.el != body) {
            this.el._setHeight = this.el.setHeight;
            this.el._setWidth = this.el.setWidth;
            this._applyElementSize();
            this.el.addClass('os-layout-screen');
        }

        this.el.setHeight = Ext.emptyFn;
        this.el.setWidth = Ext.emptyFn;
        this.el.setSize = Ext.emptyFn;
        this.el.dom.scroll = 'no';
        this.allowDomMove = false;
        this.autoWidth = true;
        this.autoHeight = true;
        Ext.EventManager.onWindowResize(this.fireResize, this);
        this.renderTo = this.el;
    },

    /**
     * Fires a resize event when the window is resized.
     *
     * @param {int} w width
     * @param {int} h height
     */
    fireResize : function(w, h) {        
        var aw = w;
        var ah = h;

        if (this.el != Ext.getBody()) {
            ah = this._applyElementSize();
        }

        this.fireEvent('resize', this, aw, ah, w, h);
    },

    /**
     * Sets the height and width of the element and returns what it set.
     */
    _applyElementSize : function() {

        var bodySize = this._getViewportSize();

        var heightSlack = 10;
        var newHeight = bodySize.height - this.el.getY() - heightSlack;

        var widthSlack = 10;
        var newWidth = bodySize.width - this.el.getX() - widthSlack;
        
        var hasChanged = ( (newHeight != this.lastHeight) || (newWidth != this.lastWidth) ); 
        
        // Last width and height had to be repeated, run twice, in IE8 when resizing, not sure why.
        // I am letting it repeat twice, run three times, with the same values to be sure things work.
        if( hasChanged || this.lastRepeated < 2 ) {
            this.el._setHeight(newHeight);
            this.el._setWidth(newWidth);

            if( hasChanged ) {
                this.lastHeight = newHeight;
                this.lastWidth = newWidth;
                this.lastRepeated = 0;
            } else {            	
            	this.lastRepeated = this.lastRepeated + 1;        
            }
            if (Ext.isIE6) {
            	setTimeout(this._resizeElement.createDelegate(this,[bodySize,newHeight,newWidth]),0);
            } else {
            	this._resizeElement(bodySize,newHeight,newWidth);
            }
        }
    },

    _resizeElement: function(bodySize,newHeight,newWidth) {
    	var newScrollSize = this._getScrollSize();

        if (newScrollSize.height > bodySize.height) {
            newHeight -= (newScrollSize.height - bodySize.height);
            this.el._setHeight(newHeight);
        }

        if (newScrollSize.width > bodySize.width) {
            newWidth -= (newScrollSize.width - bodySize.width);
            this.el._setWidth(newWidth);
        }
    },
    _getScrollSize : function() {
        var scrollWidth;
        var scrollHeight;

        if (typeof document.documentElement != 'undefined') {
            scrollWidth = document.documentElement.scrollWidth;
            scrollHeight = document.documentElement.scrollHeight;
        } else {
            var body = Ext.getBody().dom;
            scrollWidth = body.scrollWidth;
            scrollHeight = body.scrollHeight;
        }

        return {
            height : scrollHeight,
            width : scrollWidth
        }

    },

    _getViewportSize : function() {

        var viewportwidth;
        var viewportheight;

        if (typeof window.innerWidth != 'undefined')
        {
             viewportwidth = window.innerWidth,
             viewportheight = window.innerHeight
        }

        // IE6 in standards compliant mode (i.e. with a valid doctype as the first line in the document)

        else if (typeof document.documentElement != 'undefined'
            && typeof document.documentElement.clientWidth !=
            'undefined' && document.documentElement.clientWidth != 0)
        {
              viewportwidth = document.documentElement.clientWidth,
              viewportheight = document.documentElement.clientHeight
        }

        // older versions of IE

        else
        {
              viewportwidth = document.getElementsByTagName('body')[0].clientWidth,
              viewportheight = document.getElementsByTagName('body')[0].clientHeight
        }

//        var scrollSize = this._getScrollSize();
//        var scrollSize = {
//            height : 0,
//            width : 0
//
//        }

        return {
            height: viewportheight,
            width : viewportwidth
        }

    }

}); // end mzinga.ui.MainScreen

/**
 * A ComboBox used to dynamic search on an input box. It handles calling a URL and retrieving the data to display in a drop down. 
 * @param {Object} confg An object containing handler configuration
 * properties. This may contain any of the following properties:<ul>
 * <li>selectFunction {Object} This is the function to be used when the Dynamic Input dropdown value is selected.</li>
 * <li>beforeLoadFunction {Object} This is the function to be used before retrieving the data and loading it in the data store.</li>
 * <li>if you don't create your own data store and assign it using the store parameter, you can use the dataStoreConfigs param 
 * and the following properties...<ul>
 * <li>urlCall {String} The URL used to make the AJAX call to return the data.</li>
 * <li>queryParams {Array of Objects} The query string parameters and values to be passed across, can use empty string for values.</li>
 * <li>idColumn {String} The key value for datastore to be used as the unique ID for each row.</li>
 * <li>dataColumns {Array of Strings} The columns for each row of the data store. </li>
 * </ul></li>
 * </ul>
 * @constructor
 */
mzinga.ui.DynamicInput = Ext.extend(Ext.form.ComboBox, {
	typeAhead: true,
    mode: 'remote',
    triggerAction: 'all',
    hideTrigger: true,
    selectOnFocus:true,
	
    initComponent: function() {
		if (this.store == undefined) {
			this._buildStore();
		}
		
		this.on('select', this.selectFunction, this);
		mzinga.ui.DynamicInput.superclass.initComponent.apply(this, arguments);
    },

	_buildStore : function() {
    	this.store = new Ext.data.Store({
	        baseParams: this.dataStoreConfigs.queryParams,
	        proxy: new Ext.data.HttpProxy({
	            url: this.dataStoreConfigs.urlCall,
	            method: 'GET'             
	        }),
	        reader: new Ext.data.JsonReader({
                id: this.dataStoreConfigs.idColumn,
                fields: this.dataStoreConfigs.dataColumns
            }),
	        listeners: {
	            beforeload: this.dataStoreConfigs.beforeLoadFunction
	        }
	    });
	}
});

//ExtJS 2.2 patch for TriggerField's using "hideTrigger=true"
Ext.form.TriggerField.override({
    afterRender : function(){
        Ext.form.TriggerField.superclass.afterRender.call(this);
        var y;
        if(Ext.isIE && !this.hideTrigger && this.el.getY() != (y = this.trigger.getY())){
            this.el.position();
            this.el.setY(y);
        }
    }
});

