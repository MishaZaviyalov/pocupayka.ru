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
            <h2>Изменение</h2>
            <form class="js-message" action="/admin/edit/<?php echo $data['id']; ?>" method="post">
                <input name="name" type="text" placeholder="Наименование" value="<?=htmlspecialchars($data['name'], ENT_QUOTES); ?>">
                <input name="price" type="text" placeholder="Цена" value="<?=htmlspecialchars($data['price'], ENT_QUOTES); ?>">
                <textarea name="description" class="description" placeholder="Описание"><?=htmlspecialchars($data['description'], ENT_QUOTES); ?></textarea>
                <input name="img" type="file">
                <input type="submit" value="Изменить">
            </form>
        </div>
    </div>
</div>
