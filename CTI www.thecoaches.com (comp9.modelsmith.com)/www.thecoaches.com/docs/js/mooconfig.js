

	var accordionClicks;
	var accordionContents;
	var accordion1;
	var accordion2;
	
    window.onload = function() {
		// example 1
		accordionClicks = document.getElementsByClassName('accordion-click1');
		accordionContents = document.getElementsByClassName('accordion-content1');

		accordion1 = new fx.Accordion(accordionClicks, accordionContents);
		
		accordionClicks = document.getElementsByClassName('accordion-click2');
		accordionContents = document.getElementsByClassName('accordion-content2');

		accordion2 = new fx.Accordion(accordionClicks, accordionContents, {width: true, height:true});
        accordion2.showThisHideOpen(accordionContents[0]);

    }
