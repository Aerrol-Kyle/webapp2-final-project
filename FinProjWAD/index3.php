<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Post Page</title>
    <style>
         * {
            padding: 0;
            margin: 0;
            box-sizing: border-box;
            font-family: 'Courier New', Courier, monospace;
        }

        body {
            
            color: #ffffff;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
            padding: 20px;
            background-image: url('4.png');
        }

        .container {
            max-width: 800px;
            width: 100%;
            background-color: #333333;
            border-radius: 12px;
            padding: 30px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.5);
            backdrop-filter: blur(10px);
            background-size: cover;
            background-position: center;
            margin-bottom: 10px;
            position: relative;
            
        }

        .item-details {
            position: relative;
            z-index: 2; 
        }

        h1 {
            font-size: 36px;
            text-align: center;
            margin-bottom: 20px;
            color: black;
        }
        
        h3 {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 10px;
        }

        p {
            font-size: 18px;
            line-height: 1.6;
            margin-bottom: 20px;
        }

        .return {
            display: flex;
            justify-content: center;
            margin-top: 10px;
            margin-left: 700px;
        }

        #return {
            display: inline-flex;
            align-items: center;
            background-color: #333333;
            color: white;
            padding: 10px 20px;
            border-radius: 25px;
            text-decoration: none;
            font-size: 18px;
            font-weight: bold;
            transition: background-color 0.3s, color 0.3s, transform 0.3s;
        }

        #return:hover {
            color: black;
            transform: scale(1.05);
            background-color: #ffffff;
        }
    </style>
</head>
<body>
    <h1>Post Page</h1>
    <div class="container">
        <div class="item-details">
            <?php
            require 'config.php';

            if (!isset($_SESSION['user_id'])) {
                header("Location: index.php");
                exit;
            }

            $dsn = "mysql:host=$host;dbname=$db;charset=UTF8";
            $options = [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION];

            try {
                $pdo = new PDO($dsn, $user, $password, $options);

                if ($pdo) {
                    if (isset($_GET['id'])) {
                        $id = $_GET['id'];

                        $query = "SELECT * FROM `posts` WHERE id = :id";
                        $statement = $pdo->prepare($query);
                        $statement->execute([':id' => $id]);

                        $post = $statement->fetch(PDO::FETCH_ASSOC);

                        if ($post) {
                            echo '<h3>Title: ' . $post['title'] . '</h3>';
                            echo '<p>Body: ' . $post['body'] . '</p>';
                        } else {
                            echo '<div class="item-info">No post found with ID ' . htmlspecialchars($id) . '!</div>';
                        }
                    } else {
                        echo '<div class="item-info">No post ID provided!</div>';
                    }
                }
            } catch (PDOException $e) {
                echo '<div class="item-info">' . htmlspecialchars($e->getMessage()) . '</div>';
            }
            ?>
        </div>
    </div>
    <div class="return">
            <a id="return" href="index2.php">BACK</a>
        </div>
</body>
</html>
