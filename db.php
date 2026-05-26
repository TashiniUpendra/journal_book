<?php
$conn = new mysqli("localhost","root","","journal_book");

if($conn->connect_error){
    die("DB Connection Failed: " . $conn->connect_error);
}
?>