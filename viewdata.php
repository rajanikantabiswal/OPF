<?php

if (isset($_SESSION['loggedin']) && $_SESSION['loggedin']  != true){
    header("Location: login.php");
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>View Data</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="//cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">
    <meta name="viewport" content="width=device-width, initial-scale=1">
<!-- Add icon library -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <style>
        .hero-callout {
    background-color: #fff;
    padding: 1.5em;
    box-shadow: 3px 3px 20px rgba(0,0,0,.3);
    border-radius: 7px;
    width:90%;
    margin:auto;
}
.odd {
    box-shadow: inset 0 0 0 9999px rgba(0,0,0,.023);
    box-shadow: inset 0 0 0 9999px rgba(var(--dt-row-stripe), 0.023);
    background:"#f1f1f1"
}
.btn {
  background-color: DodgerBlue;
  border: none;
  color: white;
 
  cursor: pointer;
 
}
        </style>
</head>
<body>
    <div class = "row" style="width:100%">
<h2 style="text-align:center">Insrted Data</h2>
<button class="btn" style="    float: right;
    margin-right: 5%;
    margin-bottom: 10px; background:red" onclick="logout()"><i class="fa fa-logout"></i> Logout</button>

<button class="btn" style="    float: right;
    margin-right: 1%;
    margin-bottom: 10px;" onclick="download()"><i class="fa fa-download"></i> Download CSV</button>


</div>

    <div class = "row" style="width:100%">
    <div class="table-responsive hero-callout">
        <table class="table table-striped table-bordered" id="myTable">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone Number</th>
                    <th>Address</th>
                    <th>Transaction ID</th>
                    <th>Download Resume</th>
                    <!-- Add more columns as needed -->
                </tr>
            </thead>
            <tbody>
                <?php
                // Fetch data from the database
                include 'db.php';

                $sql = "SELECT * FROM OPF where is_payment_done = '1'";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    $count = 1;
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $count++ . "</td>";
                        echo "<td>" . $row['first_name'] . " ".$row['middle_name'] ." ". $row['last_name'] . "</td>";
                        echo "<td>" . $row['email_id'] . "</td>";
                        echo "<td>" . $row['mobile_no'] . "</td>";
                        echo "<td>" . $row['address'] .", ".$row['post_office'] .", ".$row['police_station'] .", ".$row['district'] .", ".$row['state'] .", ".$row['pincode']. "</td>";
                        echo "<td>" . $row['trans_id'] . "</td>";

                        if ($row['resume'] != ""){
                        ?>
<td><button class="btn" style=" 
    margin-right: 1%;
    margin-bottom: 10px;" onclick="downloadresume('<?= $row['resume'] ?>')"><i class="fa fa-download"></i> Download Resume</button></td>
                        <?php
                        }
                         
                        // Add more columns as needed
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='3'>No data found</td></tr>";
                }
                $conn->close();
                ?>
            </tbody>
        </table>
    </div>
    </div>


<!-- Bootstrap JS -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="//cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
<script>
let table = new DataTable('#myTable');
function download(){
    window.location.href="download-data.php"
}
function logout(){
    window.location.href="logout.php"
}
</script>

</body>
</html>
