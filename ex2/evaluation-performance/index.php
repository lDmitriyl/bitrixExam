<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Оценка-производительности");
?>
       [ex2-88]
Cамая ресурсоёмкая страница /products/index.php доля нагрузки 24,78%
<br>
Работа компонента по умолчанию: кеш: 15кб.
<br>
Работа компонента только нужные параметры: кеш: 11кб
<br>
Разница 15кб - 11кб = 4кб

        [ex2-10]
Cамая ресурсоёмкая страница /products/index.php доля нагрузки 24,78%
средее время генерации страницы 0,1181
<br>
Самый загруженный компонент
bitrix:catalog 0.0198 секунд

    [ex2-11]
Самая ресурсоёмкая страница /products/index.php доля нагрузки 24,78%
средее время генерации страницы 0,1181
<br>
Самый загруженный компонент
bitrix:catalog 34 запроса к бд
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>