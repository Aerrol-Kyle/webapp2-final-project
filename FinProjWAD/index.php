<?php

require 'config.php';

$dsn = "mysql:host=$host;dbname=$db;charset=UTF8";
$options = [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION];

try {
    $pdo = new PDO($dsn, $user, $password, $options);

    if ($pdo) {
        if ($_SERVER['REQUEST_METHOD'] === "POST") {
            $username = $_POST['username'];
            $password = $_POST['password'];

            $query = "SELECT * FROM `users` WHERE username = :username";
            $statement = $pdo->prepare($query);
            $statement->execute([':username' => $username]);

            $user = $statement->fetch(PDO::FETCH_ASSOC);

            if ($user) {
                if ('password' === $password) {
                    $_SESSION['user_id'] = $user['id'];
                    $_SESSION['username'] = $user['username'];

                    header("Location: index2.php");
                    exit;
                } else {
                    echo "Invalid password!";
                }
            } else {
                echo "User not found!";
            }
        }
    }
} catch (PDOException $e) {
    echo $e->getMessage();
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <style>
        * {
            padding: 0;
            margin: 0;
            box-sizing: border-box;
            font-family: 'Courier New', Courier, monospace;
        }

        body {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background: black;
            background-size: cover;
            background-position: center;
            background-image: url('3.jpg');
        }

        .wrapper {
            width: 420px;
            background: transparent;
            border: 2px solid rgba(255, 255, 255, .2);
            backdrop-filter: blur(5px);
            box-shadow: 0 0 10px rgba(0, 0, 0, .1);
            color: white;
            border-radius: 10px;
            padding: 30px 40px;
            box-shadow: -2px 2px 5px #333;
           
        }

        .wrapper h1 {
            font-size: 36px;
            text-align: center;
        }

        .input-box {
            width: 100%;
            height: 50px;
            margin-bottom: 30px;
            color: white; 
        }

        .input-box input {
            width: 100%;
            height: 60%;
            background: white;
            border: none;
            outline: none;
            border: 2px solid rgba(255, 255, 255, .2);
            border-radius: 40px;
            font-size: 16px;
            padding: 20px 20px 20px 20px;
            color: black; 
        }

        input::placeholder {
        color: black;
        opacity: 1; 
        }

        .input-box label {
            display: block;
            margin-bottom: 5px; /* Space between label and input */
            font-weight: bold;
        }


        .icon {
        position: absolute;
        left: 10px;
        top: 50%;
        transform: translateY(-50%);
        width: 20px; /* Adjust the width as needed */
        height: 20px; /* Adjust the height as needed */
        }

        .remember-forgot {
            display: flex;
            justify-content: space-between;
            font-size: 14.5px;
            margin: 15px;
            color: white;

        }

        h1 {
            margin-bottom: 20px;
        }

        .remember-forgot label input {
            accent-color: #fff;
            margin-right: 3px;
            cursor: pointer;
        }

        .remember-forgot a {
            color: white;
            text-decoration: none;
        }

        .remember-forgot a:hover {
            text-decoration: underline;
        }

        .btn {
            width: 70%;
            height: 40px;
            border: none;
            outline: none;
            border-radius: 40px;
            box-shadow: 0 0 10px rgba(0, 0, 0, .1);
            cursor: pointer;
            font-size: 16px;
            color: #333;
            font-weight: bold;
            box-shadow: -2px 3px #333;
            margin-left: 50px;
        }

        .btn:hover {
            box-shadow: 0 0 !important;
            border: inset 4px #333 !important;
        }

        .register-link {
            font-size: 14.5px;
            text-align: center;
            margin: 20px 0 15px;
        }

        .register-link p a {
            color: #fff;
            text-decoration: none;
            font-weight: 600;
        }

        .register-link p a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>


    
    <div class="wrapper">
        <h1>Login</h1>
        <div class="login-container">
            <form id="loginForm" method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
                    <div class="input-box">
                 <label for="username">Username</label>
                <input type="text" id="username" placeholder="Enter username" name="username" required>
                    </div>
                    <div class="input-box">
                 <label for="password">Password</label>
                <input type="password" id="password" placeholder="Enter password" name="password" required>
                    </div>
                    <div class="remember-forgot">
                <label><input type="checkbox" name="remember"> Remember me</label>
                <a href="#">Forgot password?</a>
                    </div>
                <button class="btn" id="submit">Login</button>
            </form>
        </div>
        <div class="register-link">
            <p>Don't have an account? <a href="#">Register here</a></p>
        </div>
    </div>
</body>
</html>
