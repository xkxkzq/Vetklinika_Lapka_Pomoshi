<?php
session_start();

// Подключение к базе данных
$link = mysqli_connect('localhost', 'root', '', 'vetklinika') or die(mysqli_error($link));

$error = '';
$success = false;

// Проверяем, отправлена ли форма
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $surname = mysqli_real_escape_string($link, $_POST['surname']);
    $name = mysqli_real_escape_string($link, $_POST['name']);
    $phone = mysqli_real_escape_string($link, $_POST['phone']);
    $password = mysqli_real_escape_string($link, $_POST['password']);
    $confirm_password = mysqli_real_escape_string($link, $_POST['confirm_password']);
    $birthday = mysqli_real_escape_string($link, $_POST['birthday']);
    
    // Очищаем телефон от форматирования и приводим к формату 10 цифр
    $clean_phone = preg_replace('/[^0-9]/', '', $phone);
    
    // Обработка различных форматов номера
    if (strlen($clean_phone) == 11) {
        // Если номер начинается с 8 или 7, убираем первую цифру
        if ($clean_phone[0] == '8' || $clean_phone[0] == '7') {
            $clean_phone = substr($clean_phone, 1);
        } else {
            $error = 'Неверный формат номера телефона. Номер должен начинаться с 8 или +7';
        }
    } elseif (strlen($clean_phone) == 10) {
        // Номер уже в правильном формате (10 цифр)
        $clean_phone = $clean_phone;
    } else {
        $error = 'Неверный формат номера телефона. Введите 10 цифр после +7 или 8';
    }
    
    // Валидация
    if (empty($error)) {
        if (empty($name) || empty($clean_phone) || empty($password)) {
            $error = 'Пожалуйста, заполните все обязательные поля';
        } elseif ($password !== $confirm_password) {
            $error = 'Пароли не совпадают';
        } elseif (strlen($password) < 6) {
            $error = 'Пароль должен содержать не менее 6 символов';
        } else {
            // Проверка, существует ли уже пользователь с таким телефоном
            $check_query = "SELECT id_user FROM users WHERE phone = '$clean_phone'";
            $check_result = mysqli_query($link, $check_query);
            
            if (mysqli_num_rows($check_result) > 0) {
                $error = 'Пользователь с таким номером телефона уже зарегистрирован';
            } else {
                // Вставка нового пользователя
                $insert_query = "INSERT INTO users (surname, name, phone, password, birthday) 
                                 VALUES ('$surname', '$name', '$clean_phone', '$password', '$birthday')";
                
                if (mysqli_query($link, $insert_query)) {
                    $success = true;
                    // Очищаем форму
                    $_POST = array();
                } else {
                    $error = 'Ошибка при регистрации: ' . mysqli_error($link);
                }
            }
        }
    }
}

