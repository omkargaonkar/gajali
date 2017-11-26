<!DOCTYPE html>
<html>
<head>
  <link rel="stylesheet" href="editprofile.css" type="text/css">
  <script>
   function previewFile(){
       var preview = document.querySelector('img'); //selects the query named img
       var file    = document.querySelector('input[type=file]').files[0]; //sames as here
       var reader  = new FileReader();
       reader.onloadend = function () {
           preview.src = reader.result;
       }
       if (file) {
           reader.readAsDataURL(file); //reads the data as a URL
       } else {
           preview.src = "";
       }
  }
  previewFile();  //calls the function named previewFile()
  </script>
</head>
<body>
  <?php
  $fname=$_POST['fname'];
  $lname=$_POST['lname'];
  $email= $_POST['email'];
  $password= $_POST['password'];
  $dob=$_POST['dob'];
  $gender=$_POST['gender'];
  // $path1=$_POST['img'];
  $img_name=$_FILES['a']['name'];
  $img_tmp=$_FILES['a']['tmp_name'];
  $img_size=$_FILES['a']['size'];
  $img_type=$_FILES['a']['type'];
  $path="images/".$img_name;
  if($_FILES['type']="images/jpeg" || $_FILES['type']="images/png" || $_FILES['size']<=1000)
  {
  move_uploaded_file($img_tmp,$path);
  // mysql_query("insert into product(path) value($path)");
  }
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

  // echo "Connection established successfully ";
  $select_db = mysqli_select_db($conn,$db_name);
   session_start();
  $edit_user=$_SESSION['sid'];
  $sql ="select fname,lname,email,password,dob,profile_pic from user where uid='$edit_user';";
  $result = mysqli_query($conn,$sql);
  if (mysqli_num_rows($result) > 0) {
      // output data of each row
      while($row = mysqli_fetch_assoc($result)) {
          $f_name=$row['fname'];
          $l_name=$row['lname'];
          $emailid=$row['email'];
          $passwd=$row['password'];
          $bithdate=$row['dob'];
          $picture=$row['profile_pic'];
            }
        }
   ?>
  <div id="id01" class="panel2">
    <form class="modal-content animate" action="" method="post" enctype="multipart/form-data" >
      <div class="container">
        <table align="center" cellpadding=3px cellspacing=2px>
          <caption><h1>Edit Profile</h1></caption>
          <tr>
            <td>
              <?php
                $select="select profile_pic from user where uid='$edit_user'";
                $result1= mysqli_query($con, $select);
                $row = mysqli_fetch_assoc($result1);
                 ?>
              <div id="img"><img src="<?php echo $row['profile_pic'];?>" height="100" width="100" style="border-radius:5px;border:solid"></div>
            </td>
          </tr>
          <tr>
            <td><input type="file" name="a" value="<?php echo $picture; ?>"></td>
          </tr>
          <tr>
            <td><label>Firstname:</label></td>
          </tr>
          <tr>
            <td><input type="text" name="fname" id="fname" placeholder="Firstname" value="<?php echo $f_name; ?>"></td>
          </tr>
          <tr>
            <td><label>Lastname:</label></td>
          </tr>
          <tr>
            <td><input type="text" name="lname" id="lname" placeholder="Lastname" value="<?php echo $l_name; ?>"></td>
          </tr>
          <tr>
            <td><label>Email:</label></td>
          </tr>
          <tr>
            <td><input type="text" name="email" id="email" placeholder="Email" value="<?php echo $emailid; ?>"></td>
          </tr>
          <tr>
            <td><label>Password:</label></td>
          </tr>
          <tr>
            <td><input type="text" name="password" id="password" placeholder="Password" value="<?php echo $passwd; ?>"></td>
          </tr>
          <tr>
            <td><label>DOB:</label></td>
          </tr>
          <tr>
            <td><input type="date" name="dob" id="dob" value="<?php echo $bithdate; ?>"></td>
          </tr>
          <tr>
            <td><label>Gender:</label></td>
          </tr>
          <tr>
            <td><select name="gender">
                <option value="male" >Male</option>
                <option value="female">Female</<option>
              </select></td>
          </tr>
          <tr>
            <td>
              <div id="save"><button name="save" type="submit" data-inline="true">Save</button></div>
            </td>
          </tr>
        </div>
      </form>
    </div>
  </body>
  </html>
  <?php
  // if ($_SERVER["REQUEST_METHOD"] == "POST")
  //  {
     if((isset($_POST['save']) && ($_SERVER["REQUEST_METHOD"] == "POST"))){
         $sqlupdate="update user set fname='$fname',lname='$lname',email='$email',password='$password',dob='$dob',gender='$gender',profile_pic='$path' where uid='$edit_user'";
         $retval = mysqli_query($conn,$sqlupdate);
         var_dump($retval);
         if(! $retval )
         {
           die('Could not update data: ' . mysql_error());
         }
         echo "Updated data successfully\n";
         header('Location: timeline.php');
       }
      //  }
  ?>
