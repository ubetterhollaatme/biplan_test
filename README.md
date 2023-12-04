# Biplane24 Test Task

### Проверено под:
#### macOS (Sonoma 14.0) + docker desktop (docker v24.0.5 build ced0996 & docker-compose v2.20.2-desktop.1)
#### WSL2 - Ubuntu distro (win 10 pro) + docker desktop (docker v24.0.6, build ed223bc & docker-compose v2.23.0-desktop.1)
##### Остальное вшито в сборку

### Инструкция:

1. Устанавливаем Docker Desktop (если не установлен)
2. Клонируем репозиторий
3. Открываем консоль
4. Переходим в корневой каталог репозитория (cd <some_path>/biplan_test/)
5. Вызываем docker-compose build --no-cache
6. Дожидаемся успешного завершения билда
7. Вызываем docker-compose up -d
8. Дожидаемся успешного старта всех контейнеров (Статус контейнера: Started/Healthy)
9. Вызываем docker exec -it php_testcase bash
10. Вызываем php artisan command:loadcsv --file=./storage/file.csv (можно залить свой файл и указать путь к нему)
11. Переходим по [ссылке](http://localhost:8989/?pgsql=pgsql_testcase&username=testcase&db=testcase&ns=public&select=jobs) (добавил в проект adminer, так вам не придется подключать IDE к базе)
12. Вводим пароль testcase и входим в интерфейс
13. Наблюдаем(Ctrl+R) за тем, как таблица jobs наполняется/пустеет
14. Проверяем результат выполнения фоновых задач по [ссылке](http://localhost:8989/?pgsql=pgsql_testcase&username=testcase&db=testcase&ns=public&select=employees_count_in_org)

### Примечания:

1. project/app/Helpers/EmployeesHelper.php - Обращения к базе реализованы на моделях
2. project/app/Jobs/CountOrganizationEmployees.php - Обращения к базе реализованы на фасаде DB
3. Постарался прокинуть порты, которые не пересекутся с Вашими
4. Проверка уникальности email сотрудника и имени организации - вшиты в миграциях
5. Файл создан на базе excel таблицы, поэтому у email`ов нет окончаний вида '@mail.ru', но в данном случае ни на что не влияет, валидация email в задаче не упоминалась, но сделать не проблема, как и сгенерить таблицу с валидными мэйлами, просто уже времени нет :(
6. Ушло в районе 8-12 часов, много времени ушло на поднятие задач именно в фоне, т.к. с supervisor сервисом я ранее не сталкивался, потребовалось время, чтобы разобраться и настроить все необходимые конфигурации + некоторое время ушло на подготовку сборщика и инструкции
7. Итого: сборка+инструкция+supervisor+сообразить как бы получше всё это организовать - 4-6ч; всё что касается laravel в данном проекте - 4-6ч
