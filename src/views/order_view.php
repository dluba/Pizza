<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Заказ пиццы</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
<h1>Закажите пиццу</h1>

<form method="POST" action="index.php?action=order">
    <label for="pizza">Выберите пиццу:</label>
    <select name="pizza" id="pizza">
        <?php foreach ($pizzas as $pizza): ?>
            <?php foreach ($pizzas as $pizza): ?>
                    <option value="<?= $pizza->getId() ?>"><?= $pizza->getName() ?> (<?= number_format($pizza->getPriceBYN(), 2) ?> BYN)</option>
            <?php endforeach; ?>
        <?php endforeach; ?>
    </select>

    <br><br>

    <label for="size">Выберите размер:</label>
    <select name="size" id="size">
        <?php foreach ($sizes as $size): ?>
            <?php foreach ($sizes as $size): ?>
                    <option value="<?= $size->getId() ?>"><?= $size->getName() ?> см (<?= number_format($size->getPriceBYN(), 2) ?> BYN)</option>
            <?php endforeach; ?>
        <?php endforeach; ?>
    </select>

    <br><br>

    <label for="sauce">Выберите соус:</label>
    <select name="sauce" id="sauce">
        <?php foreach ($sauces as $sauce): ?>
            <?php foreach ($sauces as $sauce): ?>
                    <option value="<?= $sauce->getId() ?>"><?= $sauce->getName() ?> (<?= number_format($sauce->getPriceBYN(), 2) ?> BYN)</option>
            <?php endforeach; ?>
        <?php endforeach; ?>
    </select>

    <br><br>

    <button type="submit" id="order-button">Заказать</button>
</form>
<div id="totalAmount">
                Итоговая сумма заказа: <span id="totalByn">0.00</span> BYN
</div>
<?php if (isset($totalPrice)): ?>
    <h2>Итого: <?= number_format($totalPrice, 2, ',', ' ') ?> руб.</h2>
<?php endif; ?>

<div id="order-summary" style="display: none;">
        <h2>Ваш заказ</h2>
        <p id="order-description"></p>
        <p id="order-price"></p>
    </div>
<div id="receipt"></div>
</div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="script.js"></script>
</body>
</html>