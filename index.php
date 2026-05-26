<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Journal Book</title>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&family=Playfair+Display:wght@700&display=swap" rel="stylesheet">

    <style>

        *{
            margin:0;
            padding:0;
            box-sizing:border-box;
        }

        body{
            font-family:'Poppins', sans-serif;
            min-height:100vh;
            display:flex;
            justify-content:center;
            align-items:center;
            background:linear-gradient(135deg,#667eea,#764ba2,#ff758c);
            background-size:400% 400%;
            animation:bgMove 10s ease infinite;
            overflow:hidden;
        }

        @keyframes bgMove{
            0%{
                background-position:0% 50%;
            }
            50%{
                background-position:100% 50%;
            }
            100%{
                background-position:0% 50%;
            }
        }

        .container{
            width:100%;
            display:flex;
            justify-content:center;
            align-items:center;
            padding:20px;
        }

        .book-card{
            position:relative;
            width:500px;
            padding:50px 40px;
            text-align:center;
            border-radius:25px;
            background:rgba(255,255,255,0.15);
            backdrop-filter:blur(15px);
            border:1px solid rgba(255,255,255,0.2);
            box-shadow:0 15px 35px rgba(0,0,0,0.25);
            overflow:hidden;
        }

        .glow{
            position:absolute;
            width:300px;
            height:300px;
            background:rgba(255,255,255,0.2);
            border-radius:50%;
            top:-120px;
            left:-100px;
            filter:blur(60px);
        }

        h1{
            font-family:'Playfair Display', serif;
            font-size:42px;
            color:#fff;
            margin-bottom:15px;
        }

        p{
            color:#f5f5f5;
            font-size:16px;
            line-height:1.8;
            margin-bottom:35px;
        }

        .buttons{
            display:flex;
            justify-content:center;
            gap:20px;
        }

        .buttons a{
            text-decoration:none;
        }

        .buttons button{
            border:none;
            padding:14px 35px;
            border-radius:50px;
            font-size:16px;
            font-weight:600;
            cursor:pointer;
            transition:0.4s;
        }

        .login-btn{
            background:#ffffff;
            color:#6a11cb;
        }

        .register-btn{
            background:#ff758c;
            color:white;
        }

        .login-btn:hover{
            transform:translateY(-5px);
            box-shadow:0 10px 20px rgba(255,255,255,0.4);
        }

        .register-btn:hover{
            transform:translateY(-5px);
            box-shadow:0 10px 20px rgba(255,117,140,0.5);
        }

        .book-card:hover{
            transform:scale(1.02);
            transition:0.4s;
        }

        .footer{
            margin-top:25px;
            color:white;
            font-size:13px;
            opacity:0.8;
        }

        @media(max-width:600px){

            .book-card{
                width:100%;
                padding:40px 25px;
            }

            h1{
                font-size:32px;
            }

            .buttons{
                flex-direction:column;
            }

            .buttons button{
                width:100%;
            }
        }

    </style>
</head>

<body>

<div class="container">

    <div class="book-card">

        <div class="glow"></div>

        <h1>📖 My Journal Book</h1>

        <p>
            Welcome to your personal journal. <br>
            Capture memories, record your thoughts, express your emotions,
            and keep your life stories safely in one beautiful place.
        </p>

        <div class="buttons">

            <a href="login.php">
                <button class="login-btn">Login</button>
            </a>

            <a href="register.php">
                <button class="register-btn">Register</button>
            </a>

        </div>

        <div class="footer">
            © 2026 My Journal Book | All Rights Reserved
        </div>

    </div>

</div>

</body>
</html>