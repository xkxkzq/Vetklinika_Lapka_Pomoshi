<?php
session_start();

// Проверяем авторизацию
if (!isset($_SESSION['user_id'])) {
    header("Location: auth.php");
    exit();
}

// Подключаемся к БД
$link = mysqli_connect('localhost', 'root', '', 'vetklinika') or die(mysqli_error($link));

// Получаем информацию о пользователе
$user_id = $_SESSION['user_id'];
$query = "SELECT * FROM users WHERE id_user = '$user_id'";
$result = mysqli_query($link, $query);
$user = mysqli_fetch_assoc($result);

// Получаем записи пользователя
$appointments_query = "SELECT a.*, s.service, s.price 
                       FROM appointments a 
                       LEFT JOIN services s ON a.service_id = s.id_service 
                       WHERE a.user_id = '$user_id' 
                       ORDER BY a.appointment_date DESC, a.appointment_time DESC";
$appointments_result = mysqli_query($link, $appointments_query);

// Проверка успешной записи или отмены
$success_message = '';
if (isset($_GET['success']) && $_GET['success'] == 1) {
    $success_message = 'Запись успешно оформлена! Мы свяжемся с вами для подтверждения.';
}
if (isset($_GET['cancelled']) && $_GET['cancelled'] == 1) {
    $success_message = 'Запись успешно отменена.';
}
if (isset($_GET['error']) && $_GET['error'] == 1) {
    $error_message = 'Не удалось отменить запись. Попробуйте позже.';
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Лапка помощи - Профиль</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/profile.css">
</head>
<body>
    <header class="header">
        <div class="container">
            <div class="header__inner">
                <a href="main.html" class="logo">
                    <img class="logo__icon" src="image/logo.png" alt="Лапка помощи">
                    <span class="logo__text">Лапка помощи</span>
                </a>

                <button class="burger" id="burger" aria-label="Меню">
                    <span></span>
                    <span></span>
                    <span></span>
                </button>

                <nav class="nav" id="nav">
                    <ul class="nav__list">
                        <li class="nav__item"><a href="about.php" class="nav__link">О нас</a></li>
                        <li class="nav__item"><a href="services.php" class="nav__link">Услуги</a></li>
                        <li class="nav__item"><a href="specialists.php" class="nav__link">Специалисты</a></li>
                        <li class="nav__item"><a href="profile.php" class="nav__link">Профиль</a></li>
                    </ul>
                </nav>
            </div>
        </div>
    </header>

    <main>
        <div class="profile-container">
            <div class="profile-header">
                <div class="profile-avatar">
                    <i class="fas fa-user-circle"></i>
                </div>
                <div class="profile-info">
                    <h2><?= htmlspecialchars($user['name'] . ' ' . ($user['surname'] ?? '')) ?></h2>
                    <p><i class="fas fa-phone"></i> +7 <?= preg_replace('/(\d{3})(\d{3})(\d{2})(\d{2})/', '($1) $2-$3-$4', htmlspecialchars($user['phone'])) ?></p>
                    <?php if (!empty($user['birthday'])): ?>
                        <p><i class="fas fa-calendar-alt"></i> Дата рождения: <?= htmlspecialchars($user['birthday']) ?></p>
                    <?php endif; ?>
                </div>
                <a href="logout.php" class="logout-btn">
                    <i class="fas fa-sign-out-alt"></i> Выйти
                </a>
            </div>
            
            <div class="profile-card">
                <h3><i class="fas fa-paw"></i> Мои записи</h3>
                
                <?php if ($success_message): ?>
                    <div class="success-message">
                        <i class="fas fa-check-circle"></i> <?= $success_message ?>
                    </div>
                <?php endif; ?>
                <?php if (isset($error_message)): ?>
                    <div class="error-message">
                        <i class="fas fa-exclamation-circle"></i> <?= $error_message ?>
                    </div>
                <?php endif; ?>
                
                <?php if (mysqli_num_rows($appointments_result) > 0): ?>
                    <table class="appointments-table">
                        <thead>
                            <tr>
                                <th>Дата</th>
                                <th>Время</th>
                                <th>Услуга</th>
                                <th>Питомец</th>
                                <th>Тип питомца</th>
                                <th>Стоимость</th>
                                <th>Статус</th>
                                <th>Действия</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($appointment = mysqli_fetch_assoc($appointments_result)): ?>
                                <tr>
                                    <td data-label="Дата"><?= date('d.m.Y', strtotime($appointment['appointment_date'])) ?></td>
                                    <td data-label="Время"><?= htmlspecialchars($appointment['appointment_time']) ?></td>
                                    <td data-label="Услуга"><?= htmlspecialchars($appointment['service']) ?></td>
                                    <td data-label="Питомец"><?= htmlspecialchars($appointment['pet_name']) ?></td>
                                    <td data-label="Тип питомца"><?= htmlspecialchars($appointment['pet_type'] ?: 'Не указан') ?></td>
                                    <td data-label="Стоимость"><?= number_format($appointment['price'], 0, '.', ' ') ?> ₽</td>
                                    <td data-label="Статус">
                                        <span class="status-<?= $appointment['status'] ?>">
                                            <?php
                                            $statuses = [
                                                'pending' => 'В ожидании',
                                                'confirmed' => 'Подтверждено',
                                                'cancelled' => 'Отменено',
                                                'completed' => 'Выполнено'
                                            ];
                                            echo $statuses[$appointment['status']] ?? $appointment['status'];
                                            ?>
                                        </span>
                                    </td>
                                    <td data-label="Действия">
                                        <?php if ($appointment['status'] === 'pending'): ?>
                                            <a href="cancel_appointment.php?id=<?= $appointment['id_appointment'] ?>" 
                                               class="cancel-btn"
                                               onclick="return confirm('Вы уверены, что хотите отменить запись?')">
                                                <i class="fas fa-times"></i> Отменить
                                            </a>
                                        <?php else: ?>
                                            <span class="no-action">—</span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                <?php else: ?>
                    <div class="empty-state">
                        <i class="fas fa-calendar-alt"></i>
                        <p>У вас пока нет записей к врачу</p>
                        <a href="zayavka.php" class="btn-primary">Записаться на прием</a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </main>
    
   <!-- 8. Футер -->
    <footer class="footer">
        <div class="container">
            <div class="footer__content">
                <div class="footer__info">
                    <h3 class="footer__title">Контакты</h3>
                    <p class="footer__contact">Телефон: 8 (123) 456 78 90</p>
                    <p class="footer__contact">E-mail: lapka_pomoshi@mail.ru</p>
                    <p class="footer__contact">Адрес: г.Ярославль, ул.Жукова, д.33</p>
                    
                    <div class="schedule">
                        <h3 class="footer__title">График работы</h3>
                        <div class="schedule__item">
                            <span class="schedule__day">Пн-Пт:</span>
                            <span class="schedule__time">09:00 - 21:00</span>
                        </div>
                        <div class="schedule__item">
                            <span class="schedule__day">Сб-Вс:</span>
                            <span class="schedule__time">10:00 - 18:00</span>
                        </div>
                    </div>
                </div>
                
                <div class="footer__links">
                    <div class="footer__column">
                        <h3 class="footer__title">Клиентам</h3>
                        <ul class="footer__list">
                            <li><a href="zayavka.php" class="footer__link">Оставить заявку</a></li>
                            <li><a href="services.php" class="footer__link">Цены</a></li>
                        </ul>
                    </div>
                    
                    <div class="footer__column">
                        <h3 class="footer__title">О нас</h3>
                        <ul class="footer__list">
                            <li><a href="about.php" class="footer__link">Компания</a></li>
                            <li><a href="about.php" class="footer__link">Вакансии</a></li>
                            <li><a href="about.php" class="footer__link">Лицензии</a></li>
                        </ul>
                    </div>
                    
                    <div class="footer__column">
                        <h3 class="footer__title">Навигация</h3>
                        <ul class="footer__list">
                            <li><a href="main.html" class="footer__link">Главная</a></li>
                            <li><a href="about.php" class="footer__link">О нас</a></li>
                            <li><a href="services.php" class="footer__link">Услуги</a></li>
                            <li><a href="specialists.php" class="footer__link">Специалисты</a></li>
                            <li><a href="profile.php" class="footer__link">Личный кабинет</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="footer__bottom">
                <p class="footer__copyright">© 2026 Ветеринарная клиника "Лапка помощи"</p>
            </div>
        </div>
    </footer>

    <script src="js/main.js"></script>
</body>
</html>

<?php
mysqli_close($link);
?>