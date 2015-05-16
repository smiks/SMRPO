// BEGIN: GLOBAL VARS
var shrinkBy = 130;	// shrink for n-px
var extendBy= 130;	// extend by n-px
var div_width_sum = 0;  // Var is needed to calculate width of swimline. Var is changed everytime new div is inserted
// END: GLOBAL VARS
	
// Function resets sum of divs (for different swimlines)
function reset_div_sums(){
	div_width_sum = 0;
}
	
// Function sums up all div widths (add together one by one)
function sum_width(divName){
	var this_div_px = $('#div_'+divName+"_1").css('width');			// get div width
	div_width_sum = div_width_sum + parseInt(this_div_px);
}
	
// Function applies sum of all divs to swimline, therefor sumline width is equal to sum of div widths
function apply_width_to_swimline(swimline_name){
	var this_div_px = $('#'+swimline_name).css('width');	
	var extra_width = 20;							// increase extra_width if last column breaks into next line
	$('#'+swimline_name).css('width', (parseInt(div_width_sum) + parseInt(extra_width)) +'px'); // set new swimline width
}
	
// Function extends div width if div cotains any subdivs
function extend_function(name, subColumns){
	var number_of_sub = parseInt(subColumns);
	if (number_of_sub > 1){
		var myDiv = "div_" + name + "_1";
		var div_px = $('#'+myDiv).css('width');				// get div width
		div_px = number_of_sub*182 + 18;				// calculate new dimensions (extend)
		$('#'+myDiv).css('width', div_px+'px');				// set new dimensions
	}
}
	

	
/* BEGIN: global vars */
var extend = 0;
var shrink = 0;
var single_column_width = 130; // its actually 180, but small column width is 50 ... 180-50 = 130
var changedBySubDiv = false;
var dimensions = {}; // dimensions of divs we closed, so we can apply them to swim line when we need to extend
var divToExtend = "";
/* END: global vars */
	
function toggle_swimline(divName, divNoNumber, divNumber){
		
		
	// if swimline was clicked!
	if (extend == 0 && shrink == 0){
		// if we clicked on BIG swimline
		if(divNumber == 1){
			var divHideString = "#" + divNoNumber + "1";
			var divShowString = "#" + divNoNumber + "2";
		}
		else if (divNumber == 2){
			var divHideString = "#" + divNoNumber + "2";
			var divShowString = "#" + divNoNumber + "1";
		}
		else{
			alert("Error in swimline toggle ... ");
		}
			
		$(divShowString).show('slow');
		$(divHideString).hide('slow');
	}
	// if sub_div or div was clicked!
	else{
		var swl_width = parseInt($('#'+divName).css('width'));		// get current swl width
		
		// If sub_div was clicked!
		if (changedBySubDiv == true){
			changedBySubDiv = false;
			if(shrink != 0){
				shrink = 0;
				var new_width = swl_width - single_column_width;	
				$('#'+divName).css('width', new_width+'px');		// set new dimensions
			}
			else if (extend != 0){
				extend = 0;
				var new_width = swl_width + single_column_width;		
				$('#'+divName).css('width', new_width+'px');		// set new dimensions
			}	
		}
			
		// If div was clicked
		else if(changedBySubDiv == false){
			// If div was shrinked
			if(shrink != 0){
				var new_width = swl_width - shrink + 50;
				$('#'+divName).css('width', new_width+'px');
				shrink = 0;
			}
				
			// If div was extended
			else if(extend != 0){
				extend = 0;
				var extended_div_width = parseInt(dimensions[divToExtend]);
				var new_width = swl_width + extended_div_width - 50;
				$('#'+divName).css('width', new_width+'px');
			}
		}
	}
}
	
function toggle_div(divName, divNoNumber, divNumber){
		
	// if div was clicked!
	if(extend == 0 && shrink == 0){
		
		// shrink div
		if(divNumber == 1){
			var divHideString = "#" + divNoNumber + "1";
			var divShowString = "#" + divNoNumber + "2";
				
			// store width when swimline will need to extend again
			var div_width = parseInt($('#'+divName).css('width'));		// get div width
			dimensions[divName] = div_width; 				// add divName and its width to dict

			shrink = div_width; 
		}
			
		// extend div
		else if(divNumber == 2){
			var divHideString = "#" + divNoNumber + "2";
			var divShowString = "#" + divNoNumber + "1";
				
			divToExtend = divNoNumber + "1";
			extend = 666;
		}
			
		else{
			alert("Error in div toggle ...");
		}
		
		$(divShowString).show();
		$(divHideString).hide();
	}
	// if sub_div was clicked!
	else{
		var div_width = parseInt($('#'+divName).css('width'));		// get div width
		if(extend != 0){
			var new_width = div_width + single_column_width;
			$('#'+divName).css('width', new_width+'px');		// set new dimensions
		}
		if (shrink != 0){
			var new_width = div_width - single_column_width;
			$('#'+divName).css('width', new_width+'px');		// set new dimensions
		}
	}
}


function toggle_sub_div(divName, divNoNumber, divNumber){
	
	// shrink sub_div
	if(divNumber == 1){
		var divHideString = "#" + divNoNumber + "1";
		var divShowString = "#" + divNoNumber + "2";
		shrink = single_column_width;
	}
		
	// extend sub_div
	else if(divNumber == 2){
		var divHideString = "#" + divNoNumber + "2";
		var divShowString = "#" + divNoNumber + "1";
		extend = single_column_width;
	}
		
	else{
		alert("Error in div toggle ...");
	}
			
	$(divShowString).show();
	$(divHideString).hide();
			
	changedBySubDiv = true;
}




// Function below is called when we click ANY div!! Handle it correctly!
// Warning: if you click on one sub_div, this function is called for every div where clicked sub_div is nested.
// To prevent warning above, you can write 'return false;' so NO other div will call this function automatically!
// Be sure to check if everything works ok after you change code in function below!!!
$(document).on('click', 'div', function () {

	
	if(String(this.id) != ""){
	
		

		// get div properties
		var myDiv = String(this.id);
		var myDivLength = myDiv.length;
		var divNumber = parseInt(myDiv.charAt(myDivLength-1));	// get div number. Possible values: 1 || 2
		var divNoNumber = myDiv.substring(0, myDivLength-1);	// Possible values: swl_xxx || div_xxxx || sub_xxx
		
		var clicked = myDiv.substring(0,3);
		//if(myDiv == "card_div"){
		//	alert("Card");
		//	return false;
		//}
		
		if(clicked == "swl" || clicked == "div" || clicked == "sub"){
		// BEGIN: HANDLE SHOW/HIDE COLUMNS AND SWIMLINE
		if(clicked == "swl"){
			toggle_swimline(myDiv, divNoNumber, divNumber);
		}
		else if(clicked  == "div"){
			toggle_div(myDiv, divNoNumber, divNumber);
		}
		else if(clicked  == "sub"){
			toggle_sub_div(myDiv, divNoNumber, divNumber);
		}
		// END: HANDLE SHOW/HIDE COLUMNS AND SWIMLINE
		else{
			// TODO : if somebody wants to handle something else ...
		}
		}
			
		//return false; // Do not delete this!	
			
	}
		
});
	