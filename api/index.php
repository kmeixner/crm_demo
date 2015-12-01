<?php
error_reporting(E_ALL); // Note: FALSE to suppress error reporting, E_ALL to report all

require_once('Crm_Api.class.php');
$objAPI = new Crm_Api();


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
	
		$iId = $objAPI->addContact(
			$_REQUEST['firstname'],
			$_REQUEST['lastname'],
			$_REQUEST['email'],
			$_REQUEST['phone']
		);
		
		if (!empty($iId)) {
		  echo $objAPI->showMessage($iId);
		}
		else {
		  echo $objAPI->showError($objAPI->getError());		
		}
		
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

		$successful = $objAPI->updateContact(
			$_REQUEST['contact_id'],
			$_REQUEST['firstname'],
			$_REQUEST['lastname'],
			$_REQUEST['email'],
			$_REQUEST['phone']
		);
		
		if ($successful) {
		  echo $objAPI->showMessage('Contact Updated: '.$_REQUEST['id']);
		}
		else {
		  echo $objAPI->showError($objAPI->getError());		
		}
	
		break;

	case 'update_organization':

		$successful = $objAPI->updateOrganization(
			$_REQUEST['org_id'],
			$_REQUEST['org_name'],
			$_REQUEST['website']
		);
		
		if ($successful) {
		  echo $objAPI->showMessage('Organization Updated: '.$_REQUEST['id']);
		}
		else {
		  echo $objAPI->showError($objAPI->getError());		
		}
	
		break;
		
	case 'delete_contact':

		$successful = $objAPI->deleteContact(
			$_REQUEST['contact_id']
		);
		
		if ($successful) {
		  echo $objAPI->showMessage('Contact Deleted: '.$_REQUEST['id']);
		}
		else {
		  echo $objAPI->showError($objAPI->getError());		
		}	
	
		break;
		
	case 'delete_organization':

		$successful = $objAPI->deleteOrganization(
			$_REQUEST['org_id']
		);
		
		if ($successful) {
		  echo $objAPI->showMessage('Contact Deleted: '.$_REQUEST['org_id']);
		}
		else {
		  echo $objAPI->showError($objAPI->getError());		
		}		
	
		break;

	default:
		echo $objAPI->showMessage('Unsupported Action.',FALSE);
}