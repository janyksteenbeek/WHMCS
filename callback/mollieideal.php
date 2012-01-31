<?php

# Required File Includes
include("../../../dbconnect.php");
include("../../../includes/functions.php");
include("../../../includes/gatewayfunctions.php");
include("../../../includes/invoicefunctions.php");

$gatewaymodule = "mollieideal"; # Enter your gateway module name here replacing mollieideal

$GATEWAY = getGatewayVariables($gatewaymodule);

if (!$GATEWAY["type"]) die("Module Not Activated"); # Checks gateway module is active before accepting callback

# Get Returned Variables - Adjust for Post Variable Names from your Gateway's Documentation
$invoiceid = urldecode($_GET["invoiceid"]);
$transid = $_GET["transaction_id"];
$amount = urldecode($_GET["amount"]);
$fee = urldecode($_GET["fee"]);

//$invoiceid = checkCbInvoiceID($invoiceid,$GATEWAY["name"]); # Checks invoice ID is a valid invoice number or ends processing

checkCbTransID($transid); # Checks transaction number isn't already in the database and ends processing if it does

if (isset($transid)) 
{ 

	$iDEAL = new iDEAL_Payment($GATEWAY['partnerid']);
	
	$iDEAL->checkPayment($_GET["transaction_id"]);

	if ($iDEAL->getPaidStatus() == true) {
	    # Successful
	    addInvoicePayment($invoiceid,$transid,$amount,$fee,$gatewaymodule); # Apply Payment to Invoice: invoiceid, transactionid, amount paid, fees, modulename
		logTransaction($GATEWAY["name"],$_GET,"Successful"); # Save to Gateway Log: name, data array, status
	} else {
		# Unsuccessful
	    logTransaction($GATEWAY["name"],$_GET,"Unsuccessful"); # Save to Gateway Log: name, data array, status
	}
}


?>