<?php
include("db.php");

$message = "";

if(isset($_POST['register']))
{
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    if(empty($username) || empty($email) || empty($password))
    {
        $message = "All fields are required!";
    }
    else
    {
        $check = $conn->prepare("SELECT id FROM users WHERE email=?");
        $check->bind_param("s", $email);
        $check->execute();
        $result = $check->get_result();

        if($result->num_rows > 0)
        {
            $message = "Email already exists!";
        }
        else
        {
            $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

            $stmt = $conn->prepare("INSERT INTO users(username,email,password) VALUES(?,?,?)");
            $stmt->bind_param("sss", $username, $email, $hashedPassword);

            if($stmt->execute())
            {
                header("Location: login.php");
                exit();
            }
            else
            {
                $message = "Registration failed!";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Register | Journal SaaS</title>

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
}

/* GLOW EFFECT */
.glow{
    position:absolute;
    width:300px;
    height:300px;
    background:#6366f1;
    filter:blur(120px);
    opacity:0.4;
    top:-50px;
    left:-50px;
}

.glow2{
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
    width:400px;
    background:rgba(17,24,39,0.9);
    backdrop-filter:blur(20px);
    border:1px solid rgba(255,255,255,0.08);
    padding:30px;
    border-radius:20px;
    color:white;
    z-index:10;
    animation:fadeIn 0.7s ease;
}

@keyframes fadeIn{
    from{transform:translateY(20px);opacity:0;}
    to{transform:translateY(0);opacity:1;}
}

h2{
    text-align:center;
    margin-bottom:5px;
}

p{
    text-align:center;
    font-size:13px;
    color:#94a3b8;
    margin-bottom:15px;
}

/* INPUT */
input{
    width:100%;
    padding:12px;
    margin:8px 0;
    border-radius:12px;
    border:1px solid #1f2937;
    background:#0f172a;
    color:white;
    outline:none;
}

input:focus{
    border-color:#3b82f6;
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
}

button:hover{
    transform:translateY(-2px);
}

/* HOME BUTTON */
.home-btn{
    display:block;
    text-align:center;
    margin-top:10px;
    padding:10px;
    border-radius:12px;
    background:#1f2937;
    color:#cbd5e1;
    text-decoration:none;
    font-size:13px;
}

.home-btn:hover{
    background:#374151;
    color:white;
}

/* MESSAGE */
.message{
    background:#ef4444;
    padding:8px;
    border-radius:10px;
    text-align:center;
    margin-bottom:10px;
    font-size:13px;
}
</style>

</head>

<body>

<div class="glow"></div>
<div class="glow2"></div>

<div class="card">

    <h2>📝 Create Account</h2>
    <p>Join your Journal SaaS</p>

    <?php if($message!=""){ ?>
        <div class="message"><?php echo $message; ?></div>
    <?php } ?>

    <form method="POST">

        <input type="text" name="username" placeholder="Username" required>

        <input type="email" name="email" placeholder="Email" required>

        <input type="password" name="password" placeholder="Password" required>

        <button type="submit" name="register">Register</button>

    </form>

    <!-- HOME BUTTON -->
    <a href="index.php" class="home-btn">🏠 Back to Home</a>

    <p style="margin-top:10px;">
        Already have account? <a href="login.php" style="color:#60a5fa;">Login</a>
    </p>

</div>

</body>
</html>