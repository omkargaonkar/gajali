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
  <div class="ul-panel">

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['gajalians'])) {
  session_start();
  if(isset($_SESSION['sid'])) {
    echo "Your session is running " . $_SESSION['sid'];
  }
  else{
    header("location:index.php");
  }
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
  // echo "connection established";
  $select_db = mysqli_select_db($conn,$db_name);
	// SQL query
	$strSQL = "SELECT * FROM user ORDER BY fname DESC";
	// Execute the query (the recordset $rs contains the result)
	$rs = mysqli_query($conn,$strSQL);
	// Loop the recordset $rs
	while($row = mysqli_fetch_assoc($rs)) {
	   // Name of the person
	  $strName = $row['fname'] . " " . $row['lname'];
	   //create link
	   $strLink = "<a id='gajalilink' href = 'com.php?id=" . $row['uid'] . "'>" . $strName . "</a>";
	    // List link
	   echo "<div class='gajaliWrapper'><h3>" . $strLink . "</h3></div>";
	  }
}
else {
?>
<style type="text/css">.user_list{
  display:none;
  }
  </style>
  <?php
}
	?>


</div>
</body>
  <?php
  include("footer.php");
  ?>
