<?php
$config = include('install/config.php');
$server_name = $config['servername'];
$user_name = $config['username'];
$password = $config['password'];
$db_name = $config['db_name'];
$conn = mysqli_connect($server_name,$user_name, $password);
// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
$select_db = mysqli_select_db($conn,$db_name);
$q = $_REQUEST["q"];
$type_user = $_SESSION['sid'];
if (isset($_POST['post'])) {
  $msg = $_POST['textmsg'];
  $time= date();
  $postmsg = "INSERT INTO timeline (uid,msgs) VALUES ('$type_user','$msg')";
  if (mysqli_query($conn, $postmsg)) {
  }
  else {
      echo "Error: " . $postmsg . "<br>" . mysqli_error($conn);
  }
}
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
  while($row = mysqli_fetch_assoc($result)) {
    $t_id = $row['tid'];
    echo "<div class='gajaliWrapper'>
    <img class='image-class' src='".$row['profile_pic']."' width='60' height='60'>
    <span class='name'>".$row['fname']."</span> <span class='time'>".time_ago1($time)."</span>
    <p>".$row['msgs']."<form method='post'><input type='submit' name='save' class='like'><input type='hidden' name='like_btn' value='$t_id'></form></p>
    </div>";
  }
}
else {
  echo "0 results";
}
?>