mysqli_close($link);
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Регистрация - Лапка помощи</title>
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
        
        .register-card {
            max-width: 550px;
            width: 100%;
            background: white;
            border-radius: 32px;
            box-shadow: 0 20px 40px rgba(0, 151, 121, 0.15);
            overflow: hidden;
        }
        
        .register-header {
            background: linear-gradient(120deg, #009779 0%, #00b894 100%);
            padding: 30px;
            text-align: center;
            position: relative;
        }
        
        .register-header h1 {
            color: white;
            font-size: 1.8rem;
            margin-bottom: 8px;
        }
        
        .register-header p {
            color: rgba(255,255,255,0.9);
            font-size: 0.9rem;
        }
        
        .register-body {
            padding: 30px;
        }
        
        .form-group {
            margin-bottom: 20px;
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
        
        .form-group input,
        .form-group select {
            width: 100%;
            padding: 12px 16px;
            border: 2px solid #e2e8f0;
            border-radius: 12px;
            font-size: 1rem;
            transition: all 0.3s;
        }
        
        .form-group input:focus,
        .form-group select:focus {
            outline: none;
            border-color: #009779;
            box-shadow: 0 0 0 3px rgba(0, 151, 121, 0.1);
        }
        
        .phone-input {
            display: flex;
            align-items: center;
            border: 2px solid #e2e8f0;
            border-radius: 12px;
            overflow: hidden;
            transition: all 0.3s;
        }
        
        .phone-input:focus-within {
            border-color: #009779;
            box-shadow: 0 0 0 3px rgba(0, 151, 121, 0.1);
        }
        
        .phone-prefix {
            background: #f7fafc;
            padding: 12px 16px;
            color: #4a5568;
            font-weight: 500;
            border-right: 2px solid #e2e8f0;
        }
        
        .phone-input input {
            border: none;
            flex: 1;
            padding: 12px 16px;
            font-size: 1rem;
            outline: none;
            background: transparent;
            border-radius: 0;
        }
        
        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }
        
        .btn-register {
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
        
        .btn-register:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(0, 151, 121, 0.3);
        }
        
        .login-link {
            text-align: center;
            margin-top: 25px;
            padding-top: 20px;
            border-top: 1px solid #e2e8f0;
        }
        
        .login-link p {
            color: #718096;
            font-size: 0.9rem;
        }
        
        .login-link a {
            color: #009779;
            text-decoration: none;
            font-weight: 600;
        }
        
        .login-link a:hover {
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
        
        .required-field {
            color: #e53e3e;
        }
        
        /* Затемнение фона */
        .overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: 1000;
            align-items: center;
            justify-content: center;
        }
        
        .overlay.active {
            display: flex;
        }
        
        /* Окно уведомления */
        .notification {
            background: white;
            border-radius: 24px;
            padding: 40px 30px;
            text-align: center;
            max-width: 450px;
            width: 90%;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.2);
            animation: fadeIn 0.3s ease;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .notification__icon {
            font-size: 60px;
            color: #38a169;
            margin-bottom: 20px;
        }
        
        .notification__title {
            font-size: 1.5rem;
            font-weight: 700;
            color: #2d3748;
            margin-bottom: 10px;
        }
        
        .notification__text {
            font-size: 1rem;
            color: #4a5568;
            margin-bottom: 25px;
            line-height: 1.5;
        }
        
        .notification__btn {
            display: inline-block;
            background: linear-gradient(120deg, #009779 0%, #00b894 100%);
            color: white;
            padding: 12px 30px;
            border-radius: 40px;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s;
        }
        
        .notification__btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(0, 151, 121, 0.3);
        }
        
        @media (max-width: 640px) {
            .form-row {
                grid-template-columns: 1fr;
                gap: 0;
            }
            
            .register-body {
                padding: 20px;
            }
        }
    </style>
</head>
<body>
    <!-- Затемнение с уведомлением -->
    <?php if ($success): ?>
    <div class="overlay active" id="successOverlay">
        <div class="notification">
            <div class="notification__icon">
                <i class="fas fa-check-circle"></i>
            </div>
            <h2 class="notification__title">Регистрация завершена!</h2>
            <p class="notification__text">Ваш аккаунт успешно создан. Сейчас вы будете перенаправлены на страницу входа.</p>
            <a href="auth.php" class="notification__btn">ОК</a>
        </div>
    </div>
    <script>
        // Автоматическое перенаправление через 3 секунды
        setTimeout(function() {
            window.location.href = 'auth.php';
        }, 3000);
    </script>
    <?php endif; ?>
    
    <div class="register-card">
        <div class="register-header">
            <h1><i class="fas fa-paw"></i> Регистрация</h1>
            <p>Создайте аккаунт в клинике "Лапка помощи"</p>
        </div>
        
        <div class="register-body">
            <?php if ($error): ?>
                <div class="message error">
                    <i class="fas fa-exclamation-triangle"></i> <?= htmlspecialchars($error) ?>
                </div>
            <?php endif; ?>
            
            <form method="POST" action="">
                <div class="form-row">
                    <div class="form-group">
                        <label><i class="fas fa-user"></i> Фамилия</label>
                        <input type="text" name="surname" 
                               value="<?= isset($_POST['surname']) ? htmlspecialchars($_POST['surname']) : '' ?>">
                    </div>
                    
                    <div class="form-group">
                        <label><i class="fas fa-user"></i> Имя <span class="required-field">*</span></label>
                        <input type="text" name="name" required 
                               value="<?= isset($_POST['name']) ? htmlspecialchars($_POST['name']) : '' ?>">
                    </div>
                </div>
                
                <div class="form-group">
                    <label><i class="fas fa-phone"></i> Номер телефона <span class="required-field">*</span></label>
                    <div class="phone-input">
                        <span class="phone-prefix">+7</span>
                        <input type="tel" name="phone" id="phone" required 
                               placeholder="(___) ___-__-__"
                               value="<?= isset($_POST['phone']) ? htmlspecialchars($_POST['phone']) : '' ?>">
                    </div>
                </div>
                
                <div class="form-group">
                    <label><i class="fas fa-calendar-alt"></i> Дата рождения</label>
                    <input type="date" name="birthday" 
                           value="<?= isset($_POST['birthday']) ? htmlspecialchars($_POST['birthday']) : '' ?>">
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label><i class="fas fa-lock"></i> Пароль <span class="required-field">*</span></label>
                        <input type="password" name="password" required minlength="6">
                    </div>
                    
                    <div class="form-group">
                        <label><i class="fas fa-lock"></i> Подтвердите пароль <span class="required-field">*</span></label>
                        <input type="password" name="confirm_password" required minlength="6">
                    </div>
                </div>
                
                <button type="submit" class="btn-register">
                    <i class="fas fa-user-plus"></i> Зарегистрироваться
                </button>
            </form>
            
            <div class="login-link">
                <p>Уже есть аккаунт? <a href="auth.php">Войти</a></p>
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