<?php //phpinfo() ?>

<div class="full-screen-block">
    <div class="form-box">
        <div class="form-value">
            <form class="js-message" action="/recovery" method="post">
                <h2>Восстановление</h2>
                <div class="input-box">
                    <ion-icon name="id-card-outline"></ion-icon>
                    <input name="First_name" id="First_name" type="text" minlength="1" maxlength="64" required>
                    <label>Фамилия</label>
                </div>
                <div class="input-box">
                    <ion-icon name="id-card-outline"></ion-icon>
                    <input name="Second_name" type="text" minlength="1" maxlength="64" required>
                    <label>Имя</label>
                </div>
            <div class="input-box">
                <ion-icon name="mail-outline"></ion-icon>
                <input name="Email" type="text" minlength="1" maxlength="120" required>
                <label for="">Электронная почта</label>
            </div>
            <div class="input-box">
                <ion-icon name="lock-closed-outline"></ion-icon>
                <input name="password" type="password" minlength="1" maxlength="64" required>
                <label>Пароль</label>
            </div>
            <div class="input-box">
                <ion-icon name="lock-closed-outline"></ion-icon>
                <input name="repeat-password" type="password" minlength="1" maxlength="64" required>
                <label>Повтор пароля</label>
            </div>
            <input class="registration__button" type="submit" value="Изменить пароль!">
            </form>
<!--            <div class="already_exists_link">-->
<!--                <p>Нету аккаунта? <a href="/registration">Зарегистироваться!</a></p>-->
<!--            </div>-->
        </div>
    </div>
</div>