// define globals
var show_object = 0;
var slide_speed = 15;
var clip_left = 0;
var clip_top = 0;
var top_offset = 20;
var current_object = null;
var menu_bgcolor = '#EEEEEE';
var menu_color = '#000099';
var menu_highlight_bgcolor = '#999999';
var menu_highlight_color = '#ffffff';

// define some background menu colors?

// close all menu windows
//
function dc_close_all() {
   dc_close_menu('dc_search_form');
   dc_close_menu('menu_1');
   dc_close_menu('menu_2');
   dc_close_menu('menu_3');
}

// function dc_get_obj_id
// return object id of the event item
function dc_get_obj_id(evt) {
   var object_id = (evt.target) ? evt.target.id : ((evt.srcElement) ? evt.srcElement.id : null);
   return object_id;
}

function dc_toggle_menu(evt,objectID) {

   if (show_object == 0) {
      show_object = 1;
	  dc_open_menu(evt,objectID);
	}
	else {
		show_object = 0;
	  	dc_close_menu(objectID);
	}
}

function dc_open_menu(evt,objectID) {

   var object = document.getElementById(objectID);
   var object3 = document.getElementById(dc_get_obj_id(evt));

   object.style.top = object3.offsetTop + top_offset;
   object.style.left = object3.offsetLeft;

   // reset clip area
   clip_left = 0;
   clip_top = 0;

//   if (current_object != objectID) {
   if (show_object) {
       dc_close_all();
	   object.style.clip="rect(0 " + clip_left + " " + clip_top + " 0)";   
	   object.style.visibility = "visible";
	   dc_slide_open(objectID);
   }

   //current_object = objectID;
   
}

function dc_slide_open(objectID) {
   var object = document.getElementById(objectID);

   var obj_w = object.offsetWidth + 30;
   var obj_h = object.offsetHeight + 30;

   clip_left += Math.floor(obj_w/slide_speed);
   clip_top += Math.floor(obj_h/slide_speed);
   
   object.style.clip="rect(0 " + clip_left + " " + clip_top + " 0)";   

   if (clip_left < 1.1*obj_w && clip_top < 1.1*obj_h ) {
      object.style.clip="rect(0 " + clip_left + " " + clip_top + " 0)";
      object_timeout_id = setTimeout("dc_slide_open('" + objectID + "')",10);
   }
   else {
//      clearTimeout("dc_slide_open(" + object_timeout_id + ")");
   }

}


function dc_close_menu(objectID) {
   var object = document.getElementById(objectID);
   if (object.style.visibility == 'visible')
      dc_slide_close(objectID);
}

function dc_slide_close(objectID) {
   var object = document.getElementById(objectID);

   var obj_w = object.offsetWidth;
   var obj_h = object.offsetHeight;

   clip_left -= Math.floor(obj_w/slide_speed);
   clip_top -= Math.floor(obj_h/slide_speed);

   if (clip_left > 0 && clip_top > 0) {
      object.style.clip="rect(0 " + clip_left + " " + clip_top + " 0)";
      object_timeout_id = setTimeout("dc_slide_close('" + objectID + "')",10);
   }
   else {
      object.style.visibility = "hidden";
//      clearTimeout("dc_slide_close(" + objectID + ")");
   }
}

function dc_highlight_cell(this_cell,this_url) {
   this_cell.style.cursor = 'pointer';
   this_cell.style.background = menu_highlight_bgcolor;
   this_cell.style.color = menu_highlight_color;
   window.status = this_url;
}

function dc_unhighlight_cell(this_cell) {
   this_cell.style.background = menu_bgcolor;
   this_cell.style.color = menu_color;
   window.status = '';
}

function dc_jump_to(this_url) {
   location.href = this_url;
}

