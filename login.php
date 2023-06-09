<?php


session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['username']) && isset($_POST['password'])) {
        $username = $_POST['username'];
        $password = $_POST['password'];

        // Подключаемся к базе данных
        $db_file = './database.db';

        try {
            $pdo = new PDO("sqlite:$db_file");
            $pdo->setAttribute(
                PDO::ATTR_ERRMODE,
                PDO::ERRMODE_EXCEPTION
            );
            // echo "Connected successfully";
        } catch (PDOException $e) {
            echo "Connection failed:" . $e->getMessage();
        }

        // Проверяем, есть ли пользователь с таким логином и паролем
        $stmt = $pdo->prepare('SELECT * FROM users WHERE `username` = ?');
        $stmt->execute([$username]);
        $user = $stmt->fetch();

        // Сравниваем хэшированные значения логина и пароля со значениями в сессии
        $hash = hash('sha256', $username . $password);
        if (isset($_SESSION['login_failures'])) {
            $failures = array_filter($_SESSION['login_failures'], function ($failure) use ($hash) {
                return ($failure[0] === $hash);
            });

            if (count($failures) >= 5000) {
                exit('Слишком много неудачных попыток входа. Попробуйте снова через 5 минут.');
            }
        }

        $hashed_password = hash("sha256", $password);
        // Проверяем, соответствует ли пароль хешу в базе данных
        if ($user && ($hashed_password == $user['password'])) {
            // Успешная авторизация
            $_SESSION['user_id'] = $user['id'];

            // Очищаем предыдущие ошибки аутентификации
            if (isset($_SESSION['login_failures'])) {
                $_SESSION['login_failures'] = array_filter($_SESSION['login_failures'], function ($failure) use ($hash) {
                    return ($failure[0] !== $hash);
                });
            }

            // Выводим информацию о пользователе
            $users_photo_id = $user['photo_id'];

            $sql = "SELECT imageType,imageData FROM photos WHERE id=?";
            $statement = $pdo->prepare($sql);
            $statement->execute([$users_photo_id]) or die("<b>Error:</b> Problem on Retrieving Image BLOB<br/>");
            $row = $statement->fetch();


            $output = '<link rel="stylesheet" href="style.css">';
            
            $output .= '<div class = "container"> <p class = "header">  Имя пользователя: ' . htmlspecialchars($user['name']) . '</p>';
            $output .= '<div id = "message"></div>';
            $output .= '<script src = "./message.js"></script>';
            
            
            $output .= '<img src="data:image/jpeg;base64,' . base64_encode($row['imageData']) . '"/>';

            $output .= '<p class = "text">Дата рождения пользователя: ' . htmlspecialchars($user['birthdate']) . '</p>';
            $output .= '<p><button class="btn" ><a href="logout.php">Выход</a></button></p></div>';

            echo $output;

            exit();
        } else {
            // Неверный логин или пароль
            if (isset($_SESSION['login_failures'])) {
                $_SESSION['login_failures'][] = [$hash, time()];
            } else {
                $_SESSION['login_failures'] = [[$hash, time()]];
            }

            exit('Неверный логин или пароль');
        }
    }
}
