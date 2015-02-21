//

    var navigatorFields = new Array();
    var useNavigatorEvents = (navigator.appName.indexOf("Netscape") != -1);
    var useIEEvents = (navigator.appName.indexOf("Microsoft") != -1);

    if (useNavigatorEvents) {
        document.captureEvents(Event.KEYPRESS);
    }

    function ieKeyHandler() {
        e = window.event;
        key = e.keyCode;
        if (key != 0) {
            return false;
        }
        return true;
    }

    function navigatorKeyHandler(e) {
        key = e.which;
        if (key != 0) {
            for (i=0; i < navigatorFields.length; i++) {
                if (e.target == navigatorFields[i]) {
                    return false;
                }
            }
        }
        return true;
    }

    function submitToController(requestTarget) {
        if(document.xslControllerForm){
            document.xslControllerForm.RequestTarget.value = requestTarget;
            document.xslControllerForm.submit();
        }
    }

    function submitToPage(pageName) {
        if(document.navigationPageForm){
            document.navigationPageForm.Page.value = pageName;
            document.navigationPageForm.submit();
        }
    }

    function submitAdminNavigation(mainLocation, optionsLocation, infoLocation, secureMode){
    	if (secureMode && document.AdminFrameRedirect) {
    		document.AdminFrameRedirect.AdminFrameSetMain.value=mainLocation;
    		document.AdminFrameRedirect.AdminFrameSetOptions.value=optionsLocation;
    		document.AdminFrameRedirect.AdminFrameSetInfo.value=infoLocation;
			document.AdminFrameRedirect.submit();
		} else {
	        window.parent.main.location.href=mainLocation;
	        window.parent.options.location.href=optionsLocation;
		}
    }
    
    function goDomain() {
    	var domainSelected = document.formDomainSelect.domainSelect[document.formDomainSelect.domainSelect.selectedIndex].value;
    	document.formDomainSelect.action = domainSelected;  	
    	document.formDomainSelect.submit();
    }
    
    function goExperience() {
    	var experienceSelected = document.formExperienceSelect.experienceSelect[document.formExperienceSelect.experienceSelect.selectedIndex].value;
    	document.formExperienceSelect.action = experienceSelected;  	
    	document.formExperienceSelect.submit();
    }

    function goPersonal() {
        if(document.formPersonal){
            if(document.formPersonal.roleChoice[document.formPersonal.roleChoice.selectedIndex].value=="Learner"){
                      submitToController("SWITCH_TO_LEARNER");
            } else if(document.formPersonal.roleChoice[document.formPersonal.roleChoice.selectedIndex].value=="Mentor"){
                      submitToController("SWITCH_TO_MENTOR");
            } else if(document.formPersonal.roleChoice[document.formPersonal.roleChoice.selectedIndex].value=="Admin" && document.login){
                      document.login.submit();
            }
        }
    }
    
    var currentTab;
    function changeTabById(itemId) {
        var anItem = document.getElementById(itemId);
        changeTab(anItem);
    }

    function changeTab(anItem) {
        var activeElement = document.getElementById(currentTab);
        activeElement.className='inactive';
        anItem.className='active';
        var tabContentElement = document.getElementById(currentTab + 'contents');
        tabContentElement.className="tabcontentshidden";
        tabContentElement = document.getElementById(anItem.id + 'contents');
        tabContentElement.className="tabcontents";
        currentTab = anItem.id;
        if (eval('self.' + currentTab + 'OnChange')) {
            eval(currentTab + 'OnChange')();
        }
    }

    function dehighlight(anItem) {
        var hoverIndex = anItem.className.indexOf(" hover");
        if (hoverIndex >= 0) {            
        	var origClass = anItem.className;
        	anItem.className = origClass.substring(0,hoverIndex) + origClass.substring(hoverIndex+6);
        }
    }

    function highlight(anItem) {
        anItem.className = anItem.className + " hover"; 
    }

    /**
     * Enable the passed in tab. This will add the standard tab switch functions
     * if the tabOnClickMap is not passed in.     
     * @param anItem The tab Element.
     * @param theClassName The CSS class for the tab. Defaults to 'disabled'
     * @param tabOnClikMap A map with {elementName : functionName}
     */
    function enableTab(anItem, theClassName, tabOnClickMap) {
        if (!theClassName) {
            theClassName = "inactive";
        }
        anItem.className=theClassName;
        if (tabOnClickMap && tabOnClickMap[anItem.id]) {
            anItem.onclick=tabOnClickMap[anItem.id];
        } else {
            anItem.onclick=function() { changeTab(this);return false; };
        }
        anItem.onmouseover=function() { if (highlight) highlight(this); };
        anItem.onmouseout=function() { if (dehighlight) dehighlight(this); };
    }

    /**
     * Disable the passed in tab. This will remove the onClick events and will
     * make the tab look disabled.
     * @param anItem The tab Element.
     * @param theClassName The CSS class for the tab. Defaults to 'disabled'
     */
    function disableTab(anItem, theClassName) {
        if (!theClassName) {
            theClassName = "disabled";
        }
        anItem.className=theClassName;
		anItem.onclick=function() { };
        anItem.onmouseover=function() { };
        anItem.onmouseout=function() {  };
    }

	/**
     * Initialize a set of tabs using a HTML unordered or ordered list.
     * The format of the HTML should be as follows:
     *	<ul id="mytabs" class="tabcontainer">
     *		<li id="tab1">
     *			Tab 1 Title
     *		</li>
     *		<li id="tab2">
     *			Tab 2 Title
     *		</li>
     *		<li id="tab3">
     *			Tab 3 Title
     *		</li>
     *	</ul>                            
     *	<div class="tabcontents" id="tab1contents">
     *		Tab 1 contents
     *	</div>
     *	<div class="tabcontentshidden" id="tab2contents">
     *		Tab 2 contents
     *	</div>
     *	<div class="tabcontentshidden" id="tab3contents">
     *		Tab 3 contents
     *	</div>
     *	Each of the list items needs an id.  The div for a tab
     *	must be the list item id plus "contents", so if your list id was
     *	"tab1", the div id would be "tab1contents".  The list itself
     *	needs to use the tabcontainer class.  The tab contents can be made
     *	visible by using the tabcontents class and the other tab contents can
     *	be hidden by using the tabcontentshidden class.     
     * Parameter: aListElementName -- The id of the list to setup as tabs.
     * Parameter: aHighlightId -- The id of the tab (list item) to set as highlighted.
     * If this value is not passed in, highlight the first tab.
     * Parameter: disabledArray -- An array of tab id's that will be disabled.
     * Parameter: formSubmitMap -- An map with the form to submit when a tab is clicked.
     */
    function initializeTabs(aListElementName, aHighlightId, disabledArray, tabOnClickMap) {
        var cntr;
        var isDisabled = false;
        var listElement = document.getElementById(aListElementName);
        var listElements = listElement.getElementsByTagName("*");
        currentTab = aHighlightId?aHighlightId:listElements[0].id;
        for (i=0; i < listElements.length; i++){
            if (listElements[i].id == currentTab) {
                enableTab(listElements[i], "active", tabOnClickMap);
            } else {
                if (disabledArray && disabledArray != null && disabledArray.length > 0) {
                    for (cntr = 0; cntr < disabledArray.length; cntr++) {
                        if (disabledArray[cntr] == listElements[i].id) {
                            isDisabled = true;
                            break;
                        }
                    }
                }
                if (isDisabled) {
                    listElements[i].className="disabled";
                } else {
                    enableTab(listElements[i], "inactive", tabOnClickMap);
                }
            }
			isDisabled = false;
        }
        changeTab(document.getElementById(currentTab));
    }

    function logout() {
        document.logoutForm.submit();
        return true;
    }

