$(document).ready(function(){
	refreshContacts();
	refreshOrganizations();	
});

function showError(strError) {
	
	var objError = document.getElementById('error');
	objError.innerHTML = 'Error: '+strError;
	
	return;
}

function clearError() {
	
	var objError = document.getElementById('error');
	objError.innerHTML = '&nbsp;';
	
	return;
}

function refreshContacts() {

	clearError();

	$.ajax({
		url: "api/index.php?action=fetch_contacts", 
		success: function(result){
			refreshContacts_callback(result);
		}
	});

	return;
}

function refreshContacts_callback(data) {

	var objResponse = JSON.parse(data);
	
	if (objResponse['successful'] && 'false' == objResponse['successful']) {
		showError(objResponse['message']);
	}
	else {
		displayContacts(objResponse['contacts'], objResponse['organizations']);	
	}
	
	return;
}

function displayContacts(arrContacts, arrOrgs) {

	var strHTML = '<form class="addform"> \
					<input class="field" name="firstname" type="text" placeholder="First Name" required="required" /> \
					<input class="field" name="lastname" type="text" placeholder="Last Name" required="required" /> \
					<input class="field" name="email" type="email" placeholder="Email" required="required" /> \
					<input class="field" name="phone" type="tel" placeholder="Phone Number" required="required" /> \
					<input type="button" value="Create" onclick="addContact($(this).parent());" /> \
					</form><br /> \
				  ';
				  
	for (var x in arrContacts) {

		var iID = arrContacts[x]['id'];	
		var strFirstname = arrContacts[x]['firstname'];
		var strLastname = arrContacts[x]['lastname'];
		var strEmail = arrContacts[x]['email'];
		var strPhone = arrContacts[x]['phone'];
		
		var iLinkId = arrContacts[x]['link_id'];
		var iOrgId = arrContacts[x]['org_id'];		
		
		var strOrgSelect = generateOrgSelect(iID, arrOrgs, iLinkId, iOrgId);

		strHTML += '<form data-id='+iID+'> \
					<input class="idfield" type="text" value="'+iID+'" disabled="disabled" /> \
					<input class="field" name="firstname" type="text" value="'+strFirstname+'" required="required" /> \
					<input class="field" name="lastname" type="text" value="'+strLastname+'" required="required" /> \
					<input class="field" name="email" type="email" value="'+strEmail+'" required="required" /> \
					<input class="field" name="phone" type="tel" value="'+strPhone+'" required="required" /> \
					<input type="button" value="Update" onclick="updateContact($(this).parent());" /> \
					<input type="button" value="Delete" onclick="deleteContact($(this).parent());" /> \
					&nbsp; &nbsp; Organization: '+strOrgSelect+' \
					</form> \
					';
					
	}
	
	var objContactDiv = document.getElementById('contactArea');
	objContactDiv.innerHTML = strHTML;
	
	return;
}

function generateOrgSelect(iID, arrOrgs, iLinkId, iOrgId) {

	var strHTML  = '';
		strHTML += '<select data-id="'+iID+'" onchange="handleOrgChange($(this).val(), '+iID+');"><option value="0">None</option>';
		
	for (var x in arrOrgs) {
	
		var iCurrOrgId = arrOrgs[x]['id'];
		var strOrgName = arrOrgs[x]['org_name'];		
		
		strHTML += '<option value="'+iCurrOrgId+'"';
		
		if (null != iOrgId && iOrgId == iCurrOrgId) {
			strHTML += ' selected="selected"';
		}
		
		strHTML += '>'+strOrgName+'</option>';
	}
		
		
	strHTML += '</select>';
		
	return strHTML;
}

function handleOrgChange(iOrgId, iContactId) {

	clearError();

	if (0 == iOrgId) {
		unlinkContact(iContactId);
	}
	else {
		linkContact(iOrgId, iContactId);	
	}

	return;
}

