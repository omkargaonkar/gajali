<?php

$config = include('config.php');
$server_name = $config['servername'];
$user_name = $config['username'];
$password = $config['password'];
$db_name = $config['db_name'];

$conn = mysqli_connect($server_name, $user_name, $password);
// Check connection
if (!$conn) {
  die("Connection failed:" . mysqli_connect_error());
}
else
{
//echo "Connected successfully";
//create database
$sql_db =  "CREATE DATABASE IF NOT EXISTS ".$db_name;
if (mysqli_query($conn, $sql_db)) {
  //echo "Database created successfully";
  $select_db = mysqli_select_db($conn,$db_name);
  //echo $select_db;
  // create table user
  $sql = "CREATE TABLE IF NOT EXISTS user(
    uid int NOT NULL AUTO_INCREMENT,
    fname varchar(255),
    lname varchar(255),
    email varchar(255),
    password varchar(255),
    dob DATE,
    gender varchar(255),
    profile_pic varchar(255),
    PRIMARY KEY(uid));";

  if (mysqli_query($conn, $sql)) {
    //echo "Table user created successfully";
  }
  else {
    echo "Error creating table: " . mysqli_error($conn);
  }

  // create table timeline
  $sql1 = "CREATE TABLE IF NOT EXISTS timeline (
           tid int(11) NOT NULL AUTO_INCREMENT,
           uid int(11) NOT NULL,
           msgs text,
           posted_at timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
           PRIMARY KEY(tid),
           FOREIGN KEY(uid) REFERENCES user(uid)
         );";

  if (mysqli_query($conn, $sql1)) {
    //echo "Table timeline created successfully.";
  }
  else {
    echo "Error creating table: " . mysqli_error($conn);
  }

  // create table favourites
  $sql2 = "CREATE TABLE IF NOT EXISTS favourites (
           fid int(11) NOT NULL AUTO_INCREMENT,
           tid int(11) NOT NULL,
           uid int(11) NOT NULL,
           PRIMARY KEY(fid),
           CONSTRAINT FOREIGN KEY (uid) REFERENCES user(uid),
           CONSTRAINT FOREIGN KEY (tid) REFERENCES timeline(tid)
          );";


  if (mysqli_query($conn, $sql2)) {
      //echo "Table favourites created successfully";
  }
  else
  {
      echo "Error creating table: " . mysqli_error($conn);
  }
  }

  //mysql_close($conn);

}



?>
