<?php
session_start();
include("db.php");

// login check
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

$message = "";
$success = "";

if (isset($_POST['save_goal'])) {

    $title = trim($_POST['goal_title']);
    $description = trim($_POST['description']);
    $target_date = $_POST['target_date'];

    if (empty($title)) {
        $message = "Goal title is required!";
    } else {

        $stmt = $conn->prepare("
            INSERT INTO future_goals
            (user_id, goal_title, description, target_date, progress, status, created_at)
            VALUES (?, ?, ?, ?, 0, 'Pending', NOW())
        ");

        $stmt->bind_param(
            "isss",
            $user_id,
            $title,
            $description,
            $target_date
        );

        if ($stmt->execute()) {
            header("Location: goals.php?msg=added");
            exit();
        } else {
            $message = "Failed to add goal!";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Add Goal</title>

<style>
body{
    margin:0;
    font-family:Arial;
    background:#0b1220;
    color:white;
    display:flex;
    justify-content:center;
    align-items:center;
    min-height:100vh;
}

.card{
    width:600px;
    background:#111827;
    padding:25px;
    border-radius:15px;
    border:1px solid #1f2937;
}

h2{
    text-align:center;
}

input, textarea{
    width:100%;
    padding:12px;
    margin:10px 0;
    border:none;
    border-radius:10px;
    background:#1f2937;
    color:white;
    outline:none;
}

textarea{
    height:120px;
    resize:none;
}

button{
    width:100%;
    padding:12px;
    border:none;
    border-radius:10px;
    background:#3b82f6;
    color:white;
    font-weight:bold;
    cursor:pointer;
}

button:hover{
    background:#2563eb;
}

.message{
    background:#ef4444;
    padding:10px;
    border-radius:8px;
    text-align:center;
    margin-bottom:10px;
}

.back{
    text-align:center;
    margin-top:10px;
}

.back a{
    color:#60a5fa;
    text-decoration:none;
}
</style>

</head>

<body>

<div class="card">

    <h2>➕ Add New Goal</h2>

    <?php if($message!=""){ ?>
        <div class="message"><?php echo $message; ?></div>
    <?php } ?>

    <form method="POST">

        <input type="text" name="goal_title" placeholder="Goal Title" required>

        <textarea name="description" placeholder="Description"></textarea>

        <input type="date" name="target_date">

        <button type="submit" name="save_goal">Save Goal</button>

    </form>

    <div class="back">
        <a href="goals.php">← Back to Goals</a>
    </div>

</div>

</body>
</html>