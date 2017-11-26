<?php
include("header.php");
include("email.php");
?>
<body class=default>
  <div id="signup">
    <!-- Email already exists part -->
    <?php
    $config = include('install/config.php');
    $server_name = $config['servername'];
    $user_name = $config['username'];
    $password = $config['password'];
    $db_name = $config['db_name'];
    $conn = mysqli_connect($server_name, $user_name, $password);
    if(!$conn) {
      die("connection failed...");
    }
    $select_db = mysqli_select_db($conn,$db_name);
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['signup']) && !Empty($_POST['email']) && !Empty($_POST['password']))
    {
      $email= $_POST['email'];
      $password= $_POST['password'];
      $lenpw = strlen($password);
      // if(!filter_var($email,FILTER_VALIDATE_EMAIL) || $lenpw<6){
      //   // $mailErr='checkerror';
      //   // $emailErr = "Invalid email format";
      //   echo "<script> alert('invalid email or Password!!!');</script>";
      // }
      if($email) {
        $select = "SELECT email FROM user WHERE email = '$email'";
        $result_select = mysqli_query($conn,$select);
        //var_dump($result_select);
        if (mysqli_num_rows($result_select) > 0) {
          while($row = mysqli_fetch_assoc($result_select)){
            echo "Email".$row['email'];
            header("location:signup.php");
            echo "<script>alert('Email already exists!')</script>";
          }
        }
        elseif(filter_var($email,FILTER_VALIDATE_EMAIL) && $lenpw > 6) {
          $insert = "INSERT INTO user(email,password,profile_pic) VALUES('$email','$password','images/anonymous.png')";
          $result = mysqli_query($conn,$insert);
          // var_dump($result);
          if($result) {
            $select_sign = "SELECT uid FROM user WHERE email = '$email'";
            $result_sign = mysqli_query($conn,$select_sign);
            if (mysqli_num_rows($result_sign) > 0) {
              while($row = mysqli_fetch_assoc($result_sign)) {
                $sign_user = $row['uid'];
              }
            }
            session_start();
            $_SESSION['sid'] = $sign_user;
            $_SESSION['start_time']= date("h-i-sa");
            $session_time = "Session started at:".$_SESSION['start_time']."";
            header("location:timeline.php");
            // echo "new rec inserted";
            // echo $_SESSION['sid'];
          }
          $params = array(
               'to' => $_POST['email'],
               'subject' => 'Welcome to the Gajali team',
               'message' => 'Thank you For Joining GAJALI',
             );
             sendemail($params);
        }
        else{
          echo "<script> alert('invalid email or Password!!!');</script>";
        }
      }
    }
    ?>
    <?php
    // $select_sign = "SELECT uid FROM user WHERE email = '$email'";
    // $result_sign = mysqli_query($conn,$select);
    // if (mysqli_num_rows($result_sign) > 0) {
    //   while($row = mysqli_fetch_assoc($result_sign)) {
    //     $sign_user = $row['uid'];
    //   }
    // }

    ?>
    <form class="panel1" name="signupForm" method="POST" action="" onsubmit="validatesignup()">
      <div id="signupdiv"><br><br><br><br>
        <h2 id="signuptag">SIGN UP</h2>
        <input type="text" id="emailname" name="email" placeholder="Enter E-mail">
        <br>
        <input type="password" id="passwordname" name="password" placeholder="Enter Password">
        <br><br>
        <button id="btn-new" name="signup" type="submit" value="submit">Sign Up</button>
      </div>
    </form>
  </div>
  <?php
  include("footer.php");
  ?>
