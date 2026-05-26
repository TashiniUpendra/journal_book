<?php
session_start();
include("db.php");

$message = "";

if(isset($_POST['login']))
{
    $email = $_POST['email'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT * FROM users WHERE email=?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if($result->num_rows > 0)
    {
        $user = $result->fetch_assoc();

        if(password_verify($password, $user['password']))
        {
            session_regenerate_id(true);

            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];

            header("Location: dashboard.php");
            exit();
        }
        else
        {
            $message = "Incorrect Password!";
        }
    }
    else
    {
        $message = "Email not found!";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Login | Journal SaaS</title>

<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">

<style>
*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:'Inter', sans-serif;
}

/* BACKGROUND */
body{
    height:100vh;
    display:flex;
    justify-content:center;
    align-items:center;
    background: radial-gradient(circle at top,#1e293b,#0b1220);
    overflow:hidden;
}

/* GLOW EFFECTS */
.bg-glow{
    position:absolute;
    width:300px;
    height:300px;
    background:#3b82f6;
    filter:blur(120px);
    opacity:0.4;
    top:-50px;
    left:-50px;
}

.bg-glow2{
    position:absolute;
    width:300px;
    height:300px;
    background:#ec4899;
    filter:blur(120px);
    opacity:0.3;
    bottom:-80px;
    right:-80px;
}

/* CARD */
.card{
    width:380px;
    background:rgba(17,24,39,0.85);
    backdrop-filter:blur(20px);
    border:1px solid rgba(255,255,255,0.08);
    padding:30px;
    border-radius:20px;
    box-shadow:0 20px 60px rgba(0,0,0,0.5);
    color:white;
    z-index:10;
    animation:fadeIn 0.8s ease;
}

@keyframes fadeIn{
    from{transform:translateY(20px);opacity:0;}
    to{transform:translateY(0);opacity:1;}
}

/* TITLE */
h2{
    text-align:center;
    margin-bottom:5px;
    font-size:26px;
}

p{
    text-align:center;
    font-size:13px;
    color:#94a3b8;
    margin-bottom:20px;
}

/* INPUT */
input{
    width:100%;
    padding:12px;
    margin:10px 0;
    border-radius:12px;
    border:1px solid #1f2937;
    background:#0f172a;
    color:white;
    outline:none;
    transition:0.3s;
}

input:focus{
    border-color:#3b82f6;
    box-shadow:0 0 0 2px rgba(59,130,246,0.2);
}

/* BUTTON */
button{
    width:100%;
    padding:12px;
    border:none;
    border-radius:12px;
    background:linear-gradient(90deg,#3b82f6,#6366f1);
    color:white;
    font-weight:600;
    cursor:pointer;
    transition:0.3s;
}

button:hover{
    transform:translateY(-2px);
    box-shadow:0 10px 20px rgba(59,130,246,0.3);
}

/* MESSAGE */
.message{
    background:#ef4444;
    padding:8px;
    border-radius:8px;
    text-align:center;
    font-size:13px;
    margin-bottom:10px;
}

/* HOME BUTTON */
.home-btn{
    display:block;
    text-align:center;
    margin-top:12px;
    padding:10px;
    border-radius:10px;
    background:#1f2937;
    color:#cbd5e1;
    text-decoration:none;
    font-size:13px;
    transition:0.3s;
}

.home-btn:hover{
    background:#374151;
    color:white;
}

/* LINK */
a{
    color:#60a5fa;
    text-decoration:none;
    font-size:13px;
}

a:hover{
    text-decoration:underline;
}
</style>

</head>

<body>

<div class="bg-glow"></div>
<div class="bg-glow2"></div>

<div class="card">

    <h2>📖 Welcome Back</h2>
    <p>Login to your Journal SaaS</p>

    <?php if($message!=""){ ?>
        <div class="message"><?php echo $message; ?></div>
    <?php } ?>

    <form method="POST">

        <input type="email" name="email" placeholder="Email address" required>

        <input type="password" name="password" placeholder="Password" required>

        <button type="submit" name="login">Sign In</button>

    </form>

    <!-- HOME BUTTON -->
    <a href="index.php" class="home-btn">🏠 Back to Home</a>

    <p style="margin-top:15px;">
        Don't have account? <a href="register.php">Create account</a>
    </p>

</div>

</body>
</html>