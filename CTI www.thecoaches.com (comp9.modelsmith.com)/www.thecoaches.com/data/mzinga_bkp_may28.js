


function getElementsByClassName(node,classname) {

  if (node.getElementsByClassName) { // use native implementation if available

    return node.getElementsByClassName(classname);

  } else {

    return (function getElementsByClass(searchClass,node) {

        if ( node == null )

          node = document;

        var classElements = [],

            els = node.getElementsByTagName("*"),

            elsLen = els.length,

            pattern = new RegExp("(^|\\s)"+searchClass+"(\\s|$)"), i, j;



        for (i = 0, j = 0; i < elsLen; i++) {

          if ( pattern.test(els[i].className) ) {

              classElements[j] = els[i];

              j++;

          }

        }

        return classElements;

    })(classname, node);

  }

}



function hideAssessment() {

    var bodyDataText = getElementsByClassName(document,'body-dataText');

    n = bodyDataText.length;

    for (var i = 0; i < n; i++) {

        var e = bodyDataText[i];

        e.style.display='none';

    }

    var data = getElementsByClassName(document,'data');

    n = data.length;

    for (var i = 0; i < n; i++) {

        var e = data[i];

        e.style.display='none';

    }

}



function insertAfter(referenceNode, newNode) {

    referenceNode.parentNode.insertBefore(newNode, referenceNode.nextSibling);

}





    window.console && console.log('mzinga.js version 1.4');



