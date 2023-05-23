<div class="full-screen-block">
    <div class="form-box">
        <div class="form-value">
            <form class="js-message" action="/authorization" method="post">
                <h2>Авторизация</h2>
                <div class="input-box">
                    <ion-icon name="mail-outline"></ion-icon>
                    <input name="email" type="text" minlength="1" maxlength="120" required>
                    <label for="">Электронная почта</label>
                </div>
                <div class="input-box">
                    <ion-icon name="lock-closed-outline"></ion-icon>
                    <input name="password" type="password" minlength="1" maxlength="64" required>
                    <label for="">Пароль</label>
                </div>
                <input class="registration__button" type="submit" value="Авторизироваться!">
            </form>
            <div class="already_exists_link">
                <p>Забыт пароль от учётной записи?<br> <a href="/recovery">Восстановить!</a></p>
            </div>
        </div>
    </div>
</div>
