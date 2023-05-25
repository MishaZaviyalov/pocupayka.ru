<?php  //debug($dataOrder);?>
<div class="container">
    <div class="profile_user_content">
        <div class="profile_user">
            <img src="/public/images/userImg.png" alt="Аватарка пользователя">
            <div class="profile_user__description_info">
                <p class="profile_user__full_name"><?=$dataProfile[0]['fullName']?></p>
                <p class="profile_user__email"><?=$dataProfile[0]['Email']?></p>
<!--                <a href="/recovery">Сменить пароль</a>-->
            </div>
        </div>
        <div class="profile_user__orders">
            <?php if(count($dataOrder) > 0) {?>
                <table>
                    <thead>
                    <tr>
                        <th>Номер</th>
                        <th>Статус</th>
                        <th>Адрес</th>
                        <th>Время и дата создания</th>
                        <th>Количество товаров</th>
                        <th>Общая цена</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($dataOrder as $element) { ?>
                        <tr>
                            <td><?=$element['id_order']?></td>
                            <td><?=$element['status']?></td>
                            <td><?=$element['address']?></td>
                            <td><?=$element['date']?></td>
                            <td><?=$element['quantity']?></td>
                            <td><?=$element['price']?></td>
                        </tr>
                    <?php } ?>
                    </tbody>
                </table>
            <?php } else {?>
                <h1 style="display: flex; justify-content: center">Вы не совершали ни одного заказа!</h1>
            <?php } ?>
        </div>
    </div>
</div>