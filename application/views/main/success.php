<div class="full-screen-block">
    <div class="form-box">
        <div class="form-value success-order">
            <?php if(count($data) > 0){?>
                <h2>Заказ записан!</h2>
                <h3>Мы вам напишем.</h3>
                <p>Время: <?=$data[0]['Time']?></p>
                <p>Дата: <?=$data[0]['Date']?></p>
                <p>Статус: <?=$data[0]['Status']?></p>
                <p>Пользователь: <?=$data[0]['FullName']?></p>
            <?php } else {?>
                <h2>Заказ не найден!</h2>
            <?php }?>
        </div>
    </div>
</div>