<!DOCTYPE html>
<html>
<head>
</head>

<?php
	$shopLogin = 'GESPAYXXXX';
	$currency = '242';
	$importo = '0.05';
	$shopTransactionID='aBgtsr234wZy75';
	require_once($_SERVER["DOCUMENT_ROOT"]."/nusoap.php");
	$wsdl = "https://testecomm.sella.it/gestpay/gestpayws/WSCryptDecrypt.asmx?WSDL";
	$client = new soapclient($wsdl,true); 
	$param = array('shopLogin' => $shopLogin, 'uicCode' => $currency, 'amount' => $importo, 'shopTransactionId' => $shopTransactionID); //,'buyerName' => '', 'buyerEmail' => '', 'languageId' => '1', 'customInfo' => '');
	$objectresult = $client->call('Encrypt', $param);?>
	<body>
	<?
	$err = $client->getError();
	if ($err) {
	        // Display the error
		echo '<h2>Error</h2><pre>' . $err . '</pre>';
	} else {
	// Display the result
		
		/*echo "<pre><I>";
		print_r ($objectresult);
		echo "</I>";  
		echo "</pre>";  */
    
    	$errCode = $objectresult['EncryptResult']['GestPayCryptDecrypt']['ErrorCode'];

    	if ($errCode == '0') {
    		$encString = $objectresult['EncryptResult']['GestPayCryptDecrypt']['CryptDecryptString'];
    	?>
    		<form name="GestPayPaymentPage" method="post" action="https://testecomm.sella.it/pagam/pagam.aspx" id="GestPayPaymentPage">
    			<input type="hidden" name="a" value="<? echo($shopLogin) ?>" />
    			<input type="hidden" name="b" value="<? echo($encString) ?>" />
    		</form>
    		<script>
    			document.getElementById('GestPayPaymentPage').submit();
    		</script>
    		
		
		<?
		}else{

			echo '<div style=color:red;font-weight:bold;>Error:';
			echo $errCode;
			echo '<br>ErrorDesc:';
			echo $objectresult['EncryptResult']['GestPayCryptDecrypt']['ErrorDescription'] ;
			echo '</div>';
		}
	}	
?>






</body>
</html>