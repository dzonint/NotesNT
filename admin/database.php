<?php 
session_start();
if(isset($_SESSION['SESS_CHANGEID']) == TRUE) {
session_unset();
session_regenerate_id();
}

$conn = mysqli_connect("localhost", "root", "", "notesnt") or die("Unable to access the database - " . mysqli_connect_error()); 
mysqli_set_charset($conn, "utf8");
?>