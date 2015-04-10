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
						$("#places").append("You have searched for places nearby :" + " ");
						for(var i = 0; i < data.places.length ; i++){
							place = data.places[i]['place name'];
							$("#places").append("<b>" + place + ",</b> ");
							var query = "zip_code=" + zipCode;
							$.ajax({
								type: "POST",
								url: "process/donor-details.php",
								data: query,
								cache: false,
								success: function(html){
									alert(html);
								}
							});
						}						
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
				alert("Please check your email now.");
			}
		});
        dialog.dialog( "close" );
      }
      return valid;
    }
 
    dialog = $( "#dialog-form" ).dialog({
      autoOpen: false,
      height: 300,
      width: 350,
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
	passwordTwoValue = document.forms[formName][passTwoFieldName].value;
	if(passwordOneValue != passwordTwoValue){
		var div = document.getElementById(errorId);
		div.innerHTML = '';
		div.innerHTML = 'Password is not matching';
		return false;
	}
	return true;
}

function validateOldPassword(oldPass, emailFromSession){
	var query = "ajax=true&pass="+oldPass+"&email=" + emailFromSession;
	$.ajax({
		type: "POST",
		url: "process/update-password.php",
		data: query,
		cache: false,
		success: function(html){
			alert(html);
		}
	});
}