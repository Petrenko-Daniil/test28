Проект имеет встроенный набор команд:
* ``php artisan vehicle-service:create`` - создание моделей
* ``php artisan vehicle-service:find`` - получение данных о модели
* ``php artisan vehicle-service:get`` - получение коллекции данных
* ``php artisan vehicle-service:delete`` - удаление модели
* ``php artisan make:user`` - создание нового пользователя и API токена

Для начала использования приложения вызовите ``php artisan make:user``
и скопируйте полученный API токен для дальнейшей работы с Postman,
либо воспользуйтесь набором команд *vehicle-service* для того чтобы получить доступ
к сущностям из CLI

---
В ТЗ не требуется CRUD для сущностей кроме Vehicle, поэтому для них реализованы только *get* и *find*.
Создание реализовано динамически при указании строковых значений при создании Vehicle. Другие методы реализованы в CLI.
