<div class="wrapper block_form_resize">
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
            <h2>Добавление</h2>
            <form class="js-message" action="/admin/add" method="post" enctype="multipart/form-data">
                <input name="name" type="text" placeholder="Наименование">
                <textarea name="description" class="description" placeholder="Описание" ></textarea>
                <input name="price" type="number" placeholder="Цена">
                <input name="img" type="file">
                <input type="submit" value="Добавить">
            </form>
        </div>
    </div>
</div>
