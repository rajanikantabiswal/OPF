<?php
include 'db.php';
include 'processSale.php';

function generateTransactionID() {
    $prefix = 'TXN'; // Prefix for the transaction ID
    $uniqueID = uniqid(); // Unique identifier
    $randomString = bin2hex(random_bytes(3)); // Random string

    $transactionID = $prefix . '_' . $uniqueID . '_' . $randomString;
    return $transactionID;
}


$filed_array = ["first_name","middle_name","last_name","address","post_office","police_station","district","state","pincode","mobile_no","email_id","teliphone_no","nearest_station","nearest_station_state","dob","age","sex","marital_status","category","cast_cetificate","father_or_husband_name","relation","state_of_domicile","nationality","is_pwd","pwd_certificate","age_relaxation_claimed","highest_qualification","Examination_Passed","10th_name_of_the_board_or_council_or_university","10th_discipline_or_subject","10th_course_duration","10th_Year_of_Passing","10th_percentage_of_marks_or_CGPA","10th_certificate","10th_marksheet","12th_name_of_the_board_or_council_or_university","12th_discipline_or_subject","12th_course_duration","12th_Year_of_Passing","12th_percentage_of_marks_or_CGPA","12th_certificate","12th_marksheet","graduation_name_of_the_board_or_council_or_university","graduation_discipline_or_subject","graduation_course_duration","graduation_Year_of_Passing","graduation_percentage_of_marks_or_CGPA","graduation_certificate","post_graduation_name_of_the_board_or_council_or_university","post_graduation_discipline_or_subject","post_graduation_course_duration","post_graduation_Year_of_Passing","post_graduation_percentage_of_marks_or_CGPA","post_graduation_certificate","1st_employer_name_address","1st_employer_from_date","1st_employer_to_date","1st_employer_designation","1st_employer_pay_scale","1st_employer_work_details","1st_employer_employment_type","1st_employer_type","2nd_employer_name_address","2nd_employer_from_date","2nd_employer_to_date","2nd_employer_designation","2nd_employer_pay_scale","2nd_employer_work_details","2nd_employer_employment_type","2nd_employer_type","3rd_employer_name_address","3rd_employer_from_date","3rd_employer_to_date","3rd_employer_designation","3rd_employer_pay_scale","3rd_employer_work_details","3rd_employer_employment_type","3rd_employer_type","passport_photo","sign","resume","laguage_comfort","language_eligibility","Examination_Passed","language_certificate","experience_certificate","trans_id"];
 
$uniqueTransactionID = generateTransactionID();
$_POST["trans_id"] =  $uniqueTransactionID;
$_POST["is_payment_done"] = 0;
$_POST["mobile_no"] =$_POST["20"] ;
$columns_to_insert = "(";
$value_to_insert = "(";
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    foreach ($_POST as $key => $value) {
        // $sanitized_value = htmlspecialchars($value); // Sanitize the value

        if (in_array($key, $filed_array)) {
            $columns_to_insert= $columns_to_insert."`".$key."`,";
            $value_to_insert = $value_to_insert."'".$value."',";

        }

        // echo "Key: " . $key . ", Value: " . $sanitized_value . "<br>";

    }

    $columns_to_insert = substr($columns_to_insert, 0, -1);
    $value_to_insert = substr($value_to_insert, 0, -1);
    $columns_to_insert = $columns_to_insert.")";
    $value_to_insert = $value_to_insert.")";
    $sql = "INSERT INTO OPF ".$columns_to_insert. "VALUES ".$value_to_insert;
    // echo $sql;



    if ($conn->query($sql) === TRUE) {
        echo "New record created successfully";
    } else {
        echo "Error:  <br>" . $conn->error;
    }

    if ($_POST["category"] == "UR" || $_POST["category"] == "SEBC"){
        
        $amount = 500;
        send_payment_gatway($uniqueTransactionID,$amount);
    }else{
        $sql = "UPDATE OPF SET is_payment_done = '1' WHERE trans_id ='". $uniqueTransactionID."'";

if (mysqli_query($conn, $sql)) {
    ?>
	<script>
		window.location.href='payment-success.php';
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

    



}



 



$postdata = file_get_contents("php://input");
// Close connection
$conn->close();
?>
