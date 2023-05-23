<div class="container">
            <div class="assortment__grid">
                <h1>Поиск товаров по наименованию</h1>
                <form action="/assortment" method="post" class="assortment__form_find js-message">
                    <input name="name" placeholder="Наименование товара" autocomplete="off" type="text">
                    <input type="submit" value="Найти!">
                </form>
                <form action="/assortment" method="post" class="assortment__form_filter">
                    <label><input type="radio" name="price-object" value="cheap" checked><div>Дешёво</div></label>
                    <label><input type="radio" name="price-object" value="expensive"><div>Дорого</div></label>
                    <input type="submit" value="Отфильтровать">
                </form>
                <div class="assortment__grid_element">
                    <ul class="assortment__grid_list_elements">
                        <li class="assortment__grid_list_element">
                            <!--Block-->
                            <?php for($i = 0; $i < count($data); $i++){?>
                            <div class="assortment__grid_card_view">
                                <img src="/public/materials/<?=$data[$i]['id']?>.png" alt="Отсуствие фотография товара">
                                <p class="name-item"><?=$data[$i]['name']?></p>
                                <p class="price-item"><?=$data[$i]['price']?> рублей</p>
                                <a href="/product/<?=$data[$i]['id']?>" class="about-item first">Подробнее</a>
                                <a href="/assortment/add/<?=$data[$i]['id']?>" class="about-item second">В корзирну</a>
                            </div>
                            <?php }?>
                            <!--Block-->
                        </li>
                    </ul>
                </div>
                <div class="block-pagination">
                    <?php echo $pagination?>
                </div>
            </div>
        </div>