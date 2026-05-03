<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>О нас - Ветеринарная клиника "Лапка помощи"</title>
    <meta name="description" content="Ветеринарная клиника Лапка помощи в Ярославле. Современное оборудование, опытные врачи, забота о ваших питомцах. Узнайте больше о нашей миссии и истории.">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/about.css">
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
        <section class="about-page-section">
            <div class="container container-about">
                <h2 class="section-title">О клинике «Лапка помощи»</h2>
                <p class="about-subtitle">
                    Мы объединили профессионализм, современные технологии и искреннюю любовь к животным, чтобы ваш питомец был здоров и счастлив.
                </p>

                <!-- История клиники -->
                <div class="about-story">
                    <h3 class="story-title">Наша история</h3>
                    <div class="story-text">
                        <p>Ветеринарная клиника «Лапка помощи» открыла свои двери в 2015 году в самом сердце Ярославля. Её основатель — Анна Сергеевна Ветрова, ветеринарный врач с 20-летним стажем, мечтала создать место, где животные получали бы не только квалифицированную медицинскую помощь, но и тепло, заботу и понимание.</p>
                        
                        <p>Начинали мы с небольшого кабинета и двух врачей-энтузиастов. Первые пациенты — соседские кошки и собаки — быстро оценили наш подход, и уже через год мы переехали в просторное помещение на улице Жукова. Сегодня «Лапка помощи» — это современная клиника площадью более 300 м², оснащённая цифровым рентгеном, УЗИ экспертного класса, собственной лабораторией и операционной.</p>
                        
                        <div class="story-highlight">
                            «Мы верим, что каждое животное заслуживает такого же внимания и качественного лечения, как и человек. Наша миссия — сделать ветеринарную помощь доступной, понятной и максимально комфортной для питомцев и их владельцев».
                        </div>
                        
                        <p>За годы работы мы помогли более чем 15 000 пациентам — от хомячков и попугаев до собак крупных пород и экзотических рептилий. Наши врачи регулярно проходят стажировки в ведущих ветеринарных центрах России и Европы, а клиника участвует в благотворительных программах по стерилизации бездомных животных.</p>
                        
                        <p>В 2025 году мы запустили направление телемедицины, чтобы владельцы могли получить консультацию, не выходя из дома. А в планах на будущее — открытие филиала в другом районе города и расширение спектра узкопрофильных услуг.</p>
                        
                        <p>«Лапка помощи» — это больше, чем клиника. Это сообщество людей, искренне любящих своё дело и своих пушистых (и не очень) пациентов.</p>
                    </div>
                </div>

                <!-- Ценности -->
                <h2 class="section-title">Наши ценности</h2>
                <div class="values-grid">
                    <div class="value-card">
                        <div class="value-card__header">
                            <div class="value-card__icon">
                                <i class="fas fa-heart"></i>
                            </div>
                            <h3 class="value-card__title">Любовь к животным</h3>
                        </div>
                        <div class="value-card__body">
                            <p class="value-card__description">Каждый сотрудник клиники искренне любит своих пациентов и относится к ним как к своим. Мы понимаем язык животных и делаем всё, чтобы им было комфортно.</p>
                        </div>
                    </div>
                    <div class="value-card">
                        <div class="value-card__header">
                            <div class="value-card__icon">
                                <i class="fas fa-microscope"></i>
                            </div>
                            <h3 class="value-card__title">Оборудование</h3>
                        </div>
                        <div class="value-card__body">
                            <p class="value-card__description">УЗИ экспертного класса, цифровой рентген, собственная лаборатория — всё для точной диагностики и эффективного лечения.</p>
                        </div>
                    </div>
                    <div class="value-card">
                        <div class="value-card__header">
                            <div class="value-card__icon">
                                <i class="fas fa-user-md"></i>
                            </div>
                            <h3 class="value-card__title">Опытные врачи</h3>
                        </div>
                        <div class="value-card__body">
                            <p class="value-card__description">Специалисты с многолетним стажем, регулярно повышающие квалификацию в России и за рубежом. Мы лечим по принципам доказательной медицины.</p>
                        </div>
                    </div>
                    <div class="value-card">
                        <div class="value-card__header">
                            <div class="value-card__icon">
                                <i class="fas fa-clock"></i>
                            </div>
                            <h3 class="value-card__title">Забота 24/7</h3>
                        </div>
                        <div class="value-card__body">
                            <p class="value-card__description">Мы на связи даже после приёма: консультируем по телефону в экстренных ситуациях и всегда готовы прийти на помощь.</p>
                        </div>
                    </div>
                </div>

                <!-- Команда (превью) -->
                <h2 class="section-title" style="margin-top: 60px;">Познакомьтесь с командой</h2>
                <div class="team-preview">
                    <?php
                    $link = mysqli_connect('localhost', 'root', '', 'vetklinika');
                    if ($link) {
                        mysqli_set_charset($link, "utf8mb4");
                        $result = mysqli_query($link, "SELECT full_name, specialty, photo FROM specialists WHERE is_active = 1 ORDER BY sort_order ASC LIMIT 4");
                        while ($row = mysqli_fetch_assoc($result)) {
                            $photo = !empty($row['photo']) ? 'image/'.$row['photo'] : '';
                            $nameParts = explode(' ', $row['full_name']);
                            $initials = (count($nameParts) >= 2) ? mb_substr($nameParts[0], 0, 1) . mb_substr($nameParts[1], 0, 1) : mb_substr($row['full_name'], 0, 2);
                            ?>
                            <div class="team-card">
                                <div class="team-card__photo">
                                    <?php if ($photo && file_exists($photo)): ?>
                                        <img src="<?= htmlspecialchars($photo) ?>" alt="<?= htmlspecialchars($row['full_name']) ?>">
                                    <?php else: ?>
                                        <div class="photo-placeholder">
                                            <span><?= htmlspecialchars($initials) ?></span>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                <div class="team-card__info">
                                    <div class="team-card__name"><?= htmlspecialchars($row['full_name']) ?></div>
                                    <div class="team-card__role"><?= htmlspecialchars($row['specialty']) ?></div>
                                </div>
                            </div>
                            <?php
                        }
                        mysqli_close($link);
                    } else {
                        // Заглушки
                        $stub = [
                            ['Иванова Анна Сергеевна', 'Главный врач, терапевт'],
                            ['Петров Владимир Игоревич', 'Хирург'],
                            ['Смирнова Елена Николаевна', 'УЗИ-диагност'],
                            ['Козлов Дмитрий Алексеевич', 'Орнитолог']
                        ];
                        foreach ($stub as $s) {
                            $initials = mb_substr($s[0], 0, 1) . mb_substr(explode(' ', $s[0])[1] ?? '', 0, 1);
                            echo '
                            <div class="team-card">
                                <div class="team-card__photo">
                                    <div class="photo-placeholder"><span>'.htmlspecialchars($initials).'</span></div>
                                </div>
                                <div class="team-card__info">
                                    <div class="team-card__name">'.htmlspecialchars($s[0]).'</div>
                                    <div class="team-card__role">'.htmlspecialchars($s[1]).'</div>
                                </div>
                            </div>';
                        }
                    }
                    ?>
                </div>
                <div style="text-align: center; margin-top: 10px;">
                    <a href="specialists.php" class="btn-all-team">Вся команда</i></a>
                </div>

                <!-- Контакты и карта -->
                <h2 class="section-title" style="margin-top: 60px;">Как нас найти</h2>
                <div class="contact-wrapper">
                    <div class="contact-info">
                        <div class="contact-item">
                            <div class="contact-icon"><i class="fas fa-map-marker-alt"></i></div>
                            <div class="contact-text">
                                <h4>Адрес</h4>
                                <p>г. Ярославль, ул. Жукова, д. 33</p>
                            </div>
                        </div>
                        <div class="contact-item">
                            <div class="contact-icon"><i class="fas fa-phone-alt"></i></div>
                            <div class="contact-text">
                                <h4>Телефон</h4>
                                <p>8 (123) 456 78 90</p>
                            </div>
                        </div>
                        <div class="contact-item">
                            <div class="contact-icon"><i class="fas fa-envelope"></i></div>
                            <div class="contact-text">
                                <h4>Email</h4>
                                <p>lapka_pomoshi@mail.ru</p>
                            </div>
                        </div>
                        <div class="contact-item">
                            <div class="contact-icon"><i class="fas fa-clock"></i></div>
                            <div class="contact-text">
                                <h4>Режим работы</h4>
                                <p>Пн-Пт: 09:00 – 21:00<br>Сб-Вс: 10:00 – 18:00</p>
                            </div>
                        </div>
                    </div>
                    <div class="map-wrapper">
                        <div id="about-map"></div>
                    </div>
                </div>
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
    <script src="https://api-maps.yandex.ru/2.1/?apikey=&lang=ru_RU" type="text/javascript"></script>
    <script>
        ymaps.ready(initAboutMap);
        function initAboutMap() {
            var clinicCoords = [57.634510, 39.828524];
            var map = new ymaps.Map("about-map", {
                center: clinicCoords,
                zoom: 17,
                controls: ['zoomControl', 'fullscreenControl']
            });
            var placemark = new ymaps.Placemark(clinicCoords, {
                hintContent: 'Ветеринарная клиника "Лапка помощи"',
                balloonContent: '<strong>Лапка помощи</strong><br/>г. Ярославль, ул. Жукова, д.33<br/>☎ 8 (123) 456 78 90'
            }, {
                preset: 'islands#greenDotIcon',
                iconColor: '#009779'
            });
            map.geoObjects.add(placemark);
        }
    </script>
</body>
</html>