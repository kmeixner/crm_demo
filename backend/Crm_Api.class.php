<?php

require_once('DB.class.php');

class Crm_Api {

	function __construct($blnVerbose=FALSE) {
		$this->db = new DB();
		return;
	}
	
	function getError() {
		return $this->error;
	}
	
	function getOrganizations() {
		return $this->jsonify('organizations', $this->getOrganizationsFromDB());
	}
   
	function getContacts() {
		return $this->jsonify('contacts', $this->getContactsFromDB());
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
	
		$iId = $this->addContactToDB(
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

		$iId = $this->addOrganizationToDB(
			$strOrgName,
			$strWebsite
		);
		
		if (empty($iId)) {
			$this->error = 'Add Organization: There was a problem adding the organization to the database.';
			return FALSE;
		}

		return $iId;
	}  	
	
	function getOrganizationsFromDB() {
	
		$strSQL = 'SELECT * FROM organization';
		$results = $this->db->query($strSQL);	
		
		return $results;
	}
	
	function getContactsFromDB() {
	
		$strSQL = 'SELECT * FROM contact';
		$results = $this->db->query($strSQL);
	
		return $results;
	}

	function addContactToDB(
		$strFirstname,
		$strLastname,
		$strEmail,
		$strPhone
	) {

		$strINSERT  = 'INSERT INTO contact (firstname,lastname,email,phone) VALUES (';
		$strINSERT .= "'".$strFirstname."'";
		$strINSERT .= ",'".$strLastname."'";
		$strINSERT .= ",'".$strEmail."'";
		$strINSERT .= ",'".$strPhone."'";    
		$strINSERT .= ')';

		$iID = $this->db->update($strINSERT);

		return $iID;
	}
   
	function addOrganizationToDB(
		$strOrgName,
		$strWebsite
	) {

		$strINSERT  = 'INSERT INTO organization (org_name,website) VALUES (';
		$strINSERT .= "'".$strOrgName."'";
		$strINSERT .= ",'".$strWebsite."'";
		$strINSERT .= ')';

		$iID = $this->db->update($strINSERT);

		return $iID;
	}   

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