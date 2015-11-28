<?php

require_once('DBComm.class.php');

class Crm_Api {

	function __construct() {
		$this->dbcomm = new DBComm();
		return;
	}
	
	/**
	 * Returns a JSON format success/error message.
	 *
	 * @param string $strMessage: the message (required)
	 * @param boolean $blnSuccessful: FALSE for error, TRUE otherwise (Default: TRUE)
	 *
	 * @returns JSON: the message
	 */
	function showMessage($strMessage, $blnSuccessful=TRUE) {
	
		$arrJSON = array();
		$arrJSON['message'] = $strMessage;
		
		if ($blnSuccessful) {
			$arrJSON['successful'] = 'true';
		}
		else {
			$arrJSON['successful'] = 'false';		
		}
		
		return json_encode($arrJSON);
	}
	
	/**
	 * Returns a JSON formaterror message.
	 *
	 * @param string $strMessage: the message (required)
	 *
	 * @returns JSON: the error message
	 */	
	function showError($strMessage) {
		return $this->showMessage($strMessage,FALSE);
	}	
	
	/**
	 * Returns error message
	 *
	 * @returns string: the error message
	 */
	function getError() {
		return $this->error;
	}
	
	/**
	 * Returns organization list.
	 *
	 * @returns JSON: organization list
	 */
	function getOrganizations() {
	
		return $this->jsonify(
			'organizations', 
			$this->dbcomm->getOrganizationsFromDB()
		);
	}
   
	/**
	 * Returns contact list.
	 *
	 * @returns JSON: contact list
	 */   
	function getContacts() {
	
		return $this->jsonify(
			'contacts', 
			$this->dbcomm->getContactsFromDB()
		);
	}
	
	function addContact(
		$strFirstname,
		$strLastname,
		$strEmail,
		$strPhone
	) {
	
		if (empty($strFirstname)) {
			$this->error = 'Add Contact: Firstname is a required parameter';
			return FALSE;
		}
		
		if (empty($strLastname)) {
			$this->error = 'Add Contact: Lastname is a required parameter';
			return FALSE;
		}

		if (empty($strEmail)) {
			$this->error = 'Add Contact: email is a required parameter';
			return FALSE;
		}

		if (empty($strPhone)) {
			$this->error = 'Add Contact: phone is a required parameter';
			return FALSE;
		}		
	
		$iId = $this->dbcomm->addContactToDB(
			$strFirstname,
			$strLastname,
			$strEmail,
			$strPhone
		);
		
		if (empty($iId)) {
			$this->error = 'Add Contact: There was a problem adding the contact to the database.';
			return FALSE;
		}
		
		return $iId;
	}
	
	function addOrganization(
		$strOrgName,
		$strWebsite
	) {
	
		if (empty($strOrgName)) {
			$this->error = 'Add Organization: organization is a required parameter';
			return FALSE;
		}

		if (empty($strWebsite)) {
			$this->error = 'Add Organization: website is a required parameter';
			return FALSE;
		}		

		$iId = $this->dbcomm->addOrganizationToDB(
			$strOrgName,
			$strWebsite
		);
		
		if (empty($iId)) {
			$this->error = 'Add Organization: There was a problem adding the organization to the database.';
			return FALSE;
		}

		return $iId;
	}
	
	function deleteContact($iId) {
	
		if (empty($iId)) {
			$this->error = 'Delete Contact: Invalid parameters received.';			
			return FALSE;
		}
		
		return $this->dbcomm->deleteContactFromDB($iId);
	}
	
	function deleteOrganization($iId) {
	
		if (empty($iId)) {
			$this->error = 'Delete Organization: Invalid parameters received.';	
			return FALSE;
		}
	
		return $this->dbcomm->deleteOrganizationFromDB($iId);	
	}
	
	function updateContact(
		$iId,
		$strFirstname,
		$strLastname,
		$strEmail,
		$strPhone
	) {
	
		if (empty($iId)) {
			$this->error = 'Update Contact: Invalid parameters received.';	
			return FALSE;
		}

		if (empty($strFirstname)) {
			$this->error = 'Add Contact: Firstname is a required parameter';
			return FALSE;
		}
		
		if (empty($strLastname)) {
			$this->error = 'Add Contact: Lastname is a required parameter';
			return FALSE;
		}

		if (empty($strEmail)) {
			$this->error = 'Add Contact: email is a required parameter';
			return FALSE;
		}

		if (empty($strPhone)) {
			$this->error = 'Add Contact: phone is a required parameter';
			return FALSE;
		}		
	
		return $this->dbcomm->updateContactInDB(
			$iId,
			$strFirstname,
			$strLastname,
			$strEmail,
			$strPhone
		);		
	}
	
	function updateOrganization(
		$iId,
		$strOrgName,
		$strWebsite
	) {
	
		if (empty($iId)) {
			$this->error = 'Update Organization: Invalid parameters received.';	
			return FALSE;
		}

		if (empty($strOrgName)) {
			$this->error = 'Update Organization: Organization is a required parameter';
			return FALSE;
		}

		if (empty($strWebsite)) {
			$this->error = 'Update Organization: Website is a required parameter';
			return FALSE;
		}

		return $this->dbcomm->updateOrganizationInDB(
			$iId,
			$strOrgName,
			$strWebsite
		);		
	}

	/**
	 * Converts a list of results from the database into JSON.
	 *
	 * @param string $strLabel: name to tag the result list with
	 * @param array $arrResults: array of results
	 *
	 * @returns JSON: the results
	 */
	function jsonify($strLabel, $arrResults) {

		 $arrJSON = array();
		 $arrJSON[$strLabel] = $arrResults;

		 return json_encode($arrJSON);
	}
   
	/**
	* @param string $strUser: the username
	* @param string $strPwd: the user password
	* 
	* @return boolean: TRUE if login successful, FALSE otherwise
	*/
	function authenticate($strUser, $strPwd) {
		return TRUE; // placeholder, hard-code as TRUE for now
	}

	function isLoggedOn($strUser) {
		return TRUE; // placeholder, hard-code as TRUE for now
	}   

}