<?php
require_once('DB.class.php');

class DBComm {

	function __construct() {
		$this->db = new DB();
		return;
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

	function deleteContactFromDB($iId) {
		$sqlDELETE = "DELETE FROM contact WHERE id='".$iId."'";
		return $this->db->update($sqlDELETE);
	}
	
	function deleteOrganizationFromDB($iId) {
		$sqlDELETE = "DELETE FROM organization WHERE id='".$iId."'";
		return $this->db->update($sqlDELETE);	
	}

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
	
}	