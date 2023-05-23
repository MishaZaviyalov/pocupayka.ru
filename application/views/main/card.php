<?php //debug($_SESSION);?>

<div class="container full-screen-for-container">
    <div class="shopping_cart">
        <h1>Корзина</h1>
        <?php if(isset($_SESSION['cart']) and count($_SESSION['cart']) != 0){ ?>
        <table>
            <thead>
            <tr>
                <th>Наименование</th>
                <th>Цена</th>
                <th>Количество</th>
                <th colspan="2">Функции</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($data as $element) {?>
            <tr>
                <td><?=$element['name']?></td>
                <td><?=$element['price']?></td>
                <td><?=$_SESSION['cart'][$element['id']]?></td>
                <td><a href="/assortment/add/<?=$element['id']?>"><ion-icon name="add-outline"></ion-icon></a></td>
                <td><a href="/assortment/remove/<?=$element['id']?>"><ion-icon name="trash-outline"></ion-icon></a></td>
            </tr>
            <?php }?>
            </tbody>
        </table>
        <div>
            <a href="/assortment/formulate">Оформить заказ</a>
            <a href="/assortment/clean">Почистить корзину</a>
        </div>
        <?php } else {?>
            <h2>Корзина пуста!</h2>
        <?php } ?>
    </div>
</div>
<script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>