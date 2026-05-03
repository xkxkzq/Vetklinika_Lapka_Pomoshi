<?php
session_start();

// Подключение к базе данных
$link = mysqli_connect('localhost', 'root', '', 'vetklinika') or die(mysqli_error($link));

$error = '';

// Проверяем, отправлена ли форма
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['phone']) && isset($_POST['password'])) {
    $phone = mysqli_real_escape_string($link, $_POST['phone']);
    $password = mysqli_real_escape_string($link, $_POST['password']);
    
    // Очищаем телефон от форматирования и приводим к единому формату (10 цифр)
    $clean_phone = preg_replace('/[^0-9]/', '', $phone);
    
    // Обработка различных форматов номера
    if (strlen($clean_phone) == 11) {
        // Если номер начинается с 8 или 7, убираем первую цифру
        if ($clean_phone[0] == '8' || $clean_phone[0] == '7') {
            $clean_phone = substr($clean_phone, 1);
        }
    } elseif (strlen($clean_phone) == 10) {
        // Номер уже в правильном формате (10 цифр)
        $clean_phone = $clean_phone;
    } else {
        $error = 'Неверный формат номера телефона';
    }
    
    // Поиск пользователя (в БД номер хранится в формате 10 цифр, без 8 или +7)
    if (empty($error)) {
        $query = "SELECT * FROM users WHERE phone = '$clean_phone' AND password = '$password'";
        $result = mysqli_query($link, $query);
        
        if (mysqli_num_rows($result) > 0) {
            $user = mysqli_fetch_assoc($result);
            
            // Сохраняем данные в сессию
            $_SESSION['user_id'] = $user['id_user'];
            $_SESSION['surname'] = $user['surname'];
            $_SESSION['name'] = $user['name'];
            $_SESSION['phone'] = $user['phone'];
            $_SESSION['login'] = true;
            
            // Закрываем соединение
            mysqli_close($link);
            
            // Перенаправляем в профиль
            header('Location: profile.php');
            exit;
        } else {
            $error = 'Неверный номер телефона или пароль';
        }
    }
}

// Закрываем соединение
mysqli_close($link);

// Если пользователь уже авторизован и это НЕ POST запрос, перенаправляем
if (isset($_SESSION['login']) && $_SESSION['login'] === true && $_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: profile.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Вход - Лапка помощи</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Roboto', sans-serif;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #ebfffb 0%, #d4f5ef 100%);
            padding: 40px 20px;
        }
        
        .login-card {
            max-width: 450px;
            width: 100%;
            background: white;
            border-radius: 32px;
            box-shadow: 0 20px 40px rgba(0, 151, 121, 0.15);
            overflow: hidden;
        }
        
        .login-header {
            background: linear-gradient(120deg, #009779 0%, #00b894 100%);
            padding: 40px 30px;
            text-align: center;
        }
        
        .login-logo {
            width: 80px;
            height: 80px;
            background: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
        }
        
        .login-logo i {
            font-size: 40px;
            color: #009779;
        }
        
        .login-header h1 {
            color: white;
            font-size: 1.8rem;
            margin-bottom: 8px;
        }
        
        .login-header p {
            color: rgba(255,255,255,0.9);
            font-size: 0.9rem;
        }
        
        .login-body {
            padding: 40px 30px;
        }
        
        .form-group {
            margin-bottom: 25px;
        }
        
        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: #2d3748;
            font-size: 0.9rem;
        }
        
        .form-group label i {
            color: #009779;
            width: 20px;
        }
        
        .phone-input {
            display: flex;
            align-items: center;
            border: 2px solid #e2e8f0;
            border-radius: 16px;
            overflow: hidden;
            transition: all 0.3s;
        }
        
        .phone-input:focus-within {
            border-color: #009779;
            box-shadow: 0 0 0 3px rgba(0, 151, 121, 0.1);
        }
        
        .phone-prefix {
            background: #f7fafc;
            padding: 14px 16px;
            color: #4a5568;
            font-weight: 500;
            border-right: 2px solid #e2e8f0;
        }
        
        .phone-input input {
            border: none;
            flex: 1;
            padding: 14px 16px;
            font-size: 1rem;
            outline: none;
        }
        
        .form-group input[type="password"] {
            width: 100%;
            padding: 14px 16px;
            border: 2px solid #e2e8f0;
            border-radius: 16px;
            font-size: 1rem;
            transition: all 0.3s;
        }
        
        .form-group input[type="password"]:focus {
            outline: none;
            border-color: #009779;
            box-shadow: 0 0 0 3px rgba(0, 151, 121, 0.1);
        }
        
        .btn-login {
            width: 100%;
            background: linear-gradient(120deg, #009779 0%, #00b894 100%);
            color: white;
            border: none;
            padding: 14px 24px;
            border-radius: 40px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
            margin-top: 10px;
        }
        
        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(0, 151, 121, 0.3);
        }
        
        .register-link {
            text-align: center;
            margin-top: 25px;
            padding-top: 20px;
            border-top: 1px solid #e2e8f0;
        }
        
        .register-link p {
            color: #718096;
            font-size: 0.9rem;
        }
        
        .register-link a {
            color: #009779;
            text-decoration: none;
            font-weight: 600;
        }
        
        .register-link a:hover {
            text-decoration: underline;
        }
        
        .back-link {
            display: inline-block;
            margin-top: 15px;
            color: #009779;
            text-decoration: none;
            font-size: 0.9rem;
        }
        
        .back-link:hover {
            text-decoration: underline;
        }
        
        .message {
            padding: 12px 16px;
            border-radius: 12px;
            margin-bottom: 20px;
            font-size: 0.9rem;
        }
        
        .message.error {
            background: #fed7d7;
            color: #742a2a;
            border-left: 4px solid #e53e3e;
        }
        
        @media (max-width: 480px) {
            .login-body {
                padding: 30px 20px;
            }
            
            .login-header {
                padding: 30px 20px;
            }
        }
    </style>
