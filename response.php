.<?php
require("nusoap.php");

$test_env = true;

if ($test_env) {
		$wsdl = "https://testecomm.sella.it/gestpay/gestpayws/WSCryptDecrypt.asmx?WSDL"; //TESTCODES 
	} else {
		$wsdl = "https://ecomms2s.sella.it/gestpay/gestpayws/WSCryptDecrypt.asmx?WSDL"; //PRODUCTION
	}

$client = new nusoap_client($wsdl,true);

$shopLogin = $_GET["a"];

$CryptedString = $_GET["b"];

echo '<p><strong>Shop Login:</strong> '. $shopLogin . '</p>';

echo '<p><strong>Crypted String:</strong> '. $CryptedString . '<p/>';

$params = array('shopLogin' => $shopLogin, 'CryptedString' => $CryptedString);


$objectresult = $client->call('Decrypt',$params);


$err = $client->getError();


if ($err) {
	
	// 	Display the error
	echo '<h2>Error</h2><pre>' . $err . '</pre>';
	
}
else {
	
	// 	Display the result
	echo '<h2></h2>';
	
	
	echo '<h2>Result</h2>';
	
	echo '<pre>';
	
	
	print_r ($objectresult);
	
	echo '</pre>';
	
}


?>