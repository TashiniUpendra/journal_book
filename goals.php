<?php
session_start();
include("db.php");

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

/* FETCH GOALS */
$stmt = $conn->prepare("
    SELECT * FROM future_goals 
    WHERE user_id=? 
    ORDER BY created_at DESC
");

$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html>
<head>
<title>Your Goals</title>

<style>
body{
    margin:0;
    font-family:Arial;
    background:#0b1220;
    color:white;
}

.sidebar{
    position:fixed;
    width:220px;
    height:100vh;
    background:#111827;
    padding:20px;
}

.sidebar a{
    display:block;
    color:#cbd5e1;
    text-decoration:none;
    padding:10px;
    margin-bottom:8px;
    border-radius:8px;
}

.sidebar a:hover{
    background:#1f2937;
}

.main{
    margin-left:240px;
    padding:20px;
}

.header{
    display:flex;
    justify-content:space-between;
    align-items:center;
}

.btn{
    background:#3b82f6;
    padding:10px 15px;
    border-radius:10px;
    color:white;
    text-decoration:none;
}

.grid{
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(260px,1fr));
    gap:15px;
    margin-top:20px;
}

.card{
    background:#111827;
    padding:15px;
    border-radius:12px;
    border:1px solid #1f2937;
}

.title{
    font-size:18px;
    color:#60a5fa;
    font-weight:bold;
}

.meta{
    font-size:12px;
    color:#94a3b8;
    margin:5px 0;
}

.progress{
    margin-top:10px;
    height:8px;
    background:#1f2937;
    border-radius:5px;
    overflow:hidden;
}

.progress-bar{
    height:100%;
    background:#10b981;
}
.actions{
    margin-top:10px;
}

.actions a{
    text-decoration:none;
    font-size:12px;
    padding:6px 10px;
    border-radius:6px;
    margin-right:5px;
}

.edit{ background:#f59e0b; color:white; }
.delete{ background:#ef4444; color:white; }
.add{ background:#3b82f6; color:white; }
</style>

</head>

<body>

<!-- SIDEBAR -->
<div class="sidebar">
    <h3 style="color:#60a5fa;">📖 Journal SaaS</h3>

    <a href="dashboard.php">🏠 Dashboard</a>
    <a href="goals.php">🎯 Goals</a>
    <a href="add_goal.php">➕ Add Goal</a>
    <a href="logout.php">🚪 Logout</a>
</div>

<!-- MAIN -->
<div class="main">

    <div class="header">
        <h2>🎯 Your Goals</h2>

        <a class="btn" href="add_goal.php">+ Add Goal</a>
    </div>

    <div class="grid">

    <?php if ($result->num_rows > 0) { ?>

        <?php while ($row = $result->fetch_assoc()) { ?>

        <div class="card">

            <div class="title">
                <?php echo htmlspecialchars($row['goal_title']); ?>
            </div>

            <div class="meta">
                📅 <?php echo $row['target_date']; ?> |
                📊 <?php echo $row['status']; ?>
            </div>

            <!-- PROGRESS BAR -->
            <div class="progress">
                <div class="progress-bar" style="width:<?php echo $row['progress']; ?>%"></div>
            </div>

            <div style="margin-top:5px; font-size:12px;">
                <?php echo $row['progress']; ?>%
            </div>

            <div class="actions">
                <a class="edit" href="edit_goal.php?id=<?php echo $row['id']; ?>">Edit</a>
                <a class="delete" href="delete_goal.php?id=<?php echo $row['id']; ?>"
                   onclick="return confirm('Delete this goal?')">Delete</a>
            </div>

        </div>

        <?php } ?>

    <?php } else { ?>

        <div class="card">
            🎯 No goals found. Start by adding your first goal.
            <br><br>
            <a class="add" href="add_goal.php">+ Add Goal</a>
        </div>

    <?php } ?>

    </div>

</div>

</body>
</html>