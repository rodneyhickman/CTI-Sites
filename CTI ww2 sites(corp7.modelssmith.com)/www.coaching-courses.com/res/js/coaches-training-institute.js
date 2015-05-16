// GLOBAL JS UTILITIES

function insert_social_bookmarking() {
	document.write('<scr'+'ipt type="text/javascript">var addthis_pub="rnadworny"; var addthis_options = "email, favorites, twitter, digg, delicious, myspace, google, facebook, reddit, live, more,;"</scr'+'ipt>');
	document.write('<a href="http://www.addthis.com/bookmark.php?v=20" onmouseover="return addthis_open(this, \'\', \'[URL]\', \'[TITLE]\')" onmouseout="addthis_close()" onclick="return addthis_sendto()"><img src="http://s7.addthis.com/static/btn/lg-share-en.gif" width="125" height="16" alt="Bookmark and Share" style="border:0"/></a>');
	document.write('<scr'+'ipt type="text/javascript" src="http://s7.addthis.com/js/200/addthis_widget.js"></scr'+'ipt>');
}

function out_collapselink() {
		document.write('<a name="collapse-link" class="hidestuff">collapse</a>');
}

function out_ecbiolink(id) {
		document.write('<a id="'+id+'" name="collapse-link" class="showstuff">Expand/Collapse <abbr title="Biographic">Bio</abbr> Details</a>');
}

function out_stuffvis() {
		document.write('<style type="text/css">.stuff {visibility: hidden; margin-bottom: 25px;}</style>');
}


function pricepop(content) {
	window.open( content, "pricepop", 
	"status = 1, scrollbars=1, height = 300, width = 700, resizable = 1" )
}
