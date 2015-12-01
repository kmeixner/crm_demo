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
	
		$strSQL = 'SELECT * FROM organization ORDER BY org_name';
		$results = $this->db->query($strSQL);	
		
		return $results;
	}
	
	/**
	 * Fetch contact list.
	 *
	 * @returns array: list of contacts
	 */	
	function getContactsFromDB() {
	
		$strSQL = 'SELECT * FROM contact ORDER BY firstname, lastname';
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
		$strINSERT .= "'".$this->db->sanitize($strFirstname)."'";
		$strINSERT .= ",'".$this->db->sanitize($strLastname)."'";
		$strINSERT .= ",'".$this->db->sanitize($strEmail)."'";
		$strINSERT .= ",'".$this->db->sanitize($strPhone)."'";    
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
		$strINSERT .= "'".$this->db->sanitize($strOrgName)."'";
		$strINSERT .= ",'".$this->db->sanitize($strWebsite)."'";
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
		$sqlDELETE = "DELETE FROM contact WHERE id='".$this->db->sanitize($iId)."'";
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
		$sqlDELETE = "DELETE FROM organization WHERE id='".$this->db->sanitize($iId)."'";
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
		$strUPDATE .= "firstname='".$this->db->sanitize($strFirstname)."'";
		$strUPDATE .= ",lastname='".$this->db->sanitize($strLastname)."'";
		$strUPDATE .= ",email='".$this->db->sanitize($strEmail)."'";
		$strUPDATE .= ",phone='".$this->db->sanitize($strPhone)."'";		
		$strUPDATE .= " WHERE id='".$this->db->sanitize($iId)."'";

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
		$strUPDATE .= "org_name='".$this->db->sanitize($strOrgName)."'";
		$strUPDATE .= ",website='".$this->db->sanitize($strWebsite)."'";
		$strUPDATE .= " WHERE id='".$this->db->sanitize($iId)."'";

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
		
		$strSQL = "SELECT id FROM contact WHERE email='".$this->db->sanitize($strEmail)."'";
		
		if (!empty($iOmitId))
			$strSQL .= " WHERE id != ".$this->db->sanitize($iOmitId);
		
		$result = $this->db->query($strSQL);
		
		if (empty($result)) {
			return FALSE;
		}
		else {
			return TRUE;
		}
	}
	
	/**
	 * Assigns a contact to an organization.
	 *
	 * @param int $iContactId: the contact id
	 * @param int $iOrgId: the organization id	 
	 *
	 * @returns int: the id of the org_contact record created or FALSE upon failure
	 */
	function linkContactToOrgInDB($iContactId, $iOrgId) {
	
		$strINSERT  = 'INSERT INTO org_contact (org_id, contact_id) VALUES ( ';
		$strINSERT .= "'".$this->db->sanitize($iContactId)."'";
		$strINSERT .= ",'".$this->db->sanitize($iOrgId)."'";
		$strINSERT .= ')';

		return $this->db->update($strINSERT);	
	}
	
	/**
	 * Deletes an organization.
	 *
	 * @param int $iId: the organization id (required)
	 *
	 * @returns boolean: TRUE if successful, FALSE otherwise
	 */		
	function unlinkContactFromOrgInDB($iLinkId) {
		$sqlDELETE = "DELETE FROM org_contact WHERE id='".$this->db->sanitize($iLinkId)."'";
		return $this->db->update($sqlDELETE);	
	}
	
}	