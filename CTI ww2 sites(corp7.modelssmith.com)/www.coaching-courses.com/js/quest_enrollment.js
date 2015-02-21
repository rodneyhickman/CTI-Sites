/* for /Quest/enrollment.html */

$(document).ready( function() {

    //alert('loaded');

    $('#step2').hide();
    $('#step3').hide();
    $('#step4').hide();

    $('.times').hide();
 
    $('#op1').change( function() {
        //alert($('#op1').attr('value'));
        if($(this).attr('value') == 'May 16-18, 2008 - Chicago'){
          $('.times').hide();
          $('#step2').show();
          $('#step3').show();
          $('#chicago_may').show();
        }

        if($(this).attr('value') == 'June 6-8, 2008 - Toronto'){
          $('.times').hide();
          $('#step2').show();
          $('#step3').show();
          $('#toronto_june').show();
        }

        if($(this).attr('value') == 'September 12-14, 2008 - San Francisco'){
          $('.times').hide();
          $('#step2').show();
          $('#step3').show();
          $('#sf_sept').show();
        }

        if($(this).attr('value') == 'October 17-19, 2008 - Boston'){
          $('.times').hide();
          $('#step2').show();
          $('#step3').show();
          $('#boston_oct').show();
        }
        if($(this).attr('value') == '----'){
          $('#step2').hide();
          $('#step3').hide();
        }

      });

    $('#op2').change( function(){ checkChoices() } );
    $('#op3').change( function(){ checkChoices() } );
    $('#op4').change( function(){ checkChoices() } );

});

function checkChoices() {
  if(   $('#op2').attr('value') != '----'
     && $('#op3').attr('value') != '----'
     && $('#op4').attr('value') != '----' ){
            $('#step4').show();
     } else {
            $('#step4').hide();
     }
}
