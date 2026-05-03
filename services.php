<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Лапка помощи - Услуги ветеринарной клиники</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/services.css">
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
        <section class="services-page-section">
            <div class="container container-services">
                <h2 class="section-title">Наши ветеринарные услуги</h2>
                <p class="services-subtitle">
                    Забота о здоровье вашего питомца — наша главная задача. Профессиональная диагностика, лечение и профилактика под одной крышей.
                </p>
                
                <?php
                // Подключение к базе данных
                $link = mysqli_connect('localhost', 'root', '', 'vetklinika') or die(mysqli_error($link));
                $result = mysqli_query($link, "SELECT * FROM services ORDER BY id_service ASC");
                
                // Собираем данные в массив
                $services_list = [];
                while ($row = mysqli_fetch_assoc($result)) {
                    $services_list[] = $row;
                }
                $total_services = count($services_list);
                ?>
                
                <!-- Карточки услуг -->
                <div class="services-cards-grid">
                    <?php if ($total_services > 0): ?>
                        <?php foreach ($services_list as $service): 
                            $icon_map = [
                                'вакцинация' => 'fa-syringe',
                                'прием' => 'fa-stethoscope',
                                'осмотр' => 'fa-eye',
                                'хирургия' => 'fa-scalpel',
                                'узи' => 'fa-microscope',
                                'анализ' => 'fa-flask',
                                'чипирование' => 'fa-microchip',
                                'груминг' => 'fa-cut',
                                'стоматология' => 'fa-tooth',
                                'дерматология' => 'fa-paw',
                            ];
                            $service_name_lower = mb_strtolower($service['service']);
                            $icon_class = 'fa-paw';
                            foreach ($icon_map as $key => $icon) {
                                if (strpos($service_name_lower, $key) !== false) {
                                    $icon_class = $icon;
                                    break;
                                }
                            }
                        ?>
                        <div class="service-card" data-service-id="<?= $service['id_service'] ?>">
                            <div class="service-card__header">
                                <div class="service-card__icon">
                                    <i class="fas <?= $icon_class ?>"></i>
                                </div>
                                <h3 class="service-card__title"><?= htmlspecialchars($service['service']) ?></h3>
                            </div>
                            <div class="service-card__body">
                                <div class="service-card__description">
                                    <?= htmlspecialchars($service['description']) ?>
                                </div>
                                <div class="service-card__price">
                                    <span class="price-label">Стоимость</span>
                                    <span class="price-value"><?= number_format($service['price'], 0, '.', ' ') ?> <small>₽</small></span>
                                </div>
                                <div class="service-card__action">
                                  <a href="zayavka.php?service=<?= $service['id_service'] ?>" class="btn-service">
                                        Записаться <i class="fas fa-arrow-right"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="no-services-message">
                            <i class="fas fa-paw"></i>
                            <h3>Услуги временно не загружены</h3>
                            <p>Пожалуйста, обратитесь к администратору клиники.</p>
                        </div>
                    <?php endif; ?>
                </div>
                
                <?php mysqli_close($link); ?>
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