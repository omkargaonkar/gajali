<?php
include("header.php");
?>
<?php
session_start();
// echo $_SESSION['sid'];
$session_time = "Session started at:".$_SESSION['start_time']."";
// echo $session_time;
?>
<?php
if(isset($_REQUEST['logout'])) {
  include('logout.php');
}
?>

<body class="default">
  <div class = "panel">
    <div class="left">
      <h1>Whats up? </h1>
      <div class="gajaliWrapper">
          <form class="post-form" name="new_post" action="" method="POST" >
            <textarea name="textmsg" rows ="5" cols="65">Enter text</textarea>
            <input type="submit" id="post" name="post" value="POST">
          </form>
      </div>
      <h1>New feeds </h1>
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
        // print_r($_GET);
        $display_user = $_GET["id"];
        // var_dump($display_user);
        $sqlmsgs="SELECT user.fname,user.profile_pic,timeline.msgs,timeline.posted_at FROM timeline LEFT JOIN user ON user.uid=timeline.uid WHERE timeline.uid = '$display_user' ORDER BY timeline.posted_at DESC";
        $result = mysqli_query($conn, $sqlmsgs);
        // var_dump($result);
        if (mysqli_num_rows($result) > 0) {
        //  time format
         function time_ago($date) {
           if (empty($date)) {
               return "No date provided";
           }
           $periods = array("second", "minute", "hour", "day", "week", "month", "year", "decade");
           $lengths = array("60", "60", "24", "7", "4.35", "12", "10");
           $now = time();
           $unix_date = strtotime($date);
           // check validity of date
           if (empty($unix_date)) {
               return "Bad date";
           }
           // is it future date or past date
           if ($now > $unix_date) {
               $difference = $now - $unix_date;
               $tense = "ago";
           } else {
               $difference = $unix_date - $now;
               $tense = "from now";
           }
           for ($j = 0; $difference >= $lengths[$j] && $j < count($lengths) - 1; $j++) {
               $difference /= $lengths[$j];
           }
           $difference = round($difference);
           if ($difference != 1) {
               $periods[$j].= "s";
           }
           return "$difference $periods[$j] {$tense}";
         }
        while($row = mysqli_fetch_assoc($result)) {
            echo "<div class='gajaliWrapper'>
                  <img class='image-class' src=".$row['profile_pic']." width='70' height='70'>
                  <span class='name'>".$row['fname']."</span><span class='time'>".time_ago($row['posted_at'])."</span>
                <p>".$row['msgs']."<form method='post'><input type='submit' name='save' class='like'><input type='hidden' name='Like_btn' value='$t_id'></form></p>
                </div>";
          }
        }
        else {
          echo "0 results";
        }
       ?>
       <?php
           if (isset($_POST['like_btn'])) {
             // var_dump($_POST);
             $time_id = $_POST['tid'];
             $like_msg = "INSERT INTO favourites(uid,tid) VALUES('$type_user','$time_id')";
             $like_result = mysqli_query($conn,$like_msg);
           }
        ?>
     </div>

      <div class="right">
      <?php
      $data="SELECT fname,lname,profile_pic,email,dob FROM user where uid ='$display_user' ";
      $result_data = mysqli_query($conn, $data);
      // var_dump($result);
      if (mysqli_num_rows($result_data) > 0) {
      while($row = mysqli_fetch_assoc($result_data)) {
        echo "<div class='content-left trans' id='img'>
              <img src='".$row['profile_pic']."' alt='Profile picture' width='150' height='150'>
              </div>
              <div class='trans content-left num'>
                <h3><a href='#'>".$row['fname']." ".$row['lname']."</a></h3>
                <p>Email:".$row['email']."</p>
                <p>DOB:".$row['dob']."</p>
              </div>";
        }
      }
      else {
        echo "0 results";
      }
      ?>

      <div class="content-left trans num">
        <form name="my_acc" action="timeline.php" method="post">
          <input type="submit" name="my_acc" value="My Timeline" >
        </form>
      </div>
    </div>
    </div>
</body>
<?php
include("footer.php");
?>
