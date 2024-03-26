<?php
function send_payment_gatway($TxnRefNo,$amount){
set_time_limit(0);

require_once ('lib/Utility.php');
require_once('lib/config.php');
$utility = new Utility();

$logFilePath = 'sale_log.log';

$EncKey = ENC_KEY;
$SECURE_SECRET = SECURE_SECRET;
$gatewayURL = GATEWAYURL;

// get inputs
$data =[];
$data['payOpt'] = "3PARTY";
$data['TxnRefNo'] = $TxnRefNo;
$data['Currency'] = 356;
$data['Version'] = VERSION;
$data['PassCode'] = PASSCODE;
$data['BankId'] = BANKID;
$data['MerchantId'] = MERCHANTID;
$data['MCC'] = MCC;
$data['TerminalId'] = TERMINALID;
$data['ReturnURL'] = RETURNURL."?trans_id=".$TxnRefNo;
$data['Amount'] = $amount*100;
//Remove Unwanted POST Variable
unset($data["SubButL"]);

//------- sort on keys
ksort($data);
$dataToPostToPG="";
foreach ($data as $key => $value) 
{
	if("" == trim($value) && $value === NULL){
	//
	} else {
		$dataToPostToPG=$dataToPostToPG.$key."||".($value)."::";
	}
}

//Generate Secure hash on parameters
$SecureHash = $utility->generateSecurehash($data);
//Appending hash and data with ::
$dataToPostToPG="SecureHash||".urlencode($SecureHash)."::".$dataToPostToPG;
//Removing last 2 characters (::)
$dataToPostToPG=substr($dataToPostToPG, 0, -2);

//Save request to log
// $dataArray = explode("::", $dataToPostToPG);
// $currentTime = date('d-m-Y H:i:s'); // Get current timestamp with date and time
// $logRequest = 'Request:'."[$currentTime]"; // Include timestamp in the log message
// $logRequest .= json_encode($dataArray);
// $logFile = fopen($logFilePath, 'a');
// fwrite($logFile, $logRequest . PHP_EOL.PHP_EOL);
// fclose($logFile);

/*encrypting data with AES*/	
$EncData=$utility->encrypt($dataToPostToPG, $EncKey);
?>
<!-- Submit the data to sale api -->
<form action="<?php echo $gatewayURL ?>" method="post" name="server_request" id="sales-api-form" target="_top" >
	<input type="hidden" name="EncData" id="EncData" value="<?php echo  $EncData; ?>">
	<input type="hidden" name="MerchantId" id="MerchantId" value="<?php echo $data['MerchantId']; ?>" />
	<input type="hidden" name="BankId" id="BankId" value="<?php echo $data['BankId']; ?>" />
	<input type="hidden" name="TerminalId" id="TerminalId" value="<?php echo $data['TerminalId']; ?>">
	<input type="hidden" name="Version" id="Version" value="<?php echo $data['Version']; ?>">
</form>
<script type="text/javascript">
	document.server_request.submit(); 
</script>
<?php
}
?>