/**
 * return the value of the radio button that is checked
 */
function getCheckedValue(radioObj) {
    var radioLength = radioObj.length;
    if(radioLength == undefined) {
        if(radioObj.checked) {
            return radioObj.value;
        } else {
            return '';
        }
    }
    for(var i = 0; i < radioLength; i++) {
        if(radioObj[i].checked) {
            return radioObj[i].value;
        }
    }
    return '';
}

/**
 * Check the radio with the passed in value.
 */
function setCheckedValue(radioObj, theValue) {
    var radioLength = radioObj.length;
    if(radioLength == undefined) {
        if(radioObj.value == theValue) {
            radioObj.checked;
        }
    }
    for(var i = 0; i < radioLength; i++) {
        if(radioObj[i].value == theValue) {
            radioObj[i].checked = true;
			break;
        }
    }
    return;
}

/**
 * Check to see if the passed in field value is numeric.
 * It uses the following errorMessage messages.
 *
 * var errorMessages = {
 *      dollarError: 'No Dollar Signs',
 *      notNumeric: 'Non numeric entered. Please enter a valid number',
 *      noDecimals: 'Only enter whole numbers. No decimals allowed'
 *  }
 */
function isNumericValue(myField, justInt, errorMessages) {
    errorMessages = errorMessages || {};
    if(myField && myField.name){  //check if the form field exists
        var str = myField.value;
        var ch = "";
        var msg = "";
        var decLoc=-1;
        for (var i=0; i < str.length; i++){
            ch=str.substring(i, i+1);
            if (ch != "."){
                if (ch < "0" || ch > "9") {
                    if(ch == "$"){
                        if (errorMessages.dollarError) {
                            msg = errorMessages.dollarError;
                        } else {
                            msg = "No Dollar Sign allowed: add message to errorMessages object."
                        }
                        alert(msg);
                    } else{
                        if (errorMessages.notNumeric) {
                            msg = errorMessages.notNumeric;
                        } else {
                            msg = "Not a Numeric Value: add message to errorMessages object."
                        }
                        alert(msg);
                    }
                    i=str.length;
                    myField.focus();
                    return false;
                }
            } else if(justInt && (ch == ".")){
                if (errorMessages.noDecimals) {
                    msg = errorMessages.noDecimals;
                } else {
                    msg = "No Decimals allowed: add message to errorMessages object."
                }
                alert(msg);
                myField.focus();
                return false;
            } else if(!justInt && (ch==".")) {
                if(decLoc == -1){
                    decLoc = i;
                }
            }
        }
        if(decLoc > -1 && (str.length - (decLoc+1) > 2)){
            myField.value = str.substring(0, (decLoc+3));
        }
    }
    return true;
}

/**
 * Deselect all the radio's in the given group.
 */
function deselectRadio(radioObj) {
    var radioLength = radioObj.length;
    if(radioLength == undefined) {
        if(radioObj.checked) {
            radioObj.checked = false;
            return;
        }
    }
    for(var i = 0; i < radioLength; i++) {
        if(radioObj[i].checked) {
            radioObj[i].checked = false;
            return;
        }
    }
}

