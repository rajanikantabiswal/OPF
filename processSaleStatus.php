<?php
ini_set('display_errors', 1);
error_reporting(E_ERROR | E_WARNING | E_PARSE);
include 'db.php';

// get inputs
$data = $_POST;

require_once ('lib/Utility.php');
require_once('lib/config.php');
$utility = new Utility();

$EncKey = ENC_KEY;
$SECURE_SECRET = SECURE_SECRET;
$gatewayURL = STATUSURL;
$data['BankId'] = BANKID;
$data['MerchantId'] = MERCHANTID;
$data['TerminalId'] = TERMINALID;
$data['PassCode'] = PASSCODE;
$data['MCC'] = MCC;


//Remove Unwanted POST Variable
unset($data["SubButL"]);

//------ remove null values
//$data = array_filter($data);

//------- sort on keys
$value=ksort($data);
$dataToPostToPG="";

$SecureHash = $utility->generateSecurehash($data);

foreach ($data as $key => $value) 
{
    if("" == trim($value) && $value === NULL){
     	//
    } else {
		$dataToPostToPG=$dataToPostToPG.$key."=".urlencode($value)."&";
	}
}

$dataToPostToPG="SecureHash=".urlencode($SecureHash)."&".$dataToPostToPG;
$dataToPostToPG=substr($dataToPostToPG, 0, -1);

//Generate Secure hash on parameters
$response = "";

// Do Post to Payment Gateway
set_time_limit(0);
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "$gatewayURL");
curl_setopt($ch, CURLOPT_WRITEFUNCTION, 'cgets');
curl_setopt($ch, CURLOPT_BUFFERSIZE, 128);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false); 
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_TIMEOUT, 1000000);
curl_setopt($ch, CURLOPT_POSTFIELDS, $dataToPostToPG);
curl_exec($ch);
$info = curl_getinfo($ch);

function cgets($ch, $string) 
{
    global $response;
	$length = strlen($string);
    $response .= $string;
    flush();
    return $length;
}

//Parse and Show response received from PG
$responseArray = parseResponse($response);
 //showResponse($responseArray);


if ($responseArray["ResponseCode"]==00){
// Values to update
$idToUpdate = $responseArray["TxnRefNo"]; // ID of the row to update
$newValue = "1"; // New value to set

// SQL query to update a specific row
// $sql = "UPDATE OPF SET is_payment_done = ? WHERE trans_id = ?";
$sql = "UPDATE OPF SET is_payment_done = '$newValue' WHERE trans_id ='". $idToUpdate."'";

if (mysqli_query($conn, $sql)) {
    ?>
	<script>
		window.location.href='payment-success.php?trans=<?= $responseArray["TxnRefNo"] ?>';
		</script>
   
	<?php
    
	
} else {
	echo "Error updating record: " . $conn->error;
	?>
	<script>
		window.location.href='payment-failed.php';
		</script>
   
	<?php
}




}
else{
	?>
	<script>
		window.location.href='payment-failed.php';
		</script>
   
	<?php
}



//Parse Response received
function parseResponse($response)
{
	$responseArray = array();
	if($response)
	{
		$params = explode("&", $response);
		foreach ($params as $value)
		{
			$responseParams = explode("=", $value);
			$responseArray[$responseParams[0]] = $responseParams[1];
		}
	}
	return $responseArray;
}


//Show response received
function showResponse($responseArray)
{ ?>
<style type="text/css">
	* { font-family:sans-serif; }
	h1 {font-size: 20px;font-weight: 600;margin-bottom: 5px; color: #08185A;}
	h4 {text-align: center;}
	.shade { height:30px; background-color:#E1E1E1 }	
</style>
<center><h1>STATUS RESPONSE <?php 

echo $responseArray["ResponseCode"];

?>
</h1></center><hr>

	<table width="60%" align="center" border="0" cellpadding='0' cellspacing='0'>
		<?php
			$n = 0;
			foreach($responseArray as $key=>$_responseArray) { ?>
				<tr class="<?php if($n%2 == 0) { echo 'shade'; }?>">
			        <td><strong><em><?php echo $key; ?> </em></strong></td>
			        <td><?php echo $_responseArray; ?></td>
			    </tr>

			<?php $n++;
			}
		?>
	</table>

<?php	
}
?>
