$(document).ready(function() {
    // Функция для получения курса USD/BYN с API НБРБ
    function getExchangeRate() {
        return $.ajax({
            url: 'https://api.nbrb.by/exrates/rates/840?parammode=2',
            type: 'GET',
            dataType: 'json'
        }).then(function(data) {
            return data.Cur_OfficialRate;
        }).catch(function() {
            console.error('Ошибка получения курса валюты');
            return 3.25; // Fallback-значение на случай ошибки
        });
    }

    // Функция для обновления итоговой суммы
    function updateTotal() {
        const pizzaPrice = parseFloat($('#pizza option:selected').data('price')) || 0;
        const saucePrice = parseFloat($('#sauce option:selected').data('price')) || 0;
        const sizePrice = parseFloat($('#size option:selected').data('size-price')) || 0;

        const totalUsd = pizzaPrice + saucePrice + sizePrice;

        getExchangeRate().then(function(rate) {
            const totalByn = totalUsd * rate;
            $('#totalByn').text(totalByn.toFixed(2));
        });
    }

    // Инициализация данных о ценах в атрибутах data-price
    function initializePrices() {
        $('#pizza option').each(function() {
            const price = parseFloat($(this).text().match(/\d+\.?\d*/)[0]);
            $(this).data('price', price);
        });

        $('#sauce option').each(function() {
            const price = parseFloat($(this).text().match(/\d+\.?\d*/)[0]);
            $(this).data('price', price);
        });

        $('#size option').each(function() {
            // Предполагаем, что размер может не иметь цены в интерфейсе, добавляем атрибут вручную
            const sizePrice = $(this).data('size-price') || 0; // Если цены нет, используем 0
            $(this).data('size-price', sizePrice);
        });

        updateTotal(); // Обновляем сумму при загрузке
    }

    // Вызов инициализации цен при загрузке страницы
    initializePrices();

    // Обновление суммы при изменении выбора
    $('#pizza, #size, #sauce').on('change', updateTotal);

    // Обработка отправки формы через AJAX
    $(document).ready(function() {
        $('#orderForm').on('submit', function(e) {
            e.preventDefault();
    
            $.ajax({
                url: '/public/index.php?action=order',
                type: 'POST',
                data: $(this).serialize(),
                dataType: 'json',
                success: function(response) {
                    if (response.error) {
                        alert(response.error);
                        return;
                    }
    
                    $('#orderDetails').text(`Пицца: ${response.pizza}, Размер: ${response.size}, Соус: ${response.sauce}`);
                    $('#totalPrice').text(`Итого: ${response.total_byn} BYN`);
                    $('#receipt').show();
                },
                error: function(xhr, status, error) {
                    console.log('Ошибка AJAX:', status, error);
                    alert('Ошибка при обработке заказа');
                }
            });
        });
    });
});