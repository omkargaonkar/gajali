
<?php
// session_start();
if (session_destroy()) {
  $_SESSION['end_time'] =date("h-i-sa");
  header("Location: index.php?message=".$_SESSION['end_time']."array value=".$_SESSION);
}
?>