</head>
<body>
    <div class="login-card">
        <div class="login-header">
            <div class="login-logo">
                <i class="fas fa-paw"></i>
            </div>
            <h1>Лапка помощи</h1>
            <p>Ветеринарная клиника</p>
        </div>
        
        <div class="login-body">
            <?php if ($error): ?>
                <div class="message error">
                    <i class="fas fa-exclamation-triangle"></i> <?= htmlspecialchars($error) ?>
                </div>
            <?php endif; ?>
            
            <form method="POST" action="">
                <div class="form-group">
                    <label><i class="fas fa-phone"></i> Номер телефона</label>
                    <div class="phone-input">
                        <span class="phone-prefix">+7</span>
                        <input type="tel" name="phone" id="phone" 
                               placeholder="(___) ___-__-__" required autofocus>
                    </div>
                </div>
                
                <div class="form-group">
                    <label><i class="fas fa-lock"></i> Пароль</label>
                    <input type="password" name="password" id="password" 
                           placeholder="Введите пароль" required>
                </div>
                
                <button type="submit" class="btn-login">
                    <i class="fas fa-arrow-right"></i> Войти
                </button>
            </form>
            
            <div class="register-link">
                <p>Нет аккаунта? <a href="reg.php">Зарегистрироваться</a></p>
            </div>
            
            <a href="main.html" class="back-link">
                <i class="fas fa-arrow-left"></i> Вернуться на главную
            </a>
        </div>
    </div>
    
    <script>
        function phoneMask(input) {
            // Удаляем все нецифровые символы
            let value = input.value.replace(/\D/g, '');
            
            // Ограничиваем длину 10 цифрами (без +7)
            if (value.length > 10) value = value.slice(0, 10);
            
            let formatted = '';
            if (value.length > 0) {
                formatted = '(' + value.slice(0, 3);
            }
            if (value.length >= 4) {
                formatted += ') ' + value.slice(3, 6);
            }
            if (value.length >= 7) {
                formatted += '-' + value.slice(6, 8);
            }
            if (value.length >= 9) {
                formatted += '-' + value.slice(8, 10);
            }
            
            input.value = formatted;
        }
        
        const phoneInput = document.getElementById('phone');
        if (phoneInput) {
            phoneInput.addEventListener('input', function() {
                phoneMask(this);
            });
        }
    </script>
</body>
</html>