window.onload = function () {

if(document.URL=='http://login.mycoactive.com/exp/cert_tr/app/servlet/navigation')
{
	var el = document.getElementsByTagName("h1")[0],
	text = "textContent" in el ? "textContent" : "innerText"; 
	if(el[text]==' ' || el[text]=='')
	{
			el.style.display = 'none';
	}
}
if(document.URL=='http://login.mycoactive.com/exp/cert_tr/app/testtaker/StartTest.jsp')
{
	var el = document.getElementsByTagName("h1")[0],
	text = "textContent" in el ? "textContent" : "innerText"; 
	if(el[text]==' ' || el[text]=='')
	{
			el.style.display = 'none';
	}
}
/* var el = document.getElementsByTagName("h1");
text = "textContent" in el ? "textContent" : "innerText"; 
if(el[text]==' ' || el[text]=='')
{
		el.style.display = 'none';
}
  */
 
    var trackerTitle = 0;



    var detailsDiv = document.getElementById("detailsDiv")

    if(detailsDiv) detailsDiv.style.display='none';



    var osDetails1 = getElementsByClassName(document,'os-detail-list');

    if(osDetails1 && osDetails1.length > 0){

        osDetails = osDetails1[0].getElementsByTagName('li');

        var n = osDetails.length;

        for (var i = 0; i < n; i++) {

            var e = osDetails[i];

            if(e.innerHTML.match(/Price:/)){

                e.style.display='none';

            }

            else if(e.innerHTML.match(/(Tracker:|Feedback Survey\.|Program Review:|Homework for)/)){

                trackerTitle = 1;

                var str = e.innerHTML;

                e.innerHTML = str.replace(/Description: ?/i,"");

            }

        }

    }



    window.console && window.console.log('checking page-titleText');

    var titleText = getElementsByClassName(document,'page-titleText');

    n = titleText.length;

    for (var i = 0; i < n; i++) {

        var e = titleText[i];

        window.console && window.console.log('page-titleText: '+e.innerHTML);

        if(e.innerHTML.match(/Homework Journal/i)){

            var startOverElements = getElementsByClassName(document, 'os-btn');

            for(var j=0; j<startOverElements.length; j++){

                var startOverBtn = startOverElements[j];

                if(startOverBtn.innerHTML.match(/Start Over/i)){

                    startOverBtn.style.display='none';

                }

            }

            var bodyDataTexts = getElementsByClassName(document, 'body-dataText');

             for(var j=0; j<bodyDataTexts.length; j++){

                var bodyDataText = bodyDataTexts[j];

                if(bodyDataText.innerHTML.match(/Click "Start"/i)){

                    var str = bodyDataText.innerHTML;

                    bodyDataText.innerHTML = str.replace(/Click "Start"/,'Click "Start" or "Continue"');

                }

                if(bodyDataText.innerHTML.match(/You have already started/i)){

					bodyDataText.style.display='none';

                }

            }

            var pageSubtitleTexts = getElementsByClassName(document, 'page-subTitleText');

             for(var j=0; j<pageSubtitleTexts.length; j++){

                var pageSubtitleText = pageSubtitleTexts[j];

                if(pageSubtitleText.innerHTML.match(/Completing/i)){

					pageSubtitleText.style.display='none';

                }

            }

        }



		if (e.innerHTML.match(/Relaciones empoderadas/i)) {

			e.innerHTML = "Diario de Tarea";

			

			var logo = getElementsByClassName(document, 'os-headless');

			if (logo.length > 0) {

				logo[0].style.display = 'none';

			}

			var pageSubtitleTexts = getElementsByClassName(document, 'page-subTitleText');

            for(var j=0; j<pageSubtitleTexts.length; j++){

                var pageSubtitleText = pageSubtitleTexts[j];

                if(pageSubtitleText.innerHTML.match(/Realizar el sondeo/i)){

					pageSubtitleText.style.display='none';

                }

                if(pageSubtitleText.innerHTML.match(/Salir del sondeo/i)){

					pageSubtitleText.style.display='none';

                }

            }



            var bodyDataTexts = getElementsByClassName(document, 'body-dataText');

            for(var j=0; j<bodyDataTexts.length; j++){

                var bodyDataText = bodyDataTexts[j];

                if(bodyDataText.innerHTML.match(/Existen dos formas de salir del sondeo/i)){

					bodyDataText.style.display='none';

                }

                if(bodyDataText.innerHTML.match(/Conteste a las distintas preguntas/i)){

					bodyDataText.style.display='none';

                }

				

            }

		}

        var str = e.innerHTML;

        e.innerHTML = str.replace(/(\#01.*Relationships.*|Completion|#13.*|#06.*):/i,"");

        str = e.innerHTML;

        e.innerHTML = str.replace(/Mid-Program Review/,"<h2>Mid-Program Review</h2>");



    }

    

    titleText = getElementsByClassName(document,'os-left');

    n = titleText.length;

    for (var i = 0; i < n; i++) {

        var e = titleText[i];

        var str = e.innerHTML;

        e.innerHTML = str.replace(/#06A /i,"");

        var str = e.innerHTML;

        e.innerHTML = str.replace(/Results/i,"Progress");

    }

    



    if(trackerTitle == 1){

        var osLeft = getElementsByClassName(document,'os-left');

        if(osLeft.length > 1){

            var e = osLeft[1];

            e.style.display='none';

        }

    }



    var homeworkResults = 0;

    var headingText = getElementsByClassName(document,'HEADING');

    n = headingText.length;

    for (var i = 0; i < n; i++) {

        var e = headingText[i];

        var str = e.innerHTML;

		if (e.innerHTML.match(/Nombre del sondeo/i)) {

			e.innerHTML = "Diario de Tarea";

			var logo = getElementsByClassName(document, 'os-headless');

			if (logo.length > 0) {

				logo[0].style.display = 'none';

			}

			break;

		}

        e.innerHTML = str.replace(/((Name)?: #01 Empowered Relationships.*:|Name: #(06|13).*:|Name:.*Completion:|Name:.*Learning:)/i,"");

        str = e.innerHTML;

        e.innerHTML = str.replace(/>:/,">");

        if(e.innerHTML.match(/Name:\s+Homework/)){

            homeworkResults = 1;

        }

        str = e.innerHTML;

        e.innerHTML = str.replace(/Name:\s+Homework/,"Homework");

        if(e.innerHTML.match(/Coaching Hours Tracker/i)){

            hideAssessment();

        }

    }



    var osMain = getElementsByClassName(document,'os-main');

    if(osMain && osMain.length > 0){

    var h2Text = osMain[0].getElementsByTagName('h3');

    n = h2Text.length;

    for (var i = 0; i < n; i++) {

        var e = h2Text[i];

        str = e.innerHTML;

        e.innerHTML = str.replace(/:/,"");

        e.style.fontSize = "20px";

        if(homeworkResults == 0 && e.innerHTML.match(/(Homework Journal|Feedback Survey)/i)){

            window.console && window.console.log(e.innerHTML);

            var hrNode = document.createElement('hr');

            insertAfter(e, hrNode);

            var txtNode = document.createTextNode('Click "Save and Leave Unfinished" at the bottom of this page when you complete your answers. Your answers will be saved and available the next time you visit. Do not click "Finish" until you have completed all questions.'); 

            var pNode = document.createElement('p');

            pNode.appendChild(txtNode);

            insertAfter(e, pNode);

            break;

        }

    }

    h2Text = osMain[0].getElementsByTagName('h2');

    n = h2Text.length;

    for (var i = 0; i < n; i++) {

        var e = h2Text[i];

        e.style.fontSize = "20px";

        if(e.innerHTML.match(/Completion Tracker/i)){

            window.console && window.console.log(e.innerHTML);

            var hrNode = document.createElement('hr');

            insertAfter(e, hrNode);

            var txtNode = document.createTextNode('Click "Save and Leave Unfinished" at the bottom of this page when you complete your answers. Your answers will be saved and available the next time you visit. Do not click "Finish" until you have completed all questions.');

            var pNode = document.createElement('p');

            pNode.appendChild(txtNode);

            //insertAfter(e, pNode);

            break;

        }

    }

    }



    var resultString = getElementsByClassName(document,'resultString');

    n = resultString.length;

	

    for (var i = 0; i < n; i++) {

        var e = resultString[i];

        var str = e.innerHTML;

        e.innerHTML = str.replace(/#06A /i,"");

    }



//Ticket #660 - Coding starts 

//*********************************

//Hiding the 3 rd column (Date) and the 5th column (Registered)



var todolisttable = document.getElementById("todolisttable");

var trTags = todolisttable.getElementsByTagName("tr");

n = trTags.length;

for (var i=0; i< n; i++) {

    var tdTags = trTags[i].getElementsByTagName("td");

    if (tdTags.length > 0) {

        tdTags[2].style.display = "none";  // 3rd column (Date)

        tdTags[4].style.display = "none";  // 5th column (Registered)

    }

}


//TICKET #806 STARTs


 
    var resultString = getElementsByClassName(document,'resultString');

    n = resultString.length; 

    for (var i = 0; i < n; i++) {

        var e = resultString[i];

        var str = e.innerHTML;

        e.innerHTML = str.replace(/Modül #06a: /i,"");
		
    } 
	
	var resultString = getElementsByClassName(document,'resultString');

    n = resultString.length; 

    for (var i = 0; i < n; i++) {

        var e = resultString[i];

        var str = e.innerHTML; 
			e.innerHTML = str.replace(/Modül #13: Tamamlama \(\hafta 25\): /i,"");
		 
    }
	
	
	 var resultString = getElementsByClassName(document,'resultString');
 
     n = resultString.length; 
 
     for (var i = 0; i < n; i++) {
 
         var e = resultString[i];
 		
         var str = e.innerHTML;		 
 			 e.innerHTML = str.replace(/Modül #01: Güçlü İlişkiler \(\hafta 1 &amp; 2\):/i,""); 
 		 
     }
	
 

//TICKET # 806 Ends


//Ticket #660 - Coding ends

//********************************* 

	//Ticket 471 - Work starts 

	//*********************************

	

    var resultString = getElementsByClassName(document,'resultString');

    n = resultString.length;

	

    for (var i = 0; i < n; i++) {

        var e = resultString[i];

        var str = e.innerHTML;

		if (e.innerHTML.match(/Module 06A /i)) {

			e.innerHTML = str.replace(/Module 06A : /i,"");

			break;

		}

    }

	

    var resultString = getElementsByClassName(document,'resultString');

    n = resultString.length;

    for (var i = 0; i < n; i++) {

        var e = resultString[i].getElementsByTagName("a");

		if (e.length <= 0) {

			continue;

		} else {

			e = e[0];

		}

        var str = e.innerHTML;

		//window.console && window.console.log("e.innerHTML = " + e.innerHTML);

		if (str.match(/Check-List de/i)) {

			//window.console && window.console.log("Matched...Module 13 : Clôture (semaine 25):  Check-List de Clôture");

			e.innerHTML = "Check-List de";

			//window.console && window.console.log("Replaced..." + str);

		} else if (str.match(/Evaluation Finale/i)) {

			//window.console && window.console.log("Matched...Module 13 : Clôture (semaine 25):  Evaluation Finale");

			e.innerHTML = "Evaluation Finale";

			//window.console && window.console.log("Replaced..." + str);

		} else if (str.match(/Journal d’Approfondissement de l’Apprentissage/i)) {

			//window.console && window.console.log("Matched...Module 01 : Le Pouvoir de la Relation (semaines 1 &amp; 2):  Journal d’Approfondissement de l’Apprentissage");

			e.innerHTML = "Journal d’Approfondissement de l’Apprentissage";

			//window.console && window.console.log("Replaced..." + str);

		} else if (str.match(/Diario de tarea/i)) {

			e.innerHTML = "Diario de tarea";

		}

		

    }

	

    // var resultString = getElementsByClassName(document,'resultString');

    // n = resultString.length;

    // for (var i = 0; i < n; i++) {

        // var e = resultString[i];

        // var str = e.innerHTML;

		// if (e.innerHTML.match(/MODULE 01 /i)) {

			// e.innerHTML = str.replace(/MODULE 01 : LE POUVOIR DE LA RELATION (SEMAINES 1 & 2): /i,"");

		// }

    // }



	var osdetailtype = getElementsByClassName(document, "os-detail-type");

	if (osdetailtype) {

		for (var i = 0; i < osdetailtype.length; i++) {

			if (osdetailtype[i].innerHTML.match(/Prix/i)) {

				osdetailtype[i].parentNode.style.display='none';

				break;

			} else if (osdetailtype[i].innerHTML.match(/Precio/i)) {

				osdetailtype[i].parentNode.style.display='none';

				break;

			} else if (osdetailtype[i].innerHTML.match(/Descripción del sondeo/i)) {

				osdetailtype[i].style.display='none';

			}

		}

	}



	var title_str = document.title;

	if (title_str && title_str.match(/Informations sur le cours/i)) {

		title_str = title_str.substring(28);

		document.title = title_str;

	} else if (title_str && title_str.match(/Información del curso/i)) {

		title_str = title_str.substring(23);

		document.title = title_str;

	}

	

	if (title_str && title_str.match(/Module 06A/i)) {

		title_str = title_str.substring(13);

		document.title = title_str;

	}

	

    var h1tags = osMain[0].getElementsByTagName('h1');

    n = h1tags.length;

    for (var i = 0; i < n; i++) {

        var e = h1tags[i];

        if(e.innerHTML.match(/Informations sur le cours/i)){

			e.innerHTML = e.innerHTML.substring(33);

			if(e.innerHTML.match(/Module 06A/i)){

				e.innerHTML = e.innerHTML.substring(13);

			}

            break;

        } else if (e.innerHTML.match(/Información del curso/i)){

			e.innerHTML = e.innerHTML.substring(22);

			break;

		}

    }

	

	var menutext = getElementsByClassName(document, "menutext");

	if (menutext) {

		for (var i=0; i<menutext.length; i++) {

			menutext[i].style.display = 'none';

		}

	}

	

	var osTodolistAssessment = getElementsByClassName(document, "os-todolist-Assessment");

	if (osTodolistAssessment) {

		//window.console && window.console.log("if osTodolistAssessment");

		var osTodolistAssessment_copy = [];

		for (var i=0; i<osTodolistAssessment.length; i++) {

			osTodolistAssessment_copy[i] = osTodolistAssessment[i];

			//window.console && window.console.log("removing osTodolistAssessment[" + i + "]");

		}

		var osTodolistCourse = getElementsByClassName(document, "os-todolist-Course");

		if (osTodolistCourse) {

			//window.console && window.console.log("if osTodolistCourse");

			for (var i=osTodolistAssessment_copy.length-1; i>=0; i--) {

				//window.console && window.console.log("adding osTodolistAssessment_copy[" + i + "]");

				insertAfter(osTodolistCourse[osTodolistCourse.length-1], osTodolistAssessment_copy[i]);

			}

		}

	}

	

	var headingElements = getElementsByClassName(document, "table-headingText");

	if (headingElements) {

		for (var i = 0; i < headingElements.length; i++) {

			//window.console && window.console.log("headingElements[i].innerHTML = " + headingElements[i].innerHTML);

			if (headingElements[i].innerHTML == "" || headingElements[i].innerHTML.match(/TITRE/i)) {

				//window.console && window.console.log("Titre matched,k continuing");

				continue;

			}

			//window.console && window.console.log("display = none");

			headingElements[i].style.display='none';

		}

	}

	

	//*********************************

	//Ticket 471 - Work ends. 

}