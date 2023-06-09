<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="style.css">
    <title>Форма регистрации</title>
</head>

<body>

    <div class='header'>Регистрация</div>

    <form id="register-form" action="register.php" method="POST" enctype="multipart/form-data">
        <p>
            <label for="username" class='padding'>Логин:</label>
            <input type="text" name="username" id="username" class='text-input' required>
        </p>
        <p>
            <label for="password">Пароль:</label>
            <input type="password" name="password" id="password" class='text-input' required>
        </p>
        <p>
            <label for="name" class='padding_2'>Имя:</label>
            <input type="text" name="name" id="name" class='text-input' required>
        </p>
        <p class='padding_3'>
            <label for="birthdate" >Дата рождения:</label>
            <input type="date" name="birthdate" id="birthdate" class='text-input' required>
        </p>
        <p>
            <label for="photo">Фотография:</label>
            <input type="file" name="photo" id="photo" required/>
        </p>
        <p>
            <button type="submit" id="register-button" class='btn'>Зарегистрироваться</button>
        </p>
    </form>

    <div id="error-message"></div>

</body>

</html>