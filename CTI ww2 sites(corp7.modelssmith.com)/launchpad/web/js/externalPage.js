DabblePageForm = {
	path: '',
	requiredFields: [],
	errorMessage: 'Before you can submit this form, the following fields must be completed:',
	noMatches: 'No matches found.',
	moreMatches: '<strong>&#8230;and others</strong>',
	spinnerHTML: '<img class="dabblePageLoadingSpinner" src="/weblatest/images/spinner.gif" alt="Loading" />',
	resizeComponents: {
		runOnce: false,
		subtractFooter: false
	},
	navBoxTimer: null,
	form: null,
	submitButtonName: null,
	firstRequest: true,
	firstRequestSubmitted: false,
	lastPageRequestData: '',
	
	promoteFixedContainer: function() {
		return;
	},
	fixIESelect: function(box) {
		if (DabblePageForm.Browser.name == 'Internet Explorer' && DabblePageForm.Browser.version < 7) {
			var iframe = box.find('iframe.dabblePageIE6CoverSelects');
			if (!iframe.length) {
				iframe = $E('iframe.dabblePageIE6CoverSelects', { src: '/weblatest/blank.html' });
				iframe.attr('scrolling', 'no');
				iframe.attr('frameborder', '0');
				box.prepend(iframe);
			}
			iframe.css({ height: box.offsetHeight() + 'px' });
		}
	},
	togglePopMenu: function(id) {
		var box = $('#' + id);
		if (box.filter(':visible').length) {
			box.hideAndDemote();
		} else {
			box.showAndPromote();
			DabblePageForm.fixIESelect(box);
		}
	},
	
	fileUpload: function(node, id) {
		node.empty();
		node.append($E('input.file', { type: 'file', name: id }));
	},
	
	initializeView: function(defaultPostData) {
		if (!this.viewContent) this.viewContent = $('#dabbleViewContent');
		if (this.viewContent.length) {
			this.initHistoryLinks();
		}
		if (!window.location.hash && defaultPostData) {
			window.location.hash = defaultPostData.replace(/\n/, '');
		}
		if (!DabblePageForm.firstRequestSubmitted) {
		// Safari seems to need this kick in the pants to load the first view
			$.historyLoad(window.location.hash.replace(/^#/, ''));
		}
	},
	
	showViewLoadingSpinner: function() {
		var existingTable = DabblePageForm.viewContent.find('table:first').not('#dabblePagePlaceholder');
		if (existingTable.length) {
			var busyLoadingBox = $E('div.dabblePageBusyLoadingBox', { innerHTML: DabblePageForm.spinnerHTML }).prependTo(DabblePageForm.viewContent);
			var tableHeight = existingTable.offsetHeight();			
			var height = tableHeight > 0 ? (parseInt(tableHeight / 2, 10) + 'px') : 0;
			var width = (existingTable.offsetWidth() || DabblePageForm.viewContent.offsetWidth()) + 'px';
			busyLoadingBox.css({
				height: height,
				paddingTop: height,
				width: width
			});
		}
	},
	
	requestPage: function(postData, updateID) {
		DabblePageForm.showViewLoadingSpinner();
		var postDataMatch = postData.match(/focus=(.*?)&/);
		if (postDataMatch) {
			$('#dabblePageFocusField').val(postDataMatch[postDataMatch.length - 1]);
		}
		DabblePageForm.firstRequestSubmitted = true;
		return $.ajax({
			url: window.location.pathname,
			data: postData.charAt(0) == '?' ? postData.substr(1) : postData,
			type: 'get',
			dataType: 'html',
			success: function (data) {
				$('#' + updateID).html(data);
				DabblePageForm.initTableRows();
				if (DabblePageForm.firstRequest) {
					DabblePageForm.scrollToForm();
					DabblePageForm.firstRequest = false;
				}
			},
			error: function() {
				var error = '<p>Sorry. An error occurred.</p>';
				var placeholder = $('#dabblePagePlaceholderContent');
				if (placeholder.length) {
					placeholder.html(error);
				} else {
					DabblePageForm.viewContent.prepend('<div id="dabblePagePlaceholderContent">' + error + '</div>');
				}
			}
		});
	},

	validate: function(event) {
		if (event) event.preventDefault();
		var errors = [];
		var resultHTML = '';
		this.errorBox.empty();
		if (DabblePageForm.submitButtonName != 'cancel' && DabblePageForm.submitButtonName != 'delete') {
			var radioButtons = {};
			var toManyElements = {};
			var requiredElementBoxes = $('.dabblePageFormItemRequired');
			
			// reset hidden input values for autocomplete boxes:
			$('.dabblePageAutocompleteFieldBox input:text').each(function () {
				var autocompleteInput = this;
				var hiddenEntryID = $('#' + autocompleteInput.id + '-autocompleteID');
				if (hiddenEntryID.length) {
					if (!autocompleteInput.value || (autocompleteInput.value.indexOf('Search for ') === 0 && autocompleteInput.style.color == 'gray')) {
						hiddenEntryID.val('');
					}
				}
			});

			// validate the fields
			$('.dabblePageFormItemRequiredError').removeClass('dabblePageFormItemRequiredError');
			requiredElementBoxes.each(function () {
				var box = $(this);
				function printValidationError(element) {
					var closestField = element.closest('.dabblePageFormField');
					var previousLabel = closestField.prevAll('.dabblePageFormLabel');
					var labelEl = previousLabel.find('label');
					var label = labelEl.html();
					if (label.charAt(label.length - 1) == '*') {
						label = label.slice(0, label.length - 1);
					}
					errors.push(label);
					box.addClass('dabblePageFormItemRequiredError');
				}
				
				function validateElement() {
					element = $(this);
					var validationError = false;
					if (element.closest('.datePickerTable').length) return; // if this is part of a date picker, ignore
					var isToMany = element.parent('.dabblePageAutocompleteFieldBox').length || element.next('.dabblePageAutocompleteFieldBox').length; // figure out if this is a to-many field
					if (element.attr('type') == 'radio') {
						// for each set of radio buttons, check validation once only
						var rName = element.attr('name');
						if (radioButtons[rName]) {
							return;
						} else {
							radioButtons[rName] = true;
							validationError = !$('input.radio[name="' + rName + '"]').filter(function () { return this.checked; }).length;
						}
					} else if (element.attr('type') == 'checkbox') {
						validationError = !element[0].checked;
					} else if (isToMany) {
						var fieldNameStem = element.attr('name').match(/^(\d+)/)[1];
						if (!toManyElements[fieldNameStem]) { // for to-manies, cache value if one hasn't been recorded yet so we can easily check validation
							toManyElements[fieldNameStem] = element.val();
						}
					} else {
						validationError = !element.val();
					}
					if (validationError) {
						printValidationError(element);
					}
				}

				// validate all normal fields
				box.find('input:not(:submit,:reset,:file,:hidden,:image,:button),select,textarea').filter('*[name]').each(validateElement);

				// validate all hidden ID fields for autocompleters
				box.find('.dabblePageAutocompleteFieldBox input[name]').each(validateElement);

				// for each to-many without a value, print a validation error
				for (var name in toManyElements) {
					if (!toManyElements[name]) {
						var elToError = box.find('*[id="f' + name + '"]:first');
						if (elToError.length) {
							printValidationError(elToError);
						}
					}
				}
			});
		}
		var numErrors = errors.length;
		if (numErrors > 0) {
			resultHTML = '<p>' + this.errorMessage + '</p><ul class="bulleted">';
			for (var i = 0; i < numErrors; i++) {
				resultHTML += '<li>' + errors[i] + '</li>';
			}
			resultHTML += '</ul>';
			this.errorBox.html(resultHTML);
			$(window).scrollTop(this.errorBox.offset().top);
		} else {
			if (DabblePageForm.submitButtonName) {
				DabblePageForm.form.append($E('input', { type: 'hidden', name: DabblePageForm.submitButtonName, value: DabblePageForm.submitButtonName }));
			}
			DabblePageForm.form[0].submit();
		}
		return false;
	},
	
	Browser: {
		name: '',
		version: '',
		OS: '',
		versionLocationInString: 8,
		agentString: navigator.userAgent.toLowerCase(),
		browserStrings: {
			'konqueror': "Konqueror",
			'webkit': "Safari",
			'omniweb': "OmniWeb",
			'opera': "Opera",
			'webtv': "WebTV",
			'icab': "iCab",
			'msie': "Internet Explorer",
			'firefox': "Firefox"
		},
		OSStrings: {
			'linux': "Linux",
			'x11': "Unix",
			'mac': "Mac",
			'win': "Windows"
		},
		findOS: function() {
			for (var s in this.OSStrings) {
				var index = this.agentString.indexOf(s);
				if (index != -1) {
					this.OS = this.OSStrings[s];
					return;
				}
			}
			this.OS = "An unknown operating system";
			return;
		},
		detect: function() {
			for (var s in this.browserStrings) {
				var index = this.agentString.indexOf(s);
				if (index != -1) {
					this.name = this.browserStrings[s];
					this.version = this.agentString.charAt(index + s.length + 1);
					this.findOS();
					return;
				}			
			}
			
			if (this.agentString.indexOf('compatible') == -1) {
				this.name = "Netscape Navigator";
				this.version = this.agentString.charAt(8);
			} else {
				this.name = "An unknown browser";
			}
			
			this.findOS();
			return;
		}
	},
	
	removeValueButtonHandler: function() {
		$(this).parent().remove();
		return false;
	},

	duplicateField: function(fieldID) {
		var field = $('#' + fieldID);
		var box = field.parents('.dabblePageFormField');
		var newField = field.clone();
		var newFieldBox = $E('span.dabblePageAutocompleteFieldBox');
		var removeButton = $E('input.dabblePageAutocompleteFieldRemoveButton', { type: 'image', src: this.path + 'images/icons/delete.gif' });
		var fieldCount = 1;
		var lastField;
		newFieldBox.append(newField);
// find a unique ID for the new field
// start at 2 and count up until there's no existing field with that number
		do { 
			fieldCount++; 
			lastField = $('#' + fieldID + '-' + fieldCount);
		} while (lastField.length);
		newField.attr({ id: newField.attr('id') + '-' + fieldCount });
		newFieldBox.append(removeButton);
		if (newField.getNodeName() == 'input') {
			var hiddenIDField = $('#' + fieldID + '-autocompleteID').clone();
			hiddenIDField.attr({
				id: newField.attr('id') + '-autocompleteID',
				name: hiddenIDField.attr('name') + '-' + fieldCount
			}).val('');
			newFieldBox.append(hiddenIDField);
			var results = $E('span.dabblePageFieldSearchResults#' + newField.attr('id') + '-searchResults').hide();
			newFieldBox.append(results).insertBefore($('#' + fieldID + '-addAnotherButton'));
			var name = newField.closest('.dabblePageFormField').prevAll('.dabblePageFormLabel').find('label').html();
			newField.css({ color: 'gray' }).val('Search for ' + name);
			new DabblePageForm.SearchField(newField.attr('id'));
			newField.focus().select();
		} else if (newField.getNodeName() == 'select') {
			newField.selectedIndex = 0;
			newField.attr({ name: field.attr('name') + '-' + fieldCount });
			newFieldBox.insertBefore($('#' + fieldID + '-addAnotherButton'));
			DabblePageForm.fixSelectWidthForIE(newField);
			newField.addClass('dabblePageFormIESelect').focus();
		}
		removeButton.click(function() {
			$(this).parent().remove();
			return false;
		});
	},
	
	fixPageSize: function() {
		var rc = DabblePageForm.resizeComponents;
		if (!rc.runOnce) {
			rc.runOnce = true;
			rc.mainContainer = $('.dabblePageContainer');
			rc.shadowWidth = 6;
			if (!rc.mainContainer.length) return;
			rc.navBox = $('#dabblePageNavigation');
			rc.navBoxWidth = rc.navBox.offsetWidth() || 0;
			rc.pageContent = $('#dabblePageContent');
			rc.header = rc.mainContainer.find('div.dabblePageHeader');
			rc.footer = rc.pageContent.find('.dabblePageSectionFormActions'); // try finding the footer in the page content
			// check for really wide <select> menus and compensate if necessary
			rc.formOverflow = 0;
			$('.dabblePageFormField select').each(function () {
				var selectOverflow = this.offsetWidth + this.offsetLeft - $(this).parents('.dabblePageSection').offsetWidth() - rc.navBoxWidth;
				if (selectOverflow > rc.formOverflow) {
					rc.formOverflow = selectOverflow;
				}
			});
			if (rc.navBox.length) {
				rc.topMessage = $('#dabblePageTopMessage');
				rc.searchForm = $('#dabblePageSearchForm');
				rc.userMenu = null;
				if (!rc.searchForm.length && !rc.topMessage.length) {
					rc.userMenu = $('.dabblePageUserMenu');
				}
				if (DabblePageForm.form) {
					if (rc.footer.length) {
						rc.subtractFooter = true; // subtract the footer if it's in the content
					} else {
						rc.footer = DabblePageForm.form.find('.dabblePageSectionFormActions'); // otherwise find it in the form
					}
				}
			}
		}
		if (!rc.mainContainer.length) return;
		var pageWidth = rc.mainContainer.offsetWidth();
		if (pageWidth < 500) return; // on small screens do nothing
// if view is too wide, make the page wider
		var viewWidth = DabblePageForm.viewContent.children(':visible').offsetWidth();
		var headerHeight = rc.header.offsetHeight();
		var footerHeight = rc.footer.offsetHeight();
		var viewOverflow = 0;
		if (viewWidth) {
			viewOverflow = viewWidth + rc.navBoxWidth - pageWidth;
		}
		if (viewOverflow > 0 || rc.formOverflow > 0) {
			var overflowToUse = (viewOverflow > rc.formOverflow) ? viewOverflow : rc.formOverflow;
			rc.mainContainer.css({
				width: (rc.mainContainer.offsetWidth() + overflowToUse + rc.shadowWidth) + 'px'
			});
			rc.formOverflow = 0;
		}
		if (DabblePageForm.Browser.name == 'Internet Explorer' && DabblePageForm.Browser.version <= 6) {
			if (headerHeight > 0) {
				rc.header.css({
					width: (rc.mainContainer.offsetWidth() - rc.shadowWidth) + 'px'
				});
			}
			if (footerHeight > 0) {
				rc.footer.css({
					width: (rc.mainContainer.offsetWidth() - rc.navBoxWidth - rc.shadowWidth) + 'px'
				});		
			}
		}
// deal with nav box height
		if (rc.navBox.length) {
			var formHeight, navScrollHeight;
			var actualContentHeight = 0;
			rc.pageContent.children().each(function() { actualContentHeight += $(this).height() });
			if (actualContentHeight > rc.pageContent.height()) {
				rc.pageContent.css({ height: '' }); // if content has changed and it's bigger than it was
			}
			formHeight = rc.pageContent.offsetHeight() + rc.searchForm.offsetHeight() + rc.topMessage.offsetHeight() + (rc.userMenu ? rc.userMenu.offsetHeight() : 0);
			if (rc.subtractFooter) {
				formHeight -= footerHeight; // if footer is part of PageContent div, subtract it
			}
			rc.navBox.css({
				paddingTop: headerHeight + 'px',
				paddingBottom: footerHeight + 'px',
				height: formHeight + 'px'
			});
			navScrollHeight = rc.navBox.scrollHeight() - headerHeight - footerHeight;
			if (formHeight < navScrollHeight) {
				if (rc.subtractFooter) {
					var footerDiff = navScrollHeight - formHeight + footerHeight;
					rc.footer.prev().css({ marginBottom: footerDiff + 'px' });
					rc.footer.find('.dabblePageFormActions').css({
						position: 'relative',
						top: '-' + footerDiff + 'px'
					});
				} else {
					rc.pageContent.css({ height: navScrollHeight + 'px' });
				}
			}
		}
		this.navBoxTimer = window.setTimeout(DabblePageForm.fixPageSize, 150);
	},

	fixUserLinkTargets: function() {
		if ($('body.dabbleBodyEmbedded').length > 0) {
			$('.dabblePageText a').each(function() {
				if (!this.target) {
					this.target = '_top';
				}
			});
		}
	},
		
	highlightTableRow: function(event) {
		$(this).closest('tr').addClass('clickRowHover');
	},
	
	unhighlightTableRow: function(event) {
		event = event || window.event;
		$(event.target || event.srcElement).closest('tr').removeClass('clickRowHover');
	},
	
	mouseUpTableRow: function() {
		if (DabblePageForm.mouseMoved) return;
		var href = $('#entry' + $(this).closest('tr').attr('id')).attr('href');
		if (href) {
			window.location = href;
		}
	},
	
	mouseDownTableRow: function() {
		DabblePageForm.mouseMoved = false;	
	},
	
	mouseMoveTableRow: function() {
		DabblePageForm.mouseMoved = true;
	},	
	
	initTableRows: function() {
		$('tr.entryRow').mouseover(DabblePageForm.highlightTableRow)
		                .mouseout(DabblePageForm.unhighlightTableRow)
		                .mousemove(DabblePageForm.mouseMoveTableRow)
		                .mousedown(DabblePageForm.mouseDownTableRow)
		                .mouseup(DabblePageForm.mouseUpTableRow);
		$('tr.entryRow a').click(function(e) { e.stopPropagation(); });
	},
	
	initLinkHandlers: function() {
		$('#toggleFilterLink').click(function() {
			var link = $(this);
			var showAndHide = $('#dabblePageFilterBox').toggleDisplay() ? ['toggleRevealed', 'toggleHidden'] : ['toggleHidden', 'toggleRevealed'];
			link.addClass(showAndHide[0]);
			link.removeClass(showAndHide[1]);
			return false;
		});

		$('#toggleNavigationLink').click(function() {
			$('#dabblePageNavigation').toggleDisplay();
			$('#dabblePageUserMenu').toggleDisplay();
			return false;
		});
		
		$('.inPageLink').each(function() {
			if (this.href.search(/#dabblePageTop/) >= 0) {
				this.onclick = function() {
					window.scrollTo(0,0);
					return true;
				};
			}
		});
		
		$('.dabblePageAutocompleteFieldRemoveButton').each(function() {
			this.onclick = DabblePageForm.removeValueButtonHandler;
		});
	},
	
	scrollToForm: function() {
		if (!this.form || !this.form.length) return;
		if (this.errorBox.length && !this.errorBox.isEmpty()) {
			$(window).scrollTop(this.errorBox.offset().top);
		} else {
			var confirmation = $('#dabblePageConfirmationMessage');
			if (confirmation.length && !confirmation.isEmpty()) {
				$(window).scrollTop(confirmation.offset().top);
			} else if ($('input[name="entry"]').length) {
				$(window).scrollTop(this.form.offset().top);
			}
		}
	},
	
	getPostData: function(hash) {
		var params = hash.split("/");
		if ($.grep(params, function(each, i) { return each.indexOf('page') === 0; }).length === 0)
			params.push("page:dHJ1ZQ==");
		params = $.grep(params, function(each, i) { return each.length !== 0; });
		var postData = $.map(params, function(ea) { 
			var array = ea.split(':');
			return [array[0], escape($.base64Decode(array[1]))].join("=");
		}).join("&");
		return postData;
	},
	
	initHistoryLinks: function() {
		var historyCallback = function(hash) {
			var postData = DabblePageForm.getPostData(hash);
			if (postData != DabblePageForm.lastPageRequestData) {
				DabblePageForm.lastPageRequestData = postData;
				DabblePageForm.requestPage(postData, "dabbleViewContent");
			}
		};

		$.historyInit(historyCallback, window.location.protocol + '//' + window.location.hostname + '/weblatest/blank.html');
		$(".history").live('click', function(){
			$.historyLoad(this.href.replace(/^.*#/, ''));
		});
	},
	
	initFormValidation: function() {
		this.form.find('input[type="text"]','input[type="email"]','input[type="url"]','input[type="checkbox"]','input[type="radio"]','input[type="file"]','select').keypress(function(e) {
			var code = e.keyCode || e.which;
			if (code == 13) {
				if ($(this).nextAll('.dabblePageFieldSearchResults:visible').length) {
				// if this is an autocomplete box and search results are visible, do nothing
					return false;
				}
				DabblePageForm.validate();
				return false;
			} else {
				return true;
			}
		});
		this.form.find('input[type="submit"]').click(function() {
			DabblePageForm.submitButtonName = this.name;
		});
		this.form.submit(function(e) { return DabblePageForm.validate(e); });
		this.submitButton.attr('disabled',	'');
	},
	
	initPrintButton: function() {
		$('.dabblePagePrintLink').click(function(event) {
			event.stopImmediatePropagation();
			DabblePageForm.showPrintDialog();
			return false;
		});
		$('#printDialogCancelButton').click(function() { DabblePageForm.hidePrintDialog(); });
	},
	
	getPrintURL: function() {
		var url = window.location.pathname.replace(/\/page\//, '/page-print/');
		var hash = window.location.hash;
		if (hash) {
			var postData = DabblePageForm.getPostData(hash.substr(1));
			if (postData) {
				url += (postData.charAt(1) != '?' ? '?' : '') + postData;
			}
		} else {
			url = url + window.location.search;		
		}
		return url;
	},
	
	showPrintDialog: function() {
		var dialog = $('#printDialogBox');
		var frame = dialog.find('iframe');
		if (!frame.length) {
			frame = $('<iframe id="printDialog" name="printDialog" frameborder="0" scrolling="no" src="/weblatest/blank.html" style="display: none"></iframe>').appendTo(dialog);
		} else {
			window.frames['printDialog'].location = '/weblatest/blank.html';
			frame.hide();
		}
		window.frames['printDialog'].location = DabblePageForm.getPrintURL();
		$('#printDialogSpinner').show();
		$('#hiddenBox').fadeIn(150, function() {
			if (!dialog.filter(':visible').length) {
				dialog.slideDown(150);
			}
		});
	},
	
	revealPrintDialog: function() {
		$('#printDialogSpinner').hide();
		$('#printDialog').show();
	},
	
	hidePrintDialog: function() {
		$('#printDialogBox').slideUp(100);
		$('#hiddenBox').fadeOut(100);	
	},
	
	fixSelectTimers: {},
	
	fixSelectWidthForIE: function(selects) {
		var timers = this.fixSelectTimers;
		if (DabblePageForm.Browser.name == 'Internet Explorer' && DabblePageForm.Browser.version <= 7) {
			if (!selects) {
				selects = this.form.find('select');
			}
			selects.bind('focusin', function() {
				if (timers[this.id]) {
					window.clearTimeout(timers[this.id]);
				}
				$(this).addClass('dabblePageFormIESelect').css({ width: 'auto' });
				this.focus();
			}).bind('focusout', function() {
				var thisSelect = $(this);
				if (this.id) {
					timers[this.id] = window.setTimeout(function() {
						thisSelect.removeClass('dabblePageFormIESelect').css({ width: '' });
					}, 50);
				}
			});
		}	
	},
	
	init: function() {
		if (!this.viewContent) this.viewContent = $('#dabbleViewContent');
		if (!this.form) {
			this.form = $('#dabblePageForm');
		}
		if (this.form.length > 0) {
			this.errorBox = $('#dabblePageErrors');
			this.submitButton = $('#dabblePageFormSubmit');
			this.initFormValidation();
	// Find autocomplete fields and add handler
			$('.dabblePageFieldSearchResults').each(function() {
				new DabblePageForm.SearchField(this.id.match(/(f\d+-*\d*)-searchResults/)[1]);
			});
	// Find to-many fields and add a button to clone
			$('.dabblePageFieldAddAnotherButton').click(function() {
				DabblePageForm.duplicateField(this.id.match(/(f\d+)-addAnotherButton/)[1]);
			});
			this.fixSelectWidthForIE();
		}
		
		this.initLinkHandlers();
		this.initTableRows();
		this.fixPageSize();
		this.fixUserLinkTargets();
		this.initPrintButton();
// Set nav height to match page height
	}	
};

DabblePageForm.SearchField = function(fieldID) {
	this.field = $('#' + fieldID);
	this.hiddenField = $E('input#' + 'f' + fieldID + '-autocomplete', { type: 'hidden' });
	this.hiddenField.val(this.field.val()); // if a value is present, put it in the hidden field too
	this.hiddenIDField = $('#' + fieldID + '-autocompleteID');
	this.results = $('#' + fieldID + '-searchResults');
	this.hiddenField.insertBefore(this.field);
	this.loading = $E('ul');
	var loadingListItem = this.loading.append($E('li'));
	loadingListItem.append($E('img.dabblePageAutocompleteLoading', {
		src: '/weblatest/images/spinner.gif',
		alt: 'Loading',
		width: '16',
		height: '16',
		border: '0'
	}));
	
	var oldValue = '';
	var $this = this;
	window.setInterval(function() {
		var newValue = $this.field.val().trim();
		if (newValue != oldValue && (newValue.indexOf('Search for ') !== 0 || $this.field.css('color') != 'gray')) {
			$this.update();
		}
		oldValue = newValue;
	}, 100);
	this.field.keydown($this.handleFirstKey);
	this.field.keyup(function(e) { return $this.handleCursorKeys(e); });
	this.field.keypress(function(e) { return $this.handleReturnKey(e); });
};

DabblePageForm.SearchField.prototype.handleFirstKey = function() {
	if (this.style.color == 'gray') {
		this.style.color = '';
		if (this.value.indexOf('Search for ') === 0) {
			this.value = '';
		}
	}
	$(this).unbind('keydown');
};

DabblePageForm.SearchField.prototype.update = function() {
	var value = this.field.val();
	if (this.requestTimer) {
		window.clearTimeout(this.requestTimer);
	}
	if (this.field.css('color') == 'gray') {
		this.field.css({ color: '' });
	}
	this.results.hideAndDemote();
	if (value == this.hiddenField.val()) return;
	if (value.length > 0) {
		var $this = this;
		this.requestTimer = window.setTimeout(function() { $this.startRequest(value); }, 400);
	}
};

DabblePageForm.SearchField.prototype.startRequest = function(value) {
	var field = this.field.attr('id').slice(1).split("-")[0];
	if (this.request) {
		this.request.abort();
	}
	this.results.empty();
	this.results.append(this.loading.clone());
	this.results.showAndPromote('block');
	var $that = this;
	this.request = $.ajax({
		url: location.protocol + '//' + location.hostname + location.pathname + '/autocomplete/' + field,
		data: { filter: value },
		type: 'GET',
		success: function(data) { $that.processResults(data); }
	});
};

DabblePageForm.SearchField.prototype.processResults = function(t) {
	this.results.empty();
	var list = this.results.append($E('ul'));
	var resultItems = eval(t);
	if (resultItems) {
		var numItems = resultItems.length;
		for (var i = 0; i < numItems; i++) {
			var resultItem = resultItems[i];
			if (resultItem !== false && resultItem !== true) {
				var listItem = this.addResultItem(resultItem[0], resultItem[1]);
				if (i === 0) {
					listItem.addClass('dabblePageAutocompleteHighlightedResult');
				}
			} else if (i === 0 && resultItem === false) {
				this.addResultItem(DabblePageForm.noMatches, '').addClass('dabblePageAutocompleteResultInvalid');
			} else if (resultItem === true) {
				this.addResultItem(DabblePageForm.moreMatches, '').addClass('dabblePageAutocompleteResultInvalid');
			}
		}
	}
	$('.dabblePageFieldSearchResults').hideAndDemote();
	this.results.showAndPromote('block');
	DabblePageForm.fixIESelect(this.results);
};

DabblePageForm.SearchField.prototype.addResultItem = function(text, value) {
	var $this = this;
	var list = this.results.find('ul');
	var listItem = $E('li');
	var link = $E('a').attr({ href: 'javascript:void(0)' }).html(text).appendTo(listItem);
	list.append(listItem);
	value = value.trim(); // trim leading/trailing spaces
	link.click(function() {
		var assignedValue = value ? text : '';
		$this.field.val(assignedValue);
		$this.hiddenField.val(assignedValue);
		$this.hiddenIDField.val(value);
		$this.results.hideAndDemote();
		return false;
	});
	listItem.mouseover(function() { $this.highlightResult(this); });
	return listItem;
};

DabblePageForm.SearchField.prototype.useHighlightedResultIfPossible = function() {
	if (this.results.filter(':visible').length > 0) {
		this.results.find('li.dabblePageAutocompleteHighlightedResult>a').click();
	}
	return false;
};

DabblePageForm.SearchField.prototype.highlightResult = function(element) {
	this.results.find('li.dabblePageAutocompleteHighlightedResult').removeClass('dabblePageAutocompleteHighlightedResult');
	$(element).closest('li').addClass('dabblePageAutocompleteHighlightedResult');
};

DabblePageForm.SearchField.prototype.highlightSiblingResult = function(index) {
	var oldItem = this.results.find('li.dabblePageAutocompleteHighlightedResult');
	if (oldItem.length > 0) {
		var newItem;
		if (index > 0) {
			newItem = oldItem.next('li');
		} else if (index < 0) {
			newItem = oldItem.prev('li');
		}
		if (newItem.length > 0 && !newItem.hasClass('dabblePageAutocompleteResultInvalid')) {
			oldItem.removeClass('dabblePageAutocompleteHighlightedResult');
			newItem.addClass('dabblePageAutocompleteHighlightedResult');
		}
	}
};

DabblePageForm.SearchField.prototype.handleCursorKeys = function(evt) {
	var keyCode = evt.keyCode || evt.which;
	switch(keyCode) {
		case 38: // up arrow
			this.highlightSiblingResult(-1);
			return false;
		case 40: // down arrow
			this.highlightSiblingResult(1);
			return false;
		default:
			return true;
	}
};

DabblePageForm.SearchField.prototype.handleReturnKey = function(evt) {
	var keyCode = evt.keyCode || evt.which;
	switch(keyCode) {
		case 13: // return
			this.useHighlightedResultIfPossible();
			evt.stopPropagation();
			return false;
		default:
			return true;
	}
};

jQuery.fn.extend({
	showAndPromote: function(forceDisplayType) {
		if (forceDisplayType) {
			this.css({ display: forceDisplayType });
		} else {
			this.show();
		}
		this.parent().css({ zIndex: '10' });
		return this;
	},
	
	hideAndDemote: function() {
		this.hide();
		this.parent().css({ zIndex: '' });
		return this;
	},
	
	getNodeName: function() {
		return this[0] && this[0].nodeName.toLowerCase();
	},
	
	toggleDisplay: function() {
		var shown;
		this.each(function() {
			if (!this.offsetHeight) {
				this.style.display = 'block';
				shown = true;
			} else {
				this.style.display = 'none';
				shown = false;
			}
		});
		return shown;
	},
	
	offsetWidth: function() {
		return this[0] ? this[0].offsetWidth : 0;
	},
	
	offsetHeight: function() {
		return this[0] ? this[0].offsetHeight : 0;
	},
	
	scrollWidth: function() {
		return this[0] ? this[0].scrollWidth : 0;	
	},
	
	scrollHeight: function() {
		return this[0] ? this[0].scrollHeight : 0;	
	},
	
	setColspan: function(value) {
		return this.each(function() {
			if (this.colSpan) {
				this.colSpan = value;
			} else {
				this.setAttribute('colspan', value);
			}
		});
	},
	
	isEmpty: function(value) {
		var numElements = this.length;
		return this.filter(':empty').length == numElements;
	}
});

// Element builder with support for classes and IDs using CSS style selectors
function $E(tag, attributes) {
	var tagComponents = tag.match(/([A-Za-z0-9]+)([\.\#]?.*)/);
	var tagName = tagComponents[1];
	var selectors = tagComponents[2];
	var classes = [];
	var id = '';
	if (selectors) {
		classes = selectors.split('.');
		for (var i = classes.length - 1; i >= 0; i--) {
			var possibleIDs = classes[i].match(/(.*)\#(.+)/);
			if (possibleIDs && possibleIDs.length > 1) {
				id = possibleIDs[2];
				classes[i] = possibleIDs[1];
			}
		}
	}
	var element = $(document.createElement(tagName));
	if (classes.length >= 1) {
		element.addClass(classes.join(' '));
	}
	if (id) {
		element.attr('id', id);
	}
	for (a in attributes) {
		element.attr(a, attributes[a]);
	}
	return element;
}

DabbleCalendar = {
	ONEDAY: 86400000, // shorthand for 1 day in milliseconds
	months: ["January","February","March","April","May","June","July","August","September","October","November","December"],
	shortMonths: ["Jan","Feb","Mar","Apr","May","June","July","Aug","Sept","Oct","Nov","Dec"],
	days: ["Su","M","Tu","W","Th","F","Sa"],
	rangeText: "Select a date range",
	helpText: {
		previousMonth: "Previous month",
		thisMonth: "This month",
		nextMonth: "Next month",
		time: "Time:",
		startTime: "Start time:",
		endTime: "End time:",
		help: 'Click above or just type e.g.&nbsp;&ldquo;Today&rdquo; or &ldquo;Now&rdquo;<br /><a href="http://dabbledb.com/help/index/date_and_time_values" target="help">More info</a>'
	},
	selectRangeByDefault: false,
	selectRangeIsOptional: true,
	allowTime: true,
	showHelp: true,
	locale: "american",
	firstDay: 0, // First day of the week; 0 = Sunday
	localeConversions: {
		zeroPad: function(integer) { return (integer < 10) ? "0" + integer : integer; },
		"yyyyMmDd": function(date) { return date.getFullYear() + "-" + this.zeroPad(date.getMonth() + 1) + "-" + this.zeroPad(date.getDate()); },
		"mmDdYy": function(date) { return this.zeroPad(date.getMonth() + 1) + "/" + this.zeroPad(date.getDate()) + "/" + date.getFullYear(); },
		"ddMmYy": function(date) { return this.zeroPad(date.getDate()) + "/" + this.zeroPad(date.getMonth() + 1) + "/" + date.getFullYear(); },
		"mmDdYyyy": function(date) { return this.zeroPad(date.getMonth() + 1) + "/" + this.zeroPad(date.getDate()) + "/" + date.getFullYear(); },
		"ddMmYyyy": function(date) { return this.zeroPad(date.getDate()) + "/" + this.zeroPad(date.getMonth() + 1) + "/" + date.getFullYear(); },
		"british": function(date) { return date.getDate() + " " + DabbleCalendar.months[date.getMonth()] + " " + date.getFullYear(); },
		"britishShort": function(date) { return date.getDate() + " " + DabbleCalendar.shortMonths[date.getMonth()] + " " + date.getFullYear(); },
		"americanShort": function(date) { return DabbleCalendar.shortMonths[date.getMonth()] + " " + date.getDate() + " " + date.getFullYear(); },
		"american": function(date) { return DabbleCalendar.months[date.getMonth()] + " " + date.getDate() + ", " + date.getFullYear(); }
	},
	localeString: function(date) {
		return this.localeConversions[this.locale](date);
	},
	buildMonth: function(monthNumber, yearNumber) {
		var $this = this;
		var printDate = new Date();
		printDate.setDate(1);
		printDate.setMonth(monthNumber);
		printDate.setFullYear(yearNumber);
		printDate.setHours(12,0,0);

// calendar logic for beginning and end of the year
		if (monthNumber == 0) {
			this.previousMonth = 11;
			this.previousYear = yearNumber - 1;
		} else {
			this.previousMonth = monthNumber - 1;
			this.previousYear = yearNumber;		
		}
		if (monthNumber < 11) {
			this.nextMonth = monthNumber + 1;
			this.nextYear = yearNumber;
		} else {
			this.nextMonth = 0;
			this.nextYear = yearNumber + 1;
		}

// build the table
		var table = $E("table.datePickerTable.noClickThrough");
		var thead = $E("thead");
		var navigationRow = $E("tr");
		var titleRow = $E("tr");
		var weekdaysRow = $E("tr");
		var title = $E("th.datePickerTitle", { innerHTML: DabbleCalendar.months[monthNumber] + " " + yearNumber });
		title.setColspan("7");

// previous month link
		var plc = $E("th.datePickerNav.datePickerPreviousMonthLink");
		plc.setColspan("2");
		var pl = $E("a.noClickThrough", { innerHTML: "&laquo;", href: "javascript:void(0)", title: DabbleCalendar.helpText.previousMonth });
		pl.click(function() { $this.buildMonth($this.previousMonth, $this.previousYear); });
		plc.append(pl);

// current month link
		var clc = $E("th.datePickerNav.datePickerCurrentMonthLink");
		clc.setColspan("3");
		var cl = $E("a.noClickThrough", { innerHTML: "&bull;", href: "javascript:void(0)", title: DabbleCalendar.helpText.thisMonth });
		cl.click(function() { $this.buildMonth(DabbleCalendar.now.getMonth(), DabbleCalendar.now.getFullYear()); });
		clc.append(cl);

// next month link
		var nlc = $E("th.datePickerNav.datePickerNextMonthLink");
		nlc.setColspan("2");
		var nl = $E("a.noClickThrough", { innerHTML: "&raquo;", href: "javascript:void(0)", title: DabbleCalendar.helpText.nextMonth });
		nl.click(function() { $this.buildMonth($this.nextMonth, $this.nextYear); });
		nlc.append(nl);
		
// weekdays
		for (var dayToPrint, i = 0; i < 7; i++) {
			dayToPrint = DabbleCalendar.firstDay + i;
			if (dayToPrint > 6) {
				dayToPrint -= 7;
			}
			var day = $E("th.datePickerWeekday", { innerHTML: DabbleCalendar.days[dayToPrint] });
			weekdaysRow.append(day);
		}
		
		navigationRow.append(plc);
		navigationRow.append(clc);
		navigationRow.append(nlc);
		titleRow.append(title);
		thead.append(weekdaysRow);
		weekdaysRow.before(navigationRow);
		weekdaysRow.before(titleRow);
		
		var tbody = $E("tbody");

// Rewind to the first day of the week before the 1st of the month
// Takes into account the firstDay setting
		var numberDaysToRewind = printDate.getDay();
		if (DabbleCalendar.firstDay < numberDaysToRewind) {
			numberDaysToRewind -= DabbleCalendar.firstDay;
		} else if (DabbleCalendar.firstDay > numberDaysToRewind) {
			numberDaysToRewind = 7 - DabbleCalendar.firstDay + numberDaysToRewind;
		} else {
			numberDaysToRewind = 0;
		}

		for (var i = numberDaysToRewind; i > 0; i--) {
			printDate.setTime(printDate.getTime() - DabbleCalendar.ONEDAY);
		}

		var previousMonthValid = (monthNumber > 0) ? monthNumber - 1 : 11;

// Print the days of the month
		while (printDate.getMonth() == monthNumber || printDate.getMonth() == previousMonthValid) {
			var row = $E("tr");
			for (var weekday = 0; weekday < 7; weekday++) {
				var cell = $E("td", { className: "datePickerDay" + ((printDate.getMonth() == monthNumber) ? " datePickerDayThisMonth" : " datePickerDayOtherMonth") });
				if (DabbleCalendar.localeString(DabbleCalendar.now) == DabbleCalendar.localeString(printDate)) {
					cell.addClass("datePickerDayToday");
				}
				if (this.firstDate) {
					if (DabbleCalendar.localeString(this.firstDate) == DabbleCalendar.localeString(printDate)) {
						cell.addClass("datePickerStartRange");
					}
				}
				var link = $E("a#d" + printDate.getTime(), { innerHTML: printDate.getDate(), href: "javascript:void(0)" });
				link.click(function() { DabbleCalendar.setFieldValueOnClick(this, $this); });
				printDate.setTime(printDate.getTime() + DabbleCalendar.ONEDAY);
				cell.append(link);
				row.append(cell);
			}
			tbody.append(row);
		}
		
		var tfoot = $E("tfoot");
		
		if (this.allowTime) {
			var timeRow = tfoot.append($E("tr"));
			var timeCell = $E("th.datePickerTimeBox");
			var idPrefix = this.target.attr('id');
			timeCell.setColspan("7");
			this.startTimeBox = $E("span.datePickerStartTime");
			this.endTimeBox = $E("span.datePickerEndTime");
			if (!this.selectRange) {
				this.endTimeBox.css({ display: 'none' });
			}
			this.startTimeLabel = $E("label", { innerHTML: (this.selectRange ? DabbleCalendar.helpText.startTime : DabbleCalendar.helpText.time) });
			this.endTimeLabel = $E("label", { innerHTML: DabbleCalendar.helpText.endTime + " " });
			var startTime = $E("input.text.formTextInput#" + idPrefix + "StartTime", { type: "text", value: this.startTime });
			var endTime = $E("input.text.formTextInput#" + idPrefix + "EndTime", { type: "text", value: this.endTime });
			this.startTimeLabel.attr("for", startTime.id);
			this.endTimeLabel.attr("for", endTime.id);
			this.startTimeBox.append(this.startTimeLabel);
			this.startTimeBox.append(" ");
			this.startTimeBox.append(startTime);
			this.endTimeBox.append(this.endTimeLabel);
			this.startTimeBox.append(" ");
			this.endTimeBox.append(endTime);
			timeCell.append(this.startTimeBox);
			timeCell.append(this.endTimeBox);
			timeRow.append(timeCell);
			startTime.keyup(function() { $this.startTime = this.value;	});
			endTime.keyup(function() { $this.endTime = this.value; });
			var cancelReturnKey = function(event) {
				event = event || window.event;
				var key = event.keyCode || event.which;
				return (key != 13);
			};
			startTime.onkeypress = cancelReturnKey;
			endTime.onkeypress = cancelReturnKey;
		}

// Show checkbox for selecting ranges (if applicable)
		if (this.selectRangeIsOptional) {
			var footerRow = tfoot.append($E("tr"));
			var footerCell = $E("th.datePickerOptions");
			footerCell.setColspan("7");
			var checkbox = $E("input.checkbox#" + this.field.id + "RangeCheckbox-" + printDate.getFullYear() + printDate.getMonth(), { type: "checkbox" });
			checkbox.click(function() {
				$this.selectRange = checkbox.attr('checked');
				if ($this.selectRange && $this.allowTime) {
					$this.endTimeBox.show();
					$this.startTimeLabel.innerHTML = DabbleCalendar.helpText.startTime;
				} else if (!$this.selectRange && $this.allowTime) {
					$this.endTimeBox.hide();				
					$this.startTimeLabel.innerHTML = DabbleCalendar.helpText.time;
				}
			});
			var label = $E("label", { innerHTML: " " + DabbleCalendar.rangeText });
			label.attr("for", checkbox.attr('id'));
			footerCell.append(checkbox);
			footerCell.append(label);
			footerRow.append(footerCell);
			checkbox.attr('checked', this.selectRange ? 'checked' : '');
		}

// Show help link (if applicable)
		if (DabbleCalendar.showHelp) {
			var helpRow = $E("tr");
			var helpCell = $E("th.datePickerHelp", { innerHTML: DabbleCalendar.helpText.help });
			helpCell.setColspan("7");
			helpRow.append(helpCell);
			tfoot.append(helpRow);
		}

		table.append(thead);
		table.append(tbody);
		table.append(tfoot);
		
		this.target.find('table.datePickerTable').remove();

		this.target.append(table);
		DabblePageForm.fixIESelect(this.target);
	},
	setFieldValueOnClick: function(link, $this) {
		var link = $(link);
		var date = new Date();
		date.setTime(link.attr('id').substr(1)); // copy the date to set from the link's ID
		var startTime = ($this.startTime == "") ? "" : " " + $this.startTime;
		if ($this.selectRange) { // if ranges are enabled, then check whether a start date has been chosen
			var endTime = ($this.endTime == "") ? "" : " " + $this.endTime;
			if (!$this.firstDate) {
				$this.firstDate = date;
				$this.field.val(DabbleCalendar.localeString(date) + startTime + " - ");
				link.addClass("datePickerStartRange");
			} else {
				if ($this.firstDate.getTime() < date.getTime()) {
					$this.field.val(DabbleCalendar.localeString($this.firstDate) + startTime + " - " + DabbleCalendar.localeString(date) + endTime);
				} else {
					$this.field.val(DabbleCalendar.localeString(date) + startTime + " - " + DabbleCalendar.localeString($this.firstDate) + endTime);
				}
				var firstDateLink = $("#d" + $this.firstDate.getTime());
				if (firstDateLink) {
					firstDateLink.removeClass("datePickerStartRange");
				}
				$this.firstDate = null;
				$this.target.hide();
			}
		} else {
			$this.field.val(DabbleCalendar.localeString(date) + startTime);
			$this.target.hide();
		}
	},
	field: null,
	target: null,
	now: new Date(),
	runOnce: false,
	initialize: function() {
		if (this.firstDay > 6 || this.firstDay < 0) {
			this.firstDay = 0;
		}
		if (typeof(DabblePageForm) != 'undefined') { // if we're on a page, don't show help
			this.showHelp = false;
		}
	},
	Create: function(fieldID, calendarBoxID, attributes) {
		if (!this.runOnce) {
			this.initialize();
		}
		var newCalendar = {
			field: $('#' + fieldID),
			target: $('#' + calendarBoxID),
			selectRange: DabbleCalendar.selectRangeByDefault,
			selectRangeIsOptional: DabbleCalendar.selectRangeIsOptional,
			allowTime: DabbleCalendar.allowTime,
			startTime: '',
			endTime: '',
			firstDate: null,
			buildMonth: DabbleCalendar.buildMonth,
			buildTime: DabbleCalendar.buildTime,
			initialized: false
		};
		for (a in attributes) {
			newCalendar[a] = attributes[a];
		}
		if (!newCalendar.field || !newCalendar.target) return null;
		var calendarPopupLink = newCalendar.target.prevAll('a');
		var initializeNewCalendar = function() {
			if (!newCalendar.initialized) {
				newCalendar.buildMonth(DabbleCalendar.now.getMonth(), DabbleCalendar.now.getFullYear());
				newCalendar.initialized = true;
			}
		};
		calendarPopupLink.click(initializeNewCalendar);
		return newCalendar;
	}
};

String.prototype.trim = function() {
	return this.replace(/^\s*|\s*$/g, '');
};

DabblePageForm.Browser.detect();

// Create a console object if undefined to prevent errors from debugging code left in
if (typeof(console) == 'undefined') {
	console = {
		log: function() {},
		dir: function() {}
	};
}

	
	/**
	 * jQuery BASE64 functions
	 * 
	 * 	<code>
	 * 		Encodes the given data with base64. 
	 * 		String $.base64Encode ( String str )
	 *		<br />
	 * 		Decodes a base64 encoded data.
	 * 		String $.base64Decode ( String str )
	 * 	</code>
	 * 
	 * Encodes and Decodes the given data in base64.
	 * This encoding is designed to make binary data survive transport through transport layers that are not 8-bit clean, such as mail bodies.
	 * Base64-encoded data takes about 33% more space than the original data. 
	 * This javascript code is used to encode / decode data using base64 (this encoding is designed to make binary data survive transport through transport layers that are not 8-bit clean). Script is fully compatible with UTF-8 encoding. You can use base64 encoded data as simple encryption mechanism.
	 * If you plan using UTF-8 encoding in your project don't forget to set the page encoding to UTF-8 (Content-Type meta tag). 
	 * This function orginally get from the WebToolkit and rewrite for using as the jQuery plugin.
	 * 
	 * Example
	 * 	Code
	 * 		<code>
	 * 			$.base64Encode("I'm Persian."); 
	 * 		</code>
	 * 	Result
	 * 		<code>
	 * 			"SSdtIFBlcnNpYW4u"
	 * 		</code>
	 * 	Code
	 * 		<code>
	 * 			$.base64Decode("SSdtIFBlcnNpYW4u");
	 * 		</code>
	 * 	Result
	 * 		<code>
	 * 			"I'm Persian."
	 * 		</code>
	 * 
	 * @alias Muhammad Hussein Fattahizadeh < muhammad [AT] semnanweb [DOT] com >
	 * @link http://www.semnanweb.com/jquery-plugin/base64.html
	 * @see http://www.webtoolkit.info/
	 * @license http://www.gnu.org/licenses/gpl.html [GNU General Public License]
	 * @param {jQuery} {base64Encode:function(input))
	 * @param {jQuery} {base64Decode:function(input))
	 * @return string
	 */
	
	(function($){
		
		var keyString = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/=";
		
		var uTF8Encode = function(string) {
			string = string.replace(/\x0d\x0a/g, "\x0a");
			var output = "";
			for (var n = 0; n < string.length; n++) {
				var c = string.charCodeAt(n);
				if (c < 128) {
					output += String.fromCharCode(c);
				} else if ((c > 127) && (c < 2048)) {
					output += String.fromCharCode((c >> 6) | 192);
					output += String.fromCharCode((c & 63) | 128);
				} else {
					output += String.fromCharCode((c >> 12) | 224);
					output += String.fromCharCode(((c >> 6) & 63) | 128);
					output += String.fromCharCode((c & 63) | 128);
				}
			}
			return output;
		};
		
		var uTF8Decode = function(input) {
			var string = "";
			var i = 0;
			var c = c1 = c2 = 0;
			while ( i < input.length ) {
				c = input.charCodeAt(i);
				if (c < 128) {
					string += String.fromCharCode(c);
					i++;
				} else if ((c > 191) && (c < 224)) {
					c2 = input.charCodeAt(i+1);
					string += String.fromCharCode(((c & 31) << 6) | (c2 & 63));
					i += 2;
				} else {
					c2 = input.charCodeAt(i+1);
					c3 = input.charCodeAt(i+2);
					string += String.fromCharCode(((c & 15) << 12) | ((c2 & 63) << 6) | (c3 & 63));
					i += 3;
				}
			}
			return string;
		}
		
		$.extend({
			base64Encode: function(input) {
				var output = "";
				var chr1, chr2, chr3, enc1, enc2, enc3, enc4;
				var i = 0;
				input = uTF8Encode(input);
				while (i < input.length) {
					chr1 = input.charCodeAt(i++);
					chr2 = input.charCodeAt(i++);
					chr3 = input.charCodeAt(i++);
					enc1 = chr1 >> 2;
					enc2 = ((chr1 & 3) << 4) | (chr2 >> 4);
					enc3 = ((chr2 & 15) << 2) | (chr3 >> 6);
					enc4 = chr3 & 63;
					if (isNaN(chr2)) {
						enc3 = enc4 = 64;
					} else if (isNaN(chr3)) {
						enc4 = 64;
					}
					output = output + keyString.charAt(enc1) + keyString.charAt(enc2) + keyString.charAt(enc3) + keyString.charAt(enc4);
				}
				return output;
			},
			base64Decode: function(input) {
				if (!input) input = '';
				var output = "";
				var chr1, chr2, chr3;
				var enc1, enc2, enc3, enc4;
				var i = 0;
				input = input.replace(/[^A-Za-z0-9\+\/\=]/g, "");
				while (i < input.length) {
					enc1 = keyString.indexOf(input.charAt(i++));
					enc2 = keyString.indexOf(input.charAt(i++));
					enc3 = keyString.indexOf(input.charAt(i++));
					enc4 = keyString.indexOf(input.charAt(i++));
					chr1 = (enc1 << 2) | (enc2 >> 4);
					chr2 = ((enc2 & 15) << 4) | (enc3 >> 2);
					chr3 = ((enc3 & 3) << 6) | enc4;
					output = output + String.fromCharCode(chr1);
					if (enc3 != 64) {
						output = output + String.fromCharCode(chr2);
					}
					if (enc4 != 64) {
						output = output + String.fromCharCode(chr3);
					}
				}
				output = uTF8Decode(output);
				return output;
			}
		});
	})(jQuery);

$(function() { DabblePageForm.init(); });
