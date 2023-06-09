<?php


session_start();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['username']) && isset($_POST['password']) && isset($_POST['name']) && isset($_POST['birthdate'])) {
        $username = $_POST['username'];
        $password = $_POST['password'];
        $name = $_POST['name'];
        $birthdate = $_POST['birthdate'];

        //добавляю фотографию в базу данных

        // Хешируем пароль
        $hashed_password = hash('sha256', $password);

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

        // Проверяем, есть ли пользователь с таким логином
        $stmt = $pdo->prepare('SELECT * FROM users WHERE username = ?');
        $stmt->execute([$username]);
        $user = $stmt->fetch();

        if ($user) {
            // Пользователь с таким логином уже есть
            exit('Пользователь с таким логином уже зарегистрирован');
        } else {

            // добавляю фото в базу данных
            if (is_uploaded_file($_FILES['photo']['tmp_name'])) {
                $imgData = file_get_contents($_FILES['photo']['tmp_name']);
                $imgType = $_FILES['photo']['type'];
                $sql = "INSERT INTO photos (imageType ,imageData) VALUES(?, ?)";
                $statement = $pdo->prepare($sql);
                //$statement->bindParam('ss', $imgType, $imgData);
                $statement->execute([$imgType, $imgData]) or die("<b>Error:</b> Problem on Image Insert<br/>");

                $sql = "SELECT id FROM photos ORDER BY ID DESC LIMIT ?";

                $statement = $pdo->prepare($sql);
                $statement->execute([1]) or die("<b>Error:</b> Problem on Retrieving Image BLOB<br/>");
                $row = $statement->fetch();
            }
            //регистрирую пользователя
            $stmt = $pdo->prepare('INSERT INTO users (username, password, name, birthdate, photo_id) VALUES (?, ?, ?, ?,?)');
            $stmt->bindParam(':data', $photo, PDO::PARAM_LOB);
            $stmt->execute([$username, $hashed_password, $name, $birthdate, $row['id']]);
        }
    }
}
header('Location: login_form.php');
