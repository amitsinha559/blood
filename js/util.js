function validateForm(formName, requiredFields, requiredFieldsName, errorIds){
	var returnVal = true;
	clearField('country_error');
	for(var i = 0; i < requiredFields.length ; i++) {	
		var div = document.getElementById(errorIds[i]);
		div.innerHTML = '';
	}
	var div = document.getElementById('mob_two_error');
	div.innerHTML = '';
	if(requiredFields && requiredFieldsName && errorIds && requiredFields.length > 0 && requiredFieldsName.length > 0 && errorIds.length > 0 && requiredFields.length === requiredFieldsName.length && requiredFieldsName.length === errorIds.length){
		for(var i = 0; i < requiredFields.length ; i++) {
			var x=document.forms[formName][requiredFields[i]].value;
			if (x==null || x==""){
				var div = document.getElementById(errorIds[i]);
				div.innerHTML = '';
				div.innerHTML = 'Please enter your ' + requiredFieldsName[i];
				returnVal = false;
			}
			if (returnVal && requiredFields[i]==='email'){
				x=document.forms[formName][requiredFields[i]].value;
				var atpos=x.indexOf("@");
				var dotpos=x.lastIndexOf(".");
				var div = document.getElementById(errorIds[i]);
				div.innerHTML = '';
				if (atpos<1 || dotpos<atpos+2 || dotpos+2>=x.length){		
					div.innerHTML = 'Please enter a valid email id';
					returnVal = false;
				}
			}
			if (returnVal && requiredFields[i]==='repeat_password') {
				returnVal = validatePassword(formName, requiredFields[i], requiredFields[i-1], errorIds[i]);
			}
			if(returnVal && requiredFields[i]==='mobile_number_one'){
				returnVal = validateMobileNumber(formName, requiredFields[i], errorIds[i]);
			}
			if(returnVal && requiredFields[i]==='last_donate_date'){
				x=document.forms[formName][requiredFields[i]].value;
				returnVal = validateDate(x);
				if(!returnVal){
					var lastDonateErrorId = clearField('last_donate_error');
					lastDonateErrorId.innerHTML = "Please enter a valid date. e.g: 06/28/2000";
				}
			}
			var placeOfDonation = document.forms[formName][requiredFields[i]].value;
			if(returnVal && requiredFields[i]==='place_of_donation' && placeOfDonation === "Not Selected") {
				var placeOfDonationErrorId = clearField('place_of_donation_error');
				placeOfDonationErrorId.innerHTML = "Please choose your place of last donation";
				returnVal = false;
			}
		}
		if(returnVal){
			returnVal = validateZipAndCountry();
		}
		return returnVal;
	} else {
		return false;
	}
}



function validateMobileNumber(formName, mobileFieldOne, mobileFieldOneErrorId){
	mobileNumberOne = document.forms[formName][mobileFieldOne].value;
	mobileNumberTwo = document.forms[formName]['mobile_number_two'].value;
	if(!Number(mobileNumberOne)){
		var div = document.getElementById(mobileFieldOneErrorId);
		div.innerHTML = '';
		div.innerHTML = 'Please enter a valid mobile number. Note: Please don\'t enter the ISD codes like: +91 or +880';
		return false;
	}
	if(mobileNumberTwo == null || mobileNumberTwo == ""){
		return true;
	} else if(!Number(mobileNumberTwo)){
		var div = document.getElementById('mob_two_error');
		div.innerHTML = '';
		div.innerHTML = 'Please enter a valid mobile number. Note: Please don\'t enter the ISD codes like: +91 or +880';
		return false;
	}
	return true;
}

function onCountryChange(value){
	clearField('zip_code_error');
	var x=document.forms['donor_form']['zip_code'].value;
	if (x==null || x==""){
		div = clearField('zip_code_error');
		div.innerHTML = 'Please enter your zip code first';
		div = clearField('country_error');
		div.innerHTML = 'Please enter your zip code first';
	} else {
		var zipCode=document.forms['donor_form']['zip_code'].value;
		var countryCode=document.forms['donor_form']['country'].value;
		var client = new XMLHttpRequest();
		client.open("GET", "http://api.zippopotam.us/" + countryCode + "/" + zipCode, true);
		client.onreadystatechange = function() {
			if(client.readyState == 4) {
				if(client.statusText === "Not Found" || client.status === 404){
					var errorIdName = clearField('zip_code_error');
					errorIdName.innerHTML = 'Opps!! zip code is available in this country';
					errorIdName = clearField('country_error');
					errorIdName.innerHTML = "Please enter a valid zip code and country";
					$("#state_label").hide();
					$("#state").hide();
					$("#place_label").hide();
					$("#place").hide();
				} else {
					errorIdName = clearField('country_error');
					clearField('zip_code_error');
					$("#state_label").show();
					$("#state").show();
					$("#place_label").show();
					$("#place").show();
					var data = JSON.parse(client.responseText);
					var state = data.places[0].state;
					var places = data.places;
					var place;
					$("#state_label").html("<br/>" + 'State :');
					$("#state").html("<i>" + state + "</i>");
					$("#place_label").html('<br/> Places Near by:');
					$("#place").html("");
					for(var i = 0; i < places.length; i++) {
						place = data.places[i]['place name'];
						$("#place").append("<i>" + place + "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</i>");
					}
					console.log(data);
				}
			}
		};
		client.send();		
	}
}

function validateZipAndCountry(){
	var returnVal = true;
	clearField('zip_code_error');
	var zipCode=document.forms['donor_form']['zip_code'].value;
	var countryCode=document.forms['donor_form']['country'].value;
	var client = new XMLHttpRequest();
	client.open("GET", "http://api.zippopotam.us/" + countryCode + "/" + zipCode, true);
	client.onreadystatechange = function() {
		if(client.readyState == 4) {
			if(client.statusText === "Not Found" || client.status === 404){
				var errorIdName = clearField('zip_code_error');
				errorIdName.innerHTML = 'Opps!! zip code is available in this country';
				errorIdName = clearField('country_error');
				errorIdName.innerHTML = "Please enter a valid zip code and country";
				$("#state_label").hide();
				$("#state").hide();
				$("#place_label").hide();
				$("#place").hide();
				returnVal = false;
			} else {
				returnVal = true;
			}			
		}
	};
	client.send();
	return returnVal;
}

function validateDate(txtDate)
{
  var currVal = txtDate;
  if(currVal == '')
    return false;
  
  //Declare Regex  
  var rxDatePattern = /^(\d{1,2})(\/|-)(\d{1,2})(\/|-)(\d{4})$/; 
  var dtArray = currVal.match(rxDatePattern); // is format OK?

  if (dtArray == null)
     return false;
 
  //Checks for mm/dd/yyyy format.
  dtMonth = dtArray[1];
  dtDay= dtArray[3];
  dtYear = dtArray[5];

  if (dtMonth < 1 || dtMonth > 12)
      return false;
  else if (dtDay < 1 || dtDay> 31)
      return false;
  else if ((dtMonth==4 || dtMonth==6 || dtMonth==9 || dtMonth==11) && dtDay ==31)
      return false;
  else if (dtMonth == 2)
  {
     var isleap = (dtYear % 4 == 0 && (dtYear % 100 != 0 || dtYear % 400 == 0));
     if (dtDay> 29 || (dtDay ==29 && !isleap))
          return false;
  }
  return true;
}