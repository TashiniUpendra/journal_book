<?php
session_start();
include("db.php");

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

$success = "";
$error = "";

// Get User Data
$stmt = $conn->prepare("SELECT * FROM users WHERE id=?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$user = $stmt->get_result()->fetch_assoc();

if(isset($_POST['update'])){

    $first_name = $_POST['first_name'];
    $last_name  = $_POST['last_name'];
    $phone      = $_POST['phone'];
    $address    = $_POST['address'];
    $about_me   = $_POST['about_me'];
    $gender     = $_POST['gender'];
    $birth_date = $_POST['birth_date'];

    $stmt = $conn->prepare("
        UPDATE users SET
        first_name=?,
        last_name=?,
        phone=?,
        address=?,
        about_me=?,
        gender=?,
        birth_date=?
        WHERE id=?
    ");

    $stmt->bind_param(
        "sssssssi",
        $first_name,
        $last_name,
        $phone,
        $address,
        $about_me,
        $gender,
        $birth_date,
        $user_id
    );

    if($stmt->execute()){
        $success = "Profile Updated Successfully!";
    }else{
        $error = "Update Failed!";
    }

    // Refresh Data
    $stmt = $conn->prepare("SELECT * FROM users WHERE id=?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $user = $stmt->get_result()->fetch_assoc();
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Profile</title>

<style>
body{
    margin:0;
    font-family:Arial;
    background:#0b1220;
    color:white;
}

.sidebar{
    position:fixed;
    width:230px;
    height:100vh;
    background:#111827;
    padding:20px;
}

.logo{
    font-size:20px;
    font-weight:bold;
    color:#60a5fa;
    margin-bottom:25px;
}

.sidebar a{
    display:block;
    color:#cbd5e1;
    text-decoration:none;
    padding:10px;
    border-radius:8px;
    margin-bottom:8px;
}

.sidebar a:hover{
    background:#1f2937;
}

.main{
    margin-left:250px;
    padding:30px;
}

.card{
    max-width:700px;
    background:#111827;
    padding:25px;
    border-radius:15px;
}

h2{
    margin-top:0;
}

input,select,textarea{
    width:100%;
    padding:12px;
    margin-top:10px;
    margin-bottom:15px;
    border:none;
    border-radius:10px;
    background:#1f2937;
    color:white;
    box-sizing:border-box;
}

textarea{
    height:100px;
}

button{
    width:100%;
    padding:12px;
    background:#3b82f6;
    border:none;
    border-radius:10px;
    color:white;
    font-weight:bold;
    cursor:pointer;
}

button:hover{
    background:#2563eb;
}

.success{
    background:#16a34a;
    padding:10px;
    border-radius:8px;
    margin-bottom:15px;
}

.error{
    background:#dc2626;
    padding:10px;
    border-radius:8px;
    margin-bottom:15px;
}
</style>

</head>
<body>

<div class="sidebar">

    <div class="logo">📖 Journal SaaS</div>

    <a href="dashboard.php">🏠 Dashboard</a>
    <a href="add.php">➕ New Journal</a>
    <a href="goals.php">🎯 Goals</a>
    <a href="profile.php">👤 Profile</a>
    <a href="logout.php">🚪 Logout</a>

</div>

<div class="main">

    <div class="card">

        <h2>👤 My Profile</h2>

        <?php if($success){ ?>
            <div class="success"><?php echo $success; ?></div>
        <?php } ?>

        <?php if($error){ ?>
            <div class="error"><?php echo $error; ?></div>
        <?php } ?>

        <form method="POST">

            <label>First Name</label>
            <input type="text" name="first_name"
                value="<?php echo htmlspecialchars($user['first_name'] ?? ''); ?>">

            <label>Last Name</label>
            <input type="text" name="last_name"
                value="<?php echo htmlspecialchars($user['last_name'] ?? ''); ?>">

            <label>Phone</label>
            <input type="text" name="phone"
                value="<?php echo htmlspecialchars($user['phone'] ?? ''); ?>">

            <label>Address</label>
            <input type="text" name="address"
                value="<?php echo htmlspecialchars($user['address'] ?? ''); ?>">

            <label>About Me</label>
            <textarea name="about_me"><?php echo htmlspecialchars($user['about_me'] ?? ''); ?></textarea>

            <label>Gender</label>
            <select name="gender">
                <option value="">Select Gender</option>
                <option value="Male">Male</option>
                <option value="Female">Female</option>
                <option value="Other">Other</option>
            </select>

            <label>Birth Date</label>
            <input type="date" name="birth_date"
                value="<?php echo htmlspecialchars($user['birth_date'] ?? ''); ?>">

            <button type="submit" name="update">
                Update Profile
            </button>

        </form>

    </div>

</div>

</body>
</html>