<?php
if( ($_SERVER["REQUEST_METHOD"] == "POST") && isset($_POST['signup']))
{
  $config = include('install/config.php');
  $server_name = $config['servername'];
  $user_name = $config['username'];
  $password = $config['password'];
  $db_name = $config['db_name'];
  $con = mysqli_connect($server_name, $user_name, $password, $db_name);
   if(!$con) {
     die("connection failed...");
   }
  echo "connection successfully<br>";
  $email= $_POST['email'];
  $password= $_POST['password'];
  $Check = "SELECT count(email) AS emailcount FROM user WHERE email = '$email'";
  $result = mysqli_query($con, $Check);
  $result = mysqli_fetch_assoc($result);
  if($result['emailcount'] == '0')
  {
    $insert="insert into user (email,password) values('$email', '$password')";
    if (mysqli_query($con,$insert)){
      // echo "alert("Welcome to Gajali")";
      echo "New record created successfully";
    }
  }
  else {
    echo "This Email Id is Alredy registered";
  }
}
?>