function linkContact(iOrgId, iContactId) {

	clearError();

	var strURL  = 'api/index.php?action=link_contact';
		strURL += '&contact_id='+iContactId;
		strURL += '&org_id='+iOrgId;

	$.ajax({
		url: strURL,
		success: function(result){
			linkContact_callback(result);
		}
	});

	return;
}

function linkContact_callback(data) {

	var objResponse = JSON.parse(data);
	
	if (objResponse['successful'] && 'false' == objResponse['successful']) {
		showError(objResponse['message']);
	}
	else {
		refreshContacts();
	}
	
	return;
}

function unlinkContact(iContactId) {

	clearError();

	var strURL  = 'api/index.php?action=unlink_contact';
		strURL += '&contact_id='+iContactId;

	$.ajax({
		url: strURL,
		success: function(result){
			unlinkContact_callback(result);
		}
	});

	return;
}

function unlinkContact_callback(data) {

	var objResponse = JSON.parse(data);
	
	if (objResponse['successful'] && 'false' == objResponse['successful']) {
		showError(objResponse['message']);
	}
	else {
		refreshContacts();
	}
	
	return;
}

function refreshOrganizations() {

	clearError();

	$.ajax({
		url: "api/index.php?action=fetch_organizations", 
		success: function(result){
			refreshOrganizations_callback(result);
		}
	});
	
	return;
}

function refreshOrganizations_callback(data) {

	var objResponse = JSON.parse(data);
	
	if (objResponse['successful'] && 'false' == objResponse['successful']) {
		showError(objResponse['message']);
	}
	else {
		displayOrganizations(objResponse['organizations']);	
	}
	
	return;
}

function displayOrganizations(arrContacts) {

	var strHTML = '<form class="addform"> \
					<input class="field" name="org_name" type="text" placeholder="Organization Name" required="required" /> \
					<input class="field" name="website" type="text" placeholder="Website" required="required" /> \
					<input type="button" value="Create" onclick="addOrganization($(this).parent());" /> \
					</form><br /> \
				  ';
	
	for (var x in arrContacts) {

		var iID = arrContacts[x]['id'];	
		var strOrgName = arrContacts[x]['org_name'];
		var strWebsite = arrContacts[x]['website'];

		strHTML += '<form data-id='+iID+'> \
					<input class="idfield" type="text" value="'+iID+'" disabled="disabled" /> \
					<input class="field" style="left: 50px;" name="org_name" type="text" value="'+strOrgName+'" required="required" /> \
					<input class="field" name="website" type="text" value="'+strWebsite+'" required="required" /> \
					<input type="button" value="Update" onclick="updateOrganization($(this).parent());" /> \
					<input type="button" value="Delete" onclick="deleteOrganization($(this).parent());" /> \
					</form> \
					';
					
	}
	
	var objOrgDiv = document.getElementById('organizationArea');
	objOrgDiv.innerHTML = strHTML;
	
	return;
}

function addContact(objForm) {

	clearError();

	var arrElements = $(objForm).children();
	
	var strFirstName = $(arrElements[0]).val();
	var strLastName = $(arrElements[1]).val();	
	var strEmail = $(arrElements[2]).val();	
	var strPhone = $(arrElements[3]).val();
	
	var strURL  = 'api/index.php?action=add_contact';
		strURL += '&firstname='+strFirstName;
		strURL += '&lastname='+strLastName;
		strURL += '&email='+strEmail;
		strURL += '&phone='+strPhone;
	
	$.ajax({
		url: strURL, 
		success: function(result){
			addContact_callback(result);
		}
	});	
  
}

function addContact_callback(data) {

	var objResponse = JSON.parse(data);
	
	if (objResponse['successful'] && 'false' == objResponse['successful']) {
		showError(objResponse['message']);
	}
	else {
		refreshContacts(objResponse['contacts']);	
	}

	return;
}

