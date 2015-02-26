<script language="JavaScript1.2">

var howOften = 5; //number often in seconds to rotate
var current = 0; //start the counter at 0
var ns6 = document.getElementById&&!document.all; //detect netscape 6

// place your images, text, etc in the array elements here
var items = new Array();
    items[0]="<a href='link.htm' ><img alt='image0 (9K)' src='/Images/image0.jpg' height='300' width='300' border='0' /></a>"; //a linked image
    items[1]="<a href='link.htm'><img alt='image1 (9K)' src='/Images/image1.jpg' height='300' width='300' border='0' /></a>"; //a linked image
    items[2]="<a href='link.htm'><img alt='image2 (9K)' src='/Images/image2.jpg' height='300' width='300' border='0' /></a>"; //a linked image
   items[3]="<a href='link.htm'><img alt='image3 (9K)' src='/Images/image3.jpg' height='300' width='300' border='0' /></a>"; //a linked image
    items[4]="<a href='link.htm'><img alt='image4 (9K)' src='/Images/image4.jpg' height='300' width='300' border='0' /></a>"; //a linked image
    items[5]="<a href='link.htm'><img alt='image5 (18K)' src='/Images/image5.jpg' height='300' width='300' border='0' /></a>"; //a linked image
function rotater() {
    document.getElementById("placeholder").innerHTML = items[current];
    current = (current==items.length-1) ? 0 : current + 1;
    setTimeout("rotater()",howOften*1000);
}

function rotater() {
    if(document.layers) {
        document.placeholderlayer.document.write(items[current]);
        document.placeholderlayer.document.close();
    }
    if(ns6)document.getElementById("placeholderdiv").innerHTML=items[current]
        if(document.all)
            placeholderdiv.innerHTML=items[current];

    current = (current==items.length-1) ? 0 : current + 1; //increment or reset
    setTimeout("rotater()",howOften*1000);
}
window.onload=rotater;
//-->
</script>