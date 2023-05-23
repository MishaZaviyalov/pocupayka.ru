<?php //debug($data);?>
<div class="wrapper">
    <div class="side-menu">
        <div class="brand-name">
            <h1>Покупайка</h1>
        </div>
        <ul>
            <li><img src="/public/images/plus.png" class="icon-image">
                <a href="/admin/add">Добавление товара</a></li>
            <li><img src="/public/images/table.png" class="icon-image">
                <a href="/admin/products">Торары</a></li>
            <li><img src="/public/images/table.png" class="icon-image">
                <a href="/admin/orders">Заказы</a></li>
            <li><img src="/public/images/exit.png" class="icon-image">
                <a href="/admin/logout">Выход</a></li>
        </ul>
    </div>
    <div class="content-menu">
        <div class="page__add-content">
            <h2>Заказы</h2>
            <table>
                <tr>
                    <th>Номер</th>
                    <th>Адрес</th>
                    <th>Статус</th>
                    <th>Дата создания</th>
                    <th>Клиент</th>
                    <th>Функция</th>
                </tr>
                    <?php foreach ($data as $element) {?>
                <tr>
                        <td><?=$element['id_order']?></td>
                        <td><?=mb_substr($element['Address'], 0, 12)?>...</td>
                        <td ><?=$element['status']?></td>
                        <td><?=$element['created_at']?></td>
                        <td><?=$element['Person_name']?></td>
                        <td><a class="link__function" href="/admin/orders/<?=$element['id_order']?>">Изменить</a></td>
                </tr>
                    <?php }?>
            </table>
            <div class="pagination margin-redactor">

            </div>
        </div>

    </div>
</div>