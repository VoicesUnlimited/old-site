/*** SET BUTTON'S FOLDER HERE ***/

var buttonFolder = "buttons/";



/*** SET BUTTONS' FILENAMES HERE ***/

upSources = ["button1up.png","button2up.png","button3up.png","button4up.png","button5up.png","button6up.png"];



overSources = ["button1over.png","button2over.png","button3over.png","button4over.png","button5over.png","button6over.png"];



// SUB MENUS DECLARATION, Set sub menus text links and targets here

subInfo = [
    // Whoever wrote this clearly wasn't comfortable with 0-based indexing.
    // And why the hell are the second and third menu items in reverse order?
    // To do: Modify this so that it uses 0-based indexing.
    // To do: swap subInfo[2] and subInfo[3] (should be 1 and 2, respectively)
    [],
    [
        [],
        ["Algemeen ","algemeen.htm","inhoud"],
        ["Nieuws ","nieuws.htm","inhoud"],
        ["Kom ook bij ons zingen ","wordooklid.htm","inhoud"]
    ],
    [
        [],
        ["Kerstconcert","agenda.htm","inhoud"],
        //["Kaarten bestellen ","kaarten.htm","inhoud"],
        ["Eerdere concerten","jaarcon2009.htm","inhoud"]
    ],
    [
        [],
        ["Wie zijn wij","wiezijnwij.htm","inhoud"],
        ["Dirigent ","dirigent.htm","inhoud"],
        ["Pianiste ","pianiste.htm","inhoud"],
        ["Repertoire ","repertoire.htm","inhoud"],
        ["Word vriend ","vriend.htm","inhoud"]
    ],
    [
        [],
        ["Sponsors ","sponsors.htm","inhoud"],
        ["Activiteiten ","activiteiten.htm","inhoud"],
        ["Geschiedenis ","geschiedenis.htm","inhoud"],
        ["Contact ","contact.htm","inhoud"],
        ["Links ","links.htm","inhoud"]
    ],
    [],
    []
]


//*** SET SUB MENU POSITION ( RELATIVE TO BUTTON ) ***//

var xSubOffset = 8;

var ySubOffset = 29;







//*** NO MORE SETTINGS BEYOND THIS POINT ***//

var overSub = false;

var delay = 1000;

totalButtons = upSources.length;



// GENERATE SUB MENUS

for ( x=0; x<totalButtons; x++) {

	// SET EMPTY DIV FOR BUTTONS WITHOUT SUBMENU

	if ( subInfo[x+1].length < 1 ) { 

		document.write('<div id="submenu' + (x+1) + '">');

	// SET DIV FOR BUTTONS WITH SUBMENU

	} else {

		document.write('<div id="submenu' + (x+1) + '" class="dropmenu" ');

		document.write('onMouseOver="overSub=true;');

		document.write('setOverImg(\'' + (x+1) + '\',\'\');"');

		document.write('onMouseOut="overSub=false;');

		document.write('setTimeout(\'hideSubMenu(\\\'submenu' + (x+1) + '\\\')\',delay);');

		document.write('setOutImg(\'' + (x+1) + '\',\'\');">');





		document.write('<ul>');

		for ( k=0; k<subInfo[x+1].length-1; k++ ) {

			document.write('<li>');

			document.write('<a href="' + subInfo[x+1][k+1][1] + '" ');

			document.write('target="' + subInfo[x+1][k+1][2] + '">');

			document.write( subInfo[x+1][k+1][0] + '</a>');

			document.write('</li>');

		}

		document.write('</ul>');

	}

	document.write('</div>');

}











//*** MAIN BUTTONS FUNCTIONS ***//

// PRELOAD MAIN MENU BUTTON IMAGES

function preload() {

	for ( x=0; x<totalButtons; x++ ) {

		buttonUp = new Image();

		buttonUp.src = buttonFolder + upSources[x];

		buttonOver = new Image();

		buttonOver.src = buttonFolder + overSources[x];

	}

}



// SET MOUSEOVER BUTTON

function setOverImg(But, ID) {

	document.getElementById('button' + But + ID).src = buttonFolder + overSources[But-1];

}



// SET MOUSEOUT BUTTON

function setOutImg(But, ID) {

	document.getElementById('button' + But + ID).src = buttonFolder + upSources[But-1];

}







//*** SUB MENU FUNCTIONS ***//

// GET ELEMENT ID MULTI BROWSER

function getElement(id) {

	return document.getElementById ? document.getElementById(id) : document.all ? document.all(id) : null; 

}



// GET X COORDINATE

function getRealLeft(id) { 

	var el = getElement(id);

	if (el) { 

		xPos = el.offsetLeft;

		tempEl = el.offsetParent;

		while (tempEl != null) {

			xPos += tempEl.offsetLeft;

			tempEl = tempEl.offsetParent;

		} 

		return xPos;

	} 

} 



// GET Y COORDINATE

function getRealTop(id) {

	var el = getElement(id);

	if (el) { 

		yPos = el.offsetTop;

		tempEl = el.offsetParent;

		while (tempEl != null) {

			yPos += tempEl.offsetTop;

			tempEl = tempEl.offsetParent;

		}

		return yPos;

	}

}



// MOVE OBJECT TO COORDINATE

function moveObjectTo(objectID,x,y) {

	var el = getElement(objectID);

	el.style.left = x;

	el.style.top = y;

}



// MOVE SUBMENU TO CORRESPONDING BUTTON

function showSubMenu(subID, buttonID) {

	hideAllSubMenus();

	butX = getRealLeft(buttonID);

	butY = getRealTop(buttonID);

	moveObjectTo(subID,butX+xSubOffset, butY+ySubOffset);

}



// HIDE ALL SUB MENUS

function hideAllSubMenus() {

	for ( x=0; x<totalButtons; x++) {

		moveObjectTo("submenu" + (x+1) + "",-500, -500 );

	}

}



// HIDE ONE SUB MENU

function hideSubMenu(subID) {

	if ( overSub == false ) {

		moveObjectTo(subID,-500, -500);

	}

}







//preload();



