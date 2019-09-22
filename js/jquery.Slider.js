
// V A R I A B L E S  F O R  S L I D E R
var slider;
var slideStep = 0;
var slideSpeed = 100;
var sliding = false;
var slideRunning = false;

var gotoOnStartup = 'none';


// VARIABLES FOR ARCS
var activeArc = '';
var a;

// VARIABLES FOR IMAGE/MEDIA-SLIDER
var mediaDiv = '';
var mediaThumb = '';
var mediaClick = '';

/*
	Register general events for slider and mieter-goto
*/
$(document).ready(function () {
	
	// G E N E R A L  S L I D E R
	slider = $('#slider');
	if ( slider ) {
		slider.mouseenter( sliderMouseEnter );
		slider.mouseleave( sliderMouseLeave );
		slider.mousemove( sliderMouseMove );
		$('#sliderNavLeft').mouseenter( navleftMouseEnter );
		$('#sliderNavLeft').mouseleave( navMouseLeave );
		$('#sliderNavRight').mouseenter( navrightMouseEnter );
		$('#sliderNavRight').mouseleave( navMouseLeave );
		
		if ( !a ) {
			slider.scrollLeft(0);
		}
	}
		
	// G L O B A L  P O P U P S
	$('#festpopup').click( function( event ) {
		if (event.target.nodeName == 'A' || event.target.parentNode.nodeName == 'A'){
			// dont't hide, as link was clicked
		} else {
			$(this).css( 'display', 'none' );
			$('#fest-icon').css('display', 'block');
		}
	});
	$('#indexteaser .close').click( function( event ) {
		$(this).parent().hide();
	});
	$('#indexteaser .calendar').click( function( event ) {
		document.location = '/content/agenda';
	});
	
	//$('#marktpopup .bar').click( closePopup );
	$('#eventpopup .bar').click( closePopup );
	$('#eventpopup .content').jScrollPane({showArrows:false, scrollbarWidth:12, paneWidth:350, paneHeight:415});
	
	//<.. HEADER GOTO... >
	
	
	// T O O L T I P
	$('.tooltip').tooltip({track: true, delay: 0, showURL: false, showBody: " - ", fade: 250 });	

	
	// M A P
	
	$('#iv-map area').each(function(i){
		var $arcName = $('#arc-label #arc-name');
		var $arcId = $('#arc-label #arc-id');
		
		var $this = $(this);
		var id = this.id;
		if ( id.indexOf('a') == 0 ) {
			$this.mouseenter(function(){
				id = id.replace('a', '');
				if ( arcs[id] != undefined ) {
					$arcName.html(arcs[id].replace(' | ','<br/>'));
					$arcId.html('...'+id);
					var aclass = 'arc-red';
					if ( 1 <= id && 33 >= id ) {
						aclass = 'arc-yellow';
					} else if ( 33 < id && 52 >= id ) {
						aclass = 'arc-green';
					} else if ( id == 'M' ) {
						aclass = 'arc-blue';
					}
					$arcId.addClass(aclass);
				}
			}).mouseleave(function(){
				$arcName.html('');
				$arcId.html('').removeClass();
			}).click(function(e){
				e.preventDefault();
			});
		} 
	});
	
	
});


$(window).load(function() {
	
	// H E A D E R  M I E T E R  G O - T O  AND  F I L T E R
	$('#header li').mouseenter( function() { $(this).addClass('active')});
	$('#header li').mouseleave( function() { $(this).removeClass('active')});
	
	
	// IMPORTANT: Because of rendering troubles the width and height of the whole ScrollPane is
	// passed as parameter to the ScrollPane! 
	$('.goto .list').jScrollPane({showArrows:false, scrollbarWidth:12, scrollbarMargin:0, paneWidth:240, paneHeight:307 });
	$('.goto .jScrollPaneContainer').css('display', gotoOnStartup);
	$('#header .goto').mouseenter( function() { $(this).children('.jScrollPaneContainer').css('display', 'block')});
	$('#header .goto').mouseleave( function() { $(this).children('.jScrollPaneContainer').css('display', 'none')});
	$('#header .goto .list').css('display', 'block');
	
	
	$('.filter .list').jScrollPane({showArrows:false, scrollbarWidth:12, scrollbarMargin:0, paneWidth:240, paneHeight:307 });
	$('.filter .jScrollPaneContainer').css('display', 'none');
	$('#header .filter').mouseenter( function() { $(this).children('.jScrollPaneContainer').css('display', 'block')});
	$('#header .filter').mouseleave( function() { $(this).children('.jScrollPaneContainer').css('display', 'none')});
	$('#header .filter .list').css('display', 'block');
	
		
});


function closePopup() {
	$(this).parent().css( 'display', 'none' );
}

// H E L P E R S  F O R  S L I D E R
//====================================

function sliderMouseEnter() {
	slideStart();
}

