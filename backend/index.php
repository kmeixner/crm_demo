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

$result = $objAPI->updateOrganization(5,'Smurfyland','www.smurfy.com');

echo var_export($result, TRUE)



?>