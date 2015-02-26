var howOften = 2; //number often in seconds to rotate
var current = 0; //start the counter at 0

// place your images, text, etc in the array elements here
var items = new Array();

items[0]="<img alt='image0' src='http://login.mycoactive.com/zzippu00002z/images/leadership-leopard-1.png' height='150' width='290' border='0' />"; 
items[1]="<img alt='image1' src='http://login.mycoactive.com/zzippu00002z/images/leadership-leopard-2.png' height='150' width='290' border='0' />"; 
items[2]="<img alt='image2' src='http://login.mycoactive.com/zzippu00002z/images/leadership-leopard-3.png' height='150' width='290' border='0' />"; 
items[2]="<img alt='image3' src='http://login.mycoactive.com/zzippu00002z/images/leadership-leopard-4.png' height='150' width='290' border='0' />"; 

function rotater() {
    document.getElementById("ext-gen33").innerHTML = items[current];
    current = (current==items.length-1) ? 0 : current + 1;
    setTimeout("rotater()",howOften*1000);
}

window.onload=rotater;