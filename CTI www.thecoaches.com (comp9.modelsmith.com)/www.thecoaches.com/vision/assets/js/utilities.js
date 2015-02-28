// Place any jQuery/helper plugins in here.

$(document).ready(function() {

    // TABS
	$('#tabs div').hide();
	$('#tabs div#tab-1').show();
	$('#tabs ul li:nth-child(1)').addClass('active');
	$('#tabs ul li a').click(function(e){ 
		$('#tabs ul li').removeClass('active');
		$(this).parent().addClass('active'); 
		var currentTab = $(this).attr('href'); 
		$('#tabs div').hide();
		$(currentTab).show();
		e.preventDefault();
	});

	$('#tabs-1 div').hide();
	$('#tabs-1 div#tab-4').show();
	$('#tabs-1 ul li:nth-child(1)').addClass('active');
	$('#tabs-1 ul li a').click(function(e){ 
		$('#tabs-1 ul li').removeClass('active');
		$(this).parent().addClass('active'); 
		var currentTab = $(this).attr('href'); 
		$('#tabs-1 div').hide();
		$(currentTab).show();
		e.preventDefault();
	});

	$('#tabs-2 div').hide();
	$('#tabs-2 div#tab-7').show();
	$('#tabs-2 ul li:nth-child(1)').addClass('active');
	$('#tabs-2 ul li a').click(function(e){ 
		$('#tabs-2 ul li').removeClass('active');
		$(this).parent().addClass('active'); 
		var currentTab = $(this).attr('href'); 
		$('#tabs-2 div').hide();
		$(currentTab).show();
		e.preventDefault();
	});

	$('#tabs-3 div').hide();
	$('#tabs-3 div#tab-10').show();
	$('#tabs-3 ul li:nth-child(1)').addClass('active');
	$('#tabs-3 ul li a').click(function(e){ 
		$('#tabs-3 ul li').removeClass('active');
		$(this).parent().addClass('active'); 
		var currentTab = $(this).attr('href'); 
		$('#tabs-3 div').hide();
		$(currentTab).show();
		e.preventDefault();
	});

    
/*
NOTE: I was requested by Henry, Sabrina and Kevin to change the Fable so that 
viewers could just read the fable and listen to the audio without having to 
perform the homework. In order to make these changes minimal, I did the following:
1) Turned on all status cookies (below) so that the Fable would think that the
homeworks have all been submitted
2) Commented the removeClass/addClass functions for the tabs (see below)
3) Added style="display:none" to the Fable/Homework tabs in Expression Engine
4) Added style="display:none" to the homework links in the middle of the pages

T. Beutel 1/29/2014
*/

$.cookie('statusone', 'submitted', { expires: 365, path: '/' });
$.cookie('statustwo', 'submitted', { expires: 365, path: '/' });
$.cookie('statusthree', 'submitted', { expires: 365, path: '/' });
$.cookie('statusfour', 'submitted', { expires: 365, path: '/' });

    // check cookie homework one
    var statusone = $.cookie("statusone")

    if (statusone != null) {
        $(".homework.one span.form,.homework.one span.answers").addClass('submitted');
	    $(".comments.one p,.comments.one div.fb-comments").addClass('submitted');
		$("#two").removeClass('unsubmitted');
	/*	$('#tabs ul li').removeClass('active');
		$('#tabs ul li.homework-1').addClass('active');
		$('#tabs #tab-1').css('display', 'none');
		$('#tabs #tab-2').css('display', 'block'); */
	}

    // set cookie
    $(".homework.one #new_submission").submit(function(e) {
        if($(this).valid()) {
        	var email = $('.required').val();
			var textarea = $('.required').val();
			$.cookie('statusone', 'submitted', { expires: 365, path: '/' });
        	$(".homework.one span.form,.homework.one span.answers").addClass('submitted');
    	    $(".comments.one p,.comments.one div.fb-comments").addClass('submitted');
    		$("#two").removeClass('unsubmitted');
    	    $('#overlay').css('height', $(document.body).height() + 'px')
		    $('#overlay').show()
		    // $('#dialog').html($(element).html())
		    centerMe('#dialog')
		    scroll(0, 0);
    		//	return false;
    	} else {
    		$("html, body").animate({ scrollTop: 0 }, "fast");
	    	$('.required').focus().addClass('focus');
	    	e.preventDefault();
    	}
    });
    // check cookie homework two
    var statustwo = $.cookie("statustwo")

    if (statustwo != null) {
        $(".homework.two span.form,.homework.two span.answers").addClass('submitted');
	    $(".comments.two p,.comments.two div.fb-comments").addClass('submitted');
		$("#three").removeClass('unsubmitted');
	/*	$('#tabs-1 ul li').removeClass('active');
		$('#tabs-1 ul li.homework-2').addClass('active');
		$('#tabs-1 #tab-4').css('display', 'none');
		$('#tabs-1 #tab-5').css('display', 'block'); */
	}

    // set cookie
    $(".homework.two #new_submission").submit(function(e){
        if($(this).valid()) {
   			$.cookie('statustwo', 'submitted', { expires: 365, path: '/' });
        	$(".homework.two span.form,.homework.two span.answers").addClass('submitted');
    	    $(".comments.two p,.comments.two div.fb-comments").addClass('submitted');
    		$("#three").removeClass('unsubmitted');
    		$('#overlay').css('height', $(document.body).height() + 'px')
		    $('#overlay').show()
		    // $('#dialog').html($(element).html())
		    centerMe('#dialog')
		    scroll(0, 0);
    		//	return false;
    	} else {
    		$("html, body").animate({ scrollTop: 0 }, "fast");
    		$('.required').focus().addClass('focus');
	    	e.preventDefault();
    	}
    });
    // check cookie homework three
    var statusthree = $.cookie("statusthree")

    if (statusthree != null) {
        $(".homework.three span.form,.homework.three span.answers").addClass('submitted');
	    $(".comments.three p,.comments.three div.fb-comments").addClass('submitted');
	    $("#four").removeClass('unsubmitted');
	/*	$('#tabs-2 ul li').removeClass('active');
		$('#tabs-2 ul li.homework-3').addClass('active');
		$('#tabs-2 #tab-7').css('display', 'none');
		$('#tabs-2 #tab-8').css('display', 'block'); */
	}

    // set cookie
    $(".homework.three #new_submission").submit(function(e){
    	if($(this).valid()) {
       		$.cookie('statusthree', 'submitted', { expires: 365, path: '/' });
        	$(".homework.three span.form,.homework.three span.answers").addClass('submitted');
    	    $(".comments.three p,.comments.three div.fb-comments").addClass('submitted');
    	    $("#four").removeClass('unsubmitted');
    	    $('#overlay').css('height', $(document.body).height() + 'px')
		    $('#overlay').show()
		    // $('#dialog').html($(element).html())
		    centerMe('#dialog')
		    scroll(0, 0);
			//	return false;
    	} else {
    		$("html, body").animate({ scrollTop: 0 }, "fast");
    		$('.required').focus().addClass('focus');
	    	e.preventDefault();
    	}
    });
    // check cookie homework four
    var statusfour = $.cookie("statusfour")

    if (statusfour != null) {
        $(".homework.four span.form,.homework.four span.answers").addClass('submitted');
	    $(".comments.four p,.comments.four div.fb-comments").addClass('submitted');
	/*	$('#tabs-3 ul li').removeClass('active');
		$('#tabs-3 ul li.homework-4').addClass('active');
		$('#tabs-3 #tab-10').css('display', 'none');
		$('#tabs-3 #tab-11').css('display', 'block'); */
	}

    // set cookie
    $(".homework.four #new_submission").submit(function(e){
    	if($(this).valid()) {
       		$.cookie('statusfour', 'submitted', { expires: 365, path: '/' });
        	$(".homework.four span.form,.homework.four span.answers").addClass('submitted');
    	    $(".comments.four p,.comments.four div.fb-comments").addClass('submitted');
    	    $('#overlay').css('height', $(document.body).height() + 'px')
		    $('#overlay').show()
		    // $('#dialog').html($(element).html())
		    centerMe('#dialog')
		    scroll(0, 0);
			//	return false;
    	} else {
    		$("html, body").animate({ scrollTop: 0 }, "fast");
    		$('.required').focus().addClass('focus');
	    	e.preventDefault();
    	}
    });
	
	
	
	
	
	
	$(".homeworkLink a").mouseup(function(){
    	$("#tabs div").hide();
    	$("#tabs div#tab-2").show();
    	$("#tabs ul li").removeClass('active');
		$("#tabs ul li:nth-child(2)").addClass('active'); 
	});

	$(".homeworkLink-1 a").mouseup(function(){
    	$("#tabs-1 div").hide();
    	$("#tabs-1 div#tab-5").show();
    	$("#tabs-1 ul li").removeClass('active');
		$("#tabs-1 ul li:nth-child(2)").addClass('active'); 
	});

	$(".homeworkLink-2 a").mouseup(function(){
    	$("#tabs-2 div").hide();
    	$("#tabs-2 div#tab-8").show();
    	$("#tabs-2 ul li").removeClass('active');
		$("#tabs-2 ul li:nth-child(2)").addClass('active'); 
	});

	$(".homeworkLink-3 a").mouseup(function(){
    	$("#tabs-3 div").hide();
    	$("#tabs-3 div#tab-11").show();
    	$("#tabs-3 ul li").removeClass('active');
		$("#tabs-3 ul li:nth-child(2)").addClass('active'); 
	});
	
	$(".unsubmitted").detach();
	
	function preload(arrayOfImages) {
	    $(arrayOfImages).each(function(){
	        $('<img/>')[0].src = this;
	        // Alternatively you could use:
	        // (new Image()).src = this;
	    });
	}
	
	// Usage:
	
	preload([
	    'http://www.thecoaches.com/vision/assets/img/uploading.gif',
	    'http://www.thecoaches.com/vision/assets/img/bg_page.jpg',
	    'http://www.thecoaches.com/vision/assets/img/img_book_cover.jpg',
	    'http://www.thecoaches.com/vision/assets/img/img_book_open.jpg',
	    'http://www.thecoaches.com/vision/assets/img/img_book_disorienting-alt2.jpg',
	    'http://www.thecoaches.com/vision/assets/img/img_book_struggle-alt2.jpg',
	    'http://www.thecoaches.com/vision/assets/img/img_book_discovery-alt2.jpg',
	    'http://www.thecoaches.com/vision/assets/img/img_book_new-world-alt2.jpg'
	]);
	
});
