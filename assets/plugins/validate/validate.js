function validate(forms_id){
	var chk_complete = 0; 
	var element_form = document.getElementById(forms_id);
	// console.log(element_form);
	for (var i = 0; i < element_form.elements.length; i++){
		var attr = element_form[i].hasAttribute("validate");
		if (typeof attr !== typeof undefined && attr !== false) { //เช็ค tag ไหนใส่ validate
			if(element_form[i].tagName != "BUTTON" && element_form[i].tagName != "button"){ // เช็คว่าไม่ใช่ปุ่ม
				var elem = element_form[i];
				var elem_id = element_form[i].id;//get id of element
				var prev_ele = $("#"+elem_id).parent().attr("id");//get id of previous elements	
				// console.log("prev_ele => "+prev_ele);
				var val = $("#"+elem_id).val();
				
				if(val != "" && val != null){
					// console.log(val);
					// console.log(elem_id);
					$("#"+elem_id).css("background","transparent");
					$("#"+elem_id).css("border-color","#D2D6DE");
					$("#"+elem_id).removeAttr('placeholder');
					
				}else{
					$("#"+elem_id).css("background","#fbe8e5");
					$("#"+elem_id).css("border-color","#f69988");
					$("#"+elem_id).attr('placeholder','กรุณากรอกข้อมูล');
					chk_complete++;
				}//check null value
				
				//Check Select2
				if(element_form[i].tagName == "select" || element_form[i].tagName == "SELECT"){
					if(val == "" || val == null){
						$("#s2id_"+elem_id).children().css("background","#fbe8e5");
						$("#s2id_"+elem_id).children().css("border-color","#f69988");
						$(".select2-drop").css("background","#ffffff");
						$(".select2-drop").css("border-color","#D2D6DE");
					}else{
						$("#s2id_"+elem_id).children().css("background","#ffffff");
						$("#s2id_"+elem_id).children().css("border-color","#D2D6DE");
					}
				}//End if
				
			}//if
		}//if
	}//for
	
	if(chk_complete > 0){
		return false;
	}else{
		// $("#"+forms).submit();
		return true;		
	}
	
	// console.log(element_form.elements.length);
}

function clear_validate(forms_id){
	var chk_complete = 0; 
	var element_form = document.getElementById(forms_id);
	// console.log(element_form);
	for (var i = 0; i < element_form.elements.length; i++){
		var attr = element_form[i].hasAttribute("validate");
		if (typeof attr !== typeof undefined && attr !== false) { //เช็ค tag ไหนใส่ validate
			if(element_form[i].tagName != "BUTTON" && element_form[i].tagName != "button"){ // เช็คว่าไม่ใช่ปุ่ม
				var elem = element_form[i];
				var elem_id = element_form[i].id;//get id of element
				var prev_ele = $("#"+elem_id).parent().attr("id");//get id of previous elements	
				// console.log("prev_ele => "+prev_ele);
				var val = $("#"+elem_id).val();
				
				if(val == "" || val == null){
					// console.log(val);
					// console.log(elem_id);
					$("#"+elem_id).css("background","#ffffff");
					$("#"+elem_id).css("border-color","#D2D6DE");
					$("#"+elem_id).removeAttr('placeholder');
					
				}
				
				//Check Select2
				if(element_form[i].tagName == "select" || element_form[i].tagName == "SELECT"){
					if(val == "" || val == null){
						$("#s2id_"+elem_id).children().css("background","#ffffff");
						$("#s2id_"+elem_id).children().css("border-color","#D2D6DE");
					}
				}//End if
				
			}//if
		}//if
	}//for
}