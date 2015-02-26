var path = myArray[1] ? myArray[1] : myArray[3];
var url  = myArray[1] ? myArray[2] : myArray[3];
$("div.head a[href!="+url+"]").children().hover(
  function () {
    $(this).css('opacity','1');
  },
  function () {
    $(this).css('opacity','0.5');
  }
);
