<?php
session_start();
include("db.php");

// check login
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// check ID
if (!isset($_GET['id'])) {
    die("Invalid request!");
}

$id = intval($_GET['id']);
$user_id = $_SESSION['user_id'];

// delete only user’s own journal
$stmt = $conn->prepare("
    DELETE FROM journals 
    WHERE id=? AND user_id=?
");

$stmt->bind_param("ii", $id, $user_id);

// execute
if ($stmt->execute()) {
    header("Location: dashboard.php");
    exit();
} else {
    echo "❌ Delete failed!";
}
?>