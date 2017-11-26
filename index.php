<?php
include("header.php");
//include("jquery-file.js")
//include("jquery-1.11.2.min.js");	
?>
<body class="default">
  <!-- Installation process -->
  <?php
  $config = include('install/config.php');
  $server_name = $config['servername'];
  $user_name = $config['username'];
  $password = $config['password'];
  $db_name = $config['db_name'];
  // echo "database".$db_name."exists";
  $conn = mysqli_connect($server_name,$user_name, $password);
  // Check connection
  if (!$conn) {
      die("Connection failed: " . mysqli_connect_error());
  }
  //echo "connection established";
  $select_db = mysqli_select_db($conn,$db_name);
  if($select_db == FALSE) {
    ?>
    <style type="text/css">.panel1{
      display:none;
      }
      </style>
      <?php
      if(isset($_REQUEST['install'])) {
        include('install/install.php');
        echo "<script>alert('Installation Complete!')</script>";
        ?>
        <style type="text/css">#toggle{
          display:none;
          }
          </style>
          <style type="text/css">.panelinstall {
            display:none;
            }
        </style>
          <style type="text/css">.panel1{
            display:block;
            }
            </style>
          <?php
        }
      }
      else{
        ?>
        <style type="text/css">#toggle{
          display:none;
          }
          </style>
          <?php
          // echo "<script>alert('you are up to date')</script>";
          }
            ?>

            <?php
            //session part
            if (($_SERVER["REQUEST_METHOD"] == "POST") && isset($_POST['login']))  {
              $login_email = $_POST['username'];
              $login_password = $_POST['password'];


              //database connection
              $config = include('install/config.php');
              $server_name = $config['servername'];
              $user_name = $config['username'];
              $password = $config['password'];
              $db_name = $config['db_name'];
              // echo "database".$db_name."exists";
              $conn = mysqli_connect($server_name,$user_name, $password);
              // Check connection
              if (!$conn) {
                  die("Connection failed: " . mysqli_connect_error());
              }
              //echo "connection established";
              $select_db = mysqli_select_db($conn,$db_name);

              //echo "Connection successfully for login.";

              $select ="select uid, email, password from user where email = '$login_email'
                        and password = '$login_password'";

              $result = mysqli_query($conn,$select);
              //var_dump($result);

              //console.log($result);
              if (mysqli_num_rows($result) > 0) {
                while($row = mysqli_fetch_assoc($result)) {
                // echo "username: " . $row["email"]. " password " . $row["password"]. "<br>";
                //session part
                if(($login_email == $row['email']) &&($login_password == $row['password'])) {
                  session_start();
              	  $_SESSION['sid'] = $row["uid"];
                  $_SESSION['start_time']= date("h-i-sa");
                  $session_time = "Session started at:".$_SESSION['start_time']."";
                  header("location:timeline.php");
                }
                else {
                    echo "<script> alert('Your username or password is invalid.')</script>";
                }
              }
            }
              else {
                echo "0 results";
              }
            }
            ?>


        <div id="toggle">
        <p id="tog">Install the required configuration to proceed</p>
        <form>
        <div><input type="submit" id="install-btn" name="install" value="INSTALL"></div>
      </form>
      </div>

      <div id="container">
		<h2>Get Your Daily Quote</h2>
			<div id="quoteContainer">
				<p></p>
				<p id="quoteGenius"></p>
			</div><!--end quoteContainer-->

			<div id="buttonContainer">
				<a href="#" id="quoteButton">Quote Me</a>
		</div><!--end buttonContainer-->


	</div><!--end container-->
      <div class="panel1">
            <div class="container">
              <div class="login">
                <h2 id="heading">चल गजालिक</h2>
                <form name="login" method="POST">
                  <img src="images/login.png" id="imglogo" alt="login"></img>
                  <input type="text" name="username" class="log_info" placeholder="Enter Email">
                  <input type="password" name="password" class="log_info" placeholder="Password">
                  <input type="submit" class="log_btninfo" name= "login" value="Log in">
                  <label id="labellink"><a href="forgotpass.php" id="link">Forgot Password ?</a></label><br>
                <label id="labellink">New User on Gajali ?<br><a href="signup.php" id="link">Sign Up>></a></label>
                </form>
              </div>
            </div>
          </form>
        </div>

  </div>
<?php
  include("footer.php");
?>
