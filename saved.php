<?php
include("header.php");
?>
<?php
session_start();
if(isset($_SESSION['sid'])) {
  // echo "Your session is running " . $_SESSION['sid'];
}
else{
  session_destroy();
  header("location:index.php");
}
?>
<body class="default">
  <div class = "panel">
    <div class="left_saved">
        <h1>Saved Messages<form name="my_acc" action="timeline.php" method="post">
            <input type="submit" id="my_tym" name="my_acc" value="My Timeline" >
          </form></h1>
      <?php
      session_start();
      echo $_SESSION['sid'];
      $session_time = "Session started at:".$_SESSION['start_time']."";
      echo $session_time;
      ?>
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
    // if($_SERVER['REQUEST_METHOD'] =='POST')
    $select_db = mysqli_select_db($conn,$db_name);
      $type_user = $_SESSION['sid'];
        $show_msgs = "SELECT favourites.tid,timeline.msgs,timeline.posted_at FROM timeline LEFT JOIN favourites ON favourites.tid=timeline.tid WHERE favourites.uid='$type_user' ORDER BY timeline.posted_at";
        $result_msgs = mysqli_query($conn, $show_msgs);
        // var_dump($result);
        if (mysqli_num_rows($result_msgs) > 0) {
          //time format
          function time_ago1($date) {
            if (empty($date)) {
                return "No date provided";
            }
            $periods = array("second", "minute", "hour", "day", "week", "month", "year", "decade");
            $lengths = array("60", "60", "24", "7", "4.35", "12", "10");
            $now = time();
            $unix_date = strtotime($date);
            // check validity of date
            if (empty($unix_date)) {
                return "Incorrect date";
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
        while($row = mysqli_fetch_assoc($result_msgs)) {
          echo "<div class='gajaliWrapper'>
                  <span class='name'>".$row['fname']."</span> <span class='time'>".time_ago1($row['posted_at'])."</span>
                <p>".$row['msgs']."</p>
                </div>";
          }
        }
        else {
          echo "0 results";
        }
        ?>

      <div class="gajaliWrapper">
        <div>
          <p id="pid"><b>You don't have any saved messages. Happy exploring :)</b></p>
        </div>
      </div>
    </div>
  </div>
</body>
<?php
  include("footer.php");
 ?>
