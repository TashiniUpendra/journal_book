<?php
session_start();
include("db.php");

if(!isset($_SESSION['user_id']))
{
    header("Location: login.php");
    exit();
}

$message = "";
$success = "";

if(isset($_POST['save']))
{
    $user_id = $_SESSION['user_id'];
    $title = trim($_POST['title']);
    $mood = $_POST['mood'];
    $content = trim($_POST['content']);
    $date = $_POST['journal_date'];

    if(empty($title) || empty($content))
    {
        $message = "⚠ Please fill all fields!";
    }
    else
    {
        $stmt = $conn->prepare("
            INSERT INTO journals
            (user_id,title,mood,content,journal_date,created_at)
            VALUES (?,?,?,?,?,NOW())
        ");

        $stmt->bind_param(
            "issss",
            $user_id,
            $title,
            $mood,
            $content,
            $date
        );

        if($stmt->execute())
        {
            $success = "Journal saved successfully ✅";
        }
        else
        {
            $message = "Failed to save journal!";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Add Journal</title>

<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">

<style>

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:'Inter',sans-serif;
}

body{
    min-height:100vh;
    display:flex;
    justify-content:center;
    align-items:center;
    background:linear-gradient(135deg,#0f172a,#1e293b,#312e81);
    color:white;
}

.card{
    width:700px;
    background:rgba(17,24,39,0.9);
    padding:30px;
    border-radius:20px;
    box-shadow:0 15px 40px rgba(0,0,0,0.4);
}

.top{
    display:flex;
    justify-content:space-between;
    align-items:center;
    margin-bottom:20px;
}

.top a{
    text-decoration:none;
    color:#cbd5e1;
}

.top a:hover{
    color:white;
}

h2{
    margin-bottom:10px;
}

input,
select,
textarea{
    width:100%;
    padding:12px;
    margin:10px 0;
    border:none;
    border-radius:10px;
    background:#0f172a;
    color:white;
}

textarea{
    height:220px;
    resize:none;
}

button{
    width:100%;
    padding:12px;
    border:none;
    border-radius:10px;
    background:#4f46e5;
    color:white;
    font-size:16px;
    cursor:pointer;
}

button:hover{
    background:#4338ca;
}

.message{
    background:#dc2626;
    padding:10px;
    border-radius:8px;
    margin-bottom:10px;
    text-align:center;
}

.success{
    background:#16a34a;
    padding:10px;
    border-radius:8px;
    margin-bottom:10px;
    text-align:center;
}

.counter{
    text-align:right;
    font-size:12px;
    color:#94a3b8;
}

</style>
</head>

<body>

<div class="card">

    <div class="top">
        <h2>📝 New Journal</h2>

        <a href="dashboard.php">
            ← Dashboard
        </a>
    </div>

    <?php
    if($message!="")
    {
        echo "<div class='message'>$message</div>";
    }

    if($success!="")
    {
        echo "<div class='success'>$success</div>";
    }
    ?>

    <form method="POST">

        <input
            type="text"
            name="title"
            placeholder="Journal Title"
            required
        >

        <select name="mood">
            <option value="Happy">😊 Happy</option>
            <option value="Sad">😔 Sad</option>
            <option value="Excited">🔥 Excited</option>
            <option value="Neutral">😐 Neutral</option>
            <option value="Tired">😴 Tired</option>
        </select>

        <input
            type="date"
            name="journal_date"
            required
        >

        <textarea
            name="content"
            id="content"
            maxlength="2000"
            placeholder="Write your thoughts..."
            required
        ></textarea>

        <div class="counter">
            <span id="count">0</span>/2000
        </div>

        <br>

        <button type="submit" name="save">
            Save Journal
        </button>

    </form>

</div>

<script>
let content = document.getElementById("content");
let count = document.getElementById("count");

content.addEventListener("input", function()
{
    count.innerText = content.value.length;
});
</script>

</body>
</html>