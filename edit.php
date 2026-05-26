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
    die("Invalid request");
}

$id = intval($_GET['id']);
$user_id = $_SESSION['user_id'];

// SELECT journal (safe + user check)
$stmt = $conn->prepare("
    SELECT * FROM journals 
    WHERE id=? AND user_id=? AND is_deleted=0
");

$stmt->bind_param("ii", $id, $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    die("Journal not found!");
}

$data = $result->fetch_assoc();

// UPDATE
if (isset($_POST['update'])) {

    $title = $_POST['title'];
    $mood = $_POST['mood'];
    $content = $_POST['content'];
    $date = $_POST['journal_date'];

    $stmt = $conn->prepare("
        UPDATE journals 
        SET title=?, mood=?, content=?, journal_date=? 
        WHERE id=? AND user_id=?
    ");

    $stmt->bind_param(
        "ssssii",
        $title,
        $mood,
        $content,
        $date,
        $id,
        $user_id
    );

    if ($stmt->execute()) {
        header("Location: dashboard.php");
        exit();
    } else {
        echo "Update failed!";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Edit Journal</title>

<style>
body{
    margin:0;
    font-family:Arial;
    background:#0b1220;
    display:flex;
    justify-content:center;
    align-items:center;
    height:100vh;
    color:white;
}

.card{
    width:500px;
    background:#111827;
    padding:25px;
    border-radius:15px;
}

input, select, textarea{
    width:100%;
    padding:12px;
    margin:8px 0;
    border:none;
    border-radius:10px;
    background:#1f2937;
    color:white;
}

button{
    width:100%;
    padding:12px;
    border:none;
    border-radius:10px;
    background:#f59e0b;
    font-weight:bold;
    cursor:pointer;
}
</style>

</head>

<body>

<div class="card">

    <h2>✏ Edit Journal</h2>

    <form method="POST">

        <input type="text" name="title"
               value="<?php echo htmlspecialchars($data['title']); ?>" required>

        <select name="mood" required>
            <option value="happy" <?php if($data['mood']=="happy") echo "selected"; ?>>happy</option>
            <option value="sad" <?php if($data['mood']=="sad") echo "selected"; ?>>sad</option>
            <option value="neutral" <?php if($data['mood']=="neutral") echo "selected"; ?>>neutral</option>
            <option value="excited" <?php if($data['mood']=="excited") echo "selected"; ?>>excited</option>
            <option value="stressed" <?php if($data['mood']=="stressed") echo "selected"; ?>>stressed</option>
        </select>

        <input type="date" name="journal_date"
               value="<?php echo $data['journal_date']; ?>" required>

        <textarea name="content" required><?php echo htmlspecialchars($data['content']); ?></textarea>

        <button type="submit" name="update">Update Journal</button>

    </form>

</div>

</body>
</html>