<!DOCTYPE HTML>

<?php
/**
To use this example: 
1. create a test account on GESTPAY. You'll receive via mail the ShopLogin  ("codice esercente").
2. In the administration area, insert the public IP address of your server (you can use whatsmyip or create a tunnel via ngrok )
3. If the variable $test_env is true, the example will use the test environment; otherwise it will try to reach out to the production environment. 
*/
	$test_env = true; 
	$shopLogin = 'GESPAYXXXXX';
	$currency = '242'; //EURO 
	$amount = '10.05';
	$shopTransactionID='123456790';

	if ($test_env) {
		$wsdl = "https://testecomm.sella.it/gestpay/gestpayws/WSCryptDecrypt.asmx?WSDL"; //TESTCODES
		$action_pagamento = "https://testecomm.sella.it/pagam/pagam.aspx"; 
	} else {
		$wsdl = "https://ecomms2s.sella.it/gestpay/gestpayws/WSCryptDecrypt.asmx?WSDL"; //PRODUCTION
		$action_pagamento = "https://ecomm.sella.it/pagam/pagam.aspx";
	}
	
	// this snippet tries to retrieve the public ip address
	//put your public ip address in gestpay merchant backoffice 
	$externalContent = file_get_contents('http://checkip.dyndns.com/');
	preg_match('/Current IP Address: \[?([:.0-9a-fA-F]+)\]?/', $externalContent, $m);
	$externalIp = $m[1];
	echo "<p>IP for Gestpay configuration: $externalIp </p>"; 
	
	require("nusoap.php");

	$client = new nusoap_client($wsdl,true);

	$param = array(
    'shopLogin' => $shopLogin 
    ,'uicCode' => $currency
    ,'amount' => $amount
    ,'shopTransactionId' => $shopTransactionID
  );

echo "<p>Data that will be sent to Gestpay WsCryptDecrypt.Encrypt method: </p>";
echo '<pre>';
print_r ($param);
echo '</pre>';

$objectresult = $client->call('Encrypt', $param); 

$err = $client->getError();
$errCode= $objectresult['EncryptResult']['GestPayCryptDecrypt']['ErrorCode'];
$encString = $objectresult['EncryptResult']['GestPayCryptDecrypt']['CryptDecryptString'];
$errDesc= $objectresult['EncryptResult']['GestPayCryptDecrypt']['ErrorDescription'] ;
?>
<html>
	<body>
		<h1>TEST PAYMENT</h1>

		<!-- if there is an error trying to contact Gestpay Server (e.g. your IP address is not recognized, or the shopLogin is invalid) you'll see it here. -->
		<?php	if($errCode !== '0'){ ?>
		<h2>Error: <?php echo $errCode ?> - <?php echo $errDesc ?></h2>

	<?php } ?>

	We will start a payment with this data: <br>
	shopLogin: <?= $shopLogin ?><br>
	amount: <?= $amount ?> &euro;

	<!--hidden form, with cyphered data to start the payment process -->
	<form 
		name="pagamento" 
		method="post" 
		id="fpagam" 
		action="<?= $action_pagamento ?> ">
		<input name="a" type="hidden" value="<?php echo($shopLogin) ?>" />
		<input name="b" type="hidden" value="<?php echo($encString) ?>" />
		<input style="width:90px;height:70px" type="submit" name="Pay" Value="Pay Now!" />
	</form>
	</body>
</html>