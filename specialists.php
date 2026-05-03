<?php
// specialists.php
// Подключение к базе данных
$link = mysqli_connect('localhost', 'root', '', 'vetklinika') or die(mysqli_error($link));
mysqli_set_charset($link, "utf8mb4");

// Получаем всех активных специалистов, отсортированных по порядку
$result = mysqli_query($link, "SELECT * FROM specialists WHERE is_active = 1 ORDER BY sort_order ASC");
$specialists_list = [];
while ($row = mysqli_fetch_assoc($result)) {
    $specialists_list[] = $row;
}
$total_specialists = count($specialists_list);
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Лапка помощи - Врачи ветеринарной клиники, опытные специалисты</title>
    <meta name="description" content="Врачи ветеринарной клиники «Лапка помощи» – высококвалифицированные специалисты с многолетним опытом. Терапевты, хирурги, узкие специалисты. Запишитесь на прием к лучшим ветеринарам Ярославля.">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="css/specialists.css">
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
        <section class="specialists-page-section">
            <div class="container container-specialists">
                <h2 class="section-title">Наши специалисты</h2>
                <p class="specialists-subtitle">
                    Высококвалифицированные врачи с многолетним опытом работы. Каждый специалист — профессионал своего дела, любящий животных и заботящийся об их здоровье.
                </p>
                
                <?php if ($total_specialists > 0): ?>
                    <div class="specialists-grid">
                        <?php foreach ($specialists_list as $specialist): 
                            // Проверяем наличие фото
                            $photo_path = 'image/' . htmlspecialchars($specialist['photo']);
                            if (!file_exists($photo_path) || empty($specialist['photo']) || $specialist['photo'] == 'default.jpg') {
                                $photo_path = null;
                            }
                        ?>
                        <div class="specialist-card">
                            <div class="specialist-card__photo">
                                <?php if ($photo_path && file_exists($photo_path)): ?>
                                    <img src="<?= $photo_path ?>" alt="<?= htmlspecialchars($specialist['full_name']) ?>">
                                <?php else: ?>
                                    <div class="photo-placeholder">
                                        <i class="fas fa-user-md"></i>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <div class="specialist-card__info">
                                <h3 class="specialist-card__name"><?= htmlspecialchars($specialist['full_name']) ?></h3>
                                <span class="specialist-card__specialty">
                                    <?= htmlspecialchars($specialist['specialty']) ?>
                                </span>
                                <p class="specialist-card__description"><?= htmlspecialchars($specialist['description']) ?></p>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <div class="no-specialists">
                        <i class="fas fa-user-md"></i>
                        <h3>Специалисты временно не загружены</h3>
                        <p>Пожалуйста, обратитесь к администратору клиники.</p>
                    </div>
                <?php endif; ?>
            </div>
        </section>
    </main>
    
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