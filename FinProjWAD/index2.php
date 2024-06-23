<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Posts Page</title>
    <style>
         * {
            padding: 0;
            margin: 0;
            box-sizing: border-box;
            font-family: 'Courier New', Courier, monospace;
        }

        body {
            background-color: black;
            font-family: 'Courier New', Courier, monospace;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            background-image: url('post.jpg');
            background-repeat: no-repeat;
            background-size: cover; 
        }
        

        h1 {
            display: flex;
            justify-content: center;
            align-items: center;
            color: black;
            margin-top: 20px;
            font-size: 36px;
        }

        #container {
            background: rgba(255, 255, 255, 0.1);
            color: white;
            border: 2px solid rgba(255, 255, 255, 0.2);
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, .1);
            width: 75%;
            margin: auto;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 20px;
            padding: 20px;
            backdrop-filter: blur(5px);
            box-shadow: -2px 2px 5px #333;
        }

        ul {
            list-style: none;
            padding: 0;
        }

        li {
            background: rgba(200, 255, 255, 0.2);
            padding: 20px;
            margin: 10px 0;
            border-radius: 10px;
            transition: background 0.3s, transform 0.3s;
        }

        li a {
            text-decoration: none;
            color: black;
            font-size: 18px;
            font-weight: bold;
        }

        li:hover {
            background: rgba(255, 255, 255, 0.3);
            transform: scale(1.05);
        }
    </style>
</head>
<body>
    <div id="container" class="posts-container">
        <h1>Posts Page</h1>
        <ul id="postLists">
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
                    $user_id = $_SESSION['user_id'];

                    $query = "SELECT * FROM `posts` WHERE user_id = :id";
                    $statement = $pdo->prepare($query);
                    $statement->execute([':id' => $user_id]);

                    $rows = $statement->fetchAll(PDO::FETCH_ASSOC);

                    foreach ($rows as $row) {
                        echo '<li><a href="index3.php?id=' . $row['id'] . '">' . $row['title'] . '</a></li>';
                    }
                }
            } catch (PDOException $e) {
                echo $e->getMessage();
            }
            ?>
        </ul>
    </div>
</body>
</html>


