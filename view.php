<?php
session_start();
include("db.php");

if(!isset($_SESSION['user_id']))
{
    header("Location: login.php");
    exit();
}

$id = $_GET['id'];
$user_id = $_SESSION['user_id'];

$stmt = $conn->prepare("
    SELECT * FROM journals
    WHERE id=? AND user_id=? AND is_deleted=0
");

$stmt->bind_param("ii",$id,$user_id);
$stmt->execute();

$result = $stmt->get_result();

if($result->num_rows == 0)
{
    die("Journal not found!");
}

$row = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html>
<head>
<title>View Journal</title>

<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">

<style>
body{
    margin:0;
    font-family:'Inter',sans-serif;
    background:#0b1220;
    color:white;
    display:flex;
    justify-content:center;
    align-items:center;
    min-height:100vh;
}

.card{
    width:700px;
    background:#111827;
    padding:30px;
    border-radius:15px;
    border:1px solid #1f2937;
}

.top{
    display:flex;
    justify-content:space-between;
    align-items:center;
    margin-bottom:20px;
}

.back{
    color:#60a5fa;
    text-decoration:none;
}

.back:hover{
    text-decoration:underline;
}

.title{
    font-size:28px;
    color:#60a5fa;
    margin-bottom:10px;
}

.meta{
    color:#94a3b8;
    font-size:14px;
    margin-bottom:20px;
}

.content{
    line-height:1.8;
    color:#cbd5e1;
    white-space:pre-wrap;
}
</style>

</head>

<body>

<div class="card">

    <div class="top">
        <h2>📖 Journal Entry</h2>

        <a class="back" href="dashboard.php">
            ← Back Dashboard
        </a>
    </div>

    <div class="title">
        <?php echo htmlspecialchars($row['title']); ?>
    </div>

    <div class="meta">
        😊 <?php echo htmlspecialchars($row['mood']); ?>
        |
        📅 <?php echo htmlspecialchars($row['journal_date']); ?>
    </div>

    <div class="content">
        <?php echo nl2br(htmlspecialchars($row['content'])); ?>
    </div>

</div>

</body>
</html>