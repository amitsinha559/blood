function validateFormIndex(formName, requiredFields, requiredFieldsName, errorIds){
	var returnVal = true;
	if(requiredFields && requiredFieldsName && errorIds && requiredFields.length > 0 && requiredFieldsName.length > 0 && errorIds.length > 0 && requiredFields.length === requiredFieldsName.length && requiredFieldsName.length === errorIds.length){
		for(var i = 0; i < requiredFields.length ; i++) {
			var x=document.forms[formName][requiredFields[i]].value;
			if (x==null || x==""){
				var div = document.getElementById(errorIds[i]);
				div.innerHTML = '';
				div.innerHTML = 'Please enter your ' + requiredFieldsName[i];
				returnVal = false;
			}			
		}
		return returnVal;
	} else {
		return false;
	}
}

function onCountryChangeIndex(value){
	clearField('zip_code_error');
	clearField('country_error');
	clearField('places');
	var countryCode = value;
	var zipCode = document.forms['search_donor_form']['zip_code'].value;
	var bloodGroup = document.forms['search_donor_form']['blood_group'].value;
	if(zipCode === null || zipCode === ''){
		$("#zip_code_error").html("Please enter the zip code");
	} else {
		var client = new XMLHttpRequest();
		client.open("GET", "http://api.zippopotam.us/" + countryCode + "/" + zipCode, true);
		client.onreadystatechange = function() {
			if(client.readyState == 4) {
				if(client.statusText === "Not Found" || client.status === 404){
					$("#zip_code_error").html("Please enter a valid zip code");
					$("#country_error").html("Zip code is not available in this country");
				} else {
					var data = JSON.parse(client.responseText);
					var state = data.places[0].state;
					if(data.places && data.places.length > 0){
						clearField('zip_code_error');
						clearField('country_error');
						var place = "";
						$("#places").append("You are searching for <b>"+ bloodGroup + "</b> blood group in places nearby :" + " ");
						for(var i = 0; i < data.places.length ; i++){
							place += data.places[i]['place name'] + ", ";
						}
						$("#places").append("<b>" + place + "</b> ");
						var query = "get=list&zip_code=" + zipCode + "&blood_group="+bloodGroup;
						$.ajax({
							type: "POST",
							url: "process/donor-details.php",
							data: query,
							cache: false,
							success: function(data){
								$("#list").html(data);
							}
						});						
					}
					console.log(data);
				}
			}
		};
		client.send();
	}
}

function clearField(fieldName){
	div = document.getElementById(fieldName);
	div.innerHTML = '';
	div = document.getElementById(fieldName);
	return div;
}

function emailValidate(email){
	var atpos=email.indexOf("@");
	var dotpos=email.lastIndexOf(".");
	if (atpos<1 || dotpos<atpos+2 || dotpos+2>=email.length){
		return false;
	}
	return true;
}

$(function() {
    var dialog, form,
	  reset_email = $( "#reset_email" ),
      allFields = $( [] ).add( reset_email ),
      tips = $( ".validateTips" );
 
    function updateTips( t ) {
      tips
        .text( t )
        .addClass( "ui-state-highlight" );
      setTimeout(function() {
        tips.removeClass( "ui-state-highlight", 1500 );
      }, 500 );
    }
 
    function checkRegexp( email, n ) {
		var email1 = email.val();
		var o = email;
		var atpos=email1.indexOf("@");
		var dotpos=email1.lastIndexOf(".");
		if (atpos<1 || dotpos<atpos+2 || dotpos+2>=email1.length){
			o.addClass( "ui-state-error" );
			updateTips( n );
			return false;
		}
		return true;
    }
 
    function sendEmail() {
      var valid = true;
      allFields.removeClass( "ui-state-error" );
      valid = valid && checkRegexp( reset_email, "eg. amitsinha559@gmail.com" );
 
      if ( valid ) {
		  var query = "post=pass&email=" + reset_email.val();
		$.ajax({
			type: "POST",
			url: "process/forgot-password.php",
			data: query,
			cache: false,
			success: function(html){
				alert(html);
				alert("Please check your email now.");
			}
		});
        dialog.dialog( "close" );
      }
      return valid;
    }
 
    dialog = $( "#dialog-form" ).dialog({
	  dialogClass: 'no-close success-dialog',
	  resizable: false,
      autoOpen: false,
      height: 330,
      width: 500,
      modal: true,
      buttons: {
        "Reset Password": sendEmail,
        Cancel: function() {
          dialog.dialog( "close" );
        }
      },
      close: function() {
        form[ 0 ].reset();
        allFields.removeClass( "ui-state-error" );
      }
    });
 
    form = dialog.find( "form" ).on( "submit", function( event ) {
      event.preventDefault();
      sendEmail();
    });
	
	
	$('#create-user').click(function(e) { 
		dialog.dialog( "open" );
    });
  });
  
  