function updateContact(objForm) {

	clearError();

	var iId = $(objForm).data('id');
	var arrElements = $(objForm).children();
	
	var strFirstName = $(arrElements[1]).val();
	var strLastName = $(arrElements[2]).val();	
	var strEmail = $(arrElements[3]).val();	
	var strPhone = $(arrElements[4]).val();
	
	var strURL  = 'api/index.php?action=update_contact';
		strURL += '&contact_id='+iId;	
		strURL += '&firstname='+strFirstName;
		strURL += '&lastname='+strLastName;
		strURL += '&email='+strEmail;
		strURL += '&phone='+strPhone;
	
	$.ajax({
		url: strURL, 
		success: function(result){
			updateContact_callback(result);
		}
	});	
	
	return;
}

function updateContact_callback(data) {

	var objResponse = JSON.parse(data);
	
	if (objResponse['successful'] && 'false' == objResponse['successful']) {
		showError(objResponse['message']);
	}
	else {
		refreshContacts(objResponse['contacts']);	
	}

	return;
}

function addOrganization(objForm) {

	clearError();

	var arrElements = $(objForm).children();
	
	var strOrgName= $(arrElements[0]).val();
	var strWebsite = $(arrElements[1]).val();	
	
	var strURL  = 'api/index.php?action=add_organization';
		strURL += '&org_name='+strOrgName;
		strURL += '&website='+strWebsite;
	
	$.ajax({
		url: strURL, 
		success: function(result){
			addOrganization_callback(result);
		}
	});	
  
}

function addOrganization_callback(data) {

	var objResponse = JSON.parse(data);
	
	if (objResponse['successful'] && 'false' == objResponse['successful']) {
		showError(objResponse['message']);
	}
	else {
		refreshOrganizations(objResponse['contacts']);	
	}

	return;
}

function updateOrganization(objForm) {

	clearError();

	var iId = $(objForm).data('id');
	var arrElements = $(objForm).children();
	
	var strOrgName = $(arrElements[1]).val();
	var strWebsite = $(arrElements[2]).val();	
	
	var strURL  = 'api/index.php?action=update_organization';
		strURL += '&org_id='+iId;	
		strURL += '&org_name='+strOrgName;
		strURL += '&website='+strWebsite;
	
	$.ajax({
		url: strURL, 
		success: function(result){
			updateOrganization_callback(result);
		}
	});

	return;
}

function updateOrganization_callback(data) {

	var objResponse = JSON.parse(data);
	
	if (objResponse['successful'] && 'false' == objResponse['successful']) {
		showError(objResponse['message']);
	}
	else {
		refreshOrganizations(objResponse['organizations']);	
	}

	return;
}

function deleteContact(objForm) {

	clearError();

	var iId = $(objForm).data('id');
	var arrElements = $(objForm).children();
	
	var strURL  = 'api/index.php?action=delete_contact';
		strURL += '&contact_id='+iId;	
	
	$.ajax({
		url: strURL, 
		success: function(result){
			deleteContact_callback(result);
		}
	});

	return;
}

function deleteContact_callback(data) {

	var objResponse = JSON.parse(data);
	
	if (objResponse['successful'] && 'false' == objResponse['successful']) {
		showError(objResponse['message']);
	}
	else {
		refreshContacts(objResponse['contacts']);	
	}
	
	return;
}

function deleteOrganization(objForm) {

	clearError();

	var iId = $(objForm).data('id');
	var arrElements = $(objForm).children();
	
	var strURL  = 'api/index.php?action=delete_organization';
		strURL += '&org_id='+iId;	
	
	$.ajax({
		url: strURL, 
		success: function(result){
			deleteOrganization_callback(result);
		}
	});

	return;
}

function deleteOrganization_callback(data) {

	var objResponse = JSON.parse(data);
	
	if (objResponse['successful'] && 'false' == objResponse['successful']) {
		showError(objResponse['message']);
	}
	else {
		refreshOrganizations(objResponse['organizations']);	
	}
	
	return;
}
