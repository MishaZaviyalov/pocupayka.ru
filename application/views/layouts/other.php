<?php
function cartPrint(){
    $i = 0;
    $cart = $_SESSION['cart'] ?? null;
    if($cart != null){
        foreach ($cart as $element){
            $i += $element;
        }
        return '<a href="/assortment/card" class="header__enter-link">Корзина ('.$i.')</a>';
    }
    else return '<a href="/assortment/card" class="header__enter-link">Корзина</a>';
}

?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, initial-scale=1.0">
    <title>Покупайка</title>
    <link rel="stylesheet" href="/public/styles/ministyle.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@100;400&display=swap" rel="stylesheet">
    <script src="/public/scripts/jquery-3.2.1.min.js"></script>
    <script src="/public/scripts/form.js"></script>
    <link rel="icon" href="/public/images/logoSite.png">
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</head>
<body>
<div class="wrapper">
    <header class="header">
        <div class="header__top-line">
            <div class="container">
                <a href="/" class="logo">
                    <p class="logo__text"><span>П</span>окупайка</p>
                </a>
                <nav class="header__navigation">
                    <a href="/" class="header__navigation-link">Главная</a>
                    <a href="/assortment" class="header__navigation-link">Ассортимент</a>
                    <a href="/contact" class="header__navigation-link">Контакты</a>
                </nav>
                <div class="header__enter-links">
                    <?php if(!isset($_SESSION['authorize']['id'])){?>
                        <a href="/authorization" class="header__enter-link">Вход</a>
                        <a href="/registration" class="header__enter-link">Регистрация</a>
                    <?php } else {?>
                        <a href="/profile" class="header__enter-link">Профиль</a>
                        <?=cartPrint()?>
<!--                        <a href="/assortment/card" class="header__enter-link">Корзина</a>-->
                        <a href="/logout" class="header__enter-link">Выход</a>
                    <?php }?>
                </div>
            </div>
        </div>
</header>
    <main class="main">
        <?php echo $content; ?>
    </main>
    <footer class="footer">
        <div class="footer__content">
            <div class="container">
                <div class="footer__content-controle">
                    <p class="footer__text">Все права защищены!</p>
                    <ul class="footer_list-contacts">
                        <li class="footer__item-contact">
                            <a href="contact" class="footer__link-contact">
                                <img src="/public/images/whatsapp.svg" alt="Whatsapp" class="footer__img-contact">
                            </a>
                        </li>
                        <li class="footer__item-contact">
                            <a href="contact" class="footer__link-contact">
                                <img src="/public/images/vk.svg" alt="VK" class="footer__img-contact">
                            </a>
                        </li>
                        <li class="footer__item-contact">
                            <a href="contact" class="footer__link-contact">
                                <img src="/public/images/telegram.svg" alt="Telegram" class="footer__img-contact">
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </footer>
</div>
</body>
</html>