function sliderMouseLeave() {
	slideStop();
}

function navleftMouseEnter() {
	slideStep = -20;
	slideStart();
}

function navrightMouseEnter() {
	slideStep = 20;
	slideStart();
}

function navMouseLeave() {
	slideStop();
}

function sliderMouseMove(e) {
	var offset = slider.offset();
	var xPos = e.pageX - offset.left;
	var yPos = e.pageY - offset.top;
	
	var w = slider.width() + 2; // +2px for Border!!
	if ( xPos > w/2 ) {
		xPos = xPos - w;
	}
	var xPosAbs = Math.abs( xPos );
	var step = 0;
	if ( xPosAbs > 0 && xPosAbs < 200 ) {
		step = 2000 / xPos + 5;
		step = Math.round(step * -1);
	}
	slideStep = step;
}

function slideStart(){
	if ( sliding == false ) {
		sliding = true;
		if ( slideRunning == false ) {
			slide();
		}
	}
}

function slide() {
	if ( mediaDiv != '' && slideStep != 0 ) {
		mediaDiv.html(mediaThumb);
		mediaDiv.click(mediaClick );
		mediaDiv.css("cursor","pointer");
		mediaDiv = '';
		mediaThumb = '';
	}
	slideRunning = true;
	slider.scrollLeft( slider.scrollLeft() + slideStep );
	if ( sliding ) {
		setTimeout( slide, slideSpeed );
	} else {
		slideRunning = false;
	}
}

function slideStop() {
	sliding = false;
	slideStep = 0;
}

// END 
//======================================================




// HELPERS FOR ARC SLIDER
//-------------------------

function arcMouseEnter() {
	deactivateArc();
	activeArc = $(this);
	activateArc();
}

function arcMouseLeave() { 
	deactivateArc();
}


function gotoArc( id ) {
	deactivateArc();
	var pos = a[id];
	slider.scrollLeft( (pos-1) * 240 - 100);
	activeArc = $('#arc-'+id );
	/*var eventPopupDisplay = $('#eventpopup').css('display');
	if ( id == 1 && ( eventPopupDisplay == null || eventPopupDisplay == 'none')) {
		$('#marktpopup').css( 'display', 'block' );
		
		// Adjust paneWidth and paneHeight here if it has changed in css. Don't forget to 
		// reduce the height by the bar-height; the bar is not scrolling...
		$('#marktpopup .content').jScrollPane({showArrows:false, scrollbarWidth:12, paneWidth:350, paneHeight:415});
	} else if ( id != 1 ) {
		$('#marktpopup').css( 'display', 'none' );
	}*/
	activateArc();
}

/* vui only show Arcs before Restaurant Markthalle... */
function gotoArcRandom( maxpos ) {
	var id;
	var pos;
	while ( !pos || pos>=maxpos ) {
		id = Math.floor(Math.random() * a.length); 
		pos = a[id];
		//alert(pos + '/' + maxpos);
	}	
	gotoArc(id);
}

function activateArc() {
	if ( activeArc != '' ) {
		activeArc.find( '.popup' ).css('display', 'block');
		activeArc.find( '.top img.img-overlay' ).css( 'display', 'none' );
		activeArc.find( '.top img.img-overlay-slide' ).css( 'display', 'block' );
	}
}

function deactivateArc() {
	if ( activeArc != '' ) {
		activeArc.find( '.popup' ).css('display', 'none');
		activeArc.find( '.top img.img-overlay' ).css( 'display', 'block' );
		activeArc.find( '.top img.img-overlay-slide' ).css( 'display', 'none' );
		activeArc = '';
	}
}

// HELPERS FOR IMAGE/MEDIA SLIDER
//--------------------------------

function play( mediaDivId, movie ) {
	slideStop();
	if ( mediaDiv != '' ) {
		return;
	}
	var mdiv = $('#'+mediaDivId );
	mediaDiv = mdiv;
	mediaThumb = mdiv.html();
	mediaClick = mdiv.attr('onclick');
	
	mdiv.removeAttr( 'onclick' );
	mdiv.css("cursor","auto");
	mdiv.html(
		'<object classid="clsid:02BF25D5-8C17-4B23-BC80-D3488ABDDC6B" codebase="http://www.apple.com/qtactivex/qtplugin.cab" '+
			'height="320" width="460" > '+
			'<param name="src" value="'+movie+'"/>' +
			'<param name="scale" value="1" />'+
			'<param name="controller" value="true" />'+
			'<param name="autoplay" value="true" />'+
			'<param name="bgcolor" value="#ffffff" />'+
			'<embed '+
				'type="video/quicktime" '+
				'pluginspage="http://www.apple.com/quicktime/download/" '+
				'height="320" '+
				'width="460" '+
				'src="'+movie+'" '+
				'scale="1" '+
				'controller="true" '+
				'autoplay="true" bgcolor="ffffff"/> '+
		'</object>');
}






