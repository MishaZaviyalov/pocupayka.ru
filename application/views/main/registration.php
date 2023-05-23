<div class="full-screen-block">
    <div class="form-box">
        <dib class="form-value">
            <form class="js-message" action="/registration" method="post">
                <h2>Регистрация</h2>
                <div class="input-box">
                    <ion-icon name="id-card-outline"></ion-icon>
                    <input name="first_name" id="First_name" type="text" minlength="1" maxlength="64" required>
                    <label>Фамилия</label>
                </div>
                <div class="input-box">
                    <ion-icon name="id-card-outline"></ion-icon>
                    <input name="second_name" type="text" minlength="1" maxlength="64" required>
                    <label>Имя</label>
                </div>
                <div class="input-box">
                    <ion-icon name="mail-outline"></ion-icon>
                    <input name="email" type="text" minlength="1" maxlength="120" required>
                    <label>Электронная почта</label>
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
                <input class="registration__button" type="submit" value="Зарегистироваться!">
                <div class="already_exists_link">
                    <p>Уже имеется аккаунт? <a href="/authorization">Авторизироваться!</a></p>
                </div>
            </form>
        </dib>
    </div>
</div>