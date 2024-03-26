<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES["file"])) {
    $targetDir = "uploads/"; // Directory to store uploaded files
    $targetFile = $targetDir . basename($_FILES["file"]["name"]);
    $maxFileSize = $_POST["file_size"] * 1024 * 1024;
    if ($_FILES["file"]["size"] <= $maxFileSize) {

        $fileExtension = pathinfo($_FILES["file"]["name"], PATHINFO_EXTENSION);
        $uniqueFilename = uniqid() . '.' . $fileExtension; // Generate a unique filename

        $targetFile = $targetDir . $uniqueFilename;

        if (move_uploaded_file($_FILES["file"]["tmp_name"], $targetFile)) {
            $data = [
                'status' => true,
                'file_name' =>$uniqueFilename
            ];
            $jsonResponse = json_encode($data);
            echo $jsonResponse;

            // echo "File has been uploaded successfully.";
        } else {
            $data = [
                'status' => false,
                'msg' =>"Sorry, there was an error uploading your file."
            ];
            $jsonResponse = json_encode($data);
            echo $jsonResponse;

        }
    }
    else {
        $data = [
            'status' => false,
            'msg' =>"File Size Should Not Be More Than " .$_POST["file_size"]. " MB"
        ];
        $jsonResponse = json_encode($data);
        echo $jsonResponse;
    }
}
?>
