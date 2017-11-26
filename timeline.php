<?php
include("header.php");
?>
<?php
session_start();
if(isset($_SESSION['sid'])) {
 //echo "Your session is running " . $_SESSION['sid'];
}
else{
  session_destroy();
  header("location:index.php");
//  echo "helooooooo";
}
$session_time = "Session started at:".$_SESSION['start_time']."";
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
          <div class="lead emoji-picker-container">
            <textarea id="textarea_msg" name="textmsg" rows ="5" cols="65" maxlength="150" placeholder="Enter messege.." data-emojiable="true"></textarea>
          </div>
          <input type="submit" id="post" name="post_message" value="POST">
        </form>
      </div>
      <h1 id="new_feed">New feeds </h1>
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
      // echo "connection established";
      $select_db = mysqli_select_db($conn,$db_name);
      $type_user = $_SESSION['sid'];
      if (isset($_POST['post_message'])) {
        $msg = $_POST['textmsg'];
        $postmsg = "INSERT INTO timeline (uid,msgs) VALUES ('$type_user','$msg')";
        if (mysqli_query($conn, $postmsg)) {
        }
        else {
            echo "Error: " . $postmsg . "<br>" . mysqli_error($conn);
        }
      }
      ?>
      <?php
      $sqlmsgs="SELECT user.fname,user.profile_pic,timeline.msgs,timeline.tid,timeline.posted_at FROM timeline LEFT JOIN user ON user.uid=timeline.uid WHERE timeline.uid='$type_user' ORDER BY timeline.posted_at DESC";
      $result = mysqli_query($conn,$sqlmsgs);
      if (mysqli_num_rows($result) > 0) {
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

          return $difference . " " . $periods[$j] . " " . $tense;
        }
        $t_id=array();
        while($row = mysqli_fetch_assoc($result)) {
          // $t_id[] = $row['tid'];
          array_push($t_id,$row);
          print_r($t_id);
          echo "<div class='gajaliWrapper'>
          <img class='image-class' src='" . $row['profile_pic'] . "' width='60' height='60'>
          <span class='name'>" . $row['fname'] . "</span>
          <span class='time'>" . time_ago1($row['posted_at']) . "</span>
          <p>".$row['msgs']."<form method='post' action=''><input type='submit' name='save' value='save_post' class='like'><input type='submit' name='like_btn' value='array()'></form></p>
          </div>";
        }
      }
      else {
        //echo "0 results";
      }
        //NOT WORKINg
        if (isset($_POST['like_btn'])) {
          $like_msg = "INSERT INTO favourites(uid,tid) VALUES('$type_user','$t_id')";
          $like_result = mysqli_query($conn,$like_msg);
          if($like_result) {
          //echo "message inserted";
          header("location:".$_SERVER['HTTP_REFERER']."");
          }
          else {
            echo "Error: " . $like_result . "<br>" . mysqli_error($conn);
          }
        }


      ?>
      <div class="gajaliWrapper" id="demo">
        <div>
          <p><b>Hello.Welcome to the Gajali.</b></p>
        </div>
      </div>
    </div>
    <div class="right">
      <?php
      $data="SELECT fname,lname,profile_pic,email,dob FROM user where uid ='$type_user' ";
      $result_data = mysqli_query($conn, $data);
      if (mysqli_num_rows($result_data) > 0) {
      while($row = mysqli_fetch_assoc($result_data)) {
        echo "<div class='content-left trans' id='img'>
        <img src='".$row['profile_pic']."' alt='Profile picture' width='150' height='150'>
        </div>
        <div class='trans content-left num'>
        <h3><a id='h3name' href='#'>".$row['fname']." ".$row['lname']."</a></h3>
        <p id='h3name'>Email:".$row['email']."</p>
        <p id='h3name'>DOB:".$row['dob']."</p>
        </div>";
      }
    }
    else {
      echo "0 results";
    }
      ?>
      <div class="content-left trans num">
        <form name="edit" action="editprofile.php" method="post">
          <input type="submit" name="edit" value="Edit Profile">
        </form>
        <form name="community" action="community.php" method="post">
          <input type="submit" name="gajalians" value="Gajaliikars" >
        </form>
        <form name="saved" action="saved.php" method="post">
          <input type="submit" name="fav" value="Favourited Posts" >
        </form>
        <form name="logout" action="" method="post">
          <input type="submit" name="logout" value="Logout" >
        </form>
      </div>
    </div>
  </div>
  <script src="emoji/jquery-3.2.1.js"></script>
  <!-- Begin emoji-picker JavaScript -->
  <script src="emoji/config.js"></script>
  <script src="emoji/util.js"></script>
  <script src="emoji/jquery.emojiarea.js"></script>
  <script src="emoji/emoji-picker.js"></script>
  <!-- End emoji-picker JavaScript -->
  <script>
  $(function() {
    // Initializes and creates emoji set from sprite sheet
    window.emojiPicker = new EmojiPicker({
      emojiable_selector: '[data-emojiable=true]',
      assetsPath: 'emoji/img/',
      popupButtonClasses: 'fa fa-smile-o'
    });
    window.emojiPicker.discover();
  });
  </script>
</body>
<?php
include("footer.php");
?>
