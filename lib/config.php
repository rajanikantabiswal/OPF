<?php

// Set parameters provided by gateway

define('ENC_KEY', '5EC4A697141C8CE45509EF485EE7D4B1'); 
define('SECURE_SECRET', 'E59CD2BF6F4D86B5FB3897A680E0DD3E'); 
define('VERSION', '1'); 
define('PASSCODE', 'SVPL4257'); 
define('MERCHANTID', '101000000000781'); 
define('BANKID', '000004'); 
define('TERMINALID', '10100781'); 
define('MCC', '5137'); 
define('GATEWAYURL', 'https://sandbox.isgpay.com/ISGPay-Genius/request.action'); 
define('STATUSURL', 'https://sandbox.isgpay.com/ISGPay-Genius/Status'); 
define('REFUNDURL', 'http://localhost/OPF/callpack.php');
define('RETURNURL', 'http://localhost/OPF/callback.php'); // define('RETURNURL', 'YOUR_DOMAIN/ISGPAY_PHP/responseSale.php');

?>