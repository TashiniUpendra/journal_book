<?php
session_start();
include("db.php");

if(!isset($_SESSION['user_id']))
{
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

$stmt = $conn->prepare("
    SELECT * FROM journals
    WHERE user_id=? AND is_deleted=0
    ORDER BY created_at DESC
");

$stmt->bind_param("i",$user_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html>
<head>
<title>Journal SaaS Pro</title>

<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">

<style>
*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:'Inter', sans-serif;
}

body{
    background:#0b1220;
    color:white;
}

/* SIDEBAR */
.sidebar{
    position:fixed;
    width:240px;
    height:100vh;
    background:#111827;
    padding:20px;
}

.logo{
    font-size:20px;
    font-weight:700;
    color:#60a5fa;
    margin-bottom:30px;
}

.nav a{
    display:block;
    color:#cbd5e1;
    text-decoration:none;
    padding:10px;
    border-radius:8px;
    margin-bottom:8px;
}

.nav a:hover{
    background:#1f2937;
    color:white;
}

/* MAIN */
.main{
    margin-left:260px;
    padding:25px;
}

/* HEADER */
.header{
    display:flex;
    justify-content:space-between;
    align-items:center;
    margin-bottom:20px;
}

.header h2{
    font-size:26px;
}

.btn{
    background:#3b82f6;
    padding:10px 15px;
    border-radius:10px;
    color:white;
    text-decoration:none;
    font-weight:600;
}

.btn:hover{
    background:#2563eb;
}

/* GRID */
.grid{
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(260px,1fr));
    gap:15px;
}

/* CARD */
.card{
    background:#111827;
    padding:15px;
    border-radius:15px;
    transition:0.3s;
    border:1px solid #1f2937;
}

.card:hover{
    transform:translateY(-5px);
    border-color:#3b82f6;
}

.title{
    font-size:18px;
    font-weight:600;
    color:#60a5fa;
}

.meta{
    font-size:12px;
    color:#94a3b8;
    margin:5px 0;
}

.content{
    margin-top:10px;
    font-size:14px;
    color:#cbd5e1;
    line-height:1.5;
}

/* ACTIONS */
.actions{
    margin-top:10px;
    display:flex;
    gap:10px;
}

.actions a{
    font-size:12px;
    text-decoration:none;
    padding:6px 10px;
    border-radius:6px;
}

.view{
    background:#10b981;
    color:white;
}

.edit{
    background:#f59e0b;
    color:white;
}

.delete{
    background:#ef4444;
    color:white;
}

.search{
    margin-bottom:20px;
}

.search input{
    width:100%;
    padding:12px;
    border-radius:10px;
    border:none;
    outline:none;
    background:#1f2937;
    color:white;
}

.empty{
    background:#111827;
    padding:20px;
    border-radius:15px;
    text-align:center;
}
</style>

</head>

<body>

<!-- SIDEBAR -->
<div class="sidebar">

    <div class="logo">📖 Journal SaaS</div>

    <div class="nav">
        <a href="dashboard.php">🏠 Dashboard</a>
        <a href="add.php">➕ New Journal</a>
        <a href="logout.php">🚪 Logout</a>
    </div>

</div>

<!-- MAIN -->
<div class="main">

    <div class="header">
        <h2>
            Welcome 👋 <?php echo htmlspecialchars($_SESSION['username']); ?>
        </h2>

        <a class="btn" href="add.php">
            + New Entry
        </a>
    </div>

    <div class="search">
        <input type="text" placeholder="🔍 Search journals...">
    </div>

    <div class="grid">

    <?php
    if($result->num_rows > 0)
    {
        while($row = $result->fetch_assoc())
        {
    ?>

        <div class="card">

            <div class="title">
                <?php echo htmlspecialchars($row['title']); ?>
            </div>

            <div class="meta">
                😊 <?php echo htmlspecialchars($row['mood']); ?>
                |
                📅 <?php echo htmlspecialchars($row['journal_date']); ?>
            </div>

            <div class="content">
                <?php echo substr(htmlspecialchars($row['content']),0,120); ?>...
            </div>

            <div class="actions">

                <a class="view"
                   href="view.php?id=<?php echo $row['id']; ?>">
                    View
                </a>

                <a class="edit"
                   href="edit.php?id=<?php echo $row['id']; ?>">
                    Edit
                </a>

                <a class="delete"
                   onclick="return confirm('Delete this journal?')"
                   href="delete.php?id=<?php echo $row['id']; ?>">
                    Delete
                </a>

            </div>

        </div>

    <?php
        }
    }
    else
    {
        echo '
        <div class="empty">
            <h3>No journals found</h3>
            <br>
            <a class="btn" href="add.php">Create Your First Journal</a>
        </div>';
    }
    ?>

    </div>

</div>

</body>
</html>