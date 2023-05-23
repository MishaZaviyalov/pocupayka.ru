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
            <h2>Товары</h2>
            <table>
                <tr>
                    <th>Номер</th>
                    <th>Наименование</th>
                    <th>Описание</th>
                    <th>Цена</th>
                    <th colspan="2">Функция</th>
                </tr>
                <?php foreach ($data as $element) {?>
                    <tr>
                        <td><?=$element['id']?></td>
                        <td><?=$element['name']?></td>
                        <td><?=mb_substr($element['description'], 0, 5).'...'?></td>
                        <td><?=$element['price'].' рублей'?></td>
                        <td><a class="link__function" href="/admin/edit/<?=$element['id']?>">Изменить</a></td>
                        <td><a class="link__function" href="/admin/delete/<?=$element['id']?>">Удалить</a></td>
                    </tr>
                <?php }?>
            </table>
            <div class="pagination margin-redactor">
                <?php echo $pagination?>
            </div>
        </div>

    </div>
</div>