function validatePassword(formName, passTwoFieldName, passOneFieldName, errorId){
	passwordOneValue = document.forms[formName][passOneFieldName].value;
	if(passwordOneValue.length < 6) {
		var div = document.getElementById('pass_one_error');
		div.innerHTML = '';
		div.innerHTML = 'Password must have at least 6 characters';
		return false;
	} else {
		passwordOneValue = document.forms[formName][passOneFieldName].value;
		passwordTwoValue = document.forms[formName][passTwoFieldName].value;
		if(passwordOneValue != passwordTwoValue){
			var div = document.getElementById(errorId);
			div.innerHTML = '';
			div.innerHTML = 'Password is not matching';
			return false;
		}
	}
	
	return true;
}

function validateOldPassword(oldPass, emailFromSession, newPassword, repeatPassword){
	var query = "ajax=true&oldPass="+oldPass+"&email=" + emailFromSession + "&newPass=" + newPassword + "&repeatPass=" + repeatPassword;
	if(newPassword.length < 6 ) {
		$("#new_password_error").html("Password should have at least 6 characters");
	} else {
		$.ajax({
			type: "POST",
			url: "process/update-password.php",
			data: query,
			cache: false,
			success: function(html){
				if(html == 1234) {
					$("#repeat_new_password_error").html("Please repeat your old new password!");
					$("#old_password_error").html("Please enter your old password!");
					$("#new_password_error").html("Please choose a new password!");	
				}
				
				if(html == 234) {
					$("#repeat_new_password_error").html("Please repeat your old new password!");
					$("#new_password_error").html("Please choose a new password!");	
				}
				
				if(html == 134) {
					$("#repeat_new_password_error").html("Please repeat your old new password!");
					$("#old_password_error").html("Please enter your old password!");
				}
				
				if(html == 124) {
					$("#new_password_error").html("Please choose a new password!");	
					$("#old_password_error").html("Please enter your old password!");
					$("#repeat_new_password_error").html("Password is not matching!");
				}
				
				if(html == 34) {
					$("#repeat_new_password_error").html("Password is not matching!");
				}
				
				if(html == 24) {
					$("#new_password_error").html("Please choose a new password!");	
					$("#repeat_new_password_error").html("Password is not matching!");
				}
				
				if(html == 14) {
					$("#old_password_error").html("Please enter your old password!");
					$("#new_password_error").html("Please choose a new password!");	
					$("#repeat_new_password_error").html("Password is not matching!");
				}
				
				if(html == 16) {
					$("#old_password_error").html("Please enter your old password!");
				}
				
				if(html == 6) {
					$("#old_password_error").html("Incorrect Password!");
				}
				
				if(html == 4) {
					$("#repeat_new_password_error").html("Password is not matching!");
				}
				
				if(html == 7) {
					alert("Your password has been changed");
					window.location.replace("index.php");
				}
			}
		});
	}
	
}

$(function() {
    var tooltips = $( "[title]" ).tooltip({
      position: {
        my: "left top",
        at: "right+5 top-5"
      }
    });
  });
  
function getDonorDetails(bloodGroup, zipCode){
	var getLocationQuery = "get=location&zip_code=" + zipCode;
	$.ajax({
		type: "POST",
		url: "process/donor-details.php",
		data: getLocationQuery,
		cache: false,
		success: function(data){
			var placesFromDB = data.split("__");
			alert(placesFromDB.length);
			var allPlaces = " ";
			$("#places").append("You are searching for <b>"+ bloodGroup + "</b> blood group in places nearby :" + " ");
			//alert(placesFromDB[1]);
			for(var i = 1; i < placesFromDB.length ; i++ ){
				allPlaces += " <b> " + placesFromDB[i] + " ,</b>";
			}
			$("#places").append(allPlaces);
		}
	});
	
	var query = "get=list&zip_code=" + zipCode + "&blood_group="+bloodGroup;
	$.ajax({
		type: "POST",
		url: "process/donor-details.php",
		data: query,
		cache: false,
		success: function(data){
			$("#list").html(data);
		}
	});
}