<?php //debug($opData);?>
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
        <div class="page__add-content order-add">
            <h2>Корректировка заказа</h2>
            <form action="/admin/orders/<?=$data[0]['id_order']?>" method="post" enctype="multipart/form-data">
                <table>
                    <tr>
                        <td>Номер: </td>
                        <td><?=$data[0]['id_order']?></td>
                    </tr>
                    <tr>
                        <td>Адрес: </td>
                        <td><?=$data[0]['Address']?></td>
                    </tr>
                    <tr>
                        <td>Время формирования: </td>
                        <td><?=$data[0]['created_at']?></td>
                    </tr>
                    <tr>
                        <td>Товары на изготовление: </td>
                        <td class="block-products">
                            <?php foreach ($opData as $element) { ?>
                                <?='Номер: '.$element['id'].' Наименование: "'.$element['name'].'" Количество: '.$element['Quantity'].";</br>"?>
                            <?php }?>
                        </td>
                    </tr>
                </table>
                <?=$select?>
                <input type="submit" value="Установить статус">
            </form>
        </div>
    </div>
</div>