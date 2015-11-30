<?php
require_once('DB.class.php');

/**
 * @class DBComm
 *
 * This class performs the actual SQL queries to the database.
 */
class DBComm {

	function __construct() {
		$this->db = new DB();
		return;
	}
	
	/**
	 * Fetch organization list.
	 *
	 * @returns array: list of organizations
	 */
	function getOrganizationsFromDB() {
	
		$strSQL = 'SELECT * FROM organization';
		$results = $this->db->query($strSQL);	
		
		return $results;
	}
	
	/**
	 * Fetch contact list.
	 *
	 * @returns array: list of contacts
	 */	
	function getContactsFromDB() {
	
		$strSQL = 'SELECT * FROM contact';
		$results = $this->db->query($strSQL);
	
		return $results;
	}

	/**
	 * Create a new contact.
	 *
	 * @param string $strFirstname: the first name (required)
	 * @param string $strLastname: the last name (required)
	 * @param string $strEmail: the email (required)
	 * @param string $strPhone: the phone number (required)
	 *
	 * @returns int: the id of the new contact (or FALSE upon error)
	 */		
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
   
	/**
	 * Create a new organization.
	 *
	 * @param string $strOrgName: the organization name (required)
	 * @param string $strWebsite: the website (required)
	 *
	 * @returns int: the id of the new organization (or FALSE upon error)
	 */	   
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

	/**
	 * Deletes a contact.
	 *
	 * @param int $iId: the contact id (required)
	 *
	 * @returns boolean: TRUE if successful, FALSE otherwise
	 */		
	function deleteContactFromDB($iId) {
		$sqlDELETE = "DELETE FROM contact WHERE id='".$iId."'";
		return $this->db->update($sqlDELETE);
	}
	
	/**
	 * Deletes an organization.
	 *
	 * @param int $iId: the organization id (required)
	 *
	 * @returns boolean: TRUE if successful, FALSE otherwise
	 */			
	function deleteOrganizationFromDB($iId) {
		$sqlDELETE = "DELETE FROM organization WHERE id='".$iId."'";
		return $this->db->update($sqlDELETE);	
	}

	/**
	 * Updates a contact.
	 *
	 * @param int $iId: the contact id (required)	 
	 * @param string $strFirstname: the first name (required)
	 * @param string $strLastname: the last name (required)
	 * @param string $strEmail: the email (required)
	 * @param string $strPhone: the phone number (required)
	 *
	 * @returns boolean: TRUE if successful, FALSE otherwise
	 */		
	function updateContactInDB(
		$iId,
		$strFirstname,
		$strLastname,
		$strEmail,
		$strPhone
	) {
	
		$strUPDATE  = 'UPDATE contact SET ';
		$strUPDATE .= "firstname='".$strFirstname."'";
		$strUPDATE .= ",lastname='".$strLastname."'";
		$strUPDATE .= ",email='".$strEmail."'";
		$strUPDATE .= ",phone='".$strPhone."'";		
		$strUPDATE .= " WHERE id='".$iId."'";

		return $this->db->update($strUPDATE);
	}
	
	/**
	 * Updates an organization.
	 *
	 * @param int $iId: the contact id (required)	 
	 * @param string $strOrgName: the first name (required)
	 * @param string $strWebsite: the last name (required)
	 *
	 * @returns boolean: TRUE if successful, FALSE otherwise
	 */		
	function updateOrganizationInDB(
		$iId,
		$strOrgName,
		$strWebsite
	) {
	
		$strUPDATE  = 'UPDATE organization SET ';
		$strUPDATE .= "org_name='".$strOrgName."'";
		$strUPDATE .= ",website='".$strWebsite."'";
		$strUPDATE .= " WHERE id='".$iId."'";

		return $this->db->update($strUPDATE);
	}
	
	/**
	 * This returns whether or not a contact already exists that has the
	 * given email.
	 *
	 * @param string $strEmail: the email
	 * @param int $iOmitId: (optional) if included don't check the record 
	 *   with this id
	 *
	 * @returns TRUE if email found, FALSE otherwise
	 */
	function emailExistInContactsInDB($strEmail, $iOmitId=NULL) {
		
		$strSQL = "SELECT id FROM contact WHERE email='".$strEmail."'";
		
		if (!empty($iOmitId))
			$strSQL .= " WHERE id != ".$iOmitId;
		
		$result = $this->db->query($strSQL);
		
		if (empty($result)) {
			return FALSE;
		}
		else {
			return TRUE;
		}
	}
	
}	