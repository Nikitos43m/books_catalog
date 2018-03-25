// Вешаем обработчик события onchange
$("[data-trigger=dep-drop]").on("change", function() {
    // Собираем данные для отправки в действие контроллера
    var data = {};
    data[$(this).attr("data-name")] = $(this).val();
    // Контейнер для помещения ответа от сервера
    var target = $(this).attr("data-target");
    // Непосредственно отправка запроса на сервер

    city = $(this).attr("city_id");


    $.getJSON(
        $(this).attr("data-url"), //URL
        data, // GET-параметры
        // Обработчик ответа сервера
        function(response, statusCode, xhr) {
            var slct = $(target); // jQuery-объект целевого тега
            slct.empty(); // Очищаем текущие <option>
            
            // Обходим каждый элемент массива из ответа сервера
            for (el in response) {
                // И добавляем его в конец <select>
                if(el == city) {
                    $("<option value=\"" + el + "\" selected>" + response[el] + "</option>").appendTo(slct);
                }else{
                    $("<option value=\"" + el + "\">" + response[el] + "</option>").appendTo(slct);
                }
            }

            slct.removeAttr("disabled"); // Удаляем атрибут запрещающий изменение <select>
        }
    );
}).change();