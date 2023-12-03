# Biplan Test Task

Проверено под WSL2 (win 10 pro docker desktop)

1. Клонируем репозиторий
2. Вызываем docker-compose up -d в корневом каталоге проекта
3. Дожидаемся успешного подъема всех контейнеров
4. Вызываем docker exec -it php_testcase bash
5. Вызываем php artisan command:loadcsv --file=./storage/file.csv (можно залить свой файл и указать путь к нему)
6. Переходим по ссылке http://localhost:8989/?pgsql=pgsql_testcase&username=testcase&db=testcase&ns=public&select=jobs
7. Вводим пароль testcase
8. Наблюдаем(Ctrl+R) за тем, как таблица jobs наполняется/пустеет (на всякий добавил в проект adminer, тк не придется подключать IDE к базе)
9. Проверяем результат выполнения фоновых задач по ссылке http://localhost:8989/?pgsql=pgsql_testcase&username=testcase&db=testcase&ns=public&select=employees_count_in_org

### Примечания:

1. project/app/Helpers/EmployeesHelper.php - Обращения к базе реализованы на моделях
2. project/app/Jobs/CountOrganizationEmployees.php - Обращения к базе реализованы на фасаде DB
3. Постарался прокинуть порты, которые не пересекутся с Вашими
