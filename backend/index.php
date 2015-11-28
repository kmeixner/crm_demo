<?php
error_reporting(E_ALL); // Note: FALSE to suppress error reporting, E_ALL to report all

require_once('Crm_Api.class.php');
$objAPI = new Crm_Api();

//echo $objAPI->addContact('Bugs','Bunny','henry@forest.com','1-800-555-1212');
//echo $objAPI->addOrganization('Runes','www.runes.com');

//echo $objAPI->getOrganizations();
//echo $objAPI->getContacts();

//$result = $objAPI->deleteOrganization(2);
//echo var_export($result, TRUE);

//$result = $objAPI->updateOrganization(5,'Smurfyland','www.smurfy.com');
//echo var_export($result, TRUE)

$strAction = $_REQUEST['action'];

if (empty($strAction)) {
	echo $objAPI->showError('Action is a required parameter');
	die();
}

switch ($strAction) {
	
	case 'fetch_contacts':
		echo $objAPI->getContacts();
		break;
		
	case 'fetch_organizations':
		echo $objAPI->getOrganizations();
		break;
		
	case 'add_contact':
	
		
		echo $objAPI->showMessage('TO DO: add_contact.');	
		break;
		
	case 'add_organization':

		$iId = $objAPI->addOrganization(
			$_REQUEST['org_name'],
			$_REQUEST['website']			
		);
		
		if (!empty($iId)) {
		  echo $objAPI->showMessage($iId);
		}
		else {
		  echo $objAPI->showError($objAPI->getError());		
		}
		
		break;

	case 'update_contact':
		echo $objAPI->showMessage('TO DO: update_contact.');	
		break;

	case 'update_organization':
		echo $objAPI->showMessage('TO DO: update_organization.');	
		break;
		
	case 'delete_contact':
		echo $objAPI->showMessage('TO DO: delete_contact.');	
		break;
		
	case 'delete_organization':
		echo $objAPI->showMessage('TO DO: delete_organization.');	
		break;

	default:
		echo $objAPI->showMessage('Unsupported Action.',FALSE);
}