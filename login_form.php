<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Форма авторизации</title>
   <!-- <script src="script.js"></script> -->
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <div class = 'header'>Авторизация</div>

    <form id="login-form" action="login.php" method="POST">
    
        <p>
            <label for="username" class = 'padding'>Логин:</label>
            <input type="text" name="username" id="username" class = 'text-input'required>
        </p>
        <p>
            <label for="password">Пароль:</label>
            <input type="password" name="password" id="password"  class = 'text-input'required>
        </p>
        <p>
            <button type="submit" id="login-button" class = 'btn' >Войти</button><br>

        </p>
    </form>
    <button class="btn_2" ><a href="register_form.php">Нет аккаунта?</a></button>
    <div id="error-message"></div>

    <div id="user-info"></div>

</body>
</html>