<?php

include 'db.php';
include 'processSale.php';
// send_payment_gatway("sdcsdcsdc",1);
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];
    if ($username == "admin" && $password == "admin"){
        $_SESSION['loggedin'] = true;
        
        header("Location: viewdata.php");
    }
    else{
        header("Location: login.php");
    }

}
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin']  === true){
    header("Location: viewdata.php");
}


?>
<div class="wrapper">

<div class="heading">
<h2>Welcome!</h2>
<p>Sign In to your account</p>
</div>

<form action="" method="POST">
    <div class="input-group">
    <input type="text" name="username" class="input-field" placeholder="Username" >
    </div>

    <div class="input-group">
    <input type="password" name="password" class="input-field" placeholder="Password" >
    </div>

    <div class="input-group row">

    <div class="row">
    <input type="checkbox" id="remember" hidden>
    <label for="remember" class="custom-checkbox"></label>
    <label for="remember">Remember me?</label>
    </div>
    
    <div class="row">
        <!-- <a href="#" target="_blank">Forgot password?</a>  -->
    </div>
    </div>


    <div class="input-group">
    <button type="submit">Login <i class="fa-solid fa-arrow-right"></i></button>
    </div>
</form>
</div>

<!-- <footer>
Created With ❤️ by <a href="https://instagram.com/" target="_black">Bhoopendra</a>
</footer> -->
<style>

::selection{
 color: #ffffff;
 background-color: #31285C;
}

*{
 padding:0;
 margin: 0;
 font-family: 'Outfit', sans-serif;
 box-sizing: border-box;
 text-decoration: none;
}

a{
 color: #31285C;
}



body{
 width: 100%;
 min-height: 100vh;
 display: flex;
 justify-content: center;
 align-items: center;
 flex-direction: column;
 background-color: #F0F0F0;
 padding-top: 20px;
}

.wrapper{
 width: 320px;
 min-height:100px;
 background-color: #FFFFFF;
 border-radius: 5px;
 box-shadow: 5px 5px 15px rgba(0,0,0,0.05);
 padding: 30px;
}

.input-field{
 width: 100%;
 height: 45px;
 border: none;
 padding: 10px;
 background-color: #eeeeee;
 color: gray;
 outline: none;
 font-size: 15px;
 margin-bottom: 20px;
 transition: .5s;
 border-radius: 5px;
}

input:hover{
}


.heading{
 color: #3B3663;
 margin-bottom: 20px;
}

.heading p{ 
 color: #AAA8BB;
}

.heading i{
 font-size: 30px;
 color: #4D61FC;
} 

label{
 color: #AAA8BB;
 font-weight: 400;
}

button{
 width: 100%;
 height: 45px;
 border: none;
 color: #FFFFFF;
 background-color: #31285C;
 border-radius: 5px;
 font-size: 17px;
 font-weight: 500;
 transition: 0.3s;
}

button:hover{
 background-color: #31283B;
}

.row{
 min-width: 5px;
 min-height: 10px;
 display: flex;
 align-items: center;
 justify-content: space-between;
 margin-bottom: 10px;
 font-size: 15px;
}

.custom-checkbox{
 width: 17px;
 height: 17px;
 border-radius: 5px;
 background-color: #eeeeee;
 display: flex;
 align-items: center;
 justify-content: center; 
 font-size: 10px;
 margin-right: 5px;
}

input[type=checkbox]:checked ~ .custom-checkbox{
 background-color: #31285C;
}

input[type=checkbox]:checked ~ .custom-checkbox::before {
font-family: "Font Awesome 5 Free";
  content: "\f00c";
  display: inline-block;
  font-weight: 900;
  color: #ffffff;
}

footer{
 text-align: center;
 margin: 20px;
}

</style>