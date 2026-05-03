document.addEventListener('DOMContentLoaded', function() {
    const burger = document.getElementById('burger');
    const nav = document.getElementById('nav');
    const navLinks = document.querySelectorAll('.nav__link');

    if (burger) {
        burger.addEventListener('click', function() {
            burger.classList.toggle('active');
            nav.classList.toggle('active');
            if (nav.classList.contains('active')) {
                document.body.style.overflow = 'hidden';
            } else {
                document.body.style.overflow = '';
            }
        });
    }

    navLinks.forEach(link => {
        link.addEventListener('click', function() {
            if (burger) burger.classList.remove('active');
            if (nav) nav.classList.remove('active');
            document.body.style.overflow = '';
        });
    });

    document.addEventListener('click', function(event) {
        if (nav && burger && !nav.contains(event.target) && !burger.contains(event.target) && nav.classList.contains('active')) {
            if (burger) burger.classList.remove('active');
            nav.classList.remove('active');
            document.body.style.overflow = '';
        }
    });
});