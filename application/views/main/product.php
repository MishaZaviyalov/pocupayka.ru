<div class="container">
    <div class="aboutProduct__block">
        <h1><?=$data[0]['name']?></h1>
        <img src="/public/materials/<?=$data[0]['id']?>.png" alt="Фотография товара">
        <p><?=$data[0]['description']?></p>
        <br>
        <span><?=$data[0]['price']?> рублей</span>
        <div>
            <a href="">В корзину</a>
            <a href="/assortment">Ассортемент</a>
        </div>
    </div>
</div>