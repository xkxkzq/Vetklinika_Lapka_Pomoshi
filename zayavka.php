<?php
session_start();

// Проверка авторизации
if (!isset($_SESSION['user_id'])) {
    header('Location: auth.php');
    exit;
}

$link = mysqli_connect('localhost', 'root', '', 'vetklinika') or die(mysqli_error($link));

// Получаем ID услуги из URL
$service_id = isset($_GET['service']) ? (int)$_GET['service'] : 0;

// Получаем информацию об услуге
$service_info = null;
if ($service_id > 0) {
    $query = "SELECT * FROM services WHERE id_service = $service_id";
    $result = mysqli_query($link, $query);
    $service_info = mysqli_fetch_assoc($result);
}

// Получаем список всех услуг для выпадающего списка
$services_result = mysqli_query($link, "SELECT * FROM services ORDER BY service");

// Обработка отправки формы
$message = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Получаем данные из формы
    $selected_service_id = (int)$_POST['service_id'];
    $appointment_date = mysqli_real_escape_string($link, $_POST['appointment_date']);
    $appointment_time = mysqli_real_escape_string($link, $_POST['appointment_time']);
    $pet_name = mysqli_real_escape_string($link, $_POST['pet_name']);
    $pet_type = mysqli_real_escape_string($link, $_POST['pet_type']);
    $phone = mysqli_real_escape_string($link, $_POST['phone']);
    $comment = mysqli_real_escape_string($link, $_POST['comment']);
    
    // Очищаем телефон от форматирования и приводим к формату 10 цифр
    $clean_phone = preg_replace('/[^0-9]/', '', $phone);
    
    // Обработка различных форматов номера
    if (strlen($clean_phone) == 11) {
        if ($clean_phone[0] == '8' || $clean_phone[0] == '7') {
            $clean_phone = substr($clean_phone, 1);
        } else {
            $error = 'Неверный формат номера телефона';
        }
    } elseif (strlen($clean_phone) != 10) {
        $error = 'Неверный формат номера телефона';
    }
    
    // Проверка на существующую запись на это время
    if (empty($error)) {
        $check_query = "SELECT * FROM appointments 
                        WHERE appointment_date = '$appointment_date' 
                        AND appointment_time = '$appointment_time' 
                        AND status != 'cancelled'";
        $check_result = mysqli_query($link, $check_query);
        
        if (mysqli_num_rows($check_result) > 0) {
            $error = 'Извините, это время уже занято. Пожалуйста, выберите другое время.';
        } else {
            // Вставляем запись в базу данных
            $user_id = $_SESSION['user_id'];
            
            $insert_query = "INSERT INTO appointments (user_id, service_id, appointment_date, appointment_time, pet_name, pet_type, phone, comment, status) 
                             VALUES ($user_id, $selected_service_id, '$appointment_date', '$appointment_time', '$pet_name', '$pet_type', '$clean_phone', '$comment', 'pending')";
            
            if (mysqli_query($link, $insert_query)) {
                // Перенаправляем на страницу профиля с сообщением об успехе
                header('Location: profile.php?success=1');
                exit;
            } else {
                $error = 'Ошибка при оформлении записи: ' . mysqli_error($link);
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
    <title>Запись на прием - Лапка помощи</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Roboto', sans-serif;
            background: linear-gradient(135deg, #f8fafc 0%, #eef2f5 100%);
            min-height: 100vh;
        }
        
        .booking-container {
            max-width: 800px;
            margin: 40px auto;
            padding: 0 20px;
        }
        
        .booking-card {
            background: white;
            border-radius: 24px;
            box-shadow: 0 20px 35px -12px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }
        
        .booking-header {
            background: linear-gradient(120deg, #009779 0%, #00b894 100%);
            padding: 30px;
            text-align: center;
            position: relative;
        }
        
        .back-button {
            position: absolute;
            left: 30px;
            top: 50%;
            transform: translateY(-50%);
            background: rgba(255,255,255,0.2);
            color: white;
            text-decoration: none;
            padding: 8px 16px;
            border-radius: 40px;
            font-size: 14px;
            transition: all 0.3s;
        }
        
        .back-button:hover {
            background: white;
            color: #009779;
        }
        
        .booking-header h1 {
            color: white;
            font-size: 1.8rem;
            margin-bottom: 10px;
        }
        
        .booking-header p {
            color: rgba(255,255,255,0.9);
        }
        
        .booking-body {
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
        }
        
        .form-group input,
        .form-group select,
        .form-group textarea {
            width: 100%;
            padding: 12px 16px;
            border: 2px solid #e2e8f0;
            border-radius: 12px;
            font-size: 1rem;
            transition: all 0.3s;
        }
        
        .form-group input:focus,
        .form-group select:focus,
        .form-group textarea:focus {
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
        }
        
        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }
        
        .btn-submit {
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
        }
        
        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(0, 151, 121, 0.3);
        }
        
        .message {
            padding: 12px 20px;
            border-radius: 12px;
            margin-bottom: 20px;
        }
        
        .message.success {
            background: #c6f6d5;
            color: #22543d;
            border-left: 4px solid #38a169;
        }
        
        .message.error {
            background: #fed7d7;
            color: #742a2a;
            border-left: 4px solid #e53e3e;
        }
        
        .service-info {
            background: #f7fafc;
            border-radius: 16px;
            padding: 20px;
            margin-bottom: 25px;
        }
        
        .service-info h3 {
            color: #009779;
            margin-bottom: 10px;
        }
        
        .price-tag {
            font-size: 1.5rem;
            font-weight: bold;
            color: #009779;
        }
        
        @media (max-width: 640px) {
            .form-row {
                grid-template-columns: 1fr;
                gap: 0;
            }
            
            .booking-body {
                padding: 20px;
            }
            
            .back-button {
                position: static;
                display: inline-block;
                margin-bottom: 15px;
                transform: none;
            }
            
            .booking-header {
                padding: 20px;
            }
            
            .booking-header h1 {
                margin-top: 10px;
            }
        }
    </style>
</head>
<body>
    <div class="booking-container">
        <div class="booking-card">
            <div class="booking-header">
                <a href="services.php" class="back-button">
                    <i class="fas fa-arrow-left"></i> Назад
                </a>
                <h1><i class="fas fa-calendar-plus"></i> Запись на прием</h1>
                <p>Оставьте заявку, и мы свяжемся с вами для подтверждения</p>
            </div>
            
            <div class="booking-body">
                <?php if ($message): ?>
                    <div class="message success">
                        <i class="fas fa-check-circle"></i> <?= htmlspecialchars($message) ?>
                    </div>
                <?php endif; ?>
                
                <?php if ($error): ?>
                    <div class="message error">
                        <i class="fas fa-exclamation-triangle"></i> <?= htmlspecialchars($error) ?>
                    </div>
                <?php endif; ?>
                
                <?php if ($service_info): ?>
                    <div class="service-info">
                        <h3><i class="fas fa-stethoscope"></i> Выбранная услуга</h3>
                        <p><strong><?= htmlspecialchars($service_info['service']) ?></strong></p>
                        <p><?= htmlspecialchars($service_info['description']) ?></p>
                        <p class="price-tag"><?= number_format($service_info['price'], 0, '.', ' ') ?> ₽</p>
                    </div>
                <?php endif; ?>
                
                <form method="POST" action="">
                    <div class="form-group">
                        <label for="service_id">Услуга <span style="color: red;">*</span></label>
                        <select name="service_id" id="service_id" required>
                            <option value="">Выберите услугу</option>
                            <?php 
                            // Сбрасываем указатель результата запроса, чтобы пройтись по нему снова
                            mysqli_data_seek($services_result, 0);
                            while ($service = mysqli_fetch_assoc($services_result)): ?>
                                <option value="<?= $service['id_service'] ?>" 
                                    <?= (isset($selected_service_id) && $selected_service_id == $service['id_service']) || 
                                        (isset($service_id) && $service_id == $service['id_service']) ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($service['service']) ?> - <?= number_format($service['price'], 0, '.', ' ') ?> ₽
                                </option>
                            <?php endwhile; ?>
                        </select>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label for="appointment_date">Дата приема <span style="color: red;">*</span></label>
                            <input type="date" name="appointment_date" id="appointment_date" 
                                   min="<?= date('Y-m-d') ?>" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="appointment_time">Время приема <span style="color: red;">*</span></label>
                            <select name="appointment_time" id="appointment_time" required>
                                <option value="">Выберите время</option>
                                <option value="09:00">09:00</option>
                                <option value="10:00">10:00</option>
                                <option value="11:00">11:00</option>
                                <option value="12:00">12:00</option>
                                <option value="13:00">13:00</option>
                                <option value="14:00">14:00</option>
                                <option value="15:00">15:00</option>
                                <option value="16:00">16:00</option>
                                <option value="17:00">17:00</option>
                                <option value="18:00">18:00</option>
                                <option value="19:00">19:00</option>
                                <option value="20:00">20:00</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label for="pet_name">Имя питомца <span style="color: red;">*</span></label>
                            <input type="text" name="pet_name" id="pet_name" required 
                                   value="<?= isset($_POST['pet_name']) ? htmlspecialchars($_POST['pet_name']) : '' ?>">
                        </div>
                        
                        <div class="form-group">
                            <label for="pet_type">Вид животного</label>
                            <select name="pet_type" id="pet_type">
                                <option value="">Выберите вид</option>
                                <option value="собака">Собака</option>
                                <option value="кот">Кот</option>
                                <option value="птица">Птица</option>
                                <option value="грызун">Грызун</option>
                                <option value="рептилия">Рептилия</option>
                                <option value="другое">Другое</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="phone">Телефон для связи <span style="color: red;">*</span></label>
                        <div class="phone-input">
                            <span class="phone-prefix">+7</span>
                            <input type="tel" name="phone" id="phone" required 
                                   placeholder="(___) ___-__-__"
                                   value="<?= isset($_POST['phone']) ? htmlspecialchars($_POST['phone']) : '' ?>">
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="comment">Комментарий</label>
                        <textarea name="comment" id="comment" rows="3" 
                                  placeholder="Дополнительная информация (аллергии, особенности и т.д.)"><?= isset($_POST['comment']) ? htmlspecialchars($_POST['comment']) : '' ?></textarea>
                    </div>
                    
                    <button type="submit" class="btn-submit">
                        <i class="fas fa-paw"></i> Записаться на прием
                    </button>
                </form>
            </div>
        </div>
    </div>
    
    <script>
        // Установка минимальной даты
        document.getElementById('appointment_date').min = new Date().toISOString().split('T')[0];
        
        // Маска для телефона
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