<?php
include 'db.php';

$sql = "SELECT  COUNT(*) as rowCount FROM OPF where trans_id='".  htmlspecialchars($_GET["trans_id"])."'"; // Replace with your table name
$result = $conn->query($sql);

if ($result) {
    $row = mysqli_fetch_assoc($result);
    $rowCount = $row['rowCount'];
    // echo "Number of rows: " . $rowCount;
    if ($rowCount==0){
        header("Location: payment-failed.php");
    }


} else {
    header("Location: payment-failed.php");
    
}

?>


<h3 style="margin-top:10%;text-align:center">Please Wait....</h3>

<form action="processSaleStatus.php" id="myForm" method="post" style="display:none">
            <table width="80%" align="center" border="0" cellpadding="0" cellspacing="0">
                <tbody><tr>
                    <td colspan="2"><h3>STATUS QUERY FIELDS:</h3></td>
                </tr>
                <tr>
                    <td><strong><em>Merchant Txn. Ref. No</em></strong></td>
                    <td><input type="text" name="TxnRefNo" value="<?= $_GET["trans_id"] ?>" size="40" maxlength="40"></td>
                </tr>
                <tr>
                    <td><strong><em>Txn Type:</em></strong></td>
                    <td><input type="text" name="TxnType" value="Status" size="40" maxlength="40" readonly=""></td>
                </tr>
                <tr>
                    <td></td>
                    <td><input type="submit"  id = "validate" name="SubButL" value="submit"></td>
                </tr>
            </tbody></table>
        </form>
<script>

document.getElementById("validate").click();

</script>


