<?php
 include('header.php');
 include("email.php");
?>
<?php
   $config = include('install/config.php');
   $servername = $config['servername'];
   $username = $config['username'];
   $password = $config['password'];
   $dbname = $config['db_name'];
   // Create connection
   $conn = new mysqli($servername, $username, $password, $dbname);
   // Check connection
   if ($conn->connect_error) {
     die("Connection failed: " . $conn->connect_error);
   }
   if($_SERVER['REQUEST_METHOD'] && isset($_POST['submit']))
   {
       $sql = 'SELECT * FROM user WHERE email = "'.$_POST['mailId'].'"';
       $result = $conn->query($sql);
       //var_dump($result);
         if ($result->num_rows > 0) {
         while($row = $result->fetch_assoc()) {
           $params = array(
             'to' => $row["email"],
             'subject' => 'pasword recovery',
             'message' => 'Your password is ' . $row["password"],
           );
           sendemail($params);
         }
         echo "<script>
         alert('Messge sent sucessfully');
         window.location.href='index.php';
         </script>";
       }
       else{
         echo "No record found";
       }

     }
?>
<body class=default>
<div class=forgotpass>
 <div class=panel>
   <h2>Find Your Gajali Account</h2>
   <form method="post" action="">
     <input type="email" name="mailId" placeholder="Enter EmailID" required ><span class="error"><?php echo "$error"; ?></span>
     <input type="submit" class="recoverymail" name="submit" value="Submit" >
   </form>
 </div>
</div>

<?php
 include('footer.php');
?>
